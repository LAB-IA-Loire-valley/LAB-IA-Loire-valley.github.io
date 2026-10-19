<?php
/**
 * Plugin Name: LAB'IA — Migration des logos clients vers la médiathèque
 * Description: Outil one-shot : importe les logos clients (fichiers du thème) dans la médiathèque WordPress et renseigne le champ média « Logo » de chaque fiche. Idempotent.
 * Version:     1.0.0
 * Author:      LAB'IA Loire Valley
 *
 * Après exécution, ce fichier peut être supprimé (l'outil n'est plus nécessaire).
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Page d'outil sous « Outils ».
 */
add_action( 'admin_menu', function () {
    add_submenu_page(
        'tools.php',
        'Migration des logos clients',
        'Migration logos clients',
        'manage_options',
        'labia-migrate-client-logos',
        'labia_migrate_client_logos_page'
    );
} );

function labia_migrate_client_logos_page() {
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }
    $count = (int) wp_count_posts( 'client' )->publish;
    ?>
    <div class="wrap">
        <h1>Migration des logos clients</h1>
        <p>
            <?php echo esc_html( $count ); ?> client(s) publié(s).
            Cette action importe les logos (fichiers du thème) dans la médiathèque
            et renseigne le champ média « Logo » de chaque fiche.
            Les fiches déjà pourvues d'un logo sont ignorées (idempotent).
        </p>
        <form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
            <input type="hidden" name="action" value="labia_migrate_client_logos" />
            <?php wp_nonce_field( 'labia_migrate_client_logos' ); ?>
            <?php submit_button( 'Lancer la migration' ); ?>
        </form>
    </div>
    <?php
}

/**
 * Traite le formulaire et redirige avec un compte rendu.
 */
add_action( 'admin_post_labia_migrate_client_logos', function () {
    if ( ! current_user_can( 'manage_options' ) || ! check_admin_referer( 'labia_migrate_client_logos' ) ) {
        wp_die( 'Non autorisé.' );
    }

    $result = labia_client_logos_migrate();

    wp_safe_redirect( add_query_arg(
        array(
            'page'     => 'labia-migrate-client-logos',
            'migrated' => $result['ok'],
            'skipped'  => $result['skip'],
            'errored'  => count( $result['err'] ),
        ),
        admin_url( 'tools.php' )
    ) );
    exit;
} );

/**
 * Importe les logos clients du thème dans la médiathèque.
 *
 * @return array{ok:int,skip:int,err:array<int,string>}
 */
function labia_client_logos_migrate() {
    require_once ABSPATH . 'wp-admin/includes/file.php';
    require_once ABSPATH . 'wp-admin/includes/media.php';
    require_once ABSPATH . 'wp-admin/includes/image.php';

    $result = array( 'ok' => 0, 'skip' => 0, 'err' => array() );

    if ( ! function_exists( 'labia_resolve_client_logo_file' ) ) {
        $result['err'][] = 'Helper thème labia_resolve_client_logo_file() introuvable.';
        return $result;
    }

    $clients = get_posts( array(
        'post_type'      => 'client',
        'post_status'    => 'any',
        'posts_per_page' => -1,
        'no_found_rows'  => true,
    ) );

    // Fiches dont le champ « Logo fichier » est vide alors que le logo existe
    // dans le thème (fichier utilisé ailleurs sur le site).
    $known_files = array(
        'Campus des Métiers' => 'campus-metiers.svg',
        'APEC CVL'           => 'apec.svg',
        'DSN Conseil'        => 'dsn-conseil.svg',
        'Forum Vibration'    => 'vibration.png',
    );

    // Force la détection MIME des SVG (non reconnus automatiquement) et
    // autorise leur upload le temps de la migration uniquement.
    $allow_svg_mime = function ( $mimes ) {
        $mimes['svg'] = 'image/svg+xml';
        return $mimes;
    };
    $allow_svg = function ( $data, $file, $filename, $mimes ) {
        if ( 'svg' === strtolower( pathinfo( $filename, PATHINFO_EXTENSION ) ) ) {
            $data['ext']  = 'svg';
            $data['type'] = 'image/svg+xml';
        }
        return $data;
    };
    add_filter( 'upload_mimes', $allow_svg_mime );
    add_filter( 'wp_check_filetype_and_ext', $allow_svg, 10, 4 );

    $logo_dir = trailingslashit( get_template_directory() ) . 'assets/img/logos/';

    foreach ( $clients as $client ) {
        if ( (int) get_post_meta( $client->ID, 'logo', true ) ) {
            $result['skip']++;
            continue;
        }

        $file = labia_resolve_client_logo_file( get_post_meta( $client->ID, 'logo_file', true ) );
        if ( '' === $file && isset( $known_files[ $client->post_title ] ) ) {
            $file = labia_resolve_client_logo_file( $known_files[ $client->post_title ] );
        }
        if ( '' === $file ) {
            $result['skip']++;
            continue;
        }

        $src = $logo_dir . $file;
        if ( ! is_file( $src ) ) {
            $result['skip']++;
            continue;
        }

        $tmp = wp_tempnam( $file );
        if ( ! $tmp || ! copy( $src, $tmp ) ) {
            $result['err'][] = $client->post_title . ' : copie du fichier impossible.';
            continue;
        }

        $att_id = media_handle_sideload(
            array( 'name' => $file, 'tmp_name' => $tmp ),
            $client->ID,
            $client->post_title
        );

        if ( is_wp_error( $att_id ) ) {
            @unlink( $tmp );
            $result['err'][] = $client->post_title . ' : ' . $att_id->get_error_message();
            continue;
        }

        update_post_meta( $client->ID, 'logo', (int) $att_id );
        update_post_meta( $att_id, '_wp_attachment_image_alt', $client->post_title );
        $result['ok']++;
    }

    remove_filter( 'wp_check_filetype_and_ext', $allow_svg, 10 );
    remove_filter( 'upload_mimes', $allow_svg_mime );

    return $result;
}
