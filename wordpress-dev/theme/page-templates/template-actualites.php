<?php
/**
 * Template Name: Actualités
 * News article feed — full-width scrollable format
 */

get_header();
?>


<div class="page-hero" id="main-content">
  <div class="container">
    <div class="page-hero__inner">
      <div class="section-label" style="margin-bottom:16px;"><span style="color:rgba(255,255,255,.4);">Nos nouvelles</span></div>
      <h1 class="t-display page-hero__title">Actualités</h1>
      <p class="page-hero__lead t-lead">Événements, projets, interventions, nouveautés — tout ce qui fait vivre le LAB'IA Loire Valley au quotidien.</p>
    </div>
  </div>
</div>

<section>
  <div class="container">

    <?php
    $articles = labia_get_news_articles();
    if ( $articles ) :
    ?>
    <div class="news-feed">
      <?php foreach ( $articles as $a ) :
          $date     = get_post_meta( $a->ID, 'pub_date', true );
          $category = get_post_meta( $a->ID, 'news_category', true );
          $source   = get_post_meta( $a->ID, 'source_url', true );
          $img_id   = get_post_meta( $a->ID, 'featured_image', true );
          $img_url  = $img_id ? wp_get_attachment_url( $img_id ) : '';
          $content  = apply_filters( 'the_content', $a->post_content );
      ?>
      <article class="news-article reveal">
        <div class="news-article__header">
          <div>
            <?php if ( $category ) : ?><span class="badge badge-magenta" style="margin-bottom:8px;"><?php echo esc_html( $category ); ?></span><?php endif; ?>
            <h2 class="news-article__title"><?php echo esc_html( $a->post_title ); ?></h2>
          </div>
          <div class="news-article__date"><?php echo $date ? date( 'd M Y', $date ) : ''; ?></div>
        </div>
        <?php if ( $img_url ) : ?>
          <div class="news-article__image">
            <img src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo esc_attr( $a->post_title ); ?>" />
          </div>
        <?php endif; ?>
        <div class="news-article__body">
          <?php echo $content; ?>
        </div>
        <?php if ( $source ) : ?>
          <div class="news-article__footer">
            <a href="<?php echo esc_url( $source ); ?>" target="_blank" rel="noopener" class="btn btn-sm btn-outline">
              Lire l'article source
              <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 8h10M9 4l4 4-4 4"/></svg>
            </a>
          </div>
        <?php endif; ?>
      </article>
      <?php endforeach; ?>
    </div>
    <?php else : ?>
    <p class="text-muted" style="text-align:center; padding:80px 0;">Aucune actualité pour le moment.</p>
    <?php endif; ?>

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
