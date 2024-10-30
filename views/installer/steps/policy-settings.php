<h1>
	Privacy Policy (1/2)
</h1>

<h2>Privacy Policy page</h2>
<p>
	The second major requirement of LGPD is a thorough Privacy Policy that explains all of the rights your customers
	have and describes how exactly their data is used. We've put together a LGPD-compliant privacy policy template for you.
	Fill in the fields below and a privacy policy will be generated automatically. Note that you will need to modify it later to suit your website and business. <br>
	
	If you already have a LGPD-compliant Privacy Policy, simply select the page where it is displayed and skip the rest.
	<br>
</p>

<fieldset>
	<label>
		<input type="radio" name="lgpd_create_policy_page" value="yes" class="js-lgpd-conditional" <?php echo ! $policyPage ? 'checked' : ''; ?>>
		Automatically create a new page for Privacy Policy
	</label>

	<label>
		<input type="radio" name="lgpd_create_policy_page" value="no" class="js-lgpd-conditional" data-show=".lgpd-select-policy-page" <?php echo $policyPage ? 'checked' : ''; ?>> I want to use an existing page
	</label>
</fieldset>

	<p class="lgpd-select-policy-page hidden">
		<label for="lgpd_policy_page">Select the page where your Privacy Policy will be displayed</label>
		<?php echo $policyPageSelector; ?>
		<strong>OR</strong>
		<label for="lgpd_custom_policy_page">Enter the page URL where your Privacy Policy will be displayed</label>
		<input 
			type="url" 
			name="lgpd_custom_policy_page" 
			id="lgpd_custom_policy_page" 
			value="<?php echo esc_attr( $policy_page_url ); ?>"
		>
		<span class="notice_lgpd">(Leave blank if policy page selected above or make it blank if policy page exist in above page lists.)</span>
	</p>
<p>
	We can generate a somewhat personalized Privacy Policy template for you based on some information you can fill in below.
	Note that if you're using an existing page, this will overwrite the page contents.

	<label for="lgpd_generate_policy">
		<input
			type="checkbox"
			name="lgpd_generate_policy"
			id="lgpd_generate_policy"
			class="js-lgpd-conditional"
			data-show=".lgpd-generator-fields"
			value="yes"
		>
		Generate Privacy Policy
	</label>
	<em>Heads up - this will take some time to configure!</em>
</p>

<hr>

<div class="lgpd-generator-fields hidden">

	<h2>Company information</h2>
	<label for="lgpd_company_name">Company legal name</label>
	<input type="text" id="lgpd_company_name" name="lgpd_company_name" value="<?php echo esc_attr( $companyName ); ?>"/>
	<em>Enter the name of your company. If you are not registered as a company, enter your full name.</em>

	<label for="lgpd_contact_email">Contact email</label>
	<input type="email" id="lgpd_contact_email" name="lgpd_contact_email" value="<?php echo esc_attr( $contactEmail ); ?>"/>
	<em>
		Enter the contact email which should be used for LGPD and personal data related inquiries.<br>
		This email will be displayed in the Privacy Policy.
	</em>

	<hr>

	<h2>Company location</h2>
	<label for="lgpd_company_location">Company location</label>
	<select id="lgpd_company_location" name="lgpd_company_location" class="js-lgpd-select2 lgpd-select js-lgpd-conditional js-lgpd-country-selector">
		<?php echo $countryOptions; ?>
	</select>
	<em>
		Select the country where your company is registered. <br>
		If you are not registered as a company, enter your country of residence.
	</em>
	<div class="lgpd-representative hidden">
		<p>

		   
		</p>
		<p>
			If you have a representative contact, enter the contact details below.

			<label for="lgpd_representative_contact_name">Representative contact name</label>
			<input type="text" value="<?php echo esc_attr( $representativeContactName ); ?>" id="lgpd_representative_contact_name" name="lgpd_representative_contact_name" data />

			<label for="lgpd_representative_contact_email">Representative contact email</label>
			<input type="email" value="<?php echo esc_attr( $representativeContactEmail ); ?>" id="lgpd_representative_contact_email" name="lgpd_representative_contact_email" />

			<label for="lgpd_representative_contact_phone">Representative contact phone</label>
			<input type="text" value="<?php echo esc_attr( $representativeContactPhone ); ?>" id="lgpd_representative_contact_phone" name="lgpd_representative_contact_phone" />

		</p>
	</div>
	<br>
	<hr>

	
	<script>
		window.lgpdDpaData = <?php echo $dpaData; ?>;
	</script>

</div>

<h2>Terms & Conditions page</h2>
<p>
	If you have a Terms & Conditions page, we will need to know where it is located. If you don't have a Terms & Conditions page, you can safely skip this step.<br>
	
	<label for="lgpd_has_terms_page">
		<input
				type="checkbox"
				name="lgpd_has_terms_page"
				id="lgpd_has_terms_page"
				class="js-lgpd-conditional"
				data-show=".lgpd-terms-page"
				value="yes"
			<?php echo checked( $hasTermsPage, 'yes' ); ?>
		>
		I have a Terms & Conditions page
	</label>
</p>
<p>
	<span class="lgpd-terms-page hidden">
	<label for="lgpd_terms_page">Select the page where your Terms & Conditions are displayed</label>
		<?php if ( $termsPageNote ) : ?>
			<em><?php echo esc_html( $termsPageNote ); ?></em>
		<?php endif; ?>
		<?php echo $termsPageSelector; ?>
		<br>
	</span>
</p>

<hr>
<br>
<input type="submit" class="button button-lgpd button-right" value="Save &raquo;" />
