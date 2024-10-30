<?php do_action( 'lgpd/privacy-tools-page/identify/before' ); ?>

<?php if ( isset( $_REQUEST['lgpd_notice'] ) && in_array( $_REQUEST['lgpd_notice'], array( 'data_deleted', 'request_sent' ) ) ) : ?>
	<p>
		<br>

		<a href="<?php echo esc_url( get_home_url() ); ?>">
			<?php echo __( 'Back to front page', 'lgpd-framework' ); ?>
		</a>
	</p>
<?php else : ?>

	<h3>
		<?php echo __( 'Please identify yourself via e-mail', 'lgpd-framework' ); ?>
	</h3>
	<form>
		<?php do_action( 'lgpd/privacy-tools-page/identify/fields/before' ); ?>
		<label for="lgpd_email"><?php echo __( 'Enter your email address', 'lgpd-framework' ); ?></label>
		<input type="hidden" name="lgpd_action" value="identify" />
		<input type="hidden" name="lgpd_nonce" value="<?php echo $nonce; ?>" />
		<input type="email" id="lgpd_email" name="email" placeholder="<?php echo __( 'Enter your email address', 'lgpd-framework' ); ?>" />
		<?php do_action( 'lgpd/privacy-tools-page/identify/fields/after' ); ?>
		<?php $gdprbutton = apply_filters( 'gdpr_tool_button', 'Send email' ); ?>
		<input type="submit" value="<?php echo __( $gdprbutton, 'lgpd-framework' ); ?>" id="lgpd-submit"/>
	</form>

<?php endif; ?>

<?php do_action( 'lgpd/privacy-tools-page/identify/after' ); ?>
