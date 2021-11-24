<?php

if ( ! ( defined( 'WP_UNINSTALL_PLUGIN' ) && WP_UNINSTALL_PLUGIN ) ) {
	exit;
}

require_once __DIR__ . '/index.php';
require_once __DIR__ . '/core/uninstall-functions.php';

nss_cleanup_option();
