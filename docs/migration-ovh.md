# Migration LAB'IA Loire Valley vers OVH

Migration du site WordPress (serveur docker `10.0.18.215:8765`) vers l'hébergement mutualisé OVH.
Date : 2026-09-03

## État final

- **URL temporaire** : http://savqafo.cluster131.hosting.ovh.net
- **Contenu (re-déployé le 2026-09-09, voir section Re-déploiement)** : 181 posts / 24 `press_article` (174 actus + 10 presse Wix, médias locaux)
- **Hébergement** : OVH, cluster131 — FTP `ftp.cluster131.hosting.ovh.net` (user `savqafo`)
- **Base de données** : `savqafoadmin` (user `savqafoadmin`, host `savqafoadmin.mysql.db` — réseau interne OVH, pas `localhost`)
- **Site vérifié** : 0 erreur PHP, permaliens OK, wp-admin OK, thème + CMB2 actifs
- **Domaine `labia-loirevalley.fr`** : pas encore pointé (en cours) — voir « Reprendre plus tard »

## Ce qui a été fait

### 1. Récupération depuis le serveur docker (10.0.18.215)

```bash
# Fichiers WP (volume docker labia_wp_wpdata), thème exclu (bind mount)
ssh -p 43 -i ~/.ssh/id_monitoring selim@10.0.18.215 \
  "docker exec labia_wp tar czf - -C /var/www/html --exclude=wp-content/themes/labia-wp ." > wpdata.tar.gz

# Dump DB
ssh -p 43 -i ~/.ssh/id_monitoring selim@10.0.18.215 \
  "docker exec labia_wpdb mysqldump -u wp -pwppass wordpress" > labia-import.sql

# Thème : celui du repo git local (plus récent que celui du serveur : footer/spacing)
# Copié dans wp-content/themes/labia-wp, SANS import-data/ ni import-from-wix.php (outils de dev)
```

**Points notables sur l'ancien serveur :**
- Le plugin **CMB2 n'était pas installé** (seulement akismet) → les metaboxes admin ne fonctionnaient pas ; le contenu existait quand même en DB (postmeta)
- Pas de dossier `wp-content/uploads` (aucune médiathèque)

### 2. Préparation du bundle (dossier `/tmp/opencode/labia-ovh/`)

- `wp-config.php` généré depuis le sample avec :
  - `DB_NAME`/`DB_USER` : `savqafoadmin`, `DB_PASSWORD` : mot de passe FTP, `DB_HOST` : **`savqafoadmin.mysql.db`** (⚠️ pas `localhost` ni `127.0.0.1` — échec socket/timeout)
  - Sels d'auth frais via `https://api.wordpress.org/secret-key/1.1/salt/`
  - `WP_DEBUG false`, `WP_MEMORY_LIMIT 256M`
