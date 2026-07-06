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

    <div class="team-section-title reveal">Pôle opérationnel</div>
    <div class="grid-3 mb-48">
      <div class="card card--team reveal">
        <div class="card--team-photo" style="background:var(--magenta-faint);">CN</div>
        <div class="card--team-role">Responsable Opérationnelle</div>
        <div class="card--team-name">Corinne Neau</div>
        <p class="card--team-bio">Suit le projet depuis 2020. En charge de la structuration des équipes, des premiers contacts clients, des partenariats et de la communication. Double formation économie &amp; management.</p>
      </div>
      <div class="card card--team reveal reveal-delay-1">
        <div class="card--team-photo" style="background:var(--blue-faint);color:#1a7acc;">TR</div>
        <div class="card--team-role">Commercial &amp; Marketing</div>
        <div class="card--team-name">Tommy Rajsombath</div>
        <p class="card--team-bio">Relationnel, démarchage client et prise de contact avec les prospects. Intervient lors des événements et conférences du LAB'IA Loire Valley.</p>
      </div>
      <div class="card card--team reveal reveal-delay-2">
        <div class="card--team-photo" style="background:#f0fff4;color:#22863a;">JD</div>
        <div class="card--team-role">Communication (alternance)</div>
        <div class="card--team-name">Jimmy Do</div>
        <p class="card--team-bio">En charge du site internet et des publications LinkedIn. Intervient également dans la préparation des événements et conférences.</p>
      </div>
    </div>

    <div class="team-section-title reveal">Pôle technique — Data Scientists</div>
    <div class="grid-3 mb-48">
      <div class="card card--team reveal">
        <div class="card--team-photo"><img src="https://static.wixstatic.com/media/667cf1_99afd254e641486895b2388a7eb26cf8~mv2.jpg" alt="Narimane Berradj" /></div>
        <div class="card--team-role">Data Scientist</div>
        <div class="card--team-name">Narimane Berradj</div>
        <p class="card--team-bio">Master Big Data & Analytics Management (Univ. Tours). Compétences en Machine Learning, Deep Learning, Data Engineering. Expertise Talend &amp; Oracle.</p>
      </div>
      <div class="card card--team reveal reveal-delay-1">
        <div class="card--team-photo"><img src="https://static.wixstatic.com/media/667cf1_3169d52b5878427c83c74201892abba0~mv2.jpg" alt="Kévin Goupil" /></div>
        <div class="card--team-role">Data Scientist</div>
        <div class="card--team-name">Kévin Goupil</div>
        <p class="card--team-bio">Master recherche en écologie, reconverti en IA. Diplômé Jedha Bootcamp Data Science. Expertise en ingénierie des données, ML et analyse statistique.</p>
      </div>
      <div class="card card--team reveal reveal-delay-2">
        <div class="card--team-photo"><img src="https://static.wixstatic.com/media/667cf1_b068fcdb3fe949319ae92f97e51f7fa8~mv2.jpg" alt="Sylvine Durand" /></div>
        <div class="card--team-role">Data Scientist</div>
        <div class="card--team-name">Sylvine Durand</div>
        <p class="card--team-bio">Docteur en biologie évolutive, reconvertie en IA. Rigueur scientifique et créativité au service de la valorisation de la donnée et des solutions innovantes.</p>
      </div>
      <div class="card card--team reveal">
        <div class="card--team-photo"><img src="https://static.wixstatic.com/media/667cf1_af3cc0a5ffbd4b07a91fc8c9d589b120~mv2.jpg" alt="Selim Mohamed" /></div>
        <div class="card--team-role">Data Scientist (alternance)</div>
        <div class="card--team-name">Selim Mohamed</div>
        <p class="card--team-bio">Cycle ingénieur CESI d'Orléans. Solide maîtrise des fondamentaux mathématiques et développement logiciel. Approches créatives et efficaces sur les problématiques data.</p>
      </div>
    </div>

    <div class="team-section-title reveal">Réseau d'experts — Data Scientists partenaires</div>
    <div class="grid-2 mb-48">
      <div class="card card--team reveal" style="text-align:left;flex-direction:row;gap:20px;align-items:flex-start;">
        <div class="card--team-photo" style="flex-shrink:0;"><img src="https://static.wixstatic.com/media/667cf1_a9c7583af84145ca88e15b1b81d304fd~mv2.png" alt="Rémi Julien" /></div>
        <div>
          <div class="card--team-role">Data Scientist Expérimenté</div>
          <div class="card--team-name">Rémi Julien</div>
          <p class="card--team-bio">20+ ans d'expérience. Consultant spécialisé dans les projets à impact : transition écologique, énergie, mobilité. Technologies : R, Python, SQL, Scikit-learn, Dataiku DSS.</p>
        </div>
      </div>
      <div class="card card--team reveal reveal-delay-1" style="text-align:left;flex-direction:row;gap:20px;align-items:flex-start;">
        <div class="card--team-photo" style="flex-shrink:0;"><img src="https://static.wixstatic.com/media/667cf1_e143d7d1a8644634bb021e0e2ae63b65~mv2.png" alt="Julien Robert" /></div>
        <div>
          <div class="card--team-role">Data Scientist &amp; Docteur</div>
          <div class="card--team-name">Julien Robert</div>
          <p class="card--team-bio">Docteur en algorithmique (ENS Lyon), agrégé de mathématiques, Chef de département informatique à l'IUT d'Orléans. Expertise technique pointue et gestion de projet.</p>
        </div>
      </div>
    </div>

    <div class="team-section-title reveal">Équipe Technopolitaine — en support</div>
    <div class="grid-4">
      <div class="card card--team reveal">
        <div class="card--team-photo" style="background:#fff8e1;color:#c68a00;">FR</div>
        <div class="card--team-role">Direction</div>
        <div class="card--team-name">Frédéric Ros</div>
        <p class="card--team-bio">Fondateur du LAB'IA, chercheur en computing science. Longue expérience de l'IA en milieu industriel. Vision stratégique du Centre de Ressources.</p>
      </div>
      <div class="card card--team reveal reveal-delay-1">
        <div class="card--team-photo" style="background:var(--offwhite);">NO</div>
        <div class="card--team-role">Expertise Juridique &amp; RH</div>
        <div class="card--team-name">Natacha Olivier</div>
        <p class="card--team-bio">Responsable BU Innovation et Transfert de Technologies. Apporte son regard RH et son soutien en conseils juridiques.</p>
      </div>
      <div class="card card--team reveal reveal-delay-2">
        <div class="card--team-photo" style="background:var(--offwhite);">CD</div>
        <div class="card--team-role">Ressources Humaines</div>
        <div class="card--team-name">Cécile Deloge</div>
        <p class="card--team-bio">Gère les ressources humaines de la Technopole d'Orléans et du LAB'IA.</p>
      </div>
      <div class="card card--team reveal reveal-delay-3">
        <div class="card--team-photo" style="background:var(--offwhite);">MS</div>
        <div class="card--team-role">Comptabilité</div>
        <div class="card--team-name">Marie Silva Ferreira</div>
        <p class="card--team-bio">Rédaction des devis, facturation et suivi du financement PIA3.</p>
      </div>
    </div>
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
