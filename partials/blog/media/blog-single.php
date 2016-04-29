<?php
/**
 * Blog single post standard format media
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WPSP_Blog
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} 

// Return if there isn't a thumbnail
if ( $thumbnail = wpsp_get_blog_post_thumbnail() ) : ?> ?>
	<div id="post-media" class="clear">
	<?php if ( wpsp_get_redux( 'is-featured-image-lightbox' )  ) { ?>
		<a href="<?php echo wp_get_attachment_url( get_post_thumbnail_id() ); ?>" title="<?php echo esc_attr( the_title_attribute( 'echo=0' ) ); ?>" data-type="image">
			<?php echo $thumbnail; ?>
		</a>
	<?php } else { ?>
		<?php echo $thumbnail; ?>
	<?php }	 ?>
	<?php
		// Blog entry caption
		if ( wpsp_get_redux( 'blog-thumbnail-caption' ) && $caption = wpsp_featured_image_caption() ) : ?>
		
			<div class="post-media-caption clear"><?php echo $caption; ?></div>

		<?php endif; ?>
	</div> <!-- #post-media -->
<?php endif; ?>

