<?php if ( $consentData or $consentInfo ) : ?>
	<hr>
	<h2><?php echo __( 'Consent', 'lgpd-framework' ); ?></h2>
	<?php if ( $consentData ) : ?>
		<form method="post">
			<p><?php echo __( 'Here you can withdraw any consents you have given.', 'lgpd-framework' ); ?></p>
			<table class="lgpd-consent lgpd-consent-user">
				<th colspan="3"><?php echo __( 'Consents', 'lgpd-framework' ); ?></th>
				<?php foreach ( $consentData as $item ) : ?>
					<tr>
						<td>
							&#10004;
						</td>
						<td class="lgpd-consent-user-title">
						  <?php echo $item['title']; ?>
						</td>
						<td class="lgpd-consent-user-desc">
						  <?php echo $item['description']; ?>
						</td>
						<td>
							<?php if ( 'privacy-policy' !== $item['slug'] ) : ?>
								<a href="<?php echo esc_url( $item['withdraw_url'] ); ?>" class="button button-primary">
									<?php echo __( 'Withdraw', 'lgpd-framework' ); ?>
								</a>
							<?php endif; ?>
						</td>
					</tr>
				<?php endforeach; ?>
			</table>
		</form>
	<?php endif; ?>

	<?php if ( $consentInfo ) : ?>
		<p class="lgpd-consent-disclaimer">
			<em><?php echo do_shortcode( $consentInfo ); ?></em>
		</p>
	<?php endif; ?>

<?php endif; ?>
