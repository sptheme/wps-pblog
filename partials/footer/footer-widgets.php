<?php
/**
 * Footer bottom widgets
 *
 * @package WPSP_Blog
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Get footer widgets columns
$columns    = wpsp_get_redux( 'footer-widgets-columns', '4' );
$grid_class = wpsp_grid_class( $columns );
$gap        = wpsp_get_redux( 'footer-widgets-gap', '30' );

// Classes
$wrap_classes = array( 'clear' );
if ( '1' == $columns ) {
	$wrap_classes[] = 'single-col-footer';
} 
if ( $gap ) {
	$wrap_classes[] = 'gap-'. $gap;
}
$wrap_classes = implode( ' ', $wrap_classes ); ?>

<div id="footer-widgets" class="wpsp-row <?php echo esc_attr( $wrap_classes ); ?>">

	<?php
	// Footer box 1 ?>
	<div class="footer-box <?php echo esc_attr( $grid_class ); ?> col col-1">
		<?php dynamic_sidebar( 'footer_one' ); ?>
	</div><!-- .footer-one-box -->

	<?php
	// Footer box 2
	if ( $columns > '1' ) : ?>
		<div class="footer-box <?php echo esc_attr( $grid_class ); ?> col col-2">
			<?php dynamic_sidebar( 'footer_two' ); ?>
		</div><!-- .footer-one-box -->
	<?php endif; ?>
	
	<?php
	// Footer box 3
	if ( $columns > '2' ) : ?>
		<div class="footer-box <?php echo esc_attr( $grid_class ); ?> col col-3 ">
			<?php dynamic_sidebar( 'footer_three' ); ?>
		</div><!-- .footer-one-box -->
	<?php endif; ?>

	<?php
	// Footer box 4
	if ( $columns > '3' ) : ?>
		<div class="footer-box <?php echo esc_attr( $grid_class ); ?> col col-4">
			<?php dynamic_sidebar( 'footer_four' ); ?>
		</div><!-- .footer-box -->
	<?php endif; ?>

	<?php
	// Footer box 5
	if ( $columns > '4' ) : ?>
		<div class="footer-box <?php echo esc_attr( $grid_class ); ?> col col-5">
			<?php dynamic_sidebar( 'footer_five' ); ?>
		</div><!-- .footer-box -->
	<?php endif; ?>

</div><!-- #footer-widgets -->