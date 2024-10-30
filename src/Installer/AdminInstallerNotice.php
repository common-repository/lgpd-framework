<?php

namespace Data443\LGPD\Installer;

use Data443\LGPD\Admin\AdminNotice;

class AdminInstallerNotice extends AdminNotice {

	public function render() {
		if ( ! $this->template ) {
            return;
		}

		echo lgpd( 'view' )->render( 'admin/notices/header-step' );
		echo lgpd( 'view' )->render( $this->template, $this->data );
		echo lgpd( 'view' )->render( 'admin/notices/footer-step' );
	}
}
