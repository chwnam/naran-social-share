<?php
/**
 * NSS: Custom post type register base
 */

/* ABSPATH check */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'NSS_Register_Base_Post_Type' ) ) {
	abstract class NSS_Register_Base_Post_Type implements NSS_Register {
		use NSS_Hook_Impl;

		public function __construct() {
			$this->add_filter( 'init', 'register' );
		}

		/**
		 * @callback
		 * @actin       init
		 */
		public function register() {
			foreach ( $this->get_items() as $item ) {
				if ( $item instanceof NSS_Reg_Post_Type ) {
					$item->register();
				}
			}
		}
	}
}
