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

<ul class="nss-available-widget">
	<?php foreach ( $available as $key => $label ) : ?>
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
	<?php endforeach; ?>
</ul>
