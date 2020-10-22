<?php
namespace DeoThemes\Widgets;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly.

class Deo_Widget_Tabs_Post extends \Elementor\Widget_Base {

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
		return 'deo-tabs-post';
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
		return esc_html__( 'Deo Tabs Post', 'deo-elementor' );
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
		return 'eicon-tabs';
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
		$this->section_post_options();
		$this->section_meta();

		$this->section_title_style();
	}

	/**
	* Content > Post options.
	*/
	private function section_post_options() {
		$this->start_controls_section(
			'section_grid_options',
			[
				'label' => __( 'Post Options', 'deo-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		// Hero height
		$this->add_responsive_control(
			'hero_height',
			[
				'label' => __( 'Hero Height', 'deo-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'vh' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 1200,
					],
					'vh' => [
						'min' => 1,
						'max' => 100,
					]
				],
				'selectors' => [
					'{{WRAPPER}} .hero__slide' => 'height: {{SIZE}}{{UNIT}};',
				],
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
				'label'       => '<i class="fa fa-th-large"></i> ' . __( 'Posts per page', 'deo-elementor' ),
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

		// Hide category
		$this->add_control(
			'category_hide',
			[
				'label'   => '<i class="fa fa-minus-circle"></i> ' . __( 'Hide Category', 'deo-elementor' ),
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'default' => '',
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

		$string_ID = $settings['post_ids'];
		$post_ID = ( ! empty( $string_ID ) ) ? array_map( 'intval', explode( ',', $string_ID ) ) : '';

		// Output
		echo '<section class="hero">';

		$args = [
			'post_type' 	=> 'post',
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

		$this->add_render_attribute( 'slides', [
			'class'	=> 'carousel-main carousel-main-' . $this->get_id(),
			'dir'	=> 'ltr'
		] );

		if ( $query->have_posts() ) :

			echo '<div ' . $this->get_render_attribute_string( 'slides' ) . '>';
				while ( $query->have_posts() ) :
					$query->the_post();

					echo '<div class="carousel-cell hero__slide">'; ?>

						<article <?php post_class( 'hero__slide-entry entry' ); ?>>

							<!-- Image -->
							<?php $this->renderImage(); ?>

							<div class="hero__slide-thumb-text-holder">
								<div class="container">

									<?php $this->renderCategory(); ?>

									<!-- Title -->
									<?php $this->renderTitle(); ?>
								</div>
							</div>

						</article>
					</div>
					<?php
				endwhile;
			echo '</div>';

			$this->add_render_attribute( 'thumbs', [
				'class'	=> 'carousel-thumbs',
				'dir'	=> 'ltr'
			] );

			// Slider thumbs
			echo '<div class="carousel-thumbs-holder">
				<div class="container">
					<div ' .  $this->get_render_attribute_string( 'thumbs' ) . '>';

				while ( $query->have_posts() ) :
					$query->the_post();

					?>
					<div class="carousel-cell">
						<div class="carousel-thumbs__item">
							<div class="carousel-thumbs__img-holder">
								<?php
								if ( has_post_thumbnail() ) :
									the_post_thumbnail( 'neotech-small-tab-post' );
								endif; ?>
							</div>
							<h2 class="carousel-thumbs__title">
								<?php the_title(); ?>
							</h2>
						</div>
					</div>

					<?php
				endwhile;
			echo '</div></div></div>';
		endif;

		wp_reset_postdata();

		echo '</section>';

	}

	/**
	 * Render image of post.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function renderImage() {
		$settings = $this->get_settings_for_display();
		$alt = get_post_meta( attachment_url_to_postid( get_the_post_thumbnail_url() ), '_wp_attachment_image_alt', true );
		?>

		<div class="hero__slide-thumb-bg-holder"  >
			<?php if ( has_post_thumbnail() ) : ?>
				<img data-flickity-lazyload="<?php the_post_thumbnail_url( 'full' ); ?>" alt="<?php echo esc_attr( $alt ); ?>" class="hero__slide-thumb-img hero__slide-thumb-img--object-fit" />
			<?php endif; ?>
			<div class="bottom-gradient"></div>
		</div>
		<?php
	}


	/**
	* Render title of post.
	*
	* @since 1.0.0
	* @access protected
	*/
	protected function renderTitle() {
		$settings = $this->get_settings_for_display(); ?>

		<<?php esc_attr_e( $settings['title_size'] ); ?> class="entry__title--lg entry__title--white">
			<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
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
			echo $this->renderCategories();
		}
	}

	protected function renderCategories() {

		$categories = get_the_category();
		$separator = ', ';
		$categories_output = '';
		$output = '';

		if ( !empty($categories) ):
			foreach( $categories as $index => $category ):
				if ($index > 0) : $categories_output .= $separator; endif;
				$categories_output .= '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '" class="entry__meta-category entry__meta-category--label">' . esc_html( $category->name ) . '</a>';
			endforeach;
		endif;

		if ( 'post' == get_post_type() ) :
			$output .= $categories_output;
		endif;

		return $output;
	}
}