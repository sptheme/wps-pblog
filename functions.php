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

		// Setup theme => add_theme_support, register_nav_menus, load_theme_textdomain, etc
		// Must run on 10 priority or else child theme locale will be overritten
		add_action( 'after_setup_theme', array( $this, 'theme_setup' ), 10 );

		// Load the scripts in WP Admin
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );

		// Load theme style
		add_action( 'wp_enqueue_scripts', array( $this, 'wpsp_theme_css') );
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
		define( 'WPSP_THEME_VERSION', '1.0.0' );

		// Paths to the parent theme directory
		define( 'WPSP_THEME_DIR', get_template_directory() );
		define( 'WPSP_THEME_URI', get_template_directory_uri() );

		// Javascript and CSS Paths
		define( 'WPSP_JS_DIR_URI', WPSP_THEME_URI.'/js/' );
		define( 'WPSP_CSS_DIR_URI', WPSP_THEME_URI.'/css/' );

		// INC path
		define( 'WPSP_INC_DIR', WPSP_THEME_DIR.'/inc/' );
		define( 'WPSP_INC_DIR_URL', WPSP_THEME_DIR.'/inc/');
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
	public static function admin_scripts( $hook ){
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
}
$wpsp_theme_setup = new WPSP_Theme_Setup;






if ( ! function_exists( 'wpspblog_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function wpspblog_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on WPSP Blog, use a find and replace
	 * to change 'wpspblog' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'wpspblog', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary', 'wpspblog' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See https://developer.wordpress.org/themes/functionality/post-formats/
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'wpspblog_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif;
add_action( 'after_setup_theme', 'wpspblog_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function wpspblog_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'wpspblog_content_width', 640 );
}
add_action( 'after_setup_theme', 'wpspblog_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function wpspblog_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'wpspblog' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'wpspblog' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'wpspblog_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function wpspblog_scripts() {
	wp_enqueue_style( 'wpspblog-style', get_stylesheet_uri() );

	wp_enqueue_script( 'wpspblog-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'wpspblog-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'wpspblog_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';
