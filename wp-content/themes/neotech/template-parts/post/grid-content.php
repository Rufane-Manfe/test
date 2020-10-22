<?php
/**
 * Grid posts template file.
 *
 * @package Neotech
 */
?>

<?php
	$columns = '';
	$blog_columns = get_theme_mod( 'deo_blog_columns', 'col-md-6' );
	$archive_columns = get_theme_mod( 'deo_archives_columns', 'col-md-6' );

	if ( is_home() ) {
		$columns = $blog_columns;
	}

	if ( is_archive() ) {
		$columns = $archive_columns;
	}
?>

<?php if ( have_posts() ) : ?>

	<div class="row masonry-grid" id="masonry-grid">

		<?php while ( have_posts() ) : the_post(); ?>

			<div class="<?php echo esc_attr( $columns ) ?> masonry-item">
				<?php get_template_part( 'template-parts/post/content', get_post_format() ); ?>
			</div>

		<?php endwhile; ?>

	</div> <!-- .row -->

	<?php else : ?>
		<?php get_template_part( 'template-parts/post/content', 'none' ); ?>
<?php endif; ?>