<?php

namespace Data443\LGPD\Components\WordpressUser;

use Data443\LGPD\DataSubject\DataSubject;
use Data443\LGPD\DataSubject\DataSubjectManager;

class RegistrationForm {

	/* @var DataSubjectManager */
	protected $dataSubjectManager;

	public function __construct( DataSubjectManager $dataSubjectManager ) {
		$this->dataSubjectManager = $dataSubjectManager;
		if ( ! lgpd( 'options' )->get( 'register_checkbox' ) ) {
			if ( lgpd( 'options' )->get( 'policy_page' ) || lgpd( 'options' )->get( 'custom_policy_page' ) ) {
				add_action( 'register_form', array( $this, 'addRegisterFormCheckbox' ) );
				add_filter( 'registration_errors', array( $this, 'validate' ), PHP_INT_MAX );
			}
		}
	}

	public function addRegisterFormCheckbox() {
		$privacyPolicyUrl = ! get_permalink( lgpd( 'options' )->get( 'custom_policy_page' ) ) ? get_permalink( lgpd( 'options' )->get( 'policy_page' ) ) : get_permalink( lgpd( 'options' )->get( 'custom_policy_page' ) );
		add_filter( 'lgpd_custom_policy_link', 'lgpdfPrivacyPolicyurl' );
		$privacyPolicyUrl = apply_filters( 'lgpd_custom_policy_link', $privacyPolicyUrl );
		$termsPage = ! lgpd( 'options' )->get( 'custom_terms_page' ) ? lgpd( 'options' )->get( 'terms_page' ) : lgpd( 'options' )->get( 'custom_terms_page' );

		if ( $termsPage ) {
			$termsUrl = get_permalink( $termsPage ) ? get_permalink( $termsPage ) : $termsPage;
		} else {
			$termsUrl = false;
		}

		echo lgpd( 'view' )->render(
			'modules/wordpress-user/registration-terms-checkbox',
			compact( 'privacyPolicyUrl', 'termsUrl' )
		);
	}

	public function validate( \WP_Error $errors ) {
		if ( empty( $_POST['lgpd_terms'] ) || ! $_POST['lgpd_terms'] ) {
			$errors->add( 'lgpd_error', __( '<strong>ERROR</strong>: You must accept the terms and conditions.', 'lgpd-framework' ) );
		} else {
			$dataSubject = $this->dataSubjectManager->getByEmail( $_POST['user_email'] );
			$dataSubject->giveConsent( 'privacy-policy' );
		}

		return $errors;
	}
}
