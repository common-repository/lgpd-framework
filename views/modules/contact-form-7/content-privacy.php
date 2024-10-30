<?php
if ( ! isset( $lgpd_value ) ) :
	$lgpd_value = '';
	endif;
if ( ! isset( $lgpd_arg2 ) ) :
	$lgpd_arg2 = '';
	endif;
if ( ! isset( $lgpd_arg3 ) ) :
	$lgpd_arg3 = '';
	endif;
	add_filter( 'lgpd-framework-consent-policy', 'lgpdfPrivacyPolicy' );
	$lgpd_text_policy = apply_filters( 'lgpd-framework-consent-policy', $lgpd_value, $lgpd_arg2, $lgpd_arg3 );
?>
	
<?php
echo sprintf(
	__( $lgpd_text_policy, 'lgpd-framework' ),
	"<a href='{$privacyPolicyUrl}' target='_blank'>",
	'</a>'
);
