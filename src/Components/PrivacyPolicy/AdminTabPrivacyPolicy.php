<?php

namespace Data443\LGPD\Components\PrivacyPolicy;

use Data443\LGPD\Admin\AdminTab;

class AdminTabPrivacyPolicy extends AdminTab {

	/* @var string */
	protected $slug = 'privacy-policy';

	/* @var PolicyGenerator */
	protected $policyGenerator;

	public function __construct( PolicyGenerator $policyGenerator ) {
		$this->policyGenerator = $policyGenerator;

		$this->title = _x( 'Privacy Policy', '(Admin)', 'lgpd-framework' );

		$this->registerSetting( 'lgpd_company_name' );
		$this->registerSetting( 'lgpd_contact_email' );
		$this->registerSetting( 'lgpd_company_location' );

		$this->registerSetting( 'lgpd_representative_contact_name' );
		$this->registerSetting( 'lgpd_representative_contact_email' );
		$this->registerSetting( 'lgpd_representative_contact_phone' );

		$this->registerSetting( 'lgpd_dpa_website' );
		$this->registerSetting( 'lgpd_dpa_email' );
		$this->registerSetting( 'lgpd_dpa_phone' );

		$this->registerSetting( 'lgpd_has_dpo' );
		$this->registerSetting( 'lgpd_dpo_name' );
		$this->registerSetting( 'lgpd_dpo_email' );
		$this->registerSetting( 'lgpd_delete_text' );

		add_action( 'lgpd/admin/action/privacy-policy/generate', array( $this, 'generatePolicy' ) );
	}

	public function init() {
		/**
		 * General settings
		 */
		$this->registerSettingSection(
			'lgpd_section_privacy_policy',
			_x( 'Privacy Policy', '(Admin)', 'lgpd-framework' ),
			array( $this, 'renderHeader' )
		);

		/**
		 * Company info
		 */
		$this->registerSettingSection(
			'lgpd_section_privacy_policy_company',
			_x( 'Company information', '(Admin)', 'lgpd-framework' )
		);

		$this->registerSettingField(
			'lgpd_company_name',
			_x( 'Company Name', '(Admin)', 'lgpd-framework' ),
			array( $this, 'renderCompanyNameHtml' ),
			'lgpd_section_privacy_policy_company'
		);

		$this->registerSettingField(
			'lgpd_company_email',
			_x( 'Company Email', '(Admin)', 'lgpd-framework' ),
			array( $this, 'renderCompanyEmailHtml' ),
			'lgpd_section_privacy_policy_company'
		);

		$this->registerSettingField(
			'lgpd_company_location',
			_x( 'Company Location', '(Admin)', 'lgpd-framework' ),
			array( $this, 'renderCompanyLocationHtml' ),
			'lgpd_section_privacy_policy_company'
		);

		/**
		 * Change Delete Text
		 */

		$this->registerSettingField(
			'lgpd_delete_text',
			_x( 'Delete Text', '(Admin)', 'lgpd-framework' ),
			array( $this, 'renderDeleteTextHtml' ),
			'lgpd_section_privacy_policy_company'
		);

	}

	public function renderHeader() {
		echo lgpd( 'view' )->render( 'admin/privacy-policy/header' );
	}

	/**
	 * Company info
	 */

	public function renderCompanyNameHtml() {
		$value       = lgpd( 'options' )->get( 'company_name' ) ? esc_attr( lgpd( 'options' )->get( 'company_name' ) ) : '';
		$placeholder = _x( 'Company Name', '(Admin)', 'lgpd-framework' );
		echo "<input name='lgpd_company_name' placeholder='{$placeholder}' value='{$value}'>";
	}

	public function renderCompanyEmailHtml() {
		$value       = lgpd( 'options' )->get( 'contact_email' ) ? esc_attr( lgpd( 'options' )->get( 'contact_email' ) ) : '';
		$placeholder = _x( 'Contact Email', '(Admin)', 'lgpd-framework' );
		echo "<input type='email' name='lgpd_contact_email' placeholder='{$placeholder}' value='{$value}'>";
	}

