<?php
/****************************************************************************
 * @param $pageVar
 * @return array
 *
 * General layout functions
 ***************************************************************************/

    $sidebarWidth = $sidebarSticky = 0;
    $sidebarSkin = $sidebarAlign = $sidebarStyle = $sidebarSwitch = $sidebarPosition=$sidebarId = '';

function pixflow_page_width($pageVar){

    $values =  array();
    $values['wClass'] = $values['wStyle'] = $values['cClass'] = $values['cStyle'] = '';
    global $sidebarWidth;
    $values['wClass'] = 'left ';

    if($pageVar['headerPosition'] == 'left' || $pageVar['headerPosition'] == 'top'){
        $values['wClass'] = 'right ';
    }elseif($pageVar['headerPosition'] == 'right'){
        $values['wClass'] = 'left ';
    }

    //header Side
    if($pageVar['headerPosition'] == 'left' || $pageVar['headerPosition'] == 'right'){

        //when header is left or right calculate the wrap
        $headerWidth = ($pageVar['header']['width'] > 40 ) ? 40 : $pageVar['header']['width'];
        $wrapWidth = 100 - $headerWidth;

        if($pageVar['sidebar']['position'] != 'none'){

            //header side - normal sidebar
            $wrapWidth = 100 - $headerWidth;
            $values['wStyle'] = 'width:'. $wrapWidth .'%;';

            //header side - 'double' normal sidebar
            if ( $pageVar['sidebar']['position'] == 'double'  ){

                $sidebarWidth *= 2;
                $mainContentWidth = 100 - $sidebarWidth;
                $values['cClass']  = 'double-sidebar left ';
                $values['cStyle']  = 'width:'. $mainContentWidth .'%;';
            }
            //header side - 'single' normal sidebar
            else
            {
                $mainContentWidth = 100 - $sidebarWidth;
                $values['cClass'] = 'single-sidebar left';
                $values['cStyle'] = 'width:'. $mainContentWidth .'%;';
            }
        }

        if(pixflow_get_theme_mod('header_side_theme',PIXFLOW_HEADER_SIDE_THEME)=='modern'){
            $values['wStyle'] = '';
        }else{
            $values['wStyle'] = 'width:'. $wrapWidth .'%;';
        }

    }
    //header Top
    else{
        //if header is top
        if($pageVar['sidebar']['sticky'] && $pageVar['sidebar']['position'] != 'none' )
        {
            //header top - 'double' sticky sidebar
            if ( $pageVar['sidebar']['position'] == 'double' ){

                $sidebarWidth *= 2;
                $wrapWidth = 100 - ( $sidebarWidth /*+ $gapWidth */) ;
                $values['wClass'] .=  ' double-sidebar';
                $values['wStyle'] = 'width:'. $wrapWidth .'%;';
            }
            //header top - 'single' sticky sidebar
            else
            {
                $wrapWidth = 100 - $sidebarWidth;
                $values['wClass'] .=  ' single-sidebar';
                $values['wStyle']  = 'width:'. $wrapWidth .'%';
            }

        } elseif( !$pageVar['sidebar']['sticky'] && $pageVar['sidebar']['position'] != 'none' && $pageVar['sidebar']['position'])
        {
            //header top - 'double' normal sidebar
            if ( $pageVar['sidebar']['position'] == 'double' ){

                $sidebarWidth *= 2;
                $mainContentWidth = 100 - $sidebarWidth;
                $values['cClass']  = 'double-sidebar left ';
                $values['cStyle']  = 'width:'. $mainContentWidth .'%; ';
            }
            //header top - 'single' normal sidebar
            else
            {
                $mainContentWidth = 100 - $sidebarWidth;
                $values['cClass'] = 'single-sidebar left ';
                $values['cStyle'] = 'width:'. $mainContentWidth .'%;';
            }

        }

    }

    return $values;
}

/****************************************************************
 * functions to generate a Page
 ***************************************************************/

