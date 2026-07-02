<?php
/**
 * Template Name: Presse
 *
 * Press articles are loaded from the press_article CPT, grouped by year.
 */

get_header();
?>

<div class="page-hero" id="main-content">
    <div class="container">
        <div class="page-hero__inner">
            <div class="section-label" style="margin-bottom:16px;"><span style="color:rgba(255,255,255,.4);">On parle de nous</span></div>
            <h1 class="t-display page-hero__title">Presse</h1>
            <p class="page-hero__lead t-lead">Articles, vidéos, podcasts, interviews — la présence médiatique du LAB'IA Loire Valley depuis 2021.</p>
        </div>
    </div>
</div>

<section>
    <div class="container">
        <?php
        $articles = labia_get_press_articles();
        if ( $articles ) :
            // Group by year
            $by_year = array();
            foreach ( $articles as $article ) {
                $date = get_post_meta( $article->ID, 'pub_date', true );
                $year = $date ? date( 'Y', $date ) : '—';
                if ( ! isset( $by_year[ $year ] ) ) {
                    $by_year[ $year ] = array();
                }
                $by_year[ $year ][] = $article;
            }
            krsort( $by_year );
        ?>
            <div class="press-timeline">
                <?php foreach ( $by_year as $year => $items ) : ?>
                    <div class="press-year-group">
                        <div class="press-year reveal"><?php echo esc_html( $year ); ?></div>
                        <div class="press-items">
                            <?php foreach ( $items as $article ) :
                                $date    = get_post_meta( $article->ID, 'pub_date', true );
                                $source  = get_post_meta( $article->ID, 'source', true );
                                $url     = get_post_meta( $article->ID, 'article_url', true );
                                $excerpt = get_post_meta( $article->ID, 'excerpt', true );
                                $type    = wp_get_post_terms( $article->ID, 'press_type', array( 'fields' => 'names' ) );
                                $type_icon = '📰';
                                if ( ! empty( $type ) ) {
                                    $first_type = strtolower( $type[0] );
                                    if ( $first_type === 'radio' ) $type_icon = '🎙️';
                                    elseif ( $first_type === 'vidéo' || $first_type === 'video' ) $type_icon = '🎬';
                                    elseif ( $first_type === 'web' ) $type_icon = '🌐';
                                }
                            ?>
                                <div class="press-item reveal">
                                    <div class="press-item__date"><?php echo esc_html( $date ? date( 'd M Y', $date ) : '—' ); ?></div>
                                    <div>
                                        <div class="press-item__title"><?php echo esc_html( $article->post_title ); ?></div>
                                        <?php if ( $source || $type ) : ?>
                                            <div class="press-item__source">
                                                <span class="press-item__type-icon"><?php echo esc_html( $type_icon ); ?></span>
                                                <?php echo esc_html( $source ); ?>
                                                <?php if ( $type ) : ?>
                                                    <span>·</span>
                                                    <?php echo esc_html( implode( ', ', $type ) ); ?>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>
                                        <?php if ( $excerpt ) : ?>
                                            <div class="press-item__excerpt"><?php echo esc_html( $excerpt ); ?></div>
                                        <?php endif; ?>
                                    </div>
                                    <?php if ( $url ) : ?>
                                        <a href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener" class="btn btn-sm btn-outline">Lire<svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 8h10M9 4l4 4-4 4"/></svg></a>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else : ?>
            <p class="text-muted">Aucun article de presse enregistré pour le moment. <a href="<?php echo esc_url( admin_url( 'post-new.php?post_type=press_article' ) ); ?>">Ajouter un article</a></p>
        <?php endif; ?>
    </div>
</section>

<?php
set_query_var( 'cta_title', "Contact presse" );
set_query_var( 'cta_lead', "Pour toute demande média, interview ou partenariat presse, contactez-nous." );
set_query_var( 'cta_btn_text', 'Contact presse' );
set_query_var( 'cta_btn_url', home_url( '/contact/?objet=presse' ) );
get_template_part( 'template-parts/section-cta' );
?>

<?php get_footer(); ?>
