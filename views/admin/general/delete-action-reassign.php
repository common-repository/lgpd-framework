<select id="lgpd_delete_action_reassign" name="lgpd_delete_action_reassign" class="lgpd-select js-lgpd-conditional">
	<option value="delete" <?php echo selected( $reassign, 'delete' ); ?>>
		<?php echo esc_html_x( 'Delete content', '(Admin)', 'lgpd-framework' ); ?>
	</option>
	<option value="reassign" <?php echo selected( $reassign, 'reassign' ); ?> data-show=".js-lgpd-delete-action-reassign-user">
		<?php echo esc_html_x( 'Reassign content to a user', '(Admin)', 'lgpd-framework' ); ?>
	</option>
</select>
<p class="description">
	<?php echo esc_html_x( 'If the user has submitted any content on your site, should it be deleted or reassigned to another user?', '(Admin)', 'lgpd-framework' ); ?>
</p>
