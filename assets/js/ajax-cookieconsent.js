window.addEventListener(
	"load",
	function () {
		if (lgpd_policy_page.lgpd_url) {
			if (lgpd_policy_page.lgpd_popup) {
				var layoutcheck = 'lgpd-cool-layout';
			} else {
				var layoutcheck = 'lgpd-cool-layout-wlink';
			}
		} else {
			var layoutcheck = 'lgpd-cool-layout-wlink';
		}
		window.cookieconsent.initialise(
			{
				layout: layoutcheck,
				layouts: {
					'lgpd-cool-layout': '{{header}}{{message}}{{link}}{{compliance}}<span aria-label="dismiss cookie message" role="button" tabindex="0" class="lgpd-close"><span class="emoji lgpd-close-popup  cc-close">&#10005;</span></span>',
					'lgpd-cool-layout-wlink': '{{header}}{{message}}{{compliance}}<span aria-label="dismiss cookie message" role="button" tabindex="0" class="lgpd-close"><span class="emoji lgpd-close-popup cc-close">&#10005;</span></span>',
				},
				"palette": {
					"popup": {
						"background": lgpd_policy_page.lgpd_popup_background,
						"text": lgpd_policy_page.lgpd_popup_text
					},
					"button": {
						"background": lgpd_policy_page.lgpd_button_background,
						"text": lgpd_policy_page.lgpd_button_text,
						"border": lgpd_policy_page.lgpd_button_border
					}
				},
				"position": lgpd_policy_page.lgpd_popup_position,
				"static": lgpd_policy_page.lgpd_popup_static,
				"theme": lgpd_policy_page.lgpd_popup_theme,
				"type": lgpd_policy_page.lgpd_popup_type,
				"content": {
					"header": lgpd_policy_page.lgpd_header, // "Cookies used on the website!"
					"message": lgpd_policy_page.lgpd_message,
					"href": lgpd_policy_page.lgpd_url,
					"link": lgpd_policy_page.lgpd_link,
					"deny": lgpd_policy_page.lgpd_dismiss,
					"allow": lgpd_policy_page.lgpd_allow,
					"policy": lgpd_policy_page.policy,
					"target": lgpd_policy_page.lgpd_link_target,
				},
				onStatusChange: function (status, chosenBefore) {
					if (chosenBefore == 'false' || status == "allow") {
						jQuery( document ).ready(
							function ($) {
								$.getJSON(
									'https://api.ipify.org?format=json',
									function (data) {
										$.ajax(
											{
												url: lgpd_policy_page.ajaxurl,
												type: 'POST',
												data: {
													action: 'lgpd_add_consent_accept_cookies',
													userip: data.ip,
													nonce: popup_lgpd.nonce
												},
												success: function (data) {
													$( '.cc-close' ).click();
													if (lgpd_policy_page.lgpd_hide) {
														$( ".cc-revoke" ).hide();
													}
												}
											}
										);
									}
								);
							}
						);
					} else if (chosenBefore == 'false' || status == "deny") {
						jQuery( document ).ready(
							function ($) {
								$.getJSON(
									'https://api.ipify.org?format=json',
									function (data) {
										$.ajax(
											{
												url: lgpd_policy_page.ajaxurl,
												type: 'POST',
												data: {
													action: 'lgpd_add_consent_deny_cookies',
													userip: data.ip,
													nonce: popup_lgpd.nonce
												},
												success: function (data) {
													$( '.cc-close' ).click();
													if (lgpd_policy_page.lgpd_hide) {
														$( ".cc-revoke" ).hide();
													}
												}
											}
										);
									}
								);
							}
						);
					}
				}
			}
		)
	}
);
