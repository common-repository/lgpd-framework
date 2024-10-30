<?php

namespace Data443\LGPD\Components\Support;

use Data443\LGPD\Admin\AdminTab;

class AdminTabSupport extends AdminTab {

	protected $slug = 'support';

	public function __construct() {
		$this->title = _x( 'Support', '(Admin)', 'lgpd-framework' );
	}

	public function init() {
		$this->registerSettingSection(
			'lgpd-section-support',
			_x( 'Support', '(Admin)', 'lgpd-framework' ),
			array( $this, 'renderTab' )
		);
	}

	public function renderTab() {
		echo lgpd( 'view' )->render( 'admin/support/contents' );
	}

	public function renderSubmitButton() {
		// Intentionally left blank
	}
}
