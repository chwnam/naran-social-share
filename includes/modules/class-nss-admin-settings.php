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
			$this
				->prepare_settings()
				->script( 'nss-admin-settings' )
				->enqueue()
				->localize(
					[
						'textCopyShortcode' => __( 'Copy shortcode', 'nss' ),
						'textCopied'        => __( 'Copied!', 'nss' ),
					]
				)
			;

			$this->render(
				'admin/settings',
				[ 'option_group' => nss_option()->option->get_option_group() ]
			);
		}

		private function prepare_settings(): self {
			$option_name = nss_option()->option->get_option_name();
			$setup       = nss_setup();

			// Section: General ////////////////////////////////////////////////////////////////////////////////////////
			add_settings_section(
				'nss-general',
				__( 'General', 'nss' ),
				'__return_empty_string',
				'nss'
			);

			// Enable/disable.
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

			// Available services.
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

			// Post types.
			add_settings_field(
				'nss-display-post-type',
				__( 'Post Types', 'nss' ),
				[ $this, 'render_post_types' ],
				'nss',
				'nss-general',
				[
					'name'  => $option_name,
					'value' => $setup->get_post_types(),
				]
			);

			// Exclude.
			add_settings_field(
				'nss-display-exclude',
				__( 'Exclude', 'nss' ),
				[ $this, 'render_textarea' ],
				'nss',
				'nss-general',
				[
					'id'          => "$option_name-exclude",
					'label_for'   => "$option_name-exclude",
					'name'        => "{$option_name}[exclude]",
					'value'       => implode( "\r\n", $setup->get_exclude() ),
					'attrs'       => [ 'rows' => 3 ],
					'description' => __( 'Social share buttons do not appear on posts in this list. Please enter post ID one by one row.', 'nss' ),
				]
			);

			// Section: Display ////////////////////////////////////////////////////////////////////////////////////////
			add_settings_section(
				'nss-display',
				__( 'Display', 'nss' ),
				'__return_empty_string',
				'nss'
			);

			add_settings_field(
				'nss-display-force-enqueue-style',
				__( 'Force enqueue style', 'nss' ),
				[ $this, 'render_checkbox' ],
				'nss',
				'nss-display',
				[
					'id'          => "$option_name-force-enqueue-style",
					'name'        => "{$option_name}[force_enqueue_style]",
					'value'       => $setup->is_force_enqueue_style(),
					'instruction' => __( 'Force style.css to be enqueued in header tags.', 'nss' ),
					'description' => __( 'If checked, style.css is always output in header tags. You may need this option if you are using [nss] shortcode in your custom builder.', 'nss' ),
				]
			);

			add_settings_field(
				'nss-popup-width',
				__( 'Popup Width', 'nss' ),
				[ $this, 'render_input' ],
				'nss',
				'nss-display',
				[
					'id'          => "$option_name-width",
					'label_for'   => "$option_name-width",
					'name'        => "{$option_name}[width]",
					'type'        => 'number',
					'value'       => $setup->get_width(),
					'placeholder' => __( 'Popup width, in pixel', 'nss' ),
					'attrs'       => [ 'min' => '0' ],
					'after'       => __( 'px', 'nss' ),
				]
			);

			add_settings_field(
				'nss-popup-height',
				__( 'Popup Height', 'nss' ),
				[ $this, 'render_input' ],
				'nss',
				'nss-display',
				[
					'id'          => "$option_name-height",
					'label_for'   => "$option_name-height",
					'name'        => "{$option_name}[height]",
					'type'        => 'number',
					'value'       => $setup->get_height(),
					'placeholder' => __( 'Popup width, in pixel', 'nss' ),
					'attrs'       => [ 'min' => '0' ],
					'after'       => __( 'px', 'nss' ),
				]
			);

			add_settings_field(
				'nss-priority',
				__( 'Priority', 'nss' ),
				[ $this, 'render_input' ],
				'nss',
				'nss-display',
				[
					'id'          => "$option_name-priority",
					'label_for'   => "$option_name-priority",
					'name'        => "{$option_name}[priority]",
					'type'        => 'number',
					'value'       => $setup->get_priority(),
					'description' => __( '\'the_content\' filter priority.', 'nss' ),
				]
			);

			add_settings_field(
				'nss-concat',
				__( 'Concatenation', 'nss' ),
				[ $this, 'render_select' ],
				'nss',
				'nss-display',
				[
					'id'        => "$option_name-concat",
					'label_for' => "$option_name-concat",
					'name'      => "{$option_name}[concat]",
					'value'     => $setup->get_concat(),
					'options'   => [
						'prepend' => __( 'Prepend', 'nss' ),
						'append'  => __( 'Append', 'nss' ),
					],
					'attrs'     => [],
				]
			);

			add_settings_field(
				'nss-display-icon-set',
				__( 'Icon Set', 'nss' ),
				[ $this, 'render_icon_set' ],
				'nss',
				'nss-display',
				[
					'id'    => "$option_name-icon-set",
					'name'  => "{$option_name}[icon_set]",
					'value' => $setup->get_icon_set(),
				]
			);

			add_settings_field(
				'nss-display-shortcode',
				__( 'Shortcode Guide', 'nss' ),
				[ $this, 'render_shortcode_guide' ],
				'nss',
				'nss-display'
			);

			// Section: Kakao API //////////////////////////////////////////////////////////////////////////////////////
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
					'description' => sprintf(
					/* translators: kakao developers URL. */
						__( 'Visit <a href="%1$s" target="_blank">Kakao developers</a> and get a JavaScript API key.', 'nss' ),
						'https://developers.kakao.com/console/app'
					),
				]
			);

			do_action( 'nss_prepare_settings' );

			return $this;
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

			NSS_HTML::input(
				[
					'id'      => $args['id'],
					'name'    => $args['name'],
					'type'    => 'checkbox',
					'value'   => 'yes',
					'checked' => $args['value'],
				]
			);

			NSS_HTML::tag_open( 'label', [ 'for' => $args['id'] ] );
			{
				echo esc_html( $args['instruction'] );
			}
			NSS_HTML::tag_close( 'label' );

			self::render_description( $args['description'] );
		}

		/**
		 * Render select widget
		 *
		 * @param array $args
		 */
		public function render_select( array $args ) {
			$args = wp_parse_args(
				$args,
				[
					'id'          => '',
					'name'        => '',
					'value'       => '',
					'options'     => [],
					'attrs'       => [],
					'description' => '',
				]
			);

			NSS_HTML::select(
				$args['options'],
				$args['value'],
				[
					'id'   => $args['id'],
					'name' => $args['name'],
					...$args['attrs'],
				]
			);


			self::render_description( $args['description'] );
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
					'attrs'       => [],
					'description' => '',
					'after'       => '',
				]
			);

			NSS_HTML::input(
				array_merge(
					[
						'id'          => $args['id'],
						'name'        => $args['name'],
						'type'        => $args['type'],
						'class'       => $args['class'],
						'value'       => $args['value'],
						'placeholder' => $args['placeholder'],
					],
					$args['attrs']
				)
			);

			if ( $args['after'] ) {
				echo esc_html( $args['after'] );
			}

			self::render_description( $args['description'] );
		}

		/**
		 * Render textarea
		 *
		 * @callback
		 *
		 * @param array $args
		 */
		public function render_textarea( array $args ) {
			$args = wp_parse_args(
				$args,
				[
					'id'          => '',
					'name'        => '',
					'value'       => '',
					'attrs'       => [],
					'description' => '',
				]
			);

			NSS_HTML::tag_open(
				'textarea',
				array_merge(
					[
						'id'   => $args['id'],
						'name' => $args['name'],
					],
					$args['attrs']
				)
			);
			{
				echo esc_textarea( $args['value'] );
			}
			NSS_HTML::tag_close( 'textarea' );

			self::render_description( $args['description'] );
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
				->enqueue_style( 'nss-admin-settings' )
				->render(
					'admin/available-widget',
					[
						'option_name' => $args['option_name'],
						'available'   => $args['available'],
						'value'       => $args['value'],
					]
				)
			;
		}

		/**
		 * Render 'post_types' custom widget.
		 *
		 * @param array $args
		 */
		public function render_post_types( array $args ) {
			$post_types = array_map(
				function ( $object ) { return $object->label; },
				get_post_types( [ 'public' => true ], 'objects' )
			);

			$this->render(
				'admin/post-type-widget',
				[
					'post_types'  => $post_types,
					'option_name' => $args['name'] ?? '',
					'value'       => $args['value'] ?? [],
				]
			);
		}

		/**
		 * Render 'shortcode_guide' custom widget.
		 */
		public function render_shortcode_guide() {
			$this->render( 'admin/shortcode-guide', [ 'all_avail' => nss_get_available_services() ] );
		}

		/**
		 * Render 'icon_set' custom widget.
		 */
		public function render_icon_set( array $args ) {
			$icon_sets = nss_get_icon_sets();
			$value     = $args['value'] ?? '';

			if ( empty( $value ) || ! isset( $icon_sets[ $value ] ) ) {
				$default = NSS_Setup::get_default_value();
				$value   = $default['icon_set'];
			}

			$this->render(
				'admin/icon-set',
				[
					'all_avail' => nss_get_available_services(),
					'icon_sets' => $icon_sets,
					'id'        => $args['id'] ?? '',
					'name'      => $args['name'] ?? '',
					'value'     => $value,
				]
			);
		}

		private static function render_description( string $description ) {
			if ( $description ) {
				$kses = [
					'a' => [
						'href'   => true,
						'target' => true,
					],
				];
				echo '<p class="description">' . wp_kses( $description, $kses ) . '</p>';
			}
		}
	}
}
