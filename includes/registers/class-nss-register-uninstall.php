<?php
/**
 * NSS: Uninstall register
 */

/* ABSPATH check */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'NSS_Register_Uninstall' ) ) {
	class NSS_Register_Uninstall extends NSS_Register_Base_Uninstall {
		public function get_items(): Generator {
			yield new NSS_Reg_Uninstall(
				function () {
					nss_option()->option->delete();
				}
			);
		}
	}
}
