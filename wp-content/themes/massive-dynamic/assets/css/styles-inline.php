<?php
$absolute_path = explode('wp-content', $_SERVER['SCRIPT_FILENAME']);
$wp_load = $absolute_path[0] . 'wp-load.php';
require_once($wp_load);
$_SESSION['pixflow_post_id'] = (isset($_GET['post_id']))?$_GET['post_id']:null;

//sidebar values
$sidebarSwitch = $sidebarBgType = '';
$sidebarWidth = 0;


//header value
$header = pixflow_get_theme_mod('header_position',PIXFLOW_HEADER_POSITION);
//navigation values
$navColor = pixflow_get_theme_mod('nav_color',PIXFLOW_NAV_COLOR);
$navHoverColor = pixflow_get_theme_mod('nav_hover_color',PIXFLOW_NAV_HOVER_COLOR);

$sidebarType = !isset($_GET['id']) || $_GET['id']==''?'blog':$_GET['id'];

$sidebarType = ('product' == $sidebarType)?'shop':$sidebarType;

if($sidebarType == 'single' || $sidebarType == 'blog' || $sidebarType == 'shop'){
    $sidebarSwitch           = pixflow_get_theme_mod('sidebar-switch-'.$sidebarType,constant(strtoupper('PIXFLOW_SIDEBAR_SWITCH_'.$sidebarType)));
    $sidebarWidth            = pixflow_get_theme_mod('sidebar-width-'.$sidebarType,constant(strtoupper('PIXFLOW_SIDEBAR_WIDTH_'.$sidebarType)));
    $sidebarStyle            = pixflow_get_theme_mod('sidebar-style-'.$sidebarType,constant(strtoupper('PIXFLOW_SIDEBAR_STYLE_'.$sidebarType)));
    $sidebarShadow           = pixflow_get_theme_mod('sidebar-shadow-color-'.$sidebarType,constant(strtoupper('PIXFLOW_'.$sidebarType.'_SIDEBAR_SHADOW_COLOR')));
   
}else if( $_GET['id'] == 'page' ){
    $sidebarSwitch           = pixflow_get_theme_mod('sidebar-switch',PIXFLOW_SIDEBAR_SWITCH);
    $sidebarWidth            = pixflow_get_theme_mod('sidebar-width',PIXFLOW_SIDEBAR_WIDTH);
    $sidebarStyle            = pixflow_get_theme_mod('sidebar-style',PIXFLOW_SIDEBAR_STYLE);
    $sidebarShadow           = pixflow_get_theme_mod('sidebar-shadow-color',PIXFLOW_PAGE_SIDEBAR_SHADOW_COLOR);
}


if($sidebarType == 'single'){
    $sidebarShadow           = pixflow_get_theme_mod('sidebar-shadow-color-single',PIXFLOW_SINGLE_SIDEBAR_SHADOW_COLOR);
}




/**
Do stuff like connect to WP database and grab user set values
 */

header('Content-type: text/css');
header('Cache-control: must-revalidate');

?>
/*====================================================
                    Heading
======================================================*/
h1 {
    color: <?php echo esc_attr(pixflow_get_theme_mod('h1_color', PIXFLOW_H1_COLOR)); ?>;
    font-family: <?php echo esc_attr(pixflow_get_theme_mod('h1_name', PIXFLOW_H1_NAME)); ?>;
    font-weight: <?php echo esc_attr(pixflow_get_theme_mod('h1_weight', PIXFLOW_H1_WEIGHT)); ?>;
    font-style: <?php echo esc_attr(pixflow_get_theme_mod('h1_style', PIXFLOW_H1_STYLE)); ?>;
    font-size: <?php echo esc_attr(pixflow_get_theme_mod('h1_size', PIXFLOW_H1_SIZE)) . 'px' ?>;
    line-height: <?php echo esc_attr(pixflow_get_theme_mod('h1_lineHeight', PIXFLOW_H1_LINEHEIGHT)) . 'px'; ?>;
    letter-spacing: <?php echo esc_attr(pixflow_get_theme_mod('h1_letterSpace', PIXFLOW_H1_LETTERSPACE)) . 'px'; ?>;
}

h2 {
    color: <?php echo esc_attr(pixflow_get_theme_mod('h2_color', PIXFLOW_H2_COLOR)); ?>;
    font-family: <?php echo esc_attr(pixflow_get_theme_mod('h2_name', PIXFLOW_H2_NAME)); ?>;
    font-weight: <?php echo esc_attr(pixflow_get_theme_mod('h2_weight', PIXFLOW_H2_WEIGHT)); ?>;
    font-style: <?php echo esc_attr(pixflow_get_theme_mod('h2_style', PIXFLOW_H2_STYLE)); ?>;
    font-size: <?php echo esc_attr(pixflow_get_theme_mod('h2_size', PIXFLOW_H2_SIZE)) . 'px' ?>;
    line-height: <?php echo esc_attr(pixflow_get_theme_mod('h2_lineHeight', PIXFLOW_H2_LINEHEIGHT)) . 'px'; ?>;
    letter-spacing: <?php echo esc_attr(pixflow_get_theme_mod('h2_letterSpace', PIXFLOW_H2_LETTERSPACE)) . 'px'; ?>;
}

h3,
h3.wpb_accordion_header,
h3.wpb_toggle_header{
    color: <?php echo esc_attr(pixflow_get_theme_mod('h3_color', PIXFLOW_H3_COLOR)); ?>;
    font-family: <?php echo esc_attr(pixflow_get_theme_mod('h3_name', PIXFLOW_H3_NAME)); ?>;
    font-weight: <?php echo esc_attr(pixflow_get_theme_mod('h3_weight', PIXFLOW_H3_WEIGHT)); ?>;
    font-style: <?php echo esc_attr(pixflow_get_theme_mod('h3_style', PIXFLOW_H3_STYLE)); ?>;
    font-size: <?php echo esc_attr(pixflow_get_theme_mod('h3_size', PIXFLOW_H3_SIZE)) . 'px' ?>;
    line-height: <?php echo esc_attr(pixflow_get_theme_mod('h3_lineHeight', PIXFLOW_H3_LINEHEIGHT)) . 'px'; ?>;
    letter-spacing: <?php echo esc_attr(pixflow_get_theme_mod('h3_letterSpace', PIXFLOW_H3_LETTERSPACE)) . 'px'; ?>;
}

h4 {
    color: <?php echo esc_attr(pixflow_get_theme_mod('h4_color', PIXFLOW_H4_COLOR)); ?>;
    font-family: <?php echo esc_attr(pixflow_get_theme_mod('h4_name', PIXFLOW_H4_NAME)); ?>;
    font-weight: <?php echo esc_attr(pixflow_get_theme_mod('h4_weight', PIXFLOW_H4_WEIGHT)); ?>;
    font-style: <?php echo esc_attr(pixflow_get_theme_mod('h4_style', PIXFLOW_H4_STYLE)); ?>;
    font-size: <?php echo esc_attr(pixflow_get_theme_mod('h4_size', PIXFLOW_H4_SIZE)) . 'px' ?>;
    line-height: <?php echo esc_attr(pixflow_get_theme_mod('h4_lineHeight', PIXFLOW_H4_LINEHEIGHT)) . 'px'; ?>;
    letter-spacing: <?php echo esc_attr(pixflow_get_theme_mod('h4_letterSpace', PIXFLOW_H4_LETTERSPACE)) . 'px'; ?>;
}

h5 {
    color: <?php echo esc_attr(pixflow_get_theme_mod('h5_color', PIXFLOW_H5_COLOR)); ?>;
    font-family: <?php echo esc_attr(pixflow_get_theme_mod('h5_name', PIXFLOW_H5_NAME)); ?>;
    font-weight: <?php echo esc_attr(pixflow_get_theme_mod('h5_weight', PIXFLOW_H5_WEIGHT)); ?>;
    font-style: <?php echo esc_attr(pixflow_get_theme_mod('h5_style', PIXFLOW_H5_STYLE)); ?>;
    font-size: <?php echo esc_attr(pixflow_get_theme_mod('h5_size', PIXFLOW_H5_SIZE)) . 'px' ?>;
    line-height: <?php echo esc_attr(pixflow_get_theme_mod('h5_lineHeight', PIXFLOW_H5_LINEHEIGHT)) . 'px'; ?>;
    letter-spacing: <?php echo esc_attr(pixflow_get_theme_mod('h5_letterSpace', PIXFLOW_H5_LETTERSPACE)) . 'px'; ?>;
}

h6 {
    color: <?php echo esc_attr(pixflow_get_theme_mod('h6_color', PIXFLOW_H6_COLOR)); ?>;
    font-family: <?php echo esc_attr(pixflow_get_theme_mod('h6_name', PIXFLOW_H6_NAME)); ?>;
    font-weight: <?php echo esc_attr(pixflow_get_theme_mod('h6_weight', PIXFLOW_H6_WEIGHT)); ?>;
    font-style: <?php echo esc_attr(pixflow_get_theme_mod('h6_style', PIXFLOW_H6_STYLE)); ?>;
    font-size: <?php echo esc_attr(pixflow_get_theme_mod('h6_size', PIXFLOW_H6_SIZE)) . 'px' ?>;
    line-height: <?php echo esc_attr(pixflow_get_theme_mod('h6_lineHeight', PIXFLOW_H6_LINEHEIGHT)) . 'px'; ?>;
    letter-spacing: <?php echo esc_attr(pixflow_get_theme_mod('h6_letterSpace', PIXFLOW_H6_LETTERSPACE)) . 'px'; ?>;
}

