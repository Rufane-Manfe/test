<?php
/**
 * Globally-accessible functions
 *
 * @link        https://deothemes.com
 * @since       1.0.0
 *
 * @package     Deo_Core
 * @subpackage  Deo_Core/includes
 */


/**
* Social share icons
*/
function deo_social_sharing_buttons() {
	$output = '';
	$URL = urlencode(get_permalink());
	$title = str_replace( ' ', '%20', get_the_title());
	$thumb = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );

	// Construct sharing URL without using any script
	$facebookURL = 'https://www.facebook.com/sharer/sharer.php?u=' . get_permalink();
	$twitterURL = 'https://twitter.com/intent/tweet?text=' . $title . '&amp;url=' . $URL;	
	$linkedInURL = 'https://www.linkedin.com/shareArticle?mini=true&url=' . get_permalink() . '&amp;title=' . $title;
	$pinterestURL = 'https://pinterest.com/pin/create/button/?url=' . $URL . '&amp;media=' . $thumb[0] . '&amp;description=' . $title;
	$vkontakteURL = 'https://vk.com/share.php?url=' . get_permalink();
	$pocketURL = 'https://getpocket.com/save?url=' . $URL;
	$facebookMessengerURL = 'fb-messenger://share/?link=' . get_permalink();
	$whatsappURL = 'whatsapp://send?text=' . get_permalink();
	$viberURL = 'viber://forward?text=' . get_permalink();
	$telegramURL = 'https://t.me/share/url?&text=' . $URL . '&amp;url=' . get_permalink();
	$lineURL = 'http://line.me/R/msg/text/?' . get_permalink();
	$redditURL = 'https://www.reddit.com/submit?url=' . get_permalink();
	$emailURL = 'mailto:?subject=' . $title . '&amp;body=' . $title . '%20' . get_permalink();

	ob_start();


	$social = get_theme_mod( 'deo_share_facebook', true );
	if ( $social ) {
		printf( '<a class="social social-facebook entry__share-social" href="%1$s" target="_blank" rel="noopener nofollow"><i class="ui-facebook"></i></a>',
			esc_url( $facebookURL )
		);
	}

	$social = get_theme_mod( 'deo_share_twitter', true );
	if ( $social ) {
		printf( '<a class="social social-twitter entry__share-social" href="%1$s" target="_blank" rel="noopener nofollow"><i class="ui-twitter"></i></a>',
			esc_url( $twitterURL )
		);
	}

	$social = get_theme_mod( 'deo_share_linkedin', true );
	if ( $social ) {
		printf( '<a class="social social-linkedin entry__share-social" href="%1$s" target="_blank" rel="noopener nofollow"><i class="ui-linkedin"></i></a>',
			esc_url( $linkedInURL )
		);
	}

	$social = get_theme_mod( 'deo_share_pinterest', true );
	if ( $social ) {
		printf( '<a class="social social-pinterest entry__share-social" href="%1$s" target="_blank" rel="noopener nofollow"><i class="ui-pinterest"></i></a>',
			esc_url( $pinterestURL )
		);
	}

	$social = get_theme_mod( 'deo_share_vkontakte', false );
	if ( $social ) {
		printf( '<a class="social social-vkontakte entry__share-social" href="%1$s" target="_blank" rel="noopener nofollow"><i class="ui-vkontakte"></i></a>',
			esc_url( $vkontakteURL )
		);
	}

	$social = get_theme_mod( 'deo_share_pocket', true );
	if ( $social ) {
		printf( '<a class="social social-pocket entry__share-social" href="%1$s" target="_blank" rel="noopener nofollow"><i class="ui-get-pocket"></i></a>',
			esc_url( $pocketURL )
		);
	}

	$social = get_theme_mod( 'deo_share_facebook_messenger', false );
	if ( $social ) {
		printf( '<a class="social social-facebook-messenger entry__share-social" href="%1$s" target="_blank" rel="noopener nofollow"><i class="ui-facebook-messenger"></i></a>',
			esc_url( $facebookMessengerURL, [ 'fb-messenger' ] )
		);
	}

	$social = get_theme_mod( 'deo_share_whatsapp', false );
	if ( $social ) {
		printf( '<a class="social social-whatsapp entry__share-social" href="%1$s" target="_blank" rel="noopener nofollow"><i class="ui-whatsapp"></i></a>',
			esc_url( $whatsappURL, [ 'whatsapp' ] )
		);
	}

	$social = get_theme_mod( 'deo_share_viber', false );
	if ( $social ) {
		printf( '<a class="social social-viber entry__share-social" href="%1$s" target="_blank" rel="noopener nofollow"><i class="ui-viber"></i></a>',
			esc_url( $viberURL, [ 'viber' ] )
		);
	}

	$social = get_theme_mod( 'deo_share_telegram', false );
	if ( $social ) {
		printf( '<a class="social social-telegram entry__share-social" href="%1$s" target="_blank" rel="noopener nofollow"><i class="ui-telegram"></i></a>',
			esc_url( $telegramURL )
		);
	}

	$social = get_theme_mod( 'deo_share_line', false );
	if ( $social ) {
		printf( '<a class="social social-line entry__share-social" href="%1$s" target="_blank" rel="noopener nofollow"><i class="ui-line"></i></a>',
			esc_url( $lineURL )
		);
	}

	$social = get_theme_mod( 'deo_share_reddit', false );
	if ( $social ) {
		printf( '<a class="social social-reddit entry__share-social" href="%1$s" target="_blank" rel="noopener nofollow"><i class="ui-reddit"></i></a>',
			esc_url( $redditURL )
		);
	}

	$social = get_theme_mod( 'deo_share_email', true );
	if ( $social ) {
		printf( '<a class="social social-email entry__share-social" href="%1$s" target="_blank" rel="noopener nofollow"><i class="ui-email"></i></a>',
			esc_url( $emailURL )
		);
	}

	$output = ob_get_clean();

	if ( strlen( $output ) ) {
		return sprintf( '<div class="socials">%1$s</div>', $output );
	}

	return false;
}

