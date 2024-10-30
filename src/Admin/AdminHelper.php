<?php

namespace Data443\LGPD\Admin;

class AdminHelper {

	public function __construct() {
		$this->toolsHelper();
		$this->autoinstallHelper();
		$this->policyHelper();
		$this->settingsHelper();
	}

	protected function toolsHelper() {
		$toolsPage = lgpd( 'options' )->get( 'tools_page' );

		// Display the notice only on Tools page
		if ( ! $toolsPage || ! isset( $_GET['post'] ) || $_GET['post'] !== $toolsPage ) {
			return;
		}

		$post    = get_post( $toolsPage );
		$helpUrl = lgpd( 'helpers' )->docs();

		if ( ! stristr( $post->post_content, '<!-- wp:shortcode -->[lgpd_privacy_tools]<!-- /wp:shortcode -->' ) ) {
			lgpd( 'admin-notice' )->add( 'admin/notices/helper-tools', compact( 'helpUrl' ) );
		}
	}

	protected function autoinstallHelper() {
		if ( ! isset( $_GET['lgpd-notice'] ) || empty( $_GET['lgpd-notice'] ) || 'autoinstall' !== $_GET['lgpd-notice'] ) {
			return;
		}

		lgpd('admin-notice')->add('admin/notices/helper-autoinstall');
	}

	protected function policyHelper() {
		$policyPage = lgpd( 'options' )->get( 'policy_page' );

		// Display the notice only on Policy page
		if ( ! $policyPage || ! isset( $_GET['post'] ) || $_GET['post'] !== $policyPage ) {
			return;
		}

		$post    = get_post( $policyPage );
		$helpUrl = lgpd( 'helpers' )->docs();

		if ( stristr( $post->post_content, '[TODO]' ) ) {
			lgpd( 'admin-notice' )->add( 'admin/notices/helper-policy', compact( 'helpUrl' ) );
		}
	}

	protected function settingsHelper() {
		if ( lgpd( 'options' )->get( 'is_installed' ) && ( ( ! lgpd( 'options' )->get( 'tools_page' ) || is_null( get_post( lgpd( 'options' )->get( 'tools_page' ) ) ) ) ) && ! lgpd( 'options' )->get( 'custom_tools_page' ) ) {
			$this->renderSettingsHelperNotice();
		}

		if ( 'download_and_notify' === lgpd( 'options' )->get( 'export_action' ) || 'notify' === lgpd( 'options' )->get( 'export_action' ) ) {
			if ( ! lgpd( 'options' )->get( 'export_action_email' ) ) {
				$this->renderSettingsHelperNotice();
			}
		}

		if ( 'anonymize_and_notify' === lgpd( 'options' )->get( 'delete_action' ) ||
			'delete_and_notify' === lgpd( 'options' )->get( 'delete_action' ) ||
			'notify' === lgpd( 'options' )->get( 'delete_action' )
		) {
			if ( ! lgpd( 'options' )->get( 'delete_action_email' ) ) {
				$this->renderSettingsHelperNotice();
			}
		}
	}

	protected function renderSettingsHelperNotice() {
		lgpd( 'admin-notice' )->add( 'admin/notices/helper-settings' );
	}
}
