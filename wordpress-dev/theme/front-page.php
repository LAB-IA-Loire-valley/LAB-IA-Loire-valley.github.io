<?php
/**
 * Front Page template — 1-to-1 port of index.html
 */

get_header();
?>
<?php get_template_part( 'template-parts/section-hero' ); ?>

<!-- ── Stats ───────────────────────────────────────────────── -->
<section class="s-sm" style="padding:0; border-bottom: 1px solid var(--border);">
  <div class="stats-strip">
    <div class="stat-item reveal">
      <div class="stat-number" style="color:#4FB0FF;"><span>2021</span></div>
      <div class="stat-label">Année de fondation<br/>au sein de la Technopole d'Orléans</div>
    </div>
    <div class="stat-item reveal reveal-delay-1">
      <div class="stat-number" style="color:#475297;"><span data-count="38" data-suffix="%">38%</span></div>
      <div class="stat-label">de productivité gagnée<br/>grâce à l'IA d'ici 2035 <span style="font-size:.75em;opacity:.6">(Accenture)</span></div>
    </div>
    <div class="stat-item reveal reveal-delay-2">
      <div class="stat-number" style="color:#852F85;"><span data-count="6"></span></div>
      <div class="stat-label">étapes pour<br/>un projet IA réussi</div>
    </div>
    <div class="stat-item reveal reveal-delay-3">
      <div class="stat-number" style="color:#E2007D;">+100</div>
      <div class="stat-label">structures accompagnées<br/>en région Centre-Val de Loire</div>
    </div>
  </div>
</section>

<!-- ── Notre Offre ─────────────────────────────────────────── -->
<section>
  <div class="container">
    <div class="section-label reveal"><span>Notre offre</span></div>
    <div style="display:grid; grid-template-columns: 1fr 1fr; gap: 16px; align-items: end; margin-bottom: 64px;">
      <h2 class="t-h1 reveal">Des prestations<br/>sur-mesure pour<br/>concrétiser l'IA.</h2>
      <div class="reveal reveal-delay-2">
        <p class="t-lead" style="margin-bottom:28px;">
          Formations spécialisées, accompagnement technique, sensibilisation stratégique :
          nous intervenons à chaque étape de votre transformation IA.
        </p>
        <a href="<?php echo esc_url( home_url( '/notre-offre/' ) ); ?>" class="btn btn-outline">
          Voir toute l'offre
          <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 8h10M9 4l4 4-4 4"/></svg>
        </a>
      </div>
    </div>

    <div class="grid-4">
      <div class="card card--service accent-blue reveal">
        <div class="card-icon accent-blue">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 014.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15.3M14.25 3.104c.251.023.501.05.75.082M19.8 15.3l-1.57.393A9.065 9.065 0 0112 15a9.065 9.065 0 00-6.23-.693L5 14.5m14.8.8l1.402 1.402c1 1 .03 2.798-1.4 2.798H4.2c-1.43 0-2.4-1.798-1.4-2.798L4.2 15.3"/></svg>
        </div>
        <h3 class="t-h3">Accompagnement &amp; Prototypage</h3>
        <p class="t-body text-muted">
          De l'idée au déploiement : diagnostic, maquettage, développement éco-responsable,
          tests et mise en production avec nos Data Scientists.
        </p>
        <a href="<?php echo esc_url( home_url( '/notre-offre/' ) ); ?>#accompagnement" class="btn btn-sm btn-outline" style="align-self:flex-start; margin-top:auto">
          En savoir plus
          <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 8h10M9 4l4 4-4 4"/></svg>
        </a>
      </div>

      <div class="card card--service accent-indigo reveal reveal-delay-1">
        <div class="card-icon accent-indigo">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5"/></svg>
        </div>
        <h3 class="t-h3">Formations &amp; Ateliers</h3>
        <p class="t-body text-muted">
          Python, IA générative, Data Science, MLOps… Des parcours certifiés QUALIOPI
          ou sur-mesure pour faire monter vos équipes en compétences.
        </p>
        <a href="<?php echo esc_url( home_url( '/notre-offre/' ) ); ?>#formations" class="btn btn-sm btn-outline" style="align-self:flex-start; margin-top:auto">
          Voir le catalogue
          <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 8h10M9 4l4 4-4 4"/></svg>
        </a>
      </div>

      <div class="card card--service accent-violet reveal reveal-delay-2">
        <div class="card-icon accent-violet">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z"/></svg>
        </div>
        <h3 class="t-h3">Sensibilisation &amp; Conférences</h3>
        <p class="t-body text-muted">
          Démystifier la Data et l'IA, éveiller les consciences, initier les premiers usages.
          Formats adaptés : conférence, atelier ½ journée, masterclass.
        </p>
        <a href="<?php echo esc_url( home_url( '/notre-offre/' ) ); ?>#sensibilisation" class="btn btn-sm btn-outline" style="align-self:flex-start; margin-top:auto">
          En savoir plus
          <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 8h10M9 4l4 4-4 4"/></svg>
        </a>
      </div>

      <div class="card card--service reveal reveal-delay-3">
        <div class="card-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z"/></svg>
        </div>
        <h3 class="t-h3">Conseil &amp; Gouvernance IA</h3>
        <p class="t-body text-muted">
          Charte IA co-construite, diagnostic de maturité, accompagnement à la présentation CSE —
          structurez votre politique IA avant de déployer.
        </p>
        <a href="<?php echo esc_url( home_url( '/notre-offre/' ) ); ?>#conseil-gouvernance" class="btn btn-sm btn-outline" style="align-self:flex-start; margin-top:auto">
          En savoir plus
          <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 8h10M9 4l4 4-4 4"/></svg>
        </a>
      </div>
    </div>
  </div>
