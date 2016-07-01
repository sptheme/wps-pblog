<?php
/**
 * Mobile Icons Header Menu.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WPSP_Blog
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Menu Location
$menu_location = apply_filters( 'wpsp_main_menu_location', 'main_menu' );

// Display if menu is defined
if ( has_nav_menu( $menu_location ) ) : ?>

	<div id="wpsp-mobile-menu-fixed-top" class="clear wpsp-hidden">
		<div class="container clear">
			<a href="#mobile-menu" class="mobile-menu-toggle"><?php echo apply_filters( 'wpsp_mobile_menu_open_button_text', '<span class="fa fa-navicon"></span>' ); ?><span class="wpsp-text"><?php echo wpsp_get_redux( 'mobile-menu-toggle-text', esc_html__( 'Menu', 'wpsp-blog' ) ); ?></span></a>
		</div><!-- .container -->
	</div><!-- #mobile-menu -->

<?php endif; ?>