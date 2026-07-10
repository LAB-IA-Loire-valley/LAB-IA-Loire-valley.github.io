<?php
/**
 * Template Name: Nos Solutions
 * 1-to-1 port of nos-solutions.html
 */

get_header();
?>


<!-- Page Hero -->
<div class="page-hero" id="main-content">
  <div class="container">
    <div class="page-hero__inner">
      <div class="section-label" style="margin-bottom:16px;"><span style="color:rgba(255,255,255,.4);">Prêt à déployer</span></div>
      <h1 class="t-display page-hero__title">Nos Solutions</h1>
      <p class="page-hero__lead t-lead">
        Trois solutions IA développées et éprouvées, déployables en quelques semaines —
        souveraines, hébergées chez vous, adaptées à vos enjeux terrain.
      </p>
    </div>
  </div>
</div>

<!-- ── Les 3 solutions ──────────────────────────────────────── -->
<section>
  <div class="container">
    <div class="section-label reveal mb-48"><span>Toutes nos solutions</span></div>

<?php
$solutions = labia_get_solutions( false );
if ( $solutions ) :
    foreach ( $solutions as $i => $solution ) :
        $slug   = get_post_meta( $solution->ID, 'anchor_slug', true ) ?: sanitize_title( $solution->post_title );
        $emoji  = get_post_meta( $solution->ID, 'emoji', true ) ?: '🤖';
        $bg     = get_post_meta( $solution->ID, 'hero_bg', true ) ?: 'linear-gradient(135deg,#0D0D0D,#0a1a1a)';
        $tags   = get_post_meta( $solution->ID, 'tags', true );
        $tags_lines = $tags ? array_filter( array_map( 'trim', explode( "\n", $tags ) ) ) : array();
        $features   = get_post_meta( $solution->ID, 'features', true );
        $features_lines = $features ? array_filter( array_map( 'trim', explode( "\n", $features ) ) ) : array();
?>
    <div id="<?php echo esc_attr( $slug ); ?>" class="solution-card-full reveal mb-32"<?php echo $i > 0 ? ($i === 1 ? ' style=""' : '') : ''; ?>>
      <div class="solution-card-full__header">
        <div class="solution-card-full__icon" style="background:var(--blue-faint);"><?php echo esc_html( $emoji ); ?></div>
        <div style="flex:1;">
          <div style="display:flex;gap:8px;flex-wrap:wrap;margin-bottom:12px;">
            <?php foreach ( $tags_lines as $tag ) :
                $parts = explode( ':', $tag );
                $label = $parts[0];
                $color = $parts[1] ?? '#000';
                $style = $color ? 'background:' . $color : '';
            ?>
              <span class="badge" style="<?php echo esc_attr( $style ); ?>color:white;"><?php echo esc_html( $label ); ?></span>
            <?php endforeach; ?>
          </div>
          <h3 class="t-h2 mb-12"><?php echo esc_html( $solution->post_title ); ?></h3>
          <p class="t-lead" style="font-size:1rem;"><?php echo esc_html( $solution->post_content ); ?></p>
        </div>
      </div>
      <div class="solution-card-full__body">
        <?php foreach ( $features_lines as $feature ) : ?>
          <div class="solution-feature"><?php echo esc_html( $feature ); ?></div>
        <?php endforeach; ?>
      </div>
    </div>
<?php endforeach; else : ?>
    <p class="text-muted">Aucune solution pour le moment.</p>
<?php endif; ?>

  </div>
</section>

<!-- CTA -->
<section class="ctx-magenta cta-section">
  <div class="container">
    <div class="section-label reveal" style="justify-content:center;"><span style="color:rgba(255,255,255,.6);">Votre projet</span></div>
    <h2 class="t-h1 reveal mt-16" style="color:var(--white);">Votre besoin ne rentre pas dans une case ?</h2>
    <p class="t-lead reveal reveal-delay-1" style="color:rgba(255,255,255,.75);">
      Nous co-construisons chaque solution avec vous. Partagez votre problématique,
      nos experts vous proposent une approche adaptée en moins d'une semaine.
    </p>
    <div class="flex-center gap-16 flex-wrap reveal reveal-delay-2" style="margin-top:40px;">
      <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="btn btn-white btn-lg" style="color:var(--magenta);">
        Parler de mon besoin
        <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 8h10M9 4l4 4-4 4"/></svg>
      </a>
    </div>
  </div>
</section>


<?php get_footer(); ?>
