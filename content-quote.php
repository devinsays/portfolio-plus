<?php
/**
 * @package WordPress
 * @subpackage Portfolio Plus
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="entry-content">
		<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'portfolioplus' ) ); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'portfolioplus' ), 'after' => '</div>' ) ); ?>
	</div><!-- .entry-content -->

	<footer class="entry-meta">
		<?php
			printf( __( '<span class="meta-prep meta-prep-author">Posted on </span><a href="%1$s" rel="bookmark"><time class="entry-date" datetime="%2$s" pubdate>%3$s</time></a> <span class="meta-sep"> by </span> <span class="author vcard"><a class="url fn n" href="%4$s" title="%5$s">%6$s</a></span>', 'portfolioplus' ),
				get_permalink(),
				get_the_date( 'c' ),
				get_the_date(),
				get_author_posts_url( get_the_author_meta( 'ID' ) ),
				sprintf( esc_attr__( 'View all posts by %s', 'portfolioplus' ), get_the_author() ),
				get_the_author()
			);
		?>
		<span class="meta-sep"> | </span>
		<span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'portfolioplus' ), __( '1 Comment', 'portfolioplus' ), __( '% Comments', 'portfolioplus' ) ); ?></span>
		<?php edit_post_link( __( 'Edit', 'portfolioplus' ), '<span class="meta-sep">|</span> <span class="edit-link">', '</span>' ); ?>
	</footer><!-- #entry-meta -->
</article><!-- #post-<?php the_ID(); ?> -->
