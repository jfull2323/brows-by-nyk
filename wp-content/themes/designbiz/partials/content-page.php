<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php
		$style = get_theme_mod( 'designbiz_featured_image_page_style', 'cover' );
		if ( $style === 'standard' ) :
	?>
		<?php designbiz_post_thumbnail(); ?>

		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	<?php endif; ?>

	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'designbiz' ) . '</span>',
				'after'  => '</div>',
				'link_before' => '<span class="link-numbers">',
				'link_after' => '</span>',
			) );
		?>
	</div><!-- .entry-content -->

	<?php if ( function_exists( 'sharing_display' ) ) : ?>
		<div class="jetpack-share-like">
			<?php sharing_display( '', true ); ?>
			<?php if ( class_exists( 'Jetpack_Likes' ) ) { $custom_likes = new Jetpack_Likes; echo $custom_likes->post_likes( '' ); } ?>
		</div>
	<?php endif; ?>

	<?php edit_post_link( esc_html__( 'Edit', 'designbiz' ), '<footer class="entry-footer"><span class="edit-link">', '</span></footer>' ); ?>

</article><!-- #post-## -->
