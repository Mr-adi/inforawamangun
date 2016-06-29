<?php

function pixflow_register_menus() {
	register_nav_menu( 'primary-nav', esc_attr__( 'Primary Navigation', 'massive-dynamic' ) );
    register_nav_menu( 'mobile-nav', esc_attr__( 'Mobile Navigation', 'massive-dynamic' ) );
}

add_action( 'init', 'pixflow_register_menus');

function pixflow_add_search_menu_item($items, $args)
{
    if( 'primary-nav' != $args->theme_location )
        return $items;

    ob_start();
    ?>
    <!--Add someting to navigation like search box-->
    <?php
    $items .= ob_get_clean();
    return $items;
}

add_filter('wp_nav_menu_items', 'pixflow_add_search_menu_item', 10, 2);