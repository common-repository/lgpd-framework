<p>
	<?php echo esc_html_x(
		sprintf( 'A data subject (%s) has requested to remove their data.', esc_html( $email ) ),
		'(Admin)',
		'lgpd-framework'
	); ?>
	<br>
	<?php
	echo esc_html_x(
		sprintf( 'To access the data subject\'s data, %sclick here%s', "<a href='{$adminTabLink}'>", '</a>' ),
		'(Admin)',
		'lgpd-framework'
	);
	?>
</p>
<p>
	<?php echo esc_html_x( 'As a reminder: according to LGPD, you have 30 days to comply.', '(Admin)', 'lgpd-framework' ); ?>
</p>
