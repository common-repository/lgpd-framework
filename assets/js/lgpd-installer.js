jQuery(
	function ($) {

		/**
		 * Init select2
		 */
		$( '.js-lgpd-select2' ).select2(
			{
				width: 'style'
			}
		);

		$( '#tabs' ).tabs();

		$( ".sortable" ).sortable();

		/**
		 * https://github.com/DubFriend/jquery.repeater
		 */
		$repeater = $( '.js-lgpd-repeater' );
		if ($repeater.length) {
			$repeater.repeater(
				{
					ready: function (setIndexes) {
						$( ".sortable" ).on( 'sortupdate', setIndexes );
					}
				}
			);

			if (typeof window.lgpdConsentTypes !== undefined) {
				$repeater.setList( window.lgpdConsentTypes );
			}
		}

		/**
		 * Auto-fill DPA info
		 */
		$( '.js-lgpd-country-selector' ).on(
			'change',
			function () {
				var dpaData, $website, $email, $phone;
				var countryCode = $( this ).val();

				if ( ! window.lgpdDpaData[countryCode]) {
					return;
				}

				dpaData = window.lgpdDpaData[countryCode];

				$website = $( '#lgpd_dpa_website' );
				if ('' === $website.data( 'set' )) {
					$website.val( dpaData['website'] );
				}

				$email = $( '#lgpd_dpa_email' );
				if ('' === $email.data( 'set' )) {
					$email.val( dpaData['email'] );
				}

				$phone = $( '#lgpd_dpa_phone' );
				if ('' === $phone.data( 'set' )) {
					$phone.val( dpaData['phone'] );
				}
			}
		);
	}
);
