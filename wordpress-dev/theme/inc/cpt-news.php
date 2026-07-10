<?php
/**
 * Custom Post Type: news_article
 * Taxonomy: none (category stored as meta for flexibility)
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

add_action( 'init', 'labia_register_cpt_news' );
function labia_register_cpt_news() {
    register_post_type( 'news_article', array(
        'labels' => array(
            'name'          => 'Actualités',
            'singular_name' => 'Actualité',
            'add_new_item'  => 'Ajouter une actualité',
            'edit_item'     => "Modifier l'actualité",
            'all_items'     => 'Toutes les actualités',
            'menu_name'     => 'Actualités',
        ),
        'public'          => false,
        'show_ui'         => true,
        'show_in_menu'    => true,
        'show_in_rest'    => true,
        'menu_position'   => 9,
        'menu_icon'       => 'dashicons-megaphone',
        'supports'        => array( 'title', 'editor' ),
        'has_archive'     => false,
        'rewrite'         => false,
        'capability_type' => 'post',
    ) );
}

add_action( 'cmb2_admin_init', 'labia_register_news_metabox' );
function labia_register_news_metabox() {
    $box = new_cmb2_box( array(
        'id'           => 'news_metabox',
        'title'        => "Détails de l'actualité",
        'object_types' => array( 'news_article' ),
    ) );

    $box->add_field( array(
        'name' => 'Date de publication',
        'id'   => 'pub_date',
        'type' => 'text_date_timestamp',
    ) );

    $box->add_field( array(
        'name' => 'Catégorie',
        'id'   => 'news_category',
        'type' => 'text',
        'desc' => 'Ex : Événement, Projet, Médias, Innovation, etc.',
    ) );

    $box->add_field( array(
        'name' => "URL source (lien externe)",
        'id'   => 'source_url',
        'type' => 'text_url',
        'desc' => 'Lien vers l\'article source (optionnel)',
    ) );

    $box->add_field( array(
        'name'    => 'Image à la une',
        'id'      => 'featured_image',
        'type'    => 'file',
        'options' => array( 'url' => false ),
    ) );
}

function labia_get_news_articles( $limit = -1 ) {
    $args = array(
        'post_type'      => 'news_article',
        'posts_per_page' => $limit,
        'orderby'        => 'meta_value',
        'meta_key'       => 'pub_date',
        'order'          => 'DESC',
        'no_found_rows'  => true,
    );
    return get_posts( $args );
}
