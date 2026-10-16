<?php
/**
 * Template Name: Notre Offre
 * 1-to-1 port of notre-offre.html
 */

get_header();
?>


<!-- Page Hero -->
<div class="page-hero" id="main-content">
  <div class="container">
    <div class="page-hero__inner">
      <div class="section-label" style="margin-bottom:16px;"><span style="color:rgba(255,255,255,.4);">Ce que nous faisons</span></div>
      <h1 class="t-display page-hero__title">Notre Offre</h1>
      <p class="page-hero__lead t-lead">
        Des prestations sur-mesure pour imaginer, explorer et déployer vos solutions IA,
        de la sensibilisation à l'industrialisation.
      </p>
    </div>
  </div>
</div>

<!-- Sticky sub-nav -->
<div class="offre-nav">
  <div class="container">
    <div class="offre-nav__inner">
      <a href="#sensibilisation" class="offre-nav__link">Sensibilisation</a>
      <a href="#formations" class="offre-nav__link">Formations</a>
      <a href="#accompagnement" class="offre-nav__link">Accompagnement</a>
      <a href="#conseil-gouvernance" class="offre-nav__link">Conseil &amp; Gouvernance</a>
      <a href="<?php echo esc_url( home_url( '/nos-solutions/' ) ); ?>" class="offre-nav__link" style="color:var(--magenta);">→ Nos Solutions</a>
    </div>
  </div>
</div>

<!-- ── Sensibilisation ─────────────────────────────────────── -->
<section id="sensibilisation">
  <div class="container">
    <div class="grid-2" style="gap:80px; align-items:center;">
      <div>
        <div class="section-label reveal"><span>Sensibilisation</span></div>
        <h2 class="t-h1 reveal mt-16 mb-24">Éveiller les consciences,<br/>initier les premiers usages.</h2>
        <p class="t-lead reveal reveal-delay-1">
          Conférences inspirantes, ateliers interactifs, quiz et supports visuels :
          des formats participatifs qui démystifient l'IA pour tous les publics.
        </p>
        <div style="margin-top:40px; display:flex;flex-direction:column;gap:20px;" class="reveal reveal-delay-2">
          <div style="display:flex;gap:16px;align-items:flex-start;padding:20px;background:var(--offwhite);border-radius:var(--radius-md);">
            <div style="font-size:1.5rem;flex-shrink:0;">🎤</div>
            <div>
              <div style="font-family:var(--font-display);font-size:.9rem;font-weight:700;margin-bottom:4px;">Conférences &amp; Keynotes</div>
              <div style="font-size:.84rem;color:var(--ink-60);line-height:1.5;">Intervention 1h à 2h pour COMEX, séminaires, évènements. Panorama IA, tendances, enjeux stratégiques.</div>
            </div>
          </div>
          <div style="display:flex;gap:16px;align-items:flex-start;padding:20px;background:var(--offwhite);border-radius:var(--radius-md);">
            <div style="font-size:1.5rem;flex-shrink:0;">🛠️</div>
            <div>
              <div style="font-family:var(--font-display);font-size:.9rem;font-weight:700;margin-bottom:4px;">Ateliers d'acculturation</div>
              <div style="font-size:.84rem;color:var(--ink-60);line-height:1.5;">Format ½ journée à 1 journée. Mise en situation, démonstrations live, échanges ouverts.</div>
            </div>
          </div>
          <div style="display:flex;gap:16px;align-items:flex-start;padding:20px;background:var(--offwhite);border-radius:var(--radius-md);">
            <div style="font-size:1.5rem;flex-shrink:0;">🎓</div>
            <div>
              <div style="font-family:var(--font-display);font-size:.9rem;font-weight:700;margin-bottom:4px;">Masterclasses &amp; Interventions école</div>
              <div style="font-size:.84rem;color:var(--ink-60);line-height:1.5;">Présentation métiers Data Science, cas d'usage réels, retours terrain pour étudiants et apprentis.</div>
            </div>
          </div>
        </div>
      </div>
      <div class="reveal reveal-delay-1">
        <div style="background:var(--dark);border-radius:var(--radius-xl);padding:48px;text-align:center;">
          <div style="font-family:var(--font-display);font-size:5rem;font-weight:800;color:var(--magenta);line-height:1;margin-bottom:8px;">100%</div>
          <div style="font-size:1rem;color:rgba(255,255,255,.5);margin-bottom:32px;">pratique &amp; terrain</div>
          <div style="font-family:var(--font-display);font-size:3rem;font-weight:800;color:var(--blue);line-height:1;margin-bottom:8px;">+60%</div>
          <div style="font-size:1rem;color:rgba(255,255,255,.5);margin-bottom:32px;">du temps en ateliers actifs</div>
          <div style="font-family:var(--font-display);font-size:3rem;font-weight:800;color:var(--white);line-height:1;margin-bottom:8px;">J+1</div>
          <div style="font-size:1rem;color:rgba(255,255,255,.5);">compétences exploitables dès le retour en poste</div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ── Formations ──────────────────────────────────────────── -->
