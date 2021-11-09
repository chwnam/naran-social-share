<?php
/**
 * NSS: uninstall
 */

/* ABSPATH check */
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	die;
}

foreach ( nss()->registers->uninstall->get_items() as $item ) {
	if ( $item instanceof NSS_Register_Uninstall ) {
		$item->register();
	}
}
