<?php
/**
 * Header Menu Functions
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WPSP_Blog
 */

/**
 * Returns correct menu classes
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'wpsp_header_menu_classes' ) ) :
function wpsp_header_menu_classes( $return ) {

	// Define classes array
	$classes = array();

	// Get data
	$header_style = wpsp_get_redux( 'header-style' );
	$has_overlay  = wpsp_get_redux( 'has-overlay-header' );

	// Return wrapper classes
	if ( 'wrapper' == $return ) {

		// Add Header Style to wrapper
		$classes[] = 'navbar-style-'. $header_style;

		// Add the fixed-nav class if the fixed header option is enabled
		if ( wpsp_get_redux( 'is-fixed-header', true )
			&& ( 'two' == $header_style
				|| 'three' == $header_style
				|| 'four' == $header_style
			)
		) {
			$classes[] = 'fixed-nav';
		}

		// Dropdown dropshadow
		if ( 'one' == $header_style || 'five' == $header_style || $has_overlay ) {
			$classes[] = 'wpsp-dropdowns-caret';
		}

		// Flush Dropdowns
		if ( wpsp_get_redux( 'menu-flush-dropdowns' )
			&& 'one' == $header_style
			&& ! $has_overlay
		) {
			$classes[] = 'wpsp-flush-dropdowns';
		}

		// Dropdown dropshadow
		if ( $shadow = wpsp_get_redux( 'menu-dropdown-dropshadow' ) ) {
			$classes[] = 'wpsp-dropdowns-shadow-'. $shadow;
		}

		// Add special class if the dropdown top border option in the admin is enabled
		if ( wpsp_get_redux( 'menu-dropdown-top-border' ) ) {
			$classes[] = 'wpsp-dropdown-top-border';
		}

		// Add clearfix
		$classes[] = 'clear';

		// Set keys equal to vals
		$classes = array_combine( $classes, $classes );

		// Apply filters
		$classes = apply_filters( 'wpsp_header_menu_wrap_classes', $classes );

	}

	// Inner Classes
	elseif ( 'inner' == $return ) {

		// Core
		$classes[] = 'navigation';
		$classes[] = 'main-navigation';
		$classes[] = 'clear';

		// Add the container div for specific header styles
		if ( in_array( $header_style, array( 'two', 'three', 'four' ) ) ) {
			$classes[] = 'container';
		}

		// Set keys equal to vals
		$classes = array_combine( $classes, $classes );

		// Apply filters
		$classes = apply_filters( 'wpsp_header_menu_classes', $classes );

	}

	// Return
	if ( is_array( $classes ) ) {
		return implode( ' ', $classes );
	} else {
		return $return;
	}

}
endif;

/**
 * Custom menu walker
 *
 * @since 1.0.0
 */
if ( ! class_exists( 'WPSP_Dropdown_Walker_Nav_Menu' ) ) :
	class WPSP_Dropdown_Walker_Nav_Menu extends Walker_Nav_Menu {
		function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output ) {

			// Define vars
			$id_field     = $this->db_fields['id'];
			$header_style = wpsp_get_redux( 'header-style' );

			// Down Arrows
			if ( ! empty( $children_elements[$element->$id_field] ) && ( $depth == 0 ) ) {
				$element->classes[] = 'dropdown';
				if ( wpsp_get_redux( 'menu-arrow-down' ) ) {
					$arrow_class = 'six' == $header_style ? 'fa-chevron-right' : 'fa-angle-down';
					$element->title .= ' <span class="nav-arrow top-level fa '. $arrow_class .'"></span>';
				}
			}

			// Right/Left Arrows
			if ( ! empty( $children_elements[$element->$id_field] ) && ( $depth > 0 ) ) {
				$element->classes[] = 'dropdown';
				if ( wpsp_get_redux( 'menu-arrow-side', true ) ) {
					if ( is_rtl() ) {
						$element->title .= '<span class="nav-arrow second-level fa fa-angle-left"></span>';
					} else {
						$element->title .= '<span class="nav-arrow second-level fa fa-angle-right"></span>';
					}
				}
			}

			// Remove current menu item when using local-scroll class
			if ( in_array( 'local-scroll', $element->classes ) && in_array( 'current-menu-item', $element->classes ) ) {
				$key = array_search( 'current-menu-item', $element->classes );
				unset( $element->classes[$key] );
			}

			// Define walker
			Walker_Nav_Menu::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );

		}
	}
endif;

/**
 * Checks for custom menus.
 *
 * @since 1.0.0
 */
if ( ! class_exists( 'wpsp_custom_menu' ) ) :
function wpsp_custom_menu() {
	$menu = get_post_meta( wpsp_global_obj( 'post_id' ), 'wpsp_custom_menu', true );
	$menu = 'default' != $menu ? $menu : '';
	return apply_filters( 'wpsp_custom_menu', $menu );
}
endif;