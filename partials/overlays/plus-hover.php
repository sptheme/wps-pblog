<?php
/**
 * Plus Hover Overlay
 *
 * @package WPSP_Blog
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Only used for inside position
if ( 'inside_link' != $position ) {
	return;
} ?>

<span class="overlay-plus-hover overlay-hide theme-overlay"></span>