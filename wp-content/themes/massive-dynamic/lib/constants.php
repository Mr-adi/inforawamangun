<?php
//defining allowed HTML tags for wp_kses
global $md_allowed_HTML_tags;
$md_allowed_HTML_tags = array(
    'a' => array(
        'href' => array(),
        'class' => array(),
        'style' => array(),
        'title' => array(),
        'data-filter' => array(),
    ),
    'div' => array(
        'class' => array(),
        'style' => array(),
    ),
    'span' => array(
        'class' => array(),
        'value' => array(),
        'style' => array(),
    ),
    'h4' => array(
        'class' => array(),
        'style' => array(),
    ),
    'br' => array(

    ),
    'p' => array(
        'class' => array(),
        'style' => array(),
    ),
    'button' => array(
        'class' => array(),
        'style' => array(),
    ),
    'li' => array(
        'class' => array(),
        'style' => array(),
    ),
    'ol' => array(
        'class' => array(),
        'style' => array(),
    ),
    'ul' => array(
        'class' => array(),
        'style' => array(),
    ),
    'source' => array(
        'class' => array(),
        'style' => array(),
        'src'	=> array(),
        'type'	=> array()
    ),
    'img' => array(
        'class' => array(),
        'id' => array(),
        'style' => array(),
        'alt' => array(),
        'src' => array(),
        'srcset' => array(),
        'height' => array(),
        'width' => array(),
    ),
    'i' => array(
        'class' => array(),
        'style' => array(),
    ),
    'dl' => array(
        'class' => array(),
        'style' => array(),
    ),
    'dd' => array(
        'class' => array(),
        'style' => array(),
    ),
    'dt' => array(
        'class' => array(),
        'style' => array(),
    ),
);

