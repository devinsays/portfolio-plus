<?php
/**
 * @package Portfolio+
 */

/**
 * Overrides the default behavior of portfolio taxonomies to use the archive-portfolio template
 * http://www.billerickson.net/reusing-wordpress-theme-files/
 *
 * @param string template path
 */
function portfolioplus_template_chooser( $template ) {

	global $wp_query;
	$portfolio = false;

	// Check if the taxonomy query contains only image or gallery post formats
	if ( is_category() || is_tag() || is_home() ) {
		$portfolio = true;
		if ( $wp_query->have_posts() ) :
			while ( $wp_query->have_posts() ) : $wp_query->the_post();
				$format = get_post_format();
				if ( ( $format !=='image' ) && ( $format != 'gallery' ) ) {
					$portfolio = false;
				}
			endwhile;
		endif;
	}

	// Check if template should be displayed as archive-portfolio.php
	if (
		is_post_type_archive( 'portfolio' ) ||
		is_tax( 'post_format', 'post-format-image' ) ||
		is_tax( 'post_format', 'post-format-gallery' ) ||
		is_tax( 'portfolio_category' ) ||
		is_tax( 'portfolio_tag' )
	) {
		$portfolio = true;
	}

	// Use the archive-portfolio.php template
	if ( $portfolio ) {
		$wp_query->set( 'portfolio_view', true );
		$template = get_query_template( 'archive-portfolio' );
	}

	return $template;
}
add_filter( 'template_include', 'portfolioplus_template_chooser' );

/**
 * Adds a body class to archives that display as a portfolio view
 *
 * @param array classes applied to post
 * @return array modified classes
 */
function portfolioplus_body_class( $classes ) {

	global $post;

	if (
		is_page_template( 'templates/portfolio.php' ) ||
		is_page_template( 'templates/full-width-portfolio.php' ) ||
		is_page_template( 'templates/image-gallery-formats.php' ) ||
		is_page_template( 'templates/full-width-image-gallery-formats.php' ) ||
		is_page_template( 'templates/portfolio-categories.php' ) ||
		get_query_var( 'portfolio_view' )
	) {
		$classes[] = 'portfolio-view';
		if ( of_get_option( 'portfolio_sidebar', false ) ) {
			$classes[] = 'full-width-portfolio';
		}
	}

	// Remove the term "templates" from the page template body class
	// Primarily for backwards compatibility
	if ( isset( $post ) && (
			is_page_template( 'templates/full-width-page.php' ) ||
			is_page_template( 'templates/portfolio.php' ) ||
			is_page_template( 'templates/full-width-portfolio.php' ) ||
			is_page_template( 'templates/image-gallery-formats.php' ) ||
			is_page_template( 'templates/full-width-image-gallery-formats.php' ) ||
			is_page_template( 'templates/portfolio-categories.php' )
		)
	) {
		foreach( $classes as $key => $value) {
			if ( $value == 'page-template-templatesfull-width-page-php') {
				$classes[$key] = 'page-template-full-width-page-php';
			}
			if ( $value == 'page-template-templatesportfolio-php') {
				$classes[$key] = 'page-template-portfolio-php';
			}
			if ( $value == 'page-template-templatesfull-width-portfolio-php') {
				$classes[$key] = 'page-template-full-width-portfolio-php';
			}
			if ( $value == 'page-template-templatesimage-gallery-formats-php') {
				$classes[$key] = 'page-template-image-gallery-formats-php';
			}
			if ( $value == 'page-template-templatesfull-width-image-gallery-formats-php') {
				$classes[$key] = 'page-template-full-width-image-gallery-formats-php';
			}
			if ( $value == 'page-template-templatesportfolio-categories-php') {
				$classes[$key] = 'page-template-portfolio-categories-php';
			}
		}
	}

	if ( !of_get_option( 'portfolio_sidebar', false ) ) {
		if (
			is_page_template( 'templates/full-width-portfolio.php' ) ||
			is_page_template( 'templates/full-width-image-gallery-formats.php' )
		) {
			$classes[] = 'full-width-portfolio';
		}
	}

	return $classes;
}
add_filter( 'body_class','portfolioplus_body_class' );

/**
 * Helper function for displaying image
 */
