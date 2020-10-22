(function($) {
	"use strict";

	var $window = $(window);

	var DeoWidgetHandler = {

		window: $(window),
		html: $('html, body'),
		ajax: {},

		document_ready: function() {
			DeoWidgetHandler.ajax_filter_list();
		},

		ajax_cache_obj: {

			data: {},

			get: function(id) {
				return DeoWidgetHandler.ajax_cache_obj.data[id];
			},
			set: function(id, data) {
				DeoWidgetHandler.ajax_cache_obj.remove(id);
				DeoWidgetHandler.ajax_cache_obj.data[id] = data;
			},
			remove: function(id) {
				delete DeoWidgetHandler.ajax_cache_obj.data[id];
			},
			exist: function(id) {
				return DeoWidgetHandler.ajax_cache_obj.data.hasOwnProperty(id) && DeoWidgetHandler.ajax_cache_obj.data[id] !== null;
			}
		},

		ajax_block_data: function(block) {
			var param = {};
			param.block_id = block.data('block_id');
			param.posts_per_page = block.data('posts_per_page');
			param.category_id = block.data('category_id');
			param.category_ids = block.data('category_ids');
			param.orderby = block.data('orderby');
			param.widget_type = block.data('widget_type');
			param.category_hide = block.data('category_hide');

			return param;
		},

		ajax_filter_list: function() {

			$('.block-filter-link').off('click').on('click', function(e) {

				e.preventDefault();
				e.stopPropagation();

				var filter_link = $(this);
				var block = filter_link.parents('.content-section.section-recent-news');

				var block_id = block.attr('block_id');

				if ( true == DeoWidgetHandler.ajax[block_id + '_processing'] ) {
					return;
				}

				var filter_link_val = filter_link.data('ajax_filter_val');
				DeoWidgetHandler.ajax[block_id + '_processing'] = true;

				//disable other link
				block.find('.block-link').removeClass('is-active tabs__item--active');
				block.find('.block-link').not(this).addClass('is-disable');
				filter_link.addClass('is-active');

				block.find('.block-inner-content').append('<div class="ajax-overlay"><div class="loader ajax-loader"><div></div></div></div>');

				var param = DeoWidgetHandler.ajax_block_data(block);
				DeoWidgetHandler.ajax_filter_reset_param(block, param, filter_link_val);
				setTimeout(function() {
					DeoWidgetHandler.ajax_filter_list_process(block, param);
				}, 500);

			});
		},

		ajax_filter_reset_param: function(block, param, filter_link_val) {

			param.block_page_current = 1;

			block.data('block_page_current', 1);
			var block_id = block.attr('id');

			if ( 'undefined' == typeof ( DeoWidgetHandler.ajax[block_id + '_category_id'] ) ) {
				DeoWidgetHandler.ajax[block_id + '_category_id'] = 0;
			}

			if ( 0 == filter_link_val ) {
				param.cat = DeoWidgetHandler.ajax[block_id + '_cat'];
				param.category_ids = DeoWidgetHandler.ajax[block_id + '_category_ids'];

				block.data('cat', DeoWidgetHandler.ajax[block_id + '_cat']);
				block.data('category_ids', DeoWidgetHandler.ajax[block_id + '_category_ids']);

			} else {
				param.cat = filter_link_val;
				param.category_ids = 0;

				block.data('cat', filter_link_val);
				block.data('category_ids', 0);
			}
		},

		ajax_filter_list_process: function(block, param) {

			var param_cache = param;
			delete param_cache.block_page_max;
			var cache_id = JSON.stringify(param_cache);

			if ( DeoWidgetHandler.ajax_cache_obj.exist( cache_id ) ) {
				var data = DeoWidgetHandler.ajax_cache_obj.get( cache_id );
				if ( 'undefined' != data.block_page_max ) {
					block.data( 'block_page_max', data.block_page_max );
				}

				DeoWidgetHandler.ajax_end_result( block, data.content );
				return false;
			}

			$.ajax({
				type: 'POST',
				url: deo_vars.ajax_url,
				data: {
					action: 'deo_widget_ajax_data',
					data: param
				},
				success: function(data) {
					data = $.parseJSON(data);
					if ('undefined' != data.block_page_max) {
						block.data('block_page_max', data.block_page_max);
					}
					DeoWidgetHandler.ajax_cache_obj.set(cache_id, data);
					DeoWidgetHandler.ajax_end_result(block, data.content);
				}
			});
		},

		ajax_end_result: function(block, content) {

			block.delay(100).queue(function() {

				block.find('.block-link').removeClass('is-disable');
				block.find('.block-filter-more').removeClass('is-disable');

				var block_id = block.attr('block_id');
				var content_wrap = block.find('.block-content-wrapper');
				var content_inner = content_wrap.find('.block-inner-content');
				
				content_inner.stop();                
				content_inner.html(content);

				content_inner.removeClass('is-overflow');

				DeoWidgetHandler.ajax[block_id + '_processing'] = false;

				block.dequeue();
			});
		},

		//ajax blog data
		ajax_blog_data: function(blog) {
			var param = {};
			param.posts_per_page = blog.data('posts_per_page');
			param.category_id = blog.data('category_id');
			
			return param;
		}
	};

	var DeoLoadMore = {
		window: $(window),
		html: $('html, body'),

		document_ready: function() {
			DeoLoadMore.ajax_load_more();
		},

		ajax_load_more: function() {
			$('.deo-load-more__button').on('click', function (e) {
				var button = $(this);

				if ( ! button.is('.clicked') ) {
					button.addClass('clicked');

					e.preventDefault();
					e.stopPropagation();

					var block = button.parent('.deo-load-more').siblings('.deo-load-more-container');
					var page = block.data('page');
					var newPage = page + 1;

					var data = {
						action: 'deo_widget_load_more',
						security: deo_vars.ajax_nonce,
						data : {
							page : page,
							posts_per_page : block.data('posts_per_page'),
							page_max : block.data('page_max'),
							category_id : block.data('category_id'),
							order_by : block.data('order_by'),
							widget_type : block.data('widget_type'),
							image_hide : block.data('image_hide'),
							category_hide : block.data('category_hide'),
							date_hide : block.data('date_hide'),
							author_hide : block.data('author_hide'),
							content_hide : block.data('content_hide'),
							reviews_hide : block.data('reviews_hide'),
							content_length : block.data('content_length'),
							title_size : block.data('title_size'),
							post_columns : block.data('post_columns'),
							post_columns_tablet : block.data('post_columns_tablet'),
							post_columns_mobile : block.data('post_columns_mobile'),
						}
					}

					$.ajax({
						type: 'POST',
						url: deo_vars.ajax_url,
						data: data,
						beforeSend : function ( xhr ) {
							button.addClass('deo-loading');
							button.append('<div class="loader"><div></div></div>');
						},
						success: function(data) {
							if ( data ) {
								button.removeClass('deo-loading clicked');
								button.find('.loader').remove();

								block.data('page', newPage);
								block.append(data);
								
								if ( block.data('page_max') == block.data('page') ) {
									button.remove();
								}
							} else {
								button.remove();
							}  

						}
					});

				}

				return false;

			});
		},



		
	};

	$(document).ready(function() {
		DeoWidgetHandler.document_ready();
		DeoLoadMore.document_ready();
	});


	/* Tabs Post
	-------------------------------------------------------*/
	var deoTabsPost = function( $scope, $ ) {		

		setTimeout(() => {
			$('.carousel-thumbs').flickity('reloadCells');
		}, 500);
		initMasonry();		

		// 1st carousel, main
		$('.carousel-main').flickity({
			cellAlign: 'left',
			contain: true,
			pageDots: false,
			prevNextButtons: false,
			draggable: false,
			lazyLoad: true
		});

		// 2nd carousel, thumbs
		$('.carousel-thumbs').each( function() {
			
			var widgetID = $(this).closest('.elementor-element').data('id');

			$(this).flickity({
				cellAlign: 'left',
				asNavFor: '.carousel-main-' + widgetID,
				imagesLoaded: true,
				contain: true,
				pageDots: false,
				prevNextButtons: false,
			});
		});

		// Watch the changes of hero height control
		if ( elementorFrontend.isEditMode() ) {
			elementor.channels.editor.on( 'change', function( view ) {
				let changed = view.elementSettingsModel.changed;

				if ( changed.hero_height ) {
					$('.carousel-main').flickity('resize');
				}
			});
		}
	}


	/* Posts Carousel
	-------------------------------------------------------*/	
	var deoPostsCarousel = function( $scope, $ ) {
		$('.carousel-posts').flickity({
			cellAlign: 'left',
			pageDots: false,
			imagesLoaded: true,
			wrapAround: true,
		});		
	}


	/* Masonry
	-------------------------------------------------------*/
	function initMasonry() {
		var $grid = $('.masonry-grid').imagesLoaded( function() {
			$grid.masonry({
			itemSelector: '.masonry-item',
			columnWidth: '.masonry-item',
			percentPosition: true
			});
		});
	}

	$window.on('elementor/frontend/init', function () {
		elementorFrontend.hooks.addAction('frontend/element_ready/deo-posts-carousel.default', deoPostsCarousel);
		elementorFrontend.hooks.addAction('frontend/element_ready/deo-posts-featured-slider.default', deoPostsCarousel);
		elementorFrontend.hooks.addAction('frontend/element_ready/deo-tabs-post.default', deoTabsPost);
	});

})(jQuery);