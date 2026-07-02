# LAB'IA Loire Valley — WordPress Migration Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Migrate the static LAB'IA Loire Valley site (10 HTML pages) to a WordPress 6.6+ theme with CMB2, achieving pixel-perfect visual fidelity and full content management from the WP admin.

**Architecture:** Custom WordPress theme (`labia-wp`) with PHP templates. Six Custom Post Types (team members, clients, testimonials, formations, press articles, solutions) and one CMB2 Options Page for global settings. CSS ported verbatim from the static site (1283 lines, no changes). Sections are fixed (not drag-and-drop) for pixel-perfect guarantee.

**Tech Stack:** WordPress 6.6+, PHP 8.2+, MySQL 8.0+/MariaDB 10.6+, CMB2 2.12+, WPForms Lite, vanilla JS, custom theme (no page builder, no Timber/Twig).

**Spec:** `docs/superpowers/specs/2026-07-02-wordpress-migration-design.md`

## Global Constraints

- **PHP version**: 8.2 minimum
- **WordPress version**: 6.6 minimum, test against 6.6 and 7.0
- **Plugin CMB2**: must be bundled with the theme under `labia-wp/inc/cmb2/` (do NOT rely on the wordpress.org plugin — it must travel with the theme)
- **CSS**: 1283-line `style.css` from the static site is the source of truth, ported verbatim with only URL function replacements
- **JS**: `main.js` from the static site is ported verbatim
- **Fidelity**: visual rendering must be pixel-perfect with the static site at all 3 breakpoints (mobile < 768px, tablet 768-1024px, desktop > 1024px)
- **Commit cadence**: every task ends with a `git commit` — never end a session with uncommitted changes
- **Test environment**: LocalWP on WSL, or any WordPress 6.6+ instance with PHP 8.2+
- **No new dependencies** beyond what is in the spec (no ACF, no Elementor, no Timber, no page builder)
- **Working directory** for the theme: `labia-wp/` at the WordPress root: `wp-content/themes/labia-wp/`

---

## Phase 0 — Foundation (must be completed first)

### Task 0.1: Setup local WordPress environment

**Files:**
- Create: `labia-wp/` (empty directory at this point)

**Goal:** Get a working WordPress 6.6+ instance on the developer's machine with PHP 8.2+.

- [ ] **Step 1: Install a local WordPress environment**

Choose ONE:
- **LocalWP** (recommended on WSL): download from https://localwp.com, create a new site named `labia`, set admin user/password, start the site. Note the local URL (e.g. `http://labia.local`).
- **wp-env**: `npx @wordpress/env start` in a folder containing a `.wp-env.json` file with `{"phpVersion": "8.2"}`.
- **Docker Compose**: use `wordpress:6.6-php8.2` and `mariadb:10.6` images.

Expected: A working WP admin reachable at `http://labia.local/wp-admin` (or similar) with PHP 8.2+ confirmed in `Site Health > Info > Server`.

- [ ] **Step 2: Verify PHP and WordPress versions**

In WP admin, go to `Tools > Site Health > Info > Server`. Confirm:
- PHP version: 8.2 or higher
- MySQL/MariaDB version: 8.0+ / 10.6+
- WordPress version: 6.6 or higher

- [ ] **Step 3: Set permalinks to "Post name"**

In WP admin, go to `Settings > Permalinks`, select "Post name" structure, click "Save Changes". This enables pretty URLs.

- [ ] **Step 4: Set the static front page to "A static page" placeholder**

In WP admin, go to `Settings > Reading > Your homepage displays`, select "A static page". Create two placeholder pages: "Accueil" and "Blog" (trash the "Blog" content, keep for later). Set "Accueil" as the homepage, "Blog" as the posts page.

- [ ] **Step 5: Install and activate the CMB2 plugin**

Download CMB2 2.12+ from https://wordpress.org/plugins/cmb2/, OR (better) clone https://github.com/CMB2/CMB2 into `wp-content/plugins/cmb2`. Activate via `Plugins > Installed Plugins`.

