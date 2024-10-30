<?php

namespace Data443\LGPD;

use Data443\LGPD\DataSubject\DataSubjectAuthenticator;

/**
 * Handles automatically identifying context and triggering actions based on $_REQUEST['lgpd_action']
 *
 * Class Router
 *
 * @package Data443\LGPD
 */
class Router {

	/* @var DataSubjectAuthenticator $authenticator */
	protected $authenticator;

	/**
	 * Router constructor.
	 *
	 * @param DataSubjectAuthenticator $authenticator
	 */
	public function __construct( DataSubjectAuthenticator $authenticator ) {
		$this->authenticator = $authenticator;

		// Routing happens at priority 20 to allow other 'init' actions to complete before
		add_action( 'init', array( $this, 'routeFrontendRequest' ), 20 );
		add_action( 'admin_init', array( $this, 'routeAdminRequest' ), 20 );
	}

	/**
	 * Get and sanitize the action parameter
	 *
	 * @return bool|mixed
	 */
	protected function getAction() {
		if ( ! isset( $_REQUEST['lgpd_action'] ) ) {
			return false;
		}

		// Simple sanitization: allowed chars are alphanumeric, dash, underscore and forward slash.
		return preg_replace( '/[^a-zA-Z0-9_\-\/]/', '', sanitize_key( $_REQUEST['lgpd_action'] ) );
	}

	/**
	 * Detect and trigger proper action in front-end
	 *
	 * @param $action
	 */
	public function routeFrontendRequest() {
		// Since the 'init' hooks runs in both admin and non-admin requests, double-check where we are
		if ( is_admin() ) {
			return;
		}

		// Handle identification by email
		$this->authenticator->identify();

		$action = $this->getAction();
		$nonce  = isset( $_REQUEST['lgpd_nonce'] ) ? sanitize_key( $_REQUEST['lgpd_nonce'] ) : null;

		if ( ! $action ) {
			return;
		}

		$dataSubject = $this->authenticator->authenticate();

		if ( $dataSubject ) {
			$tag = "lgpd/frontend/privacy-tools-page/action/{$action}";
			if ( wp_verify_nonce( $nonce, $tag ) ) {
				$key = isset( $_REQUEST['lgpd_key'] ) ? sanitize_key( $_REQUEST['lgpd_key'] ) : null;
				do_action( $tag, $dataSubject, $key );
			} else {
				wp_die(
					sprintf(
						__( 'Nonce error for action "%s". Please go back and try again!', 'lgpd-framework' ),
						esc_html( $action )
					)
				);
			}
		} else {
			$tag = "lgpd/frontend/action/{$action}";
			if ( wp_verify_nonce( $nonce, $tag ) ) {
				do_action( $tag );
			} else {
				wp_die(
					sprintf(
						__( 'Nonce error for action "%s". Please go back and try again!', 'lgpd-framework' ),
						esc_html( $action )
					)
				);
			}
		}
	}

	/**
	 * Detect and trigger proper action in admin
	 *
	 * @param $action
	 */
	public function routeAdminRequest() {
		$action = $this->getAction();
		$nonce  = isset( $_REQUEST['lgpd_nonce'] ) ? sanitize_key( $_REQUEST['lgpd_nonce'] ) : null;

		if ( ! $action ) {
			return;
		}

		if ( isset( $_GET['page'] ) && 'lgpd-profile' === sanitize_key( $_GET['page'] ) ) {

			$dataSubject = $this->authenticator->authenticate();
			if ( $dataSubject ) {
				$tag = "lgpd/dashboard/privacy-tools/action/{$action}";

				if ( wp_verify_nonce( $nonce, $tag ) ) {
					do_action( $tag, $dataSubject );
				} else {
					wp_die(
						sprintf(
							__( 'Nonce error for action "%s". Please go back and try again!', 'lgpd-framework' ),
							esc_html( $action )
						)
					);
				}
			}
		} else {
			if ( $this->checkAdminPermissions() ) {

				$tag = "lgpd/admin/action/{$action}";

				if ( wp_verify_nonce( $nonce, $tag ) ) {
					do_action( $tag );
				} else {
					wp_die(
						sprintf(
							__( 'Nonce error for action "%s". Please go back and try again!', 'lgpd-framework' ),
							esc_html( $action )
						)
					);
				}
			} else {
				wp_die(
					sprintf(
						_x( 'You do not have the required permissions to perform this action!', '(Admin)', 'lgpd-framework' ),
						esc_html( $action )
					)
				);
			}
		}
	}

	/**
	 * Check if the current user has the correct capability to perform an admin action
	 *
	 * @return bool
	 */
	protected function checkAdminPermissions() {
		return current_user_can( apply_filters( 'lgpd/capability', 'manage_options' ) );
	}
}