</section>

<!-- ── Nos Solutions (teaser) ──────────────────────────────── -->
<section style="background: linear-gradient(180deg, var(--offwhite) 0%, var(--white) 100%);">
  <div class="container">
    <div class="section-label reveal"><span>Nos solutions</span></div>
    <div style="display:flex; align-items:flex-end; justify-content:space-between; gap:32px; margin-bottom:56px; flex-wrap:wrap;">
      <h2 class="t-h1 reveal" style="max-width:520px;">Des solutions IA<br/>prêtes à déployer.</h2>
      <a href="<?php echo esc_url( home_url( '/nos-solutions/' ) ); ?>" class="btn btn-outline reveal reveal-delay-2">
        Toutes nos solutions
        <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 8h10M9 4l4 4-4 4"/></svg>
      </a>
    </div>

    <div class="grid-3">
      <a href="<?php echo esc_url( home_url( '/nos-solutions/' ) ); ?>#assistant" class="card card--solution reveal" style="text-decoration:none; color:inherit;">
        <div class="card-img">
          <div class="card-img-inner" style="background:linear-gradient(135deg,#0D0D0D,#0a1a1a);">
            <span style="font-size:2.5rem;color:rgba(79,176,255,.6);">🤖</span>
          </div>
        </div>
        <div>
          <div class="card-tags">
            <span class="badge badge-blue">GenAI</span>
            <span class="badge badge-dark">RAG · LLM</span>
          </div>
          <h3 class="t-h3 mt-12 mb-8">Assistant IA Documentaire</h3>
          <p class="t-body text-muted">Chatbot sur votre base documentaire interne — déployable en 2 à 4 semaines, souverain et sécurisé.</p>
        </div>
      </a>

      <a href="<?php echo esc_url( home_url( '/nos-solutions/' ) ); ?>#extraction" class="card card--solution reveal reveal-delay-1" style="text-decoration:none; color:inherit;">
        <div class="card-img">
          <div class="card-img-inner" style="background:linear-gradient(135deg,#0D0D0D,#1a1a0a);">
            <span style="font-size:2.5rem;color:rgba(198,138,0,.6);">📄</span>
          </div>
        </div>
        <div>
          <div class="card-tags">
            <span class="badge" style="background:#fff8e1;color:#c68a00;">Documents</span>
            <span class="badge badge-dark">OCR · LLM</span>
          </div>
          <h3 class="t-h3 mt-12 mb-8">Extraction intelligente</h3>
          <p class="t-body text-muted">Transformez factures, contrats et formulaires en données structurées exploitables — réduction de saisie jusqu'à 95 %.</p>
        </div>
      </a>

      <a href="<?php echo esc_url( home_url( '/nos-solutions/' ) ); ?>#mails" class="card card--solution reveal reveal-delay-2" style="text-decoration:none; color:inherit;">
        <div class="card-img">
          <div class="card-img-inner" style="background:linear-gradient(135deg,#0D0D0D,#1a0a1a);">
            <span style="font-size:2.5rem;color:rgba(226,0,125,.6);">📧</span>
          </div>
        </div>
        <div>
          <div class="card-tags">
            <span class="badge badge-magenta">Productivité</span>
            <span class="badge badge-dark">LLM · NLP</span>
          </div>
          <h3 class="t-h3 mt-12 mb-8">Automatisation des mails</h3>
          <p class="t-body text-muted">Tri, priorisation et brouillons de réponse automatiques pour vos boîtes de réception professionnelles.</p>
        </div>
      </a>
    </div>
  </div>
</section>

