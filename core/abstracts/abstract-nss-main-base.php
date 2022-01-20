<?php
/**
 * NSS: Main base
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'NSS_Main_Base' ) ) {
	/**
	 * Class NSS_Main_Base
	 */
	abstract class NSS_Main_Base implements NSS_Module {
		use NSS_Hook_Impl;
		use NSS_Submodule_Impl;

		/**
		 * @var NSS_Main_Base|null
		 */
		private static ?NSS_Main_Base $instance = null;

		/**
		 * Free storage for the plugin.
		 *
		 * @var array
		 */
		private array $storage = [];

		/**
		 * Parsed module cache.
		 * Key:   input string notation.
		 * Value: found module, or false.
		 *
		 * @var array
		 */
		private array $parsed_cache = [];

		/**
		 * Module's constructor parameters.
		 * Key:   module name
		 * Value: Array for constructor.
		 *
		 * @var array
		 */
		private array $constructor_params = [];

		/**
		 * Get instance method.
		 *
		 * @return NSS_Main_Base
		 */
		public static function get_instance(): NSS_Main_Base {
			if ( is_null( self::$instance ) ) {
				self::$instance = new static();
				self::$instance->initialize();
			}
			return self::$instance;
		}

		/**
		 * NSS_Main_Base constructor.
		 */
		protected function __construct() {
		}

		/**
		 * Return plugin main file.
		 *
		 * @return string
		 */
		public function get_main_file(): string {
			return NSS_MAIN_FILE;
		}

		/**
		 * Get default priority
		 *
		 * @return int
		 */
		public function get_priority(): int {
			return NSS_PRIORITY;
		}

		/**
		 * Retrieve submodule by given string notation.
		 *
		 * @param string $module_notation
		 *
		 * @return object|false
		 */
		public function get_module_by_notation( string $module_notation ) {
			if ( class_exists( $module_notation ) ) {
				return $this->new_instance( $module_notation );
			} elseif ( $module_notation ) {
				if ( ! isset( $this->parsed_cache[ $module_notation ] ) ) {
					$module = $this;
					foreach ( explode( '.', $module_notation ) as $crumb ) {
						if ( isset( $module->{$crumb} ) ) {
							$module = $module->{$crumb};
						} else {
							$module = false;
							break;
						}
					}
					$this->parsed_cache[ $module_notation ] = $module;
				}

				return $this->parsed_cache[ $module_notation ];
			}

			return false;
		}

		/**
		 * Return submodule's callback method by given string notation.
		 *
		 * @param Closure|array|string $item
		 *
		 * @return Closure|array|string
		 * @throws NSS_Callback_Exception
		 * @example foo.bar@baz ---> array( nss()->foo->bar, 'baz )
		 */
		public function parse_callback( $item ) {
			if ( is_callable( $item ) ) {
				return $item;
			} elseif ( is_string( $item ) && false !== strpos( $item, '@' ) ) {
				[ $module_part, $method ] = explode( '@', $item, 2 );

				$module = $this->get_module_by_notation( $module_part );

				if ( $module && is_callable( [ $module, $method ] ) ) {
					return [ $module, $method ];
				}
			}

			throw new NSS_Callback_Exception(
				sprintf(
				/* translators: formatted module name. */
					__( '%s is invalid for callback.', 'nss' ),
					nss_format_callback( $item )
				),
				100
			);
		}

		/**
		 * Get the theme version
		 *
		 * @return string
		 */
		public function get_version(): string {
			return NSS_VERSION;
		}

		/**
		 * Get something from storage.
		 */
		public function get( string $key, $default = '' ) {
			return $this->storage[ $key ] ?? $default;
		}

		/**
		 * Set something to storage.
		 */
		public function set( string $key, $value ) {
			$this->storage[ $key ] = $value;
		}

		/**
		 * Load textdomain
		 *
		 * @used-by initialize()
		 */
		public function load_textdomain() {
			load_plugin_textdomain( 'nss', false, wp_basename( dirname( $this->get_main_file() ) ) . '/languages' );
		}

		/**
		 * Return constructor params.
		 *
		 * @return array
		 */
		public function get_constructor_params(): array {
			return $this->constructor_params;
		}

		/**
		 * @uses NSS_Main_Base::init_conditional_modules()
		 * @uses NSS_Main_Base::load_textdomain()
		 */
		protected function initialize() {
			$this
				->assign_constructors( $this->get_constructors() )
				->assign_modules( $this->get_modules() )
				->add_action( 'plugins_loaded', 'load_textdomain' )
			;

			// Add 'init_conditional_modules' method if exists.
			if ( method_exists( $this, 'init_conditional_modules' ) ) {
				$this->add_action( 'wp', 'init_conditional_modules' );
			}

			$this->extra_initialize();

			do_action( 'nss_initialized' );
		}

		protected function assign_constructors( array $constructors ): NSS_Main_Base {
			$this->constructor_params = $constructors;
			return $this;
		}

		/**
		 * Return root modules
		 *
		 * @return array
		 */
		abstract protected function get_modules(): array;

		/**
		 * Return constructor params
		 *
		 * @return array
		 */
		abstract protected function get_constructors(): array;

		/**
		 * Do NSS_Main specific initialization.
		 */
		abstract protected function extra_initialize(): void;
	}
}
