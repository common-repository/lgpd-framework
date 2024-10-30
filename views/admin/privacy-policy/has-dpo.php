<label for="lgpd_has_dpo">
	<input
		type="checkbox"
		name="lgpd_has_dpo"
		id="lgpd_has_dpo"
		class="js-lgpd-conditional"
		data-show=".lgpd-dpo"
		value="yes"
		<?php echo checked( $hasDPO, 'yes' ); ?>
	>
	<?php echo esc_html_x( 'I have appointed a Data Protection Officer (DPO)', '(Admin)', 'lgpd-framework' ); ?>
</label>
