<?php
/**
 * General post content template
 *
 * @package Portfolio Plus
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'portfolioplus' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
		<div class="entry-meta">
			<?php portfolioplus_postby_meta(); ?>
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->

	<?php if ( is_archive() || is_search() ) : // Only display Excerpts for archives & search ?>
	<div class="entry-summary">
		<?php the_excerpt( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'portfolioplus' ) ); ?>
	</div><!-- .entry-summary -->
	<?php else : ?>
	<div class="entry-content">
		<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'portfolioplus' ) ); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'portfolioplus' ), 'after' => '</div>' ) ); ?>
	</div><!-- .entry-content -->
	<?php endif; ?>

	<?php portfoliopress_footer_meta( get_post_format() ); ?>
	
</article><!-- #post-<?php the_ID(); ?> -->
