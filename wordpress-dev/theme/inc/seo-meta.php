<?php
/**
 * Balises de partage : meta description + Open Graph + Twitter Card.
 *
 * Le thème n'a pas de plugin SEO : ces balises alimentent les aperçus de lien
 * (Teams, LinkedIn, WhatsApp, Slack, Facebook…) de façon propre et cohérente.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/** Accroche par défaut du site (reprend la baseline de la page d'accueil). */
function labia_default_tagline() {
    return "L'intelligence artificielle, accessible à tous.";
}

/** Description par défaut (paragraphe d'introduction de la page d'accueil). */
function labia_default_description() {
    return "Le LAB'IA Loire Valley accompagne les entreprises et structures de la région Centre-Val de Loire dans leurs projets Data & IA, du diagnostic à l'industrialisation.";
}

/** URL canonique de la page courante, utilisable dans un aperçu de partage. */
function labia_current_url() {
    if ( is_singular() ) {
        return get_permalink();
    }
    if ( is_front_page() ) {
        return home_url( '/' );
    }
    global $wp;
    $path = isset( $wp->request ) ? $wp->request : '';
    return $path !== '' ? home_url( '/' . ltrim( $path, '/' ) ) : home_url( '/' );
}

/** Titre lisible pour un aperçu de partage. */
function labia_share_title() {
    if ( is_front_page() ) {
        return get_bloginfo( 'name' ) . ' — ' . labia_default_tagline();
    }
    if ( is_singular() ) {
        return single_post_title( '', false ) . ' — ' . get_bloginfo( 'name' );
    }
    if ( is_category() || is_tag() || is_tax() ) {
        return single_term_title( '', false ) . ' — ' . get_bloginfo( 'name' );
    }
    if ( is_search() ) {
        return 'Recherche — ' . get_bloginfo( 'name' );
    }
    return wp_get_document_title();
}

/** Description pour un aperçu de partage. */
function labia_share_description() {
    if ( is_front_page() ) {
        return labia_default_description();
    }
    if ( is_singular() ) {
        $post = get_queried_object();
        if ( $post instanceof WP_Post ) {
            $text = has_excerpt( $post ) ? get_the_excerpt( $post ) : $post->post_content;
            $text = wp_strip_all_tags( strip_shortcodes( (string) $text ) );
            $text = trim( preg_replace( '/\s+/', ' ', $text ) );
            if ( $text !== '' ) {
                return wp_html_excerpt( $text, 155, '…' );
            }
        }
    }
    if ( is_category() || is_tag() || is_tax() ) {
        $text = trim( preg_replace( '/\s+/', ' ', wp_strip_all_tags( term_description() ) ) );
        if ( $text !== '' ) {
            return wp_html_excerpt( $text, 155, '…' );
        }
    }
    return labia_default_description();
}

/** Image de partage : image à la une si présente, sinon visuel de marque 1200×630. */
function labia_share_image() {
    $default = LABIA_THEME_URI . '/assets/img/og-default.png';
    if ( is_singular() && has_post_thumbnail() ) {
        $src = get_the_post_thumbnail_url( null, 'full' );
        if ( $src ) {
            $id  = get_post_thumbnail_id();
            $dim = $id ? wp_get_attachment_image_src( $id, 'full' ) : false;
            // On ne garde l'image à la une que si elle est assez grande pour
            // un bel aperçu ; sinon on retombe sur le visuel de marque 1200×630.
            if ( $dim && (int) $dim[1] >= 600 ) {
                return array(
                    'url'    => $src,
                    'width'  => (int) $dim[1],
                    'height' => (int) $dim[2],
                );
            }
        }
    }
    return array(
        'url'    => $default,
        'width'  => 1200,
        'height' => 630,
    );
}

/** Écrit les balises dans <head>. */
function labia_output_share_meta() {
    $title = labia_share_title();
    $desc  = labia_share_description();
    $url   = labia_current_url();
    $image = labia_share_image();

    $type = is_singular( 'post' ) ? 'article' : 'website';

    echo "\n<!-- Balises de partage (LAB'IA) -->\n";
    echo '<meta name="description" content="' . esc_attr( $desc ) . '">' . "\n";

    echo '<meta property="og:site_name" content="' . esc_attr( get_bloginfo( 'name' ) ) . '">' . "\n";
    echo '<meta property="og:locale" content="fr_FR">' . "\n";
    echo '<meta property="og:type" content="' . esc_attr( $type ) . '">' . "\n";
    echo '<meta property="og:title" content="' . esc_attr( $title ) . '">' . "\n";
    echo '<meta property="og:description" content="' . esc_attr( $desc ) . '">' . "\n";
    echo '<meta property="og:url" content="' . esc_url( $url ) . '">' . "\n";
    echo '<meta property="og:image" content="' . esc_url( $image['url'] ) . '">' . "\n";
    echo '<meta property="og:image:width" content="' . esc_attr( (string) $image['width'] ) . '">' . "\n";
    echo '<meta property="og:image:height" content="' . esc_attr( (string) $image['height'] ) . '">' . "\n";

    echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
    echo '<meta name="twitter:title" content="' . esc_attr( $title ) . '">' . "\n";
    echo '<meta name="twitter:description" content="' . esc_attr( $desc ) . '">' . "\n";
    echo '<meta name="twitter:image" content="' . esc_url( $image['url'] ) . '">' . "\n";
}
add_action( 'wp_head', 'labia_output_share_meta', 2 );
