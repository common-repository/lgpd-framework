<?php
namespace Data443\LGPD\Modules\NewsletterCcpa;

use Data443\LGPD\Components\Consent\ConsentManager;
use Data443\LGPD\DataSubject\DataSubjectManager;


if ( file_exists( dirname( ES_PLUGIN_FILE ) . '/includes/db/class-es-db-contacts.php' ) ) {
	include_once dirname( ES_PLUGIN_FILE ) . '/includes/db/class-es-db-contacts.php';
} else {
	include_once dirname( ES_PLUGIN_FILE ) . '/lite/includes/db/class-es-db-contacts.php';
}

class NewsletterCcpa {

	public function __construct( DataSubjectManager $dataSubjectManager, ConsentManager $consentManager ) {

		$this->dataSubjectManager = $dataSubjectManager;
		$this->consentManager     = $consentManager;

		if ( ! defined( 'ES_PLUGIN_VERSION' ) ) {
			return;
		}

		add_filter( 'lgpd/data-subject/data', array( $this, 'getNewsletterExportData' ), 20, 2 );
		add_action( 'lgpd/data-subject/delete', array( $this, 'deleteNewsletterEntries' ) );
		add_action( 'lgpd/data-subject/anonymize', array( $this, 'deleteNewsletterEntries' ) );
		add_action( 'ig_es_after_form_fields', array( $this, 'newsletter_checkbox_consent' ) );
		add_filter( 'ig_es_add_subscriber_data', array( $this, 'newsletter_lgpd_consent' ) );

	}

	public function newsletter_checkbox_consent( $data ) {
		$policyPage = lgpd( 'options' )->get( 'policy_page' );

		$policyPageUrl = get_permalink( $policyPage );

		add_filter( 'lgpd-framework-consent-policy', 'lgpdfPrivacyPolicy' );

		$lgpd_text_policy = apply_filters( 'lgpd-framework-consent-policy', 'true' );

		$data  = '<div class="es-field-wrap">
                <input type="checkbox" name="es-lgpd-agree" id="es-lgpd-agree" value="1" required="required"> ';
		$data .= sprintf(
			__( $lgpd_text_policy, 'lgpd-framework' ),
			"<a href='{$policyPageUrl}' target='_blank'>",
			'</a>'
		);
		$data .= '</div>';

		echo $data;
	}

	public function newsletter_lgpd_consent( $data ) {
		if ( $_POST['esfpx_email'] ) {
				$esfpx_email = sanitize_email( $_POST['esfpx_email'] );
				$dataSubject = $this->dataSubjectManager->getByEmail( $esfpx_email );
				$dataSubject->giveConsent( 'privacy-policy' );
		}
		 return $data;
	}

	public function getNewsletterExportData( array $data, $email ) {
		global $wpdb;

		$results = $wpdb->get_row( $wpdb->prepare( "SELECT wc.*, GROUP_CONCAT(DISTINCT ls.name ORDER BY ls.name) as list_details  FROM {$wpdb->prefix}ig_contacts as wc LEFT JOIN {$wpdb->prefix}ig_lists_contacts as wl ON wc.id = wl.contact_id LEFT JOIN {$wpdb->prefix}ig_lists as ls ON ls.id = wl.list_id WHERE email = %s", sanitize_email( $email ) ), ARRAY_A );

		if ( ! count( $results ) ) {
			return $data;
		}

		unset( $results['hash'], $results['is_rolebased'], $results['is_webmail'], $results['is_deliverable'], $results['is_sendsafely'], $results['is_verified'], $results['is_disposable'], $results['id'] );

		if ( $results['email'] ) {
			$title = __( 'Newsletter Form submissions: ', 'lgpd' );
			foreach ( $results as $i => $message ) {
				$data[ $title ][ $i ] = $message;
			}
		}

		return $data;
	}
	/*
	*   Delete user information from order by email address.
	*/
	public function deleteNewsletterEntries( $email ) {
		$contact_id = \ES_DB_Contacts::get_contact_id_by_email( $email );
		if ( $contact_id ) {
			\ES_DB_Contacts::delete_subscribers( array( $contact_id ) );
		}
	}
}