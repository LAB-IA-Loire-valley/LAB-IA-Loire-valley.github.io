<?php
/**
 * Custom Post Type: solution
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
        'id'   => 'features',
        'type' => 'textarea',
    ) );

    $box->add_field( array(
        'name' => "Afficher sur l'accueil",
        'id'   => 'featured_homepage',
        'type' => 'checkbox',
    ) );

    $box->add_field( array(
        'name'    => "Ordre d'affichage",
        'id'      => 'display_order',
        'type'    => 'text_small',
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
