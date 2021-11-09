<?php
/**
 * NSS: Main
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'NSS_Main' ) ) {
	/**
	 * Class NSS_Main
	 *
	 * @property-read NSS_Admin_Settings $admin_settings
	 * @property-read NSS_Front          $front
	 * @property-read NSS_Registers      $registers
	 * @property-read NSS_Setup          $setup
	 */
	final class NSS_Main extends NSS_Main_Base {
		protected function get_modules(): array {
			return [
				'admin_settings' => NSS_Admin_Settings::class,
				'front'          => NSS_Front::class,
				'registers'      => NSS_Registers::class,
				'setup'          => function () { return new NSS_Setup(); },
			];
		}
	}
}
