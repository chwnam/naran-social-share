<?php
/**
 * NSS: Register interface
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! interface_exists( 'NSS_Register' ) ) {
	interface NSS_Register {
		public function get_items(): Generator;

		public function register();
	}
}
