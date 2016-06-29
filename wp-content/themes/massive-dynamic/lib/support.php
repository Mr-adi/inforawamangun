<?php

function pixflow_add_image_size_retina($name, $width = 0, $height = 0, $crop = false)
{
    add_image_size($name, $width, $height, $crop);
    add_image_size("$name@2x", $width*2, $height*2, $crop);
}

/*-----------------------------------------------------------------------------------*/
/*	Configure WP2.9+ Thumbnails
/*-----------------------------------------------------------------------------------*/

if ( function_exists( 'add_theme_support' ) ) {
	add_theme_support( 'post-thumbnails' );

    //Post Detail Image size
    pixflow_add_image_size_retina('pixflow_logo');

	//set_post_thumbnail_size
    pixflow_add_image_size_retina( 'pixflow_post-thumbnail-calendar', 400,360,true);//fixed view
    pixflow_add_image_size_retina( 'pixflow_post-related-sm', 245,150,true);//fixed view

    //Post Detail Image size
    pixflow_add_image_size_retina( 'pixflow_post-single', 1180,550 );

    /* Blog Widget */
    pixflow_add_image_size_retina( 'pixflow_recent-post-widget', 60, 50, true );

    /* Portfolio Widget */
    pixflow_add_image_size_retina( 'pixflow_recent-portfolio-widget', 80, 60, true );

    /* Product Compare */
    pixflow_add_image_size_retina( 'pixflow_product-compare', 800, 800, true );

    /* Display Slider */
    pixflow_add_image_size_retina( 'pixflow_display-slider', 750, 414, true );

    /* Tablet Slider */
    pixflow_add_image_size_retina( 'pixflow_tablet-slider', 590, 450, true );

    /* Mobile Slider */
    pixflow_add_image_size_retina( 'pixflow_mobile-slider', 235, 415, true );

    /* Portfolio Multisize Thumbnail */
    pixflow_add_image_size_retina( 'pixflow_multisize-thumb', 630, 542, true );

    /* Client Thumbnail */
    pixflow_add_image_size_retina( 'pixflow_client-thumb', 500, 500, true );

    /* Music Thumbnail */
    pixflow_add_image_size_retina( 'pixflow_music-thumb', 351, 334, true );

    /* Team Member Style2 Thumbnail */
    pixflow_add_image_size_retina( 'pixflow_team-member-style2-thumb', 380, 404, true );

    /* Subscribe Modern */
    pixflow_add_image_size_retina('pixflow_subscribe-modern',520,485,true);

}

/*-----------------------------------------------------------------------------------*/
/*	Title Tag
/*-----------------------------------------------------------------------------------*/

add_theme_support( 'title-tag' );

/*-----------------------------------------------------------------------------------*/
/*	RSS Feeds
/*-----------------------------------------------------------------------------------*/

add_theme_support( 'automatic-feed-links' );

/*-----------------------------------------------------------------------------------*/
/*	Post Formats
/*-----------------------------------------------------------------------------------*/

add_theme_support( 'post-formats', array( 'quote', 'video', 'audio', 'gallery' ) );

/*-----------------------------------------------------------------------------------*/
/*	Editor Style
/*-----------------------------------------------------------------------------------*/
add_action( 'init', 'pixflow_add_editor_styles');
function pixflow_add_editor_styles() {
    add_editor_style( get_stylesheet_uri() );
}
/*-----------------------------------------------------------------------------------*/
/*	WooCommerce
/*-----------------------------------------------------------------------------------*/
//Adding WooCommerce Support to theme
add_action( 'after_setup_theme', 'pixflow_woocommerce_support');
function pixflow_woocommerce_support() {
    add_theme_support( 'woocommerce' );
}
//WooCommerce Product Detail Summary Order
//We need to unhook actions, then hook them again with different priority
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );

add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 9 );


/*-----------------------------------------------------------------------------------*/
/*	Title Tag Support
/*-----------------------------------------------------------------------------------*/
//Adding Title Tag Support to theme
add_action( 'after_setup_theme', 'pixflow_title_support');
function pixflow_title_support() {
    add_theme_support( 'title-tag' );
}