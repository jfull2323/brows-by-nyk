<div class="hero">
	<div class="container">

		<?php if ( is_post_type_archive( 'jetpack-testimonial' ) ) : ?>

			<?php $jetpack_options = get_theme_mod( 'jetpack_testimonials' ); ?>

			<div class="entry-content">

				<h1 class="entry-title">
					<?php
						if ( '' != $jetpack_options['page-title'] ) {
							echo esc_html( $jetpack_options['page-title'] );
						} else {
							esc_html_e( 'Testimonials', 'designbiz' );
						}
					?>
				</h1>

				<?php if ( isset( $jetpack_options['page-content'] ) && '' != $jetpack_options['page-content'] ) : // only display if content not empty ?>
					<?php echo convert_chars( convert_smilies( wptexturize( stripslashes( wp_filter_post_kses( addslashes( $jetpack_options['page-content'] ) ) ) ) ) ); ?>
				<?php endif; ?>
			</div>

		<?php else : ?>

			<div class="entry-content">
				<?php if ( 'post' == get_post_type() ) : ?>
					<?php
						/* translators: used between list items, there is a space after the comma */
						$categories_list = get_the_category_list( esc_html__( ', ', 'designbiz' ) );
						if ( $categories_list && designbiz_categorized_blog() ) :
					?>
					<span class="cat-links">
						<?php echo $categories_list; ?>
					</span>
					<?php endif; // End if categories ?>
				<?php endif; ?>

				<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

				<p><?php echo wp_kses_post( get_post( get_post_thumbnail_id() )->post_excerpt ); ?></p>
			</div>

		<?php endif; ?>

	</div>
</div>