p {
    color: <?php echo esc_attr(pixflow_get_theme_mod('p_color', PIXFLOW_P_COLOR)); ?>;
    font-family: <?php echo esc_attr(pixflow_get_theme_mod('p_name', PIXFLOW_P_NAME)); ?>;
    font-weight: <?php echo esc_attr(pixflow_get_theme_mod('p_weight', PIXFLOW_P_WEIGHT)); ?>;
    font-style: <?php echo esc_attr(pixflow_get_theme_mod('p_style', PIXFLOW_P_STYLE)); ?>;
    font-size: <?php echo esc_attr(pixflow_get_theme_mod('p_size', PIXFLOW_P_SIZE)) . 'px' ?>;
    line-height: <?php echo esc_attr(pixflow_get_theme_mod('p_lineHeight', PIXFLOW_P_LINEHEIGHT)) . 'px'; ?>;
    letter-spacing: <?php echo esc_attr(pixflow_get_theme_mod('p_letterSpace', PIXFLOW_P_LETTERSPACE)) . 'px'; ?>;
}


a{
color: <?php echo esc_attr(pixflow_get_theme_mod('link_color', PIXFLOW_LINK_COLOR)); ?>;
font-family: <?php echo esc_attr(pixflow_get_theme_mod('link_name', PIXFLOW_LINK_NAME)); ?>;
font-weight: <?php echo esc_attr(pixflow_get_theme_mod('link_weight', PIXFLOW_LINK_WEIGHT)); ?>;
font-style: <?php echo esc_attr(pixflow_get_theme_mod('link_style', PIXFLOW_LINK_STYLE)); ?>;
font-size: <?php echo esc_attr(pixflow_get_theme_mod('link_size', PIXFLOW_LINK_SIZE)) . 'px' ?>;
line-height: <?php echo esc_attr(pixflow_get_theme_mod('link_lineHeight', PIXFLOW_LINK_LINEHEIGHT)) . 'px'; ?>;
letter-spacing: <?php echo esc_attr(pixflow_get_theme_mod('link_letterSpace', PIXFLOW_LINK_LETTERSPACE)) . 'px'; ?>;
}
/*====================================================
                    Layout
======================================================*/
.layout{
    padding-top: <?php echo esc_attr(pixflow_get_theme_mod('site_top',PIXFLOW_SITE_TOP)) . 'px'; ?>;
    padding-bottom: <?php echo  esc_attr(pixflow_get_theme_mod('footer-marginB',PIXFLOW_FOOTER_MARGINB)) . 'px;'; ?>;
}

main{
    padding-top: <?php echo esc_attr(pixflow_get_theme_mod('main-top', PIXFLOW_MAIN_TOP)) . 'px'; ?>;
}


/*====================================================
                    Header
======================================================*/


<?php if(! pixflow_get_theme_mod('notification_enable',PIXFLOW_NOTIFICATION_ENABLE)){ ?>
    header .content ul.icons-pack li.icon ,
    header.top-block .style-style2 .icons-pack .icon.notification-item{display:none;}

<?php }else{
    if( (! pixflow_get_theme_mod('shop_cart_enable',PIXFLOW_SHOP_CART_ENABLE) || ! pixflow_get_theme_mod('notification_cart',PIXFLOW_NOTIFICATION_CART))){?>
        header ul.icons-pack li.shopcart-item,
        header.top-block .style-style2 .icons-pack li.icon.shopcart-item {display:none !important;}

    <?php }

    $notifyPosts = pixflow_get_theme_mod('notification_post',PIXFLOW_NOTIFICATION_POST);
    $notifyPortfolio = pixflow_get_theme_mod('notification_portfolio',PIXFLOW_NOTIFICATION_PORTFOLIO);
    $notifyIcon = pixflow_get_theme_mod('active_icon',PIXFLOW_ACTIVE_ICON);
    if( (!$notifyPosts && !$notifyPortfolio) ){?>
        header ul.icons-pack li.notification-item,
        header.top-block .style-style2 .icons-pack .icon.notification-item{display:none !important;}
    <?php } else if(!$notifyIcon){ ?>
        header ul.icons-pack li.notification-item ,
        header.top-block .style-style2 .icons-pack .icon.notification-item{display:none !important;}
    <?php } ?>

    <?php if( (! pixflow_get_theme_mod('search_enable',PIXFLOW_SEARCH_ENABLE) || ! pixflow_get_theme_mod('notification_search',PIXFLOW_SEARCH_ENABLE))){?>
        header ul.icons-pack li.search-item,
        header.top-block .style-style2 .icons-pack .icon.search-item{display:none !important;}
    <?php }
    }
    ?>


/*================= General Styles ================ */
<?php
$headerPosition = ($header == 'left' || $header == 'right')?'side':'top';
$headerSideTheme = pixflow_get_theme_mod('header_side_theme', PIXFLOW_HEADER_SIDE_THEME);
$headerTopTheme = pixflow_get_theme_mod('header_theme', PIXFLOW_HEADER_THEME);
$headerTopBlockSkin = pixflow_get_theme_mod('block_style', PIXFLOW_BLOCK_STYLE);

$businessEnable = pixflow_get_theme_mod('businessBar_enable', PIXFLOW_BUSINESSBAR_ENABLE);
$headerTopPos = pixflow_get_theme_mod('header_top_position', PIXFLOW_HEADER_TOP_POSITION);


if ( $headerPosition == 'top' && !$businessEnable ) { ?>
    header {
        top: <?php echo esc_attr($headerTopPos); ?>px;
    }
<?php } else if ( $headerPosition == 'top' && $businessEnable && $headerTopPos > 36 ) { ?>
    header {
        top: <?php echo esc_attr($headerTopPos); ?>px;
    }
<?php } else if ( $headerPosition == 'top' && $businessEnable && $headerPosition < 36 ) {
        if ($headerTopTheme == 'modern'){ ?>
            header {
                top: <?php echo esc_attr($headerTopPos); ?>px;
            }
        <?php }else{ ?>
            header {
                top: 36px;
            }
        <?php  } ?>

<?php }
$menu_item_styleDefault = ($headerPosition == 'top' && $headerTopTheme == 'block')?'icon-text':'text';
$menu_item_style = pixflow_get_theme_mod('menu_item_style', $menu_item_styleDefault);
if ( $menu_item_style == 'icon' || ($headerPosition == 'side' && $headerSideTheme == 'modern') || ($headerPosition == 'top' && $headerTopTheme == 'block' && $headerTopBlockSkin == 'style2')) { ?>
    header:not(.top-block) .top nav > ul > li .menu-title .icon ,
    header:not(.top-block) .top nav > ul > li .hover-effect .icon {display:inline-block;}

    header.side-classic .side nav > ul > li > a .menu-title .icon{display:block}

    header:not(.top-block) .top nav > ul > li .menu-title .title,
    header.side-classic .side nav > ul > li > a .menu-title .title,
    header:not(.top-block) .top nav > ul > li .hover-effect .title {display:none;}

<?php } else if ( $menu_item_style == 'text' ) { ?>
    header:not(.top-block) .top nav > ul > li .menu-title .icon ,
    header.side-classic .side nav > ul > li > a .menu-title .icon,
    header:not(.top-block) .top nav > ul > li .hover-effect .icon {display:none;}
    header:not(.top-block) .top nav > ul > li .hover-effect .icon {display:none;}

    header:not(.top-block) .top nav > ul > li .menu-title .title,
    header.side-classic .side nav > ul > li > a .menu-title .title,
    header:not(.top-block) .top nav > ul > li .hover-effect .title {display:inline-block;}
<?php } else{?>
    header:not(.top-block) .top nav > ul > li .menu-title .icon ,
    header:not(.top-block) .top nav > ul > li .hover-effect .icon ,
    header:not(.top-block) .top nav > ul > li .menu-title .title,
    header.side-classic .side nav > ul > li > a .menu-title .title,
    header:not(.top-block) .top nav > ul > li .hover-effect .title {display:inline-block;}
    header.side-classic .side nav > ul > li > a .menu-title .icon{display:inline-block}
    header.side-classic .style-center nav > ul > li > a .menu-title .icon{display:block}
<?php } ?>


.activeMenu{
    color: <?php echo esc_attr($navHoverColor); ?> !important;
}

header a,
header .navigation a,
header .navigation,
.gather-overlay .menu a,
header.side-classic div.footer .footer-content .copyright p{
    color: <?php echo esc_attr($navColor); ?>;
    font-family: <?php echo esc_attr(pixflow_get_theme_mod('nav_name', PIXFLOW_NAV_NAME)); ?>;
    font-weight: <?php echo esc_attr(pixflow_get_theme_mod('nav_weight', PIXFLOW_NAV_WEIGHT)); ?>;
    font-style: <?php echo esc_attr((pixflow_get_theme_mod('nav_style', PIXFLOW_NAV_STYLE)==true)?'italic':'normal'); ?>;
    font-size: <?php echo esc_attr(pixflow_get_theme_mod('nav_size', PIXFLOW_NAV_SIZE)) . 'px' ?>;
    letter-spacing: <?php echo esc_attr(pixflow_get_theme_mod('nav_letterSpace', PIXFLOW_NAV_LETTERSPACE)) . 'px'; ?>;
    line-height : 1.5em;
}

header .icons-pack a{
    color:<?php echo esc_attr($navColor); ?>;
}

header .navigation .separator a {
    background-color:<?php echo esc_attr(pixflow_colorConvertor($navColor,'rgba',.5)); ?>;
}

/* Menu icons pack color */
header .icons-pack .elem-container .title-content{
    color: <?php echo esc_attr($navColor); ?>;
}

.top-classic .navigation .menu-separator,
.top-logotop .navigation .menu-separator{
    background-color: <?php echo esc_attr($navHoverColor); ?>;
}
.top-classic:not(.header-clone) .style-wireframe .navigation .menu-separator{
    background-color: <?php echo esc_attr($navColor); ?>;
}
header.top-block .icons-pack li .elem-container,
header .top .icons-pack .icon span,
header.top-block .icons-pack li .title-content .icon,
header.top-modern .icons-pack li .title-content .icon,
header .icons-pack a{
    font-size: <?php echo esc_attr(pixflow_get_theme_mod('nav_icon_size', PIXFLOW_NAV_ICON_SIZE)) . 'px' ?>;
}

.gather-btn .icon-gathermenu {
    font-size: <?php echo esc_attr(pixflow_get_theme_mod('nav_icon_size', PIXFLOW_NAV_ICON_SIZE)) + 8 . 'px' ?>;
}

