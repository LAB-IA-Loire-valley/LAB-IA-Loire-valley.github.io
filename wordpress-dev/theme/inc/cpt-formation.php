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
        'id'   => 'duration',
        'type' => 'text',
    ) );

    $box->add_field( array(
        'name' => 'Prérequis',
        'id'   => 'prerequisites',
        'type' => 'textarea',
    ) );

    $box->add_field( array(
        'name'    => 'Modalité',
        'id'      => 'modality',
        'type'    => 'select',
        'options' => array(
            'presentiel' => 'Présentiel',
            'distanciel' => 'Distanciel',
            'hybride'    => 'Hybride',
        ),
    ) );

    $box->add_field( array(
        'name' => 'Prix',
        'id'   => 'price',
        'type' => 'text',
    ) );

    $box->add_field( array(
        'name' => 'Qualiopi',
        'id'   => 'qualiopi',
        'type' => 'checkbox',
    ) );

    $box->add_field( array(
        'name'    => "Ordre d'affichage",
        'id'      => 'display_order',
        'type'    => 'text_small',
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
