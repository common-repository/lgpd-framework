<input
	type="checkbox"
	id="lgpd_onetime_popup"
	name="lgpd_onetime_popup"
	value="1"
	<?php echo checked( $enabled, true ); ?>
/>
<label for="lgpd_onetime_popup">
	<?php echo esc_html_x( 'Enable One Time Cookie Acceptance Popup', '(Admin)', 'lgpd-framework' ); ?>
</label>
