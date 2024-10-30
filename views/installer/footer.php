				<!-- Close the installer form -->
				</form>

				<?php if ( ! isset( $disableBackButton ) or ! $disableBackButton ) : ?>
					<form method="POST">
						<input type="hidden" name="lgpd-installer" value="previous" />
						<input type="submit" class="button button-secondary lgpd-step-button lgpd-step-button-prev" value="&laquo; <?php echo __( 'Back' ); ?>">
					</form>
				<?php endif; ?>

			</div> <!-- .lgpd-content -->

		</div> <!-- .container -->
		
		<div class="lgpd-footer-links">
		  <p>
			You can always leave and continue the setup later from where you left off
		  </p>
		  <a class="button button-secondary" href="<?php echo esc_url( admin_url() ); ?>">
			Go to Dashboard
		  </a>
		</div>
		
		<?php
		wp_print_scripts(
			array(
				'lgpd-installer',
				'jquery-repeater',
				'select2',
				'conditional-show',
			)
		);
		?>
		<?php do_action( 'admin_print_footer_scripts' ); ?>
	</body>
</html>
