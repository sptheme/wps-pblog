<?php
/**
 * Setup theme hooks
 *
 * @package WPSP_Blog
 */

/**
 * Outer Wrap Hooks
 *
 * @since 1.0.0
 */
function wpsp_outer_wrap_before() {
	do_action( 'wpsp_outer_wrap_before' );
}
function wpsp_outer_wrap_after() {
	do_action( 'wpsp_outer_wrap_after' );
}


/**
 * Topbar Hooks
 *
 * @since 21.0.0
 */
function wpsp_hook_topbar_before() {
	do_action( 'wpsp_hook_topbar_before' );
}
function wpsp_hook_topbar_after() {
	do_action( 'wpsp_hook_topbar_after' );
}

/**
 * Wrap Hooks
 *
 * @since 1.0.0
 */
function wpsp_hook_wrap_before() {
	do_action( 'wpsp_hook_wrap_before' );
}
function wpsp_hook_wrap_top() {
	do_action( 'wpsp_hook_wrap_top' );
}
function wpsp_hook_wrap_bottom() {
	do_action( 'wpsp_hook_wrap_bottom' );
}
function wpsp_hook_wrap_after() {
	do_action( 'wpsp_hook_wrap_after' );
}

/**
 * Main Header Hooks
 *
 * @since 1.0.0
 */
function wpsp_hook_header_before() {
	do_action( 'wpsp_hook_header_before' );
}
function wpsp_hook_header_top() {
	do_action( 'wpsp_hook_header_top' );
}
function wpsp_hook_header_inner() {
	do_action( 'wpsp_hook_header_inner' );
}
function wpsp_hook_header_bottom() {
	do_action( 'wpsp_hook_header_bottom' );
}
function wpsp_hook_header_after() {
	do_action( 'wpsp_hook_header_after' );
}