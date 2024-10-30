<input
	type="checkbox"
	id="lgpd_enable_stylesheet"
	name="lgpd_enable_stylesheet"
	value="1"
	<?php echo checked( $enabled, true ); ?>
/>
<label for="lgpd_enable_stylesheet">
	<?php esc_html( _ex( 'Enable basic styling for Privacy Tools page.', '(Admin)', 'lgpd-framework' ) ); ?>
</label>
