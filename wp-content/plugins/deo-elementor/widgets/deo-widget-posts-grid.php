<?php
namespace DeoThemes\Widgets;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly.

class Deo_Widget_Posts_Grid extends \Elementor\Widget_Base {

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
		return 'deo-posts-grid';
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
		return esc_html__( 'Deo Posts Grid', 'deo-elementor' );
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
		return 'eicon-posts-grid';
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
		$this->section_posts();
		$this->section_image();
		$this->section_meta();
		$this->section_content();

		$this->section_title_style();
		$this->section_meta_style();
	}


	/**
	* Content > Posts.
	*/
	private function section_posts() {
		$this->start_controls_section(
			'section_grid_options',
			[
				'label' => __( 'Posts Options', 'deo-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		// Post categories.
		$this->add_control(
			'post_categories',
			[
				'type'      => \Elementor\Controls_Manager::SELECT,
				'label'     => '<i class="fa fa-folder"></i> ' . __( 'Category', 'deo-elementor' ),
				'options'   => $this->get_post_categories(),
			]
		);

		// Items.
		$this->add_control(
			'posts_per_page',
			[
				'type'        => \Elementor\Controls_Manager::NUMBER,
				'label'       => '<i class="fa fa-th-large"></i> ' . __( 'Posts', 'deo-elementor' ),
				'placeholder' => __( '6', 'deo-elementor' ),
				'default'     => 6,
			]
		);

		// Order by
		$this->add_control(
			'post_order_by',
			[
				'type'    => \Elementor\Controls_Manager::SELECT,
				'label'   => '<i class="fa fa-sort"></i> ' . __( 'Order by', 'deo-elementor' ),
				'default' => 'date',
				'options' => [
					'date'          => __( 'Date', 'deo-elementor' ),
					'title'         => __( 'Title', 'deo-elementor' ),
					'meta_key'			=> __( 'Post Views', 'deo-elementor' ),
					'modified'      => __( 'Modified date', 'deo-elementor' ),
					'comment_count' => __( 'Comment count', 'deo-elementor' ),
					'rand'          => __( 'Random', 'deo-elementor' ),
				],
			]
		);

		// Order
		$this->add_control(
			'order',
			[
				'type'    => \Elementor\Controls_Manager::SELECT,
				'label'   => '<i class="fa fa-sort"></i> ' . __( 'Order', 'deo-elementor' ),
				'default' => 'DESC',
				'options' => [
					'ASC'  => __( 'Ascending', 'deo-elementor' ),
					'DESC' => __( 'Descending', 'deo-elementor' ),
				],
			]
		);

		// Ignore sticky posts
		$this->add_control(
			'ignore_sticky_posts',
			[
				'label'   => '<i class="fa fa-minus-circle"></i> ' . __( 'Ignore Sticky Posts', 'deo-elementor' ),
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		// Specific Posts by ID.
		$this->add_control(
			'post_ids',
			[
				'type'        => \Elementor\Controls_Manager::TEXT,
				'label'       => __( 'Show specific posts by ID', 'deo-elementor' ),
				'placeholder' => __( 'ex.: 256, 54, 78', 'deo-elementor' ),
				'description'   => __( 'Paste post ID\'s separated by commas. To find ID, click edit post and you\'ll find it in the browser address bar', 'deo-elementor' ),
				'default'     => '',
				'separator'     => 'before',
				'label_block' => true,
			]
		);

		$this->end_controls_section();
	}

	/**
	* Content > Image.
	*/
	private function section_image() {
		$this->start_controls_section(
			'section_image',
			[
				'label' => __( 'Image', 'deo-elementor' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		// Hide image
		$this->add_control(
			'image_hide',
			[
				'label'   => '<i class="fa fa-minus-circle"></i> ' . __( 'Hide', 'deo-elementor' ),
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'default' => '',
			]
		);

		$this->end_controls_section();
	}

	/**
	* Content > Meta.
	*/
	private function section_meta() {
		$this->start_controls_section(
			'section_meta',
			[
				'label' => __( 'Meta', 'deo-elementor' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		// Hide date
		$this->add_control(
			'date_hide',
			[
				'label'   => '<i class="fa fa-minus-circle"></i> ' . __( 'Hide Date', 'deo-elementor' ),
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'default' => '',
			]
		);

		// Hide category
		$this->add_control(
			'category_hide',
			[
				'label'   => '<i class="fa fa-minus-circle"></i> ' . __( 'Hide Category', 'deo-elementor' ),
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'default' => '',
			]
		);

		// Hide comments
		$this->add_control(
			'hide_author',
			[
				'label'   => '<i class="fa fa-minus-circle"></i> ' . __( 'Hide Author', 'deo-elementor' ),
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'default' => '',
			]
		);

		$this->end_controls_section();
	}

	/**
	* Content > Content.
	*/
	private function section_content() {
		$this->start_controls_section(
			'section_content',
			[
				'label' => __( 'Content', 'deo-elementor' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		// Hide content.
		$this->add_control(
			'content_hide',
			[
				'label'   => '<i class="fa fa-minus-circle"></i> ' . __( 'Hide', 'deo-elementor' ),
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'default' => '',
			]
		);

		// Length.
		$this->add_control(
			'content_length',
			[
				'type'        => \Elementor\Controls_Manager::NUMBER,
				'label'       => '<i class="fa fa-arrows-h"></i> ' . __( 'Length (words)', 'deo-elementor' ),
				'placeholder' => __( 'Length of content (words)', 'deo-elementor' ),
				'default'     => 15,
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
				'label' => __( 'Color', 'elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#3A444D',
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
	* Style > Meta.
	*/
	private function section_meta_style() {
		$this->start_controls_section(
			'section_meta_style',
			[
				'label'     => __( 'Meta', 'deo-elementor' ),
				'tab'       => \Elementor\Controls_Manager::TAB_STYLE
			]
		);

		$this->add_control(
			'meta_color',
			[
				'label' => __( 'Color', 'elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#919BA3',
				'selectors' => [
					'{{WRAPPER}} .entry__meta li' => 'color: {{VALUE}};',
					'{{WRAPPER}} .entry__meta a' => 'color: {{VALUE}};'
				],
				'scheme' => [
					'type' => \Elementor\Scheme_Color::get_type(),
					'value' => \Elementor\Scheme_Color::COLOR_2,
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'meta_typography',
				'selector' => '{{WRAPPER}} .entry__meta a, {{WRAPPER}} .entry__meta li',
				'scheme' => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
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

		$string_ID = $settings['post_ids'];
		$post_ID = ( ! empty( $string_ID ) ) ? array_map( 'intval', explode( ',', $string_ID ) ) : '';

		// Output
		echo '<section class="content-section section-editors-choice">';

		$args = [
			'post_type' => 'post',
			'post_status' => 'publish'
		];

		// How many posts
		if ( ! empty( $settings['posts_per_page'] ) ) {
			$args['posts_per_page'] = $settings['posts_per_page'];
		}

		// Category
		if ( ! empty( $settings['post_categories'] ) ) {
			$args['category_name'] = $settings['post_categories'];
		}

		// Order by
		if ( ! empty( $settings['post_order_by'] ) ) {
			if ( 'meta_key' == $settings['post_order_by'] ) {
				$args['orderby'] = 'meta_value_num';
				$args['meta_key'] = '_deo_post_views';
			} else {
				$args['orderby'] = $settings['post_order_by'];
			}			
		}

		// Order
		if ( ! empty( $settings['order'] ) ) {
			$args['order'] = $settings['order'];
		}

		// Sticky Posts
		if ( 'yes' == $settings['ignore_sticky_posts'] ) {
			$args['ignore_sticky_posts'] = 1;
		}

		// Specific Posts by ID's
		if ( ! empty( $settings['post_ids'] ) ) {
			$args['post__in'] = $post_ID;
		}

		// Query
		$query = new \WP_Query( $args );	

		if ( $query->have_posts() ) :

			echo '<div class="row">';

			$i = 1;

			while ( $query->have_posts() ) :
				$query->the_post();

				if ( $i == 1 || $i < 3 ) {
					$this->largepostcolumns( get_the_ID() );
				} else {
					$this->smallpostcolumns( get_the_ID() );
				}

				$i++;
			endwhile;

			echo '</div>';
		endif;

		wp_reset_postdata();

		echo '</section> <!-- .row -->';
	}

	protected function largepostcolumns( $post_id = '' ) { ?>

		<div class="col-lg-6">
			<article <?php post_class( 'entry' ); ?>>
				<?php $this->renderImage(); ?>

				<div class="entry__body">
					<div class="entry__header">
						<?php $this->renderCategory(); ?>

						<?php $this->renderTitle(); ?>

						<?php $this->renderMeta(); ?>

					</div>
					<?php $this->renderContent(); ?>
				</div>
			</article>
		</div>

		<?php
	}

	protected function smallpostcolumns( $post_id = '' ) { ?>

		<div class="col-lg-6">
			<div class="post-list-small__item">
				<article <?php post_class( 'post-list-small__entry' ); ?>>
					<a href="<?php echo esc_url( get_the_permalink() ); ?>" class="clearfix">
						<?php $this->renderSmallImage(); ?>
						<div class="post-list-small__body">
							<?php $this->renderSmalltitle(); ?>
							<ul class="entry__meta">
								<li class="entry__meta-date">
									<i class="ui-date"></i>
									<?php echo neotech_meta_date(); ?>
								</li>
							</ul>
						</div>
					</a>
				</article>
			</div>
		</div>

		<?php

	}


	/**
	 * Render image of post type.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function renderImage() {
		$settings = $this->get_settings_for_display();

		if ( $settings['image_hide'] !== 'yes' ) {
			if ( has_post_thumbnail() ) { ?>
				<a href="<?php the_permalink(); ?>">
					<div class="entry__img-holder">
						<?php
						the_post_thumbnail(
							'neotech-post-grid-cat-thumb', array(
								'class' => 'entry__img',
							)
						); ?>
					</div>
				</a>
			<?php }
		}
	}

	/**
	 * Render image of post type.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function renderSmallImage() {
		$settings = $this->get_settings_for_display();

		if ( $settings['image_hide'] !== 'yes' ) {
			if ( has_post_thumbnail() ) { ?>
				<div class="post-list-small__img-holder">
					<div class="thumb-container">
						<?php
						the_post_thumbnail(
							'neotech-small-grid-widget-thumb', array(
								'class' => 'post-list-small__img',
							)
						); ?>
					</div>
				</div>
			<?php }
		}
	}

	/**
	* Render title of post.
	*
	* @since 1.0.0
	* @access protected
	*/
	protected function renderTitle() {
		$settings = $this->get_settings_for_display(); ?>
		<<?php esc_attr_e( $settings['title_size'] ); ?> class="entry__title">
			<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		</<?php esc_attr_e( $settings['title_size'] ); ?>>
		<?php
	}

	protected function renderSmallTitle() {
		$settings = $this->get_settings_for_display(); ?>
		<<?php esc_attr_e( $settings['title_size'] ); ?> class="post-list-small__entry-title">
			<?php the_title(); ?>
		</<?php esc_attr_e( $settings['title_size'] ); ?>>
		<?php
	}

	/**
	 * Get post categories.
	 */
	private function get_post_categories() {
		$options = array();

		if ( ! empty( 'category' ) ) {
			// Get categories for post type.
			$terms = get_terms(
				array(
					'taxonomy'   => 'category',
					'hide_empty' => false,
				)
			);

			$options = array( '0' => esc_html__( 'All categories', 'deo-elementor' ) );

			if ( ! empty( $terms ) ) {
				foreach ( $terms as $term ) {
					if ( isset( $term ) ) {
						if ( isset( $term->slug ) && isset( $term->name ) ) {
							$options[ $term->slug ] = $term->name;
						}
					}
				}
			}
		}

		return $options;
	}


	/**
	 * Render category of post type.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function renderCategory() {
		$settings = $this->get_settings_for_display();

		if ( $settings['category_hide'] !== 'yes' ) {
			echo neotech_meta_category();
		}
	}

	/**
	 * Render meta (date, comments) of post type.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function renderMeta() {
		$settings = $this->get_settings_for_display();

		if ( $settings['date_hide'] !== 'yes' || $settings['hide_author'] !== 'yes' ) { ?>

			<ul class="entry__meta">
				<?php if ( $settings['date_hide'] !== 'yes' ) : ?>
					<li class="entry__meta-date">
						<?php echo neotech_meta_date(); ?>
					</li>
				<?php endif; ?>
				<?php if ( $settings['hide_author'] !== 'yes' ): ?>
					<li class="entry__meta-author">
						<?php esc_html_e( 'by ', 'neotech' ); ?>
						<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) ); ?>">
							<?php the_author(); ?>
						</a>
					</li>
				<?php endif; ?>
			</ul>

		<?php }
	}

	/**
	* Render content of post type.
	*
	* @since 1.0.0
	* @access protected
	*/
	protected function renderContent() {
		$settings = $this->get_settings_for_display();
		if ( $settings['content_hide'] !== 'yes' ) { ?>
			<div class="entry__excerpt">
				<?php
				if ( empty( $settings['content_length'] ) ) {
					the_excerpt();
				} else {
					echo '<p>' . wp_trim_words( get_the_excerpt(), $settings['content_length'] ) . '</p>';
				} ?>
			</div>
			<?php
		}
	}

}