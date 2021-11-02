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
	 * @property-read NSS_Register_Activation    $activation
	 * @property-read NSS_Register_Ajax          $ajax
	 * @property-read NSS_Register_Comment_Meta  $comment_meta
	 * @property-read NSS_Register_Cron          $cron
	 * @property-read NSS_Register_Cron_Schedule $cron_schedule
	 * @property-read NSS_Register_Deactivation  $deactivation
	 * @property-read NSS_Register_Option        $option
	 * @property-read NSS_Register_Post_Meta     $post_meta
	 * @property-read NSS_Register_Post_Type     $post_type
	 * @property-read NSS_Register_Script        $script
	 * @property-read NSS_Register_Style         $style
	 * @property-read NSS_Register_Submit        $submit
	 * @property-read NSS_Register_Taxonomy      $taxonomy
	 * @property-read NSS_Register_Term_Meta     $term_meta
	 * @property-read NSS_Register_User_Meta     $user_meta
	 */
	class NSS_Registers implements NSS_Module {
		use NSS_Submodule_Impl;

		public function __construct() {
			/**
			 * You can remove unused registers.
			 */
			$this->assign_modules(
				[
//					'activation'    => NSS_Register_Activation::class,
//					'ajax'          => NSS_Register_Ajax::class,
//					'comment_meta'  => NSS_Register_Comment_Meta::class,
//					'cron'          => NSS_Register_Cron::class,
//					'cron_schedule' => NSS_Register_Cron_Schedule::class,
//					'deactivation'  => NSS_Register_Deactivation::class,
					'option' => NSS_Register_Option::class,
//					'post_meta'     => NSS_Register_Post_Meta::class,
//					'post_type'     => NSS_Register_Post_Type::class,
					'script' => NSS_Register_Script::class,
					'style'  => NSS_Register_Style::class,
//					'submit'        => NSS_Register_Submit::class,
//					'taxonomy'      => NSS_Register_Taxonomy::class,
//					'term_meta'     => NSS_Register_Term_Meta::class,
					// NOTE: 'uninstall' is not a part of registers submodules.
					//       Because it 'uninstall' hook requires static method callback.
//					'user_meta'     => NSS_Register_User_Meta::class,
				]
			);
		}
	}
}
