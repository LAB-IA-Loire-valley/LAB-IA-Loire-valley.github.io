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

// Load in correct order (CPTs first, then CMB2 config, then enqueue).
require_once LABIA_THEME_DIR . '/inc/enqueue.php';
require_once LABIA_THEME_DIR . '/inc/cmb2-config.php';
