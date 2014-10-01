<?php
/**
 * This template displays portfolio post content
 *
 * @package Portfolio+
 */

// Set thumbnail size
$thumbnail = 'thumbnail';

// Set fullwidth thumbnail size
if (
	of_get_option( 'portfolio_sidebar', 0 ) ||
	of_get_option( 'layout', 'layout-2cr' ) ==  'layout-1col' ) {
	$thumbnail = 'thumbnail-fullwidth';
}
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="entry-content">
		<?php
		$link = get_the_permalink();
		$target = '';
		if ( get_post_meta( $post->ID, 'portfolioplus_url', true ) ) {
			$link = esc_url( get_post_meta( $post->ID, 'portfolioplus_url', true ) );
			$target = ' target="_blank"';
		} ?>
		<a href="<?php echo $link; ?>" <?php echo $target; ?> rel="bookmark" class="thumb">
			<h3><?php the_title() ?></h3>
			<?php
			if ( has_post_format( array( 'gallery', 'image' ) ) ) :
				$format = get_post_format();
			?>
			<div class="portfolio-format-meta icon-format-<?php echo $format; ?>"></div>
			<?php endif; ?>
			<?php if ( post_password_required() ) { ?>
				<img src="<?php echo  esc_url( get_template_directory_uri() . '/images/protected-' . $thumbnail . '.gif' ); ?>">
			<?php }
			elseif ( has_post_thumbnail() ) {
				the_post_thumbnail( 'portfolio-' . $thumbnail );
			} else { ?>
				<img src="<?php echo esc_url( get_template_directory_uri() . '/images/placeholder-' . $thumbnail . '.gif' ); ?>">
			<?php } ?>
		</a>
	</div><!-- .entry-content -->
</article><!-- #post-<?php the_ID(); ?> -->