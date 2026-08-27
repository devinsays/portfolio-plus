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
		'theme-license' => __( 'Theme License', 'portfolio-plus' ),
		'enter-key' => __( 'Enter your theme license key.', 'portfolio-plus' ),
		'license-key' => __( 'License Key', 'portfolio-plus' ),
		'license-action' => __( 'License Action', 'portfolio-plus' ),
		'deactivate-license' => __( 'Deactivate License', 'portfolio-plus' ),
		'activate-license' => __( 'Activate License', 'portfolio-plus' ),
		'status-unknown' => __( 'License status is unknown.', 'portfolio-plus' ),
		'renew' => __( 'Renew?', 'portfolio-plus' ),
		'unlimited' => __( 'unlimited', 'portfolio-plus' ),
		'license-key-is-active' => __( 'License key is active.', 'portfolio-plus' ),
		/* translators: %s: License expiration date. */
		'expires%s' => __( 'Expires %s.', 'portfolio-plus' ),
		/* translators: %1$s: Number of sites activated. %2$s: Site limit for the license, or "unlimited". */
		'%1$s/%2$-sites' => __( 'You have %1$s / %2$s sites activated.', 'portfolio-plus' ),
		/* translators: %s: Date the license expired. */
		'license-key-expired-%s' => __( 'License key expired %s.', 'portfolio-plus' ),
		'license-key-expired' => __( 'License key has expired.', 'portfolio-plus' ),
		'license-keys-do-not-match' => __( 'License keys do not match.', 'portfolio-plus' ),
		'license-is-inactive' => __( 'License is inactive.', 'portfolio-plus' ),
		'license-key-is-disabled' => __( 'License key is disabled.', 'portfolio-plus' ),
		'site-is-inactive' => __( 'Site is inactive.', 'portfolio-plus' ),
		'license-status-unknown' => __( 'License status is unknown.', 'portfolio-plus' ),
		'update-notice' => __( "Updating this theme will lose any customizations you have made. 'Cancel' to stop, 'OK' to update.", 'portfolio-plus' ),
		/*
		 * translators: Update available notice.
		 * %1$s: Theme name.
		 * %2$s: New version number.
		 * %3$s: URL of the changelog thickbox.
		 * %4$s: Theme name, for the link title attribute.
		 * %5$s: Update URL.
		 * %6$s: Confirmation onclick attribute, already escaped.
		 */
		'update-available' => __('<strong>%1$s %2$s</strong> is available. <a href="%3$s" class="thickbox" title="%4$s">Check out what\'s new</a> or <a href="%5$s"%6$s>update now</a>.', 'portfolio-plus' )
	)

);