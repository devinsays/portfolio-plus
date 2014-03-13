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
 * Output the inline css used for theme options
 */
function portfolioplus_inline_css() {

	// If custom styles are turned off, return early
	if ( of_get_option( 'disable_styles', false ) ) {
		return;
	}

	$output = '';

	if ( of_get_option( 'body_color' ) ) {
		$output .= 'body, #content blockquote, #commentform .form-allowed-tags { color:' . of_get_option('body_color') . "; }\n";
	}

	if ( of_get_option( 'link_color' ) ) {
		$output .= 'a:link, a:visited { color:' . of_get_option('link_color') . "; }\n";
	}

	if ( of_get_option( 'link_hover_color' ) ) {
		$output .= 'a:hover { color:' . of_get_option('link_hover_color') . "; }\n";
	}

	if ( of_get_option( 'site_title_color' ) ) {
		$output .= '#logo #site-title a { color:' . of_get_option('site_title_color') . "; }\n";
	}

	if ( of_get_option( 'tagline_color' ) ) {
		$output .= '#logo #site-description { color:' . of_get_option('tagline_color') . "; }\n";
	}

	if ( of_get_option( 'menu_color' ) ) {
		$output .= '#navigation ul a { color:' . of_get_option('menu_color') . "; }\n";
		$output .= '#navigation .menu-toggle { color:' . of_get_option('menu_color') . "; }\n";
	}

	if ( of_get_option( 'header_color' ) ) {
		$output .= 'h1, h2, h3, h4, h5, h6, #comments h3 { color:' . of_get_option('header_color') . "; }\n";
	}

	if ( of_get_option( 'widget_header_color' ) ) {
		$output .= '.widget-container h3 { color:' . of_get_option('widget_header_color') . "; }\n";
	}

	if ( of_get_option( 'border_color' ) != '#dddddd' ) {
		$output .= '#content .entry-header, .widget-container h3 { border-bottom-color:' . of_get_option('border_color') . "; box-shadow:none; }\n";
		$output .= '.archive-title:after, .archive-meta:after, footer.entry-meta:before, footer.entry-meta:after, #comments:before { background:' . of_get_option('border_color') . "; box-shadow:none; }\n";

	}

	if ( of_get_option( 'footer_color' ) ) {
		$output .= '#colophon #site-generator p { color:' . of_get_option('footer_color') . "; }\n";
	}

	if ( of_get_option( 'header_bg' ) ) {
		$output .= portfolioplus_output_bg( '#branding', of_get_option('header_bg'), array('color'=>'#000000') );
	}

	$main_bg = of_get_option( 'main_bg' );
	if ( $main_bg ) {
		$output .= portfolioplus_output_bg( '#main', of_get_option('main_bg'), array('color'=>'#f3f3f3') );
		if ( $main_bg['color'] != '#f3f3f3' ) {
			$output .= "#content .entry-title, .widget-container h3, #nav-below { text-shadow: none; }\n";
		}
	}

	if ( of_get_option( 'footer_bg' ) ) {
		$output .= portfolioplus_output_bg( 'body', of_get_option('footer_bg'), array( 'color'=>'#ffffff' ) );
	}

	if ( of_get_option( 'menu_position' ) == "clear") {
		$output .= "#navigation { clear:both; float:none; margin-left:-10px; }\n";
		$output .= "#navigation ul li { margin-left:0; margin-right:10px; }\n";
	}

	// Output styles
	if ( $output <> '' ) {
		$output = "\n<!-- Portfolio+ Styling -->\n<style type=\"text/css\">\n" . $output . "</style>\n";
		echo $output;
	}
}
add_action('wp_head', 'portfolioplus_inline_css');

/**
 * Helper function for outputting background CSS
 *
 * @param string selector
 * @param array option
 * @param array default
 */
function portfolioplus_output_bg( $selector, $option, $default ) {
	$output = '';
	if ( $option['color'] != $default['color'] ) {
		$output .= 'background:' . $option['color'] . '; ';
	}
	if ( isset( $option['image'] ) && $option['image'] != '' ) {
		$output .= 'background-image: url("' . $option['image'] . '"); ';
		$output .= 'background-repeat:' . $option['repeat'] . '; ';
		$output .= 'background-position:' . $option['position'] . '; ';
		$output .= 'background-attachment:' . $option['attachment'] . '; ';
	}
	if ( $output != '' ) {
		$output = $selector . " { " .$output . "}\n";
	}
	return $output;
}

/**
 * Removes image and gallery post formats from is_home if option is set
 */
