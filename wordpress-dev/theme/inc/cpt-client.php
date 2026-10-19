<?php
/**
 * Custom Post Type: client
 * Taxonomy: client_type
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
        'name'    => 'Logo',
        'id'      => 'logo',
        'type'    => 'file',
        'options' => array( 'url' => false ),
    ) );

    $box->add_field( array(
        'name' => 'Logo fichier',
        'desc' => 'Nom du fichier dans assets/img/logos/ (ex: laposte.svg). Alternative si pas upload.',
        'id'   => 'logo_file',
        'type' => 'text',
    ) );

    $box->add_field( array(
        'name' => 'Emoji (fallback logo)',
        'id'   => 'emoji',
        'type' => 'text',
    ) );

    $box->add_field( array(
        'name' => 'Secteur',
        'id'   => 'sector',
        'type' => 'text',
    ) );

    $box->add_field( array(
        'name' => 'URL du site',
        'id'   => 'site_url',
        'type' => 'text',
    ) );

    $box->add_field( array(
        'name'    => "Ordre d'affichage",
        'id'      => 'display_order',
        'type'    => 'text_small',
        'default' => '10',
    ) );
}

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

/**
 * Résout le nom de fichier logo d'un client vers un fichier valide du thème.
 *
 * Corrige les références cassées : fichier absent, ou SVG entièrement blanc
 * (invisible sur fond clair). Essaie d'abord le nom fourni, puis le même
 * basename avec d'autres extensions.
 *
 * @param string $file Nom de fichier (ex: "afnor.svg").
 * @return string Nom du fichier valide, ou chaîne vide.
 */
function labia_resolve_client_logo_file( $file ) {
    $file = ltrim( (string) $file, '/' );
    if ( '' === $file || false !== strpos( $file, '/' ) ) {
        return '';
    }

    $dir = trailingslashit( get_template_directory() ) . 'assets/img/logos/';

    $candidates = array( $file );
    $ext        = strtolower( pathinfo( $file, PATHINFO_EXTENSION ) );
    if ( $ext ) {
        $base = substr( $file, 0, -( strlen( $ext ) + 1 ) );
        foreach ( array( 'png', 'svg', 'jpg', 'jpeg', 'webp' ) as $alt ) {
            if ( $alt !== $ext ) {
                $candidates[] = $base . '.' . $alt;
            }
        }
    }

    foreach ( $candidates as $candidate ) {
        $path = $dir . $candidate;
        if ( ! is_file( $path ) ) {
            continue;
        }
        if ( 'svg' === strtolower( pathinfo( $candidate, PATHINFO_EXTENSION ) )
            && ! labia_svg_is_visible( $path ) ) {
            continue; // fichier invalide (page 404 déguisée) ou logo blanc invisible
        }
        return $candidate;
    }

    return '';
}

/**
 * Vérifie qu'un fichier est un SVG valide et visible (au moins une couleur
 * autre que blanche). Rejette notamment les pages 404 déguisées en `.svg`.
 *
 * @param string $path Chemin du fichier SVG.
 * @return bool
 */
function labia_svg_is_visible( $path ) {
    $svg = @file_get_contents( $path );
    if ( false === $svg || false === stripos( $svg, '<svg' ) ) {
        return false; // pas un vrai SVG
    }
    if ( ! preg_match_all( '/(?:fill\s*:\s*|fill\s*=\s*["\'])\s*(#[0-9a-fA-F]{3,8})/', $svg, $m ) ) {
        return true; // pas de fill explicite → on suppose visible
    }

    foreach ( $m[1] as $hex ) {
        $hex = strtolower( ltrim( $hex, '#' ) );
        if ( 3 === strlen( $hex ) ) {
            $hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
        }
        if ( 'ffffff' !== substr( $hex, 0, 6 ) ) {
            return true; // au moins une couleur non blanche
        }
    }

    return false; // uniquement blanc → invisible
}

/**
 * Retourne le HTML du logo d'un client : média WordPress, sinon fichier du
 * thème, sinon emoji.
 *
 * @param int|WP_Post $client Client.
 * @param string      $size   Taille d'image WP pour le média.
 * @return string HTML.
 */
function labia_client_logo_html( $client, $size = 'medium' ) {
    $client = get_post( $client );
    if ( ! $client ) {
        return '';
    }

    $alt    = $client->post_title;
    $att_id = (int) get_post_meta( $client->ID, 'logo', true );
    if ( $att_id ) {
        $img = wp_get_attachment_image( $att_id, $size, false, array(
            'class'    => 'client-logo__img',
            'alt'      => $alt,
            'loading'  => 'lazy',
            'decoding' => 'async',
        ) );
        if ( $img ) {
            return $img;
        }
    }

    $file = labia_resolve_client_logo_file( get_post_meta( $client->ID, 'logo_file', true ) );
    if ( $file ) {
        return sprintf(
            '<img class="client-logo__img" src="%s" alt="%s" loading="lazy" decoding="async" />',
            esc_url( LABIA_THEME_URI . '/assets/img/logos/' . $file ),
            esc_attr( $alt )
        );
    }

    $emoji = get_post_meta( $client->ID, 'emoji', true );
    if ( $emoji ) {
        return '<div class="client-emoji">' . esc_html( $emoji ) . '</div>';
    }

    return '';
}
