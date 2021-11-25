<?php
/**
 * NSS: Shortcode register.
 */

/* ABSPATH check */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'NSS_Register_Shortcode' ) ) {
	class NSS_Register_Shortcode extends NSS_Register_Base_Shortcode {
		public function get_items(): Generator {
			/** @uses NSS_Front::handle_shortcode() */
			yield new NSS_Reg_Shortcode( 'nss', 'front@handle_shortcode' );
		}
	}
}
