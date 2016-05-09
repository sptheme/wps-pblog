<?php
/**
 * Header Logo
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WPSP_Blog
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Define variables
$logo_url     = wpsp_header_logo_url();
$logo_img     = wpsp_get_redux( 'custom-logo' );
$overlay_logo = wpsp_header_overlay_logo(); 
$logo_title   = wpsp_header_logo_title(); ?>

<div id="site-logo" class="site-branding">
	<div id="site-logo-inner" class="site-logo-inner clear">
		<?php
		// Custom site-wide image logo
		if ( $logo_img && ! $overlay_logo ) : ?>
		
			<a href="<?php echo esc_url( $logo_url ); ?>" title="<?php echo esc_attr( $logo_title ); ?>" rel="home" class="main-logo">
				<img src="<?php echo esc_url( $logo_img['url'] ); ?>" alt="<?php echo esc_attr( $logo_title ); ?>" />
			</a>

		<?php endif; ?>

		<?php
		// Custom header-overlay logo
		if ( $overlay_logo ) : ?>

			<a href="<?php echo esc_url( $logo_url ); ?>" title="<?php echo esc_attr( $logo_title ); ?>" rel="home" class="overlay-header-logo">
				<img src="<?php echo esc_url( $overlay_logo ); ?>" alt="<?php echo esc_attr( $logo_title ); ?>" />
			</a>

		<?php endif; ?>
	</div> <!-- .site-logo-inner -->
</div><!-- .site-branding -->