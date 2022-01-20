<?php
/**
 * NSS: Script method chain helper
 */

/* ABSPATH check */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'NSS_Script_Helper' ) ) {
	class NSS_Script_Helper {
		/** @var NSS_Template_Impl|NSS_Module */
		private $parent;

		/** @var string */
		private string $handle;

		public function __construct( $parent, string $handle ) {
			$this->parent = $parent;
			$this->handle = $handle;
		}

		/**
		 * Return another script helper.
		 *
		 * @param string $handle Handle string.
		 *
		 * @return NSS_Script_Helper
		 */
		public function script( string $handle ): NSS_Script_Helper {
			return new NSS_Script_Helper( $this->parent, $handle );
		}

		/**
		 * Return another style helper.
		 *
		 * @param string $handle Handle string.
		 *
		 * @return NSS_Style_Helper
		 */
		public function style( string $handle ): NSS_Style_Helper {
			return new NSS_Style_Helper( $this->parent, $handle );
		}

		/**
		 * Enqueue the script.
		 */
		public function enqueue(): self {
			wp_enqueue_script( $this->handle );
			return $this;
		}

		/**
		 * Function wp_localize_script() wrapper.
		 *
		 * @param array  $l10n        Localization data.
		 * @param string $object_name JS object name.
		 *
		 * @return self
		 */
		public function localize( array $l10n = [], string $object_name = '' ): self {
			if ( empty( $object_name ) ) {
				$split = preg_split( '/[-_]/', $this->handle );
				if ( $split ) {
					$object_name = $split[0] . implode( '', array_map( 'ucfirst', array_slice( $split, 1 ) ) );
				}
			}

			wp_localize_script( $this->handle, $object_name, $l10n );

			return $this;
		}

		/**
		 * Function wp_set_script_translations() wrapper.
		 *
		 * @param string      $domain
		 * @param string|null $path
		 *
		 * @return self
		 */
		public function script_translations( string $domain = 'default', string $path = null ): self {
			wp_set_script_translations( $this->handle, $domain, $path );
			return $this;
		}

		/**
		 * @return NSS_Template_Impl|NSS_Module
		 */
		public function then() {
			return $this->parent;
		}
	}
}
