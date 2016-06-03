<?php
/**
 * Portfolio single content
 *
 * @package WPSP_Blog
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<article class="entry clear"<?php wpsp_schema_markup( 'entry_content' ); ?>>
	<?php the_content(); ?>
</article><!-- .entry clr -->