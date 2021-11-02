<?php
/**
 * NSS: Option register
 */

/* ABSPATH check */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'NSS_Register_Option' ) ) {
	/**
	 * @property-read NSS_Reg_Option $option
	 */
	class NSS_Register_Option implements NSS_Register {
		use NSS_Hook_Impl;

		/** @var array Key: alias, value: option_name */
		private array $fields = [];

		public function __construct() {
			$this->add_action( 'init', 'register' );
		}

		public function __get( string $alias ): ?NSS_Reg_Option {
			if ( isset( $this->fields[ $alias ] ) ) {
				return NSS_Reg_Option::factory( $this->fields[ $alias ] );
			} else {
				return null;
			}
		}

		/**
		 * @callback
		 * @action       init
		 */
		public function register() {
			foreach ( $this->get_items() as $idx => $item ) {
				if ( $item instanceof NSS_Reg_Option ) {
					$item->register();

					$alias = is_int( $idx ) ? $item->get_option_name() : $idx;

					$this->fields[ $alias ] = $item->get_option_name();
				}
			}
		}

		/**
		 * Define items here.
		 *
		 * To use alias, do not forget to return generator as 'key => value' form!
		 *
		 * @return Generator
		 */
		public function get_items(): Generator {
			yield 'option' => new NSS_Reg_Option(
				'nss_option_group',
				'nss_option',
				[
					'type'              => 'array',
					/* translators: Option message. Translation is not required. */
					'description'       => _x( 'Naran social share option', 'Option description.', 'nss' ),
					'sanitize_callback' => [ NSS_Setup::class, 'sanitize' ],
					'show_in_rest'      => false,
					'default'           => NSS_Setup::get_default_value(),
					'autoload'          => false,
				]
			);
		}
	}
}
