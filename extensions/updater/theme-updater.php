<?php
/**
 * One-click updater for theme
 *
 * @package Portfolio+
 */

// Includes the files needed for the theme updater
if ( !class_exists( 'EDD_Theme_Updater_Admin' ) ) {
	include( dirname( __FILE__ ) . '/theme-updater-admin.php' );
}

// Loads the updater classes
$updater = new EDD_Theme_Updater_Admin(

	array(
		'remote_api_url' => 'http://wptheming.com', // Site where EDD is hosted
		'item_name' => 'portfolio-theme', // Name of theme
		'theme_slug' => 'portfolioplus', // Theme slug
		'version' => '3.6.0', // The current version of this theme
		'author' => 'Devin Price' // The author of this theme
	)

);