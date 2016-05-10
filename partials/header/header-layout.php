<?php
/**
 * Header layout
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WPSP_Blog
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<a class="skip-link screen-reader-text" href="#main"><?php esc_html_e( 'Skip to content', 'wpspblog' ); ?></a>

<header id="site-header" class="site-header <?php echo wpsp_header_classes(); ?>"<?php wpsp_schema_markup( 'header' ); ?> role="banner">
	<div id="site-header-inner" class="container clear">
		
		<?php 
		// insert site branding
		get_template_part( 'partials/header/header-logo' ); 

		// insert main navigation 
		get_template_part( 'partials/header/header-menu' ); ?>

	</div> <!-- .container .clear -->
</header><!-- #masthead -->