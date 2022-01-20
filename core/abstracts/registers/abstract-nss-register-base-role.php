<?php
/**
 * NSS: Role register base
 */

/* ABSPATH check */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'NSS_Register_Base_Role' ) ) {
	abstract class NSS_Register_Base_Role implements NSS_Register {
		public function register() {
			foreach ( $this->get_items() as $item ) {
				if ( $item instanceof NSS_Reg_Role ) {
					$item->register();
				}
			}
		}

		public function unregister() {
			foreach ( $this->get_items() as $item ) {
				if ( $item instanceof NSS_Reg_Role ) {
					$item->unregister();
				}
			}
		}
	}
}
