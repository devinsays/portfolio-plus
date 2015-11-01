<?php
/**
 * @package Portfolio+
 */

// Include the TGM_Plugin_Activation class.
require_once dirname( __FILE__ ) . '/class-tgm-plugin-activation.php';

function portfolioplus_recommended_plugins() {

	// Recommended Plugins
	$plugins = array(

		// Regenerate thumbnails
		array(
			'name' 		=> 'Regenerate Thumbnails',
			'slug' 		=> 'regenerate-thumbnails',
			'required' 	=> false,
		),

	);

    // Strings for translations
    $config = array();

    tgmpa( $plugins, $config );

}
add_action( 'tgmpa_register', 'portfolioplus_recommended_plugins' );