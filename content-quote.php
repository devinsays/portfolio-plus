<?php
/**
 * Quote post format template
 *
 * @package Portfolio Plus
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="entry-content">
		<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'portfolioplus' ) ); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'portfolioplus' ), 'after' => '</div>' ) ); ?>
	</div><!-- .entry-content -->

	<?php portfolioplus_footer_meta( get_post_format() ); ?>

</article><!-- #post-<?php the_ID(); ?> -->
