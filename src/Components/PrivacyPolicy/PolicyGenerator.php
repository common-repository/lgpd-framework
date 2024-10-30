<?php

namespace Data443\LGPD\Components\PrivacyPolicy;

class PolicyGenerator {

	public function generate() {
		return lgpd( 'view' )->render(
			'policy/policy',
			$this->getData()
		);
	}

	public function getData() {
		$location = lgpd( 'options' )->get( 'company_location' );
		$date     = date( get_option( 'date_format' ) );

		return array(
			'companyName'                => lgpd( 'options' )->get( 'company_name' ),
			'companyLocation'            => $location,
			'contactEmail'               => lgpd( 'options' )->get( 'contact_email' ) ?
				lgpd( 'options' )->get( 'contact_email' ) :
				get_option( 'admin_email' ),

			'hasRepresentative'          => lgpd( 'helpers' )->countryNeedsRepresentative( $location ),
			'representativeContactName'  => lgpd( 'options' )->get( 'representative_contact_name' ),
			'representativeContactEmail' => lgpd( 'options' )->get( 'representative_contact_email' ),
			'representativeContactPhone' => lgpd( 'options' )->get( 'representative_contact_phone' ),

			'dpaWebsite'                 => lgpd( 'options' )->get( 'dpa_website' ),
			'dpaEmail'                   => lgpd( 'options' )->get( 'dpa_email' ),
			'dpaPhone'                   => lgpd( 'options' )->get( 'dpa_phone' ),

			'hasDpo'                     => lgpd( 'options' )->get( 'has_dpo' ),
			'dpoName'                    => lgpd( 'options' )->get( 'dpo_name' ),
			'dpoEmail'                   => lgpd( 'options' )->get( 'dpo_email' ),

			'hasTerms'                   => lgpd( 'options' )->get( 'terms_page' ),

			'date'                       => $date,
		);
	}
}