header .icons-pack .shopcart-item .number{
    color: <?php echo esc_attr($navColor); ?>;
    background-color: <?php echo esc_attr($navHoverColor); ?>;
}

header .icons-pack a.shopcart .icon-shopcart2{
    font-size: <?php echo esc_attr(pixflow_get_theme_mod('nav_icon_size', PIXFLOW_NAV_ICON_SIZE)) + 3  . 'px' ?>;
}

<?php if( pixflow_get_theme_mod('businessBar_enable',PIXFLOW_BUSINESSBAR_ENABLE) == 1) { ?>
    <!--.business{display:block}-->
<?php } else { ?>
    .business{display:none}
<?php } ?>

/*================= Header Top - Classic ================ */

<?php if (pixflow_get_theme_mod('header_theme',PIXFLOW_HEADER_THEME) == 'classic' && pixflow_get_theme_mod('classic_style',PIXFLOW_CLASSIC_STYLE) == 'border') { ?>
    header.top-classic .style-border nav  > ul > li,
    header.top-classic .style-border nav > ul > li:last-child {
        border-color: <?php echo esc_attr(pixflow_colorConvertor($navColor,'rgba',.5)); ?>;
        border-right: 1px solid <?php echo esc_attr(pixflow_colorConvertor($navColor,'rgba',.5));?>;
    }
    header.top-classic .style-border nav > ul > li:first-child {
        border-left: 1px solid <?php echo esc_attr(pixflow_colorConvertor($navColor,'rgba',.5)); ?>;
    }
<?php } if ($header == 'top' && pixflow_get_theme_mod('header_theme',PIXFLOW_HEADER_THEME) == 'classic') {
    ?>
    header.top-classic:not(.header-clone) .content:not(.style-wireframe) nav > ul > li:hover > a .menu-title  span,
    header.top-classic:not(.header-clone) .content:not(.style-wireframe) nav > ul > li:hover > a .menu-title:after{
        color: <?php echo esc_attr($navHoverColor); ?>;
    }
    .top-classic .style-wireframe .navigation  > ul > li:hover .menu-separator{
        background-color: <?php echo esc_attr($navHoverColor); ?>;
    }

    header.top-classic .icons-pack .icon:hover {
        color: <?php echo esc_attr($navHoverColor); ?>;
    }

<?php } ?>

/*================= Header Top - Block ================ */
<?php if ($header == 'top' && pixflow_get_theme_mod('header_theme',PIXFLOW_HEADER_THEME) == 'block') { ?>

        header.top-block .style-style2 nav > ul > li:hover > a,
        header.top-block .style-style2 .icons-pack li:hover a{
            color: <?php echo esc_attr(pixflow_get_theme_mod('nav_color', PIXFLOW_NAV_COLOR)); ?>;
        }

        header.top-block .style-style2 nav > ul > li:hover,
        header.top-block .style-style2 .icons-pack  li:hover ,
        header.top-block .style-style2 nav > ul > li a .hover-effect:after,
        header.top-block .style-style2 .icons-pack li .elem-container .hover-content:after{
            background-color:<?php echo esc_attr(pixflow_colorConvertor($navColor,'rgba',.15)); ?>,;
        }

        header.top-block .style-style2 nav > ul > li,
        header.top-block .style-style2 nav > ul > li > a,
        header.top-block .style-style2 .icons-pack li,
        header.top-block .style-style2 .icons-pack li a{
            line-height : 74px;
            height : 74px;
        }

        header.top-block .style-style2 .menu-separator-block{
            background-color: <?php echo esc_attr($navHoverColor); ?>;
        }

    <?php
    if( pixflow_get_theme_mod('block_style',PIXFLOW_BLOCK_STYLE) == 'style1' ) {
        $headerBg = pixflow_get_theme_mod('header_bg_solid_color', PIXFLOW_HEADER_BG_SOLID_COLOR);
        ?>
        header.top-block  .color-overlay{
        background: <?php echo esc_attr(pixflow_colorConvertor($headerBg,'rgb')); ?>;
        }

        header.top-block nav > ul > li > a .menu-title,
        header.top-block .style-style1 .icons-pack li a .title-content{
        color: <?php echo esc_attr($navColor); ?>;
        }

        header.top-block .style-style1 nav > ul > li > a .hover-effect,
        header.top-block .style-style1 nav > ul > li > a .menu-title,
        header.top-block .style-style1 .icons-pack .title-content{
        background:<?php echo esc_attr(pixflow_colorConvertor($headerBg,'rgb')); ?>;
        }

        header.top-block .style-style1 nav  > ul > li:hover > a .menu-title,
        header.top-block .style-style1 .icons-pack li:hover a .title-content{
        background-color:<?php echo esc_attr($navHoverColor); ?>;
        color:<?php echo esc_attr($navHoverColor); ?>;
        }

        header.top-block .style-style1 nav > ul > li > a .hover-effect,
        header.top-block .style-style1 ul.icons-pack  li .elem-container .hover-content{
        background-color: <?php echo esc_attr($navHoverColor); ?>;
        }

    <?php
    }
?>

/* block menu border color */
header.top-block .style-style2 nav > ul > li,
header.top-block .style-style1 nav  > ul > li:last-child,
header.top-block .style-style2 .icons-pack li,
header.top-block .style-style1 .icons-pack li{
    border-right-color: <?php echo esc_attr(pixflow_colorConvertor($navColor,'rgba',.3)); ?>;
}

header.top-block .style-style2 nav > ul > li:first-child,
header.top-block .style-style1 .icons-pack li:first-child,
header.top-block .style-style1 nav > ul > li,
header.top-block .style-style2 .icons-pack li:first-child{
    border-left: 1px solid <?php echo esc_attr(pixflow_colorConvertor($navColor,'rgba', .3)); ?>;
    position: relative;
}

<?php } ?>

/*================= Header Top - Gather ================ */

<?php if ($header == 'top' && pixflow_get_theme_mod('header_theme',PIXFLOW_HEADER_THEME) == 'gather') { ?>

    header.top-gather .style-style2 .icons-pack li{
        border-right:1px solid <?php echo esc_attr(pixflow_colorConvertor($navColor,'rgba',.5)); ?>;
    }

    header.top-gather .style-style2 .icons-pack li:first-child{
        border-left:1px solid <?php echo esc_attr(pixflow_colorConvertor($navColor,'rgba',.5)); ?>;
    }

    header.top-gather .style-style2 .border-right,
    header.top-gather .style-style2 .border-left{
        border-color: <?php echo esc_attr(pixflow_colorConvertor($navColor,'rgba',.5)); ?>;
    }

    .gather-overlay{
        background-color : <?php echo esc_attr(pixflow_get_theme_mod('overlay_bg', PIXFLOW_OVERLAY_BG)); ?>
    }

    .gather-overlay .menu nav > ul > li{
        border-color: <?php echo esc_attr(pixflow_colorConvertor(pixflow_get_theme_mod('popup_menu_color',PIXFLOW_POPUP_MENU_COLOR),'rgba',.3));  ?> ;
    }

    .gather-overlay nav > ul > li:after,
    .gather-overlay nav > ul > li a,
    .gather-overlay .menu a,
    .gather-overlay .gather-btn > span{
        color: <?php echo esc_attr(pixflow_get_theme_mod('popup_menu_color', PIXFLOW_POPUP_MENU_COLOR)); ?>;
    }

    .gather-overlay .menu nav > ul > li:hover > a,
    .gather-overlay .gather-btn > span:hover{
        color: <?php echo esc_attr(pixflow_colorConvertor(pixflow_get_theme_mod('popup_menu_color', PIXFLOW_POPUP_MENU_COLOR),'rgba',.7)); ?>;
    }

    .top-gather .icons-pack li.icon:hover .title-content,
    .top-gather .gather-btn > span:hover{
        color: <?php echo esc_attr($navHoverColor); ?> ;
    }

    .top-gather .icons-pack .icon .hover{
        color: <?php echo esc_attr($navHoverColor); ?> ;
    }


<?php
} ?>

/*================= Header Top - LogoTop ================ */

<?php if ($header == 'top' && pixflow_get_theme_mod('header_theme',PIXFLOW_HEADER_THEME) == 'logotop') {

    $businessHeight = (pixflow_get_theme_mod('businessBar_enable', PIXFLOW_BUSINESSBAR_ENABLE) == '1') ? 36 : 0; ?>

    header.top-logotop .logo-top-container {
        margin-top: <?php echo (pixflow_get_theme_mod('logotop_logoSpace', PIXFLOW_LOGOTOP_LOGOSPACE)) . 'px'; ?>
    }

    header.top-logotop .icons-pack li a{
        color:<?php echo esc_attr(pixflow_colorConvertor($navColor,'rgba',.7));  ?>;
    }

    header.top-logotop .icons-pack .icon:hover {
        color: <?php echo esc_attr($navHoverColor);?>;
    }

    header.top-logotop nav > ul > li > a:hover{
        color: <?php echo esc_attr($navHoverColor);?>;
    }

    header.top-logotop nav > ul > li > a:after {
        background-color: <?php echo esc_attr($navHoverColor);?>;
    }

    header.top-logotop nav > ul > li .active{
        color:<?php echo esc_attr($navHoverColor); ?>;
    }

    <?php
    if(! pixflow_get_theme_mod('businessBar_enable', PIXFLOW_BUSINESSBAR_ENABLE)) {
        ?>
        .business.content{margin:auto;}

    <?php
    } ?>

    <?php

} ?>


/*================= Header Top - Modern ================ */
    header.top-modern .btn-1b:after {
        background: <?php echo esc_attr($navColor); ?>;
    }

    header.top-modern .btn-1b:active{
        background: <?php echo esc_attr($navColor); ?>;
    }


    header.top-modern nav > ul> li,
    header.top-modern .icons-pack li,
    header.top-modern .first-part{
        border-right: 1px solid <?php echo esc_attr(pixflow_colorConvertor($navColor,'rgba',.3));  ?>;
    }
    header.top-modern .business{
        border-bottom: 1px solid <?php echo esc_attr(pixflow_colorConvertor($navColor,'rgba',.3)); ?>;
    }

    header.top-modern .business,
    header.top-modern .business a{
        color: <?php echo esc_attr($navColor); ?>;
    }



