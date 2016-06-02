<?php
/**
 * Adds custom metaboxes to the WordPress categories
 *
 * @package WPSP_Blog
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Start Class
if ( ! class_exists( 'WPSP_Category_Meta' ) ) {
	
	class WPSP_Category_Meta {

		/**
		 * Main constructor
		 *
		 * @access public
		 * @since  1.0.0
		 */
		public function __construct() {
			add_action ( 'edit_category_form_fields', array( $this, 'edit_category_form_fields' ) );
			add_action ( 'edited_category', array( $this, 'edited_category' ) );
		}

		/**
		 * Adds new category fields
		 *
		 * @access public
		 * @since  1.0.0
		 */
		public function edit_category_form_fields( $tag ) {

			// Get term id
			$tag_id    = $tag->term_id;
			$term_meta = get_option( "category_$tag_id");

			// Layout
			$layout = ! empty( $term_meta['wpsp_term_layout'] ) ? $term_meta['wpsp_term_layout'] : '' ; ?>
			<tr class="form-field wpsp_term_layout">
			<th scope="row" valign="top"><label for="wpsp_term_layout"><?php esc_html_e( 'Layout', 'wpsp-admin' ); ?></label></th>
			<td>
				<select name="term_meta[wpsp_term_layout]">
					<option value="" <?php selected( $layout ) ?>><?php esc_html_e( 'Default', 'wpsp-admin' ); ?></option>
					<option value="right-sidebar" <?php selected( $layout, 'right-sidebar' ) ?>><?php esc_html_e( 'Right Sidebar', 'wpsp-admin' ); ?></option>
					<option value="left-sidebar" <?php selected( $layout, 'left-sidebar' ) ?>><?php esc_html_e( 'Left Sidebar', 'wpsp-admin' ); ?></option>
					<option value="full-width" <?php selected( $layout, 'full-width' ) ?>><?php esc_html_e( 'Full Width', 'wpsp-admin' ); ?></option>
				</select>
			</td>
			</tr>

			<?php
			// Style
			$style = ! empty( $term_meta['wpsp_term_style'] ) ? $term_meta['wpsp_term_style'] : '' ; ?>
			<tr class="form-field wpsp_term_style">
			<th scope="row" valign="top"><label for="wpsp_term_style"><?php esc_html_e( 'Style', 'wpsp-admin' ); ?></label></th>
			<td>
				<select name="term_meta[wpsp_term_style]">
					<option value="" <?php selected( $style ); ?>><?php esc_html_e( 'Default', 'wpsp-admin' ); ?></option>
					<option value="large-image" <?php selected( $style, 'large-image' ); ?>><?php esc_html_e( 'Large Image', 'wpsp-admin' ); ?></option>
					<option value="thumbnail" <?php selected( $style, 'thumbnail' ); ?>><?php esc_html_e( 'Thumbnail', 'wpsp-admin' ); ?></option>
					<option value="grid" <?php selected( $style, 'grid' ); ?>><?php esc_html_e( 'Grid', 'wpsp-admin' ); ?></option>
				</select>
			</td>
			</tr>
			
			<?php
			// Grid Columns
			$grid_cols = ! empty( $term_meta['wpsp_term_grid_cols'] ) ? $term_meta['wpsp_term_grid_cols'] : ''; ?>
			<tr class="form-field wpsp_term_grid_cols"<?php if ( 'grid' != $style ) echo ' style="display:none;"'; ?>>
			<th scope="row" valign="top"><label for="wpsp_term_grid_cols"><?php esc_html_e( 'Grid Columns', 'wpsp-admin' ); ?></label></th>
			<td>
				<select name="term_meta[wpsp_term_grid_cols]">
					<option value=""  <?php selected( $grid_cols ); ?>><?php esc_html_e( 'Default', 'wpsp-admin' ); ?></option>
					<option value="6" <?php selected( $grid_cols, 6 ) ?>>6</option>
					<option value="5" <?php selected( $grid_cols, 5 ) ?>>5</option>
					<option value="4" <?php selected( $grid_cols, 4 ) ?>>4</option>
					<option value="3" <?php selected( $grid_cols, 3 ) ?>>3</option>
					<option value="2" <?php selected( $grid_cols, 2 ) ?>>2</option>
					<option value="1" <?php selected( $grid_cols, 1 ) ?>>1</option>
				</select>
			</td>
			</tr>

			<?php
			// Grid Style
			$grid_style = ! empty( $term_meta['wpsp_term_grid_style'] ) ? $term_meta['wpsp_term_grid_style'] : '' ; ?>
			<tr class="form-field wpsp_term_grid_style"<?php if ( 'grid' != $style ) echo ' style="display:none;"'; ?>>
			<th scope="row" valign="top"><label for="wpsp_term_grid_style"><?php esc_html_e( 'Grid Style', 'wpsp-admin' ); ?></label></th>
			<td>
				<select name="term_meta[wpsp_term_grid_style]">
					<option value="" <?php selected( $grid_style ) ?>><?php esc_html_e( 'Default', 'wpsp-admin' ); ?></option>
					<option value="fit-rows" <?php selected( $grid_style, 'fit-rows' ) ?>><?php esc_html_e( 'Fit Rows', 'wpsp-admin' ); ?></option>
					<option value="masonry" <?php selected( $grid_style, 'masonry' ) ?>><?php esc_html_e( 'Masonry', 'wpsp-admin' ); ?></option>
				</select>
			</td>
			</tr>
			
			<?php
			// Pagination Type
			$pagination = ! empty( $term_meta['wpsp_term_pagination'] ) ? $term_meta['wpsp_term_pagination'] : ''; ?>
			<tr class="form-field wpsp_term_pagination">
			<th scope="row" valign="top"><label for="wpsp_term_pagination"><?php esc_html_e( 'Pagination', 'wpsp-admin' ); ?></label></th>
			<td>
				<select name="term_meta[wpsp_term_pagination]">
					<option value="" <?php echo ( $pagination == "") ? 'selected="selected"': ''; ?>><?php esc_html_e( 'Default', 'wpsp-admin' ); ?></option>
					<option value="standard" <?php selected( $pagination, 'standard' ) ?>><?php esc_html_e( 'Standard', 'wpsp-admin' ); ?></option>
					<option value="infinite_scroll" <?php selected( $pagination, 'infinite_scroll' ) ?>><?php esc_html_e( 'Inifinite Scroll', 'wpsp-admin' ); ?></option>
					<option value="next_prev" <?php selected( $pagination, 'next_prev' ) ?>><?php esc_html_e( 'Next/Previous', 'wpsp-admin' ); ?></option>
				</select>
			</td>
			</tr>
			
			<?php
			// Excerpt length
			$excerpt_length = ! empty( $term_meta['wpsp_term_excerpt_length'] ) ? intval( $term_meta['wpsp_term_excerpt_length'] ) : ''; ?>
			<tr class="form-field wpsp_term_excerpt_length">
			<th scope="row" valign="top"><label for="wpsp_term_excerpt_length"><?php esc_html_e( 'Excerpt Length', 'wpsp-admin' ); ?></label></th>
				<td>
				<input type="number" name="term_meta[wpsp_term_excerpt_length]" size="3" style="width:100px;" value="<?php echo esc_attr( $excerpt_length ); ?>">
				</td>
			</tr>
			
			<?php
			// Posts Per Page
			$posts_per_page = ! empty( $term_meta['wpsp_term_posts_per_page'] ) ? intval( $term_meta['wpsp_term_posts_per_page'] ) : ''; ?>
			<tr class="form-field wpsp_term_posts_per_page">
			<th scope="row" valign="top"><label for="wpsp_term_posts_per_page"><?php esc_html_e( 'Posts Per Page', 'wpsp-admin' ); ?></label></th>
				<td>
				<input type="number" name="term_meta[wpsp_term_posts_per_page]" size="3" style="width:100px;" value="<?php echo esc_attr( $posts_per_page ); ?>">
				</td>
			</tr>
			
			<?php
			// Image Width
			$wpsp_term_image_width = ! empty( $term_meta['wpsp_term_image_width'] ) ? intval( $term_meta['wpsp_term_image_width'] ) : '';?>
			<tr class="form-field wpsp_term_image_width">
			<th scope="row" valign="top"><label for="wpsp_term_image_width"><?php esc_html_e( 'Image Width', 'wpsp-admin' ); ?></label></th>
				<td>
				<input type="number" name="term_meta[wpsp_term_image_width]" size="3" style="width:100px;" value="<?php echo esc_attr( $wpsp_term_image_width ); ?>">
				</td>
			</tr>
				
			<?php
			// Image Height
			$wpsp_term_image_height = ! empty( $term_meta['wpsp_term_image_height'] ) ? intval( $term_meta['wpsp_term_image_height'] ) : ''; ?>
			<tr class="form-field wpsp_term_image_height">
			<th scope="row" valign="top"><label for="wpsp_term_image_height"><?php esc_html_e( 'Image Height', 'wpsp-admin' ); ?></label></th>
				<td>
				<input type="number" name="term_meta[wpsp_term_image_height]" size="3" style="width:100px;" value="<?php echo esc_attr( $wpsp_term_image_height ); ?>">
				</td>
			</tr>

			<script>
				// Show and hide wpsp fields
				( function( $ ) {
					"use strict";
					$( document ).ready( function() {
						var $termStyle      = $( '.wpsp_term_style select' ),
							$termStyleVal   = $termStyle.val(),
							$gridDependents = $( '.wpsp_term_grid_style, .wpsp_term_grid_cols' );
						$termStyle.on('change', function() {
							if ( 'grid' == this.value ) {
								$gridDependents.show();
							} else {
								$gridDependents.hide();
								$gridDependents.find( 'select' ).val( '' );
							}
						} );
					} );
				} ) ( jQuery );
			</script>

		<?php  }

		/**
		 * Saves new category fields
		 *
		 * @access public
		 * @since  1.0.0
		 */
		public function edited_category( $term_id ) {
			if ( isset( $_POST['term_meta'] ) ) {
				$tag_id    = $term_id;
				$term_meta = get_option( "category_$tag_id" );
				$cat_keys  = array_keys( $_POST['term_meta'] );
				foreach ( $cat_keys as $key ) {
					if ( isset( $_POST['term_meta'][$key] ) ) {
						$term_meta[$key] = $_POST['term_meta'][$key];
					}
				}
				update_option( "category_$tag_id", $term_meta );
			}
		}

	}

}
new WPSP_Category_Meta();