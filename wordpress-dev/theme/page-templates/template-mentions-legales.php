<?php
/**
 * Template Name: Mentions légales
 */

get_header();
?>

<div class="page-hero" id="main-content">
  <div class="container">
    <div class="page-hero__inner">
      <div class="section-label" style="margin-bottom:16px;"><span style="color:rgba(255,255,255,.4);">Informations légales</span></div>
      <h1 class="t-display page-hero__title">Mentions légales</h1>
    </div>
  </div>
</div>

<section>
  <div class="container container--narrow legal-content">

    <h2 class="t-h3">Éditeur</h2>
    <p class="t-body text-muted">
      Technopole d'Orléans<br>
      LE LAB'O<br>
      1 avenue du Champ de Mars, CS 30019<br>
      45074 Orléans Cedex 2<br>
      Tél : 02 38 69 80 24
    </p>
    <p class="t-body text-muted">
      <strong>Directeur de la publication :</strong> Frédéric Ros · <a href="mailto:frederic.ros@tech-orleans.fr" style="color:var(--magenta);">frederic.ros@tech-orleans.fr</a>
    </p>

    <hr class="legal-hr">

    <h2 class="t-h3">Hébergeur</h2>
    <p class="t-body text-muted">
      OVH SAS<br>
      2 rue Kellermann<br>
      59100 Roubaix – France<br>
      <a href="https://www.ovhcloud.com/fr/terms-and-conditions/" target="_blank" rel="noopener" style="color:var(--magenta);">Informations légales OVHcloud</a>
    </p>

    <hr class="legal-hr">

    <h2 class="t-h3">Données personnelles</h2>
    <p class="t-body text-muted">
      Les données personnelles éventuellement recueillies lors de l’utilisation du site sont traitées conformément au Règlement général sur la protection des données (RGPD) et à la loi Informatique et Libertés. Les informations sur les traitements et l’exercice de vos droits figurent dans notre <a href="<?php echo esc_url( home_url( '/politique-de-confidentialite/' ) ); ?>" style="color:var(--magenta);">politique de confidentialité</a>.
    </p>
    <p class="t-body text-muted">
      Pour toute demande concernant vos données personnelles, vous pouvez contacter l’éditeur aux coordonnées ci-dessus ou à l’adresse <a href="mailto:contact@labia-loirevalley.fr" style="color:var(--magenta);">contact@labia-loirevalley.fr</a>.
    </p>
  </div>
</section>


<?php get_footer(); ?>
