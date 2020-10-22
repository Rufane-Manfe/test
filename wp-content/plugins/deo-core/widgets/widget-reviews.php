<?php
/**
 * Widget Reviews
 *
 * @package Neotech
 */

class Neotech_Latest_Reviews extends WP_Widget {

	// setup the widget name, description etc.
	function __construct() {
		$widget_options = array(
			'classname'   => esc_attr( "widget-latest-reviews" ),
			'description'  => esc_html__( 'Latest Reviews widget', 'deo-core' ),
			'customize_selective_refresh' => true
		);
		parent::__construct( 'neotech_latest_reviews', 'Neotech Latest Reviews', $widget_options );
	}

	// front-end display of widget
	function widget( $args, $instance ) {

		$total = ( ! empty( $instance['total'] ) ? absint( $instance['total'] ) : 3 );

		extract( $args );
		extract( $instance, EXTR_SKIP );

		$title = '';

		if ( ! empty( $instance['title'] ) ) {
			$title = apply_filters( 'widget_title', $instance['title'] );
		}

		echo wp_kses_post( $before_widget );

		echo wp_kses_post( $before_title . $title . $after_title );

		if ( ! function_exists( 'wp_review_get_reviews_query' ) ) {
			return false;
		}

		$args = [
			'post_type' => 'post',
			'post_status' => 'publish',
			'ignore_sticky_posts' => 1,
			'review_type' => 'star',
			'post_num' => $total,
			'cat'       => '',
			'page'      => '',
			'clear_cache'  => true,
		];

		$query_args = wp_review_get_reviews_query( 'toprated', $args );

		if ( $query_args->have_posts() ) {
			$this->render_first_post( $query_args );
			$this->render_post_list( $query_args );
		}

		wp_reset_postdata();

		echo wp_kses_post( $after_widget );
	}

	protected function render_first_post( \WP_Query $query ) {

		$query->the_post();

		?>

		<article <?php post_class( 'entry' ); ?>>

			<?php if ( has_post_thumbnail() ): ?>
				<div class="entry__img-holder">
					<a href="<?php echo esc_url( get_the_permalink() ); ?>">
					  <div class="thumb-container">
						<?php the_post_thumbnail( 'neotech-post-grid-cat-thumb', array('class' => 'entry__img' ) ); ?>
					  </div>
					</a>
				</div>
			<?php endif; ?>

			<div class="entry__body">
				<div class="entry__header">

					<?php
					echo neotech_meta_category();
					the_title( sprintf( '<h2 class="entry__title"><a href="%s">', esc_url( get_the_permalink() ) ), '</a></h2>' );
					?>

					<ul class="entry__meta">
						<li class="entry__meta-rating">
							<?php wp_review_show_total(true, 'widget-top-reviews__rating', get_the_ID(), array('in_widget' => true)); ?>
						</li>
					</ul>
				</div>
			</div>
		</article>
	<?php
	}

	protected function render_post_list( \WP_Query $query ) {

		if ( $query->post_count <= 1 ) {
			return null;
		} ?>

		<ul class="post-list-small">

			<?php while ( $query->have_posts() ) : $query->the_post();?>

				<li class="post-list-small__item">
					<article <?php post_class( 'post-list-small__entry' ); ?>>
						<!-- Title -->
						<a href="<?php echo esc_url( get_the_permalink() ); ?>" class="clearfix">

							<?php if ( has_post_thumbnail() ): ?>
								<div class="post-list-small__img-holder">
									<div class="thumb-container">
										<?php the_post_thumbnail( 'neotech-small-grid-widget-thumb', array('class' => 'post-list-small__img' ) ); ?>
									</div>
								</div>
							<?php endif; ?>

							<div class="post-list-small__body">
								<h3 class="post-list-small__entry-title">
									<?php echo esc_html( get_the_title() ); ?>
								</h3>
								<ul class="entry__meta">
									<li class="entry__meta-rating">
										<?php wp_review_show_total(true, 'widget-top-reviews__rating', get_the_ID(), array('in_widget' => true)); ?>
									</li>
								</ul>
							</div>
						</a>
					</article>
				</li>
			<?php endwhile; ?>
		</ul>
	<?php
	}

	// back-end display of widget
	function form( $instance ) {

		$title = ( ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Latest Reviews', 'deo-core' ) );
		$total = ( ! empty( $instance['total'] ) ? absint( $instance['total'] ) : 3 );

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

		<?php
	}

	// update of the widget
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['total'] = ( ! empty( $new_instance['total'] ) ) ? absint( strip_tags( $new_instance['total'] ) ) : 0;
		return $instance;
	}
}

add_action( 'widgets_init', function() {
	register_widget( 'Neotech_Latest_Reviews' );
});