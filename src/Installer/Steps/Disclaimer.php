<?php


namespace Data443\LGPD\Installer\Steps;

use Data443\LGPD\Installer\InstallerStep;
use Data443\LGPD\Installer\InstallerStepInterface;

class Disclaimer extends InstallerStep implements InstallerStepInterface {

	protected $slug = 'disclaimer';

	protected $type = 'wizard';

	protected $template = 'installer/steps/disclaimer';

	protected $activeSteps = 0;

	public function submit() {
		lgpd( 'options' )->set( 'plugin_disclaimer_accepted', 'yes' );
	}
}
