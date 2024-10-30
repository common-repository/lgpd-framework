<?php

namespace Data443\LGPD\Installer\Steps;

use Data443\LGPD\Installer\InstallerStep;
use Data443\LGPD\Installer\InstallerStepInterface;

class PolicySettings extends InstallerStep implements InstallerStepInterface {

	protected $slug = 'policy-settings';

	protected $type = 'wizard';

	protected $template = 'installer/steps/policy-settings';

	protected $activeSteps = 2;

	protected function renderContent() {
		$policyPage         = lgpd( 'options' )->get( 'policy_page' );
		$policyPageSelector = wp_dropdown_pages(
			array(
				'name'              => 'lgpd_policy_page',
				'show_option_none'  => _x( '&mdash; Create a new page &mdash;', '(Admin)', 'lgpd-framework' ),
				'option_none_value' => 'new',
				'selected'          => $policyPage ? $policyPage : 'new',
				'echo'              => false,
				'class'             => 'lgpd-select js-lgpd-select2',
			)
		);

		$hasTermsPage    = lgpd( 'options' )->get( 'has_terms_page' );
		$termsPage       = lgpd( 'options' )->get( 'terms_page' );
		$policy_page_url = lgpd( 'options' )->get( 'custom_policy_page' );
		// Woo compatibility
		if ( ! $termsPage && get_option( 'woocommerce_terms_page_id' ) ) {
			$hasTermsPage  = 'yes';
			$termsPage     = get_option( 'woocommerce_terms_page_id' );
			$termsPageNote = _x(
				'We have automatically selected your WooCommerce Terms & Conditions page.',
				'(Admin)',
				'lgpd-framework'
			);
		} else {
			$termsPageNote = false;
		}

		$termsPageSelector = wp_dropdown_pages(
			array(
				'name'              => 'lgpd_terms_page',
				'show_option_none'  => _x( '&mdash; Create a new page &mdash;', '(Admin)', 'lgpd-framework' ),
				'option_none_value' => 'new',
				'selected'          => $termsPage ? $termsPage : 'new',
				'echo'              => false,
				'class'             => 'lgpd-select js-lgpd-select2',
			)
		);

		$companyName     = lgpd( 'options' )->get( 'company_name' );
		$companyLocation = lgpd( 'options' )->get( 'company_location' );
		$countryOptions  = lgpd( 'helpers' )->getCountrySelectOptions( $companyLocation );
		$contactEmail    = lgpd( 'options' )->get( 'contact_email' ) ?
			lgpd( 'options' )->get( 'contact_email' ) :
			get_option( 'admin_email' );

		$representativeContactName  = lgpd( 'options' )->get( 'representative_contact_name' );
		$representativeContactEmail = lgpd( 'options' )->get( 'representative_contact_email' );
		$representativeContactPhone = lgpd( 'options' )->get( 'representative_contact_phone' );

		$dpaWebsite = lgpd( 'options' )->get( 'dpa_website' );
		$dpaEmail   = lgpd( 'options' )->get( 'dpa_email' );
		$dpaPhone   = lgpd( 'options' )->get( 'dpa_phone' );
		$dpaData    = json_encode( lgpd( 'helpers' )->getDataProtectionAuthorities() );

		$hasDPO   = lgpd( 'options' )->get( 'has_dpo' );
		$dpoName  = lgpd( 'options' )->get( 'dpo_name' );
		$dpoEmail = lgpd( 'options' )->get( 'dpo_email' );

		echo lgpd( 'view' )->render(
			$this->template,
			compact(
				'policyPage',
				'policyPageSelector',
				'policy_page_url',
				'companyName',
				'companyLocation',
				'contactEmail',
				'countryOptions',
				'hasDPO',
				'dpoEmail',
				'dpoName',
				'representativeContactName',
				'representativeContactEmail',
				'representativeContactPhone',
				'dpaWebsite',
				'dpaEmail',
				'dpaPhone',
				'dpaData',
				'hasTermsPage',
				'termsPage',
				'termsPageSelector',
				'termsPageNote'
			)
		);
	}

	/*
	public function validate()
	{
		if (!is_email($_POST['lgpd_contact_email'])) {
			$this->errors = 'Company email is not a valid email!';
			return false;
		}

		return true;

		//filter_var($url, FILTER_VALIDATE_URL) === FALSE
	}
	*/

