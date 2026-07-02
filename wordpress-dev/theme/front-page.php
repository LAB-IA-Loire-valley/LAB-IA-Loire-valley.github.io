<?php
/**
 * Front Page template
 */

get_header();
?>

<?php get_template_part( 'template-parts/section-hero' ); ?>

<?php get_template_part( 'template-parts/section-stats' ); ?>

<!-- Notre Offre -->
<section>
    <div class="container">
        <div class="section-label reveal"><span>Notre offre</span></div>
        <div style="display:grid; grid-template-columns: 1fr 1fr; gap: 16px; align-items: end; margin-bottom: 64px;">
            <h2 class="t-h1 reveal">Des prestations<br/>sur-mesure pour<br/>concrétiser l'IA.</h2>
            <div class="reveal reveal-delay-2">
                <p class="t-lead" style="margin-bottom:28px;">Formations spécialisées, accompagnement technique, sensibilisation stratégique : nous intervenons à chaque étape de votre transformation IA.</p>
                <a href="<?php echo esc_url( home_url( '/notre-offre/' ) ); ?>" class="btn btn-outline">Voir toute l'offre
                    <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 8h10M9 4l4 4-4 4"/></svg>
                </a>
            </div>
        </div>

        <div class="grid-4">
            <div class="card card--service accent-blue reveal">
                <div class="card-icon accent-blue"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 014.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15.3M14.25 3.104c.251.023.501.05.75.082M19.8 15.3l-1.57.393A9.065 9.065 0 0112 15a9.065 9.065 0 00-6.23-.693L5 14.5m14.8.8l1.402 1.402c1 1 .03 2.798-1.4 2.798H4.2c-1.43 0-2.4-1.798-1.4-2.798L4.2 15.3"/></svg></div>
                <h3 class="t-h3">Accompagnement &amp; Prototypage</h3>
                <p class="t-body text-muted">De l'idée au déploiement : diagnostic, maquettage, développement éco-responsable, tests et mise en production avec nos Data Scientists.</p>
                <a href="<?php echo esc_url( home_url( '/notre-offre/' ) ); ?>#accompagnement" class="btn btn-sm btn-outline" style="align-self:flex-start; margin-top:auto">En savoir plus<svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 8h10M9 4l4 4-4 4"/></svg></a>
            </div>

            <div class="card card--service accent-indigo reveal reveal-delay-1">
                <div class="card-icon accent-indigo"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5"/></svg></div>
                <h3 class="t-h3">Formations &amp; Ateliers</h3>
                <p class="t-body text-muted">Python, IA générative, Data Science, MLOps… Des parcours certifiés QUALIOPI ou sur-mesure pour faire monter vos équipes en compétences.</p>
                <a href="<?php echo esc_url( home_url( '/notre-offre/' ) ); ?>#formations" class="btn btn-sm btn-outline" style="align-self:flex-start; margin-top:auto">Voir le catalogue<svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 8h10M9 4l4 4-4 4"/></svg></a>
            </div>

            <div class="card card--service accent-violet reveal reveal-delay-2">
                <div class="card-icon accent-violet"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z"/></svg></div>
                <h3 class="t-h3">Sensibilisation &amp; Conférences</h3>
                <p class="t-body text-muted">Démystifier la Data et l'IA, éveiller les consciences, initier les premiers usages. Formats adaptés : conférence, atelier ½ journée, masterclass.</p>
                <a href="<?php echo esc_url( home_url( '/notre-offre/' ) ); ?>#sensibilisation" class="btn btn-sm btn-outline" style="align-self:flex-start; margin-top:auto">En savoir plus<svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 8h10M9 4l4 4-4 4"/></svg></a>
            </div>

            <div class="card card--service reveal reveal-delay-3">
                <div class="card-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z"/></svg></div>
                <h3 class="t-h3">Conseil &amp; Gouvernance IA</h3>
                <p class="t-body text-muted">Charte IA co-construite, diagnostic de maturité, accompagnement à la présentation CSE — structurez votre politique IA avant de déployer.</p>
                <a href="<?php echo esc_url( home_url( '/notre-offre/' ) ); ?>#conseil-gouvernance" class="btn btn-sm btn-outline" style="align-self:flex-start; margin-top:auto">En savoir plus<svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 8h10M9 4l4 4-4 4"/></svg></a>
            </div>
        </div>
    </div>
</section>

