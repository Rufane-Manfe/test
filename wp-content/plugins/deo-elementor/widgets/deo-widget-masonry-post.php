<?php
namespace DeoThemes\Widgets;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly.

class Deo_Widget_Masonry_Post extends \Elementor\Widget_Base {

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
		return 'deo-masonry_post';
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
		return __( 'Deo Masonry Posts', 'deo-elementor' );
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
		return 'eicon-gallery-group';
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
		$this->section_grid();
		$this->section_meta();

		$this->section_title_style();
		$this->section_meta_style();
	}


	/**
	* Content > Grid.
	*/
	private function section_grid() {
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
				'placeholder' => __( '3', 'deo-elementor' ),
				'default'     => 3,
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
				'default' => '',
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
		echo '<section class="featured-posts-masonry">';

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

		if ( $query->have_posts() ) {

			$i = 1;

			while ( $query->have_posts() ) :
				$query->the_post();

				if ( $i == 1 ) {
					$this->renderFirstPost( get_the_ID() );
				} elseif ( $i <= 2 ) {
					$this->renderSecondList( get_the_ID() );
				} elseif ( $i <= 3 ) {
					$this->renderLastList( get_the_ID() );
				}

			$i++;

			if ( $i >= 4 ) {
				$i = 1;
			}
			endwhile;
		}

		wp_reset_postdata();

		echo '</section>';
	}

	protected function renderFirstPost( $post_id = '' ) { ?>

		<div class="featured-posts-masonry__item featured-posts-masonry__item--lg">
			<article <?php post_class( 'entry featured-posts-masonry__entry' ); ?>>
				<?php $this->renderImage( $post_id ); ?>

				<div class="thumb-text-holder">
					<?php

					$this->renderCategory( $post_id );

					$this->renderTitle( $post_id );
					?>

				</div>
			</article>
		</div>

	<?php
	}

	protected function renderSecondList( $post_id = '' ) {?>

		<div class="featured-posts-masonry__item featured-posts-masonry__item--sm">
			<article <?php post_class( 'entry featured-posts-masonry__entry' ); ?>>
				<?php $this->renderImage( $post_id ); ?>

				<div class="thumb-text-holder">
					<?php

					$this->renderCategory( $post_id );

					$this->renderTitle( $post_id );
					?>

				</div>
			</article>
		</div>
	<?php
	}

	protected function renderLastList( $post_id = '' ) {?>

		<div class="featured-posts-masonry__item">
			<article <?php post_class( 'entry featured-posts-masonry__entry' ); ?>>
				<?php $this->renderImage( $post_id ); ?>

				<div class="thumb-text-holder">
					<?php

					$this->renderCategory( $post_id );

					$this->renderTitle( $post_id );
					?>

				</div>
			</article>
		</div>
	<?php
	}

	/**
	 * Render image of post.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function renderImage( $post_id = '' ) {
		$settings = $this->get_settings_for_display(); ?>

		<div class="thumb-bg-holder" <?php if ( has_post_thumbnail( $post_id ) ) : ?>style="background-image: url('<?php the_post_thumbnail_url(); ?>')" <?php endif; ?> >
			<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" class="thumb-url"></a>
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
	protected function renderTitle( $post_id = '' ) {
		$settings = $this->get_settings_for_display();
		?>

		<<?php esc_attr_e( $settings['title_size'] ); ?> class="entry__title--lg entry__title--white">
			<a href="<?php the_permalink( $post_id ); ?>"><?php echo wp_kses_post( get_the_title( $post_id ) ); ?></a>
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