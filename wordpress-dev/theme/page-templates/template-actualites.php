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
      <p class="page-hero__lead t-lead">Événements, projets, interventions, nouveautés : tout ce qui fait vivre le LAB'IA Loire Valley au quotidien.</p>
    </div>
  </div>
</div>

<section>
  <div class="container">

    <?php
    $paged = max( 1, (int) get_query_var( 'paged' ), (int) get_query_var( 'page' ) );
    $news_query = new WP_Query( array(
        'post_type'      => 'post',
        'post_status'    => 'publish',
        'posts_per_page' => 12,
        'paged'          => $paged,
        'orderby'        => 'date',
        'order'          => 'DESC',
    ) );
    if ( $news_query->have_posts() ) :
    ?>
    <div class="actu-grid">
      <?php while ( $news_query->have_posts() ) : $news_query->the_post(); ?>
      <article class="actu-card reveal">
        <?php if ( has_post_thumbnail() ) : ?>
        <a class="actu-card__img" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true"><?php the_post_thumbnail( 'medium_large' ); ?></a>
        <?php endif; ?>
        <div class="actu-card__body">
          <div class="actu-card__date"><?php echo esc_html( get_the_date( 'd M Y' ) ); ?></div>
          <h2 class="actu-card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
          <p class="actu-card__excerpt"><?php echo esc_html( get_the_excerpt() ); ?></p>
          <div class="actu-card__footer">
            <a href="<?php the_permalink(); ?>" class="btn btn-sm btn-outline">Lire<svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 8h10M9 4l4 4-4 4"/></svg></a>
          </div>
        </div>
      </article>
      <?php endwhile; ?>
    </div>
    <?php
    $big = 999999999;
    $pagination = paginate_links( array(
        'base'    => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
        'format'  => '?paged=%#%',
        'current' => $paged,
        'total'   => $news_query->max_num_pages,
        'prev_text' => '←',
        'next_text' => '→',
        'type'    => 'list',
    ) );
    if ( $pagination ) : ?>
    <nav class="pagination" aria-label="Pagination des actualités">
      <?php echo $pagination; ?>
    </nav>
    <?php endif;
    wp_reset_postdata();
    ?>
    <?php else : ?>
    <p class="text-muted actu-empty">Aucune actualité pour le moment.</p>
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
