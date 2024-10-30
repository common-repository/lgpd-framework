<?php
/**
 * Description:       Tools to help make your website LGPD-compliant. Fully documented, extendable and developer-friendly.
 * @package WordPress
 */

add_action( 'wp_ajax_lgpd_add_consent_accept_cookies', 'lgpd_add_consent_accept_cookies' );
add_action( 'wp_ajax_nopriv_lgpd_add_consent_accept_cookies', 'lgpd_add_consent_accept_cookies' );

/**
 * Ajax function on accept cookie button
 */
function lgpd_add_consent_accept_cookies()
{
    $referer = isset( $_SERVER['HTTP_REFERER'] );
    $address = isset( $_SERVER['SERVER_NAME'] );
    if ( $referer ) {
        if ( strpos( $address, $referer ) !== 0 ) {
            global $wpdb;
            $table_name    = $wpdb->prefix . 'lgpd_consent';
            $current_user = wp_get_current_user();
            $user_email   = sanitize_email( $current_user->user_email );
            if ( '' == $user_email && isset( $_COOKIE['lgpd_key'] ) ) {
                $email      = explode( '|', sanitize_text_field( wp_unslash( $_COOKIE['lgpd_key'] ) ) );
                $user_email = sanitize_email( $email['0'] );
            }

            if (!empty($user_email)) {
                $future_date = '8999-12-31 23:59:59';
                $consent = 'lgpd_cookie_consent';

                $n = count(
                            $wpdb->get_results(
                                $wpdb->prepare(
                                    "SELECT * FROM {$table_name} WHERE email = %s AND consent = %s;",
                                    $user_email,
                                    $consent
                                )
                            )
                        );

                if ($n > 0) {
                    $wpdb->update(
                        $table_name,
                        [
                            'status'      => 1,
                            'updated_at'  => current_time( 'mysql' ),
                            'ip'          => $_SERVER['REMOTE_ADDR'],
                            'valid_until' => $future_date,
                        ],
                        [
                            'email'   => $user_email,
                            'consent' => $consent,
                        ]
                    );
                } else {
                    $wpdb->insert(
                        $table_name,
                        array(
                            'email'      => $user_email,
                            'version'    => 1,
                            'consent'    => $consent,
                            'status'     => 1,
                            'updated_at' => current_time( 'mysql' ),
                            'ip'         => $_SERVER['REMOTE_ADDR'],
                            'valid_until' => $future_date,
                        )
                    );
                }
                do_action( 'lgpd_consent_accept_cookies' );
            }
            wp_die();
        } else {
            echo 'Error !!!';
            wp_die();
        }
    } else {
        echo 'ERROR !!';
        wp_die();
    }
}
add_action( 'wp_ajax_lgpd_add_consent_deny_cookies', 'lgpd_add_consent_deny_cookies' );
add_action( 'wp_ajax_nopriv_lgpd_add_consent_deny_cookies', 'lgpd_add_consent_deny_cookies' );

/**
 * ajax function on deny cookie button
 */
function lgpd_add_consent_deny_cookies()
{
    $referer = $_SERVER['HTTP_REFERER'];
    $address = $_SERVER['SERVER_NAME'];
    if ( $referer ) {
        if ( strpos( $address, $referer ) !== 0 ) {
            global $wpdb;
            $table_name    = $wpdb->prefix . 'lgpd_consent';
            $current_user = wp_get_current_user();
            $user_email   = sanitize_email( $current_user->user_email );
            if ( '' == $user_email && isset( $_COOKIE['lgpd_key'] ) ) {
                $email      = explode( '|', sanitize_text_field( wp_unslash( $_COOKIE['lgpd_key'] ) ) );
                $user_email = sanitize_email( $email['0'] );
            }

            if (!empty($user_email)) {
                $future_date = '7999-12-31 23:59:59';
                $consent = 'lgpd_cookie_consent';
    
                $n = count(
                            $wpdb->get_results(
                                $wpdb->prepare(
                                    "SELECT * FROM {$table_name} WHERE email = %s AND consent = %s;",
                                    $user_email,
                                    $consent
                                )
                            )
                        );
    
                if ($n > 0) {
                    $wpdb->update(
                        $table_name,
                        [
                            'version'     => 1,
                            'status'      => 0,
                            'updated_at'  => current_time( 'mysql' ),
                            'ip'          => $_SERVER['REMOTE_ADDR'],
                            'valid_until' => $future_date,
                        ],
                        [
                            'email'   => $user_email,
                            'consent' => $consent,
                        ]
                    );
                } else {
                    $wpdb->insert(
                        $table_name,
                        array(
                            'email'      => $user_email,
                            'version'    => 1,
                            'consent'    => $consent,
                            'status'     => 0,
                            'updated_at' => current_time( 'mysql' ),
                            'ip'         => $_SERVER['REMOTE_ADDR'],
                            'valid_until' => $future_date,
                        )
                    );
                }
                do_action( 'lgpd_consent_deny_cookies' );
            }
            wp_die();
        } else {
            echo 'Error !!!';
            wp_die();
        }
    } else {
        echo 'ERROR !!';
        wp_die();
    }
}

