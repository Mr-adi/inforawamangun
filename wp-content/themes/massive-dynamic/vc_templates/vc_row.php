<?php
/** @var $this WPBakeryShortCode_VC_Row */
$css =$box_size_container= '';
extract( shortcode_atts( array(

    'row_type'        => 'none',
    'type_width'      => 'full_size',
    'box_size_states' => 'content_box_size',

    'row_poster_url' => '',
    'row_webm_url'   => '',
    'row_mp4_url'    => '',

    'row_gradient_color'     => '',
    'background_color'       => 'rgba(255,255,255,1)',
    'background_color_image' => 'rgba(0,0,0,0.2)',
    'row_image'              => '',
    'row_image_gradient'     => '',
    'row_image_position'     => 'default',
    'row_image_position_gradient' => 'fit',

    'first_color'  => '',
    'second_color' => '',

    'parallax_status' => 'no',
    'parallax_speed'  => '1',

    'row_inner_shadow' => '',

    'row_sloped_edge'         => 'no',
    'row_slope_edge_position' => 'top',
    'row_sloped_edge_color'   => '',
    'row_sloped_edge_angle'   => '-3',

    'row_padding_top'    => '45',
    'row_padding_bottom' => '45',
    'row_padding_right'  => '0',
    'row_padding_left'   => '0',

    'row_margin_top'     => '0',
    'row_margin_bottom'  => '0',

    'row_fit_to_height'         => 'false',
    'row_bg_repeat_image_gp'    => 'false',
    'row_bg_repeat_gradient_gp' => 'false',

    'row_vertical_align' => 'false',
    'row_section_id'     => '',

    'row_bg_image_size_tab_image'    => '',
    'row_bg_image_size_tab_gradient' => '',

), $atts ));

if ($row_type == 'none'){
    $background_color = $background_color;
}else{
    $background_color = $background_color_image;
}
$row_image_size = '';
if ($row_type == 'image'){
    $row_image = $row_image;
    $row_image_position = $row_image_position;
    $row_image_size = $row_bg_image_size_tab_image;

}elseif($row_type == 'gradient'){
    $row_image = $row_image_gradient;
    $row_image_position = $row_image_position_gradient;
    $row_image_size = $row_bg_image_size_tab_gradient;
}
$parallax_image_id = '';
$parallax_image_src = '';

if('top' == $row_image_position){
    $row_image_position = 'center top';
    $row_image_repeat  = ' no-repeat';
    $backgroundSize = '100%';
}elseif('bottom' == $row_image_position){
    $row_image_position = 'center bottom';
    $row_image_repeat  = ' no-repeat';
    $backgroundSize = '100%';
}else{
    $row_image_position = 'center center';
    $row_image_repeat  = '';
    $backgroundSize = 'cover';
}

if( "yes" == $row_sloped_edge && "yes" == $row_inner_shadow ){
    if ( $row_slope_edge_position || $row_slope_edge_position ){
        $shadowTop ='0px 11px 8px -10px rgba(0,0,0,.8);';
    }
    if( $row_slope_edge_position || $row_slope_edge_position){
        $shadowBottom ='0px -11px 8px -10px rgba(0,0,0,.8);';
    }
}else{
    $shadowTop = 'none;';
    $shadowBottom = 'none;';
}

wp_enqueue_script( 'wpb_composer_front_js' );

$id = pixflow_sc_id('rowCustom');

//row spacing
$controlsTop = 0;
$rowspacePadding = "";
$rowspaceMargin = "";
$box_size_container = false;
$class = '';

if ( $row_padding_top != "" || 'yes' == $row_sloped_edge  || $row_padding_bottom != "" || $row_padding_left != "" || $row_padding_right != "" || $row_margin_top != "" || $row_margin_bottom != "" ) {

    if ( $row_padding_top != ""  ) {
        $rowspacePadding .= 'padding-top:'.$row_padding_top.'px;';
        $controlsTop = intval($row_padding_top)*-1;

    }

    if ( $row_padding_bottom != ""  ) {
        $rowspacePadding .= 'padding-bottom:'.$row_padding_bottom.'px;';
    }

    if ( $row_padding_right != "" ) {

        $rowspacePadding .= 'padding-right:'.$row_padding_right.'px;';
    }

    if ( $row_padding_left != "" ) {
        $rowspacePadding .= 'padding-left:'.$row_padding_left.'px;';
    }

    if ( $row_margin_top != "") {
        $rowspaceMargin .= 'margin-top:'.$row_margin_top.'px;';
    }

    if ( $row_margin_bottom != "") {
        $rowspaceMargin .= 'margin-bottom:'.$row_margin_bottom.'px;';
    }

}

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'vc_row wpb_row ' . ( $this->settings( 'base' ) === 'vc_row_inner' ? 'vc_inner ' : '' ) , $this->settings['base'], $atts );
$css_class .= ( intval($row_padding_top) < 45 ) ? ' controls-in' : $css_class;

