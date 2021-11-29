<?php
/**
 * NSS: Post type widget template
 *
 * Context:
 *
 * @var array<string, string> $post_types  Public post types, type => label.
 * @var string                $option_name Option name.
 * @var array<string>         $value       Active services.
 */

/* ABSPATH check */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

<ul class="nss-post-types nss-widget-ul">
	<?php foreach ( $post_types as $post_type => $label ) : ?>
		<?php
		$id   = "$option_name-$post_type";
		$name = "{$option_name}[post_types][]"
		?>
        <li>
            <input id="<?php echo esc_attr( $id ); ?>"
                   name="<?php echo esc_attr( $name ); ?>"
                   type="checkbox"
                   value="<?php echo esc_attr( $post_type ); ?>"
				<?php checked( in_array( $post_type, $value ) ); ?> >
            <label for="<?php echo esc_attr( $id ); ?>"><?php echo esc_attr( $label ); ?></label>
        </li>
	<?php endforeach; ?>
</ul>
<p class="description">
	<?php _e( 'Choose items to display social share buttons on every single page of that post type.', 'nss' ); ?>
</p>