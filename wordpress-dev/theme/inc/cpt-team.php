<?php
/**
 * Custom Post Type: team_member
 * Taxonomy: team_pole
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

add_action( 'init', 'labia_register_cpt_team' );
function labia_register_cpt_team() {
    register_post_type( 'team_member', array(
        'labels' => array(
            'name'          => "Membres équipe",
            'singular_name' => 'Membre équipe',
            'add_new_item'  => 'Ajouter un membre',
            'edit_item'     => 'Modifier le membre',
            'all_items'     => 'Tous les membres',
            'menu_name'     => 'Équipe',
        ),
        'public'          => false,
        'show_ui'         => true,
        'show_in_menu'    => true,
        'show_in_rest'    => true,
        'menu_position'   => 5,
        'menu_icon'       => 'dashicons-groups',
        'supports'        => array( 'title', 'editor' ),
        'has_archive'     => false,
        'rewrite'         => false,
        'capability_type' => 'post',
    ) );

    register_taxonomy( 'team_pole', 'team_member', array(
        'labels' => array(
            'name'          => 'Pôles',
            'singular_name' => 'Pôle',
            'add_new_item'  => 'Ajouter un pôle',
            'edit_item'     => 'Modifier le pôle',
            'all_items'     => 'Tous les pôles',
            'menu_name'     => 'Pôles',
        ),
        'public'              => false,
        'show_ui'             => true,
        'show_in_rest'        => true,
        'hierarchical'        => true,
        'show_admin_column'   => true,
    ) );
}

add_action( 'cmb2_admin_init', 'labia_register_team_metabox' );
function labia_register_team_metabox() {
    $box = new_cmb2_box( array(
        'id'           => 'team_member_metabox',
        'title'        => 'Informations du membre',
        'object_types' => array( 'team_member' ),
        'context'      => 'normal',
        'priority'     => 'high',
    ) );

    $box->add_field( array(
        'name'    => 'Photo',
        'id'      => 'photo',
        'type'    => 'file',
        'options' => array( 'url' => false ),
        'text'    => array( 'add_upload_file_text' => 'Choisir une photo' ),
    ) );

    $box->add_field( array(
        'name' => 'Rôle',
        'id'   => 'role',
        'type' => 'text',
    ) );

    $box->add_field( array(
        'name' => 'Biographie',
        'id'   => 'bio',
        'type' => 'textarea',
    ) );

    $box->add_field( array(
        'name' => 'URL LinkedIn',
        'id'   => 'linkedin_url',
        'type' => 'text',
    ) );

    $box->add_field( array(
        'name'    => "Ordre d'affichage",
        'id'      => 'display_order',
        'type'    => 'text_small',
        'default' => '10',
    ) );

    $box->add_field( array(
        'name' => 'Initiales (fallback photo)',
        'id'   => 'initials',
        'type' => 'text_small',
    ) );

    $box->add_field( array(
        'name' => 'Couleur de fond (fallback)',
        'id'   => 'initials_bg',
        'type' => 'text',
    ) );

    $box->add_field( array(
        'name' => 'Couleur de texte (fallback)',
        'id'   => 'initials_color',
        'type' => 'text',
    ) );
}

function labia_get_team_members( $pole_slug = null ) {
    $args = array(
        'post_type'      => 'team_member',
        'posts_per_page' => -1,
        'orderby'        => 'meta_value_num',
        'meta_key'       => 'display_order',
        'order'          => 'ASC',
        'no_found_rows'  => true,
    );

    if ( $pole_slug ) {
        $args['tax_query'] = array( array(
            'taxonomy' => 'team_pole',
            'field'    => 'slug',
            'terms'    => $pole_slug,
        ) );
    }

    return get_posts( $args );
}
