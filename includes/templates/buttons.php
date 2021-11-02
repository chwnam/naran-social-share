<?php
/**
 * NSS template: buttons
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
    <div class="nss-buttons-wrap">
        <ul>
			<?php foreach ( $available as $key ) : ?>
				<?php if ( isset( $all_avail[ $key ] ) ) : ?>
                    <li>
                        <a href="javascript: void(0);"
                           data-nss="<?php echo esc_attr( $key ); ?>">
							<?php echo esc_attr( $all_avail[ $key ] ); ?>
                        </a>
                    </li>
				<?php endif; ?>
			<?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
