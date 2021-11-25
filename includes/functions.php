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
			'facebook'  => __( 'Facebook', 'nss' ),
			'twitter'   => __( 'Twitter', 'nss' ),
			'linkedIn'  => __( 'LinkedIn', 'nss' ),
			'telegram'  => __( 'Telegram', 'nss' ),
			'kakaoTalk' => __( 'KakaoTalk', 'nss' ),
			'naverBlog' => __( 'Naver Blog', 'nss' ),
			'clipboard' => __( 'Clipboard', 'nss' ),
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
				'facebook'  => $img_url . 'facebook.png',
				'twitter'   => $img_url . 'twitter.png',
				'linkedIn'  => $img_url . 'linked-in.png',
				'telegram'  => $img_url . 'telegram.png',
				'kakaoTalk' => $img_url . 'kakao-talk.png',
				'naverBlog' => $img_url . 'naver-blog.png',
				'clipboard' => $img_url . 'share.png',
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
