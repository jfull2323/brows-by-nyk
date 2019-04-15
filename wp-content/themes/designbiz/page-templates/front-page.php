<?php
/**
 * Template Name: Front Page
 */

get_header(); ?>

	<?php while ( have_posts() ) : the_post(); ?>

		<div class="hero">
			<div class="container">

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

					<div class="entry-content">
						<?php the_content(); ?>
						<?php
							wp_link_pages( array(
								'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'designbiz' ),
								'after'  => '</div>',
							) );
						?>
					</div><!-- .entry-content -->

				</article><!-- #post-## -->

			</div>
		</div>

	<?php endwhile; ?>

	<?php rewind_posts(); ?>

	<?php get_sidebar( 'front-page' ); ?>

<?php get_footer(); ?>
