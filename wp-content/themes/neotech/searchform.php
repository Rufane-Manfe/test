<?php defined('ABSPATH') OR die('restricted access');

$unique_id = uniqid( 'search-form-' ); ?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <input type="search" id="<?php echo esc_attr( $unique_id ); ?>" class="search-form__input" placeholder="<?php esc_attr_e( 'Search an article', 'neotech' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
    <button type="submit" class="search-form__button btn btn-md btn-color btn-button"><i class="ui-search search-form__icon"></i></button>
</form>