<option value="download" <?php echo selected( $exportAction, 'download' ); ?>>
	<?php echo esc_html_x( 'Automatically download data', '(Admin)', 'lgpd-framework' ); ?>
</option>
<option value="download_and_notify" <?php echo selected( $exportAction, 'download_and_notify' ); ?>
		data-show=".js-lgpd-export-action-email">
	<?php echo esc_html_x( 'Automatically download data and notify me via email', '(Admin)', 'lgpd-framework' ); ?>
</option>
<option value="notify" <?php echo selected( $exportAction, 'notify' ); ?>
		data-show=".js-lgpd-export-action-email">
	<?php echo esc_html_x( 'Only notify me via email', '(Admin)', 'lgpd-framework' ); ?>
</option>



