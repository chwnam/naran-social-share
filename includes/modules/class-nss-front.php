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
					->enqueue_script( 'nss-front' )
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
		 * Prepent or append our share buttons to post content.
		 *
		 * @param string $content
		 *
		 * @return string
		 */
		public function content( string $content ): string {
			$buttons = $this->render(
				'buttons',
				[
					'all_avail' => nss_get_available_services(),
					'available' => nss_setup()->get_available()
				],
				'',
				false
			);

			$buttons = preg_replace( '/>\s+</', '><', $buttons );

			$concat = nss_setup()->get_concat();
			if ( 'prepend' === $concat ) {
				$content = $buttons . $content;
			} elseif ( 'append' === $concat ) {
				$content = $content . $buttons;
			}

			return $content;
		}

		/**
		 * Check if share buttons are avaiable.
		 *
		 * @return bool
		 */
		public function is_sharable(): bool {
			return apply_filters( 'nss_sharable', is_singular() );
		}
	}
}
