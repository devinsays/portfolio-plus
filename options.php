<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * By default it uses 'portfoliopress'.  If the identifier changes, it'll appear as if the options have been reset.
 *
 * @package WordPress
 * @subpackage Portfolio Press
 */

function optionsframework_option_name() {
	
	$optionsframework_settings = get_option('optionsframework');
	$optionsframework_settings['id'] = 'portfoliopress';
	update_option('optionsframework', $optionsframework_settings);
	
}

/**
 * Define the options
 */

function optionsframework_options() {
		
	// If using image radio buttons, define a directory path
	$imagepath =  get_template_directory_uri() . '/images/';
	
	$options = array();
		
	$options[] = array( 'name' => __('General','portfoliopress'),
                    	'type' => 'heading');
						
	$options[] = array( 'name' => __('Custom Logo','portfoliopress'),
						'desc' => __('Upload a logo (optional)','portfoliopress'),
						'id' => 'logo',
						'type' => 'upload');
	
	if ( !of_get_option('logo') ) {
		$options[] = array( 'name' => __('Display Site Tagline', 'portfoliopress'),
						'desc' => __('Display tagline under site title', 'portfoliopress'),
						'id' => 'tagline',
						'std' => '1',
						'type' => 'checkbox');
	}
						
	$options[] = array( 'name' => __('Custom Favicon','portfoliopress'),
						'desc' => __('Upload a favicon (16px)','portfoliopress'),
						'id' => 'custom_favicon',
						'type' => 'upload');
	
	$options[] = array( 'name' => __('Infinite Scroll','portfoliopress'),
						'desc' => __('Load new posts and portfolio items as the user scrolls down','portfoliopress'),
						'id' => 'infinite_scroll',
						'std' => '1',
						'type' => 'checkbox');
						
	$options[] = array( 'name' => __('Main Layout','portfoliopress'),
						'desc' => __('Select main content and sidebar alignment.','portfoliopress'),
						'id' => 'layout',
						'std' => 'layout-2cr',
						'type' => 'images',
						'options' => array(
							'layout-2cr' => $imagepath . '2cr.png',
							'layout-2cl' => $imagepath . '2cl.png',
							'layout-1col' => $imagepath . '1cl.png')
						); 
						
	$options[] = array( 'name' => __('Menu Position','portfoliopress'),
						'desc' => __('Select where the main menu should go in the header.  Long menus should go underneath.','portfoliopress'),
						'id' => 'menu_position',
						'std' => 'right',
						'type' => 'radio',
						'options' => array(
							'right' => 'Right of logo',
							'clear' => 'Underneath logo') );
							
	$options[] = array( 'name' => __('Custom Footer Text','portfoliopress'),
						'desc' => __('Custom text that will appear in the footer of your theme.','portfoliopress'),
						'id' => 'footer_text',
						'type' => 'textarea');
						
	$options[] = array( 'name' => 'Disable Styles',
						'desc' => 'Disable inline styles from options (useful in child themes)',
						'id' => 'disable_styles',
						'std' => false,
						'type' => 'checkbox' );
							
	$options[] = array( 'name' => __('Colors','portfoliopress'),
						'type' => 'heading');
						
	$options[] = array( 'name' => 'Body Font Color',
						'id' => 'body_color',
						'std' => '#555555',
						'type' => 'color' );
						
	$options[] = array( 'name' => 'Link Colors',
						'desc' => '',
						'type' => 'info' );
						
	$options[] = array( 'desc' => 'Link color',
						"id" => 'link_color',
						"std" => '#106177',
						"type" => 'color' );
		
	$options[] = array( 'desc' => 'Hover color',
						'id' => 'link_hover_color',
						'std' => '#106177',
						'type' => 'color' );
						
	$options[] = array( 'name' => 'Header Section',
						'desc' => '',
						'type' => 'info' );
						
	$options[] = array( 'desc' => 'Site Title Color',
						'id' => 'site_title_color',
						'std' => '#ffffff',
						'type' => 'color' );
	
	if ( of_get_option( 'tagline', true ) ) {
	$options[] = array( 'desc' => 'Tagline Color',
						'id' => 'tagline_color',
						'std' => '#dddddd',
						'type' => 'color' );
	}
						
	$options[] = array( 'desc' => 'Menu Link Color',
						'id' => 'menu_color',
						'std' => '#ffffff',
						'type' => 'color' );
						
	$options[] = array( 'name' => 'Header Colors (H1, H2, H3)',
						'id' => 'header_color',
						'std' => '#111111',
						'type' => 'color' );
						
	$options[] = array( 'name' => 'Sidebar Header Colors (Widgets)',
						'id' => 'widget_header_color',
						'std' => '#555555',
						'type' => 'color' );
						
	$options[] = array( 'name' => 'Border Colors',
						'id' => 'border_color',
						'std' => '#dddddd',
						'type' => 'color' );
						
	$options[] = array( 'name' => 'Footer Text Color',
						'id' => 'footer_color',
						'std' => '#333333',
						'type' => 'color' );                          
    
	$options[] = array( 'name' => __('Backgrounds','portfoliopress'),
						'type' => 'heading');
						
	$options[] = array( 'name' =>  __('Header Background', 'portfoliopress'),
						'id' => 'header_bg',
						'std' => array(
							'color' => '#000000',
							'image' => '',
							'repeat' => 'repeat',
							'position' => 'top center',
							'attachment'=>'scroll' ),
							'type' => 'background' );
						
	$options[] = array( 'name' =>  __('Main Section Background', 'portfoliopress'),
						'id' => 'main_bg',
						'std' => array(
							'color' => '#f3f3f3',
							'image' => '',
							'repeat' => 'repeat',
							'position' => 'top center',
							'attachment'=>'scroll' ),
							'type' => 'background' );
						
	$options[] = array( 'name' =>  __('Footer Background', 'portfoliopress'),
						'id' => 'footer_bg',
						'std' => array(
							'color' => '#ffffff',
							'image' => '',
							'repeat' => 'repeat',
							'position' => 'top center',
							'attachment'=>'scroll' ),
							'type' => 'background' );
						
	$options[] = array( 'name' => __('Portfolio','portfoliopress'),
                    	'type' => 'heading');
                    	
    $options[] = array( 'name' => __('Display Images on Portfolio Posts','portfoliopress'),
						'desc' => __('Uncheck this if you wish to manually display portfolio images on single posts','portfoliopress'),
						'id' => 'portfolio_images',
						'std' => '1',
						'type' => 'checkbox');
						
	$options[] = array( 'name' => __('Display Portfolio Archives Full Width','portfoliopress'),
						'desc' => __('Check this to display all portfolio archives full width','portfoliopress'),
						'id' => 'portfolio_sidebar',
						'std' => '0',
						'type' => 'checkbox');
						
	$options[] = array( 'name' => __('Number of Portfolio Items','portfoliopress'),
						'desc' => __('Select the number of portfolio items to show per page.','portfoliopress'),
						'id' => 'portfolio_num',
						'class' => 'mini',
						'std' => '9',
						'type' => 'select',
						'options' => array(
							'9' => '9',
							'12' => '12') );
									
	return $options;
}