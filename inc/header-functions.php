<?php
/**
 * Site Header Helper Functions
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WPSP_Blog
 */

/**
 * Returns page header overlay logo
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'wpsp_header_overlay_logo' ) ) :
function wpsp_header_overlay_logo() {

	// Return false if disabled
	if ( ! wpsp_get_redux( 'has-overlay-header' ) ) {
		return false;
	}

	// No custom overlay logo by default
	$logo = false;

	// Get logo via custom field
	$logo = wpsp_get_redux( 'custom-overlay-logo' );

	// Check old method
	if ( is_array( $logo ) ) {
		if ( ! empty( $logo['url'] ) ) {
			$logo = $logo['url'];
		} else {
			$logo = false;
		}
	}

	// Apply filters for child theming
	$logo = apply_filters( 'wpsp_header_overlay_logo', $logo );

	// If numeric logo is an attachment ID so lets get the URL
	if ( is_numeric( $logo ) ) {
		$logo = wp_get_attachment_image_src( $logo, 'full' );
		$logo = $logo[0];
	}

	// Return logo
	return esc_url( $logo );

}
endif;

/**
 * Add classes to the header wrap
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'wpsp_header_classes' ) ) :
function wpsp_header_classes() {

	// Vars
	$header_style = wpsp_get_redux( 'header-style' );

	// Setup classes array
	$classes = array();

	// Main header style
	$classes['header_style'] = 'header-'. $header_style;

	// Full width header
	if ( wpsp_get_redux( 'full-width-header' ) ) {
		$classes[] = 'wpsp-full-width';
	}

	// Sticky Header
	if ( wpsp_get_redux( 'has-fixed-header' ) && ( 'one' == $header_style || 'five' == $header_style ) ) {
		$classes['fixed_scroll'] = 'fixed-scroll';
		if ( wpsp_get_redux( 'is-shrink-fixed-header' ) ) {
			$classes['wpsp-shrink-sticky-header'] = 'wpsp-shrink-sticky-header';
		}	
	}

	// Reposition cart and search dropdowns
	if ( 'three' == $header_style || 'five' == $header_style ) {
		$classes[] = 'wpsp-reposition-cart-search-drops';
	}

	// Dropdown style (must be added here so we can target shop/search dropdowns)
	if ( $dropdown_style = wpsp_get_redux( 'menu_dropdown_style' ) ) {
		$classes['wpsp-dropdown-style-'. $dropdown_style] = 'wpsp-dropdown-style-'. $dropdown_style;
	}

	// Header Overlay Style
	if ( wpsp_get_redux( 'has-overlay-header', true ) ) {

		// Dark dropdowns for overlay header
		unset( $classes['wpsp-dropdown-style-'. $dropdown_style] );
		$classes[] = 'wpsp-dropdown-style-black';

		// Remove fixed scroll class
		if ( wpsp_get_redux( 'has-top-bar', true )  ) {
			//unset( $classes['fixed_scroll'] );
			//unset( $classes['wpsp-shrink-sticky-header'] );
		}

		// Add overlay header class
		$classes[] = 'overlay-header';

		// Add a fixed class for the overlay-header style only
		if ( wpsp_get_redux( 'has-fixed-header' ) ) {
			$classes[] = 'fix-overlay-header';
		}

		// Add overlay header class
		$classes[] = 'overlay-header';

		// Add overlay header style class
		$overlay_style = wpsp_get_redux( 'header-overlay-style' );
		$overlay_style = $overlay_style ? $overlay_style : 'light';
		$classes[] = $overlay_style .'-style';

	}


	// Clearfix class
	$classes[] = 'clear';

	// Set keys equal to vals
	$classes = array_combine( $classes, $classes );
	
	// Apply filters for child theming
	$classes = apply_filters( 'wpsp_header_classes', $classes );

	// Turn classes into space seperated string
	$classes = implode( ' ', $classes );

	// return classes
	return $classes;

}
endif;

/**
 * Returns header logo title
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'wpsp_header_logo_title' ) ) :
function wpsp_header_logo_title() {
	$title = get_bloginfo( 'name' );
	$title = apply_filters( 'wpsp_logo_title', $title );
	return $title;
}
endif;

/**
 * Returns header logo URL
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'wpsp_header_logo_url' ) ) :
function wpsp_header_logo_url() {
	$url = esc_url( home_url( '/' ) );
	$url = apply_filters( 'wpsp_logo_url', $url );
	return $url;
}
endif;