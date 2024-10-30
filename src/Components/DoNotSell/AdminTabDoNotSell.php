<?php

namespace Data443\LGPD\Components\DoNotSell;

use Data443\LGPD\Admin\AdminTab;

class AdminTabDoNotSell extends AdminTab {

	/* @var string */
	protected $slug = 'do-not-sell';

	/* @var PolicyGenerator */
	protected $policyGenerator;

	public function __construct() {
		 $this->title = _x( 'Do Not Sell My Data', '(Admin)', 'lgpd-framework' );
		//$this->registerSetting( 'lgpd_privacy_safe_params' );
		//$this->registerSetting( 'lgpd_privacy_safe_imagecode' );

		add_action( 'lgpd/admin/action/PrivacyManager/generate', array( $this, 'generateDoNotSell' ) );

	}

	public function init() {
		/**
		 * Do Not Sell My Data settings
		 */
		$this->registerSettingSection(
			'lgpd_about_privacy_safe_section',
			_x( 'Do Not Sell My Data', '(Admin)', 'lgpd-framework' ),
			array( $this, 'renderAboutHeader' )
		);

		$this->registerSettingField(
			'lgpd_privacy_safe_shortcode',
			_x( 'Shortcode', '(Admin)', 'lgpd-framework' ), 
			array( $this, 'shortcode' ),
			'lgpd_about_privacy_safe_section'
		);
		$this->registerSettingField(
			'lgpd_privacy_safe_shortcodephp',
			_x( 'Shortcode for PHP', '(Admin)', 'lgpd-framework' ),
			array( $this, 'shortcodephp' ),
			'lgpd_about_privacy_safe_section'
		);

	}

	public function renderAboutHeader() {
		echo '<p>Place this shortcode on the page you would like to accept requests from users to not sell their information. We recommend placing the shortcode under the privacy tools shortcode on the privacy tools page.</p>';
	}

	public function renderSubmitButton()
	{
		// FRAM-134 - remove unnecessary save button
		// this overrides the placement of a save button which is not needed
	}

	public function shortcode() {
		echo "<code>[lgpd_do_not_sell_form]</code>";
	}
	public function shortcodephp() {
		echo "<code>echo do_shortcode('[lgpd_do_not_sell_form]');</code>";
	}
}
