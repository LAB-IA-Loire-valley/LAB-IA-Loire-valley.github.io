<?php
/**
 * Template générique des pages (celles sans template dédié).
 */

get_header();

while ( have_posts() ) :
    the_post();
?>

<div class="page-hero" id="main-content">
  <div class="container">
    <div class="page-hero__inner">
      <h1 class="t-display page-hero__title"><?php the_title(); ?></h1>
    </div>
  </div>
</div>

<section>
  <div class="container container--narrow legal-content">
    <?php the_content(); ?>
  </div>
</section>

<?php
endwhile;
get_footer();
