<?php
/**
 * Migration one-shot : insère les images attachées (au-delà de l'image à la
 * une) dans post_content sous forme de blocs image Gutenberg.
 *
 * Les imports Wix ont sideloadé toutes les images mais n'ont mis que la
 * première en image à la une ; les autres sont restées de simples pièces
 * jointes, invisibles dans l'éditeur.
 *
 * Usage :
 *   docker exec labia_wp wp eval-file wp-content/themes/labia-wp/inc/migrate-news-images.php --allow-root          (dry-run)
 *   docker exec labia_wp wp eval-file wp-content/themes/labia-wp/inc/migrate-news-images.php apply --allow-root    (écriture)
 *   ... cleanup (supprime les pièces jointes doublons physiques)   (à valider séparément)
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$mode = $args[0] ?? 'dry';

if ( 'apply' === $mode || 'fixurls' === $mode ) {
    // En CLI aucun utilisateur n'est connecté : kses est actif et supprimerait
    // les commentaires de blocs Gutenberg (<!-- wp:image -->).
    wp_set_current_user( 1 );
    kses_remove_filters();
}

/**
 * Markup canonique d'un bloc image Gutenberg (identique à ce que save()
 * génère) : src/alt/class seulement. WordPress ajoute srcset/sizes/loading au
 * rendu via wp_filter_content_tags ; les stocker ferait échouer la validation
 * de bloc dans l'éditeur (« contenu inattendu »).
 *
 * WP_HOME est dynamique (host courant). En CLI il vaut « http://localhost »,
 * ce qui graverait un host invalide dans le contenu. On stocke donc une URL
 * racine-relative pour que le contenu fonctionne sur tous les hosts.
 */
function labia_image_block( $aid ) {
    $aid = (int) $aid;
    $src = wp_get_attachment_image_url( $aid, 'large' );
    if ( ! $src ) {
        return '';
    }
    $src = str_replace( untrailingslashit( home_url() ), '', $src );
    $alt = (string) get_post_meta( $aid, '_wp_attachment_image_alt', true );

    return "<!-- wp:image {\"id\":{$aid},\"sizeSlug\":\"large\",\"linkDestination\":\"none\"} -->\n"
        . '<figure class="wp-block-image size-large">'
        . '<img src="' . esc_url( $src ) . '" alt="' . esc_attr( $alt ) . '" class="wp-image-' . $aid . '"/>'
        . '</figure>'
        . "\n<!-- /wp:image -->";
}

// Réécrit les blocs déjà insérés dans leur forme canonique Gutenberg.
if ( 'fixblocks' === $mode ) {
    $fixed = 0;
    $ids   = get_posts( array(
        'post_type'      => 'post',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'fields'         => 'ids',
        's'              => 'wp:image',
    ) );
    foreach ( $ids as $pid ) {
        $content = get_post_field( 'post_content', $pid );
        $new     = preg_replace_callback(
            '#<!-- wp:image \{"id":(\d+)[^}]*\} -->.*?<!-- /wp:image -->#s',
            function ( $m ) {
                $block = labia_image_block( (int) $m[1] );
                return $block !== '' ? $block : $m[0];
            },
            $content
        );
        if ( $new !== $content ) {
            wp_update_post( array( 'ID' => $pid, 'post_content' => $new ) );
            $fixed++;
        }
    }
    echo "=== fixblocks : {$fixed} post(s) corrigé(s) ===\n";
    return;
}

$posts = get_posts( array(
    'post_type'      => 'post',
    'post_status'    => 'publish',
    'posts_per_page' => -1,
    'fields'         => 'ids',
) );

$stats = array(
    'posts_updated'    => 0,
    'images_inserted'  => 0,
    'duplicates_found' => 0,
);

foreach ( $posts as $pid ) {
    $post     = get_post( $pid );
    $content  = $post->post_content;
    $thumb    = (int) get_post_thumbnail_id( $pid );
    $children = get_children( array(
        'post_parent' => $pid,
        'post_type'   => 'attachment',
        'post_status' => 'inherit',
        'fields'      => 'ids',
    ) );
    if ( ! $children ) {
        continue;
    }
    sort( $children, SORT_NUMERIC );

    // Regroupe les pièces jointes par empreinte physique (md5).
    $groups = array();
    foreach ( $children as $aid ) {
        $file = get_attached_file( $aid );
        if ( ! $file || ! file_exists( $file ) ) {
            continue;
        }
        $groups[ md5_file( $file ) ][] = (int) $aid;
    }

    // Garde l'image à la une si possible, sinon la plus récente de chaque groupe.
    $canonical = array();
    foreach ( $groups as $ids ) {
        $keep = in_array( $thumb, $ids, true ) ? $thumb : max( $ids );
        $canonical[] = $keep;
        $stats['duplicates_found'] += count( $ids ) - 1;
    }
    sort( $canonical, SORT_NUMERIC );

    $extras = array_values( array_diff( $canonical, array( $thumb ) ) );

    // Idempotence : ignore les images déjà présentes dans le contenu.
    $to_insert = array();
    foreach ( $extras as $aid ) {
        if ( strpos( $content, 'wp-image-' . $aid ) === false ) {
            $to_insert[] = $aid;
        }
    }
    if ( ! $to_insert ) {
        continue;
    }

    $blocks = '';
    foreach ( $to_insert as $aid ) {
        $block = labia_image_block( $aid );
        if ( $block ) {
            $blocks .= "\n\n" . $block;
        }
    }
    if ( ! $blocks ) {
        continue;
    }

    printf(
        "[%s] #%d « %s » : +%d image(s) (%s)%s\n",
        $mode,
        $pid,
        mb_substr( $post->post_title, 0, 60 ),
        count( $to_insert ),
        implode( ',', $to_insert ),
        $mode === 'apply' ? '' : ' (dry-run)'
    );

    $stats['posts_updated']++;
    $stats['images_inserted'] += count( $to_insert );

    if ( 'apply' === $mode ) {
        wp_update_post( array(
            'ID'           => $pid,
            'post_content' => rtrim( $content ) . $blocks,
        ) );
    }
}

echo "\n=== Migration images actualités ({$mode}) ===\n";
echo "Posts mis à jour        : {$stats['posts_updated']}\n";
echo "Images insérées         : {$stats['images_inserted']}\n";
echo "Doublons physiques vus  : {$stats['duplicates_found']}\n";
