<?php
/**
 * NSS: Admin > settings > icon set.
 *
 * Context:
 *
 * @var array<string, string>                $all_avail key: identifier, value: label.
 * @var array<string, array<string, string>> $icon_sets key: identifier, value: icon array.
 * @var string                               $id        Form widget name.
 * @var string                               $name      Form widget name.
 * @var string                               $value     Selected value.
 */

/* ABSPATH check */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

<div id="nss-icon-set">
    <ul class="nss-widget-ul">
		<?php foreach ( $icon_sets as $icon => $sets ) : ?>
			<?php if ( ! empty( $sets ) ) : ?>
                <li>
                    <p class="nss-icon-radio-col">
                        <input id="<?php echo esc_attr( "$id-$icon" ) ?>"
                               type="radio"
                               name="<?php echo esc_attr( $name ); ?>"
                               value="<?php echo esc_attr( $icon ); ?>"
							<?php checked( $value, $icon ); ?>>
                        <label for="<?php echo esc_attr( "$id-$icon" ) ?>">
							<?php echo esc_html( ucfirst( $icon ) ); ?>
                        </label>
                    </p>
                    <ul class="nss-widget-ul nss-icons-row">
						<?php foreach ( $all_avail as $service => $label ) : ?>
							<?php $url = $sets[ $service ] ?? ''; ?>
                            <li>
								<?php if ( $url ) : ?>
                                    <div class="nss-icon-image-wrap">
                                        <img src="<?php echo esc_url( $url ); ?>"
                                             class="nss-icon-set"
                                             alt="<?php echo esc_attr( "$icon: $label" ); ?>">
                                    </div>
								<?php endif; ?>
                                <p><?php echo esc_html( $label ); ?></p>
                            </li>
						<?php endforeach; ?>
                    </ul>
                </li>
			<?php endif; ?>
		<?php endforeach; ?>
    </ul>
</div>
