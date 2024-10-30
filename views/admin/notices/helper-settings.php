<p>
	<?php echo esc_html_x( 'Heads up! The LGPD Framework is not properly configured, so it will not work just yet.', '(Admin)', 'lgpd-framework' ); ?> <br>
	<?php
	echo sprintf(
		esc_html_x( 'Go to %1$sTools > Data443 LGPD%2$s and make sure all fields are filled in.', '(Admin)', 'lgpd-framework' ),
		"<a href='" . esc_url( lgpd( 'helpers' )->getAdminUrl() ) . "'>",
		'</a>'
	);
	?>
</p>
