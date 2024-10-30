<?php

namespace Data443\LGPD\Admin;

class AdminNotice {

	protected $template;

	protected $data;

	/**
	 * AdminNotice constructor.
	 */
	public function __construct() {
		if ( did_action( 'admin_notices' ) ) {
            return;
		}

		add_action( 'admin_notices', array( $this, 'render' ), 9999 );
	}

	public function add( $template, $data = array() ) {
		$this->template = $template;
		$this->data     = $data;
	}

	public function render() {
		if ( ! $this->template ) {
            return;
		}

		echo lgpd( 'view' )->render( 'admin/notices/header' );
		echo lgpd( 'view' )->render( $this->template, $this->data );
		echo lgpd( 'view' )->render( 'admin/notices/footer' );
	}
}
