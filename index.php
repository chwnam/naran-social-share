<?php
/**
 * Plugin Name:       Naran Social Share
 * Plugin URI:        https://github.com/chwnam/naran-social-share
 * Description:       Share your posts to social media, and so on.
 * Version:           0.4.3
 * Requires at least: 4.4.0
 * Requires PHP:      7.4
 * Author:            changwoo
 * Author URI:        https://blog.changwoo.pe.kr/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       nss
 * Domain Path:       /languages
 * CPBN version:      1.3.1
 */

/* ABSPATH check */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once __DIR__ . '/vendor/autoload.php';

const NSS_MAIN_FILE = __FILE__;
const NSS_VERSION   = '0.4.3';
const NSS_PRIORITY = 885;

nss();
