<?php
namespace DeoThemes\Widgets;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly.

class Deo_Widget_Newsletter extends \Elementor\Widget_Base {

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
		return 'deo-newsletter';
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
		return __( 'Deo Newsletter', 'deo-elementor' );
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
		return 'eicon-email-field';
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
		$this->section_content();

		$this->section_title_style();
	}


	/**
	* Content > Content.
	*/
	private function section_content() {
		$this->start_controls_section(
			'section_content',
			[
				'label' => __( 'Content Options', 'deo-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'widget_title', [
				'label' => __( 'Widget Title', 'deo-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Stay up to date' , 'deo-elementor' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'newsletter_shortcode', [
				'label' => __( 'Newsletter Shortcode', 'deo-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => '[mc4wp_form id="29"]',
				'description' => sprintf( esc_html__( 'Paste newsletter shortcode here. You can edit your sign-up form in the %1$s MailChimp for WordPress form settings.%2$s', 'deo-elementor' ), '<a href="' . site_url() . '/wp-admin/admin.php?page=mailchimp-for-wp-forms" target="_blank">', '</a>' ),
				'dynamic' => [
					'active' => true,
				],
				'default' => '[mc4wp_form id="29"]',
				'label_block' => true,
				'separator' => 'before'
			]
		);

		$this->end_controls_section();
	}

	/**
	* Style > Widget Title.
	*/
	private function section_title_style() {
		$this->start_controls_section(
			'section_title_style',
			[
				'label'     => __( 'Widget Title', 'deo-elementor' ),
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
					'{{WRAPPER}} .widget-title' => 'color: {{VALUE}};',
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
				'selector' => '{{WRAPPER}} .widget-title',
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
		$this->add_render_attribute( 'widget_title', 'class', [ 'widget-title', 'newsletter-wide__title' ] );
		$this->add_inline_editing_attributes( 'widget_title' );
		$shortcode = do_shortcode( shortcode_unautop( $settings['newsletter_shortcode'] ) );

		?>

			<div class="newsletter-wide widget widget_mc4wp_form_widget">

				<?php if ( $settings['widget_title'] ) : ?>
					<div class="newsletter-wide__text">
						<h4 <?php echo $this->get_render_attribute_string( 'widget_title' ); ?>><?php echo esc_html( $settings['widget_title'] ); ?></h4>
					</div>
				<?php endif; ?>

				<?php if ( $settings['newsletter_shortcode'] ) : ?>
					<div class="newsletter-wide__form"><?php echo $shortcode; ?></div>
				<?php endif; ?>

			</div>
		<?php
	}



}