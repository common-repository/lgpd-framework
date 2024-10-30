<?php

namespace Data443\LGPD\Components\Consent;

use Data443\LGPD\Admin\AdminTab;

/**
 * Handle rendering and saving the Consent tab on LGPD Options page
 *
 * Class AdminTabConsent
 *
 * @package Data443\LGPD\Components\Consent
 */
class AdminTabConsent extends AdminTab {

	/* @var string */
	protected $slug = 'consent';

	/* @var ConsentManager */
	protected $consentManager;

	/**
	 * AdminTabConsent constructor.
	 *
	 * @param ConsentManager $consentManager
	 */
	public function __construct( ConsentManager $consentManager ) {
		$this->consentManager = $consentManager;

		$this->title = _x( 'Consent', '(Admin)', 'lgpd-framework' );

		// If we don't register the settings, WP will not allow this page to be submitted
		$this->registerSetting( 'consent_types' );
		$this->registerSetting( 'consent_info' );
		$this->registerSetting( 'lgpd_consent_until_display' );

		$this->renderErrors();

		// Register handler for this action
		add_action( 'lgpd/admin/action/update_consent_data', array( $this, 'updateConsentData' ) );
	}

	/**
	 * Initialize tab contents and register hooks
	 */
	public function init() {
		$this->registerSettingSection(
			'lgpd_section_consent',
			_x( 'Consent', '(Admin)', 'lgpd-framework' ),
			array( $this, 'renderConsentForm' )
		);
		$this->registerSettingSection(
            'lgpd_section_consent_until',
            _x('Additional Settings', '(Admin)', 'lgpd-framework'),
            [$this, 'renderConsentUntil']
		);
		$this->registerSettingField(
			'lgpd_consent_until_display',
			_x( 'Display Consent Calendar', '(Admin)', 'lgpd-framework' ),
			array( $this, 'consent_until_display' ),
			'lgpd_section_consent_until'
		);
	}

	/**
	 * Render the contents of the registered section
	 */
	public function renderConsentForm() {
		$consentInfo = lgpd( 'options' )->get( 'consent_info' );

		if ( is_null( $consentInfo ) ) {
			$consentInfo = $this->getDefaultConsentInfo();
		} elseif ( ! $consentInfo ) {
			$consentInfo = '';
		}

		$nonce               = wp_create_nonce( 'lgpd/admin/action/update_consent_data' );
		$defaultConsentTypes = $this->consentManager->getDefaultConsentTypes();
		$customConsentTypes  = $this->consentManager->getCustomConsentTypes();

		// todo: move to a filter
		if ( defined( 'ICL_LANGUAGE_CODE' ) ) {
			$prefix = ICL_LANGUAGE_CODE . '_';
		} else {
			$prefix = '';
		}

		echo lgpd( 'view' )->render( 'admin/consent', compact( 'nonce', 'customConsentTypes', 'defaultConsentTypes', 'consentInfo', 'prefix' ) );
	}

	/**
	 * Save the submitted consent types
	 */
	public function updateConsentData() {
		// Update additional information
		if ( isset( $_POST['lgpd_consent_info'] ) ) {
			lgpd( 'options' )->set( 'consent_info', wp_unslash( $_POST['lgpd_consent_info'] ) );
		}

		// Update consent types
		if ( isset( $_POST['lgpd_consent_types'] ) && is_array( $_POST['lgpd_consent_types'] ) ) {
			$consentTypes = $_POST['lgpd_consent_types'];
		} else {
			$consentTypes = array();
		}

		// Strip slashes which WP adds automatically
		if ( count( $consentTypes ) ) {
			foreach ( $consentTypes as &$type ) {
				foreach ( $type as $key => $item ) {
					if ( is_array( $item ) ) {
						$type[ $key ] = array_map( 'wp_unslash', $item );
					} else {
						$type[ $key ] = wp_unslash( $item );
					}

					if ( 'visible' === $key ) {
						$type[ $key ] = 1;
					}
				}
			}
		}

		$errors = array();

		if ( ! empty( $consentTypes ) ) {
			//$errors = $this->validate( $consentTypes );
		}

		if ( ! count( $errors ) ) {
			$this->consentManager->saveCustomConsentTypes( $consentTypes );
		} else {
			$errorQuery = http_build_query( $errors );
			wp_safe_redirect( lgpd( 'helpers' )->getAdminUrl( '&lgpd-tab=consent&' ) . $errorQuery );
			exit;
		}
	}

	protected function validate( $consentTypes ) {
		$errors = array();

		foreach ( $consentTypes as $consentType ) {
			if ( empty( $consentType['slug'] ) ) {
				$errors['errors[]'] = 'slug-empty';
			}

			if ( ! preg_match( '/^[A-Za-z0-9_-]+$/', $consentType['slug'] ) ) {
				$errors['errors[]'] = 'slug-invalid';
			}

			if ( empty( $consentType['title'] ) ) {
				$errors['errors[]'] = 'title-empty';
			}
		}

		return $errors;
	}

	public function renderErrors() {
		if ( isset( $_GET['errors'] ) && count( $_GET['errors'] ) ) {

			foreach ( $_GET['errors'] as $error ) {
				if ( 'slug-empty' === $error ) {
					$message = _x( 'Consent slug is a required field!', '(Admin)', 'lgpd-framework' );
					lgpd( 'admin-error' )->add( 'admin/notices/error', compact( 'message' ) );
				}

				if ( 'slug-invalid' === $error ) {
					$message = _x( 'You may only use alphanumeric characters, dash and underscore in the consent slug field.', '(Admin)', 'lgpd-framework' );
					lgpd( 'admin-error' )->add( 'admin/notices/error', compact( 'message' ) );
				}

				if ( 'title-empty' === $error ) {
					$message = _x( 'Consent title is a required field!', '(Admin)', 'lgpd-framework' );
					lgpd( 'admin-error' )->add( 'admin/notices/error', compact( 'message' ) );
				}
			}
		}
	}

	/**
	 * @return string
	 */
	public function getDefaultConsentInfo() {
		return __( 'To use this website, you accepted our Privacy Policy. If you wish to withdraw your acceptance, please use the "Delete my data" button below.', 'lgpd-framework' );
	}

	public function renderConsentUntil() {
		echo '<p>Enable this feature to allow users to submit a time limit on how many months their consent is given for their coments and registration.</p>';
	}

	public function consent_until_display(){
		if ( get_option( 'lgpd_consent_until_display' ) === '1' ) {
			$checked = get_option( 'lgpd_consent_until_display' );
		}else{
			$checked = 0;
		}		
		echo lgpd( 'view' )->render( 'admin/consent/enable-consent-until' , compact( 'checked' ) );
	}
}
