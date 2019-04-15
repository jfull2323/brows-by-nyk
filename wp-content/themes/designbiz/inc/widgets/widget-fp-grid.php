<?php
/**
 * Display list of pages with its childs.
 */
class Designbiz_Featured_Pages_Grid_Widget extends WP_Widget {

	/**
	 * Sets up the widgets.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {

		// Set up the widget options.
		$widget_ops = array(
			'classname'   => 'widget_fp_grid',
			'description' => esc_html__( 'Use this widget only in Front Page Top sidebar. Display page with its child pages.', 'designbiz' ),
			'customize_selective_refresh' => true
		);

		// Create the widget.
		parent::__construct(
			'designbiz-fp-grid',                                     // $this->id_base
			esc_html__( 'Designbiz - Featured Pages', 'designbiz' ), // $this->name
			$widget_ops                                              // $this->widget_options
		);

		$this->alt_option_name = 'widget_fp_grid';

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
		$page_id    = ( ! empty( $instance['page_id'] ) ) ? absint( $instance['page_id'] ) : '';
		$number     = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 4;
		$show_title = isset( $instance['show_title'] ) ? $instance['show_title'] : false;

		// Hide if no page selected
		if ( $page_id ) :

			// Output the theme's $before_widget wrapper.
			echo $args['before_widget'];

				// Display the data
				$child_pages = new WP_Query( array(
					'post_type'      => 'page',
					'orderby'        => 'menu_order',
					'order'          => 'ASC',
					'post_parent'    => $page_id,
					'posts_per_page' => $number,
					'no_found_rows'  => true,
				) );

				if ( $child_pages->have_posts() ) : ?>

					<div class="featured-pages">
						<div class="container">

							<?php if ( $show_title ) : ?>
								<div class="front-page-header">
									<h3 class="page-title"><?php echo sanitize_text_field( get_the_title( $page_id ) ); ?></h3>
									<p><?php echo wp_kses_post( get_post_field( 'post_content', $page_id ) ); ?></p>
								</div>
							<?php endif; ?>

							<div class="grid-area">

									<?php while ( $child_pages->have_posts() ) : $child_pages->the_post(); ?>

										<div class="grid two-columns">
											<?php get_template_part( 'partials/content', 'grid' ); ?>
										</div><!-- .grid -->

									<?php endwhile; ?>

							</div><!-- .grid-area -->

						</div><!-- .container -->
					</div><!-- .grid-area -->

				<?php
				endif; wp_reset_postdata();

			// Close the theme's widget wrapper.
			echo $args['after_widget'];

		endif;

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
		$instance['page_id']    = absint( $new_instance['page_id'] );
		$instance['number']     = absint( $new_instance['number'] );
		$instance['show_title'] = isset( $new_instance['show_title'] ) ? (bool) $new_instance['show_title'] : false;
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
		$page_id    = isset( $instance['page_id'] ) ? absint( $instance['page_id'] ) : '';
		$number     = isset( $instance['number'] ) ? absint( $instance['number'] ) : 4;
		$show_title = isset( $instance['show_title'] ) ? (bool) $instance['show_title'] : true;
	?>

		<p>
			<label for="<?php echo $this->get_field_id( 'page_id' ); ?>">
				<?php _e( 'Parent Page: ', 'designbiz' ); ?>
			</label>
			<?php
				wp_dropdown_pages(
					array(
						'show_option_none' => esc_html__( 'Select a parent page', 'designbiz' ),
						'name'             => $this->get_field_name( 'page_id' ),
						'selected'         => $page_id
					)
				);
			?>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'number' ); ?>">
				<?php esc_html_e( 'Number of child pages to show: ', 'designbiz' ); ?>
			</label>
			<input class="tiny-text" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="number" step="1" min="1" value="<?php echo $number; ?>" size="3" />
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked( $show_title ); ?> id="<?php echo $this->get_field_id( 'show_title' ); ?>" name="<?php echo $this->get_field_name( 'show_title' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'show_title' ); ?>">
				<?php esc_html_e( 'Show the parent page title & content?', 'designbiz' ); ?>
			</label>
		</p>

	<?php

	}

}
