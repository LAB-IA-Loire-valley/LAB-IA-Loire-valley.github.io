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
