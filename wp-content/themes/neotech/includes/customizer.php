<?php
/**
 * Theme Customizer
 *
 * @package Neotech
 */

function deo_customize_register( $wp_customize ) {

	// Customize Background Settings
	$wp_customize->get_section('background_image')->title = esc_html__('Background Styles', 'neotech');
	$wp_customize->get_control('background_color')->section = 'background_image';

	// Footer Copyright
	$wp_customize->add_setting( 'deo_footer_bottom_text', array(
		'capability' => 'edit_theme_options',
		'default' => sprintf(esc_html__( 'Neotech, made by %1$sDeoThemes%2$s' , 'neotech' ),
		'<a href="https://deothemes.com">',
		'</a>'),
		'sanitize_callback' => 'deo_sanitize_html',
	 ) );

	$wp_customize->add_control( 'deo_footer_bottom_text', array(
		'type'        => 'text',
		'section'     => 'deo_footer',
		'label'       => esc_html__( 'Footer bottom text', 'neotech' ),
		'description' => esc_html__( 'Allowed HTML: a, span, i, em, strong', 'neotech' ),
		'priority'    => 30,
	) );

	// Remove Custom Header Section
	$wp_customize->remove_section('header_image');
	$wp_customize->remove_section('colors');
}
add_action( 'customize_register', 'deo_customize_register' );

