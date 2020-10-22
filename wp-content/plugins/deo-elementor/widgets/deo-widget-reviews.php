<?php
namespace DeoThemes\Widgets;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly.

class Deo_Widget_Reviews extends \Elementor\Widget_Base {

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
		return 'deo-reviews';
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
		return esc_html__( 'Deo Reviews', 'deo-elementor' );
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
		$this->section_grid();
		$this->section_image();
		$this->section_meta();
		$this->section_content();

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
				'label' => __( 'Grid Options', 'deo-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		// Columns.
		$this->add_responsive_control(
			'post_columns',
			[
				'type'           => \Elementor\Controls_Manager::SELECT,
				'label'          => '<i class="fa fa-columns"></i> ' . __( 'Columns', 'deo-elementor' ),
				'default'        => 4,
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
				'default' => 'yes',
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
			'reviews_hide',
			[
				'label'   => '<i class="fa fa-minus-circle"></i> ' . __( 'Hide Reviews', 'deo-elementor' ),
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
		$ajax_param = '';

		$args = array(
			'post_type'      => 'post',
			'post_status'		 => 'publish',
			'meta_key'       => 'wp_review_total',
			'orderby'        => 'meta_value_num',
			'meta_query' 		=> array(
				array(
					'key' => 'wp_review_type',
					'compare' => 'IN',
					'value' => array('star')
				)				
			)
		);

		// How many posts
		if ( ! empty( $settings['posts_per_page'] ) ) {
			$args['posts_per_page'] = $settings['posts_per_page'];
		}

		// Category
		if ( ! empty( $settings['post_categories'] ) ) {
			$args['category__in'] = $settings['post_categories'];
		}

		// Order
		if ( ! empty( $settings['order'] ) ) {
			$args['order'] = $settings['order'];
		}

		// Sticky Posts
		if ( 'yes' == $settings['ignore_sticky_posts'] ) {
			$args['ignore_sticky_posts'] = 1;
		}

		$query = new \WP_Query( $args );

		if ( ! empty( $query ) && is_object( $query ) ) {
			$ajax_param = $this->_ajax_param( $settings, $query );
		}

		echo '<div class="row deo-load-more-container"' . esc_attr( $ajax_param ) . '>';

		if ( $query->have_posts() ) :
			while ( $query->have_posts() ) :
				$query->the_post();

				echo '<div class="' . ( ! empty( $settings['post_columns_mobile'] ) ? ' col-' . $settings['post_columns_mobile'] : '' ) . ( ! empty( $settings['post_columns_tablet'] ) ? ' col-md-' . $settings['post_columns_tablet'] : '' ) . ( ! empty( $settings['post_columns'] ) ? ' col-lg-' . $settings['post_columns'] : '' ) . '">'; ?>

					<article <?php post_class( 'entry' ); ?>>

						<?php $this->renderImage();?>

							<div class="entry__body">
								<div class="entry__header">

									<?php $this->renderCategory(); ?>

									<!-- Title -->
									<?php $this->renderTitle(); ?>

									<?php $this->renderMeta(); ?>

								</div>
								<?php

								// Excerpt
								$this->renderContent();
							?>

						</div>
					</article>
				</div>
				<?php
			endwhile;
		endif;
		wp_reset_postdata();
		echo '</div> <!-- .row -->';
		//echo $this->_render_pagination( $settings, $query);
	}


	protected function _ajax_param( $block, $data_query ) {

		//check
		if ( empty( $block ) ) {
			return false;
		}

		$str                    = '';
		$param                  = array();
		$block_options          = $block;
		$param['data-block_id'] = esc_attr( $this->get_id() );

		// Post per page
		if ( ! empty( $block_options['posts_per_page'] ) ) {
			$param['data-posts_per_page'] = $block_options['posts_per_page'];
		}

		// Max page
		if ( ! empty( $data_query->max_num_pages ) ) {
			$param['data-page_max'] = $data_query->max_num_pages;
		} else {
			$param['data-page_max'] = 1;
		}

		// Widget Type
		$param['data-widget_type'] = $this->get_name();

		// Current page
		$param['data-page'] = 1;
		
		// Columns Mobile
		if ( ! empty( $block_options['post_columns_mobile'] ) ) {
			$param['data-post_columns_mobile'] = $block_options['post_columns_mobile'];
		}

		// Columns Tablet
		if ( ! empty( $block_options['post_columns_tablet'] ) ) {
			$param['data-post_columns_tablet'] = $block_options['post_columns_tablet'];
		}

		// Columns Desktop
		if ( ! empty( $block_options['post_columns'] ) ) {
			$param['data-post_columns'] = $block_options['post_columns'];
		}	

		// Category
		if ( ! empty( $block_options['post_categories'] ) ) {
			$param['data-category_id'] = $block_options['post_categories'];
		}

		// Image Hide
		if ( ! empty( $block_options['image_hide'] ) ) {
			$param['data-image_hide'] = $block_options['image_hide'];
		}

		// Category Hide
		if ( ! empty( $block_options['category_hide'] ) ) {
			$param['data-category_hide'] = $block_options['category_hide'];
		}

		// Date Hide
		if ( ! empty( $block_options['date_hide'] ) ) {
			$param['data-date_hide'] = $block_options['date_hide'];
		}

		// Reviews Hide
		if ( ! empty( $block_options['reviews_hide'] ) ) {
			$param['data-reviews_hide'] = $block_options['reviews_hide'];
		}

		// Content Hide
		if ( ! empty( $block_options['content_hide'] ) ) {
			$param['data-content_hide'] = $block_options['content_hide'];
		}

		// Content Length
		if ( ! empty( $block_options['content_length'] ) ) {
			$param['data-content_length'] = $block_options['content_length'];
		}

		// Title Size
		if ( ! empty( $block_options['title_size'] ) ) {
			$param['data-title_size'] = $block_options['title_size'];
		}

		// Order by
		if ( ! empty( $block_options['post_order_by'] ) ) {
			$param['data-order_by'] = $block_options['post_order_by'];
		}

		// Generate String of Attributes
		foreach ( $param as $k => $v ) {
			if ( ! empty( $k ) ) {
				$str .= esc_attr( $k ) . '= ' . esc_attr( $v ) . ' ';
			}
		}

		return $str;
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
				<div class="entry__img-holder">
					<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
						<div class="thumb-container">
							<?php
							the_post_thumbnail(
								'neotech-post-grid-cat-thumb', array(
									'class' => 'entry__img',
								)
							); ?>
						</div>
					</a>
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
			<a href="<?php echo esc_url( get_the_permalink() ); ?>" title="<?php the_title_attribute(); ?>">
				<?php echo esc_attr( get_the_title() ); ?>
			</a>
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
							$options[ $term->term_id ] = $term->name;
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

		if ( $settings['date_hide'] !== 'yes' || $settings['reviews_hide'] !== 'yes' ) { ?>

			<ul class="entry__meta">
				<?php if ( $settings['date_hide'] !== 'yes' ) : ?>
					<li class="entry__meta-date">
						<?php echo neotech_meta_date(); ?>
					</li>
				<?php endif; ?>
				<?php if ( function_exists( 'wp_review_show_total' ) && 'yes' !== $settings['reviews_hide'] ) : ?>
					<li class="entry__meta-rating">
						<?php wp_review_show_total(true, 'widget-top-reviews__rating', null, array('in_widget' => true)); ?>
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
					echo '<p>' . wp_trim_words( get_the_content(), $settings['content_length'] ) . '</p>';
				} ?>
			</div>
			<?php
		}
	}


	protected function _render_pagination( $settings, $query ) {
		$output = '';

		if ( empty( $settings['post_pagination'] ) ) {
			return false;
		}

		if ( 'numbered' == $settings['post_pagination'] ) {
			if ( is_front_page() ) {
				$paged = ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1;
			} else {
				$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
			}
		}

		ob_start();

		// Pagination
		if ( 'numbered' == $settings['post_pagination'] ) :
			$paginate_args = array(
				'base'      => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
				'current'   => max( 1, $paged ),
				'total'     => $query->max_num_pages,
				'prev_text' => wp_kses( '<i class="ui-arrow-left"></i>', array( 'i' => array( 'class' => array() ) ) ),
				'next_text' => wp_kses( '<i class="ui-arrow-right"></i>', array( 'i' => array( 'class' => array() ) ) ),
			);

			$pagination = paginate_links( $paginate_args ); ?>
			<nav class="pagination elementor-pagination">
				<?php echo $pagination; ?>
			</nav>

		<?php elseif( 'load_more' == $settings['post_pagination'] ) : ?>
			<nav class="deo-load-more elementor-pagination">
				<button class="btn btn-md btn-color deo-load-more__button">
					<span><?php esc_attr_e( 'Load More', 'deo-elementor' ) ?></span>
				</button>
			</nav><?php
		endif;

		$output .= ob_get_clean();
		return $output;

	}

}