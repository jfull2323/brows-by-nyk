<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php designbiz_post_thumbnail(); ?>

	<div class="grid-content">

		<span class="cat-links">
			<?php echo get_the_term_list( $post->ID, 'jetpack-portfolio-type', '', ', ' ); ?>
		</span>

		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
	</div>

</article><!-- #post-## -->