// Check if Kirki is installed
if ( class_exists( 'Kirki' ) ) {

	// Selector Vars
	$selector = array(
		'main_color'            =>
			'a,
			.loader,
			.nav__menu > .active > a,
			.nav__menu > li > a:hover,
			.nav__dropdown-menu > li > a:hover,
			.nav__dropdown-menu > li > a:focus,
			.entry__meta a:hover,
			.entry__meta a:focus,
			.entry__meta-category,
			h1 > a:hover,
			h1 > a:focus,
			h2 > a:hover,
			h2 > a:focus,
			h3 > a:hover,
			h3 > a:focus,
			h4 > a:hover,
			h4 > a:focus,
			h5 > a:hover,
			h5 > a:focus,
			h6 > a:hover,
			h6 > a:focus,
			.tab-post__tabs .tabs__item .is-active,
			.tab-post__tabs .tabs__item .tabs__item--active,
			.widget-popular-posts__entry-title a:hover,
			.widget_recent_entries a:hover,
			.widget_recent_comments a:hover,
			.widget_nav_menu a:hover,
			.widget_archive a:hover,
			.widget_pages a:hover,
			.widget_categories a:hover,
			.widget_meta a:hover,
			.tab-post__tabs .tabs__item a:hover,
			.tab-post__tabs .tabs__item a:focus,
			.entry__title:hover a,
			.featured-posts-slider__entry-title:hover a,
			.entry-author__name:hover,
			.related-posts__entry-title:hover a,
			.comment-edit-link,
			.post-list-small__entry:hover .post-list-small__entry-title,
			.video-playlist__list-item:hover .video-playlist__list-item-title,
			.flickity-prev-next-button:hover,
			.socials--nobase a:hover,
			.socials--nobase a:focus,
			.nav__right a:hover,
			.nav__right a:focus,
			.highlight,
			.breadcrumbs a:hover,
			.footer .widget.widget_calendar a,
			.copyright a:hover,
			.copyright a:focus',

		'post_links_color' => '.entry__article a:not(.wp-block-button__link)',
		'main_background_color' =>
			'.btn--color,
			.btn--button:focus,
			.nav__menu > li > a:after,
			.post-password-form label + input,
			#back-to-top:hover,
			.widget_tag_cloud a:hover,
			.page-numbers.current,
			.page-numbers:not(span):hover,
			.entry__meta-category--label,
			.entry__meta-category-holder .entry__meta-category,
			.widget-popular-posts__number
			',
		'main_border_color' => 'input:focus, textarea:focus',
		'main_border_top_color' => '.elementor-widget-tabs .elementor-tab-title.elementor-active, .carousel-thumbs .carousel-cell.is-selected .carousel-thumbs__item',
		'headings_color'  =>
			'h1,h2,h3,h4,h5,h6,
			.widget-upcoming-icos span,
			.sidebar .widget_mc4wp_form_widget .widget-title,
			.widget-popular-posts__entry-title a,
			label',
		'text_color'  =>
			'body,
			.deo-newsletter-gdpr-checkbox__label,
			.widget_tag_cloud a',
		'meta_color' => '.entry__meta li, .entry__meta a, .entry-author__website',
		'headings'        => 'h1,h2,h3,h4,h5,h6',
		'h1'              => 'h1',
		'h2'              => 'h2',
		'h3'              => 'h3',
		'h4'              => 'h4',
		'h5'              => 'h5',
		'h6'              => 'h6',
		'text'            => 'body, .copyright'
	);

	// Kirki
	Kirki::add_config( 'deo_config', array(
		'capability'    => 'edit_theme_options',
		'option_type'   => 'theme_mod',
		'option_name'   => 'deo_config'
	) );

	/**
	* SECTIONS / PANELS
	**/

	$priority = 20;

	// Preloader
	Kirki::add_section( 'deo_preloader', array(
		'title'          => esc_html__( 'Preloader', 'neotech' ),
		'description'    => esc_html__( 'Theme Preloader Options', 'neotech' ),
		'priority'       => $priority++,
		'capability'     => 'edit_theme_options',
	) );

	// Navigation
	Kirki::add_section( 'deo_navigation', array(
		'title'          => esc_html__( 'Navigation', 'neotech' ),
		'description'    => esc_html__( 'Navigation options', 'neotech' ),
		'priority'       => $priority++,
		'capability'     => 'edit_theme_options',
	) );

	// Blog PANEL
	Kirki::add_panel( 'deo_blog', array(
		'title'       => esc_attr__( 'Blog', 'neotech' ),
		'priority'    => $priority++,
	) );

			// Post Meta
			Kirki::add_section( 'deo_post_meta', array(
				'title'          => esc_html__( 'Post Meta', 'neotech' ),
				'description'    => esc_html__( 'These options will apply to the default WordPress posts. Customize Elementor widgets post meta via Elementor.', 'neotech' ),
				'panel'          => 'deo_blog',
				'capability'     => 'edit_theme_options',
			) );

			// Single Post
			Kirki::add_section( 'deo_single_post', array(
				'title'          => esc_html__( 'Single Post', 'neotech' ),
				'panel'          => 'deo_blog',
				'capability'     => 'edit_theme_options',
			) );

			// Socials Share
			Kirki::add_section( 'deo_socials_share', array(
				'title'          => esc_html__( 'Socials Share Icons', 'neotech' ),
				'panel'          => 'deo_blog',
				'capability'     => 'edit_theme_options',
			) );

			// Archives
			Kirki::add_section( 'deo_archives', array(
				'title'          => esc_html__( 'Archives', 'neotech' ),
				'panel'          => 'deo_blog',
				'capability'     => 'edit_theme_options',
			) );


	// Layout PANEL
	Kirki::add_panel( 'deo_layout', array(
		'title'          => esc_html__( 'Layout', 'neotech' ),
		'priority'       => $priority++,
	) );

		// Blog Layout
		Kirki::add_section( 'deo_blog_layout', array(
			'title'          => esc_html__( 'Blog', 'neotech' ),
			'description'    => esc_html__( 'Layout options for the blog pages', 'neotech' ),
			'panel'			 => 'deo_layout',
			'capability'     => 'edit_theme_options',
		) );

		// Page Layout
		Kirki::add_section( 'deo_page_layout', array(
			'title'          => esc_html__( 'Page', 'neotech' ),
			'description'    => esc_html__( 'Layout options for the regular pages', 'neotech' ),
			'panel'			 => 'deo_layout',
			'capability'     => 'edit_theme_options',
		) );

		// Archives Layout
		Kirki::add_section( 'deo_archives_layout', array(
			'title'          => esc_html__( 'Archives', 'neotech' ),
			'description'    => esc_html__( 'Layout options for archives and categories pages', 'neotech' ),
			'panel'			 => 'deo_layout',
			'capability'     => 'edit_theme_options',
		) );


	// Colors PANEL
	Kirki::add_panel( 'deo_colors', array(
		'title'          => esc_html__( 'Colors', 'neotech' ),
		'priority'       => $priority++,
	) );

		// General Colors
		Kirki::add_section( 'deo_general_colors', array(
			'title'          => esc_html__( 'General Colors', 'neotech' ),
			'panel'			 => 'deo_colors',
		) );

		// Navigation Colors
		Kirki::add_section( 'deo_navigation_colors', array(
			'title'          => esc_html__( 'Navigation Colors', 'neotech' ),
			'panel'			 => 'deo_colors',
		) );

		// Blog Colors
		Kirki::add_section( 'deo_blog_colors', array(
			'title'          => esc_html__( 'Blog Colors', 'neotech' ),
			'panel'			 => 'deo_colors',
		) );

		// Text Colors
		Kirki::add_section( 'deo_text_colors', array(
			'title'          => esc_html__( 'Text Colors', 'neotech' ),
			'panel'			 => 'deo_colors',
		) );

		// Footer Colors
		Kirki::add_section( 'deo_footer_colors', array(
			'title'          => esc_html__( 'Footer Colors', 'neotech' ),
			'panel'			 => 'deo_colors',
		) );

	// Typography
	Kirki::add_section( 'deo_typography', array(
		'title'          => esc_html__( 'Typography', 'neotech' ),
		'priority'       => $priority++,
		'capability'     => 'edit_theme_options',
	) );

	// Socials
	Kirki::add_section( 'deo_socials', array(
		'title'          => esc_html__( 'Socials', 'neotech' ),
		'description'    => esc_html__( 'Socials options. Paste your social profile links here', 'neotech'  ),
		'priority'       => $priority++,
		'capability'     => 'edit_theme_options',
	) );

	// Breadcrumbs
	Kirki::add_section( 'deo_breadcrumbs', array(
		'title'          => esc_html__( 'Breadcrumbs', 'neotech' ),
		'description'    => esc_html__( 'Breadcrumbs options.', 'neotech'  ),
		'priority'       => $priority++,
		'capability'     => 'edit_theme_options',
	) );

	// GDPR
	Kirki::add_section( 'deo_gdpr', array(
		'title'          => esc_html__( 'GDPR', 'neotech' ),
		'description'    => esc_html__( 'Settings for GDPR compliance.', 'neotech'  ),
		'priority'       => $priority++,
		'capability'     => 'edit_theme_options',
	) );

	// Footer
	Kirki::add_section( 'deo_footer', array(
		'title'          => esc_html__( 'Footer', 'neotech' ),
		'description'    => esc_html__( 'Footer options', 'neotech' ),
		'priority'       => $priority++,
		'capability'     => 'edit_theme_options',
	) );
	

	/**
	* CONTROLS
	**/

	// Logo Image Upload
	Kirki::add_field( 'deo_config', array(
		'type'        => 'image',
		'settings'    => 'deo_logo_image_upload',
		'label'       => esc_attr__( 'Upload Logo', 'neotech' ),
		'section'     => 'title_tagline',
		'default'     => get_template_directory_uri() . '/assets/img/logo_light.png',
	) );

	// Logo Retina Image Upload
	Kirki::add_field( 'deo_config', array(
		'type'        => 'image',
		'settings'    => 'deo_logo_retina_image_upload',
		'label'       => esc_attr__( 'Upload Retina Logo', 'neotech' ),
		'description' => esc_html__( 'Logo 2x bigger size', 'neotech' ),
		'section'     => 'title_tagline',
		'default'     => get_template_directory_uri() . '/assets/img/logo_light@2x.png',
	) );

	// Preloader
	Kirki::add_field( 'deo_config', array(
		'type'        => 'switch',
		'settings'    => 'deo_preloader_settings',
		'label'       => esc_html__( 'Enable/Disable Theme Preloader', 'neotech' ),
		'section'     => 'deo_preloader',
		'default'     => false,
		'choices'     => array(
			'on'   => esc_attr__( 'On', 'neotech' ),
			'off' => esc_attr__( 'Off', 'neotech' ),
		),
	) );

	/**
	* Navigation
	*/

	// Sticky nav
	Kirki::add_field( 'deo_config', array(
		'type'        => 'switch',
		'settings'    => 'deo_sticky_nav_show',
		'label'       => esc_html__( 'Sticky Navbar', 'neotech' ),
		'description' => esc_html__( 'Will apply only on big screens', 'neotech' ),
		'section'     => 'deo_navigation',
		'default'     => 1,
		'choices'     => array(
			'on'   => esc_attr__( 'On', 'neotech' ),
			'off' => esc_attr__( 'Off', 'neotech' ),
		),
	) );

	// Header height
	Kirki::add_field( 'deo_config', array(
		'type'        => 'slider',
		'settings'    => 'deo_header_height',
		'label'       => esc_attr__( 'Header height', 'neotech' ),
		'description' => esc_html__( 'Will apply only on big screens', 'neotech' ),
		'section'     => 'deo_navigation',
		'default'     => 50,
		'choices'     => array(
			'min'  => '40',
			'max'  => '200',
			'step' => '1',
		),
		'output'       => array(
			array(
				'element'     => '.nav, .nav__flex-parent, .nav--sticky, .nav--sticky.sticky',
				'property'    => 'height',
				'units'       => 'px',
				'media_query' => '@media (min-width: 992px)',
			),
			array(
				'element'     => '.nav',
				'property'    => 'min-height',
				'units'       => 'px',
				'media_query' => '@media (min-width: 992px)',
			),
			array(
				'element'     => '.nav__menu > li > a',
				'property'    => 'line-height',
				'units'       => 'px',
				'media_query' => '@media (min-width: 992px)',
			),
		),
		'transport' => 'auto',
	) );

	// Logo height
	Kirki::add_field( 'deo_config', array(
		'type'        => 'slider',
		'settings'    => 'deo_header_logo_height',
		'label'       => esc_attr__( 'Header logo height', 'neotech' ),
		'section'     => 'deo_navigation',
		'default'     => 48,
		'choices'     => array(
			'min'  => '10',
			'max'  => '200',
			'step' => '1',
		),
		'output'       => array(
			array(
				'element'     => '.nav__holder .logo__img',
				'property'    => 'max-height',
				'units'       => 'px',
			),
		),
		'transport' => 'auto',
	) );

	// Show nav socials
	Kirki::add_field( 'deo_config', array(
		'type'        => 'switch',
		'settings'    => 'deo_nav_socials_show',
		'label'       => esc_html__( 'Show socials in the navbar', 'neotech' ),
		'section'     => 'deo_navigation',
		'default'     => true,
		'choices'     => array(
			'on'   => esc_attr__( 'On', 'neotech' ),
			'off' => esc_attr__( 'Off', 'neotech' ),
		),
	) );

	// Show nav search
	Kirki::add_field( 'deo_config', array(
		'type'        => 'switch',
		'settings'    => 'deo_nav_search_show',
		'label'       => esc_html__( 'Show search in the navbar', 'neotech' ),
		'section'     => 'deo_navigation',
		'default'     => true,
		'choices'     => array(
			'on'   => esc_attr__( 'On', 'neotech' ),
			'off' => esc_attr__( 'Off', 'neotech' ),
		),
	) );

	// Show back to top
	Kirki::add_field( 'deo_config', array(
		'type'        => 'switch',
		'settings'    => 'deo_back_to_top_show',
		'label'       => esc_html__( 'Show back to top arrow', 'neotech' ),
		'section'     => 'deo_navigation',
		'default'     => true,
		'choices'     => array(
			'on'   => esc_attr__( 'On', 'neotech' ),
			'off' => esc_attr__( 'Off', 'neotech' ),
		),
	) );


	/**
	* Blog
	*/

	// Meta category
	Kirki::add_field( 'deo_config', array(
		'type'        => 'switch',
		'settings'    => 'deo_meta_category_show',
		'label'       => esc_attr__( 'Show meta category', 'neotech' ),
		'section'     => 'deo_post_meta',
		'default'     => 1,
		'choices'     => array(
			'on'   => esc_attr__( 'On', 'neotech' ),
			'off' => esc_attr__( 'Off', 'neotech' ),
		),
	) );

	// Meta date
	Kirki::add_field( 'deo_config', array(
		'type'        => 'switch',
		'settings'    => 'deo_meta_date_show',
		'label'       => esc_attr__( 'Show meta date', 'neotech' ),
		'section'     => 'deo_post_meta',
		'default'     => 1,
		'choices'     => array(
			'on'   => esc_attr__( 'On', 'neotech' ),
			'off' => esc_attr__( 'Off', 'neotech' ),
		),
	) );

	// Meta time
	Kirki::add_field( 'deo_config', array(
		'type'        => 'switch',
		'settings'    => 'deo_meta_time_show',
		'label'       => esc_attr__( 'Show meta time', 'neotech' ),
		'section'     => 'deo_post_meta',
		'default'     => false,
		'choices'     => array(
			'on'   => esc_attr__( 'On', 'neotech' ),
			'off' => esc_attr__( 'Off', 'neotech' ),
		),
	) );

	// Meta author
	Kirki::add_field( 'deo_config', array(
		'type'        => 'switch',
		'settings'    => 'deo_meta_author_show',
		'label'       => esc_attr__( 'Show meta author', 'neotech' ),
		'section'     => 'deo_post_meta',
		'default'     => 1,
		'choices'     => array(
			'on'   => esc_attr__( 'On', 'neotech' ),
			'off' => esc_attr__( 'Off', 'neotech' ),
		),
	) );

	// Meta views
	Kirki::add_field( 'deo_config', array(
		'type'        => 'switch',
		'settings'    => 'deo_meta_views_show',
		'label'       => esc_attr__( 'Show meta views', 'neotech' ),
		'description'	=> esc_attr__( 'Shows in single post only', 'neotech' ),
		'section'     => 'deo_post_meta',
		'default'     => 1,
		'choices'     => array(
			'on'   => esc_attr__( 'On', 'neotech' ),
			'off' => esc_attr__( 'Off', 'neotech' ),
		),
	) );

	// Meta reading time
	Kirki::add_field( 'deo_config', array(
		'type'        => 'switch',
		'settings'    => 'deo_meta_reading_time_show',
		'label'       => esc_attr__( 'Show reading time', 'neotech' ),
		'description'	=> esc_attr__( 'Shows in single post only', 'neotech' ),
		'section'     => 'deo_post_meta',
		'default'     => 1,
		'choices'     => array(
			'on'   => esc_attr__( 'On', 'neotech' ),
			'off' => esc_attr__( 'Off', 'neotech' ),
		),
	) );

	// Post excerpt
	Kirki::add_field( 'deo_config', array(
		'type'        => 'switch',
		'settings'    => 'deo_post_excerpt_show',
		'label'       => esc_attr__( 'Show post excerpt', 'neotech' ),
		'section'     => 'deo_post_meta',
		'default'     => 1,
		'choices'     => array(
			'on'   => esc_attr__( 'On', 'neotech' ),
			'off' => esc_attr__( 'Off', 'neotech' ),
		),
	) );

	// Featured Image
	Kirki::add_field( 'deo_config', array(
		'type'        => 'switch',
		'settings'    => 'deo_post_featured_image_show',
		'label'       => esc_attr__( 'Show Featured Image', 'neotech' ),
		'section'     => 'deo_single_post',
		'default'     => true,
		'choices'     => array(
			'on'   => esc_attr__( 'On', 'neotech' ),
			'off' => esc_attr__( 'Off', 'neotech' ),
		),
	) );

	// Post tags
	Kirki::add_field( 'deo_config', array(
		'type'        => 'switch',
		'settings'    => 'deo_post_tags_show',
		'label'       => esc_attr__( 'Show tags', 'neotech' ),
		'section'     => 'deo_single_post',
		'default'     => true,
		'choices'     => array(
			'on'   => esc_attr__( 'On', 'neotech' ),
			'off' => esc_attr__( 'Off', 'neotech' ),
		),
	) );

	// Sticky Sidebar
	Kirki::add_field( 'deo_config', array(
		'type'        => 'switch',
		'settings'    => 'deo_sticky_sidebar',
		'label'       => esc_attr__( 'Sticky sidebar', 'neotech' ),
		'section'     => 'deo_single_post',
		'default'     => true,
		'choices'     => array(
			'on'   => esc_attr__( 'On', 'neotech' ),
			'off' => esc_attr__( 'Off', 'neotech' ),
		),
	) );

	// Previous / Next post pagination
	Kirki::add_field( 'deo_config', array(
		'type'        => 'switch',
		'settings'    => 'deo_prev_next_post_pagination_show',
		'label'       => esc_attr__( 'Show prev/next post pagination', 'neotech' ),
		'section'     => 'deo_single_post',
		'default'     => true,
		'choices'     => array(
			'on'   => esc_attr__( 'On', 'neotech' ),
			'off' => esc_attr__( 'Off', 'neotech' ),
		),
	) );

	// Author box
	Kirki::add_field( 'deo_config', array(
		'type'        => 'switch',
		'settings'    => 'deo_author_box_show',
		'label'       => esc_attr__( 'Author box', 'neotech' ),
		'section'     => 'deo_single_post',
		'default'     => true,
		'choices'     => array(
			'on'   => esc_attr__( 'On', 'neotech' ),
			'off' => esc_attr__( 'Off', 'neotech' ),
		),
	) );    

	// Related posts
	Kirki::add_field( 'deo_config', array(
		'type'        => 'switch',
		'settings'    => 'deo_related_posts_show',
		'label'       => esc_attr__( 'Show related posts', 'neotech' ),
		'section'     => 'deo_single_post',
		'default'     => true,
		'choices'     => array(
			'on'   => esc_attr__( 'On', 'neotech' ),
			'off' => esc_attr__( 'Off', 'neotech' ),
		),
	) );

	// Related by
	Kirki::add_field( 'deo_config', array(
		'type'        => 'select',
		'settings'    => 'deo_related_posts_relation',
		'label'       => esc_html__( 'Related by', 'neotech' ),
		'section'     => 'deo_single_post',
		'default'     => 'category',
		'choices'     => array(
			'category' => esc_attr__( 'Category', 'neotech' ),
			'tag' => esc_attr__( 'Tag', 'neotech' ),
			'author' => esc_attr__( 'Author', 'neotech' ),
		),
	) );

	// Socials Share Icons
	Kirki::add_field( 'deo_config', array(
		'type'        => 'switch',
		'settings'    => 'deo_post_share_icons_show',
		'label'       => esc_attr__( 'Show share icons', 'neotech' ),
		'section'     => 'deo_socials_share',
		'default'     => 1,
		'choices'     => array(
			'on'   => esc_attr__( 'On', 'neotech' ),
			'off' => esc_attr__( 'Off', 'neotech' ),
		),
	) );

	// Facebook Share
	Kirki::add_field( 'deo_config', array(
		'type'        => 'checkbox',
		'settings'    => 'deo_share_facebook',
		'label'       => esc_attr__( 'Facebook', 'neotech' ),
		'section'     => 'deo_socials_share',
		'default'     => true,
	) );

	// Twitter Share
	Kirki::add_field( 'deo_config', array(
		'type'        => 'checkbox',
		'settings'    => 'deo_share_twitter',
		'label'       => esc_attr__( 'Twitter', 'neotech' ),
		'section'     => 'deo_socials_share',
		'default'     => true,
	) );

	// Linkedin Share
	Kirki::add_field( 'deo_config', array(
		'type'        => 'checkbox',
		'settings'    => 'deo_share_linkedin',
		'label'       => esc_attr__( 'Linkedin', 'neotech' ),
		'section'     => 'deo_socials_share',
		'default'     => true,
	) );

	// Pinterest Share
	Kirki::add_field( 'deo_config', array(
		'type'        => 'checkbox',
		'settings'    => 'deo_share_pinterest',
		'label'       => esc_attr__( 'Pinterest', 'neotech' ),
		'section'     => 'deo_socials_share',
		'default'     => true,
	) );

	// Vkontakte Share
	Kirki::add_field( 'deo_config', array(
		'type'        => 'checkbox',
		'settings'    => 'deo_share_vkontakte',
		'label'       => esc_attr__( 'Vkontakte', 'neotech' ),
		'section'     => 'deo_socials_share',
		'default'     => false,
	) );

	// Pocket Share
	Kirki::add_field( 'deo_config', array(
		'type'        => 'checkbox',
		'settings'    => 'deo_share_pocket',
		'label'       => esc_attr__( 'Pocket', 'neotech' ),
		'section'     => 'deo_socials_share',
		'default'     => true,
	) );

	// Facebook Messenger Share
	Kirki::add_field( 'deo_config', array(
		'type'        => 'checkbox',
		'settings'    => 'deo_share_facebook_messenger',
		'label'       => esc_attr__( 'Facebook Messenger', 'neotech' ),
		'section'     => 'deo_socials_share',
		'default'     => false,
	) );

	// Whatsapp Share
	Kirki::add_field( 'deo_config', array(
		'type'        => 'checkbox',
		'settings'    => 'deo_share_whatsapp',
		'label'       => esc_attr__( 'Whatsapp', 'neotech' ),
		'section'     => 'deo_socials_share',
		'default'     => true,
	) );

	// Viber Share
	Kirki::add_field( 'deo_config', array(
		'type'        => 'checkbox',
		'settings'    => 'deo_share_viber',
		'label'       => esc_attr__( 'Viber', 'neotech' ),
		'section'     => 'deo_socials_share',
		'default'     => false,
	) );

	// Telegram Share
	Kirki::add_field( 'deo_config', array(
		'type'        => 'checkbox',
		'settings'    => 'deo_share_telegram',
		'label'       => esc_attr__( 'Telegram', 'neotech' ),
		'section'     => 'deo_socials_share',
		'default'     => false,
	) );

	// Line Share
	Kirki::add_field( 'deo_config', array(
		'type'        => 'checkbox',
		'settings'    => 'deo_share_line',
		'label'       => esc_attr__( 'Line', 'neotech' ),
		'section'     => 'deo_socials_share',
		'default'     => false,
	) );

	// Reddit Share
	Kirki::add_field( 'deo_config', array(
		'type'        => 'checkbox',
		'settings'    => 'deo_share_reddit',
		'label'       => esc_attr__( 'Reddit', 'neotech' ),
		'section'     => 'deo_socials_share',
		'default'     => false,
	) );

	// Email Share
	Kirki::add_field( 'deo_config', array(
		'type'        => 'checkbox',
		'settings'    => 'deo_share_email',
		'label'       => esc_attr__( 'Email', 'neotech' ),
		'section'     => 'deo_socials_share',
		'default'     => true,
	) );


	/**
	* Layout
	*/

	// Blog Layout
	Kirki::add_field( 'deo_config', array(
		'type'        => 'radio-image',
		'settings'    => 'deo_blog_layout_type',
		'label'       => esc_html__( 'Layout type', 'neotech' ),
		'section'     => 'deo_blog_layout',
		'default'     => 'right-sidebar',
		'choices'     => array(
			'left-sidebar'   => get_template_directory_uri() . '/assets/img/customizer/left-sidebar.png',
			'right-sidebar' => get_template_directory_uri() . '/assets/img/customizer/right-sidebar.png',
			'fullwidth'  => get_template_directory_uri() . '/assets/img/customizer/fullwidth.png',
		),
	) );

	// Blog columns
	Kirki::add_field( 'deo_config', array(
		'type'        => 'select',
		'settings'    => 'deo_blog_columns',
		'label'       => esc_html__( 'Columns', 'neotech' ),
		'section'     => 'deo_blog_layout',
		'default'     => 'col-md-6',
		'choices'     => array(
			'col-md-12' => esc_attr__( '1 Column', 'neotech' ),
			'col-md-6' => esc_attr__( '2 Columns', 'neotech' ),
			'col-md-4' => esc_attr__( '3 Columns', 'neotech' ),
			'col-md-3' => esc_attr__( '4 Columns', 'neotech' ),
		),
	) );


	// Page Layout
	Kirki::add_field( 'deo_config', array(
		'type'        => 'radio-image',
		'settings'    => 'deo_page_layout_type',
		'label'       => esc_html__( 'Layout type', 'neotech' ),
		'section'     => 'deo_page_layout',
		'default'     => 'right-sidebar',
		'choices'     => array(
			'left-sidebar'   => get_template_directory_uri() . '/assets/img/customizer/left-sidebar.png',
			'right-sidebar' => get_template_directory_uri() . '/assets/img/customizer/right-sidebar.png',
			'fullwidth'  => get_template_directory_uri() . '/assets/img/customizer/fullwidth.png',
		),
	) );

	// Archives Layout
	Kirki::add_field( 'deo_config', array(
		'type'        => 'radio-image',
		'settings'    => 'deo_archives_layout_type',
		'label'       => esc_html__( 'Layout type', 'neotech' ),
		'section'     => 'deo_archives_layout',
		'default'     => 'right-sidebar',
		'choices'     => array(
			'left-sidebar'   => get_template_directory_uri() . '/assets/img/customizer/left-sidebar.png',
			'right-sidebar' => get_template_directory_uri() . '/assets/img/customizer/right-sidebar.png',
			'fullwidth'  => get_template_directory_uri() . '/assets/img/customizer/fullwidth.png',
		),
	) );

	// Archives columns
	Kirki::add_field( 'deo_config', array(
		'type'        => 'select',
		'settings'    => 'deo_archives_columns',
		'label'       => esc_html__( 'Columns', 'neotech' ),
		'section'     => 'deo_archives_layout',
		'default'     => 'col-md-6',
		'choices'     => array(
			'col-md-12' => esc_attr__( '1 Column', 'neotech' ),
			'col-md-6' => esc_attr__( '2 Columns', 'neotech' ),
			'col-md-4' => esc_attr__( '3 Columns', 'neotech' ),
			'col-md-3' => esc_attr__( '4 Columns', 'neotech' ),
		),
	) );
	

	/**
	* Colors
	*/

	/* General Colors */

	// Main color
	Kirki::add_field( 'deo_config', array(
		'type'        => 'color',
		'settings'    => 'deo_main_color',
		'label'       => esc_html__( 'Main primary color of a theme', 'neotech' ),
		'description'   => esc_html__( 'Some buttons can be customized with Elementor instead', 'neotech' ),
		'section'     => 'deo_general_colors',
		'default'     => '#E12A21',
		'output' => array(
			array(
				'element'  => $selector['main_color'],
				'property' => 'color',
			),
			array(
				'element' => $selector['main_background_color'],
				'property' => 'background-color',
			),
			array(
				'element' => $selector['main_border_color'],
				'property' => 'border-color',
			),
			array(
				'element' => $selector['main_border_top_color'],
				'property' => 'border-top-color',
			),
		),
		'transport' => 'auto',
	) );

	// Button gradient first color
	Kirki::add_field( 'deo_config', array(
		'type'        => 'color',
		'settings'    => 'deo_buttons_gradient_first_color',
		'label'       => esc_html__( 'Buttons gradient first color', 'neotech' ),
		'section'     => 'deo_general_colors',
		'default'     => '#FB4A64',
		'output'    => array(
			array(
				'element'         => '.btn-color',
				'property'        => 'background',
				'value_pattern'   => 'linear-gradient(to right, $ 0%, secondColor 100%)',
				'pattern_replace' => array(
					'secondColor' => 'deo_buttons_gradient_second_color',
				),
			),
		),
		'transport' => 'auto',
	) );

	// Button gradient second color
	Kirki::add_field( 'deo_config', array(
		'type'        => 'color',
		'settings'    => 'deo_buttons_gradient_second_color',
		'label'       => esc_html__( 'Buttons gradient second color', 'neotech' ),
		'section'     => 'deo_general_colors',
		'default'     => '#F8875F',
		'output'    => array(
			array(
				'element'         => '.btn-color',
				'property'        => 'background',
				'value_pattern'   => 'linear-gradient(to right, firstColor 0%, $ 100%)',
				'pattern_replace' => array(
					'firstColor'    => 'deo_buttons_gradient_first_color',
				),
			),
		),
		'transport' => 'auto',
	) );


	/* Navigation Colors */

	// Navigation background color
	Kirki::add_field( 'deo_config', array(
		'type'        => 'color',
		'settings'    => 'deo_navigation_background_color',
		'label'       => esc_html__( 'Navigation background color', 'neotech' ),
		'section'     => 'deo_navigation_colors',
		'default'     => '#002B4D',
		'output' => array(
			array(
				'element'  => '.nav__holder',
				'property' => 'background-color',
			),
		),
		'transport' => 'auto',
	) );

	// Navigation links color
	Kirki::add_field( 'deo_config', array(
		'type'        => 'color',
		'settings'    => 'deo_navigation_links_color',
		'label'       => esc_html__( 'Navigation links color', 'neotech' ),
		'section'     => 'deo_navigation_colors',
		'default'     => '#ffffff',
		'output' => array(
			array(
				'element'  => '.nav__menu > li > a, .nav__socials a, .nav__subscribe, .nav__search-trigger, .sidenav__menu-link, .sidenav__menu--is-open > .sidenav__menu-toggle, .sidenav__menu-toggle',
				'property' => 'color',
			),
		),
		'transport' => 'auto',
	) );

	// Navigation dropdown background color
	Kirki::add_field( 'deo_config', array(
		'type'        => 'color',
		'settings'    => 'deo_navigation_dropdown_background_color',
		'label'       => esc_html__( 'Navigation dropdown background color', 'neotech' ),
		'section'     => 'deo_navigation_colors',
		'default'     => '#041726',
		'output' => array(
			array(
				'element'  => '.nav__dropdown-menu, .sidenav__menu-dropdown',
				'property' => 'background-color',
			),
		),
		'transport' => 'auto',
	) );

	// Navigation dropdown links color
	Kirki::add_field( 'deo_config', array(
		'type'        => 'color',
		'settings'    => 'deo_navigation_dropdown_links_color',
		'label'       => esc_html__( 'Navigation dropdown links color', 'neotech' ),
		'section'     => 'deo_navigation_colors',
		'default'     => '#adb4ba',
		'output' => array(
			array(
				'element'  => '.nav__dropdown-menu > li > a',
				'property' => 'color',
			),
		),
		'transport' => 'auto',
	) );

	// Navigation mobile sidebar background color
	Kirki::add_field( 'deo_config', array(
		'type'        => 'color',
		'settings'    => 'deo_navigation_mobile_sidebar_background_color',
		'label'       => esc_html__( 'Navigation mobile sidebar background color', 'neotech' ),
		'section'     => 'deo_navigation_colors',
		'default'     => '#041726',
		'output' => array(
			array(
				'element'  => '.sidenav',
				'property' => 'background-color',
			),
		),
		'transport' => 'auto',
	) );

	// Navigation mobile dropdown links color
	Kirki::add_field( 'deo_config', array(
		'type'        => 'color',
		'settings'    => 'deo_navigation_mobile_dropdown_links_color',
		'label'       => esc_html__( 'Navigation mobile dropdown links color', 'neotech' ),
		'section'     => 'deo_navigation_colors',
		'default'     => '#919BA3',
		'output' => array(
			array(
				'element'  => '.sidenav__menu-dropdown a',
				'property' => 'color',
			),
		),
		'transport' => 'auto',
	) );

	// Navigation mobile dropdown active background color
	Kirki::add_field( 'deo_config', array(
		'type'        => 'color',
		'settings'    => 'deo_navigation_mobile_dropdown_active_background_color',
		'label'       => esc_html__( 'Navigation mobile dropdown active background color', 'neotech' ),
		'section'     => 'deo_navigation_colors',
		'default'     => '#002B4D',
		'output' => array(
			array(
				'element'  => '.sidenav__menu--is-open > a',
				'property' => 'background-color',
			),
		),
		'transport' => 'auto',
	) );

	// Navigation mobile dropdown dividers color
	Kirki::add_field( 'deo_config', array(
		'type'        => 'color',
		'settings'    => 'deo_navigation_mobile_dropdown_dividers_color',
		'label'       => esc_html__( 'Navigation mobile dropdown dividers color', 'neotech' ),
		'section'     => 'deo_navigation_colors',
		'default'     => '#182835',
		'output' => array(
			array(
				'element'  => '.sidenav__menu li, .sidenav__search-mobile-input',
				'property' => 'border-color',
			),
		),
		'transport' => 'auto',
	) );

	// Navigation mobile search color
	Kirki::add_field( 'deo_config', array(
		'type'        => 'color',
		'settings'    => 'deo_navigation_mobile_search_color',
		'label'       => esc_html__( 'Navigation mobile search color', 'neotech' ),
		'section'     => 'deo_navigation_colors',
		'default'     => '#9AA3AB',
		'output' => array(
			array(
				'element'  => '.sidenav__search-mobile-submit, .sidenav__search-mobile-input',
				'property' => 'color',
			),
			array(
				'element'  => '.sidenav__search-mobile-form input::-webkit-input-placeholder',
				'property' => 'color',
			),
			array(
				'element'  => '.sidenav__search-mobile-form input:-moz-placeholder, .sidenav__search-mobile-form input::-moz-placeholder',
				'property' => 'color',
			),
			array(
				'element'  => '.sidenav__search-mobile-form input:-ms-input-placeholder',
				'property' => 'color',
			),
		),
		'transport' => 'auto',
	) );

	// Navigation mobile toggle color
	Kirki::add_field( 'deo_config', array(
		'type'        => 'color',
		'settings'    => 'deo_navigation_mobile_toggle_color',
		'label'       => esc_html__( 'Navigation mobile toggle color', 'neotech' ),
		'section'     => 'deo_navigation_colors',
		'default'     => '#ffffff',
		'output' => array(
			array(
				'element'  => '.nav-icon-toggle__inner, .nav-icon-toggle__inner:before, .nav-icon-toggle__inner:after',
				'property' => 'background-color',
			),
		),
		'transport' => 'auto',
	) );


	/* Blog Colors */

	// Post links color
	Kirki::add_field( 'deo_config', array(
		'type'        => 'color',
		'settings'    => 'deo_post_links_color',
		'label'       => esc_html__( 'Post links color', 'neotech' ),
		'section'     => 'deo_blog_colors',
		'default'     => '#4C86E7',
		'output' => array(
			array(
				'element'  => $selector['post_links_color'],
				'property' => 'color',
			),
			array(
				'element' => '.edit-post-visual-editor a, .editor-rich-text__tinymce a',
				'property' => 'color',
				'context' => array( 'editor' ),
			)
		),
		'transport' => 'auto',
	) );

	// Post Meta color
	Kirki::add_field( 'deo_config', array(
		'type'        => 'color',
		'settings'    => 'deo_meta_color',
		'label'       => esc_html__( 'Post meta color', 'neotech' ),
		'section'     => 'deo_blog_colors',
		'default'     => '#908E99',
		'output' => array(
			array(
				'element'  => $selector['meta_color'],
				'property' => 'color',
			),
		),
		'transport' => 'auto',
	) );

	// Breadcrumbs background color
	Kirki::add_field( 'deo_config', array(
		'type'        => 'color',
		'settings'    => 'deo_breadcrumbs_background_color',
		'label'       => esc_html__( 'Breadcrumbs background color', 'neotech' ),
		'section'     => 'deo_blog_colors',
		'default'     => '#f4f6f6',
		'output' => array(
			array(
				'element'  => '.breadcrumbs-wrap',
				'property' => 'background-color',
			),
		),
		'transport' => 'auto',
	) );



	/* Text Colors */

	// Headings color
	Kirki::add_field( 'deo_config', array(
		'type'        => 'color',
		'settings'    => 'deo_headings_color',
		'label'       => esc_html__( 'Headings color', 'neotech' ),
		'section'     => 'deo_text_colors',
		'default'     => '#3A444D',
		'output' => array(
			array(
				'element'  => $selector['headings_color'],
				'property' => 'color',
			),
			array(
				'element' => '.edit-post-visual-editor .editor-post-title__block .editor-post-title__input,
				.edit-post-visual-editor .wp-block[data-type="core/heading"] h1,
				.edit-post-visual-editor .wp-block[data-type="core/heading"] h2,
				.edit-post-visual-editor .wp-block[data-type="core/heading"] h3,
				.edit-post-visual-editor .wp-block[data-type="core/heading"] h4,
				.edit-post-visual-editor .wp-block[data-type="core/heading"] h5,
				.edit-post-visual-editor .wp-block[data-type="core/heading"] h6',
				'property' => 'color',
				'context' => array( 'editor' ),
			)
		),
		'transport' => 'auto',
	) );

	// Text color
	Kirki::add_field( 'deo_config', array(
		'type'        => 'color',
		'settings'    => 'deo_text_color',
		'label'       => esc_html__( 'Text color', 'neotech' ),
		'section'     => 'deo_text_colors',
		'default'     => '#49545E',
		'output' => array(
			array(
				'element'  => $selector['text_color'],
				'property' => 'color',
			),
			array(
				'element' => '.edit-post-visual-editor .block-editor-block-list__block,
				.edit-post-visual-editor .block-editor-block-list__block-edit,
				.edit-post-visual-editor',
				'property' => 'color',
				'context' => array( 'editor' ),
			)
		),
		'transport' => 'auto',
	) );
	

	/* Footer Colors */

	// Footer background color
	Kirki::add_field( 'deo_config', array(
		'type'        => 'color',
		'settings'    => 'deo_footer_background_color',
		'label'       => esc_html__( 'Footer background color', 'neotech' ),
		'section'     => 'deo_footer_colors',
		'default'     => '#002B4D',
		'output' => array(
			array(
				'element'  => '.footer',
				'property' => 'background-color',
			),
		),
		'transport' => 'auto',
	) );    

	// Footer dividers color
	Kirki::add_field( 'deo_config', array(
		'type'        => 'color',
		'settings'    => 'deo_footer_dividers_color',
		'label'       => esc_html__( 'Footer dividers color', 'neotech' ),
		'section'     => 'deo_footer_colors',
		'default'     => '#254054',
		'output' => array(
			array(
				'element'  => '.footer__widgets .widget_categories li,
				.footer__widgets .widget_recent_entries li,
				.footer__widgets .widget_nav_menu li,
				.footer__widgets .widget_archive li,
				.footer__widgets .widget_pages li,
				.footer__widgets .widget_meta li,
				.footer__widgets .widget .sub-menu li:first-child,
				.footer__widgets .widget .children li:first-child,
				.footer__widgets .widget_rss li,
				.footer__widgets .widget_tag_cloud a,
				.footer__widgets .widget_product_tag_cloud a,
				.footer__widgets .recentcomments',
				'property' => 'border-color',
			),
		),
		'transport' => 'auto',
	) );

	// Footer widget title color
	Kirki::add_field( 'deo_config', array(
		'type'        => 'color',
		'settings'    => 'deo_footer_widget_title_color',
		'label'       => esc_html__( 'Footer widget title color', 'neotech' ),
		'section'     => 'deo_footer_colors',
		'default'     => '#ffffff',
		'output' => array(
			array(
				'element'  => '.footer__widgets .widget-title',
				'property' => 'color',
			),
		),
		'transport' => 'auto',
	) );

	// Footer text color
	Kirki::add_field( 'deo_config', array(
		'type'        => 'color',
		'settings'    => 'deo_footer_text_color',
		'label'       => esc_html__( 'Footer text color', 'neotech' ),
		'section'     => 'deo_footer_colors',
		'default'     => '#ffffff',
		'output' => array(
			array(
				'element'  => '.footer__widgets p,
				.footer__widgets a:not(.social),
				.footer__widgets li,
				.footer__widgets #wp-calendar caption,
				.footer__widgets #wp-calendar a,
				.footer__widgets .widget_rss .rsswidget,
				.footer__widgets .widget_recent_comments .recentcomments a,
				.footer__widgets .deo-newsletter-gdpr-checkbox__label,
				.footer__widgets ul li a:hover',
				'property' => 'color',
			),
		),
		'transport' => 'auto',
	) );

	// Footer bottom background color
	Kirki::add_field( 'deo_config', array(
		'type'        => 'color',
		'settings'    => 'deo_footer_bottom_background_color',
		'label'       => esc_html__( 'Footer bottom background color', 'neotech' ),
		'section'     => 'deo_footer_colors',
		'default'     => '#041726',
		'output' => array(
			array(
				'element'  => '.footer__bottom',
				'property' => 'background-color',
			),
		),
		'transport' => 'auto',
	) );

	// Footer bottom text color
	Kirki::add_field( 'deo_config', array(
		'type'        => 'color',
		'settings'    => 'deo_footer_bottom_text_color',
		'label'       => esc_html__( 'Footer bottom text color', 'neotech' ),
		'section'     => 'deo_footer_colors',
		'default'     => '#9AA3AB',
		'output' => array(
			array(
				'element'  => '.copyright',
				'property' => 'color',
			),
		),
		'transport' => 'auto',
	) );



	/**
	* Typography
	*/

	// H1
	Kirki::add_field( 'deo_config', array(
		'type'        => 'typography',
		'settings'    => 'deo_headings_h1',
		'label'       => esc_html__( 'H1 Headings', 'neotech' ),
		'section'     => 'deo_typography',
		'default'     => array(
			'font-family' => 'Poppins',
			'font-size'   => '35px',
			'font-weight' => '600',
			'line-height' => '1.3',
		),
		'choices'  => array(
			'variant' => array(
				'regular',
				'700',
			),
		),
		'output' => array(
			array(
				'element' => $selector['h1'],
			),
			array(
				'element' => '.edit-post-visual-editor .wp-block[data-type="core/heading"] h1,
				.edit-post-visual-editor .editor-post-title__block .editor-post-title__input',
				'context' => array( 'editor' ),
			)
		),
		'transport' => 'auto',
	));

	// H2
	Kirki::add_field( 'deo_config', array(
		'type'        => 'typography',
		'settings'    => 'deo_headings_h2',
		'label'       => esc_html__( 'H2 Headings', 'neotech' ),
		'section'     => 'deo_typography',
		'default'     => array(
			'font-family' => 'Poppins',
			'font-size'   => '28px',
			'font-weight' => '600',
			'line-height' => '1.3',
		),
		'choices'  => array(
			'variant' => array(
				'regular',
				'700',
			),
		),
		'output' => array(
			array(
				'element' => $selector['h2'],
			),
			array(
				'element' => '.edit-post-visual-editor .wp-block[data-type="core/heading"] h2',
				'context' => array( 'editor' ),
			)
		),
		'transport' => 'auto',
	));

	// H3 control
	Kirki::add_field( 'deo_config', array(
		'type'        => 'typography',
		'settings'    => 'deo_headings_h3',
		'label'       => esc_html__( 'H3 Headings', 'neotech' ),
		'section'     => 'deo_typography',
		'default'     => array(
			'font-family' => 'Poppins',
			'font-size'   => '24px',
			'font-weight' => '600',
			'line-height' => '1.3',
		),
		'choices'  => array(
			'variant' => array(
				'regular',
				'700',
			),
		),
		'output' => array(
			array(
				'element' => $selector['h3'],
			),
			array(
				'element' => '.edit-post-visual-editor .wp-block[data-type="core/heading"] h3',
				'context' => array( 'editor' ),
			)
		),
		'transport' => 'auto',
	));

	// H4
	Kirki::add_field( 'deo_config', array(
		'type'        => 'typography',
		'settings'    => 'deo_headings_h4',
		'label'       => esc_html__( 'H4 Headings', 'neotech' ),
		'section'     => 'deo_typography',
		'default'     => array(
			'font-family' => 'Poppins',
			'font-size'   => '20px',
			'font-weight' => '600',
			'line-height' => '1.3',
		),
		'choices'  => array(
			'variant' => array(
				'regular',
				'700',
			),
		),
		'output' => array(
			array(
				'element' => $selector['h4'],
			),
			array(
				'element' => '.edit-post-visual-editor .wp-block[data-type="core/heading"] h4',
				'context' => array( 'editor' ),
			)
		),
		'transport' => 'auto',
	));

	// H5
	Kirki::add_field( 'deo_config', array(
		'type'        => 'typography',
		'settings'    => 'deo_headings_h5',
		'label'       => esc_html__( 'H5 Headings', 'neotech' ),
		'section'     => 'deo_typography',
		'default'     => array(
			'font-family' => 'Poppins',
			'font-size'   => '18px',
			'font-weight' => '600',
			'line-height' => '1.3',
		),
		'choices'  => array(
			'variant' => array(
				'regular',
				'700',
			),
		),
		'output' => array(
			array(
				'element' => $selector['h5'],
			),
			array(
				'element' => '.edit-post-visual-editor .wp-block[data-type="core/heading"] h5',
				'context' => array( 'editor' ),
			)
		),
		'transport' => 'auto',
	));

	// H6
	Kirki::add_field( 'deo_config', array(
		'type'        => 'typography',
		'settings'    => 'deo_headings_h6',
		'label'       => esc_html__( 'H6 Headings', 'neotech' ),
		'section'     => 'deo_typography',
		'default'     => array(
			'font-family' => 'Poppins',
			'font-size'   => '15px',
			'font-weight' => '600',
			'line-height' => '1.3',
		),
		'choices'  => array(
			'variant' => array(
				'regular',
				'700',
			),
		),
		'output' => array(
			array(
				'element' => 'h6, .elementor-widget-tabs .elementor-tab-title, .elementor-accordion .elementor-tab-title',
			),
			array(
				'element' => '.edit-post-visual-editor .wp-block[data-type="core/heading"] h6',
				'context' => array( 'editor' ),
			)
		),
		'transport' => 'auto',
	));

	// Body typography
	Kirki::add_field( 'deo_config', array(
		'type'        => 'typography',
		'settings'    => 'deo_body_typography',
		'label'       => esc_html__( 'Body Typography', 'neotech' ),
		'description' => esc_html__( 'Select the main typography options for your site.', 'neotech' ),
		'help'        => esc_html__( 'The typography options you set here apply to all content on your site.', 'neotech' ),
		'section'     => 'deo_typography',
		'default'     => array(
			'font-family'  => 'Roboto',
			'font-size'    => '15px',
			'line-height'  => '1.5',
		),
		'choices'  => array(
			'variant' => array(
				'700',
				'500',
				'italic',
			),
		),
		'output' => array(
			array(
				'element' => $selector['text'],
			),
		),
		'transport' => 'auto',
	));


	// Post typography control
	Kirki::add_field( 'deo_config', array(
		'type'        => 'typography',
		'settings'    => 'deo_post_typography',
		'label'       => esc_html__( 'Post Typography', 'neotech' ),
		'description' => esc_html__( 'Select the post typography options for your site.', 'neotech' ),
		'section'     => 'deo_typography',
		'default'     => array(
			'font-size'    => '1.0625rem',
			'line-height'  => '1.8',
		),
		'output' => array(
			array(
				'element' => '.entry__article',
			),
			array(
				'element' => '.edit-post-visual-editor .block-editor-block-list__block,
				.edit-post-visual-editor .block-editor-block-list__block-edit,
				.edit-post-visual-editor',
				'context' => array( 'editor' ),
			)
		),
		'transport' => 'auto',
	));

	/**
	* Socials
	*/

	Kirki::add_field( 'deo_config', array(
		'type'        => 'url',
		'settings'    => 'deo_socials_settings_facebook',
		'label'       => esc_html__( 'Facebook', 'neotech' ),
		'section'     => 'deo_socials',
	) );

	Kirki::add_field( 'deo_config', array(
		'type'        => 'text',
		'settings'    => 'deo_socials_settings_twitter',
		'label'       => esc_html__( 'Twitter', 'neotech' ),
		'section'     => 'deo_socials',
	) );

	Kirki::add_field( 'deo_config', array(
		'type'        => 'text',
		'settings'    => 'deo_socials_settings_pinterest',
		'label'       => esc_html__( 'Pinterest', 'neotech' ),
		'section'     => 'deo_socials',
	) );

	Kirki::add_field( 'deo_config', array(
		'type'        => 'text',
		'settings'    => 'deo_socials_settings_instagram',
		'label'       => esc_html__( 'Instagram', 'neotech' ),
		'section'     => 'deo_socials',
	) );

	Kirki::add_field( 'deo_config', array(
		'type'        => 'text',
		'settings'    => 'deo_socials_settings_snapchat',
		'label'       => esc_html__( 'Snapchat', 'neotech' ),
		'section'     => 'deo_socials',
	) );

	Kirki::add_field( 'deo_config', array(
		'type'        => 'text',
		'settings'    => 'deo_socials_settings_linkedin',
		'label'       => esc_html__( 'Linkedin', 'neotech' ),
		'section'     => 'deo_socials',
	) );

	Kirki::add_field( 'deo_config', array(
		'type'        => 'text',
		'settings'    => 'deo_socials_settings_dribbble',
		'label'       => esc_html__( 'Dribbble', 'neotech' ),
		'section'     => 'deo_socials',
	) );

	Kirki::add_field( 'deo_config', array(
		'type'        => 'text',
		'settings'    => 'deo_socials_settings_tumblr',
		'label'       => esc_html__( 'Tumblr', 'neotech' ),
		'section'     => 'deo_socials',
	) );

	Kirki::add_field( 'deo_config', array(
		'type'        => 'text',
		'settings'    => 'deo_socials_settings_reddit',
		'label'       => esc_html__( 'Reddit', 'neotech' ),
		'section'     => 'deo_socials',
	) );

	Kirki::add_field( 'deo_config', array(
		'type'        => 'text',
		'settings'    => 'deo_socials_settings_behance',
		'label'       => esc_html__( 'Behance', 'neotech' ),
		'section'     => 'deo_socials',
	) );

	Kirki::add_field( 'deo_config', array(
		'type'        => 'text',
		'settings'    => 'deo_socials_settings_vkontakte',
		'label'       => esc_html__( 'Vkontakte', 'neotech' ),
		'section'     => 'deo_socials',
	) );

	Kirki::add_field( 'deo_config', array(
		'type'        => 'text',
		'settings'    => 'deo_socials_settings_slack',
		'label'       => esc_html__( 'Slack', 'neotech' ),
		'section'     => 'deo_socials',
	) );

	Kirki::add_field( 'deo_config', array(
		'type'        => 'text',
		'settings'    => 'deo_socials_settings_github',
		'label'       => esc_html__( 'Github', 'neotech' ),
		'section'     => 'deo_socials',
	) );

	Kirki::add_field( 'deo_config', array(
		'type'        => 'text',
		'settings'    => 'deo_socials_settings_flickr',
		'label'       => esc_html__( 'Flickr', 'neotech' ),
		'section'     => 'deo_socials',
	) );

	Kirki::add_field( 'deo_config', array(
		'type'        => 'text',
		'settings'    => 'deo_socials_settings_youtube',
		'label'       => esc_html__( 'Youtube', 'neotech' ),
		'section'     => 'deo_socials',
	) );

	Kirki::add_field( 'deo_config', array(
		'type'        => 'text',
		'settings'    => 'deo_socials_settings_xing',
		'label'       => esc_html__( 'Xing', 'neotech' ),
		'section'     => 'deo_socials',
	) );

	Kirki::add_field( 'deo_config', array(
		'type'        => 'text',
		'settings'    => 'deo_socials_settings_vimeo',
		'label'       => esc_html__( 'Vimeo', 'neotech' ),
		'section'     => 'deo_socials',
	) );



	/**
	* Breadcrumbs
	*/

	// Show breadcrumbs on regular pages
	Kirki::add_field( 'deo_config', array(
		'type'        => 'switch',
		'settings'    => 'deo_breadcrumbs_pages_show',
		'label'       => esc_attr__( 'Show breadcrumbs on regular pages', 'neotech' ),
		'section'     => 'deo_breadcrumbs',
		'default'     => true,
		'choices'     => array(
			'on'   => esc_attr__( 'On', 'neotech' ),
			'off' => esc_attr__( 'Off', 'neotech' ),
		),
	) );

	// Show breadcrumbs on blog pages
	Kirki::add_field( 'deo_config', array(
		'type'        => 'switch',
		'settings'    => 'deo_breadcrumbs_blog_show',
		'label'       => esc_attr__( 'Show breadcrumbs on blog pages', 'neotech' ),
		'section'     => 'deo_breadcrumbs',
		'default'     => true,
		'choices'     => array(
			'on'   => esc_attr__( 'On', 'neotech' ),
			'off' => esc_attr__( 'Off', 'neotech' ),
		),
	) );

	// Show breadcrumbs on archive pages
	Kirki::add_field( 'deo_config', array(
		'type'        => 'switch',
		'settings'    => 'deo_breadcrumbs_archive_show',
		'label'       => esc_attr__( 'Show breadcrumbs on archive pages', 'neotech' ),
		'section'     => 'deo_breadcrumbs',
		'default'     => true,
		'choices'     => array(
			'on'   => esc_attr__( 'On', 'neotech' ),
			'off' => esc_attr__( 'Off', 'neotech' ),
		),
	) );


	/**
	* GDPR
	*/

	// Show cookies consent bar
	Kirki::add_field( 'deo_config', array(
		'type'        => 'switch',
		'settings'    => 'deo_cookies_bar_show',
		'label'       => esc_attr__( 'Show cookies consent notification bar', 'neotech' ),
		'section'     => 'deo_gdpr',
		'default'     => false,
		'choices'     => array(
			'on'   => esc_attr__( 'On', 'neotech' ),
			'off' => esc_attr__( 'Off', 'neotech' ),
		),
	) );

	// Cookies message
	Kirki::add_field( 'deo_config', array(
		'type'        => 'textarea',
		'settings'    => 'deo_cookies_message',
		'label'       => esc_html__( 'Cookies message text', 'neotech' ),
		'section'     => 'deo_gdpr',
		'default'     => esc_html__( 'We are using cookies to personalize content and ads to make our site easier for you to use.', 'neotech' ),
	) );

	// Cookies button
	Kirki::add_field( 'deo_config', array(
		'type'        => 'text',
		'settings'    => 'deo_cookies_button',
		'label'       => esc_html__( 'Cookies button text', 'neotech' ),
		'section'     => 'deo_gdpr',
		'default'     => esc_html__( 'Agree', 'neotech' ),
	) );

	// Cookies Learn More text
	Kirki::add_field( 'deo_config', array(
		'type'        => 'text',
		'settings'    => 'deo_cookies_learn_more_text',
		'label'       => esc_html__( 'Cookies learn more text', 'neotech' ),
		'section'     => 'deo_gdpr',
		'default'     => esc_html__( 'Learn More', 'neotech' ),
	) );

	// Cookies URL button
	Kirki::add_field( 'deo_config', array(
		'type'        => 'url',
		'settings'    => 'deo_cookies_learn_more_url',
		'label'       => esc_html__( 'Cookies learn more URL', 'neotech' ),
		'section'     => 'deo_gdpr',
		'default'     => esc_url( 'http://cookiesandyou.com' ),
	) );


	/**
	* Footer
	*/

	// Show footer widgets
	Kirki::add_field( 'deo_config', array(
		'type'        => 'switch',
		'settings'    => 'deo_footer_widgets_show',
		'label'       => esc_attr__( 'Show footer widgets', 'neotech' ),
		'section'     => 'deo_footer',
		'default'     => 1,
		'choices'     => array(
			'on'   => esc_attr__( 'On', 'neotech' ),
			'off' => esc_attr__( 'Off', 'neotech' ),
		),
	) );

	// Footer columns
	Kirki::add_field( 'deo_config', array(
		'type'        => 'select',
		'settings'    => 'deo_footer_columns',
		'label'       => esc_html__( 'How many columns to show', 'neotech' ),
		'section'     => 'deo_footer',
		'default'     => 'four-col',
		'choices'     => array(
			'one-col' => esc_attr__( '1 Column', 'neotech' ),
			'two-col' => esc_attr__( '2 Columns', 'neotech' ),
			'three-col' => esc_attr__( '3 Columns', 'neotech' ),
			'four-col' => esc_attr__( '4 Columns', 'neotech' ),
		),
	) );

	// Show bottom footer
	Kirki::add_field( 'deo_config', array(
		'type'        => 'switch',
		'settings'    => 'deo_footer_bottom_show',
		'label'       => esc_attr__( 'Show bottom footer', 'neotech' ),
		'section'     => 'deo_footer',
		'default'     => 1,
		'choices'     => array(
			'on'   => esc_attr__( 'On', 'neotech' ),
			'off' => esc_attr__( 'Off', 'neotech' ),
		),
	) );

} // endif Kirki check