//defining unique controllers
global $md_uniqueSettings;
$md_uniqueSettings = array(
    /***GENERAL OPTIONS***/
    /*Layout*/
    'site_width',
    'site_top',
    /*Background*/
    'site_bg',
    'site_bg_type',
    'site_bg_color_type',
    'site_bg_solid_color',
    'site_bg_gradient_orientation',
    'site_bg_gradient_color1',
    'site_bg_gradient_color2',
    'site_bg_image_image',
    'site_bg_image_repeat',
    'site_bg_image_attach',
    'site_bg_image_position',
    'site_bg_image_size',
    'site_bg_image_opacity',
    'site_bg_image_overlay',
    'site_bg_image_overlay_type',
    'site_bg_image_solid_overlay',
    'site_bg_overlay_gradient_orientation',
    'site_bg_overlay_gradient_color1',
    'site_bg_overlay_gradient_color2',
    'site_bg_texture',
    'site_bg_texture_opacity',
    'site_bg_texture_overlay',
    'site_bg_texture_solid_overlay',
    /***HEADER***/
    /*Layout*/
    'header_position',
    'header_top_position',
    'header_theme',
    'header_side_theme',
    'logotop_logoSpace',
    'classic_style',
    'block_style',
    'gather_style',
    'header_side_align',
    'header_side_footer',
    'header_styles',
    'show_up_after',
    'show_up_style',
    'header_top_width',
    'header-top-height',
    'header-side-width',
    'header-content',
    'menu_item_style',
    'header_items_order',
    /*Appearance*/
    'nav_color',
    'nav_hover_color',
    'header_bg_color_type',
    'header_bg_solid_color',
    'header_bg_gradient_orientation',
    'header_bg_gradient_color1',
    'header_bg_gradient_color2',
    'logo_style',
    'header_border_enable',
    'nav_color_second',
    'nav_hover_color_second',
    'header_bg_color_type_second',
    'header_bg_solid_color_second',
    'header_bg_gradient_second_orientation',
    'header_bg_gradient_second_color1',
    'header_bg_gradient_second_color2',
    'logo_style_second',
    'popup_menu',
    'popup_menu_color',
    'overlay_bg',
    'header_side_image_image',
    'header_side_image_repeat',
    'header_side_image_position',
    'header_side_image_size',
    /*DropDown*/
    'dropdown_bg_solid_color',
    'dropdown_heading_solid_color',
    'dropdown_fg_solid_color',
    'dropdown_fg_hover_color',
    /*BussinessBar*/
    'businessBar_enable',
    'businessBar_style',
    'businessBar_social',
    'businessBar_content_color',
    'businessBar_bg_color',
    'businessBar_address',
    'businessBar_tel',
    'businessBar_email',
    /*Typography*/
    'nav_name',
    'nav_size',
    'nav_weight',
    'nav_letterSpace',
    'nav_style',
    /***SITE CONTENT***/
    /*Layout*/
    'main-width',
    'mainC-width',
    'main-top',
    'mainC-padding',
    /*Background*/
    'main_bg',
    'main_bg_color_type',
    'main_bg_solid_color',
    'main_bg_gradient_orientation',
    'main_bg_gradient_color1',
    'main_bg_gradient_color2',
    /***FOOTER***/
    /*Layout*/
    'footer_widgets_styles',
    'footer_widget_area_height',
    'footer_bottom_area_height',
    'footer-width',
    'footerC-width',
    'footer-marginT',
    'footer-marginB',
    /*Widget Aera*/
    'footer_widgets_order',
    'footer_widget_area_columns_status',
    'footer_widget_area_columns',
    /*Copyright Area*/
    'footer_bottom_items_layout',
    'footer_copyright_text',
    'footer_switcher',
    'footer_logo',
    'footer_copyright',
    'footer_social',
    'footer_logo_skin',
    'footer_logo_opacity',
    /*Background*/
    'footer_widget_area_skin',
    'footer_parallax',
    'footer_widget_area_bg_color_rgba',
    'copyright_separator',
    'copyright_color',
    'footer_bottom_area_bg_color_rgba',
    'footer_bg',
    'footer_bg_type',
    'footer_bg_image_image',
    'footer_bg_image_repeat',
    'footer_bg_image_attach',
    'footer_bg_image_position',
    'footer_bg_image_size',
    'footer_bg_image_opacity',
    'footer_bg_image_overlay',
    'footer_bg_image_overlay_type',
    'footer_bg_image_solid_overlay',
    'footer_bg_overlay_gradient_orientation',
    'footer_bg_overlay_gradient_color1',
    'footer_bg_overlay_gradient_color2',
    'footer_bg_texture',
    'footer_bg_texture_opacity',
    'footer_bg_texture_overlay',
    'footer_bg_texture_solid_overlay',
    /*Go to Top BTN*/
    'go_to_top_status',
    'footer_section_gototop_skin',
    'go_to_top_show',
    /***SIDEBAR***/
    /*Page Sidebar*/
    'sidebar-switch',
    'sidebar-position',
    'sidebar-width',
    'sidebar-skin',
    'sidebar-style',
    'sidebar-align',
    'sidebar-shadow-color',
    /*Background*/
    'page_sidebar_bg',
    'page_sidebar_bg_type',
    'page_sidebar_bg_color_type',
    'page_sidebar_bg_solid_color',
    'page_sidebar_bg_gradient_orientation',
    'page_sidebar_bg_gradient_color1',
    'page_sidebar_bg_gradient_color2',
    'page_sidebar_bg_image_image',
    'page_sidebar_bg_image_repeat',
    'page_sidebar_bg_image_attach',
    'page_sidebar_bg_image_position',
    'page_sidebar_bg_image_size',
    'page_sidebar_bg_image_opacity',
    'page_sidebar_bg_image_overlay',
    'page_sidebar_bg_image_overlay_type',
    'page_sidebar_bg_image_solid_overlay',
    'page_sidebar_bg_overlay_gradient_orientation',
    'page_sidebar_bg_overlay_gradient_color1',
    'page_sidebar_bg_overlay_gradient_color2',
    'page_sidebar_bg_texture',
    'page_sidebar_bg_texture_opacity',
    'page_sidebar_bg_texture_overlay',
    'page_sidebar_bg_texture_solid_overlay',
    /*Post Sidebar*/
    'sidebar-switch-single',
    'sidebar-position-single',
    'sidebar-width-single',
    'sidebar-skin-single',
    'sidebar-style-single',
    'sidebar-align-single',
    'sidebar-shadow-color-single',
    /*Background*/
    'single_sidebar_bg',
    'single_sidebar_bg_type',
    'single_sidebar_bg_color_type',
    'single_sidebar_bg_solid_color',
    'single_sidebar_bg_gradient_orientation',
    'single_sidebar_bg_gradient_color1',
    'single_sidebar_bg_gradient_color2',
    'single_sidebar_bg_image_image',
    'single_sidebar_bg_image_repeat',
    'single_sidebar_bg_image_attach',
    'single_sidebar_bg_image_position',
    'single_sidebar_bg_image_size',
    'single_sidebar_bg_image_opacity',
    'single_sidebar_bg_image_overlay',
    'single_sidebar_bg_image_overlay_type',
    'single_sidebar_bg_image_solid_overlay',
    'single_sidebar_bg_overlay_gradient_orientation',
    'single_sidebar_bg_overlay_gradient_color1',
    'single_sidebar_bg_overlay_gradient_color2',
    'single_sidebar_bg_texture',
    'single_sidebar_bg_texture_opacity',
    'single_sidebar_bg_texture_overlay',
    'single_sidebar_bg_texture_solid_overlay',
);
if(in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) || class_exists( 'WooCommerce' )){
    /*Shop Sidebar*/
    $md_uniqueSettings[] = 'sidebar-switch-shop';
    $md_uniqueSettings[] = 'sidebar-position-shop';
    $md_uniqueSettings[] = 'sidebar-width-shop';
    $md_uniqueSettings[] = 'sidebar-skin-shop';
    $md_uniqueSettings[] = 'sidebar-style-shop';
    $md_uniqueSettings[] = 'sidebar-align-shop';
    $md_uniqueSettings[] = 'sidebar-shadow-color-shop';
}
/** @var $theme WP_Theme */
$theme = wp_get_theme();

