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

	// Body Background
	$setting = 'main_bg';
	$background = portfolioplus_get_option( $setting, array( 'color' => '#f6f6f6' ) );
	$color = sanitize_hex_color( $background['color'] );

	Customizer_Library_Styles()->add( array(
		'selectors' => array(
			'#main'
		),
		'declarations' => array(
			'background' => $color
		)
	) );

	if ( '#f6f6f6' != $color ) :
		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'#content .entry-title',
				'.widget-container h3',
				'#nav-below'

			),
			'declarations' => array(
				'text-shadow' => 'none'
			)
		) );
	endif;

	if ( isset( $background['image'] ) && $background['image'] !== '' ) {

		$image = esc_url( $background['image'] );

		$declarations = array();
		$declarations['background-image'] = 'url("' . $image. '")';

		if ( isset( $background['repeat'] ) ) {
			$declarations['background-repeat'] = $background['repeat'];
		}
		if ( isset( $background['size'] ) ) {
			$declarations['background-size'] = $background['size'];
		}
		if ( isset( $background['attach'] ) ) {
			$declarations['background-attachment'] = $background['attach'];
		}
		if ( isset( $background['repeat'] ) ) {
			$declarations['background-position'] = $background['position'];
		}

		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'#main'
			),
			'declarations' => $declarations
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

	// Header Background
	$setting = 'header_bg';
	$defaults = array(
		'color' => '#000000',
		'image' => ''
	);
	$background = portfolioplus_get_option( $setting, $defaults );

	if ( $background['color'] !== '#000000' ) {

		$color = sanitize_hex_color( $background['color'] );

		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'#branding'
			),
			'declarations' => array(
				'background' => $color
			)
		) );

	}

	if ( isset( $background['image'] ) && $background['image'] !== '' ) {

		$image = esc_url( $background['image'] );

		$declarations = array();
		$declarations['background-image'] = 'url("' . $image. '")';

		if ( isset( $background['repeat'] ) ) {
			$declarations['background-repeat'] = $background['repeat'];
		}
		if ( isset( $background['repeat'] ) ) {
			$declarations['background-size'] = $background['size'];
		}
		if ( isset( $background['attach'] ) ) {
			$declarations['background-attachment'] = $background['attach'];
		}
		if ( isset( $background['repeat'] ) ) {
			$declarations['background-position'] = $background['position'];
		}

		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'#branding'
			),
			'declarations' => $declarations
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

	// Footer Background
	$setting = 'footer_bg';
	$background = portfolioplus_get_option( $setting, array( 'color' => '#ffffff' ) );

	if ( $background['color'] !== '#ffffff' ) {

		$color = sanitize_hex_color( $background['color'] );

		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'#colophon'
			),
			'declarations' => array(
				'background' => $color
			)
		) );

	}

	if ( isset( $background['image'] ) && $background['image'] !== '' ) {

		$image = esc_url( $background['image'] );

		$declarations = array();
		$declarations['background-image'] = 'url("' . $image. '")';

		if ( isset( $background['repeat'] ) ) {
			$declarations['background-repeat'] = $background['repeat'];
		}
		if ( isset( $background['size'] ) ) {
			$declarations['background-size'] = $background['size'];
		}
		if ( isset( $background['attach'] ) ) {
			$declarations['background-attachment'] = $background['attach'];
		}
		if ( isset( $background['repeat'] ) ) {
			$declarations['background-position'] = $background['position'];
		}

		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'#colophon'
			),
			'declarations' => $declarations
		) );

	}

	// Menu Position
	$setting = 'menu_position';

	if ( 'clear' == customizer_library_get_default( $setting ) ) {

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
	if ( portfolioplus_get_option( 'disable_styles', false ) ) {
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