/**
* Renders social icons from customizer
*/
function deo_render_social_icons( $type = '', $echo = false ) {
	ob_start();

	$title = ($type == 'text') ? '<span class="social__text">%2$s</span>' : '';

	$social = get_theme_mod( 'deo_socials_settings_facebook', '' );

	if ( $social ) {
		printf(
			'<a class="social social-facebook" href="%1$s" title="%2$s" target="_blank" rel="noopener nofollow"><i class="ui-facebook"></i>' . $title . '</a>',
			esc_url( $social ),
			__( 'Facebook', 'deo-core' )
		);
	}

	$social = get_theme_mod( 'deo_socials_settings_twitter', '' );
	if ( $social ) {
		printf(
			'<a class="social social-twitter" href="%1$s" title="%2$s" target="_blank" rel="noopener nofollow"><i class="ui-twitter"></i>' . $title . '</a>',
			esc_url( $social ),
			__( 'Twitter', 'deo-core' )
		);
	}

	$social = get_theme_mod( 'deo_socials_settings_instagram', '' );
	if ( $social ) {
		printf(
			'<a class="social social-instagram" href="%1$s" title="%2$s" target="_blank" rel="noopener nofollow"><i class="ui-instagram"></i>' . $title . '</a>',
			esc_url( $social ),
			__( 'Instagram', 'deo-core' )
		);
	}

	$social = get_theme_mod( 'deo_socials_settings_pinterest', '' );
	if ( $social ) {
		printf(
			'<a class="social social-pinterest" href="%1$s" title="%2$s" target="_blank" rel="noopener nofollow"><i class="ui-pinterest"></i>' . $title . '</a>',
			esc_url( $social ),
			__( 'Pinterest', 'deo-core' )
		);
	}

	$social = get_theme_mod( 'deo_socials_settings_snapchat', '' );
	if ( $social ) {
		printf(
			'<a class="social social-snapchat" href="%1$s" title="%2$s" target="_blank" rel="noopener nofollow"><i class="ui-snapchat"></i>' . $title . '</a>',
			esc_url( $social ),
			__( 'Snapchat', 'deo-core' )
		);
	}

	$social = get_theme_mod( 'deo_socials_settings_linkedin', '' );
	if ( $social ) {
		printf(
			'<a class="social social-linkedin" href="%1$s" title="%2$s" target="_blank" rel="noopener nofollow"><i class="ui-linkedin"></i>' . $title . '</a>',
			esc_url( $social ),
			__( 'Linkedin', 'deo-core' )
		);
	}

	$social = get_theme_mod( 'deo_socials_settings_dribbble', '' );
	if ( $social ) {
		printf(
			'<a class="social social-dribbble" href="%1$s" title="%2$s" target="_blank" rel="noopener nofollow"><i class="ui-dribbble"></i>' . $title . '</a>',
			esc_url( $social ),
			__( 'Dribbble', 'deo-core' )
		);
	}

	$social = get_theme_mod( 'deo_socials_settings_tumblr', '' );
	if ( $social ) {
		printf(
			'<a class="social social-tumblr" href="%1$s" title="%2$s" target="_blank" rel="noopener nofollow"><i class="ui-tumblr"></i>' . $title . '</a>',
			esc_url( $social ),
			__( 'Tumblr', 'deo-core' )
		);
	}

	$social = get_theme_mod( 'deo_socials_settings_reddit', '' );
	if ( $social ) {
		printf(
			'<a class="social social-reddit" href="%1$s" title="%2$s" target="_blank" rel="noopener nofollow"><i class="ui-reddit"></i>' . $title . '</a>',
			esc_url( $social ),
			__( 'Reddit', 'deo-core' )
		);
	}

	$social = get_theme_mod( 'deo_socials_settings_behance', '' );
	if ( $social ) {
		printf(
			'<a class="social social-behance" href="%1$s" title="%2$s" target="_blank" rel="noopener nofollow"><i class="ui-behance"></i>' . $title . '</a>',
			esc_url( $social ),
			__( 'Behance', 'deo-core' )
		);
	}

	$social = get_theme_mod( 'deo_socials_settings_vkontakte', '' );
	if ( $social ) {
		printf(
			'<a class="social social-vkontakte" href="%1$s" title="%2$s" target="_blank" rel="noopener nofollow"><i class="ui-vkontakte"></i>' . $title . '</a>',
			esc_url( $social ),
			__( 'Vkontakte', 'deo-core' )
		);
	}

	$social = get_theme_mod( 'deo_socials_settings_slack', '' );
	if ( $social ) {
		printf(
			'<a class="social social-slack" href="%1$s" title="%2$s" target="_blank" rel="noopener nofollow"><i class="ui-slack"></i>' . $title . '</a>',
			esc_url( $social ),
			__( 'Slack', 'deo-core' )
		);
	}

	$social = get_theme_mod( 'deo_socials_settings_github', '' );
	if ( $social ) {
		printf(
			'<a class="social social-github" href="%1$s" title="%2$s" target="_blank" rel="noopener nofollow"><i class="ui-github"></i>' . $title . '</a>',
			esc_url( $social ),
			__( 'Github', 'deo-core' )
		);
	}

	$social = get_theme_mod( 'deo_socials_settings_flickr', '' );
	if ( $social ) {
		printf(
			'<a class="social social-flickr" href="%1$s" title="%2$s" target="_blank" rel="noopener nofollow"><i class="ui-flickr"></i>' . $title . '</a>',
			esc_url( $social ),
			__( 'Flickr', 'deo-core' )
		);
	}

	$social = get_theme_mod( 'deo_socials_settings_youtube', '' );
	if ( $social ) {
		printf(
			'<a class="social social-youtube" href="%1$s" title="%2$s" target="_blank" rel="noopener nofollow"><i class="ui-youtube"></i>' . $title . '</a>',
			esc_url( $social ),
			__( 'Youtube', 'deo-core' )
		);
	}

	$social = get_theme_mod( 'deo_socials_settings_xing', '' );
	if ( $social ) {
		printf(
			'<a class="social social-xing" href="%1$s" title="%2$s" target="_blank" rel="noopener nofollow"><i class="ui-xing"></i>' . $title . '</a>',
			esc_url( $social ),
			__( 'Xing', 'deo-core' )
		);
	}

	$social = get_theme_mod( 'deo_socials_settings_vimeo', '' );
	if ( $social ) {
		printf(
			'<a class="social social-vimeo" href="%1$s" title="%2$s" target="_blank" rel="noopener nofollow"><i class="ui-vimeo"></i>' . $title . '</a>',
			esc_url( $social ),
			__( 'Vimeo', 'deo-core' )
		);
	}

	$output = ob_get_clean();

	if ( strlen( $output ) ) {
		if ( $echo ) {
			printf( '<div class="socials socials--%1$s">%2$s</div>', $type, $output );
		} else {
			return sprintf( '<div class="socials socials--%1$s">%2$s</div>', $type, $output );
		}
	}
	return false;
}


