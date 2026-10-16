<?php
/**
 * Hero section — homepage (Design A : brand-forward, Mono)
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$brand     = labia_opt( 'hero_brand', "LAB'<span>IA</span> Loire Valley" );
$tagline   = labia_opt( 'hero_title', "L'intelligence artificielle, <em>accessible à tous.</em>" );
$lead      = labia_opt( 'hero_lead', "Le LAB'IA Loire Valley accompagne les entreprises et structures de la région Centre-Val de Loire dans leurs projets Data & IA, du diagnostic à l'industrialisation." );
$cta1_text = labia_opt( 'hero_cta_1_text', 'Découvrir notre offre' );
$cta1_url  = labia_opt( 'hero_cta_1_url', '/notre-offre/' );
$cta2_text = labia_opt( 'hero_cta_2_text', 'Parler de mon projet' );
$cta2_url  = labia_opt( 'hero_cta_2_url', '/contact/' );
$badge_id  = labia_opt( 'ambassador_badge_image' );
$badge_url = $badge_id ? wp_get_attachment_url( $badge_id ) : LABIA_THEME_URI . '/assets/img/badge-osez-lia.png';
?>
<section class="hero" id="main-content">
    <canvas id="hero-canvas"></canvas>

    <div class="container">
        <div class="hero__inner">
            <h1 class="hero__brand"><?php echo wp_kses_post( $brand ); ?></h1>
            <p class="hero__tagline"><?php echo wp_kses_post( $tagline ); ?></p>
            <p class="hero__lead"><?php echo esc_html( $lead ); ?></p>
            <div class="hero__actions">
                <a href="<?php echo esc_url( $cta1_url ); ?>" class="btn btn-primary btn-lg">
                    <?php echo esc_html( $cta1_text ); ?>
                    <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 8h10M9 4l4 4-4 4"/></svg>
                </a>
                <a href="<?php echo esc_url( $cta2_url ); ?>" class="btn btn-outline btn-lg"><?php echo esc_html( $cta2_text ); ?></a>
            </div>
        </div>
    </div>

    <?php if ( $badge_url ) : ?>
    <div class="hero__badge">
        <div class="hero__badge-circle">
            <img class="hero__badge-img" src="<?php echo esc_url( $badge_url ); ?>" alt="Label Ambassadeur IA" />
        </div>
    </div>
    <?php endif; ?>

    <div class="hero__bg-logo">
        <img src="<?php echo esc_url( LABIA_THEME_URI . '/assets/img/logos/logo labia without name.png' ); ?>" alt="" aria-hidden="true" />
    </div>

    <div class="hero__scroll">
        <div class="hero__scroll-line"></div>
        <span class="hero__scroll-text">Scroll</span>
    </div>
</section>
