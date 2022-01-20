<?php
/**
 * NSS: Registrable interface
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! interface_exists( 'NSS_Reg' ) ) {
	interface NSS_Reg {
		public function register( $dispatch = null );
	}
}
