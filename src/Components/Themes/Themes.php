<?php

namespace Data443\LGPD\Components\Themes;

class Themes {

	protected $theme;

	public $supportedThemes = array(
		'twentynineteen',
		'twentyseventeen',
		'twentysixteen',
		'storefront',
	);

	public function __construct() {
		$this->theme = get_option( 'stylesheet' );

		if ( ! $this->isCurrentThemeSupported() || ! lgpd( 'options' )->get( 'enable_theme_compatibility' ) ) {
			return;
		}

		// If both pages aren't defined, bail
		$privacyPolicy    = lgpd( 'options' )->get( 'policy_page' );
		$privacyToolsPage = lgpd( 'options' )->get( 'tools_page' );

		if ( ! $privacyPolicy || ! $privacyToolsPage ) {
			return;
		}

		$theme = $this->theme;
		$this->$theme();
	}

	public function isCurrentThemeSupported() {
		return in_array( $this->theme, $this->supportedThemes );
	}

	public function getCurrentThemeName() {
		return $this->theme;
	}
	public function twentynineteen() {
		add_action( 'the_privacy_policy_link', array( $this, 'rendertwentynineteenFooterLinks' ), 10, 2 );
	}
	public function twentyseventeen() {
		add_action( 'get_template_part_template-parts/footer/site', array( $this, 'renderTwentyseventeenFooterLinks' ), 10, 2 );
	}

	public function twentysixteen() {
		add_action( 'twentysixteen_credits', array( $this, 'renderTwentysixteenFooterLinks' ) );
	}

	public function storefront() {
		// I feel slightly dirty, but also clever
		add_filter( 'storefront_credit_link', array( $this, 'renderStorefrontFooterLinks' ) );
	}
	public function rendertwentynineteenFooterLinks() {

		$privacyPolicyUrl = get_permalink( lgpd( 'options' )->get( 'policy_page' ) );
		add_filter( 'lgpd_custom_policy_link', 'lgpdfPrivacyPolicyurl' );
		$privacyPolicyUrl    = apply_filters( 'lgpd_custom_policy_link', $privacyPolicyUrl );
		$privacyToolsPageUrl = get_permalink( lgpd( 'options' )->get( 'tools_page' ) );

		echo lgpd( 'view' )->render(
			'themes/twentyseventeen/footer',
			compact( 'privacyPolicyUrl', 'privacyToolsPageUrl' )
		);
	}
	public function renderTwentyseventeenFooterLinks( $slug, $name ) {
		if ( 'info' !== $name ) {
			return;
		}

		$privacyPolicyUrl = get_permalink( lgpd( 'options' )->get( 'policy_page' ) );
		add_filter( 'lgpd_custom_policy_link', 'lgpdfPrivacyPolicyurl' );
		$privacyPolicyUrl    = apply_filters( 'lgpd_custom_policy_link', $privacyPolicyUrl );
		$privacyToolsPageUrl = get_permalink( lgpd( 'options' )->get( 'tools_page' ) );

		echo lgpd( 'view' )->render(
			'themes/twentyseventeen/footer',
			compact( 'privacyPolicyUrl', 'privacyToolsPageUrl' )
		);
	}

	public function renderTwentysixteenFooterLinks() {
		$privacyPolicyUrl = get_permalink( lgpd( 'options' )->get( 'policy_page' ) );
		add_filter( 'lgpd_custom_policy_link', 'lgpdfPrivacyPolicyurl' );
		$privacyPolicyUrl    = apply_filters( 'lgpd_custom_policy_link', $privacyPolicyUrl );
		$privacyToolsPageUrl = get_permalink( lgpd( 'options' )->get( 'tools_page' ) );

		echo lgpd( 'view' )->render(
			'themes/twentysixteen/footer',
			compact( 'privacyPolicyUrl', 'privacyToolsPageUrl' )
		);
	}

	public function renderStorefrontFooterLinks( $value ) {
		$privacyPolicyUrl = get_permalink( lgpd( 'options' )->get( 'policy_page' ) );
		add_filter( 'lgpd_custom_policy_link', 'lgpdfPrivacyPolicyurl' );
		$privacyPolicyUrl    = apply_filters( 'lgpd_custom_policy_link', $privacyPolicyUrl );
		$privacyToolsPageUrl = get_permalink( lgpd( 'options' )->get( 'tools_page' ) );

		echo lgpd( 'view' )->render(
			'themes/storefront/footer',
			compact( 'privacyPolicyUrl', 'privacyToolsPageUrl' )
		);

		return $value;
	}
}