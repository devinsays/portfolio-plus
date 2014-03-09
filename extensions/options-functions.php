<?php
/**
 * @package Portfolio+
 */

/**
 * Helper function to get options set by the Options Framework plugin
 */
if ( !function_exists( 'of_get_option' ) ) :
function of_get_option( $name, $default = false ) {

	$optionsframework_settings = get_option( 'optionsframework' );

	// Gets the unique option id
	$option_name = $optionsframework_settings['id'];

	if ( get_option($option_name) ) {
		$options = get_option($option_name);
	}

	if ( isset($options[$name]) ) {
		return $options[$name];
	} else {
		return $default;
	}
}
endif;

/**
 * Additional content to display after the options panel
 */
function portfolioplus_panel_info() { ?>
    <p style="color: #777;">
    <?php printf(
    	'Theme <a href="%s">documentation</a>.  For additional options, see <a href="%s">Portfolio+</a>.',
    	esc_url( 'http://wptheming.com/portfolio-theme' ),
    	esc_url( 'http://wptheming.com/portfolio-plus' )
    );
    ?>
    </p>
<?php }

add_action( 'optionsframework_after', 'portfolioplus_panel_info', 100 );

/**
 * Adds a body class to indicate sidebar position
 */
function portfolioplus_body_class_options( $classes ) {

	// Layout options
	$classes[] = of_get_option( 'layout','layout-2cr' );

	// Clear the menu if selected
	if ( of_get_option( 'menu_position', false ) == 'clear' ) {
		$classes[] = 'clear-menu';
	}

	return $classes;
}
add_filter( 'body_class', 'portfolioplus_body_class_options' );

/**
 * Favicon Option
 */
function portfolio_favicon() {
	$favicon = of_get_option( 'custom_favicon', false );
	if ( $favicon ) {
        echo '<link rel="shortcut icon" href="' . esc_url( $favicon ) . '"/>'."\n";
    }
}
add_action( 'wp_head', 'portfolio_favicon' );

/**
 * Menu Position Option
 */
function portfolio_head_css() {

		$output = '';

		if ( of_get_option( 'header_color' ) != "#000000") {
			$output .= "#branding {background:" . of_get_option('header_color') . "}\n";
		}

		// Output styles
		if ($output <> '') {
			$output = "<!-- Custom Styling -->\n<style type=\"text/css\">\n" . $output . "</style>\n";
			echo $output;
		}
}

add_action( 'wp_head', 'portfolio_head_css' );

/**
 * Removes image and gallery post formats from is_home if option is set
 */
function portfolioplus_exclude_post_formats( $query ) {
	if (
		of_get_option( 'display_image_gallery_post_formats', false ) &&
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

/**
 * Infinite Scroll
 */
function portfolioplus_infinite_scroll_js() {
    if ( !is_single() && of_get_option( 'infinite_scroll', true ) ) { ?>
	    <script>
	    var infinite_scroll = {
	        loading: {
	            img: "<?php echo get_template_directory_uri(); ?>/images/spinner.gif",
	            msgText: "",
	            finishedMsg: "<?php _e( 'All items have loaded.', 'portfolioplus' ); ?>",
	            speed: 'slow'
	        },
	        "nextSelector":".nav-previous a",
	        "navSelector":"#nav-below",
	        "itemSelector":"article",
	        "contentSelector":"#content"
	    };
	    jQuery( infinite_scroll.contentSelector ).infinitescroll( infinite_scroll, function( elements ) {
		    // Empty callback
	    });
	    </script>
	    <?php
    }
}
add_action( 'wp_footer', 'portfolioplus_infinite_scroll_js', 100 );

/**
 * Front End Customizer
 *
 * WordPress 3.4 Required
 */

if ( function_exists( 'optionsframework_init' ) ) {
	add_action( 'customize_register', 'portfolioplus_customize_register' );
}

function portfolioplus_customize_register( $wp_customize ) {

	$options = optionsframework_options();

	/* Title & Tagline */

	$wp_customize->add_setting( 'portfolioplus[logo]', array(
		'type' => 'option'
	) );

	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'logo', array(
		'label' => $options['logo']['name'],
		'section' => 'title_tagline',
		'settings' => 'portfolioplus[logo]'
	) ) );

	/* Layout */

	$wp_customize->add_section( 'portfolioplus_layout', array(
		'title' => __( 'Layout', 'portfolioplus' ),
		'priority' => 100,
	) );

	$wp_customize->add_setting( 'portfolioplus[layout]', array(
		'default' => 'layout-2cr',
		'type' => 'option'
	) );

	$wp_customize->add_control( 'portfolioplus_layout', array(
		'label' => $options['layout']['name'],
		'section' => 'portfolioplus_layout',
		'settings' => 'portfolioplus[layout]',
		'type' => 'radio',
		'choices' => array(
			'layout-2cr' => 'Sidebar Right',
			'layout-2cl' => 'Sidebar Left',
			'layout-1col' => 'Single Column')
	) );

	$wp_customize->add_setting( 'portfolioplus[menu_position]', array(
		'default' => 'right',
		'type' => 'option'
	) );

	$wp_customize->add_control( 'portfolioplus_menu_position', array(
		'label' => $options['menu_position']['name'],
		'section' => 'nav',
		'settings' => 'portfolioplus[menu_position]',
		'type' => 'radio',
		'choices' => $options['menu_position']['options']
	) );

	/* Header Styles */

	$wp_customize->add_section( 'portfolioplus_header_styles', array(
		'title' => __( 'Header Style', 'portfolioplus' ),
		'priority' => 105,
	) );

	$wp_customize->add_setting( 'portfolioplus[header_color]', array(
		'default' => '#000000',
		'type' => 'option'
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'header_color', array(
		'label' => __( 'Background Color', 'portfolioplus' ),
		'section' => 'portfolioplus_header_styles',
		'settings' => 'portfolioplus[header_color]'
	) ) );

	/* PostMessage Support */
	$wp_customize->get_setting( 'portfolioplus[header_color]' )->transport = 'postMessage';
}

/**
 * Register asynchronous customizer support for core controls.
 */
function portfolioplus_async_suport_core( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
}
add_action( 'customize_register', 'portfolioplus_async_suport_core' );

/**
 * Enqueue script enabling asynchronous customizer support.
 */
function portfolioplus_customize_preview_js() {
	wp_enqueue_script( 'portfolioplus_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20140221', true );
}
add_action( 'customize_preview_init', 'portfolioplus_customize_preview_js' );
