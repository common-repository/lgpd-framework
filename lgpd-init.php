<?php

require_once(dirname(__FILE__).'/src/Singleton.php');

function lgpd($name)
{
    global $lgpd;
    if ($name === 'admin-notice') {
        return $lgpd->AdminNotice;
    } elseif ($name === 'themes') {
        return $lgpd->Themes;
    } elseif ($name === 'view') {
        return $lgpd->View;
    } elseif ($name === 'helpers') {
        return $lgpd->Helpers;
    } elseif ($name === 'admin-error') {
        return $lgpd->AdminError;
    } elseif ($name === 'options') {
        return $lgpd->Options;
    } elseif ($name === 'consent') {
        return $lgpd->Consent;
    } elseif ($name === 'data-subject') {
        return $lgpd->DataSubject;
    } elseif ($name === 'controller') {
        return $lgpd->Controller;
    } elseif ($name === 'config') {
        return $lgpd->Configuration;
    } elseif ($name === 'privacy-safe') {
        return $lgpd->PrivacySafe;
    }
    die("Unknown name in lgpd: " . $name);
}

add_action('init', function() {

    if (!is_admin()) {
        return;
    }

    new \Data443\LGPD\SetupAdmin();
}, 0);

include_once(dirname(__FILE__).'/src/Updater/Updater.php');

/**
 * Start the plugin on plugins_loaded at priority 0.
 */
add_action('plugins_loaded', function () {
    
    new \Data443\LGPD\Updater\Updater();

    global $lgpd;
    $lgpd = new \Data443\LGPD\Singleton();
    $lgpd->init(__FILE__);

}, 0);
