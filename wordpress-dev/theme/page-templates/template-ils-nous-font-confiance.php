<?php
/**
 * Template Name: Ils nous font confiance
 */

get_header();
?>

<div class="page-hero" id="main-content">
    <div class="container">
        <div class="page-hero__inner">
            <div class="section-label" style="margin-bottom:16px;"><span style="color:rgba(255,255,255,.4);">Références</span></div>
            <h1 class="t-display page-hero__title">Ils nous font confiance</h1>
            <p class="page-hero__lead t-lead">Entreprises, institutions, opérateurs, écoles de formation — un écosystème régional engagé dans la transformation IA.</p>
        </div>
    </div>
</div>

<section style="padding-bottom:0;">
    <div class="container">
        <div class="section-label reveal mb-32"><span>Nos clients &amp; partenaires</span></div>
    </div>
</section>

<div class="client-ticker">
    <div class="client-track">
        <?php
        $clients = labia_get_clients();
        if ( $clients ) :
            // Render the set twice for the marquee effect
            for ( $i = 0; $i < 2; $i++ ) :
                foreach ( $clients as $client ) :
                    $logo_id  = get_post_meta( $client->ID, 'logo', true );
                    $emoji    = get_post_meta( $client->ID, 'emoji', true );
                    $sector   = get_post_meta( $client->ID, 'sector', true );
                    $site_url = get_post_meta( $client->ID, 'site_url', true );
                    $logo_url = $logo_id ? wp_get_attachment_url( $logo_id ) : '';
                    $is_duplicate = ( $i > 0 );
        ?>
                    <div class="client-logo-item"<?php echo $is_duplicate ? ' aria-hidden="true"' : ''; ?>>
                        <?php if ( $site_url && ! $is_duplicate ) : ?><a href="<?php echo esc_url( $site_url ); ?>" target="_blank" rel="noopener" style="text-decoration:none;color:inherit;"><?php endif; ?>
                            <?php if ( $logo_url && ! $is_duplicate ) : ?>
                                <img src="<?php echo esc_url( $logo_url ); ?>" alt="<?php echo esc_attr( $client->post_title ); ?>" />
                            <?php else: ?>
                                <div class="client-emoji"><?php echo esc_html( $emoji ); ?></div>
                            <?php endif; ?>
                            <div class="client-name"><?php echo esc_html( $client->post_title ); ?></div>
                            <?php if ( $sector ) : ?>
                                <div class="client-sector"><?php echo esc_html( $sector ); ?></div>
                            <?php endif; ?>
                        <?php if ( $site_url && ! $is_duplicate ) : ?></a><?php endif; ?>
                    </div>
                <?php endforeach;
            endfor;
        else : ?>
            <div class="container">
                <p class="text-muted">Aucun client enregistré pour le moment. <a href="<?php echo esc_url( admin_url( 'post-new.php?post_type=client' ) ); ?>">Ajouter un client</a></p>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Témoignages détaillés -->
<section style="background:var(--offwhite); padding-top:0;">
    <div class="container">
        <div class="section-label reveal mb-48"><span>Témoignages</span></div>

        <?php
        $testimonials = labia_get_testimonials();
        if ( $testimonials ) :
            $i = 0;
            foreach ( $testimonials as $testimonial ) :
                $quote        = get_post_meta( $testimonial->ID, 'quote', true );
                $author       = get_post_meta( $testimonial->ID, 'author', true );
                $author_role  = get_post_meta( $testimonial->ID, 'author_role', true );
                $company      = get_post_meta( $testimonial->ID, 'company', true );
                $logo_id      = get_post_meta( $testimonial->ID, 'company_logo', true );
                $emoji        = get_post_meta( $testimonial->ID, 'emoji', true );
                $sector       = get_post_meta( $testimonial->ID, 'sector', true );
                $sector_color = get_post_meta( $testimonial->ID, 'sector_color', true ) ?: 'var(--magenta)';
                $logo_url     = $logo_id ? wp_get_attachment_url( $logo_id ) : '';
        ?>
            <div class="case-study reveal">
                <div class="case-study__header">
                    <div class="case-study__logo"><?php echo $logo_url ? '<img src="' . esc_url( $logo_url ) . '" alt="' . esc_attr( $company ) . '" style="max-height:40px;">' : esc_html( $emoji ?: '🏢' ); ?></div>
                    <div>
                        <div class="badge mb-8" style="background:<?php echo esc_attr( $sector_color ); ?>;color:white;"><?php echo esc_html( $sector ); ?></div>
                        <h3 class="t-h3"><?php echo esc_html( $company ); ?></h3>
                        <?php if ( $author_role ) : ?><p class="t-small text-muted"><?php echo esc_html( $author_role ); ?></p><?php endif; ?>
                    </div>
                </div>
                <div class="case-study__body">
                    <p class="case-study__quote">"<?php echo esc_html( $quote ); ?>"</p>
                    <?php if ( $author ) : ?>
                        <div class="case-study__author"><?php echo esc_html( $author ); ?><?php if ( $author_role ) echo ' — ' . esc_html( $author_role ); ?><?php if ( $company ) echo ' · ' . esc_html( $company ); ?></div>
                    <?php endif; ?>
                </div>
            </div>
        <?php $i++; endforeach; else : ?>
            <p class="text-muted">Aucun témoignage à afficher pour le moment. <a href="<?php echo esc_url( admin_url( 'post-new.php?post_type=testimonial' ) ); ?>">Ajouter un témoignage</a></p>
        <?php endif; ?>
    </div>
</section>

<?php
set_query_var( 'cta_title', 'Rejoignez nos références' );
set_query_var( 'cta_lead', 'Pré-diagnostic offert. Parlons de votre projet Data & IA.' );
set_query_var( 'cta_btn_text', 'Nous contacter' );
set_query_var( 'cta_btn_url', home_url( '/contact/' ) );
get_template_part( 'template-parts/section-cta' );
?>

<?php get_footer(); ?>
