<?php
/**
 * Helper awesome overlays for image hovers
 *
 * @package WPSP_Blog
 */

/**
 * Displays the Overlay HTML
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'wpsp_overlay' ) ) {
	function wpsp_overlay( $position = 'inside_link', $style = '', $args = array() ) {

		// If style is set to none lets bail
		if ( 'none' == $style ) {
			return;
		}

		// If style not defined get correct style based on theme_mods
		elseif ( ! $style ) {
			$style = wpsp_overlay_style();
		}

		// If style is defined lets locate and include the overlay template
		if ( $style ) {

			// Load the overlay template
			$overlays_dir = 'partials/overlays/';
			$template = $overlays_dir . $style .'.php';
			$template = locate_template( $template, false );

			// Only load template if it exists
			if ( $template ) {
				include( $template );
			}

		}

	}
}

/**
 * Create an array of overlay styles so they can be altered via child themes
 *
 * @since 1.0.0
 */
function wpsp_overlay_styles_array( $style = NULL ) {
	$array = array(
		''                              => esc_html__( 'None', 'wpspblog' ),
		'hover-button'                  => esc_html__( 'Hover Button', 'wpspblog' ),
		'magnifying-hover'              => esc_html__( 'Magnifying Glass Hover', 'wpspblog' ),
		'plus-hover'                    => esc_html__( 'Plus Icon Hover', 'wpspblog' ),
		'plus-two-hover'                => esc_html__( 'Plus Icon #2 Hover', 'wpspblog' ),
		'plus-three-hover'              => esc_html__( 'Plus Icon #3 Hover', 'wpspblog' ),
		'title-bottom'                  => esc_html__( 'Title Bottom', 'wpspblog' ),
		'title-bottom-see-through'      => esc_html__( 'Title Bottom See Through', 'wpspblog' ),
		'title-excerpt-hover'           => esc_html__( 'Title + Excerpt Hover', 'wpspblog' ),
		'title-category-hover'          => esc_html__( 'Title + Category Hover', 'wpspblog' ),
		'title-category-visible'        => esc_html__( 'Title + Category Visible', 'wpspblog' ),
		'title-date-hover'              => esc_html__( 'Title + Date Hover', 'wpspblog' ),
		'title-date-visible'            => esc_html__( 'Title + Date Visible', 'wpspblog' ),
		'slideup-title-white'           => esc_html__( 'Slide-Up Title White', 'wpspblog' ),
		'slideup-title-black'           => esc_html__( 'Slide-Up Title Black', 'wpspblog' ),
		'category-tag'                  => esc_html__( 'Category Tag', 'wpspblog' ),
	);
	return apply_filters( 'wpsp_overlay_styles_array', $array );
}

/**
 * Returns the overlay type depending on your theme options & post type
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'wpsp_overlay_style' ) ) {
	function wpsp_overlay_style( $style = '' ) {
		$style = $style ? $style : get_post_type();
		if ( 'portfolio' == $style ) {
			$style = wpsp_get_redux( 'portfolio-entry-overlay-style' );
		} elseif ( 'staff' == $style ) {
			$style = wpsp_get_redux( 'staff-entry-overlay-style' );
		}
		return apply_filters( 'wpsp_overlay_style', $style );
	}
}

/**
 * Returns the correct overlay Classname
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'wpsp_overlay_classes' ) ) {
	function wpsp_overlay_classes( $style = '' ) {

		// Return if style is none
		if ( 'none' == $style ) {
			return;
		}

		// Sanitize style
		$style = $style ? $style : wpsp_overlay_style();

		// Return classes
		if ( $style ) {
			return 'overlay-parent overlay-parent-'. $style;
		}
		
	}
}