/*================= Header Side - Classic ================ */

<?php if (($header == 'left' || $header == 'right') && pixflow_get_theme_mod('header_side_theme',PIXFLOW_HEADER_SIDE_THEME) == 'classic') { ?>
    header.side-classic nav > ul > li > a span.menu-separator{
        border-color: <?php echo esc_attr($navHoverColor); ?>;
    }

    header.side-classic .icons-holder{
        border-color: <?php echo esc_attr(pixflow_colorConvertor($navColor,'rgba',.3)); ?> ;
    }

    header.side-classic div.footer ul li.info .footer-content span{
        color: <?php echo esc_attr($navColor); ?>;
        font-family: <?php echo esc_attr(pixflow_get_theme_mod('nav_name', PIXFLOW_NAV_NAME)); ?>;
        font-weight: <?php echo esc_attr(pixflow_get_theme_mod('nav_weight', PIXFLOW_NAV_WEIGHT)); ?>;
        font-style: <?php echo esc_attr((pixflow_get_theme_mod('nav_style', PIXFLOW_NAV_STYLE)==true)?'italic':'normal'); ?>;
        font-size: 13px;
        letter-spacing: <?php echo esc_attr(pixflow_get_theme_mod('nav_letterSpace', PIXFLOW_NAV_LETTERSPACE)) . 'px'; ?>;
    }

<?php } ?>
/* Header Side Background Image */
<?php if( $headerPosition == 'side' && $headerSideTheme != 'modern'){ ?>
header.side-classic > .bg-image {
<?php if( pixflow_get_theme_mod('header_side_image_image','') != '' ){ ?>
    background-image: url(<?php echo esc_url(pixflow_get_theme_mod('header_side_image_image')); ?>);
<?php } ?>
    background-repeat: <?php echo esc_attr(pixflow_get_theme_mod('header_side_image_repeat', PIXFLOW_HEADER_SIDE_IMAGE_REPEAT)); ?>;
    background-size: <?php echo esc_attr(pixflow_get_theme_mod('header_side_image_size', PIXFLOW_HEADER_SIDE_IMAGE_SIZE)); ?>;
    background-position: <?php echo esc_attr(str_replace('-', ' ', pixflow_get_theme_mod('header_side_image_position', PIXFLOW_HEADER_SIDE_IMAGE_POSITION))); ?>
}
<?php } ?>

/* Side menu color */
header.side-classic nav > ul > li:hover > a,
header.side-classic.standard-mode .icons-holder ul.icons-pack li:hover a,
header.side-classic.standard-mode .footer-socials li:hover a,
header.side-classic nav > ul > li.has-dropdown:not(.megamenu):hover > a,
header.side-classic nav > ul > li:hover > a > .menu-title span,
header.side-classic .footer-socials li a .hover,
header.side-classic .icons-pack li a .hover,
header.side-modern .icons-pack li a span.hover,
header.side-modern .nav-modern-button span.hover,
header.side-modern .footer-socials span.hover,
header.side-classic nav > ul > li.has-dropdown:not(.megamenu) .dropdown a:hover .menu-title span,
header.side-classic nav > ul > li > ul li.has-dropdown:not(.megamenu):hover > a .menu-title span{
    color: <?php echo esc_attr($navHoverColor); ?>;
    border-color: <?php echo esc_attr($navHoverColor); ?>;
}

header.side-classic div.footer ul li.info .footer-content span,
header.side-classic .icons-pack li.search .search-form input{
    color: <?php echo esc_attr($navColor); ?>;
}

header.side-classic div.footer ul,
header.side-classic div.footer ul li,
header.side-classic .icons-holder{
    border-color: <?php echo esc_attr($navColor); ?>;
}

header.side-classic .icons-holder li hr{
    background-color: <?php echo esc_attr($navColor); ?>;
}
header .side .footer .copyright p{
    color: <?php echo esc_attr($navColor); ?>;
}
/*================= Header Side - Modrn ================ */
<?php if (($header == 'left' || $header == 'right') && pixflow_get_theme_mod('header_side_theme',PIXFLOW_HEADER_SIDE_THEME) == 'modern') { ?>

    header.side-modern .side .logo,
    header.side-modern .side .footer,
    header.side-modern .nav-modern-button,
    header.side-modern .footer .info .footer-content ul,
    header.side-modern .icons-pack li{
    border-color: <?php echo esc_attr(pixflow_colorConvertor($navColor,'rgba',.15)); ?> ;
    }

    header.side-modern .nav-modern-button span,
    header.side-modern .footer .info .footer-content ul a,
    header.side-modern .footer .info> a,
    header.side-modern .footer .copyright p,
    header.side-modern .search-form input[type="text"]{
    color: <?php echo esc_attr($navColor); ?>;
    }

    <?php if (($header == "left")) { ?>
        .li-level2{
            transform-origin: left top!important;
        }
    <?php } elseif (($header == "right"))  { ?>
        .li-level2{
            transform-origin: right top!important;
        }
    <?php }?>

<?php } ?>

/* Header Overlay*/
header .color-overlay,
header.side-modern .footer .info .footer-content .copyright,
header.side-modern .footer .info .footer-content .footer-socials,
header.side-modern .search-form input[type="text"]{
<?php if (pixflow_get_theme_mod('header_bg_color_type',PIXFLOW_HEADER_BG_COLOR_TYPE) == 'gradient') {
    $color1 = pixflow_get_theme_mod('header_bg_gradient_color1', PIXFLOW_HEADER_BG_GRADIENT_COLOR1);
    $color2 = pixflow_get_theme_mod('header_bg_gradient_color2', PIXFLOW_HEADER_BG_GRADIENT_COLOR2);
    $orientation = pixflow_get_theme_mod('header_bg_gradient_orientation', PIXFLOW_HEADER_BG_GRADIENT_ORIENTATION);
    $colorSecond1 = pixflow_get_theme_mod('header_bg_gradient_second_color1', PIXFLOW_HEADER_BG_GRADIENT_SECOND_COLOR1);
    $colorSecond2 = pixflow_get_theme_mod('header_bg_gradient_second_color2', PIXFLOW_HEADER_BG_GRADIENT_SECOND_COLOR2);
    $orientation = pixflow_get_theme_mod('header_bg_gradient_orientation', PIXFLOW_HEADER_BG_GRADIENT_ORIENTATION);
    ?> background: <?php echo esc_attr($color1) ?>; /* Old browsers */
    <?php if ($orientation == 'horizontal') { ?>
        background: -moz-linear-gradient(left,  <?php echo esc_attr($color1 )?> 0%,<?php echo esc_attr($color2) ?> 33%, <?php echo esc_attr($colorSecond1) ?> 66%,<?php echo esc_attr($colorSecond2) ?> 100%); /* FF3.6+ */
        background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,<?php echo esc_attr($color1) ?>), color-stop(33%,<?php echo esc_attr($color2) ?>),color-stop(66%,<?php echo esc_attr($colorSecond1) ?>),color-stop(100%,<?php echo esc_attr($colorSecond2) ?>)); /* Chrome,Safari4+ */
        background: -webkit-linear-gradient(left,  <?php echo esc_attr($color1) ?> 0%,<?php echo esc_attr($color2) ?> 33%,<?php echo esc_attr($colorSecond1) ?> 66%, <?php echo esc_attr($colorSecond2)?> 100%); /* Chrome10+,Safari5.1+ */
        background: -o-linear-gradient(left,  <?php echo esc_attr($color1) ?> 0%,<?php echo esc_attr($color2) ?> 33%,<?php echo esc_attr($colorSecond1) ?> 66%, <?php echo esc_attr($colorSecond2)?> 100%); /* Opera 11.10+ */
        background: -ms-linear-gradient(left,  <?php echo esc_attr($color1) ?> 0%,<?php echo esc_attr($color2) ?> 33%,<?php echo esc_attr($colorSecond1) ?> 66%, <?php echo esc_attr($colorSecond2)?> 100%); /* IE10+ */
        background: linear-gradient(to right,  <?php echo esc_attr($color1) ?> 0%,<?php echo esc_attr($color2) ?> 33%,<?php echo esc_attr($colorSecond1) ?> 66%, <?php echo esc_attr($colorSecond2)?> 100%); /* W3C */
        background-size:400% 100%;
    <?php } else { ?>
        background: -moz-linear-gradient(top,  <?php echo esc_attr($color1) ?> 0%, <?php echo esc_attr($color2) ?> 33%, <?php echo esc_attr($colorSecond1) ?> 66%,<?php echo esc_attr($colorSecond2) ?> 100%); /* FF3.6+ */
        background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,<?php echo esc_attr($color1) ?>), color-stop(33%,<?php echo esc_attr($color2) ?>),color-stop(66%,<?php echo esc_attr($colorSecond1) ?>),color-stop(100%,<?php echo esc_attr($colorSecond2) ?>)); /* Chrome,Safari4+ */
        background: -webkit-linear-gradient(top,  <?php echo esc_attr($color1) ?> 0%,<?php echo esc_attr($color2) ?> 33%,<?php echo esc_attr($colorSecond1) ?> 66%, <?php echo esc_attr($colorSecond2)?> 100%); /* Chrome10+,Safari5.1+ */
        background: -o-linear-gradient(top,  <?php echo esc_attr($color1) ?> 0%,<?php echo esc_attr($color2) ?> 33%,<?php echo esc_attr($colorSecond1) ?> 66%, <?php echo esc_attr($colorSecond2)?> 100%); /* Opera 11.10+ */
        background: -ms-linear-gradient(top,  <?php echo esc_attr($color1) ?> 0%,<?php echo esc_attr($color2) ?> 33%,<?php echo esc_attr($colorSecond1) ?> 66%, <?php echo esc_attr($colorSecond2)?> 100%); /* IE10+ */
        background: linear-gradient(to bottom,  <?php echo esc_attr($color1) ?> 0%,<?php echo esc_attr($color2) ?> 33%,<?php echo esc_attr($colorSecond1) ?> 66%, <?php echo esc_attr($colorSecond2)?> 100%); /* W3C */
        background-size:100% 400%;
    <?php } ?> filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='<?php echo esc_attr($color1) ?>', endColorstr='<?php echo esc_attr($color2) ?>', GradientType=0); /* IE6-8 */

    transition: background-position 500ms;