function pixflow_get_page_variables(){
    $var = array();

    /**************************************
     * Header
     *************************************/
        //  header position :  top ,  left ,  right
        $var['headerPosition'] = pixflow_get_theme_mod('header_position', PIXFLOW_HEADER_POSITION);

        $var['header'] = array('width' => ($var['headerPosition'] == 'top')? (int)pixflow_get_theme_mod('header_top_width', PIXFLOW_HEADER_TOP_WIDTH): (int) pixflow_get_theme_mod('header-side-width',PIXFLOW_HEADER_SIDE_WIDTH) );

    /**************************************
     * Sidebar
     *************************************/
        //sidebar class
        global $sidebarSkin,$sidebarAlign,$sidebarStyle,$sidebarSwitch,$sidebarPosition,$sidebarSticky,$sidebarId;
        $class = 'visible-desktop hidden-tablet ';
        $class .=  $sidebarSkin. '-sidebar ';
        $class .= $sidebarAlign . '-align ';
        $class .= ($sidebarStyle != 'none') ? $sidebarStyle. ' ' :'';
        // Sidebar
        if($sidebarSwitch == 'on' || ($sidebarSwitch == true && $sidebarSwitch != 'false')) $sidebarSwitch =1;
        elseif($sidebarSwitch == 'off' || $sidebarSwitch == false || $sidebarSwitch == 'false') $sidebarSwitch=0;

        // Disable sidebar in single portfolio page
        $sidebarSwitch = (is_singular('portfolio'))?0:$sidebarSwitch;

        $var['sidebar'] = array(
            'id'     => $sidebarId, //Id , get the sidebar id of this page and pass to func
            'class'  => $class,
            'sticky' => (int) $sidebarSticky,// sticky  : 0 - off , 1- on
            'position' => ($sidebarSwitch == 1)? $sidebarPosition:'none',// position :   right ,  left , double
        );


    /**************************************
     * layout
     *************************************/
        //layout
        $var['layout'] = array(
            'mainWidth'    => pixflow_get_theme_mod('main-width',PIXFLOW_MAIN_WIDTH),
            'mainTop'      => pixflow_get_theme_mod('main-top',PIXFLOW_MAIN_TOP),
            'mainCWidth'   => pixflow_get_theme_mod('mainC-width',PIXFLOW_MAINC_WIDTH),
            'mainCPadding' => pixflow_get_theme_mod('mainC-padding',PIXFLOW_MAINC_PADDING),
        );

    return $var;
}

function pixflow_generate_head($pageVar){

    get_header();

    if ( $pageVar['headerPosition'] == 'left' || $pageVar['headerPosition'] == 'right' ){

        get_template_part( 'templates/header-side' );

    }

    //check for sticky sidebar and generate it
    if($pageVar['sidebar']['sticky'] && $pageVar['sidebar']['position'] != 'none'){


        if( $pageVar['headerPosition'] == 'top' && ($pageVar['sidebar']['position'] == 'double' || $pageVar['sidebar']['position'] == 'left' )){

            pixflow_get_sidebar($pageVar['sidebar']['id'],'sticky',$pageVar['sidebar']['class']);

        }

        //generate left or right sticky sidebar according to menu
        else if ($pageVar['headerPosition'] == $pageVar['sidebar']['position'] || $pageVar['sidebar']['position'] == 'double'){

            pixflow_get_sidebar($pageVar['sidebar']['id'],'sticky',$pageVar['sidebar']['class']);

        }

    }

}

