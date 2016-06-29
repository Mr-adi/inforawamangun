<?php
function pixflow_theme_scripts()
{
    //Register Bootstrap Style
    wp_enqueue_style('bootstrap-style',pixflow_path_combine(PIXFLOW_THEME_CSS_URI,'bootstrap.css'),array(),PIXFLOW_THEME_VERSION);

    //Register Main Theme Styles
    wp_enqueue_style('style', get_stylesheet_uri(), false, PIXFLOW_THEME_VERSION);

    //Register google fonts
    pixflow_theme_fonts();

    //enqueue style
    wp_enqueue_style('plugin-styles',pixflow_path_combine(PIXFLOW_THEME_CSS_URI,'plugin.css'),false,PIXFLOW_THEME_VERSION);

    //TF requirement (we have our own reply script for gods sake!)
    if(PIXFLOW_USE_COMMENT_REPLY_SCRIPT && is_singular())
        wp_enqueue_script( "comment-reply" );

    $postType = '';

    if( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) )) ){
        //enqueue style
        wp_enqueue_style('woo-commerce-styles',pixflow_path_combine(PIXFLOW_THEME_CSS_URI,'woo-commerce.css'),false,PIXFLOW_THEME_VERSION);

    }

    if (is_home()) {
        $postID = get_option('page_for_posts');
    } elseif (function_exists('is_shop') && (is_shop() || is_product_category()) && !is_product()) {
        $postID = get_option('woocommerce_shop_page_id');
    } else {
        $postID = get_the_ID();
    }
    if ((in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins'))) || class_exists('WooCommerce')) && function_exists('is_product')) {
        if (is_product()) {
            $postType = 'product';
        } else if ((is_woocommerce() || is_account_page())) {
            $postType = 'shop';
        }
    }
    if (is_single()) {
        $postType = 'single';
    } else if (is_home() || (is_front_page() && is_home())) {
        $postType = 'blog';
    } else if (is_page()) {
        $postType = 'page';
    } elseif (function_exists('is_shop') && (is_shop() || is_product_category()) && !is_product()) {
        $postType = 'shop';
    } else {
        $postType = 'blog';
        $postID = get_option('page_for_posts');
    }
    //Responsive styles
    wp_enqueue_style('responsive-style', pixflow_path_combine(PIXFLOW_THEME_CSS_URI, 'responsive.css'), false, PIXFLOW_THEME_VERSION);


    wp_enqueue_style('styles', pixflow_path_combine(PIXFLOW_THEME_CSS_URI, 'styles-inline.php?id=' . $postType . '&post_id=' . $postID), array(), PIXFLOW_THEME_VERSION, 'all');

    //register and enqueue html5shiv
    global $wp_scripts;
    wp_register_script(
        'html5shiv',
        pixflow_path_combine(PIXFLOW_THEME_JS_URI, 'html5shiv.js'),
        array(),
        '3.6.2'
    );
    $wp_scripts->add_data('html5shiv', 'conditional', 'lt IE 9');
    if (! isset($_SERVER['HTTP_USER_AGENT'])) {
        $_SERVER['HTTP_USER_AGENT'] = '';
    }
    preg_match('/MSIE (.*?);/', $_SERVER['HTTP_USER_AGENT'], $matches);
    if (count($matches) > 1) {
        //Then we're using IE
        $version = $matches[1];

        if ($version <= 9) {
            wp_enqueue_script('html5shiv');
        }
        if ($version <= 10) {
            wp_enqueue_style('isotope', pixflow_path_combine(PIXFLOW_THEME_CSS_URI, 'isotope.css'), false, PIXFLOW_THEME_VERSION);
        }
    }

    //Include jQuery
    wp_enqueue_script('jquery');

    wp_enqueue_script('jquery-ui-script', pixflow_path_combine(PIXFLOW_THEME_JS_URI, 'jquery-ui.min.js'), array(), PIXFLOW_THEME_VERSION, true);

    //Register Pixflow icon-font library
    wp_enqueue_style('px=iconfonts-style', pixflow_path_combine(PIXFLOW_THEME_CSS_URI, 'iconfonts.css'), array(), PIXFLOW_THEME_VERSION);

    // Flexslider(added for mac device slider shortcode)
    wp_enqueue_script('flexslider-script', pixflow_path_combine(PIXFLOW_THEME_JS_URI, 'jquery.flexslider-min.js'), array(), PIXFLOW_THEME_VERSION);
    wp_enqueue_style('flexslider-style', pixflow_path_combine(PIXFLOW_THEME_CSS_URI, 'flexslider.css'), array(), PIXFLOW_THEME_VERSION);

    if(defined('LS_PLUGIN_VERSION')){
        wp_dequeue_script('greensock');
    }

    wp_enqueue_script('plugin-js', pixflow_path_combine(PIXFLOW_THEME_JS_URI, 'plugins.js'), array(), PIXFLOW_THEME_VERSION, true);
    wp_enqueue_script('main-custom-js', pixflow_path_combine(PIXFLOW_THEME_JS_URI, 'custom.js'), array(), PIXFLOW_THEME_VERSION, true);

    //Flickity Pluging
    wp_enqueue_style('flickity-style', pixflow_path_combine(PIXFLOW_THEME_CSS_URI, 'flickity.min.css'), array(), PIXFLOW_THEME_VERSION);

    $customizeLocalizedOptions = array(

        'site_bg_image_attach' => pixflow_get_theme_mod('site_bg_image_attach', PIXFLOW_SITE_BG_IMAGE_ATTACH),
        'headerBgColorType' => pixflow_get_theme_mod('header_bg_color_type', PIXFLOW_HEADER_BG_COLOR_TYPE),
        'navColor' => pixflow_get_theme_mod('nav_color', PIXFLOW_NAV_COLOR),
        'navHoverColor' => pixflow_get_theme_mod('nav_hover_color', PIXFLOW_NAV_HOVER_COLOR),
        'navColorSecond' => pixflow_get_theme_mod('nav_color_second', PIXFLOW_NAV_COLOR_SECOND),
        'navHoverColorSecond' => pixflow_get_theme_mod('nav_hover_color_second', PIXFLOW_NAV_HOVER_COLOR_SECOND),
        'headerBgGradientColor1' => pixflow_get_theme_mod('header_bg_gradient_color1', PIXFLOW_HEADER_BG_GRADIENT_COLOR1),
        'headerBgGradientColor2' => pixflow_get_theme_mod('header_bg_gradient_color2', PIXFLOW_HEADER_BG_GRADIENT_COLOR2),
        'headerBgGradientOrientation' => pixflow_get_theme_mod('header_bg_gradient_orientation', PIXFLOW_HEADER_BG_GRADIENT_ORIENTATION),
        'headerBgColorTypeSecond' => pixflow_get_theme_mod('header_bg_color_type_second', PIXFLOW_HEADER_BG_COLOR_TYPE_SECOND),
        'headerBgGradientSecondColor1' => pixflow_get_theme_mod('header_bg_gradient_second_color1', PIXFLOW_HEADER_BG_GRADIENT_SECOND_COLOR1),
        'headerBgGradientSecondColor2' => pixflow_get_theme_mod('header_bg_gradient_second_color2', PIXFLOW_HEADER_BG_GRADIENT_SECOND_COLOR2),
        'headerBgGradientSecondOrientation' => pixflow_get_theme_mod('header_bg_gradient_second_orientation', PIXFLOW_HEADER_BG_GRADIENT_SECOND_ORIENTATION),
        'headerBgSolidColorSecond' => pixflow_get_theme_mod('header_bg_solid_color_second', PIXFLOW_HEADER_BG_SOLID_COLOR_SECOND),
        'headerBgSolidColor' => pixflow_get_theme_mod('header_bg_solid_color', PIXFLOW_HEADER_BG_SOLID_COLOR),
        'businessBarEnable' => pixflow_get_theme_mod('businessBar_enable', PIXFLOW_BUSINESSBAR_ENABLE),
        'sidebar_style' => pixflow_get_theme_mod('sidebar-style', PIXFLOW_SIDEBAR_STYLE),
        'page_sidebar_bg_image_position' => pixflow_get_theme_mod('page_sidebar_bg_image_position', PIXFLOW_PAGE_SIDEBAR_BG_IMAGE_POSITION),
        'sidebar_style_shop' => pixflow_get_theme_mod('sidebar-style-shop', PIXFLOW_SIDEBAR_STYLE_SHOP),
        'shop_sidebar_bg_image_position' => pixflow_get_theme_mod('shop_sidebar_bg_image_position', PIXFLOW_SHOP_SIDEBAR_BG_IMAGE_POSITION),
        'sidebar_style_single' => pixflow_get_theme_mod('sidebar-style-single', PIXFLOW_SIDEBAR_STYLE_SINGLE),
        'single_sidebar_bg_image_position' => pixflow_get_theme_mod('single_sidebar_bg_image_position', PIXFLOW_SINGLE_SIDEBAR_BG_IMAGE_POSITION),
        'sidebar_style_blog' => pixflow_get_theme_mod('sidebar-style-blog', PIXFLOW_SIDEBAR_STYLE_BLOG),
        'blog_sidebar_bg_image_position' => pixflow_get_theme_mod('blog_sidebar_bg_image_position', PIXFLOW_BLOG_SIDEBAR_BG_IMAGE_POSITION),
        'showUpAfter' => pixflow_get_theme_mod('show_up_after', PIXFLOW_SHOW_UP_AFTER),
        'showUpStyle' => pixflow_get_theme_mod('show_up_style', PIXFLOW_SHOW_UP_STYLE),
        'siteTop' => pixflow_get_theme_mod('site_top', PIXFLOW_SITE_TOP),
        'footerWidgetAreaSkin' => pixflow_get_theme_mod('footer_widget_area_skin', PIXFLOW_FOOTER_WIDGET_AREA_SKIN),
        'headerTopWidth' => pixflow_get_theme_mod('header_top_width', PIXFLOW_HEADER_TOP_WIDTH),
        'layoutWidth' => pixflow_get_theme_mod('site_width', PIXFLOW_SITE_WIDTH),
        'lightLogo' => pixflow_get_theme_mod('light_logo', PIXFLOW_LIGHT_LOGO),
        'darkLogo' => pixflow_get_theme_mod('dark_logo', PIXFLOW_DARK_LOGO),
        'logoStyle' => pixflow_get_theme_mod('logo_style', PIXFLOW_LOGO_STYLE),
        'logoStyleSecond' => pixflow_get_theme_mod('logo_style_second', PIXFLOW_LOGO_STYLE_SECOND),
        'activeNotificationTab' => pixflow_get_theme_mod('active_tab_sec', PIXFLOW_ACTIVE_TAB_SEC),
        'goToTopShow' => pixflow_get_theme_mod('go_to_top_show', PIXFLOW_GO_TO_TOP_SHOW),
        'loadingType' => pixflow_get_theme_mod('loading_type', PIXFLOW_LOADING_TYPE),
        'leaveMsg' => esc_attr__('You are about to leave this page and you haven\'t saved changes yet, would you like to save changes before leaving?','massive-dynamic'),
        'unsaved' => esc_attr__('Unsaved Changes!','massive-dynamic'),
        'save_leave' => esc_attr__('Save & Leave','massive-dynamic'),
        'mailchimpNotInstalled' => esc_attr__('MailChimp for Wordpress is not installed.','massive-dynamic'),
        'search' => esc_attr__('Search...','massive-dynamic'),
    );
    if(is_front_page()){
        $customizeLocalizedOptions['loadingText'] = pixflow_get_theme_mod('loading_text', PIXFLOW_LOADING_TEXT);
        $customizeLocalizedOptions['preloaderLogo'] = pixflow_get_theme_mod('preloader_logo', PIXFLOW_PRELOADER_LOGO);
    }else{
        $customizeLocalizedOptions['loadingText'] = '';
    }
    wp_localize_script('main-custom-js', 'themeOptionValues', $customizeLocalizedOptions);

    // Load required scripts in customizer
    $_SERVER['HTTP_REFERER'] = (isset($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : '';
    $parentURL = $_SERVER['HTTP_REFERER'];
    if (($pos = strpos($parentURL, "?")) === false) $parentURL = $parentURL;
    else $parentURL = substr($parentURL, 0, $pos);
    if (strpos($parentURL, 'wp-admin/customize.php') !== false || strpos($_SERVER['HTTP_REFERER'], 'customizer=true')) {
        wp_enqueue_style('gizmo', pixflow_path_combine(PIXFLOW_THEME_LIB_URI . '/assets/css/', 'vc-gizmo.css'), array(), PIXFLOW_THEME_VERSION);
        wp_register_script('livepreview',pixflow_path_combine(PIXFLOW_THEME_CUSTOMIZER_URI . '/assets/js', 'livepreview.js'),false,PIXFLOW_THEME_VERSION,false);
        wp_enqueue_script('livepreview');
        wp_localize_script('livepreview', 'livepreview_var', array(
                'url' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('ajax-nonce'),
                'settings' => esc_attr__('settings','massive-dynamic'),
                'footerSetting' => esc_attr__('Footer Settings','massive-dynamic'),
                'saving' => esc_attr__('Saving...','massive-dynamic'),
                'save_preview' => esc_attr__('Save & View','massive-dynamic'),
                'allDone' => esc_attr__('All Done!','massive-dynamic')
            )
        );
    }

    if (!wp_script_is('niceScroll', 'enqueued')) {
        wp_enqueue_script('niceScroll', pixflow_path_combine(PIXFLOW_THEME_LIB_URI, 'assets/script/jquery.nicescroll.min.js'), false, PIXFLOW_THEME_VERSION, true);
    }

    if(is_singular('portfolio')){
        wp_enqueue_style('carousel_css',pixflow_path_combine(PIXFLOW_THEME_CSS_URI,'owl.carousel.css'),array(),PIXFLOW_THEME_VERSION);
        wp_enqueue_script('carousel_js',pixflow_path_combine(PIXFLOW_THEME_JS_URI,'owl.carousel.min.js'),array(),PIXFLOW_THEME_VERSION,true);
    }
}

if(isset($_SERVER['QUERY_STRING'])){
    if (strpos($_SERVER['QUERY_STRING'],'vc_action=vc_inline')===false) {
        add_action('wp_enqueue_scripts', 'pixflow_theme_scripts');
    }
}

//for define tween max in admin panel
function pixflow_admin_theme_scripts(){
    wp_enqueue_script('videojs-script',pixflow_path_combine(PIXFLOW_THEME_JS_URI,'video-js/video.js'),array(),PIXFLOW_THEME_VERSION,true);
    wp_enqueue_script('videojs-youtube-script',pixflow_path_combine(PIXFLOW_THEME_JS_URI,'video-js/youtube.js'),array(),PIXFLOW_THEME_VERSION,true);
    wp_enqueue_script('tweenMax',pixflow_path_combine(PIXFLOW_THEME_JS_URI,'TweenMax.min.js'),array(),PIXFLOW_THEME_VERSION,true);
}
add_action('admin_enqueue_scripts', 'pixflow_admin_theme_scripts');

function pixflow_customScript() {
    wp_enqueue_script( 'custom-script', pixflow_path_combine(PIXFLOW_THEME_JS_URI,'custom-script.js'));
    wp_add_inline_script( 'custom-script', pixflow_get_theme_mod('custom_js') );
}
add_action( 'wp_enqueue_scripts', 'pixflow_customScript' );

function pixflow_theme_fonts()
{
    $h1  = pixflow_get_theme_mod('h1_name',PIXFLOW_H1_NAME);
    $h2  = pixflow_get_theme_mod('h2_name',PIXFLOW_H2_NAME);
    $h3  = pixflow_get_theme_mod('h3_name',PIXFLOW_H3_NAME);
    $h4  = pixflow_get_theme_mod('h4_name',PIXFLOW_H4_NAME);
    $h5  = pixflow_get_theme_mod('h5_name',PIXFLOW_H5_NAME);
    $h6  = pixflow_get_theme_mod('h6_name',PIXFLOW_H6_NAME);
    $p   = pixflow_get_theme_mod('p_name',PIXFLOW_P_NAME);
    $nav = pixflow_get_theme_mod('nav_name',PIXFLOW_NAV_NAME);
    $link   = pixflow_get_theme_mod('link_name',PIXFLOW_LINK_NAME);
    $notification = $nav;

    //Fix for setup problem (shouldn't happen after the update, just for old setups)
    if('' == $h1 && '' == $h2 && '' == $h3 && '' == $h4 && '' == $h5 && '' == $h6
    && '' == $p && '' == $nav && ''== $link && '' == $notification )
        $notification = $h1 = $h2 = $h3 = $h4 = $h5 = $h6 = $p = $link = $nav = '';

    $fonts        = array($h1, $h2, $h3,$h4,$h5,$h6,$p,$nav,$link,$notification);
    $fonts        = array_filter($fonts);//remove empty elements

    $fontVariants = array(
        array( (pixflow_get_theme_mod('h1_style',PIXFLOW_H1_STYLE)== 1 ) ? pixflow_get_theme_mod('h1_weight',PIXFLOW_H1_WEIGHT).'italic': pixflow_get_theme_mod('h1_weight',PIXFLOW_H1_WEIGHT) ),
        array( (pixflow_get_theme_mod('h2_style',PIXFLOW_H2_STYLE)== 1 ) ? pixflow_get_theme_mod('h2_weight',PIXFLOW_H2_WEIGHT).'italic': pixflow_get_theme_mod('h2_weight',PIXFLOW_H2_WEIGHT) ),
        array( (pixflow_get_theme_mod('h3_style',PIXFLOW_H3_STYLE)== 1 ) ? pixflow_get_theme_mod('h3_weight',PIXFLOW_H3_WEIGHT).'italic': pixflow_get_theme_mod('h3_weight',PIXFLOW_H3_WEIGHT) ),
        array( (pixflow_get_theme_mod('h4_style',PIXFLOW_H4_STYLE)== 1 ) ? pixflow_get_theme_mod('h4_weight',PIXFLOW_H4_WEIGHT).'italic': pixflow_get_theme_mod('h4_weight',PIXFLOW_H4_WEIGHT) ),
        array( (pixflow_get_theme_mod('h5_style',PIXFLOW_H5_STYLE)== 1 ) ? pixflow_get_theme_mod('h5_weight',PIXFLOW_H5_WEIGHT).'italic': pixflow_get_theme_mod('h5_weight',PIXFLOW_H5_WEIGHT) ),
        array( (pixflow_get_theme_mod('h6_style',PIXFLOW_H6_STYLE)== 1 ) ? pixflow_get_theme_mod('h6_weight',PIXFLOW_H6_WEIGHT).'italic': pixflow_get_theme_mod('h6_weight',PIXFLOW_H6_WEIGHT) ),
        array( (pixflow_get_theme_mod('p_style',PIXFLOW_P_STYLE)== 1 )  ? pixflow_get_theme_mod('p_weight',PIXFLOW_P_WEIGHT).'italic' : pixflow_get_theme_mod('p_weight',PIXFLOW_P_WEIGHT) ),
        array( (pixflow_get_theme_mod('nav_style',PIXFLOW_NAV_STYLE)== 1 )  ? pixflow_get_theme_mod('nav_weight',PIXFLOW_NAV_WEIGHT).'italic' : pixflow_get_theme_mod('nav_weight',PIXFLOW_NAV_WEIGHT) ),
        array( (pixflow_get_theme_mod('link_style',PIXFLOW_LINK_STYLE)== 1 ) ? pixflow_get_theme_mod('link_weight',PIXFLOW_LINK_WEIGHT).'italic' : pixflow_get_theme_mod('link_weight',PIXFLOW_LINK_WEIGHT)),
        array(400,700)
    );//Suggested variants if available//Suggested variants if available

    $fontSubsets = array();
    if (pixflow_get_theme_mod('advance_char',PIXFLOW_ADVANCE_CHAR)){

        if(pixflow_get_theme_mod('cyrillic',PIXFLOW_CYRILLIC)== 1)
            $fontSubsets [] = 'cyrillic';

        if(pixflow_get_theme_mod('cyrillic_ext',PIXFLOW_CYRILLIC_EXT)== 1)
            $fontSubsets [] = 'cyrillic-ext';

        if(pixflow_get_theme_mod('latin',PIXFLOW_LATIN)== 1)
            $fontSubsets [] = 'latin';

        if(pixflow_get_theme_mod('latin_ext',PIXFLOW_LATIN_EXT)== 1)
            $fontSubsets [] = 'latin-ext';

        if(pixflow_get_theme_mod('greek',PIXFLOW_GREEK)== 1)
            $fontSubsets [] = 'greek';

        if(pixflow_get_theme_mod('greek_ext',PIXFLOW_GREEK_EXT)== 1)
            $fontSubsets [] = 'greek-ext';

        if(pixflow_get_theme_mod('vietnamese',PIXFLOW_VIETNAMESE)== 1)
            $fontSubsets [] = 'vietnamese';

    }

    $fontList     = array();
    $fontReq      = '//fonts.googleapis.com/css?family=';
    $gf           = new PixflowGoogleFonts(pixflow_path_combine(PIXFLOW_THEME_LIB_URI, 'googlefonts.json'));

    //Build font list
    foreach($fonts as $key => $font)
    {

        $duplicate = false;
        //Search for duplicate
        foreach($fontList as &$item)
        {
            if($font == $item['font'] )
            {
                $duplicate = true;
                $item['variants'] = array_unique(array_merge($item['variants'],$fontVariants[$key] ));
                break;
            }
        }

        //Add
        if(!$duplicate){
            $fontList[] = array('font' => $font, 'variants' => $fontVariants[$key]);
        }
    }

    $temp=array();
    $i=0;

    $subsets = array();

    foreach($fontList as $fontItem)
    {
        $i++;

        $font = $gf->Pixflow_GetFontByName($fontItem['font']);

        if(null==$font){
            continue;
        }

        $variants = array();

        foreach($fontItem['variants'] as $variant)
        {
            //Check if font object has the variant
            if(in_array($variant, $font->variants))
            {
                $variants[] = $variant;
            }
            else if(400 === $variant && in_array('regular', $font->variants))
            {
                $variants[] = $variant;
            }else if('400italic' === $variant && in_array('italic',$font->variants))
            {
                $variants[] = $variant ;
            }else{
                $num = substr($variant,0,3);
                if(in_array( $num , $font->variants )){
                    $variants[] = $num;
                }
            }
        }

        $subsets =$fontSubsets;


        $query = preg_replace('/ /', '+', $fontItem['font']);

        if(count($variants))
            $query .= ':' . implode(',', $variants);

        $temp[] = $query;
    }

    $subsetReq = '';
    if(count($subsets))
    {
        $subsetReq = '&subset=' . implode(',', $subsets);
    }

    if(count($temp))
    {
        $fontReq .= implode('|', $temp);

        if(strlen($subsetReq))
            $fontReq .= $subsetReq;


        wp_enqueue_style('fonts', $fontReq);
    }
}


/*====================================================
                Custom Css
======================================================*/
function pixflow_add_inline_css(){
    $customCssText = pixflow_get_theme_mod('custom_css');
    wp_add_inline_style("style",$customCssText);
}

add_action( 'wp_enqueue_scripts', 'pixflow_add_inline_css', 100 );
