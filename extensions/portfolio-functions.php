<?php
/**
 * @package WordPress
 * @subpackage Portfolio Plus
 */

/* Fire our meta box setup function on the post editor screen. */
add_action( 'load-post.php', 'portfolioplus_meta_boxes_setup' );
add_action( 'load-post-new.php', 'portfolioplus_meta_boxes_setup' );


/* Meta box setup function. */
function portfolioplus_meta_boxes_setup() {

	/* Add meta boxes on the 'add_meta_boxes' hook. */
	add_action( 'add_meta_boxes', 'smashing_add_post_meta_boxes' );

	/* Save post meta on the 'save_post' hook. */
	add_action( 'save_post', 'portfoliopress_save_url_meta', 10, 2 );
}

/*	Create one or more meta boxes to be displayed on the post editor screen.
 *	http://codex.wordpress.org/Function_Reference/add_meta_box
 */

function smashing_add_post_meta_boxes() {

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

	<?php wp_nonce_field( basename( __FILE__ ), 'portfolioplus_url_nonce' ); ?>

	<p>
		<label for="portfolioplus-portfolio-url"><?php _e( "If you enter a url below, your portfolio item will link to it in portfolio archives:", 'portfolioplus' ); ?></label>
		<br><br>
		<input class="widefat" type="text" name="portfolioplus-portfolio-url" id="portfolioplus-portfolio-url" value="<?php echo esc_attr( get_post_meta( $object->ID, 'portfolioplus_url', true ) ); ?>" size="30" />
	</p>
<?php }

/* Save the meta box's post metadata. */
function portfoliopress_save_url_meta( $post_id, $post ) {

	/* Verify the nonce before proceeding. */
	if ( !isset( $_POST['portfolioplus_url_nonce'] ) || !wp_verify_nonce( $_POST['portfolioplus_url_nonce'], basename( __FILE__ ) ) )
		return $post_id;

	/* Get the post type object. */
	$post_type = get_post_type_object( $post->post_type );

	/* Check if the current user has permission to edit the post. */
	if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
		return $post_id;

	/* Get the posted data and sanitize it for use as an HTML class. */
	$new_meta_value = ( isset( $_POST['portfolioplus-portfolio-url'] ) ? esc_url( $_POST['portfolioplus-portfolio-url'] ) : '' );

	/* Get the meta key. */
	$meta_key = 'portfolioplus_url';

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