<section id="formations" style="background:var(--offwhite);">
  <div class="container">
    <div class="section-label reveal"><span>Formations</span></div>
    <div style="display:flex;align-items:flex-end;justify-content:space-between;gap:32px;margin-bottom:48px;flex-wrap:wrap;">
      <div>
        <h2 class="t-h1 reveal mt-16">Monter en compétences,<br/>concrètement.</h2>
        <p class="t-lead reveal reveal-delay-1 mt-16" style="max-width:520px;">
          Des parcours pédagogiques adaptés au monde du travail : plus de 60% du temps
          consacré à la pratique.
        </p>
      </div>
      <div class="qualif-box reveal reveal-delay-2" style="max-width:320px;">
        <div class="qualif-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
        </div>
        <div>
          <div style="font-family:var(--font-display);font-size:.85rem;font-weight:700;color:#1a7acc;margin-bottom:6px;">Certifié QUALIOPI</div>
          <div style="font-size:.82rem;color:var(--ink-60);line-height:1.5;">Financement OPCO possible via notre partenariat avec un organisme labellisé.</div>
        </div>
      </div>
    </div>

    <!-- Sensibilisation -->
    <h3 class="t-h3 reveal mb-20">Sensibilisation &amp; Acculturation</h3>
    <div class="formation-grid mb-48">
      <div class="formation-card reveal">
        <span class="badge badge-dark mb-12">½ à 1 jour</span>
        <h4 class="t-h4">Démystifier la Data &amp; l'IA</h4>
        <p>Comprendre les fondamentaux : données, modèles, cas d'usage, limites. Format conférence (1-2h) ou atelier interactif (½ journée).</p>
        <div class="formation-card-meta">
          <span class="badge badge-dark">Grand débutant</span>
          <span class="badge badge-dark">Directions métier</span>
        </div>
      </div>
      <div class="formation-card reveal reveal-delay-1">
        <span class="badge badge-dark mb-12">½ à 1 jour</span>
        <h4 class="t-h4">Introduction à l'IA Générative</h4>
        <p>Cas concrets, démonstrations live (LLM, vision, no-code) et réflexion sur les usages professionnels.</p>
        <div class="formation-card-meta">
          <span class="badge badge-dark">Tous niveaux</span>
          <span class="badge badge-magenta">ChatGPT · Copilot</span>
        </div>
      </div>
    </div>

    <!-- Formations techniques -->
    <h3 class="t-h3 reveal mb-20">Formations Techniques</h3>
    <div class="formation-grid">
      <div class="formation-card reveal">
        <span class="badge badge-magenta mb-12">4 jours</span>
        <h4 class="t-h4">IA Engineering · Formation intensive</h4>
        <p>Préparation, entraînement et évaluation de modèles supervisés. Choix des algorithmes, gestion du sur-apprentissage, déploiement API.</p>
        <div class="formation-card-meta">
          <span class="badge badge-dark">Scikit-learn</span>
          <span class="badge badge-dark">MLOps</span>
          <span class="badge badge-dark">Python</span>
        </div>
      </div>
      <div class="formation-card reveal reveal-delay-1">
        <span class="badge badge-magenta mb-12">½ à 1 jour</span>
        <h4 class="t-h4">IA Générative · Formation pratique</h4>
        <p>Optimisation des connaissances théoriques et pratiques. Version "grand débutant" ou "approfondie" selon les besoins.</p>
        <div class="formation-card-meta">
          <span class="badge badge-dark">LLM</span>
          <span class="badge badge-dark">Prompt Engineering</span>
        </div>
      </div>
      <div class="formation-card reveal">
        <span class="badge badge-blue mb-12">3 à 5 jours</span>
        <h4 class="t-h4">Python · Parcours complet</h4>
        <p>Initiation (3j) → Programmation POO (3j) → Développement avancé (5j). Syntaxe, bonnes pratiques PEP 8, frameworks FastAPI/Django.</p>
        <div class="formation-card-meta">
          <span class="badge badge-dark">Python</span>
          <span class="badge badge-dark">FastAPI</span>
          <span class="badge badge-dark">CI/CD</span>
        </div>
      </div>
      <div class="formation-card reveal reveal-delay-1">
        <span class="badge badge-blue mb-12">5 jours</span>
        <h4 class="t-h4">Data Science avec Python</h4>
        <p>NumPy, Pandas, Matplotlib, Scikit-learn, pipelines, feature engineering, notebooks et data storytelling.</p>
        <div class="formation-card-meta">
          <span class="badge badge-dark">NumPy · Pandas</span>
          <span class="badge badge-dark">Machine Learning</span>
        </div>
      </div>
    </div>

    <div style="text-align:center; margin-top:48px;" class="reveal">
      <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>#formations" class="btn btn-primary">
        Demander un devis formation
        <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 8h10M9 4l4 4-4 4"/></svg>
      </a>
    </div>
  </div>
