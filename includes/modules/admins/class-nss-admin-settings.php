<?php
/**
 * NSS: Admin settings module.
 */

/* ABSPATH check */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'NSS_Admin_Settings' ) ) {
	class NSS_Admin_Settings implements NSS_Admin_Module {
		use NSS_Hook_Impl;
		use NSS_Template_Impl;

		public function __construct() {
			$this->add_action( 'admin_menu', 'add_admin_menu' );
		}

		public function add_admin_menu() {
			add_options_page(
				__( 'Naran social share settings', 'nss' ),
				__( 'Naran Social Share', 'nss' ),
				'manage_options',
				'nss',
				[ $this, 'output_admin_menu' ]
			);
		}

		public function output_admin_menu() {
			$this->prepre_settings();

			$this->render(
				'admin/settings',
				[ 'option_group' => nss_option()->option->get_option_group() ]
			);
		}

		private function prepre_settings() {
			$option_name = nss_option()->option->get_option_name();
			$setup       = nss_setup();

			add_settings_section(
				'nss-general',
				__( 'General', 'nss' ),
				'__return_empty_string',
				'nss'
			);

			add_settings_field(
				'nss-enable',
				__( 'Enable/Disable', 'nss' ),
				[ $this, 'render_checkbox' ],
				'nss',
				'nss-general',
				[
					'id'          => "$option_name-enabled",
					'name'        => "{$option_name}[enabled]",
					'value'       => $setup->is_enabled(),
					'instruction' => __( 'Use social share', 'nss' ),
				]
			);

			add_settings_field(
				'nss-services',
				__( 'Available Services', 'nss' ),
				[ $this, 'render_available_widget' ],
				'nss',
				'nss-general',
				[
					'option_name' => $option_name,
					'available'   => nss_get_available_services(),
					'value'       => $setup->get_available(),
				]
			);

			add_settings_field(
				'nss-popup-width',
				__( 'Popup Width', 'nss' ),
				[ $this, 'render_input' ],
				'nss',
				'nss-general',
				[
					'id'          => "$option_name-width",
					'label_for'   => "$option_name-width",
					'name'        => "{$option_name}[width]",
					'type'        => 'number',
					'value'       => $setup->get_width(),
					'placeholder' => __( 'Popup width, in pixel', 'nss' ),
					'attrs'       => [ 'min' => '0' ],
				]
			);

			add_settings_field(
				'nss-popup-height',
				__( 'Popup Height', 'nss' ),
				[ $this, 'render_input' ],
				'nss',
				'nss-general',
				[
					'id'          => "$option_name-height",
					'label_for'   => "$option_name-height",
					'name'        => "{$option_name}[height]",
					'type'        => 'number',
					'value'       => $setup->get_height(),
					'placeholder' => __( 'Popup width, in pixel', 'nss' ),
					'attrs'       => [ 'min' => '0' ],
				]
			);

			add_settings_section(
				'nss-kakao',
				__( 'Kakao API', 'nss' ),
				'__return_empty_string',
				'nss'
			);

			add_settings_field(
				'nss-kakao-api-key',
				__( 'JavaScript API Key', 'nss' ),
				[ $this, 'render_input' ],
				'nss',
				'nss-kakao',
				[
					'id'          => "$option_name-kakao_api_key",
					'label_for'   => "$option_name-kakao_api_key",
					'name'        => "{$option_name}[kakao_api_key]",
					'type'        => 'text',
					'class'       => 'text long-text',
					'value'       => $setup->get_kakao_api_key(),
					'placeholder' => __( 'Kakao JavaScript API key.', 'nss' ),
					'attrs'       => [ 'autocomplete' => 'off' ],
				]
			);

			do_action( 'nss_prepare_settings' );
		}

		/**
		 * Render checkbox widget.
		 *
		 * @callback
		 *
		 * @param array $args
		 */
		public function render_checkbox( array $args ) {
			$args = wp_parse_args(
				$args,
				[
					'id'          => '',
					'name'        => '',
					'value'       => false,
					'instruction' => '',
					'description' => '',
				]
			);

			printf(
				'<input id="%s" name="%s" type="checkbox" value="yes" %s> ',
				esc_attr( $args['id'] ),
				esc_attr( $args['name'] ),
				checked( $args['value'], true, false ),
			);

			printf(
				'<label for="%s">%s</label> ',
				esc_attr( $args['id'] ),
				esc_html( $args['instruction'] )
			);

			if ( $args['description'] ) {
				$kses = [
					'a' => [ 'href' => true, 'target' => true ]
				];
				echo '<p class="description">' . wp_kses( $args['instruction'], $kses ) . '</p>';
			}
		}

		/**
		 * Render input widget
		 *
		 * @callback
		 *
		 * @param array $args
		 */
		public function render_input( array $args ) {
			$args = wp_parse_args(
				$args,
				[
					'id'          => '',
					'name'        => '',
					'type'        => '',
					'class'       => 'text',
					'value'       => '',
					'placeholder' => '',
					'attrs'       => '',
					'description' => '',
				]
			);

			if ( ! empty( $args['attrs'] ) ) {
				$buffer = [];
				foreach ( (array) $args['attrs'] as $key => $value ) {
					$key   = sanitize_key( $key );
					$value = esc_attr( $value );
					if ( $key ) {
						$buffer[] = "$key=\"$value\"";
					}
				}
				$args['attrs'] = implode( ' ', $buffer );
			}

			printf(
				'<input id="%s" name="%s" type="%s" class="%s" value="%s" placeholder="%s" %s> ',
				esc_attr( $args['id'] ),
				esc_attr( $args['name'] ),
				esc_attr( $args['type'] ),
				esc_attr( $args['class'] ),
				esc_attr( $args['value'] ),
				esc_attr( $args['placeholder'] ),
				$args['attrs']
			);

			if ( $args['description'] ) {
				$kses = [
					'a' => [ 'href' => true, 'target' => true ]
				];
				echo '<p class="description">' . wp_kses( $args['instruction'], $kses ) . '</p>';
			}
		}

		/**
		 * Render 'available' custom widget.
		 */
		public function render_available_widget( array $args ) {
			$args = wp_parse_args(
				$args,
				[
					'option_name' => '',
					'available'   => [],
					'value'       => [],
				]
			);

			$this
				->enqueue_style('nss-admin-settings')
				->render(
				'admin/available-widget',
				[
					'option_name' => $args['option_name'],
					'available'   => $args['available'],
					'value'       => $args['value'],
				]
			);
		}
	}
}
