	</div><!-- #content -->

	<footer id="colophon" class="site-footer">

		<?php get_template_part( 'sidebar', 'footer' ); // Loads the sidebar-footer.php template. ?>

		<div class="site-info">
			<div class="container">
				<?php get_template_part( 'menu', 'footer' ); // Loads the menu-footer.php template. ?>
				<?php designbiz_footer_text(); ?>
			</div>
		</div><!-- .site-info -->

	</footer><!-- #colophon -->

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
