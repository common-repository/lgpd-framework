<input
	type="checkbox"
	id="lgpd_enable_tac"
	name="lgpd_enable_tac"
	value="1"
	<?php echo checked( $enabled, true ); ?>
/>
<label for="lgpd_enable_tac">
	<?php echo esc_html_x( 'Enable the term and condition page.', '(Admin)', 'lgpd-framework' ); ?>
</label>
