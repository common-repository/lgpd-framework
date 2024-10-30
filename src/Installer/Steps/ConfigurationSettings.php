<?php

namespace Data443\LGPD\Installer\Steps;

use Data443\LGPD\Installer\InstallerStep;
use Data443\LGPD\Installer\InstallerStepInterface;

class ConfigurationSettings extends InstallerStep implements InstallerStepInterface {

	protected $slug = 'configuration-settings';

	protected $type = 'wizard';

	protected $template = 'installer/steps/configuration-settings';

	protected $activeSteps = 1;

	protected function renderContent() {
		$privacyToolsPageUrl = get_permalink( lgpd( 'options' )->get( 'tools_page' ) );
		$deleteAction        = lgpd( 'options' )->get( 'delete_action' );
		$deleteActionEmail   = lgpd( 'options' )->get( 'delete_action_email' );

		$exportAction      = lgpd( 'options' )->get( 'export_action' );
		$exportActionEmail = lgpd( 'options' )->get( 'export_action_email' );

		$reassign     = lgpd( 'options' )->get( 'delete_action_reassign' );
		$reassignUser = lgpd( 'options' )->get( 'delete_action_reassign_user' );

		echo lgpd( 'view' )->render(
			$this->template,
			compact(
				'deleteAction',
				'deleteActionEmail',
				'exportAction',
				'exportActionEmail',
				'privacyToolsPageUrl',
				'reassign',
				'reassignUser'
			)
		);
	}

	public function submit() {
		if ( isset( $_POST['lgpd_export_action'] ) ) {
			lgpd( 'options' )->set( 'export_action', sanitize_text_field( $_POST['lgpd_export_action'] ) );
		}

		if ( isset( $_POST['lgpd_export_action_email'] ) ) {
			lgpd( 'options' )->set( 'export_action_email', sanitize_email( $_POST['lgpd_export_action_email'] ) );
		}

		if ( isset( $_POST['lgpd_delete_action'] ) ) {
			lgpd( 'options' )->set( 'delete_action', sanitize_text_field( $_POST['lgpd_delete_action'] ) );
		}

		if ( isset( $_POST['lgpd_delete_action_email'] ) ) {
			lgpd( 'options' )->set( 'delete_action_email', sanitize_email( $_POST['lgpd_delete_action_email'] ) );
		}

		if ( isset( $_POST['lgpd_delete_action_reassign'] ) ) {
			lgpd( 'options' )->set( 'delete_action_reassign', sanitize_text_field( $_POST['lgpd_delete_action_reassign'] ) );
		}

		if ( isset( $_POST['lgpd_delete_action_reassign_user'] ) ) {
			lgpd( 'options' )->set( 'delete_action_reassign_user', sanitize_text_field( $_POST['lgpd_delete_action_reassign_user'] ) );
		}
	}
}
