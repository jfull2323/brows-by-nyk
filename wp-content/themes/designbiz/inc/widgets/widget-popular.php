<?php
/**
 * Popular Posts with Thumbnail widget.
 */
class Designbiz_Popular_Widget extends WP_Widget {

	/**
	 * Sets up the widgets.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {

		// Set up the widget options.
		$widget_ops = array(
			'classname'   => 'widget_popular_entries_thumbnail posts_with_thumbnail',
			'description' => esc_html__( 'Display your site\'s most popular Posts with thumbnails.', 'designbiz' ),
			'customize_selective_refresh' => true
		);

		// Create the widget.
		parent::__construct(
			'designbiz-popular-posts',                             // $this->id_base
			esc_html__( 'Designbiz - Popular Posts', 'designbiz' ), // $this->name
			$widget_ops                                           // $this->widget_options
		);

		$this->alt_option_name = 'widget_popular_entries_thumbnail';

	}

	/**
	 * Outputs the widget based on the arguments input through the widget controls.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $args     Display arguments including 'before_title', 'after_title',
	 *                        'before_widget', and 'after_widget'.
	 * @param array $instance Settings for the current Popular Posts widget instance.
	 */
	public function widget( $args, $instance ) {
		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		// Set up default value
		$title     = ( ! empty( $instance['title'] ) ) ? $instance['title'] : '';
		$number    = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
		$show_date = isset( $instance['show_date'] ) ? $instance['show_date'] : false;

		// Output the theme's $before_widget wrapper.
		echo $args['before_widget'];

		// If the title not empty, display it.
		if ( $title ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $title, $instance, $this->id_base ) . $args['after_title'];
		}

			// Posts query arguments.
			$query = array(
				'post_type'           => 'post',
				'posts_per_page'      => $number,
				'no_found_rows'       => true,
				'post_status'         => 'publish',
				'ignore_sticky_posts' => true,
				'orderby'             => 'comment_count'
			);

			// Allow developer to filter the arguments.
			$query = apply_filters( 'designbiz_widget_popular_args', $query );

			// The post query.
			$popular = new WP_Query( $query ); ?>

			<?php if ( $popular->have_posts() ) : ?>
				<ul>

					<?php while ( $popular->have_posts() ) : $popular->the_post(); ?>

						<li>
							<?php if ( has_post_thumbnail() ) : ?>
								<a class="thumbnail-link" href="<?php the_permalink(); ?>">
									<?php the_post_thumbnail( 'thumbnail', array( 'class' => 'entry-thumbnail', 'alt' => esc_attr( get_the_title() ) ) ); ?>
								</a>
							<?php endif; ?>
							<div class="post-detail">
								<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
								<?php if ( $show_date ) : ?>
									<time class="entry-date" datetime="<?php echo esc_html( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
								<?php endif; ?>
							</div>
						</li>

					<?php endwhile; ?>

				</ul>

			<?php
			endif; wp_reset_postdata();

		// Close the theme's widget wrapper.
		echo $args['after_widget'];

	}

	/**
	 * Updates the widget control options for the particular instance of the widget.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $new_instance New settings for this instance as input by the user via
	 *                            WP_Widget::form().
	 * @param array $old_instance Old settings for this instance.
	 * @return array Updated settings to save.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance              = $old_instance;
		$instance['title']     = sanitize_text_field( $new_instance['title'] );
		$instance['number']    = (int) $new_instance['number'];
		$instance['show_date'] = isset( $new_instance['show_date'] ) ? (bool) $new_instance['show_date'] : false;
		return $instance;
	}

	/**
	 * Displays the widget control options in the Widgets admin screen.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $instance Current settings.
	 */
	public function form( $instance ) {
		$title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : esc_html__( 'Popular Posts', 'designbiz' );
		$number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
		$show_date = isset( $instance['show_date'] ) ? (bool) $instance['show_date'] : false;
	?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>">
				<?php esc_html_e( 'Title', 'designbiz' ); ?>
			</label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $title; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'number' ); ?>">
				<?php esc_html_e( 'Number of posts to show', 'designbiz' ); ?>
			</label>
			<input class="tiny-text" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="number" step="1" min="1" value="<?php echo $number; ?>" size="3" />
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked( $show_date ); ?> id="<?php echo $this->get_field_id( 'show_date' ); ?>" name="<?php echo $this->get_field_name( 'show_date' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'show_date' ); ?>">
				<?php esc_html_e( 'Display post meta?', 'designbiz' ); ?>
			</label>
		</p>

	<?php

	}

}
