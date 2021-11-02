<?php
/**
 * NSS: Settings page.
 *
 * Context:
 *
 * @var string $option_group
 */

/* ABSPATH check */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

<div class="wrap">
    <h1><?php _e( 'Naran Social Share Settings', 'nss' ); ?></h1>

	<?php do_action( 'nss_before_option_form' ); ?>

    <form method="post" action="<?php echo admin_url( 'options.php' ); ?>" novalidate>
		<?php
        settings_fields( $option_group );
		do_action( 'nss_after_settings_fields' );
        ?>

		<?php
        do_settings_sections( 'nss' );
        do_action( 'nss_after_do_settings_sections' );
        ?>

		<?php submit_button(); ?>
    </form>

    <?php do_action( 'nss_after_option_form' ); ?>
</div>
