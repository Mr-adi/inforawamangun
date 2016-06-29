<?php

if ( !function_exists('register_sidebar') )
    return;

$defaults = array(
    'name' => esc_attr__('Main Sidebar', 'massive-dynamic'),
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget'  => '</div>',
    'before_title'  => '<h4 class="widget-title">',
    'after_title'   => '</h4><div class="separator"></div>',
);

//Main sidebar
register_sidebar(array_merge($defaults, array('id'=> 'main-sidebar')));

//Page sidebar
register_sidebar(array_merge($defaults, array('name'=>esc_attr__('Page Sidebar', 'massive-dynamic'), 'id' => 'page-sidebar')));

//Post sidebar
register_sidebar(array_merge($defaults, array('name'=>esc_attr__('Post Sidebar', 'massive-dynamic'), 'id' => 'post-sidebar')));

//Double sidebar
register_sidebar(array_merge($defaults, array('name'=>esc_attr__('Double Sidebar', 'massive-dynamic'), 'id' => 'double-sidebar')));

//Shop sidebar
register_sidebar(array_merge($defaults, array('name'=>esc_attr__('Shop Sidebar', 'massive-dynamic'), 'id' => 'shop-sidebar')));

//Footer widgets
$footerWidgets = pixflow_opt('footer_widgets') == '' ? PIXFLOW_DEFAULT_FOOTER_WIDGETS : (int)pixflow_opt('footer_widgets');

for($i=1; $i<=$footerWidgets; $i++)
{
    register_sidebar(array_merge($defaults, array(
        'id'   => "footer-widget-$i",
        'name' => "Footer Widget Area $i",
    )));
}

//Custom Sidebars

$sidebars = pixflow_get_custom_sidebars();

foreach($sidebars as $key => $item)
{
    register_sidebar(array_merge($defaults, array(
        'id'   => $key,
        'name' => $item,
    )));
}
