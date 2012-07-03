<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * By default it uses 'portfolioplus'.  If the identifier changes, it'll appear as if the options have been reset.
 *
 * @package WordPress
 * @subpackage Portfolio Plus
 */

function optionsframework_option_name() {
	$optionsframework_settings = get_option('optionsframework');
	$optionsframework_settings['id'] = 'portfolioplus';
	update_option('optionsframework', $optionsframework_settings);
}

/**
 * Define the options
 */

function optionsframework_options() {
		
	// If using image radio buttons, define a directory path
	$imagepath =  get_template_directory_uri() . '/images/';
	
	$options = array();
		
	$options[] = array( 'name' => __('General','portfolioplus'),
                    	'type' => 'heading');
						
	$options['logo'] = array( 'name' => __('Custom Logo','portfolioplus'),
						'desc' => __('Upload a logo (optional)','portfolioplus'),
						'id' => 'logo',
						'type' => 'upload');
	
	if ( !of_get_option('logo') ) {
		$options['tagline'] = array( 'name' => __('Display Site Tagline', 'portfolioplus'),
						'desc' => __('Display tagline under site title', 'portfolioplus'),
						'id' => 'tagline',
						'std' => '1',
						'type' => 'checkbox');
	}
						
	$options['custom_favicon'] = array( 'name' => __('Custom Favicon','portfolioplus'),
						'desc' => __('Upload a favicon (16px)','portfolioplus'),
						'id' => 'custom_favicon',
						'type' => 'upload');
	
	$options['infinite_scroll'] = array( 'name' => __('Infinite Scroll','portfolioplus'),
						'desc' => __('Load new posts and portfolio items as the user scrolls down','portfolioplus'),
						'id' => 'infinite_scroll',
						'std' => '1',
						'type' => 'checkbox');
						
	$options['layout'] = array( 'name' => __('Main Layout','portfolioplus'),
						'desc' => __('Select main content and sidebar alignment.','portfolioplus'),
						'id' => 'layout',
						'std' => 'layout-2cr',
						'type' => 'images',
						'options' => array(
							'layout-2cr' => $imagepath . '2cr.png',
							'layout-2cl' => $imagepath . '2cl.png',
							'layout-1col' => $imagepath . '1cl.png')
						); 
						
	$options['menu_position'] = array( 'name' => __('Menu Position','portfolioplus'),
						'desc' => __('Select where the main menu should go in the header.  Long menus should go underneath.','portfolioplus'),
						'id' => 'menu_position',
						'std' => 'right',
						'type' => 'radio',
						'options' => array(
							'right' => 'Right of logo',
							'clear' => 'Underneath logo') );
							
	$options['footer_text'] = array( 'name' => __('Custom Footer Text','portfolioplus'),
						'desc' => __('Custom text that will appear in the footer of your theme.','portfolioplus'),
						'id' => 'footer_text',
						'type' => 'textarea');
						
	$options['disable_styles'] = array( 'name' => 'Disable Styles',
						'desc' => 'Disable inline styles from options (useful in child themes)',
						'id' => 'disable_styles',
						'std' => false,
						'type' => 'checkbox' );
							
	$options[] = array( 'name' => __('Colors','portfolioplus'),
						'type' => 'heading');
						
	$options['body_color'] = array( 'name' => __('Body Font Color','portfolioplus'),
						'id' => 'body_color',
						'std' => '#555555',
						'type' => 'color' );
						
	$options[] = array( 'name' => __('Link Colors','portfolioplus'),
						'desc' => '',
						'type' => 'info' );
						
	$options['link_color'] = array( 'desc' => __('Link color','portfolioplus'),
						"id" => 'link_color',
						"std" => '#106177',
						"type" => 'color' );
		
	$options['link_hover_color'] = array( 'desc' => __('Hover color','portfolioplus'),
						'id' => 'link_hover_color',
						'std' => '#106177',
						'type' => 'color' );
						
	$options[] = array( 'name' => 'Header Section',
						'desc' => '',
						'type' => 'info' );
						
	$options['site_title_color'] = array( 'desc' => __('Site Title Color','portfolioplus'),
						'id' => 'site_title_color',
						'std' => '#ffffff',
						'type' => 'color' );
	
	if ( of_get_option( 'tagline', true ) ) {
	$options['tagline_color'] = array( 'desc' => __('Tagline Color','portfolioplus'),
						'id' => 'tagline_color',
						'std' => '#dddddd',
						'type' => 'color' );
	}
						
	$options['menu_color'] = array( 'desc' => __('Menu Link Color','portfolioplus'),
						'id' => 'menu_color',
						'std' => '#ffffff',
						'type' => 'color' );
						
	$options['header_color'] = array( 'name' => __('Header Colors (H1, H2, H3)','portfolioplus'),
						'id' => 'header_color',
						'std' => '#111111',
						'type' => 'color' );
						
	$options['widget_header_color'] = array( 'name' => __('Sidebar Header Colors (Widgets)','portfolioplus'),
						'id' => 'widget_header_color',
						'std' => '#555555',
						'type' => 'color' );
						
	$options['border_color'] = array( 'name' => __('Border Colors','portfolioplus'),
						'id' => 'border_color',
						'std' => '#dddddd',
						'type' => 'color' );
						
	$options['footer_color'] = array( 'name' => __('Footer Text Color','portfolioplus'),
						'id' => 'footer_color',
						'std' => '#333333',
						'type' => 'color' );                          
    
	$options[] = array( 'name' => __('Backgrounds','portfolioplus'),
						'type' => 'heading');
						
	$options['header_bg'] = array( 'name' =>  __('Header Background', 'portfolioplus'),
						'id' => 'header_bg',
						'std' => array( 'color' => '#000000', 'image' => '') );
						
	$options['main_bg'] = array( 'name' =>  __('Body Background', 'portfolioplus'),
						'id' => 'main_bg',
						'std' => array( 'color' => '#f3f3f3', 'image' => '' ) );
						
	$options['footer_bg'] = array( 'name' =>  __('Footer Background', 'portfolioplus'),
						'id' => 'footer_bg',
						'std' => array( 'color' => '#ffffff', 'image' => '' ) );
						
	$options[] = array( 'name' => __('Portfolio','portfolioplus'),
                    	'type' => 'heading');
                    	
    $options['portfolio_images'] = array( 'name' => __('Display Images on Portfolio Posts','portfolioplus'),
						'desc' => __('Uncheck this if you wish to manually display portfolio images on single posts','portfolioplus'),
						'id' => 'portfolio_images',
						'std' => '1',
						'type' => 'checkbox');
						
	$options['portfolio_sidebar'] = array( 'name' => __('Display Portfolio Archives Full Width','portfolioplus'),
						'desc' => __('Check this to display all portfolio archives full width','portfolioplus'),
						'id' => 'portfolio_sidebar',
						'std' => '0',
						'type' => 'checkbox');
						
	$options['portfolio_num'] = array( 'name' => __('Number of Portfolio Items','portfolioplus'),
						'desc' => __('Select the number of portfolio items to show per page.','portfolioplus'),
						'id' => 'portfolio_num',
						'class' => 'mini',
						'std' => '9',
						'type' => 'select',
						'options' => array(
							'9' => '9',
							'12' => '12') );
													
	return $options;
}