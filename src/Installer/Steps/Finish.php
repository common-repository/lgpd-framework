<?php

namespace Data443\LGPD\Installer\Steps;

use Data443\LGPD\Installer\InstallerStep;
use Data443\LGPD\Installer\InstallerStepInterface;

class Finish extends InstallerStep implements InstallerStepInterface {

	protected $slug = 'finish';

	protected $type = 'wizard';

	protected $template = 'installer/steps/finish';

	protected $activeSteps = 4;

	public function submit() {
		lgpd( 'options' )->set( 'is_installed', true );
	}

	protected function renderFooter() {
		echo lgpd( 'view' )->render( 'installer/footer', array( 'disableBackButton' => true ) );
	}
}
