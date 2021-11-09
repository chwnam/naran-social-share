<?php
/**
 * NSS: Shortcode reg.
 */

/* ABSPATH check */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'NSS_Reg_Shortcode' ) ) {
	class NSS_Reg_Shortcode implements NSS_Reg {
		public string $tag;

		/**
		 * @var string|callable
		 */
		public $callback;

		/**
		 * @var string|callable|null
		 */
		public $heading_action;

		/**
		 * @param string          $tag
		 * @param string|callable $callback
		 * @param null            $heading_action
		 */
		public function __construct( string $tag, $callback, $heading_action = null ) {
			$this->tag            = $tag;
			$this->callback       = $callback;
			$this->heading_action = $heading_action;
		}

		public function register( $dispatch = null ) {
			add_shortcode( $this->tag, $dispatch );
		}
	}
}
