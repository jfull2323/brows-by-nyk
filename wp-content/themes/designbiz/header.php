<!DOCTYPE html>
<html class="no-js" <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<div id="page" class="site">

	<header id="masthead" class="site-header">
		<div class="container">

			<?php designbiz_site_branding(); ?>

			<?php get_template_part( 'menu' ); // Loads the menu.php template. ?>

		</div><!-- .container -->
	</header><!-- #masthead -->

	<div id="content" class="site-content">
