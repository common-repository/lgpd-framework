<p>
	<?php echo esc_html_x( 'On this page, you can find which data subjects personal data you are storing and download, export or delete it.', '(Admin)', 'lgpd-framework' ); ?>
</p>

<hr>

<?php echo $results; ?>

<label>
	<h3><?php echo esc_html_x( 'Find data subject by email', '(Admin)', 'lgpd-framework' ); ?></h3>
	<input type="email" name="lgpd_email" placeholder="<?php echo esc_html_x( 'Email address', '(Admin)', 'lgpd-framework' ); ?>" />
</label>

<input type="hidden" name="lgpd_nonce" value="<?php echo $nonce; ?>" />
<input type="hidden" name="lgpd_action" value="search" />
<input class="button button-primary" type="submit" value="<?php echo esc_html_x( 'Search', '(Admin)', 'lgpd-framework' ); ?>" />

<br><br>
