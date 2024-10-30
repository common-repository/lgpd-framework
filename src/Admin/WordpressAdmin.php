<?php

namespace Data443\LGPD\Admin;

/**
 * Handles general admin functionality
 *
 * Class WordpressAdmin
 *
 * @package Data443\LGPD\Admin
 */
class WordpressAdmin {

	public function __construct( WordpressAdminPage $adminPage ) {
		$this->adminPage = $adminPage;

		// Allow turning off helpers
		if ( apply_filters( 'lgpd/admin/helpers/enabled', true ) ) {
			new AdminHelper();
		}

		$this->setup();

	}

	/**
	 * Set up hooks
	 */
	protected function setup() {
		// Register the main LGPD options page
		add_action( 'admin_menu', array( $this, 'registerLGPDOptionsPage' ) );

		// Register General admin tab
		add_filter( 'lgpd/admin/tabs', array( $this, 'registerAdminTabGeneral' ), 0 );

		// Enqueue assets
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue' ) );

		// Register post states
		add_filter( 'display_post_states', array( $this, 'registerPostStates' ), 10, 2 );

		// Show help notice
		add_action( 'current_screen', array( $this, 'maybeShowHelpNotice' ), 999 );

				add_action( 'delete_user', array( $this, 'lgpdf_delete_userlogs' ) );
	}


	public function maybeShowHelpNotice() {
		if ( 'tools_page_lgpd_privacy' === get_current_screen()->base ) {
			// lgpd('admin-notice')->add('admin/notices/help');
		}
	}

	/**
	 * Register the LGPD options page in WP admin
	 */
	public function registerLGPDOptionsPage() {
		add_management_page(
			_x( 'Privacy & LGPD Settings', '(Admin)', 'lgpd-framework' ),
			_x( 'Data443 LGPD', '(Admin)', 'lgpd-framework' ),
			'manage_options',
			'lgpd_privacy',
			array( $this->adminPage, 'renderPage' )
		);
	}

	/**
	 * Register General admin tab
	 *
	 * @param $tabs
	 * @return array
	 */
    public function registerAdminTabGeneral( $tabs ) {
        global $lgpd;
        $tabs['general'] = $lgpd->AdminTabGeneral;
        return $tabs;
    }

	/**
	 * Enqueue all admin scripts and styles
	 */
	public function enqueue() {
		/**
		 * General admin styles
		 */
		wp_enqueue_style(
			'lgpd-admin',
			lgpd( 'config' )->get( 'plugin.url' ) . 'assets/css/lgpd-admin.css'
		);

		$screen = get_current_screen();
		if ( $screen->base == 'tools_page_lgpd_privacy' ) {
			/**
			 * jQuery UI dialog for modals
			 */
			// wp_enqueue_style('wp-jquery-ui-dialog');
			wp_enqueue_script(
				'lgpd-admin',
				lgpd( 'config' )->get( 'plugin.url' ) . 'assets/js/lgpd-admin.js',
				array( 'jquery-ui-dialog' )
			);
			/**
			 * jQuery Repeater
			 */
			wp_enqueue_script(
				'jquery-repeater',
				lgpd( 'config' )->get( 'plugin.url' ) . 'assets/js/jquery.repeater.min.js',
				array( 'jquery' )
			);

			/**
			 * Select2
			 */

			wp_dequeue_script( 'select2css' );
			wp_dequeue_script( 'select2' );

			wp_enqueue_style(
				'select2css',
				lgpd( 'config' )->get( 'plugin.url' ) . 'assets/css/select2-4.0.5.css'
			);

			wp_enqueue_script(
				'select2',
				lgpd( 'config' )->get( 'plugin.url' ) . 'assets/js/select2-4.0.3.js',
				array( 'jquery' )
			);

			wp_enqueue_script(
				'conditional-show',
				lgpd( 'config' )->get( 'plugin.url' ) . 'assets/js/conditional-show.js',
				array( 'jquery' )
			);
			/**
			 * Color Picker
			 */
			// wp_enqueue_script( 'iris',lgpd('config')->get('plugin.url') .'assets/js/iris.min.js' );
			wp_enqueue_script( 'iris' );
			wp_enqueue_script( 'iris-init', lgpd( 'config' )->get( 'plugin.url' ) . 'assets/js/iris-init.js', array( 'iris' ), false, true );
		}
	}

	/**
	 * Add a new Post State for our super important system pages
	 */
	public function registerPostStates( $postStates, $post ) {
		if ( lgpd( 'options' )->get( 'policy_page' ) == $post->ID ) {
			$postStates['lgpd_policy_page'] = _x( 'Privacy Policy Page', '(Admin)', 'lgpd-framework' );
		}

		if ( lgpd( 'options' )->get( 'tools_page' ) == $post->ID ) {
			$postStates['lgpd_tools_page'] = _x( 'Privacy Tools Page', '(Admin)', 'lgpd-framework' );
		}

		return $postStates;
	}
	// Delete userlogs if user deleted from admin panel.
	public function lgpdf_delete_userlogs( $user_id ) {
		global $wpdb;

		$this->logtableName = $wpdb->prefix . 'lgpd_userlogs';

		return $wpdb->delete(
			$this->logtableName,
			array(
				'user_id' => $user_id,
			)
		);
	}

}
