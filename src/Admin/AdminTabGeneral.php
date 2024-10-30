<?php

namespace Data443\LGPD\Admin;

class AdminTabGeneral extends AdminTab {

	protected $slug = 'general';

	public function __construct() {
		$this->title = _x( 'General', '(Admin)', 'lgpd-framework' );
		/**
		 * Register settings
		 */
		$this->registerSetting( 'lgpd_enable' );
		$this->registerSetting( 'lgpd_enable_tac' );
		$this->registerSetting( 'lgpd_comment_checkbox' );
		$this->registerSetting( 'lgpd_register_checkbox' );

		$this->registerSetting( 'lgpd_tools_page' );
		$this->registerSetting( 'lgpd_custom_tools_page' );
		$this->registerSetting( 'lgpd_custom_terms_page' );
		$this->registerSetting( 'lgpd_policy_page' );
		$this->registerSetting( 'lgpd_custom_policy_page' );
		$this->registerSetting( 'lgpd_terms_page' );
		$this->registerSetting( 'lgpd_name_from' );
		$this->registerSetting( 'lgpd_email_from' );
		$this->registerSetting( 'lgpd_export_action' );
		$this->registerSetting( 'lgpd_export_action_email' );
		$this->registerSetting( 'lgpd_unknown_user_message' );

		$this->registerSetting( 'lgpd_delete_action' );
		$this->registerSetting( 'lgpd_delete_action_reassign' );
		$this->registerSetting( 'lgpd_delete_action_reassign_user' );
		$this->registerSetting( 'lgpd_delete_action_email' );

		$this->registerSetting( 'lgpd_enable_stylesheet' );
		$this->registerSetting( 'lgpd_enable_theme_compatibility' );
		if ( class_exists( 'WooCommerce' ) ) {
			$this->registerSetting( 'lgpd_enable_woo_compatibility' );
			$this->registerSetting( 'lgpd_disable_checkbox_woo_compatibility' );
			$this->registerSetting( 'lgpd_disable_register_checkbox_woo_compatibility' );
		}
		if ( class_exists( 'Easy_Digital_Downloads' ) ) {
			$this->registerSetting( 'lgpd_enable_edd_compatibility' );
		}
	}

