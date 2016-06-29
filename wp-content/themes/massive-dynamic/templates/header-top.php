<?php
//Default header template
global $headerClass, $headerTheme, $defaults;
$headerTheme = pixflow_get_theme_mod('header_theme', PIXFLOW_HEADER_THEME);
$headerClass ='top-' . $headerTheme;
$defaults = array(
    'classic' => array(
        'logo' => array('align' => 'item-left', 'width' => 15),
        'menu' => array('align' => 'item-right', 'width' => 79.2),
        'icons' => array('align' => 'item-center', 'width' => 5.7)
    ),
    'block' => array(
        'logo' => array('align' => 'item-left', 'width' => 13),
        'menu' => array('align' => 'item-right', 'width' => 70),
        'icons' => array('align' => 'item-right', 'width' => 17)
    ),
    'gather' => array(
        'logo' => array('align' => 'item-left', 'width' => 80),
        'menu' => array('align' => 'item-right', 'width' => 5),
        'icons' => array('align' => 'item-right', 'width' => 15)
    ),
    'logotop' => array(
        'logo' => array('align' => 'item-left', 'width' => 15),
        'menu' => array('align' => 'item-left', 'width' => 5),
        'icons' => array('align' => 'item-left', 'width' => 20)
    ),
    'modern' => array(
        'logo' => array('align' => 'item-left', 'width' => 15),
        'menu' => array('align' => 'item-left', 'width' => 5),
        'icons' => array('align' => 'item-left', 'width' => 20)
    )
);
if (pixflow_get_theme_mod('header_position',PIXFLOW_HEADER_POSITION) == 'top') {
    if (pixflow_get_theme_mod('header_styles',PIXFLOW_HEADER_STYLES) == 'style1') {
        $headerClass .= " header-style1";
    } else if (pixflow_get_theme_mod('header_styles',PIXFLOW_HEADER_STYLES) == 'style2') {
        $headerClass .= " header-style2";
    } else if (pixflow_get_theme_mod('header_styles',PIXFLOW_HEADER_STYLES) == 'style3') {
        $headerClass .= " header-style3";
    }
}

$businessBarEnable = pixflow_get_theme_mod('businessBar_enable', PIXFLOW_BUSINESSBAR_ENABLE);
$headerTopWidth = pixflow_get_theme_mod('header_top_width', PIXFLOW_HEADER_TOP_WIDTH);
$headerTopHeight = pixflow_get_theme_mod('header-top-height', PIXFLOW_HEADER_TOP_HEIGHT);

$headerContentStyle = 'width:' . pixflow_get_theme_mod('header-content', PIXFLOW_HEADER_CONTENT) . '%;';

// set styles of header according to its theme
if (('gather' == $headerTheme && 'style2' == pixflow_get_theme_mod('gather_style', PIXFLOW_GATHER_STYLE))) {
    $headerTopHeight = 62;
}

if ('block' == $headerTheme) {
    if ('style1' == pixflow_get_theme_mod('block_style',PIXFLOW_BLOCK_STYLE)) {
        $headerTopHeight = 70;
    }elseif ('style2' == pixflow_get_theme_mod('block_style',PIXFLOW_BLOCK_STYLE)) {
        $headerTopHeight = 74;
    }
}

$headerStyle = 'width: ' . $headerTopWidth . '%; height:' . $headerTopHeight .'px'. ';';


if ('modern' == $headerTheme) {
    $menuStyle = ($businessBarEnable) ? 'style-style1' : 'style-style2';
    $businessBarEnable = pixflow_get_theme_mod('businessBar_enable', PIXFLOW_BUSINESSBAR_ENABLE);
    if ($businessBarEnable) {
        $headerStyle = 'width: ' . $headerTopWidth . '%; height:100px;';
    } else {
        $headerStyle = 'width: ' . $headerTopWidth . '%; height:70px;';
    }
} else if ('logotop' == $headerTheme) {
    $menuStyle = 'style-logotop';
} else if ('classic' == $headerTheme) {
    $menuStyle = pixflow_get_theme_mod($headerTheme . '_style', PIXFLOW_CLASSIC_STYLE);
    $menuStyle = 'style-' . $menuStyle;
} else if ('block' == $headerTheme){
    $menuStyle = pixflow_get_theme_mod($headerTheme . '_style', PIXFLOW_BLOCK_STYLE);
    $menuStyle = 'style-' . $menuStyle;
}else {
    $menuStyle = pixflow_get_theme_mod($headerTheme . '_style', PIXFLOW_GATHER_STYLE);
    $menuStyle = ($headerTheme != 'logotop') ? 'style-' . $menuStyle : 'style-slash';
}

