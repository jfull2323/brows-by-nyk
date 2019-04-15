<?php
/**
 * Custom template tags for this theme.
 * Eventually, some of the functionality here could be replaced by core features.
 */

if ( ! function_exists( 'designbiz_site_branding' ) ) :
/**
 * Site branding for the site.
 *
 * Display site title by default, but user can change it with their custom logo.
 * They can upload it on Customizer page.
 */
function designbiz_site_branding() {

	// Get the log.
	$logo_id  = get_theme_mod( 'custom_logo' );
	$logo_url = wp_get_attachment_image_src( $logo_id , 'full' );

	// Check if logo available, then display it.
	if ( $logo_id ) :
		echo '<div class="site-branding">'. "\n";
			echo '<div class="logo">';
				echo '<a href="' . esc_url( get_home_url() ) . '" rel="home">' . "\n";
					echo '<img src="' . esc_url( $logo_url[0] ) . '" alt="' . esc_attr( get_bloginfo( 'name' ) ) . '" />' . "\n";
				echo '</a>' . "\n";
			echo '</div>' . "\n";
		echo '</div>' . "\n";

	// If not, then display the Site Title and Site Description.
	else :
		echo '<div class="site-branding">'. "\n";
			echo '<h1 class="site-title"><a href="' . esc_url( get_home_url() ) . '" rel="home">' . esc_attr( get_bloginfo( 'name' ) ) . '</a></h1>'. "\n";
		echo '</div>'. "\n";
	endif;

}
endif;

/**
 * Returns true if a blog has more than 1 category.
 */
function designbiz_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'designbiz_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,

			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'designbiz_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so designbiz_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so designbiz_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in designbiz_categorized_blog.
 */
function designbiz_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'designbiz_categories' );
}
add_action( 'edit_category', 'designbiz_category_transient_flusher' );
add_action( 'save_post',     'designbiz_category_transient_flusher' );

if ( ! function_exists( 'designbiz_post_thumbnail' ) ) :
/**
 * Display an optional post thumbnail.
 */
function designbiz_post_thumbnail() {
	if ( post_password_required() || is_attachment() || ! has_post_thumbnail() || has_post_format() ) {
		return;
	}
?>

	<a class="thumbnail-link" href="<?php the_permalink(); ?>">
		<?php
			if ( is_page_template( 'page-templates/front-page.php' ) || is_page_template( 'page-templates/grid-page.php' ) || is_post_type_archive( 'jetpack-portfolio' ) ) {
				$ratio = get_theme_mod( 'designbiz_thumbnail_style' );
				switch ( $ratio ) {
					case 'square':
						the_post_thumbnail( 'designbiz-thumbnail-square' );
						break;
					default :
						the_post_thumbnail( 'designbiz-thumbnail-landscape' );
				}
			} elseif ( is_page_template( 'page-templates/full-width-page.php' ) ) {
				the_post_thumbnail( 'designbiz-featured-full' );
			} else {
				the_post_thumbnail( 'designbiz-hero' );
			}
		?>
	</a>

<?php
}
endif;

if ( ! function_exists( 'designbiz_post_author_box' ) ) :
/**
 * Author post informations.
 */
