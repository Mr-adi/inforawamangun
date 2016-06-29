<?php
// Include customizer Plugin
include_once(PIXFLOW_THEME_CUSTOMIZER . '/customizer.php');

function pixflow_customizer_config()
{
    $args = array(
        'logo_image' => get_template_directory_uri() . '/assets/img/logo.png',
        'url_path' => get_template_directory_uri() . '/lib/customizer/',
        'stylesheet_id' => 'massive-dynamic',
    );
    return $args;
}
add_filter('customizer/config', 'pixflow_customizer_config');

/*
 * Create the sections
 */
function pixflow_customizer_sections($wp_customize)
{

    // Remove the "Navigation" menu so that we may add it manually using a different priority
    $wp_customize->remove_section('nav');
    $wp_customize->remove_section('colors');
    $wp_customize->remove_section('header_image');
    $wp_customize->remove_section('background_image');
    $wp_customize->remove_section('featured_content');
    $wp_customize->remove_section('static_front_page');

    $panels = array(
        'layout' => array('title' => esc_attr__('General Options', 'massive-dynamic'), 'description' => esc_attr__('Set theme layout', 'massive-dynamic'), 'priority' => 20),
        'header' => array('title' => esc_attr__('Header', 'massive-dynamic'), 'description' => esc_attr__('Make your own header here', 'massive-dynamic'), 'priority' => 30),
        'site_content' => array('title' => esc_attr__('Site Content', 'massive-dynamic'), 'description' => esc_attr__('Make your own header here', 'massive-dynamic'), 'priority' => 40),
        'footer' => array('title' => esc_attr__('Footer', 'massive-dynamic'), 'description' => esc_attr__('Set theme footer settings', 'massive-dynamic'), 'priority' => 50),
        'sidebar' => array('title' => esc_attr__('Sidebar', 'massive-dynamic'), 'description' => esc_attr__('Make your own sidebar here', 'massive-dynamic'), 'priority' => 60),
        'typography' => array('title' => esc_attr__('Typography', 'massive-dynamic'), 'description' => esc_attr__('Set theme font styles', 'massive-dynamic'), 'priority' => 80),
    );

    $sectionPriority = 0;
    $sections = array(
        'layout_sec' => array('title' => esc_attr__('Site Layout', 'massive-dynamic'), 'priority' => ++$sectionPriority, 'panel' => 'layout'),
        'front_page_sec' => array('title' => esc_attr__('Front Page', 'massive-dynamic'), 'priority' => ++$sectionPriority, 'panel' => 'layout'),
        'site_bg_sec' => array('title' => esc_attr__('Background', 'massive-dynamic'), 'priority' => ++$sectionPriority, 'panel' => 'layout'),
        'loading_sec' => array('title' => esc_attr__('Site Loading', 'massive-dynamic'), 'priority' => ++$sectionPriority, 'panel' => 'layout'),
        'portfolio_sec' => array('title' => esc_attr__('Portfolio Detail', 'massive-dynamic'), 'priority' => ++$sectionPriority, 'panel' => 'layout'),
        'custom_css' => array('title' => esc_attr__('Custom CSS', 'massive-dynamic'), 'priority' => ++$sectionPriority, 'panel' => 'layout'),
        'custom_js' => array('title' => esc_attr__('Custom JS', 'massive-dynamic'), 'priority' => ++$sectionPriority, 'panel' => 'layout'),
        'header_layout' => array('title' => esc_attr__('Header Layout', 'massive-dynamic'), 'priority' => ++$sectionPriority, 'panel' => 'header'),
        'header_style' => array('title' => esc_attr__('Appearance', 'massive-dynamic'), 'priority' => ++$sectionPriority, 'panel' => 'header'),
        'header_dropdown' => array('title' => esc_attr__('Drop Down & Mega Menu', 'massive-dynamic'), 'priority' => ++$sectionPriority, 'panel' => 'header'),
        'header_business_bar' => array('title' => esc_attr__('Business Bar', 'massive-dynamic'), 'priority' => ++$sectionPriority, 'panel' => 'header'),
        'nav_sec' => array('title' => esc_attr__('Typography', 'massive-dynamic'), 'priority' => ++$sectionPriority, 'panel' => 'header'),
        'responsive' => array('title' => esc_attr__('Responsive', 'massive-dynamic'), 'priority' => ++$sectionPriority, 'panel' => 'header'),
        'main_layout' => array('title' => esc_attr__('Main Layout', 'massive-dynamic'), 'priority' => ++$sectionPriority, 'panel' => 'site_content'),
        'main_bg_sec' => array('title' => esc_attr__('Background', 'massive-dynamic'), 'priority' => ++$sectionPriority, 'panel' => 'site_content'),
        'footer_layout' => array('title' => esc_attr__('Footer Layout', 'massive-dynamic'), 'priority' => ++$sectionPriority, 'panel' => 'footer'),
        'footer_bg_sec' => array('title' => esc_attr__('Appearance', 'massive-dynamic'), 'priority' => ++$sectionPriority, 'panel' => 'footer'),
        'footer_widget_area' => array('title' => esc_attr__('Widget Area', 'massive-dynamic'), 'priority' => ++$sectionPriority, 'panel' => 'footer'),
        'footer_bottom_area' => array('title' => esc_attr__('Copyright Area', 'massive-dynamic'), 'priority' => ++$sectionPriority, 'panel' => 'footer'),
        'footer_go_to_top_sec' => array('title' => esc_attr__('Go To Top Button', 'massive-dynamic'), 'priority' => ++$sectionPriority, 'panel' => 'footer'),
        'sidebar_general' => array('title' => esc_attr__('Page Sidebar', 'massive-dynamic'), 'priority' => ++$sectionPriority, 'panel' => 'sidebar'),
        'sidebar_blogPage' => array('title' => esc_attr__('Main Sidebar', 'massive-dynamic'), 'priority' => ++$sectionPriority, 'panel' => 'sidebar'),
        'sidebar_blogSingle' => array('title' => esc_attr__('Post Sidebar', 'massive-dynamic'), 'priority' => ++$sectionPriority, 'panel' => 'sidebar'),
        'branding' => array('title' => esc_attr__('Branding', 'massive-dynamic'), 'priority' => 70, 'panel' => ''),
        'h1_sec' => array('title' => esc_attr__('Heading 1', 'massive-dynamic'), 'priority' => ++$sectionPriority, 'panel' => 'typography'),
        'h2_sec' => array('title' => esc_attr__('Heading 2', 'massive-dynamic'), 'priority' => ++$sectionPriority, 'panel' => 'typography'),
        'h3_sec' => array('title' => esc_attr__('Heading 3', 'massive-dynamic'), 'priority' => ++$sectionPriority, 'panel' => 'typography'),
        'h4_sec' => array('title' => esc_attr__('Heading 4', 'massive-dynamic'), 'priority' => ++$sectionPriority, 'panel' => 'typography'),
        'h5_sec' => array('title' => esc_attr__('Heading 5', 'massive-dynamic'), 'priority' => ++$sectionPriority, 'panel' => 'typography'),
        'h6_sec' => array('title' => esc_attr__('Heading 6', 'massive-dynamic'), 'priority' => ++$sectionPriority, 'panel' => 'typography'),
        'p_sec' => array('title' => esc_attr__('Paragraph', 'massive-dynamic'), 'priority' => ++$sectionPriority, 'panel' => 'typography'),
        'link_sec' => array('title' => esc_attr__('Links', 'massive-dynamic'), 'priority' => ++$sectionPriority, 'panel' => 'typography'),
        'charset_sec' => array('title' => esc_attr__('Charset', 'massive-dynamic'), 'priority' => ++$sectionPriority, 'panel' => 'typography'),
        'social_item' => array('title' => esc_attr__('Social Links', 'massive-dynamic'), 'priority' => 90, 'panel' => ''),
        'notification_main' => array('title' => esc_attr__('Notification Center', 'massive-dynamic'), 'priority' => 100,'panel'=>''),
    );
    if(in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) || class_exists( 'WooCommerce' )){
        $sections['sidebar_shop'] = array('title' => esc_attr__('Shop Sidebar', 'massive-dynamic'), 'priority' => ++$sectionPriority, 'panel' => 'sidebar');
    }

    foreach ($panels as $panel => $args) {

        $wp_customize->add_panel($panel, array(
            'title' => $args['title'],
            'priority' => $args['priority'],
            'capability' => 'edit_theme_options',
            'theme_supports' => '',
            'description' => $args['description'],
        ));

    }

    foreach ($sections as $section => $args) {

        $wp_customize->add_section($section, array(
            'title' => $args['title'],
            'priority' => $args['priority'],
            'panel' => $args['panel']
        ));

    }
}

add_action('customize_register', 'pixflow_customizer_sections');

