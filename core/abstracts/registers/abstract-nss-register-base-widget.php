<?php
/**
 * NSS: Widget register base
 */

/* ABSPATH check */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'NSS_Register_Base_Widget' ) ) {
	abstract class NSS_Register_Base_Widget implements NSS_Register {
		use NSS_Hook_Impl;

		public function __construct() {
			$this->add_action( 'widgets_init', 'register' );
		}

		public function register() {
			foreach ( $this->get_items() as $item ) {
				if ( $item instanceof NSS_Reg_Widget ) {
					$item->register();
				}
			}
		}
	}
}
