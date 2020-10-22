<?php
/**
 * Widget Tweets
 *
 * @package Neotech
 */

class Neotech_Latest_Tweets extends WP_Widget {

	// setup the widget name, description etc.
	function __construct() {
		$widget_options = array(
			'classname'   => esc_attr( "widget-twitter" ),
			'description'  => esc_html__( 'Latest Tweets widget', 'deo-core' ),
			'customize_selective_refresh' => true
		);
		parent::__construct( 'Neotech_Latest_Tweets', 'Neotech Latest Tweets', $widget_options );
	}

	// front-end display of widget
	function widget( $args, $instance )
	{
		extract( $args );
		extract( $instance, EXTR_SKIP );

		$data = array();

		if ( ! empty( $username ) && ! empty( $consumer_key ) && ! empty( $consumer_secret ) && ! empty( $access_token ) && ! empty( $access_secret ) ) {
			$data = $this->_fetch_data( $instance );
		}

		$title = '';

		if ( ! empty( $instance['title'] ) ) {
			$title = apply_filters( 'widget_title', $instance['title'] );
		}

		echo wp_kses_post( $before_widget );

		echo wp_kses_post( $before_title . $title . $after_title );


		if ( ! empty( $username ) && ! empty( $data ) && ! empty( $consumer_key ) && ! empty( $consumer_secret ) && ! empty( $access_token ) && ! empty( $access_secret ) ) {
		?>
			<div class="widget-twitter__wrap">
				<?php
					foreach ( $data as $tweet ):
						$tweet->text = preg_replace('/((https?|s?ftp|ssh)\:\/\/[^"\s\<\>]*[^.,;\'">\:\s\<\>\)\]\!])/', '<a href="\\1">\\1</a>', $tweet->text);
						$tweet->text = preg_replace('/\B@([_a-z0-9]+)/i', '<a href="http://twitter' . '.com/\\1">@\\1</a>', $tweet->text);
						$permalink = 'http://twitter.com/#!/'. $username .'/status/'. $tweet->id_str;

						$time = strtotime( $tweet->created_at );
						$final_time = sprintf( esc_html__( '%s ago', 'deo-core' ), human_time_diff( $time ) );
				?>
					<div class="widget-twitter__tweets">
						<div class="widget-twitter__tweet">
							<i class="ui-twitter widget-twitter__tweet-icon"></i>
							<div class="widget-twitter__tweet-text-holder">
								<p class="widget-twitter__tweet-text"><?php echo wp_kses_post( $tweet->text ); ?></p>
								<div class="widget-twitter__tweet-time"><a href="<?php echo esc_url( $permalink ) ?>" title="<?php echo date( 'Y/m/d H:i:s', $time ) ?>" target="_blank" rel="nofollow"><?php echo esc_attr( $final_time ) ?></a></div>
							</div>
						</div>
					</div>

				<?php endforeach; ?>
			</div>

		<?php
		}

		echo wp_kses_post( $after_widget );
	}

	// update of the widget
	function update( $new_instance, $old_instance ) {

		foreach ( $new_instance as $key => $val ) {
			$new_instance[$key] = wp_filter_kses( $val );
		}

		delete_transient('neotech-transient-tweets');

		$new_instance['show_num'] = intval($new_instance['show_num']);

		return $new_instance;
	}

	public function form($instance)
	{
		$instance = array_merge(array(
			'title' => 'Twitter Feed', 'username' => '', 'consumer_key' => '', 'consumer_secret' => '', 'access_token' => '', 'access_secret' => '', 'show_num' => 3,
		), (array) $instance);

		extract($instance);

	?>

	<p><a href="http://dev.twitter.com/apps" target="_blank"><?php _e('Create your Twitter App', 'deo-core'); ?></a></p>

	<p>
		<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php _e('Title:', 'deo-core'); ?></label>
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php
			echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
	</p>

	<p>
		<label for="<?php echo esc_attr($this->get_field_id('username')); ?>"><?php _e('Username:', 'deo-core'); ?></label>
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id('username')); ?>" name="<?php
			echo esc_attr($this->get_field_name('username')); ?>" type="text" value="<?php echo esc_attr($username); ?>" />
	</p>

	<p>
		<label for="<?php echo esc_attr($this->get_field_id('consumer_key')); ?>"><?php _e('Consumer Key', 'deo-core'); ?></label>
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id('consumer_key')); ?>" name="<?php
			echo esc_attr($this->get_field_name('consumer_key')); ?>" type="text" value="<?php echo esc_attr($consumer_key); ?>" />
	</p>

	<p>
		<label for="<?php echo esc_attr($this->get_field_id('consumer_secret')); ?>"><?php _e('Consumer Secret', 'deo-core'); ?></label>
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id('consumer_secret')); ?>" name="<?php
			echo esc_attr($this->get_field_name('consumer_secret')); ?>" type="text" value="<?php echo esc_attr($consumer_secret); ?>" />
	</p>

	<p>
		<label for="<?php echo esc_attr($this->get_field_id('access_token')); ?>"><?php _e('Access Token', 'deo-core'); ?></label>
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id('access_token')); ?>" name="<?php
			echo esc_attr($this->get_field_name('access_token')); ?>" type="text" value="<?php echo esc_attr($access_token); ?>" />
	</p>

	<p>
		<label for="<?php echo esc_attr($this->get_field_id('access_secret')); ?>"><?php _e('Access Token Secret', 'deo-core'); ?></label>
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id('access_secret')); ?>" name="<?php
			echo esc_attr($this->get_field_name('access_secret')); ?>" type="text" value="<?php echo esc_attr($access_secret); ?>" />
	</p>

	<p>
		<label for="<?php echo esc_attr($this->get_field_id('show_num')); ?>"><?php _e('Number of Tweets:', 'deo-core'); ?></label>
		<input class="width100" id="<?php echo esc_attr($this->get_field_id('show_num')); ?>" name="<?php
			echo esc_attr($this->get_field_name('show_num')); ?>" type="text" value="<?php echo esc_attr($show_num); ?>" />
	</p>

	<?php

	}

	public function _fetch_data($instance)
	{
		$tweets_key  = 'neotech-transient-tweets';
		$cache       = get_transient( $tweets_key );

		if ( $cache === false ) {
			$data = $this->_fetch_tweets($instance);

			if ( $data ) {
				set_transient( $tweets_key, $data, 60 * 10 );
			}

			return $data;
		} else {
			return $cache;
		}
	}

	public function _fetch_tweets( $instance )
	{
		extract( $instance );

		/*
		 * Twitter API
		 */
		require_once DEO_CORE_PATH . '/includes/twitteroauth/twitteroauth.php';

		$twitterConnection = new TwitterOAuth(
			$instance['consumer_key'],
			$instance['consumer_secret'],
			$instance['access_token'],
			$instance['access_secret']
		);

		$instance = $twitterConnection->get('statuses/user_timeline', array('screen_name' => $username, 'count' => $show_num, 'exclude_replies' => false ) );

		if ( $twitterConnection->http_code === 200 ) {
			return $instance;
		}

		return false;
	}
}

add_action( 'widgets_init', function() {
	register_widget( 'Neotech_Latest_Tweets' );
});