function pixflow_generate_content($pageVar, $loop = 'blog'){

    //get sidebar wrap or content width
    $elements_meta = pixflow_page_width($pageVar);
    ?>
    <!-- Start of Wrap -->
    <div class="wrap <?php echo esc_attr($elements_meta['wClass']); ?>" style="<?php echo esc_attr($elements_meta['wStyle']); ?>" >
<?php   if( $pageVar['headerPosition'] == 'top' ){
            get_template_part( 'templates/header-top' );
        }

        //create main tag inline style
        if(is_home()){
            $mainStyle = 'width:'. $pageVar['layout']['mainWidth'].'%;' ;
        } else {
            $mainStyle = 'padding-top:' . $pageVar['layout']['mainTop'] . 'px; width:'. $pageVar['layout']['mainWidth'].'%;' ;
        }?>


        <?php //create main > .content inline style
        $mainContentWidth = ($elements_meta['cStyle'] == '')?'': $elements_meta['cStyle'];
        if($pageVar['sidebar']['position'] == 'none' && $pageVar['headerPosition'] == 'top'){
            $mainContentStyle = 'padding: '.$pageVar['layout']['mainCPadding'] . '% ;' ;
        }else{
            $mainContentStyle = $mainContentWidth .'padding: '.$pageVar['layout']['mainCPadding'] . '% ;' ;
        }
        ?>
        <!-- Start of Main -->
        <?php
        //adding related class if footer is set on parallax
        $footer_parallax = pixflow_get_theme_mod('footer_parallax',PIXFLOW_FOOTER_PARALLAX);
        if($footer_parallax == 'on' || $footer_parallax == '1'){
        $footer_parallax = 'has-parallax-footer';
        } else{
        $footer_parallax = '';
        }?>
        <main class="clearfix <?php echo esc_attr($footer_parallax) ?> <?php ?><?php if ($pageVar['sidebar']['position'] =='right') {
                                        echo esc_attr(' right-sidebar-blog');
                                    }else if ($pageVar['sidebar']['position'] =='left') {
                                        echo esc_attr(' left-sidebar-blog');
                                    } else if ($pageVar['sidebar']['position'] =='double'){
                                        echo esc_attr(' double-sidebar-blog');
                                    }
            ?>" style="<?php echo esc_attr($mainStyle); ?>">
            <?php $showPageTitle=''; global $post;if(null != $post){$showPageTitle=get_post_meta( $post->ID, 'show_page_title', true );}//$showPageTitle = ($showPageTitle === '')?'yes':$showPageTitle;  ?>
            <?php if('yes' == $showPageTitle){ ?>
            <h4 class="page-custom-title"><?php echo the_title(); ?></h4>
            <?php } ?>
            <?php  if(is_single() && !is_singular('portfolio') && !is_singular('product')) {
                    get_template_part( 'templates/single', "post-media" );
                 }
        ?>

        <?php

        //generate normal left sidebar
        if ( ($pageVar['sidebar']['position'] =='left' || $pageVar['sidebar']['position'] == 'double') &&  !$pageVar['sidebar']['sticky'] && $pageVar['sidebar']['position'] != 'none'){
            $sidebar_class = ' left';

            $id = ($pageVar['sidebar']['position'] == 'double') ? 'double-sidebar':$pageVar['sidebar']['id'];

            pixflow_get_sidebar($id,'normal',$pageVar['sidebar']['class'].$sidebar_class);

        }
        ?>

            <!-- Start of Main content -->
            <div id="content" class="content <?php echo esc_attr($elements_meta['cClass']); ?>" style="<?php echo esc_attr($mainContentStyle) ?>" >
                <div class="color-overlay color-type"></div>
                    <?php

                    if($loop == 'blog'){
                        get_template_part( 'templates/loop', 'blog' );
                        if(PIXFLOW_USE_CUSTOM_PAGINATION)
                            pixflow_get_pagination();
                        else
                            paginate_links();
                    }elseif($loop == 'page'){
                        get_template_part('templates/loop-page');
                    }elseif ($loop == 'single-portfolio') {
                        get_template_part('templates/single', 'portfolio');
                    }elseif ($loop == 'single-post'){
                        get_template_part('templates/single-post','detail');
                    }elseif ($loop == '404'){
                        ?>
                        <div class="not-found-page">

                            <div class="image"></div>

                            <strong style="font-size:36px;"><?php esc_attr_e('404', 'massive-dynamic'); ?></strong>

                            <p style="font-size:21px;"><?php esc_attr_e('page is not available', 'massive-dynamic'); ?></p>

                        </div>
                        <?php
                    }elseif($loop == 'search'){
                        global $s;
                        $pageHeading = have_posts() ? sprintf(esc_attr__("result(s) found for '%s'", 'massive-dynamic'), $s) : esc_attr__('No results found', 'massive-dynamic');

                        $postsCount = 0;

                        while(have_posts()) {
                            the_post();
                            $postsCount++;
                        }
                        //$total_posts = $total_posts;
                        $postsCount = ($postsCount > 0 ) ? $postsCount : '';
                        ?>
                        <div>

                            <br/>
                            <?php get_search_form(); ?>

                            <hr/>

                            <p><?php echo esc_attr($postsCount).' '. esc_attr($pageHeading) ; ?></p>

                            <div class="search-result">
                                <?php
                                get_template_part( 'templates/loop', 'search' );
                                pixflow_get_pagination();
                                ?>
                            </div>

                        </div>
                        <?php
                    }

                    ?>
            </div>
            <!-- End of Main content -->

            <?php
            //generate normal right sidebar
            if ( ($pageVar['sidebar']['position'] =='right' || $pageVar['sidebar']['position'] == 'double') &&  !$pageVar['sidebar']['sticky'] && $pageVar['sidebar']['position'] != 'none' ){
                $sidebar_class = " left right-sidebar";
                pixflow_get_sidebar($pageVar['sidebar']['id'],'normal',$pageVar['sidebar']['class'].$sidebar_class);
            } ?>

        </main>
        <!-- End of Main -->

        <?php
        //generate footer
        get_template_part('templates/footer');

        ?>

    </div>
    <!-- End of Wrap -->

    <?php
}

function pixflow_generate_footer($pageVar){
    if($pageVar['sidebar']['sticky'] && $pageVar['sidebar']['position'] != 'none' ){
        //change header position to generate opposite sidebar

        if( $pageVar['headerPosition'] == 'top' && ($pageVar['sidebar']['position'] == 'right' || $pageVar['sidebar']['position'] == 'double' )){

            pixflow_get_sidebar($pageVar['sidebar']['id'],'sticky',$pageVar['sidebar']['class']);

        }else if (pixflow_not($pageVar['headerPosition']) == $pageVar['sidebar']['position'] || $pageVar['sidebar']['position'] == 'double'){

            pixflow_get_sidebar($pageVar['sidebar']['id'],'sticky',$pageVar['sidebar']['class']);

        }

    }

    get_footer();
}



