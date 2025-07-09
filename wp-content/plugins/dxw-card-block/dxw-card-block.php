<?php
/**
 * Plugin Name:       Dxw Card Block
 * Description:       Example block scaffolded with Create Block tool.
 * Requires at least: 6.1
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            The WordPress Contributors
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       dxw/dxw-card-block
 * Update URI:        false
 *
 * @package           dxw
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */
function dxw_card_block_init() {
	register_block_type( __DIR__ . '/build', [
		'render_callback' => 'dxw_render_card_block'
	] );
}

add_action( 'init', 'dxw_card_block_init' );

function dxw_render_card_block($attributes, $content) {
	if ($attributes) {
		$selectedPost = (int) filter_var($attributes['selectedPost'], FILTER_SANITIZE_NUMBER_INT);
		$cardTypePost = $attributes['cardTypePost'];
		$headingLevel = $attributes['headingLevel'];
	}

	ob_start();
	
	?>
	<div <?php echo get_block_wrapper_attributes(); ?>>
		<?php if($cardTypePost) { ?>
			<<?php echo esc_attr($headingLevel); ?>><?php echo get_the_title($selectedPost); ?></<?php echo esc_attr($headingLevel); ?>>
			<?php if (get_the_post_thumbnail($selectedPost)) {
				echo get_the_post_thumbnail($selectedPost, 'medium');
				} else {
					var_dump( get_the_post_thumbnail($selectedPost));
				} ?>
			<p><?php echo get_the_excerpt($selectedPost); ?></p>
		<?php }
			else {
				echo $content;
			}
		?>
	</div>
	<?php
	return ob_get_clean();
}

