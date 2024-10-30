<h1>
	Configuration (2/2)
</h1>
<h2>&#10004; Privacy Tools page configured!</h2>
<p>
	You can take a look at the Privacy Tools page <a href="<?php echo esc_url( $privacyToolsPageUrl ); ?>" target="_blank">here</a>. <br>
	<br>
 
</p>
<hr>

<h2>Right to view & export data</h2>
<p>
	Your customers have the right to review and export their personal data.

	<label for="lgpd_export_action">Select what happens if a customer wishes to view or export their personal data</label>

	<select class="lgpd-select js-lgpd-conditional" name="lgpd_export_action">
		<?php echo lgpd( 'view' )->render( 'global/export-action', compact( 'exportAction' ) ); ?>
	</select>
	<span class="hidden js-lgpd-export-action-email">
		<label for="export_action_email">
			<?php echo esc_html_x( 'Enter the email address to notify', '(Admin)', 'lgpd-framework' ); ?>
		</label>
		<input
				type="email"
				id="lgpd_export_action_email"
				name="lgpd_export_action_email"
				placeholder="<?php echo __( 'Email address', 'lgpd-framework' ); ?>"
				value="<?php echo esc_attr( $exportActionEmail ); ?>"
		/>
	</span>
</p>
<hr>

<h2>Right to be forgotten</h2>
<p>
	Your customers have the right to request deleting their personal data.

	<label for="lgpd_delete_action">Select what happens if a customer wishes to delete their personal data</label>

	<select class="lgpd-select js-lgpd-conditional" name="lgpd_delete_action">
		<?php echo lgpd( 'view' )->render( 'global/delete-action', compact( 'deleteAction' ) ); ?>
	</select>

	<span class="hidden js-lgpd-delete-action-reassign">
		<label for="lgpd_delete_action_reassign">If the user has created any content (posts or pages), should it be deleted or reassigned?</label>
		<select id="lgpd_delete_action_reassign" name="lgpd_delete_action_reassign" class="lgpd-select js-lgpd-conditional">
			<option value="delete" <?php echo selected( $reassign, 'delete' ); ?>>
				<?php echo esc_html_x( 'Delete content', '(Admin)', 'lgpd-framework' ); ?>
			</option>
			<option value="reassign" <?php echo selected( $reassign, 'reassign' ); ?> data-show=".js-lgpd-delete-action-reassign-user">
				<?php echo esc_html_x( 'Reassign content to a user', '(Admin)', 'lgpd-framework' ); ?>
			</option>
		</select>
	</span>

	<span class="hidden js-lgpd-delete-action-reassign-user">
		<label for="lgpd_delete_action_reassign_user">Select the user to reassign content to</label>
		<?php
		wp_dropdown_users(
			array(
				'name'              => 'lgpd_delete_action_reassign_user',
				'show_option_none'  => esc_html_x( '&mdash; Select &mdash;', '(Admin)', 'lgpd-framework' ),
				'option_none_value' => '0',
				'selected'          => $reassignUser,
				'class'             => 'js-lgpd-select2 lgpd-select',
				'id'                => 'lgpd_delete_action_reassign_user',
				'role__in'          => apply_filters( 'lgpd/options/reassign/roles', array( 'administrator', 'editor' ) ),
			)
		);
		?>
	</span>

	<span class="hidden js-lgpd-delete-action-email">
		<label for="delete_action_email">
			<?php echo esc_html_x( 'Enter the email address to notify', '(Admin)', 'lgpd-framework' ); ?>
		</label>
		<input
			type="email"
			id="lgpd_delete_action_email"
			name="lgpd_delete_action_email"
			placeholder="<?php echo __( 'Email address', 'lgpd-framework' ); ?>"
			value="<?php echo esc_attr( $deleteActionEmail ); ?>"
		/>
	</span>
</p>

<hr>
<br>
<input type="submit" class="button button-lgpd button-right" value="Save &raquo;"/>
