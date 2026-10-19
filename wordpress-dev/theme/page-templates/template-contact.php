<?php
/**
 * Template Name: Contact
 * 1-to-1 port of contact.html
 */

get_header();
?>


<div class="page-hero" id="main-content" style="padding-bottom:64px;">
  <div class="container">
    <div class="page-hero__inner">
      <div class="section-label"><span>On vous répond sous 48h</span></div>
      <h1 class="t-display page-hero__title">Parlons de<br/>votre projet.</h1>
      <p class="page-hero__lead t-lead">Pré-diagnostic offert : partagez votre problématique, nos experts définissent avec vous la meilleure approche.</p>
    </div>
  </div>
</div>

<section style="padding-top:64px;">
  <div class="container">
    <div class="contact-grid">

      <!-- Infos contact -->
      <div style="display:flex;flex-direction:column;gap:16px;">
        <div class="section-label reveal"><span>Nous trouver</span></div>

        <a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', labia_opt( 'phone', '02 38 69 80 24' ) ) ); ?>" class="contact-info-item reveal" style="text-decoration:none;">
          <div class="contact-info-icon">📞</div>
          <div>
            <div class="contact-info-label">Téléphone</div>
            <div class="contact-info-value"><?php echo esc_html( labia_opt( 'phone', '02 38 69 80 24' ) ); ?></div>
            <div class="contact-info-sub">Lun–Ven, 9h–17h</div>
          </div>
        </a>

        <a href="mailto:<?php echo esc_attr( labia_opt( 'email', 'contact@labia-loirevalley.fr' ) ); ?>" class="contact-info-item reveal reveal-delay-1" style="text-decoration:none;">
          <div class="contact-info-icon">✉️</div>
          <div>
            <div class="contact-info-label">Email</div>
            <div class="contact-info-value"><?php echo esc_html( labia_opt( 'email', 'contact@labia-loirevalley.fr' ) ); ?></div>
            <div class="contact-info-sub">Réponse sous 48h ouvrées</div>
          </div>
        </a>

        <div class="contact-info-item reveal reveal-delay-2">
          <div class="contact-info-icon">📍</div>
          <div>
            <div class="contact-info-label">Adresse</div>
            <div class="contact-info-value">Le LAB'O, Village By CA Orléans</div>
            <div class="contact-info-sub">1 avenue du Champ de Mars, CS 30019<br/>45074 Orléans Cedex 2</div>
          </div>
        </div>

        <a href="<?php echo esc_url( labia_opt( 'linkedin_url', 'https://www.linkedin.com/company/lab-ia-loire-valley' ) ); ?>" target="_blank" rel="noopener" class="contact-info-item reveal reveal-delay-3" style="text-decoration:none;">
          <div class="contact-info-icon">
            <svg viewBox="0 0 24 24" fill="#0077b5" style="width:20px;height:20px;"><path d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2z"/><circle cx="4" cy="4" r="2"/></svg>
          </div>
          <div>
            <div class="contact-info-label">LinkedIn</div>
            <div class="contact-info-value">LAB'IA Loire Valley</div>
            <div class="contact-info-sub">Suivez nos actualités</div>
          </div>
        </a>

        <!-- Rappel offre -->
        <div style="margin-top:16px;padding:24px;background:var(--dark);border-radius:var(--radius-lg);" class="reveal">
          <div style="font-family:var(--font-display);font-size:.75rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:var(--magenta-light);margin-bottom:12px;">Pré-diagnostic offert</div>
          <p style="font-size:.88rem;color:rgba(255,255,255,.55);line-height:1.7;">Avant tout engagement, nous réalisons avec vous un pré-diagnostic gratuit pour évaluer la faisabilité et la valeur de votre projet IA.</p>
        </div>
      </div>

      <!-- Formulaire -->
      <div class="form-card reveal reveal-delay-1">
        <h2 class="t-h3 mb-8">Envoyez-nous un message</h2>
        <p class="t-body text-muted mb-32">Projet, formation, partenariat, presse : remplissez le formulaire, nous vous recontactons rapidement.</p>

        <?php if ( isset( $_GET['form_status'] ) && sanitize_key( wp_unslash( $_GET['form_status'] ) ) === 'success' ) : ?>
          <p id="form-feedback" role="status" tabindex="-1" class="t-body" style="color:green;">Merci, votre demande a bien été reçue. Nous vous répondrons sous 48h ouvrées.</p>
        <?php elseif ( isset( $_GET['form_status'] ) && sanitize_key( wp_unslash( $_GET['form_status'] ) ) === 'error' ) : ?>
          <p id="form-feedback" role="alert" tabindex="-1" class="t-body" style="color:#b00020;">Votre demande n’a pas pu être envoyée. Vérifiez les champs obligatoires et réessayez.</p>
        <?php endif; ?>
        <form action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post">
          <input type="hidden" name="action" value="labia_contact_form" />
          <input type="hidden" name="labia_form" value="contact" />
          <input type="hidden" name="return_url" value="<?php echo esc_url( get_permalink() ); ?>" />
          <input type="hidden" name="form_started" value="<?php echo esc_attr( time() ); ?>" />
          <?php wp_nonce_field( 'labia_contact_form', 'labia_form_nonce' ); ?>
          <div aria-hidden="true" style="position:absolute;left:-10000px;width:1px;height:1px;overflow:hidden;">
            <label for="contact-website">Ne pas remplir ce champ</label><input type="text" id="contact-website" name="website" tabindex="-1" autocomplete="off" />
          </div>
          <div class="form-row">
            <div class="form-group">
              <label class="form-label" for="contact-name">Prénom &amp; Nom <span class="required">*</span></label>
              <input type="text" id="contact-name" name="name" class="form-input" placeholder="Jean Dupont" autocomplete="name" required />
            </div>
            <div class="form-group">
              <label class="form-label" for="contact-organization">Société / Organisation</label>
              <input type="text" id="contact-organization" name="organization" class="form-input" placeholder="Mon entreprise" autocomplete="organization" />
            </div>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label class="form-label" for="contact-email">Email <span class="required">*</span></label>
              <input type="email" id="contact-email" name="email" class="form-input" placeholder="vous@entreprise.fr" autocomplete="email" required />
            </div>
            <div class="form-group">
              <label class="form-label" for="contact-phone">Téléphone</label>
              <input type="tel" id="contact-phone" name="phone" class="form-input" placeholder="06 XX XX XX XX" autocomplete="tel" />
            </div>
          </div>
          <div class="form-group">
            <label class="form-label" for="contact-request">Objet de votre demande <span class="required">*</span></label>
            <select id="contact-request" name="request" class="form-select" required>
              <option value="">Sélectionnez…</option>
              <option value="Accompagnement d'un projet Data / IA">Accompagnement d'un projet Data / IA</option>
              <option value="Formation pour mon équipe">Formation pour mon équipe</option>
              <option value="Conférence / Sensibilisation">Conférence / Sensibilisation</option>
              <option value="Partenariat">Partenariat</option>
              <option value="Presse / Médias">Presse / Médias</option>
              <option value="Autre demande">Autre demande</option>
            </select>
          </div>
          <div class="form-group">
            <label class="form-label" for="contact-message">Votre message <span class="required">*</span></label>
            <textarea id="contact-message" name="message" class="form-textarea" placeholder="Décrivez votre projet, vos besoins ou votre question..." style="min-height:140px;" required></textarea>
          </div>
          <div style="display:flex;align-items:flex-start;gap:10px;margin-bottom:28px;font-size:.8rem;color:var(--ink-60);">
            <input type="checkbox" id="rgpd" name="consent" value="1" style="margin-top:2px;flex-shrink:0;accent-color:var(--magenta);" required />
            <label for="rgpd">J'accepte que mes données soient traitées par le LAB'IA Loire Valley afin de répondre à ma demande, conformément à la <a href="<?php echo esc_url( home_url( '/politique-de-confidentialite/' ) ); ?>" style="color:var(--magenta);">politique de confidentialité</a>.</label>
          </div>
          <button type="submit" class="btn btn-primary btn-lg" style="width:100%;justify-content:center;">
            Envoyer ma demande
            <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 8h10M9 4l4 4-4 4"/></svg>
          </button>
        </form>
      </div>
    </div>
  </div>
