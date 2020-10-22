<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/public/partials
 */
class Deo_Core_Public_Display extends Deo_Core
{
	/**
	* Social share icons
	*/
	public function social_sharing_buttons() {
		$output = '';
		$URL = urlencode(get_permalink());
		$title = str_replace( ' ', '%20', get_the_title());
		$thumb = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );

		// Construct sharing URL without using any script
		$twitterURL = 'https://twitter.com/intent/tweet?text=' . $title . '&amp;url=' . $URL;
		$facebookURL = 'https://www.facebook.com/sharer/sharer.php?u=' . $URL;
		$googleURL = 'https://plus.google.com/share?url=' . $URL;
		$linkedInURL = 'https://www.linkedin.com/shareArticle?mini=true&url=' . $URL . '&amp;title=' . $title;
		$pinterestURL = 'https://pinterest.com/pin/create/button/?url=' . $URL . '&amp;media=' . $thumb[0] . '&amp;description=' . $title;
		$emailURL = 'mailto:?subject=' . $title;

		ob_start();

		$social = get_theme_mod( 'deo_share_facebook', true );
		if ( $social ) {
				printf( '<a class="social social-facebook entry__share-social social--colored social--colored-facebook" href="%1$s" target="_blank"><i class="ui-facebook"></i></a>',
						esc_url( $facebookURL )
				);
		}

		$social = get_theme_mod( 'deo_share_twitter', true );
		if ( $social ) {
				printf( '<a class="social social-twitter entry__share-social social--colored social--colored-twitter" href="%1$s" target="_blank"><i class="ui-twitter"></i></a>',
						esc_url( $twitterURL )
				);
		}

		$social = get_theme_mod( 'deo_share_google_plus', true );
		if ( $social ) {
				printf( '<a class="social social-google-plus entry__share-social social--colored social--colored-google" href="%1$s" target="_blank"><i class="ui-google"></i></a>',
						esc_url( $googleURL )
				);
		}

		$social = get_theme_mod( 'deo_share_linkedin', false );
		if ( $social ) {
				printf( '<a class="social social-linkedin entry__share-social social--colored social--colored-linkedin" href="%1$s" target="_blank"><i class="ui-linkedin"></i></a>',
						esc_url( $linkedInURL )
				);
		}

		$social = get_theme_mod( 'deo_share_pinterest', false );
		if ( $social ) {
				printf( '<a class="social social-pinterest entry__share-social social--colored social--colored-pinterest" href="%1$s" target="_blank"><i class="ui-pinterest"></i></a>',
						esc_url( $pinterestURL )
				);
		}

		$social = get_theme_mod( 'deo_share_email', true );
		if ( $social ) {
				printf( '<a class="social social-email entry__share-social social--colored social--colored-email" href="%1$s" target="_blank"><i class="ui-email"></i></a>',
						esc_url( $emailURL )
				);
		}

		$output = ob_get_clean();

		if ( strlen( $output ) ) {
				return sprintf( '<div class="socials entry__share-socials">%1$s</div>', $output );
		}

		return false;
	}
}

$Deo_Core_Public_Display = new Deo_Core_Public_Display();