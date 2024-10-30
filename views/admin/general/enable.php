<input
	type="checkbox"
	id="lgpd_enable"
	name="lgpd_enable"
	value="1"
	<?php echo checked( $enabled, true ); ?>
/>
<label for="lgpd_enable">
	<?php echo esc_html_x( 'Enable the view, export and forget functionality for users and visitors', '(Admin)', 'lgpd-framework' ); ?>
</label>
<p class="description">
	<?php echo esc_html_x( 'Enable the Privacy Tools page on front-end and dashboard. This allows visitors to request viewing and deleting their personal data and withdraw consents.', '(Admin)', 'lgpd-framework' ); ?>
</p>
