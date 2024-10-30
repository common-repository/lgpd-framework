<p>
	The LGPD Framework has not been set up yet. Would you like to do that? <br>
	Our setup wizard will guide you through the process. <br>
	You can also configure the plugin manually by going to <a href="<?php echo esc_url( lgpd( 'helpers' )->getAdminUrl() ); ?>">Tools > Data443 LGPD</a>.
</p>

<a class="button button-primary" href="<?php echo $installerUrl; ?>">
	<?php echo esc_html_x( 'Run the setup wizard', '(Admin)', 'lgpd-framework' ); ?>
</a>

<a class="button button-secondary" href="<?php echo $autoInstallUrl; ?>">
	<?php echo esc_html_x( 'Auto-install pages', '(Admin)', 'lgpd-framework' ); ?>
</a>

<a class="button button-secondary" href="<?php echo $skipUrl; ?>">
	<?php echo esc_html_x( 'Skip and install manually', '(Admin)', 'lgpd-framework' ); ?>
</a>
