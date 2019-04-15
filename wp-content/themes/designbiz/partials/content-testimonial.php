<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<span class="author-img">
		<?php the_post_thumbnail( 'designbiz-thumbnail-square' ); ?>
	</span>

	<div class="grid-content">

		<?php the_title( '<h2 class="entry-title">', '</h2>' ); ?>

		<?php the_content(); ?>

	</div>

</article><!-- #post-## -->
