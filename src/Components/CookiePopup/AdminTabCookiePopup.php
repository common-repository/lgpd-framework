<?php

namespace Data443\LGPD\Components\CookiePopup;

use Data443\LGPD\Admin\AdminTab;

class AdminTabCookiePopup extends AdminTab {

	/* @var string */
	protected $slug = 'cookie-popup';

	/* @var PolicyGenerator */
	protected $policyGenerator;

	public function __construct() {
		$this->title = _x( 'Cookie Popup', '(Admin)', 'lgpd-framework' );
		$this->registerSetting( 'lgpd_enable_popup' );
		$this->registerSetting( 'lgpd_onetime_popup' );
		$this->registerSetting( 'lgpd_policy_popup' );
		$this->registerSetting( 'lgpd_popup_content' );
		$this->registerSetting( 'lgpd_header' );
		$this->registerSetting( 'lgpd_popup_position' );
		$this->registerSetting( 'lgpd_popup_theme' );
		$this->registerSetting( 'lgpd_popup_allow_text' );
		$this->registerSetting( 'lgpd_popup_dismiss_text' );
		$this->registerSetting( 'lgpd_popup_learnmore_text' );
		$this->registerSetting( 'lgpd_popup_background' );
		$this->registerSetting( 'lgpd_popup_text' );
		$this->registerSetting( 'lgpd_popup_link_target' );
		$this->registerSetting( 'lgpd_popup_button_background' );
		$this->registerSetting( 'lgpd_popup_button_text' );
		$this->registerSetting( 'lgpd_popup_border_text' );
		add_action( 'lgpd/admin/action/CookiePopup/generate', array( $this, 'generateCookiePopup' ) );
	}

	public function init() {
		/**
		 * Cookie Popup settings
		 */
		$this->registerSettingSection(
			'lgpd_cookie_popup_setting',
			_x( 'Cookie Popup Settings', '(Admin)', 'lgpd-framework' )
		);
		$this->registerSettingField(
			'lgpd_enable_popup',
			_x( 'Enable Cookie Acceptance Popup', '(Admin)', 'lgpd-framework' ),
			array( $this, 'renderEnableCheckboxpopup' ),
			'lgpd_cookie_popup_setting'
		);
		$this->registerSettingField(
			'lgpd_onetime_popup',
			_x( 'Enable One Time Cookie Acceptance Popup', '(Admin)', 'lgpd-framework' ),
			array( $this, 'renderEnableOneTimeCheckboxpopup' ),
			'lgpd_cookie_popup_setting'
		);
		$this->registerSettingField(
			'lgpd_policy_popup',
			_x( 'Enable Privacy policy on Popup', '(Admin)', 'lgpd-framework' ),
			array( $this, 'renderEnablePolicyOnPopup' ),
			'lgpd_cookie_popup_setting'
		);
		$this->registerSettingField(
			'lgpd_header',
			_x( 'Cookie Acceptance Popup header', '(Admin)', 'lgpd-framework' ),
			array( $this, 'renderheaderCheckboxpopup' ),
			'lgpd_cookie_popup_setting'
		);
		$this->registerSettingField(
			'lgpd_popup_content',
			_x( 'Cookie Acceptance Popup Content', '(Admin)', 'lgpd-framework' ),
			array( $this, 'rendercontentCheckboxpopup' ),
			'lgpd_cookie_popup_setting'
		);
		/**
		 * LGPD Popup setting
		 */
		$this->registerSettingSection(
			'lgpd_popup_section',
			_x( 'Acceptance Popup Setting', '(Admin)', 'lgpd-framework' )
		);

		$this->registerSettingField(
			'lgpd_popup_position',
			_x( 'Popup Position', '(Admin)', 'lgpd-framework' ),
			array( $this, 'renderPopupPositionSelector' ),
			'lgpd_popup_section'
		);

		$this->registerSettingField(
			'lgpd_popup_theme',
			_x( 'Popup theme', '(Admin)', 'lgpd-framework' ),
			array( $this, 'renderPopupThemeSelector' ),
			'lgpd_popup_section'
		);

		$this->registerSettingField(
			'lgpd_popup_allow_text',
			_x( 'Popup Allow Text', '(Admin)', 'lgpd-framework' ),
			array( $this, 'renderAllowContentPopup' ),
			'lgpd_popup_section'
		);

		$this->registerSettingField(
			'lgpd_popup_dismiss_text',
			_x( 'Popup Dismiss Text', '(Admin)', 'lgpd-framework' ),
			array( $this, 'renderDismissContentPopup' ),
			'lgpd_popup_section'
		);

		$this->registerSettingField(
			'lgpd_popup_learnmore_text',
			_x( 'Popup Learn More Text', '(Admin)', 'lgpd-framework' ),
			array( $this, 'renderlearnmorePopup' ),
			'lgpd_popup_section'
		);

		$this->registerSettingField(
			'lgpd_popup_link_target',
			_x( 'Cookie Acceptance link target', '(Admin)', 'lgpd-framework' ),
			array( $this, 'renderpopuplinktarget' ),
			'lgpd_popup_section'
		);

		$this->registerSettingField(
			'lgpd_popup_background',
			_x( 'Cookie Acceptance Background Color', '(Admin)', 'lgpd-framework' ),
			array( $this, 'renderpopupBackgroundcolor' ),
			'lgpd_popup_section'
		);

		$this->registerSettingField(
			'lgpd_popup_text',
			_x( 'Cookie Acceptance Text Color', '(Admin)', 'lgpd-framework' ),
			array( $this, 'renderpopupTextcolor' ),
			'lgpd_popup_section'
		);

		$this->registerSettingField(
			'lgpd_popup_button_background',
			_x( 'Cookie Acceptance Button Backgroung Color', '(Admin)', 'lgpd-framework' ),
			array( $this, 'renderbuttonBackgroundcolor' ),
			'lgpd_popup_section'
		);

		$this->registerSettingField(
			'lgpd_popup_button_text',
			_x( 'Cookie Acceptance Button Color', '(Admin)', 'lgpd-framework' ),
			array( $this, 'renderbuttonTextcolor' ),
			'lgpd_popup_section'
		);

		$this->registerSettingField(
			'lgpd_popup_border_text',
			_x( 'Cookie Acceptance Border Color', '(Admin)', 'lgpd-framework' ),
			array( $this, 'renderborderTextcolor' ),
			'lgpd_popup_section'
		);
	}

