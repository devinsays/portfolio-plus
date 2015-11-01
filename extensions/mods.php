<?php
/**
 * Implements specific functionality based on option selections.
 *
 * @package 	Portfolio+
 * @author		Devin Price
 */

if ( ! function_exists( 'portfolioplus_get_option' ) ) :
/**
 * Helper function to return saved options.
 *
 * @param	string	$name		The id to return from the option array.
 * @param	mixed	$default	Default value to return.
 * @return	mixed				Option value or default.
 */
function portfolioplus_get_option( $name, $default = false ) {

	$options = get_option( 'portfolioplus' );

	if ( isset( $options[$name] ) ) {
		return $options[$name];
	}

	return $default;
}
endif;

if ( ! function_exists( 'of_get_option' ) ) :
/**
 * Helper function to return saved options.
 * Legacy code and will eventually be deprecated.
 *
 * @param	string	$name		The id to return from the option array.
 * @param	mixed	$default	Default value to return.
 * @return	mixed				Option value or default.
 */
function of_get_option( $name, $default = false ) {

	$options = get_option( 'portfolioplus' );

	if ( isset( $options[$name] ) ) {
		return $options[$name];
	}

	return $default;
}
endif;

/**
 * Adds a body class to indicate sidebar position
 */
function portfolioplus_body_class_options( $classes ) {

	// Layout options
	$classes[] = portfolioplus_get_option( 'layout','layout-2cr' );

	// Clear the menu if selected
	if ( portfolioplus_get_option( 'menu_position', false ) == 'clear' ) {
		$classes[] = 'clear-menu';
	}

	if ( portfolioplus_post_template() ) {
		$classes[] = 'full-width';
	}

	return $classes;
}
add_filter( 'body_class', 'portfolioplus_body_class_options' );

/**
 * Determine if post template is set to full width.
 */
function portfolioplus_post_template() {

	if ( portfolioplus_get_option( 'layout' ) == 'layout-1col' ) {
		return false;
	}

	if ( is_singular() ) {
		$post_template = get_post_meta( get_the_ID(), 'portfolioplus_post_template', true );
		if ( 'full-width' == $post_template ) {
			return true;
		}
	}
	return false;
}

/**
 * Infinite Scroll
 */
function portfolioplus_infinite_scroll_js() {
    if ( !is_single() && portfolioplus_get_option( 'infinite_scroll', true ) ) { ?>
	    <script>
	    var infinite_scroll = {
	        loading: {
	            img: "<?php echo get_template_directory_uri(); ?>/images/spinner.gif",
	            msgText: "",
	            finishedMsg: "<?php _e( 'All items have loaded.', 'portfolio-plus' ); ?>",
	            speed: 'slow'
	        },
	        "nextSelector":".nav-previous a",
	        "navSelector":"#nav-below",
	        "itemSelector":".hentry",
	        "contentSelector":"#content"
	    };
	    jQuery( infinite_scroll.contentSelector ).infinitescroll( infinite_scroll, function( elements ) {
	    	// Jetpack Infinite Scroll also uses this callback
		    jQuery('body').trigger( 'post-load' );
	    });
	    </script>
	    <?php
    }
}
add_action( 'wp_footer', 'portfolioplus_infinite_scroll_js', 100 );

/**
 * Removes image and gallery post formats from is_home if option is set
 */
function portfolioplus_exclude_post_formats( $query ) {
	if (
		! portfolioplus_get_option( 'display_image_gallery_post_formats', true ) &&
		$query->is_main_query() &&
		$query->is_home()
	) {
		$tax_query = array(
			array(
				'taxonomy' => 'post_format',
				'field' => 'slug',
				'terms' => array(
					'post-format-image',
					'post-format-gallery'
				),
				'operator' => 'NOT IN',
			)
		);
		$query->set( 'tax_query', $tax_query );
	}
}
add_action( 'pre_get_posts', 'portfolioplus_exclude_post_formats' );