	public function init() {
		/**
		 * General
		 */
		$this->registerSettingSection(
			'lgpd_section_general',
			_x( 'General Settings', '(Admin)', 'lgpd-framework' )
		);

		$this->registerSettingField(
			'lgpd_enable',
			_x( 'Enable Privacy Tools', '(Admin)', 'lgpd-framework' ),
			array( $this, 'renderEnableCheckbox' ),
			'lgpd_section_general'
		);

		$this->registerSettingField(
			'lgpd_enable_tac',
			_x( 'Enable Term and Conditions', '(Admin)', 'lgpd-framework' ),
			array( $this, 'renderEnableCheckboxtac' ),
			'lgpd_section_general'
		);

		$this->registerSettingField(
			'lgpd_comment_checkbox',
			_x( 'Disable Comment Checkbox', '(Admin)', 'lgpd-framework' ),
			array( $this, 'renderCommentCheckbox' ),
			'lgpd_section_general'
		);

		$this->registerSettingField(
			'lgpd_register_checkbox',
			_x( 'Disable Register Form Checkbox', '(Admin)', 'lgpd-framework' ),
			array( $this, 'renderRegisterCheckbox' ),
			'lgpd_section_general'
		);

		/**
		 * LGPD Email setting
		 */
		$this->registerSettingSection(
			'lgpd_email_section',
			_x( 'Email Setting', '(Admin)', 'lgpd-framework' )
		);

		$this->registerSettingField(
			'lgpd_name_from',
			_x( 'From Name', '(Admin)', 'lgpd-framework' ),
			array( $this, 'renderNameFrom' ),
			'lgpd_email_section'
		);

		$this->registerSettingField(
			'lgpd_email_from',
			_x( 'From Email', '(Admin)', 'lgpd-framework' ),
			array( $this, 'renderEmailFrom' ),
			'lgpd_email_section'
		);
		/**
		 * LGPD system pages
		 */
		$this->registerSettingSection(
			'lgpd_section_pages',
			_x( 'Pages', '(Admin)', 'lgpd-framework' )
		);

		$this->registerSettingField(
			'lgpd_tools_page',
			_x( 'Privacy Tools Page', '(Admin)', 'lgpd-framework' ) . '*',
			array( $this, 'renderPrivacyToolsPageSelector' ),
			'lgpd_section_pages'
		);

		$this->registerSettingField(
			'lgpd_custom_tools_page',
			_x( 'Privacy Tools Custom URL', '(Admin)', 'lgpd-framework'),
			array( $this, 'renderToolsCustomPageSelector' ),
			'lgpd_section_pages'
		);

		$this->registerSettingField(
			'lgpd_policy_page',
			_x( 'Privacy Policy Page', '(Admin)', 'lgpd-framework' ) . '*',
			array( $this, 'renderPolicyPageSelector' ),
			'lgpd_section_pages'
		);

		$this->registerSettingField(
			'lgpd_custom_policy_page',
			_x( 'Privacy Policy Custom URL', '(Admin)', 'lgpd-framework' ),
			array( $this, 'renderPolicyCustomPageSelector' ),
			'lgpd_section_pages'
		);

		$this->registerSettingField(
			'lgpd_terms_page',
			_x( 'Terms & Conditions Page', '(Admin)', 'lgpd-framework' ),
			array( $this, 'renderTermsPageSelector' ),
			'lgpd_section_pages'
		);

		$this->registerSettingField(
			'lgpd_custom_terms_page',
			_x('Terms & Conditions Custom URL', '(Admin)', 'lgpd-framework'),
			array( $this, 'renderCustomTermsPageSelector' ),
			'lgpd_section_pages'
		);

		/**
		 * View & Export
		 */
		$this->registerSettingSection(
			'lgpd_section_export',
			_x( 'View & Export Data', '(Admin)', 'lgpd-framework' )
		);

		$this->registerSettingField(
			'lgpd_export_action',
			_x( 'Export action', '(Admin)', 'lgpd-framework' ),
			array( $this, 'renderExportActionSelector' ),
			'lgpd_section_export'
		);

		$this->registerSettingField(
			'lgpd_export_action_email',
			_x( 'Email to notify', '(Admin)', 'lgpd-framework' ),
			array( $this, 'renderExportActionEmail' ),
			'lgpd_section_export',
			array( 'class' => 'js-lgpd-export-action-email hidden' )
		);

        $this->registerSettingField(
            'lgpd_unknown_user_message',
            _x('Unknown Data Subject Message', '(Admin)', 'lgpd-framework'),
            [$this, 'renderUnknownUserField'],
            'lgpd_section_export'
        );

		/**
		 * Delete data
		 */
		$this->registerSettingSection(
			'lgpd_section_delete',
			_x( 'Delete & Anonymize Data', '(Admin)', 'lgpd-framework' )
		);

		$this->registerSettingField(
			'lgpd_delete_action',
			_x( 'Delete action', '(Admin)', 'lgpd-framework' ),
			array( $this, 'renderDeleteActionSelector' ),
			'lgpd_section_delete'
		);

		$this->registerSettingField(
			'lgpd_delete_action_reassign',
			_x( 'Delete or reassign content?', '(Admin)', 'lgpd-framework' ),
			array( $this, 'renderDeleteActionReassign' ),
			'lgpd_section_delete',
			array( 'class' => 'js-lgpd-delete-action-reassign hidden' )
		);

		$this->registerSettingField(
			'lgpd_delete_action_reassign_user',
			_x( 'Reassign content to', '(Admin)', 'lgpd-framework' ),
			array( $this, 'renderDeleteActionReassignUser' ),
			'lgpd_section_delete',
			array( 'class' => 'js-lgpd-delete-action-reassign-user hidden' )
		);

		$this->registerSettingField(
			'lgpd_delete_action_email',
			_x( 'Email to notify', '(Admin)', 'lgpd-framework' ),
			array( $this, 'renderDeleteActionEmail' ),
			'lgpd_section_delete',
			array( 'class' => 'js-lgpd-delete-action-email hidden' )
		);

		/**
		 * Stylesheet
		 */

		$this->registerSettingSection(
			'lgpd_section_stylesheet',
			_x( 'Styling', '(Admin)', 'lgpd-framework' )
		);

		$this->registerSettingField(
			'lgpd_enable_theme_compatibility',
			_x( 'Enable basic styling on Privacy Tools page', '(Admin)', 'lgpd-framework' ),
			array( $this, 'renderStylesheetSelector' ),
			'lgpd_section_stylesheet'
		);

		if ( lgpd( 'themes' )->isCurrentThemeSupported() ) {

			/**
			 * Compatibility settings
			 */
			$this->registerSettingSection(
				'lgpd_section_compatibility',
				_x( 'Compatibility', '(Admin)', 'lgpd-framework' )
			);

			$this->registerSettingField(
				'lgpd_enable_theme_compatibility',
				_x( 'Enable automatic theme compatibility', '(Admin)', 'lgpd-framework' ),
				array( $this, 'renderThemeCompatibilitySelector' ),
				'lgpd_section_compatibility'
			);
		}
		if ( class_exists( 'WooCommerce' ) ) {

			/**
			 * Woocommerce Compatibility settings
			 */
			$this->registerSettingSection(
				'lgpd_woo_compatibility',
				_x( 'Woocommerce Integration', '(Admin)', 'lgpd-framework' )
			);

			$this->registerSettingField(
				'lgpd_enable_woo_compatibility',
				_x( 'Enable WooCommerce Compatibility', '(Admin)', 'lgpd-framework' ),
				array( $this, 'renderwooCompatibilitySelector' ),
				'lgpd_woo_compatibility'
			);

			$this->registerSettingField(
				'lgpd_disable_checkbox_woo_compatibility',
				_x( 'Disable WooCommerce Privacy Checkbox', '(Admin)', 'lgpd-framework' ),
				array( $this, 'renderwoodisablewooSelector' ),
				'lgpd_woo_compatibility'
			);

			$this->registerSettingField(
				'lgpd_disable_register_checkbox_woo_compatibility',
				_x( 'Disable WooCommerce Register Privacy Checkbox', '(Admin)', 'lgpd-framework' ),
				array( $this, 'renderwooregisterdisablewooSelector' ),
				'lgpd_woo_compatibility'
			);
		}

		if ( class_exists( 'Easy_Digital_Downloads' ) ) {
			/**
			 * Easy Digital Downloads Compatibility settings
			 */
			$this->registerSettingSection(
				'lgpd_edd_compatibility',
				_x( 'Easy Digital Download Integration', '(Admin)', 'lgpd-framework' )
			);

			$this->registerSettingField(
				'lgpd_enable_edd_compatibility',
				_x( 'Enable EDD Compatibility', '(Admin)', 'lgpd-framework' ),
				array( $this, 'rendereddCompatibilitySelector' ),
				'lgpd_edd_compatibility'
			);
		}
	}