function pixflow_genHeaderTopLogo($align, $width, $gatherBorderRight = true)
{
    global $headerTheme;
    $gatherBorder = '';

        $gatherBorder = '';
        $style = '';
        $itemOrderStyle = "width: " . $width . "%;";
        if('logotop' != $headerTheme && 'modern' != $headerTheme){
            $style = $itemOrderStyle;
        }

        $retString = '<a class="logo '.$gatherBorder.' '.$align.'" style="'.$style.'">';
        if(pixflow_get_theme_mod('logo_style',PIXFLOW_LOGO_STYLE)=='dark'){
            $logo=pixflow_get_theme_mod('dark_logo', PIXFLOW_DARK_LOGO);
        }else{
            $logo=pixflow_get_theme_mod('light_logo', PIXFLOW_LIGHT_LOGO);
        }
        $attachment_id = pixflow_get_image_id( $logo );
        if($attachment_id){
            $image_array = wp_get_attachment_image_src($attachment_id, 'pixflow_logo');
            $logo = (false == $image_array)?PIXFLOW_PLACEHOLDER_BLANK:$image_array[0];
        }
        $retString .= '<img data-home-url="'.esc_url(home_url('/')).'" src="' . esc_url($logo) . '"/>';
        $retString .= '</a>';
        echo($retString);
   // }
}

function pixflow_genHeaderTopMenu($align, $width, $gatherBorderRight = true){
global $headerTheme;

if ($headerTheme == 'logotop'){
?>
<div class="logo-top-container hidden-tablet hidden-phone">
    <div class="center-area">
    <?php
    }
            ob_start();
            if ($headerTheme == 'gather') {
                $gatherBorder = '';
                $itemOrderStyle = "width: " . $width . "%;";
                $style = $itemOrderStyle;
                ?>
                <div class="gather-btn navigation hidden-tablet hidden-phone" class="<?php echo esc_attr($align); ?>" style='<?php echo esc_attr($style) ?>'>
                    <span class="icon-gathermenu <?php echo esc_attr($gatherBorder) ?>"></span>
                </div>
            <?php
            } else {
                if ('modern' == $headerTheme) {
                    $style = 'height:70px';
                } else {
                    $style = '';
                    $itemOrderStyle = "width: " . $width . "%;";
                    if('logotop' != $headerTheme){
                        $style = $itemOrderStyle;
                    }
                }
                ?>

                <nav class='navigation hidden-tablet hidden-phone <?php echo esc_attr($align) ?>' style='<?php echo esc_attr($style) ?>'>
                    <?php
                    wp_nav_menu(array(
                        'container' => '',
                        'menu_class' => 'clearfix',
                        'before' => '',
                        'theme_location' => 'primary-nav',
                        'walker' => new PixflowCustomNavWalker(),
                        'fallback_cb' => false
                    ));
                    ?>
                </nav>
            <?php
        }
        $retString = ob_get_clean();
        echo($retString);
}

