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
- **Contextes colorés** : `ctx-dark`, `ctx-magenta`, `ctx-indigo`, `ctx-blue`, `ctx-violet`, `ctx-offwhite`. Les classes `ctx-*` (sauf `ctx-offwhite`) ajoutent automatiquement des éléments flottants décoratifs via `::before`/`::after`. Toujours mettre `.container` en `position: relative; z-index: 1` dans ces contextes (déjà fait dans les classes).
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

### Déploiement (production)

- **Prod** : https://labia-loirevalley.fr (hébergement OVH, cluster131)
- **Thème** : upload FTP via le script du repo (credentials par variables d'env, jamais dans le code) :

  ```bash
  OVH_FTP_PASS=... uv run tools/upload.py wordpress-dev/theme www/wp-content/themes/labia-wp
  ```

- **Base de données prod** : phpMyAdmin OVH (user `savqafoadmin`) — procédure complète dans `docs/migration-ovh.md`
- ⚠️ L'ancien serveur docker `10.0.18.215:8765` n'est plus utilisé pour le site — ne plus y déployer ni s'en servir comme environnement de dev.
