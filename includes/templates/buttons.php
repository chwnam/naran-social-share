<?php
/**
 * NSS template: buttons
 *
 * This template is just an example to illustrate how to display share links.
 * HTML structure, action hooks are not mendatory. Override them whenever if you want.
 *
 * Context:
 *
 * @var array<string, string> $all_avail Key: service identifier, value: service string.
 * @var array<string>         $available Keys of service to be displayed.
 * @var string                $icon_set  The current icon set.
 * @var string                $template  The template name.
 * @var string                $variant   The template variant.
 * @var array<string, string> $icons     Key: service identifier, value: URL to image.
 *
 * @see nss_get_available_services() for $all_avail.
 */

/* ABSPATH check */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

<?php if ( ! empty( $available ) ) : ?>

	<?php do_action( 'nss_before_buttons_wrap' ); ?>

    <div class="nss nss-buttons-wrap">

		<?php do_action( 'nss_before_buttons_list' ); ?>

        <ul class="nss nss-buttons-list">
			<?php foreach ( $available as $key ) : ?>
				<?php if ( isset( $all_avail[ $key ] ) ) : ?>
                    <li class="nss nss-button-item nss-button-item-<?php echo esc_attr( $key ); ?>">
                        <a href="javascript: void(0);"
                           aria-label="<?php
						   if ( 'clipboard' === $key ) {
							   printf(
							   /* translators: clipboard label. */
								   __( 'Copy  this page\'s URL to %s.', 'nss' ), $all_avail[ $key ] );
						   } else {
							   printf(
							   /* translators: available media label. */
								   __( 'Share this page\'s URL to %s.', 'nss' ), $all_avail[ $key ] );
						   } ?>"
                           data-nss="<?php echo esc_attr( $key ); ?>"
                           data-nss-label="<?php echo esc_attr( $all_avail[ $key ] ); ?>">

							<?php if ( isset( $icons[ $key ] ) ) : ?>
                                <div class="nss-icon-wrap">
                                    <img class="nss-icon"
                                         src="<?php echo esc_url( $icons[ $key ] ); ?>"
                                         alt="<?php
									     printf(
									     /* translators: service name. */
										     __( '%s icon', 'nss' ),
										     $all_avail[ $key ]
									     );
									     ?>">
                                </div>
							<?php endif; ?>

                            <span class="nss-service-name nss-service-name-<?php echo esc_attr( $key ); ?>"><?php
								echo esc_html( $all_avail[ $key ] ); ?></span>
                        </a>
                    </li>
				<?php endif; ?>
			<?php endforeach; ?>
        </ul>

		<?php do_action( 'nss_after_buttons_list' ); ?>

    </div>

	<?php do_action( 'nss_after_buttons_wrap' ); ?>
<?php endif; ?>
