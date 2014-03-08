<?php
/**
 * The template used to display categories (for standard posts)
 *
 * @package Portfolio+
 */

get_header(); ?>

	<div id="primary">
		<div id="content" role="main">

			<h2 class="page-title"><?php
				printf( __( 'Category Archives: %s', 'portfolioplus' ), '<span>' . single_cat_title( '', false ) . '</span>' );
			?></h2>

			<?php $categorydesc = category_description(); if ( ! empty( $categorydesc ) ) echo apply_filters( 'archive_meta', '<div class="archive-meta">' . $categorydesc . '</div>' ); ?>

			<?php if ( have_posts() ) : ?>

				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content', get_post_format() ); ?>

				<?php endwhile; ?>

				<?php portfolioplus_paging_nav(); ?>

			<?php else : ?>
				<?php get_template_part( 'content', 'none' ); ?>
			<?php endif; ?>

			</div><!-- #content -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
