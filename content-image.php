<?php
/**
 * Image post format template
 *
 * @package Portfolio Plus
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header">
		<h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'portfolioplus' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
	</header>
		
	<div class="entry-content">
		<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'portfolioplus' ) ); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'portfolioplus' ), 'after' => '</div>' ) ); ?>
	</div><!-- .entry-content -->

	<?php portfolioplus_footer_meta( get_post_format() ); ?>
	
</article><!-- #post-<?php the_ID(); ?> -->