/**
 * popup cookieconsent scipts
 */
function popup_lgpd() {

	$nonce = wp_create_nonce( 'popup_lgpd' );
	wp_register_script( 'lgpd-framework-cookieconsent-min-js', lgpd( 'config' )->get( 'plugin.url' ) . 'assets/js/cookieconsent.min.js', array(), true, true );

	wp_localize_script( 
		'lgpd-framework-cookieconsent-min-js',
		'popup_lgpd',
		array(
			'nonce' => $nonce,
		)
	);
	wp_enqueue_script( 'lgpd-framework-cookieconsent-min-js', lgpd( 'config' )->get( 'plugin.url' ) . 'assets/js/cookieconsent.min.js' );

	wp_enqueue_style( 'lgpd-framework-cookieconsent-css', lgpd( 'config' )->get( 'plugin.url' ) . 'assets/css/cookieconsent.min.css' );
	

	$lgpd_policy_page_id = get_option( 'lgpd_policy_page' );
	if ( $lgpd_policy_page_id ) {
		$lgpd_policy_page_url = get_permalink( $lgpd_policy_page_id );
		/*
		* FIX FOR MULTILANG.
		*/
		if ( $lgpd_policy_page_url == '' ) {
			if ( isset( $lgpd_policy_page_id[ substr( get_bloginfo( 'language' ), 0, 2 ) ] ) ) {
				$lgpd_policy_page_url = get_permalink( $lgpd_policy_page_id[ substr( get_bloginfo( 'language' ), 0, 2 ) ] );
			}
		}
	} else {
		$lgpd_policy_page_url = '';
	}
	add_filter( 'lgpd_custom_policy_link', 'lgpdfPrivacyPolicyurl' );

	$lgpd_policy_page_url = apply_filters( 'lgpd_custom_policy_link', $lgpd_policy_page_url );

	$lgpd_cookie_acceptance_content_url = get_option( 'lgpd_popup_content' );

	$lgpd_cookie_acceptance_content_url = do_shortcode( $lgpd_cookie_acceptance_content_url );

	if ( $lgpd_cookie_acceptance_content_url != '' ) {
		$lgpd_message = __( $lgpd_cookie_acceptance_content_url, 'lgpd-framework' );
	} else {
		$lgpd_message = __( 'This website uses cookies to ensure you get the best experience on our website.', 'lgpd-framework' );
	}

	$lgpd_cookie_dismiss_text_url = get_option( 'lgpd_popup_dismiss_text' );

	$lgpd_cookie_dismiss_text_url = do_shortcode( $lgpd_cookie_dismiss_text_url );

	if ( $lgpd_cookie_dismiss_text_url != '' ) {
		$lgpd_dismiss = __( $lgpd_cookie_dismiss_text_url, 'lgpd-framework' );
	} else {
		$lgpd_dismiss = __( 'Decline', 'lgpd-framework' );
	}

	$lgpd_cookie_allow_text_url = get_option( 'lgpd_popup_allow_text' );

	$lgpd_cookie_allow_text_url = do_shortcode( $lgpd_cookie_allow_text_url );

	if ( $lgpd_cookie_dismiss_text_url != '' ) {
		$lgpd_allow = __( $lgpd_cookie_allow_text_url, 'lgpd-framework' );
	} else {
		$lgpd_allow = __( 'Accept', 'lgpd-framework' );
	}

	$lgpd_cookie_learnmore_text_url = get_option( 'lgpd_popup_learnmore_text' );

	$lgpd_cookie_learnmore_text_url = do_shortcode( $lgpd_cookie_learnmore_text_url );

	if ( $lgpd_cookie_learnmore_text_url != '' ) {
		$lgpd_link = __( $lgpd_cookie_learnmore_text_url, 'lgpd-framework' );
	} else {
		$lgpd_link = __( 'Learn more', 'lgpd-framework' );
	}

	$position = get_option( 'lgpd_popup_position' ); // "bottom-left","top","bottom-right",""

	$static = false; // true

	$lgpd_header = get_option( 'lgpd_header' );

	$lgpd_header = do_shortcode( $lgpd_header );

	if ( $lgpd_header != '' ) {
		$lgpd_header = __( $lgpd_header, 'lgpd-framework' );
	}

	$lgpd_popup_background = get_option( 'lgpd_popup_background' );

	$lgpd_popup_text = get_option( 'lgpd_popup_text' );

	$lgpd_button_background = get_option( 'lgpd_popup_button_background' );

	$lgpd_button_text = get_option( 'lgpd_popup_button_text' );

	$lgpd_link_target = get_option( 'lgpd_popup_link_target' );

	if ( ! $lgpd_link_target ) {
		$lgpd_link_target = '_blank';
	}

	$lgpd_button_border = get_option( 'lgpd_popup_border_text' );

	if ( ! $lgpd_popup_background ) {
		$lgpd_popup_background = '#efefef';
	}
	if ( ! $lgpd_popup_text ) {
		$lgpd_popup_text = '#404040';
	}
	if ( ! $lgpd_button_background ) {
		$lgpd_button_background = 'transparent';
	}
	if ( ! $lgpd_button_text ) {
		$lgpd_button_text = '#8ec760';
	}
	if ( ! $lgpd_button_border ) {
		$lgpd_button_border = '#8ec760';
	}

	$lgpd_popup_theme = get_option( 'lgpd_popup_theme' );

	$lgpd_policy_popup = get_option( 'lgpd_policy_popup' );

	$lgpd_hide = get_option( 'lgpd_onetime_popup' );

	$type = 'opt-out'; // opt-in,opt-out,""

	$policy_text = __( 'Cookie Policy', 'lgpd-framework' );

	$get_lgpd_data = array(
		'lgpd_url'               => $lgpd_policy_page_url,

		'lgpd_message'           => $lgpd_message,

		'lgpd_dismiss'           => $lgpd_dismiss,

		'lgpd_allow'             => $lgpd_allow,

		'lgpd_header'            => $lgpd_header,

		'lgpd_link'              => $lgpd_link,

		'lgpd_popup_position'    => $position,

		'lgpd_popup_type'        => $type,

		'lgpd_popup_static'      => $static,

		'lgpd_popup_background'  => $lgpd_popup_background,

		'lgpd_popup_text'        => $lgpd_popup_text,

		'lgpd_button_background' => $lgpd_button_background,

		'lgpd_button_text'       => $lgpd_button_text,
		'lgpd_button_border'     => $lgpd_button_border,

		'lgpd_popup_theme'       => $lgpd_popup_theme,

		'lgpd_hide'              => $lgpd_hide,

		'lgpd_popup'             => $lgpd_policy_popup,

		'policy'                 => $policy_text,

		'ajaxurl'                => admin_url( 'admin-ajax.php' ),

		'lgpd_link_target'       => $lgpd_link_target,
	);

	wp_register_script( 'lgpd-framework-cookieconsent-js', lgpd( 'config' )->get( 'plugin.url' ) . 'assets/js/ajax-cookieconsent.js', array(), false, true );

	wp_localize_script( 'lgpd-framework-cookieconsent-js', 'lgpd_policy_page', $get_lgpd_data );

	wp_enqueue_script( 'lgpd-framework-cookieconsent-js', lgpd( 'config' )->get( 'plugin.url' ) . 'assets/js/ajax-cookieconsent.js' );

	
}
/**
 * Cookie acceptance Popup
 */
