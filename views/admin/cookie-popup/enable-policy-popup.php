<input
	type="checkbox"
	id="lgpd_policy_popup"
	name="lgpd_policy_popup"
	value="1"
	<?php echo checked( $enabled, true ); ?>
/>
<label for="lgpd_policy_popup">
	<?php echo esc_html_x( 'Enable Policy Link On Popup', '(Admin)', 'lgpd-framework' ); ?>
</label>
