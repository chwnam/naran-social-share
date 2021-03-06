<?php
/**
 * NSS: Activation register base
 */

/* ABSPATH check */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'NSS_Register_Base_Activation' ) ) {
	abstract class NSS_Register_Base_Activation implements NSS_Register {
		public function __construct() {
			register_activation_hook( nss()->get_main_file(), [ $this, 'register' ] );
		}

		/**
		 * Method name can mislead, but it does activation callback jobs.
		 */
		public function register() {
			foreach ( $this->get_items() as $item ) {
				if ( $item instanceof NSS_Reg_Activation ) {
					$item->register();
				}
			}
		}
	}
}