function portfolioplus_exclude_post_formats( $query ) {
	if (
		! of_get_option( 'display_image_gallery_post_formats', true ) &&
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

	$wp_customize->add_setting( 'portfolioplus[tagline]', array(
		'default' => '1',
		'type' => 'option'
	) );

	if ( !of_get_option('logo') ) {
		$wp_customize->add_control( 'portfolioplus_tagline', array(
			'label' => $options['tagline']['name'],
			'section' => 'title_tagline',
			'settings' => 'portfolioplus[tagline]',
			'type' => 'checkbox'
		) );
	}

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
		'title' => __( 'Header Styles', 'portfolioplus' ),
		'priority' => 105,
	) );

	$wp_customize->add_setting( 'portfolioplus[header_bg][color]', array(
		'default' => '#000000',
		'type' => 'option'
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'header_bg_color', array(
		'label' => __( 'Background Color', 'portfolioplus' ),
		'section' => 'portfolioplus_header_styles',
		'settings'   => 'portfolioplus[header_bg][color]'
	) ) );

	/* PostMessage Support */
	$wp_customize->get_setting( 'portfolioplus[header_bg][color]' )->transport = 'postMessage';

	$wp_customize->add_setting( 'portfolioplus[site_title_color]', array(
		'default' => '#ffffff',
		'type' => 'option'
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'site_title_color', array(
		'label' => $options['site_title_color']['desc'],
		'section' => 'portfolioplus_header_styles',
		'settings' => 'portfolioplus[site_title_color]'
	) ) );

	/* PostMessage Support */
	$wp_customize->get_setting( 'portfolioplus[site_title_color]' )->transport = 'postMessage';

	$wp_customize->add_setting( 'portfolioplus[tagline_color]', array(
		'default' => '#dddddd',
		'type' => 'option'
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'tagline_color', array(
		'label' => $options['tagline_color']['desc'],
		'section' => 'portfolioplus_header_styles',
		'settings' => 'portfolioplus[tagline_color]'
	) ) );

	/* PostMessage Support */
	$wp_customize->get_setting( 'portfolioplus[tagline_color]' )->transport = 'postMessage';

	$wp_customize->add_setting( 'portfolioplus[menu_color]', array(
		'default' => '#ffffff',
		'type' => 'option'
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'menu_color', array(
		'label' => $options['menu_color']['desc'],
		'section' => 'portfolioplus_header_styles',
		'settings' => 'portfolioplus[menu_color]'
	) ) );

	/* PostMessage Support */
	$wp_customize->get_setting( 'portfolioplus[menu_color]' )->transport = 'postMessage';

	/* Body Styles */

	$wp_customize->add_section( 'portfolioplus_body_styles', array(
		'title' => __( 'Body Styles', 'portfolioplus' ),
		'priority' => 110,
	) );

	$wp_customize->add_setting( 'portfolioplus[main_bg][color]', array(
		'default' => '#f3f3f3',
		'type' => 'option'
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'main_bg_color', array(
		'label' => $options['main_bg']['name'],
		'section' => 'portfolioplus_body_styles',
		'settings' => 'portfolioplus[main_bg][color]'
	) ) );

	$wp_customize->add_setting( 'portfolioplus[body_color]', array(
		'default' => '#555555',
		'type' => 'option',
		'sanitize_callback' => 'sanitize_hex_color'
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'body_color', array(
		'label' => $options['body_color']['name'],
		'section' => 'portfolioplus_body_styles',
		'settings' => 'portfolioplus[body_color]',
	) ) );

	$wp_customize->add_setting( 'portfolioplus[link_color]', array(
		'default' => '#106177',
		'type' => 'option'
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'link_color', array(
		'label' => $options['link_color']['desc'],
		'section' => 'portfolioplus_body_styles',
		'settings' => 'portfolioplus[link_color]',
	) ) );

	$wp_customize->add_setting( 'portfolioplus[link_hover_color]', array(
		'default' => '#106177',
		'type' => 'option'
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'link_hover_color', array(
		'label' => $options['link_hover_color']['desc'],
		'section' => 'portfolioplus_body_styles',
		'settings' => 'portfolioplus[link_hover_color]'
	) ) );

	$wp_customize->add_setting( 'portfolioplus[header_color]', array(
		'default' => '#111111',
		'type' => 'option'
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'header_color', array(
		'label' => $options['header_color']['name'],
		'section' => 'portfolioplus_body_styles',
		'settings' => 'portfolioplus[header_color]'
	) ) );

	$wp_customize->add_setting( 'portfolioplus[widget_header_color]', array(
		'default' => '#555555',
		'type' => 'option'
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'widget_header_color', array(
		'label' => $options['widget_header_color']['name'],
		'section' => 'portfolioplus_body_styles',
		'settings' => 'portfolioplus[widget_header_color]'
	) ) );

	$wp_customize->add_setting( 'portfolioplus[border_color]', array(
		'default' => '#dddddd',
		'type' => 'option'
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'border_color', array(
		'label' => $options['border_color']['name'],
		'section' => 'portfolioplus_body_styles',
		'settings' => 'portfolioplus[border_color]'
	) ) );

	/* Footer Styles */

	$wp_customize->add_section( 'portfolioplus_footer_styles', array(
		'title' => __( 'Footer Styles', 'portfolioplus' ),
		'priority' => 115
	) );

	$wp_customize->add_setting( 'portfolioplus[footer_bg][color]', array(
		'default' => '#ffffff',
		'type' => 'option'
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'footer_bg_color', array(
		'label' => __( 'Footer Background Color', 'portfolioplus' ),
		'section' => 'portfolioplus_footer_styles',
		'settings' => 'portfolioplus[footer_bg][color]'
	) ) );

	$wp_customize->add_setting( 'portfolioplus[footer_color]', array(
		'default' => '#333333',
		'type' => 'option'
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'footer_color', array(
		'label' => $options['footer_color']['name'],
		'section' => 'portfolioplus_footer_styles',
		'settings' => 'portfolioplus[footer_color]'
	) ) );

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