$enabled_gdpf_cookie_popup = get_option( 'lgpd_enable_popup' );
if ( $enabled_gdpf_cookie_popup ) {
	add_action( 'wp_enqueue_scripts', 'lgpd_frontend_enqueue' );
	function lgpd_frontend_enqueue() {
		wp_enqueue_script( 'jquery' );
		if ( get_option( 'lgpd_onetime_popup' ) == '1' ) {
			if ( ! isset( $_COOKIE['cookieconsent_status'] ) ) {
				popup_lgpd();
			}
		} else {
			popup_lgpd();
		}
	}
}

function lgpdTermAndConditionWithPrivacyContent() {
	 return __('I accept the %sTerms and Conditions%s and the %sPrivacy Policy%s', 'lgpd-framework');
}

function lgpdfPrivacyPolicy() {
	 return __('I accept the %sPrivacy Policy%s', 'lgpd-framework');
}

function lgpdfPrivacyPolicyurl( $policypage ) {
	$policypageURL = get_option( 'lgpd_custom_policy_page' );
	if ( $policypageURL == '' ) {
		return esc_url_raw( $policypage );
	} else {
		return esc_url_raw( $policypageURL );
	}
}

function lgpd_privacy_accpetance( $lgpd_error_massage ) {
	return $lgpd_error_massage;
}

/**
 * Save user logs
 */
add_action( 'profile_update', 'lgpd_my_profile_update', 10, 2 );

function lgpd_my_profile_update( $user_id, $old_user_data ) {
	$data              = (array) $old_user_data->data;
	$all_meta_for_user = get_user_meta( $user_id );
	if ( $all_meta_for_user['nickname']['0'] ) {
		$data['nickname'] = sanitize_text_field( $all_meta_for_user['nickname']['0'] );
	}
	if ( $all_meta_for_user['first_name']['0'] ) {
		$data['first_name'] = sanitize_email( $all_meta_for_user['first_name']['0'] );
	}
	if ( $all_meta_for_user['last_name']['0'] ) {
		$data['last_name'] = sanitize_text_field( $all_meta_for_user['last_name']['0'] );
	}
	if ( $all_meta_for_user['description']['0'] ) {
		$data['description'] = sanitize_text_field( $all_meta_for_user['description']['0'] );
	}
	$userdata = serialize( $data );
	$model    = new \Data443\LGPD\Components\Consent\UserConsentModel();
	$model->savelog( $user_id, $userdata );
}

