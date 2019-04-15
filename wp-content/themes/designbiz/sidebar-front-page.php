<?php
// Return early if no widget found.
if ( ! is_active_sidebar( 'front-page' ) ) {
	return;
}
?>

<div class="front-page-sidebar" aria-label="<?php echo esc_attr_x( 'Front Page Sidebar', 'Sidebar aria label', 'designbiz' ); ?>">
	<?php dynamic_sidebar( 'front-page' ); ?>
</div><!-- .front-page-sidebar -->
