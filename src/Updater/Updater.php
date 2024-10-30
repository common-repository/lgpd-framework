<?php

namespace Data443\LGPD\Updater;

class Updater {

	public function __construct()
	{
		update_option('lgpd_plugin_version', LGPD_FRAMEWORK_VERSION);
	}
}