	/**
	 * Rendering Views
	 */

	public function renderEnableCheckbox() {
		$enabled = lgpd( 'options' )->get( 'enable' );
		echo lgpd( 'view' )->render( 'admin/general/enable', compact( 'enabled' ) );
	}

	public function renderEnableCheckboxtac() {
		$enabled = lgpd( 'options' )->get( 'enable_tac' );
		echo lgpd( 'view' )->render( 'admin/general/enable-tac', compact( 'enabled' ) );
	}

	public function renderCommentCheckbox() {
		$content['option_name'] = 'comment_checkbox';
		$content['value']       = lgpd( 'options' )->get( 'comment_checkbox' );
		$content['option']      = _x( 'Disable Checkbox For Comments', '(Admin)', 'lgpd-framework' );
		echo lgpd( 'view' )->render( 'admin/general/disble-checkbox', compact( 'content' ) );
	}

	public function renderRegisterCheckbox() {
		$content['option_name'] = 'register_checkbox';
		$content['value']       = lgpd( 'options' )->get( 'register_checkbox' );
		$content['option']      = _x( 'Disable Checkbox For Register Form', '(Admin)', 'lgpd-framework' );
		echo lgpd( 'view' )->render( 'admin/general/disble-checkbox', compact( 'content' ) );
	}

	public function renderEnableCheckboxpopup() {
		$enabled = lgpd( 'options' )->get( 'enable_popup' );
		echo lgpd( 'view' )->render( 'admin/general/enable-popup', compact( 'enabled' ) );
	}

	public function renderEnableOneTimeCheckboxpopup() {
		$enabled = lgpd( 'options' )->get( 'onetime_popup' );
		echo lgpd( 'view' )->render( 'admin/general/enable-onetime-popup', compact( 'enabled' ) );
	}

	public function renderheaderCheckboxpopup() {
		$content = lgpd( 'options' )->get( 'header' );
		echo lgpd( 'view' )->render( 'admin/general/enable_popup_header', compact( 'content' ) );
	}
	public function rendercontentCheckboxpopup() {
		$content = lgpd( 'options' )->get( 'popup_content' );
		echo lgpd( 'view' )->render( 'admin/general/enable_popup_content', compact( 'content' ) );
	}

