<?php
/**
 * NSS: WP CLI register base
 */

/* ABSPATH check */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'NSS_Register_Base_WP_CLI' ) ) {
	abstract class NSS_Register_Base_WP_CLI implements NSS_Register {
		use NSS_Hook_Impl;

		public function __construct() {
			if ( defined( 'WP_CLI' ) && WP_CLI ) {
				$this->add_action( 'plugins_loaded', 'register' );
			}
		}

		/**
		 * @throws Exception
		 */
		public function register() {
			foreach ( $this->get_items() as $item ) {
				if ( $item instanceof NSS_Reg_WP_CLI ) {
					$item->register();
				}
			}
		}
	}
}