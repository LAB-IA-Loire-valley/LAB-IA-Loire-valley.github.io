<?php
/**
 * Template Name: Presse
 * 1-to-1 port of presse.html
 */

get_header();
?>


<div class="page-hero" id="main-content">
  <div class="container">
    <div class="page-hero__inner">
      <div class="section-label" style="margin-bottom:16px;"><span style="color:rgba(255,255,255,.4);">On parle de nous</span></div>
      <h1 class="t-display page-hero__title">Presse</h1>
      <p class="page-hero__lead t-lead">Articles, vidéos, podcasts, interviews : la présence médiatique du LAB'IA Loire Valley depuis 2021.</p>
    </div>
  </div>
</div>

<section>
  <div class="container">

    <!-- Highlight médias vidéo/podcast -->
    <div class="media-highlight reveal">
      <div>
        <span class="badge" style="background:rgba(226,0,125,.2);color:var(--magenta-light);margin-bottom:20px;">🎙️ À écouter &amp; regarder</span>
        <div class="media-highlight__title">Frédéric Ros &amp; Corinne Neau dans les médias</div>
        <div class="media-highlight__desc">Retrouvez les interventions de nos dirigeants sur France 3, France Bleu, VoxRadio, Chérie FM Tours et plus encore, pour comprendre les enjeux de l'IA en région Centre-Val de Loire.</div>
      </div>
      <div class="media-embeds">
        <div class="media-embed-item">
          <span class="press-item__type-icon">📺</span>
          <div><strong>France 3 Centre-Val de Loire</strong><br/><span>IA, le grand bouleversement · Février 2025</span></div>
        </div>
        <div class="media-embed-item">
          <span class="press-item__type-icon">🎙️</span>
          <div><strong>France Bleu · Podcast IA</strong><br/><span>Opportunités et défis de l'IA en région</span></div>
        </div>
        <div class="media-embed-item">
          <span class="press-item__type-icon">📻</span>
          <div><strong>VoxRadio · Interview</strong><br/><span>Vision de l'IA par Frédéric Ros · Janvier 2024</span></div>
        </div>
        <div class="media-embed-item">
          <span class="press-item__type-icon">📻</span>
          <div><strong>Chérie FM Tours</strong><br/><span>L'IA dans notre quotidien · Novembre 2023</span></div>
        </div>
      </div>
    </div>

    <!-- Filtres -->
    <?php
    $filter_terms = get_terms( array( 'taxonomy' => 'press_type', 'hide_empty' => true ) );
    $filter_labels = array(
        'article'  => '📰 Articles',
        'video'    => '📺 Vidéo / TV',
        'radio'    => '🎙️ Podcasts / Radio',
        'magazine' => '📕 Magazines',
    );
    ?>
    <div class="media-type-filter reveal">
      <button class="media-type-btn active" data-type="all">Tous</button>
      <?php foreach ( $filter_terms as $ft ) :
          $label = isset( $filter_labels[ $ft->slug ] ) ? $filter_labels[ $ft->slug ] : $ft->name;
      ?>
      <button class="media-type-btn" data-type="<?php echo esc_attr( $ft->slug ); ?>"><?php echo esc_html( $label ); ?></button>
      <?php endforeach; ?>
    </div>

    <!-- Timeline presse -->
    <?php
    $articles = labia_get_press_articles();
    if ( $articles ) :
        $by_year = array();
        foreach ( $articles as $a ) {
            $d = get_post_meta( $a->ID, 'pub_date', true );
            $y = $d ? date( 'Y', $d ) : 'Sans date';
            $by_year[ $y ][] = $a;
        }
        krsort( $by_year );
    ?>
    <div class="press-timeline" id="press-timeline">
        <?php foreach ( $by_year as $year => $items ) : ?>
        <div class="press-year-group reveal">
            <div class="press-year"><?php echo esc_html( $year ); ?></div>
            <div class="press-items">
                <?php foreach ( $items as $a ) :
                    $date    = get_post_meta( $a->ID, 'pub_date', true );
                    $source  = get_post_meta( $a->ID, 'source', true );
                    $url     = get_post_meta( $a->ID, 'article_url', true );
                    $excerpt = get_post_meta( $a->ID, 'excerpt', true );
                    $type    = wp_get_post_terms( $a->ID, 'press_type', array( 'fields' => 'slugs' ) );
                    $type_slug = ! empty( $type ) ? $type[0] : 'article';
                    $type_name = ! empty( $type ) ? $type[0] : 'article';
                    $type_icon = '📰';
                    if ( $type_slug === 'radio' ) $type_icon = '🎙️';
                    elseif ( $type_slug === 'video' ) $type_icon = '🎬';
                    elseif ( $type_slug === 'web' ) $type_icon = '🌐';
                    elseif ( $type_slug === 'magazine' ) $type_icon = '📕';
                ?>
                <div class="press-item" data-type="<?php echo esc_attr( $type_slug ); ?>">
                    <div>
                        <div class="press-item__date"><?php echo absint( $date ) ? date( 'd M Y', absint( $date ) ) : 'Sans date'; ?></div>
                        <div class="press-item__source"><span class="press-item__type-icon"><?php echo esc_html( $type_icon ); ?></span> <?php echo esc_html( $source ); ?></div>
                    </div>
                    <div>
                        <div class="press-item__title"><?php echo esc_html( $a->post_title ); ?></div>
                        <?php if ( $excerpt ) : ?><p class="press-item__excerpt"><?php echo esc_html( $excerpt ); ?></p><?php endif; ?>
                    </div>
                    <?php if ( $url ) : ?><a href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener" class="btn btn-sm btn-outline">Lire</a><?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php else : ?>
    <p class="text-muted">Aucun article de presse pour le moment.</p>
    <?php endif; ?>
  </div>
</section>

<!-- Contact presse -->
<section class="ctx-violet s-sm">
  <div class="container" style="text-align:center;">
    <h2 class="t-h2 reveal mb-16" style="color:white;">Contact presse</h2>
    <p class="reveal reveal-delay-1" style="color:rgba(255,255,255,.5); margin-bottom:32px; max-width:480px; margin-left:auto; margin-right:auto;">Pour toute demande d'interview, d'information ou de visuels, contactez directement notre équipe.</p>
    <div style="display:flex;gap:16px;justify-content:center;flex-wrap:wrap;" class="reveal reveal-delay-2">
      <a href="mailto:<?php echo esc_attr( labia_opt( 'email', 'contact@labia-loirevalley.fr' ) ); ?>" class="btn btn-primary">✉ contact@labia-loirevalley.fr</a>
      <a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', labia_opt( 'phone', '02 38 69 80 24' ) ) ); ?>" class="btn btn-outline-white">📞 <?php echo esc_html( labia_opt( 'phone', '02 38 69 80 24' ) ); ?></a>
    </div>
  </div>
</section>


<?php get_footer(); ?>
