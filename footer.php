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
			<?php wpsp_hook_content_bottom(); ?>

		</div><!-- #content -->

		<?php wpsp_hook_content_after(); ?>

		<footer id="colophon" class="site-footer" role="contentinfo">
			<div class="site-info">
				<div class="container clear">
				<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'wpspblog' ) ); ?>"><?php printf( esc_html__( 'Proudly powered by %s', 'wpspblog' ), 'WordPress' ); ?></a>
				<span class="sep"> | </span>
				<?php printf( esc_html__( 'Theme: %1$s by %2$s.', 'wpspblog' ), 'wpspblog', '<a href="https://www.linkedin.com/in/sopheakpeas" rel="designer">Sopheak</a>' ); ?>
				</div> <!-- .container .clear -->
			</div><!-- .site-info -->
		</footer><!-- #colophon -->
		
		<?php wpsp_hook_wrap_bottom(); ?>

	</div> <!-- #wrap -->
	
	<?php wpsp_hook_wrap_after(); ?>

</div><!-- #page -->

<?php wpsp_outer_wrap_after(); ?>

<?php wp_footer(); ?>

</body>
</html>
