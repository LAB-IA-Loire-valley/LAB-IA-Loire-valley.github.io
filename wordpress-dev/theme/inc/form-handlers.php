<?php
/** Public contact form handlers. */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

add_action( 'admin_post_nopriv_labia_contact_form', 'labia_handle_contact_form' );
add_action( 'admin_post_labia_contact_form', 'labia_handle_contact_form' );

/** Validate and send a contact or offer enquiry. */
function labia_handle_contact_form() {
    $form = isset( $_POST['labia_form'] ) ? sanitize_key( wp_unslash( $_POST['labia_form'] ) ) : '';
    if ( ! in_array( $form, array( 'contact', 'offre' ), true ) ) {
        wp_die( esc_html__( 'Formulaire invalide.', 'labia' ), '', array( 'response' => 400 ) );
    }

    $return_url = isset( $_POST['return_url'] ) ? esc_url_raw( wp_unslash( $_POST['return_url'] ) ) : '';
    $fallback   = home_url( $form === 'contact' ? '/contact/' : '/notre-offre/' );
    $return_url = wp_validate_redirect( $return_url, $fallback );
    $redirect   = static function ( $status ) use ( $return_url ) {
        wp_safe_redirect( add_query_arg( 'form_status', $status, $return_url ) . '#form-feedback' );
        exit;
    };

    $nonce = isset( $_POST['labia_form_nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['labia_form_nonce'] ) ) : '';
    if ( ! wp_verify_nonce( $nonce, 'labia_' . $form . '_form' ) ) {
        $redirect( 'error' );
    }

    // Honeypot and minimum completion time are low-friction bot checks.
    $honeypot = isset( $_POST['website'] ) ? trim( (string) wp_unslash( $_POST['website'] ) ) : '';
    $started  = isset( $_POST['form_started'] ) ? absint( $_POST['form_started'] ) : 0;
    // A cached page can legitimately carry an old timestamp; only enforce the
    // minimum completion time and reject timestamps implausibly in the future.
    if ( $honeypot !== '' || ! $started || time() - $started < 3 || $started > time() + 300 ) {
        $redirect( 'error' );
    }

    $limits = array(
        'name' => 160,
        'organization' => 200,
        'email' => 254,
        'phone' => 40,
        'request' => 100,
        'participants' => 4,
        'message' => 5000,
    );
    // Bound the entire submitted payload as well as every accepted field.
    if ( strlen( serialize( $_POST ) ) > 12000 ) {
        $redirect( 'error' );
    }

    $fields = array();
    foreach ( $limits as $key => $max_length ) {
        if ( isset( $_POST[ $key ] ) && ! is_scalar( $_POST[ $key ] ) ) {
            $redirect( 'error' );
        }
        $raw = isset( $_POST[ $key ] ) ? wp_unslash( $_POST[ $key ] ) : '';
        if ( strlen( $raw ) > $max_length ) {
            $redirect( 'error' );
        }
        $fields[ $key ] = $key === 'message' ? sanitize_textarea_field( $raw ) : sanitize_text_field( $raw );
    }

    $valid = is_email( $fields['email'] ) && $fields['name'] !== '';
    if ( $form === 'contact' ) {
        $valid = $valid && $fields['request'] !== '' && $fields['message'] !== '' && isset( $_POST['consent'] );
    } else {
        $valid = $valid && $fields['phone'] !== '' && isset( $_POST['consent'] );
        if ( $fields['participants'] !== '' && ( ! ctype_digit( $fields['participants'] ) || (int) $fields['participants'] < 1 ) ) {
            $valid = false;
        }
    }
    $allowed_requests = $form === 'contact'
        ? array( 'Accompagnement d\'un projet Data / IA', 'Formation pour mon équipe', 'Conférence / Sensibilisation', 'Partenariat', 'Presse / Médias', 'Autre demande' )
        : array( '', 'Un accompagnement projet', 'Une formation', 'Une conférence / sensibilisation', 'Autre' );
    if ( ! in_array( $fields['request'], $allowed_requests, true ) ) {
        $valid = false;
    }
    if ( ! $valid ) {
        $redirect( 'error' );
    }

    $recipient = sanitize_email( labia_opt( 'email', 'contact@labia-loirevalley.fr' ) );
    if ( ! is_email( $recipient ) ) {
        $redirect( 'error' );
    }

    // Store only a keyed digest of the remote address, never the address itself.
    $remote_address = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '';
    $rate_key = 'labia_form_rate_' . hash_hmac( 'sha256', $remote_address, wp_salt( 'auth' ) );
    $rate_count = (int) get_transient( $rate_key );
    if ( $rate_count >= 5 ) {
        $redirect( 'error' );
    }
    set_transient( $rate_key, $rate_count + 1, HOUR_IN_SECONDS );

    $labels = array(
        'name'         => $form === 'contact' ? 'Prénom & Nom' : 'Nom / Société',
        'organization' => 'Société / Organisation',
        'email'        => 'Email',
        'phone'        => 'Téléphone',
        'request'      => $form === 'contact' ? 'Objet de la demande' : 'Besoin',
        'participants' => 'Nombre de participants',
        'message'      => 'Message',
    );

    // Repli texte brut (certains clients mail n'affichent pas le HTML).
    $body = "Nouvelle demande depuis le formulaire " . ( $form === 'contact' ? 'Contact' : 'Notre Offre' ) . "\n\n";
    foreach ( $labels as $key => $label ) {
        if ( $fields[ $key ] !== '' ) {
            $body .= $label . ': ' . $fields[ $key ] . "\n";
        }
    }

    $subject   = 'Nouvelle demande · LAB\'IA Loire Valley (' . ( $form === 'contact' ? 'Contact' : 'Notre Offre' ) . ')';
    $html_body = labia_enquiry_email_html( $form, $fields, $labels );
    $headers   = array(
        'Reply-To: ' . $fields['email'],
        'Content-Type: text/html; charset=UTF-8',
    );

    // Fournit la version texte comme alternative si le client préfère le plain text.
    $alt_body_filter = static function ( $phpmailer ) use ( $body ) {
        $phpmailer->AltBody = $body;
    };
    add_action( 'phpmailer_init', $alt_body_filter );
    $sent = wp_mail( $recipient, $subject, $html_body, $headers );
    remove_action( 'phpmailer_init', $alt_body_filter );

    $redirect( $sent ? 'success' : 'error' );
}

/**
 * Rendu HTML de la notification de demande (mise en forme aux couleurs du site).
 * Tableaux + styles inline pour rester lisible dans Outlook/Gmail/Apple Mail.
 *
 * @param string $form   'contact' ou 'offre'.
 * @param array  $fields Champs nettoyés du formulaire.
 * @param array  $labels Libellés humains par clé de champ.
 * @return string
 */
function labia_enquiry_email_html( $form, $fields, $labels ) {
    $form_label = $form === 'contact' ? 'Contact' : 'Notre Offre';
    $site       = get_bloginfo( 'name' );
    $logo       = LABIA_THEME_URI . '/assets/img/logos/logo-labia-loire-valley.png';
    $home       = home_url( '/' );

    $magenta = '#E2007D';
    $faint   = '#FFF0F7';
    $ink     = '#111111';
    $muted   = '#6B6B6B';
    $border  = '#EAEAEA';
    $bg      = '#F4F4F7';
    $sans    = "Arial,'Helvetica Neue',Helvetica,sans-serif";

    $rows = '';
    foreach ( $labels as $key => $label ) {
        if ( $key === 'message' || $fields[ $key ] === '' ) {
            continue;
        }
        $value = esc_html( $fields[ $key ] );
        if ( $key === 'email' ) {
            $value = '<a href="mailto:' . esc_attr( $fields[ $key ] ) . '" style="color:' . $magenta . ';text-decoration:none;">' . $value . '</a>';
        } elseif ( $key === 'phone' ) {
            $value = '<a href="tel:' . esc_attr( preg_replace( '/\s+/', '', $fields[ $key ] ) ) . '" style="color:' . $magenta . ';text-decoration:none;">' . $value . '</a>';
        }
        $rows .= '<tr>'
            . '<td style="padding:11px 0;border-bottom:1px solid ' . $border . ';font:600 11px/1.4 ' . $sans . ';text-transform:uppercase;letter-spacing:.05em;color:' . $muted . ';width:40%;vertical-align:top;">' . esc_html( $label ) . '</td>'
            . '<td style="padding:11px 0;border-bottom:1px solid ' . $border . ';font:400 15px/1.5 ' . $sans . ';color:' . $ink . ';vertical-align:top;">' . $value . '</td>'
            . '</tr>';
    }

    $message_block = '';
    if ( $fields['message'] !== '' ) {
        $message_block = '<tr><td style="padding:22px 32px 0;" colspan="2">'
            . '<div style="font:600 11px/1.4 ' . $sans . ';text-transform:uppercase;letter-spacing:.05em;color:' . $muted . ';margin-bottom:8px;">Message</div>'
            . '<div style="background:' . $bg . ';border-left:3px solid ' . $magenta . ';border-radius:4px;padding:16px 18px;font:400 15px/1.65 ' . $sans . ';color:' . $ink . ';">' . nl2br( esc_html( $fields['message'] ) ) . '</div>'
            . '</td></tr>';
    }

    $reply_subject = rawurlencode( 'Re: votre demande — ' . $site );
    $reply_btn = '<tr><td style="padding:26px 32px 32px;" colspan="2">'
        . '<a href="mailto:' . esc_attr( $fields['email'] ) . '?subject=' . $reply_subject . '" style="display:inline-block;background:' . $magenta . ';color:#ffffff;font:700 14px/1 ' . $sans . ';text-decoration:none;padding:14px 24px;border-radius:999px;">Répondre au visiteur</a>'
        . '</td></tr>';

    $received = function_exists( 'wp_date' ) ? wp_date( 'j F Y \à H\hi' ) : date_i18n( 'j F Y \à H\hi' );

    return '<!DOCTYPE html><html lang="fr"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>'
        . esc_html( 'Nouvelle demande — ' . $form_label )
        . '</title></head>'
        . '<body style="margin:0;padding:0;background:' . $bg . ';">'
        . '<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:' . $bg . ';"><tr><td align="center" style="padding:28px 12px;">'
        . '<table role="presentation" width="600" cellpadding="0" cellspacing="0" style="width:600px;max-width:600px;background:#ffffff;border:1px solid ' . $border . ';border-radius:12px;overflow:hidden;">'
        . '<tr><td colspan="2" style="height:5px;line-height:5px;font-size:0;background:' . $magenta . ';">&nbsp;</td></tr>'
        . '<tr><td colspan="2" style="padding:28px 32px 0;">'
        . '<img src="' . esc_url( $logo ) . '" alt="' . esc_attr( $site ) . '" height="54" style="height:54px;width:auto;display:block;border:0;"></td></tr>'
        . '<tr><td colspan="2" style="padding:20px 32px 4px;">'
        . '<div style="font:700 22px/1.3 ' . $sans . ';color:' . $ink . ';">Nouvelle demande</div>'
        . '<div style="margin-top:10px;">'
        . '<span style="display:inline-block;background:' . $faint . ';color:' . $magenta . ';font:700 12px/1 ' . $sans . ';text-transform:uppercase;letter-spacing:.05em;padding:7px 12px;border-radius:999px;">Formulaire ' . esc_html( $form_label ) . '</span>'
        . '</div>'
        . '<div style="margin-top:10px;font:400 13px/1.5 ' . $sans . ';color:' . $muted . ';">Reçue le ' . esc_html( $received ) . '</div>'
        . '</td></tr>'
        . '<tr><td colspan="2" style="padding:8px 32px 0;">'
        . '<table role="presentation" width="100%" cellpadding="0" cellspacing="0">' . $rows . '</table>'
        . '</td></tr>'
        . $message_block
        . $reply_btn
        . '</table>'
        . '<div style="max-width:600px;width:600px;margin:14px auto 0;font:400 12px/1.6 ' . $sans . ';color:#8A8A8A;text-align:center;">'
        . 'Envoyé depuis le formulaire « ' . esc_html( $form_label ) . ' » du site <a href="' . esc_url( $home ) . '" style="color:#8A8A8A;">' . esc_html( $site ) . '</a>.'
        . '</div>'
        . '</td></tr></table></body></html>';
}
