<?php
/**
 * Hero section — used on the homepage
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$badge_text = labia_opt( 'hero_badge_text', "Ambassadeur IA — Plan national Osez l'IA" );
$title      = labia_opt( 'hero_title', "L'intelligence<br/>artificielle,<br/><em>accessible à tous.</em>" );
$lead       = labia_opt( 'hero_lead' );
$cta1_text  = labia_opt( 'hero_cta_1_text', 'Découvrir notre offre' );
$cta1_url   = labia_opt( 'hero_cta_1_url', '/notre-offre/' );
$cta2_text  = labia_opt( 'hero_cta_2_text', 'Parler de mon projet' );
$cta2_url   = labia_opt( 'hero_cta_2_url', '/contact/' );
$badge_id   = labia_opt( 'ambassador_badge_image' );
$badge_url  = $badge_id ? wp_get_attachment_url( $badge_id ) : 'https://static.wixstatic.com/media/667cf1_e5175fd9b21947b8bfc2f9016db01372~mv2.png';
?>
<section class="hero" id="main-content">
    <canvas id="hero-canvas"></canvas>

    <div class="container">
        <div class="hero__inner">
            <div class="hero__eyebrow">
                <span class="badge badge-white badge-dot"><?php echo esc_html( $badge_text ); ?></span>
            </div>
            <h1 class="t-display hero__title"><?php echo wp_kses_post( $title ); ?></h1>
            <p class="hero__lead"><?php echo esc_html( $lead ); ?></p>
            <div class="hero__actions">
                <a href="<?php echo esc_url( $cta1_url ); ?>" class="btn btn-primary btn-lg">
                    <?php echo esc_html( $cta1_text ); ?>
                    <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 8h10M9 4l4 4-4 4"/></svg>
                </a>
                <a href="<?php echo esc_url( $cta2_url ); ?>" class="btn btn-outline-white btn-lg"><?php echo esc_html( $cta2_text ); ?></a>
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

    <div class="hero__scroll">
        <div class="hero__scroll-line"></div>
        <span class="hero__scroll-text">Scroll</span>
    </div>
</section>
