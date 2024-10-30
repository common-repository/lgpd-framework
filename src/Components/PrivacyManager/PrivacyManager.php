<?php

namespace Data443\LGPD\Components\PrivacyManager;

/**
 * Handles putting together and rendering the privacy policy page
 *
 * Class PrivacyManager
 *
 * @package Data443\LGPD\Components\PrivacyManager
 */
class PrivacyManager {

	public function __construct() {
		add_filter( 'lgpd/admin/tabs', array( $this, 'registerAdminTab' ), 80 );
	}

	public function registerAdminTab( $tabs ) {
		$tabs['privacy-manager'] = new AdminTabPrivacyManager();
		return $tabs;
	}
}
