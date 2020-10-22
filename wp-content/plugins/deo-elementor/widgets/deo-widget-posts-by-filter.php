<?php
namespace DeoThemes\Widgets;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly.

class Deo_Widget_Posts_By_Filter extends \Elementor\Widget_Base {

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
		return 'deo-posts-by-filter';
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
		return __( 'Deo Posts By Filter', 'deo-elementor' );
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
		return 'eicon-posts-masonry';
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
		$this->section_posts_options();
		$this->section_meta();

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

		$this->add_control(
			'cat',
			[
				'label'         => esc_html__( 'Filter Items', 'deo-elementor'),
				'type'          => \Elementor\Controls_Manager::SELECT2,
				'options'       => $this->get_post_categories(),
				'multiple'      => true,
				'description'   => esc_html__('Enter categories be shown in the filter list.', 'deo-elementor'),
			]
		);


		$this->end_controls_section();
	}

	/**
	* Content > Posts Options.
	*/
	private function section_posts_options() {
		$post_categories = get_categories();

		$this->start_controls_section(
			'section_posts_options',
			[
				'label' => __( 'Posts Options', 'deo-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		// Post categories.
		$this->add_control(
			'category_id',
			[
				'type'      => \Elementor\Controls_Manager::SELECT,
				'label'     => '<i class="fa fa-folder"></i> ' . __( 'Category', 'deo-elementor' ),
				'options'   => $this->get_post_categories(),
				'default'       => $post_categories[0]->name
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
			'orderby',
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
				'default' => 'yes',
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
				'default' => '#fff',
				'selectors' => [
					'{{WRAPPER}} .thumb-entry-title' => 'color: {{VALUE}};',
					'{{WRAPPER}} .thumb-entry-title a' => 'color: {{VALUE}};',
					'{{WRAPPER}} .thumb-entry-title a:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}} .thumb-entry-title a:focus' => 'color: {{VALUE}};',
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

		$data = $this->_fetch_query_data( $settings );

		$output  = '';
		$output .= $this->_start_block( $settings, $data );
		$output .= $this->render_block_header();
		$output .= $this->_render_content( $settings, $data );
		$output .= $this->_close_block();

		echo $output;
	}

	protected function _fetch_query_data( $query_args = array() ) {

		$args = wp_parse_args( $query_args, array(
			'post_status'         => array( 'publish' ),
			'post_type'           => 'post',
		) );

		// How many posts
		if ( ! empty( $query_args['posts_per_page'] ) ) {
			$args['posts_per_page'] = $query_args['posts_per_page'];
		}

		// Category
		if ( ! empty( $query_args['category_id'] ) ) {
			$args['category_name'] = $query_args['category_id'];
		}

		// Order by
		if ( ! empty( $query_args['post_order_by'] ) ) {
			if ( 'meta_key' == $query_args['post_order_by'] ) {
				$args['orderby'] = 'meta_value_num';
				$args['meta_key'] = '_deo_post_views';
			} else {
				$args['orderby'] = $query_args['post_order_by'];
			}			
		}

		// Order
		if ( ! empty( $query_args['order'] ) ) {
			$args['order'] = $query_args['order'];
		}

		// Prepare the cache key
		$cache_key = http_build_query( $args );

		// Check for the custom key in the theme group
		$custom_query = wp_cache_get( $cache_key, 'deo_cache_query' );

		// If nothing is found, build the object.
		if ( false === $custom_query ) {

			$custom_query = new \WP_Query( $args );

			if ( ! is_wp_error( $custom_query ) && $custom_query->have_posts() ) {
				wp_cache_set( $cache_key, $custom_query, 'deo_cache_query' );
			}
		}

		return $custom_query;
	}

	protected function _start_block( $settings, $data = null ) {

		//create class
		$main_classes    = array();
		$inner_classes   = array();
		$ajax_param      = '';

		if ( ! empty( $data ) && is_object( $data ) ) {
			$ajax_param = $this->_ajax_param( $settings, $data );
		}

		$output = '';

		$output .= '<div class="content-section section-recent-news tab-post" ' . esc_attr( $ajax_param ) . '>';
		$output .= '<div class="recent-news-inner">';

		return $output;
	}

	protected function _close_block() {
		return '</div></div><!-- .content-section section-recent-news-->';
	}

	protected function _ajax_param( $block, $data_query ) {

		//check
		if ( empty( $block ) ) {
			return false;
		}

		$str                      = '';
		$param                    = array();
		$block_options            = $block;
		$param['data-block_id']   = esc_attr( $this->get_id() );

		// Posts Per Page
		if ( ! empty( $block_options['posts_per_page'] ) ) {
			$param['data-posts_per_page'] = $block_options['posts_per_page'];
		}

		// Max Page
		if ( ! empty( $data_query->max_num_pages ) ) {
			$param['data-block_page_max'] = $data_query->max_num_pages;
		} else {
			$param['data-block_page_max'] = 1;
		}

		// Widget Type
		$param['data-widget_type'] = $this->get_name();

		// Current Page
		$param['data-block_page_current'] = 1;

		// Category
		if ( ! empty( $block_options['category_id'] ) ) {
			$param['data-category_id'] = $block_options['category_id'];
		}

		// Categories
		if ( ! empty( $block_options['cat'] ) ) {

			$cat = $block_options['cat'];

			if ( is_array( $block_options['cat'] ) ) {
				$param['data-cat'] = implode( ',', $cat );
			} else {
				$param['data-cat'] = $cat;
			}
		}

		// Category Hide
		if ( ! empty( $block_options['category_hide'] ) ) {
			$param['data-category_hide'] = $block_options['category_hide'];
		}

		// Orderby
		if ( ! empty( $block_options['orderby'] ) ) {
			$param['data-orderby'] = $block_options['orderby'];
		}

		// Generate String of Attributes
		foreach ( $param as $k => $v ) {
			if ( ! empty( $k ) ) {
				$str .= esc_attr( $k ) . '= ' . esc_attr( $v ) . ' ';
			}
		}

		return $str;
	}

	protected function _render_content( $settings, $query ) {

		$output = '';

		$output .= $this->block_content_open( 'row row-16' );

		if ( $query->have_posts() ) {
			$output .= $this->_renderPosts( $query, $settings );
		} else {
			$output .= $this->no_content();
		}

		$output .= $this->block_content_close();

		//reset post data
		wp_reset_postdata();

		return $output;
	}

	protected function block_content_open( $classes = '' ) {
		$class_name   = array();
		$class_name[] = 'block-inner-content';
		if ( ! empty( $classes ) ) {
			$class_name[] = $classes;
		}

		$class_name = implode( ' ', $class_name );

		$output = '';
		$output .= '<div class="block-content-wrapper">';
		$output .= '<div class="' . esc_attr( $class_name ) . '">';

		return $output;
	}

	protected function block_content_close() {
		return '</div></div><!-- #block content-->';
	}

	public function _renderPosts( $query, $settings ) {

		$output  = '';
		$counter = 1;
		$total   = $query->post_count;

		while ( $query->have_posts() ) {

			$query->the_post();

			if ( $counter == 1 ) {
				$output .= $this->smallpostcolumns( $settings );
			} elseif ( $counter == 2 ) {
				$output .= $this->bigpostcolumns( $settings );
			} elseif ( $counter <= 5 ) {
				$output .= $this->smallpostcolumns( $settings );
			} elseif ( $counter == 6 ) {
				$output .= $this->bigpostcolumns( $settings );
			}

			if ( $counter >= 6 ) {
				$counter = 0;
			}

			$counter++;
		}

		return $output;
	}

	protected function no_content() {
		return '<div class="deo-error"><p>' . esc_html__( 'Sorry, Posts you requested could not be found..', 'deo-elementor' ) . '</p></div>';
	}

	public function smallpostcolumns( $settings ) {

		$image_url = '';

		if ( has_post_thumbnail() ) {
			$image_url = 'style="background-image: url(' . get_the_post_thumbnail_url( get_the_ID(), 'neotech-post-grid-cat-thumb' ) . ')"';
		}

		$output  = '<div class="col-lg-3 col-sm-6">';
		$output .= '<article class="entry">';
		$output .= '<div class="thumb-bg-holder entry__bg-img-holder" '. $image_url .'>';
		if ( 'yes' !== $settings['category_hide'] ) {
			$output .= '<div class="entry__meta-category-holder">' . neotech_meta_category() . '</div>';
		}
		$output .= '<a href="'. esc_url( get_the_permalink() ).'" title="'. esc_html( get_the_title() ) .'" class="thumb-url"></a>';
		$output .= '<div class="bottom-gradient"></div>';
		$output .= '</div>';
		$output .= '<div class="thumb-text-holder">';        
		$output .= '<h2 class="thumb-entry-title">';
		$output .= '<a href="'. esc_url( get_the_permalink() ). '">'. esc_html( get_the_title() ).'</a>';
		$output .= '</h2>';
		$output .= '</div>';
		$output .= '</article>';
		$output .= '</div>';

		return $output;
	}

	public function bigpostcolumns( $settings ) {

		$image_url = '';

		if ( has_post_thumbnail() ) {
			$image_url = 'style="background-image: url(' . get_the_post_thumbnail_url( get_the_ID(), 'neotech-post-grid-cat-thumb' ) . ')"';
		}

		$output  = '<div class="col-lg-6 col-sm-6">';
		$output .= '<article class="entry">';
		$output .= '<div class="thumb-bg-holder entry__bg-img-holder" '. $image_url .'>';
		if ( 'yes' !== $settings['category_hide'] ) {
			$output .= '<div class="entry__meta-category-holder">' . neotech_meta_category() . '</div>';
		}
		$output .= '<a href="'. esc_url( get_the_permalink() ).'" title="'. esc_html( get_the_title() ) .'" class="thumb-url"></a>';
		$output .= '<div class="bottom-gradient"></div>';
		$output .= '</div>';
		$output .= '<div class="thumb-text-holder">';
		$output .= '<h2 class="thumb-entry-title">';
		$output .= '<a href="'. esc_url( get_the_permalink() ). '">'. esc_html( get_the_title() ).'</a>';
		$output .= '</h2>';
		$output .= '</div>';
		$output .= '</article>';
		$output .= '</div>';

		return $output;
	}

	/**
	 * Render Block Title.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render_block_header() {
		$settings = $this->get_settings_for_display();

		if ( ! empty( $settings['block_title'] ) || ! empty( $settings['cat'] ) ) {

			$output  = '<div class="section-title-wrap">';

			if ( ! empty( $settings['block_title'] ) ) {
				$output .= '<h3 class="section-title">'. wp_kses_post( $settings['block_title'] ) .'</h3>';
			}

			if ( ! empty( $settings['cat'] ) ) {
				$output .= self::render_filter_items( $settings );
			}

			$output .= '</div><!--#block header-->';

			return $output;
		}
	}

	protected function render_filter_items( $settings ) {

		if ( empty( $settings['cat'] ) || ! isset( $settings['cat'] ) ) {
			return;
		}

		$cat_list = $settings['cat'];

		$ajax_filter_data = $this->_filter_list( $cat_list );

		$filter_html = '<div class="tabs tab-post__tabs ajax-filter-tab"><ul class="tabs__list tabs__filter_list">';

		foreach( $ajax_filter_data as $item ) {

			$active_class = '';

			if ( $item['id'] == 0 ) {
				$active_class = 'tabs__item--active';
			}

			$filter_html .='<li class="tabs__item block-filter-link"><a href="#" class="'. $active_class .' tabs__trigger block-link block-filter-link" data-ajax_filter_val="' . esc_attr( $item['id'] ) . '">'.esc_html( $item['name'] ).'</a></li>';
		}

		$filter_html .= '</ul></div>';

		return $filter_html;
	}

	protected function _filter_list( $cat_list = '' ) {

		$filter_list = array();

		$filter_list[0] = array(
			'id'   => 0,
			'name' => esc_html__( 'ALL', 'deo-elementor' )
		);

		$categories = get_categories( array(
			'include' => $cat_list,
			'exclude' => '1',
			'number'  => 50,
		) );

		//check category input
		if ( ! empty( $cat_list ) ) {

			foreach ( $cat_list as $cat ) {
				foreach ( $categories as $category ) {
					if ( $cat == $category->slug ) {
						$filter_list[] = array(
							'id'   => $category->cat_ID,
							'name' => $category->name
						);
					}
				}
			}
		} else {
			foreach ( $categories as $categories_el ) {
				$filter_list[] = array(
					'id'   => $categories_el->cat_ID,
					'name' => $categories_el->name
				);
			}
		}

		return $filter_list;
	}

	/**
	 * Render image of post type.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function renderImage() {
		$settings = $this->get_settings_for_display(); ?>

		<div class="thumb-bg-holder entry__bg-img-holder" <?php if ( has_post_thumbnail() ) : ?>style="background-image: url('<?php the_post_thumbnail_url(); ?>')" <?php endif; ?> >
			<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" class="thumb-url"></a>
			<div class="bottom-gradient"></div>
		</div>
		<?php
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
}