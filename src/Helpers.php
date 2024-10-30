<?php

namespace Data443\LGPD;

/**
 * General helper functions
 *
 * Class Helpers
 *
 * @package Data443\LGPD
 */
class Helpers {

	public function supportUrl( $url = '' ) {
		return lgpd( 'config' )->get( 'help.url' ) . $url;
	}

	/**
	 * Get an associative array of EU countries
	 *
	 * @return array
	 */
	public function getEUCountryList() {
		return array(
			'AT' => _x( 'Austria', '(Admin)', 'lgpd-framework' ),
			'BE' => _x( 'Belgium', '(Admin)', 'lgpd-framework' ),
			'BG' => _x( 'Bulgaria', '(Admin)', 'lgpd-framework' ),
			'HR' => _x( 'Croatia', '(Admin)', 'lgpd-framework' ),
			'CY' => _x( 'Cyprus', '(Admin)', 'lgpd-framework' ),
			'CZ' => _x( 'Czech Republic', '(Admin)', 'lgpd-framework' ),
			'DK' => _x( 'Denmark', '(Admin)', 'lgpd-framework' ),
			'EE' => _x( 'Estonia', '(Admin)', 'lgpd-framework' ),
			'FI' => _x( 'Finland', '(Admin)', 'lgpd-framework' ),
			'FR' => _x( 'France', '(Admin)', 'lgpd-framework' ),
			'DE' => _x( 'Germany', '(Admin)', 'lgpd-framework' ),
			'GR' => _x( 'Greece', '(Admin)', 'lgpd-framework' ),
			'HU' => _x( 'Hungary', '(Admin)', 'lgpd-framework' ),
			'IE' => _x( 'Ireland', '(Admin)', 'lgpd-framework' ),
			'IT' => _x( 'Italy', '(Admin)', 'lgpd-framework' ),
			'LV' => _x( 'Latvia', '(Admin)', 'lgpd-framework' ),
			'LT' => _x( 'Lithuania', '(Admin)', 'lgpd-framework' ),
			'LU' => _x( 'Luxembourg', '(Admin)', 'lgpd-framework' ),
			'MT' => _x( 'Malta', '(Admin)', 'lgpd-framework' ),
			'NL' => _x( 'Netherlands', '(Admin)', 'lgpd-framework' ),
			'PL' => _x( 'Poland', '(Admin)', 'lgpd-framework' ),
			'PT' => _x( 'Portugal', '(Admin)', 'lgpd-framework' ),
			'RO' => _x( 'Romania', '(Admin)', 'lgpd-framework' ),
			'SK' => _x( 'Slovakia', '(Admin)', 'lgpd-framework' ),
			'SI' => _x( 'Slovenia', '(Admin)', 'lgpd-framework' ),
			'ES' => _x( 'Spain', '(Admin)', 'lgpd-framework' ),
			'SE' => _x( 'Sweden', '(Admin)', 'lgpd-framework' ),
			'UK' => _x( 'United Kingdom', '(Admin)', 'lgpd-framework' ),
			// All country list
			'AF' => _x( 'Afghanistan ', '(Admin)', 'lgpd-framework' ),
			'AX' => _x( 'Åland Islands', '(Admin)', 'lgpd-framework' ),
			'AL' => _x( 'Albania', '(Admin)', 'lgpd-framework' ),
			'DZ' => _x( 'Algeria', '(Admin)', 'lgpd-framework' ),
			'AS' => _x( 'American Samoa  ', '(Admin)', 'lgpd-framework' ),
			'AD' => _x( 'Andorra', '(Admin)', 'lgpd-framework' ),
			'AO' => _x( 'Angola', '(Admin)', 'lgpd-framework' ),
			'AI' => _x( 'Anguilla', '(Admin)', 'lgpd-framework' ),
			'AQ' => _x( 'Antarctica', '(Admin)', 'lgpd-framework' ),
			'AG' => _x( 'Antigua and Barbuda', '(Admin)', 'lgpd-framework' ),
			'AR' => _x( 'Argentina', '(Admin)', 'lgpd-framework' ),
			'AM' => _x( 'Armenia', '(Admin)', 'lgpd-framework' ),
			'AW' => _x( 'Aruba', '(Admin)', 'lgpd-framework' ),
			'AU' => _x( 'Australia', '(Admin)', 'lgpd-framework' ),
			'AZ' => _x( 'Azerbaijan', '(Admin)', 'lgpd-framework' ),
			'BH' => _x( 'Bahrain', '(Admin)', 'lgpd-framework' ),
			'BS' => _x( 'Bahamas', '(Admin)', 'lgpd-framework' ),
			'BD' => _x( 'Bangladesh', '(Admin)', 'lgpd-framework' ),
			'BB' => _x( 'Barbados', '(Admin)', 'lgpd-framework' ),
			'BY' => _x( 'Belarus', '(Admin)', 'lgpd-framework' ),
			'BZ' => _x( 'Belize', '(Admin)', 'lgpd-framework' ),
			'BJ' => _x( 'Benin', '(Admin)', 'lgpd-framework' ),
			'BM' => _x( 'Bermuda', '(Admin)', 'lgpd-framework' ),
			'BT' => _x( 'Bhutan', '(Admin)', 'lgpd-framework' ),
			'BO' => _x( 'Bolivia, Plurinational State of', '(Admin)', 'lgpd-framework' ),
			'BQ' => _x( 'Bonaire, Sint Eustatius and Saba', '(Admin)', 'lgpd-framework' ),
			'BA' => _x( 'Bosnia and Herzegovina', '(Admin)', 'lgpd-framework' ),
			'BW' => _x( 'Botswana', '(Admin)', 'lgpd-framework' ),
			'BV' => _x( 'Bouvet Island', '(Admin)', 'lgpd-framework' ),
			'BR' => _x( 'Brazil', '(Admin)', 'lgpd-framework' ),
			'IO' => _x( 'British Indian Ocean Territory', '(Admin)', 'lgpd-framework' ),
			'BN' => _x( 'Brunei Darussalam', '(Admin)', 'lgpd-framework' ),
			'BF' => _x( 'Burkina Faso', '(Admin)', 'lgpd-framework' ),
			'BI' => _x( 'Burundi', '(Admin)', 'lgpd-framework' ),
			'KH' => _x( 'Cambodia', '(Admin)', 'lgpd-framework' ),
			'CM' => _x( 'Cameroon', '(Admin)', 'lgpd-framework' ),
			'CA' => _x( 'Canada', '(Admin)', 'lgpd-framework' ),
			'CV' => _x( 'Cape Verde', '(Admin)', 'lgpd-framework' ),
			'KY' => _x( 'Cayman Islands', '(Admin)', 'lgpd-framework' ),
			'CF' => _x( 'Central African Republic', '(Admin)', 'lgpd-framework' ),
			'TD' => _x( 'Chad', '(Admin)', 'lgpd-framework' ),
			'CL' => _x( 'Chile', '(Admin)', 'lgpd-framework' ),
			'CN' => _x( 'China', '(Admin)', 'lgpd-framework' ),
			'CX' => _x( 'Christmas Island', '(Admin)', 'lgpd-framework' ),
			'CC' => _x( 'Cocos (Keeling) Islands', '(Admin)', 'lgpd-framework' ),
			'CO' => _x( 'Colombia', '(Admin)', 'lgpd-framework' ),
			'KM' => _x( 'Comoros', '(Admin)', 'lgpd-framework' ),
			'CG' => _x( 'Congo', '(Admin)', 'lgpd-framework' ),
			'CD' => _x( 'Congo, the Democratic Republic of the', '(Admin)', 'lgpd-framework' ),
			'CK' => _x( 'Cook Islands', '(Admin)', 'lgpd-framework' ),
			'CR' => _x( 'Costa Rica', '(Admin)', 'lgpd-framework' ),
			'CI' => _x( 'Côte dIvoire', '(Admin)', 'lgpd-framework' ),
			'CU' => _x( 'Cuba', '(Admin)', 'lgpd-framework' ),
			'CW' => _x( 'Curaçao', '(Admin)', 'lgpd-framework' ),
			'DJ' => _x( 'Djibouti', '(Admin)', 'lgpd-framework' ),
			'DM' => _x( 'Dominica', '(Admin)', 'lgpd-framework' ),
			'DO' => _x( 'Dominican Republic', '(Admin)', 'lgpd-framework' ),
			'EC' => _x( 'Ecuador', '(Admin)', 'lgpd-framework' ),
			'EG' => _x( 'Egypt', '(Admin)', 'lgpd-framework' ),
			'SV' => _x( 'El Salvador', '(Admin)', 'lgpd-framework' ),
			'GQ' => _x( 'Equatorial Guinea', '(Admin)', 'lgpd-framework' ),
			'ER' => _x( 'Eritrea', '(Admin)', 'lgpd-framework' ),
			'ET' => _x( 'Ethiopia', '(Admin)', 'lgpd-framework' ),
			'FK' => _x( 'Falkland Islands (Malvinas)', '(Admin)', 'lgpd-framework' ),
			'FO' => _x( 'Faroe Islands', '(Admin)', 'lgpd-framework' ),
			'FJ' => _x( 'Fiji', '(Admin)', 'lgpd-framework' ),
			'GF' => _x( 'French Guiana', '(Admin)', 'lgpd-framework' ),
			'PF' => _x( 'French Polynesia', '(Admin)', 'lgpd-framework' ),
			'TF' => _x( 'French Southern Territories', '(Admin)', 'lgpd-framework' ),
			'GA' => _x( 'Gabon', '(Admin)', 'lgpd-framework' ),
			'GM' => _x( 'Gambia', '(Admin)', 'lgpd-framework' ),
			'GE' => _x( 'Georgia', '(Admin)', 'lgpd-framework' ),
			'GE' => _x( 'Georgia ', '(Admin)', 'lgpd-framework' ),
			'GH' => _x( 'Ghana', '(Admin)', 'lgpd-framework' ),
			'GI' => _x( 'Gibraltar', '(Admin)', 'lgpd-framework' ),
			'GL' => _x( 'Greenland', '(Admin)', 'lgpd-framework' ),
			'GD' => _x( 'Grenada ', '(Admin)', 'lgpd-framework' ),
			'GP' => _x( 'Guadeloupe  ', '(Admin)', 'lgpd-framework' ),
			'GU' => _x( 'Guam', '(Admin)', 'lgpd-framework' ),
			'GT' => _x( 'Guatemala', '(Admin)', 'lgpd-framework' ),
			'GG' => _x( 'Guernsey', '(Admin)', 'lgpd-framework' ),
			'GN' => _x( 'Guinea  ', '(Admin)', 'lgpd-framework' ),
			'GW' => _x( 'Guinea-Bissau   ', '(Admin)', 'lgpd-framework' ),
			'GY' => _x( 'Guyana  ', '(Admin)', 'lgpd-framework' ),
			'HT' => _x( 'Haiti   ', '(Admin)', 'lgpd-framework' ),
			'HM' => _x( 'Heard Island and McDonald Islands   ', '(Admin)', 'lgpd-framework' ),
			'VA' => _x( 'Holy See (Vatican City State)   ', '(Admin)', 'lgpd-framework' ),
			'HN' => _x( 'Honduras    ', '(Admin)', 'lgpd-framework' ),
			'HK' => _x( 'Hong Kong   ', '(Admin)', 'lgpd-framework' ),
			'IN' => _x( 'India   ', '(Admin)', 'lgpd-framework' ),
			'ID' => _x( 'Indonesia   ', '(Admin)', 'lgpd-framework' ),
			'IR' => _x( 'Iran, Islamic Republic of   ', '(Admin)', 'lgpd-framework' ),
			'IQ' => _x( 'Iraq    ', '(Admin)', 'lgpd-framework' ),
			'IM' => _x( 'Isle of Man ', '(Admin)', 'lgpd-framework' ),
			'IL' => _x( 'Israel  ', '(Admin)', 'lgpd-framework' ),
			'JM' => _x( 'Jamaica ', '(Admin)', 'lgpd-framework' ),
			'JP' => _x( 'Japan   ', '(Admin)', 'lgpd-framework' ),
			'JE' => _x( 'Jersey  ', '(Admin)', 'lgpd-framework' ),
			'JO' => _x( 'Jordan  ', '(Admin)', 'lgpd-framework' ),
			'KZ' => _x( 'Kazakhstan  ', '(Admin)', 'lgpd-framework' ),
			'KE' => _x( 'Kenya   ', '(Admin)', 'lgpd-framework' ),
			'KI' => _x( 'Kiribati    ', '(Admin)', 'lgpd-framework' ),
			'KP' => _x( 'Korea, Democratic Peoples Republic of   ', '(Admin)', 'lgpd-framework' ),
			'KR' => _x( 'Korea, Republic of  ', '(Admin)', 'lgpd-framework' ),
			'KW' => _x( 'Kuwait  ', '(Admin)', 'lgpd-framework' ),
			'KG' => _x( 'Kyrgyzstan  ', '(Admin)', 'lgpd-framework' ),
			'LA' => _x( 'Lao Peoples Democratic Republic ', '(Admin)', 'lgpd-framework' ),
			'LB' => _x( 'Lebanon ', '(Admin)', 'lgpd-framework' ),
			'LS' => _x( 'Lesotho ', '(Admin)', 'lgpd-framework' ),
			'LR' => _x( 'Liberia ', '(Admin)', 'lgpd-framework' ),
			'LY' => _x( 'Libya   ', '(Admin)', 'lgpd-framework' ),
			'MO' => _x( 'Macao   ', '(Admin)', 'lgpd-framework' ),
			'MK' => _x( 'Macedonia, the Former Yugoslav Republic of  ', '(Admin)', 'lgpd-framework' ),
			'MG' => _x( 'Madagascar  ', '(Admin)', 'lgpd-framework' ),
			'MW' => _x( 'Malawi  ', '(Admin)', 'lgpd-framework' ),
			'MY' => _x( 'Malaysia    ', '(Admin)', 'lgpd-framework' ),
			'MV' => _x( 'Maldives    ', '(Admin)', 'lgpd-framework' ),
			'ML' => _x( 'Mali    ', '(Admin)', 'lgpd-framework' ),
			'MH' => _x( 'Marshall Islands    ', '(Admin)', 'lgpd-framework' ),
			'MQ' => _x( 'Martinique  ', '(Admin)', 'lgpd-framework' ),
			'MR' => _x( 'Mauritania  ', '(Admin)', 'lgpd-framework' ),
			'MU' => _x( 'Mauritius   ', '(Admin)', 'lgpd-framework' ),
			'YT' => _x( 'Mayotte ', '(Admin)', 'lgpd-framework' ),
			'MX' => _x( 'Mexico  ', '(Admin)', 'lgpd-framework' ),
			'FM' => _x( 'Micronesia, Federated States of ', '(Admin)', 'lgpd-framework' ),
			'MD' => _x( 'Moldova, Republic of    ', '(Admin)', 'lgpd-framework' ),
			'MC' => _x( 'Monaco  ', '(Admin)', 'lgpd-framework' ),
			'MN' => _x( 'Mongolia    ', '(Admin)', 'lgpd-framework' ),
			'ME' => _x( 'Montenegro  ', '(Admin)', 'lgpd-framework' ),
			'MS' => _x( 'Montserrat  ', '(Admin)', 'lgpd-framework' ),
			'MA' => _x( 'Morocco ', '(Admin)', 'lgpd-framework' ),
			'MZ' => _x( 'Mozambique  ', '(Admin)', 'lgpd-framework' ),
			'MM' => _x( 'Myanmar ', '(Admin)', 'lgpd-framework' ),
			'NA' => _x( 'Namibia ', '(Admin)', 'lgpd-framework' ),
			'NR' => _x( 'Nauru   ', '(Admin)', 'lgpd-framework' ),
			'NP' => _x( 'Nepal   ', '(Admin)', 'lgpd-framework' ),
			'NC' => _x( 'New Caledonia   ', '(Admin)', 'lgpd-framework' ),
			'NZ' => _x( 'New Zealand ', '(Admin)', 'lgpd-framework' ),
			'NI' => _x( 'Nicaragua   ', '(Admin)', 'lgpd-framework' ),
			'NE' => _x( 'Niger   ', '(Admin)', 'lgpd-framework' ),
			'NG' => _x( 'Nigeria ', '(Admin)', 'lgpd-framework' ),
			'NU' => _x( 'Niue    ', '(Admin)', 'lgpd-framework' ),
			'NF' => _x( 'Norfolk Island  ', '(Admin)', 'lgpd-framework' ),
			'MP' => _x( 'Northern Mariana Islands    ', '(Admin)', 'lgpd-framework' ),
			'OM' => _x( 'Oman    ', '(Admin)', 'lgpd-framework' ),
			'PK' => _x( 'Pakistan    ', '(Admin)', 'lgpd-framework' ),
			'PW' => _x( 'Palau   ', '(Admin)', 'lgpd-framework' ),
			'PS' => _x( 'Palestine, State of ', '(Admin)', 'lgpd-framework' ),
			'PA' => _x( 'Panama  ', '(Admin)', 'lgpd-framework' ),
			'PG' => _x( 'Papua New Guinea    ', '(Admin)', 'lgpd-framework' ),
			'PY' => _x( 'Paraguay    ', '(Admin)', 'lgpd-framework' ),
			'PE' => _x( 'Peru    ', '(Admin)', 'lgpd-framework' ),
			'PH' => _x( 'Philippines ', '(Admin)', 'lgpd-framework' ),
			'PN' => _x( 'Pitcairn    ', '(Admin)', 'lgpd-framework' ),
			'PR' => _x( 'Puerto Rico ', '(Admin)', 'lgpd-framework' ),
			'QA' => _x( 'Qatar   ', '(Admin)', 'lgpd-framework' ),
			'RE' => _x( 'Réunion ', '(Admin)', 'lgpd-framework' ),
			'RU' => _x( 'Russian Federation  ', '(Admin)', 'lgpd-framework' ),
			'RW' => _x( 'Rwanda  ', '(Admin)', 'lgpd-framework' ),
			'BL' => _x( 'Saint Barthélemy    ', '(Admin)', 'lgpd-framework' ),
			'SH' => _x( 'Saint Helena, Ascension and Tristan da Cunha    ', '(Admin)', 'lgpd-framework' ),
			'KN' => _x( 'Saint Kitts and Nevis   ', '(Admin)', 'lgpd-framework' ),
			'LC' => _x( 'Saint Lucia ', '(Admin)', 'lgpd-framework' ),
			'MF' => _x( 'Saint Martin (French part)  ', '(Admin)', 'lgpd-framework' ),
			'PM' => _x( 'Saint Pierre and Miquelon   ', '(Admin)', 'lgpd-framework' ),
			'VC' => _x( 'Saint Vincent and the Grenadines    ', '(Admin)', 'lgpd-framework' ),
			'WS' => _x( 'Samoa   ', '(Admin)', 'lgpd-framework' ),
			'SM' => _x( 'San Marino  ', '(Admin)', 'lgpd-framework' ),
			'ST' => _x( 'Sao Tome and Principe   ', '(Admin)', 'lgpd-framework' ),
			'SA' => _x( 'Saudi Arabia    ', '(Admin)', 'lgpd-framework' ),
			'SN' => _x( 'Senegal ', '(Admin)', 'lgpd-framework' ),
			'RS' => _x( 'Serbia  ', '(Admin)', 'lgpd-framework' ),
			'SC' => _x( 'Seychelles  ', '(Admin)', 'lgpd-framework' ),
			'SL' => _x( 'Sierra Leone    ', '(Admin)', 'lgpd-framework' ),
			'SG' => _x( 'Singapore   ', '(Admin)', 'lgpd-framework' ),
			'SX' => _x( 'Sint Maarten (Dutch part)   ', '(Admin)', 'lgpd-framework' ),
			'SB' => _x( 'Solomon Islands ', '(Admin)', 'lgpd-framework' ),
			'SO' => _x( 'Somalia ', '(Admin)', 'lgpd-framework' ),
			'ZA' => _x( 'South Africa    ', '(Admin)', 'lgpd-framework' ),
			'GS' => _x( 'South Georgia and the South Sandwich Islands    ', '(Admin)', 'lgpd-framework' ),
			'SS' => _x( 'South Sudan ', '(Admin)', 'lgpd-framework' ),
			'LK' => _x( 'Sri Lanka   ', '(Admin)', 'lgpd-framework' ),
			'SD' => _x( 'Sudan   ', '(Admin)', 'lgpd-framework' ),
			'SR' => _x( 'Suriname    ', '(Admin)', 'lgpd-framework' ),
			'SJ' => _x( 'Svalbard and Jan Mayen  ', '(Admin)', 'lgpd-framework' ),
			'SZ' => _x( 'Swaziland   ', '(Admin)', 'lgpd-framework' ),
			'SY' => _x( 'Syrian Arab Republic    ', '(Admin)', 'lgpd-framework' ),
			'TW' => _x( 'Taiwan   ', '(Admin)', 'lgpd-framework' ),
			'TJ' => _x( 'Tajikistan  ', '(Admin)', 'lgpd-framework' ),
			'TZ' => _x( 'Tanzania, United Republic of    ', '(Admin)', 'lgpd-framework' ),
			'TH' => _x( 'Thailand    ', '(Admin)', 'lgpd-framework' ),
			'TL' => _x( 'Timor-Leste ', '(Admin)', 'lgpd-framework' ),
			'TG' => _x( 'Togo    ', '(Admin)', 'lgpd-framework' ),
			'TK' => _x( 'Tokelau ', '(Admin)', 'lgpd-framework' ),
			'TO' => _x( 'Tonga   ', '(Admin)', 'lgpd-framework' ),
			'TT' => _x( 'Trinidad and Tobago ', '(Admin)', 'lgpd-framework' ),
			'TN' => _x( 'Tunisia ', '(Admin)', 'lgpd-framework' ),
			'TR' => _x( 'Turkey  ', '(Admin)', 'lgpd-framework' ),
			'TM' => _x( 'Turkmenistan    ', '(Admin)', 'lgpd-framework' ),
			'TC' => _x( 'Turks and Caicos Islands    ', '(Admin)', 'lgpd-framework' ),
			'TV' => _x( 'Tuvalu  ', '(Admin)', 'lgpd-framework' ),
			'UG' => _x( 'Uganda  ', '(Admin)', 'lgpd-framework' ),
			'UA' => _x( 'Ukraine ', '(Admin)', 'lgpd-framework' ),
			'AE' => _x( 'United Arab Emirates    ', '(Admin)', 'lgpd-framework' ),
			'UM' => _x( 'United States Minor Outlying Islands    ', '(Admin)', 'lgpd-framework' ),
			'UY' => _x( 'Uruguay ', '(Admin)', 'lgpd-framework' ),
			'UZ' => _x( 'Uzbekistan  ', '(Admin)', 'lgpd-framework' ),
			'VU' => _x( 'Vanuatu ', '(Admin)', 'lgpd-framework' ),
			'VE' => _x( 'Venezuela, Bolivarian Republic of   ', '(Admin)', 'lgpd-framework' ),
			'VN' => _x( 'Viet Nam    ', '(Admin)', 'lgpd-framework' ),
			'VG' => _x( 'Virgin Islands, British ', '(Admin)', 'lgpd-framework' ),
			'VI' => _x( 'Virgin Islands, U.S.    ', '(Admin)', 'lgpd-framework' ),
			'WF' => _x( 'Wallis and Futuna   ', '(Admin)', 'lgpd-framework' ),
			'EH' => _x( 'Western Sahara  ', '(Admin)', 'lgpd-framework' ),
			'YE' => _x( 'Yemen   ', '(Admin)', 'lgpd-framework' ),
			'ZM' => _x( 'Zambia  ', '(Admin)', 'lgpd-framework' ),
			'ZW' => _x( 'Zimbabwe    ', '(Admin)', 'lgpd-framework' ),
		);
	}

