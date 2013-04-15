<?php
/**
 * This template displays portfolio post content
 *
 * @package Portfolio Plus
 */

if ( is_page() && post_password_required() ) {
	echo get_the_password_form();
} else {
	// Set the size of the thumbnails and content width
	$fullwidth = false;
	
	// If portfolio is displayed full width
	if ( of_get_option( 'portfolio_sidebar' ) || is_page_template( 'full-width-portfolio.php' ) )
		$fullwidth = true;
		
	// If portfolio is a 1-column layout
	if ( of_get_option('layout','layout-2cr') ==  'layout-1col' )
		$fullwidth = true;
	
	$thumbnail = 'portfolio-thumbnail';
	
	if ( $fullwidth )
		$thumbnail = 'portfolio-thumbnail-fullwidth';
	
	// Query posts if this is being used as a page template
	if ( is_page_template() ) {
	
		global $paged;
	
		if ( get_query_var( 'paged' ) )
			$paged = get_query_var( 'paged' );
		elseif ( get_query_var( 'page' ) )
			$paged = get_query_var( 'page' );
		else
			$paged = 1;
			
		$posts_per_page = apply_filters( 'portfolioplus_posts_per_page', of_get_option('portfolio_num','9') );
		$args = array(
			'post_type' => 'portfolio',
			'posts_per_page' => $posts_per_page,
			'paged' => $paged );
		query_posts( $args );
	}
?>
<div id="portfolio"<?php if ( $fullwidth ) { echo ' class="full-width"'; }?>>
	
	<?php if ( is_tax() ): ?>
	<header class="entry-header">
		<h1 class="archive-title"><?php echo single_cat_title( '', false ); ?></h1>
		<?php $categorydesc = category_description(); if ( ! empty( $categorydesc ) ) echo apply_filters( 'archive_meta', '<div class="archive-meta">' . $categorydesc . '</div>' ); ?>
	</header>
	<?php endif; ?>

	<?php  if ( have_posts() ) : $count = 0;
		while ( have_posts() ) : the_post(); $count++;
		$classes = 'portfolio-item item-' . $count;
		if ( $count % 3 == 0 ) {
			$classes .= ' ie-col3';
		}
		if ( !has_post_thumbnail() || post_password_required() ) {
			$classes .= ' no-thumb';
		}
		$link_url = get_permalink();
		$url_target = '';
		if ( get_post_meta( $post->ID, 'portfolioplus_url', true ) ) {
			$link_url = esc_url( get_post_meta( $post->ID, 'portfolioplus_url', true ) );
			$url_target = ' target="_blank"';
		}
		?>
		<div class="<?php echo $classes; ?>">
			<?php if ( has_post_thumbnail() && !post_password_required() ) { ?>
			<a href="<?php echo $link_url; ?>" rel="bookmark" class="thumb"<?php echo $url_target;?>><?php the_post_thumbnail( $thumbnail ); ?></a>
			<?php } ?>
			<a href="<?php echo $link_url; ?>" rel="bookmark" class="title-overlay"><?php the_title() ?></a>
		</div>

		<?php endwhile; ?>

        <?php portfolioplus_content_nav(); ?>
			
		<?php else: ?>

			<h2 class="title"><?php _e( 'Sorry, no posts matched your criteria.', 'portfolioplus' ) ?></h2>

	<?php endif; ?>

</div><!-- #portfolio -->
<?php } ?>