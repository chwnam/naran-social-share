<?php
/**
 * NSS: Script register
 */

/* ABSPATH check */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'NSS_Register_Script' ) ) {
	class NSS_Register_Script extends NSS_Register_Base_Script {
		public function get_items(): Generator {
			if ( is_admin() ) {
				// Admin-only.
				yield new NSS_Reg_Script(
					'nss-admin-settings',
					$this->src_helper( 'admin/settings.js', false ),
					[ 'jquery-ui-sortable' ]
				);
			} else {
				// Front-only.
				yield new NSS_Reg_Script( 'nss-front', $this->src_helper( 'front.js', false ), [], null, true );
			}
		}
	}
}
