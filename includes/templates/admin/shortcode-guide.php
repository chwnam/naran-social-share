<?php
/**
 * NSS: Admin > NSS Settings > Shortcode template.
 *
 * Context:
 *
 * @var array<string, string> $all_avail
 */

/* ABSPATH check */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

<div id="nss-shortcode-guide">
    <p id="nss-sg-description" class="description">
		<?php _e( 'You can insert the shortcode \'nss\' manually in the content of any post types.', 'nss' ); ?>
		<?php _e( 'Configure your shortcode setup here.', 'nss' ); ?>
        <a href="#" id="nss-sg-toggle">[<?php _e( 'Toggle', 'nss' ); ?>]</a>
    </p>
    <div id="nss-sg-wrap" style="display: none;">
        <div id="nss-sg">[nss<span id="nss-sg-atts"></span>]</div>
        <p>
            <a id="nss-sg-copy" href="#"><?php _e( 'Copy shortcode', 'nss' ); ?></a>
        </p>
        <div id="nss-sg-setup-wrap">
            <h4><?php _e( 'Available services', 'nss' ); ?></h4>
            <ul id="nss-sg-services" class="nss-widget-ul">
				<?php foreach ( $all_avail as $service => $label ) : ?>
                    <li>
                        <input id="nss-service-<?php echo esc_attr( $service ); ?>"
                               value="<?php echo esc_attr( $service ); ?>"
                               autocomplete="off"
                               type="checkbox">
                        <label for="nss-service-<?php echo esc_attr( $service ); ?>"><?php
							echo esc_html( $label ) ?></label>
                    </li>
				<?php endforeach; ?>
            </ul>
            <p class="description">
				<?php _e( 'Drag a checked item to rearrange output order from the front.', 'nss' ); ?>
            </p>

            <h4><?php _e( 'Template', 'nss' ); ?></h4>
            <p>
                <label for="nss-sg-template"><?php _e( 'Template', 'nss' ); ?></label>
                <input id="nss-sg-template"
                       type="text"
                       autocomplete="off"
                       placeholder="<?php esc_attr_e( 'Template override.', 'nss' ); ?>">
            </p>
            <p>
                <label for="nss-sg-variant"><?php _e( 'Variant', 'nss' ); ?></label>
                <input id="nss-sg-variant"
                       type="text"
                       autocomplete="off"
                       placeholder="<?php esc_attr_e( 'Variant override.', 'nss' ); ?>">
            </p>
            <p class="description">
				<?php _e( 'Template and variant parameters are for those who want to develop new button templates.', 'nss' ); ?>
            </p>
        </div>
    </div>
</div>
