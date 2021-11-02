<?php
/**
 * NSS: Deactivation register
 */

/* ABSPATH check */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'NSS_Register_Deactivation' ) ) {
	class NSS_Register_Deactivation implements NSS_Register {
		public function __construct() {
			register_deactivation_hook( nss()->get_main_file(), [ $this, 'register' ] );
		}

		/**
		 * Method name can mislead, but it does deactivation callback jobs.
		 */
		public function register() {
			foreach ( $this->get_items() as $item ) {
				if ( $item instanceof NSS_Reg_Deactivation ) {
					$item->register();
				}
			}
		}

		public function get_items(): Generator {
			// Define your deactivation regs for callback.
			yield null;
		}
	}
}