</section>

<!-- ── Accompagnement ──────────────────────────────────────── -->
<section id="accompagnement">
  <div class="container">
    <div class="grid-2" style="align-items:center; gap:80px;">
      <div>
        <div class="section-label reveal"><span>Accompagnement</span></div>
        <h2 class="t-h1 reveal mt-16 mb-24">Du diagnostic à l'industrialisation</h2>
        <p class="t-lead reveal reveal-delay-1">
          Que vous souhaitiez explorer un cas d'usage, prototyper une solution ou
          déployer un système en production, nos Data Scientists vous guident
          à chaque étape.
        </p>
        <ul style="margin-top:32px; display:flex; flex-direction:column; gap:16px;" class="reveal reveal-delay-2">
          <li style="display:flex;gap:12px;align-items:flex-start;">
            <span style="width:20px;height:20px;border-radius:50%;background:var(--magenta-faint);color:var(--magenta);display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:.7rem;font-weight:700;margin-top:2px;">✓</span>
            <span class="t-body"><strong>Pré-diagnostic offert</strong> : Évaluation gratuite de la faisabilité et de la valeur de votre projet IA.</span>
          </li>
          <li style="display:flex;gap:12px;align-items:flex-start;">
            <span style="width:20px;height:20px;border-radius:50%;background:var(--magenta-faint);color:var(--magenta);display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:.7rem;font-weight:700;margin-top:2px;">✓</span>
            <span class="t-body"><strong>Contenu co-construit</strong> : Chaque intervention est adaptée à votre marché, vos métiers et vos objectifs.</span>
          </li>
          <li style="display:flex;gap:12px;align-items:flex-start;">
            <span style="width:20px;height:20px;border-radius:50%;background:var(--magenta-faint);color:var(--magenta);display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:.7rem;font-weight:700;margin-top:2px;">✓</span>
            <span class="t-body"><strong>Approche éco-responsable</strong> : IA frugale, open source et déploiement local privilégiés.</span>
          </li>
          <li style="display:flex;gap:12px;align-items:flex-start;">
            <span style="width:20px;height:20px;border-radius:50%;background:var(--magenta-faint);color:var(--magenta);display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:.7rem;font-weight:700;margin-top:2px;">✓</span>
            <span class="t-body"><strong>Maintenance incluse</strong> : Accompagnement après livraison pour garantir la pérennité de votre solution.</span>
          </li>
        </ul>
        <div style="margin-top:40px;" class="reveal reveal-delay-3">
          <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="btn btn-primary">
            Parler de mon projet
            <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 8h10M9 4l4 4-4 4"/></svg>
          </a>
        </div>
      </div>

      <!-- 6 étapes compactes -->
      <div class="reveal reveal-delay-1">
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
          <div style="padding:24px;background:var(--offwhite);border-radius:var(--radius-lg);">
            <div style="font-family:var(--font-display);font-size:2rem;font-weight:800;color:var(--magenta);opacity:.2;line-height:1;">01</div>
            <div style="font-family:var(--font-display);font-size:.9rem;font-weight:700;margin-top:4px;">Planification</div>
            <div style="font-size:.8rem;color:var(--ink-60);margin-top:4px;line-height:1.5;">Cahier des charges &amp; feuille de route</div>
          </div>
          <div style="padding:24px;background:var(--offwhite);border-radius:var(--radius-lg);">
            <div style="font-family:var(--font-display);font-size:2rem;font-weight:800;color:var(--magenta);opacity:.2;line-height:1;">02</div>
            <div style="font-family:var(--font-display);font-size:.9rem;font-weight:700;margin-top:4px;">Maquettage</div>
            <div style="font-size:.8rem;color:var(--ink-60);margin-top:4px;line-height:1.5;">Visualisation &amp; conception UX</div>
          </div>
          <div style="padding:24px;background:var(--offwhite);border-radius:var(--radius-lg);">
            <div style="font-family:var(--font-display);font-size:2rem;font-weight:800;color:var(--magenta);opacity:.2;line-height:1;">03</div>
            <div style="font-family:var(--font-display);font-size:.9rem;font-weight:700;margin-top:4px;">Développement</div>
            <div style="font-size:.8rem;color:var(--ink-60);margin-top:4px;line-height:1.5;">IA éco-responsable &amp; éthique</div>
          </div>
          <div style="padding:24px;background:var(--offwhite);border-radius:var(--radius-lg);">
            <div style="font-family:var(--font-display);font-size:2rem;font-weight:800;color:var(--magenta);opacity:.2;line-height:1;">04</div>
            <div style="font-family:var(--font-display);font-size:.9rem;font-weight:700;margin-top:4px;">Tests</div>
            <div style="font-size:.8rem;color:var(--ink-60);margin-top:4px;line-height:1.5;">Recettage &amp; validation qualité</div>
          </div>
          <div style="padding:24px;background:var(--offwhite);border-radius:var(--radius-lg);">
            <div style="font-family:var(--font-display);font-size:2rem;font-weight:800;color:var(--magenta);opacity:.2;line-height:1;">05</div>
            <div style="font-family:var(--font-display);font-size:.9rem;font-weight:700;margin-top:4px;">Déploiement</div>
            <div style="font-size:.8rem;color:var(--ink-60);margin-top:4px;line-height:1.5;">Industrialisation &amp; mise en prod</div>
          </div>
          <div style="padding:24px;background:var(--offwhite);border-radius:var(--radius-lg);">
            <div style="font-family:var(--font-display);font-size:2rem;font-weight:800;color:var(--magenta);opacity:.2;line-height:1;">06</div>
            <div style="font-family:var(--font-display);font-size:.9rem;font-weight:700;margin-top:4px;">Maintenance</div>
            <div style="font-size:.8rem;color:var(--ink-60);margin-top:4px;line-height:1.5;">Suivi &amp; évolution dans le temps</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ── Conseil & Gouvernance IA ────────────────────────────── -->