<?php } elseif (pixflow_get_theme_mod('header_bg_color_type', PIXFLOW_HEADER_BG_COLOR_TYPE) == 'solid'){ ?>
    background-color: <?php echo esc_attr(pixflow_get_theme_mod('header_bg_solid_color', PIXFLOW_HEADER_BG_SOLID_COLOR )); ?>;
<?php } ?>
}

header:not(.header-clone) > .color-overlay {
    <?php $header_border_enable = pixflow_get_theme_mod('header_border_enable'); ?>
    <?php if( (pixflow_get_theme_mod('header_border_enable',PIXFLOW_HEADER_BORDER_ENABLE) == 1 && $header == 'top') || ($header == 'top' && pixflow_get_theme_mod('classic_style',PIXFLOW_CLASSIC_STYLE) == 'wireframe') ) {?>
        border-bottom: 1px solid;
        border-bottom-color: <?php echo esc_attr(pixflow_colorConvertor($navColor,'rgba',0.3)); ?>;
    <?php } ?>

    <?php if( ($header_border_enable == 1 || $header_border_enable === null) && $header == 'left' ) {?>
        border-right: 1px solid;
        border-right-color: <?php echo esc_attr(pixflow_colorConvertor($navColor,'rgba',0.3)); ?>;
    <?php } ?>

    <?php if( ($header_border_enable == 1 || $header_border_enable === null) && $header == 'right' ) {?>
        border-left: 1px solid;
        border-left-color: <?php echo esc_attr(pixflow_colorConvertor($navColor,'rgba',0.3)); ?>;
    <?php } ?>

}

/*================= DropDown Styles ================ */
header nav.navigation li.megamenu > .dropdown,
header nav.navigation li.has-dropdown > .dropdown{
    display : table;
    position: absolute;
    top: <?php echo esc_attr(pixflow_get_theme_mod('header-top-height', PIXFLOW_HEADER_TOP_HEIGHT)).'px'?>;
}

header nav.navigation li.megamenu > .dropdown > .megamenu-dropdown-overlay,
.gather-overlay  nav li.megamenu > .dropdown > .megamenu-dropdown-overlay,
header nav > ul > li.has-dropdown:not(.megamenu)  ul .megamenu-dropdown-overlay{
    background-color:<?php echo esc_attr(pixflow_get_theme_mod('dropdown_bg_solid_color', PIXFLOW_DROPDOWN_BG_SOLID_COLOR)); ?>;

}

header nav.navigation > ul > li.megamenu > ul > li > a{
    color:<?php echo esc_attr(pixflow_get_theme_mod('dropdown_heading_solid_color', PIXFLOW_DROPDOWN_HEADING_SOLID_COLOR)); ?>;
}
header[class *= "top-"]:not(.right) nav.navigation li.megamenu > ul.dropdown:not(.side-line),
header[class *= "top-"]:not(.right) nav.navigation > ul > li.has-dropdown > ul.dropdown:not(.side-line){
    border-top:3px solid <?php echo pixflow_get_theme_mod('dropdown_fg_hover_color',PIXFLOW_DROPDOWN_FG_HOVER_COLOR) ?>;
}
header.top nav.navigation > ul > li.has-dropdown:not(.megamenu) .dropdown.side-line,
header.top nav.navigation li.megamenu > .dropdown.side-line,
.gather-overlay nav.navigation > ul > li.has-dropdown:not(.megamenu) .dropdown.side-line,
.gather-overlay nav.navigation li.megamenu > .dropdown.side-line{
    border-left: 3px solid <?php echo pixflow_get_theme_mod('dropdown_fg_hover_color',PIXFLOW_DROPDOWN_FG_HOVER_COLOR) ?>;
}

header.top nav.navigation > ul > li.has-dropdown:not(.megamenu) .dropdown.side-line li:after,
.gather-overlay nav.navigation > ul > li.has-dropdown:not(.megamenu) .dropdown.side-line li:after{
    background-color:<?php echo esc_attr(pixflow_colorConvertor(pixflow_get_theme_mod('dropdown_fg_solid_color',PIXFLOW_DROPDOWN_FG_SOLID_COLOR),'rgba',0.3)) ?>
}

header[class *= "top-"]:not(.right) nav.navigation li.megamenu > .dropdown,
header[class *= "top-"]:not(.right) nav.navigation li.has-dropdown > .dropdown{
    left: 0;
}


header[class *= "top-"] nav .dropdown a,
header[class *= "side-"] nav .dropdown a,
.gather-overlay nav .dropdown a{
    font-size: <?php echo esc_attr(pixflow_get_theme_mod('nav_size', PIXFLOW_NAV_SIZE))-1 . 'px' ?>;
}

.gather-overlay nav.navigation li.megamenu > .dropdown,
.gather-overlay nav.navigation li.has-dropdown > .dropdown{
    background-color:<?php echo esc_attr(pixflow_get_theme_mod('dropdown_bg_solid_color', PIXFLOW_DROPDOWN_BG_SOLID_COLOR)); ?>;
    display : table;
    left: 0;
    position: absolute;
    top: 150%;
}

header.left nav.navigation > ul > li.has-dropdown > .dropdown .megamenu-dropdown-overlay,
header.side-modern .side.style-style2 nav  > ul > li .megamenu-dropdown-overlay,
header.side-modern .side.style-style1 nav > ul .megamenu-dropdown-overlay,
header.side-modern .style-style1.side nav  ul  li{
    background-color:<?php echo esc_attr(pixflow_get_theme_mod('dropdown_bg_solid_color', PIXFLOW_DROPDOWN_BG_SOLID_COLOR)); ?>;
}

header.side-modern .style-style1.side nav  ul  li,
header.side-modern .style-style1.side nav.navigation > ul > li.has-dropdown .dropdown{
    border-color:<?php echo esc_attr(pixflow_colorConvertor(pixflow_get_theme_mod('dropdown_fg_solid_color',PIXFLOW_DROPDOWN_FG_SOLID_COLOR),'rgba',0.3)) ?>;
    color:<?php echo esc_attr(pixflow_get_theme_mod('dropdown_fg_solid_color',PIXFLOW_DROPDOWN_FG_SOLID_COLOR)) ?>;
}

header nav.navigation .dropdown a,
header.side-modern nav.navigation a,
.gather-overlay nav.navigation .dropdown a{
    color:<?php echo esc_attr(pixflow_get_theme_mod('dropdown_fg_solid_color',PIXFLOW_DROPDOWN_FG_SOLID_COLOR)) ?>;
    position: relative !important;
    width: auto !important;
}

/* dropDown Hover */

header .top nav > ul > li > ul li:hover > a .menu-title span,
header .top nav > ul > li .dropdown a:hover .menu-title span,
.gather-overlay nav > ul > li > ul li:hover > a .menu-title span,
.gather-overlay nav > ul > li .dropdown a:hover .menu-title span,
header.side-classic nav > ul > li > ul li:hover > a .menu-title span,
header.side-classic nav > ul > li .dropdown a:hover .menu-title span,
header.side-modern .side.style-style2 nav.navigation ul li a:hover{
    color: <?php echo esc_attr(pixflow_get_theme_mod('dropdown_fg_hover_color',PIXFLOW_DROPDOWN_FG_HOVER_COLOR));?>;
    border-color: <?php echo esc_attr(pixflow_get_theme_mod('dropdown_fg_hover_color',PIXFLOW_DROPDOWN_FG_HOVER_COLOR));?>;
}

