<?php
/**
 * Archives (catégories, étiquettes, auteurs, dates).
 */

get_header();
?>

<div class="page-hero" id="main-content">
  <div class="container">
    <div class="page-hero__inner">
      <div class="section-label"><span>Archives</span></div>
      <h1 class="t-display page-hero__title"><?php echo wp_kses_post( get_the_archive_title() ); ?></h1>
      <?php if ( get_the_archive_description() ) : ?>
      <p class="page-hero__lead t-lead"><?php echo wp_kses_post( get_the_archive_description() ); ?></p>
      <?php endif; ?>
    </div>
  </div>
</div>

<section>
  <div class="container">

    <?php if ( have_posts() ) : ?>
    <div class="actu-grid">
      <?php while ( have_posts() ) : the_post(); ?>
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
    $pagination = paginate_links( array(
        'prev_text' => '←',
        'next_text' => '→',
        'type'      => 'list',
    ) );
    if ( $pagination ) : ?>
    <nav class="pagination" aria-label="Pagination des archives">
      <?php echo $pagination; ?>
    </nav>
    <?php endif; ?>

    <?php else : ?>
    <p class="text-muted actu-empty">Aucune publication dans cette archive.</p>
    <?php endif; ?>

  </div>
</section>

<?php get_footer(); ?>
