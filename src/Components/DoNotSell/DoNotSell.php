<?php

namespace Data443\LGPD\Components\DoNotSell;

class DoNotSell {

	public function __construct() {
		 add_filter( 'lgpd/admin/tabs', array( $this, 'registerAdminTab' ), 36 );
	}

	public function registerAdminTab( $tabs ) {
		 $tabs['do-not-sell'] = new AdminTabDoNotSell();
		return $tabs;
	}
}
