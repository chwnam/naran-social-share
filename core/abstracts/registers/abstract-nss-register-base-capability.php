<?php
/**
 * NSS: Capability register base
 */

/* ABSPATH check */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'NSS_Register_Base_Capability' ) ) {
	abstract class NSS_Register_Base_Capability implements NSS_Register {
		public function register() {
			foreach ( $this->get_items() as $item ) {
				if ( $item instanceof NSS_Reg_Capability ) {
					$item->register();
				}
			}
		}

		public function unregister() {
			foreach ( $this->get_items() as $item ) {
				if ( $item instanceof NSS_Reg_Capability ) {
					$item->unregister();
				}
			}
		}
	}
}
