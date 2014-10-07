<?php
/*
 * Template Name: Portfolio Categories
 * Description: Displays all the portfolio categories
 *
 * @package Portfolio+
 */

get_header();

// The query is cached since it's a bit expensive
$portfolioplus_category_query = get_transient( 'portfolioplus_category_query' );

if ( !$portfolioplus_category_query ) {
	if ( class_exists( 'Portfolio_Post_Type' ) ) {
		$portfolioplus_category_query = portfolioplus_category_cache();
	} else {
		$portfolioplus_category_query = array();
	}
}
?>

<?php
// Set thumbnail size
$thumbnail = 'thumbnail';

// Set fullwidth thumbnail size
if (
	of_get_option( 'portfolio_sidebar' ) ||
	of_get_option( 'layout', 'layout-2cr' ) ==  'layout-1col' ) {
	$thumbnail = 'thumbnail-fullwidth';
}
?>

	<div id="primary">
		<div id="content" role="main">

			<?php /* Start the Loop */ ?>
			<?php foreach ( $portfolioplus_category_query as $portfolio_cat ) { ?>

				<article class="hentry">
					<div class="entry-content">
						<a href="<?php echo $portfolio_cat['term_link']; ?>" rel="bookmark" class="thumb">
							<h3><?php echo $portfolio_cat['name']; ?></h3>
							<?php if ( isset( $portfolio_cat['portfolio-' . $thumbnail] ) ) { ?>
								<img src="<?php echo $portfolio_cat['portfolio-' . $thumbnail]; ?>">
							<?php } else { ?>
								<img src="<?php echo esc_url( get_template_directory_uri() . '/images/placeholder-' . $thumbnail . '.gif' ); ?>">
							<?php } ?>
						</a>
					</div><!-- .entry-content -->
				</article><!-- #post-<?php the_ID(); ?> -->

			<?php } ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php if ( !of_get_option( 'portfolio_sidebar' ) ) { get_sidebar(); } ?>
<?php get_footer(); ?>