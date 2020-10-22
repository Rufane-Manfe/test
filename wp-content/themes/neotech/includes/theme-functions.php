<?php
/**
 * Core Theme Functions.
 * @author  	 DeoThemes
 * @copyright  (c) Copyright by DeoThemes
 * @link       https://deothemes.com
 * @package 	 Neotech
 * @since 		 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

/**
* Sidebar
*/
function deo_sidebar() {
	?>
		<aside class="col-lg-4 sidebar">
			<?php get_sidebar(); ?>
		</aside>
	<?php
}


/**
	* Check if page built with Elementor
	*
	* @since  1.0.0
	*/
function neotech_is_elementor_page() {
	$elementor_page = get_post_meta( get_the_ID(), '_elementor_edit_mode', true );

	if ( is_search() || is_archive() ) {
		return false;
	}

	if ( (bool)$elementor_page ) {
		return true;
	} else {
		return false;
	}	
}


/**
 * Allow shorcodes in text widgets
 */
add_filter( 'widget_text', 'do_shortcode' );


if ( ! function_exists( 'deo_paging_nav' ) ) :
	function deo_paging_nav() {
		// Don't print empty markup if there's only one page.
		if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
			return;
		} ?>

		<!-- Pagination Numbers -->
		<nav class="pagination clearfix">
			<?php $args = array(
				'prev_next'          => true,
				'prev_text'          => wp_kses( '<i class="ui-arrow-left"></i>', array( 'i' => array( 'class' => array() ) ) ),
				'next_text'          => wp_kses( '<i class="ui-arrow-right"></i>', array( 'i' => array( 'class' => array() ) ) ),
			); ?>
			<?php echo paginate_links( $args ); ?>
		</nav>

		<?php
	}
endif;


/**
 * Display navigation to next/previous post when applicable.
 */
if ( ! function_exists( 'deo_post_nav' ) ) :
	function deo_post_nav() {
		// Don't print empty markup if there's nowhere to navigate.
		$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
		$next     = get_adjacent_post( false, '', false );
		$get_next_post = get_next_post();
		$get_previous_post = get_previous_post();

		if ( ! $next && ! $previous ) {
			return;
		}
		?>
		
		<nav class="entry-navigation">
			<h5 class="screen-reader-text"><?php echo esc_html__( 'Post navigation', 'neotech' ); ?></h5>
			<div class="entry-navigation__row clearfix">

				<?php if ( ! empty( $get_next_post ) ) : ?>
					<div class="entry-navigation__col entry-navigation--left">
						<div class="entry-navigation__item">
							<div class="entry-navigation__body">
								<?php
									printf( '<i class="ui-arrow-left"></i><span class="entry-navigation__label">%s</span>', esc_html__('Previous Post', 'neotech') );
									next_post_link( '<h6 class="entry-navigation__title">%link</h6>', _x( '%title', 'Next post link', 'neotech' ) );
								?>
							</div>
						</div>
					</div>
				<?php endif; ?>
				<?php if ( ! empty( $get_previous_post ) ) : ?>
					<div class="entry-navigation__col entry-navigation--right">
						<div class="entry-navigation__item">
							<div class="entry-navigation__body">
								<?php
									printf( '<span class="entry-navigation__label">%s</span><i class="ui-arrow-right"></i>', esc_html__('Next Post', 'neotech') );
									previous_post_link( '<h6 class="entry-navigation__title">%link</h6>', _x( '%title', 'Previous post link', 'neotech' ) );  
								?>
							</div>
						</div>
					</div>
				<?php endif; ?>
			</div> <!-- .entry-navigation__row -->
		</nav>
		<?php
	}
endif;


// Get Embedded Media
function deo_get_embedded_media( $type = array() ) {
	$content = do_shortcode( apply_filters( 'the_content', get_the_content() ) );
	$embed = get_media_embedded_in_content( $content, $type );

	if( in_array( 'audio', $type ) ):
		$output = str_replace('?visual=true', '?visual=false', $embed[0]);
	else:
		$output = $embed[0];
	endif;
	return $output;
}


