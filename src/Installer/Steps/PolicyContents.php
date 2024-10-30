<?php


namespace Data443\LGPD\Installer\Steps;

use Data443\LGPD\Installer\InstallerStep;
use Data443\LGPD\Installer\InstallerStepInterface;

class PolicyContents extends InstallerStep implements InstallerStepInterface {

	protected $slug = 'policy-contents';

	protected $type = 'wizard';

	protected $template = 'installer/steps/policy-contents';

	protected $activeSteps = 2;

	protected function renderContent() {
		$policyUrl = get_permalink( lgpd( 'options' )->get( 'policy_page' ) );
		add_filter( 'lgpd_custom_policy_link', 'lgpdfPrivacyPolicyurl' );
		$policyUrl       = apply_filters( 'lgpd_custom_policy_link', $policyUrl );
		$editPolicyUrl   = get_edit_post_link( lgpd( 'options' )->get( 'policy_page' ) );
		$policyGenerated = lgpd( 'options' )->get( 'policy_generated' );

		echo lgpd( 'view' )->render(
			$this->template,
			compact( 'policyUrl', 'editPolicyUrl', 'policyGenerated' )
		);
	}
}
