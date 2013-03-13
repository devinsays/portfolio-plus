<?php
/**
 * The template used to display tag archive pages
 *
 * @package Portfolio Plus
 */

get_header(); ?>

	<div id="primary">
		<div id="content" role="main">

			<?php the_post(); ?>
			
			<header class="entry-header">
				<h1 class="archive-title"><?php printf( __( 'Tag: %s', 'portfolioplus' ), '<span>' . single_tag_title( '', false ) . '</span>' ); ?></h1>
				<?php $categorydesc = category_description(); if ( ! empty( $categorydesc ) ) echo apply_filters( 'archive_meta', '<div class="archive-meta">' . $categorydesc . '</div>' ); ?>
			</header>

			<?php rewind_posts(); ?>

			<?php if ( have_posts() ) : ?>

				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>

					<?php
						/* Include the Post-Format-specific template for the content.
						 * If you want to overload this in a child theme then include a file
						 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
						 */
						get_template_part( 'content', get_post_format() );
					?>

				<?php endwhile; ?>

				<?php portfolioplus_content_nav(); ?>
				
			<?php else : ?>
				<?php get_template_part( 'content', 'none' ); ?>
			<?php endif; ?>

			</div><!-- #content -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>