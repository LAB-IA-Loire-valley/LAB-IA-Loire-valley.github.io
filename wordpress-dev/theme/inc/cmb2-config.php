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
