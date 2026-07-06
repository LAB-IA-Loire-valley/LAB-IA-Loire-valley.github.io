<?php
/**
 * Template Name: Nos Solutions
 * 1-to-1 port of nos-solutions.html
 */

get_header();
?>


<!-- Page Hero -->
<div class="page-hero" id="main-content">
  <div class="container">
    <div class="page-hero__inner">
      <div class="section-label" style="margin-bottom:16px;"><span style="color:rgba(255,255,255,.4);">Prêt à déployer</span></div>
      <h1 class="t-display page-hero__title">Nos Solutions</h1>
      <p class="page-hero__lead t-lead">
        Trois solutions IA développées et éprouvées, déployables en quelques semaines —
        souveraines, hébergées chez vous, adaptées à vos enjeux terrain.
      </p>
    </div>
  </div>
</div>

<!-- ── Les 3 solutions ──────────────────────────────────────── -->
<section>
  <div class="container">
    <div class="section-label reveal mb-48"><span>Toutes nos solutions</span></div>

    <!-- 1. Assistant IA Documentaire -->
    <div id="assistant" class="solution-card-full reveal mb-32">
      <div class="solution-card-full__header">
        <div class="solution-card-full__icon" style="background:var(--blue-faint);">🤖</div>
        <div style="flex:1;">
          <div style="display:flex;gap:8px;flex-wrap:wrap;margin-bottom:12px;">
            <span class="badge badge-blue">IA Générative</span>
            <span class="badge badge-dark">RAG · LLM</span>
            <span class="badge badge-dark">Usage interne</span>
          </div>
          <h3 class="t-h2 mb-12">Assistant IA Documentaire</h3>
          <p class="t-lead" style="font-size:1rem;">Chatbot intelligent basé sur vos documents internes. Déployable en 2 à 4 semaines, souverain, sans fuite de données.</p>
        </div>
      </div>
      <div class="solution-card-full__body">
        <div class="solution-feature">Interrogation en langage naturel de votre base documentaire</div>
        <div class="solution-feature">Réponses sourcées et traçables (anti-hallucination)</div>
        <div class="solution-feature">Hébergement on-premise ou cloud privé — données sécurisées</div>
        <div class="solution-feature">Compatible PDF, Word, Excel, scan et images — extraction automatique des données clés</div>
        <div class="solution-feature">Interface personnalisée à votre charte graphique</div>
        <div class="solution-feature">Formation et transfert de compétences inclus</div>
      </div>
      <div class="solution-footer">
        <div style="display:flex;gap:8px;flex-wrap:wrap;">
          <span class="sector-tag">⚖️ Juridique</span>
          <span class="sector-tag">🏥 Santé</span>
          <span class="sector-tag">🏭 Industrie</span>
          <span class="sector-tag">🎓 Formation</span>
        </div>
        <div style="display:flex;gap:8px;flex-wrap:wrap;align-items:center;">
          <span class="badge badge-dark">Hébergement flexible — Local · Cloud souverain · Hybride</span>
          <span class="badge badge-dark">2–4 semaines</span>
          <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>?solution=assistant" class="btn btn-primary btn-sm">En savoir plus<svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 8h10M9 4l4 4-4 4"/></svg></a>
        </div>
      </div>
    </div>

    <!-- 2. Automatisation de boîte de mails -->
    <div id="mails" class="solution-card-full reveal mb-32">
      <div class="solution-card-full__header">
        <div class="solution-card-full__icon" style="background:var(--magenta-faint);">📧</div>
        <div style="flex:1;">
          <div style="display:flex;gap:8px;flex-wrap:wrap;margin-bottom:12px;">
            <span class="badge badge-magenta">Productivité</span>
            <span class="badge badge-dark">LLM · NLP</span>
          </div>
          <h3 class="t-h2 mb-12">Automatisation de boîte de mails</h3>
          <p class="t-lead" style="font-size:1rem;">Triez, priorisez et répondez à vos emails automatiquement. Réduisez le temps passé sur votre messagerie et ne ratez plus aucun message urgent.</p>
        </div>
      </div>
      <div class="solution-card-full__body">
        <div class="solution-feature">Classification et tri automatique des emails entrants par thème</div>
        <div class="solution-feature">Génération de brouillons de réponse contextualisés</div>
        <div class="solution-feature">Détection d'urgence et scoring de priorité</div>
        <div class="solution-feature">Routing intelligent vers les bons services ou collaborateurs</div>
        <div class="solution-feature">Résumé automatique des fils de discussion longs</div>
        <div class="solution-feature">Compatible Outlook, Gmail et messageries d'entreprise</div>
      </div>
      <div class="solution-footer">
        <div style="display:flex;gap:8px;flex-wrap:wrap;">
          <span class="sector-tag">💼 Commercial</span>
          <span class="sector-tag">🛎️ SAV</span>
          <span class="sector-tag">🏛️ Collectivités</span>
          <span class="sector-tag">🏥 Santé</span>
        </div>
        <div style="display:flex;gap:8px;flex-wrap:wrap;align-items:center;">
          <span class="badge badge-dark">1–3 semaines</span>
          <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>?solution=mails" class="btn btn-primary btn-sm">En savoir plus<svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 8h10M9 4l4 4-4 4"/></svg></a>
        </div>
      </div>
    </div>

    <!-- 4. Chatbot service client -->
    <div id="chatbot" class="solution-card-full reveal">
      <div class="solution-card-full__header">
        <div class="solution-card-full__icon" style="background:#f0fff4;">💬</div>
        <div style="flex:1;">
          <div style="display:flex;gap:8px;flex-wrap:wrap;margin-bottom:12px;">
            <span class="badge" style="background:#f0fff4;color:#22863a;">Service client</span>
            <span class="badge badge-dark">IA Générative</span>
            <span class="badge" style="background:#f0fff4;color:#22863a;">Tourné clients</span>
          </div>
          <h3 class="t-h2 mb-12">Chatbot service client</h3>
          <p class="t-lead" style="font-size:1rem;">Un assistant conversationnel disponible 24h/24 sur votre site ou portail — répond aux questions de vos clients, utilisateurs ou usagers sans intervention humaine.</p>
        </div>
      </div>
      <div class="solution-card-full__body">
        <div class="solution-feature">Réponse automatique aux questions fréquentes (FAQ dynamique)</div>
        <div class="solution-feature">Disponible 24h/24, 7j/7 sur votre site web ou portail</div>
        <div class="solution-feature">Transfert vers un agent humain si la question dépasse le périmètre</div>
        <div class="solution-feature">Personnalisé à votre domaine métier et votre ton de marque</div>
        <div class="solution-feature">Déployable en webchat, Slack, Teams ou SMS</div>
        <div class="solution-feature">Tableau de bord des questions pour amélioration continue</div>
      </div>
      <div class="solution-footer">
        <div style="display:flex;gap:8px;flex-wrap:wrap;">
          <span class="sector-tag">🛒 Commerce</span>
          <span class="sector-tag">🎓 Formation</span>
          <span class="sector-tag">🏛️ Collectivités</span>
          <span class="sector-tag">🤝 Associations</span>
        </div>
        <div style="display:flex;gap:8px;flex-wrap:wrap;align-items:center;">
          <span class="badge badge-dark">2–4 semaines</span>
          <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>?solution=chatbot" class="btn btn-primary btn-sm">En savoir plus<svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 8h10M9 4l4 4-4 4"/></svg></a>
        </div>
      </div>
    </div>

  </div>
</section>

<!-- CTA -->
<section class="ctx-magenta cta-section">
  <div class="container">
    <div class="section-label reveal" style="justify-content:center;"><span style="color:rgba(255,255,255,.6);">Votre projet</span></div>
    <h2 class="t-h1 reveal mt-16" style="color:var(--white);">Votre besoin ne rentre pas dans une case ?</h2>
    <p class="t-lead reveal reveal-delay-1" style="color:rgba(255,255,255,.75);">
      Nous co-construisons chaque solution avec vous. Partagez votre problématique,
      nos experts vous proposent une approche adaptée en moins d'une semaine.
    </p>
    <div class="flex-center gap-16 flex-wrap reveal reveal-delay-2" style="margin-top:40px;">
      <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="btn btn-white btn-lg" style="color:var(--magenta);">
        Parler de mon besoin
        <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 8h10M9 4l4 4-4 4"/></svg>
      </a>
    </div>
  </div>
</section>


<?php get_footer(); ?>
