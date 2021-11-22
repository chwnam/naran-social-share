<?php
/**
 * NSS: uninstall
 */

/* ABSPATH check */
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	die;
}

require_once __DIR__ . '/index.php';

nss()->registers->uninstall->register();
