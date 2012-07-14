<?php
/**
 * @package WordPress
 * @subpackage Portfolio Plus
 */
 
// Set the content width based on the theme's design and stylesheet
if ( ! isset( $content_width ) )
	$content_width = 640;
	
// Sets up the options panel and default functions
require_once( TEMPLATEPATH . '/extensions/options-functions.php' );

// Tell WordPress to run portfoliopress_setup() when the 'after_setup_theme' hook is run
add_action( 'after_setup_theme', 'portfoliopress_setup' );
 
if ( ! function_exists( 'portfoliopress_setup' ) ):
function portfoliopress_setup() {

	/**
	 * Make the theme available for translation.
	 * Translations can be added in the /languages/ directory.
	 */
	load_theme_textdomain( 'portfolioplus', TEMPLATEPATH . '/languages' );
	
	$locale = get_locale();
	$locale_file = TEMPLATEPATH . "/languages/$locale.php";
	if ( is_readable( $locale_file ) )
		require_once( $locale_file );
	
	// This theme styles the visual editor with editor-style.css to match the theme style
	add_editor_style();
	
	// This theme uses wp_nav_menu() in one location
	register_nav_menus( array(
			'primary' => __( 'Primary Menu', 'portfolioplus' ),
		) );
	
	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );
	
	// Add support for a variety of post formats ( will be added in next version )
	add_theme_support( 'post-formats', array( 'gallery', 'quote', 'image' ) );
	
	add_image_size( 'portfolio-thumbnail', 215, 175, true );
	add_image_size( 'portfolio-thumbnail-fullwidth', 308, 220, true );
	add_image_size( 'portfolio-large', 630, 9999, false );

}
endif; // portfoliopress_setup

/**
 * Loads the required javascript for the drop down menus and jquery effects
 * on portfolio items and post formats.
 */
 
function portfoliopress_scripts() {
	wp_register_script( 'superfish', get_template_directory_uri() .'/js/superfish.js', array( 'jquery' ), false, true );
	wp_enqueue_script('superfish');
	wp_register_script( 'themejs', get_template_directory_uri() . '/js/theme.js', array( 'jquery' ), false, true );
	wp_register_script( 'infinite_scroll',  get_template_directory_uri() . '/js/jquery.infinitescroll.min.js', array('jquery'),null,true );
	if ( !is_single() ) {
		wp_enqueue_script('themejs');
		wp_enqueue_script('infinite_scroll');
	}
}

add_action('wp_enqueue_scripts', 'portfoliopress_scripts');

/**
 * Load webfonts from Google
 */
 
if ( !function_exists( 'portfoliopress_google_fonts' ) ) {
	function portfoliopress_google_fonts() {
		if ( !is_admin() ) {
			wp_register_style( 'portfoliopress_open_sans', 'http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,600', '', null, 'screen' );
			wp_register_style( 'portfoliopress_rokkitt', 'http://fonts.googleapis.com/css?family=Rokkitt:400,700', '', null, 'screen' );
			wp_enqueue_style( 'portfoliopress_open_sans' );
			wp_enqueue_style( 'portfoliopress_rokkitt' );
		}
	}
}

add_action( 'init', 'portfoliopress_google_fonts' );

/**
 * Infinite Scroll
 */
function portfoliopress_infinite_scroll_js() {
    if ( !is_singular() && of_get_option('infinite_scroll', true) ) { ?>
	    <script>
	    var infinite_scroll = {
	        loading: {
	            img: "<?php echo get_template_directory_uri(); ?>/images/ajax-loader.gif",
	            msgText: "<?php _e( 'Loading more...', 'portfolioplus' ); ?>",
	            finishedMsg: "<?php _e( 'Congratulations.  You\'ve seen it all.', 'portfolioplus' ); ?>",
	            speed: 'slow'
	        },
	        "nextSelector":"#nav-below .nav-previous a",
	        "navSelector":"#nav-below",
	        "itemSelector":"article, .portfolio-item",
	        "contentSelector":"#content, #portfolio"
	    };
	    jQuery( infinite_scroll.contentSelector ).infinitescroll( infinite_scroll, function(elements) {
		    portfoliopress_bind(elements);
	    });
	    </script>
	    <?php
    }
}
add_action( 'wp_footer', 'portfoliopress_infinite_scroll_js',100 );

/**
 * Displays a notice letting the user know that portfolio post type functionality
 * will be moving into a plugin.  They can upgrade now, or wait one more
 * version before this code is removed.
 */