</section>

<!-- FAQ rapide -->
<section style="background:var(--offwhite); padding:80px 0 80px;">
  <div class="container container--narrow">
    <div class="section-label reveal" style="justify-content:center; margin-bottom:16px;"><span>FAQ</span></div>
    <h2 class="t-h2 reveal text-center mt-8 mb-48">Questions fréquentes</h2>
    <div class="accordion-item reveal">
      <button class="accordion-trigger">Le pré-diagnostic est-il vraiment gratuit ?<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 6v12M6 12h12"/></svg></button>
      <div class="accordion-content"><p>Oui, entièrement. Nous prenons le temps de comprendre votre problématique avant tout engagement. Ce premier échange peut se faire en visio ou en présentiel à Orléans.</p></div>
    </div>
    <div class="accordion-item reveal">
      <button class="accordion-trigger">Intervenez-vous hors de la région Centre-Val de Loire ?<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 6v12M6 12h12"/></svg></button>
      <div class="accordion-content"><p>Notre priorité est la région Centre-Val de Loire, mais nous pouvons intervenir sur d'autres territoires pour des formations ou des missions de conseil. Contactez-nous pour en discuter.</p></div>
    </div>
    <div class="accordion-item reveal">
      <button class="accordion-trigger">Mes formations sont-elles finançables via l'OPCO ?<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 6v12M6 12h12"/></svg></button>
      <div class="accordion-content"><p>Oui, grâce à notre partenariat avec un organisme certifié QUALIOPI, vos formations peuvent être éligibles au financement OPCO. Notre équipe vous accompagne dans les démarches administratives.</p></div>
    </div>
    <div class="accordion-item reveal">
      <button class="accordion-trigger">Quel délai pour démarrer un projet ?<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 6v12M6 12h12"/></svg></button>
      <div class="accordion-content"><p>Après le pré-diagnostic offert et la signature de la convention, nous pouvons généralement démarrer un projet dans les 2 à 4 semaines. Pour les formations, les sessions sont disponibles toute l'année.</p></div>
    </div>
    <div class="accordion-item reveal">
      <button class="accordion-trigger">Proposez-vous des formations pour les débutants complets ?<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 6v12M6 12h12"/></svg></button>
      <div class="accordion-content"><p>Absolument. Nous disposons de formats adaptés à tous les niveaux, de la conférence de sensibilisation pour les COMEX jusqu'aux formations techniques intensives pour les équipes data. Nous co-construisons le contenu selon votre niveau.</p></div>
    </div>
  </div>
</section>


<?php get_footer(); ?>
