<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php designbiz_post_thumbnail(); ?>

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

	<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div>

	<span class="more-link-wrapper">
		<a href="<?php the_permalink(); ?>" class="more-link button-minimal"><?php esc_html_e( 'Continue Reading', 'designbiz' ); ?></a>
	</span>

</article><!-- #post-## -->
