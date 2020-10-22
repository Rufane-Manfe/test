<?php
namespace DeoThemes\Widgets;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly.

class Deo_Widget_Posts_Carousel extends \Elementor\Widget_Base {

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
		return 'deo-posts-carousel';
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
		return esc_html__( 'Deo Posts Carousel', 'deo-elementor' );
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
		return 'eicon-carousel';
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

		$this->section_title_style();
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
			'post_items',
			[
				'type'        => \Elementor\Controls_Manager::NUMBER,
				'label'       => '<i class="fa fa-th-large"></i> ' . __( 'Posts', 'deo-elementor' ),
				'placeholder' => __( '4', 'deo-elementor' ),
				'default'     => 4,
			]
		);

		// Columns.
		$this->add_responsive_control(
			'post_columns',
			[
				'type'           => \Elementor\Controls_Manager::SELECT,
				'label'          => '<i class="fa fa-columns"></i> ' . __( 'Columns', 'deo-elementor' ),
				'default'        => 3,
				'tablet_default' => 6,
				'mobile_default' => 12,
				'options'        => [         
					3 => 4,
					4 => 3,
					6 => 2,
					12 => 1
				],
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
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .thumb-entry-title' => 'color: {{VALUE}};',
					'{{WRAPPER}} .thumb-entry-title a' => 'color: {{VALUE}};',
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
		echo '<section class="section-recommended">';

		$args = [
			'post_type' => 'post',
			'post_status' => 'publish'
		];

		// How many posts
		if ( ! empty( $settings['post_items'] ) ) {
			$args['posts_per_page'] = $settings['post_items'];
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

			echo '<div id="flickity-carousel" class="carousel-posts arrows-outside">';

				while ( $query->have_posts() ) :
					$query->the_post();
					$this->renderPosts( $settings );
				endwhile;

			echo '</div>';

		endif;

		wp_reset_postdata();

		echo '</section>';
	}

	protected function renderPosts( $settings ) { ?>

		<?php $columns = ( ! empty( $settings['post_columns_mobile'] ) ? ' col-' . $settings['post_columns_mobile'] : '' ) . ( ! empty( $settings['post_columns_tablet'] ) ? ' col-md-' . $settings['post_columns_tablet'] : '' ) . ( ! empty( $settings['post_columns'] ) ? ' col-lg-' . $settings['post_columns'] : '' ); ?>

		<div class="carousel-cell <?php echo esc_attr( $columns ); ?>">
			<article <?php post_class( 'entry' ); ?>>
				<?php $this->renderImage();?>
				<div class="thumb-text-holder">
					<?php $this->renderTitle(); ?>
				</div>
			</article>
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

		if ( has_post_thumbnail() ) { ?>
			<div class="thumb-bg-holder entry__bg-img-holder" <?php if ( has_post_thumbnail() ) : ?>style="background-image: url('<?php the_post_thumbnail_url( 'neotech-carousel-vertical-thumb' ); ?>')" <?php endif; ?> >
				<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" class="thumb-url"></a>
				<div class="bottom-gradient"></div>
				<?php $this->renderCategory(); ?>
			</div>
		<?php }
	}

	/**
	* Render title of post.
	*
	* @since 1.0.0
	* @access protected
	*/
	protected function renderTitle() {
		$settings = $this->get_settings_for_display(); ?>
		<<?php esc_attr_e( $settings['title_size'] ); ?> class="thumb-entry-title">
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
		$settings = $this->get_settings_for_display(); ?>
		<div class="entry__meta-category-holder">
			<?php echo neotech_meta_category(); ?>
		</div> <?php
	}
}