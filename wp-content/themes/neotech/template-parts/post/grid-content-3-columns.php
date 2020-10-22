<?php
/**
 * Grid posts template file.
 *
 * @package Neotech
 */
?>

<?php if ( have_posts() ) : ?>

    <div class="row masonry-grid" id="masonry-grid">

        <?php while ( have_posts() ) : the_post(); ?>

            <div class="col-md-4 masonry-item">
                <?php get_template_part( 'template-parts/post/content', get_post_format() ); ?>
            </div>

        <?php endwhile; ?>

    </div> <!-- .row -->

    <?php else : ?>
        <?php get_template_part( 'template-parts/post/content', 'none' ); ?>
<?php endif; ?>