<!-- ── Méthode ─────────────────────────────────────────────── -->
<section>
  <div class="container">
    <div style="text-align:center; margin-bottom:64px;">
      <div class="section-label reveal" style="justify-content:center;"><span>Notre méthode</span></div>
      <h2 class="t-h1 reveal mt-16">6 étapes pour un projet réussi</h2>
      <p class="t-lead reveal reveal-delay-1 mt-16" style="max-width:520px;margin-left:auto;margin-right:auto;">
        Une approche structurée de A à Z — du diagnostic initial jusqu'à la maintenance en production.
      </p>
    </div>

    <div class="timeline">
      <svg class="timeline-connector" viewBox="0 0 300 100" preserveAspectRatio="none" aria-hidden="true" focusable="false">
        <path d="M50 6 H300 V46 H0 V65 H250" />
      </svg>
      <div class="timeline-item reveal">
        <div class="timeline-step">1</div>
        <div class="timeline-title">Planification</div>
        <div class="timeline-text">Cahier des charges, feuille de route et pré-diagnostic offert pour poser les fondations solides de votre projet.</div>
      </div>
      <div class="timeline-item reveal reveal-delay-1">
        <div class="timeline-step">2</div>
        <div class="timeline-title">Maquettage</div>
        <div class="timeline-text">Conception de visualisations et maquettes attrayantes pour donner vie à votre idée avant le développement.</div>
      </div>
      <div class="timeline-item reveal reveal-delay-2">
        <div class="timeline-step">3</div>
        <div class="timeline-title">Conception</div>
        <div class="timeline-text">Développement éco-responsable et éthique par nos Data Scientists — intégration harmonieuse et efficace.</div>
      </div>
      <div class="timeline-item reveal">
        <div class="timeline-step">4</div>
        <div class="timeline-title">Tests &amp; Recettage</div>
        <div class="timeline-text">Chaque détail est examiné et ajusté lors de notre phase de recettage pour vous assurer un produit parfait.</div>
      </div>
      <div class="timeline-item reveal reveal-delay-1">
        <div class="timeline-step">5</div>
        <div class="timeline-title">Déploiement</div>
        <div class="timeline-text">Mise en production guidée selon notre processus éprouvé pour un envol réussi de votre solution.</div>
      </div>
      <div class="timeline-item reveal reveal-delay-2">
        <div class="timeline-step">6</div>
        <div class="timeline-title">Maintenance</div>
        <div class="timeline-text">Accompagnement post-livraison pour assurer la pérennité de votre solution et soutenir votre croissance.</div>
      </div>
    </div>
  </div>
</section>

<!-- ── Partenaires / Logos (dark) ─────────────────────────── -->
<section class="ctx-dark s-sm">
  <div class="container">
    <div style="text-align:center; margin-bottom:48px;">
      <p class="t-label reveal" style="color:rgba(255,255,255,.3);margin-bottom:16px;">Ils nous font confiance</p>
      <h2 class="t-h2 reveal mt-8" style="color:var(--white);">Un écosystème régional engagé</h2>
    </div>
  </div>

  <div class="logo-ticker reveal">
    <div class="logo-track">
      <!-- set 1 -->
      <div class="logo-item"><img src="<?php echo esc_url( LABIA_THEME_URI . '/assets/img/logos/' ); ?>laposte.svg" alt="La Poste" /></div>
      <div class="logo-item"><img src="<?php echo esc_url( LABIA_THEME_URI . '/assets/img/logos/' ); ?>keolis.svg" alt="Keolis" /></div>
      <div class="logo-item"><img src="<?php echo esc_url( LABIA_THEME_URI . '/assets/img/logos/' ); ?>afnor.svg" alt="AFNOR" /></div>
      <div class="logo-item"><img src="<?php echo esc_url( LABIA_THEME_URI . '/assets/img/logos/' ); ?>antea.svg" alt="Antea Group" /></div>
      <div class="logo-item"><img src="<?php echo esc_url( LABIA_THEME_URI . '/assets/img/logos/' ); ?>devup.svg" alt="Dev'Up" /></div>
      <div class="logo-item"><img src="<?php echo esc_url( LABIA_THEME_URI . '/assets/img/logos/' ); ?>aract.png" alt="ARACT CVL" /></div>
      <div class="logo-item"><img src="<?php echo esc_url( LABIA_THEME_URI . '/assets/img/logos/' ); ?>greta.png" alt="GRETA" /></div>
      <div class="logo-item"><img src="<?php echo esc_url( LABIA_THEME_URI . '/assets/img/logos/' ); ?>wildcodeschool.svg" alt="Wild Code School" /></div>
      <!-- set 2 (aria-hidden pour accessibilité) -->
      <div class="logo-item" aria-hidden="true"><img src="<?php echo esc_url( LABIA_THEME_URI . '/assets/img/logos/' ); ?>laposte.svg" alt="" /></div>
      <div class="logo-item" aria-hidden="true"><img src="<?php echo esc_url( LABIA_THEME_URI . '/assets/img/logos/' ); ?>keolis.svg" alt="" /></div>
      <div class="logo-item" aria-hidden="true"><img src="<?php echo esc_url( LABIA_THEME_URI . '/assets/img/logos/' ); ?>afnor.svg" alt="" /></div>
      <div class="logo-item" aria-hidden="true"><img src="<?php echo esc_url( LABIA_THEME_URI . '/assets/img/logos/' ); ?>antea.svg" alt="" /></div>
      <div class="logo-item" aria-hidden="true"><img src="<?php echo esc_url( LABIA_THEME_URI . '/assets/img/logos/' ); ?>devup.svg" alt="" /></div>
      <div class="logo-item" aria-hidden="true"><img src="<?php echo esc_url( LABIA_THEME_URI . '/assets/img/logos/' ); ?>aract.png" alt="" /></div>
      <div class="logo-item" aria-hidden="true"><img src="<?php echo esc_url( LABIA_THEME_URI . '/assets/img/logos/' ); ?>greta.png" alt="" /></div>
      <div class="logo-item" aria-hidden="true"><img src="<?php echo esc_url( LABIA_THEME_URI . '/assets/img/logos/' ); ?>wildcodeschool.svg" alt="" /></div>
    </div>
  </div>

  <div class="container">
    <div style="text-align:center; margin-top:40px;">
      <a href="<?php echo esc_url( home_url( '/ils-nous-font-confiance/' ) ); ?>" class="btn btn-outline-white btn-sm">Voir toutes les références</a>
    </div>
  </div>
