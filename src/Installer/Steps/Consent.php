<?php

namespace Data443\LGPD\Installer\Steps;

use Data443\LGPD\Installer\InstallerStep;
use Data443\LGPD\Installer\InstallerStepInterface;

class Consent extends InstallerStep implements InstallerStepInterface {

	protected $slug = 'consent';

	protected $type = 'wizard';

	protected $template = 'installer/steps/consent';

	protected $activeSteps = 3;

	protected function renderContent() {
		$isRegistrationOpen  = get_option( 'users_can_register' );
		$isCommentsEnabled   = class_exists( 'Disable_Comments' ) ? false : true;
		$privacyToolsPageUrl = get_permalink( lgpd( 'options' )->get( 'tools_page' ) );
		$hasGravityForms     = class_exists( '\GFForms' );
		$hasCF7              = class_exists( '\WPCF7' );
		$hasFrm              = class_exists( '\FrmHooksController' );
		echo lgpd( 'view' )->render(
			$this->template,
			compact( 'isRegistrationOpen', 'isCommentsEnabled', 'privacyToolsPageUrl', 'hasGravityForms', 'hasCF7', 'hasFrm' )
		);
	}
}