if ( ! function_exists( 'portfolioplus_display_image' ) ) :
function portfolioplus_display_image() {

	// Exit if no featured image is set
	if ( ! has_post_thumbnail() || post_password_required() ) {
		return;
	}

	// Don't display images on single post if the option is turned off
	if ( is_single() ) {
		if ( ! of_get_option( 'portfolio_images', '1' ) ) {
			return;
		}

		if ( get_post_meta( get_the_ID(), 'hide_featured_image', true ) ) {
			return;
		}
	}

	// Okay, let's display the image
	if ( ( 'image' == get_post_format() ) || 'portfolio' == get_post_type() ) { ?>
	<div class="portfolio-image">
		<?php if ( !is_single() ) { ?>
			<a href="<?php the_permalink() ?>" rel="bookmark" class="thumb">
		<?php } ?>
		<?php if ( ( of_get_option( 'layout' ) == 'layout-1col' ) || portfolioplus_post_template() ) {
			the_post_thumbnail( 'portfolio-fullwidth' );
		} else {
			the_post_thumbnail( 'portfolio-large' );
		} ?>
		<?php if ( !is_single() ) { ?>
			</a>
		<?php } ?>
	</div>
	<?php  }
}
endif;

/**
 * Add a checkbox to the featured image metabox
 */
if ( of_get_option( 'portfolio_images', '1' ) ) {
	add_filter( 'admin_post_thumbnail_html', 'portfolioplus_featured_image_meta');
}

/**
 * Adds a checkbox to the featured image metabox.
 *
 * @param string $content
 */
if ( ! function_exists( 'portfolioplus_featured_image_meta' ) ) :
function portfolioplus_featured_image_meta( $content ) {
	global $post;
	$text = __( "Don't display image in post.", 'portfolioplus' );
	$id = 'hide_featured_image';
	$value = esc_attr( get_post_meta( $post->ID, $id, true ) );
    $label = '<label for="' . $id . '" class="selectit"><input name="' . $id . '" type="checkbox" id="' . $id . '" value="' . $value . ' "'. checked( $value, 1, false) .'> ' . $text .'</label>';
    return $content .= $label;
}
endif;

/**
 * Action hooks for metaboxes.
 */
add_action( 'load-post.php', 'portfolioplus_meta_boxes_setup' );
add_action( 'load-post-new.php', 'portfolioplus_meta_boxes_setup' );


/**
 * Meta box setup function.
 */
if ( ! function_exists( 'portfolioplus_meta_boxes_setup' ) ) :
function portfolioplus_meta_boxes_setup() {

	/* Add meta boxes on the 'add_meta_boxes' hook. */
	add_action( 'add_meta_boxes', 'portfolioplus_add_post_meta_boxes' );

	/* Save post meta on the 'save_post' hook. */
	add_action( 'save_post', 'portfolioplus_verify_meta', 10, 2 );
}
endif;

/**
 * Create metaboxes to be displayed on the post editor screen.
 *
 * @link http://codex.wordpress.org/Function_Reference/add_meta_box
 * @param string $post_type
 */
if ( ! function_exists( 'portfolioplus_add_post_meta_boxes' ) ) :
function portfolioplus_add_post_meta_boxes( $post_type ) {

	$types = array( 'post', 'portfolio' );

	if ( in_array( $post_type, $types ) ) {

		add_meta_box(
			'portfolioplus-portfolio-url',	// Unique ID
			esc_html__( 'Portfolio Link', 'portfolioplus' ),	// Title
			'portfolioplus_url_meta_box',	// Callback
			$post_type,	// Post type
			'normal',	// Context
			'high'	// Priority
		);

		if ( of_get_option( 'layout' ) != 'layout-1col' ) :
		add_meta_box(
			'portfolioplus-post-atrributes',	// Unique ID
			esc_html__( 'Post Attributes', 'portfolioplus' ),	// Title
			'portfolioplus_post_template_meta_box',	// Callback
			$post_type,	// Post type
			'side',	// Context
			'low'	// Priority
		);
		endif;
	}
}
endif;

/**
 * Display the portfolio url metabox.
 *
 * @param object $post
 */
if ( ! function_exists( 'portfolioplus_url_meta_box' ) ) :
function portfolioplus_url_meta_box( $post ) { ?>
	<?php wp_nonce_field( basename( __FILE__ ), 'portfolioplus_nonce' ); ?>
	<p>
		<label for="portfolioplus-portfolio-url"><?php _e( 'If you enter a url below, your image, gallery, or portfolio item will link to it from the archive.', 'portfolioplus' ); ?></label>
	</p>
	<?php $value = esc_attr( get_post_meta( $post->ID, 'portfolioplus_url', true ) ); ?>
	<p>
		<input class="widefat" type="text" name="portfolioplus-portfolio-url" id="portfolioplus-portfolio-url" value="<?php echo $value; ?>" size="30" />
	</p>
	<?php $value = get_post_meta( $post->ID, 'portfolioplus_url_target', true ); ?>
	<p>
		<label for="portfolioplus-url-target" class="selectit">
			<input name="portfolioplus_url_target" type="checkbox" id="portfolioplus-url-target" value="<?php echo $value; ?>" <?php echo checked( $value, 1, false); ?>><?php _e( 'Open link in new window', 'portfolioplus' ); ?></label>
	</p>
<?php }
endif;