- Plugin **CMB2** téléchargé : `https://downloads.wordpress.org/plugin/cmb2.latest-stable.zip` → `wp-content/plugins/cmb2`
- Dump SQL préparé (`labia-import.sql`) :
  - Inventorier TOUTES les familles d'URL d'abord (`grep -o 'http://localhost[0-9:]*' dump.sql | sort | uniq -c` + `grep -o 'http://10.0.18.215:[0-9]*'`) — en sept. 2026 le dump contenait 5 familles (`10.0.18.215:8765` siteurl/home + `localhost:8765/8082/8080` et `localhost` nu dans contenus/guids, ~574 refs). Remplacement **serialization-safe obligatoire** (les strings PHP sérialisées portent leur longueur `s:<len>:` — un remplacement naïf casse les postmeta ; recalculer les longueurs, ex. script `replace_urls.py`, et valider 0 sérialisation cassée après).
  - `siteurl` + `home` → `http://savqafo.cluster131.hosting.ovh.net`
  - 2 `guid` de news corrigés pareillement
  - `active_plugins` : `a:0:{}` → `a:1:{i:0;s:13:"cmb2/init.php";}` (⚠️ pas `s:4:"cmb2"` — le basename/len correct est `cmb2/init.php`, sinon WP n'active pas CMB2)

### 3. Upload FTP

- Script `upload.py` (Python stdlib `ftplib`, exécuté avec **`uv run upload.py`**) : upload récursif, résumable (skip si taille distante identique)
- `www/` contenait un symlink `index.html` (welcome OVH) → supprimé sinon il prend le dessus sur `index.php`
- **Glitch OVH** : le proxy FTP rejette le fichier `wp-includes/js/mediaelement/mediaelement.min.js` (erreur `451 Transfer aborted`, 0 octet stocké, même via curl, contenu pourtant propre). Contournement : ajout d'un préfixe de commentaire `/* upload labia */` (19 octets) — upload OK. Sans impact sur le JS.

### 4. Import DB

- Script temporaire `import.php` uploadé dans `www/` (protégé par token `?key=...`) + `labia-import.sql` à côté
- `mysqli` multi-query → **12 tables, 88 posts importés**
- ⚠️ Découverte : `localhost` = socket inexistant, `127.0.0.1`/`sql.cluster131.hosting.ovh.net` = timeout → seul `savqafoadmin.mysql.db` marche (résolvable uniquement depuis l'hébergement, réseau privé OVH)
- Script + SQL **supprimés du FTP** immédiatement après

### 5. Vérifications

- Homepage : HTTP 200, titre OK, sections CPT rendues (solutions, 6 étapes, témoignages), CSS chargé, 0 erreur PHP
- `/qui-sommes-nous/`, `/actualites/` : 200 (permaliens + `.htaccess` OK)
- `wp-admin` : login OK
- Mise à jour auto WP déclenchée au 1er chargement (`.maintenance` temporaire → WP s'est auto-mis à jour) — normal, ne pas s'inquiéter

## Re-déploiement 2026-09-09 (contenu Wix : 174 actus + 10 presse)

Rejeu de la procédure §1-5 pour pousser le nouveau contenu ( distant dev : 181 posts, 24 `press_article`, uploads 1700 fichiers / 950 Mo).

- **Bundle** : 5997 fichiers / 1061 Mo (tar distant hors thème + dump 1 Mo + thème du repo **sans** `import-data/` ni `inc/import-from-wix.php` + CMB2 re-téléchargé + sels frais + workaround mediaelement appliqué en préventif). `wp-config.php` généré par script avec assertion du contenu (leçon d'un `wp-config` docker uploadé par erreur → 500 général, réparé par re-upload du seul fichier).
- **Rewrite DB** : les 5 familles d'URL → host OVH via `replace_urls.py` (0 sérialisation cassée, 574 refs NEW-host, `article_url` Ros et guids attachments inclus).
- **Upload FTP** (`upload.py` stdlib, résumable, `nohup`) : 1708 uploadés / 4289 skippés / 0 échec, ~992 Mo en 649 s (~1,5 Mo/s). Pas de 451 cette fois.
- **Import DB** : `import.php` + token, `queries=136` → **posts=181 / press=24** (match exact distant). **Script + SQL supprimés du FTP aussitôt** (vérifié `SIZE` 550 + HTTP 404).
- **Vérifs** : `/`, `/actualites/` (pagination jusqu'à `/page/16/`), `/presse/`, `/wp-login.php` → 200, 0 erreur PHP en source.
- **État OVH actuel** : 181 posts / 24 presse, thème avec feed cartes + timeline presse. Durée totale ~67 min.
- ⚠️ `/tmp/opencode/labia-ovh/` (dont `upload.py`) avait été effacé (tmp volatile) → tout reconstruit ; mot de passe FTP passé par variable d'env, **jamais stocké** (ni repo ni rapport). Pour les prochains runs : garder un `upload.py` sans credential (env-based) versionné ou adossé à cette doc.

## Re-déploiement 2026-10-12 (thème : roadmap, plan d'accès, cartes service, tirets)

Mise en ligne des 5 commits du jour (`b1de17c..cccd31a`) — thème seul, delta minimal.

- **Delta** : 17 fichiers (`style.css`, `assets/js/main.js`, `front-page.php`, `template-qui-sommes-nous.php`, `plan-labia.png` + templates/inc reformulés), poussés via `upload.py` → **17 uploadés / 0 échec**. Fichiers dev exclus (`preview-*.html`, `import-data/`, `inc/import-from-wix.php` — jamais déployés, absents du FTP).
- **Avant** : prod exactement à l'état `b1de17c` (MD5 `style.css` = `76beb663…`, `main.js` = `3a0cf610…`).
- **Après** : MD5 prod = repo HEAD (`style.css` = `37b5a887…`, `main.js` = `f1729187…`) ; `plan-labia.png` 200 (67 983 o) ; marqueurs OK (`map-block__plan`, `card-trace`, footer « · Technopole d'Orléans ») ; 11 pages principales → 200, 0 erreur PHP.
- **Reste (base prod, en attente de validation)** : reformulation des tirets cadratins en base — 16 visibles en prod (`/presse/` 8, `/ils-nous-font-confiance/` 4, `/nos-solutions/` 3, `/actualites/` 1) + contenus/attachments. Faite en **local uniquement** (`dash-fix.sql`).

## Reprendre plus tard

### Quand `labia-loirevalley.fr` est prêt (DNS)

1. **OVH Manager → Hébergement → Multisite / Domaines** : ajouter `labia-loirevalley.fr` (si le domaine est chez OVH, il s'attache directement)
2. **DNS** : si le domaine est externe, pointer les A records vers `cluster131.hosting.ovh.net` (IP 146.59.209.152) + CNAME si besoin (www, etc.)
3. **Mettre à jour l'URL dans la DB** (sinon les liens internes restent sur l'URL temporaire) :
   ```sql
   UPDATE wp_options SET option_value='https://labia-loirevalley.fr' WHERE option_name IN ('siteurl','home');
   ```
   (via phpMyAdmin OVH : https://phpmyadmin.ovh.net, ou script temporaire comme à l'étape 4)
4. Passer le site en HTTPS : OVH fournit le certificat SSL auto pour le domaine
5. Vérifier la redirection http → https et re-tester wp-admin

### Rappels utiles

- **Admin WordPress** : récupérer les identifiants depuis le gestionnaire de secrets de l’équipe. S’ils sont absents, réinitialiser le compte via un canal d’administration autorisé avant tout accès.
- **PhpMyAdmin OVH** : https://phpmyadmin.ovh.net (user `savqafoadmin`)
- **Fichiers** : les modifications de thème se font dans le repo (`wordpress-dev/theme/`), puis upload vers `www/wp-content/themes/labia-wp/` via FTP
- **L'ancien serveur (10.0.18.215) n'est plus utilisé pour le site** (décision du 2026-10-12) — ne plus y déployer, ne plus s'en servir comme fallback
- Si un jour le FTP rejette un fichier avec `451` : ajouter un préfixe de commentaire inoffensif et re-uploader

## Fichiers de travail (temporaires, dans /tmp/opencode/labia-ovh/)

- `wpdata/` : bundle WP complet prêt à uploader (wp-config OVH inclus)
- `labia-import.sql` : dump nettoyé (URL OVH + CMB2 actif)
- `upload.py` : script d'upload FTP résumable (à relancer avec `uv run upload.py`)
- `wpdata.tar.gz` : archive WP brute du serveur
- `replace_urls.py` : remplacement d'URL serialization-safe pour le dump (voir Re-déploiement) — à conserver hors `/tmp` (volatile), sans credential (mot de passe par variable d'env uniquement)