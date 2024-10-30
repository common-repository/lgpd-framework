<?php

namespace Data443\LGPD\Installer\Steps;

use Data443\LGPD\Installer\InstallerStep;
use Data443\LGPD\Installer\InstallerStepInterface;

class Integrations extends InstallerStep implements InstallerStepInterface {

	protected $slug = 'integrations';

	protected $type = 'wizard';

	protected $template = 'installer/steps/integrations';

	protected $activeSteps = 4;

	protected function renderContent() {
		$enableThemeCompatibility = lgpd( 'options' )->get( 'enable_theme_compatibility' );
		$currentTheme             = lgpd( 'themes' )->getCurrentThemeName();
		$isThemeSupported         = lgpd( 'themes' )->isCurrentThemeSupported();

		$hasWooCommerce = false;
		$hasEDD         = false;
		$hasSendGrid    = class_exists( '\Sendgrid_Tools' );

		echo lgpd( 'view' )->render(
			$this->template,
			compact(
				'enableThemeCompatibility',
				'hasEDD',
				'hasWooCommerce',
				'currentTheme',
				'isThemeSupported',
				'hasSendGrid'
			)
		);
	}

	public function submit() {
		if ( isset( $_POST['lgpd_enable_theme_compatibility'] ) && 'yes' === $_POST['lgpd_enable_theme_compatibility'] ) {
			lgpd( 'options' )->set( 'enable_theme_compatibility', true );
		} else {
			lgpd( 'options' )->set( 'enable_theme_compatibility', false );
		}
	}
}
