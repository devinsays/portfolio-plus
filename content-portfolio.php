<?php
/**
 * This template displays portfolio post content
 *
 * @package Portfolio+
 */

// If no image is set, we'll use a fallback image
if ( has_post_thumbnail() ) {
	$image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'portfolio-thumbnail', true );
	$image = $image[0];
	$class = "image-thumbnail";
} else {
	$format = get_post_format();
	$image = get_template_directory_uri() . '/images/image.svg';
	$formats = array( 'gallery', 'image', 'video' );
	if ( in_array( $format, $formats ) ) {
		$image = get_template_directory_uri() . '/images/' . $format . '.svg';
	}
	$class = 'fallback-thumbnail';
}

// If password is required, always show lock image
if ( post_password_required() ) {
	$image = get_template_directory_uri() . '/images/lock.svg';
	$class = 'fallback-thumbnail';
}

// If alternative link is set, use it
$link = get_the_permalink();
$target = '';
if ( get_post_meta( $post->ID, 'portfolioplus_url', true ) ) {
	$link = esc_url( get_post_meta( $post->ID, 'portfolioplus_url', true ) );
	if ( get_post_meta( $post->ID, 'portfolioplus_url_target', true ) ) {
		$target = ' target="_blank"';
	}
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="entry-content">
		<a href="<?php echo $link; ?>" <?php echo $target; ?> rel="bookmark" class="thumb" aria-labelledby="post-<?php the_ID(); ?>-title">
			<h3 id="post-<?php the_ID(); ?>-title"><?php the_title() ?></h3>
			<img class="<?php echo $class; ?>" src="<?php echo esc_url( $image ); ?>" width="360" height="260">
		</a>
	</div><!-- .entry-content -->
</article><!-- #post-<?php the_ID(); ?> -->