define('PIXFLOW_THEME_NAME',	$theme->Name);
define('PIXFLOW_THEME_NAME_SEO', strtolower(str_replace(" ", "_", PIXFLOW_THEME_NAME)));
define('PIXFLOW_THEME_AUTHOR',	$theme->Author);
define('PIXFLOW_THEME_VERSION',	$theme->Version);
define('PIXFLOW_OPTIONS_KEY', "theme_". PIXFLOW_THEME_NAME_SEO ."_options");

/**************************************************
Theme Defaults
 **************************************************/

define('PIXFLOW_DEFAULT_FOOTER_WIDGETS', 4);
define('PIXFLOW_USE_CUSTOM_PAGINATION', 1);//Theme-check plugin requirement
define('PIXFLOW_USE_COMMENT_REPLY_SCRIPT', 0);//Theme-check plugin requirement

/**************************************************

 * ===============Controllers Defaults================
 * Define default value for all controllers. ex: setting is "nav_color" and default value is '#000' so:
 * define('NAV_COLOR','#000');
 **************************************************/

/**************************************************
General Options Defaults
 **************************************************/
define('PIXFLOW_SITE_WIDTH',85);
define('PIXFLOW_SITE_TOP',0);
define('PIXFLOW_SITE_BG',false);
define('PIXFLOW_SITE_BG_TYPE','color');
define('PIXFLOW_SITE_BG_COLOR_TYPE','solid');
define('PIXFLOW_SITE_BG_SOLID_COLOR','#FFF');
define('PIXFLOW_SITE_BG_IMAGE_REPEAT','no-repeat');
define('PIXFLOW_SITE_BG_IMAGE_ATTACH','fixed');
define('PIXFLOW_SITE_BG_IMAGE_POSITION','center-top');
define('PIXFLOW_SITE_BG_IMAGE_SIZE','cover');
define('PIXFLOW_SITE_BG_IMAGE_OPACITY',1);
define('PIXFLOW_SITE_BG_IMAGE_OVERLAY',false);
define('PIXFLOW_SITE_BG_IMAGE_OVERLAY_TYPE','solid');
define('PIXFLOW_SITE_BG_GRADIENT_ORIENTATION','vertical');
define('PIXFLOW_SITE_BG_OVERLAY_GRADIENT_ORIENTATION','vertical');
define('PIXFLOW_SITE_BG_GRADIENT_COLOR1','#FFF');
define('PIXFLOW_SITE_BG_GRADIENT_COLOR2','#e4e4e4');
define('PIXFLOW_SITE_BG_IMAGE_SOLID_OVERLAY','rgba(0,0,0,0.2)');
define('PIXFLOW_SITE_BG_OVERLAY_GRADIENT_COLOR1','rgba(0,0,0,0.7)');
define('PIXFLOW_SITE_BG_OVERLAY_GRADIENT_COLOR2','rgba(255,255,255,0)');
define('PIXFLOW_SITE_BG_TEXTURE_OVERLAY',false);
define('PIXFLOW_SITE_BG_TEXTURE_OPACITY',0.50);
define('PIXFLOW_SITE_BG_TEXTURE',PIXFLOW_THEME_CUSTOMIZER_URI . '/assets/images/texture/1.png');
define('PIXFLOW_SITE_BG_TEXTURE_SOLID_OVERLAY','rgba(0,0,0,0.2)');
define('PIXFLOW_LOADING_TYPE','light');
define('PIXFLOW_LOADING_TEXT','');
define('PIXFLOW_PORTFOLIO_ACCENT','rgb(204,162,107)');
/**************************************************
Header Defaults
 **************************************************/
