<?php
/**
 * NSS: Block register base
 */

/* ABSPATH check */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'CLASSNAME' ) ) {
	abstract class NSS_Register_Base_Block implements NSS_Register {
		use NSS_Hook_Impl;

		public function __construct() {
			$this->add_action( 'init', 'register' );
		}

		public function register() {
			foreach ( $this->get_items() as $item ) {
				if ( $item instanceof NSS_Reg_Block ) {
					$item->register();
				}
			}
		}
	}
}
