<?php
/**
 * NSS: Style register
 */

/* ABSPATH check */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'NSS_Register_Style' ) ) {
	class NSS_Register_Style extends NSS_Register_Base_Style {
		public function get_items(): Generator {
			yield new NSS_Reg_Style( 'nss-admin-settings', $this->src_helper( 'admin/settings.css', false ) );
		}
	}
}
