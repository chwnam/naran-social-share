<?php
/**
 * NSS Front module.
 */

/* ABSPATH check */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'NSS_Front' ) ) {
	class NSS_Front implements NSS_Module {
		use NSS_Hook_Impl;
		use NSS_Template_Impl;

		public function __construct() {
			$this->add_action( 'wp', 'initialize' );
		}

		/**
		 * Initialize our front.
		 */
		public function initialize() {
			if ( nss_setup()->is_force_enqueue_style() ) {
				$this->add_action( 'wp_enqueue_scripts', 'forcibly_enqueue_style' );
			}

			if ( nss_setup()->is_enabled() && $this->is_sharable() ) {
				$this
					->add_filter( 'the_content', 'content', nss_setup()->get_priority() )
					->prepare_scripts()
				;
			}
		}

		/**
		 * Forcibly enqueue front.css.
		 *
		 * Useful if you are using custom builder, and nss shortcodes are used in builder templates.
		 *
		 * @callback
		 * @action     wp_enqueue_scripts
		 *
		 * @return void
		 */
		public function forcibly_enqueue_style() {
			$this->enqueue_style( 'nss-front' );
		}

		/**
		 * Prepend or append our share buttons to post content.
		 *
		 * @param string $content
		 *
		 * @return string
		 */
		public function content( string $content ): string {
			$buttons = $this->render_buttons();
			$concat  = nss_setup()->get_concat();

			if ( 'prepend' === $concat ) {
				$content = $buttons . $content;
			} elseif ( 'append' === $concat ) {
				$content = $content . $buttons;
			}

			return $content;
		}

		/**
		 * Check if share buttons are available.
		 *
		 * @return bool
		 */
		public function is_sharable(): bool {
			$singular       = false;
			$shortcode_used = false;
			$excluded       = false;

			$setup      = nss_setup();
			$post_types = $setup->get_post_types();

			if ( $post_types ) {
				$singular       = is_singular( $post_types );
				$shortcode_used = $singular && ( $p = get_post() ) && has_shortcode( $p->post_content, 'nss' );
				$excluded       = $singular && in_array( get_the_ID(), $setup->get_exclude() );

				/**
				 * Filter $singular.
				 *
				 * @var bool $singular
				 */
				$singular = (bool) apply_filters( 'nss_sharable_singular', $singular );

				/**
				 * Filter $shortcode_used.
				 *
				 * @var bool $shortcode_used
				 */
				$shortcode_used = (bool) apply_filters( 'nss_sharable_shortcode_used', $shortcode_used );

				/**
				 * Filter $excluded
				 *
				 * @var bool $excluded
				 */
				$excluded = (bool) apply_filters( 'nss_sharable_excluded', $excluded );
			}

			$sharable = $singular && ! $shortcode_used && ! $excluded;

			return apply_filters( 'nss_sharable', $sharable );
		}

		/**
		 * Handle shortcode 'nss'.
		 *
		 * @callback
		 *
		 * @param array|string $atts An empty string when the shortcode is used without parameters.
		 *
		 * @return string
		 * @see    NSS_Register_Shortcode::get_items()
		 */
		public function handle_shortcode( $atts ): string {
			return $this->render_buttons( $atts ?: [] );
		}

		/**
		 * Enqueue style for shortcode 'nss'.
		 *
		 * @see    NSS_Register_Style::get_items()
		 * @see    NSS_Register_Shortcode::get_items()
		 */
		public function shortcode_enqueue_style() {
			$this->enqueue_style( 'nss-front' );
		}

		protected function prepare_scripts() {
			// Script enqueueing.
			if ( ! wp_script_is( 'nss-front' ) ) {
				$params = apply_filters( 'nss_share_params', [
					'title'     => get_the_title(),
					'thumbnail' => get_the_post_thumbnail_url() ?: '',
					'permalink' => get_the_permalink()
				] );

				$this
					->script( 'nss-front' )
					->enqueue()
					->localize(
						[
							'opts' => [
								'width'                 => nss_setup()->get_width(),
								'height'                => nss_setup()->get_height(),
								'kakaoApiKey'           => nss_setup()->get_kakao_api_key(),
								'shareParams'           => $params,
								'textCopiedToClipboard' => __( 'URL copied to clipboard.', 'nss' ),
								'textPermalinkIsEmpty'  => __( 'The permalink is empty.', 'nss' ),
								'textClipboardApiError' => __( 'Clipboard API Failed.', 'nss' ),
							],
						]
					)
				;
			}

			// Style enqueueing.
			if ( ! wp_style_is( 'nss-front' ) ) {
				$this
					->style( 'nss-front' )
					->enqueue()
				;
			}
		}

		protected function render_buttons( array $args = [] ): string {
			$defaults = [
				'all_avail' => '',
				'available' => '',
				'icon_set'  => '',
				'template'  => '',
				'variant'   => '',
			];

			$args = wp_parse_args( $args, $defaults );
			$args = apply_filters( 'nss_buttons_context', $args );

			// Check 'all_avail'.
			if ( empty( $args['all_avail'] ) ) {
				$args['all_avail'] = nss_get_available_services();
			}

			// Check 'available'.
			if ( empty( $args['available'] ) ) {
				$args['available'] = nss_setup()->get_available();
			}
			if ( is_string( $args['available'] ) ) {
				$args['available'] = array_unique(
					array_filter( array_map( 'trim', explode( ',', $args['available'] ) ) )
				);
			}

			// Check 'template'.
			if ( empty( $atts['template'] ) ) {
				$args['template'] = 'buttons';
			}

			// Check icon_set.
			if ( empty( $args['icon_set'] ) ) {
				$args['icon_set'] = nss_setup()->get_icon_set();
			}

			// Add icons.
			$icon_sets     = nss_get_icon_sets();
			$args['icons'] = $icon_sets[ $args['icon_set'] ] ?? $icon_sets['default'];

			$buttons = $this->render(
				$args['template'],
				$args,
				$args['variant'] ?? '',
				false
			);

			// Make sure that script/style are all enqueued anyway, even if style would be output in footer.
			$this->prepare_scripts();

			return preg_replace( '/>\s+</', '><', $buttons );
		}
	}
}
