<?php
/**
 * NSS: Uninstall register
 */

/* ABSPATH check */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'NSS_Register_Uninstall' ) ) {
	class NSS_Register_Uninstall implements NSS_Register {
		public function __construct() {
			register_uninstall_hook( nss()->get_main_file(), [ $this, 'register' ] );
		}

		/**
		 * Method name can mislead, but it does uninstall callback jobs.
		 */
		public function register() {
			foreach ( $this->get_items() as $item ) {
				if ( $item instanceof NSS_Reg_Uninstall ) {
					$item->register();
				}
			}
		}

		public function get_items(): Generator {
			yield null;
		}
	}
}
