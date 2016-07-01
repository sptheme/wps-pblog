<?php
/**
 * Page Animation Functions
 *
 * @package WPSP_Blog
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Start Class
if ( ! class_exists( 'WPSP_Page_Animations' ) ) {

	class WPSP_Page_Animations {
		private $has_animations;
		
		/**
		 * Main constructor
		 *
		 * @since 1.0.0
		 */
		public function __construct() {

			// Animations disabled by default
			$this->has_animations = false;

			// Get animations
			$this->animate_in  = apply_filters( 'wpex_page_animation_in', wpsp_get_redux( 'page-animation-in' ) );
			$this->animate_out = apply_filters( 'wpex_page_animation_out', wpsp_get_redux( 'page-animation-out' ) );

			//echo 'Animation in: ' . $this->animation_in;

			// Set enabled to true
			if ( $this->animate_in || $this->animate_out ) {
				$this->has_animations = true;
			}

			// If page animations is enabled lets do things
			if ( $this->has_animations ) {

				// Load scripts
				add_filter( 'wp_enqueue_scripts', array( $this, 'get_css' ) );

				// Open wrapper
				add_action( 'wpsp_outer_wrap_before', array( $this, 'open_wrapper' ) );

				// Close wrapper
				add_action( 'wpsp_outer_wrap_after', array( $this, 'close_wrapper' ) );
			   
				// Add to localize array
				add_filter( 'wpsp_localize_array', array( $this, 'localize' ) );

				// Add custom CSS for text
				add_action( 'wpsp_head_css', array( $this, 'loading_text' ) );

				// Add strings to WPML
				add_filter( 'wpsp_register_theme_mod_strings', array( $this, 'register_strings' ) );

			}

		}

		/**
		 * Retrieves cached CSS or generates the responsive CSS
		 *
		 * @since 1.0.0
		 */
		public function get_css() {
			wp_enqueue_style( 'animsition', WPSP_CSS_DIR_URI .'animsition.css' );
		}

		/**
		 * Localize script
		 *
		 * @since 1.0.0
		 */
		public function localize( $array ) {

			// Set animation to true
			$array['pageAnimation'] = true;

			// Animate In
			if ( $this->animate_in && array_key_exists( $this->animate_in, $this->in_transitions() ) ) {
				$array['pageAnimationIn'] = $this->animate_in;
			}

			// Animate out
			if ( $this->animate_out && array_key_exists( $this->animate_out, $this->out_transitions() ) ) {
				$array['pageAnimationOut'] = $this->animate_out;
			}

			// Animation Speeds
			$speed = wpsp_get_redux( 'page-animation-speed' );
			$speed = $speed ? $speed : 400;
			$array['pageAnimationInDuration']  = $speed;
			$array['pageAnimationOutDuration'] = $speed;

			// Loading text
			$text = wpsp_get_redux( 'page_animation_loading' );
			$text = $text ? $text : esc_html__( 'Loading...', 'wpsp-blog' );
			$array['pageAnimationLoadingText'] = $text;

	
			// Output opening div
			return $array;

		}

		/**
		 * Open wrapper
		 *
		 * @since 1.0.0
		 *
		 */
		public function open_wrapper() {
			echo '<div class="wpsp-page-animation-wrap animsition clear">';
		}

		/**
		 * Close Wrapper
		 *
		 * @since 1.0.0
		 *
		 */
		public function close_wrapper() {
			echo '</div><!-- .animsition -->';
		}

		/**
		 * In Transitions
		 *
		 * @return array
		 *
		 * @since 1.0.0
		 *
		 */
		public static function in_transitions() {
			return array(
				''              => esc_html__( 'None', 'wpsp-blog' ),
				'fade-in'       => esc_html__( 'Fade In', 'wpsp-blog' ),
				'fade-in-up'    => esc_html__( 'Fade In Up', 'wpsp-blog' ),
				'fade-in-down'  => esc_html__( 'Fade In Down', 'wpsp-blog' ),
				'fade-in-left'  => esc_html__( 'Fade In Left', 'wpsp-blog' ),
				'fade-in-right' => esc_html__( 'Fade In Right', 'wpsp-blog' ),
				'rotate-in'     => esc_html__( 'Rotate In', 'wpsp-blog' ),
				'flip-in-x'     => esc_html__( 'Flip In X', 'wpsp-blog' ),
				'flip-in-y'     => esc_html__( 'Flip In Y', 'wpsp-blog' ),
				'zoom-in'       => esc_html__( 'Zoom In', 'wpsp-blog' ),
			);
		}

		/**
		 * Out Transitions
		 *
		 * @return array
		 *
		 * @since 1.0.0
		 */
		public static function out_transitions() {
			return array(
				''               => esc_html__( 'None', 'wpsp-blog' ),
				'fade-out'       => esc_html__( 'Fade Out', 'wpsp-blog' ),
				'fade-out-up'    => esc_html__( 'Fade Out Up', 'wpsp-blog' ),
				'fade-out-down'  => esc_html__( 'Fade Out Down', 'wpsp-blog' ),
				'fade-out-left'  => esc_html__( 'Fade Out Left', 'wpsp-blog' ),
				'fade-out-right' => esc_html__( 'Fade Out Right', 'wpsp-blog' ),
				'rotate-out'     => esc_html__( 'Rotate Out', 'wpsp-blog' ),
				'flip-out-x'     => esc_html__( 'Flip Out X', 'wpsp-blog' ),
				'flip-out-y'     => esc_html__( 'Flip Out Y', 'wpsp-blog' ),
				'zoom-out'       => esc_html__( 'Zoom Out', 'wpsp-blog' ),
			);
		}

		/**
		 * Add strings for WPML
		 *
		 * @return array
		 *
		 * @since 1.0.0
		 */
		public function register_strings( $strings ) {
			$strings['page_animation_loading'] = esc_html__( 'Loading...', 'wpsp-blog' );
			return $strings;
		}

		/**
		 * Add loading text
		 *
		 * @since 1.0.0
		 */
		public function loading_text( $css ) {
			$text = wpsp_get_redux( 'page-animation-loading' );
			$text = $text ? $text : esc_html__( 'Loading...', 'wpsp-blog' );
			$css .= '/*PAGE ANIMATIONS*/.animsition-loading{content:"'. $text .'";}';
			return $css;
		}

	}
}
$wpsp_page_transitions = new WPSP_Page_Animations();