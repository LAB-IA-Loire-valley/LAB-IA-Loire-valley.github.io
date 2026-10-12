<?php
/**
 * Full footer — mirrors the static site footer
 *
 * Reads financeur images and contact details from the Options Page.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$footer_desc   = labia_opt( 'footer_description', "Centre de ressources partagées autour de la donnée, porté par la Technopole d'Orléans depuis 2021." );
$phone         = labia_opt( 'phone', '02 38 69 80 24' );
$email         = labia_opt( 'email', 'contact@labia-loirevalley.fr' );
$addr1         = labia_opt( 'address_line_1', "Le LAB'O" );
$addr2         = labia_opt( 'address_line_2', '1 avenue du Champ de Mars, CS 30019' );
$addr3         = labia_opt( 'address_city', '45074 Orléans Cedex 2' );
$linkedin      = labia_opt( 'linkedin_url', 'https://www.linkedin.com/company/lab-ia-loire-valley' );
$fin1_id       = labia_opt( 'financeur_image_1' );
$fin2_id       = labia_opt( 'financeur_image_2' );
$fin1_url      = $fin1_id ? wp_get_attachment_url( $fin1_id ) : 'https://static.wixstatic.com/media/667cf1_2e4b6c62a12a4dbe84d1455c9ec29cfb~mv2.png/v1/fill/w_820,h_117,al_c,q_90,enc_auto/667cf1_2e4b6c62a12a4dbe84d1455c9ec29cfb~mv2.png';
$fin2_url      = $fin2_id ? wp_get_attachment_url( $fin2_id ) : 'https://static.wixstatic.com/media/667cf1_2d88a638c2664411bd62dc7111cf8ab1~mv2.png/v1/fill/w_820,h_108,al_c,q_90,enc_auto/667cf1_2d88a638c2664411bd62dc7111cf8ab1~mv2.png';
?>
<footer class="footer">
    <div class="container">
        <section class="footer-map" aria-labelledby="footer-map-title">
            <div class="footer-map__details">
                <p class="footer-map__eyebrow">Nous trouver</p>
                <h2 class="footer-map__title" id="footer-map-title">LAB’IA Loire Valley au LAB’O Village by CA</h2>
                <address class="footer-map__address">1 avenue du Champ de Mars<br>45100 Orléans</address>
                <a class="footer-map__link" href="https://www.openstreetmap.org/directions?to=47.8941%2C1.8942" target="_blank" rel="noopener noreferrer">
                    Ouvrir la carte et préparer votre itinéraire <span aria-hidden="true">↗</span>
                </a>
            </div>
            <div class="footer-map__visual">
                <iframe
                    src="https://www.openstreetmap.org/export/embed.html?bbox=1.8870%2C47.8910%2C1.9010%2C47.8972&amp;layer=mapnik&amp;marker=47.8941%2C1.8942"
                    title="Carte OpenStreetMap autour du LAB’O Village by CA à Orléans"
                    loading="lazy"
                    allowfullscreen>
                </iframe>
                <p class="footer-map__attribution">Carte © <a href="https://www.openstreetmap.org/copyright" target="_blank" rel="noopener noreferrer">OpenStreetMap</a> et ses contributeurs</p>
            </div>
        </section>
        <div class="footer__grid">
            <div class="footer__brand">
                <div class="footer__logo">
                    <img src="<?php echo esc_url( LABIA_THEME_URI . '/assets/img/logos/logo-labia-loire-valley.png' ); ?>" alt="LAB'IA Loire Valley" />
                </div>
                <p class="footer__desc"><?php echo esc_html( $footer_desc ); ?></p>
                <div class="footer__social">
                    <a href="<?php echo esc_url( $linkedin ); ?>" target="_blank" rel="noopener" aria-label="LinkedIn">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2z"/><circle cx="4" cy="4" r="2"/></svg>
                    </a>
                </div>
            </div>
            <div>
                <div class="footer__col-title">Offre</div>
                <ul class="footer__links">
                    <li><a href="<?php echo esc_url( home_url( '/notre-offre/#accompagnement' ) ); ?>">Accompagnement</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/notre-offre/#formations' ) ); ?>">Formations</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/notre-offre/#sensibilisation' ) ); ?>">Sensibilisation</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/nos-solutions/' ) ); ?>">Nos solutions</a></li>
                </ul>
            </div>
            <div>
                <div class="footer__col-title">À propos</div>
                <ul class="footer__links">
                    <li><a href="<?php echo esc_url( home_url( '/qui-sommes-nous/' ) ); ?>">Qui sommes-nous</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/ils-nous-font-confiance/' ) ); ?>">Nos clients</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/partenariat/' ) ); ?>">Partenaires</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/actualites/' ) ); ?>">Actualités</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/presse/' ) ); ?>">Presse</a></li>
                </ul>
            </div>
            <div>
                <div class="footer__col-title">Contact</div>
                <ul class="footer__links">
                    <li><a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">Nous écrire</a></li>
                    <li><a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a></li>
                    <li><a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a></li>
                </ul>
                <div style="margin-top:20px; font-size:.82rem; line-height:1.6; color:rgba(255,255,255,.8);">
                    <?php echo esc_html( $addr1 ); ?><br/>
                    <?php echo esc_html( $addr2 ); ?><br/>
                    <?php echo esc_html( $addr3 ); ?>
                </div>
            </div>
        </div>
        <div class="footer__financeurs">
            <div class="footer__financeurs-row">
                <div class="footer__financeurs-col">
                    <div class="footer__financeurs-label">Nos financeurs</div>
                    <img src="<?php echo esc_url( $fin1_url ); ?>" alt="Financeurs du LAB'IA Loire Valley" />
                </div>
                <div class="footer__financeurs-col">
                    <div class="footer__financeurs-label">La Technopole d'Orléans est financée par</div>
                    <img src="<?php echo esc_url( $fin2_url ); ?>" alt="Financeurs de la Technopole d'Orléans" />
                </div>
            </div>
        </div>
        <div class="footer__bottom">
            <span class="footer__bottom-text">© <?php echo date( 'Y' ); ?> LAB'IA Loire Valley · Technopole d'Orléans</span>
            <div class="footer__bottom-links">
                <a href="<?php echo esc_url( home_url( '/mentions-legales/' ) ); ?>">Mentions légales</a>
                <a href="<?php echo esc_url( home_url( '/politique-de-confidentialite/' ) ); ?>">Politique de confidentialité</a>
                <a href="<?php echo esc_url( home_url( '/politique-en-matiere-de-cookies/' ) ); ?>">Politique en matière de cookies</a>
            </div>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
