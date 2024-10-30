<h2><?php echo __( 'Download your data', 'lgpd-framework' ); ?></h2>

<p class="description">
	<?php echo __( 'You can download all your data formatted as a table for viewing.', 'lgpd-framework' ); ?> <br>
	<?php echo __( 'Alternatively, you can export it in machine-readable JSON format.', 'lgpd-framework' ); ?>
</p>

<div class="lgpd-download-button">
	<form method="POST">
		<input type="hidden" name="lgpd_nonce" value="<?php echo esc_attr( $nonce ); ?>" />
		<input type="hidden" name="lgpd_action" value="export" />
		<input type="hidden" name="lgpd_format" value="html" />
		<input type="submit" class="button button-primary" value="<?php echo __( 'Download as table', 'lgpd-framework' ); ?>" />
	</form>
</div>

<div class="lgpd-export-button">
	<form method="POST">
		<input type="hidden" name="lgpd_nonce" value="<?php echo esc_attr( $nonce ); ?>" />
		<input type="hidden" name="lgpd_action" value="export" />
		<input type="hidden" name="lgpd_format" value="json" />
		<input type="submit" class="button button-primary" value="<?php echo __( 'Export as JSON', 'lgpd-framework' ); ?>" />
	</form>
</div>

<hr>
