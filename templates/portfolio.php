<?php
/**
 * Template Name: Portfolio
 * Description: Basic Portfolio template.
 *
 * @package Portfolio+
 */

get_header();

if ( get_query_var( 'paged' ) ) {
	$paged = get_query_var( 'paged' );
} elseif ( get_query_var( 'page' ) ) {
	$paged = get_query_var( 'page' );
} else {
	$paged = 1;
}
$args = array(
	'post_type' => 'portfolio',
	'paged' => $paged
);
$portfolio = new WP_Query( $args );
?>

<div id="primary">
	<div id="content" role="main">

		<?php if ( $portfolio->have_posts() ) : ?>

			<?php /* Start the Loop */ ?>
			<?php while ( $portfolio->have_posts() ) : $portfolio->the_post(); ?>

				<?php
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

			<?php endwhile; ?>

			<?php portfolioplus_paging_nav( $portfolio ); ?>

		<?php else : ?>
			<?php get_template_part( 'content', 'none' ); ?>
		<?php endif; ?>

	</div><!-- #content -->
</div><!-- #primary -->

<?php wp_reset_query(); ?>

<?php if ( ! portfolioplus_get_option( 'portfolio_sidebar', false ) ) { get_sidebar(); } ?>
<?php get_footer(); ?>