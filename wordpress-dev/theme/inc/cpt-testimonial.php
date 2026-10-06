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

/**
 * Return a testimonial role without an organization suffix already shown separately.
 * Recognizes full company names and unambiguous short forms such as a parenthesized acronym.
 */
function labia_get_testimonial_display_role( $author_role, $company ) {
    $role = trim( (string) $author_role );
    $company = trim( (string) $company );
    if ( ! $role || ! $company ) {
        return $role;
    }

    $normalize = static function ( $value ) {
        return preg_replace( '/[^a-z0-9]+/', '', remove_accents( strtolower( trim( $value ) ) ) );
    };
    $company_key = $normalize( $company );
    $company_aliases = array( $company_key );

    if ( preg_match( '/\(([a-z0-9]{2,10})\)\s*$/i', $company, $acronym ) ) {
        $company_aliases[] = $normalize( $acronym[1] );
    }

    $role_parts = preg_split( '/\s*(?:[·|—|–]|,)\s*/u', $role );
    if ( ! is_array( $role_parts ) || count( $role_parts ) < 2 ) {
        return $role;
    }

    $organization_key = $normalize( end( $role_parts ) );
    foreach ( $company_aliases as $alias ) {
        if ( $organization_key && ( $organization_key === $alias || ( strlen( $organization_key ) >= 4 && strpos( $alias, $organization_key ) !== false ) ) ) {
            array_pop( $role_parts );
            return trim( implode( ' · ', $role_parts ) );
        }
    }

    return $role;
}

/** Return a testimonial image URL across CMB2's stored URL and attachment ID meta. */
function labia_get_testimonial_image_url( $testimonial_id, $field_id ) {
    $field_id = sanitize_key( $field_id );
    if ( ! in_array( $field_id, array( 'photo', 'company_logo' ), true ) ) {
        return '';
    }

    $attachment_id = absint( get_post_meta( $testimonial_id, $field_id . '_id', true ) );
    if ( $attachment_id ) {
        $attachment_url = wp_get_attachment_url( $attachment_id );
        if ( $attachment_url ) {
            return $attachment_url;
        }
    }

    $stored_value = get_post_meta( $testimonial_id, $field_id, true );
    if ( is_numeric( $stored_value ) ) {
        $attachment_url = wp_get_attachment_url( absint( $stored_value ) );
        if ( $attachment_url ) {
            return $attachment_url;
        }
    }

    return is_string( $stored_value ) ? esc_url_raw( $stored_value ) : '';
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
