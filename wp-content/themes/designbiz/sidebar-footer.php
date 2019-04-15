<?php
// Return early if no widget found.
if ( is_active_sidebar( 'footer-1' ) || is_active_sidebar( 'footer-2' ) || is_active_sidebar( 'footer-3' ) ) :
?>

<div class="sidebar-footer">
	<div class="container">

		<div class="footer-column footer-column-1">
			<?php dynamic_sidebar( 'footer-1' ); ?>
		</div>

		<div class="footer-column footer-column-2">
			<?php dynamic_sidebar( 'footer-2' ); ?>
		</div>

		<div class="footer-column footer-column-3">
			<?php dynamic_sidebar( 'footer-3' ); ?>
		</div>

	</div><!-- .container -->
</div><!-- #tertiary -->

<?php endif; ?>
