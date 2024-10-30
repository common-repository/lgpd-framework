<hr>
<?php if ( $consentData ) : ?>
	<table class="lgpd-consent">
		<th colspan="2"><?php echo _x( 'Consents given', '(Admin)', 'lgpd-framework' ); ?></th>
		<?php foreach ( $consentData as $item ) : ?>
			<tr>
				<td>
					&#10004;
				</td>
				<td>
				<?= $item['title']; ?> Valid until <?= $item['valid_until']; ?>
				</td>
			</tr>
		<?php endforeach; ?>
	</table>
<?php else : ?>
	<p><?php echo _x( 'No consents given', '(Admin)', 'lgpd-framework' ); ?>.</p>
<?php endif; ?>