	/**
	 * Get a list of <option> values for the country selector
	 *
	 * @param null $current
	 *
	 * @return mixed
	 */
	public function getCountrySelectOptions( $current = null ) {
		$eu      = $this->getEUCountryList();
		$outside = array(
			'IS' => _x( 'Iceland', '(Admin)', 'lgpd-framework' ),
			'NO' => _x( 'Norway', '(Admin)', 'lgpd-framework' ),
			'LI' => _x( 'Liechtenstein', '(Admin)', 'lgpd-framework' ),
			'CH' => _x( 'Switzerland', '(Admin)', 'lgpd-framework' ),
			'US' => _x( 'United States', '(Admin)', 'lgpd-framework' ),
			// "other" => _x('Rest of the world', '(Admin)', 'lgpd-framework'),
		);

		return lgpd( 'view' )->render( 'global/country-options', compact( 'eu', 'outside', 'current' ) );
	}

	/**
	 * Check if a controller from the given country needs a representative in the EU
	 *
	 * @param $code
	 * @return bool
	 */
	public function countryNeedsRepresentative( $code ) {
		return in_array( $code, array( 'US', 'other' ) );
	}

	/**
	 * Get the data protection authority information for a given country
	 *
	 * @param null $countryCode
	 * @return array
	 */
	public function getDataProtectionAuthorityInfo( $countryCode = null ) {
		if ( ! $countryCode ) {
			$countryCode = lgpd( 'options' )->get( 'company_location' );
		}

		$dpaData = require lgpd( 'config' )->get( 'plugin.path' ) . 'assets/data-protection-authorities.php';

		if ( isset( $dpaData[ $countryCode ] ) ) {
			return $dpaData[ $countryCode ];
		}

		return array();
	}

