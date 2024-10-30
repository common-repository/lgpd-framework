<?php

namespace Data443\LGPD\Components\PrivacyPolicy;

/**
 * Handles putting together and rendering the privacy policy page
 *
 * Class PrivacyPolicy
 *
 * @package Data443\LGPD\Components\PrivacyPolicy
 */
class PrivacyPolicy {

	public function __construct() {
		add_filter( 'lgpd/admin/tabs', array( $this, 'registerAdminTab' ), 35 );

		add_shortcode( 'lgpd_privacy', array( $this, 'doShortcode' ) );
		add_shortcode( 'lgpd_privacy_policy_url', array( $this, 'renderUrlShortcode' ) );
		add_shortcode( 'lgpd_privacy_policy_link', array( $this, 'renderLinkShortcode' ) );
	}

	public function registerAdminTab( $tabs ) {
		$tabs['privacy-policy'] = new AdminTabPrivacyPolicy(new PolicyGenerator());

		return $tabs;
	}

	public function doShortcode( $attributes ) {
		$attributes = shortcode_atts(
			array(
				'item' => null,
			),
			$attributes
		);

		switch ( $attributes['item'] ) {
			case 'company_name':
				return esc_html( lgpd( 'options' )->get( 'company_name' ) );
			case 'company_email':
				return esc_html( lgpd( 'options' )->get( 'contact_email' ) );
			case 'company_email_link':
				$email = antispambot( lgpd( 'options' )->get( 'contact_email' ) );
				return "<a href='mailto:{$email}'>{$email}</a>";
			case 'dpo_name':
				return esc_html( lgpd( 'options' )->get( 'dpo_name' ) );
			case 'dpo_email':
				return esc_html( lgpd( 'options' )->get( 'dpo_email' ) );
			case 'dpo_email_link':
				$email = antispambot( lgpd( 'options' )->get( 'dpo_email' ) );
				return "<a href='mailto:{$email}'>{$email}</a>";
			case 'rep_name':
				return esc_html( lgpd( 'options' )->get( 'representative_contact_name' ) );
			case 'rep_email':
				return esc_html( lgpd( 'options' )->get( 'representative_contact_email' ) );
			case 'rep_email_link':
				$email = antispambot( lgpd( 'options' )->get( 'representative_contact_email' ) );
				return "<a href='mailto:{$email}'>{$email}</a>";
			case 'authority_website':
				return esc_html( lgpd( 'options' )->get( 'dpa_website' ) );
			case 'authority_email':
				return esc_html( lgpd( 'options' )->get( 'dpa_email' ) );
			case 'authority_email_link':
				$email = antispambot( lgpd( 'options' )->get( 'dpa_email' ) );
				return "<a href='mailto:{$email}'>{$email}</a>";
			case 'authority_phone':
				return esc_html( lgpd( 'options' )->get( 'dpa_phone' ) );
			case null:
				return '';
		}

		return '';
	}

	public function renderUrlShortcode() {
		return lgpd( 'helpers' )->getPrivacyPolicyPageUrl();
	}

	public function renderLinkShortcode( $attributes ) {
		$attributes = shortcode_atts(
			array(
				'title' => __( 'Privacy Policy', 'lgpd-framework' ),
			),
			$attributes
		);

		$url = lgpd( 'helpers' )->getPrivacyPolicyPageUrl();

		return "<a href='{$url}'>" .
			esc_html( $attributes['title'] ) .
			'</a>';
	}
}