//layout
define('PIXFLOW_HEADER_THEME','classic');
define('PIXFLOW_HEADER_POSITION','top');
define('PIXFLOW_HEADER_SIDE_THEME','classic');
define('PIXFLOW_LOGOTOP_LOGOSPACE',10);
define('PIXFLOW_CLASSIC_STYLE','none');
define('PIXFLOW_BLOCK_STYLE','style1');
define('PIXFLOW_GATHER_STYLE','style1');
define('PIXFLOW_HEADER_SIDE_ALIGN','left');
define('PIXFLOW_HEADER_SIDE_MODERN_STYLE','style1');
define('PIXFLOW_HEADER_SIDE_FOOTER',true);
define('PIXFLOW_HEADER_STYLES','style3');
define('PIXFLOW_SHOW_UP_AFTER',800);
define('PIXFLOW_SHOW_UP_STYLE','fade_in');
define('PIXFLOW_HEADER_TOP_WIDTH',100);
define('PIXFLOW_HEADER_TOP_HEIGHT',70);
define('PIXFLOW_HEADER_SIDE_WIDTH',14);
define('PIXFLOW_HEADER_CONTENT',70);
define('PIXFLOW_HEADER_TOP_POSITION',0);
define('PIXFLOW_HEADER_SIDE_IMAGE_REPEAT','no-repeat');
define('PIXFLOW_HEADER_SIDE_IMAGE_POSITION','center-center');
define('PIXFLOW_HEADER_SIDE_IMAGE_SIZE','cover');
//Appearance section
define('PIXFLOW_NAV_COLOR','rgb(0,0,0)');
define('PIXFLOW_NAV_HOVER_COLOR','rgb(255, 196, 0)');
define('PIXFLOW_HEADER_BG_COLOR_TYPE','solid');
define('PIXFLOW_HEADER_BG_SOLID_COLOR','rgba(255, 255, 255, 1)');
define('PIXFLOW_HEADER_BG_GRADIENT_COLOR1','rgba(255,255,255,1)');
define('PIXFLOW_HEADER_BG_GRADIENT_COLOR2','rgba(255,255,255,.5)');
define('PIXFLOW_HEADER_BG_GRADIENT_ORIENTATION','vertical');
define('PIXFLOW_MENU_ITEM_STYLE','text');
define('PIXFLOW_HEADER_BG_COLOR_TYPE_SECOND','solid');
define('PIXFLOW_HEADER_BG_SOLID_COLOR_SECOND','rgba(0, 0, 0, 0.62)');
define('PIXFLOW_HEADER_BG_GRADIENT_SECOND_ORIENTATION','vertical');
define('PIXFLOW_HEADER_BG_GRADIENT_SECOND_COLOR1','rgba(255,255,255,1)');
define('PIXFLOW_HEADER_BG_GRADIENT_SECOND_COLOR2','rgba(255,255,255,.5)');
define('PIXFLOW_LOGO_STYLE','dark');
define('PIXFLOW_LOGO_STYLE_SECOND','light');
define('PIXFLOW_HEADER_BORDER_ENABLE',false);
define('PIXFLOW_NAV_COLOR_SECOND','rgb(255,255,255)');
define('PIXFLOW_NAV_HOVER_COLOR_SECOND','rgb(255, 196, 0)');
define('PIXFLOW_POPUP_MENU_COLOR','rgb(255,255,255)');
define('PIXFLOW_OVERLAY_BG','rgb(0,0,0)');
//dropdown
define('PIXFLOW_DROP_DOWN_STYLE','simple');
define('PIXFLOW_DROPDOWN_BG_SOLID_COLOR','rgba(255,255,255,.8)');
define('PIXFLOW_DROPDOWN_HEADING_SOLID_COLOR','rgb(200,200,200)');
define('PIXFLOW_DROPDOWN_FG_SOLID_COLOR','rgb(0,0,0)');
define('PIXFLOW_DROPDOWN_FG_HOVER_COLOR','rgba(63,63,63,1)');
//elements Appear
define('PIXFLOW_SEARCH_ENABLE',true);
define('PIXFLOW_NOTIFICATION_ENABLE',true);
define('PIXFLOW_SHOP_CART_ENABLE',true);
//Business Bar
define('PIXFLOW_BUSINESSBAR_ENABLE',false);
define('PIXFLOW_BUSINESSBAR_STYLE','icon');
define('PIXFLOW_BUSINESSBAR_SOCIAL','icon');
define('PIXFLOW_BUSINESSBAR_CONTENT_COLOR','rgba(255,255,255,1)');
define('PIXFLOW_BUSINESSBAR_BG_COLOR','rgb(82,82,82)');
define('PIXFLOW_BUSINESSBAR_ADDRESS','Your address will show here');
define('PIXFLOW_BUSINESSBAR_TEL','+12 34 56 78');
define('PIXFLOW_BUSINESSBAR_EMAIL','email@example.com');
//Typography
define('PIXFLOW_NAV_NAME','Roboto');
define('PIXFLOW_NAV_SIZE',13);
define('PIXFLOW_NAV_WEIGHT',400);
define('PIXFLOW_NAV_LETTERSPACE',0);
define('PIXFLOW_NAV_STYLE',false);
// Responsive
define('PIXFLOW_HEADER_RESPONSIVE_SKIN','light');
define('PIXFLOW_LOGO_RESPONSIVE_SKIN','dark');
/**************************************************
Site Content Defaults
 **************************************************/
