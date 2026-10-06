<?php
/**
 * Template Name: Ils nous font confiance
 * 1-to-1 port of ils-nous-font-confiance.html
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

<!-- Logos clients -->
<section style="padding-bottom:0;">
  <div class="container">
    <div class="section-label reveal mb-32"><span>Nos clients &amp; partenaires</span></div>
  </div>
</section>

<?php
$clients = labia_get_clients();
if ( $clients ) :
?>
<div class="client-ticker">
  <div class="client-track">
    <?php for ( $s = 0; $s < 2; $s++ ) :
        foreach ( $clients as $client ) :
            $logo_file = get_post_meta( $client->ID, 'logo_file', true );
            $emoji     = get_post_meta( $client->ID, 'emoji', true );
            $sector    = get_post_meta( $client->ID, 'sector', true );
    ?>
      <div class="client-logo-item"<?php echo $s > 0 ? ' aria-hidden="true"' : ''; ?>>
        <?php if ( $logo_file ) : ?>
          <img src="<?php echo esc_url( LABIA_THEME_URI . '/assets/img/logos/' . $logo_file ); ?>" alt="<?php echo esc_attr( $client->post_title ); ?>" />
        <?php else : ?>
          <div class="client-emoji"><?php echo esc_html( $emoji ); ?></div>
        <?php endif; ?>
        <div class="client-name"><?php echo esc_html( $client->post_title ); ?></div>
        <?php if ( $sector ) : ?><div class="client-sector"><?php echo esc_html( $sector ); ?></div><?php endif; ?>
      </div>
    <?php endforeach; endfor; ?>
  </div>
</div>
<?php endif; ?>

<!-- Témoignages détaillés -->
<section style="background:var(--offwhite); padding-top:0;">
  <div class="container">
    <div class="section-label reveal mb-48"><span>Témoignages</span></div>

    <?php
    $testimonials = labia_get_testimonials();
    if ( $testimonials ) :
        $first_four = array_slice( $testimonials, 0, 4 );
        $last_two   = array_slice( $testimonials, 4, 2 );
    ?>
        <?php foreach ( $first_four as $i => $t ) :
            $quote  = get_post_meta( $t->ID, 'quote', true );
            $author = get_post_meta( $t->ID, 'author', true );
            $author_role = get_post_meta( $t->ID, 'author_role', true );
            $company = get_post_meta( $t->ID, 'company', true );
            $company_logo_url = labia_get_testimonial_image_url( $t->ID, 'company_logo' );
            $sector = get_post_meta( $t->ID, 'sector', true );
            $sector_color = sanitize_hex_color( get_post_meta( $t->ID, 'sector_color', true ) );
            $photo_url = labia_get_testimonial_image_url( $t->ID, 'photo' );
            $initials = labia_get_initials( $author );
            $display_role = labia_get_testimonial_display_role( $author_role, $company );
            $accent = labia_avatar_color( $i );
            $faint = labia_hex_to_rgba( $accent, 0.12 );
        ?>
        <div class="case-study reveal<?php echo $i ? '' : ''; ?>">
          <div class="case-study__header">
            <?php if ( $company_logo_url ) : ?><div class="case-study__logo"><img src="<?php echo esc_url( $company_logo_url ); ?>" alt="<?php echo esc_attr( $company ?: $t->post_title ); ?>" /></div><?php endif; ?>
            <div>
              <?php if ( $sector ) : ?>
                <div class="badge mb-8" style="<?php echo $sector_color ? 'background:' . esc_attr( $sector_color ) . ';color:white;' : ''; ?>"><?php echo esc_html( $sector ); ?></div>
              <?php endif; ?>
              <h3 class="t-h3"><?php echo esc_html( $company ?: $t->post_title ); ?></h3>
            </div>
          </div>
          <div class="case-study__body">
            <p class="case-study__quote">"<?php echo esc_html( $quote ); ?>"</p>
            <?php if ( $author ) : ?>
              <div class="case-study__author">
                <?php if ( $photo_url || $initials ) : ?><div class="case-study__author-avatar" style="<?php echo $photo_url ? '' : esc_attr( "--avatar-color:$accent;--avatar-faint:$faint;" ); ?>"><?php if ( $photo_url ) : ?><img src="<?php echo esc_url( $photo_url ); ?>" alt="" /><?php else : ?><span><?php echo esc_html( $initials ); ?></span><?php endif; ?></div><?php endif; ?>
                <span class="case-study__author-copy"><span class="case-study__author-name"><?php echo esc_html( $author ); ?></span><?php if ( $display_role ) : ?> <span class="case-study__author-role">— <?php echo esc_html( $display_role ); ?></span><?php endif; ?></span>
              </div>
            <?php endif; ?>
          </div>
        </div>
        <?php endforeach; ?>

        <?php if ( $last_two ) : ?>
        <div class="grid-2 mt-32">
          <?php foreach ( $last_two as $i => $t ) :
            $quote  = get_post_meta( $t->ID, 'quote', true );
            $author = get_post_meta( $t->ID, 'author', true );
            $author_role = get_post_meta( $t->ID, 'author_role', true );
            $company = get_post_meta( $t->ID, 'company', true );
            $company_logo_url = labia_get_testimonial_image_url( $t->ID, 'company_logo' );
            $sector = get_post_meta( $t->ID, 'sector', true );
            $sector_color = sanitize_hex_color( get_post_meta( $t->ID, 'sector_color', true ) );
            $photo_url = labia_get_testimonial_image_url( $t->ID, 'photo' );
            $initials = labia_get_initials( $author );
            $accent = labia_avatar_color( $i + 4 );
            $faint = labia_hex_to_rgba( $accent, 0.12 );
            $display_role = labia_get_testimonial_display_role( $author_role, $company );
          ?>
          <div class="case-study reveal<?php echo $i ? ' reveal-delay-1' : ''; ?>" style="margin-bottom:0;">
            <div class="case-study__header">
              <?php if ( $company_logo_url ) : ?><div class="case-study__logo"><img src="<?php echo esc_url( $company_logo_url ); ?>" alt="<?php echo esc_attr( $company ?: $t->post_title ); ?>" /></div><?php endif; ?>
              <div>
                <?php if ( $sector ) : ?>
                  <div class="badge badge-dark mb-8"><?php echo esc_html( $sector ); ?></div>
                <?php endif; ?>
                <h3 class="t-h3"><?php echo esc_html( $company ?: $t->post_title ); ?></h3>
              </div>
            </div>
            <div class="case-study__body">
              <p class="case-study__quote">"<?php echo esc_html( $quote ); ?>"</p>
              <?php if ( $author ) : ?>
                <div class="case-study__author">
                  <?php if ( $photo_url || $initials ) : ?><div class="case-study__author-avatar" style="<?php echo $photo_url ? '' : esc_attr( "--avatar-color:$accent;--avatar-faint:$faint;" ); ?>"><?php if ( $photo_url ) : ?><img src="<?php echo esc_url( $photo_url ); ?>" alt="" /><?php else : ?><span><?php echo esc_html( $initials ); ?></span><?php endif; ?></div><?php endif; ?>
                  <span class="case-study__author-copy"><span class="case-study__author-name"><?php echo esc_html( $author ); ?></span><?php if ( $display_role ) : ?> <span class="case-study__author-role">— <?php echo esc_html( $display_role ); ?></span><?php endif; ?></span>
                </div>
              <?php endif; ?>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
        <?php endif; ?>
    <?php else : ?>
      <p class="text-muted">Aucun témoignage pour le moment.</p>
    <?php endif; ?>
  </div>
</section>

<!-- CTA -->
<section class="ctx-magenta cta-section">
  <div class="container">
    <h2 class="t-h1 reveal" style="color:var(--white);">Rejoignez nos références</h2>
    <p class="t-lead reveal reveal-delay-1" style="color:rgba(255,255,255,.75);">Pré-diagnostic offert. Parlons de votre projet Data &amp; IA.</p>
    <div class="flex-center gap-16 flex-wrap reveal reveal-delay-2" style="margin-top:40px;">
      <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="btn btn-white btn-lg" style="color:var(--magenta);">Nous contacter<svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 8h10M9 4l4 4-4 4"/></svg></a>
    </div>
  </div>
</section>


<?php get_footer(); ?>
