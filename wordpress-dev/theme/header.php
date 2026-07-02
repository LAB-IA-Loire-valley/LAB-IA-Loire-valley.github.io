<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a href="#main-content" class="skip-link">Aller au contenu</a>

<nav class="nav nav--dark-page" aria-label="Navigation principale">
    <div class="container">
        <div class="nav__inner">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="nav__logo">
                <img src="<?php echo esc_url( LABIA_THEME_URI . '/assets/img/logos/logo labia without name.png' ); ?>" alt="LAB'IA Loire Valley" />
            </a>
            <ul class="nav__links">
                <li><a href="<?php echo esc_url( home_url( '/notre-offre/' ) ); ?>" class="nav__link">Notre Offre</a></li>
                <li><a href="<?php echo esc_url( home_url( '/nos-solutions/' ) ); ?>" class="nav__link">Nos Solutions</a></li>
                <li><a href="<?php echo esc_url( home_url( '/qui-sommes-nous/' ) ); ?>" class="nav__link">Qui sommes-nous</a></li>
                <li class="nav__dropdown">
                    <a href="#" class="nav__link">Références ▾</a>
                    <div class="nav__dropdown-menu">
                        <a href="<?php echo esc_url( home_url( '/ils-nous-font-confiance/' ) ); ?>">Ils nous font confiance</a>
                        <a href="<?php echo esc_url( home_url( '/partenariat/' ) ); ?>">Partenaires</a>
                    </div>
                </li>
                <li class="nav__dropdown">
                    <a href="#" class="nav__link">Médias ▾</a>
                    <div class="nav__dropdown-menu">
                        <a href="<?php echo esc_url( home_url( '/actualites/' ) ); ?>">Actualités</a>
                        <a href="<?php echo esc_url( home_url( '/presse/' ) ); ?>">Presse</a>
                    </div>
                </li>
            </ul>
            <div class="nav__actions">
                <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="btn btn-primary btn-sm">Nous contacter</a>
            </div>
            <button class="nav__burger" aria-label="Menu">
                <span></span><span></span><span></span>
            </button>
        </div>
    </div>
</nav>

<div class="nav__mobile" role="dialog" aria-label="Menu mobile">
    <button class="nav__mobile-close" aria-label="Fermer">✕</button>
    <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Accueil</a>
    <a href="<?php echo esc_url( home_url( '/notre-offre/' ) ); ?>">Notre Offre</a>
    <a href="<?php echo esc_url( home_url( '/nos-solutions/' ) ); ?>">Nos Solutions</a>
    <a href="<?php echo esc_url( home_url( '/qui-sommes-nous/' ) ); ?>">Qui sommes-nous</a>
    <a href="<?php echo esc_url( home_url( '/ils-nous-font-confiance/' ) ); ?>">Ils nous font confiance</a>
    <a href="<?php echo esc_url( home_url( '/partenariat/' ) ); ?>">Partenaires</a>
    <a href="<?php echo esc_url( home_url( '/actualites/' ) ); ?>">Actualités</a>
    <a href="<?php echo esc_url( home_url( '/presse/' ) ); ?>">Presse</a>
    <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">Contact</a>
</div>