if ( ! function_exists( 'deo_user_socials' ) ) {
	/**
	* User Socials
	* @return array $contact_methods array of new fields
	*/
	function deo_user_socials( $contact_methods ) {
		$contact_methods['facebook']   		 = esc_attr__( 'Facebook', 'deo-core' );
		$contact_methods['twitter']    		 = esc_attr__( 'Twitter', 'deo-core' );		
		$contact_methods['pinterest']  		 = esc_attr__( 'Pinterest', 'deo-core' );
		$contact_methods['instagram']  		 = esc_attr__( 'Instagram', 'deo-core' );
		$contact_methods['snapchat']   		 = esc_attr__( 'Snapchat', 'deo-core' );
		$contact_methods['youtube']	   		 = esc_attr__( 'YouTube', 'deo-core' );
		$contact_methods['vimeo']	     		 = esc_attr__( 'Vimeo', 'deo-core' );
		$contact_methods['linkedin']   		 = esc_attr__( 'Linkedin', 'deo-core' );
		$contact_methods['author_email'] 	 = esc_attr__( 'Author Email', 'deo-core' );
		return $contact_methods;
	}
	add_filter( 'user_contactmethods', 'deo_user_socials' );
}


/**
* Save Posts Views
*/
function deo_save_post_views( $postID ) {
	$metaKey = '_deo_post_views';
	$views = get_post_meta( $postID, $metaKey, true );
	$count = ( empty( $views ) ? 0 : $views );
	$count++;
	update_post_meta( $postID, $metaKey, $count );
}