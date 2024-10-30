<div class="lgpd-framework-privacy-tools">
	<?php do_action( 'lgpd/frontend/privacy-tools-page/content/before', $dataSubject ); ?>

	<p>
		<?php echo __( 'You are identified as', 'lgpd-framework' ); ?> <strong><?php echo esc_html( $email ); ?></strong>
	</p>

	<hr>

	<?php do_action( 'lgpd/frontend/privacy-tools-page/content', $dataSubject ); ?>

	<?php do_action( 'lgpd/frontend/privacy-tools-page/content/after', $dataSubject ); ?>
</div>
