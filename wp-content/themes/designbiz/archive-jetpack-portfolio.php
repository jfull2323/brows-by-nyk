<?php get_header(); ?>

	<div class="portfolio-heading">
		<div class="container">

			<article class="entry">
				<h1 class="entry-title">
					<?php
						if ( '' != get_theme_mod( 'designbiz_portfolio_title' ) ) {
							echo esc_html( get_theme_mod( 'designbiz_portfolio_title' ) );
						} else {
							esc_html_e( 'Portfolio', 'designbiz' );
						}
					?>
				</h1>

				<?php if ( get_theme_mod( 'designbiz_portfolio_content' ) ) : // only display if content not empty ?>
					<div class="entry-content">
						<p><?php echo convert_chars( convert_smilies( wptexturize( stripslashes( wp_filter_post_kses( addslashes( get_theme_mod( 'designbiz_portfolio_content' ) ) ) ) ) ) ); ?></p>
					</div>
				<?php endif; ?>
			</article>

		</div>
	</div>

	<div class="wide-container">

		<div id="primary" class="content-area">
			<main id="main" class="site-main">

				<?php if ( have_posts() ) : ?>

					<div class="grid-area">

						<?php while ( have_posts() ) : the_post(); ?>

							<div class="grid three-columns portfolio-content">
								<?php get_template_part( 'partials/content', 'portfolio' ); ?>
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