/**
 * Display the post template metabox
 *
 * @param object $post
 */
if ( ! function_exists( 'portfolioplus_post_template_meta_box' ) ) :
function portfolioplus_post_template_meta_box( $post ) { ?>
	<?php $value = get_post_meta( $post->ID, 'portfolioplus_post_template', true ); ?>
	<p><strong><?php _e( 'Template', 'portfolioplus' ); ?></strong></p>
	<label class="screen-reader-text" for="portfolioplus-post-template"><?php _e( 'Post Template', 'portfolioplus' ); ?></label>
	<select name="portfolioplus-post-template" id="portfolioplus-post-template">
		<option value="default" <?php selected( $value, 'default' ); ?>><?php _e( 'Default Template', 'portfolioplus' ); ?></option>
		<option value="full-width" <?php selected( $value, 'full-width' ); ?>><?php _e( 'Full Width', 'portfolioplus' ); ?></option>
	</select>
	<p>
<?php }
endif;

/**
 * Verify that the meta data can be saved.
 *
 * @param numeric $post_id
 * @param object $post
 */
if ( ! function_exists( 'portfolioplus_verify_meta' ) ) :
function portfolioplus_verify_meta( $post_id, $post ) {

	// Verify the nonce before proceeding.
	if ( !isset( $_POST['portfolioplus_nonce'] ) || !wp_verify_nonce( $_POST['portfolioplus_nonce'], basename( __FILE__ ) ) ) {
		return $post_id;
	}

	// Get the post type object.
	$post_type = get_post_type_object( $post->post_type );

	// Check if the current user has permission to edit the post.
	if ( !current_user_can( $post_type->cap->edit_post, $post_id ) ) {
		return $post_id;
	}

	// Get the posted data for url and sanitize it.
	$url_meta_value = ( isset( $_POST['portfolioplus-portfolio-url'] ) ? esc_url( $_POST['portfolioplus-portfolio-url'] ) : '' );

	// Update the url meta.
	portfolioplus_update_meta( $post_id, $url_meta_value, 'portfolioplus_url' );

	// Open link in new winow
	$target = isset( $_POST['portfolioplus_url_target'] );
	if ( $target ) {
		$target = 1;
	} else {
		$target = 0;
	}

	portfolioplus_update_meta( $post_id, $target, 'portfolioplus_url_target' );

	// Get the posted data for post template.
	$post_template = ( isset( $_POST['portfolioplus-post-template'] ) ? sanitize_text_field( $_POST['portfolioplus-post-template'] ) : '' );

	// Update the post template meta.
	portfolioplus_update_meta( $post_id, $post_template, 'portfolioplus_post_template' );

	// Hide feature image value
	$image_meta_value = isset( $_POST['hide_featured_image'] );
	if ( $image_meta_value ) {
		$image_meta_value = 1;
	} else {
		$image_meta_value = 0;
	}

	// Update the featured image meta
	portfolioplus_update_meta( $post_id, $image_meta_value, 'hide_featured_image' );
}
endif;

/**
 * Update post meta.
 *
 * @param numeric $post_id
 * @param string $new_meta_value
 * @param numeric $meta_key
 */
if ( ! function_exists( 'portfolioplus_update_meta' ) ) :
function portfolioplus_update_meta( $post_id, $new_meta_value, $meta_key ) {

	/* Get the meta value of the custom field key. */
	$meta_value = get_post_meta( $post_id, $meta_key, true );

	/* If a new meta value was added and there was no previous value, add it. */
	if ( $new_meta_value && '' == $meta_value ) {
		add_post_meta( $post_id, $meta_key, $new_meta_value, true );
	}

	/* If the new meta value does not match the old value, update it. */
	elseif ( $new_meta_value && $new_meta_value != $meta_value ) {
		update_post_meta( $post_id, $meta_key, $new_meta_value );
	}

	/* If there is no new meta value but an old value exists, delete it. */
	elseif ( '' == $new_meta_value && $meta_value ) {
		delete_post_meta( $post_id, $meta_key, $meta_value );
	}
}
endif;