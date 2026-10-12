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
    $body = "Nouvelle demande depuis le formulaire " . ( $form === 'contact' ? 'Contact' : 'Notre Offre' ) . "\n\n";
    foreach ( $labels as $key => $label ) {
        if ( $fields[ $key ] !== '' ) {
            $body .= $label . ': ' . $fields[ $key ] . "\n";
        }
    }

    $subject = 'Nouvelle demande · LAB\'IA Loire Valley (' . ( $form === 'contact' ? 'Contact' : 'Notre Offre' ) . ')';
    $headers = array( 'Reply-To: ' . $fields['email'] );
    $sent    = wp_mail( $recipient, $subject, $body, $headers );
    $redirect( $sent ? 'success' : 'error' );
}
