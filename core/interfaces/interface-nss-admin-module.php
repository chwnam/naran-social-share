<?php
/**
 * NSS: Admin module interface
 */

/* ABSPATH check */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! interface_exists( 'NSS_Admin_Module' ) ) {
	interface NSS_Admin_Module extends NSS_Module {
	}
}
