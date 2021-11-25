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
			if ( nss_setup()->is_enabled() && $this->is_sharable() ) {
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
								'width'       => nss_setup()->get_width(),
								'height'      => nss_setup()->get_height(),
								'kakaoApiKey' => nss_setup()->get_kakao_api_key(),
								'shareParams' => $params,
							],
						]
					)
				;

				$this->add_filter( 'the_content', 'content', nss_setup()->get_priority() );
			}
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
			}

			$shareble = $singular && ! $shortcode_used && ! $excluded;

			return apply_filters( 'nss_sharable', $shareble );
		}

		/**
		 * Handle shortcode 'nss'.
		 *
		 * @callback
		 *
		 * @param array|string $atts
		 *
		 * @return string
		 * @see    NSS_Register_Shortcode::get_items()
		 */
		public function handle_shortcode( $atts ): string {
			return $this->render_buttons( $atts );
		}

		protected function render_buttons( array $args = [] ): string {
			$defaults = [
				'all_avail' => '',
				'available' => '',
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

			$buttons = $this->render( $args['template'], $args, $args['variant'] ?? '', false );

			return preg_replace( '/>\s+</', '><', $buttons );
		}
	}
}
