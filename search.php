<?php
/**
 * The template for displaying Search Results pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WPSP_Blog
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
		<?php
		if ( have_posts() ) :

			if ( is_home() && ! is_front_page() ) : ?>
				<header>
					<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
				</header>

			<?php endif; ?>

			<div id="blog-entries" class="<?php wpsp_blog_wrap_classes(); ?>">

				<?php
				// Define counter for clearing floats
				$wpsp_count = 0;

				/* Start the Loop */
				while ( have_posts() ) : the_post();
					// Add to counter
					$wpsp_count++;

					/*
					 * Include the Post-Format-specific template for the content.
					 * If you want to override this in a child theme, then include a file
					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					 */
					get_template_part( 'partials/blog/blog-entry-layout' );

					if ( wpsp_blog_entry_columns() == $wpsp_count ) {
						$wpsp_count=0;
					}
				endwhile; ?>

				<?php
				// Display post pagination (next/prev - 1,2,3,4..)
				wpsp_blog_pagination(); ?>

			</div> <!-- #blog-entries -->

		<?php
		else :

			get_template_part( 'template-parts/content', 'none' );

		endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
