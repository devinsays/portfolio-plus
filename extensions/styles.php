<?php
/**
 * Implements styles set in the theme customizer
 *
 * @package Portfolio Plus
 */

if ( ! function_exists( 'portfolioplus_styles' ) && class_exists( 'Customizer_Library_Styles' ) ) :
/**
 * Process user options to generate CSS needed to implement the choices.
 *
 * @since  1.0.0.
 *
 * @return void
 */
function portfolioplus_styles() {

	// Body Color
	$setting = 'body_color';
	$mod = portfolioplus_get_option( $setting, customizer_library_get_default( $setting ) );

	if ( $mod !== customizer_library_get_default( $setting ) ) {

		$color = sanitize_hex_color( $mod );

		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'body, #content blockquote, #commentform .form-allowed-tags'
			),
			'declarations' => array(
				'color' => $color
			)
		) );

	}

	// Link Color
	$setting = 'link_color';
	$mod = portfolioplus_get_option( $setting, customizer_library_get_default( $setting ) );

	if ( $mod !== customizer_library_get_default( $setting ) ) {

		$color = sanitize_hex_color( $mod );

		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'a:link, a:visited'
			),
			'declarations' => array(
				'color' => $color
			)
		) );

	}

	// Site Title Color
	$setting = 'site_title_color';
	$mod = portfolioplus_get_option( $setting, customizer_library_get_default( $setting ) );

	if ( $mod !== customizer_library_get_default( $setting ) ) {

		$color = sanitize_hex_color( $mod );

		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'#logo #site-title a'
			),
			'declarations' => array(
				'color' => $color
			)
		) );

	}

	// Tagline Color
	$setting = 'tagline_color';
	$mod = portfolioplus_get_option( $setting, customizer_library_get_default( $setting ) );

	if ( $mod !== customizer_library_get_default( $setting ) ) {

		$color = sanitize_hex_color( $mod );

		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'#logo #site-description'
			),
			'declarations' => array(
				'color' => $color
			)
		) );

	}

	// Header Border Color
	$setting = 'header_border_color';
	$mod = portfolioplus_get_option( $setting, customizer_library_get_default( $setting ) );

	if ( $mod !== customizer_library_get_default( $setting ) ) {

		$color = sanitize_hex_color( $mod );

		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'#branding'
			),
			'declarations' => array(
				'border-bottom-color' => $color
			)
		) );

	}

	// Menu Color
	$setting = 'menu_color';
	$mod = portfolioplus_get_option( $setting, customizer_library_get_default( $setting ) );

	if ( $mod !== customizer_library_get_default( $setting ) ) {

		$color = sanitize_hex_color( $mod );

		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'#navigation ul a',
				'#navigation .menu-toggle'
			),
			'declarations' => array(
				'color' => $color
			)
		) );

	}

	// Headings Color
	$setting = 'header_color';
	$mod = portfolioplus_get_option( $setting, customizer_library_get_default( $setting ) );

	if ( $mod !== customizer_library_get_default( $setting ) ) {

		$color = sanitize_hex_color( $mod );

		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'h1, h2, h3, h4, h5, h6, #comments h3'
			),
			'declarations' => array(
				'color' => $color
			)
		) );

	}

	// Widget Headings Color
	$setting = 'widget_header_color';
	$mod = portfolioplus_get_option( $setting, customizer_library_get_default( $setting ) );

	if ( $mod !== customizer_library_get_default( $setting ) ) {

		$color = sanitize_hex_color( $mod );

		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'.widget-container h3'
			),
			'declarations' => array(
				'color' => $color
			)
		) );

	}

	// Border Color
	$setting = 'border_color';
	$mod = portfolioplus_get_option( $setting, customizer_library_get_default( $setting ) );

	if ( $mod !== customizer_library_get_default( $setting ) ) {

		$color = sanitize_hex_color( $mod );

		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'#content .entry-header, .widget-container h3'
			),
			'declarations' => array(
				'border-bottom-color' => $color,
				'box-shadow' => 'none'
			)
		) );

		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'.archive-title:after, .archive-meta:after, footer.entry-meta:before, footer.entry-meta:after, #comments:before'
			),
			'declarations' => array(
				'background' => $color,
				'box-shadow' => 'none'
			)
		) );

	}

	// Footer Border Color
	$setting = 'footer_border_color';
	$mod = portfolioplus_get_option( $setting, customizer_library_get_default( $setting ) );

	if ( $mod !== customizer_library_get_default( $setting ) ) {

		$color = sanitize_hex_color( $mod );

		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'#colophon'
			),
			'declarations' => array(
				'border-top-color' => $color
			)
		) );

	}

	// Footer Color
	$setting = 'footer_color';
	$mod = portfolioplus_get_option( $setting, customizer_library_get_default( $setting ) );

	if ( $mod !== customizer_library_get_default( $setting ) ) {

		$color = sanitize_hex_color( $mod );

		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'#colophon #site-generator p'
			),
			'declarations' => array(
				'color' => $color
			)
		) );

	}

	/*
	if ( of_get_option( 'header_bg' ) ) {
		$output .= portfolioplus_output_bg( '#branding', of_get_option('header_bg'), array('color'=>'#000000') );
	}

	$main_bg = of_get_option( 'main_bg' );
	if ( $main_bg ) {
		$output .= portfolioplus_output_bg( 'body', of_get_option('main_bg'), array('color'=>'#f6f6f6') );
		if ( $main_bg['color'] != '#f6f6f6' ) {
			$output .= "#content .entry-title, .widget-container h3, #nav-below { text-shadow: none; }\n";
		}
	}

	if ( of_get_option( 'footer_bg' ) ) {
		$output .= portfolioplus_output_bg( '#colophon', of_get_option('footer_bg'), array( 'color'=>'#ffffff' ) );
	}
	*/

	// Footer Color
	$setting = 'menu_position';
	$mod = portfolioplus_get_option( $setting, customizer_library_get_default( $setting ) );

	if ( $mod !== customizer_library_get_default( $setting ) ) {

		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'#navigation'
			),
			'declarations' => array(
				'clear' => 'both',
				'float' => 'none',
				'margin-left' => '-10px',
			)
		) );

		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'#navigation ul li'
			),
			'declarations' => array(
				'margin-left' => '0px',
				'margin-right' => '10px',
			)
		) );

	}


}
endif;

add_action( 'customizer_library_styles', 'portfolioplus_styles' );

if ( ! function_exists( 'portfolioplus_display_customizations' ) ) :
/**
 * Generates the style tag and CSS needed for the theme options.
 *
 * By using the "Customizer_Library_Styles" filter, different components can print CSS in the header.
 * It is organized this way to ensure there is only one "style" tag.
 *
 * @since  1.0.0.
 *
 * @return void
 */
function portfolioplus_display_customizations() {

	// If custom styles are turned off, return early
	if ( of_get_option( 'disable_styles', false ) ) {
		return;
	}

	do_action( 'customizer_library_styles' );

	// Echo the rules
	$css = Customizer_Library_Styles()->build();

	if ( ! empty( $css ) ) {
		echo "\n<!-- Begin Portfolio+ Custom CSS -->\n<style type=\"text/css\" id=\"gather-custom-css\">\n";
		echo $css;
		echo "\n</style>\n<!-- End Portfolio+ Custom CSS -->\n";
	}
}
endif;

add_action( 'wp_head', 'portfolioplus_display_customizations', 11 );

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