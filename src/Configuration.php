<?php

namespace Data443\LGPD;

/**
 * General Configuration Variables
 *
 * Class Configuration
 *
 * @package Data443\LGPD
 */
class Configuration
{
    public function get($name)
    {
        global $lgpd;
        if ($name === 'plugin.url') {
            return $lgpd->PluginUrl;
        } elseif ($name === 'plugin.path') {
            return $lgpd->PluginPath;
        } elseif ($name === 'plugin.template_path') {
            return $lgpd->PluginTemplatePath;
        } elseif ($name === 'installer.wizardUrl') {
            return $lgpd->InstallerWizardUrl;
        } elseif ($name === 'help.url') {
            return $lgpd->HelpUrl;
        }
        die ("Unknown configuration variable: {$name}");
    }
}
