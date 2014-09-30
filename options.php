<?php
/**
 * This file only gets loaded if the Options Framework plugin is installed
 *
 * A unique identifier is defined to store the options in the database
 * and reference them from the theme.  By default it uses 'portfolioplus'.
 * If the identifier changes, it'll appear as if the options have been reset.
 *
 * @package Portfolio+
 */

function optionsframework_option_name() {

	$optionsframework_settings = get_option('optionsframework' );
	$optionsframework_settings['id'] = 'portfolioplus';
	update_option('optionsframework', $optionsframework_settings);

}

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the 'id' fields, make sure to use all lowercase and no spaces.
 *
 * @returns array $options
 */

function optionsframework_options() {

	// If using image radio buttons, define a directory path
	$imagepath =  get_template_directory_uri() . '/images/';

	// Background Defaults
	$background_defaults = array(
		'color' => '',
		'image' => '',
		'repeat' => 'repeat',
		'position' => 'top center',
		'attachment'=>'scroll'
	);

	$options = array();

	$options[] = array(
		'name' => __( 'General', 'portfolio-plus' ),
		'type' => 'heading'
	);

	$options['layout'] = array(
		'name' => __( 'Main Layout', 'portfolio-plus' ),
		'desc' => __( 'Select main content and sidebar alignment.', 'portfolio-plus' ),
		'id' => 'layout',
		'std' => 'layout-2cr',
		'type' => 'images',
		'options' => array(
			'layout-2cr' => $imagepath . '2cr.png',
			'layout-2cl' => $imagepath . '2cl.png',
			'layout-1col' => $imagepath . '1cl.png'
		)
	);

	$options['custom_favicon'] = array(
		'name' => __( 'Custom Favicon', 'portfolio-plus' ),
		'desc' => __( 'Upload a favicon (16px)', 'portfolio-plus' ),
		'id' => 'custom_favicon',
		'type' => 'upload'
	);

	$options['infinite_scroll'] = array(
		'name' => __( 'Infinite Scroll', 'portfolio-plus' ),
		'desc' => __( 'Load new posts as the user scrolls down.  ("Display Image and Gallery Formats on Posts Page" should be unchecked under the "Portfolio" tab for infinite scroll to work best.)', 'portfolio-plus' ),
		'id' => 'infinite_scroll',
		'std' => '1',
		'type' => 'checkbox'
	);

	$options['display_dates'] = array(
		'name' => __( 'Display dates', 'portfolio-plus' ),
		'desc' => __( 'Display dates on posts.', 'portfolio-plus' ),
		'id' => 'display_dates',
		'std' => '1',
		'type' => 'checkbox'
	);

	$options['archive_titles'] = array(
		'name' => __( 'Archive Titles', 'portfolio-plus' ),
		'desc' => __( 'Display archive titles and descriptions.', 'portfolio-plus' ),
		'id' => 'archive_titles',
		'std' => '1',
		'type' => 'checkbox'
	);

	$options['footer_text'] = array(
		'name' => __( 'Custom Footer Text', 'portfolio-plus' ),
		'desc' => __( 'Custom text that will appear in the footer of your theme.', 'portfolio-plus' ),
		'id' => 'footer_text',
		'type' => 'textarea'
	);

	$options['disable_styles'] = array(
		'name' => 'Disable Styles',
		'desc' => 'Disable inline styles from options (useful in child themes)',
		'id' => 'disable_styles',
		'std' => false,
		'type' => 'checkbox'
	);

	$options[] = array(
		'name' => __( 'Header', 'portfolio-plus' ),
		'type' => 'heading'
	);

	$options['logo'] = array(
		'name' => __( 'Custom Logo', 'portfolio-plus' ),
		'desc' => __( 'Upload a logo (optional)', 'portfolio-plus' ),
		'id' => 'logo',
		'type' => 'upload'
	);

	if ( !of_get_option('logo' ) ) {
		$options['tagline'] = array(
			'name' => __( 'Display Site Tagline', 'portfolio-plus' ),
			'desc' => __( 'Display tagline under site title.', 'portfolio-plus' ),
			'id' => 'tagline',
			'std' => '1',
			'type' => 'checkbox'
		);
	}

	$options['header_bg'] = array(
		'name' =>  __( 'Header Background', 'portfolio-plus' ),
		'id' => 'header_bg',
		'std' => array_merge( $background_defaults, array( 'color' => '#000000' ) ),
		'type' =>'background'
	);

	$options[] = array(
		'name' => __( 'Header Text Colors', 'portfolio-plus' ),
		'desc' => '',
		'type' => 'info'
	);

	$options['site_title_color'] = array(
		'desc' => __( 'Site Title Color', 'portfolio-plus' ),
		'id' => 'site_title_color',
		'std' => '#ffffff',
		'type' => 'color' );

	if ( of_get_option( 'tagline', true ) ) {
		$options['tagline_color'] = array(
			'desc' => __( 'Tagline Color', 'portfolio-plus' ),
			'id' => 'tagline_color',
			'std' => '#dddddd',
			'type' => 'color'
		);
	}

	$options['menu_color'] = array(
		'desc' => __( 'Menu Link Color', 'portfolio-plus' ),
		'id' => 'menu_color',
		'std' => '#ffffff',
		'type' => 'color'
	);

	$options['header_border_color'] = array(
		'name' =>  __( 'Header Bottom Border Color', 'portfolio-plus' ),
		'id' => 'header_border_color',
		'std' => '#000',
		'type' => 'color'
	);

	$options['menu_position'] = array(
		'name' => __( 'Menu Position', 'portfolio-plus' ),
		'desc' => __( 'Select where the main menu should go in the header.  Long menus should go underneath.', 'portfolio-plus' ),
		'id' => 'menu_position',
		'std' => 'right',
		'type' => 'radio',
		'options' => array(
			'right' => 'Right of logo',
			'clear' => 'Underneath logo'
		)
	);

	$options[] = array(
		'name' => __( 'Styles', 'portfolio-plus' ),
		'type' => 'heading'
	);

	$options['main_bg'] = array(
		'name' =>  __( 'Body Background', 'portfolio-plus' ),
		'id' => 'main_bg',
		'std' => array_merge( $background_defaults, array( 'color' => '#f3f3f3' ) ),
		'type' =>'background'
	);

	$options['body_color'] = array(
		'name' => __( 'Body Font Color', 'portfolio-plus' ),
		'id' => 'body_color',
		'std' => '#555555',
		'type' => 'color'
	);

	$options['header_color'] = array(
		'name' => __( 'Heading/Title Colors (H1, H2, H3)', 'portfolio-plus' ),
		'id' => 'header_color',
		'std' => '#111111',
		'type' => 'color'
	);

	$options[] = array(
		'name' => __( 'Link Colors', 'portfolio-plus' ),
		'desc' => '',
		'type' => 'info'
	);

	$options['link_color'] = array(
		'desc' => __( 'Link color', 'portfolio-plus' ),
		'id' => 'link_color',
		'std' => '#106177',
		'type' => 'color'
	);

	$options['link_hover_color'] = array(
		'desc' => __( 'Hover color', 'portfolio-plus' ),
		'id' => 'link_hover_color',
		'std' => '#106177',
		'type' => 'color'
	);

	$options['widget_header_color'] = array(
		'name' => __( 'Sidebar Heading/Title Colors (Widgets)', 'portfolio-plus' ),
		'id' => 'widget_header_color',
		'std' => '#555555',
		'type' => 'color'
	);

	$options['border_color'] = array(
		'name' => __( 'Border Colors', 'portfolio-plus' ),
		'id' => 'border_color',
		'std' => '#dddddd',
		'type' => 'color'
	);

	$options['footer_color'] = array(
		'name' => __( 'Footer Text Color', 'portfolio-plus' ),
		'id' => 'footer_color',
		'std' => '#333333',
		'type' => 'color'
	);

	$options['footer_border_color'] = array(
		'name' =>  __( 'Footer Top Border Color', 'portfolio-plus' ),
		'id' => 'footer_border_color',
		'std' => '#dddddd',
		'type' => 'color'
	);

	$options['footer_bg'] = array(
		'name' =>  __( 'Footer Background', 'portfolio-plus' ),
		'id' => 'footer_bg',
		'std' => array_merge( $background_defaults, array( 'color' => '#ffffff' ) ),
		'type' =>'background'
	);

	$options[] = array(
		'name' => __( 'Portfolio', 'portfolio-plus' ),
		'type' => 'heading'
	);

	if ( class_exists( 'Portfolio_Post_Type' ) ) {

		$options[] = array(
			'name' => __( 'Display Images on Portfolio / Image Posts', 'portfolio-plus' ),
			'desc' => __( 'Display featured images automatically on posts.', 'portfolio-plus' ),
			'id' => "portfolio_images",
			'std' => "1",
			'type' => "checkbox"
		);

	} else {

		$options[] = array(
			'name' => __( 'Display Images Automatically on Image Post Formats', 'portfolio-plus' ),
			'desc' => __( 'Display featured images automatically on posts.', 'portfolio-plus' ),
			'id' => "portfolio_images",
			'std' => "1",
			'type' => "checkbox"
		);

	}

	if ( class_exists( 'Portfolio_Post_Type' ) ) {

		$options[] = array(
			'name' => __( 'Display Portfolio / Image / Galleries Full Width', 'portfolio-plus' ),
			'desc' => __( 'Display all image based archives full width.', 'portfolio-plus' ),
			'id' => "portfolio_sidebar",
			'std' => "0",
			'type' => "checkbox"
		);

	} else {

		$options[] = array(
			'name' => __( 'Display Image and Gallery Post Format Archives Full Width', 'portfolio-plus' ),
			'desc' => __( 'Display all image/gallery archives full width.', 'portfolio-plus' ),
			'id' => "portfolio_sidebar",
			'std' => "0",
			'type' => "checkbox"
		);

	}

	$options[] = array(
		'name' => __( 'Display Image and Gallery Formats on Posts Page', 'portfolio-plus' ),
		'desc' => __( 'Display all post formats on posts page.', 'portfolio-plus' ),
		'id' => "display_image_gallery_post_formats",
		'std' => "1",
		'type' => "checkbox"
	);

	if ( class_exists( 'Portfolio_Post_Type' ) ) {

		$options['portfolio_navigation'] = array(
			'name' => __( 'Display portfolio navigation', 'portfolio-plus' ),
			'desc' => __( 'Show prev/next links on portfolio posts.', 'portfolio-plus' ),
			'id' => 'portfolio_navigation',
			'std' => '1',
			'type' => 'checkbox'
		);

	}

	$options[] = array(
		'name' => __( 'Posts Per Page', 'portfolio-plus' ),
		'desc' => sprintf( '<p>%s</p>',
			sprintf(
				__( 'Posts per page can be set in the <a href="%s">reading options</a>.', 'portfolio-plus' ),
				admin_url( 'options-reading.php', false )
				)
			),
		'type' => 'info'
	);

	/* Utility Options (Not Displayed) */

	$options[] = array(
		'id' => "post_per_page_ignore",
		'std' => 0,
		'class' => "hidden",
		'type' => "text"
	);

	$options[] = array(
		'id' => "version",
		'std' => "3.4.0",
		'class' => "hidden",
		'type' => "text"
	);

	return $options;
}