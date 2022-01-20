<?php
/**
 * NSS: Menu register base
 */

/* ABSPATH check */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'NSS_Register_Base_Menu' ) ) {
	abstract class NSS_Register_Base_Menu implements NSS_Register {
		use NSS_Hook_Impl;

		private array $callbacks = [];

		public function __construct() {
			$this->add_action( 'admin_menu', 'register' );
		}

		public function register() {
			foreach ( $this->get_items() as $item ) {
				if ( $item instanceof NSS_Reg_Menu || $item instanceof NSS_Reg_Submenu ) {
					$this->callbacks[ $item->register( [ $this, 'dispatch' ] ) ] = $item->callback;
					if ( $item instanceof NSS_Reg_Menu && $item->remove_submenu ) {
						remove_submenu_page( $item->menu_slug, $item->menu_slug );
					}
				}
			}
		}

		public function dispatch() {
			global $page_hook;

			try {
				$callback = nss_parse_callback( $this->callbacks [ $page_hook ] ?? '' );
				if ( is_callable( $callback ) ) {
					call_user_func( $callback );
				}
			} catch ( NSS_Callback_Exception $e ) {
				wp_die( $e->getMessage() );
			}
		}
	}
}