<section id="conseil-gouvernance" style="background:var(--offwhite);">
  <div class="container">
    <div class="grid-2" style="align-items:center; gap:80px;">
      <div>
        <div class="section-label reveal"><span>Conseil &amp; Gouvernance</span></div>
        <h2 class="t-h1 reveal mt-16 mb-24">Structurer votre usage de l'IA, de la stratégie au terrain.</h2>
        <p class="t-lead reveal reveal-delay-1">
          Avant de déployer une solution IA, il faut poser un cadre. Nous vous aidons
          à définir votre politique IA, évaluer votre maturité et préparer
          l'adhésion de vos équipes et instances représentatives.
        </p>

        <div style="margin-top:40px; display:flex; flex-direction:column; gap:20px;" class="reveal reveal-delay-2">
          <div style="display:flex;gap:16px;align-items:flex-start;padding:20px;background:var(--white);border-radius:var(--radius-md);border:1px solid var(--border);">
            <div style="font-size:1.5rem;flex-shrink:0;">📋</div>
            <div>
              <div style="font-family:var(--font-display);font-size:.9rem;font-weight:700;margin-bottom:4px;">Charte IA</div>
              <div style="font-size:.84rem;color:var(--ink-60);line-height:1.5;">Co-construction du cadre de gouvernance IA de votre organisation : périmètre des usages, points de vigilance, principes éthiques et présentation aux instances (CSE).</div>
              <div style="margin-top:10px;display:flex;gap:8px;flex-wrap:wrap;">
                <span class="badge badge-dark">Étude du périmètre</span>
                <span class="badge badge-dark">Rédaction</span>
                <span class="badge badge-dark">Assistance CSE</span>
              </div>
            </div>
          </div>
          <div style="display:flex;gap:16px;align-items:flex-start;padding:20px;background:var(--white);border-radius:var(--radius-md);border:1px solid var(--border);">
            <div style="font-size:1.5rem;flex-shrink:0;">🔍</div>
            <div>
              <div style="font-family:var(--font-display);font-size:.9rem;font-weight:700;margin-bottom:4px;">Diagnostic de maturité IA</div>
              <div style="font-size:.84rem;color:var(--ink-60);line-height:1.5;">Évaluation de votre niveau de maturité Data &amp; IA, identification des opportunités prioritaires et plan d'action adapté. Réalisable dans le cadre de dispositifs partenariaux (Loire Valley Data Hub, Constructys…).</div>
              <div style="margin-top:10px;display:flex;gap:8px;flex-wrap:wrap;">
                <span class="badge badge-blue">Potentiellement subventionné</span>
                <span class="badge badge-dark">Plan d'action</span>
              </div>
            </div>
          </div>
        </div>

        <div style="margin-top:40px;" class="reveal reveal-delay-3">
          <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="btn btn-primary">
            Nous contacter
            <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 8h10M9 4l4 4-4 4"/></svg>
          </a>
        </div>
      </div>

      <div class="reveal reveal-delay-1">
        <div style="background:var(--dark);border-radius:var(--radius-xl);padding:48px;">
          <div style="font-family:var(--font-display);font-size:.75rem;font-weight:700;letter-spacing:.12em;text-transform:uppercase;color:var(--magenta-light);margin-bottom:32px;">Charte IA · déroulé type</div>
          <div style="display:flex;flex-direction:column;gap:0;">
            <div style="display:flex;gap:20px;align-items:flex-start;padding:20px 0;border-bottom:1px solid rgba(255,255,255,.06);">
              <div style="font-family:var(--font-display);font-size:1.4rem;font-weight:800;color:var(--magenta);opacity:.5;flex-shrink:0;line-height:1;width:32px;">1</div>
              <div>
                <div style="font-family:var(--font-display);font-size:.9rem;font-weight:700;color:var(--white);margin-bottom:4px;">Étude du périmètre</div>
                <div style="font-size:.8rem;color:rgba(255,255,255,.45);line-height:1.5;">Inventaire des usages IA existants et souhaités, identification des risques et des enjeux propres à votre secteur.</div>
              </div>
            </div>
            <div style="display:flex;gap:20px;align-items:flex-start;padding:20px 0;border-bottom:1px solid rgba(255,255,255,.06);">
              <div style="font-family:var(--font-display);font-size:1.4rem;font-weight:800;color:var(--magenta);opacity:.5;flex-shrink:0;line-height:1;width:32px;">2</div>
              <div>
                <div style="font-family:var(--font-display);font-size:.9rem;font-weight:700;color:var(--white);margin-bottom:4px;">Rédaction des points cruciaux</div>
                <div style="font-size:.8rem;color:rgba(255,255,255,.45);line-height:1.5;">Formalisation des principes, règles d'usage, responsabilités et limites, adaptés à votre culture d'entreprise.</div>
              </div>
            </div>
            <div style="display:flex;gap:20px;align-items:flex-start;padding:20px 0;">
              <div style="font-family:var(--font-display);font-size:1.4rem;font-weight:800;color:var(--magenta);opacity:.5;flex-shrink:0;line-height:1;width:32px;">3</div>
              <div>
                <div style="font-family:var(--font-display);font-size:.9rem;font-weight:700;color:var(--white);margin-bottom:4px;">Assistance à la présentation CSE</div>
                <div style="font-size:.8rem;color:rgba(255,255,255,.45);line-height:1.5;">Préparation et accompagnement de la présentation aux représentants du personnel pour faciliter l'adoption.</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ── Modalités ───────────────────────────────────────────── -->
