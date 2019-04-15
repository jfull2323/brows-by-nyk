<?php get_header(); ?>

	<?php get_template_part( 'partials/content', 'hero' ); ?>

	<div class="container">

		<div id="primary" class="content-area">
			<main id="main" class="site-main">

				<?php if ( have_posts() ) : ?>

					<div class="grid-area">

					<?php while ( have_posts() ) : the_post(); ?>

						<div class="grid two-columns testimonial-content">
							<?php get_template_part( 'partials/content', 'testimonial' ); ?>
						</div><!-- .grid -->

					<?php endwhile; ?>

					</div>

					<?php get_template_part( 'pagination' ); // Loads the pagination.php template  ?>

				<?php else : ?>

					<?php get_template_part( 'partials/content', 'none' ); ?>

				<?php endif; ?>

			</main><!-- #main -->
		</div><!-- #primary -->

	</div><!-- .container -->

<?php get_footer(); ?>
