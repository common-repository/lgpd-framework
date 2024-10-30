<?php

namespace Data443\LGPD\Installer\Steps;

use Data443\LGPD\Installer\InstallerStep;
use Data443\LGPD\Installer\InstallerStepInterface;

/**
 * Handle the first step on installer screen
 *
 * Class Welcome
 *
 * @package Data443\LGPD\Installer\Steps
 */
class Welcome extends InstallerStep implements InstallerStepInterface {

	protected $slug = 'welcome';

	protected $type = 'wizard';

	protected $template = 'installer/steps/welcome';

	protected $activeSteps = 0;

	protected function renderFooter() {
		echo lgpd( 'view' )->render( 'installer/footer', array( 'disableBackButton' => true ) );
	}
}