	public function renderNameFrom() {
		$content = lgpd( 'options' )->get( 'name_from' );
		echo lgpd( 'view' )->render( 'admin/general/name_from', compact( 'content' ) );
	}

	public function renderEmailFrom() {
		$content = lgpd( 'options' )->get( 'email_from' );
		echo lgpd( 'view' )->render( 'admin/general/email_from', compact( 'content' ) );
	}

	public function renderpopupBackgroundcolor() {
		$content['value']  = lgpd( 'options' )->get( 'popup_background' );
		$content['option'] = 'background';
		echo lgpd( 'view' )->render( 'admin/general/popup_background_color_picker', compact( 'content' ) );
	}

	public function renderpopupTextcolor() {
		$content['value']  = lgpd( 'options' )->get( 'popup_text' );
		$content['option'] = 'text';
		echo lgpd( 'view' )->render( 'admin/general/popup_background_color_picker', compact( 'content' ) );
	}

	public function renderbuttonBackgroundcolor() {

		$content['value']  = lgpd( 'options' )->get( 'popup_button_background' );
		$content['option'] = 'button_background';
		echo lgpd( 'view' )->render( 'admin/general/popup_background_color_picker', compact( 'content' ) );
	}
	public function renderbuttonTextcolor() {
		$content['value']  = lgpd( 'options' )->get( 'popup_button_text' );
		$content['option'] = 'button_text';
		echo lgpd( 'view' )->render( 'admin/general/popup_background_color_picker', compact( 'content' ) );
	}

	public function renderborderTextcolor() {
		$content['value']  = lgpd( 'options' )->get( 'popup_border_text' );
		$content['option'] = 'border_text';
		echo lgpd( 'view' )->render( 'admin/general/popup_background_color_picker', compact( 'content' ) );
	}

	public function renderPrivacyToolsPageSelector() {
		wp_dropdown_pages(
			array(
				'name'              => 'lgpd_tools_page',
				'show_option_none'  => _x( '&mdash; Select &mdash;', '(Admin)', 'lgpd-framework' ),
				'option_none_value' => '0',
				'selected'          => lgpd( 'options' )->get( 'tools_page' ),
				'class'             => 'js-lgpd-select2 lgpd-select',
				'post_status'       => 'publish,draft',
			)
		);
		echo lgpd( 'view' )->render( 'admin/general/description-data-page' );
	}

	public function renderToolsCustomPageSelector()	{
		$content = lgpd( 'options' )->get( 'custom_tools_page' );
		echo lgpd( 'view' )->render( 'admin/general/custom-tools-url', compact( 'content' ));
	}

	/**
	 * Render the LGPD policy page selector dropdown
	 */
	public function renderPolicyPageSelector() {
		wp_dropdown_pages(
			array(
				'name'              => 'lgpd_policy_page',
				'show_option_none'  => _x( '&mdash; Select &mdash;', '(Admin)', 'lgpd-framework' ),
				'option_none_value' => '0',
				'selected'          => lgpd( 'options' )->get( 'policy_page' ),
				'class'             => 'js-lgpd-select2 lgpd-select',
				'post_status'       => 'publish,draft',
			)
		);
		echo lgpd( 'view' )->render( 'admin/privacy-policy/description-policy-page' );
	}

	public function renderPolicyCustomPageSelector() {
		$content = lgpd( 'options' )->get( 'custom_policy_page' );
		echo lgpd( 'view' )->render( 'admin/general/custom-policy-url', compact( 'content' ) );
	}

	public function renderTermsPageSelector() {
		wp_dropdown_pages(
			array(
				'name'              => 'lgpd_terms_page',
				'show_option_none'  => _x( '&mdash; Select &mdash;', '(Admin)', 'lgpd-framework' ),
				'option_none_value' => '0',
				'selected'          => lgpd( 'options' )->get( 'terms_page' ),
				'class'             => 'js-lgpd-select2 lgpd-select',
				'post_status'       => 'publish,draft',
			)
		);
		echo lgpd( 'view' )->render( 'admin/general/description-terms-page' );
	}

	public function renderCustomTermsPageSelector()
	{
		$content = lgpd( 'options' )->get( 'custom_terms_page' );
		echo lgpd( 'view' )->render( 'admin/general/custom-terms-url', compact( 'content' ) );
	}

