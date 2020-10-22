<?php
/**
 * Widget Popular Posts.
 *
 * @package Neotech
 */

class Neotech_Popular_Posts_Widget extends WP_Widget {

	// setup the widget name, description etc.
	function __construct() {
		$widget_options = array(
			'classname'   => esc_attr( "widget-popular-posts" ),
			'description'  => esc_html__( 'Custom Popular Posts Widget', 'deo-core' ),
			'customize_selective_refresh' => true
		);
		parent::__construct( 'neotech_popular_posts', 'Neotech Popular Posts', $widget_options);
	}


	// front-end display of widget
	function widget( $args, $instance ) {
		extract( $args );

		echo $args['before_widget'];

		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		} else {
			echo '<h4 class="widget-title">' . esc_html__( 'Popular Posts', 'deo-core' ) . '</h4>';
		}

		$query = $this->get_popular_posts( $instance );

		if ( $query->have_posts() ) :

			echo '<ul class="widget-popular-posts__list">';

				$count = 0;

				while( $query->have_posts() ) : $query->the_post();
				$count++;
					?>

					<li>
						<article itemscope itemprop="//schema.org/Article" <?php post_class('clearfix'); ?>>
							<div class="widget-popular-posts__img-holder">
								<span class="widget-popular-posts__number"><?php echo esc_attr( $count ); ?></span>
								<div class="thumb-container">
									<a href="<?php echo get_the_permalink(); ?>">
										<?php the_post_thumbnail( 'neotech-popular-posts-thumb', array('class' => 'lazyloaded' ) ); ?>
									</a>
								</div>
							</div>
							<div class="widget-popular-posts__entry">
								<?php the_title( sprintf( '<h3 class="widget-popular-posts__entry-title"><a href="%s">', esc_url( get_permalink() ) ), '</a></h3>' ); ?>
							</div>
						</article>
					</li>

					<?php

				endwhile;
			echo '</ul>';

		endif;

		wp_reset_postdata();

		echo $args['after_widget'];

	}


	// back-end display of widget
	function form( $instance ) {
		$title = ( ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Popular Posts', 'deo-core' ) );
		$total = ( ! empty( $instance['total'] ) ? absint( $instance['total'] ) : 5 );
		$posts_by_id = ( ! empty( $instance['posts_by_id'] ) ? $instance['posts_by_id'] : '' );

		?>
			<!-- Title -->
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id('title') ); ?>"><?php esc_html_e( 'Title', 'deo-core' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
			</p>

			<!-- Number of posts -->
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id('total') ); ?>"><?php esc_html_e( 'Number or posts', 'deo-core' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'total' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'total' ) ); ?>" type="number" value="<?php echo esc_attr( $total ); ?>">
			</p>

			<!-- Posts by ID -->
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id('posts_by_id') ); ?>"><?php esc_html_e( 'Posts by ID\'s', 'deo-core' ); ?></label>
				<p class="help"><?php esc_html_e( 'Paste post ID\'s separated by commas. To find ID, click edit post and you\'ll find it in the browser address bar' ); ?></p>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'posts_by_id' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'posts_by_id' ) ); ?>" type="text" value="<?php echo esc_attr( $posts_by_id ); ?>" placeholder="ex.: 256, 54, 78">
			</p>

		<?php
	}


	// update of the widget
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : esc_html__( 'Popular Posts', 'deo-core' );
		$instance['total'] = ( ! empty( $new_instance['total'] ) ) ? absint( strip_tags( $new_instance['total'] ) ) : 0;
		$instance['posts_by_id'] = ( ! empty( $new_instance['posts_by_id'] ) ) ? strip_tags( $new_instance['posts_by_id'] ) : '';
		return $instance;
	}

	public function get_popular_posts( $instance ) {

			$total = ( ! empty( $instance['total'] ) ? absint( $instance['total'] ) : 5 );

			$posts_args = array(
				'post_type'      => 'post',
				'posts_per_page' => $total,
				'meta_key'       => '_deo_post_views',
				'orderby'        => 'meta_value_num',
				'order'          => 'DESC',
				'ignore_sticky_posts' => true
			);

			// Post ID's
			if ( ! empty( $instance['posts_by_id'] ) ) {
				$posts_args['post__in'] = array_map( 'intval', explode( ',', $instance['posts_by_id'] ) );
			}

			$popular_posts = new WP_Query( $posts_args );

			if ( $popular_posts->have_posts() ) {
				return $popular_posts;
			}

		return $popular_posts;
	}
}


add_action( 'widgets_init', function() {
	register_widget( 'Neotech_Popular_Posts_Widget' );
});