<?php
// Check if there's a menu assigned to the 'primary' location.
if ( ! has_nav_menu( 'primary' ) ) {
	return;
}
?>

<nav id="site-navigation" class="main-navigation">

	<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Menu', 'designbiz' ); ?></button>

	<?php wp_nav_menu(
		array(
			'theme_location' => 'primary',
			'container'      => false,
			'menu_id'        => 'menu-primary-items',
			'menu_class'     => 'menu-primary-items'
		)
	); ?>

</nav><!-- #site-navigation -->
