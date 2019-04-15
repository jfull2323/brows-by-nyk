<?php
/**
 * Social widget.
 */
class Designbiz_Social_Widget extends WP_Widget {

	/**
	 * Sets up the widgets.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {

		// Set up the widget options.
		$widget_ops = array(
			'classname'   => 'widget_social',
			'description' => esc_html__( 'Display your social media icons.', 'designbiz' ),
			'customize_selective_refresh' => true,
		);

		// Create the widget.
		parent::__construct(
			'designbiz-social',                              // $this->id_base
			esc_html__( 'Designbiz - Social', 'designbiz' ), // $this->name
			$widget_ops                                      // $this->widget_options
		);

		$this->alt_option_name = 'widget_social';
	}

	/**
	 * Outputs the widget based on the arguments input through the widget controls.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $args     Display arguments including 'before_title', 'after_title',
	 *                        'before_widget', and 'after_widget'.
	 * @param array $instance Settings for the current Social widget instance.
	 */
	public function widget( $args, $instance ) {
		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		// Set up default value
		$title     = isset( $instance['title'] ) ? $instance['title'] : '';
		$facebook  = isset( $instance['facebook'] ) ? $instance['facebook'] : '';
		$twitter   = isset( $instance['twitter'] ) ? $instance['twitter'] : '';
		$instagram = isset( $instance['instagram'] ) ? $instance['instagram'] : '';
		$pinterest = isset( $instance['pinterest'] ) ? $instance['pinterest'] : '';
		$youtube   = isset( $instance['youtube'] ) ? $instance['youtube'] : '';
		$gplus     = isset( $instance['gplus'] ) ? $instance['gplus'] : '';
		$linkedin  = isset( $instance['linkedin'] ) ? $instance['linkedin'] : '';
		$github    = isset( $instance['github'] ) ? $instance['github'] : '';
		$dribbble  = isset( $instance['dribbble'] ) ? $instance['dribbble'] : '';
		$codepen   = isset( $instance['codepen'] ) ? $instance['codepen'] : '';

		// Output the theme's $before_widget wrapper.
		echo $args['before_widget'];

		// If the title not empty, display it.
		if ( $title ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $title, $instance, $this->id_base ) . $args['after_title'];
		}
		?>
			<?php if ( $facebook || $twitter || $instagram || $pinterest || $youtube || $gplus || $linkedin || $github || $dribbble || $codepen ) : ?>
				<div class="widget-social-icons">
					<?php if ( $facebook ) { ?>
						<a class="facebook" href="<?php echo $facebook; ?>"><i class="fa fa-facebook"></i></a>
					<?php } ?>
					<?php if ( $twitter ) { ?>
						<a class="twitter" href="<?php echo $twitter; ?>"><i class="fa fa-twitter"></i></a>
					<?php } ?>
					<?php if ( $instagram ) { ?>
						<a class="instagram" href="<?php echo $instagram; ?>"><i class="fa fa-instagram"></i></a>
					<?php } ?>
					<?php if ( $pinterest ) { ?>
						<a class="pinterest" href="<?php echo $pinterest; ?>"><i class="fa fa-pinterest"></i></a>
					<?php } ?>
					<?php if ( $youtube ) { ?>
						<a class="youtube" href="<?php echo $youtube; ?>"><i class="fa fa-youtube"></i></a>
					<?php } ?>
					<?php if ( $gplus ) { ?>
						<a class="gplus" href="<?php echo $gplus; ?>"><i class="fa fa-google-plus"></i></a>
					<?php } ?>
					<?php if ( $linkedin ) { ?>
						<a class="linkedin" href="<?php echo $linkedin; ?>"><i class="fa fa-linkedin"></i></a>
					<?php } ?>
					<?php if ( $github ) { ?>
						<a class="github" href="<?php echo $github; ?>"><i class="fa fa-github"></i></a>
					<?php } ?>
					<?php if ( $dribbble ) { ?>
						<a class="dribbble" href="<?php echo $dribbble; ?>"><i class="fa fa-dribbble"></i></a>
					<?php } ?>
					<?php if ( $codepen ) { ?>
						<a class="codepen" href="<?php echo $codepen; ?>"><i class="fa fa-codepen"></i></a>
					<?php } ?>
				</div>
			<?php endif; ?>

