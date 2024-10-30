<?php

namespace Data443\LGPD\Components\Consent;

class ConsentAdmin {

	public function __construct() {
		add_filter( 'lgpd/admin/tabs', array( $this, 'registerAdminTab' ), 20 );
	}

    public function registerAdminTab( $tabs ) {
        global $lgpd;
        $tabs['consent'] = new AdminTabConsent($lgpd->Consent);
        return $tabs;
    }
}
