<?php
/**
 * Functions
 *
 * @package      Portfolio+
 * @author       Devin Price <devin@wptheming.com>
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */
	
// Sets up the options panel and default functions
require_once( TEMPLATEPATH . '/extensions/options-functions.php' );

// Set the content width based on the theme's design and stylesheet
if ( ! isset( $content_width ) ) {
	if ( of_get_option('layout') == 'layout-1col' ) {
		$content_width = 780;
	} else {
		$content_width = 640;
	}
}

// Adds specific portfolio post type functions
if ( class_exists( 'Portfolio_Post_Type' ) || function_exists( 'portfolioposttype' ) ) {
	require_once( TEMPLATEPATH . '/extensions/portfolio-functions.php' );
}

// Theme updater functions
include( dirname( __FILE__ ) . '/extensions/theme-updater.php' );

// Tell WordPress to run portfolioplus_setup() when the 'after_setup_theme' hook is run
add_action( 'after_setup_theme', 'portfolioplus_setup' );
 
if ( ! function_exists( 'portfolioplus_setup' ) ):
function portfolioplus_setup() {

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
	
	// Add all the images sizes for the various thumbnails
	add_image_size( 'portfolio-thumbnail', 215, 175, true );
	add_image_size( 'portfolio-thumbnail-fullwidth', 314, 224, true );
	add_image_size( 'portfolio-large', 640, 9999, false );
	add_image_size( 'portfolio-fullwidth', 780, 9999, false );

}
endif; // portfolioplus_setup

function portfolioplus_wp_title( $title, $separator ) { // taken from TwentyTen 1.0
	// Don't affect wp_title() calls in feeds.
	if ( is_feed() )
		return $title;

	// The $paged global variable contains the page number of a listing of posts.
	// The $page global variable contains the page number of a single post that is paged.
	// We'll display whichever one applies, if we're not looking at the first page.
	global $paged, $page;

	if ( is_search() ) {
		// If we're a search, let's start over:
		$title = sprintf( 'Search results for %s', '"' . get_search_query() . '"' );
		// Add a page number if we're on page 2 or more:
		if ( $paged >= 2 )
			$title .= " $separator " . sprintf( 'Page %s', $paged );
		// Add the site name to the end:
		$title .= " $separator " . get_bloginfo( 'name', 'display' );
		// We're done. Let's send the new title back to wp_title():
		return $title;
	}

	// Otherwise, let's start by adding the site name to the end:
	$title .= get_bloginfo( 'name', 'display' );

	// If we have a site description and we're on the home/front page, add the description:
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title .= " $separator " . $site_description;

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		$title .= " $separator " . sprintf( 'Page %s', max( $paged, $page ) );

	// Return the new title to wp_title():
	return $title;
}
add_filter( 'wp_title', 'portfolioplus_wp_title', 10, 2 );

/**
 * Loads the required javascript for the drop down menus and jquery effects
 * on portfolio items and post formats.
 */
 
function portfolioplus_scripts() {
	wp_register_script( 'superfish', get_template_directory_uri() .'/js/superfish.js', array( 'jquery' ), false, true );
	wp_enqueue_script('superfish');
	wp_register_script( 'themejs', get_template_directory_uri() . '/js/theme.js', array( 'jquery' ), false, true );
	wp_register_script( 'infinite_scroll',  get_template_directory_uri() . '/js/jquery.infinitescroll.min.js', array('jquery'),null,true );
	if ( !is_single() ) {
		wp_enqueue_script('themejs');
		wp_enqueue_script('infinite_scroll');
	}
}

add_action('wp_enqueue_scripts', 'portfolioplus_scripts');

/**
 * Load webfonts from Google
 */
 
if ( !function_exists( 'portfolioplus_google_fonts' ) ) {
	function portfolioplus_google_fonts() {
		if ( !is_admin() ) {
			wp_register_style( 'portfolioplus_open_sans', 'http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,600', '', null, 'screen' );
			wp_register_style( 'portfolioplus_rokkitt', 'http://fonts.googleapis.com/css?family=Rokkitt:400,700', '', null, 'screen' );
			wp_enqueue_style( 'portfolioplus_open_sans' );
			wp_enqueue_style( 'portfolioplus_rokkitt' );
		}
	}
}

add_action( 'init', 'portfolioplus_google_fonts' );

/**
 * Infinite Scroll
 */
