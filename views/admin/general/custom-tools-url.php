<input type="url" name="lgpd_custom_tools_page" value="<?php if($content!=""){?>
<?= esc_html_x($content, 'lgpd-framework');?>
<?php } ?>" />
<p class="description">
    <?= esc_html_x('Leave blank if privacy tools page already selected', '(Admin)', 'lgpd-framework'); ?>
</p>
