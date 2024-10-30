<?php

namespace Data443\LGPD\DataSubject;

class DataSubjectAdmin {

	public function __construct() {
		add_filter( 'lgpd/admin/tabs', array( $this, 'registerTab' ), 30 );
	}

    public function registerTab( $tabs ) {
        global $lgpd;
        $tabs['data-subject'] = new AdminTabDataSubject($lgpd->DataSubject);
        return $tabs;
    }
}
