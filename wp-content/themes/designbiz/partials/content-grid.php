<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php designbiz_post_thumbnail(); ?>

	<div class="grid-content">
		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

		<div class="entry-summary">
			<?php the_excerpt(); ?>
		</div>

		<span class="more-link-wrapper">
			<a href="<?php the_permalink(); ?>" class="more-link button-minimal"><?php esc_html_e( 'Read More', 'designbiz' ); ?></a>
		</span>
	</div>

</article><!-- #post-## -->