function portfolioplus_infinite_scroll_js() {
    if ( !is_single() && of_get_option('infinite_scroll', true) ) { ?>
	    <script>
	    var infinite_scroll = {
	        loading: {
	            img: "<?php echo get_template_directory_uri(); ?>/images/ajax-loader.gif",
	            msgText: "<?php _e( 'Loading more...', 'portfolioplus' ); ?>",
	            finishedMsg: "<?php _e( 'All items have loaded.', 'portfolioplus' ); ?>",
	            speed: 'slow'
	        },
	        "nextSelector":"#nav-below .nav-previous a",
	        "navSelector":"#nav-below",
	        "itemSelector":"article, .portfolio-item",
	        "contentSelector":"#content, #portfolio"
	    };
	    jQuery( infinite_scroll.contentSelector ).infinitescroll( infinite_scroll, function(elements) {
		    portfolioplus_bind(elements);
	    });
	    </script>
	    <?php
    }
}
add_action( 'wp_footer', 'portfolioplus_infinite_scroll_js',100 );

/**
 * Displays a notice letting the user know that portfolio post type functionality
 * will be moving into a plugin.  They can upgrade now, or wait one more
 * version before this code is removed.
 */
if ( !function_exists( 'portfolioposttype' ) && current_user_can( 'install_plugins' ) ) {

	/* Display a notice that can be dismissed */

	add_action( 'admin_notices', 'portfolioplus_install_plugin_notice' );

	function portfolioplus_install_plugin_notice() {
		global $current_user ;
		$user_id = $current_user->ID;
		/* Check that the user hasn't already clicked to ignore the message */
		if ( ! get_user_meta( $user_id, 'portfolio_ignore_notice' ) ) {
			add_thickbox();
			echo '<div class="updated"><p>';
			printf( __( 'If you wish to use custom post types for portfolios, please install the Portfolio Post Type Plugin.  <a href="%1$s" class="thickbox onclick">Install Now</a> | <a href="%2$s">Hide Notice</a>' ), admin_url() . 'plugin-install.php?tab=plugin-information&plugin=portfolio-post-type&TB_iframe=true&width=640&height=517', '?portfolio_ignore_notice=1' );
			echo '</p></div>';
		}
	}

	add_action( 'admin_init', 'portfolioplus_post_plugin_ignore' );

	function portfolioplus_post_plugin_ignore() {
		global $current_user;
		$user_id = $current_user->ID;
		/* If user clicks to ignore the notice, add that to their user meta */
		if ( isset( $_GET['portfolio_ignore_notice'] ) && '1' == $_GET['portfolio_ignore_notice'] ) {
			add_user_meta( $user_id, 'portfolio_ignore_notice', 'true', true );
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
function portfolioplus_widgets_init() {
	
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

add_action( 'init', 'portfolioplus_widgets_init' );

/**
 * Reusable navigation code for navigation
 * Display navigation to next/previous pages when applicable
 */
function portfolioplus_content_nav() {
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
 * Sets posts displayed per portfolio to 9 or 12 (whatever the option is set to)
 */
function wpt_portfolio_custom_posts_per_page( $query ) {
	global $wp_the_query;
	if ( $wp_the_query === $query && !is_admin() ) {
		if ( is_post_type_archive( 'portfolio' ) || is_tax( 'portfolio_tag' ) ||  is_tax( 'portfolio_category' ) )
		$query->set( 'posts_per_page', of_get_option('portfolio_num','9') );
	}
}

add_action( 'pre_get_posts', 'wpt_portfolio_custom_posts_per_page' );

/**
 * Overrides the default behavior of portfolio taxonomies to use the archive-portfolio template
 * http://www.billerickson.net/reusing-wordpress-theme-files/
 */
function portfolioplus_template_chooser( $template ) {
	if ( is_tax( 'portfolio_tag' ) ||  is_tax( 'portfolio_category' ) )
		$template = get_query_template( 'archive-portfolio' );
	return $template;
}
add_filter( 'template_include', 'portfolioplus_template_chooser' );

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

/**
 * Deletes the portfolioplus_category_query transient if a portfolio post is updated
 */
 
function portfolioplus_save_portfolio( $post_id, $post ) {

	// If this is an auto save routine don't do anyting
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
		return;
		
	if ( $post->post_type == 'portfolio' ) {
		delete_transient( 'portfolioplus_category_query' );
	}
	
}
add_action( 'save_post', 'portfolioplus_save_portfolio', 10, 2 );