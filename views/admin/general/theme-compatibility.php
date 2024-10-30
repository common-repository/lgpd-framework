<input
	type="checkbox"
	id="lgpd_enable_theme_compatibility"
	name="lgpd_enable_theme_compatibility"
	value="1"
	<?php echo checked( $enabled, true ); ?>
/>
<label for="lgpd_enable_theme_compatibility">
	<?php echo esc_html_x( 'Automatically add Privacy Policy and Privacy Tools links to your site footer.', '(Admin)', 'lgpd-framework' ); ?>
</label>
