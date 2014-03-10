( function( $ ) {
    var $branding = $( '#branding' ),
    	$title = $( '#site-title a' ),
        $tagline = $( '#site-description' ),
        $menu_links = $( '#navigation ul a' );

	/* Title Text */
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$title.text( to );
		} );
	} );

	/* Tagline Text */
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$tagline.text( to );
		} );
	} );

	/* Header Background Color */
	wp.customize( 'portfolioplus[header_bg][color]', function( value ) {
		value.bind( function( to ) {
			$branding.css( 'background-color', to );
		} );
	} );

	/* Site Title Color */
	wp.customize( 'portfolioplus[site_title_color]', function( value ) {
		value.bind( function( to ) {
			$title.css( 'color', to );
		} );
	} );

	/* Tagline Color */
	wp.customize( 'portfolioplus[tagline_color]', function( value ) {
		value.bind( function( to ) {
			$tagline.css( 'color', to );
		} );
	} );

	/* Menu Color */
	wp.customize( 'portfolioplus[menu_color]', function( value ) {
		value.bind( function( to ) {
			$menu_links.css( 'color', to );
		} );
	} );

} )( jQuery );