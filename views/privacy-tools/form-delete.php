<h2><?php echo ( lgpd( 'options' )->get( 'lgpd_delete_text' ) != '' ) ? lgpd( 'options' )->get( 'lgpd_delete_text' ) : __( 'Delete my user and data', 'lgpd-framework' ); ?></h2>
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
<br/>
<div class="lgpd-delete-button">
<?php add_thickbox(); ?>

<a href="#TB_inline?width=600&height=239&inlineId=lgpdmodal-window-id" class="thickbox button button-primary"><?php echo __( 'Delete my data', 'lgpd-framework' ); ?></a>

<div id="lgpdmodal-window-id" style="display:none;">
	<center>
	<form method="GET">
		<p class="description">
			<?php echo __( 'Delete all data we have gathered about you.', 'lgpd-framework' ); ?> <br/>
			<?php echo __( 'If you have a user account on our site, it will also be deleted.', 'lgpd-framework' ); ?> <br/>
			<?php echo __( 'Be careful - this action is permanent and CANNOT be undone.', 'lgpd-framework' ); ?>
		</p>
			<input type="hidden" name="lgpd_nonce" value="<?php echo esc_attr( $nonce ); ?>"/>
			<input type="hidden" name="lgpd_action" value="<?php echo esc_attr( $action ); ?>"/>
			<input type="submit" class="button button-primary" value="<?php echo __( 'Delete my data', 'lgpd-framework' ); ?>"/>
	</form>
	<center>
</div>

   
</div>


<hr>