// Add responsive container to embeds
if ( ! function_exists( 'deo_embed_responsive_video' ) ) {
	function deo_embed_responsive_video( $cache, $url, $attr, $post_ID ) {
		$classes = array();

		$classes_all = array(
			'embed-responsive',
			'embed-responsive-16by9',
			'mb-32'
		);

		if ( false !== strpos( $url, 'vimeo.com' ) ) {
			$classes[] = 'embed-responsive-vimeo';
		}

		if ( false !== strpos( $url, 'youtube.com' ) ) {
			$classes[] = 'embed-responsive-youtube';
		}

		$classes = array_merge( $classes, $classes_all );
		
		if ( ! deo_is_gutenberg() ) { 
			return '<div class="' . esc_attr( implode( $classes, ' ' ) ) . '">' . $cache . '</div>';
		} else {
			return $cache;
		}
	}
	add_filter( 'embed_oembed_html', 'deo_embed_responsive_video', 10, 4 );
	add_filter( 'video_embed_html', 'deo_embed_responsive_video' ); // Jetpack
}


/**
* Gutenberg Check
**/
function deo_is_gutenberg() {
	return function_exists( 'register_block_type' ); 
}


if ( ! function_exists( 'deo_author_box' ) ) {
	/**
	* Author Box
	*/
	function deo_author_box() {
		$socials = [
			'facebook'  => get_the_author_meta( 'facebook' ),
			'twitter'   => get_the_author_meta( 'twitter' ),
			'pinterest' => get_the_author_meta( 'pinterest' ),
			'instagram' => get_the_author_meta( 'instagram' ),
			'snapchat'  => get_the_author_meta( 'snapchat' ),
			'youtube'   => get_the_author_meta( 'youtube' ),
			'vimeo'     => get_the_author_meta( 'vimeo' ),
			'linkedin'  => get_the_author_meta( 'linkedin' ),
		];

		$website = rtrim( get_the_author_meta( 'url' ), '/' );
		$email = get_the_author_meta( 'author_email' );

		if ( get_the_author_meta( 'description' ) ) : ?>
			<div class="entry-author entry-author--box clearfix">
				<span itemscope itemprop="image">
					<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) ); ?>">
						<?php echo get_avatar( get_the_author_meta( 'ID' ), 64, null, null, array( 'class' => array( 'entry-author__img' ) ) ); ?>
					</a>                
				</span>
				<div class="entry-author__info">
					<h6 class="entry-author__name" itemprop="url" rel="author">
						<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) ); ?>" itemprop="name">
							<span itemprop="author" itemscope itemtype="//schema.org/Person" class="entry-author__name">
								<?php the_author_meta( 'display_name' ); ?>
							</span>
						</a>
					</h6>
					<?php if ( ! empty( $website ) ) : ?>
						<a href="<?php echo esc_url( $website ); ?>" class="entry-author__website" rel="noopener nofollow" target="_blank">
							<span class="entry-author__website-text"><?php echo esc_url( $website ); ?></span>
						</a>
					<?php endif; ?>
					<p class="entry-author__description"><?php the_author_meta( 'description' ); ?></p>

					<!-- Socials -->
					<?php if ( ! empty( $socials ) ) : ?>
						<div class="entry-author__socials socials socials--nobase">
							<?php foreach ( $socials as $key => $value ) {
								if ( $value ) : ?>
									<a href="<?php echo esc_url( the_author_meta( $key ) ); ?>" class="social" title="<?php echo esc_attr( $key ); ?>" rel="noopener nofollow" target="_blank">
										<i class="ui-<?php echo esc_attr( $key ); ?>"></i>
									</a>
								<?php endif;
							}

							if ( ! empty( $email ) ) : ?>
								<a href="mailto:<?php echo sanitize_email( $email ); ?>" class="social">
									<i class="ui-email"></i>
								</a>
							<?php endif; ?>

						</div>
					<?php endif; ?>

				</div>
			</div>
		<?php endif;
	}
}


// Grab URL Post Format
function deo_grab_url() {
	if (! preg_match( '/<a\s[^>]*?href=[\'"](.+?)[\'"]/i', get_the_content(), $links ) ) {
		return false;
	}
	return esc_url_raw( $links[1] );
}