</section>

<!-- ── Témoignages ─────────────────────────────────────────── -->
<section>
  <div class="container">
    <div class="section-label reveal"><span>Témoignages</span></div>
    <h2 class="t-h2 reveal mt-8 mb-48">Ce que disent nos partenaires</h2>

    <?php
    $home_testimonials = labia_get_testimonials( 3, true );
    if ( $home_testimonials ) :
    ?>
    <div class="grid-3">
      <?php foreach ( $home_testimonials as $i => $t ) :
        $quote     = get_post_meta( $t->ID, 'quote', true );
        $author    = get_post_meta( $t->ID, 'author', true );
        $author_role = get_post_meta( $t->ID, 'author_role', true );
        $company   = get_post_meta( $t->ID, 'company', true );
        $photo_id  = get_post_meta( $t->ID, 'photo', true );
        $photo_url = $photo_id ? wp_get_attachment_url( $photo_id ) : '';
        $initials  = labia_get_initials( $author );
        $accent    = labia_avatar_color( $i );
        $faint     = labia_hex_to_rgba( $accent, 0.12 );
        $role_line = $author_role || $company ? ( $author_role ? ( $company ? "$author_role — $company" : $author_role ) : $company ) : '';
      ?>
      <div class="card card--testimonial reveal<?php echo $i ? ' reveal-delay-' . $i : ''; ?>">
        <p class="card--testimonial-quote">"<?php echo esc_html( $quote ); ?>"</p>
        <div class="card--testimonial-author">
          <div class="card--testimonial-avatar" style="<?php echo $photo_url ? '' : esc_attr( "--avatar-color:$accent;--avatar-faint:$faint;" ); ?>">
            <?php if ( $photo_url ) : ?>
              <img src="<?php echo esc_url( $photo_url ); ?>" alt="<?php echo esc_attr( $author ); ?>" />
            <?php elseif ( $initials ) : ?>
              <span><?php echo esc_html( $initials ); ?></span>
            <?php endif; ?>
          </div>
          <div>
            <div class="card--testimonial-name"><?php echo esc_html( $author ); ?></div>
            <div class="card--testimonial-role"><?php echo esc_html( $role_line ); ?></div>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>
  </div>
</section>

<!-- ── CTA ─────────────────────────────────────────────────── -->
<section class="ctx-magenta cta-section">
  <div class="container">
    <div class="section-label reveal" style="justify-content:center;"><span style="color:rgba(255,255,255,.6);">Passons à l'action</span></div>
    <h2 class="t-h1 reveal mt-16" style="color:var(--white);">Vous avez un projet Data&nbsp;/ IA ?</h2>
    <p class="t-lead reveal reveal-delay-1" style="color:rgba(255,255,255,.75);">
      Pré-diagnostic offert. Notre équipe vous recontacte sous 48h pour définir
      la meilleure approche pour vos enjeux.
    </p>
    <div class="flex-center gap-16 flex-wrap reveal reveal-delay-2" style="margin-top:40px;">
      <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="btn btn-white btn-lg" style="color:var(--magenta);">
        Parler de mon projet
        <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 8h10M9 4l4 4-4 4"/></svg>
      </a>
      <a href="<?php echo esc_url( home_url( '/notre-offre/' ) ); ?>" class="btn btn-outline-white btn-lg">Voir notre offre</a>
    </div>
  </div>
</section>

<!-- ── Footer ──────────────────────────────────────────────── -->

<?php get_footer(); ?>