	/**
	 * Get the info regarding all DPAs
	 */
	public function getDataProtectionAuthorities() {
		return require lgpd( 'config' )->get( 'plugin.path' ) . 'assets/data-protection-authorities.php';
	}

	public function getAdminUrl( $suffix = '' ) {
		return admin_url( 'tools.php?page=lgpd_privacy' . $suffix );
	}

	public function getDashboardDataPageUrl( $suffix = '' ) {
		return admin_url( 'users.php?page=lgpd-profile' . $suffix );
	}

	public function getPrivacyToolsPageUrl() {
		if(lgpd('options')->get('custom_tools_page')){
			$privacyToolsUrl = lgpd('options')->get('custom_tools_page');
			return $privacyToolsUrl;			
		}else{
			$toolsPageId = lgpd('options')->get('tools_page');
        	return $toolsPageId ? get_permalink($toolsPageId) : '';
		}
	}

	public function getPrivacyPolicyPageUrl() {
		$policyPageId  = lgpd( 'options' )->get( 'policy_page' );
		$policyPageurl = get_permalink( $policyPageId );
		add_filter( 'lgpd_custom_policy_link', 'lgpdfPrivacyPolicyurl' );
		$policyPageurl = apply_filters( 'lgpd_custom_policy_link', $policyPageurl );
		return $policyPageurl ? $policyPageurl : '';
	}

