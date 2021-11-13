<?php
/**
 * NSS template: buttons
 *
 * This template is just an example to illustrate how to display share links.
 * HTML structure, action hooks are not mendatory. Override them whenever if you want.
 *
 * Context:
 *
 * @var array<string, string> $all_avail
 * @var array<string>         $available
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
							<?php echo esc_html( $all_avail[ $key ] ); ?>
                        </a>
                    </li>
				<?php endif; ?>
			<?php endforeach; ?>
        </ul>
		<?php do_action( 'nss_after_buttons_list' ); ?>
    </div>
	<?php do_action( 'nss_after_buttons_wrap' ); ?>
<?php endif; ?>
