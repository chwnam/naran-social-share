<?php
/**
 * NSS: Custom table register base
 */

/* ABSPATH check */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'NSS_Register_Base_Custom_Table' ) ) {
	abstract class NSS_Register_Base_Custom_Table implements NSS_Register {
		public function register() {
			if ( ! function_exists( 'dbDelta' ) ) {
				require_once ABSPATH . 'wp-admin/includes/upgrade.php';
			}
			foreach ( $this->get_items() as $item ) {
				if ( $item instanceof NSS_Reg_Custom_Table ) {
					$item->register();
				}
			}
		}

		public function unregister() {
			foreach( $this->get_items() as $item ) {
				if ( $item instanceof NSS_Reg_Custom_Table ) {
					$item->unregister();
				}
			}
		}
	}
}
