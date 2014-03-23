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
		$title .= " $sep " . sprintf( __( 'Page %s', 'portfolioplus' ), max( $paged, $page ) );
	}

	return $title;
}
add_filter( 'wp_title', 'portfolioplus_wp_title', 10, 2 );


/**
 * Upgrade routine for Portfolio Press.
 * Sets $options['upgrade-3-0'] to true if user is updating
 */
function portfolioplus_upgrade_routine() {

	$options = get_option( 'portfolioplus', false );

	// If version is set, upgrade routine has already run
	if ( !empty( $options['version'] ) ) {
		return;
	}

	// If $options exist, user is upgrading
	if ( $options ) {
		$options['upgrade-3-0'] = true;
	}

	// If 'portfolio_ignore_notice' exists, user is upgrading
	// We'll also delete that data since it's no longer used
	global $current_user;
	if ( get_user_meta( $current_user->ID, 'portfolio_ignore_notice' ) ) {
		$options['upgrade-3-0'] = true;
		delete_user_meta( $current_user->ID, 'portfolio_ignore_notice' );
	}

	// Page template paths need to be updated
	if ( isset( $options['upgrade-3-0'] ) && $options['upgrade-3-0'] ) {
		portfolioplus_update_page_templates();
	}

	// New version number
	$options['version'] = '3.0';

	update_option( 'portfolioplus', $options );
}
add_action( 'admin_init', 'portfolioplus_upgrade_routine' );

/**
 * Part of the Portfolio+ upgrade routine.
 * The page template paths have changed, so let's update the template meta for the user.
 */
function portfolioplus_update_page_templates() {

	$args = array(
		'post_type' => 'page',
		'post_status' => 'publish',
		'meta_query' => array(
		    array(
		        'key' => '_wp_page_template',
		        'value' => 'default',
		        'compare' => '!='
		    )
		)
	);

	$query = new WP_Query( $args );
	if ( $query->have_posts() ) :
		while ( $query->have_posts() ) : $query->the_post();
			$current_template = get_post_meta( get_the_ID(), '_wp_page_template', true );
			$new_template = false;
			switch ( $current_template ) {
				case 'archive-portfolio.php':
					$new_template = 'templates/portfolio.php';
					break;
				case 'full-width-page.php':
					$new_template = 'templates/full-width-page.php';
					break;
				case 'full-width-portfolio.php':
					$new_template = 'templates/full-width-portfolio.php';
					break;
				case 'portfolio-category-template.php':
					$new_template = 'templates/portfolio-categories.php';
					break;
			}
			if ( $new_template ) {
				update_post_meta( get_the_ID(), '_wp_page_template', $new_template );
			}
		endwhile;
	endif;
}

/**
 * Displays notice if user has upgraded theme
 */
function portfolioplus_upgrade_notice() {

	if ( current_user_can( 'edit_theme_options' ) ) {

		$options = get_option( 'portfolioplus', false );

		if ( !empty( $options['upgrade-3-0'] ) && $options['upgrade-3-0'] ) {
			echo '<div class="updated"><p>';
				printf( __(
					'Thanks for updating Portfolio+.  Please <a href="%1$s">read about important changes</a> in this version.  <br>You may need to re-save pages that have page templates set.  Give your site a quick check!  <br><a href="%2$s">Dismiss notice</a>' ),
					'http://wptheming.com/2014/03/portfolio-theme-updates/',
					'?portfolio_upgrade_notice_ignore=1' );
			echo '</p></div>';
		}

	}
}

add_action( 'admin_notices', 'portfolioplus_upgrade_notice', 100 );

/**
 * Displays notice if post_per_page is not divisible by 3
 */
function portfolioplus_posts_per_page_notice() {

	$posts_per_page = get_option( 'posts_per_page', 10 );

	if ( ( $posts_per_page % 3 ) == 0 ) {
		return;
	}

	$options = get_option( 'portfolioplus', false );

	if ( isset( $options['post_per_page_ignore'] ) ) {
		return;
	}

	if ( current_user_can( 'manage_options' ) ) {
		echo '<div class="updated"><p>';
			printf( __(
				'Portfolio Press recommends setting posts per page to 9. This can be changed under <a href="%3$s">Settings > Reading Options</a>.<br><a href="%1$s">Update It</a> | <a href="%2$s">Dismiss Notice</a>.' ),
				'?portfolio_update_posts_per_page=1',
				'?portfolio_post_per_page_ignore=1',
				admin_url( 'options-reading.php', false ) );
		echo '</p></div>';
	}
}
add_action( 'admin_notices', 'portfolioplus_posts_per_page_notice', 120 );

/**
 * Hides notices if user chooses to dismiss it
 */
function portfolioplus_notice_ignores() {

	$options = get_option( 'portfolioplus' );

	if ( isset( $_GET['portfolio_upgrade_notice_ignore'] ) && '1' == $_GET['portfolio_upgrade_notice_ignore'] ) {
		$options['upgrade-3-0'] = false;
		update_option( 'portfolioplus', $options );
	}

	if ( isset( $_GET['portfolio_post_per_page_ignore'] ) && '1' == $_GET['portfolio_post_per_page_ignore'] ) {
		$options['post_per_page_ignore'] = false;
		update_option( 'portfolioplus', $options );
	}

	if ( isset( $_GET['portfolio_update_posts_per_page'] ) && '1' == $_GET['portfolio_update_posts_per_page'] ) {
		update_option( 'posts_per_page', 9 );
	}

}
add_action( 'admin_init', 'portfolioplus_notice_ignores' );

/**
 * Removes page templates that require the Portfolio Post Type.
 *
 * This is a backwards compatible hack for removing un-necessary
 * page templates.  Will be removed in next version of theme.
 * See: https://core.trac.wordpress.org/ticket/13265
 *
 * @param string $hook
 */
function portfolioplus_page_template_mod( $hook ) {
	global $wp_version;
	if ( class_exists( 'Portfolio_Post_Type' ) )
        return;
    if ( version_compare( $wp_version, '3.8.2', '>' ) ) {
    	return;
    }
    if ( 'post.php' != $hook )
        return;
    wp_enqueue_script( 'portfolioplus_page_template_mod', esc_url( get_template_directory_uri() . '/js/admin-page-template-mod.js' ) );
}
add_action( 'admin_enqueue_scripts', 'portfolioplus_page_template_mod' );

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
function portfoliopress_remove_caption_padding( $width ) {
    return $width - 10;
}
add_filter( 'img_caption_shortcode_width', 'portfoliopress_remove_caption_padding' );