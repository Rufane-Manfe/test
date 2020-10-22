<?php
/**
 * Widget About.
 *
 * @package Neotech
 */

class Neotech_About_Widget extends WP_Widget {

	// setup the widget name, description etc.
	function __construct() {

		$widget_options = array(
			'classname'   => esc_attr( "widget-about" ),
			'description'  => esc_html__( 'About widget', 'deo-core' ),
			'customize_selective_refresh' => true
		);

		parent::__construct( 'noetech_about', 'Neotech About', $widget_options );
	}

	// front-end display of widget
	function widget( $args, $instance ) {

		extract( $args );
		echo $args['before_widget'];

		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}

		if ( ! empty( $instance['logo_url'] ) ) {
			$alt = get_post_meta( attachment_url_to_postid($instance['logo_url']), '_wp_attachment_image_alt', true );
			?>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
					<img class="logo__img" src="<?php echo esc_url( $instance['logo_url'] ); ?>" alt="<?php echo esc_attr( $alt ); ?>">
				</a>
			<?php
		}

		if ( ! empty( $instance['description'] ) ) {
			printf('<p class="mt-20 mb-20">%s</p>', $instance['description'] );
		}

		if ( empty( $instance['socials'] ) && function_exists( 'deo_render_social_icons' ) ) {
			echo deo_render_social_icons();
		}

		echo $args['after_widget'];
	}


	// back-end display of widget
	function form( $instance ) {

		$instance = wp_parse_args(
			(array) $instance,
			array(
				'title' => '',
				'description' => '',
				'socials' => false
			)
		);

		$title = ( ! empty( $instance['title'] ) ? $instance['title'] : '' );
		$description = ( ! empty( $instance['description'] ) ? $instance['description'] : '' );
		$logo = ( ! empty( $instance['logo_url'] ) ? $instance['logo_url'] : '' );

		?>

			<!-- Title -->
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id('title') ); ?>"><?php esc_attr_e( 'Title', 'deo-core' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
			</p>

			<!-- Image -->
			<h4><?php esc_attr_e( "Choose your logo", 'deo-core' ); ?></h4>
			<p>
				<img class="deo-logo-media" src="<?php if (isset($instance['logo_url']) && $instance['logo_url'] != '' ) :
						echo esc_url( $instance['logo_url'] );
					endif; ?>" style="display: block; max-width: 100%"
				/>
			</p>
			<p>
				<input type="hidden" class="deo-logo-hidden-input widefat" name="<?php echo $this->get_field_name( 'logo_url' ); ?>" id="<?php echo $this->get_field_id( 'logo_url' ); ?>" value="<?php
					if (isset($instance['logo_url']) && $instance['logo_url'] != '' ) :
						echo esc_url( $instance['logo_url'] );
					 endif;
				?>" />
				<input type="button" class="deo-logo-upload-button button button-primary" value="<?php esc_attr_e('Choose logo','deo-core')?>">
				<input type="button" class="deo-logo-delete-button button" value="<?php esc_attr_e('Remove logo', 'deo-core') ?>">
			</p>

			<!-- Description -->
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id('description') ); ?>"><?php esc_attr_e( 'Description', 'deo-core' ); ?></label>
				<textarea id="<?php echo esc_attr( $this->get_field_id('description') ); ?>" name="<?php echo esc_attr( $this->get_field_name('description') ); ?>"  class="widefat" rows="5"><?php echo esc_textarea( $description ); ?></textarea>
			</p>

			<!-- Socials -->
			<p>
				<input class="checkbox" type="checkbox"<?php checked( $instance['socials'] ); ?> id="<?php echo $this->get_field_id( 'socials' ); ?>" name="<?php echo $this->get_field_name( 'socials' ); ?>" />
				<label for="<?php echo $this->get_field_id( 'socials' ); ?>"><?php esc_html_e( 'Hide social icons', 'deo-core' ); ?></label>
			</p>

		<?php
	}


	// update of the widget
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['description'] = wp_kses_post( $new_instance['description'] );
		$instance['logo_url'] = ( ! empty( $new_instance['logo_url'] ) ) ? strip_tags( $new_instance['logo_url'] ) : '';
		$instance['socials'] = (bool)$new_instance['socials'];
		return $instance;
	}
}

add_action( 'widgets_init', function() {
	register_widget( 'Neotech_About_Widget' );
});