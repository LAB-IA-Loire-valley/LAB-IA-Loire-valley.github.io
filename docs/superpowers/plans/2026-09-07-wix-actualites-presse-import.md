# Import Actualités + Presse depuis Wix — Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Importer les ~174 actualités et ~10 articles presse manquants depuis le site Wix vers WordPress en `post` / `press_article` avec médias rapatriés en local.

**Architecture:** Scraper Python stdlib-only (regex sur le HTML SSR Wix, zéro dépendance) → JSON versionnés dans `theme/import-data/` → extension idempotente de `inc/import-from-wix.php` (sélecteur `IMPORT_ONLY`, filtres `IMPORT_LIMIT` / `IMPORT_AFTER` pour pilote et lots) → réécriture de `template-actualites.php` en feed de cartes paginé.

**Tech Stack:** Python 3 stdlib (`re`, `html`, `urllib`, `json`), PHP 8.2 + WordPress 6.6 APIs (`wp_insert_post`, `media_handle_sideload`, `WP_Query`), WP-CLI dans le conteneur `labia_wp`.

## Global Constraints

- WordPress 6.6.2, PHP 8.2, MariaDB 10.6 (stack `wordpress-dev/docker-compose.yml`).
- Thème custom `labia-wp`, CMB2 uniquement (pas d'ACF), vanilla JS uniquement (pagination 100 % serveur, aucun JS ajouté).
- CSS uniquement dans `wordpress-dev/theme/style.css`, jamais de styles inline ni de `<style>` dans les templates.
- URLs via `home_url()`, contenus FR, dates Wix d'origine conservées (`post_date`).
- Imports idempotents (skip sur titre existant) et marqués (`meta _wix_import = 1`).
- Pilote d'abord (1 article), lots ensuite, dump DB avant import total.

---

## File Structure

- Create: `wordpress-dev/theme/../tools/scrape-wix.py` → en fait `tools/scrape-wix.py` à la racine du repo (ne pas polluer le thème déployé) ; il écrit dans `wordpress-dev/theme/import-data/actualites-full.json` et `presse-full.json`.
- Create: `wordpress-dev/theme/import-data/actualites-full.json`, `presse-full.json` (générés, versionnés).
- Modify: `wordpress-dev/theme/inc/import-from-wix.php` — ajoute `labia_sideload_pdf()`, `import_actualites_full()`, `import_presse_full()`, filtres env ; ne touche pas aux fonctions existantes.
- Modify: `wordpress-dev/theme/page-templates/template-actualites.php` — feed `WP_Query` sur `post`, 12/page.
- Modify: `wordpress-dev/theme/style.css` — ajoute le bloc `.actu-card` (adapté du statique `actualites.html`).
- Unchanged: `single.php` (fallbacks miniature/date déjà OK), `template-presse.php`, `cpt-news.php`, `cpt-presse.php`.

---

### Task 1: Scraper actualités → `actualites-full.json`

**Files:**
- Create: `tools/scrape-wix.py`
- Create: `wordpress-dev/theme/import-data/actualites-full.json` (généré)

**Interfaces:**
- Consumes: HTML SSR de `https://www.labia-loirevalley.fr/actualité` (vérifié : 178 sections `wixui-section`, dates `h6`, titres `h5`, corps `p.font_8` + `ul/li`).
- Produces: `actualites-full.json`, liste d'objets `{"title": str, "date": "YYYY-MM-DD HH:MM:SS", "content_html": str (HTML nettoyé), "images": [str] (URLs originales `https://static.wixstatic.com/media/{id}`), "pdfs": [str]}`, tri décroissant (le plus récent premier).

- [ ] **Step 1: Écrire le scraper**

```python
#!/usr/bin/env python3
"""Scrape les actualités Wix (SSR, sans JS) -> actualites-full.json."""
import html as H
import json
import re
import sys
import urllib.request

ACTU_URL = "https://www.labia-loirevalley.fr/actualit%C3%A9"
UA = {"User-Agent": "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 Chrome/120 Safari/537.36"}

MONTHS = {
    "janvier": 1, "février": 2, "fevrier": 2, "mars": 3, "avril": 4,
    "mai": 5, "juin": 6, "juillet": 7, "août": 8, "aout": 8,
    "septembre": 9, "octobre": 10, "novembre": 11, "décembre": 12, "decembre": 12,
}

SKIP_IMG = ("LOGO_LABIA_Q_S-BASELINE", "PICTO_", "logo-osez-ia")
TAG_RE = re.compile(r"<[^>]+>")


def strip_tags(s):
    return H.unescape(TAG_RE.sub("", s)).strip()


def parse_fr_date(raw):
    d = H.unescape(strip_tags(raw)).strip().lower().replace("1er ", "1 ")
    day, month, year = d.split()
    return f"{int(year):04d}-{MONTHS[month]:02d}-{int(day):02d} 10:00:00"


def clean_html(fragment):
    """Garde p/ul/ol/li/a/br/strong/em, jette spans/styles, ignore paragraphes vides."""
    parts = []
    for m in re.finditer(
        r'<p class="font_8[^"]*"[^>]*>(.*?)</p>|(<ul.*?</ul>)|(<ol.*?</ol>)',
        fragment, re.S,
    ):
        chunk = m.group(0)
        if chunk.startswith("<p"):
            inner = m.group(1)
            inner = re.sub(r"</?(span|font|div)[^>]*>", "", inner)
            inner = re.sub(r"\s(style|class|id|data-[a-z-]+)=\"[^\"]*\"", "", inner)
            text = H.unescape(TAG_RE.sub("", inner)).replace("\u200b", "").replace("\xa0", "").strip()
            if not text:
                continue
            parts.append(f"<p>{inner.strip()}</p>")
        else:
            inner = re.sub(r"</?(span|font)[^>]*>", "", chunk)
            inner = re.sub(r"\s(style|class|id|data-[a-z-]+)=\"[^\"]*\"", "", inner)
            parts.append(inner)
    return "".join(parts)


def original_media_url(wix_url):
    m = re.search(r"(https://static\.wixstatic\.com/media/[^/]+)/v1/", wix_url)
    return m.group(1) if m else wix_url


def main(out_path):
    req = urllib.request.Request(ACTU_URL, headers=UA)
    src = urllib.request.urlopen(req, timeout=60).read().decode("utf-8")
    sections = re.findall(
        r'<section[^>]*class="[^"]*wixui-section"[^>]*>(.*?)</section>', src, re.S
    )
    articles, skipped = [], []
    for s in sections:
        m_date = re.search(r"<h6[^>]*>(.*?)</h6>", s, re.S)
        if not m_date:
            continue  # sections 0-1 = header, sans date
        try:
            date = parse_fr_date(m_date.group(1))
        except (ValueError, KeyError):
            skipped.append(("bad-date", strip_tags(m_date.group(1))[:60]))
            continue
        m_title = re.search(r"<h5[^>]*>(.*?)</h5>", s, re.S)
        if m_title:
            title = strip_tags(m_title.group(1))
        else:
            h6s = re.findall(r"<h6[^>]*>(.*?)</h6>", s, re.S)
            if len(h6s) < 2:
                skipped.append((date, "no-title"))
                continue
            title = strip_tags(h6s[1])
        content = clean_html(s)
        imgs = []
        for u in re.findall(r'<img[^>]+src="(https://static\.wixstatic\.com/media/[^"]+)"', s):
            if any(k in u for k in SKIP_IMG):
                continue
            full = original_media_url(u)
            if full not in imgs:
                imgs.append(full)
        pdfs = sorted(set(
            u for u in re.findall(r'href="([^"]+\.pdf[^"]*)"', s)
            if "_files/ugd" in u
        ))
        articles.append({
            "title": title, "date": date, "content_html": content,
            "images": imgs, "pdfs": pdfs,
        })
    with open(out_path, "w", encoding="utf-8") as f:
        json.dump(articles, f, ensure_ascii=False, indent=1)
    print(f"articles={len(articles)} skipped={len(skipped)}")
    for why, info in skipped:
        print(f"  SKIP [{why}] {info}")


if __name__ == "__main__":
    main(sys.argv[1] if len(sys.argv) > 1 else
         "wordpress-dev/theme/import-data/actualites-full.json")
```

- [ ] **Step 2: Lancer le scraper et vérifier**

Run: `python3 tools/scrape-wix.py wordpress-dev/theme/import-data/actualites-full.json`
Expected: `articles=17X skipped=2` (174 ± 2 ; les 2 skips = sections 159/160 sans titre, loggés `no-title`), pas d'exception.

- [ ] **Step 3: Vérifier le contenu (pilote + bornes)**

Run: `python3 -c "import json; a=json.load(open('wordpress-dev/theme/import-data/actualites-full.json')); print(len(a)); print(a[0]['date'], '|', a[0]['title'][:60], '| imgs:', len(a[0]['images'])); print(a[-1]['date'], '|', a[-1]['title'][:60])"`
Expected: `174` (ou 173-175), première ligne `2026-07-15 10:00:00 | 10 ans du LAB'O : une soirée placée sous le signe | imgs: 2`, dernière ligne en `2021-05-04`.

- [ ] **Step 4: Commit**

```bash
git add tools/scrape-wix.py wordpress-dev/theme/import-data/actualites-full.json
git commit -m "feat(import): scraper Wix actualites + JSON complet (~174 articles)"
```

### Task 2: Import PHP — `import_actualites_full()` + sideload PDF + filtres

**Files:**
- Modify: `wordpress-dev/theme/inc/import-from-wix.php` (append, ne pas toucher aux fonctions existantes)

**Interfaces:**
- Consumes: `theme/import-data/actualites-full.json` (champs `title`, `date`, `content_html`, `images[]`, `pdfs[]` de la Task 1) ; helpers existants `import_json()`, `wp_create_post_safe()`, `sideload_image()`.
- Produces: `labia_sideload_pdf(string $url, int $post_id): string` (retourne la nouvelle URL locale ou `''`), `import_actualites_full(): void`. Filtres env `IMPORT_LIMIT` (int, ex. `1` pilote) et `IMPORT_AFTER` (`YYYY-MM-DD`, skip les articles strictement antérieurs).

- [ ] **Step 1: Ajouter le code à la fin de `import-from-wix.php` (avant le bloc RUN ALL, et appeler la fonction dans RUN ALL après `import_actualites()`)**

```php
// ===================================================================
// IMPORT ACTUALITÉS FULL (scraper Wix -> actualites-full.json, type `post`)
// Env: IMPORT_LIMIT=int (ex: 1 pour le pilote), IMPORT_AFTER=YYYY-MM-DD
// ===================================================================
function labia_sideload_pdf($url, $post_id) {
    require_once(ABSPATH . 'wp-admin/includes/media.php');
    require_once(ABSPATH . 'wp-admin/includes/file.php');
    require_once(ABSPATH . 'wp-admin/includes/image.php');

    $tmp = download_url($url, 60);
    if (is_wp_error($tmp)) {
        echo "    PDF download failed: {$url}\n";
        return '';
    }
    $path = parse_url($url, PHP_URL_PATH);
    $name = $path ? basename($path) : 'document.pdf';
    if (substr(strtolower($name), -4) !== '.pdf') {
        $name .= '.pdf';
    }
    $id = media_handle_sideload(
        array('name' => sanitize_file_name($name), 'tmp_name' => $tmp),
        $post_id
    );
    if (is_wp_error($id)) {
        @unlink($tmp);
        echo "    PDF sideload failed: {$id->get_error_message()}\n";
        return '';
    }
    return wp_get_attachment_url($id);
}

function import_actualites_full() {
    $articles = import_json('actualites-full.json');
    $limit = getenv('IMPORT_LIMIT') !== false ? intval(getenv('IMPORT_LIMIT')) : 0;
    $after = getenv('IMPORT_AFTER') !== false ? strval(getenv('IMPORT_AFTER')) : '';
    $count = 0;
    $done = 0;

    foreach ($articles as $a) {
        $title = $a['title'] ?? '';
        $date = $a['date'] ?? '';
        if (empty($title) || empty($date)) {
            continue;
        }
        if ($after !== '' && substr($date, 0, 10) < $after) {
            continue;
        }
        if ($limit > 0 && $done >= $limit) {
            break;
        }
        $done++;

        $content = $a['content_html'] ?? '';
        $post_id = wp_create_post_safe(array(
            'post_type'    => 'post',
            'post_title'   => $title,
            'post_content' => $content,
            'post_date'    => $date,
            'post_status'  => 'publish',
        ));
        if (!$post_id) {
            continue;
        }
        update_post_meta($post_id, '_wix_import', '1');

        foreach (($a['images'] ?? array()) as $i => $img_url) {
            $att_id = sideload_image($img_url, $post_id, 'Image ' . ($i + 1) . ' — ' . $title);
            if ($i === 0 && $att_id) {
                set_post_thumbnail($post_id, $att_id);
            }
        }
        $rewritten = $content;
        foreach (($a['pdfs'] ?? array()) as $pdf_url) {
            $local = labia_sideload_pdf($pdf_url, $post_id);
            if ($local !== '') {
                $rewritten = str_replace($pdf_url, $local, $rewritten);
            }
        }
        if ($rewritten !== $content) {
            wp_update_post(array('ID' => $post_id, 'post_content' => $rewritten));
        }
        $count++;
    }
    echo "\n=== ACTUALITÉS FULL: $count posts traités ===\n";
}
```

Et dans le bloc RUN ALL, remplacer les 4 appels existants par la version sélective (laisse les `echo` d'en-tête inchangés) :

```php
// RUN ALL — sélectif via IMPORT_ONLY (ex: "actualites_full", "presse,presse_full").
// Sans IMPORT_ONLY : tout est exécuté (comportement historique + nouvelles fonctions).
$IMPORT_ONLY = getenv('IMPORT_ONLY');
function labia_run($key) {
    global $IMPORT_ONLY;
    return $IMPORT_ONLY === false || $IMPORT_ONLY === '' || strpos($IMPORT_ONLY, $key) !== false;
}

if (labia_run('actualites')) { import_actualites(); }
if (labia_run('presse')) { import_presse(); }
if (labia_run('clients')) { import_clients(); }
if (labia_run('testimonials')) { import_testimonials(); }
if (labia_run('actualites_full')) { import_actualites_full(); }
if (labia_run('presse_full')) { import_presse_full(); }
```

- [ ] **Step 1b: Vérifier que `import_presse_full()` (Task 6) sera bien appelée par ce bloc** — oui via `labia_run('presse_full')` ; la Task 6 n'ajoute que la fonction, pas d'appel supplémentaire.

- [ ] **Step 2: Lint PHP**

Run: `php -l wordpress-dev/theme/inc/import-from-wix.php`
Expected: `No syntax errors detected`.

- [ ] **Step 3: Démarrer le stack local + installer WP-CLI (si absent)**

Run: `docker compose up -d` (dans `wordpress-dev/`), puis `docker compose exec wordpress ls /usr/local/bin/wp || docker compose exec wordpress bash -c "curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar && chmod +x wp-cli.phar && mv wp-cli.phar /usr/local/bin/wp"`
Expected: conteneurs `labia_wp` / `labia_wpdb` démarrés ; `docker compose exec wordpress wp --info --allow-root` affiche la version WP-CLI.

- [ ] **Step 4: Dump DB de sécu**

Run: `docker exec labia_wpdb mysqldump -u wp -pwppass wordpress > /tmp/opencode/dump-avant-import.sql && ls -la /tmp/opencode/dump-avant-import.sql`
Expected: fichier de plusieurs Mo créé sans erreur.

- [ ] **Step 5: Import pilote (1 article, le plus récent)**

Run: `docker compose exec -T wordpress bash -c "IMPORT_ONLY=actualites_full IMPORT_LIMIT=1 wp eval-file wp-content/themes/labia-wp/inc/import-from-wix.php --allow-root" 2>&1 | tail -8`
Expected: contient `=== ACTUALITÉS FULL: 1 posts traités ===` et aucune ligne `ERROR`.

- [ ] **Step 6: Vérifier le post pilote en DB**

Run: `PID=$(docker compose exec -T wordpress wp post list --post_type=post --format=csv --fields=ID,post_title --allow-root | grep "10 ans du LAB" | cut -d, -f1 | tr -d '\r'); echo "PID=$PID"; docker compose exec -T wordpress wp post meta get $PID _wix_import --allow-root; docker compose exec -T wordpress wp post meta get $PID _thumbnail_id --allow-root; docker compose exec -T wordpress wp post get $PID --field=post_date --allow-root`
Expected: `PID=<nombre>`, puis `1`, puis un ID numérique, puis `2026-07-15 10:00:00`.

- [ ] **Step 7: Commit**

```bash
git add wordpress-dev/theme/inc/import-from-wix.php
git commit -m "feat(import): import_actualites_full + sideload PDF + filtres pilote/lots"
```

### Task 3: Template Actualités → feed de cartes cliquables + CSS

**Files:**
- Modify: `wordpress-dev/theme/page-templates/template-actualites.php` (remplace la boucle `labia_get_news_articles()` par `WP_Query` sur `post`)
- Modify: `wordpress-dev/theme/style.css` (append bloc `.actu-card`, pas de `<style>` inline)

**Interfaces:**
- Consumes: posts `post` importés (Task 2), `single.php` existant pour la lecture.
- Produces: page `/actualites/` paginée (12/page, `paged`/`page` query vars), cartes avec image mise en avant + date + titre + extrait + lien permalink.

- [ ] **Step 1: Réécrire la boucle dans `template-actualites.php`**

Remplacer tout le bloc entre `<section>` et `</section>` (lignes 21-69 actuelles : `labia_get_news_articles()` + `news-feed` + `news-article`) par :

```php
<section>
  <div class="container">

    <?php
    $paged = max( 1, (int) get_query_var( 'paged' ), (int) get_query_var( 'page' ) );
    $news_query = new WP_Query( array(
        'post_type'      => 'post',
        'post_status'    => 'publish',
        'posts_per_page' => 12,
        'paged'          => $paged,
        'orderby'        => 'date',
        'order'          => 'DESC',
    ) );
    if ( $news_query->have_posts() ) :
    ?>
    <div class="actu-grid">
      <?php while ( $news_query->have_posts() ) : $news_query->the_post(); ?>
      <article class="actu-card reveal">
        <?php if ( has_post_thumbnail() ) : ?>
        <a class="actu-card__img" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true"><?php the_post_thumbnail( 'medium_large' ); ?></a>
        <?php endif; ?>
        <div class="actu-card__body">
          <div class="actu-card__date"><?php echo esc_html( get_the_date( 'd M Y' ) ); ?></div>
          <h2 class="actu-card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
          <p class="actu-card__excerpt"><?php echo esc_html( get_the_excerpt() ); ?></p>
          <div class="actu-card__footer">
            <a href="<?php the_permalink(); ?>" class="btn btn-sm btn-outline">Lire<svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 8h10M9 4l4 4-4 4"/></svg></a>
          </div>
        </div>
      </article>
      <?php endwhile; ?>
    </div>
    <?php
    $big = 999999999;
    echo paginate_links( array(
        'base'    => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
        'format'  => '?paged=%#%',
        'current' => $paged,
        'total'   => $news_query->max_num_pages,
        'prev_text' => '←',
        'next_text' => '→',
    ) );
    wp_reset_postdata();
    ?>
    <?php else : ?>
    <p class="text-muted" style="text-align:center; padding:80px 0;">Aucune actualité pour le moment.</p>
    <?php endif; ?>

  </div>
</section>
```

Conserver tels quels : le `page-hero`, le bloc LinkedIn `ctx-blue`, `get_header()` / `get_footer()`.

- [ ] **Step 2: Ajouter le CSS des cartes à la fin de `style.css`**

```css
/* Actualités — feed de cartes cliquables */
.actu-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; }
.actu-card { display: flex; flex-direction: column; border: 1px solid var(--border); border-radius: var(--radius-lg); overflow: hidden; background: white; transition: box-shadow .3s var(--ease-out), transform .3s var(--ease-out); }
.actu-card:hover { box-shadow: var(--shadow-lg); transform: translateY(-6px); }
.actu-card__img { display: block; height: 200px; overflow: hidden; background: var(--dark); }
.actu-card__img img { width: 100%; height: 100%; object-fit: cover; }
.actu-card__body { padding: 24px; display: flex; flex-direction: column; gap: 10px; flex: 1; }
.actu-card__date { font-family: var(--font-display); font-size: .72rem; font-weight: 700; color: var(--magenta); text-transform: uppercase; letter-spacing: .08em; }
.actu-card__title { font-family: var(--font-display); font-size: 1rem; font-weight: 700; line-height: 1.4; }
.actu-card__title a { color: var(--ink); text-decoration: none; }
.actu-card__title a:hover { color: var(--magenta); }
.actu-card__excerpt { font-size: .85rem; color: var(--ink-60); line-height: 1.6; flex: 1; }
.actu-card__footer { margin-top: auto; padding-top: 16px; border-top: 1px solid var(--border); }
@media (max-width: 1024px) { .actu-grid { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 640px) { .actu-grid { grid-template-columns: 1fr; } }
```

- [ ] **Step 3: Vérifier le rendu (pilote visible dans le feed)**

Run: `curl -s -o /dev/null -w "%{http_code}\n" http://localhost:8765/actualites/` puis `curl -s http://localhost:8765/actualites/ | grep -c 'actu-card__title'`
Expected: `200`, puis un nombre ≥ 1 (le titre pilote est rendu dans une carte du feed).

- [ ] **Step 4: Commit**

```bash
git add wordpress-dev/theme/page-templates/template-actualites.php wordpress-dev/theme/style.css
git commit -m "feat(actualites): feed cartes cliquables pagine + CSS actu-card"
```

### Task 4: Validation pilote de bout en bout (go / no-go)

Pas de code : checklist d'acceptation manuelle sur `http://localhost:8765` avant les lots.

- [ ] **Step 1: Feed** — ouvrir `/actualites/` : la carte pilote affiche image, `15 Juil 2026` (format `d M Y`), titre, extrait, bouton Lire.
- [ ] **Step 2: Article** — cliquer Lire : `single.php` affiche titre + date + image + paragraphes + listes, sans shortcodes ni HTML brut visible.
- [ ] **Step 3: Médias locaux** — `curl -s <permalink> | grep -o 'src="[^"]*"'` ne contient aucune URL `static.wixstatic.com` (images servies depuis `/wp-content/uploads/`).
- [ ] **Step 4: Compte-rendu** — noter go/no-go ; si no-go, corriger en Tasks 1-3 (pas de rollback nécessaire : 1 post marqué `_wix_import`, supprimable via `PID=$(docker compose exec -T wordpress wp post list --post_type=post --format=csv --fields=ID,post_title --allow-root | grep "10 ans du LAB" | cut -d, -f1 | tr -d '\r'); docker compose exec -T wordpress wp post delete $PID --force --allow-root`).

### Task 5: Import des lots (toutes les actualités)

**Files:** aucun (rejouabilité du script Task 2 ; skip idempotent des titres existants).

- [ ] **Step 1: Lancer l'import complet**

Run: `docker compose exec -T wordpress bash -c "IMPORT_ONLY=actualites_full wp eval-file wp-content/themes/labia-wp/inc/import-from-wix.php --allow-root" 2>&1 | tail -6`
Expected: `=== ACTUALITÉS FULL: 17X posts traités ===` avec des lignes `SKIP (exists)` pour les doublons des anciens JSON (65 + 26 articles déjà importés sous le même titre).

- [ ] **Step 2: Vérifier les volumes et bornes**

Run: `docker compose exec -T wordpress wp post list --post_type=post --format=count --allow-root` et `docker compose exec -T wordpress wp post list --post_type=post --format=csv --fields=post_date,post_title --allow-root | sort | head -2 && docker compose exec -T wordpress wp post list --post_type=post --format=csv --fields=post_date,post_title --allow-root | sort | tail -2`
Expected: count ≈ 174 + anciens posts ; plus ancien `2021-05-04`, plus récent `2026-07-15`.

- [ ] **Step 3: Vérifier la pagination du feed**

Run: `for p in 1 2 15; do echo -n "page $p: "; curl -s "http://localhost:8765/actualites/page/$p/" -o /dev/null -w "%{http_code}\n"; done`
Expected: `200` sur les trois (15 pages ≈ 174/12).

### Task 6: Presse — JSON existant + scrape des sections propres + `press_type`

**Files:**
- Modify: `wordpress-dev/theme/inc/import-from-wix.php` (ajoute `import_presse_full()` + inférence `press_type`)
- Create: `wordpress-dev/theme/import-data/presse-full.json` (généré par le même `tools/scrape-wix.py` étendu, mode `--presse`)

**Interfaces:**
- Consumes: `presse.json` existant (10 manquants 2021-2023 + Ros 2026, déjà au bon format) ; sections 2-12 de `/presse` (1 `h5` + 1 `h6` date complète chacune).
- Produces: `presse-full.json` (champs `title`, `date`, `source`, `url`, `excerpt`) ; `import_presse_full()` assigne la taxonomie `press_type` (termes créés si absents).

Constat : les sections 13/17/18 de `/presse` mélangent plusieurs articles par section (anciennes vidéos 2021-2022) — déjà couvertes par `presse.json`, on ne les scrape pas.

- [ ] **Step 1: Étendre `tools/scrape-wix.py` (mode presse)**

Ajouter à la fin du fichier (avant `if __name__`) :

```python
PRESS_URL = "https://www.labia-loirevalley.fr/presse"

SOURCE_MAP = [
    ("epicentre", "L'Épicentre"), ("actu.fr", "Actu.fr"),
    ("france 3", "France 3 Centre-Val de Loire"), ("france bleu", "France Bleu"),
    ("république du centre", "La République du Centre"),
    ("usine nouvelle", "L'Usine Nouvelle"), ("vibration", "Forum Vibration"),
    ("voxradio", "VoxRadio"), ("chérie fm", "Chérie FM Tours"),
    ("panorama", "Panorama des entreprises du Loiret"),
    ("acteurs de l'éco", "Acteurs de l'Éco"),
]

RANGE_RE = re.compile(r"^([a-zéû]+)\s*-\s*([a-zéû]+)\s+(\d{4})$")


def parse_presse_date(raw):
    d = H.unescape(strip_tags(raw)).strip().lower()
    m = RANGE_RE.match(d)  # ex. "mai - juin 2024" -> 1er du 1er mois
    if m:
        return f"{int(m.group(3)):04d}-{MONTHS[m.group(1)]:02d}-01 10:00:00"
    return parse_fr_date(d)


def scrape_presse(out_path):
    req = urllib.request.Request(PRESS_URL, headers=UA)
    src = urllib.request.urlopen(req, timeout=60).read().decode("utf-8")
    sections = re.findall(
        r'<section[^>]*class="[^"]*wixui-section"[^>]*>(.*?)</section>', src, re.S
    )
    articles = []
    for s in sections:
        h5s = re.findall(r"<h5[^>]*>(.*?)</h5>", s, re.S)
        m_date = re.search(r"<h6[^>]*>(.*?)</h6>", s, re.S)
        if len(h5s) != 1 or not m_date:
            continue  # header (0 h5) ou sections groupées (13/17/18)
        try:
            date = parse_presse_date(m_date.group(1))
        except (ValueError, KeyError):
            continue
        title = strip_tags(h5s[0])
        paras = [
            H.unescape(TAG_RE.sub("", p)).replace("\u200b", "").replace("\xa0", "").strip()
            for p in re.findall(r"<p[^>]*>(.*?)</p>", s, re.S)
        ]
        paras = [p for p in paras if p]
        excerpt = (paras[0][:300] + "…") if paras and len(paras[0]) > 300 else (paras[0] if paras else "")
        blob = (title + " " + " ".join(paras)).lower()
        source = ""
        for key, label in SOURCE_MAP:
            if key in blob:
                source = label
                break
        urls = [
            u for u in re.findall(r'href="([^"]+)"', s)
            if u.startswith("http") and "wixstatic" not in u
            and "labia-loirevalley.fr/_files" not in u
        ]
        pdfs = sorted(set(
            u for u in re.findall(r'href="([^"]+\.pdf[^"]*)"', s)
            if "_files/ugd" in u
        ))
        articles.append({
            "title": title, "date": date, "source": source,
            "url": urls[0] if urls else "", "excerpt": excerpt, "pdfs": pdfs,
        })
    with open(out_path, "w", encoding="utf-8") as f:
        json.dump(articles, f, ensure_ascii=False, indent=1)
    print(f"presse articles={len(articles)}")
```

Et dans `if __name__` : si `--presse` dans `sys.argv`, appeler `scrape_presse("wordpress-dev/theme/import-data/presse-full.json")`, sinon le comportement actu existant.

- [ ] **Step 2: Lancer + vérifier**

Run: `python3 tools/scrape-wix.py --presse && python3 -c "import json; a=json.load(open('wordpress-dev/theme/import-data/presse-full.json')); print(len(a)); [print(x['date'][:10], '|', x['title'][:60], '|', x['source']) for x in a[:3]]"`
Expected: `11` articles, le premier `2026-06-24 | Publication des articles sur l'IA de Frédéric Ros | …`.

- [ ] **Step 3: Ajouter `import_presse_full()` avec inférence `press_type`**

Append dans `import-from-wix.php` (l'appel est déjà couvert par le bloc RUN ALL sélectif de la Task 2 via `labia_run('presse_full')`, rien d'autre à modifier) :

```php
// ===================================================================
// IMPORT PRESSE FULL (presse-full.json) + taxonomie press_type
// ===================================================================
function labia_press_type_for($title, $excerpt) {
    $blob = strtolower($title . ' ' . $excerpt);
    if (strpos($blob, 'video') !== false) {
        return 'video';
    }
    if (strpos($blob, 'radio') !== false || strpos($blob, 'podcast') !== false
        || strpos($blob, 'fm ') !== false || strpos($blob, 'vibration') !== false
        || strpos($blob, 'voxradio') !== false || strpos($blob, 'france bleu') !== false
        || strpos($blob, 'chérie') !== false) {
        return 'radio';
    }
    if (strpos($blob, 'magazine') !== false || strpos($blob, 'épicentre') !== false
        || strpos($blob, 'panorama') !== false || strpos($blob, 'acteurs de l') !== false) {
        return 'magazine';
    }
    return 'article';
}

function import_presse_full() {
    $articles = import_json('presse-full.json');
    $limit = getenv('IMPORT_LIMIT') !== false ? intval(getenv('IMPORT_LIMIT')) : 0;
    $count = 0;
    $done = 0;

    foreach ($articles as $a) {
        $title = $a['title'] ?? '';
        if (empty($title)) {
            continue;
        }
        if ($limit > 0 && $done >= $limit) {
            break;
        }
        $done++;
        $post_id = wp_create_post_safe(array(
            'post_type'   => 'press_article',
            'post_title'  => $title,
            'post_date'   => $a['date'] ?? date('Y-m-d H:i:s'),
            'post_status' => 'publish',
        ));
        if (!$post_id) {
            continue;
        }
        if (!empty($a['date'])) {
            update_post_meta($post_id, 'pub_date', strtotime($a['date']));
        }
        if (!empty($a['source'])) {
            update_post_meta($post_id, 'source', $a['source']);
        }
        if (!empty($a['url'])) {
            update_post_meta($post_id, 'article_url', $a['url']);
        }
        if (!empty($a['excerpt'])) {
            update_post_meta($post_id, 'excerpt', $a['excerpt']);
        }
        update_post_meta($post_id, '_wix_import', '1');

        $slug = labia_press_type_for($title, $a['excerpt'] ?? '');
        if (!term_exists($slug, 'press_type')) {
            wp_insert_term(ucfirst($slug), 'press_type', array('slug' => $slug));
        }
        wp_set_object_terms($post_id, $slug, 'press_type');

        $content = '';
        foreach (($a['pdfs'] ?? array()) as $pdf_url) {
            $local = labia_sideload_pdf($pdf_url, $post_id);
            if ($local !== '') {
                if (empty($content)) {
                    $content = $local;
                    update_post_meta($post_id, 'article_url', $local);
                }
            }
        }
        $count++;
    }
    echo "\n=== PRESSE FULL: $count articles traités ===\n";
}
```

Note : l'article Ros (24 juin 2026) existe aussi dans `presse.json` → le skip idempotent par titre évite le doublon ; ses PDF sont rapatriés par `labia_sideload_pdf()` (Task 2) et `article_url` pointe vers la copie locale.

- [ ] **Step 4: Lint + import presse (les 10 de `presse.json` via l'existant + les 11 scrapés)**

Run: `php -l wordpress-dev/theme/inc/import-from-wix.php`
Expected: `No syntax errors detected`.

Run: `docker compose exec -T wordpress bash -c "IMPORT_ONLY=presse_full IMPORT_LIMIT=1 wp eval-file wp-content/themes/labia-wp/inc/import-from-wix.php --allow-root" 2>&1 | tail -8`
Expected: contient `=== PRESSE FULL: 1 articles traités ===` sans `ERROR` (seul l'article Ros du 24 juin 2026 est créé ; actus/clients non touchés grâce à `IMPORT_ONLY`).

- [ ] **Step 5: Vérifier puis solder**

Run: `docker compose exec -T wordpress wp post list --post_type=press_article --format=csv --fields=post_title --allow-root | wc -l`
Expected: ≥ 15 lignes (14 existants + pilote). Contrôle visuel `/presse/` : le pilote apparaît dans la timeline avec le bon type/filtre. Ensuite solder sans `IMPORT_LIMIT` : `IMPORT_ONLY=presse,presse_full` (les 10 de `presse.json` + les 11 scrapés, doublons skippés), et vérifier le total final (`24 + nouveaux 2024-2026` hors doublon Ros).

- [ ] **Step 6: Commit**

```bash
git add tools/scrape-wix.py wordpress-dev/theme/import-data/presse-full.json wordpress-dev/theme/inc/import-from-wix.php
git commit -m "feat(import): presse full + press_type + sideload PDF"
```

### Task 7: Déploiement distant + contrôles finaux

- [ ] **Step 1: Vérifier la layout distante puis synchroniser le thème**

Run: `ssh -p 43 -i ~/.ssh/id_monitoring selim@10.0.18.215 "ls ~/labia-wp/ && ls ~/labia-wp/wordpress-dev/theme/wp-content 2>/dev/null; docker ps --format '{{.Names}}' | head -5"`
Expected: repère le chemin du thème monté (ex. `~/labia-wp/wordpress-dev/theme`). Puis `rsync -avz -e "ssh -p 43 -i ~/.ssh/id_monitoring" wordpress-dev/theme/ selim@10.0.18.215:~/labia-wp/wordpress-dev/theme/` (adapter le chemin distant d'après le `ls`).
Expected: transfert sans erreur, sans supprimer de fichiers (`--delete` interdit).

- [ ] **Step 2: Rejouer l'import sur le distant (idempotent, ne crée que les manquants)**

Run: `ssh -p 43 -i ~/.ssh/id_monitoring selim@10.0.18.215 "cd ~/labia-wp/wordpress-dev && docker compose exec -T wordpress bash -c \"IMPORT_ONLY=actualites_full,presse,presse_full wp eval-file wp-content/themes/labia-wp/inc/import-from-wix.php --allow-root\"" 2>&1 | tail -8`
Expected: mêmes totaux qu'en local, `SKIP (exists)` pour l'existant.

- [ ] **Step 3: Contrôles finaux** — `http://10.0.18.215:8765/actualites/` (200, cartes + pagination), un permalink d'article (200, images locales), `/presse/` (timeline + filtres). Si régression : les médias distants sont indépendants du local ; rollback DB via le dump du serveur si besoin.
