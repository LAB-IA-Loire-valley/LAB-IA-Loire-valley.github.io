<?php
/**
 * Template Name: Qui sommes-nous
 * 1-to-1 port of qui-sommes-nous.html
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

<!-- ── Mission ─────────────────────────────────────────────── -->
<section>
  <div class="container">
    <div class="grid-2" style="gap:80px; align-items:center;">
      <div>
        <div class="section-label reveal"><span>Notre mission</span></div>
        <h2 class="t-h1 reveal mt-16 mb-24">Un centre de ressources partagées autour de la donnée</h2>
        <p class="t-lead reveal reveal-delay-1">
          Le LAB'IA Loire Valley a pour but d'<strong>informer</strong>, de <strong>conseiller</strong>
          et de <strong>guider</strong> les entreprises et structures de la région Centre-Val de Loire
          afin qu'elles puissent imaginer, explorer et prototyper des solutions IA
          à coût réduit et en temps raisonnable.
        </p>
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

<!-- ── Équipe opérationnelle ───────────────────────────────── -->
<section style="background:var(--offwhite);">
  <div class="container">
    <div class="section-label reveal"><span>L'équipe</span></div>
    <h2 class="t-h2 reveal mt-16 mb-12">Notre équipe opérationnelle</h2>
    <p class="t-lead reveal reveal-delay-1 mb-48" style="max-width:560px;">Notre mission : démocratiser et simplifier l'usage de l'IA pour tous nos clients.</p>

    <?php
    $poles = array(
        'pole-operationnel'      => array( 'label' => 'Pôle opérationnel', 'grid' => 'grid-3', 'horizontal' => false ),
        'pole-technique'         => array( 'label' => 'Pôle technique — Data Scientists', 'grid' => 'grid-3', 'horizontal' => false ),
        'reseau-experts'         => array( 'label' => 'Réseau d\'experts — Data Scientists partenaires', 'grid' => 'grid-2', 'horizontal' => true ),
        'equipe-technopolitaine' => array( 'label' => 'Équipe Technopolitaine — en support', 'grid' => 'grid-4', 'horizontal' => false ),
    );
    $delay_map = array( 0 => '', 1 => ' reveal-delay-1', 2 => ' reveal-delay-2', 3 => ' reveal-delay-3' );
    foreach ( $poles as $slug => $pole ) :
        $members = labia_get_team_members( $slug );
        if ( empty( $members ) ) continue;

        $term       = get_term_by( 'slug', $slug, 'team_pole' );
        $pole_color = $term ? get_term_meta( $term->term_id, 'pole_color', true ) : '';
        $pole_style = '';
        if ( $pole_color ) {
            $faint = labia_hex_to_rgba( $pole_color, 0.08 );
            $pole_style = ' style="--team-accent:' . esc_attr( $pole_color ) . ';--team-faint:' . esc_attr( $faint ) . ';"';
        }
    ?>
        <div class="team-section-title reveal"><?php echo esc_html( $pole['label'] ); ?></div>
        <div class="<?php echo esc_attr( $pole['grid'] ); ?> mb-48"<?php echo $pole_style; ?>>
            <?php foreach ( $members as $i => $member ) :
                $photo_id  = get_post_meta( $member->ID, 'photo', true );
                $photo_url = $photo_id ? wp_get_attachment_url( $photo_id ) : get_post_meta( $member->ID, 'photo_url', true );
                $role      = get_post_meta( $member->ID, 'role', true );
                $bio       = get_post_meta( $member->ID, 'bio', true );
                $initials  = get_post_meta( $member->ID, 'initials', true );
                $init_bg   = get_post_meta( $member->ID, 'initials_bg', true );
                $init_clr  = get_post_meta( $member->ID, 'initials_color', true );
                $is_horiz  = $pole['horizontal'];
                $style = $is_horiz ? 'text-align:left;flex-direction:row;gap:20px;align-items:flex-start;' : '';
                $photo_style = $photo_url ? '' : ( $init_bg ? 'background:' . $init_bg : '' ) . ( $is_horiz ? ';flex-shrink:0;' : ';' );
            ?>
                <div class="card card--team reveal<?php echo isset( $delay_map[ $i ] ) ? $delay_map[ $i ] : ''; ?>"<?php echo $style ? ' style="' . $style . '"' : ''; ?>>
                    <div class="card--team-photo"<?php echo $photo_style ? ' style="' . $photo_style . '"' : ''; ?>>
                        <?php if ( $photo_url ) : ?>
                            <img src="<?php echo esc_url( $photo_url ); ?>" alt="<?php echo esc_attr( $member->post_title ); ?>" />
                        <?php else : ?>
                            <span<?php echo $init_clr ? ' style="color:' . $init_clr . ';"' : ''; ?>><?php echo esc_html( $initials ); ?></span>
                        <?php endif; ?>
                    </div>
                    <div>
                        <div class="card--team-role"><?php echo esc_html( $role ); ?></div>
                        <div class="card--team-name"><?php echo esc_html( $member->post_title ); ?></div>
                        <p class="card--team-bio"><?php echo esc_html( $bio ); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endforeach; ?>
  </div>
</section>

<!-- ── Consortiums ─────────────────────────────────────────── -->
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
        <a href="https://www.devup-centrevaldeloire.fr/actualites/accelerez-votre-transition-numerique-avec-le-loire-valley-data-hub/" target="_blank" rel="noopener" class="btn btn-sm btn-outline" style="align-self:flex-start;">
          Évaluer ma maturité numérique
          <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 8h10M9 4l4 4-4 4"/></svg>
        </a>
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
        <a href="https://www.tech-orleans.fr/le-labia-loire-valley-membre-actif-du-consortium-du-loire-valley-data-hub/" target="_blank" rel="noopener" class="btn btn-sm btn-outline" style="align-self:flex-start;">
          En savoir plus
          <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 8h10M9 4l4 4-4 4"/></svg>
        </a>
      </div>
    </div>
  </div>
</section>

<!-- ── Localisation ────────────────────────────────────────── -->
<section style="background:var(--offwhite);">
  <div class="container">
    <div class="section-label reveal mb-32"><span>Nous trouver</span></div>
    <div class="map-block reveal">
      <div class="map-pin">📍</div>
      <div>
        <h3 class="t-h2 mb-16" style="color:white;">LAB'IA Loire Valley</h3>
        <p style="font-size:1rem;color:rgba(255,255,255,.6);line-height:1.8;margin-bottom:24px;">
          Le LAB'O — Village By CA Orléans<br/>
          1 avenue du Champ de Mars, CS 30019<br/>
          <strong style="color:rgba(255,255,255,.9);">45074 Orléans Cedex 2</strong>
        </p>
        <div style="display:flex;gap:20px;flex-wrap:wrap;">
          <a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', labia_opt( 'phone', '02 38 69 80 87' ) ) ); ?>" class="btn btn-outline-white btn-sm">📞 02 38 69 80 87</a>
          <a href="mailto:<?php echo esc_attr( labia_opt( 'email', 'contact@labia-loirevalley.fr' ) ); ?>" class="btn btn-outline-white btn-sm">✉ contact@labia-loirevalley.fr</a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- CTA -->
<section class="ctx-magenta cta-section">
  <div class="container">
    <h2 class="t-h1 reveal" style="color:var(--white);">Rejoignez l'aventure IA en région</h2>
    <p class="t-lead reveal reveal-delay-1" style="color:rgba(255,255,255,.75);">Que vous soyez entreprise, institution ou expert — le LAB'IA est fait pour collaborer.</p>
    <div class="flex-center gap-16 flex-wrap reveal reveal-delay-2" style="margin-top:40px;">
      <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="btn btn-white btn-lg" style="color:var(--magenta);">Nous contacter<svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 8h10M9 4l4 4-4 4"/></svg></a>
      <a href="<?php echo esc_url( home_url( '/partenariat/' ) ); ?>" class="btn btn-outline-white btn-lg">Devenir partenaire</a>
    </div>
  </div>
</section>


<?php get_footer(); ?>
