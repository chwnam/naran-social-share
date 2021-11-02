<?php
/**
 * NSS: Post meta register
 */

/* ABSPATH check */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'NSS_Register_Post_Meta' ) ) {
	/**
	 * NOTE: Add 'property-read' phpdoc to make your editor inspect meta items.
	 */
	class NSS_Register_Post_Meta extends NSS_Reigster_Meta {
		/**
		 * Define items here.
		 *
		 * To use alias, do not forget to return generator as 'key => value' form!
		 *
		 * @return Generator
		 */
		public function get_items(): Generator {
			yield null;
		}
	}
}
