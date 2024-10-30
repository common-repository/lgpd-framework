<?php

namespace Data443\LGPD\DataSubject;

use Data443\LGPD\Admin\AdminTab;

/**
 * Class AdminTabDataSubject
 *
 * @package Data443\LGPD\DataSubject
 */
class AdminTabDataSubject extends AdminTab {

	/* @var string */
	protected $slug = 'data-subject';

	/* @var DataSubjectManager */
	protected $dataSubjectManager;

	/**
	 * AdminTabDataSubject constructor.
	 *
	 * @param DataSubjectManager $dataSubjectManager
	 */
	public function __construct( DataSubjectManager $dataSubjectManager ) {
		$this->title              = _x( 'Data Subjects', '(Admin)', 'lgpd-framework' );
		$this->dataSubjectManager = $dataSubjectManager;

		// Workaround to allow this page to be submitted
		$this->registerSetting( 'lgpd_email' );

		// Register handler for this action
		add_action( 'lgpd/admin/action/search', array( $this, 'searchRedirect' ) );
	}

	public function init() {
		$this->registerSettingSection(
			'lgpd-section-data-subjects',
			_x( 'Data Subjects', '(Admin)', 'lgpd-framework' ),
			array( $this, 'renderTab' )
		);
	}

	public function renderTab() {
		if ( isset( $_GET['search'] ) && $_GET['search'] ) {
			$searched_email = sanitize_email( $_GET['search'] );
			$results = $this->getRenderedResults( $searched_email, $this->dataSubjectManager->getByEmail( $searched_email ) );
		} else {
			$results = '';
		}

		$nonce = wp_create_nonce( 'lgpd/admin/action/search' );
		// FRAM-133 - define variables before use
		$exportUrl = '';
		$deleteUrl = '';
		echo lgpd( 'view' )->render(
			'admin/data-subjects/search-form',
			compact( 'nonce', 'results', 'exportUrl', 'deleteUrl' )
		);
	}

	public function getRenderedResults( $email, DataSubject $dataSubject ) {
		// FRAM-133 - define variables before use
		$userName = false;
		$adminCap = false;

		$hasData = $dataSubject->hasData();
		$links   = array();
		if ( isset( $_GET['search'] ) ) {
			$searched_email = sanitize_email( $_GET['search'] );
		}
		if ( $hasData ) {
			if ( $dataSubject->getUserId() ) {
				$userName         = get_userdata( $dataSubject->getUserId() )->user_login;
				$links['profile'] = get_edit_user_link( $dataSubject->getUserId() );
				$adminCap         = user_can( $dataSubject->getUserId(), 'manage_options' );
			}

			/**
			 * TODO: these actions are currently triggered in DashboardProfilePageController
			 * Should replace this with a generic AdminController!
			 * Also consider namespacing lgpd_action in this case, i.e. profile/delete vs data-subject-tab/delete
			 */
			$links['view'] = add_query_arg(
				array(
					'lgpd_action' => 'export',
					'lgpd_format' => 'html',
					'lgpd_email'  => $searched_email,
					'lgpd_nonce'  => wp_create_nonce( 'lgpd/admin/action/export' ),
				)
			);

			$links['export'] = add_query_arg(
				array(
					'lgpd_action' => 'export',
					'lgpd_format' => 'json',
					'lgpd_email'  => $searched_email,
					'lgpd_nonce'  => wp_create_nonce( 'lgpd/admin/action/export' ),
				)
			);

			$links['anonymize'] = add_query_arg(
				array(
					'lgpd_email'        => $searched_email,
					'lgpd_action'       => 'forget',
					'lgpd_force_action' => 'anonymize',
					'lgpd_nonce'        => wp_create_nonce( 'lgpd/admin/action/forget' ),
				)
			);

			$links['delete'] = add_query_arg(
				array(
					'lgpd_email'        => $searched_email,
					'lgpd_action'       => 'forget',
					'lgpd_force_action' => 'delete',
					'lgpd_nonce'        => wp_create_nonce( 'lgpd/admin/action/forget' ),
				)
			);
		}

		$consentData = $dataSubject->getConsentData();
		return lgpd( 'view' )->render( 'admin/data-subjects/search-results', compact( 'email', 'hasData', 'links', 'userName', 'adminCap', 'consentData' ) );
	}

	public function renderSubmitButton() {
		// Intentionally left blank
	}

	public function searchRedirect() {
		if ( isset( $_POST['lgpd_email'] ) && $_POST['lgpd_email'] ) {
			$lgpd_email = sanitize_email( $_POST['lgpd_email'] );
			wp_safe_redirect( lgpd( 'helpers' )->getAdminUrl( '&lgpd-tab=data-subject&search=' . $lgpd_email ) );
			exit;
		}
	}

	public function lgpd_get_formatted_billing_name_and_address( $user_id ) {
		$address  = get_user_meta( $user_id, 'billing_address_1', true ) . ' ';
		$address .= get_user_meta( $user_id, 'billing_address_2', true ) . ' ';
		$address .= get_user_meta( $user_id, 'billing_city', true ) . ' ';
		$address .= get_user_meta( $user_id, 'billing_state', true ) . ' ';
		$address .= get_user_meta( $user_id, 'billing_postcode', true ) . ' ';
		$address .= get_user_meta( $user_id, 'billing_country', true ) . ' ';
		return esc_html_x( $address, '(Admin)', 'lgpd-framework' );
	}
}