function designbiz_post_author_box() {

	// Get the data from Customizer
	$enable = get_theme_mod( 'designbiz_author_box', 1 );
	if ( !$enable ) {
		return;
	}

	// Bail if not on the single post.
	if ( ! is_singular( 'post' ) ) {
		return;
	}

	// Bail if user hasn't fill the Biographical Info field.
	if ( ! get_the_author_meta( 'description' ) ) {
		return;
	}

	// Get the author social information.
	$twitter   = get_the_author_meta( 'twitter' );
	$facebook  = get_the_author_meta( 'facebook' );
	$gplus     = get_the_author_meta( 'gplus' );
	$instagram = get_the_author_meta( 'instagram' );
	$pinterest = get_the_author_meta( 'pinterest' );
	$linkedin  = get_the_author_meta( 'linkedin' );
?>

	<div class="author-bio clearfix">
		<?php echo get_avatar( is_email( get_the_author_meta( 'user_email' ) ), apply_filters( 'designbiz_author_bio_avatar_size', 90 ), '', strip_tags( get_the_author() ) ); ?>
		<div class="description">

			<h3 class="author-title name">
				<a class="author-name url fn n" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author"><?php echo strip_tags( get_the_author() ); ?></a>
			</h3>

			<p class="bio"><?php echo stripslashes( get_the_author_meta( 'description' ) ); ?></p>

			<?php if ( $twitter || $facebook || $gplus || $instagram || $pinterest || $linkedin ) : ?>
				<div class="social-links">
					<?php if ( $twitter ) { ?>
						<a href="//twitter.com/<?php echo esc_attr( $twitter ) ?>"><i class="fa fa-twitter"></i></a>
					<?php } ?>
					<?php if ( $facebook ) { ?>
						<a href="<?php echo esc_url( $facebook ); ?>"><i class="fa fa-facebook"></i></a>
					<?php } ?>
					<?php if ( $gplus ) { ?>
						<a href="<?php echo esc_url( $gplus ); ?>"><i class="fa fa-google-plus"></i></a>
					<?php } ?>
					<?php if ( $instagram ) { ?>
						<a href="<?php echo esc_url( $instagram ); ?>"><i class="fa fa-instagram"></i></a>
					<?php } ?>
					<?php if ( $pinterest ) { ?>
						<a href="<?php echo esc_url( $pinterest ); ?>"><i class="fa fa-pinterest"></i></a>
					<?php } ?>
					<?php if ( $linkedin ) { ?>
						<a href="<?php echo esc_url( $linkedin ); ?>"><i class="fa fa-linkedin"></i></a>
					<?php } ?>
				</div>
			<?php endif; ?>

		</div>
	</div><!-- .author-bio -->

<?php
}
endif;

if ( ! function_exists( 'designbiz_next_prev_post' ) ) :
/**
 * Custom next post link
 *
 * @since 1.0.0
 */
function designbiz_next_prev_post() {

	// Get the data set in customizer
	$enable = get_theme_mod( 'designbiz_next_prev_post', 1 );
	if ( !$enable ) {
		return;
	}

	// Display on single post page.
	if ( ! is_single() ) {
		return;
	}

	// Get the next and previous post id.
	$next = get_adjacent_post( false, '', false );
	$prev = get_adjacent_post( false, '', true );
?>
	<div class="post-pagination">

		<?php if ( $prev ) : ?>
			<div class="prev-post">

				<?php if ( has_post_thumbnail( $prev->ID ) ) : ?>
					<a class="thumbnail-link" href="<?php echo esc_url( get_permalink( $prev->ID ) ); ?>"><?php echo get_the_post_thumbnail( $prev->ID, 'thumbnail', array( 'class' => 'entry-thumbnail', 'alt' => esc_attr( get_the_title( $prev->ID ) ) ) ) ?></a>
				<?php endif; ?>

				<div class="post-detail">
					<span><?php esc_html_e( 'Previous Post', 'designbiz' ); ?></span>
					<a href="<?php echo esc_url( get_permalink( $prev->ID ) ); ?>" class="post-title"><?php echo esc_attr( get_the_title( $prev->ID ) ); ?></a>
				</div>

			</div>
		<?php endif; ?>

		<?php if ( $next ) : ?>
			<div class="next-post">

				<?php if ( has_post_thumbnail( $next->ID ) ) : ?>
					<a class="thumbnail-link" href="<?php echo esc_url( get_permalink( $next->ID ) ); ?>"><?php echo get_the_post_thumbnail( $next->ID, 'thumbnail', array( 'class' => 'entry-thumbnail', 'alt' => esc_attr( get_the_title( $next->ID ) ) ) ) ?></a>
				<?php endif; ?>

				<div class="post-detail">
					<span><?php esc_html_e( 'Next Post', 'designbiz' ); ?></span>
					<a href="<?php echo esc_url( get_permalink( $next->ID ) ); ?>" class="post-title"><?php echo esc_attr( get_the_title( $next->ID ) ); ?></a>
				</div>

			</div>
		<?php endif; ?>

	</div>
<?php
}
endif;

