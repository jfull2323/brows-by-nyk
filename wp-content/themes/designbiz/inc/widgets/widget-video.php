<?php
/**
 * Video widget.
 */
class Designbiz_Video_Widget extends WP_Widget {

	/**
	 * Sets up the widgets.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {

		// Set up the widget options.
		$widget_ops = array(
			'classname'   => 'widget_video',
			'description' => esc_html__( 'Display any type of video from any video provider.', 'designbiz' ),
			'customize_selective_refresh' => true
		);

		// Create the widget.
		parent::__construct(
			'designbiz-video',                             // $this->id_base
			esc_html__( 'Designbiz - Video', 'designbiz' ), // $this->name
			$widget_ops                                   // $this->widget_options
		);

		$this->alt_option_name = 'widget_video';
	}

	/**
	 * Outputs the widget based on the arguments input through the widget controls.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $args     Display arguments including 'before_title', 'after_title',
	 *                        'before_widget', and 'after_widget'.
	 * @param array $instance Settings for the current Video widget instance.
	 */
	public function widget( $args, $instance ) {
		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		// Set up default value
		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : '';
		$url   = ( ! empty( $instance['url'] ) ) ? esc_url( $instance['url'] ) : '';
		$code  = ( ! empty( $instance['code'] ) ) ? $instance['code'] : '';

		// Output the theme's $before_widget wrapper.
		echo $args['before_widget'];

		// If the title not empty, display it.
		if ( $title ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $title, $instance, $this->id_base ) . $args['after_title'];
		}

			// Display the video.
			if ( $url ) {
				echo '<div class="video-frame">' . wp_oembed_get( $url ) . '</div>';
			} elseif ( $code ) {
				echo '<div class="video-frame">' . $code . '</div>';
			}

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
		$instance          = $old_instance;
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		$instance['url']   = esc_url_raw( $new_instance['url'] );
		if ( current_user_can( 'unfiltered_html' ) ) {
			$instance['code'] = $new_instance['code'];
		} else {
			$instance['code'] = wp_kses_post( $new_instance['code'] );
		}
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
		$title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$url   = isset( $instance['url'] ) ? esc_url( $instance['url'] ) : '';
		$code  = isset( $instance['code'] ) ? esc_textarea( $instance['code'] ) : '';
	?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>">
				<?php esc_html_e( 'Title', 'designbiz' ); ?>
			</label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $title; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'url' ); ?>">
				<?php esc_html_e( 'Video URL', 'designbiz' ); ?>
			</label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'url' ); ?>" name="<?php echo $this->get_field_name( 'url' ); ?>" value="<?php echo $url; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'code' ); ?>">
				<?php esc_html_e( 'Embed Code', 'designbiz' ); ?>
			</label>
			<textarea class="widefat" name="<?php echo $this->get_field_name( 'code' ); ?>" id="<?php echo $this->get_field_id( 'code' ); ?>" cols="30" rows="6"><?php echo $code; ?></textarea>
		</p>

	<?php

	}

}
