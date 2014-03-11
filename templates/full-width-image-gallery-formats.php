<?php
/**
 * Template Name: Full Width Image and Gallery Posts
 * Descriptions: Displays all image and gallery post formats.
 *
 * @package Portfolio Press
 */

get_header(); ?>

<?php
if ( get_query_var('paged') ) {
  $paged = get_query_var('paged');
} elseif ( get_query_var('page') ) {
  $paged = get_query_var('page');
} else {
  $paged = 1;
}
$posts_per_page = apply_filters( 'portfoliopress_posts_per_page', '9' );
$args = array(
	'tax_query' => array(
		array(
		    'taxonomy' => 'post_format',
		    'field' => 'slug',
		    'terms' => array( 'post-format-image', 'post-format-gallery' ),
		)
	),
	'posts_per_page' => $posts_per_page,
	'paged' => $paged
);
// Override the primary post loop
query_posts( $args );
?>

	<div id="primary">
		<div id="content" role="main">

			<?php if ( have_posts() ) : ?>

				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>


					<?php
						get_template_part( 'content', 'portfolio' );
					?>

				<?php endwhile; ?>

				<?php portfoliopress_paging_nav(); ?>

			<?php else : ?>
				<?php get_template_part( 'content', 'none' ); ?>
			<?php endif; ?>

			</div><!-- #content -->
		</div><!-- #primary -->

<?php wp_reset_query(); ?>

<?php get_footer(); ?>