<?php

/** @var $this WPBakeryShortCode_VC_Row_Inner */
$box_size_container = $row_inner_margin_bottom ='';
extract( shortcode_atts( array(

    'inner_row_type'                   => 'none',
    'row_inner_type_width'             => 'full_size',
    'row_inner_box_size_states'        => 'content_box_size',

    'row_inner_gradient_color'         => '',
    'row_inner_background_color'       => '',

    'row_inner_inner_shadow'           => '',

    'inner_row_padding_top'    => '45',
    'inner_row_padding_bottom' => '45',
    'inner_row_padding_right'  => '0',
    'inner_row_padding_left'   => '0',

    'inner_row_margin_top'     => '0',
    'inner_row_margin_bottom'  => '0',

    'row_inner_image'          => '',

), $atts ));

if ($inner_row_type == 'none' || $inner_row_type == "" ){
    $row_inner_background_color = $row_inner_background_color;
}

$id_inner_row = pixflow_sc_id('rowInnerCustom');

// Inner row spacing

$innerRowSpacePadding = "";
$innerRowSpaceMargin = "";
$row_inner_box_size_container = false;

if ( $inner_row_padding_top != "" || 'yes' == $inner_row_sloped_edge  || $inner_row_padding_bottom != "" || $inner_row_padding_left != "" || $inner_row_padding_right != "" || $inner_row_margin_top != "" || $inner_row_margin_bottom != "" ) {

    if ($inner_row_padding_top != "") {
        $innerRowSpacePadding .= 'padding-top:' . $inner_row_padding_top . 'px;';
    }

    if ($inner_row_padding_bottom != "") {
        $innerRowSpacePadding .= 'padding-bottom:' . $inner_row_padding_bottom . 'px;';
    }

    if ($inner_row_padding_right != "") {

        $innerRowSpacePadding .= 'padding-right:' . $inner_row_padding_right . 'px;';
    }

    if ($inner_row_padding_left != "") {
        $innerRowSpacePadding .= 'padding-left:' . $inner_row_padding_left . 'px;';
    }

    if ($inner_row_margin_top != "") {
        $innerRowSpaceMargin .= 'margin-top:' . $inner_row_margin_top . 'px;';
    }

    if ($inner_row_margin_bottom != "") {
        $innerRowSpaceMargin .= 'margin-bottom:' . $inner_row_margin_bottom . 'px;';
    }

}

$css_class_inner_row = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'vc_row wpb_row ' . ( $this->settings( 'base' ) === 'vc_row_inner' ? 'vc_inner ' : '' ) , $this->settings['base'], $atts );

?>

    <div

        id="<?php echo esc_attr($id_inner_row); ?>"

        class="<?php echo esc_attr( $css_class_inner_row ); ?>
                <?php echo esc_attr(' sectionOverlay vc_general vc_parallax'); ?>

                <?php
        if ( $row_inner_type_width == 'full_size' ){
            echo esc_attr('full_size');
        }
        elseif ( $row_inner_type_width == 'box_size' ){
            echo esc_attr('box_size');
        }
        ?> "

        <?php if ( ! empty( $full_width ) ){
            echo esc_attr(' data-vc-full-width="true" data-vc-full-width-init="false" ');

            if ( $full_width == 'full_width' || $full_width == 'box_width' ){
                echo esc_attr(' data-vc-stretch-content="true"');
            }
        }
        ?>
    >

        <script type="text/javascript">

            "use strict";
            var $ = jQuery;
            $(document).ready(function() {

                if(typeof $ != 'function'){
                    $ = jQuery;
                }
                var $<?php echo str_replace('-','_',esc_attr($id_inner_row)); ?> = $("#<?php echo esc_attr($id_inner_row) ?>");

                $<?php echo str_replace('-','_',esc_attr($id_inner_row)); ?>.find('.row-image').remove();
                $<?php echo str_replace('-','_',esc_attr($id_inner_row)); ?>.append('<div class="row-image" ></div>');
            })


        </script>

        <?php
            if ( $row_inner_image && ($inner_row_type == 'gradient' ) ){

                $row_inner_image = wp_get_attachment_image_src( $row_inner_image, 'full' );
                $row_inner_image = (false == $row_inner_image)?PIXFLOW_PLACEHOLDER_BG:$row_inner_image[0];

                if ( ! empty( $row_inner_image ) ) {
                    $row_inner_image = $row_inner_image;
                }
            }
        ?>

        <style scoped>

            /* Do this code for each id */
            <?php echo esc_attr('#' . $id_inner_row); ?> .row-image {
                background-image: url( <?php echo esc_attr($row_inner_image); ?> );
            }

        </style>


        <div class="wrap">

            <?php
            if ( $row_inner_type_width == 'full_size' && $row_inner_box_size_states == 'content_box_size' ) {
                $box_size_container = true;
            }

            echo wpb_js_remove_wpautop( $content );
            ?>

            <script>
                if ( "<?php echo esc_attr($box_size_container == true); ?>" )
                {
                    $('<?php echo esc_attr('#' . $id_inner_row); ?>').find('.wrap').addClass('box_size_container');
                    $('<?php echo esc_attr('#' . $id_inner_row); ?>').find('.wrap').addClass('box_size_container');
                }
                else
                {
                    $('<?php echo esc_attr('#' . $id_inner_row); ?>').find('.wrap').removeClass('box_size_container');
                    $('<?php echo esc_attr('#' . $id_inner_row); ?>').find('.wrap').removeClass('box_size_container');
                }
            </script>

        </div> <!-- End wrap -->

    </div> <!-- End main row -->

    <style scoped>

        <?php if ( $row_inner_margin_bottom == "" ){ ?>

        /* Remove margin bottom from rows */
        .sectionOverlay.wpb_row{
            margin-bottom: 0;
        }

        <?php } ?>

        /* Do this code for each id */

        <?php echo esc_attr('#' . $id_inner_row); ?>{
            /* Set Margin */
            <?php echo esc_attr($innerRowSpaceMargin); ?>
        }

        <?php echo esc_attr('#' . $id_inner_row); ?>{
             /* Set padding */
            <?php echo esc_attr($innerRowSpacePadding) ?>
        }

        .sectionOverlay.box_size{
            width: <?php echo esc_attr( pixflow_get_theme_mod('mainC-width',PIXFLOW_MAINC_WIDTH).'%' ); ?>;
        }

        .sectionOverlay .box_size_container{
            width: <?php echo esc_attr( pixflow_get_theme_mod('mainC-width',PIXFLOW_MAINC_WIDTH).'%' ); ?>;
        }

        <?php echo esc_attr('#' . $id_inner_row); ?>::after {

            background-color: <?php echo esc_attr( ($inner_row_type != 'gradient') ? esc_attr($row_inner_background_color) : pixflow_makeGradientCSS($row_inner_gradient_color) ); ?>
        }

        <?php if ( $row_inner_inner_shadow == "true" ){
            echo esc_attr('#' . $id_inner_row); ?>:after{
            box-shadow: inset 0 11px 8px -10px rgba(0,0,0,0.8), inset 0 -11px 8px -10px rgba(0,0,0,0.8);
        }

        <?php } ?>

    </style>

