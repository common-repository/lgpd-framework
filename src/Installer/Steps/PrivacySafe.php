<?php


namespace Data443\LGPD\Installer\Steps; 

use Data443\LGPD\Installer\InstallerStep;
use Data443\LGPD\Installer\InstallerStepInterface;

class PrivacySafe extends InstallerStep implements InstallerStepInterface {
	protected $slug = 'privacy-safe';

	protected $type = 'wizard';

	protected $template = 'installer/steps/privacy-safe';

	protected $activeSteps = 0;

	public function submit() {
		if ( isset( $_POST['lgpd_privacy_safe_params'] ) ) {
			$seal_code  = sanitize_text_field( wp_unslash( $_POST['lgpd_privacy_safe_params'] ) );
			$image_code = sanitize_text_field( wp_unslash( $_POST['lgpd_privacy_safe_imagecode'] ) );
			if ( ! get_option( 'lgpd_privacy_safe_params' ) ) {
				lgpd( 'options' )->set( 'lgpd_privacy_safe_params', $seal_code );
			} else {
				update_option( 'lgpd_privacy_safe_params', $seal_code );
			}
			if ( ! get_option( 'lgpd_privacy_safe_imagecode' ) ) {
				lgpd( 'options' )->set( 'lgpd_privacy_safe_imagecode', $image_code );
			} else {
				update_option( 'lgpd_privacy_safe_imagecode', $image_code );
			}
		}

	}
}
