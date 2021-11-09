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