	public function error() {
		wp_die(
			__( 'An error has occurred. Please contact the site administrator.', 'lgpd-framework' )
		);
	}

	public function docs( $url = '' ) {
		return 'https://www.data443.com/' . $url;
	}

	public function developerDocs()
    {
        return 'https://data443.atlassian.net/servicedesk/customer/portal/2/article/2082439181';
    }

	public function knowledgeBase()
    {
        return 'https://data443.atlassian.net/servicedesk/customer/portal/2/article/1914831218';
    }

	public function controllingPersonalData()
    {
        return 'https://data443.atlassian.net/servicedesk/customer/portal/2/article/2082439201';
    }

	public function legalGrounds()
    {
        return 'https://data443.atlassian.net/servicedesk/customer/portal/2/article/2079293576';
    }

	public function privacyTools()
	{
		return 'https://data443.atlassian.net/servicedesk/customer/portal/2/article/2082439201';
	}

	/**
	 * Wrapper around wp_mail() to filter the headers
	 * Example code for changing the sender email:
	 *
	 *  add_filter('lgpd/mail/headers', function($headers) {
	 *       $headers[] = 'From: Firstname Lastname <test@example.com>';
	 *      return $headers;
	 *  });
	 */
	public function mail( $to, $subject, $message, $headers = '', $attachments = array() ) {
		$lgpd_name_from  = get_option( 'lgpd_name_from' );
		$lgpd_email_from = get_option( 'lgpd_email_from' );
		if ( $lgpd_name_from == '' ) {
			$lgpd_name_from = 'Data443 LGPD';
		}
		if ( $lgpd_email_from == '' ) {
			$lgpd_email_from = get_option( 'admin_email' );
		}
		$headers   = apply_filters( 'lgpd/mail/headers', $headers );
		$headers[] = 'From: ' . $lgpd_name_from . ' <' . $lgpd_email_from . '>';

		wp_mail( $to, $subject, $message, $headers, $attachments );
	}
}
