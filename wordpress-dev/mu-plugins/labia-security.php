<?php
/**
 * Plugin Name: LAB'IA — Durcissement sécurité
 * Description: Bloque l'énumération d'utilisateurs, désactive XML-RPC/pingbacks et retire les auteurs du sitemap. Sans configuration.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Interdire l'édition de fichiers depuis l'administration.
if ( ! defined( 'DISALLOW_FILE_EDIT' ) ) {
    define( 'DISALLOW_FILE_EDIT', true );
}

// Ne pas exposer la liste des utilisateurs via l'API REST aux visiteurs non connectés.
add_filter( 'rest_endpoints', function ( $endpoints ) {
    if ( ! is_user_logged_in() ) {
        unset( $endpoints['/wp/v2/users'], $endpoints['/wp/v2/users/(?P<id>[\d]+)'] );
    }
    return $endpoints;
} );

// Bloquer la recherche d'articles par auteur (?author=N) sur l'API wp/v2 pour les visiteurs.
add_filter( 'rest_pre_dispatch', function ( $result, $server, $request ) {
    $author = $request->get_param( 'author' );
    if ( ! is_user_logged_in()
        && 0 === strpos( $request->get_route(), '/wp/v2/' )
        && null !== $author
        && '' !== $author
    ) {
        return new WP_Error( 'rest_forbidden', 'Accès refusé.', array( 'status' => 403 ) );
    }
    return $result;
}, 10, 3 );

// Rediriger les archives auteur (?author=N) — évite la divulgation des identifiants.
add_action( 'template_redirect', function () {
    if ( is_author() ) {
        wp_safe_redirect( home_url( '/' ), 301 );
        exit;
    }
}, 1 );

// Retirer les auteurs du sitemap WordPress.
add_filter( 'wp_sitemaps_add_provider', function ( $provider, $name ) {
    return 'users' === $name ? false : $provider;
}, 10, 2 );

// Désactiver XML-RPC et les pingbacks.
add_filter( 'xmlrpc_enabled', '__return_false' );
add_filter( 'xmlrpc_methods', function ( $methods ) {
    unset( $methods['pingback.ping'], $methods['pingback.extensions.getPingbacks'] );
    return $methods;
} );

// Retirer l'en-tête X-Pingback.
add_filter( 'wp_headers', function ( $headers ) {
    unset( $headers['X-Pingback'] );
    return $headers;
} );