	public function renderEnableCheckboxpopup() {
		$enabled = lgpd( 'options' )->get( 'enable_popup' );
		echo lgpd( 'view' )->render( 'admin/cookie-popup/enable-popup', compact( 'enabled' ) );
	}
	public function renderEnableOneTimeCheckboxpopup() {
		$enabled = lgpd( 'options' )->get( 'onetime_popup' );
		echo lgpd( 'view' )->render( 'admin/cookie-popup/enable-onetime-popup', compact( 'enabled' ) );
	}
	public function renderEnablePolicyOnPopup() {
		$enabled = lgpd( 'options' )->get( 'policy_popup' );
		echo lgpd( 'view' )->render( 'admin/cookie-popup/enable-policy-popup', compact( 'enabled' ) );
	}
	public function renderheaderCheckboxpopup() {
		$content = lgpd( 'options' )->get( 'header' );
		echo lgpd( 'view' )->render( 'admin/cookie-popup/enable_popup_header', compact( 'content' ) );
	}
	public function rendercontentCheckboxpopup() {
		$content = lgpd( 'options' )->get( 'popup_content' );
		echo lgpd( 'view' )->render( 'admin/cookie-popup/enable_popup_content', compact( 'content' ) );
	}
	public function renderPopupPositionSelector() {
		$positionAction = lgpd( 'options' )->get( 'popup_position' );
		echo lgpd( 'view' )->render( 'admin/cookie-popup/position-action', compact( 'positionAction' ) );
		echo lgpd( 'view' )->render( 'admin/cookie-popup/description-position-action' );
	}
	public function renderPopupThemeSelector() {
		$themeAction = lgpd( 'options' )->get( 'popup_theme' );
		echo lgpd( 'view' )->render( 'admin/cookie-popup/theme-action', compact( 'themeAction' ) );
		echo lgpd( 'view' )->render( 'admin/cookie-popup/description-theme-action' );
	}
	public function renderAllowContentPopup() {
		$content = lgpd( 'options' )->get( 'popup_allow_text' );
		echo lgpd( 'view' )->render( 'admin/cookie-popup/enable_popup_allow_content', compact( 'content' ) );
	}
	public function renderDismissContentPopup() {
		$content = lgpd( 'options' )->get( 'popup_dismiss_text' );
		echo lgpd( 'view' )->render( 'admin/cookie-popup/enable_popup_dismiss_content', compact( 'content' ) );
	}
	public function renderlearnmorePopup() {
		$content = lgpd( 'options' )->get( 'popup_learnmore_text' );
		echo lgpd( 'view' )->render( 'admin/cookie-popup/enable_popup_learnmore_content', compact( 'content' ) );
	}
	public function renderpopuplinktarget() {
		$content = lgpd( 'options' )->get( 'popup_link_target' );
		echo lgpd( 'view' )->render( 'admin/cookie-popup/popup_link_target', compact( 'content' ) );
	}
	public function renderpopupBackgroundcolor() {
		$content['value']  = lgpd( 'options' )->get( 'popup_background' );
		$content['option'] = 'background';
		echo lgpd( 'view' )->render( 'admin/cookie-popup/popup_background_color_picker', compact( 'content' ) );
	}
	public function renderpopupTextcolor() {
		$content['value']  = lgpd( 'options' )->get( 'popup_text' );
		$content['option'] = 'text';
		echo lgpd( 'view' )->render( 'admin/cookie-popup/popup_background_color_picker', compact( 'content' ) );
	}
	public function renderbuttonBackgroundcolor() {
		$content['value']  = lgpd( 'options' )->get( 'popup_button_background' );
		$content['option'] = 'button_background';
		echo lgpd( 'view' )->render( 'admin/cookie-popup/popup_background_color_picker', compact( 'content' ) );
	}
	public function renderbuttonTextcolor() {
		$content['value']  = lgpd( 'options' )->get( 'popup_button_text' );
		$content['option'] = 'button_text';
		echo lgpd( 'view' )->render( 'admin/cookie-popup/popup_background_color_picker', compact( 'content' ) );
	}
	public function renderborderTextcolor() {
		$content['value']  = lgpd( 'options' )->get( 'popup_border_text' );
		$content['option'] = 'border_text';
		echo lgpd( 'view' )->render( 'admin/cookie-popup/popup_background_color_picker', compact( 'content' ) );
	}
}
