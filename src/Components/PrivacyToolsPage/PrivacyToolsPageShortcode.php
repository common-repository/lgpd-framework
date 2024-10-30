<?php

namespace Data443\LGPD\Components\PrivacyToolsPage;

use Data443\LGPD\Components\Consent\ConsentManager;
class PrivacyToolsPageShortcode {

	protected $consentManager;
	public function __construct( PrivacyToolsPageController $controller, ConsentManager $consentManager ) {
		$this->controller     = $controller;
		$this->consentManager = $consentManager;
		add_shortcode( 'lgpd_privacy_tools', array( $this, 'renderPage' ) );
		add_shortcode( 'lgpd_privacy_tools_url', array( $this, 'renderUrlShortcode' ) );
		add_shortcode( 'lgpd_privacy_tools_link', array( $this, 'renderLinkShortcode' ) );
		add_shortcode( 'lgpd_do_not_sell_form', array( $this, 'renderDoNotSellForm' ) );
		

	}

	public function renderPage() {
		if ( ! lgpd( 'options' )->get( 'enable' ) ) {
			return __( 'This page is currently disabled.', 'lgpd-framework' );
		}

		if ( ( ! lgpd( 'options' )->get( 'tools_page' ) || is_null( get_post( lgpd( 'options' )->get( 'tools_page' ) ) ) ) && ! lgpd( 'options' )->get( 'custom_tools_page' ) ) {
			return __( 'Please configure the Privacy Tools page in the admin interface.', 'lgpd-framework' );
		}

		ob_start();
		$this->controller->render();
		return ob_get_clean();
	}
	public function renderDoNotSellForm() {
		if ( ! lgpd( 'options' )->get( 'enable' ) ) {
			return __( 'This page is currently disabled.', 'lgpd-framework' );
		}

		if ( ! lgpd( 'options' )->get( 'tools_page' ) || is_null( get_post( lgpd( 'options' )->get( 'tools_page' ) ) ) ) {
			return __( 'Please configure the Privacy Tools page in the admin interface.', 'lgpd-framework' );
		}
		$slug                = 'do-not-sell-request';
		$defaultConsentTypes = $this->consentManager->getbySlugConsent( $slug );
		$first_name          = '';
		$last_name           = '';
		$user_email          = '';
		if ( is_user_logged_in() ) {
			// your code for logged in user
			$current_user = wp_get_current_user();
			$first_name   = get_user_meta( $current_user->ID, 'first_name', true );
			if ( $first_name === '' ) {
				$first_name = $current_user->user_nicename;
			}
			$last_name  = get_user_meta( $current_user->ID, 'last_name', true );
			$user_email = $current_user->user_email;
		}
		ob_start();
		// $this->controller->render();
		echo lgpd( 'view' )->render( 'privacy-tools/donotsell', compact( 'defaultConsentTypes', 'first_name', 'last_name', 'user_email' ) );
		return ob_get_clean();
	}
	public function renderUrlShortcode() {
		return lgpd( 'helpers' )->getPrivacyToolsPageUrl();
	}

	public function renderLinkShortcode( $attributes ) {
		$attributes = shortcode_atts(
			array(
				'title' => __( 'Privacy Tools', 'lgpd-framework' ),
			),
			$attributes
		);

		$url = lgpd( 'helpers' )->getPrivacyToolsPageUrl();

		return "<a href='{$url}'>" .
			esc_html( $attributes['title'] ) .
			'</a>';
	}
}
