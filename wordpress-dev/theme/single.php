<?php
/**
 * Single article — regular `post` type.
 * Mirrors the Actualités feed cards: dark page-hero + readable article column.
 */

get_header();
?>

<div class="page-hero" id="main-content">
  <div class="container">
    <div class="page-hero__inner">
      <a href="<?php echo esc_url( home_url( '/actualites/' ) ); ?>" class="page-hero__back">← Retour aux actualités</a>

      <?php
      $pub_date  = get_post_meta( get_the_ID(), 'pub_date', true );
      $category  = get_post_meta( get_the_ID(), 'news_category', true );
      $lead      = get_post_meta( get_the_ID(), 'sub_title', true );
      $date_str  = absint( $pub_date ) ? date( 'd M Y', absint( $pub_date ) ) : get_the_date( 'd M Y' );
      if ( ! $lead && has_excerpt() ) {
          $excerpt = get_the_excerpt();
          $content = get_post_field( 'post_content', get_the_ID() );
          if ( $excerpt && mb_strlen( $excerpt ) < mb_strlen( $content ) ) {
              $lead = $excerpt;
          }
      }
      ?>

      <?php if ( $category ) : ?>
        <div class="badge badge-magenta mb-16"><?php echo esc_html( $category ); ?></div>
      <?php endif; ?>

      <h1 class="t-display page-hero__title"><?php the_title(); ?></h1>
      <p class="page-hero__meta"><?php echo esc_html( $date_str ); ?></p>

      <?php if ( $lead ) : ?>
        <p class="page-hero__lead t-lead"><?php echo esc_html( $lead ); ?></p>
      <?php endif; ?>
    </div>
  </div>
</div>

<section>
  <div class="container container--narrow">
    <?php
    $img_id  = get_post_meta( get_the_ID(), 'featured_image', true );
    $img_url = $img_id ? wp_get_attachment_url( $img_id ) : '';
    ?>
    <?php if ( $img_url ) : ?>
      <div class="single-article__image">
        <img src="<?php echo esc_url( $img_url ); ?>" alt="<?php the_title_attribute(); ?>" />
      </div>
    <?php elseif ( has_post_thumbnail() ) : ?>
      <div class="single-article__image">
        <?php the_post_thumbnail( 'large' ); ?>
      </div>
    <?php endif; ?>

    <article class="single-article">
      <div class="news-article__body">
        <?php the_content(); ?>
      </div>
      <?php
      $source = get_post_meta( get_the_ID(), 'source_url', true );
      if ( $source ) :
      ?>
        <div class="single-article__footer">
          <a href="<?php echo esc_url( $source ); ?>" target="_blank" rel="noopener" class="btn btn-sm btn-outline">
            Lire l'article source
            <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 8h10M9 4l4 4-4 4"/></svg>
          </a>
        </div>
      <?php endif; ?>
    </article>
  </div>
</section>

<!-- Newsletter / LinkedIn -->
<section class="ctx-blue s-sm">
  <div class="container" style="text-align:center;">
    <h2 class="t-h2 reveal mb-16" style="color:white;">Restez informé</h2>
    <p class="reveal reveal-delay-1" style="color:rgba(255,255,255,.5); margin-bottom:32px;">Suivez toutes nos actualités en temps réel sur LinkedIn.</p>
    <a href="<?php echo esc_url( labia_opt( 'linkedin_url', 'https://www.linkedin.com/company/lab-ia-loire-valley' ) ); ?>" target="_blank" rel="noopener" class="btn btn-outline-white reveal reveal-delay-2">
      <svg viewBox="0 0 24 24" fill="currentColor" style="width:18px;height:18px;"><path d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2z"/><circle cx="4" cy="4" r="2"/></svg>
      Suivre sur LinkedIn
    </a>
  </div>
</section>

<?php get_footer(); ?>