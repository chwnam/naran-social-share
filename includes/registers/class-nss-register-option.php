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
	class NSS_Register_Option extends NSS_Register_Base_Option {
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
