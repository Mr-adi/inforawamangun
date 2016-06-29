<?php
$headerPosition = pixflow_get_theme_mod('header_position',PIXFLOW_HEADER_POSITION);
$footerStyle = 'width: ' . pixflow_get_theme_mod('footer-width',PIXFLOW_FOOTER_WIDTH) . '% ; margin-top:' . pixflow_get_theme_mod('footer-marginT',PIXFLOW_FOOTER_MARGINT) . 'px; ';
$footerContentStyle = 'width:' . pixflow_get_theme_mod('footerC-width',PIXFLOW_FOOTERC_WIDTH) .'%; ';
$footerWidgetStatus = pixflow_get_theme_mod('footer_widget_area_columns_status', PIXFLOW_FOOTER_WIDGET_AREA_COLUMNS_STATUS);
$footerWidgets = pixflow_get_theme_mod('footer_widget_area_columns',PIXFLOW_FOOTER_WIDGET_AREA_COLUMNS) ;
$widgets_separator_color = (pixflow_get_theme_mod('footer_widget_area_skin',PIXFLOW_FOOTER_WIDGET_AREA_SKIN) != "light"? "white":"black");
$footer_widget_area_skin = pixflow_get_theme_mod('footer_widget_area_skin',PIXFLOW_FOOTER_WIDGET_AREA_SKIN);
$footer_parallax = pixflow_get_theme_mod('footer_parallax',PIXFLOW_FOOTER_PARALLAX);
if($footer_parallax == 'on' || $footer_parallax == '1'){
    $footer_parallax = 'footer-parallax';
} else{
    $footer_parallax = '';
}
global $copyright;
$copyright = pixflow_get_theme_mod('footer_copyright_text');
$copyright = ($copyright === null)?PIXFLOW_FOOTER_COPYRIGHT_TEXT:$copyright;
global $logo;
if(pixflow_get_theme_mod('footer_logo_skin',PIXFLOW_FOOTER_LOGO_SKIN) == 'dark'){
    $logo = pixflow_get_theme_mod('dark_logo',PIXFLOW_DARK_LOGO);
}else{
    $logo = pixflow_get_theme_mod('light_logo',PIXFLOW_LIGHT_LOGO);
}
$attachment_id = pixflow_get_image_id( $logo );
if($attachment_id){
    $image_array = wp_get_attachment_image_src($attachment_id, 'pixflow_logo');
    $logo = (false == $image_array)?PIXFLOW_PLACEHOLDER_BLANK:$image_array[0];
}
function pixflow_genFooterLogo(){
    global $logo;
    $retString = '<div class="logo">';
    $retString .= '<img src="'.esc_url($logo).'" />';
    $retString .= '</div>';
    echo($retString);
}

function pixflow_genFooterCopyrightText(){
    global $copyright;
    $logo_status = (pixflow_get_theme_mod('footer_logo',PIXFLOW_FOOTER_LOGO) != true)?'':'footer-spacer';
    $retString = '<div class="copyright '.esc_attr($logo_status).'"><p>';
    $retString .= esc_attr($copyright);
    $retString .= '</p></div>';
    echo($retString);
}

function pixflow_genFooterSocialIcons(){
    $social_status = (pixflow_get_theme_mod('footer_social',PIXFLOW_FOOTER_SOCIAL) == true)?'':'md-hidden';
    $copyright_status = (pixflow_get_theme_mod('footer_copyright',PIXFLOW_FOOTER_COPYRIGHT) != true)?'':'footer-spacer';
    $retString ='<div class="social-icons '.esc_attr($social_status.' '.$copyright_status).'">';
    $socials = pixflow_get_active_socials();
    if($socials){
        foreach ($socials as $social ){
            $title = $social['title'];
            $icon = $social['icon'];
            $link = $social['link'];
            $retString.='<span data-social="'.esc_attr($title).'"><a href="'.esc_url($link).'"><span class="'.esc_attr($icon).'"></span></a></span>';
        }
    }
    $retString.='</div>';
    echo($retString);

}

function pixflow_genFooterBottom(){
	$footerBottomItemsLayout = pixflow_get_theme_mod('footer_bottom_items_layout',PIXFLOW_FOOTER_BOTTOM_ITEMS_LAYOUT);
    if($footerBottomItemsLayout == "linear") {
        pixflow_genFooterLogo();
        pixflow_genFooterSocialIcons();
        pixflow_genFooterCopyrightText();
    }elseif($footerBottomItemsLayout == "centered") {
        pixflow_genFooterLogo();
        pixflow_genFooterCopyrightText();
        pixflow_genFooterSocialIcons();
    }
}
?>
<footer class="footer-default <?php echo esc_attr($footer_parallax) ?>" style="<?php echo esc_attr($footerStyle); ?>">
    <div class="color-overlay texture-type"></div>
    <div class="color-overlay image-type"></div>
    <div class="texture-overlay"></div>
    <div class="bg-image"></div>
    <?php if($headerPosition == 'top'){ ?>
        <div class="content-holder">

        <?php if( $footerWidgetStatus !== 'false' && $footerWidgetStatus){ ?>
            <div class="footer-widgets <?php echo esc_attr($footer_widget_area_skin) ?>">

                <?php
                    /* Widget Clasic or Modern */
                   if ('classic' == pixflow_get_theme_mod('footer_widgets_styles',PIXFLOW_FOOTER_WIDGETS_STYLES)){
                      $widgetStyle= (pixflow_get_theme_mod('footer_classic_widgets_styles',PIXFLOW_FOOTER_CLASSIC_WIDGETS_STYLES)== 'none') ? 'classicStyle ' : 'classicStyle border ';
                      $widgetStyle .= pixflow_get_theme_mod('widgets_separator',PIXFLOW_WIDGETS_SEPARATOR);
                   }else {
                       $widgetStyle = 'modernStyle';
                   }
                ?>
                <div class="row widget-area <?php echo esc_attr($widgetStyle) ?> content" style="<?php echo esc_attr($footerContentStyle); ?>">
                    <?php
                    $widgetSize = 12 / $footerWidgets;

                    $widget_orders_json = pixflow_get_theme_mod('footer_widgets_order',PIXFLOW_FOOTER_WIDGETS_ORDER);
                    $order = $widget_orders = array();
                    if($widget_orders_json != '') {
                        $widget_orders = json_decode($widget_orders_json, true);
                    }
                    if(count($widget_orders) == $footerWidgets){
                        foreach($widget_orders as $val){
                            $order[] = substr($val,-1,1);
                        }
                    }else{
                        for($i=1;$i<=$footerWidgets;$i++){
                            $order[] = $i;
                        }
                    }


                    foreach($order as $i)
                    {
                    ?>
                        <div widgetid="footer-widget-<?php echo esc_attr($i); ?>" id="widget-column-<?php echo esc_attr($i) ?>" class="col-md-<?php echo esc_attr($widgetSize);?> widget-area-column">

                           <div class="wrapContent">

                                <?php
                                /* Widgetised Area */
                                if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar( 'footer-widget-' . $i ) ){}	?>
                                &nbsp;

                            </div>

                        </div>

                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    <?php
    }
    ?>
    <hr class="footer-separator">
    <div id="footer-bottom">
        <div class="<?php echo esc_attr(pixflow_get_theme_mod('footer_bottom_items_layout',PIXFLOW_FOOTER_BOTTOM_ITEMS_LAYOUT)); ?> content" style="<?php echo esc_attr($footerContentStyle); ?>">
            <?php
            pixflow_genFooterBottom();
            ?>
        </div>
    </div>
    <?php }?>
</footer>
