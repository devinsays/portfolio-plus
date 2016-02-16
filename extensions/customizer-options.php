<?php
/**
 * Portfolio+ Theme Customizer
 *
 * @package Portfolio+
 */

function portfolioplus_options() {

	// Stores all the controls that will be added
	$options = array();

	// Stores all the sections to be added
	$sections = array();

	// Logo section
	$section = 'header';

	$sections[] = array(
		'id' => $section,
		'title' => __( 'Logo Image', 'portfolio-plus' ),
		'priority' => '20'
	);

	$options['portfolioplus[logo]'] = array(
		'id' => 'portfolioplus[logo]',
		'option_type' => 'option',
		'label'   => __( 'Logo', 'portfolio-plus' ),
		'section' => $section,
		'type'    => 'image',
		'default' => '',
	);

	if ( ! portfolioplus_get_option( 'logo' ) ) :

	$options['portfolioplus[tagline]'] = array(
		'id' => 'portfolioplus[tagline]',
		'option_type' => 'option',
		'label' => __( 'Display Site Tagline', 'portfolio-plus' ),
		'description' => 'Display tagline under site title.',
		'section' => $section,
		'type'    => 'checkbox',
		'default' => 1
	);

	endif;

	// Layout
	$section = 'general';

	$sections[] = array(
		'id' => $section,
		'title' => __( 'Layout', 'portfolio-plus' ),
		'priority' => '70'
	);

	$choices = array(
		'layout-2cr' => __( 'Sidebar Right', 'portfolio-plus' ),
		'layout-2cl' => __( 'Sidebar Left', 'portfolio-plus' ),
		'layout-1col' => __( 'Single Column', 'portfolio-plus' )
	);

	$options['portfolioplus[layout]'] = array(
		'id' => 'portfolioplus[layout]',
		'option_type' => 'option',
		'label'   => __( 'Standard Layout', 'portfolio-plus' ),
		'section' => $section,
		'type'    => 'select',
		'choices' => $choices,
		'default' => 'layout-2cr'
	);

	$options['portfolioplus[infinite_scroll]'] = array(
		'id' => 'portfolioplus[infinite_scroll]',
		'option_type' => 'option',
		'label' => __( 'Infinite Scroll', 'portfolio-plus' ),
		'description' => __( 'Load new posts as the user scrolls down.  ("Display Image and Gallery Formats on Posts Page" should be unchecked under the "Portfolio" tab for infinite scroll to work best.)', 'portfolio-plus' ),
		'section' => $section,
		'type'    => 'checkbox',
		'default' => 0
	);

	$options['portfolioplus[display_dates]'] = array(
		'id' => 'portfolioplus[display_dates]',
		'option_type' => 'option',
		'label' => __( 'Display dates', 'portfolio-plus' ),
		'description' => __( 'Display dates on posts.', 'portfolio-plus' ),
		'section' => $section,
		'type'    => 'checkbox',
		'default' => 1
	);

	$options['portfolioplus[portfolio_navigation]'] = array(
		'id' => 'portfolioplus[portfolio_navigation]',
		'option_type' => 'option',
		'label' => __( 'Display post navigation', 'portfolio-plus' ),
		'description' => __( 'Show prev/next links.', 'portfolio-plus' ),
		'section' => $section,
		'type'    => 'checkbox',
		'default' => 0
	);

	$options['portfolioplus[archive_titles]'] = array(
		'id' => 'portfolioplus[archive_titles]',
		'option_type' => 'option',
		'label' => __( 'Archive Titles', 'portfolio-plus' ),
		'description' => __( 'Display archive titles and descriptions.', 'portfolio-plus' ),
		'section' => $section,
		'type'    => 'checkbox',
		'default' => 1
	);

	$options['portfolioplus[disable_styles]'] = array(
		'id' => 'portfolioplus[disable_styles]',
		'option_type' => 'option',
		'label' => __( 'Disable Styles', 'portfolio-plus' ),
		'description' => 'Disable inline styles from options (useful in child themes)',
		'section' => $section,
		'type'    => 'checkbox',
		'default' => 1
	);

	// Design
	$section = 'design';

	$sections[] = array(
		'id' => $section,
		'title' => __( 'Design', 'portfolio-plus' ),
		'priority' => '80'
	);

	$options['portfolioplus[header_bg][color]'] = array(
		'id' => 'portfolioplus[header_bg][color]',
		'option_type' => 'option',
		'label'   => __( 'Header Background Color', 'portfolio-plus' ),
		'section' => $section,
		'type'    => 'color',
		'default' => '#000000',
		'transport' => 'postMessage'
	);

	$options['portfolioplus[site_title_color]'] = array(
		'id' => 'portfolioplus[site_title_color]',
		'option_type' => 'option',
		'label'   => __( 'Site Title Color', 'portfolio-plus' ),
		'section' => $section,
		'type'    => 'color',
		'default' => '#ffffff',
	);

	if ( portfolioplus_get_option( 'tagline', true ) ) :

	$options['portfolioplus[tagline_color]'] = array(
		'id' => 'portfolioplus[tagline_color]',
		'option_type' => 'option',
		'label'   => __( 'Tagline Color', 'portfolio-plus' ),
		'section' => $section,
		'type'    => 'color',
		'default' => '#dddddd',
	);

	endif;

	$options['portfolioplus[menu_color]'] = array(
		'id' => 'portfolioplus[menu_color]',
		'option_type' => 'option',
		'label'   => __( 'Menu Link Color', 'portfolio-plus' ),
		'section' => $section,
		'type'    => 'color',
		'default' => '#ffffff',
	);

	$options['portfolioplus[header_border_color]'] = array(
		'id' => 'portfolioplus[header_border_color]',
		'option_type' => 'option',
		'label'   => __( 'Header Bottom Border Color', 'portfolio-plus' ),
		'section' => $section,
		'type'    => 'color',
		'default' => '#000000',
	);

	$options['portfolioplus[main_bg][color]'] = array(
		'id' => 'portfolioplus[main_bg][color]',
		'option_type' => 'option',
		'label'   => __( 'Body Background Color', 'portfolio-plus' ),
		'section' => $section,
		'type'    => 'color',
		'default' => '#f6f6f6',
	);

	$options['portfolioplus[body_color]'] = array(
		'id' => 'portfolioplus[body_color]',
		'option_type' => 'option',
		'label'   => __( 'Body Font Color', 'portfolio-plus' ),
		'section' => $section,
		'type'    => 'color',
		'default' => '#555555',
	);

	$options['portfolioplus[header_color]'] = array(
		'id' => 'portfolioplus[header_color]',
		'option_type' => 'option',
		'label'   => __( 'Heading/Title Colors (H1, H2, H3)', 'portfolio-plus' ),
		'section' => $section,
		'type'    => 'color',
		'default' => '#111111',
	);

	$options['portfolioplus[link_color]'] = array(
		'id' => 'portfolioplus[link_color]',
		'option_type' => 'option',
		'label'   => __( 'Link color', 'portfolio-plus' ),
		'section' => $section,
		'type'    => 'color',
		'default' => '#106177',
	);

	$options['portfolioplus[link_hover_color]'] = array(
		'id' => 'portfolioplus[link_hover_color]',
		'option_type' => 'option',
		'label'   => __( 'Hover color', 'portfolio-plus' ),
		'section' => $section,
		'type'    => 'color',
		'default' => '#106177',
	);

	$options['portfolioplus[widget_header_color]'] = array(
		'id' => 'portfolioplus[widget_header_color]',
		'option_type' => 'option',
		'label'   => __( 'Sidebar Heading/Title Colors (Widgets)', 'portfolio-plus' ),
		'section' => $section,
		'type'    => 'color',
		'default' => '#555555',
	);

	$options['portfolioplus[border_color]'] = array(
		'id' => 'portfolioplus[border_color]',
		'option_type' => 'option',
		'label'   => __( 'Border Colors', 'portfolio-plus' ),
		'section' => $section,
		'type'    => 'color',
		'default' => '#dddddd',
	);

	$options['portfolioplus[footer_bg][color]'] = array(
		'id' => 'portfolioplus[footer_bg][color]',
		'option_type' => 'option',
		'label'   => __( 'Footer Background Color', 'portfolio-plus' ),
		'section' => $section,
		'type'    => 'color',
		'default' => '#ffffff',
	);

	$options['portfolioplus[footer_color]'] = array(
		'id' => 'portfolioplus[footer_color]',
		'option_type' => 'option',
		'label'   => __( 'Footer Text Color', 'portfolio-plus' ),
		'section' => $section,
		'type'    => 'color',
		'default' => '#333333',
	);

	$options['portfolioplus[footer_border_color]'] = array(
		'id' => 'portfolioplus[footer_border_color]',
		'option_type' => 'option',
		'label'   => __( 'Footer Top Border Color', 'portfolio-plus' ),
		'section' => $section,
		'type'    => 'color',
		'default' => '#dddddd',
	);

	// Navigation
	$section = 'nav';

	$choices = array(
		'right' => __( 'Right of Logo', 'portfolio-plus' ),
		'clear' => __( 'Underneath Logo', 'portfolio-plus' )
	);

	$options['portfolioplus[menu_position]'] = array(
		'id' => 'portfolioplus[menu_position]',
		'option_type' => 'option',
		'label'   => __( 'Menu Position', 'portfolio-plus' ),
		'section' => $section,
		'type'    => 'select',
		'choices' => $choices,
		'default' => 'right',
		'priority' => 100
	);

	// Portfolio Settings
	$section = 'general';

	$sections[] = array(
		'id' => $section,
		'title' => __( 'General', 'portfolio-plus' ),
		'priority' => '80'
	);

	// Portfolio Post Type Plugin
	if ( class_exists( 'Portfolio_Post_Type' ) ) :

		$options['portfolioplus[portfolio_featured_images]'] = array(
			'id' => 'portfolioplus[portfolio_images]',
			'option_type' => 'option',
			'label' => __( 'Display Featured Images', 'portfolio-plus' ),
			'description' => __( 'Display featured images on portfolio posts.', 'portfolio-plus' ),
			'section' => $section,
			'type'    => 'checkbox',
			'default' => '1',
		);

	else :

		$options['portfolioplus[post_featured_images]'] = array(
			'id' => 'portfolioplus[portfolio_images]',
			'option_type' => 'option',
			'label' => __( 'Display Featured Images', 'portfolio-plus' ),
			'description' => __( 'Display featured images on posts.', 'portfolio-plus' ),
			'section' => $section,
			'type'    => 'checkbox',
			'default' => '1',
		);

	endif;

	$options['portfolioplus[postnav]'] = array(
		'id' => 'portfolioplus[postnav]',
		'option_type' => 'option',
		'label' => __( 'Display post navigation', 'portfolio-plus' ),
		'description' => __( 'Previous/next links on posts.', 'portfolio-plus' ),
		'section' => $section,
		'type'    => 'checkbox',
		'default' => '0',
	);

	// Archive Settings
	$section = 'archive';

	$sections[] = array(
		'id' => $section,
		'title' => __( 'Archive', 'portfolio-plus' ),
		'priority' => '90'
	);

		// Portfolio Post Type Plugin
	if ( class_exists( 'Portfolio_Post_Type' ) ) :

		$options['portfolioplus[portfolio_archives_fullwidth]'] = array(
			'id' => 'portfolioplus[portfolio_sidebar]',
			'option_type' => 'option',
			'label' => __( 'Full Width Archives', 'portfolio-plus' ),
			'description' => __( 'Display portfolio archives full width.', 'portfolio-plus' ),
			'section' => $section,
			'type'    => 'checkbox',
			'default' => '1',
		);

	else :

		$options['portfolioplus[post_archives_fullwidth]'] = array(
			'id' => 'portfolioplus[portfolio_sidebar]',
			'option_type' => 'option',
			'label' => __( 'Full Width Archives', 'portfolio-plus' ),
			'description' => __( 'Display image/gallery archives full width.', 'portfolio-plus' ),
			'section' => $section,
			'type'    => 'checkbox',
			'default' => '1',
		);

	endif;

	$options['portfolioplus[display_image_gallery_post_formats]'] = array(
		'id' => 'portfolioplus[display_image_gallery_post_formats]',
		'option_type' => 'option',
		'label' => __( 'Display Image and Gallery Formats on Posts Page', 'portfolio-plus' ),
		'section' => $section,
		'type'    => 'checkbox',
		'default' => '1',
	);

	$options['portfolioplus[archive_titles]'] = array(
		'id' => 'portfolioplus[archive_titles]',
		'option_type' => 'option',
		'label' => __( 'Archive Titles', 'portfolio-plus' ),
		'description' => __( 'Display archive titles and descriptions.', 'portfolio-plus' ),
		'section' => $section,
		'type'    => 'checkbox',
		'default' => '1',
	);

	// Footer Settings
	$section = 'footer';

	$sections[] = array(
		'id' => $section,
		'title' => __( 'Footer', 'portfolio-plus' ),
		'priority' => '100'
	);

	$options['portfolioplus[footer_text]'] = array(
		'id' => 'portfolioplus[footer_text]',
		'option_type' => 'option',
		'label' => __( 'Footer Text', 'portfolio-plus' ),
		'section' => $section,
		'type' => 'textarea',
		'default' => ''
	);

	$options['helptext'] = array(
		'id' => 'helptext',
		'label' => __( 'Arbitrary Content', 'textdomain' ),
		'section' => $section,
		'type' => 'content',
		'content' => '<p>' . __( 'Content to output. Use <a href="#">HTML</a> if you like.', 'textdomain' ) . '</p>',
		'description' => __( 'Description if you like.', 'textdomain' )
	);

	// Adds the sections to the $options array
	$options['sections'] = $sections;

	$customizer_library = Customizer_Library::Instance();
	$customizer_library->add_options( $options );

}
add_action( 'init', 'portfolioplus_options', 100 );

