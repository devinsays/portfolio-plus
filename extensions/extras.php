<?php
/**
 * @package Portfolio+
 */

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
		$update_url  = wp_nonce_url( add_query_arg( 'portfolio_update_posts_per_page', '1', admin_url() ), 'portfolioplus_update_posts_per_page' );
		$dismiss_url = wp_nonce_url( add_query_arg( 'portfolio_post_per_page_ignore', '1', admin_url() ), 'portfolioplus_post_per_page_ignore' );

		echo '<div class="updated"><p>';
			printf( __(
				'Portfolio+ recommends setting posts per page to 9. This can be changed under <a href="%3$s">Settings > Reading Options</a>.<br><a href="%1$s">Update It</a> | <a href="%2$s">Dismiss Notice</a>.', 'portfolio-plus' ),
				esc_url( $update_url ),
				esc_url( $dismiss_url ),
				admin_url( 'options-reading.php' ) );
		echo '</p></div>';
	}
}
add_action( 'admin_notices', 'portfolioplus_posts_per_page_notice', 120 );

/**
 * Hides notices if user chooses to dismiss it
 */
function portfolioplus_notice_ignores() {

	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$options = get_option( 'portfolioplus' );

	if ( isset( $_GET['portfolio_post_per_page_ignore'] ) && '1' == $_GET['portfolio_post_per_page_ignore'] ) {
		check_admin_referer( 'portfolioplus_post_per_page_ignore' );
		$options['post_per_page_ignore'] = 1;
		update_option( 'portfolioplus', $options );
	}

	if ( isset( $_GET['portfolio_update_posts_per_page'] ) && '1' == $_GET['portfolio_update_posts_per_page'] ) {
		check_admin_referer( 'portfolioplus_update_posts_per_page' );
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
	if ( ! class_exists( 'Portfolio_Post_Type' ) ) {
		unset( $templates['templates/portfolio.php'] );
		unset( $templates['templates/full-width-portfolio.php'] );
		unset( $templates['templates/portfolio-categories.php'] );
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