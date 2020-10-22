<?php
/**
 * @package Neotech
 *
 *
 */
?>

<div class="no-content pt-60 pb-60">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="text-center">
                <h3><?php esc_html_e( 'There is no content to display', 'neotech' ); ?></h3>

                <p class="mb-30"><?php esc_html_e('Don\'t fret! Let\'s get you back on track. Perhaps searching can help', 'neotech') ?></p>
                <?php get_search_form(); ?>
            </div>
        </div>
    </div>    
</div>