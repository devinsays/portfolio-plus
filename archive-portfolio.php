<?php
/**
 * This is the default view for portfolio archives.
 *
 * @package Portfolio+
 */

get_header(); ?>

	<div id="primary">
		<div id="content" role="main">

			<?php if ( is_tax() ): ?>
			<header class="archive-header">
				<h1 class="archive-title"><?php echo single_cat_title( '', false ); ?></h1>
				<?php $categorydesc = category_description();
					if ( ! empty( $categorydesc ) ) {
						echo apply_filters( 'archive_meta', '<div class="archive-meta">' . $categorydesc . '</div>' );
				} ?>
			</header>
			<?php endif; ?>

			<?php if ( have_posts() ) : ?>

				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>

					<?php
						/* Include the Post-Format-specific template for the content.
						 * If you want to overload this in a child theme then include a file
						 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
						 */
						get_template_part( 'content', 'portfolio' );
					?>

				<?php endwhile; ?>

				<?php portfolioplus_paging_nav(); ?>

			<?php else : ?>
				<?php get_template_part( 'content', 'none' ); ?>
			<?php endif; ?>

			</div><!-- #content -->
		</div><!-- #primary -->

<?php if ( !of_get_option( 'portfolio_sidebar' ) )
        get_sidebar(); ?>
<?php get_footer(); ?>