<?php
/**
 * NSS: Capability reg.
 */

/* ABSPATH check */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'NSS_Reg_Capability' ) ) {
	class NSS_Reg_Capability implements NSS_Reg {
		public string $role;

		public array $capabilities;

		public function __construct( string $role, array $capabilities ) {
			$this->role         = $role;
			$this->capabilities = $capabilities;
		}

		public function register( $dispatch = null ) {
			$role = get_role( $this->role );

			if ( $role ) {
				foreach ( $this->capabilities as $capability ) {
					$role->add_cap( $capability );
				}
			}
		}

		public function unregister() {
			$role = get_role( $this->role );

			if ( $role ) {
				foreach ( $this->capabilities as $capability ) {
					$role->remove_cap( $capability );
				}
			}
		}
	}
}
