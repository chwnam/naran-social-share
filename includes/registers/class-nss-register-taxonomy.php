<?php
/**
 * NSS: Custom taxonomy register
 */

/* ABSPATH check */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'NSS_Register_Taxonomy' ) ) {
	class NSS_Register_Taxonomy implements NSS_Register {
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
				if ( $item instanceof NSS_Reg_Taxonomy ) {
					$item->register();
				}
			}
		}

		public function get_items(): Generator {
			yield null;
		}
	}
}
