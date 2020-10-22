<?php
/**
 * Widget Socials
 *
 * @package Neotech
 */

class Neotech_Socials extends WP_Widget {

	// setup the widget name, description etc.
	function __construct() {
		$widget_options = array(
			'classname'   => esc_attr( "widget-socials" ),
			'description'  => esc_html__( 'Socials widget', 'deo-core' ),
			'customize_selective_refresh' => true
		);
		parent::__construct( 'Neotech_socials', 'Neotech Socials', $widget_options);
	}


	// front-end display of widget
	function widget( $args, $instance ) {

		extract( $args );
		echo $args['before_widget'];

		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}

		if ( function_exists( 'deo_render_social_icons' ) ) {
			echo deo_render_social_icons( 'text' );
		}

		echo $args['after_widget'];
	}


	// back-end display of widget
	function form( $instance ) {
		$title = ( ! empty( $instance['title'] ) ? $instance['title'] : '' );

		?>

			<!-- Title -->
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id('title') ); ?>"><?php esc_attr_e( 'Title', 'deo-core' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
			</p>

		<?php
	}


	// update of the widget
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		return $instance;
	}

}

add_action( 'widgets_init', function() {
	register_widget( 'Neotech_Socials' );
});