<?php
/**
 * Template Name: Qui sommes-nous
 *
 * Team members are loaded dynamically from the team_member CPT,
 * grouped by team_pole taxonomy.
 */

get_header();
?>

<div class="page-hero" id="main-content">
    <div class="container">
        <div class="page-hero__inner">
            <div class="section-label" style="margin-bottom:16px;"><span style="color:rgba(255,255,255,.4);">Notre histoire</span></div>
            <h1 class="t-display page-hero__title">Qui sommes-nous</h1>
            <p class="page-hero__lead t-lead">Un projet né en 2021 au sein de la Technopole d'Orléans, avec une mission claire : démocratiser et simplifier l'usage de l'IA pour toutes les entreprises de la région.</p>
        </div>
    </div>
</div>

<!-- Mission -->
<section>
    <div class="container">
        <div class="grid-2" style="gap:80px; align-items:center;">
            <div>
                <div class="section-label reveal"><span>Notre mission</span></div>
                <h2 class="t-h1 reveal mt-16 mb-24">Un centre de ressources partagées autour de la donnée</h2>
                <p class="t-lead reveal reveal-delay-1">Le LAB'IA Loire Valley a pour but d'<strong>informer</strong>, de <strong>conseiller</strong> et de <strong>guider</strong> les entreprises et structures de la région Centre-Val de Loire afin qu'elles puissent imaginer, explorer et prototyper des solutions IA à coût réduit et en temps raisonnable.</p>
                <div style="margin-top:40px; display:flex;flex-direction:column;gap:12px;" class="reveal reveal-delay-2">
                    <div style="display:flex;gap:12px;align-items:center;padding:16px;background:var(--offwhite);border-radius:var(--radius-md);">
                        <span style="color:var(--magenta);font-weight:700;flex-shrink:0;">→</span>
                        <span class="t-body">Entreprises et structures de la région Centre-Val de Loire</span>
                    </div>
                    <div style="display:flex;gap:12px;align-items:center;padding:16px;background:var(--offwhite);border-radius:var(--radius-md);">
                        <span style="color:var(--magenta);font-weight:700;flex-shrink:0;">→</span>
                        <span class="t-body">Solutions IA à coût réduit et en temps raisonnable</span>
                    </div>
                    <div style="display:flex;gap:12px;align-items:center;padding:16px;background:var(--offwhite);border-radius:var(--radius-md);">
                        <span style="color:var(--magenta);font-weight:700;flex-shrink:0;">→</span>
                        <span class="t-body">De l'idée jusqu'à l'industrialisation — une approche structurée en 6 étapes</span>
                    </div>
                </div>
            </div>
            <div class="reveal reveal-delay-1">
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                    <div class="chiffre-block"><div class="chiffre-number">2021</div><div class="chiffre-label">Année de fondation au LAB'O d'Orléans</div></div>
                    <div class="chiffre-block"><div class="chiffre-number">38%</div><div class="chiffre-label">De productivité gagnée grâce à l'IA d'ici 2035</div></div>
                    <div class="chiffre-block"><div class="chiffre-number">1950</div><div class="chiffre-label">L'année fondatrice de l'IA — test de Turing</div></div>
                    <div class="chiffre-block" style="background:var(--magenta);"><div class="chiffre-number" style="color:white;">+100</div><div class="chiffre-label" style="color:rgba(255,255,255,.7);">Structures accompagnées en région</div></div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Équipe -->
<section style="background:var(--offwhite);">
    <div class="container">
        <div class="section-label reveal"><span>L'équipe</span></div>
        <h2 class="t-h2 reveal mt-16 mb-12">Notre équipe opérationnelle</h2>
        <p class="t-lead reveal reveal-delay-1 mb-48" style="max-width:560px;">Notre mission : démocratiser et simplifier l'usage de l'IA pour tous nos clients.</p>

        <?php
        $poles = array(
            'pole-operationnel'      => 'Pôle opérationnel',
            'pole-technique'         => 'Pôle technique — Data Scientists',
            'reseau-experts'         => 'Réseau d\'experts — Data Scientists partenaires',
            'equipe-technopolitaine' => 'Équipe Technopolitaine — en support',
        );

        $grids = array(
            'pole-operationnel'      => 'grid-3',
            'pole-technique'         => 'grid-3',
            'reseau-experts'         => 'grid-2',
            'equipe-technopolitaine' => 'grid-4',
        );

        foreach ( $poles as $slug => $label ) :
            $members = labia_get_team_members( $slug );
            if ( empty( $members ) ) continue;
        ?>
            <div class="team-section-title reveal"><?php echo esc_html( $label ); ?></div>
            <div class="<?php echo esc_attr( $grids[ $slug ] ); ?> mb-48">
                <?php foreach ( $members as $member ) :
                    $photo_id       = get_post_meta( $member->ID, 'photo', true );
                    $role           = get_post_meta( $member->ID, 'role', true );
                    $bio            = get_post_meta( $member->ID, 'bio', true );
                    $initials       = get_post_meta( $member->ID, 'initials', true );
                    $initials_bg    = get_post_meta( $member->ID, 'initials_bg', true );
                    $initials_color = get_post_meta( $member->ID, 'initials_color', true );
                    $photo_url      = $photo_id ? wp_get_attachment_url( $photo_id ) : '';
                    $is_horizontal = ( $slug === 'reseau-experts' );
                ?>
                    <div class="card card--team reveal<?php echo $is_horizontal ? '' : ''; ?>" style="<?php echo $is_horizontal ? 'text-align:left;flex-direction:row;gap:20px;align-items:flex-start;' : ''; ?>">
                        <div class="card--team-photo"<?php echo $photo_url ? '' : ( $initials_bg ? ' style="background:' . esc_attr( $initials_bg ) . ( $is_horizontal ? ';flex-shrink:0;' : ';' ) . '"' : ( $is_horizontal ? ' style="flex-shrink:0;"' : '' ) ); ?>>
                            <?php if ( $photo_url ) : ?>
                                <img src="<?php echo esc_url( $photo_url ); ?>" alt="<?php echo esc_attr( $member->post_title ); ?>" />
                            <?php else : ?>
                                <span<?php echo $initials_color ? ' style="color:' . esc_attr( $initials_color ) . ';"' : ''; ?>><?php echo esc_html( $initials ); ?></span>
                            <?php endif; ?>
                        </div>
                        <div>
                            <?php if ( $role ) : ?><div class="card--team-role"><?php echo esc_html( $role ); ?></div><?php endif; ?>
                            <div class="card--team-name"><?php echo esc_html( $member->post_title ); ?></div>
                            <?php if ( $bio ) : ?><p class="card--team-bio"><?php echo esc_html( $bio ); ?></p><?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- Consortiums -->
