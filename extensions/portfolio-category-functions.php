<?php
/**
 * Portfolio Category Functions
 * @package Portfolio+
 */

/*
 * Loops over each of the terms in the custom taxonomy "portfolio_categories"
 * and retrieves the first post from each.  Since this is an expensive
 * request the result is built into an array and saved as a transient.
 *
 * @returns object $portfolioplus_category_query
 */

function portfolioplus_category_cache() {

	/* Retrieves all the terms from the taxonomy portfolio_category
	 *  http://codex.wordpress.org/Function_Reference/get_categories
	 */

	$args = array(
		'type' => 'portfolio',
		'orderby' => 'name',
		'order' => 'ASC',
		'taxonomy' => 'portfolio_category');

	$categories = get_categories( $args );

	$portfolioplus_category_query = array();

	/* Pulls the first post from each of the individual portfolio categories */

	foreach( $categories as $category ) {

		$args = array(
			'posts_per_page' => 1,
			'post_type' => 'portfolio',
			'portfolio_category' => $category->slug,
			'no_found_rows' => true,
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false
		);
		$query = new WP_Query( $args );

		// The Loop
		while ( $query->have_posts() ) : $query->the_post();

			$portfolio_thumbnail = null;
			$portfolio_thumbnail_fullwidth = null;
			$portfolio_thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id(), 'portfolio-thumbnail');
			$portfolio_thumbnail_fullwidth = wp_get_attachment_image_src( get_post_thumbnail_id(), 'portfolio-thumbnail-fullwidth');

			/* All the data pulled is saved into an array which we'll save later */

			$portfolioplus_category_query[$category->slug] = array(
				'name' => $category->name,
				'term_link' =>  esc_attr( get_term_link( $category->slug, 'portfolio_category' ) ),
				'portfolio-thumbnail' => $portfolio_thumbnail[0],
				'portfolio-thumbnail-fullwidth' => $portfolio_thumbnail_fullwidth[0]
			);

		endwhile;
   }

   	// Reset Post Data
	wp_reset_postdata();

	set_transient( 'portfolioplus_category_query', $portfolioplus_category_query, 60*60*24*7 );

	return $portfolioplus_category_query;
}

/**
 * Deletes the portfolioplus_category_query transient if a portfolio post is updated
 *
 * @param int $post_id
 * @param object $post
 */
function portfolioplus_save_portfolio( $post_id, $post ) {

	// If this is an auto save routine don't do anyting
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
		return;

	if ( $post->post_type == 'portfolio' ) {
		delete_transient( 'portfolioplus_category_query' );
	}

}
add_action( 'save_post', 'portfolioplus_save_portfolio', 10, 2 );