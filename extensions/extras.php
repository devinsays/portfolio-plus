<?php
/**
 * @package Portfolio+
 */

 /**
 * Filters wp_title to print a neat <title> tag based on what is being viewed.
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string The filtered title.
 */
function portfolioplus_wp_title( $title, $sep ) {
	if ( is_feed() ) {
		return $title;
	}

	global $page, $paged;

	// Add the blog name
	$title .= get_bloginfo( 'name', 'display' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ) {
		$title .= " $sep $site_description";
	}

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 ) {
		$title .= " $sep " . sprintf( __( 'Page %s', 'portfolio-plus' ), max( $paged, $page ) );
	}

	return $title;
}
add_filter( 'wp_title', 'portfolioplus_wp_title', 10, 2 );

/**
 * Displays notice if post_per_page is not divisible by 3
 */
function portfolioplus_posts_per_page_notice() {

	$posts_per_page = get_option( 'posts_per_page', 10 );

	if ( ( $posts_per_page % 3 ) == 0 ) {
		return;
	}

	$options = get_option( 'portfolioplus', false );

	if ( isset( $options['post_per_page_ignore'] ) && $options['post_per_page_ignore'] == 1 ) {
		return;
	}

	if ( current_user_can( 'manage_options' ) ) {
		echo '<div class="updated"><p>';
			printf( __(
				'Portfolio+ recommends setting posts per page to 9. This can be changed under <a href="%3$s">Settings > Reading Options</a>.<br><a href="%1$s">Update It</a> | <a href="%2$s">Dismiss Notice</a>.' ),
				'?portfolio_update_posts_per_page=1',
				'?portfolio_post_per_page_ignore=1',
				admin_url( 'options-reading.php', false ), 'portfolio-plus' );
		echo '</p></div>';
	}
}
add_action( 'admin_notices', 'portfolioplus_posts_per_page_notice', 120 );

/**
 * Hides notices if user chooses to dismiss it
 */
function portfolioplus_notice_ignores() {

	$options = get_option( 'portfolioplus' );

	if ( isset( $_GET['portfolio_post_per_page_ignore'] ) && '1' == $_GET['portfolio_post_per_page_ignore'] ) {
		$options['post_per_page_ignore'] = 1;
		update_option( 'portfolioplus', $options );
	}

	if ( isset( $_GET['portfolio_update_posts_per_page'] ) && '1' == $_GET['portfolio_update_posts_per_page'] ) {
		update_option( 'posts_per_page', 9 );
	}

}
add_action( 'admin_init', 'portfolioplus_notice_ignores' );

/**
 * Filter Page Templates if Portfolio Post Type Plugin
 * is not active.
 *
 * @param array $templates Array of templates.
 * @return array $templates Modified Array of templates.
 */

function portfolioplus_page_templates_mod( $templates ) {
	if ( !class_exists( 'Portfolio_Post_Type' ) ) {
		unset( $templates['templates/portfolio.php'] );
		unset( $templates['templates/full-width-portfolio.php'] );
	}
	return $templates;
}
add_filter( 'theme_page_templates', 'portfolioplus_page_templates_mod' );

/**
 * WP PageNavi Support
 *
 * Removes wp-pagenavi styling since it is handled by theme.
 */

function portfolioplus_deregister_styles() {
    wp_deregister_style( 'wp-pagenavi' );
}
add_action( 'wp_print_styles', 'portfolioplus_deregister_styles', 100 );

/**
 * Replaces definition list elements with their appropriate HTML5 counterparts.
 *
 * @param array $atts The output array of shortcode attributes.
 * @return array HTML5-ified gallery attributes.
 */
function portfolioplus_gallery_atts( $atts ) {
    $atts['itemtag']    = 'figure';
    $atts['icontag']    = 'div';
    $atts['captiontag'] = 'figcaption';

    return $atts;
}
add_filter( 'shortcode_atts_gallery', 'portfolioplus_gallery_atts' );

// Removes the default gallery styling
add_filter( 'use_default_gallery_style', '__return_false' );

/**
 * Remove WordPress's default padding on images with captions
 *
 * @param int $width Default WP .wp-caption width (image width + 10px)
 * @return int Updated width to remove 10px padding
 */
function portfolioplus_remove_caption_padding( $width ) {
    return $width - 10;
}
add_filter( 'img_caption_shortcode_width', 'portfolioplus_remove_caption_padding' );