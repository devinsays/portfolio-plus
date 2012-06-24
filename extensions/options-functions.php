<?php
/**
 * @package WordPress
 * @subpackage Portfolio Press
 */
 
/**
 * Theme options require the "Options Framework" plugin to be installed in order to display.
 * If it's not installed, default settings will be used.
 */
 
if ( !function_exists( 'of_get_option' ) ) {
function of_get_option($name, $default = false) {
	
	$optionsframework_settings = get_option('optionsframework');
	
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
}

if ( !function_exists( 'optionsframework_add_page' ) && current_user_can('edit_theme_options') ) {
	function portfolio_options_default() {
		add_theme_page(__('Theme Options','portfoliopress'), __('Theme Options','portfoliopress'), 'edit_theme_options', 'options-framework','optionsframework_page_notice');
	}
	add_action('admin_menu', 'portfolio_options_default');
}

/**
 * Displays a notice on the theme options page if the Options Framework plugin is not installed
 */

if ( !function_exists( 'optionsframework_page_notice' ) ) {
	function optionsframework_page_notice() { ?>
	
		<div class="wrap">
		<?php screen_icon( 'themes' ); ?>
		<h2><?php _e('Theme Options','portfoliopress'); ?></h2>
        <p><b><?php printf( __( 'If you would like to use the Portfolio Press theme options, please install the %s plugin.', 'portfoliopress' ), '<a href="http://wordpress.org/extend/plugins/options-framework/">Options Framework</a>' ); ?></b></p>
		</div>
	<?php
	}
}

/**
 * Adds a body class to indicate sidebar position
 */
 
function portfolio_body_class($classes) {
	$layout = of_get_option('layout','layout-2cr');
	$classes[] = $layout;
	return $classes;
}

add_filter('body_class','portfolio_body_class');

/**
 * Favicon Option
 */

function portfolio_favicon() {
	$favicon = of_get_option('custom_favicon', false);
	if ( $favicon ) {
        echo '<link rel="shortcut icon" href="'.  $favicon  .'"/>'."\n";
    }
}

add_action('wp_head', 'portfolio_favicon');

/**
 * Output the inline CSS styles
 */

function portfolio_head_css() {
				
		$output = '';
		
		// Typography Options
		
		if ( of_get_option('body_color') ) {
			$output .= 'body, #content blockquote, #commentform .form-allowed-tags { color:' . of_get_option('body_color') . "; }\n";
		}
		
		if ( of_get_option('link_color') ) {
			$output .= 'a:link, a:visited { color:' . of_get_option('link_color') . "; }\n";
		}
		
		if ( of_get_option('link_hover_color') ) {
			$output .= 'a:hover { color:' . of_get_option('link_hover_color') . "; }\n";
		}
		
		if ( of_get_option('site_title_color') ) {
			$output .= '#logo #site-title a { color:' . of_get_option('site_title_color') . "; }\n";
		}
		
		if ( of_get_option('tagline_color') ) {
			$output .= '#logo #site-description { color:' . of_get_option('tagline_color') . "; }\n";
		}
		
		if ( of_get_option('menu_color') ) {
			$output .= '#navigation ul a { color:' . of_get_option('menu_color') . "; }\n";
		}
		
		if ( of_get_option('header_color') ) {
			$output .= 'h1, h2, h3, h4, h5, h6, #comments h3 { color:' . of_get_option('header_color') . "; }\n";
		}
		
		if ( of_get_option('widget_header_color') ) {
			$output .= '.widget-container h3 { color:' . of_get_option('widget_header_color') . "; }\n";
		}
		
		if ( of_get_option('border_color') ) {
			$output .= '#content .entry-title, .widget-container h3 { border-bottom-color:' . of_get_option('border_color') . "; }\n";
		}
		
		if ( of_get_option('footer_color') ) {
			$output .= '#colophon #site-generator p { color:' . of_get_option('footer_color') . "; }\n";
		}
		
		if ( of_get_option('header_bg') ) {
			$output .= portfoliopress_output_bg( '#branding', of_get_option('header_bg'), array('color'=>'#000000') );
		}
		
		if ( of_get_option('main_bg') ) {
			$output .= portfoliopress_output_bg( '#main', of_get_option('main_bg'), array('color'=>'#f3f3f3') );
		}
		
		if ( of_get_option('footer_bg') ) {
			$output .= portfoliopress_output_bg( 'body', of_get_option('footer_bg'), array('color'=>'#ffffff') );
		}
		
		if ( !of_get_option('tagline') ) {
			$output .= "#navigation { padding:5px 0 0; }";
		}
		
		if ( of_get_option('menu_position') == "clear") {
			$output .= "#navigation { clear:both; float:none; margin-left:-10px; }\n";
			$output .= "#navigation ul li { margin-left:0; margin-right:10px; }\n";
		}
		
		// Output styles
		if ($output <> '') {
			$output = "\n<!-- Custom Styling -->\n<style type=\"text/css\">\n" . $output . "</style>\n";
			echo $output;
		}
}

add_action('wp_head', 'portfolio_head_css');

function portfoliopress_output_bg( $selector, $option, $default ) {
	$output = '';
	if ( $option['color'] != $default['color'] ) {
		$output .= 'background:' . $option['color'] . '; ';
	}
	if ( $option['image'] != '' ) {
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
 * Front End Customizer
 *
 * WordPress 3.4 Required
 */

add_action( 'customize_register', 'portfoliopress_customize_register' );

function portfoliopress_customize_register($wp_customize) {

	$wp_customize->add_section( 'portfoliopress_layout', array(
		'title' => __( 'Layout', 'portfoliopress' ),
		'priority' => 100,
	) );
	
	$wp_customize->add_setting( 'portfoliopress[layout]', array(
		'default' => 'layout-2cr',
		'type' => 'option'
	) );

	$wp_customize->add_control( 'portfoliopress_layout', array(
		'label' => __( 'Layout', 'portfoliopress' ),
		'section' => 'portfoliopress_layout',
		'settings' => 'portfoliopress[layout]',
		'type' => 'radio',
		'choices' => array(
			'layout-2cr' => 'Sidebar Right',
			'layout-2cl' => 'Sidebar Left',
			'layout-1col' => 'Single Column')
	) );
	
	$wp_customize->add_setting( 'portfoliopress[menu_position]', array(
		'default' => 'right',
		'type' => 'option'
	) );

	$wp_customize->add_control( 'portfoliopress_menu_position', array(
		'label' => __( 'Menu Position', 'portfoliopress' ),
		'section' => 'nav',
		'settings' => 'portfoliopress[menu_position]',
		'type' => 'select',
		'choices' => array(
			 'right' => 'Right of Logo',
			 'clear' => 'Underneath Logo')
	) );
	
	/* Header Styles */
	
	$wp_customize->add_section( 'portfoliopress_header_styles', array(
		'title' => __( 'Header Styles', 'portfoliopress' ),
		'priority' => 105,
	) );
	
	$wp_customize->add_setting( 'portfoliopress[header_bg][color]', array(
		'default' => '#000000',
		'type' => 'option'
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'header_bg_color', array(
		'label' => __( 'Background Color', 'portfoliopress' ),
		'section' => 'portfoliopress_header_styles',
		'settings'   => 'portfoliopress[header_bg][color]'
	) ) );
	
	$wp_customize->add_setting( 'portfoliopress[header_bg][image]', array(
		'type' => 'option'
	) );
	
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'header_bg_image', array(
		'label' => __( 'Background Image', 'portfoliopress' ),
		'section' => 'portfoliopress_header_styles',
		'settings' => 'portfoliopress[header_bg][image]'
	) ) );
	
	$wp_customize->add_setting( 'portfoliopress[site_title_color]', array(
		'default' => '#ffffff',
		'type' => 'option'
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'site_title_color', array(
		'label' => __( 'Site Title Color', 'portfoliopress' ),
		'section' => 'portfoliopress_header_styles',
		'settings' => 'portfoliopress[site_title_color]'
	) ) );
	
	$wp_customize->add_setting( 'portfoliopress[tagline_color]', array(
		'default' => '#dddddd',
		'type' => 'option'
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'tagline_color', array(
		'label' => __( 'Site Tagline Color', 'portfoliopress' ),
		'section' => 'portfoliopress_header_styles',
		'settings' => 'portfoliopress[tagline_color]'
	) ) );
	
	$wp_customize->add_setting( 'portfoliopress[menu_color]', array(
		'default' => '#ffffff',
		'type' => 'option'
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'menu_color', array(
		'label' => __( 'Menu Text Color', 'portfoliopress' ),
		'section' => 'portfoliopress_header_styles',
		'settings' => 'portfoliopress[menu_color]'
	) ) );
	
	/* Body Styles */
		
	$wp_customize->add_section( 'portfoliopress_body_styles', array(
		'title' => __( 'Body Styles', 'portfoliopress' ),
		'priority' => 110,
	) );
	
	$wp_customize->add_setting( 'portfoliopress[main_bg][color]', array(
		'default' => '#f3f3f3',
		'type' => 'option'
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'main_bg_color', array(
		'label' => __( 'Background Color', 'portfoliopress' ),
		'section' => 'portfoliopress_body_styles',
		'settings' => 'portfoliopress[main_bg][color]'
	) ) );
	
	$wp_customize->add_setting( 'portfoliopress[main_bg][image]', array(
		'type' => 'option'
	) );
	
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'main_bg_image', array(
		'label' => __( 'Background Image', 'portfoliopress' ),
		'section' => 'portfoliopress_body_styles',
		'settings' => 'portfoliopress[main_bg][image]'
	) ) );
	
	$wp_customize->add_setting( 'portfoliopress[body_color]', array(
		'default' => '#555555',
		'type' => 'option',
		'sanitize_callback' => 'sanitize_hex_color'
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'body_color', array(
		'label' => __( 'Body Color', 'portfoliopress' ),
		'section' => 'portfoliopress_body_styles',
		'settings' => 'portfoliopress[body_color]',
	) ) );
	
	$wp_customize->add_setting( 'portfoliopress[link_color]', array(
		'default' => '#106177',
		'type' => 'option'
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'link_color', array(
		'label' => __( 'Link Color', 'portfoliopress' ),
		'section' => 'portfoliopress_body_styles',
		'settings' => 'portfoliopress[link_color]',
	) ) );
	
	$wp_customize->add_setting( 'portfoliopress[link_hover_color]', array(
		'default' => '#106177',
		'type' => 'option'
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'link_hover_color', array(
		'label' => __( 'Link Hover', 'portfoliopress' ),
		'section' => 'portfoliopress_body_styles',
		'settings' => 'portfoliopress[link_hover_color]'
	) ) );
	
	$wp_customize->add_setting( 'portfoliopress[header_color]', array(
		'default' => '#111111',
		'type' => 'option'
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'header_color', array(
		'label' => __( 'Header Colors (H1, H2, H3)', 'portfoliopress' ),
		'section' => 'portfoliopress_body_styles',
		'settings' => 'portfoliopress[header_color]'
	) ) );
	
	$wp_customize->add_setting( 'portfoliopress[widget_header_color]', array(
		'default' => '#555555',
		'type' => 'option'
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'widget_header_color', array(
		'label' => __( 'Sidebar Header Colors (Widgets)', 'portfoliopress' ),
		'section' => 'portfoliopress_body_styles',
		'settings' => 'portfoliopress[widget_header_color]'
	) ) );
	
	$wp_customize->add_setting( 'portfoliopress[border_color]', array(
		'default' => '#dddddd',
		'type' => 'option'
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'border_color', array(
		'label' => __( 'Border Color', 'portfoliopress' ),
		'section' => 'portfoliopress_body_styles',
		'settings' => 'portfoliopress[border_color]'
	) ) );
	
	/* Footer Styles */
	
	$wp_customize->add_section( 'portfoliopress_footer_styles', array(
		'title' => __( 'Footer Styles', 'portfoliopress' ),
		'priority' => 115
	) );
	
	$wp_customize->add_setting( 'portfoliopress[footer_bg][color]', array(
		'default' => '#ffffff',
		'type' => 'option'
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'footer_bg_color', array(
		'label' => __( 'Footer Background Color', 'portfoliopress' ),
		'section' => 'portfoliopress_footer_styles',
		'settings' => 'portfoliopress[footer_bg][color]'
	) ) );
	
	$wp_customize->add_setting( 'portfoliopress[footer_bg][image]', array(
		'type' => 'option'
	) );
	
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'footer_bg_image', array(
		'label' => __( 'Footer Background Image', 'portfoliopress' ),
		'section' => 'portfoliopress_footer_styles',
		'settings' => 'portfoliopress[footer_bg][image]'
	) ) );
	
	$wp_customize->add_setting( 'portfoliopress[footer_color]', array(
		'default' => '#333333',
		'type' => 'option'
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'footer_color', array(
		'label' => __( 'Footer Text Color', 'portfoliopress' ),
		'section' => 'portfoliopress_footer_styles',
		'settings' => 'portfoliopress[footer_color]'
	) ) );
	
}

?>