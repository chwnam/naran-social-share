<?php
/**
 * NSS: Available widget template
 *
 * Context:
 *
 * @var string                $option_name Option name.
 * @var array<string, string> $available   All available services.
 * @var array<string>         $value       Active services.
 */

/* ABSPATH check */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

<ul class="nss-available-widget nss-widget-ul">
	<?php if ( ! empty ( $value ) ) : ?>
		<?php foreach ( $value as $item ) : ?>
			<?php if ( isset( $available[ $item ] ) ) : ?>
				<?php
				$id   = "$option_name-$item";
				$name = "{$option_name}[available][]"
				?>
                <li>
                    <input id="<?php echo esc_attr( $id ); ?>"
                           name="<?php echo esc_attr( $name ); ?>"
                           type="checkbox"
                           value="<?php echo esc_attr( $item ); ?>"
                           checked="checked">
                    <label for="<?php echo esc_attr( $id ); ?>">
						<?php echo esc_attr( $available[ $item ] ); ?>
                    </label>
                </li>
			<?php endif; ?>
		<?php endforeach; ?>
	<?php endif; ?>

	<?php foreach ( $available as $key => $label ) : ?>
		<?php if ( ! in_array( $key, $value ) ) : ?>
			<?php
			$id   = "$option_name-$key";
			$name = "{$option_name}[available][]"
			?>
            <li>
                <input id="<?php echo esc_attr( $id ); ?>"
                       name="<?php echo esc_attr( $name ); ?>"
                       type="checkbox"
                       value="<?php echo esc_attr( $key ); ?>"
					<?php checked( in_array( $key, $value ) ); ?> >
                <label for="<?php echo esc_attr( $id ); ?>"><?php echo esc_attr( $label ); ?></label>
            </li>
		<?php endif; ?>
	<?php endforeach; ?>
</ul>
<p class="description">
	<?php _e( 'Drag a checked item to rearrange output order from the front.', 'nss' ); ?>
</p>