//main
define('PIXFLOW_MAIN_WIDTH',100);
define('PIXFLOW_MAINC_WIDTH',70);
define('PIXFLOW_MAIN_TOP',0);
define('PIXFLOW_MAINC_PADDING',0);
define('PIXFLOW_MAIN_BG',false);
define('PIXFLOW_MAIN_BG_COLOR_TYPE','solid');
define('PIXFLOW_MAIN_BG_SOLID_COLOR','#FFF');
define('PIXFLOW_MAIN_BG_GRADIENT_ORIENTATION','vertical');
define('PIXFLOW_MAIN_BG_GRADIENT_COLOR1','rgba(255,255,255,1)');
define('PIXFLOW_MAIN_BG_GRADIENT_COLOR2','rgba(255,255,255,0.5)');

// background

/**************************************************
Footer Defaults
 **************************************************/
//layout
define('PIXFLOW_FOOTER_WIDGETS_STYLES','modern');
define('PIXFLOW_FOOTER_CLASSIC_WIDGETS_STYLES','border');
define('PIXFLOW_FOOTER_WIDGET_AREA_HEIGHT',300);
define('PIXFLOW_FOOTER_BOTTOM_AREA_HEIGHT',72);
define('PIXFLOW_FOOTER_WIDTH',100);
define('PIXFLOW_FOOTERC_WIDTH',70);
define('PIXFLOW_FOOTER_MARGINT',0);
define('PIXFLOW_FOOTER_MARGINB',0);
define('PIXFLOW_FOOTER_WIDGETS_ORDER','');
//widget area
define('PIXFLOW_FOOTER_WIDGET_AREA_COLUMNS_STATUS',false);
define('PIXFLOW_FOOTER_WIDGET_AREA_COLUMNS',4);
define('PIXFLOW_FOOTER_WIDGET_AREA_SKIN','light');
//Copyright area
define('PIXFLOW_FOOTER_BOTTOM_ITEMS_LAYOUT','linear');
define('PIXFLOW_FOOTER_COPYRIGHT_TEXT','Copyright - Made with Massive Dynamic');
define('PIXFLOW_COPYRIGHT_COLOR','rgb(229, 229, 229)');
define('PIXFLOW_FOOTER_SWITCHER',true);
define('PIXFLOW_FOOTER_LOGO',true);
define('PIXFLOW_FOOTER_COPYRIGHT',true);
define('PIXFLOW_FOOTER_SOCIAL',true);
define('PIXFLOW_FOOTER_LOGO_SKIN','light');
define('PIXFLOW_FOOTER_LOGO_OPACITY',1);
//Backgrounds
define('PIXFLOW_FOOTER_PARALLAX',false);
define('PIXFLOW_FOOTER_WIDGET_AREA_BG_COLOR_RGBA','rgba(40, 40, 40, 1)');
define('PIXFLOW_FOOTER_BOTTOM_AREA_BG_COLOR_RGBA','rgba(53, 53, 53, 1)');
define('PIXFLOW_COPYRIGHT_SEPARATOR',0);
define('PIXFLOW_WIDGETS_SEPARATOR','boxed');
define('PIXFLOW_COPYRIGHT_SEPARATOR_BG_COLOR','rgba(255,255,255,.1)');
define('PIXFLOW_FOOTER_BG',true);
define('PIXFLOW_FOOTER_BG_TYPE','image');
define('PIXFLOW_FOOTER_BG_IMAGE_REPEAT','no-repeat');
define('PIXFLOW_FOOTER_BG_IMAGE_ATTACH','fixed');
define('PIXFLOW_FOOTER_BG_IMAGE_POSITION','center-top');
define('PIXFLOW_FOOTER_BG_IMAGE_SIZE','cover');
define('PIXFLOW_FOOTER_BG_IMAGE_OPACITY',1);
define('PIXFLOW_FOOTER_BG_IMAGE_OVERLAY',false);
define('PIXFLOW_FOOTER_BG_IMAGE_OVERLAY_TYPE','solid');
define('PIXFLOW_FOOTER_BG_OVERLAY_GRADIENT_ORIENTATION','vertical');
define('PIXFLOW_FOOTER_BG_IMAGE_SOLID_OVERLAY','rgba(0,0,0,0.2)');
define('PIXFLOW_FOOTER_BG_OVERLAY_GRADIENT_COLOR1','rgba(0,0,0,0.7)');
define('PIXFLOW_FOOTER_BG_OVERLAY_GRADIENT_COLOR2','rgba(255,255,255,0)');
define('PIXFLOW_FOOTER_BG_TEXTURE_OVERLAY',false);
define('PIXFLOW_FOOTER_BG_TEXTURE_OPACITY',0.50);
define('PIXFLOW_FOOTER_BG_TEXTURE',PIXFLOW_THEME_CUSTOMIZER_URI . '/assets/images/texture/1.png');
define('PIXFLOW_FOOTER_BG_TEXTURE_SOLID_OVERLAY','rgba(0,0,0,0.2)');
//go to top
define('PIXFLOW_GO_TO_TOP_STATUS',false);
define('PIXFLOW_FOOTER_SECTION_GOTOTOP_SKIN','light');
define('PIXFLOW_GO_TO_TOP_SHOW',600);
/**************************************************
Sidebar Defaults
 **************************************************/
