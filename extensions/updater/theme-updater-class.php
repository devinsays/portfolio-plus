<?php
/**
 * Theme updater class.
 *
 * @package EDD Theme Updater
 */

class EDD_Theme_Updater {

	private $remote_api_url;
	private $request_data;
	private $response_key;
	private $theme_slug;
	private $license_key;
	private $license;
	private $item_name;
	private $version;
	private $author;
	protected $strings = null;

	function __construct( $args = array(), $strings = array() ) {

		$args = wp_parse_args( $args, array(
			'remote_api_url' => 'http://easydigitaldownloads.com',
			'request_data' => array(),
			'theme_slug' => get_template(),
			'item_name' => '',
			'license' => '',
			'version' => '',
			'author' => ''
		) );

		$this->license = $args['license'];
		$this->item_name = $args['item_name'];
		$this->version = $args['version'];
		$this->theme_slug = sanitize_key( $args['theme_slug'] );
		$this->author = $args['author'];
		$this->remote_api_url = $args['remote_api_url'];
		$this->request_data = $args['request_data'];
		$this->response_key = $this->theme_slug . '-update-response';
		$this->strings = $strings;

		add_filter( 'site_transient_update_themes', array( &$this, 'theme_update_transient' ) );
		add_filter( 'delete_site_transient_update_themes', array( &$this, 'delete_theme_update_transient' ) );
		add_action( 'load-update-core.php', array( &$this, 'delete_theme_update_transient' ) );
		add_action( 'load-themes.php', array( &$this, 'delete_theme_update_transient' ) );
		add_action( 'load-themes.php', array( &$this, 'load_themes_screen' ) );
	}

	function load_themes_screen() {
		add_thickbox();
		add_action( 'admin_notices', array( &$this, 'update_nag' ) );
	}

	function update_nag() {

		$strings = $this->strings;

		$theme = wp_get_theme( $this->theme_slug );

		$api_response = get_transient( $this->response_key );

		if ( false === $api_response ) {
			return;
		}

		$update_url = wp_nonce_url( 'update.php?action=upgrade-theme&amp;theme=' . urlencode( $this->theme_slug ), 'upgrade-theme_' . $this->theme_slug );
		$update_onclick = ' onclick="if ( confirm(\'' . esc_js( $strings['update-notice'] ) . '\') ) {return true;}return false;"';

		if ( version_compare( $this->version, $api_response->new_version, '<' ) ) {

			echo '<div id="update-nag">';
			printf(
				$strings['update-available'],
				$theme->get( 'Name' ),
				$api_response->new_version,
				'#TB_inline?width=640&amp;inlineId=' . $this->theme_slug . '_changelog',
				$theme->get( 'Name' ),
				$update_url,
				$update_onclick
			);
			echo '</div>';

			$changelog = $this->get_section( $api_response, 'changelog' );

			if ( '' !== $changelog ) {
				echo '<div id="' . $this->theme_slug . '_' . 'changelog" style="display:none;">';
				echo wpautop( $changelog );
				echo '</div>';
			}
		}
	}

	/**
	 * Safely reads a single section out of an API response.
	 *
	 * The sections property may be an array, an object or missing entirely,
	 * so every access is guarded before the value is returned.
	 *
	 * @param object $api_response Decoded API response.
	 * @param string $section Section name to retrieve.
	 * @return string Section content, or an empty string when unavailable.
	 */
	private function get_section( $api_response, $section ) {

		if ( ! is_object( $api_response ) || ! isset( $api_response->sections ) ) {
			return '';
		}

		$sections = $api_response->sections;

		if ( is_array( $sections ) && isset( $sections[ $section ] ) ) {
			return is_string( $sections[ $section ] ) ? $sections[ $section ] : '';
		}

		if ( is_object( $sections ) && isset( $sections->$section ) ) {
			return is_string( $sections->$section ) ? $sections->$section : '';
		}

		return '';
	}

	/**
	 * Normalizes the sections property of an API response.
	 *
	 * The EDD API returns sections as a serialized string. It is decoded
	 * without allowing any objects to be instantiated, so a tampered
	 * response cannot be used for PHP object injection.
	 *
	 * @param mixed $sections Raw sections value from the API response.
	 * @return array Sections as an array of strings.
	 */
	private function parse_sections( $sections ) {

		if ( is_string( $sections ) && is_serialized( $sections ) ) {
			$sections = unserialize( $sections, array( 'allowed_classes' => false ) );
		}

		if ( is_object( $sections ) ) {
			$sections = get_object_vars( $sections );
		}

		if ( ! is_array( $sections ) ) {
			return array();
		}

		$parsed = array();

		foreach ( $sections as $key => $value ) {
			if ( is_string( $value ) ) {
				$parsed[ $key ] = $value;
			}
		}

		return $parsed;
	}

	function theme_update_transient( $value ) {
		$update_data = $this->check_for_update();
		if ( $update_data ) {
			$value->response[ $this->theme_slug ] = $update_data;
		}
		return $value;
	}

	function delete_theme_update_transient() {
		delete_transient( $this->response_key );
	}

	function check_for_update() {

		$update_data = get_transient( $this->response_key );

		if ( false === $update_data ) {
			$failed = false;

			$api_params = array(
				'edd_action' 	=> 'get_version',
				'license' 		=> $this->license,
				'name' 			=> $this->item_name,
				'slug' 			=> $this->theme_slug,
				'author'		=> $this->author
			);

			$response = wp_remote_post( $this->remote_api_url, array( 'timeout' => 15, 'body' => $api_params ) );

			// Make sure the response was successful
			if ( is_wp_error( $response ) || 200 != wp_remote_retrieve_response_code( $response ) ) {
				$failed = true;
			}

			$update_data = json_decode( wp_remote_retrieve_body( $response ) );

			if ( ! is_object( $update_data ) ) {
				$failed = true;
			}

			// If the response failed, try again in 30 minutes
			if ( $failed ) {
				$data = new stdClass;
				$data->new_version = $this->version;
				set_transient( $this->response_key, $data, 30 * MINUTE_IN_SECONDS );
				return false;
			}

			// If the status is 'ok', return the update arguments
			if ( ! $failed ) {
				$update_data->sections = $this->parse_sections( isset( $update_data->sections ) ? $update_data->sections : array() );
				set_transient( $this->response_key, $update_data, 12 * HOUR_IN_SECONDS );
			}
		}

		if ( version_compare( $this->version, $update_data->new_version, '>=' ) ) {
			return false;
		}

		return (array) $update_data;
	}

}
