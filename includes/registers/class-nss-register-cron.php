<?php
/**
 * NSS: Cron register
 */

/* ABSPATH check */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'NSS_Register_Cron' ) ) {
	class NSS_Register_Cron implements NSS_Register {
		use NSS_Hook_Impl;

		public function __construct() {
			register_activation_hook( nss()->get_main_file(), [ $this, 'register' ] );
			register_deactivation_hook( nss()->get_main_file(), [ $this, 'unregister' ] );
		}

		public function register() {
			foreach ( $this->get_items() as $item ) {
				if ( $item instanceof NSS_Reg_Cron ) {
					$item->register();
				}
			}
		}

		public function unregister() {
			foreach ( $this->get_items() as $item ) {
				if ( $item instanceof NSS_Reg_Cron ) {
					$item->unregister();
				}
			}
		}

		public function get_items(): Generator {
			yield null;
		}
	}
}
