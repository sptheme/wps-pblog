<?php
/**
 * WPSP Blog functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WPSP_Blog
 */

/**
* Start up class
*
* @version 1.0.0
*
*/

class WPSP_Theme_Setup {
	private $template_dir;

	/**
	 * Main Theme Class Constructor
	 *
	 * Loads all necessary classes, functions, hooks, configuration files and actions for the theme.
	 * Everything starts here.
	 *
	 * @since 1.1.0
	 *
	 */
	function __construct(){
		// define template directory
		$this->template_dir = get_template_directory();

		// Add redux framework as Theme Options
		require_once( $this->template_dir . '/inc/admin/admin-init.php' );

		// Included Metabox.io framework as meta boxes of theme core
		require_once( $this->template_dir . '/inc/meta-box/meta-box.php' );
		require_once( $this->template_dir . '/inc/meta-box/meta-config.php' );

		// Define constant
		add_action( 'after_setup_theme', array( $this , 'constants' ), 0 );

		// Load all core theme function files
		// Load Before classes and addons so we can make use of them
		add_action( 'after_setup_theme', array( $this, 'wpsp_include_functions' ), 1 );

		// Load all the theme addons - must run on this hook!!!
		add_action( 'after_setup_theme', array( $this, 'wpsp_addons' ), 2 );

		// Setup theme => add_theme_support, register_nav_menus, load_theme_textdomain, etc
		// Must run on 10 priority or else child theme locale will be overritten
		add_action( 'after_setup_theme', array( $this, 'theme_setup' ), 10 );

		// Load the scripts in WP Admin
		add_action( 'admin_enqueue_scripts', array( $this, 'wpsp_admin_scripts' ) );

		// Load theme style
		add_action( 'wp_enqueue_scripts', array( $this, 'wpsp_theme_css') );

		// register sidebar widget areas
		add_action( 'widgets_init', array( $this, 'register_sidebars' ) );

		// Exclude categories from the blog page
		add_filter( 'pre_get_posts', array( $this, 'pre_get_posts' ) );

		// Add new social profile fields to the user dashboard
		add_filter( 'user_contactmethods', array( $this, 'add_user_social_fields' ) );

		// Allow for the use of shortcodes in the WordPress excerpt
		add_filter( 'the_excerpt', 'shortcode_unautop' );
		add_filter( 'the_excerpt', 'do_shortcode' );
	}

	/**
	 * Use rwmb_meta framework as metabox
	 * 
	 * @link https://metabox.io
	 * 
	 * @since 1.0.0
	 *
	 */
	public static function constants(){
		// Theme branding
		define( 'WPSP_THEME_BRANDING', 'WPSP Blog' );
		define( 'WPSP_THEME_BRANDING_PREFIX', 'WPSP' );
		define( 'WPSP_THEME_VERSION', '1.0.0' );

		// Paths to the parent theme directory
		define( 'WPSP_THEME_DIR', get_template_directory() );
		define( 'WPSP_THEME_URI', get_template_directory_uri() );

		// Javascript and CSS Paths
		define( 'WPSP_JS_DIR_URI', WPSP_THEME_URI.'/js/' );
		define( 'WPSP_CSS_DIR_URI', WPSP_THEME_URI.'/css/' );

		// INC path
		define( 'WPSP_INC_DIR', WPSP_THEME_DIR.'/inc/' );
		define( 'WPSP_INC_DIR_URL', WPSP_THEME_URI.'/inc/');
	}

	/**
	 * Framework functions
	 * Load before Classes & Addons so we can use them
	 *
	 * @since 1.0.0
	 */
	public static function wpsp_include_functions() {
		require_once( WPSP_INC_DIR .'aq_resizer.php' );
		require_once( WPSP_INC_DIR .'sanitize-data.php' );
		require_once( WPSP_INC_DIR .'wpml.php' );
		require_once( WPSP_INC_DIR .'core-functions.php' );
		require_once( WPSP_INC_DIR .'overlay.php' );
	}

	/**
	 * Addon functions
	 *
	 * @since 1.0.0
	 */
	public static function wpsp_addons() {
		require_once( WPSP_INC_DIR .'addons/widget-areas.php' );
	}

	/**
	 * Adds basic theme support functions and registers the nav menus
	 *
	 * @since 1.1.0
	 */
	public static function theme_setup() {

		// This theme styles the visual editor to resemble the theme style.
		$font_url = 'https://fonts.googleapis.com/css?family=Open+Sans:400,400italic,700,700italic';
		add_editor_style( array( 'css/editor-style.css', str_replace( ',', '%2C', $font_url ) ) );

		// Load text domain
		load_theme_textdomain( 'wpsp-blog-textdomain', WPSP_THEME_DIR .'/languages' );

		// Get globals
		global $content_width;

		// Set content width based on theme's default design
		if ( ! isset( $content_width ) ) {
			$content_width = 980;
		}

		// Array of theme menus
		$menus = apply_filters( 'wpsp_nav_menus', array(
			'topbar_menu'     => esc_html__( 'Top Bar', 'wpsp-blog-textdomain' ),
			'main_menu'       => esc_html__( 'Main', 'wpsp-blog-textdomain' ),
			'mobile_menu_alt' => esc_html__( 'Mobile Menu Alternative', 'wpsp-blog-textdomain' ),
			'mobile_menu'     => esc_html__( 'Mobile Icons', 'wpsp-blog-textdomain' ),
			'footer_menu'     => esc_html__( 'Footer', 'wpsp-blog-textdomain' ),
		) );

		// Register navigation menus
		register_nav_menus( $menus );

		// Declare theme support
		add_theme_support( 'post-formats', array( 'video', 'gallery', 'audio', 'quote', 'link' ) );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );
		add_theme_support( 'title-tag' );

