<?php
/**
 * Template Name: Actualités
 *
 * Lists WordPress blog posts in a styled grid (actu-card).
 */

get_header();
?>

<div class="page-hero" id="main-content">
    <div class="container">
        <div class="page-hero__inner">
            <div class="section-label" style="margin-bottom:16px;"><span style="color:rgba(255,255,255,.4);">Blog &amp; événements</span></div>
            <h1 class="t-display page-hero__title">Actualités</h1>
            <p class="page-hero__lead t-lead">Événements, projets, interventions, nouveautés — tout ce qui fait vivre le LAB'IA Loire Valley au quotidien.</p>
        </div>
    </div>
</div>

<section>
    <div class="container">
        <?php
        $posts = new WP_Query( array(
            'post_type'      => 'post',
            'posts_per_page' => 12,
            'paged'          => max( 1, get_query_var( 'paged' ) ),
        ) );

        if ( $posts->have_posts() ) :
        ?>
            <div class="grid-3">
                <?php while ( $posts->have_posts() ) : $posts->the_post();
                    $cats = get_the_category();
                    $cat_name = $cats ? $cats[0]->name : 'Article';
                ?>
                    <a href="<?php the_permalink(); ?>" class="actu-card reveal" style="text-decoration:none;color:inherit;">
                        <div class="actu-card__img">
                            <?php if ( has_post_thumbnail() ) : ?>
                                <?php the_post_thumbnail( 'medium' ); ?>
                            <?php else : ?>
                                <span style="position:relative;z-index:1;">📰</span>
                            <?php endif; ?>
                        </div>
                        <div class="actu-card__body">
                            <span class="badge badge-dark" style="align-self:flex-start;margin-bottom:4px;"><?php echo esc_html( $cat_name ); ?></span>
                            <div class="actu-card__date"><?php echo esc_html( get_the_date() ); ?></div>
                            <div class="actu-card__title"><?php the_title(); ?></div>
                            <p class="actu-card__excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 25 ) ); ?></p>
                            <div class="actu-card__footer">
                                <span class="actu-card__cat"><?php echo esc_html( $cat_name ); ?></span>
                                <span class="btn btn-sm btn-outline">Lire<svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 8h10M9 4l4 4-4 4"/></svg></span>
                            </div>
                        </div>
                    </a>
                <?php endwhile; wp_reset_postdata(); ?>
            </div>
        <?php else : ?>
            <div class="text-center" style="padding:60px 0;">
                <p class="t-body text-muted">Aucun article publié pour le moment.</p>
                <?php if ( current_user_can( 'edit_posts' ) ) : ?>
                    <a href="<?php echo esc_url( admin_url( 'post-new.php' ) ); ?>" class="btn btn-primary mt-16">Publier le premier article</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<section class="ctx-dark s-sm">
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
