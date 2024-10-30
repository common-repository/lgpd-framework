<input
	type="checkbox"
	id=lgpd_<?php echo esc_attr( $content['option_name'] ); ?>
	name=lgpd_<?php echo esc_attr( $content['option_name'] ); ?>
	value="1"
	<?php echo checked( $content['value'], true ); ?>
/>
<label for="lgpd_<?php echo esc_attr( $content['option_name'] ); ?>">
	<?php echo esc_html_x( $content['option'] . '.', '(Admin)', 'lgpd-framework' ); ?>
</label>
