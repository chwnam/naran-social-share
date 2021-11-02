<?php
/**
 * NSS: Callback exception
 */

/* ABSPATH check */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'NSS_Callback_Exception' ) ) {
	class NSS_Callback_Exception extends Exception{
	}
}
