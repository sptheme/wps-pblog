<?php
/**
 * Useful global functions for the portfolio
 *
 * @package WPSP_Blog
 */

/**
 * Checks if on a theme portfolio category page.
 *
 * @since 1.1.0
 */
if ( ! function_exists( 'wpsp_is_portfolio_tax' ) ) {
	function wpsp_is_portfolio_tax() {
		if ( ! is_search() && ( is_tax( 'portfolio_category' ) || is_tax( 'portfolio_tag' ) ) ) {
			return true;
		} else {
			return false;
		}
	}
}

/**
 * Returns correct thumbnail HTML for the portfolio entries
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'wpsp_get_portfolio_entry_thumbnail' ) ) {
	function wpsp_get_portfolio_entry_thumbnail( $loop = 'archive' ) {
		$size = 'archive' === $loop ? 'portfolio_entry' : 'portfolio_related';
		return wpsp_get_post_thumbnail( apply_filters( 'wpsp_get_portfolio_entry_thumbnail_args', array(
			'size'  => $size,
			'class' => 'portfolio-entry-img',
			'alt'   => wpsp_get_esc_title(),
		) ) );
	}
}

/**
 * Returns portfolio featured video url
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'wpsp_get_portfolio_featured_video_url' ) ) {
	function wpsp_get_portfolio_featured_video_url( $post_id = '') {
		if ( function_exists( 'wpsp_post_video' ) ) {
			return wpsp_get_post_video( $post_id );
		}
	}
}

/**
 * Displays the portfolio featured video
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'wpsp_portfolio_post_video' ) ) {
	function wpsp_portfolio_post_video( $post_id = '', $video = false ) {
		echo wpsp_get_portfolio_post_video();
	}
}

/**
 * Displays the portfolio featured video
 *
 * @since 1.0.0
 */
function wpsp_get_portfolio_post_video() {

	// Get video URl
	$video = wpsp_get_post_video_html();

	// Return if no video
	if ( empty( $video ) ) {
		return;
	}

	// Return video
	return '<div class="portfolio-featured-video clear">'. $video .'</div>';

}

/**
 * Returns correct classes for the portfolio grid
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'wpsp_portfolio_column_class' ) ) {
	function wpsp_portfolio_column_class( $query ) {
		if ( 'related' == $query ) {
			$columns = wpsp_get_redux( 'portfolio-related-columns', '4' );
		} else {
			$columns = wpsp_get_redux( 'portfolio-entry-columns', '4' );
		}
		return wpsp_grid_class( $columns );
	}
}

/**
 * Returns portfolio archive columns
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'wpsp_portfolio_archive_columns' ) ) {
	function wpsp_portfolio_archive_columns() {
		return wpsp_get_redux( 'portfolio-entry-columns', '4' );
	}
}

/**
 * Returns correct classes for the portfolio wrap
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'wpsp_get_portfolio_wrap_classes' ) ) {
	function wpsp_get_portfolio_wrap_classes() {

		// Get grid style
		$grid_style = wpsp_get_redux( 'portfolio-archive-grid-style' ) ? wpsp_get_redux( 'portfolio-archive-grid-style' ) : 'fit-rows';

		// Add default classes
		$classes = array( 'wpsp-row', 'clear' );

		// Add grid style class
		$classes[] = 'portfolio-'. $grid_style;

		// Add equal height class
		$classes[] = wpsp_portfolio_match_height() ? 'match-height-grid' : '';

		// Apply filters
		$classes  = apply_filters( 'wpsp_portfolio_wrap_classes', $classes );

		// Turn into string
		$classes = implode( " ",$classes );

		// Return classes
		return $classes;

	}
}

/**
 * Checks if match heights are enabled for the portfolio
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'wpsp_portfolio_match_height' ) ) {
	function wpsp_portfolio_match_height() {
		$grid_style = wpsp_get_redux( 'portfolio-archive-grid-style', 'fit-rows' ) ? wpsp_get_redux( 'portfolio-archive-grid-style', 'fit-rows' ) : 'fit-rows';
		$columns    = wpsp_get_redux( 'portfolio-entry-columns', '3' ) ? wpsp_get_redux( 'portfolio-entry-columns', '3' ) : '3';
		if ( 'fit-rows' == $grid_style && wpsp_get_redux( 'portfolio-archive-grid-equal-heights' ) && $columns > '1' ) {
			return true;
		} else {
			return false;
		}
	}
}