<section id="modalites" style="background:var(--offwhite);">
  <div class="container">
    <div class="section-label reveal"><span>Modalités</span></div>
    <h2 class="t-h2 reveal mt-16 mb-48">Comment ça se passe</h2>
    <div class="grid-3">
      <div class="modalite-card reveal">
        <div class="card-icon mb-16"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5"/></svg></div>
        <h4 class="t-h4">Pédagogie</h4>
        <ul>
          <li>Alternance théorie / mise en situation</li>
          <li>Ateliers pratiques : +60% du temps</li>
          <li>Cas réels issus de votre secteur</li>
          <li>Supports visuels &amp; quiz interactifs</li>
        </ul>
      </div>
      <div class="modalite-card reveal reveal-delay-1">
        <div class="card-icon mb-16 blue"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z"/></svg></div>
        <h4 class="t-h4">Évaluation</h4>
        <ul>
          <li>Évaluation compétences techniques &amp; soft skills</li>
          <li>Grilles de compétences individualisées</li>
          <li>Feedbacks personnalisés</li>
          <li>Attestation de réussite nominative</li>
        </ul>
      </div>
      <div class="modalite-card reveal reveal-delay-2">
        <div class="card-icon mb-16"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>
        <h4 class="t-h4">Financement</h4>
        <ul>
          <li>Formations certifiées QUALIOPI (via partenaire)</li>
          <li>Éligibilité OPCO possible</li>
          <li>Devis personnalisé selon effectif</li>
          <li>Formats intra ou inter-entreprises</li>
        </ul>
      </div>
    </div>
  </div>
