<?php
/**
 * NSS: Registers module
 *
 * Manage all registers
 */

/* ABSPATH check */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'NSS_Registers' ) ) {
	/**
	 * You can remove unused registers.
	 *
	 * @property-read NSS_Register_Option    $option
	 * @property-read NSS_Register_Script    $script
	 * @property-read NSS_Register_Style     $style
	 * @property-read NSS_Register_Uninstall $uninstall
	 */
	class NSS_Registers implements NSS_Module {
		use NSS_Submodule_Impl;

		public function __construct() {
			/**
			 * You can remove unused registers.
			 */
			$this->assign_modules(
				[
					'option'    => NSS_Register_Option::class,
					'script'    => NSS_Register_Script::class,
					'style'     => NSS_Register_Style::class,
					'uninstall' => NSS_Register_Uninstall::class,
				]
			);
		}
	}
}