if ( ! function_exists( 'designbiz_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 */
function designbiz_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
		// Display trackbacks differently than normal comments.
	?>
	<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment-container">
			<p><?php esc_html_e( 'Pingback:', 'designbiz' ); ?> <span><?php comment_author_link(); ?></span> <?php edit_comment_link( esc_html__( '(Edit)', 'designbiz' ), '<span class="edit-link">', '</span>' ); ?></p>
		</article>
	<?php
			break;
		default :
		// Proceed with normal comments.
		global $post;
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment-container">

			<div class="comment-avatar">
				<?php echo get_avatar( $comment, apply_filters( 'designbiz_comment_avatar_size', 80 ) ); ?>
				<span class="name"><?php echo get_comment_author_link(); ?></span>
				<?php echo designbiz_comment_author_badge(); ?>
			</div>

			<div class="comment-body">
				<div class="comment-wrapper">

					<div class="comment-head">
						<?php
							$edit_comment_link = '';
							if ( get_edit_comment_link() )
								$edit_comment_link = sprintf( esc_html__( '&middot; %1$sEdit%2$s', 'designbiz' ), '<a href="' . get_edit_comment_link() . '" title="' . esc_attr__( 'Edit Comment', 'designbiz' ) . '">', '</a>' );

							printf( '<span class="date"><a href="%1$s"><time datetime="%2$s">%3$s</time></a> %4$s</span>',
								esc_url( get_comment_link( $comment->comment_ID ) ),
								get_comment_time( 'c' ),
								/* translators: 1: date, 2: time */
								sprintf( esc_html__( '%1$s at %2$s', 'designbiz' ), get_comment_date(), get_comment_time() ),
								$edit_comment_link
							);
						?>
					</div><!-- comment-head -->

					<div class="comment-content comment-entry">
						<?php if ( '0' == $comment->comment_approved ) : ?>
							<p class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'designbiz' ); ?></p>
						<?php endif; ?>
						<?php comment_text(); ?>
						<span class="reply">
							<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( '<i class="fa fa-reply"></i> Reply', 'designbiz' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
						</span><!-- .reply -->
					</div><!-- .comment-content -->

				</div>
			</div>

		</article><!-- #comment-## -->
	<?php
		break;
	endswitch; // end comment_type check
}
endif;

if ( ! function_exists( 'designbiz_comment_author_badge' ) ) :
/**
 * Custom badge for post author comment
 */
function designbiz_comment_author_badge() {

	// Set up empty variable
	$output = '';

	// Get comment classes
	$classes = get_comment_class();

	if ( in_array( 'bypostauthor', $classes ) ) {
		$output = '<span class="author-badge">' . esc_html__( 'Author', 'designbiz' ) . '</span>';
	}

	// Display the badge
	return apply_filters( 'designbiz_comment_author_badge', $output );
}
endif;

if ( ! function_exists( 'designbiz_footer_text' ) ) :
/**
 * Footer Text
 */
function designbiz_footer_text() {

	// Get the customizer data
	$default = '&copy; Copyright ' . date( 'Y' ) . ' <a href="' . esc_url( home_url() ) . '">' . esc_attr( get_bloginfo( 'name' ) ) . '</a> &middot; Designed by <a href="https://www.theme-junkie.com/">Theme Junkie</a>';
	$footer_text = get_theme_mod( 'designbiz_footer_credits', $default );

	// Display the data
	echo '<p class="copyright">' . $footer_text . '</p>';

}
endif;
