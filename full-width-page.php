<?php
/**
 * Template Name: Full-width Page
 * Description: A full-width template with no sidebar
 *
 * @package WordPress
 * @subpackage Portfolio Plus
 */

global $content_width;

if ( of_get_option('layout') == 'layout-1col' ) {
	$content_width = 780;
} else {
	$content_width = 980;
}

get_header(); ?>

	<div id="primary" class="full-width">
		<div id="content" role="main">

			<?php the_post(); ?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<header class="entry-header">
					<h1 class="entry-title"><?php the_title(); ?></h1>
				</header><!-- .entry-header -->

				<div class="entry-content">
					<?php the_content(); ?>
					<?php wp_link_pages( 'before=<div class="page-link">' . __( 'Pages:', 'portfolioplus' ) . '&after=</div>' ); ?>
					<?php edit_post_link( __( 'Edit', 'portfolioplus' ), '<span class="edit-link">', '</span>' ); ?>
				</div><!-- .entry-content -->
			</article><!-- #post-<?php the_ID(); ?> -->

			<?php comments_template( '', true ); ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_footer(); ?>