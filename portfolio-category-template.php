<?php
/*
 * Template Name: Portfolio Categories
 * Description: Displays all the portfolio categories
 *
 * @package WordPress
 * @subpackage Portfolio+
 */
 
// This template requires some additional functions to work properly
require_once( get_template_directory() . '/extensions/portfolio-category-functions.php' );

get_header();
	   
	   $portfolioplus_category_query = get_transient( 'portfolioplus_category_query' );
	   
	   if ( !$portfolioplus_category_query ) {
	   		if ( class_exists( 'Portfolio_Post_Type' ) ) {
	   			$portfolioplus_category_query = portfolioplus_category_cache();
	   		} else {
		   		$portfolioplus_category_query = array();
	   		}
	   }
	    
	   $fullwidth = of_get_option( 'portfolio_sidebar', false );
	   $thumbnail = 'portfolio-thumbnail';
	   if ( $fullwidth )
	   		$thumbnail = 'portfolio-thumbnail-fullwidth';
	   		
	   	// This displays the portfolio full width, but doesn't change thumbnail sizes
	   	if ( of_get_option('layout','layout-2cr') ==  'layout-1col' )
			$fullwidth = true; ?>
	   		
	   <div id="portfolio"<?php if ( $fullwidth ) { echo ' class="full-width"'; }?>>
	   	
	   <?php  $count = 0;
	   foreach ( $portfolioplus_category_query as $portfolio_cat ) {
		   
		   $count++;
		   $classes = 'portfolio-item item-' . $count;
		   if ( $count % 3 == 0 )
		   		$classes .= ' ie-col3';
		   		
		   if ( !($portfolio_cat[$thumbnail]) )
				$classes .= ' no-thumb'; ?>
				
			<div class="<?php echo $classes; ?>">
			<?php if ( $portfolio_cat[$thumbnail] ) { ?>
			<a href="<?php echo $portfolio_cat['term_link']; ?>" class="thumb"><img src="<?php echo $portfolio_cat[$thumbnail]; ?>"></a>
			<?php } ?>
			<a href="<?php echo $portfolio_cat['term_link']; ?>" class="title-overlay"><?php echo $portfolio_cat['name']; ?></a>
		</div>
	   <?php } ?>

		</div><!-- #portfolio -->

<?php if ( !of_get_option( 'portfolio_sidebar' ) )
	get_sidebar();

get_footer();