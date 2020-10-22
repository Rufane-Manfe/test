<?php

add_filter( 'deo_meta_boxes', 'deo_add_meta_boxes' );
function deo_add_meta_boxes( $meta_boxes = [] ) {
	$prefix = 'deo_meta_';
	$meta_boxes[] = [
		'id'         => 'deo-page-settings',
		'title'      => 'Page Settings',
		'post_types' => [ 'page', 'post' ],
		'context'    => 'normal',
		'priority'   => 'high',
		'prefix'     => $prefix,
		'fields' => [
			[
				'name'  => esc_html__( 'Page Layout', 'deo-core' ),
				'id'    => '_deo_page_layout',
				'type'  => 'layout',
				'options'         => [
					'fullwidth'    => array( 'title' => esc_html__( 'Full Width', 'deo-core' ), 'img' => DEO_CORE_URL . 'admin/assets/img/fullwidth.png' ),
					'left-sidebar'  => array( 'title' => esc_html__( 'Left Sidebar', 'deo-core' ), 'img' => DEO_CORE_URL . 'admin/assets/img/left-sidebar.png' ),
					'right-sidebar' => array( 'title' => esc_html__( 'Right Sidebar', 'deo-core' ), 'img' => DEO_CORE_URL . 'admin/assets/img/right-sidebar.png' ),
				],
				'description'   => esc_html__( 'Select which layout displays on this page', 'deo-core' ),
			],
		]
	];

	$meta_boxes[] = [
		'id'         => 'deo-media-embed-settings',
		'title'      => 'Media Embed',
		'post_types' => [ 'post' ],
		'context'    => 'normal',
		'priority'   => 'high',
		'prefix'     => $prefix,
		'fields' => [			
			[
				'name'  => esc_html__( 'Media Embed URL', 'deo-core' ),
				'id'    => '_deo_meta_value_key',
				'type'  => 'text',
			],
		]
	];

	return $meta_boxes;
}