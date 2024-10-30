jQuery(
	function ($) {
		/**
		 * Color picker for cookie popup styles settings
		 */
		$( '.lgpd-color-picker' ).iris(
			{
				hide: true,
				palettes: true
			}
		);
		$( document ).click(
			function (e) {
				if ( ! $( e.target ).is( ".lgpd-color-picker, .iris-picker, .iris-picker-inner" )) {
					$( '.lgpd-color-picker' ).iris( 'hide' );
				}
			}
		);
		$( '.lgpd-color-picker' ).click(
			function (event) {
				$( '.lgpd-color-picker' ).iris( 'hide' );
				$( this ).iris( 'show' );
				return false;
			}
		);
		/**
		 * requried issue on Consent show repeater
		 */
		$( document ).on(
			"click",
			".show_form_consent_lgpd",
			function (e) {
				$( ".lgpd-hidden input" ).prop( "disabled", false );
				$( ".lgpd-hidden" ).removeClass( "lgpd-hidden" );
				$( ".show_form_consent_lgpd" ).hide();
			}
		);
		/**
		 * requried issue on Consent hide repeater
		 */

		$( document ).on(
			"click",
			".hide_form_consent_lgpd",
			function (e) {
				$( ".lgpd-show-hide" ).addClass( "lgpd-hidden" );
				$( ".lgpd-hidden input" ).prop( "disabled", true );
				$( ".show_form_consent_lgpd" ).show();
			}
		);
		/**
		 * Fix issue with more then one consent add.
		 */
		$( document ).ready(
			function () {
				$( ".lgpd-hidden input" ).prop( "disabled", true );
			}
		);
		// Handler to open the modal dialog
		$( document ).on(
			"click",
			".lgpd-open-modal",
			function (e) {
				$( $( this ).data( "lgpd-modal-target" ) ).dialog( "open" );
				e.preventDefault();
			}
		);

		// Initialize all modals on page
		$( ".lgpd-modal" ).each(
			function (i, e) {
				var $base = $( this );

				$base.dialog(
					{
						title: $base.data( "lgpd-title" ),
						dialogClass: "wp-dialog",
						autoOpen: false,
						draggable: false,
						width: "auto",
						modal: true,
						resizable: false,
						closeOnEscape: true,
						position: {
							my: "center",
							at: "center",
							of: window
						},
						create: function () {
							  // style fix for WordPress admin
							  $( ".ui-dialog-titlebar-close" ).addClass( "ui-button" );
						},
						open: function () {
							// Bind a click on the overlay to close the dialog
							$( ".ui-widget-overlay" ).bind(
								"click",
								function () {
									$base.dialog( "close" );
								}
							);

							// Bind a custom close button to close the dialog
							$base.find( ".lgpd-close-modal" ).bind(
								"click",
								function (e) {
									$base.dialog( "close" );
									e.preventDefault();
								}
							);

							// Fix overlay CSS issues in admin
							$( ".wp-dialog" ).css( "z-index", 9999 );
							$( ".ui-widget-overlay" ).css( "z-index", 9998 );
						},
						close: function () {
							$( ".wp-dialog" ).css( "z-index", 101 );
							$( ".ui-widget-overlay" ).css( "z-index", 100 );
						}
					}
				);
			}
		);

		/**
		 * https://github.com/DubFriend/jquery.repeater
		 */
		$( ".js-lgpd-repeater" ).each(
			function () {
				var $repeater = $( this ).repeater(
					{
						isFirstItemUndeletable: true
					}
				);
				if (window.repeaterData != undefined) {
					  // will only work if repeater data is defined.
					if (typeof window.repeaterData[$( this ).data( "name" )] !== undefined) {
						$repeater.setList( window.repeaterData[$( this ).data( "name" )] );
					}
				}
			}
		);

		/**
		 * Init select2
		 */
		$( ".js-lgpd-select2" ).select2(
			{
				width: "style"
			}
		);

		/**
		 * Auto-fill DPA info
		 */
		$( ".js-lgpd-country-selector" ).on(
			"change",
			function () {
				var dpaData, $website, $email, $phone;
				var countryCode = $( this ).val();

				if ( ! window.lgpdDpaData[countryCode]) {
					return;
				}

				dpaData = window.lgpdDpaData[countryCode];

				$website = $( "#lgpd_dpa_website" );
				if ("" === $website.data( "set" )) {
					$website.val( dpaData["website"] );
				}

				$email = $( "#lgpd_dpa_email" );
				if ("" === $email.data( "set" )) {
					$email.val( dpaData["email"] );
				}

				$phone = $( "#lgpd_dpa_phone" );
				if ("" === $phone.data( "set" )) {
					$phone.val( dpaData["phone"] );
				}
			}
		);
	}
);
