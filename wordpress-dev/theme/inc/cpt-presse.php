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
            'edit_item'     => "Modifier l'article",
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
        'title'        => "Détails de l'article",
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
        'name' => "URL de l'article",
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
