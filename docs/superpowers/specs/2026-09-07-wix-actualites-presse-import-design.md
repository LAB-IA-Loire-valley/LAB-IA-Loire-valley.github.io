# Import Actualités + Presse depuis Wix

Importer tout le contenu manquant depuis le site Wix (`labia-loirevalley.fr`) vers WordPress : ~150 actualités (2021 → juillet 2026) et ~10 articles presse manquants. Approche : scraper Python → JSON versionnés → import PHP idempotent (réutilise `inc/import-from-wix.php`). Pilote d'abord avec 1 article riche, puis lots.

## Décisions validées

- Chaque actu = `post` standard cliquable + carte preview sur la page Actualités (lien vers `single.php`).
- Images copiées en local (médiathèque, 1ère = image mise en avant), jamais de hotlink `wixstatic`.
- PDF Wix (`_files/ugd/...`) rapatriés en local avec réécriture des liens.
- Presse : même pipeline (1 pilote + solde), `press_type` inféré, template presse inchangé.

## Contexte technique (constats d'exploration)

- `template-actualites.php` lit le CPT `news_article`, mais l'importeur écrit dans `post` et `single.php` ne gère que `post` → incohérence à résorber (section 4).
- `theme/import-data/actualites.json` = 65 articles (2021 → nov 2024) ; `wordpress-dev/import-data/actualites.json` = 26 articles (2026). Aucun ne couvre tout.
- Presse : 14 en DB + 10 dans `presse.json` = 24, conforme à `wix-content-extract.md`.
- Sources Wix = 2 longues pages (`/actualité`, `/presse`), pas un blog : pas d'URLs par article, pas de RSS. Contenu présent en SSR → pas de JS/headless nécessaire (vérifié par fetch).
- Page Wix à jour jusqu'au 15 juillet 2026 (plus récente que l'extract de juin 2026).

## Section 1 — Scraper Python

- Script `tools/scrape-wix.py` : fetch SSR des 2 pages, parse par article (date FR → ISO, titre, HTML).
- Nettoyage HTML : garder p, listes, liens, emojis ; jeter scories Wix répétées (logo `LOGO_LABIA_Q_S-BASELINE`, pictos décoratifs).
- Collecte images `static.wixstatic.com` (URLs originales) + inventaire liens (externes conservés, PDF `_files/ugd` à rapatrier).
- Dédoublonnage par couple titre+date.

## Section 2 — JSON intermédiaires

- `actualites-full.json` / `presse-full.json` versionnés dans le repo : `title`, `date` ISO, `content_html`, `images[]`, `pdfs[]`, `source_url`.
- Inspectables à la main avant import ; import rejouable sans re-scraper.

## Section 3 — Import PHP

- Étendre `inc/import-from-wix.php` sans casser l'existant : `wp_insert_post` type `post`, `post_date` = date Wix d'origine, `post_status` publish.
- Sideload images (1ère → featured), sideload PDF en pièces jointes + réécriture des liens dans `post_content`.
- Marquage `meta _wix_import=1`, skip idempotent sur titre existant, mode pilote `LIMIT=1`.
- Pilote : « 10 ans du LAB'O » du 15 juillet 2026 (2 photos + listes à puces).

## Section 4 — Template Actualités

- Réécrire `template-actualites.php` : `WP_Query` sur `post`, cartes preview (featured image, date, titre, extrait, bouton Lire → permalink).
- `single.php` déjà compatible (fallbacks miniature/date). Réutiliser classes `actu-card` du statique. Hero + bloc LinkedIn inchangés.
- CPT `news_article` : laissé en place (pas de suppression de données), simplement plus alimenté ni affiché.

## Section 5 — Presse

- Parse de `/presse` → `press_article` + `press_type` inféré (article/vidéo/radio/magazine selon icône et source, défaut article).
- Metas existantes (`pub_date`, `source`, `article_url`, `excerpt`), PDF rapatriés comme actus. `template-presse.php` inchangé.

## Section 6 — Pagination, environnement, rollback

- Feed paginé (12/page, pagination WP native, sans JS) pour ~160 posts.
- Ordre : dump DB → pilote actu en local (`docker compose up -d`, stack arrêté) → contrôle visuel feed + single + images + liens → lots 2026/2025/2024/2021-2023 → pilote presse → solde presse → déploiement distant.
- Rollback ciblé via `meta _wix_import=1`.

## Hors scope

- Clients/partenaires/témoignages supplémentaires de l'extract (autre chantier).
- Refonte visuelle des templates (on réutilise l'existant).
- Redirections d'URLs Wix (pas d'URLs par article côté Wix, rien à rediriger).
