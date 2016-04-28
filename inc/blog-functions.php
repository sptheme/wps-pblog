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