function pixflow_genHeaderTopIcons($align, $width){

        global $headerTheme;
        /* Icon Packs */
        $style = '';


        if ('modern' == $headerTheme) {
            $style = 'height:70px';
        }else{
            $itemOrderStyle = "width: " . $width . "%;";
            if('logotop' != $headerTheme){
                $style = $itemOrderStyle;
            }
        }

        if ( pixflow_get_theme_mod('notification_enable',PIXFLOW_NOTIFICATION_ENABLE) ) {
            ?>


            <ul class="icons-pack hidden-tablet hidden-phone <?php echo esc_attr($align); ?>"
                style="<?php echo esc_attr($style); ?>">
                <?php if ('gather' == $headerTheme && 'style2' == pixflow_get_theme_mod('gather_style', PIXFLOW_GATHER_STYLE)) { ?>
                    <li class="icon shopcart-item">
                        <a class="shopcart">
                            <span class="icon-shopcart2 default"></span>
                            <span class="icon-shopcart2 hover"></span>
                        </a>
                    </li>

                    <li class="icon notification-item">
                        <a class="notification">
                            <span class="icon-notification default"></span>
                            <span class="icon-notification hover"></span>
                        </a>
                    </li>

                    <li class="icon search-item">
                        <a class="search">
                            <span class="icon-search3 default"></span>
                            <span class="icon-search3 hover"></span>
                        </a>
                    </li>
                    <?php
                } else {
                    $hoverBtnClass = '';
                    if ('modern' == $headerTheme && pixflow_get_theme_mod('header_position', PIXFLOW_HEADER_POSITION) == 'top')
                        $hoverBtnClass = 'btn btn-1 btn-1b';
                    ?>
                    <li class="icon <?php echo esc_attr($hoverBtnClass); ?> shopcart-item">
                        <a class="elem-container shopcart" href="#">
                            <span class="menu-separator-block"></span>
                            <?php if ('block' == $headerTheme) { ?>
                                <span class="hover-content">
                            <span class="icon icon-hover icon-shopcart2"></span>
                            <span class="icon icon-hover-text"><?php esc_attr_e('Shop Cart','massive-dynamic'); ?></span>
                        </span>
                            <?php } ?>
                            <span class="title-content">
                            <span class="icon icon-shopcart2"></span>
                        </span>
                        </a>
                    </li>

                    <li class="icon <?php echo esc_attr($hoverBtnClass); ?> notification-item">
                        <a class="elem-container notification" href="#">
                            <span class="menu-separator-block"></span>
                            <?php if ('block' == $headerTheme) { ?>
                                <span class="hover-content">
                                <span class="icon icon-hover icon-notification"></span>
                                <span class="icon icon-hover-text"><?php esc_attr_e('Notification','massive-dynamic'); ?></span>
                            </span>
                            <?php } ?>
                            <span class="title-content">
                            <span class="icon icon-notification"></span>
                        </span>
                        </a>
                    </li>

                    <li class="icon <?php echo esc_attr($hoverBtnClass); ?> search-item">
                        <a class="elem-container search" href="#">
                            <span class="menu-separator-block"></span>
                            <?php if ('block' == $headerTheme) { ?>
                                <span class="hover-content">
                                <span class="icon icon-hover icon-search3"></span>
                                <span class="icon icon-hover-text"><?php esc_attr_e('Search','massive-dynamic'); ?></span>
                            </span>
                            <?php } ?>
                            <span class="title-content">
                            <span class="icon icon-search3"></span>
                        </span>
                        </a>
                    </li>
                <?php } ?>
            </ul>
            <?php
        }
    if ($headerTheme == 'logotop'){
        ?>
        <div class='clearfix'></div>
        </div>
        </div>
<?php
}
    
}



