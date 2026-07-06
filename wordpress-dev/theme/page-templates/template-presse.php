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
      <p class="page-hero__lead t-lead">Articles, vidéos, podcasts, interviews — la présence médiatique du LAB'IA Loire Valley depuis 2021.</p>
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
        <div class="media-highlight__desc">Retrouvez les interventions de nos dirigeants sur France 3, France Bleu, VoxRadio, Chérie FM Tours et plus encore — pour comprendre les enjeux de l'IA en région Centre-Val de Loire.</div>
        <a href="#" class="btn btn-outline-white btn-sm">Voir toutes les vidéos</a>
      </div>
      <div class="media-embeds">
        <a href="#" class="media-embed-item" style="text-decoration:none;">
          <span class="press-item__type-icon">📺</span>
          <div><strong>France 3 Centre-Val de Loire</strong><br/><span>IA, le grand bouleversement — Février 2025</span></div>
        </a>
        <a href="#" class="media-embed-item" style="text-decoration:none;">
          <span class="press-item__type-icon">🎙️</span>
          <div><strong>France Bleu — Podcast IA</strong><br/><span>Opportunités et défis de l'IA en région</span></div>
        </a>
        <a href="#" class="media-embed-item" style="text-decoration:none;">
          <span class="press-item__type-icon">📻</span>
          <div><strong>VoxRadio — Interview</strong><br/><span>Vision de l'IA par Frédéric Ros — Janvier 2024</span></div>
        </a>
        <a href="#" class="media-embed-item" style="text-decoration:none;">
          <span class="press-item__type-icon">📻</span>
          <div><strong>Chérie FM Tours</strong><br/><span>L'IA dans notre quotidien — Novembre 2023</span></div>
        </a>
      </div>
    </div>

    <!-- Filtres -->
    <div class="media-type-filter reveal">
      <button class="media-type-btn active">Tous</button>
      <button class="media-type-btn">📰 Articles</button>
      <button class="media-type-btn">📺 Vidéo / TV</button>
      <button class="media-type-btn">🎙️ Podcasts / Radio</button>
      <button class="media-type-btn">📕 Magazines</button>
    </div>

    <!-- Timeline presse -->
    <div class="press-timeline">

      <div class="press-year-group reveal">
        <div class="press-year">2026</div>
        <div class="press-items">
          <div class="press-item">
            <div><div class="press-item__date">21 Jan. 2026</div><div class="press-item__source"><span class="press-item__type-icon">🎬</span> Loire Valley Data Hub</div></div>
            <div><div class="press-item__title">After movie — Journée « Boostez votre transition numérique »</div><p class="press-item__excerpt">Retour vidéo sur la journée du 3 décembre 2025 : 94 participants, IA et transformation numérique.</p></div>
            <a href="#" class="btn btn-sm btn-outline">Voir</a>
          </div>
          <div class="press-item">
            <div><div class="press-item__date">14 Jan. 2026</div><div class="press-item__source"><span class="press-item__type-icon">📰</span> Orléans Métropole</div></div>
            <div><div class="press-item__title">L'innovation au cœur du territoire orléanais</div><p class="press-item__excerpt">Mise en lumière de la Technopole d'Orléans et du LAB'IA comme piliers de l'innovation locale.</p></div>
            <a href="#" class="btn btn-sm btn-outline">Lire</a>
          </div>
        </div>
      </div>

      <div class="press-year-group reveal">
        <div class="press-year">2025</div>
        <div class="press-items">
          <div class="press-item">
            <div><div class="press-item__date">Oct. 2025</div><div class="press-item__source"><span class="press-item__type-icon">📰</span> Épicentre</div></div>
            <div><div class="press-item__title">Quand l'IA devient un actif stratégique</div><p class="press-item__excerpt">Corinne Neau et Aline Landier (Cosmetic Valley) mises en avant à l'occasion de VivaTech 2025 dans les colonnes d'Epicentre.</p></div>
            <a href="#" class="btn btn-sm btn-outline">Lire</a>
          </div>
          <div class="press-item">
            <div><div class="press-item__date">13 Mars 2025</div><div class="press-item__source"><span class="press-item__type-icon">📰</span> Actu.fr</div></div>
            <div><div class="press-item__title">Gestion de l'eau en CVL : l'IA au service du territoire</div><p class="press-item__excerpt">Article consacré au projet PrevizO et au rôle du LAB'IA Loire Valley au sein du consortium.</p></div>
            <a href="#" class="btn btn-sm btn-outline">Lire</a>
          </div>
          <div class="press-item">
            <div><div class="press-item__date">13 Fév. 2025</div><div class="press-item__source"><span class="press-item__type-icon">📺</span> France 3 CVL</div></div>
            <div><div class="press-item__title">« IA, le grand bouleversement » — Émission spéciale</div><p class="press-item__excerpt">Frédéric Ros partage son expertise sur l'impact industriel, énergétique et sociétal de l'IA en Centre-Val de Loire.</p></div>
            <a href="#" class="btn btn-sm btn-outline">Voir</a>
          </div>
          <div class="press-item">
            <div><div class="press-item__date">5 Fév. 2025</div><div class="press-item__source"><span class="press-item__type-icon">📰</span> La République du Centre</div></div>
            <div><div class="press-item__title">Le LAB'IA à l'honneur — RDV 360° de l'Éco</div><p class="press-item__excerpt">Double couverture : article La République du Centre + article Orléans Métropole sur l'événement.</p></div>
            <a href="#" class="btn btn-sm btn-outline">Lire</a>
          </div>
        </div>
      </div>

      <div class="press-year-group reveal">
        <div class="press-year">2024</div>
        <div class="press-items">
          <div class="press-item">
            <div><div class="press-item__date">12 Nov. 2024</div><div class="press-item__source"><span class="press-item__type-icon">📰</span> L'Usine Nouvelle</div></div>
            <div><div class="press-item__title">Visite de la ministre Clara Chappaz au LAB'IA</div><p class="press-item__excerpt">Clara Chappaz, Secrétaire d'État chargée de l'IA et du Numérique, visite le LAB'O et rencontre l'équipe.</p></div>
            <a href="#" class="btn btn-sm btn-outline">Lire</a>
          </div>
          <div class="press-item">
            <div><div class="press-item__date">Nov. 2024</div><div class="press-item__source"><span class="press-item__type-icon">📕</span> Panorama Loiret</div></div>
            <div><div class="press-item__title">Le LAB'IA Loire Valley présent en page 11</div><p class="press-item__excerpt">Le Panorama des entreprises du Loiret 2024 — 84 pages, bilan économique, classement par secteur.</p></div>
            <a href="#" class="btn btn-sm btn-outline">Consulter</a>
          </div>
          <div class="press-item">
            <div><div class="press-item__date">Nov. 2024</div><div class="press-item__source"><span class="press-item__type-icon">📺</span> France 3 CVL</div></div>
            <div><div class="press-item__title">On parle de nous sur France 3 — IA &amp; développement durable</div><p class="press-item__excerpt">Frédéric Ros livre son expertise sur l'IA au service de l'environnement en Centre-Val de Loire.</p></div>
            <a href="#" class="btn btn-sm btn-outline">Voir</a>
          </div>
          <div class="press-item">
            <div><div class="press-item__date">Mai-Juin 2024</div><div class="press-item__source"><span class="press-item__type-icon">📕</span> L'Épicentre #35</div></div>
            <div><div class="press-item__title">Dossier IA de 6 pages — L'Épicentre</div><p class="press-item__excerpt">Reportage de 6 pages avec Frédéric Ros, Christophe Brizot (Numeum) et d'autres personnalités locales.</p></div>
            <a href="#" class="btn btn-sm btn-outline">Lire p.30</a>
          </div>
          <div class="press-item">
            <div><div class="press-item__date">18 Jan. 2024</div><div class="press-item__source"><span class="press-item__type-icon">📰</span> La République du Centre</div></div>
            <div><div class="press-item__title">Double page IA — Interview exclusif Frédéric Ros &amp; Corinne Neau</div><p class="press-item__excerpt">Dossier complet sur l'IA en région avec la Technopole d'Orléans et le LAB'IA en tête d'affiche.</p></div>
            <a href="#" class="btn btn-sm btn-outline">Lire</a>
          </div>
        </div>
      </div>

      <div class="press-year-group reveal">
        <div class="press-year">2023</div>
        <div class="press-items">
          <div class="press-item">
            <div><div class="press-item__date">Jan. 2024</div><div class="press-item__source"><span class="press-item__type-icon">📻</span> VoxRadio</div></div>
            <div><div class="press-item__title">Interview de Frédéric Ros — Vision de l'IA sur VoxRadio</div><p class="press-item__excerpt">Émission diffusée le 3 décembre : Frédéric Ros partage sa vision de l'IA et son impact sociétal.</p></div>
            <a href="#" class="btn btn-sm btn-outline">Écouter</a>
          </div>
          <div class="press-item">
            <div><div class="press-item__date">28 Juin 2023</div><div class="press-item__source"><span class="press-item__type-icon">📺</span> France 3 CVL</div></div>
            <div><div class="press-item__title">Ouassila Hoceini — Data Scientist LAB'IA au 18h30</div><p class="press-item__excerpt">Intervention en direct pour parler d'IA, de ChatGPT et de l'offre de service du LAB'IA Loire Valley.</p></div>
            <a href="#" class="btn btn-sm btn-outline">Voir</a>
          </div>
          <div class="press-item">
            <div><div class="press-item__date">13 Juin 2023</div><div class="press-item__source"><span class="press-item__type-icon">📺</span> France 3 CVL</div></div>
            <div><div class="press-item__title">Frédéric Ros sur ChatGPT — Démystifier l'IA</div><p class="press-item__excerpt">Reportage visant à démystifier les a priori sur l'intelligence artificielle auprès du grand public.</p></div>
            <a href="#" class="btn btn-sm btn-outline">Voir</a>
          </div>
          <div class="press-item">
            <div><div class="press-item__date">6 Avril 2023</div><div class="press-item__source"><span class="press-item__type-icon">📻</span> Forum Vibration</div></div>
            <div><div class="press-item__title">Jérémie Méhault — L'IA dans notre quotidien</div><p class="press-item__excerpt">Interview radio : enjeux sociétaux, sociaux et environnementaux de l'IA pour les particuliers et entreprises.</p></div>
            <a href="#" class="btn btn-sm btn-outline">Écouter</a>
          </div>
        </div>
      </div>

      <div class="press-year-group reveal">
        <div class="press-year">2021–22</div>
        <div class="press-items">
          <div class="press-item">
            <div><div class="press-item__date">2022</div><div class="press-item__source"><span class="press-item__type-icon">📕</span> Acteurs de l'Éco</div></div>
            <div><div class="press-item__title">Article magazine — Le LAB'IA, un outil unique en France</div><p class="press-item__excerpt">Portrait du LAB'IA au LAB'O d'Orléans, quelques mois après son installation — un outil unique en France dans sa structuration.</p></div>
            <a href="#" class="btn btn-sm btn-outline">Lire p.7</a>
          </div>
          <div class="press-item">
            <div><div class="press-item__date">15 Fév. 2021</div><div class="press-item__source"><span class="press-item__type-icon">📰</span> La République du Centre</div></div>
            <div><div class="press-item__title">Création du LAB'IA Loire Valley — Article fondateur</div><p class="press-item__excerpt">Carole Tribout annonce la création du LAB'IA Loire Valley avec de nombreuses explications sur les objectifs du centre de ressources.</p></div>
            <a href="#" class="btn btn-sm btn-outline">Lire</a>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- Contact presse -->
<section class="ctx-dark s-sm">
  <div class="container" style="text-align:center;">
    <h2 class="t-h2 reveal mb-16" style="color:white;">Contact presse</h2>
    <p class="reveal reveal-delay-1" style="color:rgba(255,255,255,.5); margin-bottom:32px; max-width:480px; margin-left:auto; margin-right:auto;">Pour toute demande d'interview, d'information ou de visuels, contactez directement notre équipe.</p>
    <div style="display:flex;gap:16px;justify-content:center;flex-wrap:wrap;" class="reveal reveal-delay-2">
      <a href="mailto:<?php echo esc_attr( labia_opt( 'email', 'contact@labia-loirevalley.fr' ) ); ?>" class="btn btn-primary">✉ contact@labia-loirevalley.fr</a>
      <a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', labia_opt( 'phone', '02 38 69 80 87' ) ) ); ?>" class="btn btn-outline-white">📞 02 38 69 80 87</a>
    </div>
  </div>
</section>


<?php get_footer(); ?>
