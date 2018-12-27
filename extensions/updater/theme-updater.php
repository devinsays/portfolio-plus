<?php
/**
 * One-click updater for Portfolio+
 *
 * @package EDD Theme Updater
 */

// Includes the files needed for the theme updater
if ( !class_exists( 'EDD_Theme_Updater_Admin' ) ) {
	include( dirname( __FILE__ ) . '/theme-updater-admin.php' );
}

// Loads the updater classes
$updater = new EDD_Theme_Updater_Admin(

	// Config settings
	$config = array(
		'remote_api_url' => 'https://wptheming.com',
		'item_name' => 'portfolio-theme',
		'theme_slug' => 'portfolio-plus',
		'version' => PORTFOLIO_VERSION,
		'author' => 'Devin Price',
	),

	// Strings
	$strings = array(
		'theme-license' => __( 'Theme License', 'portfolioplus' ),
		'enter-key' => __( 'Enter your theme license key.', 'portfolioplus' ),
		'license-key' => __( 'License Key', 'portfolioplus' ),
		'license-action' => __( 'License Action', 'portfolioplus' ),
		'deactivate-license' => __( 'Deactivate License', 'portfolioplus' ),
		'activate-license' => __( 'Activate License', 'portfolioplus' ),
		'status-unknown' => __( 'License status is unknown.', 'portfolioplus' ),
		'renew' => __( 'Renew?', 'portfolioplus' ),
		'unlimited' => __( 'unlimited', 'portfolioplus' ),
		'license-key-is-active' => __( 'License key is active.', 'portfolioplus' ),
		'expires%s' => __( 'Expires %s.', 'portfolioplus' ),
		'%1$s/%2$-sites' => __( 'You have %1$s / %2$s sites activated.', 'portfolioplus' ),
		'license-key-expired-%s' => __( 'License key expired %s.', 'portfolioplus' ),
		'license-key-expired' => __( 'License key has expired.', 'portfolioplus' ),
		'license-keys-do-not-match' => __( 'License keys do not match.', 'portfolioplus' ),
		'license-is-inactive' => __( 'License is inactive.', 'portfolioplus' ),
		'license-key-is-disabled' => __( 'License key is disabled.', 'portfolioplus' ),
		'site-is-inactive' => __( 'Site is inactive.', 'portfolioplus' ),
		'license-status-unknown' => __( 'License status is unknown.', 'portfolioplus' ),
		'update-notice' => __( "Updating this theme will lose any customizations you have made. 'Cancel' to stop, 'OK' to update.", 'portfolioplus' ),
		'update-available' => __('<strong>%1$s %2$s</strong> is available. <a href="%3$s" class="thickbox" title="%4s">Check out what\'s new</a> or <a href="%5$s"%6$s>update now</a>.', 'portfolioplus' )
	)

);