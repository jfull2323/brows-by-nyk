<?php get_header(); ?>

	<div class="container">

		<div id="primary" class="content-area">
			<main id="main" class="site-main" role="main">

				<?php while ( have_posts() ) : the_post(); ?>

					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

						<div class="attachment-img thumbnail-link">
							<?php
								/**
								 * Filter the default image attachment size.
								 */
								$image_size = apply_filters( 'penamoo_attachment_size', 'full' );

								echo wp_get_attachment_image( get_the_ID(), $image_size );
							?>
						</div><!-- .entry-attachment -->

						<div class="entry-left">

							<time class="entry-date published" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php printf( esc_html__( 'on %s', 'designbiz' ), '<a href="' . esc_url( get_permalink() ) . '">' . esc_html( get_the_date() ). '</a>' ); ?></time>

							<span class="entry-author">
								<?php printf( esc_html__( 'by %s', 'designbiz' ), '<a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '"><span>' . esc_html( get_the_author() ) . '</span></a>' ) ?>
							</span>

						</div>

						<div class="entry-right">

							<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

							<div class="entry-content">

								<?php the_content(); ?>
								<?php
									wp_link_pages( array(
										'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'designbiz' ),
										'after'  => '</div>',
									) );
								?>

							</div>

						</div>

					</article><!-- #post-## -->

				<?php endwhile; // end of the loop. ?>

			</main><!-- #main -->
		</div><!-- #primary -->

		<?php get_sidebar(); // Loads the sidebar.php template. ?>

	</div><!-- .container -->

<?php get_footer(); ?>