	public function renderCompanyLocationHtml() {
		$country              = lgpd( 'options' )->get( 'company_location' ) ? lgpd( 'options' )->get( 'company_location' ) : '';
		$countrySelectOptions = lgpd( 'helpers' )->getCountrySelectOptions( $country );
		echo lgpd( 'view' )->render( 'admin/privacy-policy/company-location', compact( 'countrySelectOptions' ) );
	}

	public function renderDeleteTextHtml() {
		$value       = lgpd( 'options' )->get( 'delete_text' ) ? esc_attr( lgpd( 'options' )->get( 'delete_text' ) ) : '';
		$placeholder = _x( 'Delete Text', '(Admin)', 'lgpd-framework' );
		echo "<input name='lgpd_delete_text' placeholder='{$placeholder}' value='{$value}'>";
	}

	public function generatePolicy() {
		$policyPage = lgpd( 'options' )->get( 'policy_page' );

		// todo: handle errors
		if ( ! $policyPage ) {
			return;
		}

		$policy = lgpd( 'view' )->render(
			'policy/policy'
		);

		wp_update_post(
			array(
				'ID'           => $policyPage,
				'post_content' => $policy,
			)
		);

		wp_safe_redirect( lgpd( 'helpers' )->getAdminUrl( '&lgpd-tab=privacy-policy&lgpd_notice=policy_generated' ) );
	}

	/**
	 * Render either the settings or the generated policy
	 */
	public function renderContents() {
		if ( isset( $_GET['generate'] ) && 'yes' == $_GET['generate'] ) {
			return $this->renderPolicy();
		} else {
			return $this->renderSettings();
		}
	}

	/**
	 * Render the contents including settings fields, sections and submit button.
	 * Trigger hooks for rendering content before and after the settings fields.
	 *
	 * @return string
	 */
	public function renderSettings() {
		ob_start();

		do_action( "lgpd/tabs/{$this->getSlug()}/before", $this );
		$this->settingsFields( $this->getOptionsGroupName() );
		do_settings_sections( $this->getOptionsGroupName() );
		do_action( "lgpd/tabs/{$this->getSlug()}/after", $this );

		$this->renderSubmitButton();

		return ob_get_clean();
	}

	public function renderPolicy() {
		$policyPageId = lgpd( 'options' )->get( 'policy_page' );
		if ( $policyPageId ) {
			$policyUrl = get_edit_post_link( $policyPageId );
		} else {
			$policyUrl = false;
		}

		$editor  = $this->getPolicyEditor();
		$backUrl = lgpd( 'helpers' )->getAdminUrl( '&lgpd-tab=privacy-policy' );

		return lgpd( 'view' )->render( 'admin/privacy-policy/generated', compact( 'editor', 'policyUrl', 'backUrl' ) );
	}

	protected function getPolicyEditor() {
		ob_start();

		wp_editor(
			wp_kses_post( $this->policyGenerator->generate() ),
			'lgpd_policy',
			array(
				'media_buttons' => false,
				'editor_height' => 600,
				'teeny'         => true,
				'editor_css'    => '<style>#mceu_16 { display: none; }</style>',
			)
		);

		return ob_get_clean();
	}

	/**
	 * Render WP's default submit button
	 */
	public function renderSubmitButton() {
		submit_button( _x( 'Save & Generate Policy', '(Admin)', 'lgpd-framework' ) );
	}

	/**
	 * In order to set up a proper redirect to the generated policy
	 * after saving settings, we modify the way wp_nonce_field is called and insert our own referer input.
	 *
	 * @param $optionGroup
	 */
	public function settingsFields( $optionGroup ) {
		echo "<input type='hidden' name='option_page' value='" . esc_attr( $optionGroup ) . "' />";
		echo '<input type="hidden" name="action" value="update" />';
		wp_nonce_field( "$optionGroup-options", '_wpnonce', false );
		echo '<input type="hidden" name="_wp_http_referer" value="' . esc_attr( wp_unslash( $_SERVER['REQUEST_URI'] ) . '&generate=yes' ) . '" />';
	}
}
