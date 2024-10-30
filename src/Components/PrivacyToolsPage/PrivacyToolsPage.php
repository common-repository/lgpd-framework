<?php

namespace Data443\LGPD\Components\PrivacyToolsPage;

class PrivacyToolsPage {

	public function __construct() {
        global $lgpd;
        $controller = new PrivacyToolsPageController(
            $lgpd->DataSubjectAuthenticator
            , $lgpd->DataSubjectIdentificator
            , $lgpd->DataSubject
            , $lgpd->DataExporter
            , $lgpd->UserConsentModel
            );
        $lgpd->Controller = $controller;
        new PrivacyToolsPageShortcode($controller, $lgpd->Consent);
	}
}