<section>
    <div class="container">
        <div class="section-label reveal"><span>Nos consortiums</span></div>
        <h2 class="t-h2 reveal mt-16 mb-48">Les consortiums dont nous faisons partie</h2>
        <div class="grid-2">
            <div class="consortium-card reveal">
                <div>
                    <span class="badge badge-blue mb-12">Loire Valley Data Hub</span>
                    <h3 class="t-h3">Loire Valley Data Hub</h3>
                    <p style="font-size:.88rem;color:var(--ink-60);margin-top:4px;">Piloté par DEV'UP Centre-Val de Loire</p>
                </div>
                <p class="t-body text-muted">Accompagnement des entreprises et collectivités dans leurs projets de transformation numérique : collecte, sécurisation et valorisation de la data par les technologies IA, HPC, cybersécurité, IoT et blockchain.</p>
                <p class="t-body text-muted">Soutient les filières prioritaires de la région : Cosmétique, Santé, Environnement et Agriculture.</p>
                <a href="https://www.devup-centrevaldeloire.fr/actualites/accelerez-votre-transition-numerique-avec-le-loire-valley-data-hub/" target="_blank" rel="noopener" class="btn btn-sm btn-outline" style="align-self:flex-start;">Évaluer ma maturité numérique<svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 8h10M9 4l4 4-4 4"/></svg></a>
            </div>
            <div class="consortium-card reveal reveal-delay-1">
                <div>
                    <span class="badge" style="background:#f0fff4;color:#22863a;" class="mb-12">PrevizO</span>
                    <h3 class="t-h3">Consortium PrevizO</h3>
                    <p style="font-size:.88rem;color:var(--ink-60);margin-top:4px;">Région Centre-Val de Loire · Climate Data Hub</p>
                </div>
                <p class="t-body text-muted">Démonstrateurs d'IA frugale au service de la transition écologique. Solution innovante pour anticiper les périodes de stress hydrique et mieux préserver nos ressources en eau.</p>
                <div style="font-size:.82rem;color:var(--ink-60);line-height:1.6;">
                    <strong>Partenaires :</strong> Antea Group · BRGM · SMO Val de Loire Numérique · Le Nouvel Espace du Cher · Tours Métropole · Laboratoire PRISME
                </div>
                <a href="https://www.tech-orleans.fr/le-labia-loire-valley-membre-actif-du-consortium-du-loire-valley-data-hub/" target="_blank" rel="noopener" class="btn btn-sm btn-outline" style="align-self:flex-start;">En savoir plus<svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 8h10M9 4l4 4-4 4"/></svg></a>
            </div>
        </div>
    </div>
</section>

<!-- Localisation -->
<section style="background:var(--offwhite);">
    <div class="container">
        <div class="section-label reveal mb-32"><span>Nous trouver</span></div>
        <div class="map-block reveal">
            <div class="map-pin">📍</div>
            <div>
                <h3 class="t-h2 mb-16" style="color:white;">LAB'IA Loire Valley</h3>
                <p style="font-size:1rem;color:rgba(255,255,255,.6);line-height:1.8;margin-bottom:24px;">
                    <?php echo esc_html( labia_opt( 'address_line_1' ) ); ?><br/>
                    <?php echo esc_html( labia_opt( 'address_line_2' ) ); ?><br/>
                    <strong style="color:rgba(255,255,255,.9);"><?php echo esc_html( labia_opt( 'address_city' ) ); ?></strong>
                </p>
                <div style="display:flex;gap:20px;flex-wrap:wrap;">
                    <a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', labia_opt( 'phone' ) ) ); ?>" class="btn btn-outline-white btn-sm">📞 <?php echo esc_html( labia_opt( 'phone' ) ); ?></a>
                    <a href="mailto:<?php echo esc_attr( labia_opt( 'email' ) ); ?>" class="btn btn-outline-white btn-sm">✉ <?php echo esc_html( labia_opt( 'email' ) ); ?></a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<?php
set_query_var( 'cta_title', "Rejoignez l'aventure IA en région" );
set_query_var( 'cta_lead', "Que vous soyez entreprise, institution ou expert — le LAB'IA est fait pour collaborer." );
set_query_var( 'cta_btn_text', 'Nous contacter' );
set_query_var( 'cta_btn_url', home_url( '/contact/' ) );
get_template_part( 'template-parts/section-cta' );
?>

<?php get_footer(); ?>