function pixflow_customizer_settings($controls)
{

    $priority = 0;
    //-------------------------------------------------
    // Site General Options Panel
    //-------------------------------------------------

    /******* Front Page Sec *******/
    $controls[] = array(
        'type' => 'select',
        'setting' => 'front_page_type',
        'label' => esc_attr__('Front Page Type','massive-dynamic'),
        'section' => 'front_page_sec',
        'default' => get_option('show_on_front'),
        'priority' => ++$priority,
        'class' => 'first glue',
        'choices' => array(
            'posts' => esc_attr__('Your latest posts', 'massive-dynamic'),
            'page' => esc_attr__('A static page', 'massive-dynamic'),
        ),
        'transport' => 'postMessage',
        'separator' => false
    ); // Front Page type

    $pagesDropDown = array(
        '0' => esc_attr__( 'Select page','massive-dynamic' )
    );
    $pages = get_pages();
    foreach ( $pages as $page ) {
        $pagesDropDown[$page->ID ] = $page->post_title;
    }
    $controls[] = array(
        'type' => 'select',
        'setting' => 'front_page_static_page',
        'label' => esc_attr__('Front Page','massive-dynamic'),
        'section' => 'front_page_sec',
        'default' => get_option('page_on_front'),
        'priority' => ++$priority,
        'class' => 'glue',
        'choices' => $pagesDropDown,
        'transport' => 'postMessage',
        'separator' => false,
        'required' => array(
            array('type' => 'select', 'setting' => 'front_page_type', 'value' => 'page'),
        )
    ); // Front Page - page id

    $controls[] = array(
        'type' => 'select',
        'setting' => 'front_page_posts_page',
        'label' => esc_attr__('Posts page','massive-dynamic'),
        'section' => 'front_page_sec',
        'default' => get_option('page_for_posts'),
        'priority' => ++$priority,
        'class' => 'glue last',
        'choices' => $pagesDropDown,
        'transport' => 'postMessage',
        'separator' => false,
        'required' => array(
            array('type' => 'select', 'setting' => 'front_page_type', 'value' => 'page'),
        )
    ); // Front Page - blog page id

    $controls[] = array(
        'type' => 'description',
        'class' => 'first glue last',
        'default' => esc_attr__('Here you choose front page and post page for your website.','massive-dynamic'),
        'setting' => 'front_page_description',
        'section' => 'front_page_sec',
        'priority' => ++$priority
    );

    /******* Layout Sec *******/
    $controls[] = array(
        'type' => 'slider',
        'class' => 'glue first',
        'setting' => 'site_width',
        'label' => esc_attr__('Site Width', 'massive-dynamic'),
        'section' => 'layout_sec',
        'default' => PIXFLOW_SITE_WIDTH,
        'priority' => ++$priority,
        'choices' => array(
            'min' => 40,
            'max' => 100,
            'step' => 1,
            'unit' => '%'
        ),
        'transport' => 'postMessage',
        'separator' => true

    );

    $controls[] = array(
        'type' => 'slider',
        'class' => 'glue last',
        'setting' => 'site_top',
        'label' => esc_attr__('Top Space', 'massive-dynamic'),
        'section' => 'layout_sec',
        'default' => PIXFLOW_SITE_TOP,
        'priority' => ++$priority,
        'choices' => array(
            'min' => 0,
            'max' => 200,
            'step' => .1,
            'unit' => 'px'
        ),
        'transport' => 'postMessage',
        'separator' => false
    );

    $controls[] = array(
        'type' => 'description',
        'default' => esc_attr__('Site width option will change the width of your website. Also top space will add a space to top of your website.','massive-dynamic'),
        'setting' => 'layout_sec_description',
        'section' => 'layout_sec',
        'priority' => ++$priority
    );

    function pixflow_backgroundControllers($prefix, $section, $label, $priority){
        $controllers = array();
        if(!isset($section) || !isset($prefix)|| !isset($label)){
            return $controllers;
        }
        $controllers[] = array(
            'type' => 'switch',
            'setting' => $prefix.'_bg',
            'label' => esc_attr__('Background', 'massive-dynamic'),
            'section' => $section,
            'default' => constant('PIXFLOW_'.strtoupper($prefix.'_BG')),
            'priority' => ++$priority,
            'class' => 'glue first last',
            'transport' => 'postMessage',
            'separator' => false,
            'text' => array('checked' => esc_attr__('on','massive-dynamic'), 'unchecked' => esc_attr__('off','massive-dynamic') ),
            'value' => 1
        ); // site background

        if($prefix == 'footer'){
            $class= 'glue first';
            $label = 'Type';
            $choices = array(
                'image' => esc_attr__('Image', 'massive-dynamic'),
                'texture' => esc_attr__('Texture', 'massive-dynamic'),
            );
        }else{
            $class= 'glue first triple';
            $label = '';
            $choices = array(
                'color' => esc_attr__('Color', 'massive-dynamic'),
                'image' => esc_attr__('Image', 'massive-dynamic'),
                'texture' => esc_attr__('Texture', 'massive-dynamic'),
            );
        }
        $controllers[] = array(
            'type' => 'radio',
            'mode' => 'buttonset',
            'setting' => $prefix.'_bg_type',
            'label' => $label,
            'section' => $section,
            'default' => constant('PIXFLOW_'.strtoupper($prefix.'_BG_TYPE')),
            'priority' => ++$priority,
            'class' => $class,
            'choices' => $choices,
            'transport' => 'postMessage',
            'separator' => false,
            'compare' => 'and',
        ); // site background type

        if($prefix != 'footer'){
            $controllers[] = array(
                'type' => 'radio',
                'mode' => 'buttonset',
                'setting' => $prefix.'_bg_color_type',
                'label' => esc_attr__('Type', 'massive-dynamic'),
                'section' => $section,
                'default' => constant('PIXFLOW_'.strtoupper($prefix.'_BG_COLOR_TYPE')),
                'priority' => ++$priority,
                'class' => 'glue first',
                'choices' => array(
                    'solid' => esc_attr__('Solid', 'massive-dynamic'),
                    'gradient' => esc_attr__('Gradient', 'massive-dynamic'),
                ),
                'transport' => 'postMessage',
                'separator' => true,
                'compare' => 'and',
                'required' => array(
                    array('type' => 'radio', 'setting' => $prefix.'_bg_type', 'value' => 'color'),
                )
            ); // Overlay Color type

            $controllers[] = array(
                'type' => 'rgba',
                'setting' => $prefix.'_bg_solid_color',
                'label' => esc_attr__('Solid Color', 'massive-dynamic'),
                'section' => $section,
                'priority' => ++$priority,
                'class' => 'glue last',
                'default' => constant('PIXFLOW_'.strtoupper($prefix.'_BG_SOLID_COLOR')),
                'transport' => 'postMessage',
                'opacity' => true,
                'compare' => 'and',
                'required' => array(
                    array('type' => 'radio', 'setting' => $prefix.'_bg_color_type', 'value' => 'solid'),
                    array('type' => 'radio', 'setting' => $prefix.'_bg_type', 'value' => 'color'),
                )
            ); // solid color

            $controllers[] = array(
                'type' => 'gradient',
                'setting' => $prefix.'_bg_gradient',
                'label' => esc_attr__('Preview', 'massive-dynamic'),
                'section' => $section,
                'priority' => ++$priority,
                'transport' => 'postMessage',
                'class' => 'glue',
                'compare' => 'and',
                'required' => array(
                    array('type' => 'radio', 'setting' => $prefix.'_bg_color_type', 'value' => 'gradient'),
                    array('type' => 'radio', 'setting' => $prefix.'_bg_type', 'value' => 'color'),
                ),
                'default' => array(
                    'color1' => constant('PIXFLOW_'.strtoupper($prefix.'_BG_GRADIENT_COLOR1')),
                    'color2' => constant('PIXFLOW_'.strtoupper($prefix.'_BG_GRADIENT_COLOR2')),
                ),
            ); // Gradient Color

            $priority = $priority + 5;


        }

        $controllers[] = array(
            'type' => 'background',
            'setting' => $prefix.'_bg_image',
            'label' => esc_attr__('Image Background', 'massive-dynamic'),
            'section' => $section,
            'default' => array(
                'color' => false,
                'size' => true,
                'image' => null,
                'repeat' => constant('PIXFLOW_'.strtoupper($prefix.'_BG_IMAGE_REPEAT')),
                'attach' => constant('PIXFLOW_'.strtoupper($prefix.'_BG_IMAGE_ATTACH')),
                'position' => constant('PIXFLOW_'.strtoupper($prefix.'_BG_IMAGE_POSITION')),
                'opacity' => true,
            ),
            'class' => 'glue first',
            'priority' => ++$priority,
            'divide' => 'top',
            'transport'=> 'postMessage',
            'required' => array(
                array('type' => 'radio', 'setting' => $prefix.'_bg_type', 'value' => 'image'),
            ),
        ); // Background Image

        $priority = $priority + 10;

        $controllers[] = array(
            'type' => 'switch',
            'setting' => $prefix.'_bg_image_overlay',
            'label' => esc_attr__('Color Overlay', 'massive-dynamic'),
            'section' => $section,
            'priority' => ++$priority,
            'class' => 'glue first last',
            'default' => constant('PIXFLOW_'.strtoupper($prefix.'_BG_IMAGE_OVERLAY')),
            'transport' => 'postMessage',
            'separator' => true,
            'text' => array('checked' => esc_attr__('on','massive-dynamic'), 'unchecked' => esc_attr__('off','massive-dynamic') ),
            'value' => 1,
            'required' => array(
                array('type' => 'radio', 'setting' => $prefix.'_bg_type', 'value' => 'image'),
            ),

        ); // image overlay

        $controllers[] = array(
            'type' => 'radio',
            'mode' => 'buttonset',
            'setting' => $prefix.'_bg_image_overlay_type',
            'label' => esc_attr__('Type', 'massive-dynamic'),
            'section' => $section,
            'default' => constant('PIXFLOW_'.strtoupper($prefix.'_BG_IMAGE_OVERLAY_TYPE')),
            'priority' => ++$priority,
            'class' => 'glue first',
            'choices' => array(
                'solid' => esc_attr__('Solid', 'massive-dynamic'),
                'gradient' => esc_attr__('Gradient', 'massive-dynamic'),
            ),
            'transport' => 'postMessage',
            'separator' => true,
            'compare' => 'and',
            'required' => array(
                array('type' => 'radio', 'setting' => $prefix.'_bg_type', 'value' => 'image'),
                array('type' => 'checkbox', 'setting' => $prefix.'_bg_image_overlay', 'value' => '1'),
            )
        ); // image Overlay Color type

        $controllers[] = array(
            'type' => 'rgba',
            'setting' => $prefix.'_bg_image_solid_overlay',
            'label' => esc_attr__('Solid Color', 'massive-dynamic'),
            'section' => $section,
            'priority' => ++$priority,
            'class' => 'glue last',
            'transport' => 'postMessage',
            'default' => constant('PIXFLOW_'.strtoupper($prefix.'_BG_IMAGE_SOLID_OVERLAY')),
            'opacity' => true,
            'compare' => 'and',
            'required' => array(
                array('type' => 'radio', 'setting' => $prefix.'_bg_image_overlay_type', 'value' => 'solid'),
                array('type' => 'radio', 'setting' => $prefix.'_bg_type', 'value' => 'image'),
                array('type' => 'checkbox', 'setting' => $prefix.'_bg_image_overlay', 'value' => '1'),
            )
        ); // image overlay solid color

        $controllers[] = array(
            'type' => 'gradient',
            'setting' => $prefix.'_bg_overlay_gradient',
            'label' => esc_attr__('Preview', 'massive-dynamic'),
            'section' => $section,
            'priority' => ++$priority,
            'transport' => 'postMessage',
            'class' => 'glue',
            'compare' => 'and',
            'required' => array(
                array('type' => 'radio', 'setting' => $prefix.'_bg_image_overlay_type', 'value' => 'gradient'),
                array('type' => 'radio', 'setting' => $prefix.'_bg_type', 'value' => 'image'),
                array('type' => 'checkbox', 'setting' => $prefix.'_bg_image_overlay', 'value' => '1'),
            ),
            'default' => array(
                'color1' => constant('PIXFLOW_'.strtoupper($prefix.'_BG_OVERLAY_GRADIENT_COLOR1')),
                'color2' => constant('PIXFLOW_'.strtoupper($prefix.'_BG_OVERLAY_GRADIENT_COLOR2')),
            ),
        ); // image overlay Gradient Color

        $priority = $priority + 5;

        $controllers[] = array(
            'type' => 'radio',
            'mode' => 'image',
            'setting' => $prefix.'_bg_texture',
            'label' => '',
            'section' => $section,
            'priority' => ++$priority,
            'default' => constant('PIXFLOW_'.strtoupper($prefix.'_BG_TEXTURE')),
            'panel' => 'layout',
            'choices' => array(
                PIXFLOW_THEME_CUSTOMIZER_URI . '/assets/images/texture/1.png' => PIXFLOW_THEME_CUSTOMIZER_URI . '/assets/images/texture/opt-1.png',
                PIXFLOW_THEME_CUSTOMIZER_URI . '/assets/images/texture/2.png' => PIXFLOW_THEME_CUSTOMIZER_URI . '/assets/images/texture/opt-2.png',
                PIXFLOW_THEME_CUSTOMIZER_URI . '/assets/images/texture/3.png' => PIXFLOW_THEME_CUSTOMIZER_URI . '/assets/images/texture/opt-3.png',
                PIXFLOW_THEME_CUSTOMIZER_URI . '/assets/images/texture/4.png' => PIXFLOW_THEME_CUSTOMIZER_URI . '/assets/images/texture/opt-4.png',
                PIXFLOW_THEME_CUSTOMIZER_URI . '/assets/images/texture/5.png' => PIXFLOW_THEME_CUSTOMIZER_URI . '/assets/images/texture/opt-5.png',
                PIXFLOW_THEME_CUSTOMIZER_URI . '/assets/images/texture/6.png' => PIXFLOW_THEME_CUSTOMIZER_URI . '/assets/images/texture/opt-6.png',
                PIXFLOW_THEME_CUSTOMIZER_URI . '/assets/images/texture/7.png' => PIXFLOW_THEME_CUSTOMIZER_URI . '/assets/images/texture/opt-7.png',
                PIXFLOW_THEME_CUSTOMIZER_URI . '/assets/images/texture/8.png' => PIXFLOW_THEME_CUSTOMIZER_URI . '/assets/images/texture/opt-8.png',
                PIXFLOW_THEME_CUSTOMIZER_URI . '/assets/images/texture/9.png' => PIXFLOW_THEME_CUSTOMIZER_URI . '/assets/images/texture/opt-9.png',
                PIXFLOW_THEME_CUSTOMIZER_URI . '/assets/images/texture/10.png' => PIXFLOW_THEME_CUSTOMIZER_URI . '/assets/images/texture/opt-10.png',
                PIXFLOW_THEME_CUSTOMIZER_URI . '/assets/images/texture/11.png' => PIXFLOW_THEME_CUSTOMIZER_URI . '/assets/images/texture/opt-11.png',
                PIXFLOW_THEME_CUSTOMIZER_URI . '/assets/images/texture/12.png' => PIXFLOW_THEME_CUSTOMIZER_URI . '/assets/images/texture/opt-12.png',
            ),
            'class' => 'glue footer-bg-texture',
            'compare' => 'and',
            'required' => array(array('type' => 'radio', 'setting' => $prefix.'_bg_type', 'value' => 'texture')),
            'transport' => 'postMessage',
            'separator' => true,

        ); // Textures

        $controllers[] = array(
            'type' => 'slider',
            'setting' => $prefix.'_bg_texture_opacity',
            'label' => esc_attr__('Opacity', 'massive-dynamic'),
            'section' => $section,
            'priority' => ++$priority,
            'default' => constant('PIXFLOW_'.strtoupper($prefix.'_BG_TEXTURE_OPACITY')),
            'choices' => array(
                'min' => 0,
                'max' => 1,
                'step' => 0.1,
            ),
            'transport' => 'postMessage',
            'class' => 'glue last',
            'compare' => 'and',
            'required' => array(array('type' => 'radio', 'setting' => $prefix.'_bg_type', 'value' => 'texture')),
        ); // Texture Opacity

        $controllers[] = array(
            'type' => 'switch',
            'setting' => $prefix.'_bg_texture_overlay',
            'label' => esc_attr__('Texture Overlay', 'massive-dynamic'),
            'section' => $section,
            'priority' => ++$priority,
            'class' => 'glue first last',
            'default' => constant('PIXFLOW_'.strtoupper($prefix.'_BG_TEXTURE_OVERLAY')),
            'transport' => 'postMessage',
            'separator' => true,
            'text' => array('checked' => esc_attr__('on','massive-dynamic'), 'unchecked' => esc_attr__('off','massive-dynamic') ),
            'value' => 1,
            'required' => array(
                array('type' => 'radio', 'setting' => $prefix.'_bg_type', 'value' => 'texture'),
            ),

        ); // texture overlay

        $controllers[] = array(
            'type' => 'rgba',
            'setting' => $prefix.'_bg_texture_solid_overlay',
            'label' => esc_attr__('Color', 'massive-dynamic'),
            'section' => $section,
            'priority' => ++$priority,
            'class' => 'glue last',
            'transport' => 'postMessage',
            'default' => constant('PIXFLOW_'.strtoupper($prefix.'_BG_TEXTURE_SOLID_OVERLAY')),
            'opacity' => true,
            'compare' => 'and',
            'required' => array(
                array('type' => 'radio', 'setting' => $prefix.'_bg_type', 'value' => 'texture'),
                array('type' => 'checkbox', 'setting' => $prefix.'_bg_texture_overlay', 'value' => '1'),
            )
        ); // texture overlay solid color

        $controllers[] = array(
            'type' => 'description',
            'default' => esc_attr__('Choose between different background types and settings.','massive-dynamic'),
            'setting' => $prefix.'_bg_overlay_description',
            'section' => $section,
            'priority' => ++$priority
        );
        return $controllers;
    }
    $controls = array_merge($controls,pixflow_backgroundControllers('site','site_bg_sec','Site',$priority));
    $priority = $priority + 100;

    /********* Loading Sec *********/
    $controls[] = array(
        'type' => 'radio',
        'mode' => 'buttonset',
        'setting' => 'loading_type',
        'label' => esc_attr__('Type', 'massive-dynamic'),
        'section' => 'loading_sec',
        'default' => PIXFLOW_LOADING_TYPE,
        'priority' => ++$priority,
        'class' => 'first glue',
        'choices' => array(
            'light' => esc_attr__('Light', 'massive-dynamic'),
            'dark' => esc_attr__('Dark', 'massive-dynamic'),
        ),
        'transport' => 'postMessage',
        'separator' => false,
        'compare' => 'and',
    );

    $controls[] = array(
        'type' => 'textarea',
        'setting' => 'loading_text',
        'label' => esc_attr__('Loading Text', 'massive-dynamic'),
        'section' => 'loading_sec',
        'default' => PIXFLOW_LOADING_TEXT,
        'priority' => ++$priority,
        'class' => 'glue last',
        'transport' => 'postMessage',
        'output' => false
    );
    $controls[] = array(
        'type' => 'description',
        'default' => '<a href="#" class="menu-page set-logo">'.esc_attr__("Set Logo","massive-dynamic").' </a> ',
        'setting' => 'loading_description',
        'section' => 'loading_sec',
        'priority' => ++$priority
    );
    // Portfolio Panel Options
    /******* Portfolio Css Sec *******/
    $controls[] = array(
        'type' => 'rgba',
        'setting' => 'portfolio_accent',
        'label' => esc_attr__('Accent Color', 'massive-dynamic'),
        'section' => 'portfolio_sec',
        'default' => PIXFLOW_PORTFOLIO_ACCENT,
        'priority' => ++$priority,
        'transport' => 'postMessage',
        'separator' => false,
        'opacity'   => false,
        'class' => 'glue',
    );

    $controls[] = array(
        'type' => 'description',
        'default' => esc_attr__('Set accent color for portfolio details here. You can open a portfolio detail which uses static layout and change the accent color to see how it works. ','massive-dynamic'),
        'setting' => 'portfolio_detail_description',
        'section' => 'portfolio_sec',
        'priority' => ++$priority
    );


    // Custom Scripts Panel Options
    /******* Custom Css Sec *******/
    $controls[] = array(
        'type' => 'textarea',
        'default' => '',
        'setting' => 'custom_css',
        'label' => esc_attr__('Custom CSS', 'massive-dynamic'),
        'section' => 'custom_css',
        'transport' => 'postMessage',
        'priority' => ++$priority,
        'output' => false
    );

    $controls[] = array(
        'type' => 'description',
        'default' => esc_attr__('To view the effect of your custom style, after putting your code in the box above, you should save your changes from "Save & View" button (that is placed on top of your work space), and then refresh the page.','massive-dynamic'),
        'setting' => 'custom_css_description',
        'section' => 'custom_css',
        'priority' => ++$priority
    );

    /******* Custom Js Sec *******/
    $controls[] = array(
        'type' => 'textarea',
        'default' => '',
        'setting' => 'custom_js',
        'label' => esc_attr__('Custom JS', 'massive-dynamic'),
        'section' => 'custom_js',
        'transport' => 'postMessage',
        'priority' => ++$priority,
        'output' => false
    );

    $controls[] = array(
        'type' => 'description',
        'default' => esc_attr__('To view the effect of your custom script, after putting your code in the box above, you should save your changes from "Save & View" button (that is placed on top of your work space), and then refresh the page.','massive-dynamic'),
        'setting' => 'custom_js_description',
        'section' => 'custom_js',
        'priority' => ++$priority
    );
    //-------------------------------------------------
    // Header Panel Options
    //-------------------------------------------------
    /******* Layout Sec *******/
    $controls[] = array(
        'type' => 'radio',
        'mode' => 'image',
        'setting' => 'header_position',
        'label' => esc_attr__('Header Position', 'massive-dynamic'),
        'section' => 'header_layout',
        'priority' => ++$priority,
        'class' => 'header-position bold-text',
        'default' => PIXFLOW_HEADER_POSITION,
        'choices' => array(
            'left' => PIXFLOW_THEME_CUSTOMIZER_URI . '/assets/images/layout-header-left.png',
            'top' => PIXFLOW_THEME_CUSTOMIZER_URI . '/assets/images/layout-header-top.png',
            'right' => PIXFLOW_THEME_CUSTOMIZER_URI . '/assets/images/layout-header-right.png',
        )
    );

    $controls[] = array(
        'type' => 'description',
        'default' => esc_attr__('You can choose between top or side header. Each option, gives you different choices for header styles.','massive-dynamic'),
        'setting' => 'header_position_description',
        'section' => 'header_layout',
        'priority' => ++$priority
    );

    //header Size

    $controls[] = array(
        'type' => 'titletext',
        'default' => esc_attr__('Header Size','massive-dynamic'),
        'setting' => 'header_size_title',
        'section' => 'header_layout',
        'priority' => ++$priority,
        'class' => 'glue first',
        'compare' => 'or',
        'required' => array(
            array('type' => 'radio','setting' => 'header_position','value' => 'top'),
            array('type' => 'select', 'setting' => 'header_side_theme', 'value' => 'classic'),
        )
    );

    $controls[] = array(
        'type' => 'slider',
        'setting' => 'header_top_width',
        'label' => esc_attr__('Header width', 'massive-dynamic'),
        'section' => 'header_layout',
        'default' => PIXFLOW_HEADER_TOP_WIDTH,
        'priority' => ++$priority,
        'choices' => array(
            'min' => 70,
            'max' => 100,
            'step' => 1,
            'unit' => '%'
        ),
        'class' => 'glue first',
        'transport' => 'postMessage',
        'separator' => true,
        'required' => array(
            array(
                'type' => 'radio',
                'setting' => 'header_position',
                'value' => 'top'
            )
        )
    );

    $controls[] = array(
        'type' => 'slider',
        'setting' => 'header-top-height',
        'label' => esc_attr__('Header Height', 'massive-dynamic'),
        'section' => 'header_layout',
        'default' => PIXFLOW_HEADER_TOP_HEIGHT,
        'priority' => ++$priority,
        'choices' => array(
            'min' => 70,
            'max' => 200,
            'step' => 1,
            'unit' => 'px'
        ),
        'class' => 'glue',
        'transport' => 'postMessage',
        'separator' => true,
        'required' => array(
            array(
                'type' => 'radio',
                'setting' => 'header_position',
                'value' => 'top'
            )
        )
    );

    $controls[] = array(
        'type' => 'slider',
        'setting' => 'header-side-width',
        'label' => esc_attr__('Header width', 'massive-dynamic'),
        'section' => 'header_layout',
        'default' => PIXFLOW_HEADER_SIDE_WIDTH,
        'priority' => ++$priority,
        'choices' => array(
            'min' => 10,
            'max' => 25,
            'step' => 1,
            'unit' => '%'
        ),
        'class' => 'glue',
        'transport' => 'postMessage',
        'required' => array(
            array(
                'type' => 'radio',
                'setting' => 'header_position',
                'value' => 'right'
            ),
            array(
                'type' => 'radio',
                'setting' => 'header_position',
                'value' => 'left'
            ),
        )
    );

    $controls[] = array(
        'type' => 'slider',
        'setting' => 'header-content',
        'label' => esc_attr__('Container Width', 'massive-dynamic'),
        'section' => 'header_layout',
        'default' => PIXFLOW_HEADER_CONTENT,
        'priority' => ++$priority,
        'choices' => array(
            'min' => 50,
            'max' => 100,
            'step' => 1,
            'unit' => '%'
        ),
        'separator' => true,
        'class' => 'glue',
        'transport' => 'postMessage',
        'required' => array(array('type' => 'radio', 'setting' => 'header_position', 'value' => 'top')),
    );

    $controls[] = array(
        'type'     => 'slider',
        'setting'  => 'header_top_position',
        'label'    => esc_attr__('Top Space', 'massive-dynamic'),
        'section'  => 'header_layout',
        'default'  => PIXFLOW_HEADER_TOP_POSITION,
        'priority' => ++$priority,
        'choices'  => array(
            'min'  => 0,
            'max'  => 70,
            'step' => 1,
            'unit' => 'px'
        ),
        'class'     => 'glue  bold-text last',
        'transport' => 'postMessage',
        'required'  => array(
            array(
                'type'    => 'radio',
                'setting' => 'header_position',
                'value'   => 'top'
            ),
        )
    );

    $controls[] = array(
        'type' => 'description',
        'default' => esc_attr__('You can change the size of header using the controllers above. Container is an invisible box around header items, change container width to make a box inside header.','massive-dynamic'),
        'setting' => 'header_layout_description_2',
        'section' => 'header_layout',
        'priority' => ++$priority,
        'class' => 'glue last',
        'compare' => 'or',
        'required' => array(
            array('type' => 'radio','setting' => 'header_position','value' => 'top'),
            array('type' => 'select', 'setting' => 'header_side_theme', 'value' => 'classic'),
        )

    );



    //menu model

    $controls[] = array(
        'type' => 'titletext',
        'default' => esc_attr__('Header Styles','massive-dynamic'),
        'setting' => 'nav_blend_description',
        'section' => 'header_layout',
        'priority' => ++$priority,
        'class' => 'glue',
        'separator' => true
    );

    //header top models
    $controls[] = array(
        'type' => 'select',
        'setting' => 'header_theme',
        'label' => esc_attr__('Style', 'massive-dynamic'),
        'section' => 'header_layout',
        'default' => PIXFLOW_HEADER_THEME,
        'class' => 'glue first',
        'separator' => true,
        'priority' => ++$priority,
        'choices' => array(
            'classic' => esc_attr__('Classic', 'massive-dynamic'),
            'block' => esc_attr__('Block', 'massive-dynamic'),
            'gather' => esc_attr__('Gather', 'massive-dynamic'),
            'logotop' => esc_attr__('Logo Top', 'massive-dynamic'),
            'modern' => esc_attr__('Modern', 'massive-dynamic')
        ),
        'transport' => 'refresh',
        'required' => array(array('type' => 'radio', 'setting' => 'header_position', 'value' => 'top'))
    );

    $controls[] = array(
        'type' => 'description',
        'default' => esc_attr__('Modern style has a unique functionality, it will divide all the header\'s elements into small boxes. Please note that you can\'t change container width in this style, also you can\'t change item\'s order.','massive-dynamic'),
        'setting' => 'header_modern_description',
        'section' => 'header_layout',
        'priority' => ++$priority,
        'class' => 'glue',
        'compare' => 'and',
        'required' => array(
            array('type' => 'radio', 'setting' => 'header_position', 'value' => 'top'),
            array('type' => 'select', 'setting' => 'header_theme', 'value' => 'modern')
        )
    );

    /******* Header Side Themes *******/
    $controls[] = array(
        'type' => 'select',
        'setting' => 'header_side_theme',
        'label' => esc_attr__('Style', 'massive-dynamic'),
        'section' => 'header_layout',
        'default' => PIXFLOW_HEADER_SIDE_THEME,
        'class' => 'glue',
        'priority' => ++$priority,
        'choices' => array(
            'standard' => esc_attr__('Classic', 'massive-dynamic'),
            'classic' => esc_attr__('Block', 'massive-dynamic'),
            'modern' => esc_attr__('Modern', 'massive-dynamic')
        ),
        'transport' => 'refresh',
        'separator' => true,
        'compare' => 'or',
        'required' => array(
            array('type' => 'radio', 'setting' => 'header_position', 'value' => 'left'),
            array('type' => 'radio', 'setting' => 'header_position', 'value' => 'right')
        )
    );

    $controls[] = array(
        'type' => 'select',
        'setting' => 'header_side_align',
        'label' => esc_attr__('Alignment', 'massive-dynamic'),
        'section' => 'header_layout',
        'default' => PIXFLOW_HEADER_SIDE_ALIGN,
        'class' => 'glue',
        'priority' => ++$priority,
        'choices' => array(
            'left' => esc_attr__('Left', 'massive-dynamic'),
            'center' => esc_attr__('Center', 'massive-dynamic'),
            'right' => esc_attr__('Right', 'massive-dynamic')
        ),
        'transport' => 'postMessage',
        'separator' => true,
        'compare' => 'or',
        'required' => array(
            array('type' => 'radio', 'setting' => 'header_position', 'value' => 'left'),
            array('type' => 'radio', 'setting' => 'header_position', 'value' => 'right')
        )
    );

    //header side modern menu style
    $controls[] = array(
        'type' => 'select',
        'label' => esc_attr__('Type', 'massive-dynamic'),
        'setting' => 'header_side_modern_style',
        'class' => 'glue',
        'section' => 'header_layout',
        'default' => PIXFLOW_HEADER_SIDE_MODERN_STYLE,
        'priority' => ++$priority,
        'class' => 'glue triple',
        'choices' => array(
            'style1' => esc_attr__('Simple', 'massive-dynamic'),
            'style2' => esc_attr__('Accordion', 'massive-dynamic'),
        ),
        'transport' => 'postMessage',
        'required' => array(
            array('type' => 'select', 'setting' => 'header_side_theme', 'value' => 'modern')
        )
    );

    $controls[] = array(
        'type' => 'switch',
        'setting' => 'header_side_footer',
        'label' => esc_attr__('Side Footer', 'massive-dynamic'),
        'section' => 'header_layout',
        'priority' => ++$priority,
        'transport' => 'postMessage',
        'class' => 'glue last',
        'text' => array('checked' => esc_attr__('on','massive-dynamic'), 'unchecked' => esc_attr__('off','massive-dynamic') ),
        'value' => 1,
        'default' => PIXFLOW_HEADER_SIDE_FOOTER,
        'required' => array(
            array('type' => 'radio', 'setting' => 'header_position', 'value' => 'left'),
            array('type' => 'radio', 'setting' => 'header_position', 'value' => 'right')
        )
    ); // On/Off side footer

    $controls[] = array(
        'type' => 'description',
        'default' => esc_attr__('Classic is great choice for most website, while Modern is a creative style for websites with a unique design. Block style stands somewhere between classic and modern styles. You can also disable side footer here.','massive-dynamic'),
        'setting' => 'header_description_side',
        'section' => 'header_layout',
        'priority' => ++$priority,
        'compare' => 'and',
        'class' => 'glue last',
        'compare' => 'or',
        'required' => array(
            array('type' => 'radio', 'setting' => 'header_position', 'value' => 'left'),
            array('type' => 'radio', 'setting' => 'header_position', 'value' => 'right')
        )
    );

    //end of side header options

    $controls[] = array(
        'type' => 'slider',
        'setting' => 'logotop_logoSpace',
        'label' => esc_attr__(' Logo Margin', 'massive-dynamic'),
        'section' => 'header_layout',
        'priority' => ++$priority,
        'default' => PIXFLOW_LOGOTOP_LOGOSPACE,
        'panel' => 'sidebar',
        'choices' => array(
            'min' => 10,
            'max' => 100,
            'step' => 1,
            'unit' => 'px'
        ),
        'transport' => 'postMessage',
        'class' => 'glue last',
        'compare' => 'and',
        'required' => array(
            array('type' => 'radio', 'setting' => 'header_position', 'value' => 'top'),
            array('type' => 'select', 'setting' => 'header_theme', 'value' => 'logotop')
        )
    );

    $controls[] = array(
        'type' => 'description',
        'default' => esc_attr__('Logo Top gives you an option to increase the space between logo and the items below it. Please note that you can\'t change container width in this style, also you can\'t change item\'s order.','massive-dynamic'),
        'setting' => 'header_logoTop_description',
        'class' => 'glue',
        'section' => 'header_layout',
        'priority' => ++$priority,
        'compare' => 'and',
        'required' => array(
            array('type' => 'radio', 'setting' => 'header_position', 'value' => 'top'),
            array('type' => 'select', 'setting' => 'header_theme', 'value' => 'logotop')
        )
    );

    $controls[] = array(
        'type' => 'select',
        'setting' => 'classic_style',
        'label' => esc_attr__('Type', 'massive-dynamic'),
        'section' => 'header_layout',
        'default' => PIXFLOW_CLASSIC_STYLE,
        'priority' => ++$priority,
        'choices' => array(
            'none' => esc_attr__('None', 'massive-dynamic'),
            'dot' => esc_attr__('Dot', 'massive-dynamic'),
            'dash' => esc_attr__('Dash', 'massive-dynamic'),
            'slash' => esc_attr__('Slash', 'massive-dynamic'),
            'border' => esc_attr__('Border', 'massive-dynamic'),
            'wireframe' => esc_attr__('Wireframe', 'massive-dynamic'),
        ),
        'class' => 'glue last',
        'transport' => 'postMessage',
        'compare' => 'and',
        'required' => array(
            array('type' => 'radio', 'setting' => 'header_position', 'value' => 'top'),
            array('type' => 'select', 'setting' => 'header_theme', 'value' => 'classic')
        )
    );

    $controls[] = array(
        'type' => 'description',
        'default' => esc_attr__('A standard and beautiful style for all websites, it comes with different separators.','massive-dynamic'),
        'setting' => 'classic_style_description',
        'class' => 'glue',
        'section' => 'header_layout',
        'priority' => ++$priority,
        'compare' => 'and',
        'required' => array(
            array('type' => 'radio', 'setting' => 'header_position', 'value' => 'top'),
            array('type' => 'select', 'setting' => 'header_theme', 'value' => 'classic')
        )
    );

    $controls[] = array(
        'type' => 'select',
        'setting' => 'block_style',
        'label' => esc_attr__('Type', 'massive-dynamic'),
        'section' => 'header_layout',
        'default' => PIXFLOW_BLOCK_STYLE,
        'class' => 'glue last',
        'priority' => ++$priority,
        'transport' => 'refresh',
        'choices' => array(
            'style1' => esc_attr__('Rectangle', 'massive-dynamic'),
            'style2' => esc_attr__('Square', 'massive-dynamic')
        ),
        'compare' => 'and',
        'required' => array(
            array('type' => 'radio', 'setting' => 'header_position', 'value' => 'top'),
            array('type' => 'select', 'setting' => 'header_theme', 'value' => 'block')
        )
    );

    $controls[] = array(
        'type' => 'description',
        'default' => esc_attr__('A boxed shape style which works best with menu items that have icon. To set icons for your navigation, go to dashboard > appearance > menus.','massive-dynamic'),
        'setting' => 'header_block_description',
        'section' => 'header_layout',
        'priority' => ++$priority,
        'class' => 'glue',
        'compare' => 'and',
        'required' => array(
            array('type' => 'radio', 'setting' => 'header_position', 'value' => 'top'),
            array('type' => 'select', 'setting' => 'header_theme', 'value' => 'block')
        )
    );

    $controls[] = array(
        'type' => 'select',
        'setting' => 'gather_style',
        'label' => esc_attr__('Type', 'massive-dynamic'),
        'section' => 'header_layout',
        'default' => PIXFLOW_GATHER_STYLE,
        'class' => 'glue last',
        'priority' => ++$priority,
        'transport' => 'refresh',
        'choices' => array(
            'style1' => esc_attr__('Clean', 'massive-dynamic'),
            'style2' => esc_attr__('Block', 'massive-dynamic'),
        ),
        'compare' => 'and',
        'required' => array(
            array('type' => 'radio', 'setting' => 'header_position', 'value' => 'top'),
            array('type' => 'select', 'setting' => 'header_theme', 'value' => 'gather')
        )
    );

    $controls[] = array(
        'type' => 'description',
        'default' => esc_attr__('A modern header style which opens a popup to display the navigation, to change popup colors go Header settings > appearance > popup styles.','massive-dynamic'),
        'setting' => 'header_gather_description',
        'class' => 'glue',
        'section' => 'header_layout',
        'priority' => ++$priority,
        'compare' => 'and',
        'required' => array(
            array('type' => 'radio', 'setting' => 'header_position', 'value' => 'top'),
            array('type' => 'select', 'setting' => 'header_theme', 'value' => 'gather')
        )
    );

    $controls[] = array(
        'type' => 'titletext',
        'default' => esc_attr__('Header Scroll Behavior','massive-dynamic'),
        'setting' => 'header_scroll_title',
        'section' => 'header_layout',
        'priority' => ++$priority,
        'class' => 'glue first',
        'required' => array(
            array(
                'type' => 'radio',
                'setting' => 'header_position',
                'value' => 'top'
            )
        )
    );

    $controls[] = array(
        'type' => 'select',
        'setting' => 'header_styles',
        'label' => esc_attr__('Behavior', 'massive-dynamic'),
        'section' => 'header_layout',
        'default' => PIXFLOW_HEADER_STYLES,
        'class' => 'glue',
        'priority' => ++$priority,
        'choices' => array(
            'style1' => esc_attr__('Don\'t Move', 'massive-dynamic'),
            'style2' => esc_attr__('Move', 'massive-dynamic'),
            'style3' => esc_attr__('Appear After', 'massive-dynamic'),
        ),
        'transport' => 'postMessage',
        'separator' => true,
        'required' => array(
            array(
                'type' => 'radio',
                'setting' => 'header_position',
                'value' => 'top'
            )
        )
    ); // Header Styles

    $controls[] = array(
        'type' => 'slider',
        'setting' => 'show_up_after',
        'label' => esc_attr__('Show Up After', 'massive-dynamic'),
        'section' => 'header_layout',
        'default' => PIXFLOW_SHOW_UP_AFTER,
        'priority' => ++$priority,
        'choices' => array(
            'min' => 200,
            'max' => 1000,
            'step' => 1,
            'unit' => 'px'
        ),
        'class' => 'glue',
        'transport' => 'postMessage',
        'separator' => true,
        'compare' => 'and',
        'required' => array(
            array('type' => 'radio', 'setting' => 'header_position', 'value' => 'top'),
            array('type' => 'select', 'setting' => 'header_styles', 'value' => 'style3'),
        )
    );

    $controls[] = array(
        'type' => 'select',
        'setting' => 'show_up_style',
        'label' => esc_attr__('Show Up Style', 'massive-dynamic'),
        'section' => 'header_layout',
        'default' => PIXFLOW_SHOW_UP_STYLE,
        'priority' => ++$priority,
        'choices' => array(
            'fade_in' => esc_attr__('Fade In', 'massive-dynamic'),
            'slide_in' => esc_attr__('Slide', 'massive-dynamic')
        ),
        'class' => 'glue last',
        'transport' => 'postMessage',
        'compare' => 'and',
        'required' => array(
            array('type' => 'radio', 'setting' => 'header_position', 'value' => 'top'),
            array('type' => 'select', 'setting' => 'header_styles', 'value' => 'style3'),
        )
    );

    $controls[] = array(
        'type' => 'description',
        'default' => esc_attr__('The names are self-explanatory. If you choose Appear After, you\'ll have an option to set the distance to display the second header after that. Also you can choose colors for second headers in Header > appearance.','massive-dynamic'),
        'setting' => 'header_scroll_description',
        'class' => 'glue',
        'section' => 'header_layout',
        'priority' => ++$priority,
        'required' => array(
            array(
                'type' => 'radio',
                'setting' => 'header_position',
                'value' => 'top'
            )
        )
    );

    $controls[] = array(
        'type' => 'text',
        'default' => '',
        'setting' => 'header_items_order',
        'label' => esc_attr__('Order', 'massive-dynamic'),
        'section' => 'header_layout',
        'transport' => 'postMessage',
        'priority' => ++$priority,
        'output' => false
    );
    /******* Header Top Themes *******/

    $controls[] = array(
        'type' => 'titletext',
        'default' => esc_attr__('Navigation Item Style','massive-dynamic'),
        'setting' => 'header_item_content',
        'section' => 'header_layout',
        'priority' => ++$priority,
        'class' => 'glue',
    );

    $controls[] = array(
        'type' => 'select',
        'setting' => 'menu_item_style',
        'label' => esc_attr__('Style', 'massive-dynamic'),
        'section' => 'header_layout',
        'default' => PIXFLOW_MENU_ITEM_STYLE,
        'priority' => ++$priority,
        'class' => 'first last glue',
        'choices' => array(
            'text' => esc_attr__('Text', 'massive-dynamic'),
            'icon' => esc_attr__('Icon', 'massive-dynamic'),
            'icon-text' => esc_attr__('Icon & Text', 'massive-dynamic'),
        ),
        'transport' => 'postMessage'
    ); // Menu item style

    $controls[] = array(
        'type' => 'description',
        'default' => esc_attr__('You can choose to display menu items in different styles. Please note that if you choose Block - Square style, this setting will not work.','massive-dynamic'),
        'setting' => 'appearance_menu_item',
        'section' => 'header_layout',
        'priority' => ++$priority,
        'class' => 'glue',
    ); // Description

    /* Description for block style 2 selected  */

    $controls[] = array(
        'type' => 'titletext',
        'default' => esc_attr__('Primary Header','massive-dynamic'),
        'setting' => 'header_first_description',
        'section' => 'header_style',
        'priority' => ++$priority,
        'class' => 'first glue',
        'separator' => true,
    );

    $controls[] = array(
        'type' => 'rgba',
        'setting' => 'nav_color',
        'label' => esc_attr__('Item\'s Color', 'massive-dynamic'),
        'section' => 'header_style',
        'default' => PIXFLOW_NAV_COLOR,
        'priority' => ++$priority,
        'transport' => 'postMessage',
        'opacity' => false,
        'class' => 'glue',
        'separator' => true,
    );// Menu Color

    $controls[] = array(
        'type' => 'rgba',
        'setting' => 'nav_hover_color',
        'label' => esc_attr__('Item\'s Hover Color', 'massive-dynamic'),
        'section' => 'header_style',
        'default' => PIXFLOW_NAV_HOVER_COLOR,
        'priority' => ++$priority,
        'transport' => 'postMessage',
        'separator' => true,
        'class' => 'glue',
    );// Menu Hover Color

    $controls[] = array(
        'type' => 'select',
        'label' => esc_attr__('Bg Type', 'massive-dynamic'),
        'setting' => 'header_bg_color_type',
        'section' => 'header_style',
        'default' => PIXFLOW_HEADER_BG_COLOR_TYPE,
        'priority' => ++$priority,
        'class' => 'glue triple',
        'choices' => array(
            'solid' => esc_attr__('Solid', 'massive-dynamic'),
            'gradient' => esc_attr__('Gradient', 'massive-dynamic'),
        ),
        'transport' => 'postMessage',
        'separator' => true
    ); // Overlay Color type

    $controls[] = array(
        'type' => 'rgba',
        'setting' => 'header_bg_solid_color',
        'label' => esc_attr__('Solid Color', 'massive-dynamic'),
        'section' => 'header_style',
        'priority' => ++$priority,
        'default' => PIXFLOW_HEADER_BG_SOLID_COLOR,
        'class' => 'glue',
        'transport' => 'postMessage',
        'separator' => true,
        'opacity' => true,
        'required' => array(array('type' => 'select', 'setting' => 'header_bg_color_type', 'value' => 'solid')),

    ); // solid color

    $controls[] = array(
        'type' => 'gradient',
        'setting' => 'header_bg_gradient',
        'label' => esc_attr__('Preview', 'massive-dynamic'),
        'section' => 'header_style',
        'priority' => ++$priority,
        'transport' => 'postMessage',
        'class' => 'glue',
        'separator' => false,
        'required' => array(array('type' => 'select', 'setting' => 'header_bg_color_type', 'value' => 'gradient')),
        'default' => array(
            'color1' => PIXFLOW_HEADER_BG_GRADIENT_COLOR1,
            'color2' => PIXFLOW_HEADER_BG_GRADIENT_COLOR2,
        ),
    ); // Gradient Color

    $priority = $priority + 5;

    $controls[] = array(
        'type' => 'select',
        'setting' => 'logo_style',
        'label' => esc_attr__('Logo Style', 'massive-dynamic'),
        'section' => 'header_style',
        'default' => PIXFLOW_LOGO_STYLE,
        'class' => 'glue ',
        'separator' => true,
        'priority' => ++$priority,
        'choices' => array(
            'dark' => esc_attr__('Dark', 'massive-dynamic'),
            'light' => esc_attr__('Light', 'massive-dynamic'),
        ),
        'transport' => 'postMessage'
    );

    $controls[] = array(
        'type' => 'switch',
        'setting' => 'header_border_enable',
        'label' => esc_attr__('Header Border', 'massive-dynamic'),
        'section' => 'header_style',
        'priority' => ++$priority,
        'transport' => 'postMessage',
        'separator' => false,
        'class' => 'glue ',
        'text' => array('checked' => 'on', 'unchecked' => 'off'),
        'value' => 1,
        'default' => PIXFLOW_HEADER_BORDER_ENABLE,
    ); // On/Off business Bar

    $controls[] = array(
        'type' => 'description',
        'default' => esc_attr__('These are the appearance settings for primary header. Header border will add a border to bottom of header, it\'s useful for having a transparent header. Header will automatically get a border if you choose wireframe style for classic top header. For adding dark and light logo, you should upload them in Branding section first.','massive-dynamic'),
        'setting' => 'header_second_description',
        'class' => 'glue last',
        'section' => 'header_style',
        'priority' => ++$priority
    );

    /* Gather Popup Menu */
    $controls[] = array(
        'type' => 'titletext',
        'default' => esc_attr__('Popup Styles','massive-dynamic'),
        'setting' => 'popup_menu',
        'section' => 'header_style',
        'priority' => ++$priority,
        'class' => 'first glue',
        'separator' => true,
        'compare' => 'and',
        'required' => array(
            array('type' => 'radio', 'setting' => 'header_position', 'value' => 'top'),
            array('type' => 'select', 'setting' => 'header_theme', 'value' => 'gather')
        )
    );

    $controls[] = array(
        'type' => 'rgba',
        'setting' => 'popup_menu_color',
        'label' => esc_attr__('Item\'s Color', 'massive-dynamic'),
        'section' => 'header_style',
        'default' => PIXFLOW_POPUP_MENU_COLOR,
        'priority' => ++$priority,
        'transport' => 'postMessage',
        'opacity' => false,
        'class' => 'glue',
        'separator' => true,
        'compare' => 'and',
        'required' => array(
            array('type' => 'radio', 'setting' => 'header_position', 'value' => 'top'),
            array('type' => 'select', 'setting' => 'header_theme', 'value' => 'gather')
        )
    );

    $controls[] = array(
        'type' => 'rgba',
        'setting' => 'overlay_bg',
        'label' => esc_attr__('Popup Background Color', 'massive-dynamic'),
        'section' => 'header_style',
        'priority' => ++$priority,
        'class' => 'glue',
        'default' => PIXFLOW_OVERLAY_BG,
        'transport' => 'postMessage',
        'opacity' => true,
        'compare' => 'and',
        'required' => array(
            array('type' => 'radio', 'setting' => 'header_position', 'value' => 'top'),
            array('type' => 'select', 'setting' => 'header_theme', 'value' => 'gather')
        )
    );

    $controls[] = array(
        'type' => 'description',
        'default' => esc_attr__('You can change popup colors here, try changing the opacity of background color for a better look.','massive-dynamic'),
        'setting' => 'header_gather_description1',
        'section' => 'header_style',
        'priority' => ++$priority,
        'compare' => 'and',
        'class' => 'glue last',
        'required' => array(
            array('type' => 'radio', 'setting' => 'header_position', 'value' => 'top'),
            array('type' => 'select', 'setting' => 'header_theme', 'value' => 'gather')
        )
    );

    $controls[] = array(
        'type' => 'background',
        'setting' => 'header_side_image',
        'label' => esc_attr__('Background Image', 'massive-dynamic'),
        'section' => 'header_style',
        'priority' => ++$priority,
        'default' => array(
            'image' => null,
            'position' => PIXFLOW_HEADER_SIDE_IMAGE_POSITION,
            'repeat' => PIXFLOW_HEADER_SIDE_IMAGE_REPEAT,
            'color' => false,
            'size' => true,
            'attach' => false,
            'opacity' => false,
        ),
        'output' => false,
        'panel' => 'header',
        'divide' => 'top',
        'transport' => 'postMessage',
        'class' => 'glue ',
        'compare' => 'or',
        'required' => array(
            array('type' => 'select', 'setting' => 'header_side_theme', 'value' => 'classic'),
            array('type' => 'select', 'setting' => 'header_side_theme', 'value' => 'standard'),
        )
    );

    $priority = $priority + 5;

    $controls[] = array(
        'type' => 'description',
        'default' => esc_attr__('Choose your desired options to create a beautiful side header.','massive-dynamic'),
        'setting' => 'header_side_image_description',
        'section' => 'header_style',
        'priority' => ++$priority,
        'compare' => 'or',
        'class' => 'glue last',
        'required' => array(
            array('type' => 'select', 'setting' => 'header_side_theme', 'value' => 'classic'),
            array('type' => 'select', 'setting' => 'header_side_theme', 'value' => 'standard'),
        )
    );

// second section
    $controls[] = array(
        'type' => 'titletext',
        'default' => esc_attr__('Secondary Header','massive-dynamic'),
        'setting' => 'header_second_title',
        'section' => 'header_style',
        'priority' => ++$priority,
        'compare' => 'and',
        'class' => 'first glue',
        'separator' => true,
        'required' => array(
            array('type' => 'radio', 'setting' => 'header_position', 'value' => 'top')
        )
    );

    $controls[] = array(
        'type' => 'rgba',
        'setting' => 'nav_color_second',
        'label' => esc_attr__('Item\'s Color', 'massive-dynamic'),
        'section' => 'header_style',
        'default' => PIXFLOW_NAV_COLOR_SECOND,
        'priority' => ++$priority,
        'transport' => 'postMessage',
        'class' => 'glue',
        'separator' => true,
        'required' => array(
            array('type' => 'radio', 'setting' => 'header_position', 'value' => 'top')
        )
    );// Menu Color

    $controls[] = array(
        'type' => 'rgba',
        'setting' => 'nav_hover_color_second',
        'label' => esc_attr__('Item\'s Hover Color', 'massive-dynamic'),
        'section' => 'header_style',
        'default' => PIXFLOW_NAV_HOVER_COLOR_SECOND,
        'priority' => ++$priority,
        'transport' => 'postMessage',
        'class' => 'glue',
        'separator' => true,
        'required' => array(
            array('type' => 'radio', 'setting' => 'header_position', 'value' => 'top')
        )
    );// Menu Hover Color

    /******* Background Sec  *******/
    $controls[] = array(
        'type' => 'select',
        'label' => esc_attr__('Bg Type','massive-dynamic'),
        'setting' => 'header_bg_color_type_second',
        'section' => 'header_style',
        'default' => PIXFLOW_HEADER_BG_COLOR_TYPE_SECOND,
        'priority' => ++$priority,
        'class' => 'glue triple',
        'choices' => array(
            'solid' => esc_attr__('Solid', 'massive-dynamic'),
            'gradient' => esc_attr__('Gradient', 'massive-dynamic'),
        ),
        'transport' => 'postMessage',
        'separator' => true,
        'compare' => 'and',
        'required' => array(
            array('type' => 'radio', 'setting' => 'header_position', 'value' => 'top')
        )
    ); // Overlay Color type

    $controls[] = array(
        'type' => 'rgba',
        'setting' => 'header_bg_solid_color_second',
        'label' => esc_attr__('Solid Color', 'massive-dynamic'),
        'section' => 'header_style',
        'priority' => ++$priority,
        'class' => 'glue',
        'transport' => 'postMessage',
        'default' => PIXFLOW_HEADER_BG_SOLID_COLOR_SECOND,
        'opacity' => true,
        'separator' => true,
        'compare' => 'and',
        'required' => array(
            array('type' => 'radio', 'setting' => 'header_position', 'value' => 'top'),
            array('type' => 'select', 'setting' => 'header_bg_color_type_second', 'value' => 'solid'))
    ); // solid color

    $controls[] = array(
        'type' => 'gradient',
        'setting' => 'header_bg_gradient_second',
        'label' => esc_attr__('Preview', 'massive-dynamic'),
        'section' => 'header_style',
        'priority' => ++$priority,
        'transport' => 'postMessage',
        'class' => 'glue',
        'compare' => 'and',
        'separator' => false,
        'required' => array(
            array('type' => 'radio', 'setting' => 'header_position', 'value' => 'top'),
            array('type' => 'select', 'setting' => 'header_bg_color_type_second', 'value' => 'gradient')),
        'default' => array(
            'color1' => PIXFLOW_HEADER_BG_GRADIENT_SECOND_COLOR1,
            'color2' => PIXFLOW_HEADER_BG_GRADIENT_SECOND_COLOR2,
        ),
    ); // Gradient Color

    $priority = $priority + 5;

    $controls[] = array(
        'type' => 'select',
        'setting' => 'logo_style_second',
        'label' => esc_attr__('Logo Style', 'massive-dynamic'),
        'section' => 'header_style',
        'default' => PIXFLOW_LOGO_STYLE_SECOND,
        'class' => 'glue',
        'priority' => ++$priority,
        'choices' => array(
            'dark' => esc_attr__('Dark', 'massive-dynamic'),
            'light' => esc_attr__('Light', 'massive-dynamic'),
        ),
        'transport' => 'postMessage',
        'required' => array(
            array('type' => 'radio', 'setting' => 'header_position', 'value' => 'top')
        )
    );

    $controls[] = array(
        'type' => 'description',
        'default' => esc_attr__('Choose the appearance for secondary header. This header is the one that appears after you scroll down.(It only appears if you choose Move or Appear After in Scroll Behavior).','massive-dynamic'),
        'setting' => 'header_bg_overlay_description_second',
        'section' => 'header_style',
        'priority' => ++$priority,
        'class' => 'glue last',
        'compare' => 'and',
        'required' => array(
            array('type' => 'radio', 'setting' => 'header_position', 'value' => 'top'),
        )
    );

    // Changed bg position
    /******* Background Sec  *******/
    $priority = $priority + 10;
    $controls[] = array(
        'type' => 'radio',
        'mode' => 'buttonset',
        'setting' => 'drop_down_style',
        'label' => esc_attr__('Style', 'massive-dynamic'),
        'section' => 'header_dropdown',
        'default' => PIXFLOW_DROP_DOWN_STYLE,
        'class' => 'glue first last',
        'priority' => ++$priority,
        'choices' => array(
            'simple' => esc_attr__('Simple', 'massive-dynamic'),
            'side-line' => esc_attr__('Side Line', 'massive-dynamic'),
        ),
        'required' => array(
            array('type' => 'radio', 'setting' => 'header_position', 'value' => 'top'),
        ),
        'transport' => 'postMessage'
    );

    $controls[] = array(
        'type' => 'titletext',
        'default' => esc_attr__('Appearance', 'massive-dynamic'),
        'setting' => 'drop_bg_title',
        'section' => 'header_dropdown',
        'class' => 'glue first',
        'separator' => true,
        'priority' => ++$priority
    );

    $controls[] = array(
        'type' => 'rgba',
        'setting' => 'dropdown_bg_solid_color',
        'label' => esc_attr__('Background Color', 'massive-dynamic'),
        'section' => 'header_dropdown',
        'priority' => ++$priority,
        'class' => 'glue ',
        'transport' => 'postMessage',
        'separator' => true,
        'default' => PIXFLOW_DROPDOWN_BG_SOLID_COLOR,
        'opacity' => true
    ); // solid color

    $controls[] = array(
        'type' => 'rgba',
        'setting' => 'dropdown_heading_solid_color',
        'label' => esc_attr__('Heading Color', 'massive-dynamic'),
        'section' => 'header_dropdown',
        'priority' => ++$priority,
        'class' => 'glue',
        'transport' => 'postMessage',
        'separator' => true,
        'default' => PIXFLOW_DROPDOWN_HEADING_SOLID_COLOR,
        'opacity' => false
    ); // solid color

    $controls[] = array(
        'type' => 'rgba',
        'setting' => 'dropdown_fg_solid_color',
        'label' => esc_attr__('Element\'s Color', 'massive-dynamic'),
        'section' => 'header_dropdown',
        'priority' => ++$priority,
        'class' => 'glue',
        'transport' => 'postMessage',
        'separator' => true,
        'default' => PIXFLOW_DROPDOWN_FG_SOLID_COLOR,
        'opacity' => false
    ); // solid color

    $controls[] = array(
        'type' => 'rgba',
        'setting' => 'dropdown_fg_hover_color',
        'label' => esc_attr__('Element\'s Hover Color', 'massive-dynamic'),
        'section' => 'header_dropdown',
        'priority' => ++$priority,
        'class' => 'glue last',
        'default' => PIXFLOW_DROPDOWN_FG_HOVER_COLOR,
        'transport' => 'postMessage',
        'opacity' => true,
        'separator' => true
    ); // solid color


    $url = admin_url().'nav-menus.php';
    $controls[] = array(
        'type' => 'description',
        'default' => '<a target="_blank" href="'.$url.'" class="menu-page">'.esc_attr__("Edit Menu","massive-dynamic").' </a> <h6>'.esc_attr__('HOW TO CREATE MEGA MENU','massive-dynamic').'</h6><ol class="menu"><li>'.esc_attr__('Click button above and go to menu panel.','massive-dynamic').'</li><li>'.esc_attr__('Click on a first-level menu item and check the mega menu option.','massive-dynamic').'</li><li>'.esc_attr__('Now drag&drop menu items under the first-level menu item, give them an indent, so they become the sub-menu of first-level menu item.','massive-dynamic').'</li></ol>'.'<span class="menu-img"><span>',
        'setting' => 'header_dropdown_description',
        'section' => 'header_dropdown',
        'priority' => ++$priority,
        'class' => 'glue last',
    );

    /******* Menu Typography *******/
    $controls[] = array(
        'type' => 'select',
        'setting' => 'nav_name',
        'panel' => 'typo',
        'label' => esc_attr__('Font Family', 'massive-dynamic'),
        'section' => 'nav_sec',
        'default' => PIXFLOW_NAV_NAME,
        'priority' => ++$priority,
        'choices' => array(pixflow_get_theme_mod('nav_name',PIXFLOW_NAV_NAME)),
        'class' => 'glue first font-picker',
        'transport' => 'refresh',
        'separator' => 'true',
    );// Font Name

    $controls[] = array(
        'type' => 'slider',
        'setting' => 'nav_size',
        'label' => esc_attr__('Size', 'massive-dynamic'),
        'section' => 'nav_sec',
        'default' => PIXFLOW_NAV_SIZE,
        'priority' => ++$priority,
        'choices' => array(
            'min' => 10,
            'max' => 20,
            'step' => 1,
            'unit' => 'px'
        ),
        'class' => 'glue',
        'transport' => 'postMessage',
        'separator' => 'true',
    );// font size

    $controls[] = array(
        'type' => 'slider',
        'setting' => 'nav_weight',
        'label' => esc_attr__('Weight', 'massive-dynamic'),
        'section' => 'nav_sec',
        'default' => PIXFLOW_NAV_WEIGHT,
        'priority' => ++$priority,
        'choices' => array(
            'min' => 100,
            'max' => 800,
            'step' => 100,
        ),
        'class' => 'glue',
        'separator' => 'true',
        'transport' => 'refresh',
    );// font weight

    $controls[] = array(
        'type' => 'slider',
        'setting' => 'nav_letterSpace',
        'label' => esc_attr__('Letter Spacing', 'massive-dynamic'),
        'section' => 'nav_sec',
        'default' => PIXFLOW_NAV_LETTERSPACE,
        'priority' => ++$priority,
        'choices' => array(
            'min' => 0,
            'max' => 10,
            'step' => 0.01,
            'unit' => 'px'
        ),
        'separator' => true,
        'transport' => 'postMessage',
        'class' => 'glue last',
    );//Letter Spacing

    $controls[] = array(
        'type' => 'checkbox',
        'setting' => 'nav_style',
        'label' => esc_attr__('Italic', 'massive-dynamic'),
        'section' => 'nav_sec',
        'default' => PIXFLOW_NAV_STYLE,
        'transport' => 'postMessage',
        'priority' => ++$priority,
    );//Italic

    $controls[] = array(
        'type' => 'description',
        'default' => esc_attr__('Choose the typography for header and notification center. Please note that adding a lot of fonts to your website might increase the website\'s load time.','massive-dynamic'),
        'setting' => 'header_typography_description',
        'section' => 'nav_sec',
        'priority' => ++$priority,
        'class' => 'glue last',
    );

    /******* Business Bar  *******/
    $controls[] = array(
        'type' => 'switch',
        'setting' => 'businessBar_enable',
        'label' => esc_attr__('Business Bar', 'massive-dynamic'),
        'section' => 'header_business_bar',
        'priority' => ++$priority,
        'transport' => 'postMessage',
        'separator' => false,
        'text' => array('checked' => esc_attr__('on','massive-dynamic'), 'unchecked' => esc_attr__('off','massive-dynamic') ),
        'default' => PIXFLOW_BUSINESSBAR_ENABLE
    ); // On/Off business Bar

    $controls[] = array(
        'type' => 'titletext',
        'default' => esc_attr__('Appearance','massive-dynamic'),
        'setting' => 'business_style_title',
        'section' => 'header_business_bar',
        'class' => 'glue first',
        'separator' => true,
        'priority' => ++$priority,
    );

    $controls[] = array(
        'type' => 'radio',
        'mode' => 'buttonset',
        'setting' => 'businessBar_style',
        'label' => esc_attr__('Info Style', 'massive-dynamic'),
        'section' => 'header_business_bar',
        'default' => PIXFLOW_BUSINESSBAR_STYLE,
        'priority' => ++$priority,
        'class' => 'glue first',
        'choices' => array(
            'dot' => esc_attr__('Dot', 'massive-dynamic'),
            'icon' => esc_attr__('Icon', 'massive-dynamic'),
        ),
        'transport' => 'postMessage',
        'separator' => true
    ); // style

    $controls[] = array(
        'type' => 'radio',
        'mode' => 'buttonset',
        'setting' => 'businessBar_social',
        'label' => esc_attr__('Social Style', 'massive-dynamic'),
        'section' => 'header_business_bar',
        'default' => PIXFLOW_BUSINESSBAR_SOCIAL,
        'priority' => ++$priority,
        'class' => 'glue',
        'choices' => array(
            'text' => esc_attr__('Text', 'massive-dynamic'),
            'icon' => esc_attr__('Icon', 'massive-dynamic'),
        ),
        'transport' => 'refresh',
        'separator' => true
    ); // Social type

    $controls[] = array(
        'type' => 'description',
        'default' => esc_attr__('Set styles for info and social section of business bar. To add social icons, you should go to Social Links section of builder.','massive-dynamic'),
        'class' => 'glue last',
        'setting' => 'business_style_description',
        'section' => 'header_business_bar',
        'priority' => ++$priority
    );

    $controls[] = array(
        'type' => 'titletext',
        'default' => esc_attr__('Colors','massive-dynamic'),
        'setting' => 'business_color_title',
        'section' => 'header_business_bar',
        'class' => 'glue first',
        'separator' => true,
        'priority' => ++$priority,
    );


    $controls[] = array(
        'type' => 'rgba',
        'setting' => 'businessBar_content_color',
        'label' => esc_attr__('Element\'s Color', 'massive-dynamic'),
        'section' => 'header_business_bar',
        'default' => PIXFLOW_BUSINESSBAR_CONTENT_COLOR,
        'priority' => ++$priority,
        'class' => 'glue',
        'transport' => 'postMessage',
        'opacity' => true,
        'separator' => true
    ); // content color

    $controls[] = array(
        'type' => 'rgba',
        'setting' => 'businessBar_bg_color',
        'label' => esc_attr__('Background Color', 'massive-dynamic'),
        'section' => 'header_business_bar',
        'priority' => ++$priority,
        'class' => 'glue',
        'default' => PIXFLOW_BUSINESSBAR_BG_COLOR,
        'transport' => 'postMessage',
        'opacity' => true,
        'separator' => true
    ); // bg color

    $controls[] = array(
        'type' => 'description',
        'default' => esc_attr__('Set colors for business bar, a combination of white and blue is common for corporate websites.','massive-dynamic'),
        'class' => 'glue last',
        'setting' => 'business_color_description',
        'section' => 'header_business_bar',
        'priority' => ++$priority
    );

    $controls[] = array(
        'type' => 'titletext',
        'default' => esc_attr__('Info','massive-dynamic'),
        'setting' => 'business_info_title',
        'section' => 'header_business_bar',
        'class' => 'glue first',
        'separator' => true,
        'priority' => ++$priority,
    );

    $controls[] = array(
        'type' => 'text',
        'setting' => 'businessBar_address',
        'label' => esc_attr__('Address', 'massive-dynamic'),
        'section' => 'header_business_bar',
        'transport' => 'postMessage',
        'priority' => ++$priority,
        'output' => false,
        'default'=> PIXFLOW_BUSINESSBAR_ADDRESS,
        'class' => 'glue',
        'separator' => true
    ); // Address

    $controls[] = array(
        'type' => 'text',
        'setting' => 'businessBar_tel',
        'label' => esc_attr__('Tel', 'massive-dynamic'),
        'section' => 'header_business_bar',
        'transport' => 'postMessage',
        'priority' => ++$priority,
        'output' => false,
        'class' => 'glue',
        'separator' => true,
        'default'=> PIXFLOW_BUSINESSBAR_TEL,
    ); // Tel

    $controls[] = array(
        'type' => 'text',
        'setting' => 'businessBar_email',
        'label' => esc_attr__('Email', 'massive-dynamic'),
        'section' => 'header_business_bar',
        'transport' => 'postMessage',
        'priority' => ++$priority,
        'output' => false,
        'class' => 'glue last',
        'separator' => false,
        'default'=> PIXFLOW_BUSINESSBAR_EMAIL,
    ); // Email

    $controls[] = array(
        'type' => 'description',
        'default' => esc_attr__('Enter your contact information to be shown in business bar.','massive-dynamic'),
        'class' => 'glue last',
        'setting' => 'business_info_description',
        'section' => 'header_business_bar',
        'priority' => ++$priority
    );

    /******* Header Responsive *******/
    $controls[] = array(
        'type' => 'radio',
        'mode' => 'buttonset',
        'setting' => 'header_responsive_skin',
        'label' => esc_attr__('Header Skin', 'massive-dynamic'),
        'section' => 'responsive',
        'default' => PIXFLOW_HEADER_RESPONSIVE_SKIN,
        'choices' => array(
            'light' => esc_attr__('Light','massive-dynamic'),
            'dark' => esc_attr__('Dark','massive-dynamic')
        ),
        'transport' => 'postMessage',
        'priority' => ++$priority
    );

    $controls[] = array(
        'type' => 'radio',
        'mode' => 'buttonset',
        'setting' => 'logo_responsive_skin',
        'label' => esc_attr__('Logo Skin', 'massive-dynamic'),
        'section' => 'responsive',
        'default' => PIXFLOW_LOGO_RESPONSIVE_SKIN,
        'choices' => array(
            'light' => esc_attr__('Light','massive-dynamic'),
            'dark' => esc_attr__('Dark','massive-dynamic')
        ),
        'transport' => 'postMessage',
        'priority' => ++$priority
    );

    $controls[] = array(
        'type' => 'description',
        'default' => esc_attr__('You can choose the appearance of header in responsive view. Just remember you can upload dark and light logo in Branding section of builder.','massive-dynamic'),
        'class' => 'glue last',
        'setting' => 'responsive_header_description',
        'section' => 'responsive',
        'priority' => ++$priority
    );

    //-------------------------------------------------
    // Site Content Panel Options
    //-------------------------------------------------

    /******* Main Sec ******/

    $controls[] = array(
        'type' => 'slider',
        'class' => 'glue last',
        'setting' => 'mainC-width',
        'label' => esc_attr__('Container Width ', 'massive-dynamic'),
        'section' => 'main_layout',
        'default' => PIXFLOW_MAINC_WIDTH,
        'priority' => ++$priority,
        'choices' => array(
            'min' => 50,
            'max' => 100,
            'step' => 1,
            'unit' => '%'
        ),
        'separator' => true,
        'transport' => 'postMessage',
        'class' => 'glue last'
    );

    $controls[] = array(
        'type' => 'slider',
        'setting' => 'main-top',
        'label' => esc_attr__('Top Padding', 'massive-dynamic'),
        'section' => 'main_layout',
        'default' => PIXFLOW_MAIN_TOP,
        'priority' => ++$priority,
        'choices' => array(
            'min' => 0,
            'max' => 300,
            'step' => .2,
            'unit' => 'px'
        ),
        'transport' => 'postMessage',
        'class' => 'glue first',
        'separator' => true
    );

    $controls[] = array(
        'type' => 'slider',
        'setting' => 'mainC-padding',
        'label' => esc_attr__('Sides Padding', 'massive-dynamic'),
        'section' => 'main_layout',
        'default' => PIXFLOW_MAINC_PADDING,
        'priority' => ++$priority,
        'choices' => array(
            'min' => 0,
            'max' => 30,
            'step' => 0.1,
            'unit' => '%'
        ),
        'transport' => 'postMessage',
        'class' => 'glue last',
        'separator' => true
    );

    $controls[] = array(
        'type' => 'slider',
        'class' => 'glue first',
        'setting' => 'main-width',
        'label' => esc_attr__('Main Width ', 'massive-dynamic'),
        'section' => 'main_layout',
        'default' => PIXFLOW_MAIN_WIDTH,
        'priority' => ++$priority,
        'choices' => array(
            'min' => 50,
            'max' => 100,
            'step' => 1,
            'unit' => '%'
        ),
        'transport' => 'postMessage',
    );

    $controls[] = array(
        'type' => 'description',
        'default' => esc_attr__('Main is the section between website header and footer, while Container is an invisible box inside Main section. Use Top Padding to add a space between Main section and top header, or use Sides Padding to add a space between Main section and side header.','massive-dynamic'),
        'setting' => 'main_layout_description',
        'section' => 'main_layout',
        'priority' => ++$priority
    );

    $controls[] = array(
        'type' => 'switch',
        'setting' => 'main_bg',
        'label' => esc_attr__('Background', 'massive-dynamic'),
        'section' => 'main_bg_sec',
        'default' => PIXFLOW_MAIN_BG,
        'priority' => ++$priority,
        'class' => 'glue first last',
        'transport' => 'postMessage',
        'separator' => true,
        'text' => array('checked' => esc_attr__('on','massive-dynamic'), 'unchecked' => esc_attr__('off','massive-dynamic') ),
        'value' => 1
    ); // site background

    $controls[] = array(
        'type' => 'radio',
        'mode' => 'buttonset',
        'setting' => 'main_bg_color_type',
        'label' => esc_attr__('Type', 'massive-dynamic'),
        'section' => 'main_bg_sec',
        'default' => PIXFLOW_MAIN_BG_COLOR_TYPE,
        'priority' => ++$priority,
        'class' => 'glue first',
        'choices' => array(
            'solid' => esc_attr__('Solid', 'massive-dynamic'),
            'gradient' => esc_attr__('Gradient', 'massive-dynamic'),
        ),
        'transport' => 'postMessage',
        'separator' => true,
        'compare' => 'and',
        'required' => array(
            array('type' => 'checkbox', 'setting' => 'main_bg', 'value' => true),
        )
    ); // Overlay Color type

    $controls[] = array(
        'type' => 'rgba',
        'setting' => 'main_bg_solid_color',
        'label' => esc_attr__('Solid Color', 'massive-dynamic'),
        'section' => 'main_bg_sec',
        'priority' => ++$priority,
        'class' => 'glue last',
        'default' => PIXFLOW_MAIN_BG_SOLID_COLOR,
        'transport' => 'postMessage',
        'opacity' => true,
        'compare' => 'and',
        'required' => array(
            array('type' => 'checkbox', 'setting' => 'main_bg', 'value' => true),
            array('type' => 'radio', 'setting' => 'main_bg_color_type', 'value' => 'solid'),
        )
    ); // solid color

    $controls[] = array(
        'type' => 'gradient',
        'setting' => 'main_bg_gradient',
        'label' => esc_attr__('Preview', 'massive-dynamic'),
        'section' => 'main_bg_sec',
        'priority' => ++$priority,
        'transport' => 'postMessage',
        'class' => 'glue',
        'compare' => 'and',
        'required' => array(
            array('type' => 'checkbox', 'setting' => 'main_bg', 'value' => true),
            array('type' => 'radio', 'setting' => 'main_bg_color_type', 'value' => 'gradient'),
        ),
        'default' => array(
            'color1' => PIXFLOW_MAIN_BG_GRADIENT_COLOR1,
            'color2' => PIXFLOW_MAIN_BG_GRADIENT_COLOR2,
        ),
    ); // Gradient Color

    $priority = $priority + 5;

    $controls[] = array(
        'type' => 'description',
        'default' => esc_attr__('Use above settings to add background to main section. Please note that you won\'t see the background unless you set the row\'s background to transparent. To do that, move your mouse over a row, click on Row Settings, set Row Type on Solid Color, then go to BG tab and click on color picker, reduce opacity to zero and press the save button.','massive-dynamic'),
        'setting' => 'main_bg_overlay_description',
        'section' => 'main_bg_sec',
        'priority' => ++$priority,
        'required' => array(
            array('type' => 'checkbox', 'setting' => 'main_bg', 'value' => true),
            array('type' => 'radio', 'setting' => 'main_bg_color_type', 'value' => 'gradient'),
        )
    );

    //-------------------------------------------------
    // Footer Panel Options
    //-------------------------------------------------

    /******* layout Sec *******/



    $controls[] = array(
        'type' => 'slider',
        'setting' => 'footer_widget_area_height',
        'label' => esc_attr__('Widget Height', 'massive-dynamic'),
        'section' => 'footer_layout',
        'priority' => ++$priority,
        'default' => PIXFLOW_FOOTER_WIDGET_AREA_HEIGHT,
        'panel' => 'footer',
        'choices' => array(
            'min' => 200,
            'max' => 500,
            'step' => 1,
            'unit' => 'px'
        ),
        'transport' => 'postMessage',
        'class' => 'first glue',
        'separator' => true
    );

    $controls[] = array(
        'type' => 'slider',
        'setting' => 'footer_bottom_area_height',
        'label' => esc_attr__('Copyright Height', 'massive-dynamic'),
        'section' => 'footer_layout',
        'priority' => ++$priority,
        'default' => PIXFLOW_FOOTER_BOTTOM_AREA_HEIGHT,
        'panel' => 'footer',
        'choices' => array(
            'min' => 50,
            'max' => 250,
            'step' => 1,
            'unit' => 'px'
        ),
        'transport' => 'postMessage',
        'class' => 'glue last'
    );

    $controls[] = array(
        'type' => 'description',
        'default' => esc_attr__('Choose widgets style and set footer sections height. If widgets are hidden in footer, you can enable them from Widget Area section of Footer options. Also to add widgets, you should go to Dashboard > appearance > widgets.','massive-dynamic'),
        'setting' => 'footer_layout_copyright_description',
        'section' => 'footer_layout',
        'priority' => ++$priority,
        'class' => 'glue last'
    );

    $controls[] = array(
        'type' => 'slider',
        'class' => 'glue first',
        'setting' => 'footer-width',
        'label' => esc_attr__('Footer width', 'massive-dynamic'),
        'section' => 'footer_layout',
        'default' => PIXFLOW_FOOTER_WIDTH,
        'priority' => ++$priority,
        'choices' => array(
            'min' => 10,
            'max' => 100,
            'step' => 1,
            'unit' => '%'
        ),
        'transport' => 'postMessage',
        'separator' => true
    );

    $controls[] = array(
        'type' => 'slider',
        'class' => 'glue last',
        'setting' => 'footerC-width',
        'label' => esc_attr__('Container Width', 'massive-dynamic'),
        'section' => 'footer_layout',
        'default' => PIXFLOW_FOOTERC_WIDTH,
        'priority' => ++$priority,
        'choices' => array(
            'min' => 10,
            'max' => 100,
            'step' => 1,
            'unit' => '%'
        ),
        'transport' => 'postMessage'
    );

    $controls[] = array(
        'type' => 'description',
        'default' => esc_attr__('Set footer width here. Container is an invisible box inside footer, giving you the option to have a full-width footer with center aligned content.','massive-dynamic'),
        'setting' => 'footer_layout_width_description',
        'section' => 'footer_layout',
        'priority' => ++$priority,
        'class' => 'glue last',
    );

    $controls[] = array(
        'type' => 'slider',
        'class' => 'glue first',
        'setting' => 'footer-marginT',
        'label' => esc_attr__('Top Space', 'massive-dynamic'),
        'section' => 'footer_layout',
        'default' => PIXFLOW_FOOTER_MARGINT,
        'priority' => ++$priority,
        'choices' => array(
            'min' => 0,
            'max' => 200,
            'step' => .1,
            'unit' => 'px'
        ),
        'transport' => 'postMessage',
        'separator' => true,
        'required'    => array(array(
            'type'    => 'checkbox',
            'setting' => 'footer_parallax',
            'value'   => '0'
        )),
    );

    $controls[] = array(
        'type' => 'slider',
        'class' => 'glue last',
        'setting' => 'footer-marginB',
        'label' => esc_attr__('Bottom space', 'massive-dynamic'),
        'section' => 'footer_layout',
        'default' => PIXFLOW_FOOTER_MARGINB,
        'priority' => ++$priority,
        'choices' => array(
            'min' => 0,
            'max' => 200,
            'step' => .1,
            'unit' => 'px'
        ),
        'transport' => 'postMessage',
        'required'    => array(array(
            'type'    => 'checkbox',
            'setting' => 'footer_parallax',
            'value'   => '0'
        )),
    );

    $controls[] = array(
        'type' => 'description',
        'default' => esc_attr__('You can use Top Space to add a space between footer and main section, also you can add a space after footer using Bottom Space.','massive-dynamic'),
        'setting' => 'footer_layout_space_description',
        'section' => 'footer_layout',
        'priority' => ++$priority,
        'class' => 'glue last',
        'required'    => array(array(
            'type'    => 'checkbox',
            'setting' => 'footer_parallax',
            'value'   => '0'
        )),
    );

    /******* Widget Area Sec *******/
    $controls[] = array(
        'type'      => 'text',
        'default'   => PIXFLOW_FOOTER_WIDGETS_ORDER,
        'setting'   => 'footer_widgets_order',
        'label'     => esc_attr__('Order', 'massive-dynamic'),
        'section'   => 'footer_widget_area',
        'transport' => 'postMessage',
        'priority'  => ++$priority,
    );// Footer widgets order (drag & drop)

    $controls[] = array(
        'type'      => 'switch',
        'setting'   => 'footer_widget_area_columns_status',
        'label'     => esc_attr__('Display Widgets', 'massive-dynamic'),
        'section'   => 'footer_widget_area',
        'priority'  => ++$priority,
        'transport' => 'refresh',
        'text' => array('checked' => esc_attr__('on','massive-dynamic'), 'unchecked' => esc_attr__('off','massive-dynamic') ),
        'default'   => PIXFLOW_FOOTER_WIDGET_AREA_COLUMNS_STATUS
    ); // Widget Area Switch

    $controls[] = array(
        'type'     => 'radio',
        'mode'     => 'image',
        'setting'  => 'footer_widget_area_columns',
        'label'    => esc_attr__('Columns', 'massive-dynamic'),
        'section'  => 'footer_widget_area',
        'priority' => ++$priority,
        'class'    => 'footer-position',
        'default'  => PIXFLOW_FOOTER_WIDGET_AREA_COLUMNS,
        'choices'  => array(
            '1' => PIXFLOW_THEME_CUSTOMIZER_URI . '/assets/images/layout-footer-1c.png',
            '2' => PIXFLOW_THEME_CUSTOMIZER_URI . '/assets/images/layout-footer-2c.png',
            '3' => PIXFLOW_THEME_CUSTOMIZER_URI . '/assets/images/layout-footer-3c.png',
            '4' => PIXFLOW_THEME_CUSTOMIZER_URI . '/assets/images/layout-footer-4c.png',
        ),
        'required'    => array(array(
            'type'    => 'checkbox',
            'setting' => 'footer_widget_area_columns_status',
            'value'   => '1'
        )),
        'transport' => 'refresh'
    );

    $url = admin_url().'widgets.php';
    $controls[] = array(
        'type' => 'description',
        'default' => '<a target="_blank" href="'.$url.'" class="menu-page">'.esc_attr__('Add Widgets','massive-dynamic').' </a>',
        'setting' => 'footer_widgets_description',
        'section' => 'footer_widget_area',
        'priority' => ++$priority,
        'class' => 'glue last',
        'required'    => array(array(
            'type'    => 'checkbox',
            'setting' => 'footer_widget_area_columns_status',
            'value'   => '1'
        )),
    );

    /******* Copyright Area Sec *******/
    $controls[] = array(
        'type' => 'radio',
        'mode' => 'buttonset',
        'setting' => 'footer_bottom_items_layout',
        'label' => esc_attr__('Style', 'massive-dynamic'),
        'section' => 'footer_bottom_area',
        'default' => PIXFLOW_FOOTER_BOTTOM_ITEMS_LAYOUT,
        'choices' => array(
            'linear' => esc_attr__('Linear','massive-dynamic'),
            'centered' => esc_attr__('Centered','massive-dynamic')
        ),
        'transport' => 'refresh',
        'priority' => ++$priority
    );

    $controls[] = array(
        'type' => 'description',
        'default' => esc_attr__('Choose between Linear or Centered style.','massive-dynamic'),
        'setting' => 'footer_bottom_area_type_description',
        'section' => 'footer_bottom_area',
        'priority' => ++$priority
    );

    $controls[] = array(
        'type' => 'text',
        'setting' => 'footer_copyright_text',
        'label' => esc_attr__('Copyright Text', 'massive-dynamic'),
        'section' => 'footer_bottom_area',
        'transport' => 'postMessage',
        'default' => PIXFLOW_FOOTER_COPYRIGHT_TEXT,
        'priority' => ++$priority,
        'class' => 'first glue',
        'output' => false,
        'separator' => true,
    );



    $controls[] = array(
        'type' => 'description',
        'default' => esc_attr__('This is your website\'s copyright text. It will be shown in footer, or side headers.','massive-dynamic'),
        'setting' => 'footer_copyright_text_description',
        'section' => 'footer_bottom_area',
        'priority' => ++$priority,
        'class' => 'first glue',
    );

    $controls[] = array(
        'type' => 'titletext',
        'default' => esc_attr__('Copyright Area Items','massive-dynamic'),
        'setting' => 'copyright_items_title',
        'section' => 'footer_bottom_area',
        'class' => 'glue first',
        'separator' => true,
        'priority' => ++$priority,

    );

    $controls[] = array(
        'type' => 'switch',
        'setting' => 'footer_switcher',
        'label' => esc_attr__('Copyright Area', 'massive-dynamic'),
        'section' => 'footer_bottom_area',
        'priority' => ++$priority,
        'class' => 'glue',
        'transport' => 'postMessage',
        'text' => array('checked' => esc_attr__('on','massive-dynamic'), 'unchecked' => esc_attr__('off','massive-dynamic') ),
        'default' => PIXFLOW_FOOTER_SWITCHER,
    ); // Enable/Disable Footer

    $controls[] = array(
        'type' => 'switch',
        'setting' => 'footer_logo',
        'label' => esc_attr__('Logo', 'massive-dynamic'),
        'section' => 'footer_bottom_area',
        'priority' => ++$priority,
        'class' => 'glue',
        'transport' => 'postMessage',
        'text' => array('checked' => esc_attr__('on','massive-dynamic'), 'unchecked' => esc_attr__('off','massive-dynamic') ),
        'default' => PIXFLOW_FOOTER_LOGO,
    ); // Enable/Disable Logo

    $controls[] = array(
        'type' => 'switch',
        'setting' => 'footer_copyright',
        'label' => esc_attr__('Copyright', 'massive-dynamic'),
        'section' => 'footer_bottom_area',
        'priority' => ++$priority,
        'class' => 'glue',
        'transport' => 'postMessage',
        'text' => array('checked' => esc_attr__('on','massive-dynamic'), 'unchecked' => esc_attr__('off','massive-dynamic') ),
        'default' => PIXFLOW_FOOTER_COPYRIGHT,
    ); // Enable/Disable Menu

    $controls[] = array(
        'type' => 'switch',
        'setting' => 'footer_social',
        'label' => esc_attr__('Social', 'massive-dynamic'),
        'section' => 'footer_bottom_area',
        'priority' => ++$priority,
        'class' => 'glue',
        'transport' => 'postMessage',
        'default' => PIXFLOW_FOOTER_SOCIAL,
        'text' => array('checked' => esc_attr__('on','massive-dynamic'), 'unchecked' => esc_attr__('off','massive-dynamic') ),
    ); // Enable/Disable social

    $controls[] = array(
        'type' => 'description',
        'default' => esc_attr__('You can enable or disable copyright area items here.','massive-dynamic'),
        'setting' => 'footer_social_text_description',
        'section' => 'footer_bottom_area',
        'priority' => ++$priority,
        'class' => 'glue',
    );

    $controls[] = array(
        'type' => 'titletext',
        'default' => esc_attr__('Logo Options','massive-dynamic'),
        'setting' => 'footer_logo_title',
        'section' => 'footer_bottom_area',
        'class' => 'glue first',
        'separator' => true,
        'priority' => ++$priority,
    );

    $controls[] = array(
        'type' => 'radio',
        'mode' => 'buttonset',
        'setting' => 'footer_logo_skin',
        'label' => esc_attr__('Skin', 'massive-dynamic'),
        'section' => 'footer_bottom_area',
        'default' => PIXFLOW_FOOTER_LOGO_SKIN,
        'choices' => array(
            'light' => esc_attr__('Light','massive-dynamic'),
            'dark' => esc_attr__('Dark','massive-dynamic')
        ),
        'transport' => 'refresh',
        'priority' => ++$priority
    );

    $controls[] = array(
        'type' => 'slider',
        'setting' => 'footer_logo_opacity',
        'label' => esc_attr__('Logo Opacity', 'massive-dynamic'),
        'section' => 'footer_bottom_area',
        'default' => PIXFLOW_FOOTER_LOGO_OPACITY,
        'priority' => ++$priority,
        'choices' => array(
            'min' => 0,
            'max' => 1,
            'step' => 0.1,
            'unit' => '',
        ),
        'transport' => 'postMessage',
    );

    $controls[] = array(
        'type' => 'description',
        'default' => esc_attr__('Choose logo settings here, you can upload dark and light logos in Branding section of builder.','massive-dynamic'),
        'setting' => 'footer_logo_description',
        'section' => 'footer_bottom_area',
        'priority' => ++$priority,
        'class' => 'glue',
    );

    $controls[] = array(
        'type' => 'radio',
        'mode' => 'buttonset',
        'setting' => 'footer_widgets_styles',
        'label' => esc_attr__('Widget Styles', 'massive-dynamic'),
        'section' => 'footer_bg_sec',
        'default' => PIXFLOW_FOOTER_WIDGETS_STYLES,
        'choices' => array(
            'classic' => esc_attr__('Classic','massive-dynamic'),
            'modern' => esc_attr__('Modern','massive-dynamic')
        ),
        'transport' => 'refresh',
        'priority' => ++$priority,
        'separator' => true
    );

    $controls[] = array(
        'type' => 'radio',
        'mode' => 'buttonset',
        'setting' => 'footer_classic_widgets_styles',
        'label' => esc_attr__('Separator', 'massive-dynamic'),
        'section' => 'footer_bg_sec',
        'default' => PIXFLOW_FOOTER_CLASSIC_WIDGETS_STYLES,
        'choices' => array(
            'none' => esc_attr__('None','massive-dynamic'),
            'border' => esc_attr__('Border ','massive-dynamic')
        ),
        'transport' => 'postMessage',
        'required'    => array(array(
            'type'    => 'radio',
            'setting' => 'footer_widgets_styles',
            'value'   => 'classic'
        )),
        'priority' => ++$priority,
        'separator' => true
    );

    $controls[] = array(
        'type' => 'radio',
        'setting' => 'widgets_separator',
        'mode' => 'buttonset',
        'label' => esc_attr__('Separator Styles', 'massive-dynamic'),
        'section' => 'footer_bg_sec',
        'priority' => ++$priority,
        'class' => 'glue last',
        'transport' => 'postMessage',
        'default' => PIXFLOW_WIDGETS_SEPARATOR,
        'choices' => array(
            'boxed' => esc_attr__('Boxed','massive-dynamic'),
            'full' => esc_attr__('Full','massive-dynamic'),
        ),
        'required'    => array(array(
            'type'    => 'radio',
            'setting' => 'footer_widgets_styles',
            'value'   => 'classic'
        )),
    ); // Enable/Disable Go to top btn

    $controls[] = array(
        'type' => 'switch',
        'setting' => 'footer_parallax',
        'label' => esc_attr__('Footer Parallax', 'massive-dynamic'),
        'section' => 'footer_bg_sec',
        'priority' => ++$priority,
        'class' => 'glue first',
        'transport' => 'postMessage',
        'text' => array('checked' => esc_attr__('on','massive-dynamic'), 'unchecked' => esc_attr__('off','massive-dynamic') ),
        'default' => PIXFLOW_FOOTER_PARALLAX,
        'separator' => true,
    );

    $controls[] = array(
        'type' => 'description',
        'default' => esc_attr__('Please note that this option works best if Footer and Main section have the same width, for example both are set on 100 percent width. Also if you enable this option, top and bottom space will be removed from footer layout. After enabling footer parallax, scroll up and down to see the effect on footer.','massive-dynamic'),
        'setting' => 'footer_parallax_desc',
        'section' => 'footer_bg_sec',
        'priority' => ++$priority,
        'class' => 'glue',
    );

    /******* Background Sec *******/
    $priority = $priority + 10;
    $controls[] = array(
        'type' => 'titletext',
        'default' => esc_attr__('Widgets','massive-dynamic'),
        'setting' => 'widgets_bg_title',
        'section' => 'footer_bg_sec',
        'class' => 'glue first',
        'priority' => ++$priority
    );

    $controls[] = array(
        'type' => 'radio',
        'mode' => 'buttonset',
        'setting' => 'footer_widget_area_skin',
        'label' => esc_attr__('Widget Skin', 'massive-dynamic'),
        'section' => 'footer_bg_sec',
        'default' => PIXFLOW_FOOTER_WIDGET_AREA_SKIN,
        'choices' => array(
            'light' => esc_attr__('Light','massive-dynamic'),
            'dark' => esc_attr__('Dark','massive-dynamic')
        ),
        'transport' => 'postMessage',
        'priority' => ++$priority
    );

    $controls[] = array(
        'type' => 'rgba',
        'setting' => 'footer_widget_area_bg_color_rgba',
        'label' => esc_attr__('Widget Background', 'massive-dynamic'),
        'section' => 'footer_bg_sec',
        'default' => PIXFLOW_FOOTER_WIDGET_AREA_BG_COLOR_RGBA,
        'priority' => ++$priority,
        'transport' => 'postMessage',
        'output' => false,
        'opacity' => true,
        'class' => 'glue',
        'separator' => true
    );
    $controls[] = array(
        'type' => 'description',
        'default' => esc_attr__('Here you can set widget\'s foreground and background.','massive-dynamic'),
        'setting' => 'widget_bg_desc',
        'section' => 'footer_bg_sec',
        'priority' => ++$priority,
        'class' => 'glue',
    );

    $controls[] = array(
        'type' => 'titletext',
        'default' => esc_attr__('Copyright Area','massive-dynamic'),
        'setting' => 'copyright_bg_title',
        'section' => 'footer_bg_sec',
        'class' => 'glue first',
        'priority' => ++$priority
    );

    $controls[] = array(
        'type' => 'rgba',
        'setting' => 'copyright_color',
        'label' => esc_attr__('Element\'s Color', 'massive-dynamic'),
        'section' => 'footer_bg_sec',
        'default' => PIXFLOW_COPYRIGHT_COLOR,
        'priority' => ++$priority,
        'transport' => 'postMessage',
        'class' => 'glue last',
    );

    $controls[] = array(
        'type' => 'rgba',
        'setting' => 'footer_bottom_area_bg_color_rgba',
        'label' => esc_attr__('Background Color', 'massive-dynamic'),
        'section' => 'footer_bg_sec',
        'default' => PIXFLOW_FOOTER_BOTTOM_AREA_BG_COLOR_RGBA,
        'priority' => ++$priority,
        'transport' => 'postMessage',
        'output' => false,
        'opacity' => true,
        'class' => 'last glue'
    );

    $controls[] = array(
        'type' => 'description',
        'default' => esc_attr__('Here you can set foreground and background for copyright area.','massive-dynamic'),
        'setting' => 'copyright_bg_desc',
        'section' => 'footer_bg_sec',
        'priority' => ++$priority,
        'class' => 'glue',
    );

    $controls[] = array(
        'type' => 'titletext',
        'default' => esc_attr__('Copyright Area Separator','massive-dynamic'),
        'setting' => 'copyright_separator_title',
        'section' => 'footer_bg_sec',
        'class' => 'glue first',
        'priority' => ++$priority
    );

    $controls[] = array(
        'type' => 'slider',
        'setting' => 'copyright_separator',
        'label' => esc_attr__('Separator Height', 'massive-dynamic'),
        'section' => 'footer_bg_sec',
        'default' => PIXFLOW_COPYRIGHT_SEPARATOR,
        'priority' => ++$priority,
        'choices' => array(
            'min' => 0,
            'max' => 10,
            'step' => 1,
            'unit' => 'px'
        ),
        'class' => 'glue first',
        'transport' => 'postMessage',
        'separator' => true
    );

    $controls[] = array(
        'type' => 'rgba',
        'setting' => 'copyright_separator_bg_color',
        'label' => esc_attr__('Background Color', 'massive-dynamic'),
        'section' => 'footer_bg_sec',
        'default' => PIXFLOW_COPYRIGHT_SEPARATOR_BG_COLOR,
        'priority' => ++$priority,
        'transport' => 'postMessage',
        'output' => false,
        'opacity' => true,
        'class' => 'last glue',
        'separator' => true
    );

    $controls[] = array(
        'type' => 'description',
        'default' => esc_attr__('Here you can set foreground and background for copyright area.','massive-dynamic'),
        'setting' => 'separator_bg_desc',
        'section' => 'footer_bg_sec',
        'priority' => ++$priority,
        'class' => 'glue',
    );



    $controls = array_merge($controls,pixflow_backgroundControllers('footer','footer_bg_sec','Footer',$priority));
    $priority = $priority + 100;
    /******* Go To Top Sec *******/

    $controls[] = array(
        'type' => 'switch',
        'setting' => 'go_to_top_status',
        'label' => esc_attr__('To Top Button', 'massive-dynamic'),
        'section' => 'footer_go_to_top_sec',
        'priority' => ++$priority,
        'class' => 'glue',
        'transport' => 'postMessage',
        'default' => PIXFLOW_GO_TO_TOP_STATUS,
        'text' => array('checked' => esc_attr__('on','massive-dynamic'), 'unchecked' => esc_attr__('off','massive-dynamic') ),
    ); // Enable/Disable Go to top btn

    $controls[] = array(
        'type' => 'titletext',
        'default' => esc_attr__('Skin Variation','massive-dynamic'),
        'setting' => 'go_to_top_skin_title',
        'section' => 'footer_go_to_top_sec',
        'priority' => ++$priority,
        'class' => 'glue',
        'separator' => true,
        'required'    => array(array(
            'type'    => 'checkbox',
            'setting' => 'go_to_top_status',
            'value'   => true
        )),
    );

    $controls[] = array(
        'type' => 'radio',
        'mode' => 'buttonset',
        'setting' => 'footer_section_gototop_skin',
        'label' => esc_attr__('Skin', 'massive-dynamic'),
        'section' => 'footer_go_to_top_sec',
        'default' => PIXFLOW_FOOTER_SECTION_GOTOTOP_SKIN,
        'choices' => array(
            'light' => esc_attr__('Light','massive-dynamic'),
            'dark' => esc_attr__('Dark','massive-dynamic')
        ),
        'transport' => 'postMessage',
        'priority' => ++$priority,
        'required'    => array(array(
            'type'    => 'checkbox',
            'setting' => 'go_to_top_status',
            'value'   => true
        )),
    );

    $controls[] = array(
        'type' => 'description',
        'default' => esc_attr__('Choose dark skin for websites with light background and choose light skin for websites with dark background','massive-dynamic'),
        'setting' => 'go_to_top_skin_description',
        'section' => 'footer_go_to_top_sec',
        'priority' => ++$priority,
        'class' => 'glue last',
        'compare' => 'or',
        'required'    => array(array(
            'type'    => 'checkbox',
            'setting' => 'go_to_top_status',
            'value'   => true
        )),
    );

    $controls[] = array(
        'type' => 'titletext',
        'default' => esc_attr__('Display Area','massive-dynamic'),
        'setting' => 'go_to_top_space_title',
        'section' => 'footer_go_to_top_sec',
        'priority' => ++$priority,
        'class' => 'glue',
        'separator' => true,
        'required'    => array(array(
            'type'    => 'checkbox',
            'setting' => 'go_to_top_status',
            'value'   => true
        )),
    );

    $controls[] = array(
        'type' => 'slider',
        'setting' => 'go_to_top_show',
        'label' => esc_attr__('Appear after', 'massive-dynamic'),
        'section' => 'footer_go_to_top_sec',
        'default' => PIXFLOW_GO_TO_TOP_SHOW,
        'priority' => ++$priority,
        'choices' => array(
            'min' => 500,
            'max' => 2000,
            'step' => 25,
            'unit' => 'px',
        ),
        'transport' => 'postMessage',
        'required'    => array(array(
            'type'    => 'checkbox',
            'setting' => 'go_to_top_status',
            'value'   => true
        )),
    );

    $controls[] = array(
        'type' => 'description',
        'default' => esc_attr__('Go to top button will appear after you have scrolled more than the value you choose here','massive-dynamic'),
        'setting' => 'go_to_top_space_description',
        'section' => 'footer_go_to_top_sec',
        'priority' => ++$priority,
        'class' => 'glue last',
        'compare' => 'or',
        'required'    => array(array(
            'type'    => 'checkbox',
            'setting' => 'go_to_top_status',
            'value'   => true
        )),
    );



    //-------------------------------------------------
    // Sidebar Panel Options
    //-------------------------------------------------
    /******* Layout Sec *******/
    $controls[] = array(
        'type' => 'switch',
        'setting' => 'sidebar-switch',
        'label' => esc_attr__('Sidebar', 'massive-dynamic'),
        'section' => 'sidebar_general',
        'priority' => ++$priority,
        'text' => array('checked' => esc_attr__('on','massive-dynamic'), 'unchecked' => esc_attr__('off','massive-dynamic') ),
        'value' => 1,
        'default' => PIXFLOW_SIDEBAR_SWITCH
    );

    $controls[] = array(
        'type' => 'radio',
        'mode' => 'image',
        'class' => 'sidebar-position',
        'setting' => 'sidebar-position',
        'label' => '',
        'section' => 'sidebar_general',
        'priority' => ++$priority,
        'default' => PIXFLOW_SIDEBAR_POSITION,
        'choices' => array(
            'left' => PIXFLOW_THEME_CUSTOMIZER_URI . '/assets/images/layout-sidebar-left.png',
            'double' => PIXFLOW_THEME_CUSTOMIZER_URI . '/assets/images/layout-sidebar-double.png',
            'right' => PIXFLOW_THEME_CUSTOMIZER_URI . '/assets/images/layout-sidebar-right.png'
        ),

    );

    $controls[] = array(
        'type' => 'slider',
        'setting' => 'sidebar-width',
        'label' => esc_attr__('Width ', 'massive-dynamic'),
        'section' => 'sidebar_general',
        'default' => PIXFLOW_SIDEBAR_WIDTH,
        'priority' => ++$priority,
        'choices' => array(
            'min' => 12,
            'max' => 30,
            'step' => 1,
            'unit' => '%',
        ),
        'transport' => 'postMessage'
    );


    $controls[] = array(
        'type' => 'description',
        'default' => esc_attr__('Set width for page sidebar. This sidebar only appears in pages.','massive-dynamic'),
        'setting' => 'sticky_sidebar_description',
        'section' => 'sidebar_general',
        'priority' => ++$priority
    );

    $controls[] = array(
        'type' => 'radio',
        'mode' => 'buttonset',
        'setting' => 'sidebar-skin',
        'label' => esc_attr__('Element\'s Skin', 'massive-dynamic'),
        'section' => 'sidebar_general',
        'default' => PIXFLOW_SIDEBAR_SKIN,
        'choices' => array(
            'light' => esc_attr__('Light','massive-dynamic'),
            'dark' => esc_attr__('Dark','massive-dynamic')
        ),
        'transport' => 'postMessage',
        'priority' => ++$priority
    );

    $controls[] = array(
        'type'     => 'select',
        'setting'  => 'sidebar-style',
        'label'    => esc_attr__('Widget\'s Style', 'massive-dynamic'),
        'section'  => 'sidebar_general',
        'default'  => PIXFLOW_SIDEBAR_STYLE,
        'priority' => ++$priority,
        'choices'  => array(
            'none'   => esc_attr__('None', 'massive-dynamic'),
            'border' => esc_attr__('Border', 'massive-dynamic'),
            'box'    => esc_attr__('Boxed', 'massive-dynamic')
        ),
        'transport' => 'postMessage',
    );

    $controls[] = array(
        'type' => 'select',
        'setting' => 'sidebar-align',
        'label' => esc_attr__('Alignment', 'massive-dynamic'),
        'section' => 'sidebar_general',
        'default' => PIXFLOW_SIDEBAR_ALIGN,
        'priority' => ++$priority,
        'choices' => array(
            'left' => esc_attr__('Left', 'massive-dynamic'),
            'right' => esc_attr__('Right', 'massive-dynamic'),
            'center' => esc_attr__('Center', 'massive-dynamic')
        ),
        'transport' => 'postMessage'
    );


    $controls[] = array(
        'type' => 'rgba',
        'setting' => 'sidebar-shadow-color',
        'label' => esc_attr__('Shadow Color', 'massive-dynamic'),
        'section' => 'sidebar_general',
        'default' => PIXFLOW_PAGE_SIDEBAR_SHADOW_COLOR,
        'priority' => ++$priority,
        'transport' => 'postMessage',
        'class' => 'glue',
        'separator' => true,
        'opacity' => true,
        'required' => array(
            array('type' => 'select', 'setting' => 'sidebar-style', 'value' => 'box'),
        )
    );



    $controls = array_merge($controls,pixflow_backgroundControllers('page_sidebar','sidebar_general','Sidebar',$priority));
    $priority = $priority + 100;
    $url = admin_url().'widgets.php';
    $controls[] = array(
        'type' => 'description',
        'default' => '<a target="_blank" href="'.$url.'" class="menu-page">'.esc_attr__('Add Widgets','massive-dynamic').' </a>',
        'setting' => 'sidebar_general_widgets_description',
        'section' => 'sidebar_general',
        'priority' => ++$priority,
        'class' => 'glue last',
    );
    /****************  Blog Page *********************/
    /******* Layout Sec *******/
    $controls[] = array(
        'type' => 'switch',
        'setting' => 'sidebar-switch-blog',
        'label' => esc_attr__('Sidebar', 'massive-dynamic'),
        'section' => 'sidebar_blogPage',
        'priority' => ++$priority,
        'text' => array('checked' => esc_attr__('on','massive-dynamic'), 'unchecked' => esc_attr__('off','massive-dynamic') ),
        'value' => 1,
        'default' => PIXFLOW_SIDEBAR_SWITCH_BLOG
    );

    $controls[] = array(
        'type' => 'radio',
        'mode' => 'image',
        'class' => 'sidebar-position',
        'setting' => 'sidebar-position-blog',
        'label' => '',
        'section' => 'sidebar_blogPage',
        'priority' => ++$priority,
        'default' => PIXFLOW_SIDEBAR_POSITION_BLOG,
        'choices' => array(
            'left' => PIXFLOW_THEME_CUSTOMIZER_URI . '/assets/images/layout-sidebar-left.png',
            'double' => PIXFLOW_THEME_CUSTOMIZER_URI . '/assets/images/layout-sidebar-double.png',
            'right' => PIXFLOW_THEME_CUSTOMIZER_URI . '/assets/images/layout-sidebar-right.png'
        ),
    );

    $controls[] = array(
        'type' => 'slider',
        'setting' => 'sidebar-width-blog',
        'label' => esc_attr__('Width ', 'massive-dynamic'),
        'section' => 'sidebar_blogPage',
        'default' => PIXFLOW_SIDEBAR_WIDTH_BLOG,
        'priority' => ++$priority,
        'choices' => array(
            'min' => 10,
            'max' => 30,
            'step' => 1,
            'unit' => '%',
        ),
        'transport' => 'postMessage'
    );

    $controls[] = array(
        'type' => 'description',
        'default' => esc_attr__('Set width for main sidebar. This sidebar only appears in blog and archive page.','massive-dynamic'),
        'setting' => 'sticky_sidebar_description-blog',
        'section' => 'sidebar_blogPage',
        'priority' => ++$priority
    );

    $controls[] = array(
        'type' => 'radio',
        'mode' => 'buttonset',
        'setting' => 'sidebar-skin-blog',
        'label' => esc_attr__('Element\'s Skin', 'massive-dynamic'),
        'section' => 'sidebar_blogPage',
        'default' => PIXFLOW_SIDEBAR_SKIN_BLOG,
        'choices' => array(
            'light' => esc_attr__('Light','massive-dynamic'),
            'dark' => esc_attr__('Dark','massive-dynamic')
        ),
        'transport' => 'postMessage',
        'priority' => ++$priority
    );

    $controls[] = array(
        'type' => 'select',
        'setting' => 'sidebar-style-blog',
        'label' => esc_attr__('Widget\'s Style', 'massive-dynamic'),
        'section' => 'sidebar_blogPage',
        'default' => PIXFLOW_SIDEBAR_STYLE_BLOG,
        'priority' => ++$priority,
        'choices' => array(
            'none' => esc_attr__('None', 'massive-dynamic'),
            'border' => esc_attr__('Border', 'massive-dynamic'),
            'box' => esc_attr__('Boxed', 'massive-dynamic')
        ),
        'transport' => 'postMessage',
    );

    $controls[] = array(
        'type' => 'select',
        'setting' => 'sidebar-align-blog',
        'label' => esc_attr__('Alignment', 'massive-dynamic'),
        'section' => 'sidebar_blogPage',
        'default' => PIXFLOW_SIDEBAR_ALIGN_BLOG,
        'priority' => ++$priority,
        'choices' => array(
            'left' => esc_attr__('Left', 'massive-dynamic'),
            'right' => esc_attr__('Right', 'massive-dynamic'),
            'center' => esc_attr__('Center', 'massive-dynamic')
        ),
        'transport' => 'postMessage'
    );

    $controls[] = array(
        'type' => 'rgba',
        'setting' => 'sidebar-shadow-color-blog',
        'label' => esc_attr__('Shadow Color', 'massive-dynamic'),
        'section' => 'sidebar_blogPage',
        'default' => PIXFLOW_BLOG_SIDEBAR_SHADOW_COLOR,
        'priority' => ++$priority,
        'transport' => 'postMessage',
        'class' => 'glue',
        'separator' => true,
        'opacity' => true,
        'required' => array(
            array('type' => 'select', 'setting' => 'sidebar-style-blog', 'value' => 'box'),
        )
    );




    $controls = array_merge($controls,pixflow_backgroundControllers('blog_sidebar','sidebar_blogPage','Sidebar',$priority));
    $priority = $priority + 100;
    $url = admin_url().'widgets.php';
    $controls[] = array(
        'type' => 'description',
        'default' => '<a target="_blank" href="'.$url.'" class="menu-page">'.esc_attr__('Add Widgets','massive-dynamic').' </a>',
        'setting' => 'sidebar_blog_widgets_description',
        'section' => 'sidebar_blogPage',
        'priority' => ++$priority,
        'class' => 'glue last',
    );
    /****************  Blog Detail *********************/
    /******* Layout Sec *******/
    $controls[] = array(
        'type' => 'switch',
        'setting' => 'sidebar-switch-single',
        'label' => esc_attr__('Sidebar', 'massive-dynamic'),
        'section' => 'sidebar_blogSingle',
        'priority' => ++$priority,
        'text' => array('checked' => esc_attr__('on','massive-dynamic'), 'unchecked' => esc_attr__('off','massive-dynamic') ),
        'value' => 1,
        'default' => PIXFLOW_SIDEBAR_SWITCH_SINGLE
    );

    $controls[] = array(
        'type' => 'radio',
        'mode' => 'image',
        'class' => 'sidebar-position',
        'setting' => 'sidebar-position-single',
        'label' => '',
        'section' => 'sidebar_blogSingle',
        'priority' => ++$priority,
        'default' => PIXFLOW_SIDEBAR_POSITION_SINGLE,
        'choices' => array(
            'left' => PIXFLOW_THEME_CUSTOMIZER_URI . '/assets/images/layout-sidebar-left.png',
            'double' => PIXFLOW_THEME_CUSTOMIZER_URI . '/assets/images/layout-sidebar-double.png',
            'right' => PIXFLOW_THEME_CUSTOMIZER_URI . '/assets/images/layout-sidebar-right.png'
        ),
    );

    $controls[] = array(
        'type' => 'slider',
        'setting' => 'sidebar-width-single',
        'label' => esc_attr__('Width ', 'massive-dynamic'),
        'section' => 'sidebar_blogSingle',
        'default' => PIXFLOW_SIDEBAR_WIDTH_SINGLE,
        'priority' => ++$priority,
        'choices' => array(
            'min' => 10,
            'max' => 30,
            'step' => 1,
            'unit' => '%',
        ),
        'transport' => 'postMessage'
    );

    $controls[] = array(
        'type' => 'description',
        'default' => esc_attr__('Set width for post page. This sidebar only appears in post pages.','massive-dynamic'),
        'setting' => 'sticky_sidebar_description-single',
        'section' => 'sidebar_blogSingle',
        'priority' => ++$priority
    );



    $controls[] = array(
        'type' => 'radio',
        'mode' => 'buttonset',
        'setting' => 'sidebar-skin-single',
        'label' => esc_attr__('Element\'s Skin', 'massive-dynamic'),
        'section' => 'sidebar_blogSingle',
        'default' => PIXFLOW_SIDEBAR_SKIN_SINGLE,
        'choices' => array(
            'light' => esc_attr__('Light','massive-dynamic'),
            'dark' => esc_attr__('Dark','massive-dynamic')
        ),
        'transport' => 'postMessage',
        'priority' => ++$priority
    );

    $controls[] = array(
        'type'     => 'select',
        'setting'  => 'sidebar-style-single',
        'label'    => esc_attr__('Widget\'s Style', 'massive-dynamic'),
        'section'  => 'sidebar_blogSingle',
        'default'  => PIXFLOW_SIDEBAR_STYLE_SINGLE,
        'priority' => ++$priority,
        'choices'  => array(
            'none'   => esc_attr__('None', 'massive-dynamic'),
            'border' => esc_attr__('Border', 'massive-dynamic'),
            'box'    => esc_attr__('Boxed', 'massive-dynamic')
        ),
        'transport' => 'postMessage',
    );

    $controls[] = array(
        'type' => 'select',
        'setting' => 'sidebar-align-single',
        'label' => esc_attr__('Alignment', 'massive-dynamic'),
        'section' => 'sidebar_blogSingle',
        'default' => PIXFLOW_SIDEBAR_ALIGN_SINGLE,
        'priority' => ++$priority,
        'choices' => array(
            'left' => esc_attr__('Left', 'massive-dynamic'),
            'right' => esc_attr__('Right', 'massive-dynamic'),
            'center' => esc_attr__('Center', 'massive-dynamic')
        ),
        'transport' => 'postMessage'
    );

    $controls[] = array(
        'type' => 'rgba',
        'setting' => 'sidebar-shadow-color-single',
        'label' => esc_attr__('Shadow Color', 'massive-dynamic'),
        'section' => 'sidebar_blogSingle',
        'default' => PIXFLOW_SINGLE_SIDEBAR_SHADOW_COLOR,
        'priority' => ++$priority,
        'transport' => 'postMessage',
        'class' => 'glue',
        'separator' => true,
        'opacity' => true,
        'required' => array(
            array('type' => 'select', 'setting' => 'sidebar-style-single', 'value' => 'box'),
        )
    );


    $controls = array_merge($controls,pixflow_backgroundControllers('single_sidebar','sidebar_blogSingle','Sidebar',$priority));
    $priority = $priority + 100;
    $url = admin_url().'widgets.php';
    $controls[] = array(
        'type' => 'description',
        'default' => '<a target="_blank" href="'.$url.'" class="menu-page">'.esc_attr__('Add Widgets','massive-dynamic').' </a>',
        'setting' => 'sidebar_detail_widgets_description',
        'section' => 'sidebar_blogSingle',
        'priority' => ++$priority,
        'class' => 'glue last',
    );
    /****************  Shop *********************/
    /******* Layout Sec *******/
    $controls[] = array(
        'type' => 'switch',
        'setting' => 'sidebar-switch-shop',
        'label' => esc_attr__('Sidebar', 'massive-dynamic'),
        'section' => 'sidebar_shop',
        'priority' => ++$priority,
        'text' => array('checked' => esc_attr__('on','massive-dynamic'), 'unchecked' => esc_attr__('off','massive-dynamic') ),
        'value' => 1,
        'default' => PIXFLOW_SIDEBAR_SWITCH_SHOP
    );

    $controls[] = array(
        'type' => 'radio',
        'mode' => 'image',
        'class' => 'sidebar-position',
        'setting' => 'sidebar-position-shop',
        'label' => '',
        'section' => 'sidebar_shop',
        'priority' => ++$priority,
        'default' => PIXFLOW_SIDEBAR_POSITION_SHOP,
        'choices' => array(
            'left' => PIXFLOW_THEME_CUSTOMIZER_URI . '/assets/images/layout-sidebar-left.png',
            'right' => PIXFLOW_THEME_CUSTOMIZER_URI . '/assets/images/layout-sidebar-right.png'
        ),
    );

    $controls[] = array(
        'type' => 'slider',
        'setting' => 'sidebar-width-shop',
        'label' => esc_attr__('Width ', 'massive-dynamic'),
        'section' => 'sidebar_shop',
        'default' => PIXFLOW_SIDEBAR_WIDTH_SHOP,
        'priority' => ++$priority,
        'choices' => array(
            'min' => 10,
            'max' => 20,
            'step' => 1,
            'unit' => '%',
        ),
        'transport' => 'postMessage'
    );

    $controls[] = array(
        'type' => 'description',
        'default' => esc_attr__('Set width for shop page sidebar. This sidebar only appears in shop page.','massive-dynamic'),
        'setting' => 'sticky_sidebar_description-shop',
        'section' => 'sidebar_shop',
        'priority' => ++$priority
    );

    $controls[] = array(
        'type' => 'radio',
        'mode' => 'buttonset',
        'setting' => 'sidebar-skin-shop',
        'label' => esc_attr__('Skin', 'massive-dynamic'),
        'section' => 'sidebar_shop',
        'default' => PIXFLOW_SIDEBAR_SKIN_SHOP,
        'choices' => array(
            'light' => esc_attr__('Light','massive-dynamic'),
            'dark' => esc_attr__('Dark','massive-dynamic')
        ),
        'transport' => 'postMessage',
        'priority' => ++$priority
    );

    $controls[] = array(
        'type' => 'select',
        'setting' => 'sidebar-style-shop',
        'label' => esc_attr__('Widget\'s Style', 'massive-dynamic'),
        'section' => 'sidebar_shop',
        'default' => PIXFLOW_SIDEBAR_STYLE_SHOP,
        'priority' => ++$priority,
        'choices' => array(
            'none' => esc_attr__('None', 'massive-dynamic'),
            'border' => esc_attr__('Border', 'massive-dynamic'),
            'box' => esc_attr__('Boxed', 'massive-dynamic')
        ),
        'transport' => 'postMessage',
    );

    $controls[] = array(
        'type' => 'select',
        'setting' => 'sidebar-align-shop',
        'label' => esc_attr__('Alignment', 'massive-dynamic'),
        'section' => 'sidebar_shop',
        'default' => PIXFLOW_SIDEBAR_ALIGN_SHOP,
        'priority' => ++$priority,
        'choices' => array(
            'left' => esc_attr__('Left', 'massive-dynamic'),
            'right' => esc_attr__('Right', 'massive-dynamic'),
            'center' => esc_attr__('Center', 'massive-dynamic')
        ),
        'transport' => 'postMessage'
    );



    $controls[] = array(
        'type' => 'rgba',
        'setting' => 'sidebar-shadow-color-shop',
        'label' => esc_attr__('Shadow Color', 'massive-dynamic'),
        'section' => 'sidebar_shop',
        'default' => PIXFLOW_SHOP_SIDEBAR_SHADOW_COLOR,
        'priority' => ++$priority,
        'transport' => 'postMessage',
        'class' => 'glue',
        'separator' => true,
        'opacity' => true,
        'required' => array(
            array('type' => 'select', 'setting' => 'sidebar-style-shop', 'value' => 'box'),
        )
    );


    $controls = array_merge($controls,pixflow_backgroundControllers('shop_sidebar','sidebar_shop','Sidebar',$priority));
    $priority = $priority + 100;
    $url = admin_url().'widgets.php';
    $controls[] = array(
        'type' => 'description',
        'default' => '<a target="_blank" href="'.$url.'" class="menu-page">'.esc_attr__('Add Widgets','massive-dynamic').' </a>',
        'setting' => 'sidebar_shop_widgets_description',
        'section' => 'sidebar_shop',
        'priority' => ++$priority,
        'class' => 'glue last',
    );
    //-------------------------------------------------
    // Branding Panel Options
    //-------------------------------------------------
    /******* Branding Sec *******/
    $priority = $priority + 10;
    $controls[] = array(
        'type' => 'image',
        'setting' => 'dark_logo',
        'label' => esc_attr__('Dark logo', 'massive-dynamic'),
        'section' => 'branding',
        'priority' => ++$priority,
        'default' => PIXFLOW_DARK_LOGO,
        'separator' => true,
        'class' => 'first glue',
        'separator' => true
    );

    $controls[] = array(
        'type' => 'description',
        'default' => esc_attr__('Upload a dark variation of your logo here, this logo will be displayed in sections with light background.','massive-dynamic'),
        'setting' => 'dark_logo_description',
        'section' => 'branding',
        'class' => 'last glue',
        'priority' => ++$priority
    );

    $controls[] = array(
        'type' => 'image',
        'setting' => 'light_logo',
        'label' => esc_attr__('Light logo', 'massive-dynamic'),
        'section' => 'branding',
        'priority' => ++$priority,
        'default' => PIXFLOW_LIGHT_LOGO,
        'class' => 'first glue',
        'separator' => true
    );

    $controls[] = array(
        'type' => 'description',
        'default' => esc_attr__('Upload a light variation of your logo here, this logo will be displayed in sections with dark background.','massive-dynamic'),
        'setting' => 'light_logo_description',
        'section' => 'branding',
        'priority' => ++$priority,
        'class' => 'last glue',
    );

    $controls[] = array(
        'type' => 'image',
        'setting' => 'notify_logo',
        'label' => esc_attr__('Notification Logo', 'massive-dynamic'),
        'section' => 'branding',
        'priority' => ++$priority,
        'default' => PIXFLOW_NOTIFY_LOGO,
        'separator' => true,
        'class' => 'first glue',
        'separator' => true
    );

    $controls[] = array(
        'type' => 'description',
        'default' => esc_attr__('Upload a small variation of your logo here, this logo will be displayed on top of notification center.','massive-dynamic'),
        'setting' => 'notify_logo_description',
        'section' => 'branding',
        'priority' => ++$priority,
        'class' => 'last glue',
    );

    $controls[] = array(
        'type' => 'image',
        'setting' => 'preloader_logo',
        'label' => esc_attr__('Preloader Logo', 'massive-dynamic'),
        'section' => 'branding',
        'priority' => ++$priority,
        'default' => PIXFLOW_PRELOADER_LOGO,
        'separator' => true,
        'class' => 'first glue',
        'separator' => true,
        'transport' => 'postMessage'
    );

    $controls[] = array(
        'type' => 'description',
        'default' => 'Upload a small variation of your logo here, this logo will be displayed before load your website.',
        'setting' => 'preloader_logo_description',
        'section' => 'branding',
        'priority' => ++$priority,
        'class' => 'last glue',
    );
    $controls[] = array(
        'type' => 'upload',
        'setting' => 'favicon',
        'label' => esc_attr__('Site Icon', 'massive-dynamic'),
        'section' => 'branding',
        'priority' => ++$priority,
        'default' => PIXFLOW_FAVICON,
        'separator' => true,
        'class' => 'first glue',
        'separator' => true,
        'transport' => 'postMessage'
    );
    $controls[] = array(
        'type' => 'description',
        'default' => esc_attr__('The Site Icon is used as a browser and app icon for your site. Icons must be square, and at least 512px wide and tall.','massive-dynamic'),
        'setting' => 'favicon_description',
        'section' => 'branding',
        'priority' => ++$priority,
        'class' => 'last glue',
    );
    //-------------------------------------------------
    // Typography Panel Options
    //-------------------------------------------------

    $priority = $priority + 10;


    /********* H1 Sec *********/
    $controls[] = array(
        'type' => 'select',
        'setting' => 'h1_name',
        'label' => esc_attr__('Font Family', 'massive-dynamic'),
        'section' => 'h1_sec',
        'default' => PIXFLOW_H1_NAME,
        'class' => 'glue first open font-picker',
        'priority' => ++$priority,
        'choices' => array(pixflow_get_theme_mod('h1_name',PIXFLOW_H1_NAME)),
        'transport' => 'refresh',
        'separator' => true,
    );// Font Name

    $controls[] = array(
        'type' => 'slider',
        'setting' => 'h1_size',
        'label' => esc_attr__('Size', 'massive-dynamic'),
        'section' => 'h1_sec',
        'default' => PIXFLOW_H1_SIZE,
        'priority' => ++$priority,
        'class' => 'glue ',
        'choices' => array(
            'min' => 15,
            'max' => 70,
            'step' => 1,
            'unit' => 'px'
        ),
        'transport' => 'postMessage',
        'separator' => true,
    );// font size

    $controls[] = array(
        'type' => 'slider',
        'setting' => 'h1_weight',
        'label' => esc_attr__('Weight', 'massive-dynamic'),
        'section' => 'h1_sec',
        'default' => PIXFLOW_H1_WEIGHT,
        'priority' => ++$priority,
        'class' => 'glue last',
        'separator' => true,
        'choices' => array(
            'min' => 100,
            'max' => 800,
            'step' => 100,
        ),
        'transport' => 'refresh'
    );// font weight

    $controls[] = array(
        'type' => 'slider',
        'setting' => 'h1_lineHeight',
        'label' => esc_attr__('Line Height', 'massive-dynamic'),
        'section' => 'h1_sec',
        'default' => PIXFLOW_H1_LINEHEIGHT,
        'priority' => ++$priority,
        'choices' => array(
            'min' => 15,
            'max' => 90,
            'step' => 1,
            'unit' => 'px'
        ),
        'class' => 'glue first',
        'transport' => 'postMessage',
        'separator' => true,
    );//Line Height

    $controls[] = array(
        'type' => 'slider',
        'setting' => 'h1_letterSpace',
        'label' => esc_attr__('Letter Spacing', 'massive-dynamic'),
        'section' => 'h1_sec',
        'default' => PIXFLOW_H1_LETTERSPACE,
        'priority' => ++$priority,
        'choices' => array(
            'min' => 0,
            'max' => 10,
            'step' => 0.01,
            'unit' => 'px'
        ),
        'transport' => 'postMessage',
        'separator' => true,
        'class' => 'glue',
    );//Letter Spacing

    $controls[] = array(
        'type' => 'rgba',
        'setting' => 'h1_color',
        'label' => esc_attr__('Color', 'massive-dynamic'),
        'section' => 'h1_sec',
        'default' => PIXFLOW_H1_COLOR,
        'priority' => ++$priority,
        'transport' => 'postMessage',
        'class' => 'glue',
        'separator' => true,
    );// Font Color

    $controls[] = array(
        'type' => 'checkbox',
        'setting' => 'h1_style',
        'label' => esc_attr__('Italic', 'massive-dynamic'),
        'section' => 'h1_sec',
        'default' => PIXFLOW_H1_STYLE,
        'class' => 'glue',
        'priority' => ++$priority,
        'separator' => true,
        'transport' => 'postMessage',
    );//Italic

    $controls[] = array(
        'type' => 'description',
        'default' => esc_attr__('Choose desired options for H1 tag. Please note that this settings will affect most shortcodes(elements) that use H1 for title.','massive-dynamic'),
        'setting' => 'h1_description',
        'section' => 'h1_sec',
        'class' => 'glue last',
        'priority' => ++$priority
    );

    /******* H2 Sec *******/
    $controls[] = array(
        'type' => 'select',
        'setting' => 'h2_name',
        'label' => esc_attr__('Font Family', 'massive-dynamic'),
        'section' => 'h2_sec',
        'default' => PIXFLOW_H2_NAME,
        'class' => 'glue first font-picker',
        'priority' => ++$priority,
        'choices' => array(pixflow_get_theme_mod('h2_name',PIXFLOW_H2_NAME)),
        'separator' => true,
    );// Font Name

    $controls[] = array(
        'type' => 'slider',
        'setting' => 'h2_size',
        'label' => esc_attr__('Size', 'massive-dynamic'),
        'section' => 'h2_sec',
        'default' => PIXFLOW_H2_SIZE,
        'priority' => ++$priority,
        'choices' => array(
            'min' => 10,
            'max' => 60,
            'step' => 1,
            'unit' => 'px'
        ),
        'class' => 'glue ',
        'transport' => 'postMessage',
        'separator' => true,
    );// font size

    $controls[] = array(
        'type' => 'slider',
        'setting' => 'h2_weight',
        'label' => esc_attr__('Weight', 'massive-dynamic'),
        'section' => 'h2_sec',
        'default' => PIXFLOW_H2_WEIGHT,
        'priority' => ++$priority,
        'choices' => array(
            'min' => 100,
            'max' => 800,
            'step' => 100,
        ),
        'separator' => true,
        'class' => 'glue last',
    );// font weight

    $controls[] = array(
        'type' => 'slider',
        'setting' => 'h2_lineHeight',
        'label' => esc_attr__('Line Height', 'massive-dynamic'),
        'section' => 'h2_sec',
        'default' => PIXFLOW_H2_LINEHEIGHT,
        'priority' => ++$priority,
        'choices' => array(
            'min' => 8,
            'max' => 80,
            'step' => 1,
            'unit' => 'px'
        ),
        'class' => 'glue first',
        'transport' => 'postMessage',
        'separator' => true,
    );//Line Height

    $controls[] = array(
        'type' => 'slider',
        'setting' => 'h2_letterSpace',
        'label' => esc_attr__('Letter Spacing', 'massive-dynamic'),
        'section' => 'h2_sec',
        'default' => PIXFLOW_H2_LETTERSPACE,
        'priority' => ++$priority,
        'choices' => array(
            'min' => 0,
            'max' => 10,
            'step' => 0.01,
            'unit' => 'px'
        ),
        'transport' => 'postMessage',
        'separator' => true,
        'class' => 'glue',
    );//Letter Spacing

    $controls[] = array(
        'type' => 'rgba',
        'setting' => 'h2_color',
        'label' => esc_attr__('Color', 'massive-dynamic'),
        'section' => 'h2_sec',
        'default' => PIXFLOW_H2_COLOR,
        'priority' => ++$priority,
        'separator' => true,
        'class' => 'glue',
        'transport' => 'postMessage'
    );// Font Color

    $controls[] = array(
        'type' => 'checkbox',
        'setting' => 'h2_style',
        'label' => esc_attr__('Italic', 'massive-dynamic'),
        'section' => 'h2_sec',
        'default' => PIXFLOW_H2_STYLE,
        'priority' => ++$priority,
        'separator' => true,
        'class' => 'glue',
        'transport' => 'postMessage'
    );//Italic

    $controls[] = array(
        'type' => 'description',
        'default' => esc_attr__('Choose desired options for H2 tag. Please note that this settings will affect most shortcodes(elements) that use H2 for title.','massive-dynamic'),
        'setting' => 'h2_description',
        'section' => 'h2_sec',
        'class' => 'glue last',
        'priority' => ++$priority
    );

    /******* H3 Sec *******/
    $controls[] = array(
        'type' => 'select',
        'setting' => 'h3_name',
        'label' => esc_attr__('Font Family', 'massive-dynamic'),
        'section' => 'h3_sec',
        'default' => PIXFLOW_H3_NAME,
        'class' => 'glue first font-picker',
        'priority' => ++$priority,
        'choices' => array(pixflow_get_theme_mod('h3_name',PIXFLOW_H3_NAME)),
        'separator' => true,
    );// Font Name

    $controls[] = array(
        'type' => 'slider',
        'setting' => 'h3_size',
        'label' => esc_attr__('Size', 'massive-dynamic'),
        'section' => 'h3_sec',
        'default' => PIXFLOW_H3_SIZE,
        'priority' => ++$priority,
        'choices' => array(
            'min' => 10,
            'max' => 50,
            'step' => 1,
            'unit' => 'px'
        ),
        'class' => 'glue ',
        'transport' => 'postMessage',
        'separator' => true,
    );// font size

    $controls[] = array(
        'type' => 'slider',
        'setting' => 'h3_weight',
        'label' => esc_attr__('Weight', 'massive-dynamic'),
        'section' => 'h3_sec',
        'default' => PIXFLOW_H3_WEIGHT,
        'priority' => ++$priority,
        'class' => 'glue last',
        'choices' => array(
            'min' => 100,
            'max' => 800,
            'step' => 100,
        ),
        'separator' => true
    );// font weight

    $controls[] = array(
        'type' => 'slider',
        'setting' => 'h3_lineHeight',
        'label' => esc_attr__('Line Height', 'massive-dynamic'),
        'section' => 'h3_sec',
        'default' => PIXFLOW_H3_LINEHEIGHT,
        'priority' => ++$priority,
        'choices' => array(
            'min' => 10,
            'max' => 70,
            'step' => 1,
            'unit' => 'px'
        ),
        'class' => 'glue first',
        'transport' => 'postMessage',
        'separator' => true,
    );//Line Height

    $controls[] = array(
        'type' => 'slider',
        'setting' => 'h3_letterSpace',
        'label' => esc_attr__('Letter Spacing', 'massive-dynamic'),
        'section' => 'h3_sec',
        'default' => PIXFLOW_H3_LETTERSPACE,
        'priority' => ++$priority,
        'choices' => array(
            'min' => 0,
            'max' => 10,
            'step' => 0.01,
            'unit' => 'px'
        ),
        'transport' => 'postMessage',
        'separator' => true,
        'class' => 'glue',
    );//Letter Spacing

    $controls[] = array(
        'type' => 'rgba',
        'setting' => 'h3_color',
        'label' => esc_attr__('Color', 'massive-dynamic'),
        'section' => 'h3_sec',
        'default' => PIXFLOW_H3_COLOR,
        'priority' => ++$priority,
        'transport' => 'postMessage',
        'separator' => true,
        'class' => 'glue',
    );// Font Color

    $controls[] = array(
        'type' => 'checkbox',
        'setting' => 'h3_style',
        'label' => esc_attr__('Italic', 'massive-dynamic'),
        'section' => 'h3_sec',
        'default' => PIXFLOW_H3_STYLE,
        'priority' => ++$priority,
        'separator' => true,
        'class' => 'glue',
        'transport' => 'postMessage'
    );//Italic

    $controls[] = array(
        'type' => 'description',
        'default' => esc_attr__('Choose desired options for H3 tag. Please note that this settings will affect most shortcodes(elements) that use H3 for title.','massive-dynamic'),
        'setting' => 'h3_description',
        'section' => 'h3_sec',
        'priority' => ++$priority,
        'class' => 'glue last',
    );

    /******* H4 Sec *******/
    $controls[] = array(
        'type' => 'select',
        'setting' => 'h4_name',
        'label' => esc_attr__('Font Family', 'massive-dynamic'),
        'section' => 'h4_sec',
        'default' => PIXFLOW_H4_NAME,
        'priority' => ++$priority,
        'class' => 'glue first font-picker',
        'choices' => array(pixflow_get_theme_mod('h4_name',PIXFLOW_H4_NAME)),
        'separator' => true,
    );// Font Name

    $controls[] = array(
        'type' => 'slider',
        'setting' => 'h4_size',
        'label' => esc_attr__('Size', 'massive-dynamic'),
        'section' => 'h4_sec',
        'default' => PIXFLOW_H4_SIZE,
        'priority' => ++$priority,
        'choices' => array(
            'min' => 10,
            'max' => 40,
            'step' => 1,
            'unit' => 'px'
        ),
        'class' => 'glue ',
        'transport' => 'postMessage',
        'separator' => true,
    );// font size

    $controls[] = array(
        'type' => 'slider',
        'setting' => 'h4_weight',
        'label' => esc_attr__('Weight', 'massive-dynamic'),
        'section' => 'h4_sec',
        'default' => PIXFLOW_H4_WEIGHT,
        'priority' => ++$priority,
        'class' => 'glue ',
        'choices' => array(
            'min' => 100,
            'max' => 800,
            'step' => 100,
        ),
        'separator' => true,
    );// font weight

    $controls[] = array(
        'type' => 'slider',
        'setting' => 'h4_lineHeight',
        'label' => esc_attr__('Line Height', 'massive-dynamic'),
        'section' => 'h4_sec',
        'default' => PIXFLOW_H4_LINEHEIGHT,
        'priority' => ++$priority,
        'choices' => array(
            'min' => 10,
            'max' => 60,
            'step' => 1,
            'unit' => 'px'
        ),
        'class' => 'glue',
        'transport' => 'postMessage',
        'separator' => true,
    );//Line Height

    $controls[] = array(
        'type' => 'slider',
        'setting' => 'h4_letterSpace',
        'label' => esc_attr__('Letter Spacing', 'massive-dynamic'),
        'section' => 'h4_sec',
        'default' => PIXFLOW_H4_LETTERSPACE,
        'priority' => ++$priority,
        'choices' => array(
            'min' => 0,
            'max' => 10,
            'step' => 0.01,
            'unit' => 'px'
        ),
        'transport' => 'postMessage',
        'separator' => true,
        'class' => 'glue',
    );//Letter Spacing

    $controls[] = array(
        'type' => 'rgba',
        'setting' => 'h4_color',
        'label' => esc_attr__('Color', 'massive-dynamic'),
        'section' => 'h4_sec',
        'default' => PIXFLOW_H4_COLOR,
        'priority' => ++$priority,
        'separator' => true,
        'transport' => 'postMessage',
        'class' => 'glue',
    );// Font Color

    $controls[] = array(
        'type' => 'checkbox',
        'setting' => 'h4_style',
        'label' => esc_attr__('Italic', 'massive-dynamic'),
        'section' => 'h4_sec',
        'default' => PIXFLOW_H4_STYLE,
        'priority' => ++$priority,
        'separator' => true,
        'class' => 'glue',
        'transport' => 'postMessage'
    );//Italic

    $controls[] = array(
        'type' => 'description',
        'default' => esc_attr__('Choose desired options for H4 tag. Please note that this settings will affect most shortcodes(elements) that use H4 for title.','massive-dynamic'),
        'setting' => 'h4_description',
        'section' => 'h4_sec',
        'priority' => ++$priority,
        'class' => 'glue last',
    );

    /******* H5 Sec *******/
    $controls[] = array(
        'type' => 'select',
        'setting' => 'h5_name',
        'label' => esc_attr__('Font Family', 'massive-dynamic'),
        'section' => 'h5_sec',
        'default' => PIXFLOW_H5_NAME,
        'priority' => ++$priority,
        'class' => 'glue first font-picker',
        'choices' => array(pixflow_get_theme_mod('h5_name',PIXFLOW_H5_NAME)),
        'separator' => true,
    );// Font Name

    $controls[] = array(
        'type' => 'slider',
        'setting' => 'h5_size',
        'label' => esc_attr__('Size', 'massive-dynamic'),
        'section' => 'h5_sec',
        'default' => PIXFLOW_H5_SIZE,
        'priority' => ++$priority,
        'choices' => array(
            'min' => 10,
            'max' => 30,
            'step' => 1,
            'unit' => 'px'
        ),
        'class' => 'glue ',
        'transport' => 'postMessage',
        'separator' => true,
    );// font size

    $controls[] = array(
        'type' => 'slider',
        'setting' => 'h5_weight',
        'label' => esc_attr__('Weight', 'massive-dynamic'),
        'section' => 'h5_sec',
        'default' => PIXFLOW_H5_WEIGHT,
        'priority' => ++$priority,
        'class' => 'glue',
        'choices' => array(
            'min' => 100,
            'max' => 800,
            'step' => 100,
        ),
        'separator' => true,
    );// font weight

    $controls[] = array(
        'type' => 'slider',
        'setting' => 'h5_lineHeight',
        'label' => esc_attr__('Line Height', 'massive-dynamic'),
        'section' => 'h5_sec',
        'default' => PIXFLOW_H5_LINEHEIGHT,
        'priority' => ++$priority,
        'choices' => array(
            'min' => 10,
            'max' => 50,
            'step' => 1,
            'unit' => 'px'
        ),
        'class' => 'glue ',
        'transport' => 'postMessage',
        'separator' => true,
    );//Line Height

    $controls[] = array(
        'type' => 'slider',
        'setting' => 'h5_letterSpace',
        'label' => esc_attr__('Letter Spacing', 'massive-dynamic'),
        'section' => 'h5_sec',
        'default' => PIXFLOW_H5_LETTERSPACE,
        'priority' => ++$priority,
        'choices' => array(
            'min' => 0,
            'max' => 10,
            'step' => 0.01,
            'unit' => 'px'
        ),
        'transport' => 'postMessage',
        'separator' => true,
        'class' => 'glue',
    );//Letter Spacing

    $controls[] = array(
        'type' => 'rgba',
        'setting' => 'h5_color',
        'label' => esc_attr__(' Color', 'massive-dynamic'),
        'section' => 'h5_sec',
        'default' => PIXFLOW_H5_COLOR,
        'priority' => ++$priority,
        'separator' => true,
        'transport' => 'postMessage',
        'class' => 'glue',
    );// Font Color

    $controls[] = array(
        'type' => 'checkbox',
        'setting' => 'h5_style',
        'label' => esc_attr__('Italic', 'massive-dynamic'),
        'section' => 'h5_sec',
        'default' => PIXFLOW_H5_STYLE,
        'separator' => true,
        'priority' => ++$priority,
        'class' => 'glue',
        'transport' => 'postMessage'
    );//Italic

    $controls[] = array(
        'type' => 'description',
        'default' => esc_attr__('Choose desired options for H5 tag. Please note that this settings will affect most shortcodes(elements) that use H5 for title.','massive-dynamic'),
        'setting' => 'h5_description',
        'section' => 'h5_sec',
        'priority' => ++$priority,
        'class' => 'glue last',
    );

    /******* H6 Sec *******/
    $controls[] = array(
        'type' => 'select',
        'setting' => 'h6_name',
        'label' => esc_attr__('Font Family', 'massive-dynamic'),
        'section' => 'h6_sec',
        'default' => PIXFLOW_H6_NAME,
        'priority' => ++$priority,
        'class' => 'glue first font-picker',
        'choices' => array(pixflow_get_theme_mod('h6_name',PIXFLOW_H6_NAME)),
        'separator' => true,
    );// Font Name

    $controls[] = array(
        'type' => 'slider',
        'setting' => 'h6_size',
        'label' => esc_attr__('Size', 'massive-dynamic'),
        'section' => 'h6_sec',
        'default' => PIXFLOW_H6_SIZE,
        'priority' => ++$priority,
        'choices' => array(
            'min' => 10,
            'max' => 20,
            'step' => 1,
            'unit' => 'px'
        ),
        'class' => 'glue',
        'separator' => true,
        'transport' => 'postMessage'
    );// font size

    $controls[] = array(
        'type' => 'slider',
        'setting' => 'h6_weight',
        'label' => esc_attr__('Weight', 'massive-dynamic'),
        'section' => 'h6_sec',
        'default' => PIXFLOW_H6_WEIGHT,
        'priority' => ++$priority,
        'class' => 'glue',
        'separator' => true,
        'choices' => array(
            'min' => 100,
            'max' => 800,
            'step' => 100,
        )
    );// font weight

    $controls[] = array(
        'type' => 'slider',
        'setting' => 'h6_lineHeight',
        'label' => esc_attr__('Line Height', 'massive-dynamic'),
        'section' => 'h6_sec',
        'default' => PIXFLOW_H6_LINEHEIGHT,
        'priority' => ++$priority,
        'choices' => array(
            'min' => 10,
            'max' => 40,
            'step' => 1,
            'unit' => 'px'
        ),
        'class' => 'glue',
        'transport' => 'postMessage',
        'separator' => true,
    );//Line Height

    $controls[] = array(
        'type' => 'slider',
        'setting' => 'h6_letterSpace',
        'label' => esc_attr__('Letter Spacing', 'massive-dynamic'),
        'section' => 'h6_sec',
        'default' => PIXFLOW_H6_LETTERSPACE,
        'priority' => ++$priority,
        'choices' => array(
            'min' => 0,
            'max' => 20,
            'step' => 0.01,
            'unit' => 'px'
        ),
        'transport' => 'postMessage',
        'separator' => true,
        'class' => 'glue',
    );//Letter Spacing

    $controls[] = array(
        'type' => 'rgba',
        'setting' => 'h6_color',
        'label' => esc_attr__('Color', 'massive-dynamic'),
        'section' => 'h6_sec',
        'default' => PIXFLOW_H6_COLOR,
        'priority' => ++$priority,
        'separator' => true,
        'class' => 'glue',
        'transport' => 'postMessage'
    );// Font Color

    $controls[] = array(
        'type' => 'checkbox',
        'setting' => 'h6_style',
        'label' => esc_attr__('Italic', 'massive-dynamic'),
        'section' => 'h6_sec',
        'default' => PIXFLOW_H6_STYLE,
        'separator' => true,
        'priority' => ++$priority,
        'class' => 'glue',
        'transport' => 'postMessage'
    );//Italic

    $controls[] = array(
        'type' => 'description',
        'default' => esc_attr__('Choose desired options for H6 tag. Please note that this settings will affect most shortcodes(elements) that use H6 for title.','massive-dynamic'),
        'setting' => 'h6_description',
        'section' => 'h6_sec',
        'priority' => ++$priority,
        'class' => 'glue last',
    );

    /******* Paragraph Sec *******/
    $controls[] = array(
        'type' => 'select',
        'setting' => 'p_name',
        'label' => esc_attr__('Font Family', 'massive-dynamic'),
        'section' => 'p_sec',
        'default' => PIXFLOW_P_NAME,
        'class' => 'glue first font-picker',
        'priority' => ++$priority,
        'choices' => array(pixflow_get_theme_mod('p_name',PIXFLOW_P_NAME)),
        'separator' => true,
    );// Font Name

    $controls[] = array(
        'type' => 'slider',
        'setting' => 'p_size',
        'label' => esc_attr__('Size', 'massive-dynamic'),
        'section' => 'p_sec',
        'default' => PIXFLOW_P_SIZE,
        'priority' => ++$priority,
        'class' => 'glue ',
        'choices' => array(
            'min' => 7,
            'max' => 70,
            'step' => 1,
            'unit' => 'px'
        ),
        'transport' => 'postMessage',
        'separator' => true,
    );// font size

    $controls[] = array(
        'type' => 'slider',
        'setting' => 'p_weight',
        'label' => esc_attr__('Weight', 'massive-dynamic'),
        'section' => 'p_sec',
        'default' => PIXFLOW_P_WEIGHT,
        'priority' => ++$priority,
        'class' => 'glue',
        'separator' => true,
        'choices' => array(
            'min' => 100,
            'max' => 800,
            'step' => 100,
        )
    );// font weight

    $controls[] = array(
        'type' => 'slider',
        'setting' => 'p_lineHeight',
        'label' => esc_attr__('Line Height', 'massive-dynamic'),
        'section' => 'p_sec',
        'default' => PIXFLOW_P_LINEHEIGHT,
        'priority' => ++$priority,
        'choices' => array(
            'min' => 8,
            'max' => 90,
            'step' => 1,
            'unit' => 'px'
        ),
        'class' => 'glue',
        'transport' => 'postMessage',
        'separator' => true,
    );

    $controls[] = array(
        'type' => 'slider',
        'setting' => 'p_letterSpace',
        'label' => esc_attr__('Letter Spacing', 'massive-dynamic'),
        'section' => 'p_sec',
        'default' => PIXFLOW_P_LETTERSPACE,
        'priority' => ++$priority,
        'choices' => array(
            'min' => 0,
            'max' => 10,
            'step' => 0.01,
            'unit' => 'px'
        ),
        'separator' => true,
        'transport' => 'postMessage',
        'class' => 'glue',
    );

    $controls[] = array(
        'type' => 'rgba',
        'setting' => 'p_color',
        'label' => esc_attr__('Color', 'massive-dynamic'),
        'section' => 'p_sec',
        'default' => PIXFLOW_P_COLOR,
        'separator' => true,
        'priority' => ++$priority,
        'class' => 'glue',
        'transport' => 'postMessage'
    );// Font Color

    $controls[] = array(
        'type' => 'checkbox',
        'setting' => 'p_style',
        'label' => esc_attr__('Italic', 'massive-dynamic'),
        'section' => 'p_sec',
        'default' => PIXFLOW_P_STYLE,
        'separator' => true,
        'priority' => ++$priority,
        'class' => 'glue',
        'transport' => 'postMessage'
    );//font Style

    $controls[] = array(
        'type' => 'description',
        'default' => esc_attr__('Choose desired options for p tag. Please note that this settings will affect most shortcodes(elements) with description text.','massive-dynamic'),
        'setting' => 'p_description',
        'section' => 'p_sec',
        'priority' => ++$priority,
        'class' => 'glue last',
    );

    /******* Links Sec *******/
    $controls[] = array(
        'type' => 'select',
        'setting' => 'link_name',
        'panel' => 'typo',
        'label' => esc_attr__('Font Family', 'massive-dynamic'),
        'section' => 'link_sec',
        'default' => PIXFLOW_LINK_NAME,
        'priority' => ++$priority,
        'choices' => array(pixflow_get_theme_mod('link_name',PIXFLOW_LINK_NAME)),
        'class' => 'glue font-picker',
        'transport' => 'refresh',
        'separator' => true,
    );// Font Name

    $controls[] = array(
        'type' => 'slider',
        'setting' => 'link_size',
        'label' => esc_attr__('Size', 'massive-dynamic'),
        'section' => 'link_sec',
        'default' => PIXFLOW_LINK_SIZE,
        'priority' => ++$priority,
        'choices' => array(
            'min' => 10,
            'max' => 30,
            'step' => 1,
            'unit' => 'px'
        ),
        'class' => 'glue',
        'transport' => 'postMessage',
        'separator' => true,
    );// font size

    $controls[] = array(
        'type' => 'slider',
        'setting' => 'link_weight',
        'label' => esc_attr__('Weight', 'massive-dynamic'),
        'section' => 'link_sec',
        'default' => PIXFLOW_LINK_WEIGHT,
        'priority' => ++$priority,
        'choices' => array(
            'min' => 100,
            'max' => 800,
            'step' => 100,
        ),
        'class' => 'glue ',
        'separator' => true,
        'transport' => 'refresh',
    );// font weight

    $controls[] = array(
        'type' => 'slider',
        'setting' => 'link_lineHeight',
        'label' => esc_attr__('Line Height', 'massive-dynamic'),
        'section' => 'link_sec',
        'default' => PIXFLOW_LINK_LINEHEIGHT,
        'priority' => ++$priority,
        'choices' => array(
            'min' => 10,
            'max' => 30,
            'step' => 1,
            'unit' => 'px'
        ),
        'class' => 'glue',
        'transport' => 'postMessage',
        'separator' => true,
    );//Line Height

    $controls[] = array(
        'type' => 'slider',
        'setting' => 'link_letterSpace',
        'label' => esc_attr__('Letter Spacing', 'massive-dynamic'),
        'section' => 'link_sec',
        'default' => PIXFLOW_LINK_LETTERSPACE,
        'priority' => ++$priority,
        'choices' => array(
            'min' => 0,
            'max' => 10,
            'step' => 1,
            'unit' => 'px'
        ),
        'transport' => 'postMessage',
        'separator' => true,
        'class' => 'glue ',
    );//Letter Spacing

    $controls[] = array(
        'type' => 'rgba',
        'setting' => 'link_color',
        'label' => esc_attr__('Color', 'massive-dynamic'),
        'section' => 'link_sec',
        'default' => PIXFLOW_LINK_COLOR,
        'priority' => ++$priority,
        'separator' => true,
        'transport' => 'postMessage',
        'class' => 'glue',
    );// Font Color

    $controls[] = array(
        'type' => 'checkbox',
        'setting' => 'link_style',
        'label' => esc_attr__('Italic', 'massive-dynamic'),
        'section' => 'link_sec',
        'default' => PIXFLOW_LINK_STYLE,
        'separator' => true,
        'priority' => ++$priority,
        'class' => 'glue',
        'transport' => 'postMessage'
    );//Italic

    $controls[] = array(
        'type' => 'description',
        'default' => esc_attr__('Choose desired options for a tag.','massive-dynamic'),
        'setting' => 'link_description',
        'section' => 'link_sec',
        'priority' => ++$priority,
        'class' => 'glue last',
    );

    /******* Charset Sec *******/
    $controls[] = array(
        'type' => 'switch',
        'setting' => 'advance_char',
        'label' => esc_attr__('Advanced charset', 'massive-dynamic'),
        'section' => 'charset_sec',
        'priority' => ++$priority,
        'class' => 'glue first last',
        'default' => PIXFLOW_ADVANCE_CHAR,
        'transport' => 'postMessage',
        'text' => array('checked' => esc_attr__('on','massive-dynamic'), 'unchecked' => esc_attr__('off','massive-dynamic') ),
        'separator' => true,
    );
    $controls[] = array(
        'type' => 'checkbox',
        'setting' => 'cyrillic',
        'label' => esc_attr__('Cyrillic', 'massive-dynamic'),
        'section' => 'charset_sec',
        'default' => PIXFLOW_CYRILLIC,
        'priority' => ++$priority,
        'separator' => true,
        'required' => array(array('type' => 'checkbox', 'setting' => 'advance_char', 'value' => '1')),
        'class' => 'glue '

    );//char set
    $controls[] = array(
        'type' => 'checkbox',
        'setting' => 'cyrillic_ext',
        'label' => esc_attr__('Cyrillic Extended ', 'massive-dynamic'),
        'section' => 'charset_sec',
        'default' => PIXFLOW_CYRILLIC_EXT,
        'priority' => ++$priority,
        'separator' => true,
        'required' => array(array('type' => 'checkbox', 'setting' => 'advance_char', 'value' => '1')),
        'class' => 'glue'
    );
    $controls[] = array(
        'type' => 'checkbox',
        'setting' => 'latin',
        'label' => esc_attr__('Latin ', 'massive-dynamic'),
        'section' => 'charset_sec',
        'default' => PIXFLOW_LATIN,
        'priority' => ++$priority,
        'separator' => true,
        'required' => array(array('type' => 'checkbox', 'setting' => 'advance_char', 'value' => '1')),
        'class' => 'glue'
    );
    $controls[] = array(
        'type' => 'checkbox',
        'setting' => 'latin_ext',
        'label' => esc_attr__('Latin Extended ', 'massive-dynamic'),
        'section' => 'charset_sec',
        'default' => PIXFLOW_LATIN_EXT,
        'priority' => ++$priority,
        'separator' => true,
        'required' => array(array('type' => 'checkbox', 'setting' => 'advance_char', 'value' => '1')),
        'class' => 'glue'
    );
    $controls[] = array(
        'type' => 'checkbox',
        'setting' => 'greek',
        'label' => esc_attr__('Greek', 'massive-dynamic'),
        'section' => 'charset_sec',
        'default' => PIXFLOW_GREEK,
        'priority' => ++$priority,
        'separator' => true,
        'required' => array(array('type' => 'checkbox', 'setting' => 'advance_char', 'value' => '1')),
        'class' => 'glue'
    );
    $controls[] = array(
        'type' => 'checkbox',
        'setting' => 'greek_ext',
        'label' => esc_attr__('Greek Extended  ', 'massive-dynamic'),
        'section' => 'charset_sec',
        'default' => PIXFLOW_GREEK_EXT,
        'priority' => ++$priority,
        'separator' => true,
        'required' => array(array('type' => 'checkbox', 'setting' => 'advance_char', 'value' => '1')),
        'class' => 'glue'
    );
    $controls[] = array(
        'type' => 'checkbox',
        'setting' => 'vietnamese',
        'label' => esc_attr__('Vietnamese ', 'massive-dynamic'),
        'section' => 'charset_sec',
        'default' => PIXFLOW_VIETNAMESE,
        'priority' => ++$priority,
        'required' => array(array('type' => 'checkbox', 'setting' => 'advance_char', 'value' => '1')),
        'class' => 'glue'
    );

    $controls[] = array(
        'type' => 'description',
        'default' => esc_attr__('Use this option to load extra charsets for google fonts.','massive-dynamic'),
        'setting' => 'charset_sec_description',
        'section' => 'charset_sec',
        'priority' => ++$priority,
        'class' => 'glue last',
    );

    //-------------------------------------------------
    // Social Panel Options
    //-------------------------------------------------
    /******* Social Items Sec *******/
    $controls[] = array(
        'type' => 'description',
        'default' => esc_attr__('Enter your social network addresses here. Please note that there must be http:// or https:// at the beginning of URLs.','massive-dynamic'),
        'setting' => 'social_description',
        'section' => 'social_item',
        'priority' => ++$priority,
        'class' => 'glue',
    );

    $socials = array('facebook' => 'icon-facebook2', 'twitter' => 'icon-twitter5', 'vimeo' => 'icon-vimeo',
        'youtube' => 'icon-youtube2', 'googleP' => 'icon-googleplus', 'dribbble' => 'icon-dribbble',
        'tumblr' => 'icon-tumblr', 'linkedin' => 'icon-linkedin', 'flickr' => 'icon-flickr2',
        'forrst' => 'icon-forrst', 'github' => 'icon-github2', 'lastfm' => 'icon-lastfm', 'paypal' => 'icon-paypal4',
        'rss' => 'icon-feed2', 'wp' => 'icon-wordpress', 'deviantart' => 'icon-deviantart2', 'steam' => 'icon-steam',
        'soundcloud' => 'icon-soundcloud3', 'foursquare' => 'icon-foursquare', 'skype' => 'icon-skype',
        'reddit' => 'icon-reddit', 'instagram' => 'icon-instagram', 'blogger' => 'icon-blogger', 'yahoo' => 'icon-yahoo',
        'behance' => 'icon-behance', 'delicious' => 'icon-delicious', 'stumbleupon' => 'icon-stumbleupon3', 'pinterest' => 'icon-pinterest3', 'xing' => 'icon-xing');
    $defaults = array('facebook','twitter','youtube');
    foreach ($socials as $setting => $icon) {
        $default =(in_array($setting,$defaults))?'#':'';
        $controls[] = array(
            'type' => 'text',
            'placeholder' => esc_attr__('Insert Your social URL','massive-dynamic'),
            'default' => $default,
            'setting' => $setting . '_social',
            'label' => '',
            'section' => 'social_item',
            'transport' => 'postMessage',
            'priority' => ++$priority,
            'class' => 'social',
            'icon' => $icon,
        );
    }

    /******* Notification center Sec *******/
    $controls[] = array(
        'type' => 'switch',
        'setting' => 'notification_enable',
        'label' => esc_attr__('Notification', 'massive-dynamic'),
        'section' => 'notification_main',
        'priority' => ++$priority,
        'transport' => 'refresh',
        'separator' => false,
        'text' => array('checked' => esc_attr__('on','massive-dynamic'), 'unchecked' => esc_attr__('off','massive-dynamic') ),
        'default' => PIXFLOW_NOTIFICATION_ENABLE,
        'class' => 'glue'
    ); // On/Off Notification

    $controls[] = array(
        'type' => 'titletext',
        'default' => esc_attr__('Latest Post Number','massive-dynamic'),
        'setting' => 'notify_sec1_title',
        'section' => 'notification_main',
        'class' => 'glue first',
        'separator' => true,
        'priority' => ++$priority,
        'required' => array(array('type' => 'checkbox', 'setting' => 'notification_enable', 'value' => '1')),
    );//title of first sec.

    $controls[] = array(
        'type' => 'slider',
        'class' => 'glue',
        'setting' => 'post_count',
        'label' => esc_attr__('Blog Posts', 'massive-dynamic'),
        'section' => 'notification_main',
        'default' => PIXFLOW_POST_COUNT,
        'priority' => ++$priority,
        'choices' => array(
            'min' => 5,
            'max' => 20,
            'step' => 1,
        ),
        'transport' => 'refresh',
        'separator' => true,
        'required' => array(array('type' => 'checkbox', 'setting' => 'notification_enable', 'value' => '1')),

    );

    $controls[] = array(
        'type' => 'slider',
        'class' => 'glue',
        'setting' => 'project_count',
        'label' => esc_attr__('Portfolio Posts', 'massive-dynamic'),
        'section' => 'notification_main',
        'default' => PIXFLOW_PROJECT_COUNT,
        'priority' => ++$priority,
        'choices' => array(
            'min' => 5,
            'max' => 50,
            'step' => 1,
        ),
        'transport' => 'refresh',
        'required' => array(array('type' => 'checkbox', 'setting' => 'notification_enable', 'value' => '1')),
    );

    $controls[] = array(
        'type' => 'description',
        'default' => esc_attr__('Choose the number of latest blog and portfolio posts to be shown in notification center.','massive-dynamic'),
        'setting' => 'notify_sec1_description',
        'section' => 'notification_main',
        'priority' => ++$priority,
        'class' => 'glue last',
        'required' => array(array('type' => 'checkbox', 'setting' => 'notification_enable', 'value' => '1')),
    );//desc. of first sec.

    $controls[] = array(
        'type' => 'titletext',
        'default' => esc_attr__('Appearance','massive-dynamic'),
        'setting' => 'notify_sec2_title',
        'section' => 'notification_main',
        'class' => 'glue first',
        'separator' => true,
        'priority' => ++$priority,
        'required' => array(array('type' => 'checkbox', 'setting' => 'notification_enable', 'value' => '1')),
    );//title of 2nd sec.

    $controls[] = array(
        'type' => 'radio',
        'mode' => 'buttonset',
        'setting' => 'notify_bg',
        'label' => esc_attr__('Skin', 'massive-dynamic'),
        'section' => 'notification_main',
        'default' => PIXFLOW_NOTIFY_BG,
        'priority' => ++$priority,
        'class' => 'glue first',
        'choices' => array(
            'dark' => esc_attr__('Dark', 'massive-dynamic'),
            'light' => esc_attr__('Light', 'massive-dynamic'),
        ),
        'transport' => 'postMessage',
        'separator' => true,
        'required' => array(array('type' => 'checkbox', 'setting' => 'notification_enable', 'value' => '1')),
    ); // background type

    $controls[] = array(
        'type' => 'rgba',
        'setting' => 'notification_color',
        'label' => esc_attr__('Accent Color', 'massive-dynamic'),
        'section' => 'notification_main',
        'default' => PIXFLOW_NOTIFICATION_COLOR,
        'priority' => ++$priority,
        'transport' => 'postMessage',
        'class' => 'glue',
        'separator' => true,
        'required' => array(array('type' => 'checkbox', 'setting' => 'notification_enable', 'value' => '1')),
    );// Accent Color

    $controls[] = array(
        'type' => 'slider',
        'setting' => 'nav_icon_size',
        'label' => esc_attr__('Icon Size', 'massive-dynamic'),
        'section' => 'notification_main',
        'default' => PIXFLOW_NAV_ICON_SIZE,
        'priority' => ++$priority,
        'choices' => array(
            'min' => 15,
            'max' => 40,
            'step' => 1,
            'unit' => 'px'
        ),
        'class' => 'glue',
        'transport' => 'postMessage',
        'required' => array(array('type' => 'checkbox', 'setting' => 'notification_enable', 'value' => '1')),
    );// notification icons size

    $controls[] = array(
        'type' => 'description',
        'default' => esc_attr__('Choose to have a dark or light notification center. Accent color is used for colored elements in notification center. Icon size determines the size of notification center icons in header.','massive-dynamic'),
        'setting' => 'notify_sec2_description',
        'section' => 'notification_main',
        'priority' => ++$priority,
        'class' => 'glue last',
        'required' => array(array('type' => 'checkbox', 'setting' => 'notification_enable', 'value' => '1')),
    );//desc. of 2nd sec.

    $controls[] = array(
        'type' => 'titletext',
        'default' => esc_attr__('Latest Posts Sections','massive-dynamic'),
        'setting' => 'notify_sec3_title',
        'section' => 'notification_main',
        'class' => 'glue first',
        'separator' => true,
        'priority' => ++$priority,
        'required' => array(array('type' => 'checkbox', 'setting' => 'notification_enable', 'value' => '1')),
    );//title of 3rd sec.

    $controls[] = array(
        'type' => 'switch',
        'setting' => 'notification_post',
        'label' => esc_attr__('Blog Posts', 'massive-dynamic'),
        'section' => 'notification_main',
        'text' => array('checked' => esc_attr__('on','massive-dynamic'), 'unchecked' => esc_attr__('off','massive-dynamic') ),
        'default' => PIXFLOW_NOTIFICATION_POST,
        'transport' => 'postMessage',
        'class' => 'glue',
        'separator' => true,
        'priority' => ++$priority,
        'required' => array(array('type' => 'checkbox', 'setting' => 'notification_enable', 'value' => '1')),
    );//Posts

    $controls[] = array(
        'type' => 'switch',
        'setting' => 'notification_portfolio',
        'label' => esc_attr__('Portfolio Posts', 'massive-dynamic'),
        'section' => 'notification_main',
        'text' => array('checked' => esc_attr__('on','massive-dynamic'), 'unchecked' => esc_attr__('off','massive-dynamic') ),
        'default' => PIXFLOW_NOTIFICATION_PORTFOLIO,
        'transport' => 'postMessage',
        'class' => 'glue',
        'priority' => ++$priority,
        'separator' => true,
        'required' => array(array('type' => 'checkbox', 'setting' => 'notification_enable', 'value' => '1')),
    );//Portfolio

    $controls[] = array(
        'type' => 'select',
        'setting' => 'active_tab_sec',
        'label' => esc_attr__('Active Tab', 'massive-dynamic'),
        'section' => 'notification_main',
        'default' => PIXFLOW_ACTIVE_TAB_SEC,
        'class' => 'glue',
        'priority' => ++$priority,
        'choices' => array(
            'posts'   =>  esc_attr__('Posts', 'massive-dynamic'),
            'portfolio' =>  esc_attr__('Portfolio', 'massive-dynamic'),
        ),
        'transport' => 'postMessage',
        'required' => array(array('type' => 'checkbox', 'setting' => 'notification_enable', 'value' => '1')),

    );//Active tab

    $controls[] = array(
        'type' => 'switch',
        'setting' => 'active_icon',
        'label' => esc_attr__('Show Icon In Header', 'massive-dynamic'),
        'section' => 'notification_main',
        'priority' => ++$priority,
        'transport' => 'postMessage',
        'separator' => false,
        'text' => array('checked' => esc_attr__('on','massive-dynamic'), 'unchecked' => esc_attr__('off','massive-dynamic') ),
        'default' => PIXFLOW_ACTIVE_ICON,
        'class' => 'glue last',
        'separator' => true,
        'compare' => 'and',
        'required' => array(
            array('type' => 'checkbox', 'setting' => 'notification_enable', 'value' => '1'),
        ),
    ); // On/Off Active Tab Icon

    $controls[] = array(
        'type' => 'description',
        'default' => esc_attr__('Choose to display latest posts in notification center or not. You can set the active tab of notification center on latest portfolios or latest blog posts. Also you can display notification icon in header, when this icons is clicked, it will take you to active tab.','massive-dynamic'),
        'setting' => 'notify_sec3_description',
        'section' => 'notification_main',
        'priority' => ++$priority,
        'class' => 'glue last',
        'required' => array(array('type' => 'checkbox', 'setting' => 'notification_enable', 'value' => '1')),
    );//desc. of 3rd sec.


    $controls[] = array(
        'type' => 'titletext',
        'default' => esc_attr__('Search & Shop','massive-dynamic'),
        'setting' => 'notify_sec4_title',
        'section' => 'notification_main',
        'class' => 'glue first',
        'separator' => true,
        'priority' => ++$priority,
        'required' => array(array('type' => 'checkbox', 'setting' => 'notification_enable', 'value' => '1')),
    );//title of 4th sec.

    $controls[] = array(
        'type' => 'switch',
        'setting' => 'notification_search',
        'label' => esc_attr__('Search Option', 'massive-dynamic'),
        'section' => 'notification_main',
        'text' => array('checked' => esc_attr__('on','massive-dynamic'), 'unchecked' => esc_attr__('off','massive-dynamic') ),
        'default' => PIXFLOW_NOTIFICATION_SEARCH,
        'transport' => 'postMessage',
        'class' => 'glue ',
        'separator' => true,
        'priority' => ++$priority,
        'required' => array(array('type' => 'checkbox', 'setting' => 'notification_enable', 'value' => '1')),
    );//Search

    $controls[] = array(
        'type' => 'switch',
        'setting' => 'search_enable',
        'label' => esc_attr__('Show Icon In Header', 'massive-dynamic'),
        'section' => 'notification_main',
        'priority' => ++$priority,
        'transport' => 'postMessage',
        'separator' => false,
        'text' => array('checked' => esc_attr__('on','massive-dynamic'), 'unchecked' => esc_attr__('off','massive-dynamic') ),
        'default' => PIXFLOW_SEARCH_ENABLE,
        'class' => 'glue last',
        'separator' => true,
        'compare' => 'and',
        'required' => array(
            array('type' => 'checkbox', 'setting' => 'notification_search', 'value' => '1'),
            array('type' => 'checkbox', 'setting' => 'notification_enable', 'value' => '1'),
        ),
    ); // On/Off Search

    $controls[] = array(
        'type' => 'switch',
        'setting' => 'notification_cart',
        'label' => esc_attr__('Shop Cart Option', 'massive-dynamic'),
        'section' => 'notification_main',
        'text' => array('checked' => esc_attr__('on','massive-dynamic'), 'unchecked' => esc_attr__('off','massive-dynamic') ),
        'default' => PIXFLOW_NOTIFICATION_CART,
        'transport' => 'postMessage',
        'class' => 'glue',
        'priority' => ++$priority,
        'required' => array(array('type' => 'checkbox', 'setting' => 'notification_enable', 'value' => '1')),
    );//Shop Cart

    $controls[] = array(
        'type' => 'switch',
        'setting' => 'shop_cart_enable',
        'label' => esc_attr__('Show Icon in Header', 'massive-dynamic'),
        'section' => 'notification_main',
        'priority' => ++$priority,
        'transport' => 'postMessage',
        'separator' => false,
        'text' => array('checked' => esc_attr__('on','massive-dynamic'), 'unchecked' => esc_attr__('off','massive-dynamic') ),
        'default' => PIXFLOW_SHOP_CART_ENABLE,
        'class' => 'glue',
        'compare' => 'and',
        'separator' => true,
        'required' => array(
            array('type' => 'checkbox', 'setting' => 'notification_cart', 'value' => '1'),
            array('type' => 'checkbox', 'setting' => 'notification_enable', 'value' => '1')
        ),
    ); // On/Off Shop Cart

    $controls[] = array(
        'type' => 'description',
        'default' => esc_attr__('Choose to have Search and Shop section in notification center. Also you can choose to display search and shop icons in header.','massive-dynamic'),
        'setting' => 'notify_sec4_description',
        'section' => 'notification_main',
        'priority' => ++$priority,
        'class' => 'glue last',
        'required' => array(array('type' => 'checkbox', 'setting' => 'notification_enable', 'value' => '1')),
    );//desc. of 4th sec.



    return $controls;
}

add_filter('customizer/controls', 'pixflow_customizer_settings');
