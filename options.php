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
 * When creating the "id" fields, make sure to use all lowercase and no spaces.
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
		'attachment'=>'scroll' );

	$options = array();

	$options[] = array(
		'name' => __( 'General','portfolioplus' ),
		'type' => 'heading'
	);

	$options['logo'] = array(
		'name' => __( 'Custom Logo','portfolioplus' ),
		'desc' => __( 'Upload a logo (optional)','portfolioplus' ),
		'id' => 'logo',
		'type' => 'upload'
	);

	if ( !of_get_option('logo' ) ) {
		$options['tagline'] = array(
			'name' => __( 'Display Site Tagline', 'portfolioplus' ),
			'desc' => __( 'Display tagline under site title', 'portfolioplus' ),
			'id' => 'tagline',
			'std' => '1',
			'type' => 'checkbox'
		);
	}

	$options['custom_favicon'] = array(
		'name' => __( 'Custom Favicon','portfolioplus' ),
		'desc' => __( 'Upload a favicon (16px)','portfolioplus' ),
		'id' => 'custom_favicon',
		'type' => 'upload' );

	$options['infinite_scroll'] = array(
		'name' => __( 'Infinite Scroll','portfolioplus' ),
		'desc' => __( 'Load new posts and portfolio items as the user scrolls down','portfolioplus' ),
		'id' => 'infinite_scroll',
		'std' => '1',
		'type' => 'checkbox'
	);

	$options['layout'] = array(
		'name' => __( 'Main Layout','portfolioplus' ),
		'desc' => __( 'Select main content and sidebar alignment.','portfolioplus' ),
		'id' => 'layout',
		'std' => 'layout-2cr',
		'type' => 'images',
		'options' => array(
			'layout-2cr' => $imagepath . '2cr.png',
			'layout-2cl' => $imagepath . '2cl.png',
			'layout-1col' => $imagepath . '1cl.png'
		)
	);

	$options['display_dates'] = array(
		'name' => __( 'Display dates', 'portfolioplus' ),
		'desc' => __( 'Display dates on posts', 'portfolioplus' ),
		'id' => 'display_dates',
		'std' => '1',
		'type' => 'checkbox'
	);

	$options['menu_position'] = array(
		'name' => __( 'Menu Position','portfolioplus' ),
		'desc' => __( 'Select where the main menu should go in the header.  Long menus should go underneath.','portfolioplus' ),
		'id' => 'menu_position',
		'std' => 'right',
		'type' => 'radio',
		'options' => array(
			'right' => 'Right of logo',
			'clear' => 'Underneath logo'
		)
	);

	$options['footer_text'] = array(
		'name' => __( 'Custom Footer Text','portfolioplus' ),
		'desc' => __( 'Custom text that will appear in the footer of your theme.','portfolioplus' ),
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
		'name' => __( 'Colors','portfolioplus' ),
		'type' => 'heading'
	);

	$options['body_color'] = array(
		'name' => __( 'Body Font Color','portfolioplus' ),
		'id' => 'body_color',
		'std' => '#555555',
		'type' => 'color'
	);

	$options[] = array(
		'name' => __( 'Link Colors','portfolioplus' ),
		'desc' => '',
		'type' => 'info'
	);

	$options['link_color'] = array(
		'desc' => __( 'Link color','portfolioplus' ),
		"id" => 'link_color',
		"std" => '#106177',
		"type" => 'color'
	);

	$options['link_hover_color'] = array(
		'desc' => __( 'Hover color','portfolioplus' ),
		'id' => 'link_hover_color',
		'std' => '#106177',
		'type' => 'color'
	);

	$options[] = array(
		'name' => 'Header Section',
		'desc' => '',
		'type' => 'info'
	);

	$options['site_title_color'] = array(
		'desc' => __( 'Site Title Color','portfolioplus' ),
		'id' => 'site_title_color',
		'std' => '#ffffff',
		'type' => 'color' );

	if ( of_get_option( 'tagline', true ) ) {
		$options['tagline_color'] = array(
			'desc' => __( 'Tagline Color','portfolioplus' ),
			'id' => 'tagline_color',
			'std' => '#dddddd',
			'type' => 'color'
		);
	}

	$options['menu_color'] = array(
		'desc' => __( 'Menu Link Color','portfolioplus' ),
		'id' => 'menu_color',
		'std' => '#ffffff',
		'type' => 'color'
	);

	$options['header_color'] = array(
		'name' => __( 'Heading/Title Colors (H1, H2, H3)','portfolioplus' ),
		'id' => 'header_color',
		'std' => '#111111',
		'type' => 'color'
	);

	$options['widget_header_color'] = array(
		'name' => __( 'Sidebar Heading/Title Colors (Widgets)','portfolioplus' ),
		'id' => 'widget_header_color',
		'std' => '#555555',
		'type' => 'color'
	);

	$options['border_color'] = array(
		'name' => __( 'Border Colors','portfolioplus' ),
		'id' => 'border_color',
		'std' => '#dddddd',
		'type' => 'color'
	);

	$options['footer_color'] = array(
		'name' => __( 'Footer Text Color','portfolioplus' ),
		'id' => 'footer_color',
		'std' => '#333333',
		'type' => 'color'
	);

	$options[] = array(
		'name' => __( 'Backgrounds','portfolioplus' ),
		'type' => 'heading' );

	$options['header_bg'] = array(
		'name' =>  __( 'Header Background', 'portfolioplus' ),
		'id' => 'header_bg',
		'std' => array_merge( $background_defaults, array( 'color' => '#000000' ) ),
		'type' =>'background'
	);

	$options['main_bg'] = array(
		'name' =>  __( 'Body Background', 'portfolioplus' ),
		'id' => 'main_bg',
		'std' => array_merge( $background_defaults, array( 'color' => '#f3f3f3' ) ),
		'type' =>'background'
	);

	$options['footer_bg'] = array(
		'name' =>  __( 'Footer Background', 'portfolioplus' ),
		'id' => 'footer_bg',
		'std' => array_merge( $background_defaults, array( 'color' => '#ffffff' ) ),
		'type' =>'background'
	);

	$options[] = array(
		'name' => __( 'Portfolio','portfolioplus' ),
		'type' => 'heading'
	);

    $options['portfolio_images'] = array(
    	'name' => __( 'Display Images on Portfolio Posts','portfolioplus' ),
		'desc' => __( 'Display images automatically on portfolio posts','portfolioplus' ),
		'id' => 'portfolio_images',
		'std' => '1',
		'type' => 'checkbox'
	);

	$options['portfolio_sidebar'] = array(
		'name' => __( 'Display Portfolio Archives Full Width','portfolioplus' ),
		'desc' => __( 'Display all portfolio archives full width.','portfolioplus' ),
		'id' => 'portfolio_sidebar',
		'std' => '0',
		'type' => 'checkbox'
	);

	$options['portfolio_num'] = array(
		'name' => __( 'Number of Portfolio Items','portfolioplus' ),
		'desc' => __( 'Select the number of portfolio items to show per page.','portfolioplus' ),
		'id' => 'portfolio_num',
		'class' => 'mini',
		'std' => '9',
		'type' => 'select',
		'options' => array(
			'9' => '9',
			'12' => '12',
			'15' => '15'
		)
	);

	$options['portfolio_navigation'] = array(
		'name' => __( 'Display portfolio navigation', 'portfolioplus' ),
		'desc' => __( 'Show prev/next links on portfolio posts.', 'portfolioplus' ),
		'id' => 'portfolio_navigation',
		'std' => '1',
		'type' => 'checkbox'
	);

	$options['archive_titles'] = array(
		'name' => __( 'Archive Titles','portfolioplus' ),
		'desc' => 'Display titles and descriptions on portfolio category/tag pages.',
		'id' => 'archive_titles',
		'std' => '1',
		'type' => 'checkbox'
	);

	return $options;
}