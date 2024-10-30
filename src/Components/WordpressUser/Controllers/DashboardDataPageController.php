<?php

namespace Data443\LGPD\Components\WordpressUser\Controllers;

use Data443\LGPD\DataSubject\DataExporter;
use Data443\LGPD\DataSubject\DataSubject;
use Data443\LGPD\DataSubject\DataSubjectAuthenticator;

/**
 * Handles Users > Privacy Tools page
 *
 * Class DashboardDataPageController
 *
 * @package Data443\LGPD\Modules\WordpressUser\Controllers
 */
class DashboardDataPageController {

	/**
	 * DashboardDataPageController constructor.
	 *
	 * @param DataExporter $dataExporter
	 */
	public function __construct( DataExporter $dataExporter, DataSubjectAuthenticator $dataSubjectAuthenticator ) {
		$this->dataExporter             = $dataExporter;
		$this->dataSubjectAuthenticator = $dataSubjectAuthenticator;

		add_action( 'lgpd/dashboard/privacy-tools/content', array( $this, 'renderHeader' ), 10 );
		add_action( 'lgpd/dashboard/privacy-tools/content', array( $this, 'renderConsentForm' ), 20 );
		add_action( 'lgpd/dashboard/privacy-tools/content', array( $this, 'renderExportForm' ), 30 );
		add_action( 'lgpd/dashboard/privacy-tools/content', array( $this, 'renderDeleteForm' ), 40 );

		add_action( 'lgpd/dashboard/privacy-tools/action/withdraw_consent', array( $this, 'withdrawConsent' ) );
		add_action( 'lgpd/dashboard/privacy-tools/action/export', array( $this, 'export' ) );
		add_action( 'lgpd/dashboard/privacy-tools/action/forget', array( $this, 'forget' ) );

		add_action( 'admin_notices', array( $this, 'renderAdminNotices' ) );
	}

	/**
	 * Render success notices via admin_notice action
	 */
	public function renderAdminNotices() {
		if ( 'profile_page_lgpd-profile' !== get_current_screen()->base ) {
			return;
		}

		if ( ! isset( $_REQUEST['lgpd_notice'] ) ) {
			return;
		}

		if ( 'request_sent' === sanitize_key( $_REQUEST['lgpd_notice'] ) ) {
			$message = __( 'We have received your request and will reply within 30 days.', 'lgpd-framework' );
			$class   = 'notice notice-success';
		}

		if ( 'consent_withdrawn' === sanitize_key( $_REQUEST['lgpd_notice'] ) ) {
			$message = __( 'Consent withdrawn.', 'lgpd-framework' );
			$class   = 'notice notice-success';
		}

		echo lgpd( 'view' )->render( 'admin/notice', compact( 'message', 'class' ) );
	}

	/**
	 * Render page header
	 */
	public function renderHeader() {
		echo lgpd( 'view' )->render(
			'modules/wordpress-user/dashboard/data-page/header'
		);
	}

	/**
	 * Render the consent form
	 *
	 * @param DataSubject $dataSubject
	 */
	public function renderConsentForm( DataSubject $dataSubject ) {
		$consentData = $dataSubject->getVisibleConsentData();

		foreach ( $consentData as &$item ) {
			$item['withdraw_url'] = add_query_arg(
				array(
					'lgpd_action' => 'withdraw_consent',
					'lgpd_nonce'  => wp_create_nonce( 'lgpd/dashboard/privacy-tools/action/withdraw_consent' ),
					'email'       => $dataSubject->getEmail(),
					'consent'     => $item['slug'],
				)
			);
		}

		$consentInfo = wpautop( lgpd( 'options' )->get( 'consent_info' ) );

		echo lgpd( 'view' )->render(
			'modules/wordpress-user/dashboard/data-page/form-consent',
			compact( 'consentData', 'consentInfo' )
		);
	}

	/**
	 * Render the buttons that allow exporting data
	 */
	public function renderExportForm() {
		$exportHTMLUrl = add_query_arg(
			array(
				'lgpd_action' => 'export',
				'lgpd_format' => 'html',
				'lgpd_nonce'  => wp_create_nonce( 'lgpd/dashboard/privacy-tools/action/export' ),
			)
		);

		$exportJSONUrl = add_query_arg(
			array(
				'lgpd_action' => 'export',
				'lgpd_format' => 'json',
				'lgpd_nonce'  => wp_create_nonce( 'lgpd/dashboard/privacy-tools/action/export' ),
			)
		);

		echo lgpd( 'view' )->render(
			'modules/wordpress-user/dashboard/form-export',
			compact( 'exportHTMLUrl', 'exportJSONUrl' )
		);
	}

	/**
	 * Render the delete data button
	 */
	public function renderDeleteForm() {
		$showDelete = ! current_user_can( 'manage_options' );
		$url        = add_query_arg(
			array(
				'lgpd_action' => 'forget',
				'lgpd_nonce'  => wp_create_nonce( 'lgpd/dashboard/privacy-tools/action/forget' ),
			)
		);

		echo lgpd( 'view' )->render(
			'modules/wordpress-user/dashboard/data-page/form-delete',
			compact( 'url', 'showDelete' )
		);
	}

	/**
	 * @param DataSubject $dataSubject
	 */
	public function withdrawConsent( DataSubject $dataSubject ) {
		$consent = sanitize_key( $_REQUEST['consent'] );
		$dataSubject->withdrawConsent( $consent );
		$this->redirect( array( 'lgpd_notice' => 'consent_withdrawn' ) );
	}

	/**
	 * @param DataSubject $dataSubject
	 */
	public function export( DataSubject $dataSubject ) {
		$lgpd_format = sanitize_key( $_REQUEST['lgpd_format'] );
		$data        = $dataSubject->export( $lgpd_format );

		if ( ! is_null( $data ) ) {
			// If there is data, download it
			$this->dataExporter->export( $data, $dataSubject, $lgpd_format );
		} else {
			// If there's no data, then show notification that your request has been sent.
			$this->redirect( array( 'lgpd_notice' => 'request_sent' ) );
		}
	}

	/**
	 * @param DataSubject $dataSubject
	 */
	public function forget( DataSubject $dataSubject ) {
		$status = $dataSubject->forget();

		if ( ! $status ) {
			$this->redirect( array( 'lgpd_notice' => 'request_sent' ) );
		} else {
			$this->dataSubjectAuthenticator->deleteSession();
			$this->redirect( array(), '/' );
		}
	}

	/**
	 * Redirect the visitor to an appropriate location
	 *
	 * @param array $args
	 * @param null  $baseUrl
	 */
	protected function redirect( $args = array(), $baseUrl = null ) {
		if ( ! $baseUrl ) {
			$baseUrl = lgpd( 'helpers' )->getDashboardDataPageUrl();
		}

		wp_safe_redirect( add_query_arg( $args, $baseUrl ) );
		exit;
	}
}