$sidebars = array('','_BLOG','_SINGLE','_SHOP');
foreach($sidebars as $sidebar) {
    //sidebar
    define('PIXFLOW_SIDEBAR_SWITCH'.$sidebar, false);
    define('PIXFLOW_SIDEBAR_POSITION'.$sidebar, 'left');
    define('PIXFLOW_SIDEBAR_WIDTH'.$sidebar, 15);
    define('PIXFLOW_SIDEBAR_STYLE'.$sidebar, 'none');
    define('PIXFLOW_SIDEBAR_SKIN'.$sidebar, 'dark');
    define('PIXFLOW_SIDEBAR_ALIGN'.$sidebar, 'left');
}
$sidebars = array('PAGE','BLOG','SINGLE','SHOP');
foreach($sidebars as $sidebar) {
    //background
    $sidebar = 'PIXFLOW_'.$sidebar;
    define($sidebar.'_SIDEBAR_BG',true);
    define($sidebar.'_SIDEBAR_BG_TYPE','color');
    define($sidebar.'_SIDEBAR_BG_COLOR_TYPE','solid');
    define($sidebar.'_SIDEBAR_BG_SOLID_COLOR','#FFF');
    define($sidebar.'_SIDEBAR_BG_IMAGE_REPEAT','no-repeat');
    define($sidebar.'_SIDEBAR_BG_IMAGE_ATTACH','fixed');
    define($sidebar.'_SIDEBAR_BG_IMAGE_POSITION','center-top');
    define($sidebar.'_SIDEBAR_BG_IMAGE_SIZE','cover');
    define($sidebar.'_SIDEBAR_BG_IMAGE_OPACITY',1);
    define($sidebar.'_SIDEBAR_BG_IMAGE_OVERLAY',false);
    define($sidebar.'_SIDEBAR_BG_IMAGE_OVERLAY_TYPE','solid');
    define($sidebar.'_SIDEBAR_BG_GRADIENT_ORIENTATION','vertical');
    define($sidebar.'_SIDEBAR_BG_OVERLAY_GRADIENT_ORIENTATION','vertical');
    define($sidebar.'_SIDEBAR_BG_GRADIENT_COLOR1','#FFF');
    define($sidebar.'_SIDEBAR_BG_GRADIENT_COLOR2','#e4e4e4');
    define($sidebar.'_SIDEBAR_BG_IMAGE_SOLID_OVERLAY','rgba(0,0,0,0.2)');
    define($sidebar.'_SIDEBAR_BG_OVERLAY_GRADIENT_COLOR1','rgba(0,0,0,0.7)');
    define($sidebar.'_SIDEBAR_BG_OVERLAY_GRADIENT_COLOR2','rgba(255,255,255,0)');
    define($sidebar.'_SIDEBAR_BG_TEXTURE_OVERLAY',false);
    define($sidebar.'_SIDEBAR_BG_TEXTURE_OPACITY',0.50);
    define($sidebar.'_SIDEBAR_BG_TEXTURE',PIXFLOW_THEME_CUSTOMIZER_URI . '/assets/images/texture/1.png');
    define($sidebar.'_SIDEBAR_BG_TEXTURE_SOLID_OVERLAY','rgba(0,0,0,0.2)');
    define($sidebar.'_SIDEBAR_SHADOW_COLOR','rgba(0,0,0,0.2)');
}
/**************************************************
Branding Defaults
 **************************************************/