header.side-modern .side.style-style1 nav.navigation ul li:hover{
    background-color: <?php echo esc_attr(pixflow_get_theme_mod('dropdown_fg_hover_color',PIXFLOW_DROPDOWN_FG_HOVER_COLOR));?>;
}
/*====================================================
                Body
======================================================*/
<?php
function pixflow_backgroundStyles($prefix, $parent){
    if(!isset($prefix,$parent)){
        return false;
    }
    ob_start();
    // this if always is true (because background controller set to postMessage.)
    //TODO: check location of view(customizer or output)
    if(pixflow_get_theme_mod($prefix.'_bg',constant(strtoupper('PIXFLOW_'.$prefix.'_BG'))) != true){ ?>
        <?php echo esc_attr($parent); ?> > .color-overlay,<?php echo esc_attr($parent); ?> > .texture-overlay,<?php echo esc_attr($parent); ?> > .bg-image {
            display:none;
        }
    <?php }
    if(pixflow_get_theme_mod($prefix.'_bg',constant(strtoupper('PIXFLOW_'.$prefix.'_BG'))) == '1' || true){ ?>
        /*** Body Overlay ***/
        <?php
        $bg_type = pixflow_get_theme_mod($prefix.'_bg_type',constant(strtoupper('PIXFLOW_'.$prefix.'_BG_TYPE')));
        if ($bg_type != 'color') { ?>
            <?php echo esc_attr($parent); ?> > .color-overlay.color-type {
            display:none;
            }
        <?php } ?>
        <?php
        if ($bg_type != 'image') { ?>
            <?php echo esc_attr($parent); ?> > .color-overlay.image-type,
            <?php echo esc_attr($parent); ?> > .bg-image
            { display:none; }
        <?php } ?>
        <?php
        if ($bg_type != 'texture') { ?>
            <?php echo esc_attr($parent); ?> > .color-overlay.texture-type,
            <?php echo esc_attr($parent); ?> > .texture-overlay
            { display:none; }
        <?php } ?>
        <?php if($prefix != 'footer'){ ?>
        <?php echo esc_attr($parent); ?> > .color-overlay.color-type {
        <?php if (pixflow_get_theme_mod($prefix.'_bg_color_type',constant(strtoupper('PIXFLOW_'.$prefix.'_BG_COLOR_TYPE'))) == 'gradient') {
            $color1 = pixflow_get_theme_mod($prefix.'_bg_gradient_color1',constant(strtoupper('PIXFLOW_'.$prefix.'_BG_GRADIENT_COLOR1')));
            $color2 = pixflow_get_theme_mod($prefix.'_bg_gradient_color2',constant(strtoupper('PIXFLOW_'.$prefix.'_BG_GRADIENT_COLOR2')));
            $orientation = esc_attr(pixflow_get_theme_mod($prefix.'_bg_gradient_orientation',constant(strtoupper('PIXFLOW_'.$prefix.'_BG_GRADIENT_ORIENTATION'))));
            ?> background: <?php echo esc_attr($color1) ?>;
            <?php if ($orientation == 'horizontal') { ?> background: -moz-linear-gradient(left,  <?php echo esc_attr($color1) ?> 0%, <?php echo esc_attr($color2) ?> 100%);
                background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,<?php echo esc_attr($color1) ?>), color-stop(100%,<?php echo esc_attr($color2) ?>));
                background: -webkit-linear-gradient(left,  <?php echo esc_attr($color1) ?> 0%,<?php echo esc_attr($color2) ?> 100%);
                background: -o-linear-gradient(left,  <?php echo esc_attr($color1) ?> 0%,<?php echo esc_attr($color2) ?> 100%);
                background: -ms-linear-gradient(left,  <?php echo esc_attr($color1) ?> 0%,<?php echo esc_attr($color2) ?> 100%);
                background: linear-gradient(to right,  <?php echo esc_attr($color1) ?> 0%,<?php echo esc_attr($color2) ?> 100%);
            <?php } else { ?> background: -moz-linear-gradient(top,  <?php echo esc_attr($color1) ?> 0%, <?php echo esc_attr($color2) ?> 100%);
                background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,<?php echo esc_attr($color1) ?>), color-stop(100%,<?php echo esc_attr($color2) ?>));
                background: -webkit-linear-gradient(top,  <?php echo esc_attr($color1) ?> 0%,<?php echo esc_attr($color2) ?> 100%);
                background: -o-linear-gradient(top,  <?php echo esc_attr($color1) ?> 0%,<?php echo esc_attr($color2) ?> 100%);
                background: -ms-linear-gradient(top,  <?php echo esc_attr($color1) ?> 0%,<?php echo esc_attr($color2) ?> 100%);
                background: linear-gradient(to bottom,  <?php echo esc_attr($color1) ?> 0%,<?php echo esc_attr($color2) ?> 100%);
            <?php } ?> filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='<?php echo esc_attr($color1) ?>', endColorstr='<?php echo esc_attr($color2) ?>', GradientType=0);
        <?php } elseif (pixflow_get_theme_mod($prefix.'_bg_color_type',constant(strtoupper('PIXFLOW_'.$prefix.'_BG_COLOR_TYPE'))) == 'solid') { ?> background-color: <?php echo esc_attr(pixflow_get_theme_mod($prefix.'_bg_solid_color', constant(strtoupper('PIXFLOW_'.$prefix.'_BG_SOLID_COLOR')))); ?>;
        <?php } ?>
        }
        <?php } ?>
        /* Body Background Image */
        <?php if (pixflow_get_theme_mod($prefix.'_bg_image_image') != '') { ?>
            <?php echo esc_attr($parent); ?> > .bg-image {
            background-image: url(<?php echo esc_url(pixflow_get_theme_mod($prefix.'_bg_image_image')); ?>);
            }
        <?php } ?>
            <?php echo esc_attr($parent); ?> > .bg-image {
            background-repeat: <?php echo esc_attr(pixflow_get_theme_mod($prefix.'_bg_image_repeat',constant(strtoupper('PIXFLOW_'.$prefix.'_BG_IMAGE_REPEAT')))); ?>;
            <?php if(esc_attr(pixflow_get_theme_mod($prefix.'_bg_image_attach',constant(strtoupper('PIXFLOW_'.$prefix.'_BG_IMAGE_ATTACH')))) == 'fixed' && $parent == '.layout-container'){?>
            background-attachment:fixed;
            <?php }else{?>
            background-attachment: <?php echo esc_attr(pixflow_get_theme_mod($prefix.'_bg_image_attach',constant(strtoupper('PIXFLOW_'.$prefix.'_BG_IMAGE_ATTACH')))); ?>;
            <?php }?>
            background-position: <?php echo esc_attr(str_replace('-', ' ', pixflow_get_theme_mod($prefix.'_bg_image_position',constant(strtoupper('PIXFLOW_'.$prefix.'_BG_IMAGE_POSITION'))))); ?>;
            background-size: <?php echo esc_attr(pixflow_get_theme_mod($prefix.'_bg_image_size',constant(strtoupper('PIXFLOW_'.$prefix.'_BG_IMAGE_SIZE')))); ?>;
            opacity: <?php echo esc_attr(pixflow_get_theme_mod($prefix.'_bg_image_opacity', constant(strtoupper('PIXFLOW_'.$prefix.'_BG_IMAGE_OPACITY')))); ?>;
            }
        <?php if (pixflow_get_theme_mod($prefix.'_bg_image_overlay',constant(strtoupper('PIXFLOW_'.$prefix.'_BG_IMAGE_OVERLAY'))) != '') { ?>
            <?php echo esc_attr($parent); ?> > .color-overlay.image-type {
            <?php if (pixflow_get_theme_mod($prefix.'_bg_image_overlay_type',constant(strtoupper('PIXFLOW_'.$prefix.'_BG_IMAGE_OVERLAY_TYPE'))) == 'gradient') {
                $color1 = pixflow_get_theme_mod($prefix.'_bg_overlay_gradient_color1',constant(strtoupper('PIXFLOW_'.$prefix.'_BG_OVERLAY_GRADIENT_COLOR1')));
                $color2 = pixflow_get_theme_mod($prefix.'_bg_overlay_gradient_color2',constant(strtoupper('PIXFLOW_'.$prefix.'_BG_OVERLAY_GRADIENT_COLOR2')));
                $orientation = esc_attr(pixflow_get_theme_mod($prefix.'_bg_overlay_gradient_orientation', constant(strtoupper('PIXFLOW_'.$prefix.'_BG_OVERLAY_GRADIENT_ORIENTATION'))));
                ?> background: <?php echo esc_attr($color1); ?>;
                <?php if ($orientation == 'horizontal') { ?>
                    background: -moz-linear-gradient(left,  <?php echo esc_attr($color1) ?> 0%, <?php echo esc_attr($color2) ?> 100%);
                    background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,<?php echo esc_attr($color1) ?>), color-stop(100%,<?php echo esc_attr($color2) ?>));
                    background: -webkit-linear-gradient(left,  <?php echo esc_attr($color1) ?> 0%,<?php echo esc_attr($color2) ?> 100%);
                    background: -o-linear-gradient(left,  <?php echo esc_attr($color1) ?> 0%,<?php echo esc_attr($color2) ?> 100%);
                    background: -ms-linear-gradient(left,  <?php echo esc_attr($color1) ?> 0%,<?php echo esc_attr($color2) ?> 100%);
                    background: linear-gradient(to right,  <?php echo esc_attr($color1) ?> 0%,<?php echo esc_attr($color2) ?> 100%);
                <?php } else { ?> background: -moz-linear-gradient(top,  <?php echo esc_attr($color1) ?> 0%, <?php echo esc_attr($color2) ?> 100%);
                    background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,<?php echo esc_attr($color1) ?>), color-stop(100%,<?php echo esc_attr($color2) ?>));
                    background: -webkit-linear-gradient(top,  <?php echo esc_attr($color1) ?> 0%,<?php echo esc_attr($color2) ?> 100%);
                    background: -o-linear-gradient(top,  <?php echo esc_attr($color1) ?> 0%,<?php echo esc_attr($color2) ?> 100%);
                    background: -ms-linear-gradient(top,  <?php echo esc_attr($color1) ?> 0%,<?php echo esc_attr($color2) ?> 100%);
                    background: linear-gradient(to bottom,  <?php echo esc_attr($color1) ?> 0%,<?php echo esc_attr($color2) ?> 100%);
                <?php } ?>
                filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='<?php echo esc_attr($color1) ?>', endColorstr='<?php echo esc_attr($color2) ?>', GradientType=0);
            <?php } elseif (pixflow_get_theme_mod($prefix.'_bg_image_overlay_type',constant(strtoupper('PIXFLOW_'.$prefix.'_BG_IMAGE_OVERLAY_TYPE'))) == 'solid') { ?>
                background-color: <?php echo esc_attr(pixflow_get_theme_mod($prefix.'_bg_image_solid_overlay',constant(strtoupper('PIXFLOW_'.$prefix.'_BG_IMAGE_SOLID_OVERLAY')))); ?>;
            <?php } ?>
            }
        <?php }//end if has image ?>

        /* Body Texture Overlay */
        <?php echo esc_attr($parent); ?> > .texture-overlay {
        opacity: <?php echo esc_attr(pixflow_get_theme_mod($prefix.'_bg_texture_opacity',constant(strtoupper('PIXFLOW_'.$prefix.'_BG_TEXTURE_OPACITY')))); ?>;
        background-image: url(<?php echo esc_url(pixflow_get_theme_mod($prefix.'_bg_texture',constant(strtoupper('PIXFLOW_'.$prefix.'_BG_TEXTURE')))) ?>);
        }

        <?php if (pixflow_get_theme_mod($prefix.'_bg_texture_overlay',constant(strtoupper('PIXFLOW_'.$prefix.'_BG_TEXTURE_OVERLAY'))) != '') { ?>
            <?php echo esc_attr($parent); ?> > .color-overlay.texture-type {
            background-color: <?php echo esc_attr(pixflow_get_theme_mod($prefix.'_bg_texture_solid_overlay',constant(strtoupper('PIXFLOW_'.$prefix.'_BG_TEXTURE_SOLID_OVERLAY')))); ?>;
            }
        <?php }// end if texture overlay ?>

    <?php }//if site_bg
    return ob_get_flush();
}
pixflow_backgroundStyles('site','.layout-container');
pixflow_backgroundStyles('footer','footer');
?>

