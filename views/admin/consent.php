<hr>

<h3><?php echo esc_html_x( 'Default consent types', '(Admin)', 'lgpd-framework' ); ?></h3>
<p><?php echo esc_html_x( 'These are the consent types that have been automatically registered by the framework or a plugin.', '(Admin)', 'lgpd-framework' ); ?></p>
<?php if ( count( $defaultConsentTypes ) ) : ?>
	<table class="lgpd-consent">
		<th><?php echo esc_html_x( 'Slug', '(Admin)', 'lgpd-framework' ); ?></th>
		<th><?php echo esc_html_x( 'Title', '(Admin)', 'lgpd-framework' ); ?></th>
		<th><?php echo esc_html_x( 'Description', '(Admin)', 'lgpd-framework' ); ?></th>
		<th><?php echo esc_html_x( 'Visibility', '(Admin)', 'lgpd-framework' ); ?></th>
	<?php foreach ( $defaultConsentTypes as $consentType ) : ?>
		<tr>
			<td class="lgpd-consent-table-input"><?php echo $consentType['slug']; ?></td>
			<td class="lgpd-consent-table-input"><?php echo $consentType['title']; ?></td>
			<td class="lgpd-consent-table-desc"><?php echo $consentType['description']; ?></td>
			<td>
				<?php if ( $consentType['visible'] ) : ?>
					<?php echo esc_html_x( 'Visible', '(Admin)', 'lgpd-framework' ); ?>
				<?php else : ?>
					<?php echo esc_html_x( 'Hidden', '(Admin)', 'lgpd-framework' ); ?>
				<?php endif; ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>
<br>
<hr>
<h3><?php echo esc_html_x( 'Custom consent types', '(Admin)', 'lgpd-framework' ); ?></h3>
<p><?php echo esc_html_x( 'Here you can add custom consent types to track. They will not be used anywhere by default - you will need to build an integration for each of them.', '(Admin)', 'lgpd-framework' ); ?></p>
<div class="js-lgpd-repeater" data-name="lgpd_consent_types">
	<table class="lgpd-consent-admin lgpd-show-hide lgpd-hidden" data-repeater-list="lgpd_consent_types">
		<thead>
			<th>
				<?php echo esc_html_x( 'Machine-readable slug', '(Admin)', 'lgpd-framework' ); ?>*
			</th>
			<th>
				<?php echo esc_html_x( 'Title', '(Admin)', 'lgpd-framework' ); ?>*
			</th>
			<th>
				<?php echo esc_html_x( 'Description', '(Admin)', 'lgpd-framework' ); ?>
			</th>
			<th>
				<?php echo esc_html_x( 'Visible?', '(Admin)', 'lgpd-framework' ); ?>
			</th>
		</thead>
		<tr data-repeater-item>
			<td class="lgpd-consent-table-input">
				<input
						type="text"
						name="slug"
						class="lgpd_custom_consent_types"
						placeholder="<?php echo esc_html_x( 'Slug', '(Admin)', 'lgpd-framework' ); ?>"
						pattern="^[A-Za-z0-9_-]+$"
						oninvalid="setCustomValidity('Please fill in this field using alphanumeric characters, dashes and underscores.')"
						oninput="setCustomValidity('')"
						required
				/>
			</td>
			<td class="lgpd-consent-table-input">
				<input type="text" name="title" class="lgpd_custom_consent_types" placeholder="<?php echo esc_html_x( 'Title', '(Admin)', 'lgpd-framework' ); ?>" required />
			</td>
			<td class="lgpd-consent-table-desc">
				<textarea type="text" name="description" placeholder="<?php echo esc_html_x( 'Description', '(Admin)', 'lgpd-framework' ); ?>"></textarea>
			</td>
			<td>
				<label>
					<input type="checkbox" name="visible" value="1"/>
					<?php echo esc_html_x( 'Visible?', '(Admin)', 'lgpd-framework' ); ?>
				</label>
			</td>
			<td>
			  <input data-repeater-delete class="button button-primary" type="button" value="<?php echo esc_html_x( 'Remove', '(Admin)', 'lgpd-framework' ); ?>"/>
			</td>
		</tr>

	</table>
	<div class="lgpd-consent-add-button">
	  <input data-enable-repeater class="button button-primary show_form_consent_lgpd" type="button" value="<?php echo esc_html_x( 'Show Consent types', '(Admin)', 'lgpd-framework' ); ?>"/>
	  <input data-repeater-create class="button button-primary lgpd-show-hide lgpd-hidden" type="button" value="<?php echo esc_html_x( 'Add consent type', '(Admin)', 'lgpd-framework' ); ?>"/>
	  <input data-enable-repeater class="button button-primary hide_form_consent_lgpd lgpd-show-hide lgpd-hidden" type="button" value="<?php echo esc_html_x( 'Hide consent types', '(Admin)', 'lgpd-framework' ); ?>"/>
	</div>
	<input type="hidden" name="lgpd_nonce" value="<?php echo $nonce; ?>" />
	<input type="hidden" name="lgpd_action" value="update_consent_data" />
</div>

<?php if ( count( $customConsentTypes ) ) : ?>
	<script>
		window.repeaterData = [];
		window.repeaterData['lgpd_consent_types'] = <?php echo json_encode( $customConsentTypes ); ?>;
	</script>
<?php endif; ?>
<br>
<hr>
<h3><?php echo esc_html_x( 'Additional info', '(Admin)', 'lgpd-framework' ); ?></h3>
<p>
	<?php echo esc_html_x( 'This text will be displayed to your data subjects on the Privacy Tools page.', '(Admin)', 'lgpd-framework' ); ?>
</p>
<?php
wp_editor(
	wp_kses_post( $consentInfo ),
	'lgpd_consent_info',
	array(
		'textarea_rows' => 4,
	)
);
?>
<br>
<hr>
