<input
	type="checkbox"
	id="lgpd_enable_popup"
	name="lgpd_enable_popup"
	value="1"
	<?php echo checked( $enabled, true ); ?>
/>
<label for="lgpd_enable_popup">
	<?php echo esc_html_x( 'Enable Cookie Acceptance Popup', '(Admin)', 'lgpd-framework' ); ?>
</label>
<p class="description">
	<?php echo _x( '<b>Note:</b> Need to add custom content <b>lgpd_cookie_consent</b> its accepted on popup accept button.', '(Admin)', 'lgpd-framework' ); ?>
</p>
