# LAB'IA Loire Valley — AGENTS.md

## Stack
- WordPress 6.6+, PHP 8.2+, MariaDB 10.6
- Thème custom `labia-wp` (PHP templates, pas de page builder, pas de Twig/Timber)
- CMB2 pour champs custom (pas ACF, pas Carbon Fields)
- Vanilla JS, pas de jQuery, pas de framework frontend
- CSS custom properties (design tokens dans `:root`)

## Conventions

- **Templates PHP** : `get_header()` / `get_footer()`, boucles `get_posts()` / `WP_Query`
- **Helpers CPT** : fonctions dédiées dans chaque `inc/cpt-*.php` (ex: `labia_get_team_members()`, `labia_hex_to_rgba()`, `labia_get_initials()`, `labia_avatar_color()`)
- **Options globales** : via `labia_opt('field_name')` depuis Options Page CMB2
- **Active nav** : gérée côté serveur dans `header.php` avec `is_page()`, pas de JS
- **URLs** : toujours `home_url()` ou `LABIA_THEME_URI` (pas de chemins relatifs)
- **CSS** : modifications dans `style.css`, pas de styles inline sauf cas exceptionnel. Accents de couleur via variables CSS avec fallback : `var(--team-accent, var(--magenta))` ou `var(--avatar-color, var(--magenta))`
- **CMB2 taxonomy fields** : champs sur les termes de taxonomie avec `'object_types' => array( 'term' ), 'taxonomies' => array( 'ma_taxo' )`
- **Avatars témoignages** : photo si présente, sinon initiales sur fond coloré (cycle bleu `#4FB0FF` → indigo `#475297` → violet `#852F85` → magenta `#E2007D`). Utiliser `labia_get_initials($name)` et `labia_avatar_color($index)` dans `cpt-testimonial.php`.
- **Document title** : `add_theme_support('title-tag')` activé dans `functions.php` — WordPress génère le `<title>` automatiquement.

## Structure thème

- `inc/cmb2-config.php` : loader de tous les fichiers CPT
- `inc/options-general.php` : Options Page + `labia_opt()` helper
- `inc/cpt-*.php` : chaque CPT avec sa déclaration, ses champs CMB2, et son helper
- `page-templates/template-*.php` : templates de pages
- `template-parts/` : sections réutilisables

## Pages dynamiques

Les pages avec contenu éditable depuis l'admin utilisent des boucles CPT dans leur template. Les pages sans CPT sont des ports 1-to-1 du HTML statique. Voir README.md pour la liste.

## Développement

- Le thème est bind-mounté depuis `wordpress-dev/theme/` dans le container Docker
- Modifier un fichier → recharger le navigateur, pas de build step

### Server distant (dev)

Le site tourne sur un serveur Linux à l'adresse `http://10.0.18.215:8765` accessible depuis le réseau local.

- **Fichiers** : copier `wordpress-dev/` vers le serveur via `./deploy.sh` ou rsync
- **Connexion** : `ssh -p 43 -i ~/.ssh/id_monitoring selim@10.0.18.215`
- **Containers** : `docker compose up -d` dans `~/labia-wp/`
- **Base de données** : la DB locale (`docker exec labia_wpdb mysqldump -u wp -pwppass wordpress > dump.sql`) peut être importée sur le serveur
