<?php
/**
 * Display list of portfolio.
 */
class Designbiz_Portfolio_Widget extends WP_Widget {

	/**
	 * Sets up the widgets.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {

		// Set up the widget options.
		$widget_ops = array(
			'classname'   => 'widget_portfolio',
			'description' => esc_html__( 'Display your jetpack portfolio.', 'designbiz' ),
			'customize_selective_refresh' => true
		);

		// Create the widget.
		parent::__construct(
			'designbiz-portfolio',                              // $this->id_base
			esc_html__( 'Designbiz - Portfolio', 'designbiz' ), // $this->name
			$widget_ops                                         // $this->widget_options
		);

		$this->alt_option_name = 'widget_portfolio';

	}

	/**
	 * Outputs the widget based on the arguments input through the widget controls.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $args     Display arguments including 'before_title', 'after_title',
	 *                        'before_widget', and 'after_widget'.
	 * @param array $instance Settings for the current Recent Posts widget instance.
	 */
	public function widget( $args, $instance ) {
		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		// Set up default value
		$title   = ( ! empty( $instance['title'] ) ) ? $instance['title'] : '';
		$desc    = ( ! empty( $instance['desc'] ) ) ? $instance['desc'] : '';
		$number  = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 6;

		// Output the theme's $before_widget wrapper.
		echo $args['before_widget'];

			// Display the data
			$portfolio = new WP_Query( array(
				'post_type'      => 'jetpack-portfolio',
				'posts_per_page' => $number,
				'orderby'        => 'menu_order',
				'order'          => 'ASC'
			) );

			if ( $portfolio->have_posts() ) : ?>

				<div class="portfolio-widget-section">
					<div class="wide-container">

						<div class="front-page-header">
							<h3 class="page-title"><?php echo $title; ?></h3>
							<p><?php echo $desc; ?></p>
						</div>

						<div class="grid-area">

								<?php while ( $portfolio->have_posts() ) : $portfolio->the_post(); ?>

									<div class="grid three-columns portfolio-content">
										<?php get_template_part( 'partials/content', 'portfolio' ); ?>
									</div><!-- .grid -->

								<?php endwhile; ?>

						</div><!-- .grid-area -->

					</div><!-- .container -->
				</div><!-- .grid-area -->

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
		$instance               = $old_instance;
		$instance['title']      = sanitize_text_field( $new_instance['title'] );
		if ( current_user_can( 'unfiltered_html' ) ) {
			$instance['desc']   = $new_instance['desc'];
		} else {
			$instance['desc']   = wp_kses_post( $new_instance['desc'] );
		}
		$instance['number']     = absint( $new_instance['number'] );
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
		$title    = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : esc_html__( 'Our Work', 'designbiz' );
		$desc     = isset( $instance['desc'] ) ? esc_textarea( $instance['desc'] ) : '';
		$number   = isset( $instance['number'] ) ? absint( $instance['number'] ) : 6;
	?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>">
				<?php esc_html_e( 'Title', 'designbiz' ); ?>
			</label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $title; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'desc' ); ?>">
				<?php esc_html_e( 'Description', 'designbiz' ); ?>
			</label>
			<textarea class="widefat" name="<?php echo $this->get_field_name( 'desc' ); ?>" id="<?php echo $this->get_field_id( 'desc' ); ?>" cols="30" rows="6"><?php echo $desc; ?></textarea>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'number' ); ?>">
				<?php esc_html_e( 'Number of item to show: ', 'designbiz' ); ?>
			</label>
			<input class="tiny-text" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="number" step="1" min="1" value="<?php echo $number; ?>" size="3" />
		</p>

	<?php

	}

}
