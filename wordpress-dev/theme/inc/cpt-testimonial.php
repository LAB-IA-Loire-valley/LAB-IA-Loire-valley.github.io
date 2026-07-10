<?php
/**
 * Custom Post Type: testimonial
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
        'name'    => 'Logo entreprise',
        'id'      => 'company_logo',
        'type'    => 'file',
        'options' => array( 'url' => false ),
    ) );

    $box->add_field( array(
        'name'    => 'Photo de l\'auteur',
        'id'      => 'photo',
        'type'    => 'file',
        'options' => array( 'url' => false ),
    ) );

    $box->add_field( array(
        'name' => 'Emoji (en-tête de la case)',
        'id'   => 'emoji',
        'type' => 'text',
    ) );

    $box->add_field( array(
        'name' => 'Secteur / catégorie',
        'id'   => 'sector',
        'type' => 'text',
    ) );

    $box->add_field( array(
        'name' => 'Couleur du badge secteur',
        'id'   => 'sector_color',
        'type' => 'text',
    ) );

    $box->add_field( array(
        'name' => "Afficher sur la page d'accueil",
        'id'   => 'show_on_homepage',
        'type' => 'checkbox',
    ) );

    $box->add_field( array(
        'name'    => "Ordre d'affichage",
        'id'      => 'display_order',
        'type'    => 'text_small',
        'default' => '10',
    ) );
}

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

function labia_get_initials( $name ) {
    if ( empty( $name ) ) return '';
    $parts = explode( ' ', trim( $name ) );
    $initials = '';
    if ( ! empty( $parts[0] ) ) $initials .= mb_substr( $parts[0], 0, 1 );
    if ( count( $parts ) > 1 ) $initials .= mb_substr( end( $parts ), 0, 1 );
    return mb_strtoupper( $initials );
}

function labia_avatar_color( $index ) {
    $colors = array( '#4FB0FF', '#475297', '#852F85', '#E2007D' );
    return $colors[ $index % count( $colors ) ];
}
