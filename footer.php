<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WPSP_Blog
 */

?>

		</div><!-- #content -->

		<footer id="colophon" class="site-footer" role="contentinfo">
			<div class="site-info">
				<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'wpspblog' ) ); ?>"><?php printf( esc_html__( 'Proudly powered by %s', 'wpspblog' ), 'WordPress' ); ?></a>
				<span class="sep"> | </span>
				<?php printf( esc_html__( 'Theme: %1$s by %2$s.', 'wpspblog' ), 'wpspblog', '<a href="https://www.linkedin.com/in/sopheakpeas" rel="designer">Sopheak</a>' ); ?>
			</div><!-- .site-info -->
		</footer><!-- #colophon -->
		
	</div> <!-- #wrap -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
