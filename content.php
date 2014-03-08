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

	<?php // Display excerpts for archives and search ?>
	<?php if ( is_archive() || is_search() ) :?>
	<div class="entry-summary">
		<?php portfolioplus_display_image(); ?>
		<?php $excerpt = get_the_excerpt(); ?>
		<?php if ( ( !$excerpt ) && !has_post_thumbnail() ) {
			the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'portfolioplus' ) );
		} else {
			echo '<p>' . $excerpt . '</p>';
		} ?>
	</div><!-- .entry-summary -->
	<?php else : ?>

	<?php // Otherwise show full content ?>
	<div class="entry-content">
		<?php portfolioplus_display_image(); ?>
		<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'portfolioplus' ) ); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'portfolioplus' ), 'after' => '</div>' ) ); ?>
	</div><!-- .entry-content -->
	<?php endif; ?>

	<?php portfolioplus_footer_meta( $post ); ?>

</article><!-- #post-<?php the_ID(); ?> -->
