<?php
/**
 * NSS: Cron register base
 */

/* ABSPATH check */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'NSS_Register_Base_Cron' ) ) {
	abstract class NSS_Register_Base_Cron implements NSS_Register {
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
	}
}