</section>

<!-- ── Formulaire de contact ──────────────────────────────── -->
<section id="contact-form">
  <div class="container container--narrow">
    <div class="text-center mb-48">
      <div class="section-label reveal" style="justify-content:center;"><span>Prendre contact</span></div>
      <h2 class="t-h2 reveal mt-16">Vous avez un projet ou besoin de formation ?</h2>
      <p class="t-lead reveal reveal-delay-1 mt-16">Notre équipe vous recontacte sous 48h.</p>
    </div>
    <div class="reveal">
      <?php if ( isset( $_GET['form_status'] ) && sanitize_key( wp_unslash( $_GET['form_status'] ) ) === 'success' ) : ?>
        <p id="form-feedback" role="status" tabindex="-1" class="t-body text-center" style="color:green;">Merci, votre demande a bien été reçue. Nous vous répondrons sous 48h ouvrées.</p>
      <?php elseif ( isset( $_GET['form_status'] ) && sanitize_key( wp_unslash( $_GET['form_status'] ) ) === 'error' ) : ?>
        <p id="form-feedback" role="alert" tabindex="-1" class="t-body text-center" style="color:#b00020;">Votre demande n’a pas pu être envoyée. Vérifiez les champs obligatoires et réessayez.</p>
      <?php endif; ?>
      <form action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post">
        <input type="hidden" name="action" value="labia_contact_form" />
        <input type="hidden" name="labia_form" value="offre" />
        <input type="hidden" name="return_url" value="<?php echo esc_url( get_permalink() ); ?>" />
        <input type="hidden" name="form_started" value="<?php echo esc_attr( time() ); ?>" />
        <?php wp_nonce_field( 'labia_offre_form', 'labia_form_nonce' ); ?>
        <div aria-hidden="true" style="position:absolute;left:-10000px;width:1px;height:1px;overflow:hidden;">
          <label for="offre-website">Ne pas remplir ce champ</label><input type="text" id="offre-website" name="website" tabindex="-1" autocomplete="off" />
        </div>
        <div class="form-row">
          <div class="form-group">
            <label class="form-label" for="offre-name">Nom / Société <span class="required">*</span></label>
            <input type="text" id="offre-name" name="name" class="form-input" placeholder="Votre nom ou société" autocomplete="name" required />
          </div>
          <div class="form-group">
            <label class="form-label" for="offre-email">Email <span class="required">*</span></label>
            <input type="email" id="offre-email" name="email" class="form-input" placeholder="vous@entreprise.fr" autocomplete="email" required />
          </div>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label class="form-label" for="offre-phone">Téléphone <span class="required">*</span></label>
            <input type="tel" id="offre-phone" name="phone" class="form-input" placeholder="06 XX XX XX XX" autocomplete="tel" required />
          </div>
          <div class="form-group">
            <label class="form-label" for="offre-request">Vous souhaitez</label>
            <select id="offre-request" name="request" class="form-select">
              <option value="">Sélectionnez…</option>
              <option value="Un accompagnement projet">Un accompagnement projet</option>
              <option value="Une formation">Une formation</option>
              <option value="Une conférence / sensibilisation">Une conférence / sensibilisation</option>
              <option value="Autre">Autre</option>
            </select>
          </div>
        </div>
        <div class="form-group">
          <label class="form-label" for="offre-participants">Nombre de participants</label>
          <input type="number" id="offre-participants" name="participants" class="form-input" placeholder="ex : 12" min="1" />
        </div>
        <div class="form-group">
          <label class="form-label" for="offre-message">Message / Précisions</label>
          <textarea id="offre-message" name="message" class="form-textarea" placeholder="Décrivez votre projet ou vos besoins..."></textarea>
        </div>
        <div style="display:flex;align-items:flex-start;gap:10px;margin:20px 0 28px;font-size:.8rem;color:var(--ink-60);">
          <input type="checkbox" id="offre-consent" name="consent" value="1" style="margin-top:2px;flex-shrink:0;accent-color:var(--magenta);" required />
          <label for="offre-consent">J'accepte que mes données soient traitées afin de répondre à ma demande, conformément à la <a href="<?php echo esc_url( home_url( '/politique-de-confidentialite/' ) ); ?>" style="color:var(--magenta);">politique de confidentialité</a>.</label>
        </div>
        <div style="text-align:center; margin-top:8px;">
          <button type="submit" class="btn btn-primary btn-lg">
            Envoyer ma demande
            <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 8h10M9 4l4 4-4 4"/></svg>
          </button>
        </div>
      </form>
    </div>
  </div>
</section>

<!-- Footer -->

<?php get_footer(); ?>
