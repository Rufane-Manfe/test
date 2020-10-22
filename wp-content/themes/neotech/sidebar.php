<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package Neotech
 */

if ( ! is_active_sidebar( 'deo-sidebar' ) ) {
    return;
}
?>

<div id="secondary" class="widget-area <?php if( get_theme_mod( 'deo_sticky_sidebar', true ) ) : ?>sticky-col<?php endif; ?>" role="complementary">
    <?php dynamic_sidebar( 'deo-sidebar' ); ?>
</div><!-- #secondary -->
