<?php
/**
 * Template Name: Partenariat
 * 1-to-1 port of partenariat.html
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
        <p class="t-lead reveal reveal-delay-1">
          Signer un accord de partenariat avec le LAB'IA, c'est rejoindre un réseau
          d'acteurs engagés pour le développement de l'IA en Centre-Val de Loire,
          augmenter votre deal flow et participer à l'industrialisation de solutions à impact.
        </p>
        <div style="margin-top:40px;" class="reveal reveal-delay-2">
          <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>?objet=partenariat" class="btn btn-primary btn-lg">
            Devenir partenaire
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
    <div class="section-label reveal"><span>Profils recherchés</span></div>
    <h2 class="t-h2 reveal mt-16 mb-48">Nous travaillons avec tout l'écosystème</h2>
    <div class="grid-3">
      <div class="card reveal" style="text-align:center;">
        <div style="font-size:2.5rem; margin-bottom:16px;">🔬</div>
        <h3 class="t-h3 mb-12">Chercheurs &amp; Laboratoires</h3>
        <p class="t-body text-muted">Laboratoires universitaires, CNRS, instituts de recherche appliquée en IA, data science et mathématiques.</p>
      </div>
      <div class="card reveal reveal-delay-1" style="text-align:center;">
        <div style="font-size:2.5rem; margin-bottom:16px;">💻</div>
        <h3 class="t-h3 mb-12">ESN &amp; Consultants</h3>
        <p class="t-body text-muted">Experts indépendants, sociétés de services numériques, cabinets de conseil en transformation digitale.</p>
      </div>
      <div class="card reveal reveal-delay-2" style="text-align:center;">
        <div style="font-size:2.5rem; margin-bottom:16px;">🏛️</div>
        <h3 class="t-h3 mb-12">Institutions &amp; Associations</h3>
        <p class="t-body text-muted">Collectivités, chambres consulaires, pôles de compétitivité, associations professionnelles et organismes de formation.</p>
      </div>
    </div>
  </div>
</section>

<!-- Témoignages partenaires -->
<section>
  <div class="container">
    <div class="section-label reveal"><span>Ils témoignent</span></div>
    <h2 class="t-h2 reveal mt-16 mb-48">Nos partenaires parlent de nous</h2>

    <div class="grid-2">
      <div class="reveal">
        <div class="partner-quote"><p>"L'aract Centre Val de Loire est partenaire du lab'IA pour accompagner les entreprises face à l'impact de l'IA sur les environnements professionnels, les organisations et les conditions de travail."</p><div class="partner-quote__footer"><strong>Isabelle Freundlieb, Directrice ARACT Centre-Val de Loire</strong><img class="partner-quote__logo" src="<?php echo esc_url( LABIA_THEME_URI . '/assets/img/logos/aract.png' ); ?>" alt="" loading="lazy" decoding="async"></div></div>
        <div class="partner-quote"><p>"La signature d'un partenariat entre l'école CODA et le LAB'IA représente une synergie stratégique majeure. Ce partenariat permet de créer des passerelles entre formation et innovation, en intégrant les étudiants dans des projets réels d'IA portés par le LAB'IA et les entreprises locales."</p><div class="partner-quote__footer"><strong>John Devos-Gonçalves, Directeur du développement · CODA</strong><img class="partner-quote__logo" src="<?php echo esc_url( LABIA_THEME_URI . '/assets/img/logos/coda.svg' ); ?>" alt="" loading="lazy" decoding="async"></div></div>
      </div>
      <div class="reveal reveal-delay-1">
        <div class="partner-quote"><p>"Le Campus des Métiers et des Qualifications Excellence Transformation Numérique a placé l'IA en tant que l'une de ses 2 thématiques. C'est pourquoi il était tout naturel pour nous de collaborer avec le LAB'IA, structure iconique de l'IA en région Centre-Val de Loire."</p><div class="partner-quote__footer"><strong>Laurent Neveu, Référent académique · Campus des Métiers</strong><img class="partner-quote__logo" src="<?php echo esc_url( LABIA_THEME_URI . '/assets/img/logos/campus-metiers.svg' ); ?>" alt="" loading="lazy" decoding="async"></div></div>
        <div class="partner-quote"><p>"DSN Conseil s'associe au LAB'IA pour promouvoir et animer des formations dédiées aux métiers du marketing face aux transformations liées à l'IA. Cette approche s'appuie sur l'expertise marketing de DSN Conseil et l'écosystème du LAB'IA."</p><div class="partner-quote__footer"><strong>Delphine Nouvian, Associée fondatrice · DSN Conseil</strong><img class="partner-quote__logo" src="<?php echo esc_url( LABIA_THEME_URI . '/assets/img/logos/dsn-conseil.svg' ); ?>" alt="" loading="lazy" decoding="async"></div></div>
      </div>
    </div>

    <div class="grid-2" style="margin-top:20px;">
      <div class="reveal">
        <div class="partner-quote"><p>"Consciente des enjeux de l'IA sur l'emploi cadre, l'Apec Centre-Val de Loire s'est rapprochée du Lab'IA afin de renforcer nos synergies et contribuer à la montée en compétences des acteurs que nous accompagnons."</p><div class="partner-quote__footer"><strong>Nicolas François, Délégué Régional · APEC Centre-Val de Loire</strong><img class="partner-quote__logo" src="<?php echo esc_url( LABIA_THEME_URI . '/assets/img/logos/apec.svg' ); ?>" alt="" loading="lazy" decoding="async"></div></div>
      </div>
      <div class="reveal reveal-delay-1">
        <div class="partner-quote"><p>"Grâce au partenariat conclu entre l'école Curien et le LAB'IA, nos apprentis ingénieurs ont pu participer à un module Big Data. L'intervention, à la fois théorique et pratique, a permis aux étudiants d'appréhender le sujet de manière technique et concrète."</p><div class="partner-quote__footer"><strong>Aurélie Grapton, Responsable Communication Veille · CCI Bourges</strong><img class="partner-quote__logo" src="<?php echo esc_url( LABIA_THEME_URI . '/assets/img/logos/curien.png' ); ?>" alt="" loading="lazy" decoding="async"></div>
      </div>
    </div>
  </div>
</section>

<!-- CTA partenariat -->
<section class="ctx-magenta cta-section">
  <div class="container">
    <div class="section-label reveal" style="justify-content:center;"><span style="color:rgba(255,255,255,.6);">Rejoignez le réseau</span></div>
    <h2 class="t-h1 reveal mt-16" style="color:var(--white);">Prêt à signer un accord de partenariat ?</h2>
    <p class="t-lead reveal reveal-delay-1" style="color:rgba(255,255,255,.75);">Contactez-nous pour discuter des modalités et des bénéfices mutuels d'un partenariat avec le LAB'IA Loire Valley.</p>
    <div class="flex-center gap-16 flex-wrap reveal reveal-delay-2" style="margin-top:40px;">
      <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>?objet=partenariat" class="btn btn-white btn-lg" style="color:var(--magenta);">Nous contacter<svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 8h10M9 4l4 4-4 4"/></svg></a>
    </div>
  </div>
</section>


<?php get_footer(); ?>
