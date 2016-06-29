<?php
pixflow_decodeSetting();
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <?php
    pixflow_vc_url();
    pixflow_metaPageType();
    ?>
	<meta charset="<?php bloginfo('charset'); ?>" />
	<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1" />
    <meta name="format-detection" content="telephone=no">



	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

	<!-- Theme Hook -->
    <?php
        wp_head();
    ?>
	<!-- Custom CSS -->
</head>

<body <?php body_class(); ?>>
    <div id="pageLoadingOverlay" class="<?php echo (pixflow_get_theme_mod('loading_type',PIXFLOW_LOADING_TYPE) == 'dark')? "dark-loading-overlay":"light-loading-overlay";?>">
        <h6 class='loading-text'>
            <img src='<?php echo esc_url(pixflow_get_theme_mod('preloader_logo',PIXFLOW_PRELOADER_LOGO));?>'><br>
            <div class="preloader-text"><?php echo nl2br(esc_textarea(pixflow_get_theme_mod('loading_text',PIXFLOW_LOADING_TEXT)));?></div>
        </h6>
    </div>
<?php
    //notification center
    if(pixflow_get_theme_mod('notification_enable',PIXFLOW_NOTIFICATION_ENABLE)||pixflow_get_theme_mod('search_enable',PIXFLOW_SEARCH_ENABLE)||pixflow_get_theme_mod('shop_cart_enable',PIXFLOW_SHOP_CART_ENABLE)){
        get_template_part('templates/notification');
    }
?>
<div class="layout-container" id="layoutcontainer">
        <div class="color-overlay color-type"></div>
        <div class="color-overlay texture-type"></div>
        <div class="color-overlay image-type"></div>
        <div class="texture-overlay"></div>
        <div class="bg-image"></div>
    <?php
    do_action('pixflow_body_start');

    if( pixflow_get_theme_mod('header_theme',PIXFLOW_HEADER_THEME) == 'gather') {
        get_template_part('templates/header-gather-overlay');
    }
    ?>

    <div class="layout" style="width: <?php echo esc_attr(pixflow_get_theme_mod('site_width',PIXFLOW_SITE_WIDTH))?>%;">
        <?php
        do_action('pixflow_before_header');
        ?>
        <!--End Header-->
