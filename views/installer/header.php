<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta name="viewport" content="width=device-width" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>
		<?php echo esc_html_x( 'WordPress LGPD &rsaquo; Setup Wizard', '(Admin)', 'lgpd-framework' ); ?>
	</title>
	<?php wp_print_scripts( array( 'jquery' ) ); ?>
	<?php do_action( 'admin_print_styles' ); ?>
	<?php do_action( 'admin_head' ); ?>
</head>

<body class="lgpd-installer wp-core-ui">

	<div class="container lgpd-installer-container">
		<div class="lgpd-header">
		  <div class="lgpd-header_left">
			<img class="lgpd-logo" src="<?php echo lgpd( 'config' )->get( 'plugin.url' ); ?>/assets/images/data443.png" />
		  </div>
		  <div class="lgpd-header_right">
			<h1>
			  <?php echo esc_html_x( 'The LGPD Framework', '(Admin)', 'lgpd-framework' ); ?>
			</h1>
		  </div>
		</div>
		<div class="lgpd-breadcrumbs">
		  <div class="lgpd-breadcrumbs_unit <?php echo $activeSteps > 0 ? 'active' : ''; ?>">
			<div class="lgpd-breadcrumbs_item">
			  <?php echo esc_html_x( 'Configuration', '(Admin)', 'lgpd-framework' ); ?>
			</div>
		  </div>
		  <div class="lgpd-breadcrumbs_unit <?php echo $activeSteps > 1 ? 'active' : ''; ?>">
			<div class="lgpd-breadcrumbs_item">
			  <?php echo esc_html_x( 'Privacy Policy', '(Admin)', 'lgpd-framework' ); ?>
			</div>
		  </div>
		  <div class="lgpd-breadcrumbs_unit <?php echo $activeSteps > 2 ? 'active' : ''; ?>">
			<div class="lgpd-breadcrumbs_item">
			  <?php echo esc_html_x( 'Forms & Consent', '(Admin)', 'lgpd-framework' ); ?>
			</div>
		  </div>
		  <div class="lgpd-breadcrumbs_unit <?php echo $activeSteps > 3 ? 'active' : ''; ?>">
			<div class="lgpd-breadcrumbs_item">
			  <?php echo esc_html_x( 'Integrations', '(Admin)', 'lgpd-framework' ); ?>
			</div>
		  </div>
		</div>

		<div class="lgpd-content">

			<?php if ( isset( $_GET['lgpd-error'] ) ) : ?>
				<p class="error">Failed to validate nonce! Please reload page and try again.</p>
			<?php endif; ?>

			<!-- Open the installer form -->
			<form method="POST">
				<input type="hidden" name="lgpd-installer" value="next" />
