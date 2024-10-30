<h2><?php echo esc_html( __( 'LGPD Privacy', 'lgpd-framework' ) ); ?></h2>
<fieldset>
	<legend>
		<?php // _ex('Privacy configuration', '(Admin)', 'lgpd-framework'); ?>
	</legend>

	<p class="description">
		<label for="lgpd_cf7_enabled">
			<input type="checkbox" id="lgpd_cf7_enabled" name="lgpd_cf7_enabled" value="1" <?php echo checked( $enabled, true ); ?>>
			<?php _ex( "Include the entries of this form when downloading or deleting a data subject's data.", '(Admin)', 'lgpd-framework' ); ?>
		</label>
	</p>

	<br>

	<p class="description">
		<label for="lgpd_cf7_email_field">
			<?php _ex( "Select the mail-tag of the sender's email field (for example, your-email).", '(Admin)', 'lgpd-framework' ); ?>
			<?php
			$args            = wpcf7_scan_form_tags();
			$contact_form_id = filter_var( $_GET['post'], FILTER_SANITIZE_NUMBER_INT );
			$data            = get_post_meta( $contact_form_id, 'lgpd_cf7_email_field', true );
			?>
			<br>
			<select id="lgpd_cf7_email_field" name="lgpd_cf7_email_field" class="large-cf7-select">
				<?php
				if ( $args ) {
					foreach ( $args as $arg ) {
						if ( $arg->basetype == 'email' ) {
							?>
							
					<option value="<?php echo esc_attr( $arg->name ); ?>" 
											  <?php
												if ( $data == $arg->name ) {
													echo 'selected';}
												?>
					><?php echo esc_html( $arg->name ); ?></option>
							<?php
						}
					}
				}
				?>
			</select>
  
		</label>
	</p>
</fieldset>