		// Enable excerpts for pages.
		add_post_type_support( 'page', 'excerpt' );
	}

	/**
	 * Load scripts in the WP Admin
	 *
	 * @since 1.0.0 
	 *
	 */
	public static function wpsp_admin_scripts( $hook ){
		if ( !in_array($hook, array('post.php','post-new.php')) )
		return;
		wp_enqueue_script( 'admin-scripts', get_template_directory_uri() . '/js/admin-scripts.js', array( 'jquery' ) );
	}

	/**
	 * Load theme css
	 *
	 * @since 1.0.0 
	 *
	 */
	public static function wpsp_theme_css(){
		wp_enqueue_style( 'wpspblog-style', get_stylesheet_uri() );

		//Add Google Fonts (English): Open Sans
		//wp_enqueue_style( 'google-font-english', 'https://fonts.googleapis.com/css?family=Open+Sans:400,400italic,700,700italic' );
		//wp_enqueue_style( 'font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css' );

		//Add Google Font (Khmer): Hanuman
		//wp_enqueue_style( 'google-font-khmer', 'https://fonts.googleapis.com/css?family=Hanuman:400,700' );

		//Enabling Local Web Fonts
		wp_enqueue_style( 'local-fonts-english', get_template_directory_uri() . '/fonts/custom-fonts.css' );
		wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/fonts/font-awesome/css/font-awesome.min.css' );
	}

	/**
	 * Registers the theme sidebars (widget areas)
	 *
	 * @since 1.1.0
	 */
	public static function register_sidebars() {
		require_once( WPSP_INC_DIR .'widgets/widgets.php' );
	}

	/**
	 * This function runs before the main query.
	 *
	 * @since 1.0.0
	 */
	public static function pre_get_posts( $query ) {

		// Lets not break stuff
		if ( is_admin() || ! $query->is_main_query() ) {
			return;
		}

		// Search pagination
		if ( is_search() ) {
			$query->set( 'posts_per_page', wpsp_get_redux( 'search-posts-per-page', '10' ) );
			return;
		}

		// Exclude categories from the main blog
		if ( ( is_home() || is_page_template( 'templates/blog.php' ) ) && $cats = wpsp_blog_exclude_categories() ) {
			set_query_var( 'category__not_in', $cats );
			return;
		}

		// Category pagination
		$terms = get_terms( 'category' );
		if ( ! empty( $terms ) ) {
			foreach ( $terms as $term ) {
				if ( is_category( $term->slug ) ) {
					$term_id    = $term->term_id;
					$term_data  = get_option( "category_$term_id" );
					if ( $term_data ) {
						if ( ! empty( $term_data['wpsp_term_posts_per_page'] ) ) {
							$query->set( 'posts_per_page', $term_data['wpsp_term_posts_per_page'] );
							return;
						}
					}
				}
			}
		}

	}

	/**
	 * Add new user fields / user meta
	 *
	 * @since 1.0.0
	 */
	public static function add_user_social_fields( $contactmethods ) {

		$branding = wpsp_get_theme_branding();
		$branding = $branding ? $branding .' - ' : '';

		if ( ! isset( $contactmethods['wpsp_twitter'] ) ) {
			$contactmethods['wpsp_twitter'] = $branding .'Twitter';
		}

		if ( ! isset( $contactmethods['wpsp_facebook'] ) ) {
			$contactmethods['wpsp_facebook'] = $branding .'Facebook';
		}

		if ( ! isset( $contactmethods['wpsp_googleplus'] ) ) {
			$contactmethods['wpsp_googleplus'] = $branding .'Google+';
		}

		if ( ! isset( $contactmethods['wpsp_linkedin'] ) ) {
			$contactmethods['wpsp_linkedin'] = $branding .'LinkedIn';
		}

		if ( ! isset( $contactmethods['wpsp_pinterest'] ) ) {
			$contactmethods['wpsp_pinterest'] = $branding .'Pinterest';
		}
		
		if ( ! isset( $contactmethods['wpsp_instagram'] ) ) {
			$contactmethods['wpsp_instagram'] = $branding .'Instagram';
		}

		return $contactmethods;

	}

}
$wpsp_theme_setup = new WPSP_Theme_Setup;

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';