/**
 * Adds background controls to the customizer
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function portfolioplus_customize_controls( $wp_customize ) {

	// Registers header background control
	$wp_customize->add_setting( 'portfolioplus[header_bg][image_url]', array(
		'sanitize_callback' => 'esc_url',
		'type' => 'option'
	) );

	$wp_customize->add_setting( 'portfolioplus[header_bg][repeat]', array(
		'default' => 'no-repeat',
		'sanitize_callback' => 'sanitize_text_field',
		'type' => 'option'
	) );

	$wp_customize->add_setting( 'portfolioplus[header_bg][size]', array(
		'default' => 'auto',
		'sanitize_callback' => 'sanitize_text_field',
		'type' => 'option'
	) );

	$wp_customize->add_setting( 'portfolioplus[header_bg][attach]', array(
		'default' => 'scroll',
		'sanitize_callback' => 'sanitize_text_field',
		'type' => 'option'
	) );

	$wp_customize->add_setting( 'portfolioplus[header_bg][position]', array(
		'default' => 'center-center',
		'sanitize_callback' => 'sanitize_text_field',
		'type' => 'option'
	) );

	$wp_customize->add_control(
		new Customize_Custom_Background_Control(
			$wp_customize,
			'header_bg',
			array(
				'label'		=> esc_html__( 'Header Background Image', 'portfolio-plus' ),
				'section'	=> 'design',
				// Tie a setting (defined via `$wp_customize->add_setting()`) to the control.
				'settings'    => array(
					'image_url' => 'portfolioplus[header_bg][image_url]',
					'repeat' => 'portfolioplus[header_bg][repeat]', // Use false to hide the field
					'size' => 'portfolioplus[header_bg][size]',
					'position' => 'portfolioplus[header_bg][attach]',
					'attach' => 'portfolioplus[header_bg][position]'
				)
			)
		)
	);

	// Registers body background control
	$wp_customize->add_setting( 'portfolioplus[main_bg][image_url]', array(
		'sanitize_callback' => 'esc_url',
		'type' => 'option'
	) );

	$wp_customize->add_setting( 'portfolioplus[main_bg][repeat]', array(
		'default' => 'no-repeat',
		'sanitize_callback' => 'sanitize_text_field',
		'type' => 'option'
	) );

	$wp_customize->add_setting( 'portfolioplus[main_bg][size]', array(
		'default' => 'auto',
		'sanitize_callback' => 'sanitize_text_field',
		'type' => 'option'
	) );

	$wp_customize->add_setting( 'portfolioplus[main_bg][attach]', array(
		'default' => 'scroll',
		'sanitize_callback' => 'sanitize_text_field',
		'type' => 'option'
	) );

	$wp_customize->add_setting( 'portfolioplus[main_bg][position]', array(
		'default' => 'center-center',
		'sanitize_callback' => 'sanitize_text_field',
		'type' => 'option'
	) );

	// Registers example_background control
	$wp_customize->add_control(
		new Customize_Custom_Background_Control(
			$wp_customize,
			'main_bg',
			array(
				'label'		=> esc_html__( 'Body Background Image', 'portfolio-plus' ),
				'section'	=> 'design',
				'priority'	=> 15,
				// Tie a setting (defined via `$wp_customize->add_setting()`) to the control.
				'settings'    => array(
					'image_url' => 'portfolioplus[main_bg][image_url]',
					'repeat' => 'portfolioplus[main_bg][repeat]', // Use false to hide the field
					'size' => 'portfolioplus[main_bg][size]',
					'position' => 'portfolioplus[main_bg][attach]',
					'attach' => 'portfolioplus[main_bg][position]'
				)
			)
		)
	);

	// Registers footer background control
	$wp_customize->add_setting( 'portfolioplus[footer_bg][image_url]', array(
		'sanitize_callback' => 'esc_url',
		'type' => 'option'
	) );

	$wp_customize->add_setting( 'portfolioplus[footer_bg][repeat]', array(
		'default' => 'no-repeat',
		'sanitize_callback' => 'sanitize_text_field',
		'type' => 'option'
	) );

	$wp_customize->add_setting( 'portfolioplus[footer_bg][size]', array(
		'default' => 'auto',
		'sanitize_callback' => 'sanitize_text_field',
		'type' => 'option'
	) );

	$wp_customize->add_setting( 'portfolioplus[footer_bg][attach]', array(
		'default' => 'scroll',
		'sanitize_callback' => 'sanitize_text_field',
		'type' => 'option'
	) );

	$wp_customize->add_setting( 'portfolioplus[footer_bg][position]', array(
		'default' => 'center-center',
		'sanitize_callback' => 'sanitize_text_field',
		'type' => 'option'
	) );

	// Registers example_background control
	$wp_customize->add_control(
		new Customize_Custom_Background_Control(
			$wp_customize,
			'footer_bg',
			array(
				'label'		=> esc_html__( 'Footer Background Image', 'portfolio-plus' ),
				'section'	=> 'design',
				'priority'	=> 22,
				// Tie a setting (defined via `$wp_customize->add_setting()`) to the control.
				'settings'    => array(
					'image_url' => 'portfolioplus[footer_bg][image_url]',
					'repeat' => 'portfolioplus[footer_bg][repeat]', // Use false to hide the field
					'size' => 'portfolioplus[footer_bg][size]',
					'position' => 'portfolioplus[footer_bg][attach]',
					'attach' => 'portfolioplus[footer_bg][position]'
				)
			)
		)
	);

}
add_action( 'customize_register', 'portfolioplus_customize_controls' );

/**
 * Register asynchronous customizer support for core controls.
 */
function portfolioplus_async_suport_core( $wp_customize ) {

	$wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

	/*
	$wp_customize->get_setting( 'portfolioplus[header_bg][color]' )->transport = 'postMessage';
	$wp_customize->get_setting( 'portfolioplus[site_title_color]' )->transport = 'postMessage';
	$wp_customize->get_setting( 'portfolioplus[tagline_color]' )->transport = 'postMessage';
	$wp_customize->get_setting( 'portfolioplus[menu_color]' )->transport = 'postMessage';
	*/

}
add_action( 'customize_register', 'portfolioplus_async_suport_core' );

/**
 * Enqueue script enabling asynchronous customizer support.
 */
function portfolioplus_customize_preview_js() {
	wp_enqueue_script(
		'portfolioplus_customizer',
		get_template_directory_uri() . '/js/customizer.js',
		array( 'customize-preview' ),
		PORTFOLIO_VERSION,
		true
	);
}
add_action( 'customize_preview_init', 'portfolioplus_customize_preview_js' );