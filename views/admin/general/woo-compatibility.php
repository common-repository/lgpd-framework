<input
	type="checkbox"
	id="lgpd_enable_woo_compatibility"
	name="lgpd_enable_woo_compatibility"
	value="1"
	<?php echo checked( $enabled, true ); ?>
/>
<label for="lgpd_enable_woo_compatibility">
	<?php echo esc_html_x( 'Enable WooCommerce data on LGPD tool.', '(Admin)', 'lgpd-framework' ); ?>
</label>
<p class="description">
	<?php echo esc_html_x( 'Will work for WooCommerce Version 3.4.0 or later.', '(Admin)', 'lgpd-framework' ); ?>
</p>