		<?php
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
		$instance['facebook']  = esc_url_raw( $new_instance['facebook'] );
		$instance['twitter']   = esc_url_raw( $new_instance['twitter'] );
		$instance['instagram'] = esc_url_raw( $new_instance['instagram'] );
		$instance['pinterest'] = esc_url_raw( $new_instance['pinterest'] );
		$instance['youtube']   = esc_url_raw( $new_instance['youtube'] );
		$instance['gplus']     = esc_url_raw( $new_instance['gplus'] );
		$instance['linkedin']  = esc_url_raw( $new_instance['linkedin'] );
		$instance['github']    = esc_url_raw( $new_instance['github'] );
		$instance['dribbble']  = esc_url_raw( $new_instance['dribbble'] );
		$instance['codepen']   = esc_url_raw( $new_instance['codepen'] );
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
		$title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$facebook  = isset( $instance['facebook'] ) ? esc_url( $instance['facebook'] ) : '';
		$twitter   = isset( $instance['twitter'] ) ? esc_url( $instance['twitter'] ) : '';
		$instagram = isset( $instance['instagram'] ) ? esc_url( $instance['instagram'] ) : '';
		$pinterest = isset( $instance['pinterest'] ) ? esc_url( $instance['pinterest'] ) : '';
		$youtube   = isset( $instance['youtube'] ) ? esc_url( $instance['youtube'] ) : '';
		$gplus     = isset( $instance['gplus'] ) ? esc_url( $instance['gplus'] ) : '';
		$linkedin  = isset( $instance['linkedin'] ) ? esc_url( $instance['linkedin'] ) : '';
		$github    = isset( $instance['github'] ) ? esc_url( $instance['github'] ) : '';
		$dribbble  = isset( $instance['dribbble'] ) ? esc_url( $instance['dribbble'] ) : '';
		$codepen   = isset( $instance['codepen'] ) ? esc_url( $instance['codepen'] ) : '';
	?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>">
				<?php esc_html_e( 'Title', 'designbiz' ); ?>
			</label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $title; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'facebook' ); ?>">
				<?php esc_html_e( 'Facebook', 'designbiz' ); ?>
			</label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'facebook' ); ?>" name="<?php echo $this->get_field_name( 'facebook' ); ?>" value="<?php echo $facebook; ?>" placeholder="<?php echo esc_attr( 'http://' ); ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'twitter' ); ?>">
				<?php esc_html_e( 'Twitter', 'designbiz' ); ?>
			</label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'twitter' ); ?>" name="<?php echo $this->get_field_name( 'twitter' ); ?>" value="<?php echo $twitter; ?>" placeholder="<?php echo  esc_attr( 'http://' ); ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'instagram' ); ?>">
				<?php esc_html_e( 'Instagram', 'designbiz' ); ?>
			</label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'instagram' ); ?>" name="<?php echo $this->get_field_name( 'instagram' ); ?>" value="<?php echo $instagram; ?>" placeholder="<?php echo esc_attr( 'http://' ); ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'pinterest' ); ?>">
				<?php esc_html_e( 'Pinterest', 'designbiz' ); ?>
			</label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'pinterest' ); ?>" name="<?php echo $this->get_field_name( 'pinterest' ); ?>" value="<?php echo $pinterest; ?>" placeholder="<?php echo esc_attr( 'http://' ); ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'youtube' ); ?>">
				<?php esc_html_e( 'Youtube', 'designbiz' ); ?>
			</label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'youtube' ); ?>" name="<?php echo $this->get_field_name( 'youtube' ); ?>" value="<?php echo $youtube; ?>" placeholder="<?php echo esc_attr( 'http://' ); ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'gplus' ); ?>">
				<?php esc_html_e( 'Google+', 'designbiz' ); ?>
			</label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'gplus' ); ?>" name="<?php echo $this->get_field_name( 'gplus' ); ?>" value="<?php echo $gplus; ?>" placeholder="<?php echo esc_attr( 'http://' ); ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'linkedin' ); ?>">
				<?php esc_html_e( 'Linkedin', 'designbiz' ); ?>
			</label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'linkedin' ); ?>" name="<?php echo $this->get_field_name( 'linkedin' ); ?>" value="<?php echo $linkedin; ?>" placeholder="<?php echo esc_attr( 'http://' ); ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'github' ); ?>">
				<?php esc_html_e( 'Github', 'designbiz' ); ?>
			</label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'github' ); ?>" name="<?php echo $this->get_field_name( 'github' ); ?>" value="<?php echo $github; ?>" placeholder="<?php echo esc_attr( 'http://' ); ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'dribbble' ); ?>">
				<?php esc_html_e( 'Dribbble', 'designbiz' ); ?>
			</label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'dribbble' ); ?>" name="<?php echo $this->get_field_name( 'dribbble' ); ?>" value="<?php echo $dribbble; ?>" placeholder="<?php echo esc_attr( 'http://' ); ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'codepen' ); ?>">
				<?php esc_html_e( 'Codepen', 'designbiz' ); ?>
			</label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'codepen' ); ?>" name="<?php echo $this->get_field_name( 'codepen' ); ?>" value="<?php echo $codepen; ?>" placeholder="<?php echo esc_attr( 'http://' ); ?>" />
		</p>

	<?php

	}

}
