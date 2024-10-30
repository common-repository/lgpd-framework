<table class="form-table">
	<tr>
		<th>
			<label>
				<?php echo _x( 'Delete this user and all data', '(Admin)', 'lgpd-framework' ); ?>
			</label>
		</th>
		<td>
			<?php if ( $showDelete ) : ?>
				<a class="button" href="<?php echo esc_url( $url ); ?>">
					<?php echo _x( 'Delete my data', '(Admin)', 'lgpd-framework' ); ?>
				</a>
				<br/>
				<p class="description">
					<?php echo __( 'Delete all data we have gathered about you.', 'lgpd-framework' ); ?> <br/>
					<?php echo __( 'If you have a user account on our site, it will also be deleted.', 'lgpd-framework' ); ?> <br/>
					<?php echo __( 'Be careful - this action is permanent and CANNOT be undone.', 'lgpd-framework' ); ?>
					<?php if ( lgpd( 'options' )->get( 'enable_woo_compatibility' ) && class_exists( 'Woocommerce' ) ) { ?>
						<br/><strong class="lgpd_woo_note"><?php echo __( 'Note Regarding Order:', 'lgpd-framework' ); ?></strong><br/>
						<?php echo __( 'Your order with status Processing will not get deleted until status change.', 'lgpd-framework' ); ?><br/>
						<?php echo __( 'Your order with status Completed will get anonymize.', 'lgpd-framework' ); ?><br/>
						<?php echo __( "If you delete Completed order you can't apply for refund.", 'lgpd-framework' ); ?><br/>
					<?php } ?>
				</p>
			<?php else : ?>
				<p>
					<em>
						<?php echo _x( 'You seem to have an administrator or equivalent role, so deleting/anonymizing via this page is disabled.', '(Admin)', 'lgpd-framework' ); ?>
					</em>
				</p>
			<?php endif; ?>
		</td>
	</tr>
</table>