define('PIXFLOW_DARK_LOGO',PIXFLOW_THEME_IMAGES_URI . '/logo-dark.png');
define('PIXFLOW_LIGHT_LOGO',PIXFLOW_THEME_IMAGES_URI . '/logo-light.png');
define('PIXFLOW_PRELOADER_LOGO',PIXFLOW_THEME_IMAGES_URI . '/logo-preloader.png');
define('PIXFLOW_FAVICON',PIXFLOW_THEME_IMAGES_URI . '/favicon.ico');
/**************************************************
Typography Defaults
 **************************************************/
//h1
define('PIXFLOW_H1_NAME','Roboto');
define('PIXFLOW_H1_SIZE',70);
define('PIXFLOW_H1_WEIGHT',400);
define('PIXFLOW_H1_LINEHEIGHT',75);
define('PIXFLOW_H1_LETTERSPACE',0);
define('PIXFLOW_H1_COLOR','rgb(0,0,0)');
define('PIXFLOW_H1_STYLE','normal');

//h2
define('PIXFLOW_H2_NAME','Roboto');
define('PIXFLOW_H2_SIZE',60);
define('PIXFLOW_H2_WEIGHT',400);
define('PIXFLOW_H2_LINEHEIGHT',65);
define('PIXFLOW_H2_LETTERSPACE',0);
define('PIXFLOW_H2_COLOR','rgb(0,0,0)');
define('PIXFLOW_H2_STYLE','normal');

