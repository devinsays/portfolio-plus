<?php
/**
 * Template for displaying a single post
 *
 * @package Portfolio+
 */

get_header(); ?>

		<div id="primary">
			<div id="content" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<header class="entry-header">
						<h1 class="entry-title"><?php the_title(); ?></h1>

						<div class="entry-meta">
							<?php portfolioplus_postby_meta(); ?>
						</div><!-- .entry-meta -->
					</header><!-- .entry-header -->

					<div class="entry-content">
						<?php portfolioplus_display_image(); ?>
						<?php the_content(); ?>
						<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'portfolioplus' ), 'after' => '</div>' ) ); ?>
					</div><!-- .entry-content -->

					<?php portfolioplus_footer_meta( $post ); ?>

				</article><!-- #post-<?php the_ID(); ?> -->

				<?php if ( comments_open() ) {
					comments_template( '', true );
                } ?>

			<?php endwhile; // end of the loop. ?>

			</div><!-- #content -->
		</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
