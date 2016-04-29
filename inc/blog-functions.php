<?php
/**
 * Helper functions for the blog
 *
 * These functions are used throughout the theme and must be loaded
 * early on.
 *
 * @package Habitat Cambodia
 */


/**
 * Displays the blog post thumbnail
 *
 * @since Total 1.0
 */
if ( ! function_exists( 'wpsp_blog_post_thumbnail' ) ) :
function wpsp_blog_post_thumbnail( $args = '' ) {
	echo wpsp_get_blog_post_thumbnail( $args );
}
endif;

/**
 * Returns the blog post thumbnail
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'wpsp_get_blog_post_thumbnail' ) ) :
function wpsp_get_blog_post_thumbnail( $args = '' ) {

	// If args isn't array then it's the attachment
	if ( ! is_array( $args ) && ! empty( $args ) ) {
		$args = array(
			'attachment'    => $args,
			'alt'           => wpsp_get_esc_title(),
			'width'         => '',
			'height'        => '',
			'class'         => '',
			'schema_markup' => false,
		);
	}

	// Defaults
	$defaults = array(
		'size'          => 'blog_post',
		'schema_markup' => true,
	);

	// Parse arguments
	$args = wp_parse_args( $args, $defaults );

	// Apply filter to args
	$args = apply_filters( 'wpsp_blog_entry_thumbnail_args', $args );

	// Generate thumbnail
	$thumbnail = wpsp_get_post_thumbnail( $args );

	// Apply filters for child theming
	return apply_filters( 'wpsp_blog_post_thumbnail', $thumbnail );

}
endif;

/**
 * Returns single blog post blocks
 *
 * @since 2.0.0
 * @return array
 */
if ( ! function_exists( 'wpsp_blog_single_meta_sections' ) ) :
function wpsp_blog_single_meta_sections() {

	// Default sections
	$sections = array( 'date' => 1, 'author' => 1, 'categories' => 1, 'comments' => 1 );

	// Get Sections from Customizer
	$sections = wpsp_get_redux( 'blog-post-meta-sections', $sections );

	// Apply filters for easy modification
	$sections = apply_filters( 'wpsp_blog_single_meta_sections', $sections );

	// Turn into array if string
	if ( $sections && ! is_array( $sections ) ) {
		$sections = explode( ',', $sections );
	}

	// Return sections
	return $sections;

}
endif;

/**
 * Returns single blog post blocks
 *
 * @since 1.0.0
 * @return array
 */
if ( ! function_exists( 'wpsp_blog_single_layout_blocks' ) ) :
function wpsp_blog_single_layout_blocks() {

	// Get layout blocks
	$blocks = wpsp_get_redux( 'blog-single-composer' );

	// If blocks are 100% empty return defaults
	$blocks = $blocks ? $blocks : 'featured_media,title,meta,post_series,the_content,post_tags,social_share,author_bio,related_posts,comments';

	// Convert blocks to array so we can loop through them
	if ( ! is_array( $blocks ) ) {
		$blocks = explode( ',', $blocks );
	}

	// Set block keys equal to vals
	$blocks = array_combine( $blocks, $blocks );

	// Apply filters to entry layout blocks
	$blocks = apply_filters( 'wpsp_blog_single_layout_blocks', $blocks );

	// Return blocks
	return $blocks;

}
endif;


/*-------------------------------------------------------------------------------*/
/* [ Taxonomy & Terms ]
/*-------------------------------------------------------------------------------*/
/**
 * Returns the "category" taxonomy for a given post type
 *
 * @since 2.0.0
 */
if ( ! function_exists( 'wpsp_get_post_type_cat_tax' ) ) :
function wpsp_get_post_type_cat_tax( $post_type = '' ) {

	// Get the post type
	$post_type = $post_type ? $post_type : get_post_type();

	// Return taxonomy
	if ( 'post' == $post_type ) {
		$tax = 'category';
	} elseif ( 'portfolio' == $post_type ) {
		$tax = 'portfolio_category';
	} elseif ( 'staff' == $post_type ) {
		$tax = 'staff_category';
	} elseif ( 'testimonials' == $post_type ) {
		$tax = 'testimonials_category';
	} elseif ( 'product' == $post_type ) {
		$tax = 'product_cat';
	} elseif ( 'tribe_events' == $post_type ) {
		$tax = 'tribe_events_cat';
	} elseif ( 'download' == $post_type ) {
		$tax = 'download_category';
	} else {
		$tax = false;
	}

	// Apply filters & return
	return apply_filters( 'wpex_get_post_type_cat_tax', $tax );

}
endif; 

/**
 * Check if a post has terms/categories
 *
 * This function is used for the next and previous posts so if a post is in a category it
 * will display next and previous posts from the same category.
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'wpsp_post_has_terms' ) ) :
	function wpsp_post_has_terms( $post_id = '', $post_type = '' ) {

		// Post data
		$post_id    = $post_id ? $post_id : get_the_ID();
		$post_type  = $post_type ? $post_type : get_post_type( $post_id );

		// Standard Posts
		if ( $post_type == 'post' ) {
			$terms = get_the_terms( $post_id, 'category');
			if ( $terms ) {
				return true;
			}
		}

		// Portfolio
		elseif ( 'portfolio' == $post_type ) {
			$terms = get_the_terms( $post_id, 'portfolio_category');
			if ( $terms ) {
				return true;
			}
		}

		// Staff
		elseif ( 'staff' == $post_type ) {
			$terms = get_the_terms( $post_id, 'staff_category');
			if ( $terms ) {
				return true;
			}
		}

		// Testimonials
		elseif ( 'testimonials' == $post_type ) {
			$terms = get_the_terms( $post_id, 'testimonials_category');
			if ( $terms ) {
				return true;
			}
		}

	}
endif;

/**
 * Check if term description should display above the loop.
 *
 * By default the term description displays in the subheading in the page header,
 * however, there are some built-in settings to enable the term description above the loop.
 * This function returns true if the term description should display above the loop and not in the header.
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'wpsp_has_term_description_above_loop' ) ) :
function wpsp_has_term_description_above_loop( $return = false ) {

	// Return true for tags and categories only
	if (  'above_loop' == wpsp_get_redux( 'category_description_position' )
		&& ( is_category() || is_tag() )
	) {
		$return = true;
	}

	// Apply filters
	$return = apply_filters( 'wpsp_has_term_description_above_loop', $return );

	// Return
	return $return;

}
endif;