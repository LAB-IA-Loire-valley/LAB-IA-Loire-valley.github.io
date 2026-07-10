<?php
/**
 * Global site options (CMB2 Options Page)
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

add_action( 'cmb2_admin_init', 'labia_register_options_page' );
function labia_register_options_page() {

    $opt_page = new_cmb2_box( array(
        'id'           => 'labia_options',
        'title'        => "Paramètres LAB'IA",
        'object_types' => array( 'options-page' ),
        'option_key'   => 'labia_options',
        'parent_slug'  => 'options-general.php',
        'capability'   => 'manage_options',
        'save_button'  => 'Enregistrer les paramètres',
    ) );

    // Identité
    $opt_page->add_field( array(
        'name' => 'Identité du site',
        'type' => 'title',
        'id'   => 'opt_identity_title',
    ) );

    $opt_page->add_field( array(
        'name' => 'Logo du site',
        'id'   => 'site_logo',
        'type' => 'file',
        'options' => array( 'url' => false ),
        'text'    => array( 'add_upload_file_text' => 'Choisir le logo' ),
    ) );

    $opt_page->add_field( array(
        'name' => 'Description (footer)',
        'id'   => 'footer_description',
        'type' => 'textarea',
    ) );

    // Contact
    $opt_page->add_field( array(
        'name' => 'Contact',
        'type' => 'title',
        'id'   => 'opt_contact_title',
    ) );

    $opt_page->add_field( array(
        'name'    => 'Téléphone',
        'id'      => 'phone',
        'type'    => 'text',
        'default' => '02 38 69 80 87',
    ) );

    $opt_page->add_field( array(
        'name'    => 'Email',
        'id'      => 'email',
        'type'    => 'text',
        'default' => 'contact@labia-loirevalley.fr',
    ) );

    $opt_page->add_field( array(
        'name'    => 'Adresse — ligne 1',
        'id'      => 'address_line_1',
        'type'    => 'text',
        'default' => "Le LAB'O — Village By CA Orléans",
    ) );

    $opt_page->add_field( array(
        'name'    => 'Adresse — ligne 2',
        'id'      => 'address_line_2',
        'type'    => 'text',
        'default' => '1 avenue du Champ de Mars, CS 30019',
    ) );

    $opt_page->add_field( array(
        'name'    => 'Adresse — ville',
        'id'      => 'address_city',
        'type'    => 'text',
        'default' => '45074 Orléans Cedex 2',
    ) );

    // Réseaux sociaux
    $opt_page->add_field( array(
        'name' => 'Réseaux sociaux',
        'type' => 'title',
        'id'   => 'opt_social_title',
    ) );

    $opt_page->add_field( array(
        'name'    => 'URL LinkedIn',
        'id'      => 'linkedin_url',
        'type'    => 'text',
        'default' => 'https://www.linkedin.com/company/lab-ia-loire-valley',
    ) );

    // Financeurs
    $opt_page->add_field( array(
        'name' => "Financeurs (footer)",
        'type' => 'title',
        'id'   => 'opt_financeurs_title',
    ) );

    $opt_page->add_field( array(
        'name' => "Image financeurs LAB'IA",
        'id'   => 'financeur_image_1',
        'type' => 'file',
    ) );

    $opt_page->add_field( array(
        'name' => 'Image financeurs Technopole',
        'id'   => 'financeur_image_2',
        'type' => 'file',
    ) );

    // Hero
    $opt_page->add_field( array(
        'name' => "Hero (page d'accueil)",
        'type' => 'title',
        'id'   => 'opt_hero_title',
    ) );

    $opt_page->add_field( array(
        'name'    => 'Marque hero (HTML autorisé)',
        'id'      => 'hero_brand',
        'type'    => 'textarea',
        'default' => "LAB'<span>IA</span> Loire Valley",
    ) );

    $opt_page->add_field( array(
        'name' => 'Image badge ambassadeur',
        'id'   => 'ambassador_badge_image',
        'type' => 'file',
    ) );

    $opt_page->add_field( array(
        'name'    => 'Tagline hero (HTML autorisé)',
        'id'      => 'hero_title',
        'type'    => 'textarea',
        'default' => "L'intelligence artificielle, <em>accessible à tous.</em>",
    ) );

    $opt_page->add_field( array(
        'name'    => 'Sous-titre hero',
        'id'      => 'hero_lead',
        'type'    => 'textarea',
        'default' => "Le LAB'IA Loire Valley accompagne les entreprises et structures de la région Centre-Val de Loire dans leurs projets Data & IA, du diagnostic à l'industrialisation.",
    ) );

    $opt_page->add_field( array(
        'name'    => 'CTA 1 — texte',
        'id'      => 'hero_cta_1_text',
        'type'    => 'text',
        'default' => 'Découvrir notre offre',
    ) );

    $opt_page->add_field( array(
        'name'    => 'CTA 1 — URL',
        'id'      => 'hero_cta_1_url',
        'type'    => 'text',
        'default' => '/notre-offre/',
    ) );

    $opt_page->add_field( array(
        'name'    => 'CTA 2 — texte',
        'id'      => 'hero_cta_2_text',
        'type'    => 'text',
        'default' => 'Parler de mon projet',
    ) );

    $opt_page->add_field( array(
        'name'    => 'CTA 2 — URL',
        'id'      => 'hero_cta_2_url',
        'type'    => 'text',
        'default' => '/contact/',
    ) );
}

function labia_opt( $key, $default = '' ) {
    $opts = get_option( 'labia_options', array() );
    return isset( $opts[ $key ] ) && $opts[ $key ] !== '' ? $opts[ $key ] : $default;
}
