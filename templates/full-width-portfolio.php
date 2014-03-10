<?php
/*
 * Template Name: Full-width Portfolio
 * Description: A full-width portfolio template with no sidebar.
 *
 * @package Portfolio+
 */

get_header(); ?>

<?php
global $paged;
$posts_per_page = apply_filters( 'portfolioplus_posts_per_page', of_get_option( 'portfolio_num', '9' ) );
$args = array(
	'post_type' => 'portfolio',
	'posts_per_page' => $posts_per_page,
	'paged' => $paged
);
$portfolio = new WP_Query( $args );
$thumbnail = 'thumbnail-fullwidth';
?>

	<div id="primary">
		<div id="content" role="main">

		<?php if ( $portfolio->have_posts() ) : ?>

			<?php /* Start the Loop */ ?>
			<?php while ( $portfolio->have_posts() ) : $portfolio->the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<div class="entry-content">
						<a href="<?php the_permalink() ?>" rel="bookmark" class="thumb">
							<h3><?php the_title() ?></h3>
							<?php if ( has_post_format() ) :
								$format = get_post_format();
							?>
							<div class="portfolio-format-meta icon-format-<?php echo $format; ?>"></div>
							<?php endif; ?>
							<?php if ( post_password_required() ) { ?>
								<img src="<?php echo esc_url( get_template_directory_uri() . '/images/protected-' . $thumbnail . '.gif' ); ?>">
							<?php }
							elseif ( has_post_thumbnail() ) {
								the_post_thumbnail( 'portfolio-' . $thumbnail );
							} else { ?>
								<img src="<?php echo esc_url( get_template_directory_uri() . '/images/placeholder-' . $thumbnail . '.gif' ); ?>">
							<?php } ?>
						</a>
					</div><!-- .entry-content -->
				</article><!-- #post-<?php the_ID(); ?> -->

			<?php endwhile; ?>

			<?php portfolioplus_paging_nav( $portfolio ); ?>

		<?php else : ?>
			<?php get_template_part( 'content', 'none' ); ?>
		<?php endif; ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php wp_reset_query(); ?>
<?php get_footer(); ?>
