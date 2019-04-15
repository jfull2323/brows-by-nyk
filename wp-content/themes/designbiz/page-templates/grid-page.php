<?php
/**
 * Template Name: Grid Page
 */

get_header(); ?>

	<div class="container">

		<?php if ( '' != $post->post_content ) : // only display if content not empty ?>

			<div id="primary" class="content-area">
				<main id="main" class="site-main">

					<?php while ( have_posts() ) : the_post(); ?>

						<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

							<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

							<div class="entry-content">
								<?php the_content(); ?>
								<?php
									wp_link_pages( array(
										'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'designbiz' ),
										'after'  => '</div>',
									) );
								?>
							</div><!-- .entry-content -->

							<?php edit_post_link( esc_html__( 'Edit', 'designbiz' ), '<footer class="entry-footer"><span class="edit-link">', '</span></footer>' ); ?>

						</article><!-- #post-## -->


					<?php endwhile; // end of the loop. ?>

				</main><!-- #main -->
			</div><!-- #primary -->

		<?php endif; ?>

		<?php
			$child_pages = new WP_Query( array(
				'post_type'      => 'page',
				'orderby'        => 'menu_order',
				'order'          => 'ASC',
				'post_parent'    => $post->ID,
				'posts_per_page' => 999,
				'no_found_rows'  => true,
			) );
		?>

		<?php if ( $child_pages->have_posts() ) : ?>

			<div class="grid-area">

				<?php while ( $child_pages->have_posts() ) : $child_pages->the_post(); ?>

					<div class="grid two-columns">
						<?php get_template_part( 'partials/content', 'grid' ); ?>
					</div><!-- .grid -->

				<?php endwhile; ?>

			</div><!-- .grid-area -->

		<?php
			endif;
			wp_reset_postdata();
		?>

	</div><!-- .container -->

<?php get_footer(); ?>