if ( ! function_exists( 'deo_breadcrumbs_print' ) ) {
	/**
	* Print Breadcrumbs based on Breadcrumb NavXT plugin
	*
	* @since 1.5.0
	*/
	function deo_breadcrumbs_print() {
		if ( ! function_exists( 'bcn_display' ) ) {
			return;
		} ?>

		<div class="breadcrumbs mb-20" typeof="BreadcrumbList" vocab="https://schema.org/">
			<?php bcn_display(); ?>
		</div>
		
		<?php	
	}
}
add_action( 'deo_breadcrumbs', 'deo_breadcrumbs_print', 10 );


if ( ! function_exists( 'deo_bcn_settings_defaults' ) ) {
	/**
	* Change Breadcrumb NavXT separator
	*
	* @since 1.5.0
	*/
	function deo_bcn_settings_defaults( $opts ) {	
		$opts['hseparator'] 							= '<i class="ui-arrow-up breadcrumbs__separator"></i>';
		$opts['Hhome_template'] 					= '<span property="itemListElement" typeof="ListItem"><a property="item" typeof="WebPage" title="Go to %title%." href="%link%" class="%type%" bcn-aria-current><span property="name">Home</span></a><meta property="position" content="%position%"></span>';
		$opts['Hhome_template_no_anchor'] = '<span class="%type%">Home</span>';
		return $opts;
	}
	add_filter( 'bcn_settings_init', 'deo_bcn_settings_defaults' );
}


if ( ! function_exists( 'deo_layout_type' ) ) {
	/**
	 * Check layout type based on customizer and meta settings
	 * @return string $type Layout type
	 */
	function deo_layout_type( $type ) {
		$layout = '';
		$meta_value = '';
		$meta = get_post_meta( get_the_ID(), '_deo_page_layout', true );
		
		if ( $meta ) {
			foreach( $meta as $meta_layout ) {
				$meta_value = $meta_layout;
			}
		}

		if ( 'left-sidebar' == get_theme_mod( 'deo_' . $type .  '_layout_type', 'right-sidebar' ) ) {
			$layout = ( $meta_value ) ? $meta_value : 'left-sidebar';		
		}

		if ( 'right-sidebar' == get_theme_mod( 'deo_' . $type .  '_layout_type', 'right-sidebar' ) ) {
			$layout = ( $meta_value ) ? $meta_value : 'right-sidebar';
		}

		if ( 'fullwidth' == get_theme_mod( 'deo_' . $type .  '_layout_type', 'right-sidebar' ) ) {			
			$layout = ( $meta_value ) ? $meta_value : 'fullwidth';
		}	

		return $layout;
	}
}


/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function deo_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Page Layout Class
	if ( is_page() ) {
		$classes[] = deo_layout_type( 'page' );
	}

	// Blog Layout Class
	if ( is_single() || is_home() ) {
		$classes[] = deo_layout_type( 'blog' );
    }
    
    // Archives Layout Class
    if ( is_archive() ) {
        $classes[] = deo_layout_type( 'archives' );
    }

	$classes[] = '';

	return $classes;
}
add_filter( 'body_class', 'deo_body_classes' );


/**
 * Adds custom admin classes.
 *
 * @param string $classes Classes for the body element.
 * @return string
 */
function deo_admin_body_classes( $classes ) {

	$screen = get_current_screen();

	// Add blog layout class
	if( $screen->id === "post" ) {
		$classes = deo_layout_type( 'blog' );
	}

	// Add page layout class
	if( $screen->id === "page" ) {
		$classes = deo_layout_type( 'page' );
	}
	
	return $classes;
}
add_filter( 'admin_body_class', 'deo_admin_body_classes' );



/**
 * Sanitize HTML
 */
function deo_sanitize_html( $input ) {
	return wp_kses( $input, array(
		'a' => array(
			'href' => array(),
			'target' => array(),
		),
		'i' => array(),
		'span' => array(),
		'em' => array(),
		'strong' => array(),
	) );
}

