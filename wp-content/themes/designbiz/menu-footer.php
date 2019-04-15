<?php
// Check if there's a menu assigned to the 'footer' location.
if ( ! has_nav_menu( 'footer' ) ) {
	return;
}
?>

<nav class="footer-navigation">

	<?php wp_nav_menu(
		array(
			'theme_location' => 'footer',
			'container'      => false,
			'menu_id'        => 'menu-footer-items',
			'menu_class'     => 'menu-footer-items',
			'depth'          => 1
		)
	); ?>

</nav><!-- #site-navigation -->
