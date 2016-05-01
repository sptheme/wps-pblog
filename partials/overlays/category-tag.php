<?php
/**
 * Category Tag
 *
 * @package WPSP_Blog
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Only used for outside position
if ( 'outside_link' != $position ) {
	return;
}

// Get category taxonomy for current post type
$taxonomy = wpsp_get_post_type_cat_tax();

// Get terms
if ( $taxonomy ) :

	// Get terms
	$terms = wp_get_post_terms( get_the_ID(), $taxonomy );

	// Display if we have terms
	if ( $terms ) : ?>

		<div class="overlay-category-tag theme-overlay clear">
			<?php
			// Loop through terms
			foreach ( $terms as $term ) : ?>
				<a href="<?php echo esc_url( get_term_link( $term->term_id, $taxonomy ) ); ?>" title="<?php echo esc_attr( $term->name ); ?>"><?php echo $term->name; ?></a>
			<?php endforeach; ?>
		</div>

	<?php endif; ?>

<?php endif; ?>