function pixflow_generate_page($loop = 'blog'){

    global $sidebarWidth,$sidebarId , $sidebarSticky , $sidebarSkin , $sidebarAlign , $sidebarStyle ,$sidebarSwitch ,$sidebarPosition;

    if( is_single() ){
        $sidebarId = 'post-sidebar';
        $sidebarWidth = pixflow_get_theme_mod('sidebar-width-single',PIXFLOW_SIDEBAR_WIDTH_SINGLE);
        $sidebarSkin  = pixflow_get_theme_mod('sidebar-skin-single',PIXFLOW_SIDEBAR_SKIN_SINGLE);
        $sidebarAlign = pixflow_get_theme_mod('sidebar-align-single',PIXFLOW_SIDEBAR_ALIGN_SINGLE);
        $sidebarStyle = pixflow_get_theme_mod('sidebar-style-single',PIXFLOW_SIDEBAR_STYLE_SINGLE);
        $sidebarSwitch   = pixflow_get_theme_mod('sidebar-switch-single',PIXFLOW_SIDEBAR_SWITCH_SINGLE);
        $sidebarPosition = pixflow_get_theme_mod('sidebar-position-single',PIXFLOW_SIDEBAR_POSITION_SINGLE);

    }
    elseif ( (is_front_page() && is_home()) ||  is_home()  ){
        $sidebarId='main-sidebar';
        $sidebarWidth = pixflow_get_theme_mod('sidebar-width-blog',PIXFLOW_SIDEBAR_WIDTH_BLOG);
        $sidebarSkin  = pixflow_get_theme_mod('sidebar-skin-blog',PIXFLOW_SIDEBAR_SKIN_BLOG);
        $sidebarAlign = pixflow_get_theme_mod('sidebar-align-blog',PIXFLOW_SIDEBAR_ALIGN_BLOG);
        $sidebarStyle = pixflow_get_theme_mod('sidebar-style-blog',PIXFLOW_SIDEBAR_STYLE_BLOG);
        $sidebarSwitch   = pixflow_get_theme_mod('sidebar-switch-blog',PIXFLOW_SIDEBAR_SWITCH_BLOG);
        $sidebarPosition = pixflow_get_theme_mod('sidebar-position-blog',PIXFLOW_SIDEBAR_POSITION_BLOG);
    }
    elseif(is_page()){
        $sidebarId = 'page-sidebar';
        $sidebarWidth = pixflow_get_theme_mod('sidebar-width',PIXFLOW_SIDEBAR_WIDTH);
        $sidebarSkin  = pixflow_get_theme_mod('sidebar-skin',PIXFLOW_SIDEBAR_SKIN);
        $sidebarAlign = pixflow_get_theme_mod('sidebar-align',PIXFLOW_SIDEBAR_ALIGN);
        $sidebarStyle = pixflow_get_theme_mod('sidebar-style',PIXFLOW_SIDEBAR_STYLE);
        $sidebarSwitch   = pixflow_get_theme_mod('sidebar-switch',PIXFLOW_SIDEBAR_SWITCH);
        $sidebarPosition = pixflow_get_theme_mod('sidebar-position',PIXFLOW_SIDEBAR_POSITION);
    }
    if((in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) || class_exists( 'WooCommerce' )) && function_exists('is_woocommerce')){
        if(is_woocommerce()){
            $sidebarId = 'shop-sidebar';
            $sidebarWidth = pixflow_get_theme_mod('sidebar-width-shop',PIXFLOW_SIDEBAR_WIDTH_SHOP);
            $sidebarSkin  = pixflow_get_theme_mod('sidebar-skin-shop',PIXFLOW_SIDEBAR_SKIN_SHOP);
            $sidebarAlign = pixflow_get_theme_mod('sidebar-align-shop',PIXFLOW_SIDEBAR_ALIGN_SHOP);
            $sidebarStyle = pixflow_get_theme_mod('sidebar-style-shop',PIXFLOW_SIDEBAR_STYLE_SHOP);
            $sidebarSwitch   = pixflow_get_theme_mod('sidebar-switch-shop',PIXFLOW_SIDEBAR_SWITCH_SHOP);
            $sidebarPosition = pixflow_get_theme_mod('sidebar-position-shop',PIXFLOW_SIDEBAR_POSITION_SHOP);
        }
    }
    $pageVar = pixflow_get_page_variables();
    pixflow_generate_head($pageVar);
    pixflow_generate_content($pageVar,$loop);
    pixflow_generate_footer($pageVar);

}
