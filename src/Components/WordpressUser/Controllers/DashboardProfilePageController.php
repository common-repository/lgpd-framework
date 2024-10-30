<?php

namespace Data443\LGPD\Components\WordpressUser\Controllers;

use Data443\LGPD\DataSubject\DataExporter;
use Data443\LGPD\DataSubject\DataSubject;
use Data443\LGPD\DataSubject\DataSubjectManager;

class DashboardProfilePageController {

	public function __construct( DataSubjectManager $dataSubjectManager, DataExporter $dataExporter ) {
		$this->dataSubjectManager = $dataSubjectManager;
		$this->dataExporter       = $dataExporter;

		add_action( 'lgpd/dashboard/profile-page/content', array( $this, 'renderHeader' ), 10 );
		add_action( 'lgpd/dashboard/profile-page/content', array( $this, 'renderConsentTable' ), 20 );
		add_action( 'lgpd/dashboard/profile-page/content', array( $this, 'renderExportForm' ), 30 );
		add_action( 'lgpd/dashboard/profile-page/content', array( $this, 'renderDeleteForm' ), 40 );
		add_action( 'lgpd/dashboard/profile-page/contentuser', array( $this, 'renderHeader' ), 10 );
		add_action( 'lgpd/dashboard/profile-page/contentuser', array( $this, 'renderConsentTable' ), 20 );
		add_action( 'lgpd/dashboard/profile-page/userlogs', array( $this, 'lgpd_user_logs' ), 50 );

		add_action( 'lgpd/admin/action/export', array( $this, 'export' ) );
		add_action( 'lgpd/admin/action/forget', array( $this, 'forget' ) );
	}

	protected function isUserAnonymized( DataSubject $dataSubject ) {
		return ! $dataSubject->getEmail();
	}

	public function renderHeader( DataSubject $dataSubject ) {
		$isAnonymized = $this->isUserAnonymized( $dataSubject );

		echo lgpd( 'view' )->render(
			'modules/wordpress-user/dashboard/profile-page/header',
			compact( 'isAnonymized' )
		);
	}


	public function lgpd_user_logs( DataSubject $dataSubject ) {
		if ( $this->isUserAnonymized( $dataSubject ) ) {
			return;
		}

		$userlogData = $dataSubject->getuserlogsData();
		echo lgpd( 'view' )->render(
			'modules/wordpress-user/dashboard/profile-page/user-logs',
			compact( 'userlogData' )
		);
	}

	public function renderConsentTable( DataSubject $dataSubject ) {
		if ( $this->isUserAnonymized( $dataSubject ) ) {
			return;
		}

		$consentData = $dataSubject->getConsentData();

		echo lgpd( 'view' )->render(
			'modules/wordpress-user/dashboard/profile-page/table-consent',
			compact( 'consentData' )
		);
	}

	public function renderExportForm( DataSubject $dataSubject ) {
		if ( $this->isUserAnonymized( $dataSubject ) ) {
			return;
		}

		$exportHTMLUrl = add_query_arg(
			array(
				'lgpd_action' => 'export',
				'lgpd_format' => 'html',
				'lgpd_email'  => $dataSubject->getEmail(),
				'lgpd_nonce'  => wp_create_nonce( 'lgpd/admin/action/export' ),
			)
		);

		$exportJSONUrl = add_query_arg(
			array(
				'lgpd_action' => 'export',
				'lgpd_format' => 'json',
				'lgpd_email'  => $dataSubject->getEmail(),
				'lgpd_nonce'  => wp_create_nonce( 'lgpd/admin/action/export' ),
			)
		);

		echo lgpd( 'view' )->render(
			'modules/wordpress-user/dashboard/form-export',
			compact( 'exportHTMLUrl', 'exportJSONUrl' )
		);
	}

	public function renderDeleteForm( DataSubject $dataSubject ) {
		if ( $this->isUserAnonymized( $dataSubject ) ) {
			return;
		}

		// Hide the delete button away from site admins on their own profile page to avoid accidents
		$showDelete = ! ( current_user_can( 'manage_options' ) && wp_get_current_user()->ID === $dataSubject->getUserId() );

		$anonymizeUrl = add_query_arg(
			array(
				'lgpd_email'        => $dataSubject->getEmail(),
				'lgpd_action'       => 'forget',
				'lgpd_force_action' => 'anonymize',
				'lgpd_nonce'        => wp_create_nonce( 'lgpd/admin/action/forget' ),
			)
		);

		$deleteUrl = add_query_arg(
			array(
				'lgpd_email'        => $dataSubject->getEmail(),
				'lgpd_action'       => 'forget',
				'lgpd_force_action' => 'delete',
				'lgpd_nonce'        => wp_create_nonce( 'lgpd/admin/action/forget' ),
			)
		);

		echo lgpd( 'view' )->render(
			'modules/wordpress-user/dashboard/profile-page/form-delete',
			compact( 'anonymizeUrl', 'deleteUrl', 'showDelete' )
		);
	}

	public function export() {
		$lgpd_email  = sanitize_email( $_REQUEST['lgpd_email'] );
		$lgpd_format = sanitize_key( $_REQUEST['lgpd_format'] );
		$dataSubject = $this->dataSubjectManager->getByEmail( $lgpd_email );
		$data        = $dataSubject->export( $lgpd_format, true );
		$this->dataExporter->export( $data, $dataSubject, $lgpd_format );
	}

	public function forget() {
		$lgpd_email        = sanitize_email( $_REQUEST['lgpd_email'] );
		$lgpd_force_action = sanitize_key( $_REQUEST['lgpd_force_action'] );
		$dataSubject       = $this->dataSubjectManager->getByEmail( $lgpd_email );
		$dataSubject->forget( $lgpd_force_action );

		wp_safe_redirect( admin_url( 'users.php' ) );
	}
}
