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

	return null;

}

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the 'id' fields, make sure to use all lowercase and no spaces.
 *
 * @returns array $options
 */

function optionsframework_options() {

	$options = array();

	$options[] = array(
		'name' => __( 'General', 'portfolio-plus' ),
		'type' => 'heading'
	);

		$options[] = array(
		'name' => __( 'Customization Options', 'portfolio-plus' ),
		'desc' => sprintf( '<p>%s</p>',
			sprintf(
				__( '<p>All theme options are now in the <a href="%s">Customizer</a>.</p><p>You can safely disable the Options Framework and delete it from your site.</p>', 'portfolio-plus' ),
				admin_url( 'customize.php', false )
				)
			),
		'type' => 'info'
	);

	return $options;
}