<?php

namespace Data443\LGPD\Components\CookiePopup;

/**
 * Handles putting together and rendering the privacy policy page
 *
 * Class CookiePopup
 *
 * @package Data443\LGPD\Components\CookiePopup
 */
class CookiePopup {

	public function __construct() {
		add_filter( 'lgpd/admin/tabs', array( $this, 'registerAdminTab' ), 20 );
	}

	public function registerAdminTab( $tabs ) {
		$tabs['cookie-popup'] = new AdminTabCookiePopup();
		return $tabs;
	}
}
