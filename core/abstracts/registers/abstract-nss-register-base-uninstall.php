<?php
/**
 * NSS: Uninstall register base
 */

/* ABSPATH check */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'NSS_Register_Base_Uninstall' ) ) {
	abstract class NSS_Register_Base_Uninstall implements NSS_Register {
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
	}
}
