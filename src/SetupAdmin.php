<?php

namespace Data443\LGPD;

use Data443\LGPD\Admin\AdminError;
use Data443\LGPD\Admin\AdminNotice;
use Data443\LGPD\Admin\Modal;
use Data443\LGPD\Admin\WordpressAdmin;
use Data443\LGPD\Admin\WordpressAdminPage;
use Data443\LGPD\Components\Consent\ConsentAdmin;
use Data443\LGPD\Components\CookiePopup\CookiePopup;
use Data443\LGPD\Installer\Installer;
use Data443\LGPD\Installer\AdminInstallerNotice;
use Data443\LGPD\Admin\AdminPrivacySafe;
use Data443\LGPD\DataSubject\DataSubjectAdmin;
use Data443\LGPD\Components\PrivacyPolicy\PrivacyPolicy;
use Data443\LGPD\Components\DoNotSell\DoNotSell;
use Data443\LGPD\Components\Support\Support;
use Data443\LGPD\Components\AdvancedIntegration\AdvancedIntegration;
use Data443\LGPD\Components\PrivacySafe\PrivacySafe;

/**
 * Register and set up admin components.
 * This class is instantiated at admin_init priority 0
 *
 * Class SetupAdmin
 *
 * @package Data443\LGPD
 */
class SetupAdmin
{
    public function __construct()
    {
        $this->registerComponents();
        $this->runComponents();
    }

    /**
     * Register components in the container
     */
    protected function registerComponents()
    {
        global $lgpd;
        $lgpd->AdminNotice = new AdminNotice();
        $lgpd->AdminError = new AdminError();
        $lgpd->AdminInstallerNotice = new AdminInstallerNotice();
        $lgpd->PrivacySafe = new AdminPrivacySafe();
        $lgpd->AdminModal = new Modal();
        $lgpd->AdminPage = new WordpressAdminPage();
        $lgpd->AdminTabGeneral = new Admin\AdminTabGeneral();
    }

    protected function runComponents()
    {
        global $lgpd;
        new WordpressAdmin($lgpd->AdminPage);
        new Installer($lgpd->AdminTabGeneral);
        new CookiePopup();
        new ConsentAdmin();
        new DataSubjectAdmin();
        new PrivacyPolicy();
        new DoNotSell();
        new Support();
        new AdvancedIntegration();
        new PrivacySafe();
    }
}