<!-- Nos Solutions (3 cards from CPT) -->
<section style="background: linear-gradient(180deg, var(--offwhite) 0%, var(--white) 100%);">
    <div class="container">
        <div class="section-label reveal"><span>Nos solutions</span></div>
        <div style="display:flex; align-items:flex-end; justify-content:space-between; gap:32px; margin-bottom:56px; flex-wrap:wrap;">
            <h2 class="t-h1 reveal" style="max-width:520px;">Des solutions IA<br/>prêtes à déployer.</h2>
            <a href="<?php echo esc_url( home_url( '/nos-solutions/' ) ); ?>" class="btn btn-outline reveal reveal-delay-2">Toutes nos solutions
                <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 8h10M9 4l4 4-4 4"/></svg>
            </a>
        </div>
        <div class="grid-3">
            <?php
            $solutions = labia_get_solutions( true );
            if ( $solutions ) :
                foreach ( $solutions as $post ) :
                    setup_postdata( $post );
                    $tags_raw = get_post_meta( $post->ID, 'tags', true );
                    $tags_lines = $tags_raw ? array_filter( array_map( 'trim', explode( "\n", $tags_raw ) ) ) : array();
                    $anchor = get_post_meta( $post->ID, 'anchor_slug', true ) ?: sanitize_title( $post->post_title );
                    $bg = get_post_meta( $post->ID, 'hero_bg', true ) ?: 'linear-gradient(135deg,#0D0D0D,#0a1a1a)';
                    $emoji = get_post_meta( $post->ID, 'emoji', true ) ?: '🤖';
                    ?>
                    <a href="<?php echo esc_url( home_url( '/nos-solutions/#' . $anchor ) ); ?>" class="card card--solution reveal" style="text-decoration:none; color:inherit;">
                        <div class="card-img">
                            <div class="card-img-inner" style="background:<?php echo esc_attr( $bg ); ?>;">
                                <span style="font-size:2.5rem;"><?php echo esc_html( $emoji ); ?></span>
                            </div>
                        </div>
                        <div>
                            <div class="card-tags">
                                <?php foreach ( $tags_lines as $tag_line ) :
                                    list( $label, $color ) = array_pad( explode( ':', $tag_line, 2 ), 2, '#000' ); ?>
                                    <span class="badge" style="background:<?php echo esc_attr( $color ); ?>;color:white;"><?php echo esc_html( $label ); ?></span>
                                <?php endforeach; ?>
                            </div>
                            <h3 class="t-h3 mt-12 mb-8"><?php echo esc_html( $post->post_title ); ?></h3>
                            <p class="t-body text-muted"><?php echo esc_html( wp_trim_words( $post->post_content, 25 ) ); ?></p>
                        </div>
                    </a>
                <?php endforeach; wp_reset_postdata();
            else : ?>
                <p class="text-muted">Aucune solution marquée "Afficher sur l'accueil" pour le moment. <a href="<?php echo esc_url( admin_url( 'post-new.php?post_type=solution' ) ); ?>">Ajouter une solution</a></p>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Méthode -->
<section>
    <div class="container">
        <div style="text-align:center; margin-bottom:64px;">
            <div class="section-label reveal" style="justify-content:center;"><span>Notre méthode</span></div>
            <h2 class="t-h1 reveal mt-16">6 étapes pour un projet réussi</h2>
        </div>
        <div class="grid-3" style="gap:32px;">
            <?php
            $steps = array(
                array( '01', 'Cadrage',            "Définition du besoin, des objectifs et du périmètre du projet." ),
                array( '02', 'Diagnostic',         "État des lieux data, identification des cas d'usage à fort impact." ),
                array( '03', 'Prototypage',        "Développement d'un POC rapide pour valider la faisabilité." ),
                array( '04', 'Expérimentation',   'Tests en conditions réelles, itérations et ajustements.' ),
                array( '05', 'Industrialisation', 'Mise en production, monitoring, sécurisation et formation.' ),
                array( '06', 'Suivi',              'Accompagnement continu, mesure des KPIs et amélioration.' ),
            );
            foreach ( $steps as $i => $step ) : ?>
                <div class="card reveal<?php echo $i ? ' reveal-delay-' . $i : ''; ?>" style="text-align:left; padding:32px;">
                    <div style="font-family:var(--font-display); font-size:1.5rem; font-weight:800; color:var(--magenta); margin-bottom:12px;"><?php echo esc_html( $step[0] ); ?></div>
                    <h3 class="t-h3 mb-12"><?php echo esc_html( $step[1] ); ?></h3>
                    <p class="t-body text-muted"><?php echo esc_html( $step[2] ); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Témoignages -->
<section style="background:var(--offwhite);">
    <div class="container">
        <div class="section-label reveal"><span>Témoignages</span></div>
        <h2 class="t-h1 reveal mt-16 mb-48">Ils nous font confiance.</h2>
        <div class="grid-3">
            <?php
            $testimonials = labia_get_testimonials( 3, true );
            if ( $testimonials ) :
                foreach ( $testimonials as $post ) :
                    setup_postdata( $post );
                    $quote = get_post_meta( $post->ID, 'quote', true );
                    $author = get_post_meta( $post->ID, 'author', true );
                    $company = get_post_meta( $post->ID, 'company', true );
                    ?>
                    <div class="card reveal" style="text-align:left; padding:32px;">
                        <div class="t-body text-muted" style="font-style:italic; line-height:1.8;">"<?php echo esc_html( wp_trim_words( $quote, 30 ) ); ?>"</div>
                        <div style="margin-top:16px; padding-top:16px; border-top:1px solid var(--border);">
                            <div class="t-body" style="font-weight:700;"><?php echo esc_html( $author ); ?></div>
                            <div class="t-small text-muted"><?php echo esc_html( $company ); ?></div>
                        </div>
                    </div>
                <?php endforeach; wp_reset_postdata();
            else : ?>
                <p class="text-muted">Aucun témoignage à afficher pour le moment.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php
$cta_title = 'Rejoignez nos références';
$cta_lead  = 'Pré-diagnostic offert. Parlons de votre projet Data & IA.';
$cta_btn_text = 'Nous contacter';
$cta_btn_url  = home_url( '/contact/' );
get_template_part( 'template-parts/section-cta' );
?>

<?php get_footer(); ?>
