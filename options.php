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

	$options[] = array(
		'name' => __( 'Styles', 'portfolio-plus' ),
		'type' => 'heading'
	);

	$options[] = array(
		'name' => __( 'Portfolio', 'portfolio-plus' ),
		'type' => 'heading'
	);

	$options[] = array(
		'name' => __( 'Display Image and Gallery Formats on Posts Page', 'portfolio-plus' ),
		'desc' => __( 'Display all post formats on posts page.', 'portfolio-plus' ),
		'id' => "display_image_gallery_post_formats",
		'std' => "1",
		'type' => "checkbox"
	);

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
		'std' => "3.6.0",
		'class' => "hidden",
		'type' => "text"
	);

	return $options;
}