function pixflow_genHeaderTop()
{
    global $headerTheme, $defaults;
    $json = pixflow_get_theme_mod('header_items_order');

    $flag = ($headerTheme == 'modern') ? false : true;
    $items = array('logo', 'menu', 'icons');
    $itemOrderItems = $existItems = $itemsArray = array();
    $existItems = array('logo', 'menu');
    if ( pixflow_get_theme_mod('notification_enable')) {
        $existItems[] = 'icons';
    }
    if($json != ''){
        $itemsArray = json_decode($json, true);
    }

    if ($json != "" && $headerTheme != 'logotop' && $headerTheme != 'modern' && $headerTheme == $itemsArray[0]['headerTheme']) {
        $itemsArray = json_decode($json, true);
        foreach ($itemsArray as $currentItem => $item) {
            $itemOrderItems[] = $item['id'];
        }
        $result = array_diff($existItems, $itemOrderItems);
        if (count($result) > 0) {
            if ($flag) {
                pixflow_genHeaderTopLogo($defaults[$headerTheme]['logo']['align'],$defaults[$headerTheme]['logo']['width']);
            }
            pixflow_genHeaderTopMenu($defaults[$headerTheme]['menu']['align'],$defaults[$headerTheme]['menu']['width']);
            pixflow_genHeaderTopIcons($defaults[$headerTheme]['icons']['align'],$defaults[$headerTheme]['icons']['width']);
        } else {
            foreach ($itemsArray as $currentItem => $item) {
                $align = $item['align'];
                $width = $item['width'];
                $gatherBorderRight = '';

                switch ($item['id']) {
                    case 'logo':
                        if ($flag) {
                            pixflow_genHeaderTopLogo($align,$width,$gatherBorderRight);
                        }
                        break;
                    case 'menu':
                        pixflow_genHeaderTopMenu($align,$width, $gatherBorderRight);
                        break;
                    case 'icons':
                        pixflow_genHeaderTopIcons($align,$width);
                        break;
                }
            }
        }
    } elseif ($headerTheme == 'logotop' || $headerTheme == 'modern') {
        if ($flag) {
            pixflow_genHeaderTopLogo($defaults[$headerTheme]['logo']['align'],$defaults[$headerTheme]['logo']['width']);
        }
        pixflow_genHeaderTopMenu($defaults[$headerTheme]['menu']['align'],$defaults[$headerTheme]['menu']['width']);
        pixflow_genHeaderTopIcons($defaults[$headerTheme]['icons']['align'],$defaults[$headerTheme]['icons']['width']);
    } else {
        pixflow_genHeaderTopLogo($defaults[$headerTheme]['logo']['align'],$defaults[$headerTheme]['logo']['width']);
        pixflow_genHeaderTopMenu($defaults[$headerTheme]['menu']['align'],$defaults[$headerTheme]['menu']['width']);
        pixflow_genHeaderTopIcons($defaults[$headerTheme]['icons']['align'],$defaults[$headerTheme]['icons']['width']);
    }

}

function pixflow_businessBar()
{
    global $headerTheme;
    $class = '';
    $businessDefault = ($headerTheme == 'modern')?true:false;
    $businessBarEnable = pixflow_get_theme_mod('businessBar_enable', PIXFLOW_BUSINESSBAR_ENABLE);
    $class = (!$businessBarEnable)?'business-off':'';
    $headerContentStyle = 'width:' . pixflow_get_theme_mod('header_top_width', PIXFLOW_HEADER_TOP_WIDTH) . '%;';
    $businessBarSocialType = pixflow_get_theme_mod('businessBar_social', PIXFLOW_BUSINESSBAR_SOCIAL);
    $addressIcon = (pixflow_get_theme_mod('businessBar_style', PIXFLOW_BUSINESSBAR_STYLE) == 'dot') ? 'icon-record' : 'icon-location';
    $telIcon = (pixflow_get_theme_mod('businessBar_style', PIXFLOW_BUSINESSBAR_STYLE) == 'dot') ? 'icon-record' : 'icon-phone';
    $emailIcon = (pixflow_get_theme_mod('businessBar_style', PIXFLOW_BUSINESSBAR_STYLE) == 'dot') ? 'icon-record' : 'icon-Mail';
    $businessBarAddress = pixflow_get_theme_mod('businessBar_address');
    $businessBarAddress = ($businessBarAddress === null)?PIXFLOW_BUSINESSBAR_ADDRESS:$businessBarAddress;
    $businessBarTel = pixflow_get_theme_mod('businessBar_tel');
    $businessBarTel = ($businessBarTel === null)?PIXFLOW_BUSINESSBAR_TEL:$businessBarTel;
    $businessBarEmail = pixflow_get_theme_mod('businessBar_email');
    $businessBarEmail = ($businessBarEmail === null)?PIXFLOW_BUSINESSBAR_EMAIL:$businessBarEmail;
    if ('modern' == $headerTheme) {
        if ($businessBarEnable) {
            $headerContentStyle = 'width:100%; height:30%;';
        }
    }

    ?>
    <!-- Business Bar  -->
    <div class="business content visible-desktop hidden-tablet <?php echo esc_attr($class); ?>" style="<?php  echo esc_attr($headerContentStyle); ?>">
        <div class=" clearfix">
            <div class="info-container">
                <span class="item address<?php echo esc_attr($businessBarAddress == '') ? ' md-hidden' : ''; ?>">
                    <span class="icon <?php echo esc_attr($addressIcon) ?>"></span>
                    <span class="address-content"><?php echo esc_attr($businessBarAddress) ?></span>
                </span>
                <span class="item tel<?php echo esc_attr($businessBarTel == '') ? ' md-hidden' : ''; ?>">
                    <span class="icon <?php echo esc_attr($telIcon) ?>"></span>
                    <span class="tel-content"><?php echo esc_attr($businessBarTel) ?></span>
                </span>
                <span class="item email<?php echo esc_attr($businessBarEmail == '') ? ' md-hidden' : ''; ?>">
                    <span class="icon <?php echo esc_attr($emailIcon) ?>"></span>
                    <span class="email-content"><?php echo esc_attr($businessBarEmail) ?></span>
                </span>
            </div>
            <div class="social <?php echo esc_attr($businessBarSocialType) ?>">
                <?php
                $socials = pixflow_get_active_socials();
                if ($socials) {
                    foreach ($socials as $social) {
                        $title = $social['title'];
                        $icon = $social['icon'];
                        $link = $social['link'];
                        ?>
                        <span data-social="<?php echo esc_attr($title) ?>"><a href="<?php echo esc_url($link) ?>"><?php echo esc_attr($businessBarSocialType == 'icon') ? '<span class="' . $icon . '"></span>' : $title; ?></a></span>
                    <?php }
                } ?>
            </div>
        </div>
    </div>
<?php
}

