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
define( 'LABIA_THEME_URI', get_template_directory_uri() );

// Site icon (favicon) : lien servi depuis le thème (média uploads 404, non migré)
add_filter( 'get_site_icon_url', '__return_false' );
add_action( 'wp_head', function() {
    $icon = LABIA_THEME_URI . '/assets/img/logos/favicon.png';
    echo '<link rel="icon" href="' . esc_url( $icon ) . '" type="image/png">' . "\n";
    echo '<link rel="apple-touch-icon" href="' . esc_url( $icon ) . '">' . "\n";
}, 5 );

// Document title tag
add_theme_support( 'title-tag' );

// Load in correct order (CPTs first, then CMB2 config, then enqueue).
require_once LABIA_THEME_DIR . '/inc/enqueue.php';
require_once LABIA_THEME_DIR . '/inc/cmb2-config.php';
