<?php
/**
 * NSS: Main
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'NSS_Main' ) ) {
	/**
	 * Class NSS_Main
	 *
	 * @property-read NSS_Admin_Settings $admin_settings
	 * @property-read NSS_Front          $front
	 * @property-read NSS_Registers      $registers
	 * @property-read NSS_Setup          $setup
	 */
	final class NSS_Main extends NSS_Main_Base {
		protected function initialize() {
			parent::initialize();
			$this->add_filter( 'plugin_action_links_naran-social-share/index.php', 'add_plugin_action_links' );
		}

		protected function get_modules(): array {
			return [
				'admin_settings' => NSS_Admin_Settings::class,
				'front'          => NSS_Front::class,
				'registers'      => NSS_Registers::class,
				'setup'          => function () { return new NSS_Setup(); },
			];
		}

		public function add_plugin_action_links( array $actions ): array {
			return array_merge(
				[
					'settings' => sprintf(
					/* translators: %1$s: link to settings , %2$s: aria-label  , %3$s: text */
						'<a href="%1$s" id="nss-settings" aria-label="%2$s">%3$s</a>',
						admin_url( 'options-general.php?page=nss' ),
						esc_attr__( 'Naran social share settings', 'nss' ),
						esc_html__( 'Settings', 'nss' )
					)
				],
				$actions
			);
		}
	}
}