?>


<?php
//call business bar before header for all header themes except modern style
if ( $headerTheme != 'modern') {
    pixflow_businessBar();
}

$headerClass .= ' top header-'.pixflow_get_theme_mod('header_responsive_skin',PIXFLOW_HEADER_RESPONSIVE_SKIN).' logo-'.pixflow_get_theme_mod('logo_responsive_skin',PIXFLOW_LOGO_RESPONSIVE_SKIN);
?>
<!-- header -->
<header style="<?php echo esc_attr($headerStyle); ?>" class="<?php echo esc_attr($headerClass);?>" data-width="<?php echo esc_attr($headerTopWidth); ?>">
    <div class="color-overlay"></div>
    <div class="texture-overlay"></div>
    <div class="bg-image"></div>

    <div class="content top <?php echo esc_attr($menuStyle); ?>" style="<?php if ('logotop' == $headerTheme) echo 'width:100%'; else echo esc_attr($headerContentStyle); ?>">
        <?php if ($headerTheme == 'modern') { ?>
            <div class="first-part">
                <?php pixflow_genHeaderTopLogo($defaults[$headerTheme]['logo']['align'],$defaults[$headerTheme]['logo']['width']); ?>
            </div>
            <div class="second-part hidden-tablet hidden-tablet">
                <?php

                pixflow_businessBar();
                pixflow_genHeaderTop(); ?>
            </div>
        <?php
        } else
            pixflow_genHeaderTop();
        ?>

        <?php if(( is_single() && pixflow_get_theme_mod('sidebar-switch-single',PIXFLOW_SIDEBAR_SWITCH_SINGLE)) ||
            (((is_front_page() && is_home()) ||  is_home() ) && pixflow_get_theme_mod('sidebar-switch-blog',PIXFLOW_SIDEBAR_SWITCH_BLOG))||
            (is_page() && pixflow_get_theme_mod('sidebar-switch',PIXFLOW_SIDEBAR_SWITCH))||
            ((in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' )))) && is_woocommerce()&& pixflow_get_theme_mod('sidebar-switch-shop',PIXFLOW_SIDEBAR_SWITCH_SHOP)) ){
            ?>
            <a class="mobile-sidebar hidden-desktop visible-tablet"><i class="icon-plus5"></i></a>
            <?php
        }?>

        <a class="navigation-button hidden-desktop visible-tablet" href="#">
            <span class="icon-gathermenu"></span>
        </a>

        <?php if((in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ))){
              global $woocommerce;
            $cart_url = $woocommerce->cart->get_cart_url(); ?>
            <a class="mobile-shopcart hidden-desktop visible-tablet" href="<?php echo esc_url($cart_url); ?>"><span class="icon-shopcart"></span></a>
        <?php } ?>
    </div>

</header>
<?php
//Because it pushes the entire content down, we should put mobile menu here
get_template_part( 'templates/navigation-mobile' );