/*====================================================
                    Main
======================================================*/

/* Main Overlay*/
<?php
$main_bg = pixflow_get_theme_mod('main_bg',PIXFLOW_MAIN_BG);
?>
<?php if($main_bg == false){ ?>
main .content .color-overlay.color-type { display:none }
<?php } ?>
/*** SITE Content Overlay ***/
main .content .color-overlay.color-type {
<?php if (pixflow_get_theme_mod('main_bg_color_type',PIXFLOW_MAIN_BG_COLOR_TYPE) == 'gradient') {
    $color1 = pixflow_get_theme_mod('main_bg_gradient_color1',PIXFLOW_MAIN_BG_GRADIENT_COLOR1);
    $color2 = pixflow_get_theme_mod('main_bg_gradient_color2',PIXFLOW_MAIN_BG_GRADIENT_COLOR2);
    $orientation = esc_attr(pixflow_get_theme_mod('main_bg_gradient_orientation',PIXFLOW_MAIN_BG_GRADIENT_ORIENTATION));
    ?> background: <?php echo esc_attr($color1) ?>;
    <?php if ($orientation == 'horizontal') { ?> background: -moz-linear-gradient(left,  <?php echo esc_attr($color1) ?> 0%, <?php echo esc_attr($color2) ?> 100%);
        background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,<?php echo esc_attr($color1) ?>), color-stop(100%,<?php echo esc_attr($color2) ?>));
        background: -webkit-linear-gradient(left,  <?php echo esc_attr($color1) ?> 0%,<?php echo esc_attr($color2) ?> 100%);
        background: -o-linear-gradient(left,  <?php echo esc_attr($color1) ?> 0%,<?php echo esc_attr($color2) ?> 100%);
        background: -ms-linear-gradient(left,  <?php echo esc_attr($color1) ?> 0%,<?php echo esc_attr($color2) ?> 100%);
        background: linear-gradient(to right,  <?php echo esc_attr($color1) ?> 0%,<?php echo esc_attr($color2) ?> 100%);
    <?php } else { ?> background: -moz-linear-gradient(top,  <?php echo esc_attr($color1) ?> 0%, <?php echo esc_attr($color2) ?> 100%);
        background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,<?php echo esc_attr($color1) ?>), color-stop(100%,<?php echo esc_attr($color2) ?>));
        background: -webkit-linear-gradient(top,  <?php echo esc_attr($color1) ?> 0%,<?php echo esc_attr($color2) ?> 100%);
        background: -o-linear-gradient(top,  <?php echo esc_attr($color1) ?> 0%,<?php echo esc_attr($color2) ?> 100%);
        background: -ms-linear-gradient(top,  <?php echo esc_attr($color1) ?> 0%,<?php echo esc_attr($color2) ?> 100%);
        background: linear-gradient(to bottom,  <?php echo esc_attr($color1) ?> 0%,<?php echo esc_attr($color2) ?> 100%);
    <?php } ?> filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='<?php echo esc_attr($color1) ?>', endColorstr='<?php echo esc_attr($color2) ?>', GradientType=0);
<?php } elseif (pixflow_get_theme_mod('main_bg_color_type',PIXFLOW_MAIN_BG_COLOR_TYPE) == 'solid') { ?>
    background-color: <?php echo esc_attr(pixflow_get_theme_mod('main_bg_solid_color', PIXFLOW_MAIN_BG_SOLID_COLOR)); ?>;
<?php } ?>
}
main .content {
    padding: <?php echo esc_attr(pixflow_get_theme_mod('mainC-padding', PIXFLOW_MAINC_PADDING)) ?>px;
}

<?php if( $sidebarSwitch != 'on' && $sidebarSwitch != '1'){ ?>
    main #content {
        margin-left: auto;
        margin-right: auto;
    }
<?php } ?>

/*Run in header side classic */
<?php if( $header == 'left' && pixflow_get_theme_mod('header_side_theme',PIXFLOW_HEADER_SIDE_THEME) == 'classic' )
    {
        $headersideW  = pixflow_get_theme_mod('header-side-width',PIXFLOW_HEADER_SIDE_WIDTH);
        $wrapContentW = (100 - $headersideW) . '%';
?>

    .layout > .wrap{
        width: <?php echo esc_attr($wrapContentW) ?>;
        margin-left: <?php echo esc_attr($headersideW) . '%' ?>;
    }

<?php } ?>

<?php if($header != 'top'){

    //Calculating the margin
    if(pixflow_get_theme_mod('header_side_theme',PIXFLOW_HEADER_SIDE_THEME) == 'modern'){
        $sideMargin = '65px';

        //Assigning the margin
        if($header == 'left'){ ?>
            .layout > .wrap{
                margin-left: <?php echo esc_attr($sideMargin) ?>;
            }
        <?php } else if($header == 'right'){ ?>
            .layout > .wrap{
                margin-right: <?php echo esc_attr($sideMargin) ?>;
            }
        <?php }

    } else if( pixflow_get_theme_mod('header_side_theme',PIXFLOW_HEADER_SIDE_THEME) == 'classic')
    {

        if( $header == 'left' )
        {
            $headersideW  = pixflow_get_theme_mod('header-side-width',PIXFLOW_HEADER_SIDE_WIDTH);
            $sidebarW     = $sidebarWidth;
            $wrapContentW = (100 - $headersideW) . '%';
            ?>

            .layout > .wrap{
                margin-left: <?php echo esc_attr($headersideW) . '%' ?>;
            }

        <?php
        } else if( $header == 'right' )
        {
            $headersideW  = pixflow_get_theme_mod('header-side-width',PIXFLOW_HEADER_SIDE_WIDTH);
            $sidebarW     = $sidebarWidth;
            $wrapContentW = (100 - $headersideW) . '%';
            ?>

            .layout > .wrap{
                margin-right: <?php echo esc_attr($headersideW) . '%' ?>;
            }

        <?php }
    }
} ?>


/* Run in header side modern */

<?php if( $header == 'left' && pixflow_get_theme_mod('header_side_theme',PIXFLOW_HEADER_SIDE_THEME) == 'modern' )
{
    $headersideW  = 65;
    $wrapContentW = (100 - $headersideW) . '%';
    ?>

    .layout > .wrap{
        width: 100%;
        padding-left: 65px;
    }

<?php } ?>

/*====================================================
                        Footer
======================================================*/
<?php
$color = pixflow_get_theme_mod('copyright_color',PIXFLOW_COPYRIGHT_COLOR);
?>
#footer-bottom .social-icons span a,
#footer-bottom .go-to-top a,
#footer-bottom p{
    color: <?php echo esc_attr($color); ?>;
}

footer.footer-default .footer-widgets {
    background-color: <?php echo esc_attr(pixflow_get_theme_mod('footer_widget_area_bg_color_rgba',PIXFLOW_FOOTER_WIDGET_AREA_BG_COLOR_RGBA)); ?>;
    overflow: hidden;
}

footer .widget-area {
   height: <?php echo esc_attr(pixflow_get_theme_mod('footer_widget_area_height',PIXFLOW_FOOTER_WIDGET_AREA_HEIGHT)); ?>px;
}

footer hr.footer-separator{
    height:<?php echo esc_attr(pixflow_get_theme_mod('copyright_separator',PIXFLOW_COPYRIGHT_SEPARATOR)) ?>px;
    background-color:<?php echo esc_attr(pixflow_get_theme_mod('copyright_separator_bg_color',PIXFLOW_COPYRIGHT_SEPARATOR_BG_COLOR)) ?>
}

footer.footer-default .widget-area.classicStyle.border.boxed div[class*="col-"]{
    height: <?php echo esc_attr(pixflow_get_theme_mod('footer_widget_area_height',PIXFLOW_FOOTER_WIDGET_AREA_HEIGHT))-120 ; ?>px;
}

footer.footer-default .widget-area.classicStyle.border.full div[class*="col-"]{
    height : <?php echo esc_attr(pixflow_get_theme_mod('footer_widget_area_height',PIXFLOW_FOOTER_WIDGET_AREA_HEIGHT)); ?>px;
    padding : 45px 30px;
}

footer.footer-default #footer-bottom{
    background-color: <?php echo esc_attr(pixflow_get_theme_mod('footer_bottom_area_bg_color_rgba',PIXFLOW_FOOTER_BOTTOM_AREA_BG_COLOR_RGBA)); ?>;
    overflow: hidden;
}
#footer-bottom{
    height: <?php echo esc_attr(pixflow_get_theme_mod('footer_bottom_area_height',PIXFLOW_FOOTER_BOTTOM_AREA_HEIGHT)); ?>px;
}

/*Footer Switcher*/

<?php if(pixflow_get_theme_mod('footer_social',PIXFLOW_FOOTER_SOCIAL) == 'on' || pixflow_get_theme_mod('footer_switcher',PIXFLOW_FOOTER_SWITCHER) == '1'){ ?>
    #footer-bottom .social-icons > span:not(.go-to-top){display:inline-flex;}
<?php }else{?>
    #footer-bottom .social-icons > span:not(.go-to-top){display:none;}
<?php } ?>

<?php if(pixflow_get_theme_mod('footer_copyright',PIXFLOW_FOOTER_COPYRIGHT) == 'on' || pixflow_get_theme_mod('footer_copyright',PIXFLOW_FOOTER_SWITCHER) == '1'){ ?>
    #footer-bottom .copyright{display:block;}
<?php }else{?>
    #footer-bottom .copyright{display:none;}
<?php } ?>

    #footer-bottom .logo{opacity:<?php echo esc_attr(pixflow_get_theme_mod('footer_logo_opacity',PIXFLOW_FOOTER_LOGO_OPACITY)); ?>;}

