<?php
/**
 * NSS: functions.php
 */

/* Skip ABSPATH check for unit testing. */

if ( ! function_exists( 'nss' ) ) {
	/**
	 * NSS_Main alias.
	 *
	 * @return NSS_Main
	 */
	function nss(): NSS_Main {
		return NSS_Main::get_instance();
	}
}


if ( ! function_exists( 'nss_parse_module' ) ) {
	/**
	 * Retrieve submodule by given string notation.
	 *
	 * @param string $module_notation
	 *
	 * @return object|false;
	 */
	function nss_parse_module( string $module_notation ) {
		return nss()->get_module_by_notation( $module_notation );
	}
}


if ( ! function_exists( 'nss_parse_callback' ) ) {
	/**
	 * Return submodule's callback method by given string notation.
	 *
	 * @param Closure|array|string $maybe_callback
	 *
	 * @return callable|array|string
	 * @throws NSS_Callback_Exception
	 * @example foo.bar@baz ---> array( nss()->foo->bar, 'baz )
	 */
	function nss_parse_callback( $maybe_callback ) {
		return nss()->parse_callback( $maybe_callback );
	}
}


if ( ! function_exists( 'nss_option' ) ) {
	/**
	 * Alias function for option.
	 *
	 * @return NSS_Register_Option|null
	 */
	function nss_option(): ?NSS_Register_Option {
		return nss()->registers->option;
	}
}


if ( ! function_exists( 'nss_comment_meta' ) ) {
	/**
	 * Alias function for comment meta.
	 *
	 * @return NSS_Register_Comment_Meta|null
	 */
	function nss_comment_meta(): ?NSS_Register_Comment_Meta {
		return nss()->registers->comment_meta;
	}
}


if ( ! function_exists( 'nss_post_meta' ) ) {
	/**
	 * Alias function for post meta.
	 *
	 * @return NSS_Register_Post_Meta|null
	 */
	function nss_post_meta(): ?NSS_Register_Post_Meta {
		return nss()->registers->post_meta;
	}
}


if ( ! function_exists( 'nss_term_meta' ) ) {
	/**
	 * Alias function for term meta.
	 *
	 * @return NSS_Register_Term_Meta|null
	 */
	function nss_term_meta(): ?NSS_Register_Term_Meta {
		return nss()->registers->term_meta;
	}
}


if ( ! function_exists( 'nss_user_meta' ) ) {
	/**
	 * Alias function for user meta.
	 *
	 * @return NSS_Register_User_Meta|null
	 */
	function nss_user_meta(): ?NSS_Register_User_Meta {
		return nss()->registers->user_meta;
	}
}


if ( ! function_exists( 'nss_script_debug' ) ) {
	/**
	 * Return SCRIPT_DEBUG.
	 *
	 * @return bool
	 */
	function nss_script_debug(): bool {
		return apply_filters( 'nss_script_debug', defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG );
	}
}


if ( ! function_exists( 'nss_format_callback' ) ) {
	/**
	 * Format callback method or function.
	 *
	 * This method does not care about $callable is actually callable.
	 *
	 * @param Closure|array|string $callback
	 *
	 * @return string
	 */
	function nss_format_callback( $callback ): string {
		if ( is_string( $callback ) ) {
			return $callback;
		} elseif (
			( is_array( $callback ) && 2 === count( $callback ) ) &&
			( is_object( $callback[0] ) || is_string( $callback[0] ) ) &&
			is_string( $callback[1] )
		) {
			if ( method_exists( $callback[0], $callback[1] ) ) {
				try {
					$ref = new ReflectionClass( $callback[0] );
					if ( $ref->isAnonymous() ) {
						return "{AnonymousClass}::$callback[1]";
					}
				} catch ( ReflectionException $e ) {
				}
			}

			if ( is_string( $callback[0] ) ) {
				return "$callback[0]::$callback[1]";
			} elseif ( is_object( $callback[0] ) ) {
				return get_class( $callback[0] ) . '::' . $callback[1];
			}
		} elseif ( $callback instanceof Closure ) {
			return '{Closure}';
		}

		return '{Unknown}';
	}
}
