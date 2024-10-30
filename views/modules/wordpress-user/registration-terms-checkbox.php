<p class="lgpd-terms-container" style="margin-bottom: 10px">
<?php
wp_register_style( 'lgpd-consent-until-css', lgpd( 'config' )->get( 'plugin.url' ) . 'assets/css/consentuntil.min.css', array(), true );
wp_register_script( 'lgpd-consent-until-js', lgpd( 'config' )->get( 'plugin.url' ) . 'assets/js/consentuntil.min.js', array(), true, true );
wp_enqueue_script( 'lgpd-consent-until-js' );
wp_enqueue_style( 'lgpd-consent-until-css' );
wp_register_style('lgpd-consent-until-dashicons', includes_url() . '/css/dashicons.min.css', array(), true);
wp_enqueue_style('lgpd-consent-until-dashicons');
if ( ! isset( $lgpd_value ) ) :
	$lgpd_value = '';
		endif;
if ( ! isset( $lgpd_arg2 ) ) :
	$lgpd_arg2 = '';
		endif;
if ( ! isset( $lgpd_arg3 ) ) :
	$lgpd_arg3 = '';
		endif;
?>
	<label>
		<input type="checkbox" required name="lgpd_terms" id="lgpd_terms" value="1" />
		<?php $enabled = lgpd( 'options' )->get( 'enable_tac' ); ?>
		<?php
		if ( $termsUrl && $enabled ) :
			add_filter( 'lgpd-framework-consent-policy-with-terms', 'LGPDTermAndConditionWithPrivacyContent' );
			$lgpd_text_policy_with_terms = apply_filters( 'lgpd-framework-consent-policy-with-terms', $lgpd_value, $lgpd_arg2, $lgpd_arg3 );
			?>
			<?php
			echo sprintf(
				__( $lgpd_text_policy_with_terms, 'lgpd-framework' ),
				"<a href='{$termsUrl}' target='_blank'>",
				'</a>',
				"<a href='{$privacyPolicyUrl}' target='_blank'>",
				'</a>'
			);
			?>
		<?php else : ?>
		
			<?php
			add_filter( 'lgpd-framework-consent-policy', 'lgpdfPrivacyPolicy' );
			$lgpd_text_policy = apply_filters( 'lgpd-framework-consent-policy', $lgpd_value, $lgpd_arg2, $lgpd_arg3 );
			?>
			<?php
			echo sprintf(
				__( $lgpd_text_policy, 'lgpd-framework' ),
				"<a href='{$privacyPolicyUrl}' target='_blank'>",
				'</a>'
			);
			?>
		<?php endif; if( get_option( 'lgpd_consent_until_display' ) === '1' ){ ?>* for<?php } ?>

</label>
<?php if( get_option( 'lgpd_consent_until_display' ) === '1' ){ ?>
<span class="lgpd-consent-until-wrap">
		<span class="dashicons dashicons-calendar-alt lgpd-consent-until-cal"></span>
		<select id="lgpd-consent-until" class="lgpd-consent-until" name="lgpd-consent-until">
			<option value="" default>Infinite</option>
			<option value="1">1 Month</option>
			<option value="3">3 Months</option>
			<option value="6">6 Months</option>
		</select>
	</span>
	<?php } ?>
</p>
