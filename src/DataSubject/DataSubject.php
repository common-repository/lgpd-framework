<?php

namespace Data443\LGPD\DataSubject;

use Data443\LGPD\Components\Consent\ConsentManager;

/**
 * A data subject is any person whose data we are storing.
 * A data subject might or might not have a user account on this site.
 *
 * Class DataSubject
 *
 * @package Data443\LGPD\DataSubject
 */
class DataSubject {

	/* @var string */
	protected $email;

	/* @var \WP_User|null */
	protected $user = null;

	/* @var ConsentManager */
	protected $consentManager;

	/* @var array */
	protected $consents = array();

	/**
	 * DataSubject constructor.
	 *
	 * @param               $email
	 * @param \WP_User|null $user
	 */
	public function __construct( $email, \WP_User $user = null, ConsentManager $consentManager ) {
		$this->email          = $email;
		$this->user           = $user;
		$this->consentManager = $consentManager;
		$this->dataRepository = new DataRepository( $email );

		$this->consents = $this->consentManager->getAllConsents( $this->email );
	}

	/**
	 * @return string
	 */
	public function getEmail() {
		return $this->email;
	}

	/**
	 * @return bool
	 */
	public function hasUser() {
		return $this->getUser() ? true : false;
	}

	/**
	 * @return null|\WP_User
	 */
	public function getUser() {
		return $this->user;
	}

	/**
	 * @return int|null
	 */
	public function getUserId() {
		if ( $this->hasUser() ) {
			return $this->getUser()->ID;
		}

		return null;
	}

	  /**
	   * @delete logs
	   */
	public function lgpd_delete_log( $id ) {
		return $this->consentManager->lgpd_delete_log( $id );
	}

	/**
	 * Check if the data subject has consented to something specific
	 */
	public function hasConsented( $consent ) {
		return in_array( $consent, $this->consents );
	}

	/**
	 * Get all consent given by the data subject
	 */
	public function getConsents() {
		return $this->consents;
	}

	/**
	 * Get a list of all consents intersected with the data subjects consents
	 */
	public function getConsentData() {
		return $this->consentManager->getConsentData( $this->consents );
	}

	/**
	 * Get a list of user logs
	 */
	public function getuserlogsData() {
		return $this->consentManager->getuserlogsData( $this->email );
	}
	/**
	 * Get a list of all visible consents
	 */
	public function getVisibleConsentData() {
		return array_filter(
			$this->getConsentData(),
			function ( $item ) {
				return $item['visible'];
			}
		);
		return array();
	}

	/**
	 * Save given consent to data subject
	 *
	 * @param $consent
	 */
	public function giveConsent( $consent, $valid_until = null ) {
		$this->consentManager->giveConsent( $this->email, $consent, $valid_until );
	}

	/**
	 * Remove given consent from data subject
	 *
	 * @param $consent
	 */
	public function withdrawConsent( $consent ) {
		$this->consentManager->withdrawConsent( $this->email, $consent );
	}

	/**
	 * Check if there's any data stored about this data subject at all
	 */
	public function hasData() {
		return ! empty( $this->getData() );
	}

	/**
	 * Just get the data subjects data, without sending emails or anything.
	 * Applies 'lgpd/data-subject/data' filter.
	 *
	 * @return array
	 */
	public function getData() {
		return $this->dataRepository->getData( $this->getEmail() );
	}

	/**
	 * Export the data subject's data as per admin configuration.
	 * Applies 'lgpd/data-subject/data' filter.
	 *
	 * @return array|null
	 */
	public function export( $format, $force = false ) {
		return $this->dataRepository->export( $this->getEmail(), $format, $force );
	}

	/**
	 * Forget the data subject as per admin configuration.
	 * Triggers 'lgpd/data-subject/anonymize' or 'lgpd/data-subject/delete' action.
	 *
	 * @return bool
	 */
	public function forget( $forceAction = null ) {
		return $this->dataRepository->forget( $this->getEmail(), $forceAction );
	}
}
