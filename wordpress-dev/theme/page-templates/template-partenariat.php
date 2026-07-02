<?php
/**
 * Template Name: Partenariat
 */

get_header();
?>

<div class="page-hero" id="main-content">
    <div class="container">
        <div class="page-hero__inner">
            <div class="section-label" style="margin-bottom:16px;"><span style="color:rgba(255,255,255,.4);">Écosystème</span></div>
            <h1 class="t-display page-hero__title">Partenariat</h1>
            <p class="page-hero__lead t-lead">Le LAB'IA travaille avec tout l'écosystème régional : chercheurs, experts, ESN, institutions et associations. Construisons l'IA de demain ensemble.</p>
        </div>
    </div>
</div>

<!-- Pourquoi devenir partenaire -->
<section>
    <div class="container">
        <div class="section-label reveal"><span>Pourquoi nous rejoindre</span></div>
        <div class="grid-2" style="gap:80px; align-items:center; margin-top:32px;">
            <div>
                <h2 class="t-h1 reveal mb-24">Complémentarité des écosystèmes &amp; richesse du numérique en région</h2>
                <p class="t-lead reveal reveal-delay-1">Signer un accord de partenariat avec le LAB'IA, c'est rejoindre un réseau d'acteurs engagés pour le développement de l'IA en Centre-Val de Loire, augmenter votre deal flow et participer à l'industrialisation de solutions à impact.</p>
                <div style="margin-top:40px;" class="reveal reveal-delay-2">
                    <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>?objet=partenariat" class="btn btn-primary btn-lg">Devenir partenaire
                        <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 8h10M9 4l4 4-4 4"/></svg>
                    </a>
                </div>
            </div>
            <div class="grid-2 reveal reveal-delay-1">
                <div class="benefit-card">
                    <div class="benefit-number">01</div>
                    <h4 class="t-h4">Rôle actif</h4>
                    <p class="t-body text-muted">Participez à l'industrialisation des solutions IA développées avec nos clients.</p>
                </div>
                <div class="benefit-card">
                    <div class="benefit-number">02</div>
                    <h4 class="t-h4">Deal flow</h4>
                    <p class="t-body text-muted">Augmentez votre flux de clients IA grâce au réseau et à la visibilité du LAB'IA en région.</p>
                </div>
                <div class="benefit-card">
                    <div class="benefit-number">03</div>
                    <h4 class="t-h4">Visibilité</h4>
                    <p class="t-body text-muted">Apparaissez sur nos supports de communication et lors de nos événements.</p>
                </div>
                <div class="benefit-card">
                    <div class="benefit-number">04</div>
                    <h4 class="t-h4">Impact régional</h4>
                    <p class="t-body text-muted">Contribuez à l'essor de l'IA responsable en Centre-Val de Loire.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Profils partenaires -->
<section style="background:var(--offwhite);">
    <div class="container">
        <div class="section-label reveal"><span>Pour qui ?</span></div>
        <h2 class="t-h2 reveal mt-16 mb-48">Les profils qui nous rejoignent</h2>
        <div class="grid-3">
            <div class="card reveal" style="padding:32px;">
                <div style="font-size:2rem;margin-bottom:12px;">🎓</div>
                <h4 class="t-h4">Écoles &amp; Universités</h4>
                <p class="t-body text-muted">Masterclass, interventions pédagogiques, projets étudiants, stages et alternances.</p>
            </div>
            <div class="card reveal reveal-delay-1" style="padding:32px;">
                <div style="font-size:2rem;margin-bottom:12px;">💼</div>
                <h4 class="t-h4">ESN &amp; Cabinets</h4>
                <p class="t-body text-muted">Co-développement de solutions IA, montée en compétences des consultants, partage de missions.</p>
            </div>
            <div class="card reveal reveal-delay-2" style="padding:32px;">
                <div style="font-size:2rem;margin-bottom:12px;">🔬</div>
                <h4 class="t-h4">Chercheurs &amp; Labs</h4>
                <p class="t-body text-muted">Accès aux cas d'usage terrain, collaboration R&amp;D, publications communes.</p>
            </div>
            <div class="card reveal" style="padding:32px;">
                <div style="font-size:2rem;margin-bottom:12px;">🏛️</div>
                <h4 class="t-h4">Institutions &amp; Collectivités</h4>
                <p class="t-body text-muted">Dispositifs d'accompagnement, événements, représentation dans l'écosystème régional.</p>
            </div>
            <div class="card reveal reveal-delay-1" style="padding:32px;">
                <div style="font-size:2rem;margin-bottom:12px;">🤝</div>
                <h4 class="t-h4">Réseaux &amp; Clusters</h4>
                <p class="t-body text-muted">Mise en relation, événements conjoints, communication croisée.</p>
            </div>
            <div class="card reveal reveal-delay-2" style="padding:32px;">
                <div style="font-size:2rem;margin-bottom:12px;">🚀</div>
                <h4 class="t-h4">Startups IA</h4>
                <p class="t-body text-muted">Visibilité, accès au terrain, accompagnement technique et commercial.</p>
            </div>
        </div>
    </div>
</section>

<?php
set_query_var( 'cta_title', 'Devenons partenaires' );
set_query_var( 'cta_lead', "Rejoignez un réseau d'acteurs engagés pour l'IA responsable en Centre-Val de Loire." );
set_query_var( 'cta_btn_text', 'Devenir partenaire' );
set_query_var( 'cta_btn_url', home_url( '/contact/?objet=partenariat' ) );
get_template_part( 'template-parts/section-cta' );
?>

<?php get_footer(); ?>
