<?php
/**
 * Blog entry standard format media
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WPSP_Blog
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Display media if thumbnail exists
if ( $thumbnail = wpsp_get_blog_entry_thumbnail() ) :

	// Overlay style
	$overlay = wpsp_get_redux( 'blog-entry-overlay' );
	$overlay = $overlay ? $overlay : 'none'; ?>

	<div class="blog-entry-media entry-media clear <?php echo wpsp_overlay_classes( $overlay ); ?>">

		<?php
		// Lightbox style entry
		if ( wpsp_get_redux( 'is-blog-entry-image-lightbox' ) ) : ?>

			<a href="<?php echo wpsp_post_thumbnail_url(); ?>" title="<?php echo esc_attr( the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark" class="blog-entry-media-link wpex-lightbox<?php wpsp_entry_image_animation_classes(); ?>" data-type="image">
				<?php echo $thumbnail; ?>
				<?php wpsp_overlay( 'inside_link', $overlay ); ?>
			</a><!-- .blog-entry-media-link -->
			<?php wpsp_overlay( 'outside_link', $overlay ); ?>

		<?php
		// Standard link to post
		else : ?>

			<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark" class="blog-entry-media-link<?php wpsp_entry_image_animation_classes(); ?>">
				<?php echo $thumbnail; ?>
				<?php wpsp_overlay( 'inside_link', $overlay ); ?>
			</a><!-- .blog-entry-media-link -->
			<?php wpsp_overlay( 'outside_link', $overlay ); ?>
			
		<?php endif; ?>

	</div><!-- .blog-entry-media -->

<?php endif; ?>