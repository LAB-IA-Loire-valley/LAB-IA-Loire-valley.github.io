<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
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
                <img src="<?php echo esc_url( LABIA_THEME_URI . '/assets/img/logos/logo-labia-loire-valley.png' ); ?>" alt="LAB'IA Loire Valley" />
            </a>
            <ul class="nav__links">
                <li><a href="<?php echo esc_url( home_url( '/notre-offre/' ) ); ?>" class="nav__link<?php echo is_page( 'notre-offre' ) ? ' active' : ''; ?>">Notre offre</a></li>
                <li><a href="<?php echo esc_url( home_url( '/nos-solutions/' ) ); ?>" class="nav__link<?php echo is_page( 'nos-solutions' ) ? ' active' : ''; ?>">Nos solutions</a></li>
                <li><a href="<?php echo esc_url( home_url( '/qui-sommes-nous/' ) ); ?>" class="nav__link<?php echo is_page( 'qui-sommes-nous' ) ? ' active' : ''; ?>">Qui sommes-nous</a></li>
                <li class="nav__dropdown">
                    <button type="button" class="nav__link nav__dropdown-toggle<?php echo ( is_page( 'ils-nous-font-confiance' ) || is_page( 'partenariat' ) ) ? ' active' : ''; ?>" aria-expanded="false" aria-controls="nav-references-menu">Références <span aria-hidden="true">▾</span></button>
                    <div class="nav__dropdown-menu" id="nav-references-menu">
                        <a href="<?php echo esc_url( home_url( '/ils-nous-font-confiance/' ) ); ?>">Ils nous font confiance</a>
                        <a href="<?php echo esc_url( home_url( '/partenariat/' ) ); ?>">Partenaires</a>
                    </div>
                </li>
                <li class="nav__dropdown">
                    <button type="button" class="nav__link nav__dropdown-toggle<?php echo ( is_page( 'actualites' ) || is_page( 'presse' ) ) ? ' active' : ''; ?>" aria-expanded="false" aria-controls="nav-medias-menu">Médias <span aria-hidden="true">▾</span></button>
                    <div class="nav__dropdown-menu" id="nav-medias-menu">
                        <a href="<?php echo esc_url( home_url( '/actualites/' ) ); ?>">Actualités</a>
                        <a href="<?php echo esc_url( home_url( '/presse/' ) ); ?>">Presse</a>
                    </div>
                </li>
            </ul>
            <div class="nav__actions">
                <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="btn btn-primary btn-sm<?php echo is_page( 'contact' ) ? ' active' : ''; ?>">Nous contacter</a>
            </div>
            <button class="nav__burger" type="button" aria-label="Ouvrir le menu" aria-expanded="false" aria-controls="mobile-navigation">
                <span></span><span></span><span></span>
            </button>
        </div>
    </div>
</nav>

<div class="nav__mobile" id="mobile-navigation" role="navigation" aria-label="Navigation mobile">
    <button type="button" class="nav__mobile-close" aria-label="Fermer">✕</button>
    <a href="<?php echo esc_url( home_url( '/' ) ); ?>"<?php echo is_front_page() ? ' class="active"' : ''; ?>>Accueil</a>
    <a href="<?php echo esc_url( home_url( '/notre-offre/' ) ); ?>"<?php echo is_page( 'notre-offre' ) ? ' class="active"' : ''; ?>>Notre offre</a>
    <a href="<?php echo esc_url( home_url( '/nos-solutions/' ) ); ?>"<?php echo is_page( 'nos-solutions' ) ? ' class="active"' : ''; ?>>Nos solutions</a>
    <a href="<?php echo esc_url( home_url( '/qui-sommes-nous/' ) ); ?>"<?php echo is_page( 'qui-sommes-nous' ) ? ' class="active"' : ''; ?>>Qui sommes-nous</a>
    <a href="<?php echo esc_url( home_url( '/ils-nous-font-confiance/' ) ); ?>"<?php echo is_page( 'ils-nous-font-confiance' ) ? ' class="active"' : ''; ?>>Ils nous font confiance</a>
    <a href="<?php echo esc_url( home_url( '/partenariat/' ) ); ?>"<?php echo is_page( 'partenariat' ) ? ' class="active"' : ''; ?>>Partenaires</a>
    <a href="<?php echo esc_url( home_url( '/actualites/' ) ); ?>"<?php echo is_page( 'actualites' ) ? ' class="active"' : ''; ?>>Actualités</a>
    <a href="<?php echo esc_url( home_url( '/presse/' ) ); ?>"<?php echo is_page( 'presse' ) ? ' class="active"' : ''; ?>>Presse</a>
    <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"<?php echo is_page( 'contact' ) ? ' class="active"' : ''; ?>>Contact</a>
</div>
