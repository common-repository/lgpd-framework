<h3><?php echo esc_html_x( 'Privacy Policy', '(Admin)', 'lgpd-framework' ); ?></h3>
<p>
	<?php echo esc_html_x( 'Your Privacy Policy has been generated.', '(Admin)', 'lgpd-framework' ); ?>
	<?php if ( $policyUrl ) : ?>
		<?php
		echo __(
			sprintf(
				'You can copy and paste it to your %sPrivacy Policy page%s.',
				"<a href='{$policyUrl}' target='_blank'>",
				'</a>'
			),
			'(Admin)',
			'lgpd-framework'
		);
		?>
	<?php endif; ?>
</p>

<?php echo $editor; ?>

<br>
<a href="<?php echo esc_url( $backUrl ); ?>" class="button button-secondary"><?php echo esc_html_x( '&laquo; Back', '(Admin)', 'lgpd-framework' ); ?></a>
<br><br>
