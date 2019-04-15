<?php
// Return early if no widget found.
if ( ! is_active_sidebar( 'primary' ) ) {
	return;
}
?>

<div id="secondary" class="widget-area" aria-label="<?php echo esc_attr_x( 'Primary Sidebar', 'Sidebar aria label', 'designbiz' ); ?>">
	<?php dynamic_sidebar( 'primary' ); ?>
</div><!-- #secondary -->