//h3
define('PIXFLOW_H3_NAME','Roboto');
define('PIXFLOW_H3_SIZE',50);
define('PIXFLOW_H3_WEIGHT',400);
define('PIXFLOW_H3_LINEHEIGHT',55);
define('PIXFLOW_H3_LETTERSPACE',0);
define('PIXFLOW_H3_COLOR','rgb(0,0,0)');
define('PIXFLOW_H3_STYLE','normal');

//h4
define('PIXFLOW_H4_NAME','Roboto');
define('PIXFLOW_H4_SIZE',40);
define('PIXFLOW_H4_WEIGHT',400);
define('PIXFLOW_H4_LINEHEIGHT',45);
define('PIXFLOW_H4_LETTERSPACE',0);
define('PIXFLOW_H4_COLOR','rgb(0,0,0)');
define('PIXFLOW_H4_STYLE','normal');

//h5
define('PIXFLOW_H5_NAME','Roboto');
define('PIXFLOW_H5_SIZE',30);
define('PIXFLOW_H5_WEIGHT',400);
define('PIXFLOW_H5_LINEHEIGHT',35);
define('PIXFLOW_H5_LETTERSPACE',0);
define('PIXFLOW_H5_COLOR','rgb(0,0,0)');
define('PIXFLOW_H5_STYLE','normal');

//h6
define('PIXFLOW_H6_NAME','Roboto');
define('PIXFLOW_H6_SIZE',20);
define('PIXFLOW_H6_WEIGHT',400);
define('PIXFLOW_H6_LINEHEIGHT',25);
define('PIXFLOW_H6_LETTERSPACE',0);
define('PIXFLOW_H6_COLOR','rgb(0,0,0)');
define('PIXFLOW_H6_STYLE','normal');

//Paragraph
define('PIXFLOW_P_NAME','Roboto');
define('PIXFLOW_P_SIZE',14);
define('PIXFLOW_P_WEIGHT',400);
define('PIXFLOW_P_LINEHEIGHT',14);
define('PIXFLOW_P_LETTERSPACE',0);
define('PIXFLOW_P_COLOR','rgb(0,0,0)');
define('PIXFLOW_P_STYLE','normal');

//Link
define('PIXFLOW_LINK_NAME','Roboto');
define('PIXFLOW_LINK_SIZE',14);
define('PIXFLOW_LINK_WEIGHT',400);
define('PIXFLOW_LINK_LINEHEIGHT',14);
define('PIXFLOW_LINK_LETTERSPACE',0);
define('PIXFLOW_LINK_COLOR','rgb(0,0,0)');
define('PIXFLOW_LINK_STYLE','normal');

// Charset
define('PIXFLOW_ADVANCE_CHAR',false);
define('PIXFLOW_CYRILLIC',0);
define('PIXFLOW_CYRILLIC_EXT',0);
define('PIXFLOW_LATIN',0);
define('PIXFLOW_LATIN_EXT',0);
define('PIXFLOW_GREEK',0);
define('PIXFLOW_GREEK_EXT',0);
define('PIXFLOW_VIETNAMESE',0);

/**************************************************
Socials Defaults
 **************************************************/

/**************************************************
Notification Center Defaults
 **************************************************/

define('PIXFLOW_NOTIFICATION_POST',true);
define('PIXFLOW_NOTIFICATION_PORTFOLIO',true);
define('PIXFLOW_NOTIFICATION_SEARCH',true);
define('PIXFLOW_NOTIFICATION_CART',false);
define('PIXFLOW_ACTIVE_TAB_SEC','posts');
define('PIXFLOW_NOTIFY_BG','dark');
define('PIXFLOW_NOTIFICATION_COLOR','rgb(181,169,114)');
define('PIXFLOW_NAV_ICON_SIZE',18);
define('PIXFLOW_NOTIFY_LOGO','');
define('PIXFLOW_POST_COUNT',5);
define('PIXFLOW_PROJECT_COUNT',5);
define('PIXFLOW_ACTIVE_ICON',1);