<?php
/**
 * Header template
 *
 * @package Portfolio+
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page">

	<header id="branding">
    	<div class="col-width">
        <?php $heading_tag = ( is_home() || is_front_page() ) ? 'h1' : 'div'; ?>
			<hgroup id="logo">
				<<?php echo $heading_tag; ?> id="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                <?php if ( portfolioplus_get_option( 'logo', false) ) { ?>
					<img src="<?php echo esc_url( portfolioplus_get_option( 'logo' ) ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
				<?php } else {
					bloginfo( 'name' );
				}?>
                </a>
                </<?php echo $heading_tag; ?>>
				<?php if ( ! portfolioplus_get_option( 'logo', false ) &&  portfolioplus_get_option( 'tagline', true ) ) { ?>
                	<h2 id="site-description"><?php bloginfo( 'description' ); ?></h2>
                <?php } ?>
			</hgroup>

			<nav id="navigation" class="site-navigation primary-navigation" role="navigation">
				<h1 class="menu-toggle"><?php _e( 'Menu', 'portfolio-plus' ); ?></h1>
				<a class="screen-reader-text skip-link" href="#content"><?php _e( 'Skip to content', 'portfolio-plus' ); ?></a>
				<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'nav-menu' ) ); ?>
			</nav>
		</div>
	</header><!-- #branding -->

	<div id="main">
    	<div class="col-width">
