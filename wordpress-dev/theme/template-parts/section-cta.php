<?php
/**
 * Generic CTA section
 *
 * Required in scope: $cta_title, $cta_lead, $cta_btn_text, $cta_btn_url
 * Use set_query_var() before get_template_part() to pass them in.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$cta_title    = get_query_var( 'cta_title', '' );
$cta_lead     = get_query_var( 'cta_lead', '' );
$cta_btn_text = get_query_var( 'cta_btn_text', 'En savoir plus' );
$cta_btn_url  = get_query_var( 'cta_btn_url', '#' );
?>
<section class="ctx-magenta cta-section">
    <div class="container">
        <h2 class="t-h1 reveal" style="color:var(--white);"><?php echo esc_html( $cta_title ); ?></h2>
        <?php if ( ! empty( $cta_lead ) ) : ?>
            <p class="t-lead reveal reveal-delay-1" style="color:rgba(255,255,255,.75);"><?php echo esc_html( $cta_lead ); ?></p>
        <?php endif; ?>
        <div class="flex-center gap-16 flex-wrap reveal reveal-delay-2" style="margin-top:40px;">
            <a href="<?php echo esc_url( $cta_btn_url ); ?>" class="btn btn-white btn-lg" style="color:var(--magenta);">
                <?php echo esc_html( $cta_btn_text ); ?>
                <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 8h10M9 4l4 4-4 4"/></svg>
            </a>
        </div>
    </div>
</section>
