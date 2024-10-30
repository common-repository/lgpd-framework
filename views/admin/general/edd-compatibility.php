<input
	type="checkbox"
	id="lgpd_enable_edd_compatibility"
	name="lgpd_enable_edd_compatibility"
	value="1"
	<?php echo checked( $enabled, true ); ?>
/>
<label for="lgpd_enable_edd_compatibility">
	<?php echo esc_html_x( 'Enable EDD data on LGPD tool.', '(Admin)', 'lgpd-framework' ); ?>
</label>
<p class="description">
	<?php echo esc_html_x( 'Will work for EDD Version 2.0.0 or later.', '(Admin)', 'lgpd-framework' ); ?>
</p>
