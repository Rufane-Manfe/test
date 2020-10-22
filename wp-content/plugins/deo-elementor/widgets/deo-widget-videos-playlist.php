<?php
namespace DeoThemes\Widgets;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly.

class Deo_Widget_Videos_Playlist extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'deo-videos_playlist';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Deo Videos Playlist', 'deo-elementor' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-youtube';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'deothemes-widgets' ];
	}

	/**
	 * Register widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function _register_controls() {
		$this->section_block_options();
		$this->section_videos();

		$this->section_title_style();
	}

	/**
	* Content > Block Options.
	*/
	private function section_block_options() {

		$this->start_controls_section(
			'section_block_options',
			[
				'label' => __( 'Block Options', 'deo-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'block_title',
			[
				'label'         => esc_html__( 'Block Title', 'deo-elementor'),
				'type'          => \Elementor\Controls_Manager::TEXT,
				'description'   => esc_html__('Enter section title (Note: you can leave it empty).', 'deo-elementor'),
			]
		);

		$this->end_controls_section();
	}

	/**
	* Content > Posts.
	*/
	private function section_videos() {
		$this->start_controls_section(
			'section_grid_options',
			[
				'label' => __( 'Videos Options', 'deo-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		// YouTube API key
		$this->add_control(
			'youtube_api_key',
			[
				'label'       => esc_html__( 'YouTube API key', 'deo-elementor'),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
			]
		);

		$this->add_control(
			'youtube_api_key_instructions',
			[
				'type' => \Elementor\Controls_Manager::RAW_HTML,
				'raw' => sprintf(
					__( 'Visit <a href="%s" target="_blank">Google API Console</a> and login with your YouTube/Google ID. Create a project in Google API Dashboard. Enable YouTube Data API v3. Create and copy Google API key', 'deo-elementor' ), esc_url( 'https://console.cloud.google.com/apis/' ) ),
				'separator' => 'after',
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
			]
		);

		// Items.
		$this->add_control(
			'videos_list',
			[
				'label' => __( 'Video Link', 'deo-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'placeholder' => 'https://www.youtube.com/watch?v=mn6Ia5e_suY',
				'description' => __( 'Enter each video url in a coma seprated. Supports: YouTube videos only.', 'deo-elementor' ),
				'label_block' => true,
				'default' => '',
			]
		);

		// Items.
		$this->add_control(
			'block_id',
			[
				'label' => __( 'Block ID', 'deo-elementor' ),
				'type' => \Elementor\Controls_Manager::HIDDEN,
				'default' => $this->get_id(),
			]
		);

		$this->end_controls_section();
	}

	/**
	* Style > Title.
	*/
	private function section_title_style() {
		$this->start_controls_section(
			'section_title_style',
			[
				'label'     => __( 'Title', 'deo-elementor' ),
				'tab'       => \Elementor\Controls_Manager::TAB_STYLE
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => __( 'Color', 'deo-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .entry__title' => 'color: {{VALUE}};',
				],
				'scheme' => [
					'type' => \Elementor\Scheme_Color::get_type(),
					'value' => \Elementor\Scheme_Color::COLOR_1,
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'selector' => '{{WRAPPER}} .entry__title',
				'scheme' => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
			]
		);

		$this->add_control(
			'title_size',
			[
				'label' => __( 'Title Heading Tag', 'deo-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'h1' => __( 'H1', 'deo-elementor' ),
					'h2' => __( 'H2', 'deo-elementor' ),
					'h3' => __( 'H3', 'deo-elementor' ),
					'h4' => __( 'H4', 'deo-elementor' ),
					'h5' => __( 'H5', 'deo-elementor' ),
					'h6' => __( 'H6', 'deo-elementor' ),
				],
				'default' => 'h2',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();
		$videos_list     = get_transient( 'deo-shortcode-playlist-' . $settings['block_id'] );
		$videos_list_key = get_transient( 'deo-shortcode-playlist-key' . $settings['block_id'] );

		if ( empty( $videos_list ) || $settings['videos_list'] != $videos_list_key ) {
			$videos_list = $this->get_video_infos( $settings['videos_list'] );
			set_transient( 'deo-shortcode-playlist-' . $settings['block_id'], $videos_list, 18000 );
			set_transient( 'deo-shortcode-playlist-key' . $settings['block_id'], $settings['videos_list'], 18000 );
		}

		echo '<section class="video-playlist-wrapper" id="video-playlist-wrapper-'. esc_attr( $settings['block_id'] ).'">';
			$this->renderblockheader();
			echo '<div class="video-playlist">';

				if ( ! empty( $videos_list ) ):
					$this->renderIframeVideo( $videos_list );
					$this->renderVideoTabs( $videos_list );
				endif;
			echo '</div>';
		echo '</section>';
	}

	protected function renderIframeVideo( $videos_list ) { ?>
		<div class="video-playlist__content thumb-container">
			<div class="embed-responsive embed-responsive-16by9">
				<?php foreach ( (array)$videos_list as $key => $video ):
					if ( $key > 0 ) {
						continue;
					} ?>

					<iframe
						class="video-playlist__content-video lazyload"
						data-src="<?php echo esc_attr( $video['id'] ); ?>"
						data-thumbnail="<?php echo esc_url( $video['thumb_large'] ); ?>"
						allowfullscreen
						>
					</iframe>
				<?php endforeach; ?>
			</div>
		</div>
	<?php
	}

	protected function renderVideoTabs( $videos_list ) { ?>

		<div class="video-playlist__list">
			<?php
			$video_number = 0;
			foreach ( $videos_list as $video ):
				$video_number ++;

				$active_class = '';

				if ( $video_number == 1 ) {
					$active_class = 'video-playlist__list-item--active';
				}
			?>

				<a  href="<?php echo esc_attr( $video['id'] ) ?>" class="video-playlist__list-item <?php echo esc_attr( $active_class ); ?>">
					<div class="video-playlist__list-item-thumb thumb-container">
						<img src="<?php echo esc_url( $video['thumb'] ); ?>" class="video-playlist__list-item-img" alt="<?php echo esc_attr( $video['title'] ); ?>">
					</div>
					<div class="video-playlist__list-item-description">
						<h4 class="video-playlist__list-item-title"><?php echo wp_kses_post( $video['title'] ); ?></h4>
					</div>
				</a>
			<?php
			endforeach;
			?>
		</div>
	<?php
	}

	protected function get_video_infos( $videos ) {

		$videos_list = array();

		if ( empty( $videos ) ) {
			return $videos_list;
		}

		$explode_list = explode( ',', $videos );

		$videos_data = $this->get_video_info( $explode_list );

		if ( empty( $videos_data ) ) {
			return $videos_list;
		}

		$youtube_thumb_base  = 'https://i.ytimg.com/vi/';
		$youtube_player_base = 'https://www.youtube.com/embed/';

		foreach ( $videos_data as $video ) {

			if ( empty( $video['id'] ) ) {
				continue;
			}

			if ( 'youtube' == $video['type'] ) {
				$video['thumb'] = $youtube_thumb_base . $video['id'] . '/default.jpg';
				$video['thumb_large'] = 'https://i.ytimg.com/vi_webp/' . $video['id'] . '/maxresdefault.webp';
				$video['id']    = $youtube_player_base . $video['id'] . '?enablejsapi=1&amp;rel=0&amp;showinfo=0';
			}

			$videos_list[] = $video;
		}

		return $videos_list;
	}

	protected function get_video_info( $videos_list ) {

		$videos_list = array_filter( $videos_list );
		$videos_ids  = array();		

		foreach ( $videos_list as $video ) {

			// Youtube
			if ( preg_match( "#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $video, $matches ) ) {

				$video_id = preg_replace( '/\s+/', '', $matches[0] );				

				if ( ! isset( $youtube_videos[ $video_id ] ) ) {
					$videos_ids[] = $this->get_youtube_info( $video_id );
				}
			}
		}

		return $videos_ids;
	}

	protected function get_youtube_info( $video_id ) {
		$settings = $this->get_settings_for_display();

		$video = array();
		// Build the Api request
		$params = array(
			'part' => 'snippet,contentDetails',
			'id'   => $video_id,
			'key'  => $settings['youtube_api_key'],
		);

		$api_url = 'https://www.googleapis.com/youtube/v3/videos?' . http_build_query( $params );

		$request = wp_remote_get( $api_url );

		// Check if there are errors
		if ( is_wp_error( $request ) ) {
			return null;
		}

		// Prepare the data
		$result = json_decode( wp_remote_retrieve_body( $request ), true );

		// Check if the video title is exists
		if ( empty( $result['items'][0]['snippet']['title'] ) ) {
			return null;
		}

		// Prepare the Video duration
		$video_info = $result['items'][0]['contentDetails'];

		if ( ! empty( $video_info['duration'] ) ) {
			$interval          = new \DateInterval( $video_info['duration'] );
			$duration_sec      = $interval->h * 3600 + $interval->i * 60 + $interval->s;
			$time_format       = ( $duration_sec >= 3600 ) ? 'H:i:s' : 'i:s';
			$video['duration'] = gmdate( $time_format, $duration_sec );
		}

		// Video data
		$video['title'] = $result['items'][0]['snippet']['title'];
		$video['id']    = $video_id;
		$video['type']  = 'youtube';

		return $video;
	}

	protected function renderblockheader() {
		$settings = $this->get_settings_for_display();

		if ( ! empty( $settings['block_title'] ) ) { ?>

			<div class="section-title-wrap">
				<?php if ( ! empty( $settings['block_title'] ) ) :?>
					<h3 class="section-title"><?php echo wp_kses_post( $settings['block_title'] ); ?></h3>
				<?php endif;?>
			</div>

		<?php

		}
	}

}