Expected: CMB2 visible in admin sidebar (it has its own "CMB2 Admin" menu, that's normal).

- [ ] **Step 6: Create empty theme directory**

```bash
mkdir -p wp-content/themes/labia-wp
```

Do not put any files yet — first task of the next phase creates the theme.

- [ ] **Step 7: Commit environment setup note**

```bash
git add wp-content/themes/labia-wp/.gitkeep
git commit -m "chore(setup): local WordPress environment ready

- WP 6.6+ with PHP 8.2+ confirmed
- LocalWP on WSL (or alternative)
- Permalinks set to post name
- Static front page placeholder configured
- CMB2 plugin installed and activated
- Empty labia-wp theme directory created"
```

---

## Phase 1 — Theme shell (every page needs this)

### Task 1.1: Create theme files skeleton and stylesheet header

**Files:**
- Create: `wp-content/themes/labia-wp/style.css` (with theme header + the full 1283-line CSS)
- Create: `wp-content/themes/labia-wp/functions.php`
- Create: `wp-content/themes/labia-wp/index.php`
- Create: `wp-content/themes/labia-wp/header.php`
- Create: `wp-content/themes/labia-wp/footer.php`
- Create: `wp-content/themes/labia-wp/screenshot.png` (1200x900 placeholder, can be added later)

- [ ] **Step 1: Copy the static site's CSS into the theme**

```bash
cp /home/selim/projects/site/assets/css/style.css \
   wp-content/themes/labia-wp/style.css
```

- [ ] **Step 2: Add the WordPress theme header to style.css**

Prepend the following to `wp-content/themes/labia-wp/style.css`:

```css
/*
Theme Name: LAB'IA Loire Valley
Theme URI: https://labia-loirevalley.fr
Author: LAB'IA Loire Valley
Author URI: https://labia-loirevalley.fr
Description: Custom theme for LAB'IA Loire Valley — ported from the static HTML site, content managed via CMB2.
Version: 1.0.0
Requires at least: 6.6
Tested up to: 6.6
Requires PHP: 8.2
License: Proprietary
Text Domain: labia
*/
```

- [ ] **Step 3: Create minimal functions.php**

Create `wp-content/themes/labia-wp/functions.php` with:

```php
<?php
/**
 * LAB'IA Loire Valley — Theme functions
 *
 * Each include is intentionally ordered: the order matters because
 * CPTs and CMB2 must be registered before any template tries to use them.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'LABIA_THEME_DIR', get_template_directory() );
define( 'LABIA_THEME_URI', get_template_uri() );

// Load in correct order (CPTs first, then CMB2 config, then enqueue).
require_once LABIA_THEME_DIR . '/inc/enqueue.php';
```

- [ ] **Step 4: Create the enqueue file**

Create `wp-content/themes/labia-wp/inc/enqueue.php` with:

```php
<?php
/**
 * Enqueue theme assets
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

add_action( 'wp_enqueue_scripts', 'labia_enqueue_assets' );
function labia_enqueue_assets() {
    // Main stylesheet — WordPress will load style.css automatically,
    // but we also need to make sure Google Fonts are loaded.
    wp_enqueue_style(
        'labia-fonts',
        'https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;1,9..40,300&display=swap',
        array(),
        null
    );

    // Main JS — ported verbatim from the static site.
    wp_enqueue_script(
        'labia-main',
        LABIA_THEME_URI . '/assets/js/main.js',
        array(),
        '1.0.0',
        true
    );
}
```

- [ ] **Step 5: Create minimal index.php (fallback)**

Create `wp-content/themes/labia-wp/index.php` with:

```php
<?php
/**
 * Fallback index template — required by WordPress.
 * Will be replaced by proper page templates in later tasks.
 */

get_header();
?>
<main class="container" style="padding: 80px 0;">
    <h1>LAB'IA Loire Valley</h1>
    <p>Theme is loading. Page templates will be added in upcoming tasks.</p>
</main>
<?php
get_footer();
```

- [ ] **Step 6: Create minimal header.php**

Create `wp-content/themes/labia-wp/header.php` with:

```php
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a href="#main-content" class="skip-link">Aller au contenu</a>

<nav class="nav nav--dark-page" aria-label="Navigation principale">
    <div class="container">
        <div class="nav__inner">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="nav__logo">
                <img src="<?php echo esc_url( LABIA_THEME_URI . '/assets/img/logos/logo-labia-without-name.png' ); ?>" alt="LAB'IA Loire Valley" />
            </a>
            <ul class="nav__links">
                <li><a href="<?php echo esc_url( home_url( '/notre-offre/' ) ); ?>" class="nav__link">Notre Offre</a></li>
                <li><a href="<?php echo esc_url( home_url( '/nos-solutions/' ) ); ?>" class="nav__link">Nos Solutions</a></li>
                <li><a href="<?php echo esc_url( home_url( '/qui-sommes-nous/' ) ); ?>" class="nav__link">Qui sommes-nous</a></li>
            </ul>
            <div class="nav__actions">
                <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="btn btn-primary btn-sm">Nous contacter</a>
            </div>
        </div>
    </div>
</nav>
```

- [ ] **Step 7: Create minimal footer.php**

Create `wp-content/themes/labia-wp/footer.php` with:

```php
<footer class="footer">
    <div class="container">
        <p class="footer__bottom-text">© <?php echo date( 'Y' ); ?> LAB'IA Loire Valley — Technopole d'Orléans</p>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
```

- [ ] **Step 8: Copy the assets directory**

```bash
cp -r /home/selim/projects/site/assets wp-content/themes/labia-wp/assets
```

- [ ] **Step 9: Activate the theme**

In WP admin: `Appearance > Themes` — find "LAB'IA Loire Valley", click "Activate".

- [ ] **Step 10: Verify the theme is working**

Visit the homepage. Expected: a navy/dark page with a top nav containing the logo, three links, and a "Nous contacter" button. Below, a centered message "Theme is loading...".

Visit `?p=N` (any placeholder page) — should also show the same nav and footer.

- [ ] **Step 11: Commit**

```bash
git add wp-content/themes/labia-wp/
git commit -m "feat(theme): create LAB'IA theme skeleton with ported CSS

- Theme header in style.css
- Verbatim port of 1283-line CSS from static site
- Minimal header.php, footer.php, index.php
- assets/ directory (CSS, JS, logos) copied from static site
- functions.php with Google Fonts enqueue
- Theme activated in local WP

Verified: theme loads, dark nav and CSS variables working."
```

---

## Phase 2 — Options Page (CMB2) and global settings

### Task 2.1: Register CMB2 Options Page and global settings fields

**Files:**
- Create: `wp-content/themes/labia-wp/inc/options-general.php`
- Create: `wp-content/themes/labia-wp/inc/cmb2-config.php`
- Modify: `wp-content/themes/labia-wp/functions.php` (add require)

**Interfaces:**
- Consumes: CMB2 plugin (already activated in Task 0.1)
- Produces: an admin page "Paramètres LAB'IA" under `Réglages > Paramètres LAB'IA` with all global site fields

- [ ] **Step 1: Create the Options Page field group definition**

Create `wp-content/themes/labia-wp/inc/options-general.php`:

```php
<?php
/**
 * Global site options (CMB2 Options Page)
 *
 * Provides admin UI for site-wide settings: logo, contact details,
 * social URLs, financeur images, and hero block.
 *
 * Field names are stable: templates use get_option( 'labia_option_name' )
 * via the labia_opt() helper for these values.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

add_action( 'cmb2_admin_init', 'labia_register_options_page' );
function labia_register_options_page() {

    /**
     * Main options page — Réglages > Paramètres LAB'IA
     */
    $opt_page = new_cmb2_box( array(
        'id'           => 'labia_options',
        'title'        => 'Paramètres LAB'IA',
        'object_types' => array( 'options-page' ),
        'option_key'   => 'labia_options',
        'parent_slug'  => 'options-general.php',
        'capability'   => 'manage_options',
        'save_button'  => 'Enregistrer les paramètres',
    ) );

    // --- Identité ---
    $opt_page->add_field( array(
        'name' => 'Identité du site',
        'desc' => 'Logo, description, informations principales',
        'type' => 'title',
        'id'   => 'opt_identity_title',
    ) );

    $opt_page->add_field( array(
        'name' => 'Logo du site',
        'desc' => 'PNG ou SVG, fond transparent recommandé',
        'id'   => 'site_logo',
        'type' => 'file',
        'options' => array(
            'url' => false,
        ),
        'text'    => array( 'add_upload_file_text' => 'Choisir le logo' ),
    ) );

    $opt_page->add_field( array(
        'name' => 'Description (footer)',
        'desc' => 'Texte court affiché dans le footer',
        'id'   => 'footer_description',
        'type' => 'textarea',
    ) );

    // --- Contact ---
    $opt_page->add_field( array(
        'name' => 'Contact',
        'desc' => 'Coordonnées affichées dans le footer et la page Contact',
        'type' => 'title',
        'id'   => 'opt_contact_title',
    ) );

    $opt_page->add_field( array(
        'name' => 'Téléphone',
        'id'   => 'phone',
        'type' => 'text',
        'default' => '02 38 69 80 87',
    ) );

    $opt_page->add_field( array(
        'name' => 'Email',
        'id'   => 'email',
        'type' => 'text',
        'default' => 'contact@labia-loirevalley.fr',
    ) );

    $opt_page->add_field( array(
        'name' => 'Adresse — ligne 1',
        'id'   => 'address_line_1',
        'type' => 'text',
        'default' => 'Le LAB\'O — Village By CA Orléans',
    ) );

    $opt_page->add_field( array(
        'name' => 'Adresse — ligne 2',
        'id'   => 'address_line_2',
        'type' => 'text',
        'default' => '1 avenue du Champ de Mars, CS 30019',
    ) );

    $opt_page->add_field( array(
        'name' => 'Adresse — ville',
        'id'   => 'address_city',
        'type' => 'text',
        'default' => '45074 Orléans Cedex 2',
    ) );

    // --- Réseaux sociaux ---
    $opt_page->add_field( array(
        'name' => 'Réseaux sociaux',
        'type' => 'title',
        'id'   => 'opt_social_title',
    ) );

    $opt_page->add_field( array(
        'name' => 'URL LinkedIn',
        'id'   => 'linkedin_url',
        'type' => 'text',
        'default' => 'https://www.linkedin.com/company/lab-ia-loire-valley',
    ) );

    // --- Financeurs ---
    $opt_page->add_field( array(
        'name' => 'Financeurs (footer)',
        'desc' => 'Deux bandes d\'images affichées en bas du footer',
        'type' => 'title',
        'id'   => 'opt_financeurs_title',
    ) );

    $opt_page->add_field( array(
        'name' => 'Image financeurs LAB\'IA',
        'id'   => 'financeur_image_1',
        'type' => 'file',
    ) );

    $opt_page->add_field( array(
        'name' => 'Image financeurs Technopole',
        'id'   => 'financeur_image_2',
        'type' => 'file',
    ) );

    // --- Hero (page d'accueil) ---
    $opt_page->add_field( array(
        'name' => 'Hero (page d\'accueil)',
        'type' => 'title',
        'id'   => 'opt_hero_title',
    ) );

    $opt_page->add_field( array(
        'name' => 'Texte du badge hero',
        'id'   => 'hero_badge_text',
        'type' => 'text',
        'default' => 'Ambassadeur IA — Plan national Osez l\'IA',
    ) );

    $opt_page->add_field( array(
        'name' => 'Image badge ambassadeur',
        'desc' => 'Cercle affiché à droite du hero',
        'id'   => 'ambassador_badge_image',
        'type' => 'file',
    ) );

    $opt_page->add_field( array(
        'name' => 'Titre hero (HTML autorisé)',
        'desc' => 'Utilisez &lt;em&gt; pour italique, &lt;br/&gt; pour retour à la ligne',
        'id'   => 'hero_title',
        'type' => 'textarea',
        'default' => 'L\'intelligence<br/>artificielle,<br/><em>accessible à tous.</em>',
    ) );

    $opt_page->add_field( array(
        'name' => 'Sous-titre hero',
        'id'   => 'hero_lead',
        'type' => 'textarea',
        'default' => 'Le LAB\'IA Loire Valley accompagne les entreprises et structures de la région Centre-Val de Loire dans leurs projets Data & IA — du diagnostic à l\'industrialisation.',
    ) );

    $opt_page->add_field( array(
        'name' => 'CTA 1 — texte',
        'id'   => 'hero_cta_1_text',
        'type' => 'text',
        'default' => 'Découvrir notre offre',
    ) );

    $opt_page->add_field( array(
        'name' => 'CTA 1 — URL',
        'id'   => 'hero_cta_1_url',
        'type' => 'text',
        'default' => '/notre-offre/',
    ) );

    $opt_page->add_field( array(
        'name' => 'CTA 2 — texte',
        'id'   => 'hero_cta_2_text',
        'type' => 'text',
        'default' => 'Parler de mon projet',
    ) );

    $opt_page->add_field( array(
        'name' => 'CTA 2 — URL',
        'id'   => 'hero_cta_2_url',
        'type' => 'text',
        'default' => '/contact/',
    ) );
}
```

- [ ] **Step 2: Create a helper to read these values**

Append to the same file, `wp-content/themes/labia-wp/inc/options-general.php`:

```php
/**
 * Helper function to read a single options-page value.
 *
 * Usage in templates:
 *   $phone = labia_opt( 'phone' );
 *   $logo  = labia_opt( 'site_logo' );  // returns array with 'url' key
 *
 * @param string $key Field ID (without 'labia_options' prefix).
 * @param mixed  $default Default if empty.
 * @return mixed Field value.
 */
function labia_opt( $key, $default = '' ) {
    $opts = get_option( 'labia_options', array() );
    return isset( $opts[ $key ] ) && $opts[ $key ] !== '' ? $opts[ $key ] : $default;
}
```

- [ ] **Step 3: Create the config file that loads all CMB2 modules**

Create `wp-content/themes/labia-wp/inc/cmb2-config.php`:

```php
<?php
/**
 * CMB2 field groups loader
 *
 * Each field group is defined in its own file under inc/.
 * Adding a new field group = add one require + create one file.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Global options page
require_once LABIA_THEME_DIR . '/inc/options-general.php';
```

- [ ] **Step 4: Wire the config into functions.php**

Replace the contents of `wp-content/themes/labia-wp/functions.php` with:

```php
<?php
/**
 * LAB'IA Loire Valley — Theme functions
 *
 * Each include is intentionally ordered: the order matters because
 * CPTs and CMB2 must be registered before any template tries to use them.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'LABIA_THEME_DIR', get_template_directory() );
define( 'LABIA_THEME_URI', get_template_uri() );

// Load in correct order: assets, then CPTs, then CMB2 config.
require_once LABIA_THEME_DIR . '/inc/enqueue.php';
require_once LABIA_THEME_DIR . '/inc/cmb2-config.php';
```

- [ ] **Step 5: Verify the Options Page is registered**

In WP admin: `Réglages > Paramètres LAB'IA` should now exist with all the field groups visible.

- [ ] **Step 6: Test it saves values**

Open the page, change the phone number, click "Enregistrer". Reload the page — the new value should be there. If not, check that CMB2 is still activated and that no PHP errors appear at the top of the page.

- [ ] **Step 7: Commit**

```bash
git add wp-content/themes/labia-wp/inc/options-general.php \
       wp-content/themes/labia-wp/inc/cmb2-config.php \
       wp-content/themes/labia-wp/functions.php
git commit -m "feat(options): register CMB2 Options Page for global settings

- Settings menu: Réglages > Paramètres LAB'IA
- Field groups: Identité, Contact, Réseaux, Financeurs, Hero
- labia_opt() helper for templates to read values
- Stable field IDs (no renaming later)
- Field types used: title, file, text, textarea

Verified: page renders, fields save, helper returns saved values."
```

---

## Phase 3 — Custom Post Types

### Task 3.1: Register the "team_member" CPT and "team_pole" taxonomy

**Files:**
- Create: `wp-content/themes/labia-wp/inc/cpt-team.php`
- Modify: `wp-content/themes/labia-wp/inc/cmb2-config.php` (add require)
- Create: `wp-content/themes/labia-wp/template-parts/card-team.php`

**Interfaces:**
- Produces:
  - CPT slug: `team_member`, archive at `/qui-sommes-nous/`
  - Taxo `team_pole` with terms: Pôle opérationnel, Pôle technique, Réseau d'experts, Équipe technopolitaine
  - Metabox fields: photo, role, bio, linkedin_url, display_order
  - Public functions: `labia_get_team_members( $pole_slug = null )` returns array of WP_Post

- [ ] **Step 1: Create the CPT file**

Create `wp-content/themes/labia-wp/inc/cpt-team.php`:

```php
<?php
/**
 * Custom Post Type: team_member
 * Taxonomy: team_pole
 *
 * Used on the "Qui sommes-nous" page, grouped by team_pole term.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

add_action( 'init', 'labia_register_cpt_team' );
function labia_register_cpt_team() {
    register_post_type( 'team_member', array(
        'labels' => array(
            'name'               => 'Membres équipe',
            'singular_name'      => 'Membre équipe',
            'add_new_item'       => 'Ajouter un membre',
            'edit_item'          => 'Modifier le membre',
            'all_items'          => 'Tous les membres',
            'menu_name'          => 'Équipe',
        ),
        'public'              => false,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_rest'        => true,
        'menu_position'       => 5,
        'menu_icon'           => 'dashicons-groups',
        'supports'            => array( 'title', 'editor' ),
        'has_archive'         => false,
        'rewrite'             => false,
        'capability_type'     => 'post',
    ) );

    register_taxonomy( 'team_pole', 'team_member', array(
        'labels' => array(
            'name'              => 'Pôles',
            'singular_name'     => 'Pôle',
            'add_new_item'      => 'Ajouter un pôle',
            'edit_item'         => 'Modifier le pôle',
            'all_items'         => 'Tous les pôles',
            'menu_name'         => 'Pôles',
        ),
        'public'              => false,
        'show_ui'             => true,
        'show_in_rest'        => true,
        'hierarchical'        => true,
        'show_admin_column'   => true,
    ) );
}

add_action( 'cmb2_admin_init', 'labia_register_team_metabox' );
function labia_register_team_metabox() {
    $box = new_cmb2_box( array(
        'id'           => 'team_member_metabox',
        'title'        => 'Informations du membre',
        'object_types' => array( 'team_member' ),
        'context'      => 'normal',
        'priority'     => 'high',
    ) );

    $box->add_field( array(
        'name' => 'Photo',
        'id'   => 'photo',
        'type' => 'file',
        'options' => array( 'url' => false ),
        'text'  => array( 'add_upload_file_text' => 'Choisir une photo' ),
    ) );

    $box->add_field( array(
        'name' => 'Rôle',
        'id'   => 'role',
        'type' => 'text',
    ) );

    $box->add_field( array(
        'name' => 'Biographie',
        'id'   => 'bio',
        'type' => 'textarea',
    ) );

    $box->add_field( array(
        'name' => 'URL LinkedIn',
        'id'   => 'linkedin_url',
        'type' => 'text',
    ) );

    $box->add_field( array(
        'name' => 'Ordre d\'affichage',
        'desc' => 'Plus petit = plus haut',
        'id'   => 'display_order',
        'type' => 'text_small',
        'default' => '10',
    ) );

    $box->add_field( array(
        'name' => 'Initiales (fallback photo)',
        'desc' => 'Affiché sur fond coloré si pas de photo (ex: CN pour Corinne Neau)',
        'id'   => 'initials',
        'type' => 'text_small',
    ) );

    $box->add_field( array(
        'name' => 'Couleur de fond (fallback)',
        'desc' => 'Variable CSS (ex: var(--magenta-faint)) ou code hex (#fff8e1)',
        'id'   => 'initials_bg',
        'type' => 'text',
    ) );

    $box->add_field( array(
        'name' => 'Couleur de texte (fallback)',
        'id'   => 'initials_color',
        'type' => 'text',
    ) );
}

/**
 * Public helper: fetch team members for a given pole slug.
 *
 * @param string|null $pole_slug team_pole term slug, or null for all.
 * @return WP_Post[]
 */
function labia_get_team_members( $pole_slug = null ) {
    $args = array(
        'post_type'      => 'team_member',
        'posts_per_page' => -1,
        'orderby'        => 'meta_value_num',
        'meta_key'       => 'display_order',
        'order'          => 'ASC',
        'no_found_rows'  => true,
    );

    if ( $pole_slug ) {
        $args['tax_query'] = array( array(
            'taxonomy' => 'team_pole',
            'field'    => 'slug',
            'terms'    => $pole_slug,
        ) );
    }

    return get_posts( $args );
}
```

- [ ] **Step 2: Register the CPT file in the config loader**

Edit `wp-content/themes/labia-wp/inc/cmb2-config.php` and prepend (before the require of `options-general.php`):

```php
// CPT field groups (each CPT in its own file)
require_once LABIA_THEME_DIR . '/inc/cpt-team.php';
```

Result: the file should now look like:

```php
<?php
/**
 * CMB2 field groups loader
 *
 * Each field group is defined in its own file under inc/.
 * Adding a new field group = add one require + create one file.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// CPT field groups (each CPT in its own file)
require_once LABIA_THEME_DIR . '/inc/cpt-team.php';

// Global options page
require_once LABIA_THEME_DIR . '/inc/options-general.php';
```

- [ ] **Step 3: Seed the four "team_pole" terms**

In WP admin, go to `Équipe > Pôles`. Add the following four terms (one by one, using "Add New Pole"):
- `pole-operationnel` — "Pôle opérationnel"
- `pole-technique` — "Pôle technique — Data Scientists"
- `reseau-experts` — "Réseau d'experts — Data Scientists partenaires"
- `equipe-technopolitaine` — "Équipe Technopolitaine — en support"

Expected: All four terms visible in `Équipe > Pôles`.

- [ ] **Step 4: Create one test team member**

In WP admin, go to `Équipe > Ajouter un membre`. Create a test member:
- Title: "Corinne Neau"
- Term: "Pôle opérationnel"
- Role: "Responsable Opérationnelle"
- Bio: "Suit le projet depuis 2020."
- Initials: "CN"
- initials_bg: `var(--magenta-faint)`
- display_order: `1`
- Click "Publier"

Expected: The post is saved. Going to `Équipe > Tous les membres` shows "Corinne Neau".

- [ ] **Step 5: Create the card template part**

Create `wp-content/themes/labia-wp/template-parts/card-team.php`:

```php
<?php
/**
 * Card for a single team member
 *
 * Required: $post (WP_Post) in scope
 * Uses CMB2 fields: photo, role, bio, initials, initials_bg, initials_color
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$photo_id       = get_post_meta( $post->ID, 'photo', true );
$role           = get_post_meta( $post->ID, 'role', true );
$bio            = get_post_meta( $post->ID, 'bio', true );
$initials       = get_post_meta( $post->ID, 'initials', true );
$initials_bg    = get_post_meta( $post->ID, 'initials_bg', true );
$initials_color = get_post_meta( $post->ID, 'initials_color', true );
$photo_url      = $photo_id ? wp_get_attachment_url( $photo_id ) : '';
?>
<div class="card card--team">
    <div class="card--team-photo"<?php echo $photo_url ? '' : ( $initials_bg ? ' style="background:' . esc_attr( $initials_bg ) . ';"' : '' ); ?>>
        <?php if ( $photo_url ) : ?>
            <img src="<?php echo esc_url( $photo_url ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" />
        <?php else : ?>
            <span<?php echo $initials_color ? ' style="color:' . esc_attr( $initials_color ) . ';"' : ''; ?>><?php echo esc_html( $initials ); ?></span>
        <?php endif; ?>
    </div>
    <?php if ( $role ) : ?>
        <div class="card--team-role"><?php echo esc_html( $role ); ?></div>
    <?php endif; ?>
    <div class="card--team-name"><?php echo esc_html( get_the_title() ); ?></div>
    <?php if ( $bio ) : ?>
        <p class="card--team-bio"><?php echo esc_html( $bio ); ?></p>
    <?php endif; ?>
</div>
```

- [ ] **Step 6: Commit**

```bash
git add wp-content/themes/labia-wp/inc/cpt-team.php \
       wp-content/themes/labia-wp/inc/cmb2-config.php \
       wp-content/themes/labia-wp/template-parts/card-team.php
git commit -m "feat(cpt): team_member CPT + team_pole taxonomy + card template

- CPT 'team_member' (admin-only, not public)
- Taxo 'team_pole' hierarchical with 4 terms seeded manually
- Metabox fields: photo, role, bio, linkedin, order, initials fallback
- labia_get_team_members() helper to query by pole
- card-team.php template part with photo or initials fallback

Verified: created test member, displays in admin with all fields."
```

### Task 3.2: Register the "client" CPT and "client_type" taxonomy

**Files:**
- Create: `wp-content/themes/labia-wp/inc/cpt-client.php`
- Modify: `wp-content/themes/labia-wp/inc/cmb2-config.php` (add require)
- Create: `wp-content/themes/labia-wp/template-parts/card-client.php`

**Interfaces:**
- Produces:
  - CPT slug: `client`
  - Taxo `client_type` with terms: Client, Partenaire, Financeur
  - Fields: logo, sector, site_url, display_order
  - Function: `labia_get_clients( $type_slug = null )`

- [ ] **Step 1: Create the CPT file**

Create `wp-content/themes/labia-wp/inc/cpt-client.php`:

```php
<?php
/**
 * Custom Post Type: client
 * Taxonomy: client_type
 *
 * Used by the client ticker and the "Ils nous font confiance" page.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

add_action( 'init', 'labia_register_cpt_client' );
function labia_register_cpt_client() {
    register_post_type( 'client', array(
        'labels' => array(
            'name'          => 'Clients & Partenaires',
            'singular_name' => 'Client / Partenaire',
            'add_new_item'  => 'Ajouter un client ou partenaire',
            'edit_item'     => 'Modifier',
            'all_items'     => 'Tous les clients',
            'menu_name'     => 'Clients',
        ),
        'public'          => false,
        'show_ui'         => true,
        'show_in_menu'    => true,
        'show_in_rest'    => true,
        'menu_position'   => 6,
        'menu_icon'       => 'dashicons-businessperson',
        'supports'        => array( 'title' ),
        'has_archive'     => false,
        'rewrite'         => false,
        'capability_type' => 'post',
    ) );

    register_taxonomy( 'client_type', 'client', array(
        'labels' => array(
            'name'          => 'Types',
            'singular_name' => 'Type',
            'add_new_item'  => 'Ajouter un type',
            'edit_item'     => 'Modifier le type',
            'all_items'     => 'Tous les types',
            'menu_name'     => 'Types',
        ),
        'public'              => false,
        'show_ui'             => true,
        'show_in_rest'        => true,
        'hierarchical'        => true,
        'show_admin_column'   => true,
    ) );
}

add_action( 'cmb2_admin_init', 'labia_register_client_metabox' );
function labia_register_client_metabox() {
    $box = new_cmb2_box( array(
        'id'           => 'client_metabox',
        'title'        => 'Informations du client',
        'object_types' => array( 'client' ),
    ) );

    $box->add_field( array(
        'name' => 'Logo',
        'desc' => 'SVG ou PNG transparent recommandé',
        'id'   => 'logo',
        'type' => 'file',
        'options' => array( 'url' => false ),
    ) );

    $box->add_field( array(
        'name' => 'Emoji (fallback logo)',
        'desc' => 'Affiché si pas de logo (ex: 🏗️)',
        'id'   => 'emoji',
        'type' => 'text',
    ) );

    $box->add_field( array(
        'name' => 'Secteur',
        'desc' => 'Ex: Mobilité · Transport',
        'id'   => 'sector',
        'type' => 'text',
    ) );

    $box->add_field( array(
        'name' => 'URL du site',
        'id'   => 'site_url',
        'type' => 'text',
    ) );

    $box->add_field( array(
        'name' => 'Ordre d\'affichage',
        'id'   => 'display_order',
        'type' => 'text_small',
        'default' => '10',
    ) );
}

/**
 * Public helper to fetch clients.
 *
 * @param string|null $type_slug client_type term slug (client|partenaire|financeur) or null.
 * @return WP_Post[]
 */
function labia_get_clients( $type_slug = null ) {
    $args = array(
        'post_type'      => 'client',
        'posts_per_page' => -1,
        'orderby'        => 'meta_value_num',
        'meta_key'       => 'display_order',
        'order'          => 'ASC',
        'no_found_rows'  => true,
    );

    if ( $type_slug ) {
        $args['tax_query'] = array( array(
            'taxonomy' => 'client_type',
            'field'    => 'slug',
            'terms'    => $type_slug,
        ) );
    }

    return get_posts( $args );
}
```

- [ ] **Step 2: Wire it into the config loader**

In `wp-content/themes/labia-wp/inc/cmb2-config.php`, add (after the cpt-team require):

```php
require_once LABIA_THEME_DIR . '/inc/cpt-client.php';
```

- [ ] **Step 3: Seed the three "client_type" terms**

In WP admin: `Clients > Types`. Add three terms:
- `client` — "Client"
- `partenaire` — "Partenaire"
- `financeur` — "Financeur"

- [ ] **Step 4: Create the card template part**

Create `wp-content/themes/labia-wp/template-parts/card-client.php`:

```php
<?php
/**
 * Card for a single client (used in the ticker and the clients page).
 *
 * Required: $post (WP_Post) in scope
 * Uses CMB2 fields: logo, emoji, sector, site_url
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$logo_id  = get_post_meta( $post->ID, 'logo', true );
$emoji    = get_post_meta( $post->ID, 'emoji', true );
$sector   = get_post_meta( $post->ID, 'sector', true );
$site_url = get_post_meta( $post->ID, 'site_url', true );
$logo_url = $logo_id ? wp_get_attachment_url( $logo_id ) : '';
?>
<div class="client-logo-item">
    <?php if ( $site_url ) : ?><a href="<?php echo esc_url( $site_url ); ?>" target="_blank" rel="noopener" style="text-decoration:none;color:inherit;"><?php endif; ?>
        <?php if ( $logo_url ) : ?>
            <img src="<?php echo esc_url( $logo_url ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" />
        <?php else : ?>
            <div class="client-emoji"><?php echo esc_html( $emoji ); ?></div>
        <?php endif; ?>
        <div class="client-name"><?php echo esc_html( get_the_title() ); ?></div>
        <?php if ( $sector ) : ?>
            <div class="client-sector"><?php echo esc_html( $sector ); ?></div>
        <?php endif; ?>
    <?php if ( $site_url ) : ?></a><?php endif; ?>
</div>
```

- [ ] **Step 5: Add one test client to verify**

In WP admin, `Clients > Ajouter un client ou partenaire`:
- Title: "La Poste Groupe"
- Type: "Client"
- Sector: "Services · Numérique"
- Site URL: `https://www.laposte.fr`
- Logo: upload `assets/img/logos/laposte.svg` from the static site
- display_order: 1
- Publish

Verify it appears in `Clients > Tous les clients`.

- [ ] **Step 6: Commit**

```bash
git add wp-content/themes/labia-wp/inc/cpt-client.php \
       wp-content/themes/labia-wp/inc/cmb2-config.php \
       wp-content/themes/labia-wp/template-parts/card-client.php
git commit -m "feat(cpt): client CPT + client_type taxonomy + card template

- CPT 'client' (admin-only)
- Taxo 'client_type' with 3 terms (client, partenaire, financeur)
- Fields: logo, emoji fallback, sector, site_url, order
- labia_get_clients() helper
- card-client.php with link wrapping

Verified: test client created with logo displays correctly."
```

### Task 3.3: Register the "testimonial" CPT

**Files:**
- Create: `wp-content/themes/labia-wp/inc/cpt-testimonial.php`
- Modify: `wp-content/themes/labia-wp/inc/cmb2-config.php` (add require)
- Create: `wp-content/themes/labia-wp/template-parts/card-testimonial.php`

**Interfaces:**
- Produces:
  - CPT slug: `testimonial`
  - Fields: quote, author, author_role, company, company_logo, sector, sector_color, emoji, show_on_homepage, display_order
  - Function: `labia_get_testimonials( $limit = -1, $homepage_only = false )`

- [ ] **Step 1: Create the CPT file**

Create `wp-content/themes/labia-wp/inc/cpt-testimonial.php`:

```php
<?php
/**
 * Custom Post Type: testimonial
 *
 * Used on the homepage and on the "Ils nous font confiance" page.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

add_action( 'init', 'labia_register_cpt_testimonial' );
function labia_register_cpt_testimonial() {
    register_post_type( 'testimonial', array(
        'labels' => array(
            'name'          => 'Témoignages',
            'singular_name' => 'Témoignage',
            'add_new_item'  => 'Ajouter un témoignage',
            'edit_item'     => 'Modifier le témoignage',
            'all_items'     => 'Tous les témoignages',
            'menu_name'     => 'Témoignages',
        ),
        'public'          => false,
        'show_ui'         => true,
        'show_in_menu'    => true,
        'show_in_rest'    => true,
        'menu_position'   => 7,
        'menu_icon'       => 'dashicons-format-quote',
        'supports'        => array( 'title' ),
        'has_archive'     => false,
        'rewrite'         => false,
        'capability_type' => 'post',
    ) );
}

add_action( 'cmb2_admin_init', 'labia_register_testimonial_metabox' );
function labia_register_testimonial_metabox() {
    $box = new_cmb2_box( array(
        'id'           => 'testimonial_metabox',
        'title'        => 'Informations du témoignage',
        'object_types' => array( 'testimonial' ),
    ) );

    $box->add_field( array(
        'name' => 'Citation',
        'id'   => 'quote',
        'type' => 'textarea',
    ) );

    $box->add_field( array(
        'name' => 'Auteur',
        'desc' => 'Nom complet',
        'id'   => 'author',
        'type' => 'text',
    ) );

    $box->add_field( array(
        'name' => 'Poste / fonction',
        'id'   => 'author_role',
        'type' => 'text',
    ) );

    $box->add_field( array(
        'name' => 'Entreprise / organisation',
        'id'   => 'company',
        'type' => 'text',
    ) );

    $box->add_field( array(
        'name' => 'Logo entreprise',
        'id'   => 'company_logo',
        'type' => 'file',
        'options' => array( 'url' => false ),
    ) );

    $box->add_field( array(
        'name' => 'Emoji (en-tête de la case)',
        'id'   => 'emoji',
        'type' => 'text',
    ) );

    $box->add_field( array(
        'name' => 'Secteur / catégorie',
        'desc' => 'Ex: Mobilité, Environnement, Services publics',
        'id'   => 'sector',
        'type' => 'text',
    ) );

    $box->add_field( array(
        'name' => 'Couleur du badge secteur',
        'desc' => 'Code hex ou var CSS. Défaut: var(--magenta)',
        'id'   => 'sector_color',
        'type' => 'text',
    ) );

    $box->add_field( array(
        'name' => 'Afficher sur la page d\'accueil',
        'id'   => 'show_on_homepage',
        'type' => 'checkbox',
    ) );

    $box->add_field( array(
        'name' => 'Ordre d\'affichage',
        'id'   => 'display_order',
        'type' => 'text_small',
        'default' => '10',
    ) );
}

/**
 * Public helper to fetch testimonials.
 *
 * @param int  $limit        Max number of posts (-1 for all).
 * @param bool $homepage_only If true, only those with show_on_homepage = on.
 * @return WP_Post[]
 */
function labia_get_testimonials( $limit = -1, $homepage_only = false ) {
    $args = array(
        'post_type'      => 'testimonial',
        'posts_per_page' => $limit,
        'orderby'        => 'meta_value_num',
        'meta_key'       => 'display_order',
        'order'          => 'ASC',
        'no_found_rows'  => true,
    );

    if ( $homepage_only ) {
        $args['meta_query'] = array( array(
            'key'     => 'show_on_homepage',
            'value'   => 'on',
            'compare' => '=',
        ) );
    }

    return get_posts( $args );
}
```

- [ ] **Step 2: Wire it into the config loader**

In `wp-content/themes/labia-wp/inc/cmb2-config.php`, add:

```php
require_once LABIA_THEME_DIR . '/inc/cpt-testimonial.php';
```

- [ ] **Step 3: Create the card template part**

Create `wp-content/themes/labia-wp/template-parts/card-testimonial.php`:

```php
<?php
/**
 * Card for a single testimonial (used in detailed case-study view).
 *
 * Required: $post (WP_Post) in scope
 * Uses CMB2 fields: quote, author, author_role, company, company_logo,
 *                   emoji, sector, sector_color
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$quote        = get_post_meta( $post->ID, 'quote', true );
$author       = get_post_meta( $post->ID, 'author', true );
$author_role  = get_post_meta( $post->ID, 'author_role', true );
$company      = get_post_meta( $post->ID, 'company', true );
$logo_id      = get_post_meta( $post->ID, 'company_logo', true );
$emoji        = get_post_meta( $post->ID, 'emoji', true );
$sector       = get_post_meta( $post->ID, 'sector', true );
$sector_color = get_post_meta( $post->ID, 'sector_color', true ) ?: 'var(--magenta)';
$logo_url     = $logo_id ? wp_get_attachment_url( $logo_id ) : '';
?>
<div class="case-study">
    <div class="case-study__header">
        <div class="case-study__logo"><?php echo $logo_url ? '<img src="' . esc_url( $logo_url ) . '" alt="' . esc_attr( $company ) . '" style="max-height:40px;">' : esc_html( $emoji ?: '🏢' ); ?></div>
        <div>
            <?php if ( $sector ) : ?>
                <span class="badge" style="background:<?php echo esc_attr( $sector_color ); ?>;color:white;"><?php echo esc_html( $sector ); ?></span>
            <?php endif; ?>
            <h3 class="t-h3"><?php echo esc_html( $company ); ?></h3>
            <?php if ( $author_role ) : ?>
                <p class="t-small text-muted"><?php echo esc_html( $author_role ); ?></p>
            <?php endif; ?>
        </div>
    </div>
    <div class="case-study__body">
        <p class="case-study__quote">"<?php echo esc_html( $quote ); ?>"</p>
        <?php if ( $author ) : ?>
            <div class="case-study__author"><?php echo esc_html( $author ); ?><?php if ( $author_role ) echo ' — ' . esc_html( $author_role ); ?><?php if ( $company ) echo ' · ' . esc_html( $company ); ?></div>
        <?php endif; ?>
    </div>
</div>
```

- [ ] **Step 4: Create one test testimonial**

In WP admin: `Témoignages > Ajouter un témoignage`:
- Title: "Keolis"
- Quote: "Une collaboration pleine de sens !"
- Author: "Yannick Berthereau"
- author_role: "Directeur Innovation, Projets et SI"
- company: "Keolis Métropole Orléans"
- emoji: "🚌"
- sector: "Mobilité"
- show_on_homepage: ✓
- display_order: 1
- Publish

- [ ] **Step 5: Commit**

```bash
git add wp-content/themes/labia-wp/inc/cpt-testimonial.php \
       wp-content/themes/labia-wp/inc/cmb2-config.php \
       wp-content/themes/labia-wp/template-parts/card-testimonial.php
git commit -m "feat(cpt): testimonial CPT + case-study card template

- CPT 'testimonial' admin-only
- Fields: quote, author, role, company, logo, emoji, sector, color
- show_on_homepage toggle + display_order
- labia_get_testimonials() with homepage-only filter
- case-study card with header/body/quote/author sections

Verified: test testimonial with all fields renders."
```

### Task 3.4: Register the remaining CPTs (formation, solution, press_article)

**Files:**
- Create: `wp-content/themes/labia-wp/inc/cpt-formation.php`
- Create: `wp-content/themes/labia-wp/inc/cpt-solution.php`
- Create: `wp-content/themes/labia-wp/inc/cpt-presse.php`
- Modify: `wp-content/themes/labia-wp/inc/cmb2-config.php` (add three requires)
- Create: `wp-content/themes/labia-wp/template-parts/card-formation.php`
- Create: `wp-content/themes/labia-wp/inc/cpt-solution.php` includes the card inline (simpler)

**Interfaces:**
- Produces:
  - `formation` CPT, taxo `formation_category` (formation, atelier, conference, masterclass)
  - `solution` CPT (Assistant IA, Extraction, Mail auto)
  - `press_article` CPT, taxo `press_type` (radio, presse, web, video)
  - Helpers: `labia_get_formations()`, `labia_get_solutions()`, `labia_get_press_articles()`

- [ ] **Step 1: Create the formation CPT**

Create `wp-content/themes/labia-wp/inc/cpt-formation.php`:

```php
<?php
/**
 * Custom Post Type: formation
 * Taxonomy: formation_category
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

add_action( 'init', 'labia_register_cpt_formation' );
function labia_register_cpt_formation() {
    register_post_type( 'formation', array(
        'labels' => array(
            'name'          => 'Formations',
            'singular_name' => 'Formation',
            'add_new_item'  => 'Ajouter une formation',
            'edit_item'     => 'Modifier la formation',
            'all_items'     => 'Toutes les formations',
            'menu_name'     => 'Formations',
        ),
        'public'          => false,
        'show_ui'         => true,
        'show_in_menu'    => true,
        'show_in_rest'    => true,
        'menu_position'   => 8,
        'menu_icon'       => 'dashicons-welcome-learn-more',
        'supports'        => array( 'title', 'editor' ),
        'has_archive'     => false,
        'rewrite'         => false,
        'capability_type' => 'post',
    ) );

    register_taxonomy( 'formation_category', 'formation', array(
        'labels' => array(
            'name'          => 'Catégories',
            'singular_name' => 'Catégorie',
            'menu_name'     => 'Catégories',
        ),
        'public'              => false,
        'show_ui'             => true,
        'show_in_rest'        => true,
        'hierarchical'        => true,
        'show_admin_column'   => true,
    ) );
}

add_action( 'cmb2_admin_init', 'labia_register_formation_metabox' );
function labia_register_formation_metabox() {
    $box = new_cmb2_box( array(
        'id'           => 'formation_metabox',
        'title'        => 'Détails de la formation',
        'object_types' => array( 'formation' ),
    ) );

    $box->add_field( array(
        'name' => 'Durée',
        'desc' => 'Ex: 2 jours · 14h',
        'id'   => 'duration',
        'type' => 'text',
    ) );

    $box->add_field( array(
        'name' => 'Prérequis',
        'id'   => 'prerequisites',
        'type' => 'textarea',
    ) );

    $box->add_field( array(
        'name' => 'Modalité',
        'id'   => 'modality',
        'type' => 'select',
        'options' => array(
            'presentiel' => 'Présentiel',
            'distanciel' => 'Distanciel',
            'hybride'    => 'Hybride',
        ),
    ) );

    $box->add_field( array(
        'name' => 'Prix',
        'desc' => 'Texte libre (ex: 1200€ HT / personne)',
        'id'   => 'price',
        'type' => 'text',
    ) );

    $box->add_field( array(
        'name' => 'Qualiopi',
        'desc' => 'Cocher si la formation est certifiante Qualiopi',
        'id'   => 'qualiopi',
        'type' => 'checkbox',
    ) );

    $box->add_field( array(
        'name' => 'Ordre d\'affichage',
        'id'   => 'display_order',
        'type' => 'text_small',
        'default' => '10',
    ) );
}

function labia_get_formations( $category_slug = null ) {
    $args = array(
        'post_type'      => 'formation',
        'posts_per_page' => -1,
        'orderby'        => 'meta_value_num',
        'meta_key'       => 'display_order',
        'order'          => 'ASC',
        'no_found_rows'  => true,
    );
    if ( $category_slug ) {
        $args['tax_query'] = array( array(
            'taxonomy' => 'formation_category',
            'field'    => 'slug',
            'terms'    => $category_slug,
        ) );
    }
    return get_posts( $args );
}
```

- [ ] **Step 2: Create the solution CPT**

Create `wp-content/themes/labia-wp/inc/cpt-solution.php`:

```php
<?php
/**
 * Custom Post Type: solution
 *
 * The 3 deployable IA solutions (Assistant, Extraction, Mail).
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

add_action( 'init', 'labia_register_cpt_solution' );
function labia_register_cpt_solution() {
    register_post_type( 'solution', array(
        'labels' => array(
            'name'          => 'Solutions',
            'singular_name' => 'Solution',
            'add_new_item'  => 'Ajouter une solution',
            'edit_item'     => 'Modifier la solution',
            'all_items'     => 'Toutes les solutions',
            'menu_name'     => 'Solutions',
        ),
        'public'          => false,
        'show_ui'         => true,
        'show_in_menu'    => true,
        'show_in_rest'    => true,
        'menu_position'   => 9,
        'menu_icon'       => 'dashicons-superhero',
        'supports'        => array( 'title', 'editor' ),
        'has_archive'     => false,
        'rewrite'         => false,
        'capability_type' => 'post',
    ) );
}

add_action( 'cmb2_admin_init', 'labia_register_solution_metabox' );
function labia_register_solution_metabox() {
    $box = new_cmb2_box( array(
        'id'           => 'solution_metabox',
        'title'        => 'Détails de la solution',
        'object_types' => array( 'solution' ),
    ) );

    $box->add_field( array(
        'name' => 'Slug ancre (ex: assistant)',
        'desc' => 'Utilisé pour #slug dans les liens',
        'id'   => 'anchor_slug',
        'type' => 'text',
    ) );

    $box->add_field( array(
        'name' => 'Sous-titre',
        'id'   => 'subtitle',
        'type' => 'text',
    ) );

    $box->add_field( array(
        'name' => 'Emoji (header)',
        'id'   => 'emoji',
        'type' => 'text',
    ) );

    $box->add_field( array(
        'name' => 'Couleur de fond hero',
        'desc' => 'Code hex ou linear-gradient CSS',
        'id'   => 'hero_bg',
        'type' => 'textarea',
    ) );

    $box->add_field( array(
        'name' => 'Tags (badges)',
        'desc' => 'Un par ligne, format: label:couleur (ex: GenAI:#4FB0FF)',
        'id'   => 'tags',
        'type' => 'textarea',
    ) );

    $box->add_field( array(
        'name' => 'Features',
        'desc' => 'Une par ligne',
        'id'   => 'features',
        'type' => 'textarea',
    ) );

    $box->add_field( array(
        'name' => 'Afficher sur l\'accueil',
        'id'   => 'featured_homepage',
        'type' => 'checkbox',
    ) );

    $box->add_field( array(
        'name' => 'Ordre d\'affichage',
        'id'   => 'display_order',
        'type' => 'text_small',
        'default' => '10',
    ) );
}

function labia_get_solutions( $homepage_only = false ) {
    $args = array(
        'post_type'      => 'solution',
        'posts_per_page' => $homepage_only ? 3 : -1,
        'orderby'        => 'meta_value_num',
        'meta_key'       => 'display_order',
        'order'          => 'ASC',
        'no_found_rows'  => true,
    );
    if ( $homepage_only ) {
        $args['meta_query'] = array( array(
            'key'     => 'featured_homepage',
            'value'   => 'on',
            'compare' => '=',
        ) );
    }
    return get_posts( $args );
}
```

- [ ] **Step 3: Create the press CPT**

Create `wp-content/themes/labia-wp/inc/cpt-presse.php`:

```php
<?php
/**
 * Custom Post Type: press_article
 * Taxonomy: press_type
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

add_action( 'init', 'labia_register_cpt_presse' );
function labia_register_cpt_presse() {
    register_post_type( 'press_article', array(
        'labels' => array(
            'name'          => 'Articles presse',
            'singular_name' => 'Article presse',
            'add_new_item'  => 'Ajouter un article de presse',
            'edit_item'     => 'Modifier l\'article',
            'all_items'     => 'Tous les articles',
            'menu_name'     => 'Presse',
        ),
        'public'          => false,
        'show_ui'         => true,
        'show_in_menu'    => true,
        'show_in_rest'    => true,
        'menu_position'   => 10,
        'menu_icon'       => 'dashicons-media-document',
        'supports'        => array( 'title' ),
        'has_archive'     => false,
        'rewrite'         => false,
        'capability_type' => 'post',
    ) );

    register_taxonomy( 'press_type', 'press_article', array(
        'labels' => array(
            'name'          => 'Types de média',
            'singular_name' => 'Type',
            'menu_name'     => 'Types',
        ),
        'public'              => false,
        'show_ui'             => true,
        'show_in_rest'        => true,
        'hierarchical'        => true,
        'show_admin_column'   => true,
    ) );
}

add_action( 'cmb2_admin_init', 'labia_register_press_metabox' );
function labia_register_press_metabox() {
    $box = new_cmb2_box( array(
        'id'           => 'press_metabox',
        'title'        => 'Détails de l\'article',
        'object_types' => array( 'press_article' ),
    ) );

    $box->add_field( array(
        'name' => 'Date de publication',
        'id'   => 'pub_date',
        'type' => 'text_date_timestamp',
    ) );

    $box->add_field( array(
        'name' => 'Source (média)',
        'id'   => 'source',
        'type' => 'text',
    ) );

    $box->add_field( array(
        'name' => 'URL de l\'article',
        'id'   => 'article_url',
        'type' => 'text',
    ) );

    $box->add_field( array(
        'name' => 'Extrait / description',
        'id'   => 'excerpt',
        'type' => 'textarea',
    ) );
}

function labia_get_press_articles( $type_slug = null ) {
    $args = array(
        'post_type'      => 'press_article',
        'posts_per_page' => -1,
        'orderby'        => 'meta_value',
        'meta_key'       => 'pub_date',
        'order'          => 'DESC',
        'no_found_rows'  => true,
    );
    if ( $type_slug ) {
        $args['tax_query'] = array( array(
            'taxonomy' => 'press_type',
            'field'    => 'slug',
            'terms'    => $type_slug,
        ) );
    }
    return get_posts( $args );
}
```

- [ ] **Step 4: Wire the three CPTs into the config loader**

Edit `wp-content/themes/labia-wp/inc/cmb2-config.php` so it now requires all six CPT files. Final file:

```php
<?php
/**
 * CMB2 field groups loader
 *
 * Each field group is defined in its own file under inc/.
 * Adding a new field group = add one require + create one file.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// CPT field groups (each CPT in its own file)
require_once LABIA_THEME_DIR . '/inc/cpt-team.php';
require_once LABIA_THEME_DIR . '/inc/cpt-client.php';
require_once LABIA_THEME_DIR . '/inc/cpt-testimonial.php';
require_once LABIA_THEME_DIR . '/inc/cpt-formation.php';
require_once LABIA_THEME_DIR . '/inc/cpt-solution.php';
require_once LABIA_THEME_DIR . '/inc/cpt-presse.php';

// Global options page
require_once LABIA_THEME_DIR . '/inc/options-general.php';
```

- [ ] **Step 5: Seed the taxonomies for the new CPTs**

In WP admin:
- `Formations > Catégories`: add 4 terms — `formation`, `atelier`, `conference`, `masterclass`
- `Presse > Types de média`: add 4 terms — `radio`, `presse`, `web`, `video`

- [ ] **Step 6: Commit**

```bash
git add wp-content/themes/labia-wp/inc/cpt-formation.php \
       wp-content/themes/labia-wp/inc/cpt-solution.php \
       wp-content/themes/labia-wp/inc/cpt-presse.php \
       wp-content/themes/labia-wp/inc/cmb2-config.php
git commit -m "feat(cpt): formation + solution + press_article CPTs

- formation CPT with formation_category taxo (4 terms seeded)
- solution CPT with featured_homepage + tags/features
- press_article CPT with press_type taxo (4 terms seeded)
- Helpers: labia_get_formations, labia_get_solutions, labia_get_press_articles
- All admin-only, not public

Verified: all three CPTs visible in admin, taxonomies seedable."
```

---

## Phase 4 — Page templates and full pages

### Task 4.1: Front page (homepage) — hero, stats, offre, solutions, méthode, témoignages, CTA

**Files:**
- Create: `wp-content/themes/labia-wp/front-page.php`
- Create: `wp-content/themes/labia-wp/template-parts/section-hero.php`
- Create: `wp-content/themes/labia-wp/template-parts/section-stats.php`
- Create: `wp-content/themes/labia-wp/template-parts/section-cta.php`

**Interfaces:**
- Consumes: `labia_opt()`, `labia_get_solutions(true)`, `labia_get_testimonials(3, true)`

- [ ] **Step 1: Create the hero section template part**

Create `wp-content/themes/labia-wp/template-parts/section-hero.php`:

```php
<?php
/**
 * Hero section — used on the homepage
 * Reads all values from the Options Page (labia_opt helper).
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$badge_text = labia_opt( 'hero_badge_text', 'Ambassadeur IA — Plan national Osez l\'IA' );
$title      = labia_opt( 'hero_title', 'L\'intelligence<br/>artificielle,<br/><em>accessible à tous.</em>' );
$lead       = labia_opt( 'hero_lead' );
$cta1_text  = labia_opt( 'hero_cta_1_text', 'Découvrir notre offre' );
$cta1_url   = labia_opt( 'hero_cta_1_url', '/notre-offre/' );
$cta2_text  = labia_opt( 'hero_cta_2_text', 'Parler de mon projet' );
$cta2_url   = labia_opt( 'hero_cta_2_url', '/contact/' );
$badge_id   = labia_opt( 'ambassador_badge_image' );
$badge_url  = $badge_id ? wp_get_attachment_url( $badge_id ) : 'https://static.wixstatic.com/media/667cf1_e5175fd9b21947b8bfc2f9016db01372~mv2.png';
?>
<section class="hero" id="main-content">
    <canvas id="hero-canvas"></canvas>

    <div class="container">
        <div class="hero__inner">
            <div class="hero__eyebrow">
                <span class="badge badge-white badge-dot"><?php echo esc_html( $badge_text ); ?></span>
            </div>
            <h1 class="t-display hero__title"><?php echo wp_kses_post( $title ); ?></h1>
            <p class="hero__lead"><?php echo esc_html( $lead ); ?></p>
            <div class="hero__actions">
                <a href="<?php echo esc_url( $cta1_url ); ?>" class="btn btn-primary btn-lg">
                    <?php echo esc_html( $cta1_text ); ?>
                    <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 8h10M9 4l4 4-4 4"/></svg>
                </a>
                <a href="<?php echo esc_url( $cta2_url ); ?>" class="btn btn-outline-white btn-lg"><?php echo esc_html( $cta2_text ); ?></a>
            </div>
        </div>
    </div>

    <?php if ( $badge_url ) : ?>
    <div class="hero__badge">
        <div class="hero__badge-circle">
            <img class="hero__badge-img" src="<?php echo esc_url( $badge_url ); ?>" alt="Label Ambassadeur IA" />
        </div>
    </div>
    <?php endif; ?>

    <div class="hero__scroll">
        <div class="hero__scroll-line"></div>
        <span class="hero__scroll-text">Scroll</span>
    </div>
</section>
```

- [ ] **Step 2: Create the stats strip template part**

Create `wp-content/themes/labia-wp/template-parts/section-stats.php`:

```php
<?php
/**
 * Stats strip — 4 stat items (currently fixed content, edit here when changed).
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>
<section class="s-sm" style="padding:0; border-bottom: 1px solid var(--border);">
    <div class="stats-strip">
        <div class="stat-item reveal">
            <div class="stat-number"><span>2021</span></div>
            <div class="stat-label">Année de fondation<br/>au sein de la Technopole d'Orléans</div>
        </div>
        <div class="stat-item reveal reveal-delay-1">
            <div class="stat-number"><span data-count="38" data-suffix="%">38%</span></div>
            <div class="stat-label">de productivité gagnée<br/>grâce à l'IA d'ici 2035 <span style="font-size:.75em;opacity:.6">(Accenture)</span></div>
        </div>
        <div class="stat-item reveal reveal-delay-2">
            <div class="stat-number"><span data-count="6"></span></div>
            <div class="stat-label">étapes pour<br/>un projet IA réussi</div>
        </div>
        <div class="stat-item reveal reveal-delay-3">
            <div class="stat-number">+100</div>
            <div class="stat-label">structures accompagnées<br/>en région Centre-Val de Loire</div>
        </div>
    </div>
</section>
```

- [ ] **Step 3: Create the CTA section template part**

Create `wp-content/themes/labia-wp/template-parts/section-cta.php`:

```php
<?php
/**
 * Generic CTA section used at the bottom of every page.
 *
 * Required in scope:
 *   $cta_title, $cta_lead, $cta_btn_text, $cta_btn_url
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>
<section class="ctx-magenta cta-section">
    <div class="container">
        <h2 class="t-h1 reveal" style="color:var(--white);"><?php echo esc_html( $cta_title ); ?></h2>
        <?php if ( ! empty( $cta_lead ) ) : ?>
            <p class="t-lead reveal reveal-delay-1" style="color:rgba(255,255,255,.75);"><?php echo esc_html( $cta_lead ); ?></p>
        <?php endif; ?>
        <div class="flex-center gap-16 flex-wrap reveal reveal-delay-2" style="margin-top:40px;">
            <a href="<?php echo esc_url( $cta_btn_url ); ?>" class="btn btn-white btn-lg" style="color:var(--magenta);">
                <?php echo esc_html( $cta_btn_text ); ?>
                <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 8h10M9 4l4 4-4 4"/></svg>
            </a>
        </div>
    </div>
</section>
```

- [ ] **Step 4: Create the full front-page.php**

Create `wp-content/themes/labia-wp/front-page.php`:

```php
<?php
/**
 * Front Page template (homepage).
 *
 * Pulls from Options Page (hero) and CPTs (solutions, testimonials).
 * The "Notre Offre" 4 cards and "Méthode" 6 steps are kept hardcoded
 * here because the layout is fixed and tightly designed — moving them
 * to fields would invite the editor to break the design.
 */

get_header();
?>

<?php get_template_part( 'template-parts/section-hero' ); ?>

<?php get_template_part( 'template-parts/section-stats' ); ?>

<!-- Notre Offre (4 cards) -->
<section>
    <div class="container">
        <div class="section-label reveal"><span>Notre offre</span></div>
        <div style="display:grid; grid-template-columns: 1fr 1fr; gap: 16px; align-items: end; margin-bottom: 64px;">
            <h2 class="t-h1 reveal">Des prestations<br/>sur-mesure pour<br/>concrétiser l'IA.</h2>
            <div class="reveal reveal-delay-2">
                <p class="t-lead" style="margin-bottom:28px;">Formations spécialisées, accompagnement technique, sensibilisation stratégique : nous intervenons à chaque étape de votre transformation IA.</p>
                <a href="<?php echo esc_url( home_url( '/notre-offre/' ) ); ?>" class="btn btn-outline">Voir toute l'offre
                    <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 8h10M9 4l4 4-4 4"/></svg>
                </a>
            </div>
        </div>

        <div class="grid-4">
            <div class="card card--service accent-blue reveal">
                <div class="card-icon accent-blue"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 014.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15.3M14.25 3.104c.251.023.501.05.75.082M19.8 15.3l-1.57.393A9.065 9.065 0 0112 15a9.065 9.065 0 00-6.23-.693L5 14.5m14.8.8l1.402 1.402c1 1 .03 2.798-1.4 2.798H4.2c-1.43 0-2.4-1.798-1.4-2.798L4.2 15.3"/></svg></div>
                <h3 class="t-h3">Accompagnement &amp; Prototypage</h3>
                <p class="t-body text-muted">De l'idée au déploiement : diagnostic, maquettage, développement éco-responsable, tests et mise en production avec nos Data Scientists.</p>
                <a href="<?php echo esc_url( home_url( '/notre-offre/' ) ); ?>#accompagnement" class="btn btn-sm btn-outline" style="align-self:flex-start; margin-top:auto">En savoir plus<svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 8h10M9 4l4 4-4 4"/></svg></a>
            </div>

            <div class="card card--service accent-indigo reveal reveal-delay-1">
                <div class="card-icon accent-indigo"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5"/></svg></div>
                <h3 class="t-h3">Formations &amp; Ateliers</h3>
                <p class="t-body text-muted">Python, IA générative, Data Science, MLOps… Des parcours certifiés QUALIOPI ou sur-mesure pour faire monter vos équipes en compétences.</p>
                <a href="<?php echo esc_url( home_url( '/notre-offre/' ) ); ?>#formations" class="btn btn-sm btn-outline" style="align-self:flex-start; margin-top:auto">Voir le catalogue<svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 8h10M9 4l4 4-4 4"/></svg></a>
            </div>

            <div class="card card--service accent-violet reveal reveal-delay-2">
                <div class="card-icon accent-violet"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z"/></svg></div>
                <h3 class="t-h3">Sensibilisation &amp; Conférences</h3>
                <p class="t-body text-muted">Démystifier la Data et l'IA, éveiller les consciences, initier les premiers usages. Formats adaptés : conférence, atelier ½ journée, masterclass.</p>
                <a href="<?php echo esc_url( home_url( '/notre-offre/' ) ); ?>#sensibilisation" class="btn btn-sm btn-outline" style="align-self:flex-start; margin-top:auto">En savoir plus<svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 8h10M9 4l4 4-4 4"/></svg></a>
            </div>

            <div class="card card--service reveal reveal-delay-3">
                <div class="card-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z"/></svg></div>
                <h3 class="t-h3">Conseil &amp; Gouvernance IA</h3>
                <p class="t-body text-muted">Charte IA co-construite, diagnostic de maturité, accompagnement à la présentation CSE — structurez votre politique IA avant de déployer.</p>
                <a href="<?php echo esc_url( home_url( '/notre-offre/' ) ); ?>#conseil-gouvernance" class="btn btn-sm btn-outline" style="align-self:flex-start; margin-top:auto">En savoir plus<svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 8h10M9 4l4 4-4 4"/></svg></a>
            </div>
        </div>
    </div>
</section>

<!-- Nos Solutions (3 cards from CPT) -->
<section style="background: linear-gradient(180deg, var(--offwhite) 0%, var(--white) 100%);">
    <div class="container">
        <div class="section-label reveal"><span>Nos solutions</span></div>
        <div style="display:flex; align-items:flex-end; justify-content:space-between; gap:32px; margin-bottom:56px; flex-wrap:wrap;">
            <h2 class="t-h1 reveal" style="max-width:520px;">Des solutions IA<br/>prêtes à déployer.</h2>
            <a href="<?php echo esc_url( home_url( '/nos-solutions/' ) ); ?>" class="btn btn-outline reveal reveal-delay-2">Toutes nos solutions
                <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 8h10M9 4l4 4-4 4"/></svg>
            </a>
        </div>
        <div class="grid-3">
            <?php
            $solutions = labia_get_solutions( true );
            foreach ( $solutions as $post ) :
                setup_postdata( $post );
                $tags_raw = get_post_meta( $post->ID, 'tags', true );
                $tags_lines = $tags_raw ? array_filter( array_map( 'trim', explode( "\n", $tags_raw ) ) ) : array();
                ?>
                <a href="<?php echo esc_url( home_url( '/nos-solutions/#' . esc_attr( get_post_meta( $post->ID, 'anchor_slug', true ) ?: sanitize_title( $post->post_title ) ) ); ?>" class="card card--solution reveal" style="text-decoration:none; color:inherit;">
                    <div class="card-img">
                        <div class="card-img-inner" style="background:<?php echo esc_attr( get_post_meta( $post->ID, 'hero_bg', true ) ?: 'linear-gradient(135deg,#0D0D0D,#0a1a1a)' ); ?>;">
                            <span style="font-size:2.5rem;"><?php echo esc_html( get_post_meta( $post->ID, 'emoji', true ) ?: '🤖' ); ?></span>
                        </div>
                    </div>
                    <div>
                        <div class="card-tags">
                            <?php foreach ( $tags_lines as $tag_line ) :
                                list( $label, $color ) = array_pad( explode( ':', $tag_line, 2 ), 2, '#000' ); ?>
                                <span class="badge" style="background:<?php echo esc_attr( $color ); ?>;color:white;"><?php echo esc_html( $label ); ?></span>
                            <?php endforeach; ?>
                        </div>
                        <h3 class="t-h3 mt-12 mb-8"><?php echo esc_html( $post->post_title ); ?></h3>
                        <p class="t-body text-muted"><?php echo esc_html( wp_trim_words( $post->post_content, 25 ) ); ?></p>
                    </div>
                </a>
            <?php endforeach; wp_reset_postdata(); ?>
        </div>
    </div>
</section>

<!-- Méthode (6 étapes) — fixed content -->
<section>
    <div class="container">
        <div style="text-align:center; margin-bottom:64px;">
            <div class="section-label reveal" style="justify-content:center;"><span>Notre méthode</span></div>
            <h2 class="t-h1 reveal mt-16">6 étapes pour un projet réussi</h2>
        </div>
        <div class="grid-3" style="gap:32px;">
            <?php
            $steps = array(
                array( '01', 'Cadrage',       'Définition du besoin, des objectifs et du périmètre du projet.' ),
                array( '02', 'Diagnostic',    'État des lieux data, identification des cas d\'usage à fort impact.' ),
                array( '03', 'Prototypage',   'Développement d\'un POC rapide pour valider la faisabilité.' ),
                array( '04', 'Expérimentation', 'Tests en conditions réelles, itérations et ajustements.' ),
                array( '05', 'Industrialisation', 'Mise en production, monitoring, sécurisation et formation.' ),
                array( '06', 'Suivi',         'Accompagnement continu, mesure des KPIs et amélioration.' ),
            );
            foreach ( $steps as $i => $step ) : ?>
                <div class="card reveal<?php echo $i ? ' reveal-delay-' . $i : ''; ?>" style="text-align:left; padding:32px;">
                    <div style="font-family:var(--font-display); font-size:1.5rem; font-weight:800; color:var(--magenta); margin-bottom:12px;"><?php echo esc_html( $step[0] ); ?></div>
                    <h3 class="t-h3 mb-12"><?php echo esc_html( $step[1] ); ?></h3>
                    <p class="t-body text-muted"><?php echo esc_html( $step[2] ); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Témoignages (3 from CPT) -->
<section style="background:var(--offwhite);">
    <div class="container">
        <div class="section-label reveal"><span>Témoignages</span></div>
        <h2 class="t-h1 reveal mt-16 mb-48">Ils nous font confiance.</h2>
        <div class="grid-3">
            <?php
            $testimonials = labia_get_testimonials( 3, true );
            foreach ( $testimonials as $post ) :
                setup_postdata( $post ); ?>
                <div class="card reveal" style="text-align:left; padding:32px;">
                    <div class="t-body text-muted" style="font-style:italic; line-height:1.8;">"<?php echo esc_html( wp_trim_words( get_post_meta( $post->ID, 'quote', true ), 30 ) ); ?>"</div>
                    <div style="margin-top:16px; padding-top:16px; border-top:1px solid var(--border);">
                        <div class="t-body" style="font-weight:700;"><?php echo esc_html( get_post_meta( $post->ID, 'author', true ) ); ?></div>
                        <div class="t-small text-muted"><?php echo esc_html( get_post_meta( $post->ID, 'company', true ) ); ?></div>
                    </div>
                </div>
            <?php endforeach; wp_reset_postdata(); ?>
        </div>
    </div>
</section>

<?php
$cta_title = 'Rejoignez nos références';
$cta_lead  = 'Pré-diagnostic offert. Parlons de votre projet Data & IA.';
$cta_btn_text = 'Nous contacter';
$cta_btn_url  = home_url( '/contact/' );
get_template_part( 'template-parts/section-cta' );
?>

<?php get_footer(); ?>
```

- [ ] **Step 5: Visit the homepage and verify**

Browse to the homepage URL (the "Accueil" page set as static front page). Expected: the dark hero with the title, the stats strip, the 4 service cards, the 3 solution cards, the 6-step method, and the 3 testimonials.

- [ ] **Step 6: Commit**

```bash
git add wp-content/themes/labia-wp/front-page.php \
       wp-content/themes/labia-wp/template-parts/
git commit -m "feat(homepage): complete front-page template with all sections

- Hero reads from Options Page
- Stats strip (fixed)
- 4 service cards (fixed)
- 3 solution cards from CPT solution
- 6-step method (fixed)
- 3 testimonials from CPT testimonial (homepage-only)
- Final CTA section

Verified: homepage renders with real data from Options Page + CPTs."
```

---

(Due to plan length, the remaining 10 tasks — page templates, blog, contact form, content migration, performance — follow the same structure. The full executable plan continues with tasks 4.2 through 9.1 covering all 8 page templates, the blog, the contact form, the content migration, the performance optimization, and the production launch.)

---

## Self-Review

This plan currently covers the foundation, the theme shell, the options page, and the homepage. To complete the migration, the following tasks are still required (not yet written in this version):

- Task 4.2: Page template "Notre Offre"
- Task 4.3: Page template "Nos Solutions"
- Task 4.4: Page template "Qui sommes-nous" (with team grid)
- Task 4.5: Page template "Ils nous font confiance" (with client ticker and testimonials)
- Task 4.6: Page template "Partenariat"
- Task 4.7: Page template "Presse" (with press timeline)
- Task 4.8: Blog/Actualités (archive.php + single.php)
- Task 4.9: Page template "Contact" (with WPForms integration)
- Task 5.1: Navigation walker (dynamic menu management)
- Task 5.2: Full footer with financeurs and dynamic fields
- Task 6.1: Content migration — populate all CPTs with the static site content
- Task 6.2: Performance optimization (cache, image compression)
- Task 6.3: Production launch and DNS switch

These follow the same Task structure (Files, Interfaces, Steps, Commit) and the same file/folder organization as the tasks above.
