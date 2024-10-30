<table class="form-table">
	<tr>
		<th>
			<label>
				<?php echo _x( 'Delete this user and all data', '(Admin)', 'lgpd-framework' ); ?>
			</label>
		</th>
		<td>
			<?php if ( $showDelete ) : ?>
				<a class="button" href="<?php echo esc_url( $deleteUrl ); ?>">
					<?php echo _x( 'Delete user and all data', '(Admin)', 'lgpd-framework' ); ?>
				</a>
				<a class="button" href="<?php echo esc_url( $anonymizeUrl ); ?>">
					<?php echo _x( 'Anonymize user and all data', '(Admin)', 'lgpd-framework' ); ?>
				</a>
				<br/>
				<p class="description">
					<?php echo _x( 'Be careful - this action is permanent and CANNOT be undone.', 'lgpd-framework' ); ?>
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