	public function submit() {
		/**
		 * Policy page
		 */
		if ( isset( $_POST['lgpd_create_policy_page'] ) && 'yes' === $_POST['lgpd_create_policy_page'] ) {
			$id = $this->createPolicyPage();
			lgpd( 'options' )->set( 'policy_page', intval( $id ) );
		} else {
			lgpd( 'options' )->set( 'policy_page', sanitize_text_field( $_POST['lgpd_policy_page'] ) );
		}

		/**
		 * Custom Policy page URL
		 */
		if ( isset( $_POST['lgpd_custom_policy_page'] ) && '' != $_POST['lgpd_custom_policy_page'] ) {
			lgpd( 'options' )->set( 'custom_policy_page', sanitize_text_field( $_POST['lgpd_custom_policy_page'] ) );
		} else {
			lgpd( 'options' )->set( 'custom_policy_page', '' );
		}

		/**
		 * 'Generate policy' checkbox
		 */
		if ( isset( $_POST['lgpd_generate_policy'] ) && 'yes' === $_POST['lgpd_generate_policy'] ) {
			$this->generatePolicy();
			lgpd( 'options' )->set( 'policy_generated', true );
		} else {
			lgpd( 'options' )->set( 'policy_generated', false );
		}

		/**
		 * Company information
		 */
		lgpd( 'options' )->set( 'company_name', sanitize_text_field( $_POST['lgpd_company_name'] ) );
		lgpd( 'options' )->set( 'company_location', sanitize_text_field( $_POST['lgpd_company_location'] ) );

		if ( is_email( $_POST['lgpd_contact_email'] ) ) {
			lgpd( 'options' )->set( 'contact_email', sanitize_email( $_POST['lgpd_contact_email'] ) );
		}

		/**
		 * Data Protection Officer
		 */
		// FRAM-131 - check for existence of associative entries before access
		if ( isset( $_POST['lgpd_has_dpo'] ) ) {
			lgpd( 'options' )->set( 'has_dpo', sanitize_text_field( $_POST['lgpd_has_dpo'] ) );
		}

		if (isset($_POST['lgpd_dpo_name'])) {
			lgpd( 'options' )->set( 'dpo_name', sanitize_text_field( $_POST['lgpd_dpo_name'] ) );
		}

		if ( isset($_POST['lgpd_dpo_email']) && is_email( $_POST['lgpd_dpo_email'] ) ) {
			lgpd( 'options' )->set( 'dpo_email', sanitize_email( $_POST['lgpd_dpo_email'] ) );
		}

		/**
		 * Representative contact
		 */
		lgpd( 'options' )->set( 'representative_contact_name', sanitize_text_field( $_POST['lgpd_representative_contact_name'] ) );
		lgpd( 'options' )->set( 'representative_contact_phone', sanitize_text_field( $_POST['lgpd_representative_contact_phone'] ) );

		if ( is_email( $_POST['lgpd_representative_contact_email'] ) ) {
			lgpd( 'options' )->set( 'representative_contact_email', sanitize_email( $_POST['lgpd_representative_contact_email'] ) );
		}

		/**
		 * Data protection authority
		 */
		// FRAM-131 - check for existence of associative entries before access
		if (isset($_POST['lgpd_dpa_website'])) {
			lgpd( 'options' )->set( 'dpa_website', sanitize_text_field( $_POST['lgpd_dpa_website'] ) );
		}

		if (isset($_POST['lgpd_dpa_phone'])) {
			lgpd( 'options' )->set( 'dpa_phone', sanitize_text_field( $_POST['lgpd_dpa_phone'] ) );
		}

		if ( isset($_POST['lgpd_dpa_email']) && is_email( $_POST['lgpd_dpa_email'] ) ) {
			lgpd( 'options' )->set( 'dpa_email', sanitize_email( $_POST['lgpd_dpa_email'] ) );
		}

		/**
		 * Terms page
		 */
		if ( isset( $_POST['lgpd_has_terms_page'] ) ) {
			lgpd( 'options' )->set( 'has_terms_page', sanitize_text_field( $_POST['lgpd_has_terms_page'] ) );
		}

		if ( isset( $_POST['lgpd_has_terms_page'] ) && 'yes' === $_POST['lgpd_has_terms_page'] && isset( $_POST['lgpd_terms_page'] ) ) {
			lgpd( 'options' )->set( 'terms_page', sanitize_text_field( $_POST['lgpd_terms_page'] ) );
		} else {
			lgpd( 'options' )->delete( 'terms_page' );
		}
	}

	protected function createPolicyPage() {
		$id = wp_insert_post(
			array(
				'post_title' => __( 'Privacy Policy', 'lgpd-framework' ),
				'post_type'  => 'page',
			)
		);

		return intval( $id );
	}

	protected function generatePolicy() {
		wp_update_post(
			array(
				'ID'           => lgpd( 'options' )->get( 'policy_page' ),
				'post_content' => lgpd( 'view' )->render(
					'policy/policy',
					$this->getData()
				),
			)
		);
	}

	public function getData() {
		$location = lgpd( 'options' )->get( 'company_location' );
		$date     = date( get_option( 'date_format' ) );

		return array(
			'companyName'                => lgpd( 'options' )->get( 'company_name' ),
			'companyLocation'            => $location,
			'contactEmail'               => lgpd( 'options' )->get( 'contact_email' ) ?
				lgpd( 'options' )->get( 'contact_email' ) :
				get_option( 'admin_email' ),

			'hasRepresentative'          => lgpd( 'helpers' )->countryNeedsRepresentative( $location ),
			'representativeContactName'  => lgpd( 'options' )->get( 'representative_contact_name' ),
			'representativeContactEmail' => lgpd( 'options' )->get( 'representative_contact_email' ),
			'representativeContactPhone' => lgpd( 'options' )->get( 'representative_contact_phone' ),

			'dpaWebsite'                 => lgpd( 'options' )->get( 'dpa_website' ),
			'dpaEmail'                   => lgpd( 'options' )->get( 'dpa_email' ),
			'dpaPhone'                   => lgpd( 'options' )->get( 'dpa_phone' ),

			'hasDpo'                     => lgpd( 'options' )->get( 'has_dpo' ),
			'dpoName'                    => lgpd( 'options' )->get( 'dpo_name' ),
			'dpoEmail'                   => lgpd( 'options' )->get( 'dpo_email' ),

			'hasTerms'                   => lgpd( 'options' )->get( 'terms_page' ),

			'date'                       => $date,
		);
	}
}