?>

    <div

        id="<?php echo esc_attr($id); ?>"

        class="<?php echo esc_attr( $css_class ); ?>
                <?php echo esc_attr(' sectionOverlay vc_general vc_parallax vc_parallax-' . $row_image ); ?>

                <?php
        if($type_width == 'full_size'){
            echo esc_attr('full_size');
        }
        elseif ($type_width == 'box_size'){
            echo esc_attr('box_size');
        }

        if('yes' == $row_fit_to_height){
            echo ' fit-to-height';
        }

        if('yes' == $row_vertical_align){
            echo ' vertical-aligned';
        }
        ?>
              "

        <?php if ( ! empty( $full_width ) ) {
            echo esc_attr(' data-vc-full-width="true" data-vc-full-width-init="false" ');

            if ( $full_width == 'full_width' || $full_width == 'box_width' ){
                echo esc_attr(' data-vc-stretch-content="true"');
            }
        }

        // Check row container type

        if ( $row_image && ($row_type != 'none' ) ){
            $parallax_image_id = preg_replace( '/[^\d]/', '', $row_image );
            $parallax_image_src = wp_get_attachment_image_src( $parallax_image_id, 'full' );
            $parallax_image_src = (false == $parallax_image_src)?PIXFLOW_PLACEHOLDER_BG:$parallax_image_src[0];
            if ( ! empty( $parallax_image_src ) ) {
                $parallax_image_src = $parallax_image_src;
            }
            echo esc_attr(' data-vc-parallax-image=' . $parallax_image_src );
        } ?>

        >
        <?php if($row_section_id != '') { ?>
            <div id="<?php echo esc_attr($row_section_id) ?>" class="one-page-anchor"></div>
        <?php }


        // Parallax speed controller
        if ( ($parallax_status == 'yes') && ($parallax_speed != '10') ) $parallax_speed = 1 - ($parallax_speed / 10);
        ?>

        <script type="text/javascript">

            "use strict";
            var $ = jQuery;

            $(document).ready(function(){

                if(typeof $ != 'function'){
                    $ = jQuery;
                }

                var isChrome = window.chrome,
                    $<?php echo str_replace('-','_',esc_attr($id)); ?> = $("#<?php echo esc_attr($id) ?>");

                $<?php echo str_replace('-','_',esc_attr($id)); ?>.find('.row-image').remove();

                $<?php echo str_replace('-','_',esc_attr($id)); ?>.append(
                    '<div class="row-image <?php if ($parallax_speed != '10') echo esc_attr('row-image-normal'); else echo esc_attr('row-image-fixed');  if ( ($parallax_status == 'yes') && $row_image && ($row_type != 'none') ) echo esc_attr(" isParallax "); if($row_bg_repeat_image_gp == 'yes') echo esc_attr(" repeat"); ?> "> </div>'
                );

                if (!("<?php echo esc_attr($row_image) ?>")) {
                    $<?php echo str_replace('-','_',esc_attr($id)); ?>.find('.row-image').remove();
                }

                <?php if( $parallax_status == 'yes') { ?>

                if ( typeof $.fn.parallax == 'function' && $(window).width() >= 1280 ) {

                    <?php if ($parallax_speed != '10') { ?>
                    $("#<?php echo esc_attr($id) ?> .row-image-normal").parallax("50%", <?php echo esc_attr($parallax_speed); ?>);
                    <?php } ?>
                }

                <?php } ?>

                if (typeof pixflow_fitRowToHeight == 'function') {
                    pixflow_fitRowToHeight();
                }

                if (isChrome){
                    $<?php echo str_replace('-','_',esc_attr($id)); ?>.find(".row-image-fixed").append('<Style> .row-image-fixed:after { position: fixed; background-attachment: inherit; } </style>');
                }

            });

        </script>


        <!-- Set background image -->
        <style scoped>

            /* Do this code for each id */
            <?php if( $parallax_image_src != '' && $parallax_speed != '10' ) {

                echo esc_attr('#' . $id); ?> .row-image-normal
            {
                background-image: url( <?php echo esc_attr($parallax_image_src); ?> );
            }

            <?php } else if ($parallax_speed == '10') {

                echo esc_attr('#' . $id); ?> .row-image-fixed:after {
                                                             background-image: url( <?php echo esc_attr($parallax_image_src); ?> );
                                                         }

            <?php } ?>


            /* Set background image */
            <?php if($row_image_position != 'default') {

                echo esc_attr('#' . $id); ?> .row-image {
                                                             background-position: <?php echo esc_attr($row_image_position); ?>;
                                                         }

            <?php } ?>


            /* set Image Size */
            <?php
            $row_image_size = ('initial' == $row_image_size)?'auto':$row_image_size;
            if( $row_image_size != 'cover' && $row_image_size != '' ) {

                echo esc_attr('#' . $id); ?> .row-image {
                                                             background-size: <?php echo esc_attr($row_image_size); ?>;
                                                         }

            <?php } ?>

        </style>

        <?php if ( ($parallax_status == 'yes') || $row_image || ($row_type == 'image') || ($row_type == 'gradient') || ($row_type == 'none') ) {

            if('yes' == $row_sloped_edge){ ?>
                <script type="text/javascript">
                    "use strict";
                    var $ = jQuery;
                    var $<?php echo str_replace('-','_',esc_attr($id)); ?> = $('#<?php echo esc_attr($id); ?>');
                    if($<?php echo str_replace('-','_',esc_attr($id)); ?>.find('.top-edge').length > 1){
                        $<?php echo str_replace('-','_',esc_attr($id)); ?>.find('.top-edge').last().remove();
                    } else if($<?php echo str_replace('-','_',esc_attr($id)); ?>.find('.bottom-edge').length > 1){
                        $<?php echo str_replace('-','_',esc_attr($id)); ?>.find('.bottom-edge').last().remove();
                    }
                </script>
            <?php if('top' == $row_slope_edge_position){ ?>

                <script type="text/javascript">
                    "use strict";
                    var $ = jQuery;
                    var $<?php echo str_replace('-','_',esc_attr($id)); ?> = $('#<?php echo esc_attr($id); ?>');
                    if($<?php echo str_replace('-','_',esc_attr($id)); ?>.find('.bottom-edge').length){
                        $<?php echo str_replace('-','_',esc_attr($id)); ?>.find('.bottom-edge').remove();
                    }
                </script>
                <div class="sloped-edge top-edge" style="background-color: <?php echo esc_attr($row_sloped_edge_color) ?>;transform: rotate(<?php echo esc_attr($row_sloped_edge_angle).'deg' ?>);box-shadow: <?php echo esc_attr($shadowTop); ?>"></div>

            <?php } elseif('bottom' == $row_slope_edge_position){ ?>

                <script type="text/javascript">
                    "use strict";
                    var $ = jQuery;
                    var $<?php echo str_replace('-','_',esc_attr($id)); ?> = $('#<?php echo esc_attr($id); ?>');
                    if($<?php echo str_replace('-','_',esc_attr($id)); ?>.find('.top-edge').length){
                        $<?php echo str_replace('-','_',esc_attr($id)); ?>.find('.top-edge').remove();
                    }
                </script>
                <div class="sloped-edge bottom-edge" style="background-color: <?php echo esc_attr($row_sloped_edge_color) ?>;transform: rotate(<?php echo esc_attr($row_sloped_edge_angle).'deg' ?>);box-shadow: <?php echo esc_attr($shadowBottom); ?>;"></div>

            <?php } elseif('both' == $row_slope_edge_position){ ?>

                <div class="sloped-edge top-edge" style="background-color: <?php echo esc_attr($row_sloped_edge_color) ?>; transform: rotate(<?php echo esc_attr($row_sloped_edge_angle).'deg' ?>); box-shadow: <?php echo esc_attr($shadowTop); ?>"></div>
                <div class="sloped-edge bottom-edge" style="background-color: <?php echo esc_attr($row_sloped_edge_color) ?>;transform: rotate(<?php echo esc_attr($row_sloped_edge_angle).'deg' ?>);box-shadow: <?php echo esc_attr($shadowBottom); ?>;"></div>

            <?php }
            } elseif('yes' != $row_sloped_edge){ ?>
                <script type="text/javascript">
                    "use strict";
                    var $ = jQuery;
                    var $<?php echo str_replace('-','_',esc_attr($id)); ?> = $('#<?php echo esc_attr($id); ?>');
                    if($<?php echo str_replace('-','_',esc_attr($id)); ?>.find('.sloped-edge').length){
                        $<?php echo str_replace('-','_',esc_attr($id)); ?>.find('.sloped-edge').remove();
                    }
                </script>
            <?php }

        } ?>

        <?php if('transition' == $row_type){ ?>
            <script type="text/javascript">

                var load = false;
                $(document).ready(function () {
                    if(typeof pixflow_rowTransitionalColor == 'function') {
                        pixflow_rowTransitionalColor($('#<?php echo esc_attr($id); ?>'), new $.Color('<?php echo esc_attr($first_color) ?>'), new $.Color('<?php echo esc_attr($second_color) ?>'))
                    }
                });
            </script>
        <?php } ?>

        <div class="wrap">

            <?php
            if ( $type_width == 'full_size' && $box_size_states == 'content_box_size' ) {
                $box_size_container = true;
            }

            echo wpb_js_remove_wpautop( $content );
            ?>
            <?php if('video' == $row_type){
                if ($row_poster_url != '' && is_numeric($row_poster_url)) {
                    $row_poster_url = wp_get_attachment_image_src( $row_poster_url,'full') ;
                    $row_poster_url = (false == $row_poster_url)?PIXFLOW_PLACEHOLDER_BG:$row_poster_url[0];
                }
                ?>
                <video autoplay loop poster="<?php echo esc_url($row_poster_url); ?>" data-row-id="<?php echo esc_attr($id); ?>" class="row-videobg videobg-<?php echo esc_attr($id); ?>">
                    <source src="<?php echo esc_url($row_webm_url); ?>" type="video/webm">
                    <source src="<?php echo esc_url($row_mp4_url); ?>" type="video/mp4">
                </video>
            <?php } ?>
            <script>
                var $ = jQuery;
                var $<?php echo str_replace('-','_',esc_attr($id)); ?> = $('<?php echo esc_attr('#' . $id); ?>');
                if ( "<?php echo esc_attr($box_size_container == true); ?>" )
                {
                    $<?php echo str_replace('-','_',esc_attr($id)); ?>.find('> .wrap').addClass('box_size_container');
                    $<?php echo str_replace('-','_',esc_attr($id)); ?>.find('> .wrap').addClass('box_size_container');
                }
                else
                {
                    $<?php echo str_replace('-','_',esc_attr($id)); ?>.find('> .wrap').removeClass('box_size_container');
                    $<?php echo str_replace('-','_',esc_attr($id)); ?>.find('> .wrap').removeClass('box_size_container');
                }
                // Remove duplicate vide tags
                $('#<?php echo esc_attr($id); ?>').find('.row-videobg').not('.row-videobg[data-row-id="<?php echo esc_attr($id); ?>"]').remove();
            </script>

        </div> <!-- End wrap -->

    </div> <!-- End main row -->


    <style scoped>

        <?php if('transition' == $row_type){
            echo esc_attr('#' . $id);
         ?>

        <?php } ?>

        <?php if ( $row_margin_bottom == "" ){ ?>

        /* Remove margin bottom from rows */
        .sectionOverlay.wpb_row {
            margin-bottom: 0;
        }

        <?php } ?>

        /* Do this code for each id */

        <?php echo esc_attr('#' . $id); ?>{
        /* Set Margin */
        <?php echo esc_attr($rowspaceMargin); ?>
        }


        <?php echo esc_attr('#' . $id); ?>{
        /* Set padding */
        <?php echo esc_attr($rowspacePadding); ?>
        }

        .sectionOverlay.box_size{
            width: <?php echo esc_attr( pixflow_get_theme_mod('mainC-width',PIXFLOW_MAINC_WIDTH).'%' ); ?>
        }

        .sectionOverlay .box_size_container{
            width: <?php echo esc_attr( pixflow_get_theme_mod('mainC-width',PIXFLOW_MAINC_WIDTH).'%' ); ?>
        }

        <?php if('transition' != $row_type){
            echo esc_attr('#' . $id); ?>:after{
            /* Set background color */
            background-color: <?php echo esc_attr( ($row_type != 'gradient') ? $background_color : pixflow_makeGradientCSS($row_gradient_color) ); ?>
        }
        <?php } ?>

        <?php if ( $row_inner_shadow == "yes" ){
            echo esc_attr('#' . $id); ?>:after{
            box-shadow: inset 0px 11px 8px -10px rgba(0,0,0,0.8), inset 0 -11px 8px -10px rgba(0,0,0,0.8);
        }
        <?php } ?>
        <?php if('video' == $row_type){ ?>
        .videobg-<?php echo esc_attr($id)?>{
            background: url(<?php echo esc_url($row_poster_url); ?>);
        }
        <?php } ?>
    </style>

<?php

