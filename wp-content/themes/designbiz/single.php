<?php get_header(); ?>

	<?php
		$style = get_theme_mod( 'designbiz_featured_image_post_style', 'cover' );
		if ( $style === 'cover' ) :
	?>
		<?php get_template_part( 'partials/content', 'hero' ); ?>
	<?php endif; ?>

	<div class="container">

		<div id="primary" class="content-area">
			<main id="main" class="site-main" role="main">

				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'partials/content', 'single' ); ?>

					<?php designbiz_post_author_box(); // Display the author box. ?>

					<?php designbiz_next_prev_post(); // Display the next and previous post. ?>

					<?php
						// Get data set in customizer
						$comment = get_theme_mod( 'designbiz_post_comment', 1 );

						// Check if comment enable on customizer
						if ( $comment ) :
							// If enable and comments are open or we have at least one comment, load up the comment template
							if ( comments_open() || '0' != get_comments_number() ) :
								comments_template();
							endif;
						endif;
					?>

				<?php endwhile; // end of the loop. ?>

			</main><!-- #main -->
		</div><!-- #primary -->

		<?php get_sidebar(); // Loads the sidebar.php template. ?>

	</div><!-- .container -->

<?php get_footer(); ?>
