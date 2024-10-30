<?php

namespace Data443\LGPD\Admin;

/**
 * Handle registering and rendering the LGPD admin page contents
 *
 * Class WordpressAdminPage
 *
 * @package Data443\LGPD\Admin
 */
class WordpressAdminPage {

	protected $slug = 'lgpd';

	protected $tabs = array();

	public function __construct() {
		$this->setup();
	}

	protected function setup() {
		// Register the tabs
		add_action( 'admin_init', array( $this, 'registerTabs' ) );

		// todo
		// if (lgpd('options')->get('plugin_disclaimer_accepted')) {
			// Initialize the active tab
			add_action( 'admin_init', array( $this, 'initActiveTab' ) );
		// }

		// todo
		// lgpd('admin-modal')->add('lgpd-test', 'admin/modals/test', ['title' => 'Test modal']);
	}

	/**
	 * Render the main LGPD options page
	 */
	public function renderPage() {
		$tabs               = $this->getNavigationData();
		$currentTabContents = $this->getActiveTab()->renderContents();
		$signature          = apply_filters( 'lgpd/admin/show_signature', true );
		echo lgpd( 'view' )->render( 'admin/settings-page', compact( 'tabs', 'currentTabContents', 'signature' ) );
	}

	/**
	 * Allow modules to add tabs
	 */
	public function registerTabs() {
		$this->tabs = apply_filters( 'lgpd/admin/tabs', array() );
	}

	/**
	 * Get the active tab or the first tab if none are active
	 *
	 * @return AdminTabInterface
	 */
	public function getActiveTab() {
		foreach ( $this->tabs as $tab ) {
			if ( isset( $_GET['lgpd-tab'] ) && $_GET['lgpd-tab'] === $tab->getSlug() ) {
				return $tab;
			}
		}

		return reset( $this->tabs );
	}

	/**
	 * Check if the given tab is active
	 *
	 * @param $slug
	 * @return bool
	 */
	public function isTabActive( $slug ) {
		$activeTab = $this->getActiveTab();
		if ( $activeTab->getSlug() === $slug ) {
			return true;
		}

		// Hacky: if no tab set, the first tab is active
		if ( ! isset( $_GET['lgpd-tab'] ) ) {
			$firstTab = reset( $this->tabs );
			if ( $firstTab->getSlug() === $slug ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Initialize the active tab
	 */
	public function initActiveTab() {
		$activeTab = $this->getActiveTab();
		$activeTab->setup();
	}

	/**
	 * Get the tabbed navigation for LGPD options page
	 *
	 * @return array
	 */
	public function getNavigationData() {
		if ( ! count( $this->tabs ) ) {
			return array();
		}

		$navigation = array();

		foreach ( $this->tabs as $tab ) {
			/* @var $tab AdminTabInterface */
			$navigation[ $tab->getSlug() ] = array(
				'slug'   => $tab->getSlug(),
				'url'    => $this->getTabUrl( $tab->getSlug() ),
				'title'  => $tab->getTitle(),
				'active' => false,
			);

			if ( $this->isTabActive( $tab->getSlug() ) ) {
				$navigation[ $tab->getSlug() ]['active'] = true;
			}
		}

		return $navigation;
	}


	/**
	 * todo: move to helper?
	 *
	 * @param $slug
	 * @return string
	 */
	public function getTabUrl( $slug ) {
		return admin_url( 'tools.php?page=lgpd_privacy&lgpd-tab=' . $slug );
	}
}
