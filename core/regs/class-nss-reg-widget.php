<?php
/**
 * NSS: Widget reg.
 */

/* ABSPATH check */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'NSS_Reg_Widget' ) ) {
	class NSS_Reg_Widget implements NSS_Reg {
		/**
		 * @var object|string
		 */
		public $widget;

		/**
		 * @param string|object $widget
		 */
		public function __construct( $widget ) {
			$this->widget = $widget;
		}

		public function register( $dispatch = null ) {
			register_widget( $this->widget );
		}
	}
}