if ( !function_exists( 'portfolioposttype' ) && current_user_can( 'install_plugins' ) ) {

	/* Display a notice that can be dismissed */

	add_action( 'admin_notices', 'portfoliopress_install_plugin_notice' );

	function portfoliopress_install_plugin_notice() {
		global $current_user ;
		$user_id = $current_user->ID;
		/* Check that the user hasn't already clicked to ignore the message */
		if ( ! get_user_meta( $user_id, 'portfoliopress_install_plugin_notice' ) ) {
			add_thickbox();
			echo '<div class="updated"><p>';
			printf( __( 'If you wish to use custom post types for portfolios, please install the Portfolio Post Type Plugin.  <a href="%1$s" class="thickbox onclick">Install Now</a> | <a href="%2$s">Hide Notice</a>' ), admin_url() . 'plugin-install.php?tab=plugin-information&plugin=portfolio-post-type&TB_iframe=true&width=640&height=517', '?example_nag_ignore=0' );
			echo '</p></div>';
		}
	}

	add_action( 'admin_init', 'portfoliopress_post_plugin_ignore' );

	function portfoliopress_post_plugin_ignore() {
		global $current_user;
		$user_id = $current_user->ID;
		/* If user clicks to ignore the notice, add that to their user meta */
		if ( isset( $_GET['example_nag_ignore'] ) && '0' == $_GET['example_nag_ignore'] ) {
			add_user_meta( $user_id, 'example_ignore_notice', 'true', true );
		}
	}
}

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 */
function portfolio_page_menu_args( $args ) {
	$args['show_home'] = true;
	$args['menu_class'] = 'menu';
	return $args;
}

add_filter( 'wp_page_menu_args', 'portfolio_page_menu_args' );

/**
 * Class name for wp_nav_menu
 */
function portfolio_wp_nav_menu_args( $args ) {
	$args['container_class'] = 'menu';
	$args['menu_class'] = '';
	return $args;
}

add_filter( 'wp_nav_menu_args', 'portfolio_wp_nav_menu_args' );

/**
 * Register widgetized area and update sidebar with default widgets
 */
function portfoliopress_widgets_init() {
	
	register_sidebar( array (
			'name' => __( 'Sidebar', 'portfolioplus' ),
			'id' => 'sidebar',
			'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
			'after_widget' => "</li>",
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		) );

	register_sidebar( array( 'name' => __( 'Footer 1', 'portfolioplus' ),'id' => 'footer-1', 'description' => __( "Widetized footer", 'portfolioplus' ), 'before_widget' => '<div id="%1$s" class="widget-container %2$s">','after_widget' => '</div>','before_title' => '<h3>','after_title' => '</h3>' ) );
	register_sidebar( array( 'name' => __( 'Footer 2', 'portfolioplus' ),'id' => 'footer-2', 'description' => __( "Widetized footer", 'portfolioplus' ), 'before_widget' => '<div id="%1$s" class="widget-container %2$s">','after_widget' => '</div>','before_title' => '<h3>','after_title' => '</h3>' ) );
	register_sidebar( array( 'name' => __( 'Footer 3', 'portfolioplus' ),'id' => 'footer-3', 'description' => __( "Widetized footer", 'portfolioplus' ), 'before_widget' => '<div id="%1$s" class="widget-container %2$s">','after_widget' => '</div>','before_title' => '<h3>','after_title' => '</h3>' ) );
	register_sidebar( array( 'name' => __( 'Footer 4', 'portfolioplus' ),'id' => 'footer-4', 'description' => __( "Widetized footer", 'portfolioplus' ), 'before_widget' => '<div id="%1$s" class="widget-container %2$s">','after_widget' => '</div>','before_title' => '<h3>','after_title' => '</h3>' ) );
}

add_action( 'init', 'portfoliopress_widgets_init' );

/**
 * Reusable navigation code for navigation
 * Display navigation to next/previous pages when applicable
 */
function portfoliopress_content_nav() {
	global $wp_query;
	if (  $wp_query->max_num_pages > 1 ) :
		if (function_exists('wp_pagenavi') ) {
			wp_pagenavi();
		} else { ?>
        	<nav id="nav-below">
			<h1 class="screen-reader-text"><?php _e( 'Post navigation', 'portfolioplus' ); ?></h1>		
			<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'portfolioplus' ) ); ?></div>
			<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'portfolioplus' ) ); ?></div>
			</nav><!-- #nav-below -->
    	<?php }
	endif;
}

/**
 * Sets posts displayed per portfolio page to 9
 */
function wpt_portfolio_custom_posts_per_page( $query ) {
	global $wp_the_query;
	if ( $wp_the_query === $query && !is_admin() && is_post_type_archive( 'portfolio' ) ) {
		$query->set( 'posts_per_page', of_get_option('portfolio_num','9') );
	}
}

add_action( 'pre_get_posts', 'wpt_portfolio_custom_posts_per_page' );

/**
 * Overrides the default behavior of portfolio taxonomies to use the archive-portfolio template
 * http://www.billerickson.net/reusing-wordpress-theme-files/
 */
function portfoliopress_template_chooser( $template ) {
	if ( is_tax( 'portfolio_tag' ) ||  is_tax( 'portfolio_category' ) )
		$template = get_query_template( 'archive-portfolio' );
	return $template;
}
add_filter( 'template_include', 'portfoliopress_template_chooser' );

/**
 * Custom CSS is loaded for the options panel
 */
 
if ( is_admin() ) {
    $of_page= 'appearance_page_options-framework';
    add_action( "admin_print_styles-$of_page", 'optionsframework_custom_css', 100);
}
 
function optionsframework_custom_css () {
	wp_register_style( 'optionsframework_custom_css', get_template_directory_uri() .'/extensions/options-custom.css' );
	wp_enqueue_style( 'optionsframework_custom_css' );
}
