<div class="lgpd-notice">
	<mark>
		<?php if ( 'email_sent' === sanitize_key( $_REQUEST['lgpd_notice'] ) ) : ?>
			<?php echo __( 'We will send you an email with the link to access your data. Please check your spam folder as well!', 'lgpd-framework' ); ?>
		<?php endif; ?>

		<?php if ( 'invalid_email' === sanitize_key( $_REQUEST['lgpd_notice'] ) ) : ?>
			<?php echo __( 'The email you entered does not appear to be a valid email.', 'lgpd-framework' ); ?>
		<?php endif; ?>

		<?php if ( 'invalid_key' === sanitize_key( $_REQUEST['lgpd_notice'] ) ) : ?>
			<?php echo __( 'Sorry - the link seems to have expired. Please try again!', 'lgpd-framework' ); ?>
		<?php endif; ?>

		<?php if ( 'consent_withdrawn' === sanitize_key( $_REQUEST['lgpd_notice'] ) ) : ?>
			<?php echo __( 'Consent withdrawn.', 'lgpd-framework' ); ?>
		<?php endif; ?>

		<?php if ( 'request_sent' === sanitize_key( $_REQUEST['lgpd_notice'] ) ) : ?>
			<?php echo __( 'We have received your request and will reply within 30 days.', 'lgpd-framework' ); ?>
		<?php endif; ?>

		<?php if ( 'data_deleted' === sanitize_key( $_REQUEST['lgpd_notice'] ) ) : ?>
			<?php echo __( 'Your personal data has been removed!', 'lgpd-framework' ); ?>
		<?php endif; ?>

		<?php if ( 'unregistered_user' === sanitize_key( $_REQUEST['lgpd_notice'] ) ): ?>
			<?= __(sanitize_text_field(lgpd('options')->get('unknown_user_message', LGPD_DEFAULT_UNKNOWN_USER_MESSAGE)), 'lgpd-framework'); ?>
		<?php endif; ?>
	</mark>
</div>
