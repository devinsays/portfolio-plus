<?php
/**
 * General post content template
 *
 * @package Portfolio+
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header">
		<h1 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
		<?php if ( 'page' != $post->post_type ) : ?>
		<div class="entry-meta">
			<?php portfolioplus_postby_meta(); ?>
		</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->

	<div class="entry-content">

		<?php if ( portfolioplus_get_option( 'portfolio_images', true ) ) {
			portfolioplus_display_image();
		} ?>
		<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'portfolio-plus' ) ); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'portfolio-plus' ), 'after' => '</div>' ) ); ?>
	</div><!-- .entry-content -->

	<?php portfolioplus_footer_meta( $post ); ?>

</article><!-- #post-<?php the_ID(); ?> -->
