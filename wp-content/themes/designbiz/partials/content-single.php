<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php
		$style = get_theme_mod( 'designbiz_featured_image_post_style', 'cover' );
		if ( $style === 'standard' ) :
	?>
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

		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	<?php endif; ?>

	<div class="entry-content">

		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'designbiz' ),
				'after'  => '</div>',
			) );
		?>

	</div>

	<footer class="entry-footer">

		<?php
			$show = get_theme_mod( 'designbiz_post_tags', 1 );
			$tags = get_the_tags();
			if ( $show && $tags ) :
		?>
			<span class="tag-links">
				<?php foreach( $tags as $tag ) : ?>
					<a href="<?php echo esc_url( get_tag_link( $tag->term_id ) ); ?>"><?php printf( ( '#%s' ), esc_attr( $tag->name ) ); ?></a>
				<?php endforeach; ?>
			</span>
		<?php endif; ?>

	</footer>

	<?php if ( function_exists( 'sharing_display' ) ) : ?>
		<div class="jetpack-share-like">
			<?php sharing_display( '', true ); ?>
			<?php if ( class_exists( 'Jetpack_Likes' ) ) { $custom_likes = new Jetpack_Likes; echo $custom_likes->post_likes( '' ); } ?>
		</div>
	<?php endif; ?>

</article><!-- #post-## -->
