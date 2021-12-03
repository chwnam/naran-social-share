<?php
/**
 * NSS: functions.php
 */

/* ABSPATH check skipped because of phpunit */

if ( ! function_exists( 'nss_get_available_services' ) ) {
	/**
	 * Get available social share services.
	 *
	 * @return array<string, string>
	 */
	function nss_get_available_services(): array {
		return apply_filters( 'nss_available_services', [
			'clipboard'  => __( 'Clipboard', 'nss' ),
			'facebook'   => __( 'Facebook', 'nss' ),
			'kakaoStory' => __( 'KakaoStory', 'nss' ),
			'kakaoTalk'  => __( 'KakaoTalk', 'nss' ),
			'line'       => __( 'Line', 'nss' ),
			'linkedIn'   => __( 'LinkedIn', 'nss' ),
			'naverBlog'  => __( 'Naver Blog', 'nss' ),
			'pinterest'  => __( 'Pinterest', 'nss' ),
			'pocket'     => __( 'Pocket', 'nss' ),
			'telegram'   => __( 'Telegram', 'nss' ),
			'twitter'    => __( 'Twitter', 'nss' ),
		] );
	}
}


if ( ! function_exists( 'nss_get_icon_sets' ) ) {
	/**
	 * Get icon sets.
	 *
	 * @return array<string, string>
	 */
	function nss_get_icon_sets(): array {
		$img_url = plugin_dir_url( nss()->get_main_file() ) . 'assets/img/';

		return apply_filters( 'nss_icon_sets', [
			'default' => [
				'clipboard'  => $img_url . 'share.png',
				'facebook'   => $img_url . 'facebook.png',
				'kakaoStory' => $img_url . 'kakao-story.png',
				'kakaoTalk'  => $img_url . 'kakao-talk.png',
				'line'       => $img_url . 'line.png',
				'linkedIn'   => $img_url . 'linked-in.png',
				'naverBlog'  => $img_url . 'naver-blog.png',
				'pinterest'  => $img_url . 'pinterest.png',
				'pocket'     => $img_url . 'pocket.png',
				'telegram'   => $img_url . 'telegram.png',
				'twitter'    => $img_url . 'twitter.png',
			],
		] );
	}
}


if ( ! function_exists( 'nss_setup' ) ) {
	/**
	 * Alias of nss()->setup
	 */
	function nss_setup(): NSS_Setup {
		return nss()->setup;
	}
}
