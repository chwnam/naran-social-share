<?php
/**
 * NSS: Option value wrapper
 */

/* ABSPATH check */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'NSS_Setup' ) ) {
	class NSS_Setup implements NSS_Module {
		private array $value;

		public function __construct() {
			if ( ! did_action( 'init' ) ) {
				wp_die( 'Use ' . __CLASS__ . ' after init hook.' );
			} else {
				$this->initialize();
			}
		}

		public function initialize() {
			$this->value = nss_option()->option->get_value();
		}

		public function is_enabled(): bool {
			return (bool) $this->get_value( 'enabled' );
		}

		public function get_available(): array {
			return (array) $this->get_value( 'available' );
		}

		public function get_width(): int {
			return (int) $this->get_value( 'width' );
		}

		public function get_height(): int {
			return (int) $this->get_value( 'height' );
		}

		public function get_priority(): int {
			return (int) $this->get_value( 'priority' );
		}

		public function get_concat(): string {
			return $this->get_value( 'concat' );
		}

		/**
		 * Return available post types
		 *
		 * @return array
		 */
		public function get_post_types(): array {
			return (array) $this->get_value( 'post_types' );
		}

		/**
		 * Return Post ID to exclude.
		 *
		 * @return int[]
		 */
		public function get_exclude(): array {
			return (array) $this->get_value( 'exclude' );
		}

		/**
		 * Is front.css forced to be enqueued and be printed out at the header?
		 *
		 * @return bool
		 */
		public function is_force_enqueue_style(): bool {
			return (bool) $this->get_value( 'force_enqueue_style' );
		}

		/**
		 * Return icon set.
		 *
		 * @return string
		 */
		public function get_icon_set(): string {
			$icon_set = $this->get_value( 'icon_set' );

			return empty( $icon_set ) ? 'default' : $icon_set;
		}

		public function get_kakao_api_key(): string {
			return (string) $this->get_value( 'kakao_api_key' );
		}

		private function get_value( string $key ) {
			if ( isset( $this->value[ $key ] ) ) {
				return $this->value[ $key ];
			} else {
				$default = self::get_default_value();

				return $default[ $key ] ?? null;
			}
		}

		public static function get_default_value(): array {
			return [
				// Enabled/disabled.
				'enabled'             => false,

				// Available services.
				'available'           => [],

				// Popup window width (px).
				'width'               => 640,

				// Popup window height (px).
				'height'              => 320,

				// 'the_content' filter priority.
				'priority'            => 10,

				// Concat: prepend, append.
				'concat'              => 'append',

				// Post types.
				'post_types'          => [],

				// exclude.
				'exclude'             => [],

				// Force enqueue style (at header).
				'force_enqueue_style' => false,

				// Icon sets.
				'icon_set'            => 'default',

				// Kakao API Key.
				'kakao_api_key'       => '',
			];
		}

		public static function sanitize(): array {
			$option_name = nss_option()->option->get_option_name();
			$output      = self::get_default_value();
			$default     = self::get_default_value();

			$output['enabled'] = filter_var(
				$_POST[ $option_name ]['enabled'] ?? $default['enabled'],
				FILTER_VALIDATE_BOOLEAN
			);

			$output['available'] = array_unique(
				array_filter(
					array_map(
						function ( string $item ) {
							return preg_replace( '/[^A-Za-z0-9]/', '', $item );
						},
						(array) ( $_POST[ $option_name ]['available'] ?? $default['available'] )
					)
				)
			);

			$output['width'] = intval(
				$_POST[ $option_name ]['width'] ?? $default['width']
			);

			$output['height'] = intval(
				$_POST[ $option_name ]['height'] ?? $default['height']
			);

			$output['priority'] = intval(
				$_POST[ $option_name ]['priority'] ?? $default['priority']
			);

			$output['concat'] = sanitize_key(
				$_POST[ $option_name ]['concat'] ?? $default['concat']
			);

			$output['post_types'] = array_unique(
				array_filter(
					array_map(
						'sanitize_key',
						(array) ( $_POST[ $option_name ]['post_types'] ?? [] )
					)
				)
			);

			$exclude = array_unique(
				array_filter(
					array_map(
						'absint',
						explode( "\r\n", sanitize_textarea_field( $_POST[ $option_name ]['exclude'] ?? '' ) )
					)
				)
			);
			sort( $exclude );
			$output['exclude'] = $exclude;

			$output['force_enqueue_style'] = filter_var(
				$_POST[ $option_name ]['force_enqueue_style'] ?? $default['force_enqueue_style'],
				FILTER_VALIDATE_BOOLEAN
			);

			$output['icon_set'] = sanitize_text_field( $_POST[ $option_name ]['icon_set'] ?? 'default' );

			$output['kakao_api_key'] = sanitize_text_field(
				$_POST[ $option_name ]['kakao_api_key'] ?? $default['kakao_api_key']
			);

			return $output;
		}
	}
}
