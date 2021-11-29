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
			/**
			 * @uses NSS_Front::handle_shortcode()
			 * @uses NSS_Front::shortcode_enqueue_style()
			 */
			yield new NSS_Reg_Shortcode( 'nss', 'front@handle_shortcode', 'front@shortcode_enqueue_style' );
		}
	}
}
