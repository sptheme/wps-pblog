<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WPSP_Blog
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} 

// Get single blog layout blocks
$post_format       = get_post_format();
$password_required = post_password_required(); ?>

<article class="single-blog-article clear"<?php wpsp_schema_markup( 'blog_post' ); ?>>
	<?php // Loop through post detail
		get_template_part( 'partials/blog/blog-single-title' );
		get_template_part( 'partials/blog/blog-single-meta' );
		if ( ! $password_required && ! get_post_meta( get_the_ID(), 'wpsp_post_media_position', true ) ) {

			$post_format = $post_format ? $post_format : 'thumbnail';
			
			get_template_part( 'partials/blog/media/blog-single', $post_format );

		}
		get_template_part( 'partials/blog/blog-single-content' );
		get_template_part( 'partials/blog/blog-single-tags' );
		get_template_part( 'partials/social-share' );
		get_template_part( 'author-bio' );
		get_template_part( 'partials/blog/blog-single-related' );
	?>
</article>