<?php
namespace Data443\LGPD\Admin;

/**
 * AdminError
 */
class AdminError extends AdminNotice {
	/**
	 * Render
	 *
	 * @return void
	 */
	public function render() {
		if ( ! $this->template ) {
            return;
		}
		echo esc_attr( lgpd( 'view' )->render( $this->template, $this->data ) );
	}
}
