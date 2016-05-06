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

<header id="masthead" class="site-header <?php echo wpsp_header_classes(); ?>"<?php wpsp_schema_markup( 'header' ); ?> role="banner">
	<div id="site-header-inner" class="container clear">
		
		<?php get_template_part( 'partials/header/header-logo' ); ?>

		<nav id="site-navigation" class="main-navigation" role="navigation">
			<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'wpspblog' ); ?></button>
			<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu' ) ); ?>
		</nav><!-- #site-navigation -->

	</div> <!-- .container .clear -->
</header><!-- #masthead -->