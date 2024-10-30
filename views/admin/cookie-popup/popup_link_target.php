<select class="lgpd-select js-lgpd-conditional" name="lgpd_popup_link_target">
<option value="_blank" <?php echo selected( $content, '_blank' ); ?>>
	<?php echo esc_html_x( 'Next Tab', '(Admin)', 'lgpd-framework' ); ?>
</option>
<option value="_self" <?php echo selected( $content, '_self' ); ?>>
	<?php echo esc_html_x( 'Self', '(Admin)', 'lgpd-framework' ); ?>
</option>
</select>