<?php if(pixflow_get_theme_mod('footer_logo',PIXFLOW_FOOTER_LOGO) == false || pixflow_get_theme_mod('footer_logo',PIXFLOW_FOOTER_LOGO) === 'false'){ ?>
    #footer-bottom .logo{display:none;}
<?php } ?>

<?php if(pixflow_get_theme_mod('footer_switcher',PIXFLOW_FOOTER_SWITCHER) == 'on' || pixflow_get_theme_mod('footer_switcher',PIXFLOW_FOOTER_SWITCHER) == '1'){ ?>
    #footer-bottom {display:block;}
<?php }else{?>
    #footer-bottom {display:none;}
<?php } ?>

/*====================================================
                    Sidebar
======================================================*/

/* Sidebar BACKGROUND */
<?php
pixflow_backgroundStyles($sidebarType.'_sidebar','.sidebar.box .widget');
pixflow_backgroundStyles($sidebarType.'_sidebar','.sidebar');
if($sidebarStyle != 'box'){ ?>
.sidebar.box .widget .color-overlay,
.sidebar.box .widget .texture-overlay,
.sidebar.box .widget .bg-image{
    display:none;
}
<?php }
else
{
?>  
.sidebar.box .widget{
box-shadow : 2px 3px 16px 4px <?php echo esc_attr($sidebarShadow) ?>;
} 


<?php
}
?>

/*=================Widget Contact Info================ */

.dark-sidebar .widget-contact-info-content,
.dark .widget-contact-info-content{
    background:url(<?php echo esc_url(PIXFLOW_THEME_IMAGES_URI.'/map-dark.png'); ?>)no-repeat 10px 15px;
}
.light-sidebar .widget-contact-info-content,
.light .widget-contact-info-content{
    background:url(<?php echo esc_url(PIXFLOW_THEME_IMAGES_URI.'/map-light.png'); ?>)no-repeat 10px 15px;
}

/*====================================================
                    Bussiness Bar
======================================================*/

/* Business Bar */

    <?php $headerTopPosition =(pixflow_get_theme_mod('businessBar_enable',PIXFLOW_BUSINESSBAR_ENABLE))? pixflow_get_theme_mod('header_top_position',PIXFLOW_HEADER_TOP_POSITION) : 0;?>

    .business {
        background: <?php echo esc_attr(pixflow_get_theme_mod('businessBar_bg_color', PIXFLOW_BUSINESSBAR_BG_COLOR)); ?>;
        top: <?php echo esc_attr($headerTopPosition); ?>px;
        height: 36px;
    }

    .business, .business a {
        color: <?php echo esc_attr(pixflow_get_theme_mod('businessBar_content_color', PIXFLOW_BUSINESSBAR_CONTENT_COLOR)); ?>;
    }

    header {
        margin-top: 0
    }


/*====================================================
                ShortCodes
======================================================*/


/*================= Row ================ */

.box_size{
    width: <?php echo esc_attr( pixflow_get_theme_mod('mainC-width',PIXFLOW_MAINC_WIDTH).'%' ); ?>
}

.box_size_container{
    width: <?php echo esc_attr( pixflow_get_theme_mod('mainC-width',PIXFLOW_MAINC_WIDTH).'%' ); ?>
}

/*==================================================
                        widget
====================================================*/
.widget a,
.widget p,
.widget span:not(.icon-caret-right)/*:not(.star-rating span)*/{
    font-family: <?php echo esc_attr( pixflow_get_theme_mod('p_name',PIXFLOW_P_NAME)); ?>;
}

/*=====================================================
                blog
=======================================================*/
.loop-post-content .post-title:hover{
    color: <?php echo esc_attr(pixflow_colorConvertor(pixflow_get_theme_mod('h1_color', PIXFLOW_H1_COLOR),'rgba',0.8)); ?>;
}
/*=====================================================
                woocommerce
======================================================*
.woocommerce ul.product_list_widget li span:not(.star-rating span){
    font-family: <?php echo esc_attr(pixflow_get_theme_mod('link_name', PIXFLOW_LINK_NAME)); ?>;
}

/*====================================================
                    Notification Center
======================================================*/
.notification-center .post .date .day.accent-color,
    #notification-tabs p.total,
    #notification-tabs p.total .amount,
    #notification-tabs .cart_list li .quantity,
    #notification-tabs .cart_list li .quantity  .amount{
    color : <?php echo esc_attr(pixflow_get_theme_mod('notification_color',PIXFLOW_NOTIFICATION_COLOR)); ?>;
}

.notification-center span,
.notification-center a,
.notification-center p,
#notification-tabs #result-container .search-title,
#notification-tabs #result-container .more-result,
#notification-tabs #result-container .item .title,
#notification-tabs #search-input,
#notification-tabs .cart_list li.empty,
.notification-collapse{
    font-family : <?php echo esc_attr(pixflow_get_theme_mod('nav_name', PIXFLOW_NAV_NAME)); ?>;
}
<?php if (! pixflow_get_theme_mod('notification_post',PIXFLOW_NOTIFICATION_POST )  ){ ?>
    .notification-center .pager .posts,
    .notification-center #notification-tabs .pager .posts.selected{
        display :none;
    }

    .notification-center .tabs-container .posts-tab{
        opacity : 0 ;
    }
<?php } ?>

<?php if(! pixflow_get_theme_mod('notification_portfolio',PIXFLOW_NOTIFICATION_PORTFOLIO ) ){ ?>
    .notification-center .pager .portfolio,
    .notification-center #notification-tabs .pager .portfolio.selected{
        display :none;
    }

    .notification-center .tabs-container .protfolio-tab{
        opacity : 0 ;
    }
<?php  } ?>

<?php if(! pixflow_get_theme_mod('notification_search',PIXFLOW_NOTIFICATION_SEARCH ) ) { ?>
    .notification-center .pager .search,
    .notification-center #notification-tabs .pager .search.selected{
        display :none;
    }
    .notification-center .tabs-container .search-tab{
        opacity : 0;
    }

<?php } ?>
<?php if(! pixflow_get_theme_mod('notification_cart',PIXFLOW_NOTIFICATION_CART ) ) {  ?>
    .notification-center .pager .shop,
     .notification-center #notification-tabs .pager .shop.selected{
         display :none;
    }

    .notification-center .tabs-container .shop-tab{
        opacity : 0;
    }
<?php }

$oneItemChecked = 0;

if (pixflow_get_theme_mod('notification_cart',PIXFLOW_NOTIFICATION_POST )) {
    $oneItemChecked++;
}
if (pixflow_get_theme_mod('notification_post',PIXFLOW_NOTIFICATION_POST )) {
    $oneItemChecked++;
}
if (pixflow_get_theme_mod('notification_portfolio',PIXFLOW_NOTIFICATION_POST )) {
    $oneItemChecked++;
}
if (pixflow_get_theme_mod('notification_search',PIXFLOW_NOTIFICATION_POST )) {
    $oneItemChecked++;
}

if ($oneItemChecked == 1) { ?>
    #notification-tabs .pager {
        display : none !important;
    }
<?php } ?>

.portfolio .accent-color,
.portfolio .accent-color.more-project,
.portfolio-carousel .accent-color.like:hover,
.portfolio-carousel .buttons .sharing:hover{
    color :<?php echo esc_attr(pixflow_get_theme_mod('portfolio_accent',PIXFLOW_PORTFOLIO_ACCENT)) ?>

}

.portfolio-split .accent-color.like:hover,
.portfolio-full .accent-color.like:hover{
    background-color :<?php echo esc_attr(pixflow_get_theme_mod('portfolio_accent',PIXFLOW_PORTFOLIO_ACCENT)) ?>;
    border-color :<?php echo esc_attr(pixflow_get_theme_mod('portfolio_accent',PIXFLOW_PORTFOLIO_ACCENT))?>;
    color:#fff;
}

.portfolio .accent-color.more-project:after{
    background-color :<?php echo esc_attr(pixflow_get_theme_mod('portfolio_accent',PIXFLOW_PORTFOLIO_ACCENT)) ?>
}

.portfolio .accent-color.more-project:hover{
    color :<?php echo esc_attr(pixflow_colorConvertor(pixflow_get_theme_mod('portfolio_accent',PIXFLOW_PORTFOLIO_ACCENT),'rgba',.6)) ?>
}

.portfolio .category span {
    color :<?php echo esc_attr(pixflow_colorConvertor(pixflow_get_theme_mod('h2_color',PIXFLOW_H2_COLOR),'rgba',.7)); ?>
}

.portfolio .buttons .sharing,
.portfolio-carousel .buttons .like{
    border-color: <?php echo esc_attr(pixflow_get_theme_mod('p_color',PIXFLOW_P_COLOR)) ?>;
    color: <?php echo esc_attr(pixflow_get_theme_mod('p_color',PIXFLOW_P_COLOR)) ?>;
}

.portfolio-split .buttons .sharing:hover,
.portfolio-full .buttons .sharing:hover{
    background-color: <?php echo esc_attr(pixflow_get_theme_mod('p_color',PIXFLOW_P_COLOR)); ?>;
    color: #fff;
}

<?php if('side' == $headerPosition){
    $portfolioNavWidth = ($headerSideTheme=='modern')?'100':100 - esc_attr(pixflow_get_theme_mod('header-side-width',PIXFLOW_HEADER_SIDE_WIDTH));
    ?>
    /*Portfolio detail Nav*/
    .portfolio-nav{ width: <?php echo esc_attr($portfolioNavWidth).'%' ?> !important; }
    <?php if('left' == $header){
        ?>.portfolio-nav{right:0;left:auto;}<?php
    }else{
        ?>.portfolio-nav{left:0;right:auto;}<?php
    }
    if('modern' == $headerSideTheme && 'left' == $header){
        ?>.portfolio-nav a.prev{left:65px;}<?php
    }elseif('modern' == $headerSideTheme && 'right' == $header){
        ?>.portfolio-nav a.next{right:65px;}<?php
    }
}
unset($_SESSION['pixflow_post_id']);?>


