<?php
/**
 * Portfolio+ functions and definitions
 *
 * @package Portfolio+
 * @author Devin Price <devin@wptheming.com>
 * @license http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */

/**
 * Set constant for version
 */
define( 'PORTFOLIO_VERSION', '3.7.2' );

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 980;
}

if ( ! function_exists( 'portfolioplus_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function portfolioplus_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on _s, use a find and replace
	 * to change '_s' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'portfolio-plus', get_template_directory() . '/languages' );

	// This theme styles the visual editor with editor-style.css to match the theme style
	add_editor_style();

	// This theme uses wp_nav_menu() in one location
	register_nav_menus( array(
			'primary' => __( 'Primary Menu', 'portfolio-plus' ),
		) );

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	// Add support for a variety of post formats ( will be added in next version )
	add_theme_support( 'post-formats', array( 'gallery', 'image', 'video', 'quote', 'link' ) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
	) );

	// Add support for featured images
	add_theme_support( 'post-thumbnails' );

	// Add images sizes for the various thumbnails
	add_image_size( 'portfolio-thumbnail', 360, 260, true );
	add_image_size( 'portfolio-large', 690, 9999, false );
	add_image_size( 'portfolio-fullwidth', 980, 9999, false );

}
endif; // portfolioplus_setup
add_action( 'after_setup_theme', 'portfolioplus_setup' );

/**
 * Enqueue scripts and styles.
 */
function portfolioplus_scripts() {

	wp_enqueue_style(
		'portfolio-plus-style',
		get_stylesheet_uri(),
		array(),
		PORTFOLIO_VERSION
	);

	// Use style-rtl.css for RTL layouts
	wp_style_add_data(
		'portfolio-plus-style',
		'rtl',
		'replace'
	);

	if ( SCRIPT_DEBUG || WP_DEBUG ) :

		wp_enqueue_script(
			'portfolioplus-navigation',
			get_template_directory_uri() . '/js/navigation.js',
			array( 'jquery' ),
			PORTFOLIO_VERSION,
			true
		);

		wp_enqueue_script(
			'portfolioplus-fit-vids',
			get_template_directory_uri() . '/js/jquery.fitvids.js',
			array( 'jquery' ),
			PORTFOLIO_VERSION,
			true
		);

	else :

		wp_enqueue_script(
			'portfolioplus-combined',
			get_template_directory_uri() . '/js/combined-min.js',
			array( 'jquery' ),
			PORTFOLIO_VERSION,
			true
		);

	endif;

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
    	wp_enqueue_script( 'comment-reply' );
	}

	if ( !is_single() && of_get_option( 'infinite_scroll', true ) ) {
		wp_enqueue_script(
			'portfolioplus-infinite-scroll',
			get_template_directory_uri() . '/js/jquery.infinitescroll.min.js',
			array( 'jquery' ),
			PORTFOLIO_VERSION,
			true
		);
	}
}
add_action( 'wp_enqueue_scripts', 'portfolioplus_scripts' );

/**
 * Enqueues fonts
 */
function portfolioplus_fonts() {

	// Google Font
	wp_enqueue_style( 'portfolioplus_fonts', '//fonts.googleapis.com/css?family=Open+Sans:400italic,400,600|Rokkitt:400,700', '', null, 'screen' );

	// Icon font
	wp_enqueue_style( 'portfolioplus_icon_font', get_template_directory_uri() . '/fonts/custom/portfolio-custom.css', array(), PORTFOLIO_VERSION );

}
add_action( 'wp_enqueue_scripts', 'portfolioplus_fonts', 10 );

/**
 * Registers widget areas
 */
function portfolioplus_widgets_init() {

	register_sidebar( array (
		'name' => __( 'Sidebar', 'portfolio-plus' ),
		'id' => 'sidebar',
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => "</li>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Footer 1', 'portfolio-plus' ),
		'id' => 'footer-1',
		'description' => __( "Widgetized footer", 'portfolio-plus' ),
		'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>'
	) );

	register_sidebar( array(
		'name' => __( 'Footer 2', 'portfolio-plus' ),
		'id' => 'footer-2',
		'description' => __( "Widgetized footer", 'portfolio-plus' ),
		'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>'
	) );

	register_sidebar( array(
		'name' => __( 'Footer 3', 'portfolio-plus' ),
		'id' => 'footer-3',
		'description' => __( "Widgetized footer", 'portfolio-plus' ),
		'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>'
	) );

	register_sidebar( array(
		'name' => __( 'Footer 4', 'portfolio-plus' ),
		'id' => 'footer-4',
		'description' => __( "Widgetized footer", 'portfolio-plus' ),
		'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>'
	) );
}
add_action( 'init', 'portfolioplus_widgets_init' );

/**
 * Sets up the options panel and default functions
 */
require_once( get_template_directory() . '/extensions/options-functions.php' );

/**
 * Adds general template functions
 */
require_once( get_template_directory() . '/extensions/template-helpers.php' );

/**
 * Adds general portfolio functions
 */
require_once( get_template_directory() . '/extensions/portfolio-functions.php' );

/**
 * Custom functions that act independently of the theme templates.
 */
require_once( get_template_directory() . '/extensions/extras.php' );

/**
 * Displays notices for recommended plugins
 */
require_once( get_template_directory() . '/extensions/recommended-plugins.php' );

/**
 * Required functions for the portfolio category template
 */
if ( class_exists( 'Portfolio_Post_Type' ) ) {
	require_once( get_template_directory() . '/extensions/portfolio-category-functions.php' );
}

/**
 * Theme updater.
 *
 * @since 3.4.0
 */
function portfolioplus_theme_updater() {
	require( get_template_directory() . '/extensions/updater/theme-updater.php' );
}
add_action( 'after_setup_theme', 'portfolioplus_theme_updater' );