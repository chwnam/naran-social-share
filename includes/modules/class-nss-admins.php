<?php
/**
 * NSS: Admin modules group
 *
 * Manage all admin modules
 */

/* ABSPATH check */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'NSS_Admins' ) ) {
	/**
	 * @property-read NSS_Admin_Settings $settings
	 */
	class NSS_Admins implements NSS_Module {
		use NSS_Submodule_Impl;

		public function __construct() {
			$this->assign_modules(
				[
					'settings' => NSS_Admin_Settings::class,
				]
			);
		}
	}
}
