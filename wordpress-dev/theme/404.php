<?php
/**
 * 404 — page introuvable.
 */

get_header();
?>

<div class="page-hero" id="main-content">
  <div class="container">
    <div class="page-hero__inner">
      <div class="section-label"><span>Erreur 404</span></div>
      <h1 class="t-display page-hero__title">Page introuvable</h1>
      <p class="page-hero__lead t-lead">La page demandée n’existe pas ou a été déplacée. Pas d’inquiétude : tout le reste du site est toujours là.</p>
    </div>
  </div>
</div>

<section class="s-lg">
  <div class="container">
    <div class="error-404">
      <div class="hero__actions error-404__actions">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-primary btn-lg">Retour à l’accueil</a>
        <a href="<?php echo esc_url( home_url( '/actualites/' ) ); ?>" class="btn btn-outline btn-lg">Voir les actualités</a>
      </div>

      <p class="error-404__hint">Vous cherchez peut-être…</p>
      <nav class="error-404__links" aria-label="Liens utiles">
        <a class="error-404__link" href="<?php echo esc_url( home_url( '/nos-solutions/' ) ); ?>">Nos solutions<svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 8h10M9 4l4 4-4 4"/></svg></a>
        <a class="error-404__link" href="<?php echo esc_url( home_url( '/notre-offre/' ) ); ?>">Notre offre<svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 8h10M9 4l4 4-4 4"/></svg></a>
        <a class="error-404__link" href="<?php echo esc_url( home_url( '/qui-sommes-nous/' ) ); ?>">Qui sommes-nous<svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 8h10M9 4l4 4-4 4"/></svg></a>
        <a class="error-404__link" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">Nous contacter<svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 8h10M9 4l4 4-4 4"/></svg></a>
      </nav>
    </div>
  </div>
</section>

<?php get_footer(); ?>
