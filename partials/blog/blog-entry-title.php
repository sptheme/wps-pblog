<?php
/**
 * Blog entry avatar
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WPSP_Blog
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<header class="blog-entry-header clear">
	<h2 class="blog-entry-title entry-title">
		<a href="<?php wpsp_permalink(); ?>" title="<?php wpsp_esc_title(); ?>" rel="bookmark"><?php the_title(); ?></a>
	</h2><!-- .blog-entry-title -->
	<?php if ( wpsp_get_redux( 'blog-entry-author-avatar' ) ) : ?>
		<?php get_template_part( 'partials/blog/blog-entry-avatar' ); ?>
	<?php endif; ?>
</header><!-- .blog-entry-header -->