<?php

namespace Data443\LGPD\Components\AdvancedIntegration;

use Data443\LGPD\Admin\AdminTab;

class AdminTabAdvancedIntegration extends AdminTab
{
    /* @var string */
    protected $slug = 'advanced-integration';

    /* @var PolicyGenerator */
    protected $policyGenerator;

    public function __construct()
    {
        $this->title = _x('Data Hound', '(Admin)', 'lgpd-framework');

        add_action('lgpd/admin/action/AdvancedIntegration/generate', [$this, 'generateAdvancedIntegration']);
    }

    public function init()
    {
        $this->registerSettingSection(
            'lgpd_section_privacy_policy',
            'Data Hound',
            [$this, 'renderHeader']
        );
    }

    public function renderHeader()
    {
        echo lgpd('view')->render('admin/advanced-integration/header');
    }

    public function renderSubmitButton()
    {
        // leave an empty method to prevent the placement of the default save button
    }
}
