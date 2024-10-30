<textarea name="lgpd_popup_content" rows="5" cols="40">
<?php if ( $content != '' ) { ?>
	<?php echo esc_html_x( $content, 'lgpd-framework' ); ?>
<?php } else { ?>
	<?php echo esc_html_x( 'This website uses cookies to ensure you get the best experience on our website.', 'lgpd-framework' ); ?>
<?php } ?>
</textarea>

