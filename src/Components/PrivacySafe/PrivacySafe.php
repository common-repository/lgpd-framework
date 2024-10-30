<?php

namespace Data443\LGPD\Components\PrivacySafe;

class PrivacySafe {

	public function __construct() {
		 add_filter( 'lgpd/admin/tabs', array( $this, 'registerAdminTab' ), 80 );
	}

	public function registerAdminTab( $tabs ) {
		 $tabs['privacy-safe'] = new AdminTabPrivacySafe();
		return $tabs;
	}
}