	public function renderExportActionSelector() {
		$exportAction = lgpd( 'options' )->get( 'export_action' );
		echo lgpd( 'view' )->render( 'admin/general/export-action', compact( 'exportAction' ) );
		echo lgpd( 'view' )->render( 'admin/general/description-export-action' );
	}

    public function renderUnknownUserField()
    {
        $content = lgpd('options')->get('unknown_user_message', LGPD_DEFAULT_UNKNOWN_USER_MESSAGE);
        if (empty(trim($content))) {
            $content = LGPD_DEFAULT_UNKNOWN_USER_MESSAGE;
            lgpd('options')->set('unknown_user_message', $content);
        }
        echo lgpd('view')->render('admin/general/unknown-user-message', compact('content'));
    }

	public function renderPopupThemeSelector() {
		$themeAction = lgpd( 'options' )->get( 'popup_theme' );
		echo lgpd( 'view' )->render( 'admin/general/theme-action', compact( 'themeAction' ) );
		echo lgpd( 'view' )->render( 'admin/general/description-theme-action' );
	}
	public function renderPopupPositionSelector() {
		$positionAction = lgpd( 'options' )->get( 'popup_position' );
		echo lgpd( 'view' )->render( 'admin/general/position-action', compact( 'positionAction' ) );
		echo lgpd( 'view' )->render( 'admin/general/description-position-action' );
	}

	public function renderExportActionEmail() {
		$exportActionEmail = lgpd( 'options' )->get( 'export_action_email' );
		echo lgpd( 'view' )->render( 'admin/general/export-action-email', compact( 'exportActionEmail' ) );
	}

	public function renderDeleteActionSelector() {
		$deleteAction = lgpd( 'options' )->get( 'delete_action' );
		echo lgpd( 'view' )->render( 'admin/general/delete-action', compact( 'deleteAction' ) );
		echo lgpd( 'view' )->render( 'admin/general/description-delete-action' );
	}

	public function renderDeleteActionReassign() {
		$reassign = lgpd( 'options' )->get( 'delete_action_reassign' );
		echo lgpd( 'view' )->render( 'admin/general/delete-action-reassign', compact( 'reassign' ) );
	}

	public function renderDeleteActionReassignUser() {
		wp_dropdown_users(
			array(
				'name'              => 'lgpd_delete_action_reassign_user',
				'show_option_none'  => _x( '&mdash; Select &mdash;', '(Admin)', 'lgpd-framework' ),
				'option_none_value' => '0',
				'selected'          => lgpd( 'options' )->get( 'delete_action_reassign_user' ),
				'class'             => 'js-lgpd-select2 lgpd-select',
				'role__in'          => apply_filters( 'lgpd/options/reassign/roles', array( 'administrator', 'editor' ) ),
			)
		);
	}

	public function renderDeleteActionEmail() {
		$deleteActionEmail = lgpd( 'options' )->get( 'delete_action_email' );
		echo lgpd( 'view' )->render( 'admin/general/delete-action-email', compact( 'deleteActionEmail' ) );
	}

	public function renderStylesheetSelector() {
		$enabled = lgpd( 'options' )->get( 'enable_stylesheet' );
		echo lgpd( 'view' )->render( 'admin/general/stylesheet', compact( 'enabled' ) );
	}

	public function renderThemeCompatibilitySelector() {
		$enabled = lgpd( 'options' )->get( 'enable_theme_compatibility' );
		echo lgpd( 'view' )->render( 'admin/general/theme-compatibility', compact( 'enabled' ) );
	}

	public function renderwooCompatibilitySelector() {
		$enabled = lgpd( 'options' )->get( 'enable_woo_compatibility' );
		echo lgpd( 'view' )->render( 'admin/general/woo-compatibility', compact( 'enabled' ) );
	}
	public function renderwoodisablewooSelector() {
		$enabled = lgpd( 'options' )->get( 'disable_checkbox_woo_compatibility' );
		echo lgpd( 'view' )->render( 'admin/general/woo-disable_checkbox', compact( 'enabled' ) );
	}
	public function renderwooregisterdisablewooSelector() {
		$enabled = lgpd( 'options' )->get( 'disable_register_checkbox_woo_compatibility' );
		echo lgpd( 'view' )->render( 'admin/general/woo-disable_register_checkbox', compact( 'enabled' ) );
	}
	public function rendereddCompatibilitySelector() {
		$enabled = lgpd( 'options' )->get( 'enable_edd_compatibility' );
		echo lgpd( 'view' )->render( 'admin/general/edd-compatibility', compact( 'enabled' ) );
	}
}
