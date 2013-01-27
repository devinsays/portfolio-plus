<?php
/**
 * @package WordPress
 * @subpackage Portfolio Plus
 */

/* Add a checkbox to the featured image metabox */

if ( of_get_option('portfolio_images', "1") ) {
	add_filter( 'admin_post_thumbnail_html', 'portfolioplus_featured_image_meta');
}

function portfolioplus_featured_image_meta( $content ) {
	global $post;
	$text = __( "Don't display image on post.", 'portfolioplus' );
	$id = 'hide_featured_image';
	$value = esc_attr( get_post_meta( $post->ID, $id, true ) );
    $label = '<label for="' . $id . '" class="selectit"><input name="' . $id . '" type="checkbox" id="' . $id . '" value="' . $value . ' "'. checked( $value, 1, false) .'> ' . $text .'</label>';
    return $content .= $label;
}

/* Fire our meta box setup function on the post editor screen. */
add_action( 'load-post.php', 'portfolioplus_meta_boxes_setup' );
add_action( 'load-post-new.php', 'portfolioplus_meta_boxes_setup' );


/* Meta box setup function. */
function portfolioplus_meta_boxes_setup() {

	/* Add meta boxes on the 'add_meta_boxes' hook. */
	add_action( 'add_meta_boxes', 'portfolioplus_add_post_meta_boxes' );

	/* Save post meta on the 'save_post' hook. */
	add_action( 'save_post', 'portfolioplus_verify_meta', 10, 2 );
}

/*	Create one or more meta boxes to be displayed on the post editor screen.
 *	http://codex.wordpress.org/Function_Reference/add_meta_box
 */

function portfolioplus_add_post_meta_boxes() {

	add_meta_box(
		'portfolioplus-portfolio-url',	// Unique ID
		esc_html__( 'Portfolio Link', 'portfolioplus' ),	// Title
		'portfolioplus_url_meta_box',	// Callback
		'portfolio',	// Post type
		'normal',	// Context
		'high'	// Priority
	);
}

/* Display the post meta box. */
function portfolioplus_url_meta_box( $object, $box ) { ?>
	<?php wp_nonce_field( basename( __FILE__ ), 'portfolioplus_nonce' ); ?>
	<p>
		<label for="portfolioplus-portfolio-url"><?php _e( "If you enter a url below, your portfolio item will link to it in portfolio archives:", 'portfolioplus' ); ?></label>
		<br><br>
		<input class="widefat" type="text" name="portfolioplus-portfolio-url" id="portfolioplus-portfolio-url" value="<?php echo esc_attr( get_post_meta( $object->ID, 'portfolioplus_url', true ) ); ?>" size="30" />
	</p>
<?php }

/* Verify that the meta data can be saved */
function portfolioplus_verify_meta( $post_id, $post ) {

	/* Verify the nonce before proceeding. */
	if ( !isset( $_POST['portfolioplus_nonce'] ) || !wp_verify_nonce( $_POST['portfolioplus_nonce'], basename( __FILE__ ) ) )
		return $post_id;

	/* Get the post type object. */
	$post_type = get_post_type_object( $post->post_type );

	/* Check if the current user has permission to edit the post. */
	if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
		return $post_id;
		
	/* Get the posted data and sanitize it for a url */
	$url_meta_value = ( isset( $_POST['portfolioplus-portfolio-url'] ) ? esc_url( $_POST['portfolioplus-portfolio-url'] ) : '' );
	$url_meta_key = 'portfolioplus_url';
	
	// Update the url meta
	portfoliolus_update_meta( $post_id, $url_meta_value, $url_meta_key );
	
	$image_meta_value = isset( $_POST['hide_featured_image'] );
	if ( $image_meta_value )
		$image_meta_value = 1;
	$image_meta_key = 'hide_featured_image';
	
	// Update the featured image meta
	portfoliolus_update_meta( $post_id, $image_meta_value, $image_meta_key );
}

/* Update post meta */
function portfoliolus_update_meta( $post_id, $new_meta_value, $meta_key ) {

	/* Get the meta value of the custom field key. */
	$meta_value = get_post_meta( $post_id, $meta_key, true );

	/* If a new meta value was added and there was no previous value, add it. */
	if ( $new_meta_value && '' == $meta_value )
		add_post_meta( $post_id, $meta_key, $new_meta_value, true );

	/* If the new meta value does not match the old value, update it. */
	elseif ( $new_meta_value && $new_meta_value != $meta_value )
		update_post_meta( $post_id, $meta_key, $new_meta_value );

	/* If there is no new meta value but an old value exists, delete it. */
	elseif ( '' == $new_meta_value && $meta_value )
		delete_post_meta( $post_id, $meta_key, $meta_value );
}