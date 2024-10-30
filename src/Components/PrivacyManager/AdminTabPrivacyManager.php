<?php

namespace Data443\LGPD\Components\PrivacyManager;

use Data443\LGPD\Admin\AdminTab;

class AdminTabPrivacyManager extends AdminTab {

	/* @var string */
	protected $slug = 'privacy-manager';

	/* @var PolicyGenerator */
	protected $policyGenerator;

	public function __construct() {
		$this->title = _x( 'Global Privacy Manager', '(Admin)', 'lgpd-framework' );

		add_action( 'lgpd/admin/action/PrivacyManager/generate', array( $this, 'generatePrivacyManager' ) );
	}

	public function init() {
		/**
		 * General settings
		 */
		$this->registerSettingSection(
			'lgpd_section_privacy_policy',
			_x( 'Global Privacy Manager', '(Admin)', 'lgpd-framework' ),
			array( $this, 'renderHeader' )
		);

	}

	public function renderHeader() {
		echo lgpd( 'view' )->render( 'admin/privacy-manager/header' );
	}

	public function renderSubmitButton() {
		// submit_button(_x('Save', '(Admin)', 'lgpd-framework'));
	}

}
