<?php

namespace Data443\LGPD\Installer\Steps;

use Data443\LGPD\Installer\InstallerStep;
use Data443\LGPD\Installer\InstallerStepInterface;

class ConfigurationPages extends InstallerStep implements InstallerStepInterface {

	protected $slug = 'configuration-pages';

	protected $type = 'wizard';

	protected $template = 'installer/steps/configuration-pages';

	protected $activeSteps = 1;

	protected function renderContent() {
		// FRAM-115 define variables before they are used
		$policyPage         = lgpd( 'options' )->get( 'policy_page' );
		$policyPageSelector = wp_dropdown_pages(
			array(
				'name'              => 'lgpd_policy_page',
				'show_option_none'  => _x( '&mdash; Create a new page &mdash;', '(Admin)', 'lgpd-framework' ),
				'option_none_value' => 'new',
				'selected'          => $policyPage ? $policyPage : 'new',
				'echo'              => false,
				'class'             => 'lgpd-select js-lgpd-select2',
			)
		);

		$privacyToolsPage         = lgpd( 'options' )->get( 'tools_page' );
		$privacyToolsPageSelector = wp_dropdown_pages(
			array(
				'name'              => 'lgpd_tools_page',
				'show_option_none'  => _x( '&mdash; Create a new page &mdash;', '(Admin)', 'lgpd-framework' ),
				'option_none_value' => 'new',
				'selected'          => $privacyToolsPage ? $privacyToolsPage : 'new',
				'echo'              => false,
				'class'             => 'lgpd-select js-lgpd-select2',
			)
		);

		echo lgpd( 'view' )->render(
			$this->template,
			compact(
				'policyPage',
				'policyPageSelector',
				'privacyToolsPage',
				'privacyToolsPageSelector'
			)
		);
	}

	public function submit() {
		if ( isset( $_POST['lgpd_create_tools_page'] ) && 'yes' === $_POST['lgpd_create_tools_page'] ) {
			$id = $this->createPrivacyToolsPage();
			lgpd( 'options' )->set( 'tools_page', $id );
		} else {
			lgpd( 'options' )->set( 'tools_page', $_POST['lgpd_tools_page'] );
		}
	}

	protected function createPrivacyToolsPage() {
		$id = wp_insert_post(
			array(
				'post_content' => '<!-- wp:shortcode -->[lgpd_privacy_tools]<!-- /wp:shortcode -->',
				'post_title'   => __( 'Privacy Tools', 'lgpd-framework' ),
				'post_type'    => 'page',
			)
		);

		return $id;
	}
}
