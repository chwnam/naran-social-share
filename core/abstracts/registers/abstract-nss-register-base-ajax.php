<?php
/**
 * NSS: AJAX (admin-ajax.php, or wc-ajax) register base
 */

/* ABSPATH check */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'NSS_Register_Base_Ajax' ) ) {
	abstract class NSS_Register_Base_Ajax implements NSS_Register {
		use NSS_Hook_Impl;

		private array $inner_handlers = [];

		public function __construct() {
			$this->add_action( 'init', 'register' );
		}

		/**
		 * @callback
		 * @actin       init
		 */
		public function register() {
			foreach ( $this->get_items() as $item ) {
				if (
					$item instanceof NSS_Reg_Ajax &&
					$item->action &&
					! isset( $this->inner_handlers[ $item->action ] )
				) {
					$this->inner_handlers[ $item->action ] = $item->callback;
					$item->register( [ $this, 'dispatch' ] );
				}
			}
		}

		public function dispatch() {
			$action = $_REQUEST['action'] ?? '';

			if ( $action && isset( $this->inner_handlers[ $action ] ) ) {
				try {
					$callback = nss_parse_callback( $this->inner_handlers[ $action ] );
					if ( is_callable( $callback ) ) {
						call_user_func( $callback );
					}
				} catch ( NSS_Callback_Exception $e ) {
					$error = new WP_Error();
					$error->add(
						'nss_ajax_error',
						sprintf(
							'AJAX callback handler `%s` is invalid. Please check your AJAX register items.',
							nss_format_callback( $this->inner_handlers[ $action ] )
						)
					);
					wp_send_json_error( $error, 404 );
				}
			}
		}
	}
}
