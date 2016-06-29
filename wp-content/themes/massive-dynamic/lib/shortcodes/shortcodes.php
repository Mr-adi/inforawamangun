<?php
/*-----------------------------------------------------------------------------------
	Theme Shortcodes
-----------------------------------------------------------------------------------*/

//Generate ID for shortcodes
function pixflow_sc_id($key)
{
    $globalKey = "md_sc_$key";
    $id    = uniqid();
    return esc_attr("$key-$id");
}

// read animation fields and return required values
function pixflow_shortcodeAnimation($shortcode,$atts){

    $animationFields = array('animation'=>'no','animation_speed'=>400,'animation_delay'=>'0','animation_position'=>'center','animation_show'=>'once');
    foreach($animationFields as $field=>$value){
        $animation[] = shortcode_atts( array(
            $shortcode.'_'.$field => $value,
        ), $atts );
    }
    foreach($animation as $val){
        foreach($val as $k=>$v){
            $k = str_replace($shortcode.'_','',$k);
            $animationValues[$k] = $v;
        }
    }
    $animationClass = $animationAttrs = '';
    if($animationValues["animation"] != 'no'){
        $animationClass = 'has-animation';
        $animationAttrs .= 'data-animation-speed='.$animationValues["animation_speed"].' data-animation-delay='.$animationValues["animation_delay"].' data-animation-position='.$animationValues["animation_position"].' data-animation-show='.$animationValues["animation_show"];
    }
    $output['has-animation'] = $animationClass;
    $output['animation-attrs'] = $animationAttrs;
    return $output;
}

// Call Shortcode Animation
function pixflow_callAnimation($script = false){
    ob_start();
    if($script){ ?>
    <script type="text/javascript">
    <?php } ?>
    if ( document.readyState === 'complete' ){
        if(typeof pixflow_shortcodeAnimation == 'function'){
            pixflow_shortcodeAnimation();
        }
        if(typeof pixflow_shortcodeAnimationScroll == 'function'){
            pixflow_shortcodeAnimationScroll();
        }
    }
    <?php if($script){ ?>
    </script>
    <?php }
    return ob_get_flush();
}


/*-----------------------------------------------------------------------------------*/
/*  MD Button
/*-----------------------------------------------------------------------------------*/



function pixflow_buttonMaker( $button_style = 'fade-square',$button_text = 'Read More',$button_icon_class = 'icon-Layers',
                         $button_url='#',$button_target = '_self',$button_align = 'left',$button_size = 'standard',
                         $button_color='#000',$button_hover_color='#fff',$left_right_padding='0',$button_text_color='#fff',
                         $button_hover_bg_color='#000',$animation=array(),$clearfix=true) {

    $class = "button ".$button_style;
    if(count($animation)<1){
        $animation['has-animation'] = null;
        $animation['animation-attrs'] = null;
    }
    switch($button_size)
    {
        case 'small':
            $class .=' button-small';
            break;
        case 'standard':
            $class .=' button-standard';
            break;
    }

    $id = pixflow_sc_id('button');

    ob_start();


    ?>

    <style scoped="scoped">

        <?php if($button_align == 'left' || $button_align == 'right') { ?>
            <?php echo esc_attr('#'.$id); ?>{
                float: <?php echo esc_attr($button_align);  ?>;
            }
        <?php } ?>

        /* Fade Square */

        <?php if( strstr($class, 'fade-square') ) {

            if ($button_size == 'standard') {
                $paddingTop =  ($button_icon_class == 'icon-empty') ? 15 : 12;
            } else {
                $paddingTop =  10;
            }

            echo esc_attr('#'.$id); ?>.shortcode-btn .button-standard.fade-square{
                padding: <?php echo esc_attr($paddingTop).'px '. esc_attr((int)$left_right_padding+27);?>px;
            }

            <?php echo esc_attr('#'.$id); ?>.shortcode-btn .button-small.fade-square{
                padding:<?php echo esc_attr($paddingTop).'px '. esc_attr((int)$left_right_padding+21);?>px;
            }

            <?php echo esc_attr('.'.$id); ?>.fade-square{
                color: <?php echo esc_attr($button_color); ?>;
            }

            <?php echo esc_attr('.'.$id); ?>.fade-square:hover{
                color: <?php echo esc_attr($button_hover_color); ?>;
            }

            <?php echo esc_attr('.'.$id); ?>.fade-square:hover{
                background-color: <?php echo esc_attr($button_color); ?>;
                border-color: <?php echo esc_attr($button_color); ?>;
            }

        <?php } ?>

        /* Fade & Fill Oval */

        <?php if( strstr($class, 'fade-oval') || strstr($class,'fill-oval')) {

            $btnName  = (strstr($class, 'fade-oval'))?'.fade-oval':'.fill-oval';

            if ($button_size == 'standard'){
                $paddingTop =  ($button_icon_class == 'icon-empty') ? 17 : 14;
            }else{
                $paddingTop =  ($btnName == '.fade-oval') ? 10 : 11;
            }

            echo esc_attr('#'.$id); ?>.shortcode-btn .button-standard<?php echo esc_attr($btnName)?>{
                padding: <?php echo esc_attr($paddingTop).'px '.esc_attr((int)$left_right_padding+24);?>px;
            }

            <?php echo esc_attr('#'.$id); ?>.shortcode-btn .button-small<?php echo esc_attr($btnName)?>{
                padding: <?php echo esc_attr($paddingTop).'px '. esc_attr((int)$left_right_padding+15);?>px;
            }

            <?php echo esc_attr('.'.$id).' '.esc_attr($btnName); ?>{
                color: <?php echo esc_attr($button_color); ?>;
            }

             <?php if (strstr($class, 'fade-oval')){ ?>
                <?php echo esc_attr('.'.$id); ?>.fade-oval{
                    color: <?php echo esc_attr($button_color); ?>;
                }

                <?php echo esc_attr('.'.$id); ?>.fade-oval:hover{
                    background-color: <?php echo esc_attr($button_color); ?>;
                    border-color: <?php echo esc_attr($button_color); ?>;
                    color: <?php echo esc_attr($button_hover_color); ?>;
                }
            <?php } else{?>
                <?php echo esc_attr('#'.$id); ?>.shortcode-btn .fill-oval{
                    background-color: <?php echo esc_attr($button_color) ?>;
                    color: <?php echo esc_attr($button_text_color) ?>;
                    border: none;
                }

                <?php echo esc_attr('#'.$id); ?>.shortcode-btn .fill-oval:hover{
                    background-color: <?php echo esc_attr($button_hover_bg_color) ?>;
                    color: <?php echo esc_attr($button_hover_color) ?>;
                    border: none;
                }
            <?php } ?>


        <?php } ?>


        /* Slide */

        <?php if( strstr($class, 'slide') ) { ?>

            <?php echo esc_attr('.'.$id); ?>.slide{
                color: <?php echo esc_attr($button_color); ?>;
            }

            <?php echo esc_attr('.'.$id); ?>.slide span{
                color: <?php echo esc_attr($button_hover_color); ?>;
            }

            <?php echo esc_attr('.'.$id); ?>.slide:hover .button-icon{
                color: <?php echo esc_attr($button_hover_color); ?>;
            }

            <?php echo esc_attr('.'.$id); ?>.slide:hover{
                background-color: <?php echo esc_attr($button_color); ?>;
                border-color: <?php echo esc_attr($button_color); ?>;
            }

        <?php } ?>

        /* Come In */

        <?php if( strstr($class, 'come-in') || strstr($class,'fill-rectangle') ) {
            if ($button_size == 'standard'){
              if (strstr($class, 'come-in')){
                $paddingTop =  ($button_icon_class == 'icon-empty') ? 15 : 12;
              }else
                $paddingTop =  ($button_icon_class == 'icon-empty') ? 18 : 15;

            }else{
                 $paddingTop =  (strstr($class, 'come-in')) ? 10 : 12;
             }
         ?>
            <?php echo esc_attr('#'.$id); ?>.shortcode-btn .button-standard.come-in,
            <?php echo esc_attr('#'.$id); ?>.shortcode-btn .button-standard.fill-rectangle{
                padding: <?php echo esc_attr($paddingTop).'px '. esc_attr((int)$left_right_padding+32);?>px;
            }

            <?php echo esc_attr('#'.$id); ?>.shortcode-btn .button-small.come-in,
            <?php echo esc_attr('#'.$id); ?>.shortcode-btn .button-small.fill-rectangle{
                padding: <?php echo esc_attr($paddingTop).'px '. esc_attr((int)$left_right_padding+29);?>px;
            }

            <?php echo esc_attr('.'.$id); ?>.come-in,
            <?php echo esc_attr('.'.$id); ?>.fill-rectangle{
                color: <?php echo esc_attr($button_color); ?>;
            }

        <?php if( strstr($class, 'come-in')){ ?>

            <?php echo esc_attr('.'.$id); ?>.come-in:after{
                background-color: <?php echo esc_attr($button_color); ?>;
            }

            <?php echo esc_attr('.'.$id); ?>.come-in:hover span,
            <?php echo esc_attr('.'.$id); ?>.come-in:hover .button-icon{
                color: <?php echo esc_attr($button_hover_color); ?>;
            }
        <?php }else{ ?>
            <?php echo esc_attr('.'.$id); ?>.fill-rectangle{
                background-color: <?php echo esc_attr($button_color); ?>;
                color: <?php echo esc_attr($button_text_color) ?>;
                border: none;
            }

            <?php echo esc_attr('.'.$id); ?>.fill-rectangle:hover{
                background-color: <?php echo esc_attr($button_hover_bg_color); ?>;
                color: <?php echo esc_attr($button_hover_color); ?>;
                border: none;
            }


        <?php } ?>

        <?php } ?>

        /* Animation */

        <?php
        if( strstr($class, 'animation') ){
            $button_color = pixflow_colorConvertor($button_color, 'rgb');
        ?>

        <?php echo esc_attr('#'.$id); ?>.shortcode-btn .button-standard.animation{
            padding: 12px <?php echo esc_attr((int)$left_right_padding+26);?>px 12px <?php echo esc_attr((int)$left_right_padding+35);?>px;
        }
        <?php echo esc_attr('#'.$id); ?>.shortcode-btn .button-small.animation {
            padding: 11px <?php echo esc_attr((int)$left_right_padding+28);?>px;
        }

        <?php echo esc_attr('.'.$id); ?>.animation:after{
            background-color : <?php echo esc_attr($button_color); ?>;
        }

        <?php echo esc_attr('.'.$id); ?>.animation{
            color: <?php echo pixflow_colorConvertor($button_color,'rgba',.7); ?>;
        }

        <?php echo esc_attr('.'.$id); ?>.animation:hover{
            color: <?php echo esc_attr(pixflow_colorConvertor($button_color,'rgba', 1)); ?>;
            border-color: <?php echo esc_attr(pixflow_colorConvertor($button_color,'rgba', 1)); ?>;
        }

        <?php } ?>

        /* Flash Animate */

        <?php if( strstr($class, 'flash-animate') ){
            $paddingTop =  ($button_icon_class == 'icon-empty') ? 14 : 12;
        ?>

        <?php echo esc_attr('#'.$id); ?>.shortcode-btn .button-small.flash-animate{
            padding: <?php echo esc_attr($paddingTop) . 'px '.esc_attr((int)$left_right_padding+13);?>px 10px <?php echo esc_attr((int)$left_right_padding+23);?>px;
        }

        <?php echo esc_attr('#'.$id); ?>.shortcode-btn .button-standard.flash-animate{
            padding: 12px <?php echo esc_attr((int)$left_right_padding+13);?>px 12px <?php echo esc_attr((int)$left_right_padding+23);?>px;
        }

        <?php echo esc_attr('.'.$id); ?>.flash-animate{
            color : <?php echo esc_attr($button_color); ?>;
        }

        <?php echo esc_attr('#'.$id); ?>.shortcode-btn .button-standard.flash-animate:hover{
            padding-right: <?php echo esc_attr((int)$left_right_padding+30);?>px;
        }

        <?php echo esc_attr('#'.$id); ?>.shortcode-btn .button-small.flash-animate:hover{
            padding-right: <?php echo esc_attr((int)$left_right_padding+29);?>px;
        }



        <?php } ?>


    </style>

    <div id="<?php echo esc_attr($id);?>" class="shortcode-btn <?php echo esc_attr($animation['has-animation']); ?>" <?php echo esc_attr($animation['animation-attrs']); ?>>
        <?php if( strstr($class, 'fade-square') || strstr($class, 'fade-oval') ||strstr($class, 'fill-oval') || strstr($class, 'slide') || strstr($class, 'come-in') || strstr($class, 'fill-rectangle') )
        { ?>

            <a class="<?php echo esc_attr($class); echo ' ' . esc_attr($id); ?>" href="<?php echo esc_url($button_url); ?>" target="<?php echo esc_attr($button_target); ?>" >
                <?php if ($button_icon_class != 'icon-empty') { ?>
                    <i class="button-icon <?php echo esc_attr($button_icon_class); ?>"></i>
                <?php } ?>
                <span>
                    <?php echo esc_attr($button_text); ?>
                </span>
            </a>

        <?php } else { ?>

            <a class="<?php echo esc_attr($class); echo ' ' . esc_attr($id); ?>" href="<?php echo esc_url($button_url); ?>" target="<?php echo esc_attr($button_target); ?>" >
                <span>
                    <?php echo esc_attr($button_text); ?>
                </span>
                <?php if ($button_icon_class != 'none'){ ?>
                    <i class="button-icon <?php echo esc_attr($button_icon_class); ?>"></i>
                <?php } ?>
            </a>

        <?php } ?>

    </div> <!-- End wrap button -->
    <?php if(true == $clearfix){ ?>
    <div class="clearfix"></div>
    <?php } ?>
    <?php if($button_align == 'center'){ ?>
    <script>

        "use strict";

        var $ = (jQuery),
            $button = $('#<?php echo esc_attr($id) ?>');

        $button.parents('.wpb_wrapper').css({'text-align':'center'});

    </script>

    <?php }?>


    <?php if (strstr($class, 'slide') ) { ?>
        <script>

            "use strict";

            var $ = (jQuery),
                $btnIdSlide = $('<?php echo "." . esc_attr($id) ?>');

            if ( $btnIdSlide.length )
                $btnIdSlide.attr("data-width", "<?php echo "." . esc_attr($id) ?>");

            if ( typeof pixflow_btnSlide == 'function' )
            {
                pixflow_btnSlide( "<?php echo esc_attr($id) ?>" );
            }

        </script>
    <?php } ?>

    <?php
    return ob_get_clean();
}

function pixflow_sc_button($atts, $content = null)
{

    extract(shortcode_atts(array(
        'button_style'       => 'fade-square',
        'button_text'        => 'Read More',
        'button_icon_class'  => 'icon-Layers',
        'button_url'         => '#',
        'button_target'      => '_self',
        'button_align'       => 'left',
        'button_size'        => 'standard',
        'button_color'       => '#000',
        'button_text_color'  => '#fff',
        'button_bg_hover_color' => '#9b9b9b',
        'button_hover_color' => '#fff',
        'left_right_padding' => '0',
    ), $atts));

    $animation = array();
    $animation = pixflow_shortcodeAnimation('md_button',$atts);

    $output = pixflow_buttonMaker($button_style,$button_text,$button_icon_class,$button_url,$button_target,$button_align,$button_size,$button_color,$button_hover_color,$left_right_padding,$button_text_color,$button_bg_hover_color,$animation);
    $output .= pixflow_callAnimation(true);
    return $output;
}

/*-----------------------------------------------------------------------------------*/
/*  Full width button
/*-----------------------------------------------------------------------------------*/
function pixflow_sc_full_button($atts, $content = null)
{

    extract(shortcode_atts(array(
        'full_button_height'        => '90',
        'full_button_text'        => esc_attr__('Read more','massive-dynamic'),
        'full_button_text_size'        => '19',
        'full_button_heading'        => 'h3',
        'full_button_hover_letter_spacing'  => '2',
        'full_button_url'  => '#',
        'full_button_target'  => '_self',
        'full_button_bg_color'  => '#202020',
        'full_button_text_color'  => '#FFF',
        'full_button_bg_hover_color'  => '#3E005D',
        'full_button_hover_color'  => '#FFF',
    ), $atts));

    $animation = array();
    $animation = pixflow_shortcodeAnimation('md_full_button',$atts);
    $id = pixflow_sc_id('textbox');

    ob_start(); ?>

    <style scoped="scoped">
        <?php echo '.'.esc_attr($id) ?>{
          height: <?php echo esc_attr($full_button_height); ?>px;
          background-color: <?php echo esc_attr($full_button_bg_color); ?>;
        }
        <?php echo '.'.esc_attr($id) ?>:hover{
          background-color: <?php echo esc_attr($full_button_bg_hover_color); ?>;
        }
        <?php echo '.'.esc_attr($id) ?> <?php echo esc_attr($full_button_heading); ?>{
          font-size: <?php echo esc_attr($full_button_text_size); ?>px;
          color: <?php echo esc_attr($full_button_text_color); ?>;
          transition: 0.3s; /*don't move or remove this line*/
        }
        <?php echo '.'.esc_attr($id) ?>:hover <?php echo esc_attr($full_button_heading); ?>{
          letter-spacing: <?php echo esc_attr($full_button_hover_letter_spacing); ?>px;
          color: <?php echo esc_attr($full_button_hover_color); ?>;
        }
    </style>

    <div class="full-width-button <?php echo esc_attr($id.' '.$animation['has-animation']); ?>" <?php echo esc_attr($animation['animation-attrs']); ?>>
      <a href="<?php echo esc_url($full_button_url); ?>" target="<?php echo esc_attr($full_button_target); ?>">
        <<?php echo esc_attr($full_button_heading); ?> class="title">
          <?php echo esc_attr($full_button_text); ?>
        </<?php echo esc_attr($full_button_heading); ?>>
      </a>
    </div>

    <?php pixflow_callAnimation(true); ?>

    <?php
    return ob_get_clean();
}


/*-----------------------------------------------------------------------------------*/
/*  Call To Action
/*-----------------------------------------------------------------------------------*/


function pixflow_sc_callToAction( $atts, $content = null ) {
    extract(shortcode_atts(array(
        'call_to_action_title'             => 'Are you looking for job?',
        'call_to_action_heading'           => 'h1',
        'call_to_action_heading_color'     => 'rgb(255,255,255)',
        'call_to_action_description'       => 'We are a fairly small, flexible design studio that designs for print and web. We work flexibly with Send us your resume & portfolio',
        'call_to_action_description_color' => 'rgb(255,255,255)',
        'call_to_action_background_type'   => 'color_background',
        'call_to_action_background_color'  => 'rgb(37,37,37)',
        'call_to_action_background_image'  => '',
        'call_to_action_button_style'      => 'animation',
        'call_to_action_button_text'       => 'READ MORE',
        'call_to_action_button_icon_class' => 'icon-angle-right',
        'call_to_action_button_size'       => 'standard',
        'call_to_action_button_color'      => 'rgb(255,255,255)',
        'call_to_action_button_text_color' => 'rgb(255,255,255)',
        'call_to_action_button_bg_hover_color' => '#9b9b9b',
        'call_to_action_button_hover_color'=> '#fff',
        'call_to_action_button_url'        => '#',
        'call_to_action_button_target'     => '_self',
        'call_to_action_left_right_padding' => '0',
    ), $atts));
    $animation = array();
    $animation = pixflow_shortcodeAnimation('md_call_to_action',$atts);
    $id = pixflow_sc_id('call-to-action');
    $buttonSize = strtolower('button-'.$call_to_action_button_size);
    ob_start();
?>
    <style scoped="scoped">

        <?php if($call_to_action_background_type == 'color_background'){ ?>

        .<?php echo esc_attr($id) ?>{
            background-color : <?php echo esc_attr($call_to_action_background_color); ?>;
        }

        <?php }
        else if($call_to_action_background_type == 'image_background'){
            if (is_numeric($call_to_action_background_image)) {
                $imageSrc = wp_get_attachment_url($call_to_action_background_image);
                $imageSrc = (false == $imageSrc)?PIXFLOW_PLACEHOLDER1:$imageSrc;
                $call_to_action_background_image = $imageSrc;
            }
            ?>
            .<?php echo esc_attr($id) ?>{
                background-image : url("<?php echo esc_url($call_to_action_background_image); ?>");
            }
        <?php }
        else{ ?>

        .<?php echo esc_attr($id) ?>{
            background : transparent;
        }
        <?php }?>


        <?php if($buttonSize == 'button-standard'){ ?>
            .<?php echo esc_attr($id) ?> .button-parent {
                height: 50px;
                margin-top: -20px;
            }
        <?php } else{
                echo ".".esc_attr($id) ?> .button-parent {
                    height: 40px;
                    margin-top: -15px;
                }
        <?php } ?>

        .<?php echo esc_attr($id) ?>  .title {
            color: <?php echo esc_attr($call_to_action_heading_color); ?>;
        }

        .<?php echo esc_attr($id) ?> .description{
            color: <?php echo esc_attr($call_to_action_description_color); ?>;
        }
    </style>
    <div class="call-to-action <?php echo esc_attr($id.' '.$animation['has-animation']); ?>" <?php echo esc_attr($animation['animation-attrs']); ?>>
        <div class="">
            <div class="content clearfix">
                <<?php echo esc_attr($call_to_action_heading); ?> class="title"><?php echo esc_attr($call_to_action_title); ?></<?php echo esc_attr($call_to_action_heading); ?>>
                <p class="description"><?php echo preg_replace("/&lt;(.*?)&gt;/i",'',esc_attr($call_to_action_description)); ?></p>
                <div class="button-parent">
                    <?php echo pixflow_buttonMaker($call_to_action_button_style,$call_to_action_button_text,$call_to_action_button_icon_class,$call_to_action_button_url,$call_to_action_button_target,'right',$call_to_action_button_size,$call_to_action_button_color,$call_to_action_button_hover_color,$call_to_action_left_right_padding,$call_to_action_button_text_color,$call_to_action_button_bg_hover_color); ?>
                </div>
            </div>
        </div>
    </div> <!-- Call to Action ends -->
    <?php
    pixflow_callAnimation(true);
    return ob_get_clean();
}

/*-----------------------------------------------------------------------------------*/
/*  Accordion
/*-----------------------------------------------------------------------------------*/

function pixflow_sc_accordion( $atts, $content = null )
{

    wp_enqueue_script('jquery-ui-accordion');
    $output = $title = $interval = $el_class=$main_color=$hover_color = $collapsible = $disable_keyboard = $active_tab=$heading_size=$theme_style = '';
    extract(shortcode_atts(array(
        'title'            => '',
        'interval'         => '',
        'el_class'         => '',
        'collapsible'      => '',
        'disable_keyboard' => '',
        'active_tab'       => '1',
        'theme_style'      => 'with_border',
        'main_color'       => 'rgb(0,0,0)',
        'hover_color'      => 'rgb(220,220,220)',
    ), $atts));

    $animation = array();
    $animation = pixflow_shortcodeAnimation('md_accordion',$atts);
    $id = pixflow_sc_id('md_accordion');
    //define accordion type classes
    $acc_class = "";

    switch($theme_style) {
        case "with_border":
            $acc_class = "with_border";
            break;
        case "without_border":
            $acc_class = "without_border";
            break;
    }

    $main_color = esc_attr($main_color);
    ob_start();?>

    <style scoped="scoped">
        .<?php echo esc_attr($id);?>.with_border .wpb_accordion_wrapper h3:hover a,
        .<?php echo esc_attr($id);?>.with_border .wpb_accordion_wrapper h3:hover span {
            color:<?php echo esc_attr($main_color) ?>!important;
        }
        .<?php echo esc_attr($id);?>.with_border .wpb_accordion_wrapper h3:after {
            background: <?php echo esc_attr($hover_color); ?>;
        }
        .<?php echo esc_attr($id);?>.with_border{
            border: 1px solid <?php echo esc_attr($main_color) ?>;
            border-bottom: none;
        }

        .<?php echo esc_attr($id);?> .wpb_accordion_section{
            border-bottom: 1px solid <?php echo esc_attr(pixflow_colorConvertor($main_color,'rgba',.6)) ?>;
        }

        /* with border */
        .<?php echo esc_attr($id);?>.with_border .wpb_accordion_wrapper h3.wpb_accordion_header a,
        .<?php echo esc_attr($id);?>.with_border .wpb_accordion_wrapper h3.wpb_accordion_header span,
        .<?php echo esc_attr($id);?>.with_border .wpb_accordion_section .icon{
            color: <?php echo esc_attr($main_color) ?>;
            z-index: 99;
            position: absolute;
        }
        .<?php echo esc_attr($id);?>.with_border .wpb_accordion_section h3.wpb_accordion_header.ui-state-active{
            background: <?php echo esc_attr($hover_color); ?>!important;
        }
        .<?php echo esc_attr($id);?>.with_border .wpb_accordion_section h3.wpb_accordion_header.ui-state-active a,
        .<?php echo esc_attr($id);?>.with_border .wpb_accordion_wrapper h3.ui-state-active span{
            color:<?php echo esc_attr($main_color); ?>!important;
        }
        .<?php echo esc_attr($id);?>.with_border .wpb_accordion_wrapper h3.ui-state-active a,
        .<?php echo esc_attr($id);?>.with_border .wpb_accordion_wrapper h3.ui-state-active span{
            color:<?php echo esc_attr($hover_color); ?>;
        }
        .<?php echo esc_attr($id);?>.with_border .wpb_accordion_wrapper h3.ui-state-active:hover a,
        .<?php echo esc_attr($id);?>.with_border .wpb_accordion_wrapper h3.ui-state-active:hover span{
            color:<?php echo esc_attr($main_color); ?>;
        }

        /* without border */

        .<?php echo esc_attr($id);?>.without_border .wpb_accordion_wrapper h3.wpb_accordion_header a,
        .<?php echo esc_attr($id);?>.without_border .wpb_accordion_wrapper h3.wpb_accordion_header span,
        .<?php echo esc_attr($id);?>.without_border .wpb_accordion_section .icon{
            color: <?php echo esc_attr($main_color) ?>;
        }
        .<?php echo esc_attr($id);?>.without_border .wpb_accordion_wrapper h3:hover a,
        .<?php echo esc_attr($id);?>.without_border .wpb_accordion_wrapper h3:hover span {
            color: <?php echo esc_attr($hover_color); ?>;
        }

    </style>

    <?php
    $output .= ob_get_clean();
    $css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_accordion '.$id.' wpb_content_element '. $acc_class .' '. $el_class . ' not-column-inherit '.esc_attr($animation['has-animation']), 'md_accordion', $atts);
    $output .= "\n\t" . '<div class="' . $css_class . '" data-collapsible="' . $collapsible . '" data-vc-disable-keydown="' . (esc_attr(('yes' == $disable_keyboard ? 'true' : 'false'))) . '" data-active-tab="' . $active_tab . '"'. esc_attr($animation['animation-attrs']) .'>'; //data-interval="'.$interval.'"
    $output .= "\n\t\t" . '<div class="wpb_wrapper wpb_accordion_wrapper ui-accordion">';
    $output .= wpb_widget_title(array('title' => $title, 'extraclass' => 'wpb_accordion_heading'));

    $output .= "\n\t\t\t" . wpb_js_remove_wpautop($content);

    $output .= "\n\t\t" . '</div> ';
    $output .= "\n\t" . '</div> ';
    ob_start();
    ?>

    <script type="text/javascript">

        var <?php echo str_replace('-','_',$id);?>_saveBtnClicked = false,
            $ = jQuery;

        $(function(){

            $('body').on('click','.wpb_accordion_header a:last',function(e){
                e.preventDefault();
            })
            $('body',window.parent.document).on('click','.vc_panel-btn-save',function(e){
                <?php echo str_replace('-','_',$id);?>_saveBtnClicked = true;
            })
            $('body').on('click','.wpb_accordion_header',function(e){
                if(<?php echo str_replace('-','_',$id);?>_saveBtnClicked){
                    <?php echo str_replace('-','_',$id);?>_saveBtnClicked=false;
                    try {
                        $(this).closest('.wpb_accordion').accordion("destroy");
                        vc_iframe.buildAccordion( $(this).closest('.wpb_accordion'), '<?php echo esc_attr($active_tab); ?>');
                    }catch(e){}
                }
            })
        })

        $('.<?php echo esc_attr($id); ?> .wpb_accordion_header').removeClass('ui-state-active');
        $('.<?php echo esc_attr($id); ?> .wpb_accordion_content').slideUp();

        <?php
            $active_tab = trim($active_tab);
            $active_tab = (int)$active_tab;
        ?>

        $('.<?php echo esc_attr($id)?>').find('.wpb_accordion_content').eq(<?php echo esc_attr($active_tab)-1; ?>).slideDown().parent().find('.wpb_accordion_header').addClass('ui-state-active');
        <?php pixflow_callAnimation();  ?>

    </script>
    <?php

    $output.=ob_get_clean();
    return $output;
}

/*-----------------------------------------------------------------------------------*/
/*  Accordion Tab
/*-----------------------------------------------------------------------------------*/

function pixflow_sc_accordion_tab( $atts, $content = null ) {
    $output = $title = $el_id =$icon = '';

    extract( shortcode_atts( array(
        'title'       => 'Section',
        'el_id'       => '',
        'icon'        => 'icon-laptop',
    ), $atts ) );

    $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_accordion_section group', 'md_accordion_tab', $atts );
    $id= pixflow_sc_id('acc_section');
    $output .= "\n\t\t\t" . '<div id="'.$id.'" class="'.$css_class.'">';
    $output .= "\n\t\t\t\t" . '<h3 class="wpb_accordion_header ui-accordion-header"><div class="icon_left"><span class="icon '.$icon.'"></span></div><a href="#'.sanitize_title($title).'" onclick="return false">'.$title.'</a></h3>';

    $output .= "\n\t\t\t\t" . '<div class="wpb_accordion_content ui-accordion-content vc_clearfix">';
    $output .= ($content=='' || $content==' ') ? esc_attr__("Empty section. Edit page to add content here.", 'massive-dynamic') : "\n\t\t\t\t" . wpb_js_remove_wpautop($content);
    $output .= "\n\t\t\t\t" . '</div>';
    $output .= "\n\t\t\t" . '</div> '. "\n";

    ob_start();
    ?>

    <script type="text/javascript">
        var $ = jQuery;

        $(function(){

            if($('body').hasClass('vc_editor')){
                $('#<?php echo esc_attr($id); ?>').closest('.vc_md_accordion').find('.md-accordion-add-tab').remove();
                var addSectionBtn = $('<a style="cursor: pointer;padding:5px 10px; width:100%;background-color: #ddd" class="md-accordion-add-tab vc_control-btn"><strong>+</strong>Add new tab</a>');
                $('#<?php echo esc_attr($id); ?>').closest('.vc_md_accordion').find('.wpb_accordion_section').last().append(addSectionBtn);
                $('#<?php echo esc_attr($id); ?>').closest('.vc_md_accordion').find('.md-accordion-add-tab').click(function(e){
                    e.preventDefault();
                    $(this).parent().parent().find('a.vc_control-btn[title="Add new Section"] .vc_btn-content').last().click();
                })
            }

            // Remove padding if icon does not exist
            if ( $('#<?php echo esc_attr($id); ?>').find('.icon').hasClass('icon-empty') ) {
                $('#<?php echo esc_attr($id); ?>').find('h3').css('padding', '0');
            }
        })

        // Centerize text and icons
        $(window).load(function(){

            $('#<?php echo esc_attr($id); ?>').find('h3').find('> a').css('line-height', '30px');
            $('#<?php echo esc_attr($id); ?>').find('h3').find('.icon_left').css('margin', '27px 0 0 15px');
            $('#<?php echo esc_attr($id); ?>').find('h3').find('> span').css('line-height', '30px');
        })

    </script>

    <?php
    $output.=ob_get_clean();
    return $output;
}

/*-----------------------------------------------------------------------------------*/
/*  Toggle
/*-----------------------------------------------------------------------------------*/

function pixflow_sc_toggle( $atts, $content = null )
{
    wp_enqueue_script('multi-open-accordion');
    $output = $title = $interval = $heading_size=$el_class = $collapsible =$theme_style=$main_color= $hover_color=$disable_keyboard = $active_tab = '';
    extract(shortcode_atts(array(
        'el_class'         => '',
        'active_tab'       => '1',
        'theme_style'      => 'with_border',
        'main_color'       => 'rgb(0,0,0)',
        'hover_color'      => 'rgb(220,220,220)',
    ), $atts));
    $animation = array();
    $animation = pixflow_shortcodeAnimation('md_toggle',$atts);
    $id = pixflow_sc_id('md_toggle');

    //define accordion type classes
    $acc_class = "";
    $active_tab = explode(",",$active_tab);
    switch($theme_style) {
        case "with_border":
            $acc_class = "with_border";
            break;
        case "without_border":
            $acc_class = "without_border";
            break;
    }

    ob_start();?>

    <style scoped="scoped">
        .<?php echo esc_attr($id);?>.with_border h3:hover a,
        .<?php echo esc_attr($id);?>.with_border h3:hover span {
            color :<?php echo esc_attr($hover_color); ?>!important;
        }
        .<?php echo esc_attr($id);?>.with_border h3:after {
            background: <?php echo esc_attr($main_color); ?>;
        }
        .<?php echo esc_attr($id);?>.with_border{
            border: 1px solid <?php echo esc_attr($main_color); ?>;
            border-bottom: none;
        }

        .<?php echo esc_attr($id);?> .wpb_accordion_section{
            border-bottom: 1px solid <?php echo esc_attr(pixflow_colorConvertor($main_color,'rgba',.6)); ?>;
        }

        /* with border */
        .<?php echo esc_attr($id);?>.with_border h3.wpb_toggle_header a,
        .<?php echo esc_attr($id);?>.with_border h3.wpb_toggle_header span,
        .<?php echo esc_attr($id);?>.with_border .wpb_accordion_section .icon{
            color: <?php echo esc_attr($main_color); ?>;
            z-index: 99;
            position: absolute;
        }
        .<?php echo esc_attr($id);?>.with_border .wpb_accordion_section h3.wpb_toggle_header.ui-state-active{
            color :<?php echo esc_attr($hover_color); ?>!important;
            background: <?php echo esc_attr($main_color); ?>!important;
        }
        .<?php echo esc_attr($id);?>.with_border .wpb_accordion_section h3.wpb_toggle_header.ui-state-active a,
        .<?php echo esc_attr($id);?>.with_border .wpb_toggle_wrapper h3.ui-state-active span{
            color:<?php echo esc_attr($hover_color); ?>!important;
        }
        .<?php echo esc_attr($id);?>.with_border h3.ui-state-active a,
        .<?php echo esc_attr($id);?>.with_border h3.ui-state-active span{
            color:<?php echo esc_attr($hover_color); ?>;

        }
        .<?php echo esc_attr($id);?>.with_border h3.ui-state-active:hover a,
        .<?php echo esc_attr($id);?>.with_border h3.ui-state-active:hover span{
            color:<?php echo esc_attr($hover_color); ?>;
        }

        /* without border */

        .<?php echo esc_attr($id);?>.without_border h3.wpb_toggle_header a,
        .<?php echo esc_attr($id);?>.without_border h3.wpb_toggle_header span,
        .<?php echo esc_attr($id);?>.without_border .wpb_accordion_section .icon{
            color: <?php echo esc_attr($main_color); ?>;
            z-index: 99;
            position: absolute;
        }
        .<?php echo esc_attr($id);?>.without_border h3:hover a,
        .<?php echo esc_attr($id);?>.without_border .wpb_accordion_section h3:hover span {
            color: <?php echo esc_attr($hover_color); ?>;
        }

    </style>
    <?php
    $output .= ob_get_clean();
    $css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_md_toggle '.$id.' wpb_content_element '. $acc_class .' '. $el_class . ' not-column-inherit '.esc_attr($animation['has-animation']), 'md_toggle', $atts);
    $output .= "\n\t" . '<div id="'.$id.'" class="' . $css_class . '" data-collapsible="' . $collapsible . '" data-vc-disable-keydown="' . (esc_attr(('yes' == $disable_keyboard ? 'true' : 'false'))) . '"'. esc_attr($animation['animation-attrs']) .'>'; //data-interval="'.$interval.'"
    $output .= "\n\t\t" . '<div class="wpb_wrapper wpb_toggle_wrapper ui-accordion">';
    $output .= wpb_widget_title(array('title' => $title, 'extraclass' => 'wpb_toggle_heading'));

    $output .= "\n\t\t\t" . wpb_js_remove_wpautop($content);
    $output .= "\n\t\t" . '</div> ';
    $output .= "\n\t" . '</div> ';
    ob_start();
    ?>
    <script type="text/javascript">
        var <?php echo str_replace('-','_',$id);?>_saveBtnClicked = false;
        var $ = jQuery;
        if(typeof toggle == 'undefined')
            var toggle = false;
        $(function() {

            $('body').on('click', '.wpb_toggle_header a:last', function (e) {
                e.preventDefault();
            })
            $('body', window.parent.document).on('click', '.vc_panel-btn-save', function (e) {
                <?php echo str_replace('-','_',$id);?>_saveBtnClicked = true;
            })
            if (toggle == false){
                $('body').not('.vc_editor').on('click', '.wpb_toggle_header', function (e) {
                    $(this).parent().find(' > .wpb_toggle_content ').slideToggle();
                    if ($(this).hasClass('ui-state-active')) {
                        $(this).removeClass('ui-state-active').find('.ui-icon-triangle-1-e').removeClass('.ui-icon-triangle-1-e').addClass('.ui-icon-triangle-1-s');
                    } else {
                        $(this).addClass('ui-state-active').find('.ui-icon-triangle-1-s').removeClass('.ui-icon-triangle-1-s').addClass('.ui-icon-triangle-1-e');
                    }
                })
                toggle=true;
            }
            $('#<?php echo esc_attr($id); ?> .wpb_toggle_header').removeClass('ui-state-active');
            $('#<?php echo esc_attr($id); ?> .wpb_toggle_content').slideUp();
            <?php
            foreach($active_tab as $active){
                $active = trim($active);
                $active = (int)$active;
                if($active==0) continue;
            ?>
            $('.<?php echo esc_attr($id)?>').find('.wpb_toggle_content').eq(<?php echo esc_attr($active)-1; ?>).slideDown().parent().find('.wpb_toggle_header').addClass('ui-state-active');
            <?php
            }
            ?>

    })
    <?php pixflow_callAnimation(); ?>
</script>
<?php
$output.=ob_get_clean();
return $output;
}

/*-----------------------------------------------------------------------------------*/
/*  Toggle Tab
/*-----------------------------------------------------------------------------------*/

function pixflow_sc_toggle_tab( $atts, $content = null ) {
$output = $title = $el_id = $icon = $heading_size='';

extract( shortcode_atts( array(
    'title'        => 'Section',
    'el_id'        => '',
    'icon'         => 'icon-laptop',
), $atts ) );

    $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_accordion_section group', 'md_toggle_tab', $atts );
    $id= pixflow_sc_id('toggle_section');
    $style = '';
    if($icon == 'icon-empty'){
        $style = 'style="padding-left:0"';
    }
    $output .= "\n\t\t\t" . '<div class="'.$css_class.'" id="'.$id.'">';
    $output .= "\n\t\t\t\t" . '<h3 class="wpb_toggle_header" '.$style.'>
                                    <span class="ui-accordion-header-icon ui-icon ui-icon-triangle-1-s"></span>
                                    <div class="icon_left">
                                        <span class="icon '.$icon.'"></span>
                                    </div>
                                    <a href="#'.sanitize_title($title).'" onclick="return false">'.$title.'</a>
                                </h3>';

    $output .= "\n\t\t\t\t" . '<div class="wpb_toggle_content ui-accordion-content vc_clearfix">';
    $output .= ($content=='' || $content==' ') ? esc_attr__("Empty section. Edit page to add content here.", 'massive-dynamic') : "\n\t\t\t\t" . wpb_js_remove_wpautop($content);
    $output .= "\n\t\t\t\t" . '</div>';
    $output .= "\n\t\t\t" . '</div> '. "\n";
    ob_start();
    ?>
    <script type="text/javascript">
        var $ = jQuery;
        $(function(){
            if($('body').hasClass('vc_editor')){
                $('#<?php echo esc_attr($id); ?>').closest('.vc_md_toggle').find('.md-toggle-add-tab').remove();
                $('#<?php echo esc_attr($id); ?>').closest('.vc_md_toggle').find('.wpb_accordion_section').last().append('<a style="cursor: pointer;padding:5px 10px; width:100%;background-color: #ddd" class="md-toggle-add-tab vc_control-btn"><strong>+</strong>Add new tab</a>');
                $('#<?php echo esc_attr($id); ?>').closest('.vc_md_toggle').find('.md-toggle-add-tab').click(function(e){
                    e.preventDefault();
                    $(this).parent().parent().find('a.vc_control-btn[title="Add new Section"] .vc_btn-content').last().click();
                })
            }

        })
    </script>
    <?php
    $output.=ob_get_clean();
    return $output;

}

/*-----------------------------------------------------------------------------------*/
/*  Business Toggle
/*-----------------------------------------------------------------------------------*/

function pixflow_sc_toggle2( $atts, $content = null )
{
    wp_enqueue_script('multi-open-accordion');
    $output = $title = $interval = $heading_size=$el_class = $collapsible = $main_color= $hover_color=$disable_keyboard = $active_tab = '';
    extract(shortcode_atts(array(
        'el_class'         => '',
        'active_tab'       => '',
        'main_color'       => 'rgb(0,0,0)',
        'hover_color'      => 'rgb(255,255,255)',
    ), $atts));
    $animation = array();
    $animation = pixflow_shortcodeAnimation('md_toggle2',$atts);
    $id = pixflow_sc_id('md_toggle2');

    //define accordion type classes
    $acc_class = "";
    $active_tab = explode(",",$active_tab);
    ob_start();?>

    <style scoped="scoped">
        .<?php echo esc_attr($id);?> h3:hover a,
        .<?php echo esc_attr($id);?> h3:hover span {
            color :<?php echo esc_attr($hover_color); ?>!important;
        }
        .<?php echo esc_attr($id);?> h3:hover {
            background: <?php echo esc_attr($main_color); ?>;
        }

        .<?php echo esc_attr($id);?> .wpb_accordion_section h3.wpb_toggle_header{
            border: 2px solid <?php echo esc_attr($main_color); ?>;
        }
        .<?php echo esc_attr($id);?> .wpb_toggle_wrapper h3.wpb_toggle_header span.ui-accordion-header-icon{
            border-right: 2px solid <?php echo esc_attr($main_color); ?>;
        }

        .<?php echo esc_attr($id);?> h3.wpb_toggle_header a,
        .<?php echo esc_attr($id);?> h3.wpb_toggle_header span,
        .<?php echo esc_attr($id);?> .wpb_accordion_section .icon{
            color: <?php echo esc_attr($main_color); ?>;
            z-index: 99;
            position: absolute;
        }
        .<?php echo esc_attr($id);?> .wpb_accordion_section h3.wpb_toggle_header.ui-state-active{
            color :<?php echo esc_attr($hover_color); ?>!important;
            background: <?php echo esc_attr($main_color); ?>!important;
        }
        .<?php echo esc_attr($id);?> .wpb_accordion_section h3.wpb_toggle_header.ui-state-active a,
        .<?php echo esc_attr($id);?> .wpb_toggle_wrapper h3.ui-state-active span{
            color:<?php echo esc_attr($hover_color); ?>!important;
        }
        .<?php echo esc_attr($id);?> h3.ui-state-active a,
        .<?php echo esc_attr($id);?> h3.ui-state-active span{
            color:<?php echo esc_attr($hover_color); ?>;

        }
        .<?php echo esc_attr($id);?> h3.ui-state-active:hover a,
        .<?php echo esc_attr($id);?> h3.ui-state-active:hover span{
            color:<?php echo esc_attr($hover_color); ?>;
        }

    </style>
    <?php
    $output .= ob_get_clean();
    $css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_md_toggle2 '.$id.' wpb_content_element '. $el_class . ' not-column-inherit '.esc_attr($animation['has-animation']), 'md_toggle2', $atts);
    $output .= "\n\t" . '<div id="'.$id.'" class="' . $css_class . '" data-collapsible="' . $collapsible . '" data-vc-disable-keydown="' . (esc_attr(('yes' == $disable_keyboard ? 'true' : 'false'))) . '"'. esc_attr($animation['animation-attrs']) .'>'; //data-interval="'.$interval.'"
    $output .= "\n\t\t" . '<div class="wpb_wrapper wpb_toggle_wrapper ui-accordion">';
    $output .= wpb_widget_title(array('title' => $title, 'extraclass' => 'wpb_toggle_heading'));

    $output .= "\n\t\t\t" . wpb_js_remove_wpautop($content);
    $output .= "\n\t\t" . '</div> ';
    $output .= "\n\t" . '</div> ';
    ob_start();
    ?>
    <script type="text/javascript">
        var <?php echo str_replace('-','_',$id);?>_saveBtnClicked = false;
        var $ = jQuery;
        if(typeof toggle == 'undefined')
            var toggle = false;
        $(function() {

            $('body').on('click', '.wpb_toggle_header a:last', function (e) {
                e.preventDefault();
            })
            $('body', window.parent.document).on('click', '.vc_panel-btn-save', function (e) {
                <?php echo str_replace('-','_',$id);?>_saveBtnClicked = true;
            })
            if (toggle == false){
                $('body').not('.vc_editor').on('click', '.wpb_toggle_header', function (e) {
                    $(this).parent().find(' > .wpb_toggle_content ').slideToggle();
                    if ($(this).hasClass('ui-state-active')) {
                        $(this).removeClass('ui-state-active').find('.ui-icon-triangle-1-e').removeClass('.ui-icon-triangle-1-e').addClass('.ui-icon-triangle-1-s');
                    } else {
                        $(this).addClass('ui-state-active').find('.ui-icon-triangle-1-s').removeClass('.ui-icon-triangle-1-s').addClass('.ui-icon-triangle-1-e');
                    }
                })
                toggle=true;
            }
            $('#<?php echo esc_attr($id); ?> .wpb_toggle_header').removeClass('ui-state-active');
            $('#<?php echo esc_attr($id); ?> .wpb_toggle_content').slideUp();
            <?php
            foreach($active_tab as $active){
                $active = trim($active);
                $active = (int)$active;
                if($active==0) continue;
            ?>
            $('.<?php echo esc_attr($id)?>').find('.wpb_toggle_content').eq(<?php echo esc_attr($active)-1; ?>).slideDown().parent().find('.wpb_toggle_header').addClass('ui-state-active');
            <?php
            }
            ?>

        })
        <?php pixflow_callAnimation(); ?>
    </script>
    <?php
    $output.=ob_get_clean();
    return $output;
}

/*-----------------------------------------------------------------------------------*/
/*  Toggle Tab 2 (Business Version)
/*-----------------------------------------------------------------------------------*/

function pixflow_sc_toggle_tab2( $atts, $content = null ) {
    $output = $title = $el_id = $icon = $heading_size='';

    extract( shortcode_atts( array(
        'title'        => 'Section',
        'el_id'        => '',
        'icon'         => 'icon-empty',
    ), $atts ) );

    $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_accordion_section group', 'md_toggle_tab2', $atts );
    $id= pixflow_sc_id('toggle_section2');
    $style = '';
    if($icon == 'icon-empty'){
        $style = 'style="padding-left:0"';
    }
    $output .= "\n\t\t\t" . '<div class="'.$css_class.'" id="'.$id.'">';
    $output .= "\n\t\t\t\t" . '<h3 class="wpb_toggle_header" '.$style.'>
                                    <span class="ui-accordion-header-icon ui-icon ui-icon-triangle-1-s"></span>
                                    <div class="icon_left">
                                        <span class="icon '.$icon.'"></span>
                                    </div>
                                    <a href="#'.sanitize_title($title).'" onclick="return false">'.$title.'</a>
                                </h3>';

    $output .= "\n\t\t\t\t" . '<div class="wpb_toggle_content ui-accordion-content vc_clearfix">';
    $output .= ($content=='' || $content==' ') ? esc_attr__("Empty section. Edit page to add content here.", 'massive-dynamic') : "\n\t\t\t\t" . wpb_js_remove_wpautop($content);
    $output .= "\n\t\t\t\t" . '</div>';
    $output .= "\n\t\t\t" . '</div> '. "\n";
    ob_start();
    ?>
    <script type="text/javascript">
        var $ = jQuery;
        $(function(){
            if($('body').hasClass('vc_editor')){
                $('#<?php echo esc_attr($id); ?>').closest('.vc_md_toggle2').find('.md-toggle2-add-tab').remove();
                $('#<?php echo esc_attr($id); ?>').closest('.vc_md_toggle2').find('.wpb_accordion_section').last().append('<a style="cursor: pointer;padding:5px 10px; width:100%;background-color: #ddd" class="md-toggle2-add-tab vc_control-btn"><strong>+</strong>Add new tab</a>');
                $('#<?php echo esc_attr($id); ?>').closest('.vc_md_toggle2').find('.md-toggle2-add-tab').click(function(e){
                    e.preventDefault();
                    $(this).parent().parent().find('a.vc_control-btn[title="Add new Section"] .vc_btn-content').last().click();
                })
            }

        })
    </script>
    <?php
    $output.=ob_get_clean();
    return $output;

}

/*-----------------------------------------------------------------------------------*/
/*  Display Slider
/*-----------------------------------------------------------------------------------*/

function pixflow_sc_display_slider( $atts, $content = null ) {

    $output = $el_class = $slide_num = '';

    extract( shortcode_atts( array(
        'text_color' => '#000',
        'slide_num' => '3',
        'device_slider_slideshow' => 'yes',
        'align' =>'center'
    ), $atts ) );

    for($i=1; $i<=$slide_num; $i++){
        $slides[$i] = shortcode_atts( array(
            'slide_title_'.$i => '',
            'slide_description_'.$i => '',
            'slide_image_'.$i => PIXFLOW_THEME_IMAGES_URI."/place-holder.jpg",
        ), $atts );
    }
    $animation = array();
    $animation = pixflow_shortcodeAnimation('md_display_slider',$atts);

    $id = pixflow_sc_id('display_slider');
    $func_id = uniqid();

    if( 'yes' == $device_slider_slideshow){
        $slideshow = 'true';
    } else{
        $slideshow = 'false';
    }


    $output .= '<div data-flex-id="'.$id.'" clone="false" class="device-slider '.esc_attr($animation['has-animation']).' md-align-'.esc_attr($align).'" '.esc_attr($animation['animation-attrs']).'>';
    $output .= '<div data-flex-id="'.$id.'" class="flexslider-controls">';
    $output .= '<ol data-flex-id="'.$id.'" class="flex-control-nav">';

    foreach($slides as $key=>$slide){
        $title  = $slide['slide_title_'.$key];
        $decription  = $slide['slide_description_'.$key];
        $image  = $slide['slide_image_'.$key];

        if ($image != '' && is_numeric($image)){
            $imageSrc = wp_get_attachment_image_src( $image, 'pixflow_display-slider') ;
            $imageSrc = (false == $imageSrc)?PIXFLOW_PLACEHOLDER1:$imageSrc[0];
            $image = $imageSrc ;
        }
        if('' != $title) {
            $output .= '<li>' . $title . '</li>';
        }
    }

    $output .= '</ol>' . "\n";
    $output .= '</div>';
    $output .= '<div id="'.$id.'" flex="false" class="flexslider clearfix">';
    $output .= '<ul data-flex-id="'.$id.'" class="slides clearfix">';

    foreach($slides as $key=>$slide){

        $title = $slide['slide_title_'.$key];
        $decription = $slide['slide_description_'.$key];
        $image = $slide['slide_image_'.$key];

        if($image != '' && is_numeric($image)){
            $imageSrc = wp_get_attachment_image_src( $image, 'pixflow_display-slider') ;
            $imageSrc = (false == $imageSrc)?PIXFLOW_PLACEHOLDER1:$imageSrc[0];
            $image = $imageSrc ;
        }

        $output .= '<li>';
        if('' != $decription){
            $output .= '<p class="slide-description">'.preg_replace("/&lt;(.*?)&gt;/i",'',esc_attr($decription)).'</p>';
        }

        $output .= '<div class="mac-frame"></div><div class="slide-image" style="background-image:url(\''.esc_attr($image).'\');"></div>';
        $output .= '</li>';
    }
    $output .= '</ul>';
    $output .= '</div>';
    $output .= '</div>';
    ob_start();
    ?>
    <style scoped="scoped">
        [data-flex-id="<?php echo esc_attr($id); ?>"] .flex-control-nav li,
        #<?php echo esc_attr($id); ?> .slide-description{
            color: <?php echo esc_attr($text_color); ?>;
        }
    </style>
    <script type="text/javascript">
        var $ = jQuery;

        $(function(){
            if ( typeof $.flexslider == 'function' )
                $('#<?php echo esc_attr($id); ?>').flexslider({
                    animation: "fade",
                    manualControls: $('ol.flex-control-nav[data-flex-id=<?php echo esc_attr($id); ?>] li'),
                    slideshow: <?php echo esc_attr($slideshow) ?>,
                    slideshowSpeed: 5000,
                    selector: '.slides > li',
                    directionNav: false,
                });
            $('#<?php echo esc_attr($id); ?>').find('ol.flex-control-paging').remove();
        });
        <?php pixflow_callAnimation(); ?>
    </script>
    <?php
    $output .= ob_get_clean();
    return $output;
}

/*-----------------------------------------------------------------------------------*/
/*  Iconbox Top
/*-----------------------------------------------------------------------------------*/

function pixflow_sc_iconbox_top( $atts, $content = null ) {

    extract(shortcode_atts(array(
        'iconbox_alignment'         => 'center',
        'iconbox_icon'              => 'icon-diamond',
        'iconbox_title'             => 'Figure it out',
        'iconbox_heading'           => 'h1',
        'iconbox_icon_color'        => 'rgb(0,0,0)',
        'iconbox_general_color'     => '#5e5e5e',
        'iconbox_description'       => "There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable",
        'iconbox_button'            => 'yes',
        'button_style'              => 'fade-square',
        'iconbox_top_button_color'  => '#5e5e5e',
        'iconbox_button_text_color' => '#fff',
        'button_bg_hover_color'     => '#9b9b9b',
        'button_hover_color'        => '#fff',
        'iconbox_button_text'       => 'Read more',
        'button_icon_class'         => 'icon-snowflake2',
        'iconbox_button_size'       => 'standard',
        'iconbox_button_url'        => '#',
        'iconbox_button_target'     => '_self',
        'left_right_padding'        => '0',
        'align' => 'center'
    ), $atts));

    $animation = array();
    $animation = pixflow_shortcodeAnimation('md_iconbox_top',$atts);
    $id = pixflow_sc_id('iconbox-top');

    ob_start(); ?>

    <style scoped="scoped">

        <?php if('right' == $iconbox_alignment) { ?>
            <?php echo '.'.esc_attr($id) ?> .iconbox-top-content{
                text-align: right;
            }

            <?php echo '.'.esc_attr($id) ?> .icon-holder,
            <?php echo '.'.esc_attr($id) ?>.iconbox-top .description{
                float: right;
            }

            <?php echo '.'.esc_attr($id) ?> .icon-holder {
                margin-right: -25px;
            }

        <?php } elseif ('center' == $iconbox_alignment) { ?>

            <?php echo '.'.esc_attr($id) ?> .iconbox-top-content{
                text-align: center;
            }

            <?php echo '.'.esc_attr($id) ?> .icon-holder,
            <?php echo '.'.esc_attr($id) ?>.iconbox-top .description{
                margin-right: auto;
                margin-left: auto;
            }

        <?php } elseif ('left' == $iconbox_alignment) { ?>
            <?php echo '.'.esc_attr($id) ?> .iconbox-top-content{
                text-align: left;
            }

            <?php echo '.'.esc_attr($id) ?> .icon-holder,
            <?php echo '.'.esc_attr($id) ?>.iconbox-top .description{
                float: left;
            }

            <?php echo '.'.esc_attr($id) ?> .icon-holder {
                margin-left: -25px;
            }

        <?php } ?>

        <?php echo '.'.esc_attr($id) ?> .icon{
            color: <?php echo esc_attr($iconbox_icon_color); ?>;
        }

        <?php echo '.'.esc_attr($id) ?> .title{
            color: <?php echo esc_attr($iconbox_general_color); ?>;
        }

        <?php echo '.'.esc_attr($id) ?> .description{
            color: <?php echo esc_attr(pixflow_colorConvertor($iconbox_general_color,'rgba', 0.7)); ?>;
        }

    </style>

    <div class="iconbox-top <?php echo esc_attr($id.' '.$animation['has-animation'].' md-align-'.$align); ?>" <?php echo esc_attr($animation['animation-attrs']); ?>>
        <div class="iconbox-top-content">
            <div class="hover-holder">
                <div class="icon-holder">
                    <svg class="svg-circle">
                        <circle cx="49" cy="49" r="47" stroke="<?php echo esc_attr($iconbox_icon_color); ?>" stroke-width="2" fill="none"></circle>
                    </svg>
                    <?php if( isset($iconbox_icon) && 'icon-' != $iconbox_icon ){ ?>
                        <div class="icon <?php echo esc_attr($iconbox_icon) ?>"></div>
                    <?php }?>
                </div>
                <div class=" clearfix"></div>
                <!--End of Icon section-->

                <?php if( isset($iconbox_title) && '' != $iconbox_title ){ ?>
                    <<?php echo esc_attr($iconbox_heading) ?> class="title"> <?php echo esc_attr($iconbox_title) ?> </<?php echo esc_attr($iconbox_heading) ?>>
                <?php } ?>
                <!--End of Title section-->
            </div>

            <?php if( isset($iconbox_description) && '' != $iconbox_description ){ ?>
                <p class="description"><?php echo preg_replace("/&lt;(.*?)&gt;/i",'',esc_attr($iconbox_description)); ?></p>
            <div class=" clearfix"></div>
            <?php } ?>
            <!--End of Description section-->

            <?php
            if( 'yes' == $iconbox_button ){

                echo pixflow_buttonMaker($button_style,$iconbox_button_text,$button_icon_class,$iconbox_button_url,$iconbox_button_target,$iconbox_alignment,$iconbox_button_size,$iconbox_top_button_color,$button_hover_color,$left_right_padding,$iconbox_button_text_color,$button_bg_hover_color);

            }
            ?>
            <!--End of Button section-->
        </div>
    </div>

    <script>

        "use strict";

        var $ = (jQuery);

        if ( typeof pixflow_iconboxTopShortcode == 'function' )
        {
            pixflow_iconboxTopShortcode();
        }
        <?php pixflow_callAnimation(); ?>
    </script>

    <?php
    return ob_get_clean();
}

/*-----------------------------------------------------------------------------------*/
/*  Iconbox Side
/*-----------------------------------------------------------------------------------*/

function pixflow_sc_iconbox_side( $atts, $content = null ) {

        extract(shortcode_atts(array(
            'iconbox_alignment'         => 'left',
            'iconbox_icon'              => 'icon-location',
            'iconbox_icon_background'   => 'yes',
            'iconbox_title'             => 'Figure it out',
            'iconbox_heading'           => 'H3',
            'iconbox_icon_color'        => '#5e5e5e',
            'iconbox_icon_hover_color'  => '#FFF',
            'iconbox_general_color'     => '#5e5e5e',
            'iconbox_description'       => 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable',
            'iconbox_button'            => 'yes',
            'button_style'              => 'fade-square',
            'iconbox_side_button_color' => '#5e5e5e',
            'button_hover_color'        => '#fff',
            'button_text_color'         => '#fff',
            'button_bg_hover_color'     => '#9b9b9b',
            'iconbox_button_text'       => 'Read more',
            'button_icon_class'         => 'icon-snowflake2',
            'iconbox_button_size'       => 'standard',
            'iconbox_button_url'        => '#',
            'iconbox_button_target'     => '_self',
            'left_right_padding'        => '0'
        ), $atts));
    $animation = array();
    $animation = pixflow_shortcodeAnimation('md_iconbox_side',$atts);
        $id = pixflow_sc_id('iconbox-side');

        ob_start(); ?>
        <style scoped="scoped">
        <?php echo '.'.esc_attr($id) ?> .icon{
            color: <?php echo esc_attr($iconbox_icon_color); ?>;
        }

        <?php if ( $iconbox_icon_background == 'yes'){

            echo '.'.esc_attr($id) ?> .icon-container .icon:after{
                border:1px solid  <?php echo esc_attr($iconbox_icon_color); ?>;
            }

            <?php echo '.'.esc_attr($id) ?>.iconbox-side:hover .icon{
                box-shadow: 0 0 0 2px <?php echo esc_attr($iconbox_icon_color); ?>;;
                background: <?php echo esc_attr($iconbox_icon_color); ?>;
                color: <?php echo esc_attr($iconbox_icon_hover_color); ?>;
            }
        <?php
        } echo '.'.esc_attr($id) ?> .title{
            color: <?php echo esc_attr($iconbox_general_color); ?>;
        }

        <?php echo '.'.esc_attr($id) ?> .description{
            color: <?php echo esc_attr($iconbox_general_color); ?>;
            opacity: 0.7;
        }

    </style>

        <?php   $sideClass = '';
        if('right' == $iconbox_alignment) {
            $sideClass .= ' right-align';
        } else if('left' == $iconbox_alignment) {
            $sideClass .= ' left-align';
        }?>

    <div class="iconbox-side clearfix <?php echo esc_attr($id.' '.$animation['has-animation']); echo esc_attr($sideClass); ?>" <?php echo esc_attr($animation['animation-attrs']); ?>>
        <?php if( isset($iconbox_icon) && 'icon-' != $iconbox_icon ){ ?>
             <div class="icon-container <?php if ( $iconbox_icon_background == 'yes') echo 'icon-background'; ?>">
                <div class="icon <?php echo esc_attr($iconbox_icon) ?>"></div>
             </div>
        <?php }?>
        <!--End of Icon section-->

        <div class="iconbox-side-container " >
            <?php if( isset($iconbox_title) && '' != $iconbox_title ){ ?>
                <<?php echo esc_attr($iconbox_heading) ?> class="title"> <?php echo esc_attr($iconbox_title) ?> </<?php echo esc_attr($iconbox_heading) ?>>
            <?php } ?>
            <!--End of Title section-->

            <?php if( isset($iconbox_description) && '' != $iconbox_description ){ ?>
                <p class="description"><?php echo preg_replace("/&lt;(.*?)&gt;/i",'',esc_attr($iconbox_description)); ?></p>
            <?php } ?>
            <!--End of Description section-->

            <?php
            if( 'yes' == $iconbox_button ){
                echo pixflow_buttonMaker($button_style,$iconbox_button_text,$button_icon_class,$iconbox_button_url,$iconbox_button_target,$iconbox_alignment,$iconbox_button_size,$iconbox_side_button_color,$button_hover_color,$left_right_padding,$button_text_color,$button_bg_hover_color);
            }
            ?>
            <!--End of Button section-->
        </div>
    </div>
    <?php
    pixflow_callAnimation(true);
    return ob_get_clean();
}

/*-----------------------------------------------------------------------------------*/
/*  Iconbox Side 2
/*-----------------------------------------------------------------------------------*/

function pixflow_sc_iconbox_side2( $atts, $content = null ) {

        extract(shortcode_atts(array(
            'iconbox_side2_alignment'  => 'left',
            'iconbox_side2_icon'       => 'icon-ribbon',
            'iconbox_side2_title'      => 'Advertisement',
            'iconbox_side2_title_big'  => 'Creative Elements',
            'iconbox_side2_title_big_heading'  => 'H6',
            'iconbox_side2_icon_color'         => 'rgba(0,0,0,.5)',
            'iconbox_side2_small_title_color'  => '#12be83',
            'iconbox_side2_general_color'      => '#000',
            'iconbox_side2_description'        => 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable',
            'iconbox_side2_button'             => 'no',
            'iconbox_side2_button_style'       => 'fade-square',
            'iconbox_side2_button_color'       => '#5e5e5e',
            'iconbox_side2_button_hover_color' => '#fff',
            'iconbox_side2_button_text_color'  => '#fff',
            'iconbox_side2_button_bg_hover_color' => '#9b9b9b',
            'iconbox_side2_button_text'           => 'Read more',
            'iconbox_side2_class'                 => 'icon-snowflake2',
            'iconbox_side2_button_size'           => 'standard',
            'iconbox_side2_button_url'            => '#',
            'iconbox_side2_button_target'         => '_self',
            'iconbox_side2_left_right_padding'    => '0',
            'iconbox_side2_image'=> '',
            'iconbox_side2_type'=>'icon',
        ), $atts));
    $animation = array();
    $animation = pixflow_shortcodeAnimation('md_iconbox_side2',$atts);
        $id = pixflow_sc_id('iconbox-side');

        ob_start(); ?>
        <style scoped="scoped">
        <?php echo '.'.esc_attr($id) ?> .icon{
            color: <?php echo esc_attr($iconbox_side2_icon_color); ?>;
        }

        <?php echo '.'.esc_attr($id) ?> .info-title{
            color: <?php echo esc_attr($iconbox_side2_small_title_color); ?>;
        }

        <?php echo '.'.esc_attr($id) ?> .description,
        <?php echo '.'.esc_attr($id) ?> .title{
            color: <?php echo esc_attr($iconbox_side2_general_color); ?>;
        }

    </style>

        <?php   $sideClass = '';
        if('right' == $iconbox_side2_alignment) {
            $sideClass .= ' right-align';
        } else if('left' == $iconbox_side2_alignment) {
            $sideClass .= ' left-align';
        }?>

    <div class="iconbox-side style2  <?php echo esc_attr($id.' '.$animation['has-animation']); echo esc_attr($sideClass); ?>" <?php echo esc_attr($animation['animation-attrs']); ?>>
       <div class="iconbox-content">
        <div class="iconbox-side-container  clearfix" >
            <?php if( isset($iconbox_side2_icon) && 'icon-' != $iconbox_side2_icon && $iconbox_side2_type=='icon' ){ ?>
                 <div class="icon-container">
                    <div class="icon <?php echo esc_attr($iconbox_side2_icon) ?>"></div>
                 </div>
            <?php }
            else if ( isset($iconbox_side2_image) && '' != $iconbox_side2_image && $iconbox_side2_type=='image' )
            {
              $imageSrc = wp_get_attachment_url($iconbox_side2_image) ;
              $imageSrc = (false == $imageSrc)?PIXFLOW_PLACEHOLDER_BLANK:$imageSrc;
              $iconbox_side2_image_url= $imageSrc;
            ?>
                <div class="image-container">
                  <div class="iconbox_side2_image" style="background-image:url(<?php echo esc_url($iconbox_side2_image_url)  ?>);"></div>
                </div>
            <?php
            }
            ?>

            <!--End of Icon section-->

            <?php if( (isset($iconbox_side2_title_big) && '' != $iconbox_side2_title_big ) || (isset($iconbox_side2_title) && '' != $iconbox_side2_title)){ ?>
                <div class="heading">
                    <?php  if ((isset($iconbox_side2_title) && '' != $iconbox_side2_title)){ ?>
                        <span class="info-title"><?php echo esc_attr($iconbox_side2_title) ?></span>
                    <?php }

                     if(isset($iconbox_side2_title_big) && '' != $iconbox_side2_title_big ){ ?>
                        <<?php echo esc_attr($iconbox_side2_title_big_heading) ?> class="title"> <?php echo esc_attr($iconbox_side2_title_big) ?> </<?php echo esc_attr($iconbox_side2_title_big_heading) ?>>
                    <?php } ?>
                </div>
            <?php } ?>
            <!--End of Title section-->
        </div>
        <!-- End of title container -->

        <?php if( isset($iconbox_side2_description) && '' != $iconbox_side2_description ){ ?>
            <p class="description"><?php echo preg_replace("/&lt;(.*?)&gt;/i",'',esc_attr($iconbox_side2_description)); ?></p>
        <?php } ?>
        <!--End of Description section-->

        <?php
        if( 'yes' == $iconbox_side2_button ){
            echo pixflow_buttonMaker($iconbox_side2_button_style,$iconbox_side2_button_text,$iconbox_side2_class,$iconbox_side2_button_url,$iconbox_side2_button_target,$iconbox_side2_alignment,$iconbox_side2_button_size,$iconbox_side2_button_color,$iconbox_side2_button_hover_color,$iconbox_side2_left_right_padding,$iconbox_side2_button_text_color,$iconbox_side2_button_bg_hover_color);
        } ?>
        <!--End of Button section-->
        </div>
    </div>

    <?php
    pixflow_callAnimation(true);
    return ob_get_clean();
}

/*-----------------------------------------------------------------------------------*/
/*  Price Table
/*-----------------------------------------------------------------------------------*/

function pixflow_sc_product_compare( $atts, $content = null ) {
    $output = $el_class= $class =$css_class= '';
    extract(shortcode_atts(array(
        'product_compare_image'         => PIXFLOW_THEME_IMAGES_URI."/place-holder.jpg",
        'product_compare_price'         => '150',
        'product_compare_currency'      => '$',
        'product_compare_title'         => 'GENERAL',
        'product_compare_heading'       => 'h1',
        'product_compare_text'          => 'Show your work & create imperssive portfolios without knowing any HTML or how to code.',
        'product_compare_add_image'     => 'yes',
        'product_compare_button'        => 'yes',
        'product_compare_button_style'  => 'fade-oval',
        'product_compare_button_text'   => 'BUY IT',
        'product_compare_button_size'   => 'standard',
        'product_compare_button_url'    => '#',
        'product_compare_button_target' => '_self',
        'product_compare_icon_class'    => 'icon-shopcart',
        'product_compare_general_color' => '#000000',
        'product_compare_button_color'  => '#000',
        'product_compare_hover_color'   => '#ffffff',
        'product_compare_button_text_color' => '#fff',
        'product_compare_button_bg_hover_color'=>'#959595',
        'product_compare_left_right_padding'  => '0',
        'align'                         => 'center'
    ), $atts));
    $animation = array();
    $animation = pixflow_shortcodeAnimation('md_product_compare',$atts);
    $id = esc_attr(pixflow_sc_id('md_product_compare'));

    ob_start();

    ?>
    <style scoped="scoped">

        <?php echo '.'.esc_attr($id) ?> p,
        <?php echo '.'.esc_attr($id) ?> .product_compare_priceholder,
        <?php echo '.'.esc_attr($id); echo ' '.esc_attr($product_compare_heading); ?>{
            color: <?php echo esc_attr($product_compare_general_color); ?>;
        }

    </style>

    <?php
    $css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_product_compare '.$id.' wpb_content_element '. $el_class . ' not-column-inherit '.esc_attr($animation['has-animation']), 'md_product_compare', $atts);


    if(is_numeric($product_compare_image)){
        $imageSrc = wp_get_attachment_image_src( $product_compare_image, 'pixflow_product-compare') ;
        $imageSrc = (false == $imageSrc)?PIXFLOW_PLACEHOLDER_BLANK:$imageSrc[0];
        $image = $imageSrc ;
        $product_compare_image =  $imageSrc ;
    }

    ?>
    <div class="<?php echo esc_attr($css_class); ?> <?php echo esc_attr($id.' '.$animation['has-animation']); ?> md-align-<?php echo esc_attr($align);?>" <?php echo esc_attr($animation['animation-attrs']); ?> >
        <div class="wpb_wrapper wpb_product_compare_wrapper ui-product_compare">

            <?php if($product_compare_add_image=='yes'){?>
                <div class="product_compare_img"><img src="<?php echo esc_url($product_compare_image); ?>" /></div>
            <?php } ?>

            <div class="product_compare_priceholder"><span class="product_compare_currency"><?php echo esc_attr($product_compare_currency); ?></span><span class="product_compare_price"><?php echo esc_attr($product_compare_price); ?></span></div>
            <div class="product_compare_title_holder"><<?php echo esc_attr($product_compare_heading); ?> class="product_compare_title"><?php echo esc_attr($product_compare_title); ?></<?php echo esc_attr($product_compare_heading)?>></div>
            <div class="product_compare_text"><p><?php echo preg_replace("/&lt;(.*?)&gt;/i",'',esc_attr($product_compare_text)); ?></p></div>
            <?php if($product_compare_button=='yes') {?>
                <div class="button-parent">
                    <?php echo pixflow_buttonMaker($product_compare_button_style,$product_compare_button_text,$product_compare_icon_class,$product_compare_button_url,$product_compare_button_target,'center',$product_compare_button_size,$product_compare_button_color,$product_compare_hover_color,$product_compare_left_right_padding,$product_compare_button_text_color,$product_compare_button_bg_hover_color); ?>
                </div>
            <?php } ?>
        </div>
    </div>

    <?php
    pixflow_callAnimation(true);
    $output .= ob_get_clean();

    return $output;
}

/*-----------------------------------------------------------------------------------*/
/*  MD Image Box Slider
/*-----------------------------------------------------------------------------------*/

function pixflow_sc_imageBoxSlider($atts, $content = null)
{
    extract(shortcode_atts(array(
        'image_box_slider_image'              => PIXFLOW_THEME_IMAGES_URI."/place-holder.jpg",
        'image_box_slider_height'             => '300',
        'image_box_slider_size'               => 'initial',
        'image_box_slider_effect_slider'      => 'fade',
        'image_box_slider_speed'              => '3000',
        'image_box_slider_hover'              => 'no',
        'image_box_slider_hover_link'         => '',
        'image_box_slider_hover_effect'       => 'text',
        'image_box_slider_hover_image_sec'    => PIXFLOW_THEME_IMAGES_URI."/place-holder.jpg",
        'image_box_slider_hover_text_effect'  => 'light',
        'image_box_slider_hover_text'         => 'Text Hover',
        'align'         => 'center',
    ), $atts));
    $animation = array();
    $animation = pixflow_shortcodeAnimation('md_image_box_slider',$atts);
    $id = pixflow_sc_id('imageBoxSlider');

    $image_box_slider_hover_effect;

    ob_start();

    // Main Image
    $image_url = wp_get_attachment_url($image_box_slider_image);
    $image_url = (false == $image_url)?PIXFLOW_PLACEHOLDER_BLANK:$image_url;
    $image_pointer = explode(",",$image_box_slider_image);

    // Hover Image
    $image_url_hover = wp_get_attachment_url($image_box_slider_hover_image_sec);
    $image_url_hover = (false == $image_url_hover)?PIXFLOW_PLACEHOLDER_BLANK:$image_url_hover;
    $image_pointer_hover = explode(",",$image_box_slider_hover_image_sec);

    $counter = 0;
    ?>

    <div id="<?php echo esc_attr($id); ?>" data-speed="<?php echo esc_attr($image_box_slider_speed); ?>" data-effect="<?php echo esc_attr($image_box_slider_effect_slider); ?>" class="img-box-slider <?php echo esc_attr($animation['has-animation'].' md-align-'.$align); ?>" <?php echo esc_attr($animation['animation-attrs']); ?>>

        <ul class="slides">
            <?php foreach( $image_pointer as $value )
            {
                $image_url = wp_get_attachment_url($value);
                $image_url_flag = true;
				$image_meta_data= wp_get_attachment_metadata($value);

                if ($image_url == false){
                    $image_meta_data = array();
                    $image_url = PIXFLOW_PLACEHOLDER_BLANK;
                    $image_url_flag = false;
                }

                if(!isset($image_meta_data['width'])){
                    $image_meta_data['width'] = '';
                    $image_meta_data['height'] = '';
                }
                ?>
                <li>

                    <div class="imgBox-image imgBox-image-main image-<?php echo esc_attr($id).$counter ?> <?php echo esc_attr($image_box_slider_size); ?>" data-height="<?php echo esc_attr($image_meta_data['height']);  ?>" data-width="<?php echo esc_attr($image_meta_data['width']);  ?>"></div>
                    <a href="<?php echo esc_url($image_box_slider_hover_link); ?>" class="imgBox-image imgBox-image-hover image-hover-<?php echo esc_attr($id).$counter ?>"></a>

                    <?php if ($image_box_slider_hover_effect == 'text') { ?>
                        <a target="_self" href="" class="image-box-slider-hover-text <?php echo esc_attr( $image_box_slider_hover_text_effect == 'light' ? 'light' : 'dark'); ?>"> <?php echo esc_attr($image_box_slider_hover_text); ?> </a>
                    <?php } ?>

                    <!-- Set image background -->
                    <style>

                        .imgBox-image.image-<?php echo esc_attr($id).$counter ?> {
                            background-image: url("<?php echo esc_url($image_url); ?>");

                            <?php if($image_url_flag == false) { ?>
                                background-size: inherit;
                            <?php $image_url_flag = true; } ?>
                        }

                        <?php if ($image_box_slider_hover_link == '') { ?>

                            #<?php echo esc_attr($id) ?> .imgBox-image,
                            #<?php echo esc_attr($id) ?> .image-box-slider-hover-text {
                                pointer-events: none;
                                cursor: default;
                            }

                        <?php } ?>


                        /* Check if hover image effect selected */
                        <?php if ($image_box_slider_hover == 'yes' && $image_box_slider_hover_effect == 'image') { ?>

                            #<?php echo esc_attr($id) ?> .imgBox-image.image-<?php echo esc_attr($id).$counter ?> {
                                transition: all .3s;
                            }

                            .image-hover-<?php echo esc_attr($id).$counter ?> {
                                background-image: url("<?php echo esc_url($image_url_hover); ?>");
                                opacity: 0;
                            }

                            #<?php echo esc_attr($id) ?>:hover .image-hover-<?php echo esc_attr($id).$counter ?> {
                                opacity: 1;
                            }

                            #<?php echo esc_attr($id) ?> .image-hover-<?php echo esc_attr($id).$counter ?> {
                                background-size: <?php echo esc_attr($image_box_slider_size); ?>;
                            }

                            #<?php echo esc_attr($id) ?>:hover .image-<?php echo esc_attr($id).$counter ?> {
                                opacity: 0;
                            }

                            #<?php echo esc_attr($id) ?> .imgBox-image.image-<?php echo esc_attr($id).$counter ?>:after {
                                content: "";
                                height: 100%;
                                width: 100%;
                                display: block;
                                transition: all .3s;
                                opacity: 0;
                            }

                            #<?php echo esc_attr($id) ?>:hover .imgBox-image.image-<?php echo esc_attr($id).$counter ?>:after {
                                opacity: 1;
                            }

                        <?php } ?>


                        /* Check if hover text effect selected */
                        <?php if ($image_box_slider_hover == 'yes' && $image_box_slider_hover_effect == 'text') { ?>

                            #<?php echo esc_attr($id) ?> .imgBox-image.image-<?php echo esc_attr($id).$counter ?>:after {
                                opacity: 0;
                                transition: all .3s;
                                content: "";
                                display: block;
                                width: 100%;
                                height: 100%;
                            }

                            <?php if ($image_box_slider_hover_text_effect == 'light') { ?>

                                #<?php echo esc_attr($id) ?>:hover .imgBox-image.image-<?php echo esc_attr($id).$counter ?>:after {
                                    background-color: rgba(255,255,255, .5);
                                    opacity: 1;
                                }

                                #<?php echo esc_attr($id) ?>:hover .image-box-slider-hover-text{
                                    opacity: 1;
                                    color: #000;
                                }

                            <?php } ?>

                            <?php if ($image_box_slider_hover_text_effect == 'dark') { ?>

                                #<?php echo esc_attr($id) ?>:hover .imgBox-image.image-<?php echo esc_attr($id).$counter ?>:after {
                                    background-color: rgba(0,0,0, .5);
                                    opacity: 1;
                                }

                                #<?php echo esc_attr($id) ?>:hover .image-box-slider-hover-text{
                                    opacity: 1;
                                    color: #fff;
                                }

                            <?php } ?>

                        <?php } ?>


                        /* Image Size */
                        #<?php echo esc_attr($id) ?> .imgBox-image.image-<?php echo esc_attr($id).$counter ?> {
                            background-size: <?php echo esc_attr($image_box_slider_size); ?>;
                        }

                    </style>

                </li>

            <?php $counter++; } ?>
        </ul>

   </div> <!-- End image box slider -->

    <script>
        $(document).ready(function() {
            if (typeof pixflow_imageBoxSlider == 'function') {
                pixflow_imageBoxSlider("<?php echo esc_attr($id) ?>", "<?php echo esc_attr($image_box_slider_height) ?>");
            }
        });
        <?php pixflow_callAnimation(); ?>
    </script>

    <?php
    return ob_get_clean();
}

/*-----------------------------------------------------------------------------------*/
/*  MD Image Box Fancy
/*-----------------------------------------------------------------------------------*/

function pixflow_sc_imageBoxFancy($atts, $content = null)
{
    extract(shortcode_atts(array(
        'image_box_fancy_image'              => PIXFLOW_THEME_IMAGES_URI."/place-holder.jpg",
        'image_box_fancy_height_type'       => 'manual',
        'image_box_fancy_height'             => '450',
        'image_box_fancy_size'               => 'auto',
        'image_box_fancy_effect_slider'      => 'fade',
        'image_box_fancy_speed'              => '3000',
        'image_box_fancy_style'             => 'normal',
        'image_box_fancy_icon'              => 'icon-Diamond',
        'image_box_fancy_icon_color'        => 'rgba(0,177,177,1)',
        'image_box_fancy_text_color'        => 'rgba(0,0,0,1)',
        'image_box_fancy_background_color'  => 'rgba(255,255,255,1)',
        'image_box_fancy_description_title' => 'Fancy Image Box',
        'image_box_fancy_description_text'  => 'Massive Dynamic has over 10 years of experience in Design. We take pride in delivering Intelligent Designs and Engaging Experiences for clients all over the World.',
        'align'                             => 'center',
    ), $atts));
    $animation = array();
    $animation = pixflow_shortcodeAnimation('md_image_box_fancy',$atts);
    $id = pixflow_sc_id('imageBoxFancy');

    ob_start();

    // Main Image
    $imageSrc = wp_get_attachment_url($image_box_fancy_image);
    $imageSrc = (false == $imageSrc)?PIXFLOW_PLACEHOLDER1:$imageSrc;
    $image_url = $imageSrc;
    $image_pointer = explode(",",$image_box_fancy_image);

    $counter = 0;
    ?>
    <style scoped="scoped">
        #<?php echo esc_attr($id); ?> .image-box-fancy-desc{
            background: <?php echo esc_attr($image_box_fancy_background_color)?>;
        }
        #<?php echo esc_attr($id); ?> .image-box-fancy-collapse,
        #<?php echo esc_attr($id); ?> .image-box-fancy-icon{
            color: <?php echo esc_attr($image_box_fancy_icon_color)?>;
        }
        #<?php echo esc_attr($id); ?> .image-box-fancy-desc h1,
        #<?php echo esc_attr($id); ?> .image-box-fancy-desc p{
            color: <?php echo esc_attr($image_box_fancy_text_color)?>;
        }
    </style>
    <div id="<?php echo esc_attr($id); ?>" data-effect="<?php echo esc_attr($image_box_fancy_effect_slider); ?>" data-speed="<?php echo esc_attr($image_box_fancy_speed); ?>" class="img-box-fancy <?php echo esc_attr($animation['has-animation'].' md-align-'.$align); ?>" <?php echo esc_attr($animation['animation-attrs']); ?>>

        <ul class="slides">
            <?php foreach( $image_pointer as $value )
            {
                $image_url = wp_get_attachment_url($value);
                $image_url_flag = true;
                if ($image_url == false){
                    $image_url = PIXFLOW_PLACEHOLDER1;
                    $image_url_flag = false;
                }
                ?>
                <li>
                    <div class="imgBox-image imgBox-image-main image-<?php echo esc_attr($id).$counter ?>" style="<?php echo "background-image:url('".esc_attr($image_url)."');background-size:" . esc_attr($image_box_fancy_size); ?>"></div>
                </li>
            <?php $counter++; } ?>
        </ul>
        <div class="image-box-fancy-desc image-box-fancy-desc-<?php echo esc_attr($image_box_fancy_style)?>">
            <div class="image-box-fancy-collapse"><i class="px-icon icon-maximize"></i></div>
            <div class="image-box-fancy-container">
                <div class="image-box-fancy-icon"><i class="px-icon <?php echo esc_attr($image_box_fancy_icon)?>"></i></div>
                <h1 class="image-box-fancy-title"><?php echo esc_attr($image_box_fancy_description_title)?></h1>
                <p class="image-box-fancy-text"><?php echo preg_replace("/&lt;(.*?)&gt;/i",'',esc_attr($image_box_fancy_description_text)); ?></p>
            </div>
        </div>
   </div> <!-- End image box fancy -->

    <script>
        "use strict";
        $(document).ready(function() {
            if (typeof pixflow_imageBoxFancy == 'function') {
                pixflow_imageBoxFancy("<?php echo esc_attr($id) ?>", "<?php echo esc_attr($image_box_fancy_height_type) == 'manual'?esc_attr($image_box_fancy_height):'fit'; ?>");
            }
        });
        <?php pixflow_callAnimation(); ?>
    </script>

    <?php
    return ob_get_clean();
}

/*-----------------------------------------------------------------------------------*/
/*  Imagebox full-width
/*-----------------------------------------------------------------------------------*/

function pixflow_sc_imagebox_full( $atts, $content = null ) {

    extract(shortcode_atts(array(
        'imagebox_title'             => 'Products that perform as good as they look',
        'imagebox_heading_size'      => 'h3',
        'imagebox_description'       => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec porta, mi ut facilisis ullamcorper, magna risus vehicula augue, eget faucibus magna massa at justo. Sed quis augue ut eros tincidunt hendrerit eu eget nisl. Duis malesuada vehicula massa...
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec porta, mi ut facilisis ullamcorper, magna risus vehicula augue, eget faucibus magna massa at justo. Sed quis augue ut eros tincidunt hendrerit eu eget nisl.',
        'imagebox_general_color'     => '#ffffff',
        'imagebox_text_height'       => '300',
        'imagebox_alignment'         => 'left',
        'imagebox_use_background'    => 'yes',
        'imagebox_background'        => '',
        'imagebox_overlay'           => 'yes',
        'imagebox_overlay_color'     => 'rgba(90,31,136,0.5)',
        'imagebox_button'            => 'yes',
        'imagebox_button_style'      =>'slide',
        'imagebox_button_text'       => 'Read more',
        'imagebox_button_icon'       => 'icon-arrow-right4',
        'imagebox_button_color'      => '#fff',
        'imagebox_button_text_color' => '#000',
        'imagebox_button_bg_hover_color' => '#9b9b9b',
        'imagebox_button_hover_color'=> '#9b9b9b',
        'imagebox_button_size'       => 'standard',
        'imagebox_left_right_padding'=> 0,
        'imagebox_button_url'        => '#',
        'imagebox_button_target'     => '_self',
    ), $atts));
    $animation = array();
    $animation = pixflow_shortcodeAnimation('md_imagebox_full',$atts);

    $id = pixflow_sc_id('imagebox-full');

    if('yes' == $imagebox_use_background && is_numeric($imagebox_background)){
        $imagebox_background =  wp_get_attachment_url( $imagebox_background ) ;
        $imagebox_background = (false == $imagebox_background)?PIXFLOW_PLACEHOLDER1:$imagebox_background;

    }

    ob_start();?>
    <style scoped="scoped">
        <?php if($imagebox_alignment == 'center'){ ?>
            <?php echo '.'.esc_attr($id) ?>{
                text-align:center;
            }
        <?php }else{ ?>
            <?php echo '.'.esc_attr($id) ?>{
                text-align:left;
            }
        <?php } ?>

        <?php echo '.'.esc_attr($id) ?> .title,
        <?php echo '.'.esc_attr($id) ?> .description{
            color:  <?php echo esc_attr($imagebox_general_color); ?>;
            <?php if($imagebox_alignment == 'center'){ ?>
            margin-left: auto;
            margin-right: auto;
            <?php } ?>
        }
        <?php if($imagebox_alignment == 'center'){ ?>
        <?php echo '.'.esc_attr($id) ?> .shortcode-btn {
            max-width: 570px;
            margin: auto;
            display: block;
        }
        <?php echo '.'.esc_attr($id) ?> .shortcode-btn .button{
            text-align: left;
        }
        <?php } ?>
    </style>
    <div class="imagebox-full clearfix <?php echo esc_attr($id.' '.$animation['has-animation'].' align-'.$imagebox_alignment); ?>" style="<?php if($imagebox_background != ''){ ?>background-image:url('<?php echo esc_attr($imagebox_background) ?>');<?php } ?>" <?php echo esc_attr($animation['animation-attrs']); ?>>
        <?php if( 'yes' == $imagebox_overlay){ ?>
            <div class="overlay" style="<?php if('yes' == $imagebox_use_background && 'yes' == $imagebox_overlay){ ?>background-color: <?php echo esc_attr($imagebox_overlay_color)?><?php } ?>"></div>
        <?php } ?>
        <div class="text-container" style="height: <?php echo esc_attr(abs((int)$imagebox_text_height)) ?>px;max-height: <?php echo esc_attr(abs((int)$imagebox_text_height)) ?>px">
            <<?php echo esc_attr($imagebox_heading_size) ?> class="title"><?php echo esc_attr($imagebox_title) ?></<?php echo esc_attr($imagebox_heading_size) ?>>
            <p class="description"><?php echo preg_replace("/&lt;(.*?)&gt;/i",'',esc_attr($imagebox_description)); ?></p>
        </div>
        <?php
        if( 'yes' == $imagebox_button ) {
            echo pixflow_buttonMaker($imagebox_button_style, $imagebox_button_text,$imagebox_button_icon, $imagebox_button_url, $imagebox_button_target,$imagebox_alignment,$imagebox_button_size, $imagebox_button_color,$imagebox_button_hover_color,$imagebox_left_right_padding,$imagebox_button_text_color,$imagebox_button_bg_hover_color);

        } ?>
        <script>
            "use strict";
            if ( typeof pixflow_imageboxFull == 'function' )
            {
                pixflow_imageboxFull();
            }
           <?php pixflow_callAnimation(); ?>
        </script>
    </div>
    <?php
    return ob_get_clean();
}

/*---------------------------------------------------------
--------------------Tab Shortcode--------------------------
----------------------------------------------------------*/

function pixflow_sc_tabs( $atts, $content = null ){
    $output = $title = $tab_icon = $tab_icon_class = $tab_color = $title_color=$tab_active_color = $interval = '';

    extract( shortcode_atts( array(
        'interval'         => '',
        'tab_color'        => 'rgba(43,42,40,1)',
        'tab_active_color' => 'rgba(235,78,1,1)',
        'title_color'      => 'rgba(255,255,255,1)',
        'tabs_background'  => 'rgba(247,247,247,1)'
    ), $atts ) );
    $animation = array();
    $animation = pixflow_shortcodeAnimation('md_tabs',$atts);

    wp_enqueue_script('jquery-ui-tabs');

    $element = 'wpb_tabs';
    $id = esc_attr(pixflow_sc_id('md_tabs'));
    ob_start();
    ?>
    <style scoped="scoped">
    .<?php echo esc_attr($id); ?>.wpb_content_element .wpb_tabs_nav.md-custom-tab{
        background: <?php echo esc_attr($tab_color);?>;
    }
    .<?php echo esc_attr($id); ?>.wpb_content_element .wpb_tabs_nav{
        border-bottom: 4px solid <?php echo esc_attr($tab_active_color);?>;
    }
    .<?php echo esc_attr($id); ?>.wpb_content_element .wpb_tabs_nav.md-custom-tab > li.ui-tabs-active{
        background-color: <?php echo esc_attr($tab_active_color);?>;
    }
    .<?php echo esc_attr($id); ?>.wpb_content_element .wpb_tabs_nav.md-custom-tab > li:not(.ui-tabs-active):hover{
        background-color: <?php echo esc_attr(pixflow_colorConvertor($tab_active_color,'rgba',0.5));?>;
    }
    .<?php echo esc_attr($id); ?>.wpb_content_element .wpb_tabs_nav.md-custom-tab > li{
        border-right: 1px solid <?php echo esc_attr(pixflow_colorConvertor($title_color,'rgba',0.2)); ?>;
    }
    .<?php echo esc_attr($id); ?>.wpb_content_element .wpb_tabs_nav.md-custom-tab > li.ui-tabs-active{
        color: <?php echo esc_attr($title_color); ?>;
    }

    .<?php echo esc_attr($id); ?>.wpb_content_element .wpb_tabs_nav.md-custom-tab > li.ui-tabs-active a,
    .<?php echo esc_attr($id); ?>.wpb_content_element .wpb_tabs_nav.md-custom-tab > li.ui-tabs-active a i{
        color: <?php echo esc_attr($title_color); ?>;
    }
    .<?php echo esc_attr($id); ?>.wpb_content_element .wpb_tabs_nav.md-custom-tab > li:not(.ui-tabs-active):hover > a,
    .<?php echo esc_attr($id); ?>.wpb_content_element .wpb_tabs_nav.md-custom-tab > li:not(.ui-tabs-active):hover > a i{
        color: <?php echo esc_attr(pixflow_colorConvertor($title_color,'rgba',0.5)); ?>;
    }
    .<?php echo esc_attr($id); ?>.wpb_content_element .wpb_tabs_nav.md-custom-tab > li > a{
        color: <?php echo esc_attr(pixflow_colorConvertor($title_color,'rgba',0.4)); ?>;
    }
    .<?php echo esc_attr($id); ?>.wpb_content_element .wpb_tabs_nav.md-custom-tab > li a i{
        color: <?php echo esc_attr(pixflow_colorConvertor($title_color,'rgba',0.4)); ?>;
    }

    .<?php echo esc_attr($id); ?>.wpb_content_element .wpb_tabs_nav.md-custom-tab > li > a,
    .<?php echo esc_attr($id); ?>.wpb_content_element .wpb_tabs_nav.md-custom-tab .md-tab-add-tab strong{
        font-size: <?php echo esc_attr(pixflow_get_theme_mod('link_size',PIXFLOW_LINK_SIZE)); ?>px;
    }

    .<?php echo esc_attr($id); ?>.wpb_content_element .wpb_wrapper > .vc_md_tab > .vc_element-container,
    .<?php echo esc_attr($id); ?>.wpb_content_element .wpb_wrapper > .wpb_tab{
        background-color:<?php echo esc_attr($tabs_background);?>;
    }

</style>

    <?php
    $output.=ob_get_clean();
    preg_match_all( '/md_tab([^\]]+)/i', $content, $matches, PREG_OFFSET_CAPTURE );
    $tab_titles = array();

    if ( isset( $matches[1] ) ) {
        $tab_titles = $matches[1];
    }

    $tabs_nav = '';
    $tabs_nav .= '<ul class="wpb_tabs_nav ui-tabs-nav vc_clearfix md-custom-tab">';
    $i=0;

    foreach ( $tab_titles as $tab ) {
        $i++;
        $tab_atts = shortcode_parse_atts($tab[0]);
        $tab_atts['title'] = !array_key_exists('title',$tab_atts)?'Tab '.$i:$tab_atts['title'];
        $tab_atts['tab_icon'] = !array_key_exists('tab_icon',$tab_atts)?'icon-cog':$tab_atts['tab_icon'];
        $tab_atts['tab_icon_class'] = !array_key_exists('tab_icon_class',$tab_atts)?'icon-cog':$tab_atts['tab_icon_class'];
        if (isset($tab_atts['title']) || isset($tab_atts['tab_icon'])) {
            $tabs_nav .= '<li data-model="md_tabs">
                    <a href="#tab-' . (isset($tab_atts['tab_id']) ? $tab_atts['tab_id'] : sanitize_title($tab_atts['title'])) . '"><i class="left-icon '.$tab_atts['tab_icon_class'].'"></i><span>'.$tab_atts['title'].'</span></a>
                </li>';
        }
    }

    $tabs_nav .= '</ul>' . "\n";

    $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, trim( $element . ' wpb_content_element ' ), 'md_tabs', $atts );

    $output .= "\n\t" . '<div class="'.$id.' '. $css_class .' '. esc_attr($animation["has-animation"]) .'" data-interval="' . $interval . '" '.esc_attr($animation["animation-attrs"]).'>';
    $output .= "\n\t\t" . '<div class="wpb_wrapper wpb_tour_tabs_wrapper ui-tabs vc_clearfix">';
    $output .= wpb_widget_title( array( 'title' => $title, 'extraclass' => $element . '_heading' ) );
    $output .= "\n\t\t\t" . $tabs_nav;
    $output .= "\n\t\t\t" . wpb_js_remove_wpautop( $content );

    $output .= "\n\t\t" . '</div> ' ;
    $output .= "\n\t" . '</div> ';

    ob_start();
    ?>
    <script type="text/javascript">
        var $ = jQuery;
        $(function(){
            if($('body').hasClass('vc_editor')){
                $('.<?php echo esc_attr($id); ?>').closest('.vc_md_tabs').find('.md-tab-add-tab').parent().remove();
                $('.<?php echo esc_attr($id); ?>').closest('.vc_md_tabs').find('.wpb_tabs_nav').append('<li><a style="cursor: pointer;padding:30px 35px;min-height:84px" class="md-tab-add-tab vc_control-btn"><strong>+</strong>ADD TAB</a></li>');
                $('.<?php echo esc_attr($id); ?>').closest('.vc_md_tabs').find('.md-tab-add-tab').click(function(e){
                    e.preventDefault();
                    $(this).parent().parent().find('a.vc_control-btn[title="ADD TAB"] .vc_btn-content').click();
                })
            }
            setTimeout(function(){
                var navWidth = $('.<?php echo esc_attr($id); ?>').find('.wpb_tabs_nav').width()-1;
                var length = $('.<?php echo esc_attr($id); ?>').find('.wpb_tabs_nav li').length;
                $('.<?php echo esc_attr($id); ?>').find('.wpb_tabs_nav li').css('min-width',Math.floor(navWidth/length));
            },100)

            var doIt;
            $(window).resize(function(){
                if(doIt){
                    clearTimeout(doIt);
                }
                doIt = setTimeout(function(){
                    var navWidth = $('.<?php echo esc_attr($id); ?>').find('.wpb_tabs_nav').width()-1;
                    var length = $('.<?php echo esc_attr($id); ?>').find('.wpb_tabs_nav li').length;
                    if($('.<?php echo esc_attr($id); ?>').find('.md-tab-add-tab').length){
                        if(!$('.<?php echo esc_attr($id); ?>').find('.md-tab-add-tab').is(':visible')){
                            length -=1;
                        }
                    }
                    $('.<?php echo esc_attr($id); ?>').find('.wpb_tabs_nav li').css('min-width',Math.floor(navWidth/length));
                },150)
            })
        })
        if(typeof pixflow_tabShortcode == 'function'){
            pixflow_tabShortcode();
        }
        <?php pixflow_callAnimation(); ?>

    </script>
    <?php
    $output.=ob_get_clean();

    return $output;
}

/*--------------------Tab Shortcode--------------------------*/
function pixflow_sc_tab( $atts, $content = null ){

    $output = $title = $tab_id = $tab_icon_class= '';
    extract( shortcode_atts( array(
        'tab_id'         =>'' ,
        'title'        => '',
        'tab_icon_class' => ''), $atts ) );

    wp_enqueue_script( 'jquery_ui_tabs_rotate' );

    $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_tab ui-tabs-panel wpb_ui-tabs-hide vc_clearfix', 'md_tab', $atts );
    $output .= "\n\t\t\t" . '<div id="tab-' . ( empty( $tab_id ) ? sanitize_title( $title ) : $tab_id ) . '" class="' . $css_class . '">';
    $output .= ( $content == '' || $content == ' ' ) ? esc_attr__( "Empty tab. Edit page to add content here.", 'massive-dynamic' ) : "\n\t\t\t\t" . wpb_js_remove_wpautop( $content );
    $output .= "\n\t\t\t" . '</div> ';
    return $output;
}

/*-----------------------------------------------------------------------------------*/
/*  Team Member Classic
/*-----------------------------------------------------------------------------------*/

function pixflow_sc_teamMemberClassic($atts, $content = null)
{
    extract(shortcode_atts(array(
        'team_member_classic_title'       => 'John Parker!',
        'team_member_classic_subtitle'    => 'writer',
        'team_member_classic_description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec porta, mi ut facilisis ullamcorper, magna risus vehicula augue, eget faucibus.',

        'team_member_classic_texts_color' => '#fff',
        'team_member_classic_hover_color' => 'rgba(11, 171, 167, 0.85)',
        'team_member_classic_image'       => PIXFLOW_THEME_IMAGES_URI."/place-holder.jpg",

        'team_member_social_icon1'       => 'icon-facebook2',
        'team_member_social_icon2'       => 'icon-twitter5',
        'team_member_social_icon3'       => 'icon-google',
        'team_member_social_icon4'       => 'icon-dribbble',
        'team_member_social_icon5'       => 'icon-instagram',

        'team_member_social_icon1_url'   => 'http://www.facebook.com',
        'team_member_social_icon2_url'   => 'http://www.twitter.com',
        'team_member_social_icon3_url'   => 'http://www.google.com',
        'team_member_social_icon4_url'   => 'http://www.dribbble.com',
        'team_member_social_icon5_url'   => 'http://www.instagram.com',
    ), $atts));
    $animation = array();
    $animation = pixflow_shortcodeAnimation('md_team_member_classic',$atts);

    $id = pixflow_sc_id('teamMemberClassic');

    ob_start();

    wp_enqueue_script('team-member-classic-js',pixflow_path_combine(PIXFLOW_THEME_JS_URI,'sliphover.min.js'),array(),PIXFLOW_THEME_VERSION,true);

    if( is_numeric($team_member_classic_image) ){
        $image_url =  wp_get_attachment_url( $team_member_classic_image );
        $image_url = (false == $image_url)?PIXFLOW_PLACEHOLDER1:$image_url;

    }
    else{
        $image_url = $team_member_classic_image;
    }

    if ( $image_url == false){
        $image_url = $team_member_classic_image;
    }

    ?>
    <div id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($animation['has-animation']); ?>" <?php echo esc_attr($animation['animation-attrs']); ?>>

        <div class="team-member-classic">

            <!-- team member content -->

            <div class="content"

                 data-image="<?php echo esc_url($image_url); ?>"

                 data-color="<?php echo esc_attr($team_member_classic_texts_color); ?>"

                 data-caption='

                    <!-- Top position -->
                    <div class="<?php echo esc_attr($id); ?>-topPos">

                        <h3 class="title">
                            <?php echo esc_attr($team_member_classic_title); ?>
                        </h3>

                        <h4 class="subtitle">
                            <?php echo esc_attr($team_member_classic_subtitle); ?>
                        </h4>

                    </div>

                    <!-- Bottom position -->
                    <div class="teammember-classic <?php echo esc_attr($id); ?>-bottomPos" >

                        <div class="description">
                            <?php echo substr(preg_replace("/&lt;(.*?)&gt;/i",'',esc_attr($team_member_classic_description)),0 , 200); echo strlen(preg_replace("/&lt;(.*?)&gt;/i",'',esc_attr($team_member_classic_description))) > 100 ? '...' : ''; ?>
                        </div>

                        <ul class="social-icons">

                            <li>
                                <a href="<?php echo esc_attr($team_member_social_icon1_url); ?>">
                                    <i class="<?php echo esc_attr($team_member_social_icon1); ?>"></i>
                                </a>
                            </li>

                            <li>
                                <a href="<?php echo esc_attr($team_member_social_icon2_url); ?>">
                                    <i class="<?php echo esc_attr($team_member_social_icon2); ?>"></i>
                                </a>
                            </li>

                            <li>
                                <a href="<?php echo esc_attr($team_member_social_icon3_url); ?>">
                                    <i class="<?php echo esc_attr($team_member_social_icon3); ?>"></i>
                                </a>
                            </li>

                            <li>
                                <a href="<?php echo esc_attr($team_member_social_icon4_url); ?>">
                                    <i class="<?php echo esc_attr($team_member_social_icon4); ?>"></i>
                                </a>
                            </li>

                            <li>
                                <a href="<?php echo esc_attr($team_member_social_icon5_url); ?>">
                                    <i class="<?php echo esc_attr($team_member_social_icon5); ?>"></i>
                                </a>
                            </li>

                        </ul>

                    </div> <!-- End bottom position -->

                '>

            </div>

        </div>

    </div> <!-- End team member classic -->


    <script>

        var $ = (jQuery),
            $teamMemberId = $('<?php echo "#".esc_attr($id) ?>');

        $teamMemberId.attr('data-bgColor', "<?php echo esc_attr($team_member_classic_hover_color); ?>");

        if ( typeof pixflow_teamMemberClassic == 'function' ){
            pixflow_teamMemberClassic( $teamMemberId, "<?php echo esc_attr($team_member_classic_hover_color); ?>" );
        }

        if ( typeof pixflow_teamMemberClassicHover == 'function' ){
            pixflow_teamMemberClassicHover( "<?php echo esc_attr($id) ?>", "<?php echo esc_attr($image_url); ?>", "<?php echo esc_attr($team_member_classic_texts_color); ?>" );
        }

        $(document).ready(function(){
            if($('#wpadminbar').length){
                $("<style/>").html('.sliphover-container{transform:translateY(-32px)}').appendTo('body');
            }
        })
        <?php pixflow_callAnimation(); ?>
    </script>

    <?php
    return ob_get_clean();
}

/*-----------------------------------------------------------------------------------*/
/*  MD Text
/*-----------------------------------------------------------------------------------*/

function pixflow_sc_text( $atts, $content = null ){
    $output=$md_text_style = $md_text_solid_color = $md_text_gradient_color = $md_text_alignment= $md_text_description_bottom_space ='';
    $md_text_title_separator = $md_text_title = $md_text_title_size = $desc_font_weigth=$md_text_letter_space= '';
    $md_text_hover_letter_space = $md_text_use_title_custom_font = $md_text_title_google_fonts = $md_text_content_size= '';
    $md_text_use_desc_custom_font = $md_text_use_button = $md_text_button_style=$left_right_padding= '';
    $md_text_button_text = $md_text_button_icon_class = $md_text_button_color = $md_text_button_hover_color= '';
    $md_text_button_size = $md_text_button_url = $md_text_button_target = $desc_font = $title_font=$desc_font_family= '';
    $md_text_content_color = $md_text_title_line_height = $md_text_title_bottom_space=$title_font_family=$ss= '';
    $md_text_separator_width = $md_text_separator_height = $md_text_seperator_color = $md_text_separator_bottom_space ='';
    $desc_font_weigth=$desc_font_style=$title_font_weight=$title_font_weight=$title_font_style=$title_font_style=array();

    extract( shortcode_atts( array(
        'md_text_style'                => 'solid' ,
        'md_text_solid_color'          => 'rgba(20,20,20,1)',
        'md_text_gradient_color'       => '',
        'md_text_image_bg'             => '',
        'md_text_alignment'            => 'left',
        'md_text_title_separator'      => 'yes',
        'md_text_separator_width'      => '110',
        'md_text_separator_height'     => '5',
        'md_text_separator_color'     => 'rgb(0, 255, 153)',
        'md_text_separator_bottom_space' => '10',
        'md_text_description_bottom_space'=> '25',
        'md_text_number'               => '1',
        'md_text_title1'               => 'Text Shortcode',
        'md_text_title2'               => 'Text Shortcode',
        'md_text_title3'               => 'Text Shortcode',
        'md_text_title4'               => 'Text Shortcode',
        'md_text_title5'               => 'Text Shortcode',
        'md_text_title_size'           => '32',
        'md_text_letter_space'         => '0',
        'md_text_hover_letter_space'   => '0',
        'md_text_use_title_custom_font'=> 'no',
        'md_text_title_google_fonts'   => 'font_family:Roboto%3A100%2C200%2C300%2Cregular%2C500%2C600%2C700%2C800%2C900|font_style:200%20light%20regular%3A200%3Anormal',
        'md_text_content_size'         => '14',
        'md_text_content_color'        => 'rgba(20,20,20,1)',
        'md_text_use_desc_custom_font' => 'yes',
        'md_text_desc_google_fonts'    => 'font_family:Roboto%3A100%2C100italic%2C300%2C300italic%2Cregular%2Citalic%2C500%2C500italic%2C700%2C700italic%2C900%2C900italic|font_style:400%20regular%3A400%3Anormal',
        'md_text_use_button'           => 'no',
        'md_text_button_style'         => 'fade-oval',
        'md_text_button_text'          => 'READ MORE',
        'md_text_button_icon_class'    => 'icon-chevron-right',
        'md_text_button_color'         => 'rgba(0,0,0,1)',
        'md_text_button_text_color'    => 'rgba(255,255,255,1)',
        'md_text_button_bg_hover_color'=> 'rgb(0,0,0)',
        'md_text_button_hover_color'   => 'rgb(255,255,255)',
        'md_text_button_size'          => 'standard',
        'left_right_padding'           => 0,
        'md_text_button_url'           => '#',
        'md_text_button_target'        => '_self',
        'md_text_easing'               => 'cubic-bezier(0.215, 0.61, 0.355, 1)',
        'md_text_title_line_height'    => '40',
        'md_text_title_bottom_space'   => '10',
        'md_text_desc_line_height'     => '21',
        'align'     => 'center',
    ), $atts ) );
    $animation = array();
    $animation = pixflow_shortcodeAnimation('md_text',$atts);
    if($md_text_number > 1){
        wp_enqueue_script('textillate-js',pixflow_path_combine(PIXFLOW_THEME_JS_URI,'jquery.textillate.js'),array(),PIXFLOW_THEME_VERSION,true);
    }
    $titles[1] = $md_text_title1;
    $titles[2] = $md_text_title2;
    $titles[3] = $md_text_title3;
    $titles[4] = $md_text_title4;
    $titles[5] = $md_text_title5;
    if('yes' == $md_text_use_title_custom_font  && $md_text_title_google_fonts != ''){
        $md_text_title_google_fonts = str_replace("font_family:", "", $md_text_title_google_fonts);
        $arr = explode("%3A", $md_text_title_google_fonts, 2);
        $title_font = $arr[0];
        $title_font = str_replace("%20", " ", $title_font);
    }
    if('yes' == $md_text_use_desc_custom_font && $md_text_desc_google_fonts != ''){
        $md_text_desc_google_fonts = str_replace("font_family:", "", $md_text_desc_google_fonts);
        $arr = explode("%3A", $md_text_desc_google_fonts, 2);
        $desc_font = $arr[0];
        $desc_font = str_replace("%20", " ", $desc_font);
    }
    if('yes' == $md_text_use_title_custom_font || 'yes' == $md_text_use_desc_custom_font){
        // check theme typography font
        // TODO : Compare font weights

        if('yes' == $md_text_use_title_custom_font) {
            //if(true == $title_font_load){
            wp_enqueue_style('vc_google_fonts_' . $title_font, '//fonts.googleapis.com/css?family=' . $md_text_title_google_fonts);
            //}
            // Extract Title font style
            if (isset($md_text_title_google_fonts[0])) {
                $md_text_title_google_fonts = explode('|', rawurldecode($md_text_title_google_fonts));
                $title_font_style = explode(':', $md_text_title_google_fonts[1]);
                $title_font_style = explode(' ', $title_font_style[1]);
                $title_font_family = $title_font;
                $title_font_weight = $title_font_style[0];
                $title_font_style = $title_font_style[1];
            }
        }
        if('yes' == $md_text_use_desc_custom_font){
            //if(true == $desc_font_load){
                wp_enqueue_style( 'vc_google_fonts_' . $desc_font, '//fonts.googleapis.com/css?family=' . $md_text_desc_google_fonts );
            //}
            if (isset($md_text_desc_google_fonts[0])) {
                $md_text_desc_google_fonts = explode('|', rawurldecode($md_text_desc_google_fonts));
                if(count($md_text_desc_google_fonts)>1){
                    $desc_font_style = explode(':', $md_text_desc_google_fonts[1]);
                    $desc_font_style = explode(' ', $desc_font_style[1]);
                    $desc_font_family = $desc_font;
                    $desc_font_weigth = $desc_font_style[0];
                    $desc_font_style = $desc_font_style[1];
                }
            }
        }
    }
    $id = esc_attr(pixflow_sc_id('md_text_style'));
    $md_text_gradient_color = str_replace('``','"',$md_text_gradient_color);

    if(is_numeric($md_text_image_bg)){
        $md_text_image_bg =  wp_get_attachment_url( $md_text_image_bg ) ;
        $md_text_image_bg = (false == $md_text_image_bg)?PIXFLOW_PLACEHOLDER_BLANK:$md_text_image_bg;
    }
    // Change Title style to solid if browser is not chrome
    if('Google Chrome' != pixflow_detectBrowser($_SERVER['HTTP_USER_AGENT'])){
        $md_text_style = 'solid';
    }
    ob_start();
    ?>
    <style scoped="scoped">

        /* Solid Style*/
        <?php if($md_text_style=='solid'){?>
            .<?php echo esc_attr($id); ?> .md-text-title {
                color: <?php echo esc_attr($md_text_solid_color); ?>;
            }
        <?php }
        /* gradiant style */
        elseif($md_text_style=='gradient'){?>
            .<?php echo esc_attr($id); ?> .md-text-title,
            .<?php echo esc_attr($id); ?> .md-text-title span{
               <?php echo esc_attr(pixflow_makeGradientCSS($md_text_gradient_color)); ?>
                background-clip: text;
                -webkit-background-clip: text;
                text-fill-color: transparent;
                -webkit-text-fill-color: transparent;
            }
        <?php }
        /* Image style */
         else{?>
            .<?php echo esc_attr($id); ?> .md-text-title,
            .<?php echo esc_attr($id); ?> .md-text-title span{
                background: url("<?php echo esc_url($md_text_image_bg); ?>") no-repeat 100% 100%;
                background-clip: text;
                -webkit-background-clip: text;
                text-fill-color: transparent;
                -webkit-text-fill-color: transparent;
            }
        <?php } ?>

    .<?php echo esc_attr($id); ?>{
        text-align:     <?php echo esc_attr($md_text_alignment); ?>;

    }
    .<?php echo esc_attr($id); ?> .md-text-title{
            font-size:      <?php echo esc_attr($md_text_title_size); ?>px;
            line-height:    <?php echo esc_attr($md_text_title_line_height); ?>px;
            letter-spacing: <?php echo esc_attr($md_text_letter_space); ?>px;
            margin-bottom: <?php echo esc_attr($md_text_title_bottom_space); ?>px;
            transition: all .3s <?php echo esc_attr($md_text_easing); ?> ;
            <?php if($md_text_use_title_custom_font=='yes') {?>
            font-family:    <?php echo esc_attr($title_font_family); ?>;
            font-style:     <?php echo esc_attr($title_font_style); ?>;
            font-weight:    <?php echo esc_attr($title_font_weight); ?>;
            <?php }?>
        }
    .<?php echo esc_attr($id); ?> .md-text-title:not(.title-slider):hover{
        letter-spacing:  <?php echo esc_attr($md_text_hover_letter_space); ?>px;
    }
    .<?php echo esc_attr($id); ?> .md-text-title-separator{
            margin-bottom:<?php echo esc_attr($md_text_separator_bottom_space) ?>px ;
            width: <?php echo esc_attr($md_text_separator_width).'px' ?>;
            border-top: <?php echo esc_attr($md_text_separator_height).'px' ?> solid <?php echo esc_attr($md_text_separator_color); ?>;
        <?php if($md_text_alignment=='left' ){ ?>
            margin-left: 0;
            margin-right: auto;
        <?php }elseif($md_text_alignment=='right' ){?>
            margin-right: 0;
            margin-left: auto;
        <?php }elseif($md_text_alignment=='center' ){ ?>
            margin-left: auto;
            margin-right: auto;
        <?php }?>
        }

    .<?php echo esc_attr($id) ?> .md-text-content{
     margin-bottom: <?php echo esc_attr($md_text_description_bottom_space); ?>px;
    }

    .<?php echo esc_attr($id); ?> .md-text-content p{
            color:          <?php echo esc_attr($md_text_content_color);?>;
            font-size:      <?php echo esc_attr($md_text_content_size); ?>px;
            line-height:    <?php echo esc_attr($md_text_desc_line_height); ?>px;
        <?php if($md_text_use_desc_custom_font=='yes') {?>
            font-family:    <?php echo esc_attr($desc_font_family); ?>;
            font-style:     <?php echo esc_attr($desc_font_style); ?>;
            font-weight:    <?php echo esc_attr($desc_font_weigth); ?>;
        <?php }?>
    }

        <?php if($md_text_alignment == 'center'){?>
        .<?php echo esc_attr($id); ?> .md-text-content p{
            margin: 0  auto;
        }
        <?php } ?>


    </style>

    <div class="md-text-container <?php echo esc_attr($id.' '.$animation['has-animation'].' md-align-'.$align); ?> wpb_wrapper wpb_md_text_wrapper ui-md_text" <?php echo esc_attr($animation['animation-attrs']); ?>>
        <div class="md-text">

            <?php if (!($md_text_number == '1' && $md_text_title1 == '')) { ?>

                <?php if($md_text_number>1) { ?>

                    <div class="md-text-title title-slider">
                        <ul class="texts">
                            <?php for ($i=1; $i<=$md_text_number; $i++) { ?>
                                <li class="text-title"><?php echo preg_replace("/&lt;(.*?)&gt;/i",'',esc_attr($titles[$i])); ?></li>
                            <?php } ?>
                        </ul>
                    </div>

                <?php } else { ?>
                    <div class="md-text-title"><?php echo preg_replace("/&lt;(.*?)&gt;/i",'',esc_attr($titles[1])); ?></div>
                <?php } ?>

            <?php } ?>

            <?php if($md_text_title_separator=='yes'){?>
            <div class="md-text-title-separator"></div>
            <?php } ?>
            <?php if($content != ''){ ?>
            <div class="md-text-content"><p><?php echo wpb_js_remove_wpautop( $content, true ); ?></p></div>
            <?php } ?>

            <?php if($md_text_use_button=='yes'){?>
                <div class="md-text-button">
                    <?php echo pixflow_buttonMaker($md_text_button_style,$md_text_button_text,$md_text_button_icon_class,$md_text_button_url,$md_text_button_target,$md_text_alignment,$md_text_button_size,$md_text_button_color,$md_text_button_hover_color,$left_right_padding,$md_text_button_text_color,$md_text_button_bg_hover_color); ?>
                </div>
            <?php } ?>

        </div>

    </div>
    <script type="text/javascript">
        if(typeof pixflow_title_slider == 'function'){
            pixflow_title_slider();
        }
        <?php pixflow_callAnimation(); ?>
    </script>
    <?php
    $output.=ob_get_clean();

    return $output;

}

function vc_sc_column_text($atts,$content = null){
    if($atts == ''){
        $atts['md_text_title1'] = '';
        $atts['md_text_title_separator'] = 'no';
    }
    return pixflow_sc_text($atts,$content);
}
/*---------------------------------------------------------
--------------------Modern Tabs Shortcode------------------
----------------------------------------------------------*/

function pixflow_sc_modernTabs( $atts, $content = null ){
    $output  = $general_color = $interval = $title = $tab_id =  '';

    extract( shortcode_atts( array(
        'interval'         => '',
        'general_color'    => 'rgb(60,60,60)',
        'height'       => '400',

    ), $atts ) );
    $animation = array();
    $animation = pixflow_shortcodeAnimation('md_modernTabs',$atts);

    wp_enqueue_script('jquery-ui-tabs');

    $element = 'wpb_tabs';
    $id = esc_attr(pixflow_sc_id('md_modernTabs'));
    ob_start();
    ?>
    <style scoped="scoped">

        .<?php echo esc_attr($id); ?>.wpb_content_element .wpb_tabs_nav.md-custom-tab > li.ui-tabs-active,

        .<?php echo esc_attr($id); ?>.wpb_content_element .wpb_tabs_nav.md-custom-tab > li.ui-tabs-active a,
        .<?php echo esc_attr($id); ?>.wpb_content_element .wpb_tabs_nav.md-custom-tab > li.ui-tabs-active a i,

        .<?php echo esc_attr($id); ?>.wpb_content_element .wpb_tabs_nav.md-custom-tab > li:hover > a,
        .<?php echo esc_attr($id); ?>.wpb_content_element .wpb_tabs_nav.md-custom-tab > li:hover > a i{
            color: <?php echo esc_attr(pixflow_colorConvertor($general_color,'rgba',1)); ?>;
        }
        .<?php echo esc_attr($id); ?>.wpb_content_element .wpb_tabs_nav.md-custom-tab > li > a,
        .<?php echo esc_attr($id); ?>.wpb_content_element .wpb_tabs_nav.md-custom-tab > li > a i{
            color: <?php echo esc_attr(pixflow_colorConvertor($general_color,'rgba',0.5)); ?>;
            transition: color 300ms;
        }
        .<?php echo esc_attr($id); ?>.wpb_content_element .wpb_tabs_nav.md-custom-tab .md-modernTab-add-tab strong{
            font-size: <?php echo esc_attr(pixflow_get_theme_mod('link_size',PIXFLOW_LINK_SIZE))+5; ?>px;
        }
    </style>

    <?php
    $output.=ob_get_clean();
    preg_match_all( '/md_modernTab ([^\]]+)/i', $content, $matches, PREG_OFFSET_CAPTURE );
    $tab_titles = array();

    if ( isset( $matches[1] ) ) {
        $tab_titles = $matches[1];
    }

    $tabs_nav = '';
    $tabs_nav .= '<ul class="wpb_tabs_nav ui-tabs-nav vc_clearfix md-custom-tab">';
    $i=0;

    foreach ( $tab_titles as $tab ) {
        $i++;
        $tab_atts = shortcode_parse_atts($tab[0]);
        $tab_atts['title'] = !array_key_exists('title',$tab_atts)?'Tab '.$i:$tab_atts['title'];
        $tab_atts['tab_icon'] = !array_key_exists('tab_icon',$tab_atts)?'icon-cog':$tab_atts['tab_icon'];
        $tab_atts['tab_icon_class'] = !array_key_exists('tab_icon_class',$tab_atts)?'icon-cog':$tab_atts['tab_icon_class'];
        if (isset($tab_atts['title']) || isset($tab_atts['tab_icon'])) {
            $tabs_nav .= '<li data-model="md_modernTabs">
                <a href="#tab-' . (isset($tab_atts['tab_id']) ? $tab_atts['tab_id'] : sanitize_title($tab_atts['title'])) . '">';
            if($tab_atts['tab_icon_class']!='icon-') {
                $tabs_nav .='<i class="left-icon '.$tab_atts['tab_icon_class'].'"></i>';
            }
            if($tab_atts['title']!='') {
                $tabs_nav .='<div class="modernTabTitle">'.$tab_atts['title'].'</div>';
            }
            $tabs_nav .='</a></li>';
        }
    }

    $tabs_nav .= '</ul>' . "\n";

    $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, trim( $element . ' wpb_content_element md_modernTab ' ), 'md_modernTabs', $atts );

    $output .= "\n\t" . '<div class="'.$id.' '. $css_class .' '. esc_attr($animation['has-animation']) . '" data-interval="' . $interval . '"'.esc_attr($animation['animation-attrs']).'>';
    $output .= "\n\t\t" . '<div class="wpb_wrapper wpb_tour_tabs_wrapper ui-tabs vc_clearfix">';
    $output .= wpb_widget_title(array('title' => $title, 'extraclass' => $element . '_heading'));
    $output .= "\n\t\t\t" . $tabs_nav;
    $output .= "\n\t\t\t" . wpb_js_remove_wpautop( $content );

    $output .= "\n\t\t" . '</div> ' ;
    $output .= "\n\t" . '</div> ';

    ob_start();
    ?>
    <script type="text/javascript">
        var $ = jQuery,
            maxHeight=0,
            tmp=0;
        $(function(){
            if($('body').hasClass('vc_editor')){
                $('.<?php echo esc_attr($id); ?>').closest('.vc_md_modernTabs').find('.md-modernTab-add-tab').parent().remove();
                $('.<?php echo esc_attr($id); ?>').closest('.vc_md_modernTabs').find('.wpb_tabs_nav').append('<li><a style="cursor: pointer;padding:23px 0px;min-height:84px" class="md-modernTab-add-tab vc_control-btn"><strong>+</strong><div class="modernTabTitle">ADD TAB</div></a></li>');
                $('.<?php echo esc_attr($id); ?>').closest('.vc_md_modernTabs').find('.md-modernTab-add-tab').click(function(e){
                    e.preventDefault();
                    $(this).parent().parent().find('a.vc_control-btn[title="ADD TAB"] .vc_btn-content').click();
                })
            }
            $('.<?php echo esc_attr($id); ?> .ui-tabs-nav li').click(function() {
                var contentId = "#" + $(this).attr('aria-controls');
                if($(contentId).find('.process-steps').length){
                    if ( typeof pixflow_processSteps == 'function' ){
                        pixflow_processSteps();
                    }
                    if (typeof  pixflow_shortcodeScrollAnimation == 'function'){
                        pixflow_shortcodeScrollAnimation();
                    }
                }

                $('.<?php echo esc_attr($id); ?> .ui-tabs-panel').each(function () {
                    var display = $(this).css('display');
                    $(this).css({'display':'block',height:''});
                    $(window).resize();
                    maxHeight = $(this).height();
                    $(this).css('display',display);
                    if (maxHeight > tmp) {
                        tmp = maxHeight;
                    }
                });
                $('.<?php echo esc_attr($id); ?> .ui-tabs-panel').css('height', tmp + 'px');
            });
            $('.<?php echo esc_attr($id); ?> .ui-tabs-panel').each(function () {
                var display = $(this).css('display');
                $(this).css({'display':'block',height:''});
                maxHeight = $(this).height();
                $(this).css('display',display);
                if (maxHeight > tmp) {
                    tmp = maxHeight;
                }
            });

            $('.<?php echo esc_attr($id); ?> .ui-tabs-panel').css('height', tmp + 'px');
            $(window).load(function(){
                $('.<?php echo esc_attr($id); ?> .ui-tabs-panel').each(function () {
                    var display = $(this).css('display');
                    $(this).css({'display':'block',height:''});
                    maxHeight = $(this).height();
                    $(this).css('display',display);
                    if (maxHeight > tmp) {
                        tmp = maxHeight;
                    }
                });
                $('.<?php echo esc_attr($id); ?> .ui-tabs-panel').css('height', tmp + 'px');
            })
            if(typeof pixflow_tabShortcode == 'function'){
                pixflow_tabShortcode();
            }
        });
        <?php pixflow_callAnimation(); ?>
    </script>
    <?php
    $output.=ob_get_clean();

    return $output;
}

/*-------------------- Modern Tab Shortcode --------------------------*/

function pixflow_sc_modernTab( $atts, $content = null ){

    $output = $title = $tab_id = $tab_icon_class= '';
    extract( shortcode_atts( array(
        'tab_id'      =>'' ,
        'title'       =>'',
        'tab_icon_class' => ''), $atts ) );

    wp_enqueue_script( 'jquery_ui_tabs_rotate' );

    $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_tab ui-tabs-panel wpb_ui-tabs-hide vc_clearfix', 'md_modernTab', $atts );
    $output .= "\n\t\t\t" . '<div id="tab-' . ( empty( $tab_id ) ? sanitize_title( $title ) : $tab_id ) . '" class="' . $css_class . '">';
    $output .= ( $content == '' || $content == ' ' ) ? esc_attr__( "Empty tab. Edit page to add content here.", 'massive-dynamic' ) : "\n\t\t\t\t" . wpb_js_remove_wpautop( $content );
    $output .= "\n\t\t\t" . '</div> ';
    return $output;
}

/*-----------------------------------------------------------------------------------*/
/*  Tablet Slider
/*-----------------------------------------------------------------------------------*/


function pixflow_sc_tablet_slider( $atts, $content = null ) {

    $output = $tablet_slide_num = '';

    extract( shortcode_atts( array(
        'tablet_slider_text_color' => '#000',
        'tablet_slide_num'         => '3',
        'tablet_slider_slideshow'  => 'yes',
        'align'                    => 'center'
    ), $atts ) );
    $animation = array();
    $animation = pixflow_shortcodeAnimation('md_tablet_slider',$atts);

    for($i=1; $i<=$tablet_slide_num; $i++){
        $slides[$i] = shortcode_atts( array(
            'tablet_slider_slide_title_'.$i => 'Slide'.$i,
            'tablet_slider_slide_image_'.$i => PIXFLOW_THEME_IMAGES_URI."/place-holder.jpg",
        ), $atts );
    }

    $id = pixflow_sc_id('tablet_slider');
    $func_id = uniqid();

    if( 'yes' == $tablet_slider_slideshow ){
        $slideshow = 'true';
    } else{
        $slideshow = 'false';
    }

    $output .= '<div data-flex-id="'.$id.'" clone="false" class="tablet-slider md-align-'.esc_attr($align).' '.esc_attr($animation['has-animation']).'" '.$animation['animation-attrs'].'>';
    $output .= '<div data-flex-id="'.$id.'" class="flexslider-controls">';
    $output .= '<ol data-flex-id="'.$id.'" class="flex-control-nav">';

    foreach($slides as $key=>$slide){
        $title  = $slide['tablet_slider_slide_title_'.$key];
        $image  = $slide['tablet_slider_slide_image_'.$key];
        if ($image != '' && is_numeric($image)){
            $image = wp_get_attachment_image_src( $image, 'pixflow_tablet-slider') ;
            $image = (false == $image)?PIXFLOW_PLACEHOLDER1:$image[0];
        }
        if('' != $title) {
            $output .= '<li>' . $title . '</li>';
        }
    }

    $output .= '</ol>' . "\n";
    $output .= '</div>';
    $output .= '<div id="'.$id.'" flex="false" class="flexslider clearfix">';
    $output .= '<ul data-flex-id="'.$id.'" class="slides clearfix">';

    foreach($slides as $key=>$slide){
        $title  = $slide['tablet_slider_slide_title_'.$key];
        $image  = $slide['tablet_slider_slide_image_'.$key];
        if ($image != '' && is_numeric($image)){
            $image = wp_get_attachment_image_src( $image, 'pixflow_tablet-slider') ;
            $image = (false == $image)?PIXFLOW_PLACEHOLDER1:$image[0];
        }
        $output .= '<li>';
        $output .= '<div class="tablet-frame"></div><div class="slide-image" style="background-image:url(\''.esc_attr($image).'\');"></div>';
        $output .= '</li>';
    }

    $output .= '</ul>';
    $output .= '</div>';
    $output .= '</div>';
    ob_start();
    ?>

    <style scoped="scoped">
        [data-flex-id="<?php echo esc_attr($id); ?>"] .flex-control-nav li,
        #<?php echo esc_attr($id); ?> .slide-description{
            color: <?php echo esc_attr($tablet_slider_text_color); ?>;
        }
    </style>

    <script type="text/javascript">
        $(document).ready(function(){
            if (typeof pixflow_tabletSlider == 'function'){
                pixflow_tabletSlider('<?php echo esc_attr($id); ?>','<?php echo esc_attr($slideshow) ?>')
            }
        })
        <?php pixflow_callAnimation(); ?>
    </script>

    <?php
    $output .= ob_get_clean();
    return $output;
}

/*-----------------------------------------------------------------------------------*/
/*  Mobile Slider
/*-----------------------------------------------------------------------------------*/

function pixflow_sc_mobile_slider( $atts, $content = null ) {

    $output = $mobile_slide_num = '';

    extract( shortcode_atts( array(
        'mobile_slider_text_color' => '#000',
        'mobile_slide_num'         => '3',
        'mobile_slider_slideshow'  => 'yes',
        'align'                    => 'center'
    ), $atts ) );

    for($i=1; $i<=$mobile_slide_num; $i++){
        $slides[$i] = shortcode_atts( array(
            'mobile_slider_slide_title_'.$i => '',
            'mobile_slider_slide_image_'.$i => PIXFLOW_THEME_IMAGES_URI."/place-holder.jpg",
        ), $atts );
    }
    $animation = array();
    $animation = pixflow_shortcodeAnimation('md_mobile_slider',$atts);
    $id = pixflow_sc_id('mobile_slider');
    $func_id = uniqid();

    if( 'yes' == $mobile_slider_slideshow ){
        $slideshow = 'true';
    } else{
        $slideshow = 'false';
    }
    $output .= '<div data-flex-id="'.$id.'" clone="false" class="mobile-slider md-align-'.esc_attr($align).' '.$animation['has-animation'].'" '.$animation['animation-attrs'].'>';
    $output .= '<div data-flex-id="'.$id.'" class="flexslider-controls">';
    $output .= '<ol data-flex-id="'.$id.'" class="flex-control-nav">';

    foreach($slides as $key=>$slide){
        $title  = $slide['mobile_slider_slide_title_'.$key];
        $image  = $slide['mobile_slider_slide_image_'.$key];
        if ($image != '' && is_numeric($image)){
            $image = wp_get_attachment_image_src( $image, 'pixflow_mobile-slider') ;
            $image = (false == $image)?PIXFLOW_PLACEHOLDER1:$image[0];
        }
        if('' != $title) {
            $output .= '<li>' . $title . '</li>';
        }
    }

    $output .= '</ol>' . "\n";
    $output .= '</div>';
    $output .= '<div id="'.$id.'" flex="false" class="flexslider clearfix">';
    $output .= '<ul data-flex-id="'.$id.'" class="slides clearfix">';

    foreach($slides as $key=>$slide){
        $title  = $slide['mobile_slider_slide_title_'.$key];
        $image  = $slide['mobile_slider_slide_image_'.$key];
        if ($image != '' && is_numeric($image)){
            $image = wp_get_attachment_image_src( $image, 'pixflow_mobile-slider') ;
            $image = (false == $image)?PIXFLOW_PLACEHOLDER1:$image[0];
        }
        $output .= '<li>';
        $output .= '<div class="mobile-frame"></div><div class="slide-image" style="background-image:url(\''.esc_attr($image).'\');"></div>';
        $output .= '</li>';
    }

    $output .= '</ul>';
    $output .= '</div>';
    $output .= '</div>';
    ob_start();
    ?>

    <style scoped="scoped">
        [data-flex-id="<?php echo esc_attr($id); ?>"] .flex-control-nav li,
        #<?php echo esc_attr($id); ?> .slide-description{
            color: <?php echo esc_attr($mobile_slider_text_color); ?>;
        }
    </style>

    <script type="text/javascript">
        var $ = jQuery;
        $(function() {
            if (typeof $.flexslider == 'function')
                $('#<?php echo esc_attr($id); ?>').flexslider({
                    animation: "fade",
                    manualControls: $('ol.flex-control-nav[data-flex-id=<?php echo esc_attr($id); ?>] li'),
                    slideshow: <?php echo esc_attr($slideshow) ?>,
                    slideshowSpeed: 3000,
                    selector: '.slides > li',
                    directionNav: false,
                });
        });
        <?php pixflow_callAnimation(); ?>
    </script>

    <?php
    $output .= ob_get_clean();
    return $output;
}

/*-----------------------------------------------------------------------------------*/
/*  Contact Form
/*-----------------------------------------------------------------------------------*/

function pixflow_sc_contactform( $atts, $content = null ){

    if (!(is_plugin_active( 'contact-form-7/wp-contact-form-7.php' ) || defined( 'WPCF7_PLUGIN' ))) {

        $url = admin_url('themes.php?page=install-required-plugins');
        $a='<a href="'.$url.'">Contact Form 7</a>';

       $mis = '<div class="miss-shortcode"><p class="title">'. esc_attr__('Oops!! Something\'s Missing','massive-dynamic').'</p><p class="desc">'.sprintf(esc_attr__('Please install and activat %s to use this shortcode. For importing form styles, please read the description in contact form setting panel.','massive-dynamic'),$a).'</p></div>';

        return $mis;
    }
    $output = '';
    extract( shortcode_atts( array(
        'contactform_id'            =>'' ,
        'contactform_title'         =>'CONTACT FORM',
        'contactform_description'   => 'We are a fairly small, flexible design studio that designs for print and web.',
        'contactform_general_color' => 'rgb(0,0,0)',
        'contactform_field_color'   => 'rgb(255,255,255)',
        'contactform_button_color'  => 'rgb(0,0,0)',
        'contactform_button_hover'  => 'rgba(150,150,150,0.9)',
        'left_right_padding'        => 12,
        'align'        => 'center'
    ), $atts ) );
    $animation = array();
    $animation = pixflow_shortcodeAnimation('md_contactform',$atts);
    $id = pixflow_sc_id('contact-form');

    ob_start(); ?>
    <style scoped="scoped">
        .<?php echo esc_attr($id) ?> .form-title,
        .<?php echo esc_attr($id) ?> .input input,
        .<?php echo esc_attr($id) ?> .input textarea {
            color: <?php echo esc_attr(pixflow_colorConvertor($contactform_general_color,'rgba', 1)); ?>;
        }

        .<?php echo esc_attr($id) ?> .form-description,
        .<?php echo esc_attr($id) ?> .form-input,
        .<?php echo esc_attr($id) ?> .input__label{
            color: <?php echo esc_attr(pixflow_colorConvertor($contactform_general_color,'rgba', 0.7)); ?>;
        }

        .<?php echo esc_attr($id) ?> .form-input ::-webkit-input-placeholder{
            color: <?php echo esc_attr(pixflow_colorConvertor($contactform_general_color,'rgba', 0.7)); ?>;
        }

        .<?php echo esc_attr($id) ?> .form-input ::-moz-placeholder{
            color: <?php echo esc_attr(pixflow_colorConvertor($contactform_general_color,'rgba', 0.7)); ?>;
        }

        .<?php echo esc_attr($id) ?> .form-input :-ms-input-placeholder{
            color: <?php echo esc_attr(pixflow_colorConvertor($contactform_general_color,'rgba', 0.7)); ?>;
        }

        .<?php echo esc_attr($id) ?> .form-input input,
        .<?php echo esc_attr($id) ?> .form-input textarea,
        .<?php echo esc_attr($id) ?> .input__label--hoshi::before,
        .<?php echo esc_attr($id) ?> .input__label--hoshi::after{
            border-color: <?php echo esc_attr(pixflow_colorConvertor($contactform_general_color,'rgba', 0.7)); ?>;
        }

        .<?php echo esc_attr($id) ?> .form-input input,
        .<?php echo esc_attr($id) ?> .input input,
        .<?php echo esc_attr($id) ?> .form-input textarea,
        .<?php echo esc_attr($id) ?> .input textarea{
            background-color: <?php echo esc_attr($contactform_field_color); ?>;
        }

        .<?php echo esc_attr($id) ?> .form-submit input,
        .<?php echo esc_attr($id) ?> .submit-button{
            background-color: <?php echo esc_attr($contactform_button_color); ?> ;
        }

        .<?php echo esc_attr($id) ?> .form-submit input:hover,
        .<?php echo esc_attr($id) ?> .submit-button:hover{
            background-color: <?php echo esc_attr($contactform_button_hover); ?> ;
        }
        .<?php echo esc_attr($id) ?> .wpcf7-response-output{
            color: <?php echo esc_attr(pixflow_colorConvertor($contactform_general_color,'rgba',0.9)); ?>;
        }
        .<?php echo esc_attr($id) ?> .form-container-classic .form-submit input {
            padding: 0 <?php echo esc_attr((int)$left_right_padding+50);?>px;
        }

    </style>
    <div class="contact-form <?php echo esc_attr($id.' '.$animation['has-animation'].' md-align-'.$align) ?>" <?php echo esc_attr($animation['animation-attrs']); ?>>
        <?php if("" != $contactform_title){ ?>
        <h3 class="form-title"><?php echo esc_attr($contactform_title) ?></h3>
        <?php }
        if("" != $contactform_description){ ?>
        <p class="form-description"><?php echo preg_replace("/&lt;(.*?)&gt;/i",'',esc_attr($contactform_description)); ?></p>
        <?php }


        if ($contactform_id == ''){
            global $md_allowed_HTML_tags;
            $cf7 = get_posts( 'post_type="wpcf7_contact_form"&numberposts=-1' );
            if ( is_array($cf7) && count($cf7) > 0){
                $index = count($cf7)-1;
                $contactform_id = $cf7[$index]->ID;
                echo do_shortcode('[contact-form-7 id="'.esc_attr($contactform_id).'"]');
            }else{
                $url = admin_url('themes.php?page=install-required-plugins');
                $a='<a href="'.$url.'">Contact Form 7</a>';
                $mis = '<div class="miss-shortcode"><p class="title">'. esc_attr__('Oops!! Something\'s Missing','massive-dynamic').'</p><p class="desc">'.sprintf(esc_attr__('No Contact Form Found; No Form found, make sure you have created a From in %s before using this shortcode. ','massive-dynamic'),$a).'</p></div>';
                echo wp_kses($mis,$md_allowed_HTML_tags);
            }

        }else if($contactform_id && $contactform_id != 0){
                echo do_shortcode('[contact-form-7 id="'.esc_attr($contactform_id).'"]');
        } ?>
    </div>

    <?php
    pixflow_callAnimation(true);
    return ob_get_clean();
}

/*-----------------------------------------------------------------------------------*/
/*  Skill
/*-----------------------------------------------------------------------------------*/

function pixflow_sc_skill_style1( $atts, $content = null ) {

    $output = $skill_style1_num = '';

    extract( shortcode_atts( array(
        'skill_style1_num' => '4',
        'align' => 'left',
    ), $atts ) );
    $animation = array();
    $animation = pixflow_shortcodeAnimation('md_skill_style1',$atts);

    for( $i=1; $i<=$skill_style1_num; $i++ ){
        $bars[$i] = shortcode_atts( array(
            'skill_style1_percentage_'.$i  => '40',
            'skill_style1_title_'.$i       => 'Title',
            'skill_style1_texts_color_'.$i => '#9b9b9b',
            'skill_style1_color_'.$i       => '#9b9b9b',
        ), $atts );
    }

    $id = pixflow_sc_id('skill_style1');
    $func_id = uniqid();

    $output .= '<div id='.$id.' class="skill-style1 md-align-'.esc_attr($align).'">';

    foreach( $bars as $key=>$bar )
    {
        $title       = $bar['skill_style1_title_'.$key];
        $progressbar = $bar['skill_style1_percentage_'.$key];
        $textsColor  = $bar['skill_style1_texts_color_'.$key];
        $barColor    = $bar['skill_style1_color_'.$key];

        $output .= '<div id="'.$id.$key.'" class="bar-main-container '.esc_attr($animation['has-animation']).'" '.esc_attr($animation['animation-attrs']).'>';
            $output .= '<div>';
                $output .= '<div class="bar-percentage" data-percentage="'. $progressbar .'">0%</div>';
                $output .= '<div class="bar-container">';
                    $output .= '<div class="bar"></div>';
                $output .= '</div>';

                $output .= '<div class="bar-title">'. $title .'</div>';

            $output .= '</div>';
        $output .= '</div>';

        $output .=
            '<style scoped="scoped">
                #'. $id.$key .' .bar{ background-color: '. $barColor .' }
                #'. $id.$key .' .bar-percentage{ color: '. $textsColor .' }
                #'. $id.$key .' .bar-title{ color: '. $textsColor .' }
            </style>';
    }

    $output .= '</div>';  // End skill style1

    ob_start();
    ?>

    <script type="text/javascript">
        "use strict";
        var $ = jQuery;

        if ( typeof pixflow_skill_style1 == 'function' ){
            pixflow_skill_style1( "#<?php echo esc_attr( $id ); ?>" );
        }
        <?php pixflow_callAnimation(); ?>
    </script>

    <?php
    $output .= ob_get_clean();
    return $output;
}






/*-----------------------------------------------------------------------------------*/
/*  Skill 2
/*-----------------------------------------------------------------------------------*/

function pixflow_sc_skill_style2( $atts, $content = null ) {

    $output = $skill_style2_num = '';

    extract( shortcode_atts( array(
        'skill_style2_num' => '4',
        'align' => 'left',
        'skill_style2_texts_color'=> '#4d4d4e',
    ), $atts ) );
    $animation = array();
    $animation = pixflow_shortcodeAnimation('md_skill_style2',$atts);

    for( $i=1; $i<=$skill_style2_num; $i++ ){
        $bars[$i] = shortcode_atts( array(
            'skill_style2_percentage_'.$i  => '40',
            'skill_style2_title_'.$i       => 'Skill Title '.$i,
            'skill_style2_color_'.$i       => '#7b58c3',
        ), $atts );
    }

    $id = pixflow_sc_id('skill_style2');
    $func_id = uniqid();

    $output .= '<div id='.$id.' class="skill-style1 style2 md-align-'.esc_attr($align).'">';

    foreach( $bars as $key=>$bar )
    {
        $title       = $bar['skill_style2_title_'.$key];
        $progressbar = $bar['skill_style2_percentage_'.$key];

        $barColor    = $bar['skill_style2_color_'.$key];

        $output .= '<div id="'.$id.$key.'" class="bar-main-container '.esc_attr($animation['has-animation']).'" '.esc_attr($animation['animation-attrs']).'>';
        $output .= '<div>';
        $output .= '<div class="bar-container">';
        $output .= '<div class="bar-title">'. $title .'</div>';
        $output .= '<div class="bar"></div>';

        $output .= '<div class="back-bar"></div>';

        $output .= '<div class="middle-bar"><div class="circle"></div></div>';

        $output .= '</div>';
        $output .= '<div class="bar-percentage" data-percentage="'. $progressbar .'">0%</div>';



        $output .= '</div>';
        $output .= '</div>';

        $output .=
            '<style scoped="scoped">
                #'. $id.$key .' .bar{ background-color: '. $barColor .' }
                #'. $id.$key .' .middle-bar .circle{ background-color: '. $skill_style2_texts_color .' }
                #'. $id.$key .' .bar-percentage{ color: '. $skill_style2_texts_color .' }
                #'. $id.$key .' .bar-title{ color: '. $skill_style2_texts_color .' }
            </style>';
    }

    $output .= '</div>';  // End skill style1

    ob_start();
    ?>

    <script type="text/javascript">
        "use strict";
        var $ = jQuery;

        if ( typeof pixflow_skill_style1 == 'function' ){
            pixflow_skill_style1( "#<?php echo esc_attr( $id ); ?>" );
        }

        <?php pixflow_callAnimation(); ?>
    </script>

    <?php
    $output .= ob_get_clean();
    return $output;
}





/*-----------------------------------------------------------------------------------*/
/*  Portfolio Multisize
/*-----------------------------------------------------------------------------------*/

require_once(PIXFLOW_THEME_LIB . '/portfolio-walker.php');
// Ajax function to save portfolio
add_action( 'wp_ajax_nopriv_pixflow_portfolio_size', 'pixflow_portfolio_size' );
add_action( 'wp_ajax_pixflow_portfolio_size', 'pixflow_portfolio_size' );
function pixflow_portfolio_size() {
    $nonce = $_POST['nonce'];
    if ( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) )
        die ( '' );

    if ( isset( $_POST['portfolio_size'] ) ) {

        $post_id = $_POST['post_id']; // post id

        if ( function_exists ( 'wp_cache_post_change' ) ) { // invalidate WP Super Cache if exists
            $GLOBALS["super_cache_enabled"]=1;
            wp_cache_post_change( $post_id );
        }

        update_post_meta( $post_id, "_portfolio_size", $_POST['portfolio_size'] );
        return true;
    }
    exit;
}

function pixflow_sc_portfolio_multisize( $atts, $content = null ){
    if (!(defined( 'PX_PORTFOLIO_VER' ))) {
        $url = admin_url('themes.php?page=install-required-plugins');
        $a='<a href="'.$url.'">Pixflow Portfolio</a>';

        $mis = '<div class="miss-shortcode"><p class="title">'. esc_attr__('Oops!! Something\'s Missing','massive-dynamic').'</p><p class="desc">'.sprintf(esc_attr__('Please install and activate %s to use this shortcode','massive-dynamic'),$a).'</p></div>';

        return $mis;
    }
    extract(shortcode_atts(array(
        'multisize_title'           => 'OUR PROJECTS',
        'multisize_meta_position'   => 'inside',
        'multisize_category'        => '',
        'multisize_filters'         => 'yes',
        'multisize_filters_align'   => 'left',
        'multisize_like'            => 'yes',
        'multisize_spacing'         => '0',
        'multisize_filter_color'        => 'rgb(0,0,0)',
        'multisize_text_color'          => 'rgba(191,191,191,1)',
        'multisize_overlay_color'       => 'rgba(0,0,0,0.5)',
        'multisize_frame_color'         => '#fff',
        'multisize_item_number'         => '-1',
        'multisize_load_more'           => 'yes',
        'multisize_button_style'        => 'fade-square',
        'multisize_button_text'         => 'LOAD MORE',
        'multisize_button_icon_class'   => 'icon-plus6',
        'multisize_button_color'        => 'rgba(0,0,0,1)',
        'multisize_button_text_color'   => '#fff',
        'multisize_button_bg_hover_color' => '#9b9b9b',
        'multisize_button_hover_color'  => 'rgb(255,255,255)',
        'multisize_button_size'         => 'standard',
        'multisize_button_padding'      => '0',
        'multisize_detail_target'       => 'popup',
        'multisize_post_count'       => 'no',
        'multisize_counter_color'=>'#ffffff',
        'multisize_counter_background_color'=>'#af72ff',
    ), $atts));
    $animation = array();
    $animation = pixflow_shortcodeAnimation('md_portfolio_multisize',$atts);
    //Get the Page ID
    $pid = 0;
    if(is_page())
        $pid = get_the_ID();

    $portfolioId = pixflow_sc_id('portfolio-multisize');

    //Check detail target
    if($multisize_detail_target !='popup' && $multisize_detail_target !='page' )
    {
         $multisize_detail_target = $multisize_detail_target == 'yes'?'popup':'page';
    }


    if($multisize_detail_target == 'popup'){
        $detailTarget = 'portfolio-popup';
    } else{
        $detailTarget = '';
    }

    //Check the style
    if('inside' != $multisize_meta_position && 'outside' != $multisize_meta_position)
        $multisize_meta_position = 'inside';

    //Item Number
    $items   = max($multisize_item_number, -1);

    //Convert slugs to IDs
    $catArr  = pixflow_slugs_to_ids(explode(',', $multisize_category), 'skills');

    //Show category filter either:
    $catList = '';


     $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    if ( get_query_var('paged') ) {
        $paged = get_query_var('paged');
    } elseif ( get_query_var('page') ) {
        $paged = get_query_var('page');
    } else {
        $paged = 1;
    }


     $queryArgs = array(
        'post_type'      => 'portfolio',
        'posts_per_page' => $items,
        'paged'          => $paged
    );

    //Taxonomy filter
    if(count($catArr))
    {
        $queryArgs['tax_query'] =  array(
            // Note: tax_query expects an array of arrays!
            array(
                'taxonomy' => 'skills',
                'field'    => 'id',
                'terms'    => $catArr
            ));
    }

    $query = new WP_Query($queryArgs);
    $md_portfolio_count=$query->post_count;

    if(count($catArr) == 0 || count($catArr) > 1)
    {
        if('yes'==$multisize_post_count)
        {
            $listCatsArgs = array('title_li' => '', 'taxonomy' => 'skills', 'walker' => new PixflowPortfolioWalker(), 'echo' => 0, 'include' => implode(',', $catArr));
            $catList = '<li class="current have-counter"><a data-filter="*" href="#">'.esc_attr__('All Items', 'massive-dynamic').'</a><span class="md_portfolio_counter">'.$md_portfolio_count.'</span></li>';
            $catList .= wp_list_categories($listCatsArgs);
        }
        else
        {
            $listCatsArgs = array('title_li' => '', 'taxonomy' => 'skills', 'walker' => new PixflowPortfolioWalker(), 'echo' => 0, 'include' => implode(',', $catArr));
            $catList = '<li class="current"><a data-filter="*" href="#">'.esc_attr__('All Items', 'massive-dynamic').'</a></li>';
            $catList .= wp_list_categories($listCatsArgs);
        }

    }

    $filterClass = 'filter';
    ob_start();
    ?>
    <style scoped="scoped">
        .<?php echo esc_attr($portfolioId)?> .md_portfolio_counter{
            background-color: <?php echo esc_attr($multisize_counter_background_color); ?>;
            color: <?php echo esc_attr($multisize_counter_color); ?>;
        }
        <?php if('left' == $multisize_filters_align){ //filter left aligned ?>
        .<?php echo esc_attr($portfolioId)?> .filter{
            float: left;
        }
        .<?php echo esc_attr($portfolioId)?> .title{
            float: right;
        }
        <?php }elseif('center' == $multisize_filters_align){ //filter center aligned ?>
        .<?php echo esc_attr($portfolioId)?> .filter,
        .<?php echo esc_attr($portfolioId)?> .title{
            float: none;
        }
        .<?php echo esc_attr($portfolioId)?> .heading{
            text-align: center;
        }
        <?php }elseif('right' == $multisize_filters_align){ //filter right aligned ?>
        .<?php echo esc_attr($portfolioId)?> .filter{
            float: right;
        }
        .<?php echo esc_attr($portfolioId)?> .title{
            float: left;
        }
        <?php }

        if('yes' != $multisize_filters){ ?>
        .<?php echo esc_attr($portfolioId)?> .title{
            float: none;
        }
        .<?php echo esc_attr($portfolioId)?> .heading{
            text-align: inherit;
        }
        <?php }?>

        .<?php echo esc_attr($portfolioId)?> .filter a{
            color: <?php echo esc_attr(pixflow_colorConvertor($multisize_filter_color,'rgba',0.5)); ?>
        }

        .<?php echo esc_attr($portfolioId)?> .title,
        .<?php echo esc_attr($portfolioId)?> .filter li.current a{
            color: <?php echo esc_attr(pixflow_colorConvertor($multisize_filter_color,'rgba',1)); ?>
        }

        .<?php echo esc_attr($portfolioId)?> .item-title a,
        .<?php echo esc_attr($portfolioId)?> .item-category,
        .<?php echo esc_attr($portfolioId)?> .like-heart,
        .<?php echo esc_attr($portfolioId)?> .like-count{
            color: <?php echo esc_attr($multisize_text_color); ?>
        }

        .<?php echo esc_attr($portfolioId)?> .overlay-background{
            background-color: <?php echo esc_attr($multisize_overlay_color); ?>
        }

        .<?php echo esc_attr($portfolioId)?> .item-image div{
            background-color: <?php echo esc_attr($multisize_frame_color); ?>
        }

        .<?php echo esc_attr($portfolioId)?> .line{
            background-color: <?php echo esc_attr($multisize_text_color); ?>
        }

        .<?php echo esc_attr($portfolioId)?> .heading{
            padding: 0 <?php echo esc_attr($multisize_spacing)?>px;
        }
        <?php if($multisize_like!='yes'){?>
        .<?php echo esc_attr($portfolioId)?> .md-post-like{
            display:none!important;
        }
        <?php }?>
    </style>
    <div class="portfolio portfolio-multisize <?php echo esc_attr($portfolioId.' '.$multisize_meta_position.' '.$animation['has-animation']); ?>" data-id="<?php echo esc_attr($portfolioId)?>" data-items-padding="<?php echo esc_attr($multisize_spacing)?>" <?php echo esc_attr($animation['animation-attrs'])?>>
        <?php if($multisize_title != '' || (strlen($catList) && 'yes' == $multisize_filters)){ ?>
        <div class="heading clearfix">

            <?php if('' != $multisize_title){ ?>
            <h3 class="title"><?php echo esc_attr($multisize_title) ?></h3>
            <?php }

            if(strlen($catList) && 'yes' == $multisize_filters){
            global $md_allowed_HTML_tags;
            ?>
                <div class="<?php echo esc_attr($filterClass); ?> <?php echo esc_attr($multisize_post_count) ?>" >
                    <ul>
                        <?php echo wp_kses($catList,$md_allowed_HTML_tags); ?>
                    </ul>
                </div>
            <?php } ?>
        </div>
        <?php } ?>
        <div class="isotope clearfix portfolio-container">
            <?php while ($query->have_posts()) {
                $query->the_post();

                $terms = get_the_terms( get_the_ID(), 'skills' );

                if('inside' == $multisize_meta_position)
                    pixflow_sc_portfolio_multisize_inside($terms,$pid,$detailTarget);
                else
                    pixflow_sc_portfolio_multisize_outside($terms,$pid,$detailTarget);

            } ?>
        </div>
        <?php if('yes' == $multisize_load_more && $items != -1 ){
            wp_reset_postdata();
            $queryArgs = array (
                'post_type'      => 'portfolio',
                'posts_per_page' =>  $items,
            );
            $query = new WP_Query($queryArgs);
            $ppaged = ( get_query_var('paged') > 1 ) ? get_query_var('paged') : 1;
            $pmax = $query->max_num_pages;
            $count_posts = wp_count_posts( 'portfolio' )->publish;
            $ppostperpage = abs($items) ;
            $maxPages =  ceil ($count_posts / $ppostperpage)  ;
            $multisize_button_url = '#';
            $multisize_button_target = '_self';
            echo pixflow_buttonMaker($multisize_button_style,$multisize_button_text,$multisize_button_icon_class,$multisize_button_url,$multisize_button_target,'center',$multisize_button_size,$multisize_button_color,$multisize_button_hover_color,$multisize_button_padding,$multisize_button_text_color,$multisize_button_bg_hover_color);
            ?>
            <div class="loadmore-button md-hidden" data-portfolio-id="<?php echo esc_attr($portfolioId); ?>" data-startPage="<?php echo esc_attr($ppaged); ?>" data-maxPages="<?php echo esc_attr($maxPages); ?>" data-nextLink="<?php echo next_posts($pmax, false); ?>" data-loadMoreText="<?php echo esc_attr($multisize_button_text); ?>" data-loadingText="<?php echo esc_attr__('Loading ...','massive-dynamic'); ?>" data-noMorePostText="<?php echo esc_attr__('No More Items','massive-dynamic'); ?>">
                <div class="portfolio-pagination container">
                    <?php
                    if(PIXFLOW_USE_CUSTOM_PAGINATION)
                        pixflow_get_pagination($query);
                    else
                        paginate_links($query);
                    ?>
                </div>
            </div>
        <?php } ?>
    </div>
    <script>

        var $ = jQuery;
        $(function(){
            if ( typeof pixflow_portfolioMultisize == 'function' ){

                $('.<?php echo esc_attr($portfolioId)?> .item').each(function(){
                    var item = $('<div></div>');
                    item.attr('class',$(this).attr('class'));
                    item.attr('data-item_id',$(this).attr('data-item_id'));
                    item.html($(this).html());
                    $(this).closest('.isotope').append(item);
                    $(this).remove();
                })
                pixflow_portfolioMultisize();
                if($('.vc_editor').length) {
                    try{pixflow_portfolioItemsPanel();}
                    catch(e){

                    }
                }
            }
        });
        <?php pixflow_callAnimation(); ?>
    </script>
    <?php
    wp_reset_postdata();

    return ob_get_clean();

}

/***************** Multisize Inside function ****************/

function pixflow_sc_portfolio_multisize_inside($terms,$pageID,$detailTarget)
{
    if(0 != $pageID)
        $permalink = add_query_arg( 'pnt', $pageID, get_permalink() );
    else
        $permalink = get_permalink();

    $item_id = get_the_ID();
    $portfolio_size = get_post_meta( $item_id, "_portfolio_size", true );
    $portfolio_size = ($portfolio_size == '')?'thumbnail-small':$portfolio_size;
    ?>

    <div data-item_id="<?php echo esc_attr($item_id); ?>" class="portfolio-item item <?php if($terms) { foreach ($terms as $term) { echo "term-$term->term_id "; } } ?> <?php echo esc_attr($portfolio_size); ?>">
        <div class="item-wrap <?php echo esc_attr($detailTarget);?>" >

            <?php

            if ( function_exists('has_post_thumbnail') && has_post_thumbnail() ){
                //Adding thumbnail
                $thumbSize = "pixflow_multisize-thumb";
                $thumbId= get_post_thumbnail_id( get_the_ID() );
                $thumb = wp_get_attachment_image_src( $thumbId , $thumbSize );
                $thumb = (false == $thumb)?PIXFLOW_PLACEHOLDER1:$thumb[0];
                $thumbLarge = wp_get_attachment_image_src( $thumbId,'large');
                $thumbLarge = (false == $thumbLarge)?PIXFLOW_PLACEHOLDER1:$thumbLarge[0];
            ?>
            <div class="item-image" data-src="<?php echo esc_attr($thumbLarge);?>" style="background-image: <?php echo 'url('. esc_url($thumb) .')';?>"></div>
            <?php
            } ?>
            <div class="overlay-background" href="<?php echo esc_url($permalink); ?>">
                <div class="item-meta">
                    <h3 class="item-title <?php echo esc_attr($detailTarget);?>">
                        <a href="<?php echo esc_url($permalink); ?>"><?php the_title(); ?></a>
                    </h3>
                    <h5 class="item-category"><?php
                        $termNames = array();
                        if($terms)
                            foreach ($terms as $term)
                                $termNames[] = $term->name;


                        echo implode(', ', $termNames);
                        ?>
                    </h5>
                </div>
                <?php echo pixflow_getPostLikeLink( get_the_ID() );?>
            </div>
        </div>
    </div>

<?php
}

/***************** Multisize Outside function ****************/

function pixflow_sc_portfolio_multisize_outside($terms,$pageID,$detailTarget)
{
    if(0 != $pageID)
        $permalink = add_query_arg( 'pnt', $pageID, get_permalink() );
    else
        $permalink = get_permalink();

    $item_id = get_the_ID();
    $portfolio_size = get_post_meta( $item_id, "_portfolio_size", true );
    $portfolio_size = ($portfolio_size == '')?'thumbnail-small':$portfolio_size;
    ?>

    <div data-item_id="<?php echo esc_attr($item_id); ?>" class="portfolio-item item <?php if($terms) { foreach ($terms as $term) { echo "term-$term->term_id "; } } ?> <?php echo esc_attr($portfolio_size); ?>">
        <div class="item-wrap ">
            <?php

            if ( function_exists('has_post_thumbnail') && has_post_thumbnail() ){
                //Adding thumbnail
                $thumbSize = "pixflow_multisize-thumb";
                $thumbId= get_post_thumbnail_id( get_the_ID() );
                $thumb = wp_get_attachment_image_src( $thumbId , $thumbSize );
                $thumb = (false == $thumb)?PIXFLOW_PLACEHOLDER1:$thumb[0];
                $thumbLarge = wp_get_attachment_image_src( $thumbId,'large');
                $thumbLarge = (false == $thumbLarge)?PIXFLOW_PLACEHOLDER1:$thumbLarge[0];
                ?>
                <div class="item-image <?php echo esc_attr($detailTarget);?>" data-src="<?php echo esc_attr($thumbLarge);?>" style="background-image: <?php echo 'url('. esc_url($thumb) .')';?>">
                    <div class="border-top"></div>
                    <div class="border-right"></div>
                    <div class="border-bottom"></div>
                    <div class="border-left"></div>
                    <?php echo pixflow_getPostLikeLink( get_the_ID() );?>
                </div>
            <?php
            } ?>
            <div class="item-meta">
                <div class="line"></div>
                <h3 class="item-title <?php echo esc_attr($detailTarget);?>">
                    <a href="<?php echo esc_url($permalink); ?>"><?php the_title(); ?></a>
                </h3>
                <h5 class="item-category"><?php
                    $termNames = array();
                    if($terms)
                        foreach ($terms as $term)
                            $termNames[] = $term->name;
                    echo implode(', ', $termNames);
                    ?>
                </h5>
            </div>
        </div>
    </div>

<?php
}
/*-----------------------------------------------------------------------------------*/
/*  Video
/*-----------------------------------------------------------------------------------*/

function pixflow_sc_video( $atts, $content = null )
{

    extract(shortcode_atts(array(
        'md_video_host'           => 'youtube',
        'md_video_url_mp4'           => '',
        'md_video_url_webm'           => '',
        'md_video_url_ogg'           => '',
        'md_video_url_youtube'           => 'https://www.youtube.com/watch?v=tcxlSrYEkq8',
        'md_video_url_vimeo'           => '',
        'md_video_style'   => 'color',
        'md_video_solid_color'        => 'rgba(20,20,20,1)',
        'md_video_image'         => '',
        'md_video_size'   => '100',
        'align'   => 'center',
    ), $atts));
    $animation = array();
    $animation = pixflow_shortcodeAnimation('md_video',$atts);
    $id = pixflow_sc_id('video');
    if(is_numeric($md_video_image)){
        $md_video_image =  wp_get_attachment_url( $md_video_image ) ;
        $md_video_image = (false == $md_video_image)?PIXFLOW_PLACEHOLDER1:$md_video_image;
    }
    $md_video_play_image_position = 50;
    $solid_color_max_size = 100;
    $md_video_solid_size = $md_video_size*$solid_color_max_size/100;
    $md_video_play_image_position = $md_video_size*50/100;

    wp_enqueue_script('videojs-script',pixflow_path_combine(PIXFLOW_THEME_JS_URI,'video-js/video.js'),array(),PIXFLOW_THEME_VERSION,true);

    $sources = $dataSetup = $extURL = '';
    if($md_video_host=='self'){
        if($md_video_url_mp4!='')
            $sources .= '<source src="'.esc_url($md_video_url_mp4).'" type="video/mp4">';
        if($md_video_url_webm!='')
            $sources .= '<source src="'.esc_url($md_video_url_webm).'" type="video/webm">';
        if($md_video_url_ogg!='')
            $sources .= '<source src="'.esc_url($md_video_url_ogg).'" type="video/ogg">';
    }elseif($md_video_host=='youtube'){
        wp_enqueue_script('videojs-youtube-script',pixflow_path_combine(PIXFLOW_THEME_JS_URI,'video-js/youtube.js'),array(),PIXFLOW_THEME_VERSION,true);
        $dataSetup = '"techOrder": ["youtube"], "src": "'.esc_url($md_video_url_youtube).'"';
        $extURL = esc_url($md_video_url_youtube);
    }elseif($md_video_host=='vimeo'){
        wp_enqueue_script('videojs-vimeo-script',pixflow_path_combine(PIXFLOW_THEME_JS_URI,'video-js/vjs.vimeo.js'),array(),PIXFLOW_THEME_VERSION,true);
        $dataSetup = '"techOrder": ["vimeo"], "src": "'.esc_url($md_video_url_vimeo).'"';
        $extURL = esc_url($md_video_url_vimeo);
    }

    $opacityColor = pixflow_colorConvertor($md_video_solid_color,'rgba',0.5);
    if($md_video_solid_size < 74){
        $fontSize = '17px';
        $borderSize ='4px';
    }elseif($md_video_solid_size > 74 && $md_video_solid_size < 86){
        $fontSize = '22px';
        $borderSize ='5px';
    }else{
        $fontSize = '28px';
        $borderSize ='6px';
    }
    ob_start();
    global $md_allowed_HTML_tags;
    ?>

    <style>
        .<?php echo esc_attr($id) ?> .play-btn{
            border:<?php echo esc_attr($borderSize) ?> solid <?php echo esc_attr($opacityColor) ?>;
            width: <?php echo esc_attr($md_video_solid_size);?>px;
            height: <?php echo esc_attr($md_video_solid_size);?>px;
        }
        .<?php echo esc_attr($id) ?> .icon-play-curve{
            color: <?php echo esc_attr($md_video_solid_color) ?>;
            font-size: <?php echo esc_attr($fontSize) ?>;
        }

        <?php if( $md_video_style == "squareImage" ) { ?>
            .<?php echo esc_attr($id) ?> .video-img{
            background-image: url(<?php echo esc_url($md_video_image);?>);
            max-width:<?php echo esc_attr($md_video_size)/100*496;?>px;
            height:<?php echo esc_attr($md_video_size)/100*386;?>px;
        }
        <?php } ?>

        <?php
            if($md_video_style == 'circleImage'){
            ?>
        .<?php echo esc_attr($id) ?> .video-img {
            border-radius: 50%;
            overflow: hidden;
            background-image: url(<?php echo esc_attr($md_video_image);?>);
            max-width:<?php echo esc_attr($md_video_size)/100*420;?>px;
            height:<?php echo esc_attr($md_video_size)/100*420;?>px;
        }
        .<?php echo esc_attr($id);?> .video-poster-overlay {
            border-radius: 100%;
        }
        .<?php echo esc_attr($id) ?> .image-play-btn {
            left:50%
        }
        <?php
        }
        ?>
        .<?php echo esc_attr($id);?> .image-play-btn,.<?php echo esc_attr($id);?> .play-btn{
            cursor: pointer;
        }
        iframe<?php echo esc_attr($id);?>_video_vimeo_api{
            height:180%;
            top:-40px;
        }
        .<?php echo esc_attr($id);?> .video-poster-overlay{
            position: absolute;
            background: #000;
            opacity: .3;
            width: 100%;
            height: 100%;
            left:0;
            top:0;
        }

        .<?php echo esc_attr($id) ?> .play-btn:hover{
            border-color: <?php echo esc_attr(pixflow_colorConvertor($md_video_solid_color,'rgba',1))?>;
        }
    </style>
    <div data-id="<?php echo esc_attr($id);?>" class="video video-shortcode <?php echo esc_attr($id.' '.$animation['has-animation'].' md-align-'.$align);?>" <?php echo esc_attr($animation['animation-attrs']);?>>
        <?php
        if($md_video_style == 'color'){
        ?>
            <div class="play-btn">
                <div class="play-helper">
                    <span class="icon-play-curve"></span>
                </div>
            </div>
        <?php }else{ ?>
            <div class="video-img">
                <div class="video-poster-overlay"></div>
                <img src="<?php echo PIXFLOW_THEME_IMAGES_URI . "/play.png"?>" class="image-play-btn">

            </div>
        <?php }?>
            <script type="text/javascript">
                "use strict"
                var $=jQuery;
                $(document).ready(function()
                {
                    if(typeof pixflow_videoShortcode == 'function'){
                        pixflow_videoShortcode('<?php echo esc_attr($id);?>','<?php echo wp_kses($sources,$md_allowed_HTML_tags);?>','<?php echo esc_attr($md_video_host);?>','<?php echo esc_url($extURL);?>')
                    }
                });
            </script>
    </div>
    <?php
    pixflow_callAnimation(true);
    return ob_get_clean();

}

/*-----------------------------------------------------------------------------------
/*  Showcase
/*-----------------------------------------------------------------------------------*/

function pixflow_sc_showcase($atts,$content = null){
    $output='';

    extract( shortcode_atts( array(
        'showcase_count'  => 'three' ,
        'showcase_image1' => PIXFLOW_THEME_IMAGES_URI."/place-holder.jpg",
        'showcase_image2' => PIXFLOW_THEME_IMAGES_URI."/place-holder.jpg",
        'showcase_image3' => PIXFLOW_THEME_IMAGES_URI."/place-holder.jpg",
        'showcase_image4' => PIXFLOW_THEME_IMAGES_URI."/place-holder.jpg",
        'showcase_featured_image' =>PIXFLOW_THEME_IMAGES_URI."/place-holder.jpg",
        'showcase_meta1' =>"no",
        'showcase_meta2' =>"no",
        'showcase_meta3' =>"no",
        'showcase_meta4' =>"no",
        'showcase_meta5' =>"no",
        'showcase_title1' =>"title",
        'showcase_title2' =>"title",
        'showcase_title3' =>"title",
        'showcase_title4' =>"title",
        'showcase_title5' =>"title",
        'showcase_subtitle1' =>"subtitle",
        'showcase_subtitle2' =>"subtitle",
        'showcase_subtitle3' =>"subtitle",
        'showcase_subtitle4' =>"subtitle",
        'showcase_subtitle5' =>"subtitle",
        'showcase_border_color1' =>"rgb(255,255,255)",
        'showcase_border_color2' =>"rgb(255,255,255)",
        'showcase_border_color3' =>"rgb(255,255,255)",
        'showcase_border_color4' =>"rgb(255,255,255)",
        'showcase_border_color5' =>"rgb(255,255,255)",
    ), $atts ) );
    $animation = array();
    $animation = pixflow_shortcodeAnimation('md_skill_style1',$atts);

    $id = pixflow_sc_id('showcase');

    $showcase_count = ( $showcase_count == 'three' ) ? 3 : 5;

    if(is_numeric($showcase_featured_image)){
        $showcase_featured_image =  wp_get_attachment_image_src( $showcase_featured_image, 'full') ;
        $showcase_featured_image = (false == $showcase_featured_image)?PIXFLOW_PLACEHOLDER1:$showcase_featured_image[0];
    }

    ob_start(); ?>

    <div class="carousel <?php echo esc_attr($id.' '.$animation['has-animation']) ?> showcase" <?php echo esc_attr($animation['animation-attrs']) ?>>
        <a class="showcase-feature-image">
            <img class="carousel-shadow" src="<?php echo pixflow_path_combine(PIXFLOW_THEME_IMAGES_URI,'shadow.png')?>">
            <img class="carousel-image" alt="Image Caption" src="<?php echo esc_url($showcase_featured_image) ?>">
            <?php if('yes' == $showcase_meta1){ ?>
                <span class="overlay">
                    <span class="border" style="border-color: <?php echo esc_attr($showcase_border_color1) ?>">
                        <span class="text-container">
                            <h5 class="title"><?php echo esc_attr($showcase_title1) ?></h5>
                            <h6 class="subtitle"><?php echo esc_attr($showcase_subtitle1) ?></h6>
                        </span>
                    </span>
                </span>
            <?php } ?>
        </a>

        <?php
        for($i=1; $i < $showcase_count ; $i++){
            $image_url = ${'showcase_image' . $i};
            if(is_numeric($image_url)){
                $image_url =  wp_get_attachment_image_src( $image_url, 'full') ;
                $image_url = (false == $image_url)?PIXFLOW_PLACEHOLDER1:$image_url[0];
            }
            ?>
        <a>
            <img class="carousel-shadow" src="<?php echo pixflow_path_combine(PIXFLOW_THEME_IMAGES_URI,'shadow.png')?>">
            <img class="carousel-image" alt="Image Caption" src="<?php echo esc_url($image_url)  ?>">
            <?php
            $j = $i + 1 ;
            if('yes' == ${'showcase_meta' . $j}){ ?>
                <span class="overlay">
                    <span class="border" style="border-color: <?php echo esc_attr(${'showcase_border_color'.$j}) ?>">
                        <span class="text-container">
                            <h5 class="title"><?php echo esc_attr(${'showcase_title'.$j}) ?></h5>
                            <h6 class="subtitle"><?php echo esc_attr(${'showcase_subtitle'.$j}) ?></h6>
                        </span>
                    </span>
                </span>
            <?php } ?>
        </a>
        <?php }?>

    </div>
    <?php
    wp_enqueue_script('showcaseScript',pixflow_path_combine(PIXFLOW_THEME_JS_URI,'jquery.waterwheelCarousel.min.js'),array(),PIXFLOW_THEME_VERSION,true);
    ?>

    <script type="text/javascript">
        var $ = jQuery;
        $(function(){
            if(typeof pixflow_shortcodeScrollAnimation == 'function'){
                pixflow_shortcodeScrollAnimation();
            }
        })
        <?php pixflow_callAnimation(); ?>
    </script>

<?php
    $output = ob_get_clean();
    return $output;
}

/*-----------------------------------------------------------------------------------*/
/*  Testimonial Classic
/*-----------------------------------------------------------------------------------*/

function pixflow_sc_testimonial_classic( $atts, $content = null ) {

    $output = $testimonial_classic_num = '';

    extract( shortcode_atts( array(
        'testimonial_classic_title'  => 'TESTIMONIAL',
        'md_testimonial_solid_color' => '#000',
        'testimonial_classic_num'    => '5',
        'md_testimonial_alignment'   => 'left',
        'md_testimonial_text_size'   => 'h5',
    ), $atts ) );
    $animation = array();
    $animation = pixflow_shortcodeAnimation('md_testimonial_classic',$atts);

    for( $i=1; $i<=$testimonial_classic_num; $i++ ){
        $slieds[$i] = shortcode_atts( array(
            'testimonial_classic_img_'.$i      => '',
            'testimonial_classic_desc_'.$i     => 'Ipsum dol conse ctetuer adipis cing elit. Morbi com modo, ipsum sed pharetr gravida, orciut magna rhoncus neque,id pulvinaodio lorem non sansunioto koriot.Morbcom magna rhoncus neque,id',
            'testimonial_classic_name_job_'.$i => 'Randy Nicklson . ATC resident manager co.',
        ), $atts );
    };

    $id = pixflow_sc_id('testimonial_classic');
    $func_id = uniqid();

    $output .= '<div data-flex-id="'.$id.'" clone="false" class="testimonial-classic testimonial-classic-'. $md_testimonial_alignment .' '.esc_attr($animation['has-animation']).'" '.$animation['animation-attrs'].'>';
    $output .= '<h3 data-flex-id="'.$id.'" clone="false" class="title"> <span class="quote icon-quote4"></span> '. $testimonial_classic_title .'</h3>';

    $output .= '<div id="'.$id.'" flex="false" class="flexslider clearfix">';
    $output .= '<ul data-flex-id="'.$id.'" class="slides clearfix">';

    foreach( $slieds as $key=>$slide )
    {
        $image = $slide['testimonial_classic_img_' . $key];
        $description = $slide['testimonial_classic_desc_' . $key];
        $nameJob = $slide['testimonial_classic_name_job_' . $key];

        if ($image != '' && is_numeric($image)) {
            $image = wp_get_attachment_url($image);
            $image = (false == $image)?PIXFLOW_PLACEHOLDER_BLANK:$image;
        }

        $output .= '<li>';
            $output .= '<div class="detail">';
                $output .= '<'. $md_testimonial_text_size .' class="paragraph">'. preg_replace("/&lt;(.*?)&gt;/i",'',esc_attr($description)) .'</'. $md_testimonial_text_size .'>';
            $output .= '</div>';
            if ($image != '')
                $output .= '<div class="slide-image" style="background-image:url(\'' . esc_attr($image) . '\');"></div>';
                $output .= '<div class="name-job">'. $nameJob .'</div>';
        $output .= '</li>';
    }

    $output .= '</ul>';
    $output .= '</div>';
    $output .= '</div>';  // End Testimonial Classic

    ob_start();
    ?>

    <style scoped="scoped">

        [data-flex-id = <?php echo esc_attr($id) ?>].testimonial-classic .title,
        [data-flex-id = <?php echo esc_attr($id) ?>].testimonial-classic .title .quote,
        [data-flex-id = <?php echo esc_attr($id) ?>].testimonial-classic .flexslider .detail .paragraph,
        [data-flex-id = <?php echo esc_attr($id) ?>].testimonial-classic .flexslider .name-job{
            color: <?php echo esc_attr( $md_testimonial_solid_color ); ?>
        }

    </style>

    <script type="text/javascript">
        var $ = jQuery;
        if(typeof $.flexslider == 'function'){
            $('#<?php echo esc_attr($id); ?>').flexslider({
                animation: "fade",
                slideshow: true,
                slideshowSpeed: 5000,
                directionNav: false,
                controlNav: false,
            });
        }
        <?php pixflow_callAnimation(); ?>
    </script>

    <?php
    $output .= ob_get_clean();
    return $output;
}

/*-----------------------------------------------------------------------------------*/
/* Testimonial Carousel
/*-----------------------------------------------------------------------------------*/

function pixflow_sc_testimonial_carousel ($atts, $content = null) {

    extract(shortcode_atts(array(
        'testimonial_carousel_text_color' => '#000',
        'testimonial_carousel_num'        => '3',
        'testimonial_carousel_text_size'  => 'h6',
    ), $atts));

    $html = "";
    $id = pixflow_sc_id('testimonial_carousel');
    $animation = array();
    $animation = pixflow_shortcodeAnimation('md_testimonial_carousel',$atts);

    wp_enqueue_style('carousel_css',pixflow_path_combine(PIXFLOW_THEME_CSS_URI,'owl.carousel.css'),array(),PIXFLOW_THEME_VERSION);
    wp_enqueue_script('carousel_js',pixflow_path_combine(PIXFLOW_THEME_JS_URI,'owl.carousel.min.js'),array(),PIXFLOW_THEME_VERSION,true);


    for( $i=1; $i<=$testimonial_carousel_num; $i++ ){
        $slieds[$i] = shortcode_atts( array(
            'testimonial_carousel_img_'.$i      => PIXFLOW_THEME_IMAGES_URI."/place-holder.jpg",
            'testimonial_carousel_desc_'.$i     => 'orem ipsum dolor sit amet, nec in adipiscing purus luctus, urna pellentesque fringilla vel, non sed arcu integevestibulum in lorem nec',
            'testimonial_carousel_name_'.$i => 'Mari Javani',
            'testimonial_carousel_job_name_'.$i => 'Graphic Designer, Stupids Magazine',
        ), $atts );
    };
    ob_start();
   ?>
    <style scoped="scoped">
        .<?php echo esc_attr($id); ?>.testimonial-carousel .testimonial-carousel-name{
            color:<?php echo esc_attr(pixflow_colorConvertor($testimonial_carousel_text_color,'rgba',1)); ?>
        }
        .<?php echo esc_attr($id); ?>.testimonial-carousel .testimonial-carousel-job-name{
            color:<?php echo esc_attr(pixflow_colorConvertor($testimonial_carousel_text_color,'rgba',0.5)); ?>
        }
        .<?php echo esc_attr($id); ?>.testimonial-carousel .testimonial-carousel-job-text{
            color:<?php echo esc_attr(pixflow_colorConvertor($testimonial_carousel_text_color,'rgb')); ?>
        }
        .<?php echo esc_attr($id); ?>.testimonial-carousel .owl-dots .owl-dot span,
        .<?php echo esc_attr($id); ?>.testimonial-carousel .owl-dots .owl-dot.active span,
        .<?php echo esc_attr($id); ?>.testimonial-carousel .owl-dots .owl-dot:hover span{
            background:<?php echo esc_attr(pixflow_colorConvertor($testimonial_carousel_text_color,'rgba',0.3)); ?>
        }
    </style>

    <div id="owl-demo" class="owl-carousel owl-theme testimonial-carousel <?php echo esc_attr($id.' '.$animation['has-animation']); ?>" <?php echo esc_attr($animation['animation-attrs']); ?>>

    <?php

    foreach( $slieds as $key=>$slide ){

        $authorimg = $slide['testimonial_carousel_img_' . $key];
        $text = $slide['testimonial_carousel_desc_' . $key];
        $author = $slide['testimonial_carousel_name_' . $key];
        $job = $slide['testimonial_carousel_job_name_' . $key];

        if ($authorimg != '' && is_numeric($authorimg)) {
            $authorimg = wp_get_attachment_url($authorimg);
            $authorimg = (false == $authorimg)?PIXFLOW_PLACEHOLDER_BLANK:$authorimg;
        }
       ?>

        <div class="item">
            <div class="clipPath" style="background-image:url(<?php echo esc_attr($authorimg); ?>)"></div>
            <p class="testimonial-carousel-name"><?php echo esc_attr($author); ?></p>
            <p class="testimonial-carousel-job-name"><?php echo esc_attr($job); ?></p>
            <<?php echo esc_attr($testimonial_carousel_text_size); ?> class="testimonial-carousel-job-text"><?php echo preg_replace("/&lt;(.*?)&gt;/i",'',esc_attr($text)); ?></<?php echo esc_attr($testimonial_carousel_text_size); ?>>
        </div>

      <?php
    }
    ?>
    </div>

    <script type="text/javascript">
        var $ = jQuery;
        $(document).ready(function(){
            if(typeof pixflow_testimonialCarousel == 'function'){
                pixflow_testimonialCarousel();
            }
            <?php pixflow_callAnimation(); ?>
        })
    </script>
    <?php
    return ob_get_clean();
}

/*-----------------------------------------------------------------------------------*/
/*  Client Normal
/*-----------------------------------------------------------------------------------*/
function pixflow_sc_client_normal($atts, $content = null){
    $md_client_logo = $md_client_bg = $md_client_general_color = $md_client_text_color = $md_client_text='';
    extract(shortcode_atts(array(
        'md_client_logo'          => PIXFLOW_THEME_IMAGES_URI."/logo.png",
        'md_client_bg_type'       => "color",
        'md_client_bg_img'        => "",
        'md_client_overlay_color' =>"rgb(0,0,0)",
        'md_client_bg_color'      => 'rgb(0,0,0)',
        'md_client_hover_color'   => 'rgb(240,240,0)',
        'md_client_link'          => '#',
        'md_client_text_color'    => 'rgb(240,240,240)',
        'md_client_text'          => 'Creative Digital Agency',

    ), $atts));
    $animation = array();
    $animation = pixflow_shortcodeAnimation('md_client_normal',$atts);
    $id = pixflow_sc_id('clientNormal');

    ob_start();

    if( is_numeric($md_client_logo) ){
        $md_client_logo =  wp_get_attachment_url( $md_client_logo );
        $md_client_logo = (false == $md_client_logo)?PIXFLOW_PLACEHOLDER_BLANK:$md_client_logo;
    }else{
        $md_client_logo = $md_client_logo;
    }

    if(is_numeric($md_client_bg_img)){
        $md_client_bg_img =  wp_get_attachment_image_src( $md_client_bg_img, 'pixflow_client-thumb') ;
        $md_client_bg_img = (false == $md_client_bg_img)?PIXFLOW_PLACEHOLDER_BLANK:$md_client_bg_img[0];
    }

    ?>
    <style scoped="scoped">
        
        <?php if($md_client_bg_type=='image'){ ?>
            .<?php echo esc_attr($id); ?>.client-normal{
                background: url("<?php echo esc_attr($md_client_bg_img); ?>") no-repeat 50% 50%;
            }
            
            .<?php echo esc_attr($id); ?> .content .overlay{
                background-color: <?php echo esc_attr($md_client_overlay_color); ?>;
            }
        
            
        <?php }else{?>
            .<?php echo esc_attr($id); ?>.client-normal{
                background: <?php echo esc_attr($md_client_bg_color); ?>;
            }
            .<?php echo esc_attr($id); ?>.client-normal:hover{
                background: <?php echo esc_attr($md_client_hover_color); ?>;
            }
        <?php } ?>
        
        .<?php echo esc_attr($id); ?>.client-normal .content .title{
            color:<?php echo esc_attr($md_client_text_color); ?>;
        }
    </style>


        <div class="<?php echo esc_attr($id.' '.$animation['has-animation']); ?> client-normal" <?php echo esc_attr($animation['animation-attrs']); ?>>
            <div class="content">
                <?php if($md_client_bg_type=='image'){ ?>
                    <div class="overlay"></div>
                <?php } ?>
                <div class="holder">
                    <div class="logo">
                        <img src="<?php echo esc_attr($md_client_logo);?>" />
                    </div>
                    <a href="<?php echo esc_attr($md_client_link); ?>" target="_blank">
                        <p class="title"><?php echo preg_replace("/&lt;(.*?)&gt;/i",'',esc_attr($md_client_text)); ?></p>
                    </a>
                </div>
            </div>
        </div>
    <script>
        var $ = jQuery;
        $(function(){
            if(typeof pixflow_clientNormal == 'function'){
                pixflow_clientNormal();
            }
        });
        <?php pixflow_callAnimation(); ?>
    </script>
    <?php
    return ob_get_clean();
}

/*-----------------------------------------------------------------------------------*/
/*  Client Carousel
/*-----------------------------------------------------------------------------------*/
function pixflow_sc_client_carousel($atts, $content = null)
{
    $output = $client_carousel_num = $client_play_mode = $client_carousel_number = '';

    wp_enqueue_style('slick-theme', pixflow_path_combine(PIXFLOW_THEME_CSS_URI,'slick-theme.min.css'), array(), PIXFLOW_THEME_VERSION);
    wp_enqueue_style('slick-style', pixflow_path_combine(PIXFLOW_THEME_CSS_URI,'slick.min.css'), array(), PIXFLOW_THEME_VERSION);
    wp_enqueue_script('slick-js', pixflow_path_combine(PIXFLOW_THEME_JS_URI,'slick.min.js'), array(), PIXFLOW_THEME_VERSION, true);

    extract( shortcode_atts( array(
        'client_carousel_num' => '8',
        'client_carousel_number' => '5',
        'client_play_mode'    => 'no'
    ), $atts ) );
    $animation = array();
    $animation = pixflow_shortcodeAnimation('md_client_carousel',$atts);

    for($i=1; $i <= $client_carousel_num ; $i++){
        $slides[$i] = shortcode_atts( array(
            'client_carousel_logo_'.$i => PIXFLOW_THEME_IMAGES_URI."/place-holder.jpg",
        ), $atts );
    }

    $id = pixflow_sc_id('client-carousel');
    $func_id = uniqid();

    $output .= '<div id="'.$id.'" data-autoplay="'. $client_play_mode .'" data-slide-item="'.$client_carousel_number.'" class="wrap-client-carousel clearfix '.esc_attr($animation["has-animation"]).'" '.esc_attr($animation["animation-attrs"]).'>';

        $output .= '<ul class="slides">';

            foreach( $slides as $key=>$slide ){

                $image = $slide['client_carousel_logo_'.$key];

                if ($image != '' && is_numeric($image)) {
                    $image = wp_get_attachment_image_src($image) ;
                    $image = (false == $image)?PIXFLOW_PLACEHOLDER_BLANK:$image[0];
                }

                $output .= ' <li> ';

                    $output .= ' <div class="wrap"> <div class="client-logo"><img src="'. esc_attr($image) .'" /></div> ';

                $output .= ' </li> '; // end wrap

            }

        $output .= ' </ul> ';

    $output .= ' </div> ';

    ob_start();
    ?>

    <script type="text/javascript">

        var $ = jQuery,
            slickTtrackWidth, CTO;

        $('document').ready(function() {

            if (typeof pixflow_teammemberCarousel == 'function') {
                pixflow_teammemberCarousel("<?php echo esc_attr($id) ?>");
            }

        });
        <?php pixflow_callAnimation(); ?>
    </script>

    <?php
    $output .= ob_get_clean();
    return $output;

}

/*-----------------------------------------------------------------------------------*/
/*  Instagram
/*-----------------------------------------------------------------------------------*/
function pixflow_sc_instagram($atts, $content = null)
{
    $md_client_logo = $md_client_bg = $md_client_general_color = $md_client_text_color = $md_client_text = '';
    extract(shortcode_atts(array(
        'instagram_token_access' => '',
        'instagram_title' => 'Follow on Instagram',
        'instagram_image_number' => "4",
        'instagram_heading' => 'yes',
        'instagram_like' => 'yes',
        'instagram_comment' => 'yes',
        'instagram_general_color' => 'rgb(0,0,0)',
        'instagram_overlay_color' => 'rgba(255,255,255,0.6)',
    ), $atts));
    $animation = array();
    $animation = pixflow_shortcodeAnimation('md_instagram',$atts);
    $id = pixflow_sc_id('instagram');
    $redirect_uri = PIXFLOW_THEME_LIB_URI . '/instagram/get_token_access.php';
    $instagram = new pixflow_Instagram(array(
        'apiKey' => 'a0416c7630d74bfb894916fb4c8d0c70',
        'apiSecret' => '9df90946a6c142c9b75e6df51726124c',
        'apiCallback' => 'http://demo2.pixflow.net/instagram-app/redirect.php?redirect_uri=' . urlencode($redirect_uri)
    ));
    if (isset($instagram_token_access) && $instagram_token_access!= '') {
        $token = $instagram_token_access;
    } else {
        $redirect_uri = PIXFLOW_THEME_LIB_URI . '/instagram/get_token_access.php';
        $instagram = new pixflow_Instagram(array(
            'apiKey' => 'a0416c7630d74bfb894916fb4c8d0c70',
            'apiSecret' => '9df90946a6c142c9b75e6df51726124c',
            'apiCallback' => 'http://demo2.pixflow.net/instagram-app/redirect.php?redirect_uri=' . urlencode($redirect_uri)
        ));
        $InstagramloginURL = $instagram->getLoginUrl();

        $a='<a href="'.$InstagramloginURL.'">create a token</a>';

       $mis = '<div class="miss-shortcode"><p class="title">'. esc_attr__('Oops!! Something\'s Missing','massive-dynamic').'</p><p class="desc">'.sprintf(esc_attr__('You need to %s for your instagram account first, then use this shortcode.','massive-dynamic'),$a).'</p></div>';

        return $mis;

    }
    // check authentication
    if ($token !== false && $token != '') {
        // store user access token
        $instagram->setAccessToken($token);
        // now we have access to all authenticated user methods
        $images = $instagram->getUserMedia();
        $user = $instagram->getUser();
        $profile['image'] = $user->data->profile_picture;
        $profile['bio'] = $user->data->bio;
        $profile['username'] = $user->data->username;
        $profile['posts'] = $user->data->counts->media;
        $profile['followers'] = $user->data->counts->followed_by;
        $profile['following'] = $user->data->counts->follows;
        $imagesData = $images->data;
    }
    ob_start();
    ?>
    <style scoped="scoped">
        .<?php echo esc_attr($id) ?> .heading .title,
        .<?php echo esc_attr($id) ?> .heading .username,
        .<?php echo esc_attr($id) ?> .heading .number,
        .<?php echo esc_attr($id) ?> .meta .description,
        .<?php echo esc_attr($id) ?> .overlay-background .description{
            color: <?php echo esc_attr($instagram_general_color) ?>;
        }

        .<?php echo esc_attr($id) ?> .heading .separator{
            background-color: <?php echo esc_attr($instagram_general_color) ?>;
        }

        .<?php echo esc_attr($id) ?> .media .overlay-background{
            background-color: <?php echo esc_attr($instagram_overlay_color) ?>;
        }

        .<?php echo esc_attr($id) ?> .statistic .label {
            color: <?php echo esc_attr(pixflow_colorConvertor($instagram_general_color,'rgba',0.6)); ?>
        }

        .<?php echo esc_attr($id) ?> .statistic .item {
            border-color: <?php echo esc_attr(pixflow_colorConvertor($instagram_general_color,'rgba',0.2)); ?>
        }

        .<?php echo esc_attr($id) ?> .meta .likes,
        .<?php echo esc_attr($id) ?> .meta .comments {
            color: <?php echo esc_attr(pixflow_colorConvertor($instagram_general_color,'rgba',0.7)); ?>
        }

        .<?php echo esc_attr($id) ?> .meta .likes i,
        .<?php echo esc_attr($id) ?> .meta .comments i {
            color: <?php echo esc_attr(pixflow_colorConvertor($instagram_general_color,'rgba',0.5)); ?>
        }
    </style>
    <div class="instagram <?php echo esc_attr($id.' '.$animation['has-animation']) ?>" <?php echo esc_attr($animation['animation-attrs']) ?>>
        <?php if ('yes' == $instagram_heading) {
            $avatar = $profile['image'];
            $username = $profile['username'];
            ?>
            <div class="heading clearfix">
                <div class="left-aligned clearfix">
                    <div class="avatar" style="background-image: url('<?php echo esc_url($avatar); ?>')"></div>
                    <div class="title-holder">
                        <a href="https://instagram.com/<?php echo esc_attr($username); ?>" target="_blank">
                        <?php if ($instagram_title != '') { ?>
                            <h3 class="title"><?php echo esc_attr($instagram_title); ?></h3>
                            <div class="separator"></div>
                        <?php } ?>
                        <h4 class="username">@<?php echo esc_attr($username); ?></h4>
                        </a>
                    </div>
                </div>
                <div class="right-aligned statistic clearfix">
                    <div class="item">
                        <span class="number"><?php echo esc_attr($profile['posts']); ?></span>
                        <h6 class="label"><?php echo esc_attr__('Posts', 'massive-dynamic'); ?></h6>
                    </div>
                    <div class="item">
                        <span class="number"><?php echo esc_attr($profile['followers']); ?></span>
                        <h6 class="label"><?php echo esc_attr__('Followers', 'massive-dynamic'); ?></h6>
                    </div>
                    <div class="item">
                        <span class="number"><?php echo esc_attr($profile['following']); ?></span>
                        <h6 class="label"><?php echo esc_attr__('Following', 'massive-dynamic'); ?></h6>
                    </div>
                </div>


            </div>
        <?php } ?>
        <div class="photo-list clearfix">
        <?php
        if(isset($images->data) && is_array($images->data)){
            $counter = 1;
            foreach ($images->data as $media) {
                if($counter > $instagram_image_number){
                    break;
                }
                $likes = $media->likes->count;
                $comments = $media->comments->count;
                $comment = $media->caption->text;
                ?>
                <div class="item">
                    <div class="media">
                    <?php
                    if ($media->type === 'video') {
                        // video
                        $poster = $media->images->low_resolution->url;
                        $source = $media->videos->standard_resolution->url;
                    ?>
                        <video class="item-image video-js vjs-default-skin" width="250" height="250" poster="<?php echo esc_url($poster) ?>"
                       data-setup='{"controls":true, "preload": "auto"}'>
                         <source src="<?php echo esc_url($source) ?>" type="video/mp4" />
                       </video>";
                    <?php
                    } else {
                        // image
                        $image = $media->images->low_resolution->url;
                        ?>
                        <div class="item-image" style="background-image: url('<?php echo esc_url($image)?>')"></div>
                    <?php }
                    ?>
                        <div class="overlay-background">
                            <p class="description"><?php echo esc_attr($comment)?></p>
                        </div>
                    </div>
                    <div class="meta clearfix">
                        <?php if(strlen($comment) > 15){
                            $comment = substr($comment,0,15).'...';
                        } ?>
                        <h5 class="description"><?php echo esc_attr($comment)?></h5>
                        <?php if ('yes' == $instagram_comment){ ?> <span class="comments"><i class="icon-comment"></i><?php echo esc_attr($comments) ?> </span> <?php } ?>
                        <?php if ('yes' == $instagram_like){ ?> <span class="likes"><i class="icon-heart"></i><?php echo esc_attr($likes) ?> </span> <?php } ?>
                    </div>
                </div>
            <?php
                $counter++;
            }
        }
        ?>
        </div>
    </div>
    <script type="text/javascript">
        var $ = jQuery;

        if ( typeof pixflow_instagramShortcode == 'function' ){
            pixflow_instagramShortcode();
        }
        <?php pixflow_callAnimation(); ?>
    </script>
    <?php
    return ob_get_clean();
}

/*----------------------------------------------------------------
                    Calendar Blog
-----------------------------------------------------------------*/
function pixflow_sc_blog( $atts, $content = null ){
    $query=$output=$blog_bg=$blog_post_number=
    $blog_category=$blog_forground_color=$blog_background_color=$id= '';
    $list=$day=array();
    $i=0;

    extract( shortcode_atts( array(

        'blog_bg'               =>'',
        'blog_post_number'      =>'5' ,
        'blog_category'         => '',
        'blog_forground_color'  => 'rgb(255,255,255)',
        'blog_background_color' => 'rgb(0,0,0)',
    ), $atts ) );
    $animation = array();
    $animation = pixflow_shortcodeAnimation('md_blog',$atts);
    $id = pixflow_sc_id('blog');

    $arrg =  array(
        'category_name'  => $blog_category,
        'posts_per_page' => (int)$blog_post_number,
    ) ;

    $query = new WP_Query($arrg);

    if(is_numeric($blog_bg)){
        $blog_bg =  wp_get_attachment_image_src( $blog_bg, 'full') ;
        $blog_bg = (false == $blog_bg)?PIXFLOW_PLACEHOLDER1:$blog_bg[0];
    }
    ob_start();
    ?>
    <style scoped="scoped">
        .<?php echo esc_attr($id)?>{
            background-image: url('<?php echo esc_attr($blog_bg);?>');
            border-color:<?php echo pixflow_colorConvertor(esc_attr($blog_forground_color),'rgba',0.3); ?>
        }

        .<?php echo esc_attr($id)?> .blog-container{
            border-color:<?php echo pixflow_colorConvertor(esc_attr($blog_forground_color),'rgba',0.3); ?>
        }

        .<?php echo esc_attr($id)?> .blog-overlay{
            background-color: <?php echo pixflow_colorConvertor(esc_attr($blog_background_color),'rgba',0.8); ?>
        }

        .<?php echo esc_attr($id)?>.calendar-blog p,
        .<?php echo esc_attr($id)?>.calendar-blog h6{
            color:<?php echo pixflow_colorConvertor(esc_attr($blog_forground_color),'rgba',0.7); ?>
        }

        .<?php echo esc_attr($id)?> .blog-container:hover p,
        .<?php echo esc_attr($id) ?> .blog-container:hover h6{
            color:<?php echo pixflow_colorConvertor(esc_attr($blog_forground_color),'rgba',1); ?>
        }


    </style>

    <div class="<?php echo esc_attr($id.' '.$animation['has-animation']);?> calendar-blog" <?php echo esc_attr($animation['animation-attrs']);?>>
        <div class="blog-overlay"></div>
        <?php while ($query->have_posts()) {
            $i++;
            $query->the_post();
            global $post;
            ?>
        <a class="blog-container" href="<?php the_permalink(); ?>">
            <?php if (has_post_thumbnail()) {
                $thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ),'pixflow_post-thumbnail-calendar');
                $thumbnail_src = (false == $thumbnail_src)?PIXFLOW_PLACEHOLDER_BLANK:$thumbnail_src[0];
                ?>
                <div class="image" style='background-image: url("<?php echo esc_url($thumbnail_src); ?>")'></div>
            <?php }?>
            <h6 class="blog-day"><?php echo get_the_time('j'); ?></h6>
            <p class="blog-month"><?php echo get_the_time('F'); ?></p>
            <p class="blog-year"><?php echo get_the_time('Y') ?></p>
            <p class="blog-title"> <?php the_title(); ?></p>
            <p class="blog-details">
                    <span class="blog-cat">
                        <?php
                        $catNames = array();
                        $terms = get_the_category($post->ID);
                        if($terms)
                            foreach ($terms as $term)
                                $catNames[] = $term->name;
                        echo implode(', ', $catNames);
                        ?>
                    </span>
                <span class="blog-comment"><?php comments_number('0','1','%');?></span>
            </p>

        </a>
        <?php }?>

        <div class="clearfix"></div>
    </div>
    <script>

        var $ = jQuery;
        $(function(){
            if ( typeof pixflow_calendarBlog == 'function' ){
                pixflow_calendarBlog('<?php echo esc_attr($id); ?>',<?php echo esc_attr($i); ?>);
                var doIt;
                $(window).resize(function () {
                    if(doIt){
                        clearTimeout(doIt);
                    }
                    doIt = setTimeout(function(){
                        pixflow_calendarBlog(<?php echo esc_attr($i); ?>);
                    },150)
                });
            }
        })
        <?php pixflow_callAnimation(); ?>
    </script>
    <?php
    wp_reset_postdata();

    return ob_get_clean();

}

/*----------------------------------------------------------------
                    List
-----------------------------------------------------------------*/
function pixflow_sc_list( $atts, $content = null ){
    $output = '';
    extract( shortcode_atts( array(
        'list_style'               =>'number',
        'list_icon_class'      =>'icon-checkmark' ,
        'list_general_color'         => '#a3a3a3',
        'list_hover_color'  => '#e45d75',
        'list_item_num' => 5,
        'align' => 'left'
    ), $atts ) );
    $animation = array();
    $animation = pixflow_shortcodeAnimation('md_list',$atts);
    for($i=1; $i<=$list_item_num; $i++){
        $items[$i] = shortcode_atts( array(
            'list_item_'.$i => 'This is text for item'.$i,
        ), $atts );
    }
    $id = pixflow_sc_id('list');
    $list_starter = ($list_style == 'icon')?'<ul>':'<ol>';
    $list_finisher = ($list_style == 'icon')?'</ul>':'</ol>';
    ob_start();
    ?>
    <style scoped="scoped">

        .<?php echo esc_attr($id) ?> ul > li span{
            color: <?php echo esc_attr($list_hover_color); ?>;
            border-color: <?php echo esc_attr($list_hover_color); ?>;
        }
        .<?php echo esc_attr($id) ?> li,
        .<?php echo esc_attr($id) ?> li p{
            color: <?php echo esc_attr($list_general_color); ?>;
        }
        .<?php echo esc_attr($id) ?> li:hover,
        .<?php echo esc_attr($id) ?> li:hover p,
        .<?php echo esc_attr($id) ?> ol > li:hover:before{
            color: <?php echo esc_attr($list_hover_color); ?>;
        }
    </style>
    <div class="<?php echo esc_attr($id.' '.$animation['has-animation'].' md-align-'.$align) ?> list-shortcode" <?php echo esc_attr($animation['animation-attrs']) ?>>
        <?php global $md_allowed_HTML_tags;  echo wp_kses($list_starter,$md_allowed_HTML_tags);?>
            <?php
            foreach($items as $key=>$item){
                $title  = $item['list_item_'.$key];
                if('' != $title) {?>
                    <li>
                        <?php if($list_style == 'icon'){ ?>
                            <span class="<?php echo esc_attr($list_icon_class) ?>"></span>
                        <?php } ?>
                        <p><?php echo esc_attr($title); ?></p>
                    </li>
                <?php } ?>
            <?php } ?>
        <?php echo wp_kses($list_finisher,$md_allowed_HTML_tags); ?>
    </div>
    <?php
    pixflow_callAnimation(true);
    return ob_get_clean();
}

/*----------------------------------------------------------------
                    Process Step
-----------------------------------------------------------------*/
function pixflow_sc_process_steps( $atts, $content = null ){
    $output = '';
    extract( shortcode_atts( array(
        'pstep_step_num'  =>4,
        'pstep_style'  =>'color',
        'pstep_border_color'  =>'rgba(176,227,135,1)',
        'pstep_overlay_color'  =>'rgba(0,0,0,0.5)',
        'pstep_general_color'  =>'rgb(0,0,0)',
    ), $atts ) );

    for($i=1; $i<=$pstep_step_num; $i++){
        $steps[$i] = shortcode_atts( array(
            'pstep_image_'.$i => PIXFLOW_THEME_IMAGES_URI."/place-holder.jpg",
            'pstep_size_'.$i => 'small',
            'pstep_title_'.$i => "Step ".$i,
            'pstep_desc_'.$i => "Description of step".$i,
            'pstep_caption_'.$i => '201'.$i,
        ), $atts );
    }
    $id = pixflow_sc_id('process-steps');
    ob_start();
    ?>
    <style scoped="scoped">
        <?php if('color' == $pstep_style){ ?>

        .<?php echo esc_attr($id) ?> .circle{
            border: 2px solid <?php echo esc_attr($pstep_border_color) ?>;
        }

        <?php } ?>
        .<?php echo esc_attr($id) ?> .caption,
        .<?php echo esc_attr($id) ?> .title {
            color: <?php echo esc_attr($pstep_general_color) ?>
        }

        .<?php echo esc_attr($id) ?> .description {
            color: <?php echo esc_attr(pixflow_colorConvertor($pstep_general_color,'rgba', 0.6)) ?>
        }

        .<?php echo esc_attr($id) ?> .separator {
            border-top: 2px dotted <?php echo esc_attr(pixflow_colorConvertor($pstep_general_color,'rgba', 0.6)) ?>;
        }

        .<?php echo esc_attr($id) ?> .overlay-background{
            background-color: <?php echo esc_attr($pstep_overlay_color) ?>;
        }

    </style>
    <div class="process-steps <?php echo esc_attr($id) ?>  clearfix">
    <?php
    if(is_array($steps)){
    foreach($steps as $key=>$step) {
        $img = $step['pstep_image_' . $key];
        $size = $step['pstep_size_' . $key];
        $title = $step['pstep_title_' . $key];
        $desc = $step['pstep_desc_' . $key];
        $caption = $step['pstep_caption_' . $key];
        $inlineStyle = '';
        if('image' == $pstep_style){
            if (is_numeric($img)) {
                $img = wp_get_attachment_url($img);
                $img = (false == $img)?PIXFLOW_PLACEHOLDER1:$img;
            }
        } else{
            $img = '';
        }
        ?>
        <div class="step <?php echo esc_attr($size); ?>">
            <div class="circle" style="background-image:url('<?php echo esc_url($img)?>')">
                <span class="caption"><?php echo esc_attr($caption); ?></span>
                <div class="separator"></div>
                <?php if('image' == $pstep_style){ ?>
                <div class="overlay-background"></div>
                <?php } ?>
            </div>
            <h4 class="title"><?php echo esc_html($title); ?></h4>
            <p class="description"><?php echo preg_replace("/&lt;(.*?)&gt;/i",'',esc_attr($desc)); ?></p>
        </div>
    <?php }} ?>
    </div>
    <script type="text/javascript">
        var $ = jQuery;
        $(document).ready(function(){
            if ( typeof pixflow_processSteps == 'function' ){
                pixflow_processSteps();
            }
            if (typeof  pixflow_shortcodeScrollAnimation == 'function'){
                pixflow_shortcodeScrollAnimation();
            }
        })


    </script>
    <?php
    return ob_get_clean();
}


/*-----------------------------------------------------------------------------------*/
/*  MD Music
/*-----------------------------------------------------------------------------------*/

function pixflow_sc_music( $atts, $content = null ) {

    $output = $music_num = '';
    $tracks = array();
    extract( shortcode_atts( array(
        'music_num'          => 7,
        'music_album'        => 'Audio Jungle',
        'music_artist'       => 'PR_MusicProductions',
        'music_texts_color'  => 'rgb(80,80,80)',
        'music_played_color' => 'rgb(106, 222, 174)',
        'music_alignment'    => 'right-music-panel',
        'music_image'        =>  PIXFLOW_THEME_IMAGES_URI."/place-holder.jpg",
        'align'        =>  'center',
    ), $atts ) );

    if ($music_image != '' && is_numeric($music_image)){
        $music_image = wp_get_attachment_image_src($music_image, 'pixflow_music-thumb');
        $music_image = (false == $music_image)?PIXFLOW_PLACEHOLDER1:$music_image[0];
    }

    for( $i=1; $i<=$music_num; $i++ ){
        $tracks[$i] = shortcode_atts( array(
            'music_track_name_'.$i => "Inspiring ".$i,
            'music_track_url'.$i   => 'https://0.s3.envato.com/files/131328937/preview.mp3',
        ), $atts );
    }

    $id = pixflow_sc_id('music');
    $func_id = uniqid();

    wp_enqueue_script('jplayer-js',pixflow_path_combine(PIXFLOW_THEME_JS_URI,'jPlayer.min.js'),array(),PIXFLOW_THEME_VERSION,true);
    ob_start();

    ?>

    <div id="<?php echo esc_attr($id); ?>" class="music-sc <?php echo esc_attr($music_alignment.' md-align-'.$align); ?> clearfix">

        <div class="wrap-image">
            <span class="image-album">
                <span class="image" style="background-image:url('<?php echo esc_attr($music_image); ?>');"></span>
                <img src="<?php echo PIXFLOW_THEME_IMAGES_URI . "/music-shadow.png"?>" class="image-shadow" alt="music image shadow" />
                <span class="disc-image"></span>

                <div class="btnSimulate"></div>
            </span>

            <div class="main-album-name"> <?php echo esc_attr($music_album); ?> </div>
            <div class="artist"> <?php echo esc_attr($music_artist); ?> </div>
        </div> <!-- End wrap-image -->

        <div class="music-main-container">

            <ol class="tracks">
                <?php
                if(is_array($tracks)) {
                    foreach ($tracks as $key => $track) {
                        $track_name = $track['music_track_name_' . $key];
                        ?>
                        <li class="track">

                            <i class="music-hoverd icon-play"></i>

                            <div id="<?php echo esc_attr($id) . $key?>-track" class="track-bar"></div>

                            <div id="<?php echo esc_attr($id) . $key?>-inner-track"
                                 class="jp-audio <?php echo esc_attr($id) . $key?>-class" role="application"
                                 aria-label="media player">

                            <span class="link jp-play">
                                <span class="track-name"> <?php echo esc_attr($track_name); ?> </span>
                                <span class="track-album-name"> <?php echo esc_attr($music_album); ?> </span>
                            </span>

                                <div class="jp-type-single">

                                    <div class="jp-gui jp-interface">

                                        <div class="jp-controls-holder">

                                            <div class="jp-progress">
                                                <div class="jp-seek-bar">
                                                    <div class="jp-play-bar"></div>
                                                </div>
                                            </div>

                                        </div>
                                        <!-- End jp-controls-holder -->

                                    </div>
                                    <!-- End jp-interface -->

                                    <div class="jp-duration" role="timer" aria-label="duration"></div>
                                    <span class="music-bar"></span>

                                </div>
                                <!-- End jp-type-single -->

                                <div class="jp-controls <?php echo esc_attr($id) . $key?>-class">
                                    <button class="jp-play play-pause" role="button" tabindex="0">
                                        <div class="icon icon-play"></div>
                                    </button>
                                </div>

                            </div>
                            <!-- End jp-audio -->


                            <script type="text/javascript">
                                "use strict";

                                var $ = jQuery;
                                $(function () {
                                    $('#<?php echo esc_attr($id).'1'?>-class').show();
                                    if (typeof $.jPlayer == 'function') {
                                        $("#<?php echo esc_attr($id).$key?>-track").jPlayer({
                                            ready: function () {
                                                $(this).jPlayer("setMedia", {
                                                    m4a: "<?php echo esc_attr( $track['music_track_url'.$key] ); ?>",
                                                    oga: "<?php echo esc_attr( $track['music_track_url'.$key] ); ?>",
                                                });
                                            },
                                            play: function () {
                                                $(this).jPlayer("pauseOthers", 0); // stop all players except this one.
                                            },
                                            cssSelectorAncestor: "#<?php echo esc_attr($id).$key?>-inner-track",
                                            swfPath: "/js",
                                            supplied: "m4a, oga, mp3",
                                            useStateClassSkin: true,
                                            autoBlur: true,
                                            smoothPlayBar: true,
                                            keyEnabled: true,
                                            remainingDuration: false,
                                            toggleDuration: true,
                                        });

                                    }
                                });

                            </script>

                        </li>
                    <?php
                    }
                }
                ?>
            </ol>
        </div> <!-- End music-main-container -->

        <style scoped="scoped">


            #<?php echo esc_attr($id); ?>.music-sc .track,
            #<?php echo esc_attr($id); ?>.music-sc .track-name,
            #<?php echo esc_attr($id); ?>.music-sc .track-album-name,
            #<?php echo esc_attr($id); ?>.music-sc .main-album-name,
            #<?php echo esc_attr($id); ?>.music-sc .artist{
                color: <?php echo esc_attr($music_texts_color) ?>;
            }

            #<?php echo esc_attr($id); ?>.music-sc .track:first-child{
                border-top-color: <?php echo (pixflow_colorConvertor($music_texts_color,'rgba',0.6)) ?>;
            }

            #<?php echo esc_attr($id); ?>.music-sc .music-played,
            #<?php echo esc_attr($id); ?>.music-sc .music-played .track-name{
                color: <?php echo esc_attr($music_played_color) ?>;
            }

            #<?php echo esc_attr($id); ?>.music-sc .music-played .jp-audio .jp-play-bar{
                background-color: <?php echo esc_attr($music_played_color) ?>;
            }

            #<?php echo esc_attr($id); ?>.music-sc .jp-audio .jp-duration{
                color: <?php echo esc_attr(pixflow_colorConvertor($music_texts_color,'rgba',0.7)) ?>;
            }

            #<?php echo esc_attr($id); ?>.music-sc .jp-audio .jp-progress{
                background-color: <?php echo esc_attr(pixflow_colorConvertor($music_texts_color,'rgba',0.6)) ?>;
            }

            #<?php echo esc_attr($id); ?>.music-sc .jp-audio .jp-play-bar{
                background-color: <?php echo esc_attr($music_texts_color) ?>;
            }

        </style>

    </div> <!-- End music -->

    <script>

        "use strict";
        var $ = (jQuery),
            playedFlag = false;

        $(function() {
            if ( typeof pixflow_music == 'function' )
            {
                pixflow_music('<?php echo esc_attr($id) ?>');
            }
            if ( typeof pixflow_shortcodeScrollAnimation == 'function' )
            {
                pixflow_shortcodeScrollAnimation();
            }

            $('.jp-audio').click( function() {

                setTimeout(function(){
                    $('.music-sc .track').removeClass('music-played');
                    $('.jp-state-playing').parent().addClass('music-played');
                    playedFlag = true;
                }, 100);

            });

            var clearHoverIn1, clearHoverIn2;

            $('.track').hover( function() {

                //clearTimeout(clearHoverOut);
                var $this = $(this);

                if (!playedFlag) {

                    clearHoverIn1 = setTimeout( function() {
                        $this.css({ listStyle: 'none' });
                    }, 170);

                    clearHoverIn2 = setTimeout( function() {
                        $this.find('.music-hoverd').css({ opacity: '1', left: '0' });
                    }, 200);
                }

                playedFlag = false;

            }
            , function() {

                var $this = $(this);
                clearTimeout(clearHoverIn1);
                clearTimeout(clearHoverIn2);

                $('.music-hoverd').css({ opacity: '0', left: '-5px' });

                setTimeout( function() {
                    $this.css({ listStyle: 'inherit' });
                }, 200);

            });
        });


    </script>

    <?php
    $output .= ob_get_clean();
    return $output;
}

/*----------------------------------------------------------------
                    Separator
-----------------------------------------------------------------*/

function pixflow_sc_separator( $atts, $content = null ){
    $output = '';
    extract( shortcode_atts( array(
        'separator_style'  =>'line',
        'separator_size'  =>'5',
        'separator_width'  =>'70',
        'separator_color' =>'#ccc',
        'align' =>'center'
    ), $atts ) );
    $animation = array();
    $animation = pixflow_shortcodeAnimation('md_separator',$atts);
    $id = pixflow_sc_id('separator');
    ob_start();
    if($separator_style == 'line') {
    ?>
        <style scoped="scoped">
        .<?php echo esc_attr($id)?>{
            height:<?php echo esc_attr($separator_size)?>px;
            border-radius:10px;
            width:<?php echo esc_attr($separator_width.'%')?>;
            background:<?php echo esc_attr($separator_color)?>;
        }
        </style>
    <?php
    }
    ?>
    <div class="sc-separator <?php echo esc_attr($id.' '.$animation['has-animation'].' md-align-'.$align) ?> clearfix" <?php echo esc_attr($animation['animation-attrs']) ?>>
        <?php
        if($separator_style == 'shadow'){
            ?>
            <img src="<?php echo pixflow_path_combine(PIXFLOW_THEME_IMAGES_URI,'separator-shadow.png')?>">
            <?php
        }
        ?>
    </div>
    <?php
    pixflow_callAnimation(true);
    return ob_get_clean();
}

/*----------------------------------------------------------------
                    Subscribe
-----------------------------------------------------------------*/
function pixflow_sc_subscribe( $atts, $content = null ){
    if ( !shortcode_exists( 'mc4wp_form' ) ) {
        $url = admin_url('themes.php?page=install-required-plugins');
        $a='<a href="'.$url.'">MailChimp for WordPress Lite</a>';
        $mis = '<div class="miss-shortcode"><p class="title">'. esc_attr__('Oops!! Something\'s Missing','massive-dynamic').'</p><p class="desc">'.sprintf(esc_attr__('Please install and activate "%s" to use this shortcode.','massive-dynamic'),$a).'</p></div>';
        return $mis;
    }
    $mailChimp = get_posts( 'post_type="mc4wp-form"&numberposts=1' );
    if ( empty($mailChimp)){
        $url = admin_url('/admin.php?page=mailchimp-for-wp-forms&view=add-form');
        $a='<a href="'.$url.'">MailChimp for WordPress Lite</a>';
        $mis = '<div class="miss-shortcode"><p class="title">'. esc_attr__('Oops!! Something\'s Missing','massive-dynamic').'</p><p class="desc">'.sprintf(esc_attr__('Please create a form in " %s" plugin before using this shortcode. ','massive-dynamic'),$a).'</p></div>';
        return $mis;
    }
    $output = '';
    extract( shortcode_atts( array(
        'subscribe_bgcolor' =>'#ebebeb',
        'subscribe_input_radius' =>'35',
        'subscribe_title'  =>'SUBSCRIBE',
        'subscribe_sub_title'  => 'Sign up to receive news and updates',
        'subscribe_textcolor' =>'#000',
        'subscribe_input_style' => 'fill',
        'subscribe_input_skin' => 'light',
        'subscribe_input_opacity' => '100',
        'subscribe_button_bgcolor'=>'#c7b299',
        'subscribe_button_textcolor'=>'#FFF',
        'subscribe_successcolor'=>'rgba(116, 195, 116,1)',
        'subscribe_errorcolor'=>'#FF6A6A',

    ), $atts ) );
    $animation = array();
    $animation = pixflow_shortcodeAnimation('md_subscribe',$atts);
    if(strpos($subscribe_textcolor, 'rgb(') !== false){
        $subscribe_textcolor = pixflow_colorConvertor($subscribe_textcolor,'rgba',1);
    }

    $id = pixflow_sc_id('subscribe');
    $skinColor = ('dark' == $subscribe_input_skin)?'#000':'#FFF';
    $skinTextColor = ('dark' == $subscribe_input_skin)?'#FFF':'#000';

    ob_start();
    ?>
    <style scoped="scoped">
        .<?php echo esc_attr($id)?>{
            background: <?php echo esc_attr($subscribe_bgcolor);?>;
            color: <?php echo esc_attr($subscribe_textcolor)?>;
        }
        .<?php echo esc_attr($id)?> .subscribe-title{
            color: <?php echo esc_attr($subscribe_textcolor)?>;
        }
        .<?php echo esc_attr($id)?> .subscribe-textbox,
        .<?php echo esc_attr($id)?> .subscribe-button{
            border-radius: <?php echo esc_attr($subscribe_input_radius)?>px;
        }
        .<?php echo esc_attr($id)?> .subscribe-textbox{
            border: 2px solid;
            color: <?php echo pixflow_colorConvertor($skinTextColor,'rgba',1)?>;
        }
        <?php if('fill' == $subscribe_input_style){ ?>
        .<?php echo esc_attr($id)?> .subscribe-textbox{
            background-color: <?php echo pixflow_colorConvertor($skinColor,'rgba',(int)$subscribe_input_opacity * 0.01)?>;
            border-color: <?php echo pixflow_colorConvertor($skinColor,'rgba',0)?>;
        }
        <?php }else{ ?>
        .<?php echo esc_attr($id)?> .subscribe-textbox{
            border-color: <?php echo pixflow_colorConvertor($skinColor,'rgba',(int)$subscribe_input_opacity * 0.01)?>;
        }
        <?php } ?>

        .<?php echo esc_attr($id) ?> .subscribe-textbox::-webkit-input-placeholder {
            color: <?php echo pixflow_colorConvertor($skinTextColor,'rgba',0.6)?>;
        }
        .<?php echo esc_attr($id) ?> .subscribe-textbox:-moz-placeholder { /* Firefox 18- */
            color: <?php echo pixflow_colorConvertor($skinTextColor,'rgba',0.6)?>;
        }
        .<?php echo esc_attr($id) ?> .subscribe-textbox::-moz-placeholder {  /* Firefox 19+ */
            color: <?php echo pixflow_colorConvertor($skinTextColor,'rgba',0.6)?>;
        }
        .<?php echo esc_attr($id) ?> .subscribe-textbox:-ms-input-placeholder {
            color: <?php echo pixflow_colorConvertor($skinTextColor,'rgba',0.6)?>;
        }

        .<?php echo esc_attr($id) ?> .subscribe-button{
            background: <?php echo esc_attr($subscribe_button_bgcolor);?>;
            color: <?php echo esc_attr($subscribe_button_textcolor);?>;
        }
        .<?php echo esc_attr($id) ?> .subscribe-button:hover{
            background: <?php echo esc_attr($subscribe_button_textcolor);?>;
            color: <?php echo esc_attr($subscribe_button_bgcolor);?>;
        }

        <?php if(empty($subscribe_title) && empty($subscribe_sub_title)){ ?>
        .<?php echo esc_attr($id) ?>{
            padding-top: 0;
        }
        <?php } ?>

    </style>

    <div class="sc-subscribe <?php echo esc_attr($id.' '.$animation['has-animation']) ?> clearfix" <?php echo esc_attr($animation['animation-attrs']) ?>>
        <?php
        echo do_shortcode('[mc4wp_form id="'.$mailChimp[0]->ID.'"]');
        ?>
        <form class="send">
            <?php if(!empty($subscribe_title)){ ?>
            <h2 class="subscribe-title"><?php echo esc_attr($subscribe_title);?></h2>
            <?php } ?>
            <?php if(!empty($subscribe_sub_title)){ ?>
            <div class="subscribe-sub-title"><?php echo esc_attr($subscribe_sub_title);?></div>
            <?php } ?>
            <div><input type="email" name="mail" placeholder="ENTER YOUR E-MAIL ADDRESS" class="subscribe-textbox"></div>
            <div class="subscribe-err"></div>
            <div><button class="subscribe-button">SUBSCRIBE &nbsp;&nbsp;&nbsp;<i class="button-icon icon-angle-right"></i></button></div>
            <input type="hidden" class="errorcolor" value="<?php echo esc_attr($subscribe_errorcolor) ?>">
            <input type="hidden" class="successcolor" value="<?php echo esc_attr($subscribe_successcolor) ?>">
        </form>
    </div>

    <?php
    pixflow_callAnimation(true);
    return ob_get_clean();
}

/*************************************
 * WooCommerce shortcodes
 *************************************/

/*Categories Shortcode*/
function pixflow_sc_product_categories( $atts, $content = null ){
    if ( !(in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) || class_exists( 'WooCommerce' )) ) {

        $url = admin_url('themes.php?page=install-required-plugins');
        $a='<a href="'.$url.'">WooCommerce</a>';

       $mis = '<div class="miss-shortcode"><p class="title">'. esc_attr__('Oops!! Something\'s Missing','massive-dynamic').'</p><p class="desc">'.sprintf(esc_attr__('Please install and activate %s first, then add some products to use this shortcode','massive-dynamic'),$a).'</p></div>';

        return $mis;
    }
    $output = '';
    extract(shortcode_atts(array(
        'product_categories' => '',
        'product_categories_cols' => 3,
        'product_categories_overlay_color' => 'rgba(0,0,0,0.2)',
        'product_categories_hover_text' => 'SEE THE COLLECTION',
        'product_categories_align' => 'center',
        'product_categories_height'  => '400',
		   'product_categories_hover_color'=>'#fff'
    ), $atts));
    $animation = array();
    $animation = pixflow_shortcodeAnimation('md_product_categories',$atts);
    $id = pixflow_sc_id('product_categories');
    //Convert slugs to IDs
    $catArr = array();
    $catArr = pixflow_slugs_to_ids(explode(',', $product_categories), 'product_cat');
    $arg = array(
        'include' => $catArr,
        'orderby' => 'count',
        'hide_empty' => 0
    );
    $terms = get_terms('product_cat', $arg);
    if (!empty($terms) && !is_wp_error($terms)) {
        foreach ($terms as $term) {
            $thumbnail_id = get_woocommerce_term_meta( $term->term_id, 'thumbnail_id', true );
	        $image = wp_get_attachment_url( $thumbnail_id );
	        $image = (false == $image)?PIXFLOW_PLACEHOLDER1:$image;
            $product_cats[$term->term_id]['title'] = $term->name;
            $product_cats[$term->term_id]['subtitle'] = $term->description;
            $product_cats[$term->term_id]['url'] = get_term_link($term);
            $product_cats[$term->term_id]['image'] = $image;
        }
        $id = pixflow_sc_id('product-categories');
        ob_start();
        ?>
        <style>
            .<?php echo esc_attr($id);?> .overlay {
                background-color: <?php echo esc_attr($product_categories_overlay_color); ?>;
            }
        </style>
    <div class="<?php echo esc_attr($id.' '.$animation['has-animation']);?> product-categories clearfix" data-thumbnail-height="<?php echo esc_attr($product_categories_height)?>" <?php echo esc_attr($animation['animation-attrs']);?> data-cols="<?php echo esc_attr($product_categories_cols); ?>">
        <?php
        foreach ($product_cats as $cat) {
        ?>
            <div class="category">
                <a href="<?php echo esc_url($cat['url']); ?>">
                    <div class="background" style="background-image: url('<?php echo esc_attr($cat['image'])!=''?esc_attr($cat['image']): PIXFLOW_THEME_ASSETS_URI.'/img/place-holder.jpg'; ?>')"></div>
                    <div class="overlay"></div>
                    <div class="border-holder">
                        <div class="top-border" style="background-color:<?php echo esc_attr($product_categories_hover_color); ?>"></div>
                        <div class="right-border" style="background-color:<?php echo esc_attr($product_categories_hover_color); ?>"></div>
                        <div class="bottom-border" style="background-color:<?php echo esc_attr($product_categories_hover_color); ?>"></div>
                        <div class="left-border" style="background-color:<?php echo esc_attr($product_categories_hover_color); ?>"></div>
                    </div>
                    <div class="meta <?php echo esc_attr($product_categories_align); ?>">
                        <h5 class="subtitle" style="color:<?php echo esc_attr($product_categories_hover_color); ?>"><?php echo esc_attr($cat['subtitle']); ?></h5>
                        <h4 class="title" style="color:<?php echo esc_attr($product_categories_hover_color); ?>"><?php echo esc_attr($cat['title']); ?></h4>
                    </div>
                    <h6 class="hover-text <?php echo esc_attr($product_categories_align); ?>" style="color:<?php echo esc_attr($product_categories_hover_color); ?>"><?php echo esc_attr($product_categories_hover_text)?></h6>
                </a>
            </div>
        <?php
        }
        ?>
    </div>
    <script>
        "use strict";
        if ( typeof pixflow_productCategory == 'function' ){
            pixflow_productCategory();
        }
        <?php pixflow_callAnimation(); ?>
    </script>
    <?php
        return ob_get_clean();
    }
}
/********************************************* Products Shortcode *************************************************/
function pixflow_sc_products( $atts, $content = null ){
    if ( !(in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) || class_exists( 'WooCommerce' )) ) {
        $url = admin_url('themes.php?page=install-required-plugins');
        $a='<a href="'.$url.'">WooCommerce</a>';

       $mis = '<div class="miss-shortcode"><p class="title">'. esc_attr__('Oops!! Something\'s Missing','massive-dynamic').'</p><p class="desc">'.sprintf(esc_attr__('Please install and activate %s first, then add some products to use this shortcode','massive-dynamic'),$a).'</p></div>';

        return $mis;
    }
    $output = '';
    $product_cats = array();
    $terms = get_terms( 'product_cat', 'orderby=count&hide_empty=0' );
    if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
        foreach ( $terms as $term ) {
            $product_cats[] = $term->name;
        }
    }
    extract( shortcode_atts( array(
        'products_categories'  => $product_cats[0],
        'products_cols'  => 3,
        'products_height'  => '500',
        'products_align'  => 'left',
        'products_style'  => 'classic',
        'products_number'  => '-1',
        'products_use_button'           => 'yes',
        'products_button_style'         => 'fade-oval',
        'products_button_text'          => 'More Products',
        'products_button_icon_class'    => 'icon-chevron-right',
        'products_button_color'         => 'rgba(0,0,0,1)',
        'products_button_text_color'    => '#fff',
        'products_button_bg_hover_color'=>'#9b9b9b',
        'products_button_hover_color'   => 'rgb(255,255,255)',
        'products_button_size'          => 'standard',
        'products_left_right_padding'           => 0,
        'products_button_url'           => '#',
        'products_button_target'        => '_self',
        'products_sale_bg_color'        => 'rgba(255,255,255,1)',
        'products_sale_text_color'      => 'rgba(0,0,0,1)'
    ), $atts ) );
    $animation = array();
    $animation = pixflow_shortcodeAnimation('md_products',$atts);
    if($products_style == 'modern'){
       $products_style = 'modern-style-product';
    } else{
        $products_style = '';
    }
    $id = pixflow_sc_id('md-product');
    ob_start();
    ?>
    <style scoped="scoped">
        <?php if('left' == $products_align){ ?>
        .<?php echo esc_attr($id) ?> .products .product{
            text-align: left;
        }

        .<?php echo esc_attr($id) ?> .products-button{
            margin: 0;
        }
        <?php } elseif('center' == $products_align){ ?>
        .<?php echo esc_attr($id) ?> .products .product{
            text-align: center;
        }

        .<?php echo esc_attr($id) ?> .products .star-rating{
            margin: 0 auto 0.5em;
        }

        .<?php echo esc_attr($id) ?> .products-button{
            margin: 0 auto;
            display: table;
        }
        <?php } ?>
        .<?php echo esc_attr($id) ?> .products .product .onsale{
            background-color: <?php echo esc_attr($products_sale_bg_color); ?>;
            color: <?php echo esc_attr($products_sale_text_color); ?>;
        }
    </style>
    <div class="<?php echo esc_attr($id.' '.$animation['has-animation']) ?> thumbnails-height <?php echo esc_attr($products_style)?>" data-thumbnail-height="<?php echo esc_attr($products_height)?>" <?php echo esc_attr($animation['animation-attrs']) ?>>
    <?php
    echo do_shortcode('[product_category category="'.$products_categories.'" columns="'.$products_cols.'" per_page="'.$products_number.'"]');?>
    <?php if($products_use_button=='yes'){?>
        <div class="products-button">
            <?php echo pixflow_buttonMaker($products_button_style,$products_button_text,$products_button_icon_class,$products_button_url,$products_button_target,$products_align,$products_button_size,$products_button_color,$products_button_hover_color,$products_left_right_padding,$products_button_text_color,$products_button_bg_hover_color); ?>
        </div>
    <?php } ?>
    </div>
    <script type="text/javascript">
        var $ = jQuery;

        if ( typeof pixflow_Products == 'function' ){
            pixflow_Products();
        }
    <?php pixflow_callAnimation(); ?>
    </script>
    <?php
    return ob_get_clean();
}

/******************************************** Products Carousel Shortcode *****************************************/
function pixflow_sc_products_carousel( $atts, $content = null ){
    if ( !(in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) || class_exists( 'WooCommerce' )) ) {
        $url = admin_url('themes.php?page=install-required-plugins');
        $a='<a href="'.$url.'">WooCommerce</a>';

       $mis = '<div class="miss-shortcode"><p class="title">'. esc_attr__('Oops!! Something\'s Missing','massive-dynamic').'</p><p class="desc">'.sprintf(esc_attr__('Please install and activate %s first, then add some products to use this shortcode','massive-dynamic'),$a).'</p></div>';

        return $mis;
    }
    $output = '';
    extract( shortcode_atts( array(
        'products_carousel_categories'  => '',
        'products_carousel_cols'  => 3,
        'products_height'  => '500',
    ), $atts ) );
    $animation = array();
    $animation = pixflow_shortcodeAnimation('md_products_carousel',$atts);
    $id = pixflow_sc_id('products');
    //Convert slugs to IDs
    $catArr = array();
    $catArr  = pixflow_slugs_to_ids(explode(',', $products_carousel_categories), 'product_cat');
    $args = array(
            'post_type' => 'product',
            'posts_per_page' => -1,
            );
    $args['tax_query'] =  array(
    array(
        'taxonomy' => 'product_cat',
        'field'    => 'id',
        'terms'    => $catArr
    ));
    $loop = new WP_Query( $args );
    $posts = array();
    if ( $loop->have_posts() ) {
        while ( $loop->have_posts() ) : $loop->the_post();
            $posts[] = get_the_ID();
        endwhile;
    }
    wp_reset_postdata();
    ob_start(); ?>
    <div class="<?php echo esc_attr($animation['has-animation']) ?>" <?php echo esc_attr($animation['animation-attrs']) ?>>
        <?php echo do_shortcode('[products ids="'.implode(',',$posts).'" columns="'.$products_carousel_cols.'"]');?>
        <div class="thumbnails-height"></div>
    </div>
    <?php
    pixflow_callAnimation(true);
    return ob_get_clean();
}
/*-----------------------------------------------------------------------------------*/
/*  Team Member Carousel
/*-----------------------------------------------------------------------------------*/

function pixflow_sc_teamMemberCarousel($atts, $content = null)
{
    $output = $team_member_style2_num = '';

    wp_enqueue_style('slick-theme', pixflow_path_combine(PIXFLOW_THEME_CSS_URI,'slick-theme.min.css'), array(), PIXFLOW_THEME_VERSION);
    wp_enqueue_style('slick-style', pixflow_path_combine(PIXFLOW_THEME_CSS_URI,'slick.min.css'), array(), PIXFLOW_THEME_VERSION);
    wp_enqueue_script('slick-js', pixflow_path_combine(PIXFLOW_THEME_JS_URI,'slick.min.js'), array(), PIXFLOW_THEME_VERSION, true);

    extract( shortcode_atts( array(
        'team_member_style2_num'         => '8',
        'team_member_style2_texts_color' => '#393939',
        'team_member_style2_hover_color' => '#fff',
    ), $atts ) );
    $animation = array();
    $animation = pixflow_shortcodeAnimation('md_teammember2',$atts);

    for($i=1; $i<=$team_member_style2_num; $i++){

        $k=1;

        $slides[$i] = shortcode_atts( array(
            'team_member_style2_name_'.$i        => 'Member'.$i,
            'team_member_style2_position_'.$i    => 'Manager',
            'team_member_style2_description_'.$i => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec porta, mi ut facilisis ullamcorper.',

            'team_member_style2_image_'.$i => PIXFLOW_THEME_IMAGES_URI."/place-holder.jpg",

            'team_member_style2_social_icon_'.$k       => 'icon-facebook2',
            'team_member_style2_social_icon_url_'.$k++ => 'http://www.facebook.com',

            'team_member_style2_social_icon_'.$k       => 'icon-twitter5',
            'team_member_style2_social_icon_url_'.$k++ => 'http://www.twitter.com',

            'team_member_style2_social_icon_'.$k       => 'icon-google',
            'team_member_style2_social_icon_url_'.$k++ => 'http://www.google.com',

            'team_member_style2_social_icon_'.$k       => 'icon-dribbble',
            'team_member_style2_social_icon_url_'.$k++ => 'http://www.dribbble.com',

            'team_member_style2_social_icon_'.$k     => 'icon-instagram',
            'team_member_style2_social_icon_url_'.$k => 'http://www.instagram.com',
        ), $atts );
    }
    $id = pixflow_sc_id('teammember_style2');
    $func_id = uniqid();

    $output .= '<div id="'.$id.'" class="wrap-teammember-style2 clearfix '.esc_attr($animation["has-animation"]).'" '.esc_attr($animation["animation-attrs"]).'>';

        $output .= '<ul class="slides">';

            foreach( $slides as $key=>$slide ){

                $name = $slide['team_member_style2_name_'.$key];
                $position = $slide['team_member_style2_position_'.$key];
                $description = $slide['team_member_style2_description_'.$key];

                $generateLi = "";

                for($i=1; $i<=5; $i++) {

                    if($slide['team_member_style2_social_icon_url_' . $i] != '' && $slide['team_member_style2_social_icon_' . $i] != ''){
                        $generateLi .= '<li> <a href="' . $slide['team_member_style2_social_icon_url_' . $i] . '"> <i class="' . $slide['team_member_style2_social_icon_' . $i] . '"></i> </a> </li>';
                    }
                }

                $image = $slide['team_member_style2_image_'.$key];

                if ($image != '' && is_numeric($image)) {
                    $image = wp_get_attachment_image_src($image, 'pixflow_team-member-style2-thumb') ;
                    $image = (false == $image)?PIXFLOW_PLACEHOLDER1:$image[0];
                }

                $output .= ' <li> ';

                    $output .= ' <div class="wrap"> <div class="teammember-image" style="background-image: url(\' '. esc_attr($image) .' \') "></div> ';

                    $output .= ' <div class="teammember-hover">'.

                        '<p class="teammember-description">'. preg_replace("/&lt;(.*?)&gt;/i",'',esc_attr($description)) .'</p>'.
                        '<ul class="social-icons">'. $generateLi. '</ul>'.

                    '</div> ';

                    $output .= ' </div> <div class="meta"> <div class="name">'. $name .'</div> <div class="position">'. $position .'</div> </div>';

                $output .= ' </li> '; // end wrap

            }

        $output .= ' </ul> ';

    $output .= ' </div> ';

    ob_start();
    ?>

    <style scoped="scoped">

        #<?php echo esc_attr($id) ?> .meta .name{
            color: <?php echo esc_attr($team_member_style2_texts_color); ?>;
        }

        #<?php echo esc_attr($id) ?> .meta .position{
            color: <?php echo esc_attr(pixflow_colorConvertor($team_member_style2_texts_color,'rgba', .5)); ?>;
        }

        #<?php echo esc_attr($id) ?> .teammember-hover > p,
        #<?php echo esc_attr($id) ?> .teammember-hover ul li a{
            color: <?php echo esc_attr($team_member_style2_hover_color); ?>;
        }

    </style>

    <script type="text/javascript">

        var $ = jQuery,
            slickTtrackWidth, CTO;

        $('document').ready(function() {

            if (typeof pixflow_teammemberCarousel == 'function' /*&& typeof slick == 'function'*/) {
                pixflow_teammemberCarousel("<?php echo esc_attr($id) ?>");
            }

        });
        <?php pixflow_callAnimation(); ?>
    </script>

    <?php
    $output .= ob_get_clean();
    return $output;

}

/*----------------------------------------------------------------
                    Masonry Blog
-----------------------------------------------------------------*/

function pixflow_sc_blog_masonry( $atts, $content = null ){
    $query=$output=$width=$subStr=$style = $col
    =$blog_accent_color=$blog_post_number=$blog_text_accent_color=
    $blog_category=$blog_foreground_color=$blog_background_color=$id=$blog_column=$blog_bg = $blog_post_shadow = '';
    $list=$day=array();
    $i=0;

    extract( shortcode_atts( array(
        'blog_column'            => 'three',
        'blog_category'          => '',
        'blog_post_number'       => '5' ,
        'blog_foreground_color'  => 'rgb(255,255,255)',
        'blog_background_color'  => 'rgb(87,63,203)',
        'blog_accent_color'      => 'rgb(220,38,139)',
        'blog_text_accent_color' => 'rgb(0,0,0)',
        'blog_post_shadow'      => 'rgba(0,0,0,.12)'

    ), $atts ) );

    $animation = array();
    $animation = pixflow_shortcodeAnimation('md_blog_masonry',$atts);
    $id = pixflow_sc_id('blog-masonry');

    $arrg = array(
        'category_name'=> $blog_category,
        'posts_per_page' => $blog_post_number,
    );

    $query = new WP_Query($arrg);

    if(is_numeric($blog_bg)){
        $blog_bg =  wp_get_attachment_image_src( $blog_bg, 'pixflow_post-single') ;
        $blog_bg = (false == $blog_bg)?PIXFLOW_PLACEHOLDER1:$blog_bg[0];
    }

    if($blog_column=='three'){
        $width=100/3 ;
        $col = 3;

    }else{
        $width=100/4;
        $col = 4 ;
    }

    ob_start();
    ?>

    <style scoped="scoped">

        .<?php echo esc_attr($id); ?> .blog-masonry-container{
            background-color: <?php echo esc_attr($blog_background_color); ?>;
            width:calc(<?php echo esc_attr($width).'%'; ?> - 30px);
            -webkit-box-shadow: 0 1px 21px <?php echo esc_attr($blog_post_shadow); ?>;
            -moz-box-shadow: 0 1px 21px <?php echo esc_attr($blog_post_shadow); ?>;
            box-shadow: 0 1px 21px <?php echo esc_attr($blog_post_shadow); ?>;
        }
        .<?php echo esc_attr($id); ?> .blog-masonry-container p,
        .<?php echo esc_attr($id); ?> .blog-masonry-container span,
        .<?php echo esc_attr($id); ?> .blog-masonry-container h1,
        .<?php echo esc_attr($id); ?> .blog-masonry-container a{
            color:<?php echo esc_attr($blog_foreground_color); ?>;
        }
        .<?php echo esc_attr($id); ?> .blog-masonry-container span.blog-cat a,
        .<?php echo esc_attr($id); ?> .quote.blog-masonry-container p,
        .<?php echo esc_attr($id); ?> .quote.blog-masonry-container span,
        .<?php echo esc_attr($id); ?> .quote.blog-masonry-container h1,
        .<?php echo esc_attr($id); ?> .quote.blog-masonry-container a{
            color:<?php echo esc_attr($blog_text_accent_color); ?>;
        }

        .<?php echo esc_attr($id); ?> .blog-cat{
            background-color:<?php echo esc_attr($blog_accent_color); ?>;
        }

        .<?php echo esc_attr($id); ?> .blog-masonry-container .blog-title:hover{
             color:<?php echo esc_attr(pixflow_colorConvertor($blog_foreground_color,'rgba',0.50)); ?>;
        }

        .<?php echo esc_attr($id); ?> .blog-masonry-container .video-img{
            width:100%;
        }
        .<?php echo esc_attr($id); ?> .blog-masonry-container.quote{
            background:<?php echo esc_attr($blog_accent_color);?>
        }
        .<?php echo esc_attr($id); ?> .blog-masonry-container .blog-masonry-content .like-heart,
        .<?php echo esc_attr($id); ?> .blog-masonry-container .blog-masonry-content .share,
        .<?php echo esc_attr($id); ?> .blog-masonry-container .blog-masonry-content .share-hover{
            border: 2px solid <?php echo esc_attr(pixflow_colorConvertor($blog_foreground_color,'rgba',0.55)); ?>;
        }
        .<?php echo esc_attr($id); ?> .blog-masonry-container .blog-masonry-content .like-heart i,
        .<?php echo esc_attr($id); ?> .blog-masonry-container .blog-masonry-content .share i,
        .<?php echo esc_attr($id); ?> .blog-masonry-container .blog-masonry-content .share-hover i{
            color:<?php echo esc_attr(pixflow_colorConvertor($blog_foreground_color,'rgba',0.55)); ?>;
        }
        .<?php echo esc_attr($id); ?> .blog-masonry-container .blog-masonry-content .post-like-holder:hover .like-heart,
        .<?php echo esc_attr($id); ?> .blog-masonry-container .blog-masonry-content .post-share:hover .share,
        {
            background-color: <?php echo esc_attr($blog_foreground_color); ?>
        }
        .<?php echo esc_attr($id); ?> .blog-masonry-container .blog-masonry-content .like-count,
        .<?php echo esc_attr($id); ?> .blog-masonry-container .blog-masonry-content .post-share:hover .share-hover i{
            color: <?php echo esc_attr($blog_background_color); ?>;
        }

        .<?php echo esc_attr($id); ?> .blog-masonry-container .blog-masonry-content .post-like-holder .like-heart,
        .<?php echo esc_attr($id); ?> .blog-masonry-container .blog-masonry-content .share{
            background:<?php echo esc_attr(pixflow_colorConvertor($blog_foreground_color,'rgba',0.20)); ?>;
        }

        .<?php echo esc_attr($id); ?> .blog-masonry-container .blog-masonry-content .post-like-holder .like-heart,
        .<?php echo esc_attr($id); ?> .blog-masonry-container .blog-masonry-content .share{
            border:2px solid  <?php echo esc_attr(pixflow_colorConvertor($blog_foreground_color,'rgba',0)); ?>;
        }

        .<?php echo esc_attr($id); ?> .blog-masonry-container .blog-masonry-content .share-hover i,
        .<?php echo esc_attr($id); ?> .blog-masonry-container .blog-masonry-content .share i,
        .<?php echo esc_attr($id); ?> .blog-masonry-container .blog-masonry-content .like-heart i,
        .<?php echo esc_attr($id); ?> .blog-masonry-container .blog-masonry-content .like-count,
        .<?php echo esc_attr($id); ?> .blog-masonry-container .blog-masonry-content .post-share:hover .share-hover i
        {
             color:<?php echo esc_attr(pixflow_colorConvertor($blog_foreground_color,'rgba',0.40)); ?>;
        }

        .<?php echo esc_attr($id); ?> .blog-masonry-container .blog-masonry-content .post-like-holder:hover .like-heart,
        .<?php echo esc_attr($id); ?> .blog-masonry-container .blog-masonry-content .post-share:hover .share-hover{
            background-color: transparent;
            border:2px solid  <?php echo esc_attr(pixflow_colorConvertor($blog_foreground_color,'rgba',0.5)); ?>;
        }


    </style>

    <div id="<?php echo esc_attr($id) ?>" class="<?php echo esc_attr($id.' '.$animation['has-animation']);?> masonry-blog clearfix " <?php echo esc_attr($animation['animation-attrs']);?>>

        <?php while ($query->have_posts()) {
            $i++;
            $query->the_post();
            global $post;

            if(strlen(get_the_excerpt())>150){
                $subStr = '...';
            }else{
                $subStr='';
            }
            $format = get_post_format( $post->ID );
            if($format==false) $format = 'standard';
            $style='';

            ?>
        <div class="blog-masonry-container <?php echo esc_attr($format);?>" >
            <?php
            if($format=='audio'){
                $audio=pixflow_extract_audio_info(get_post_meta(get_the_ID(), 'audio-url', true));
                if($audio != null)
                {
                    echo pixflow_soundcloud_get_embed($audio['url'],'250');
                }
            }elseif($format=='gallery'){
                wp_enqueue_script('flexslider-script');
                wp_enqueue_style('flexslider-style');
                $images =get_post_meta( get_the_ID(), 'fg_perm_metadata');
                $images=explode(',',$images[0]);
                if(count($images)){ ?>
                    <div class="flexslider">
                        <ul class="slides">
                            <?php
                            $imageSize = 'pixflow_team-member-style2-thumb';
                            if (has_post_thumbnail()) {
                                $thumb = wp_get_attachment_image_src( get_post_thumbnail_id( ),$imageSize);
                                $thumb = (false == $thumb)?PIXFLOW_PLACEHOLDER1:$thumb[0];
                                $url = $thumb;
                                ?>
                                <li class="images" style="background-image: url('<?php echo esc_url($url); ?>');">
                                </li>
                                <?php
                            }
                            foreach($images as $img){
                                $imgTag = wp_get_attachment_image_src($img, $imageSize);
                                $imgTag = (false == $imgTag)?PIXFLOW_PLACEHOLDER1:$imgTag[0];
                                ?>
                                <li class="images" style="background-image: url('<?php echo esc_url($imgTag); ?>');">
                                </li>
                            <?php
                            }?>
                        </ul>
                    </div>
                <?php
                }
            }elseif($format=='video'){
                $videoUrl=get_post_meta( get_the_ID(), 'video-url', true);
                $findme   = 'vimeo.com';
                $pos = strpos($videoUrl, $findme);
                if($pos==false) {
                    $host = 'youtube';
                }else {
                    $host = 'vimeo';
                }
                if ( function_exists('has_post_thumbnail') && has_post_thumbnail() ) {
                    $image = get_post_thumbnail_id($post->ID);
                }else {
                    $image = "";
                }
                echo do_shortcode('[md_video md_video_host="'.$host.'" md_video_url_vimeo="'.esc_url($videoUrl).'" md_video_url_youtube="'.esc_url($videoUrl).'" md_video_style="squareImage" md_video_image="'.esc_attr($image).'"]');
            }elseif($format=='standard'){
                if (has_post_thumbnail()) {
                    $imageSize = 'full';
                    $thumb = wp_get_attachment_image_src( get_post_thumbnail_id( ),$imageSize);
                    $thumb = (false == $thumb)?PIXFLOW_PLACEHOLDER1:$thumb[0];
                    echo '<img class="attachment-post-thumbnail size-post-thumbnail wp-post-image" src="'.esc_attr($thumb).'" />';
                }
            }elseif($format=='quote') {
                echo '<img class="quote-img" src="'.PIXFLOW_THEME_IMAGES_URI.'/masonry-quote.png" />';
            }
        ?>
            <div class="blog-masonry-content">
                <?php if($format!='quote') { ?>
                    <span class="blog-details">
                    <?php
                        $terms = get_the_category($post->ID);
                        $catNames=array();
                        $md_catcounter=0;
                        if($terms)
                            foreach ($terms as $term){
                            $md_catcounter++;
                            if ($md_catcounter<2)
                            {
                        ?>
                            <span class="blog-cat"><a href="<?php echo esc_url( get_category_link( get_cat_ID($term->name)))?>" title='<?php echo esc_attr($term->name) ?>'><?php echo esc_attr($term->name) ?></a></span>
                        <?php }

                        } ?>
                    </span>
                <?php
                }
                $archive_year  = get_the_time('Y');
                $archive_month = get_the_time('m');
                $archive_day   = get_the_time('d');

                ?>
                 <?php if($format=='quote') {?>
                <span class="blog-date">
                    <i class="px-icon icon-calendar-1 classic-blog-icon"></i> <a href="<?php echo get_day_link( $archive_year, $archive_month, $archive_day); ?>"><?php the_time(get_option('date_format')) ?></a>
                </span>
                <?php }?>

                <?php if($format!='quote') {?>
                <a href="<?php the_permalink(); ?>"><h1 class="blog-title"> <?php the_title(); ?></h1></a>
                <span class="blog-date">
                    <i class="px-icon icon-calendar-1 classic-blog-icon"></i> <a href="<?php echo get_day_link( $archive_year, $archive_month, $archive_day); ?>"><?php the_time(get_option('date_format')) ?></a>
                </span>
                <?php }?>
                <p class="blog-excerpt"> <?php echo substr(get_the_excerpt(), 0,150).$subStr; ?></p>
                <?php if($format=='quote') {?>

                <p class="blog-excerpt"> <?php the_title(); ?></p>

                <?php }
                if($format!='quote') {
                    ?>
                    <div class="post-like-holder">
                        <?php echo pixflow_getPostLikeLink( get_the_ID() );?>
                    </div>
                    <?php
                    if ( function_exists('is_plugin_active') && is_plugin_active( 'add-to-any/add-to-any.php' ) ) {
                        if(!get_post_meta( get_the_ID(), 'sharing_disabled', false)){?>
                            <div class="post-share">
                                <a href="#" class="share a2a_dd"><i class="icon-share3"></i></a>
                                <a href="#" class="a2a_dd share-hover"><i class="icon-share3"></i></a>
                            </div>
                        <?php  }
                    } ?>


                <?php } ?>
            </div>
        </div>
        <?php }?>

        <div class="clearfix"></div>
    </div>
    <script>
    var $ = jQuery;

     $(document).ready(function(){
        if(typeof pixflow_blogMasonry == 'function'){
            $('.<?php echo esc_attr($id)?> .blog-masonry-container').each(function(){
                    var item = $('<div></div>');
                    item.attr('class',$(this).attr('class'));
                    item.html($(this).html());
                    $(this).closest('.masonry-blog').append(item);
                    $(this).remove();
            })
            pixflow_blogMasonry('<?php echo esc_attr($id)?>');
        }

     })
     <?php pixflow_callAnimation(); ?>
    </script>
    <?php
    wp_reset_postdata();

    return ob_get_clean();

}



/*----------------------------------------------------------------
                    Carousel Blog
-----------------------------------------------------------------*/

function pixflow_sc_blog_carousel( $atts, $content = null ){
    extract( shortcode_atts( array(
        'blog_category'          => '',
        'blog_post_number'       => '5' ,
        'carousel_autoplay'=>'no',
        'blog_foreground_color'  => 'rgb(0,0,0)',
        'blog_background_color'  => 'rgb(255,255,255)',
        'blog_date_color'=>'rgb(84,84,84)',
    ), $atts ) );

    $animation = array();
    $animation = pixflow_shortcodeAnimation('md_blog_carousel',$atts);
    $id = pixflow_sc_id('blog_carousel');
    $carousel_autoplay=$carousel_autoplay=='no'?'false':'true';

    $arrg = array(
        'category_name'=> $blog_category,
        'posts_per_page' => $blog_post_number,
    );

    $query = new WP_Query($arrg);
    ob_start();
?>

<style scoped="scoped">

        .<?php echo esc_attr($id); ?> .post-wrap.is-selected .post-content-container {
             -webkit-box-shadow: 0px 9px 32px -1px rgba(0,0,0,0.2);
            -moz-box-shadow: 0px 9px 32px -1px rgba(0,0,0,0.2);
             box-shadow: 0px 9px 32px -1px rgba(0,0,0,0.2);
             margin-top:-10px;
        }

        .<?php echo esc_attr($id); ?> .post-wrap .post-content-container{
            background-color: <?php echo esc_attr($blog_background_color); ?>
        }

        .<?php echo esc_attr($id); ?> .vertical-separator{
            background-color: <?php echo esc_attr(pixflow_colorConvertor($blog_date_color,'rgba',0.70)); ?>;
        }

        .<?php echo esc_attr($id); ?> .post-title a h1,
        .<?php echo esc_attr($id); ?> .post-title h1,
        .<?php echo esc_attr($id); ?> .post-author-name,
        .<?php echo esc_attr($id); ?> .post-author-name a,
        .<?php echo esc_attr($id); ?> .post-description p,
        .<?php echo esc_attr($id); ?> .post-date-day,
        .<?php echo esc_attr($id); ?> .post-date-month{
           color: <?php echo esc_attr($blog_foreground_color); ?>
        }

        .<?php echo esc_attr($id); ?> .post-date-day,
        .<?php echo esc_attr($id); ?> .post-date-month{
           color: <?php echo esc_attr($blog_date_color); ?>
        }

        .<?php echo esc_attr($id); ?> .post-description p{
            color: <?php echo esc_attr(pixflow_colorConvertor($blog_foreground_color,'rgba',0.70)); ?>;
        }

        .<?php echo esc_attr($id); ?> .separator{
           background-color: <?php echo esc_attr(pixflow_colorConvertor($blog_foreground_color,'rgba',0.90)); ?>;
        }

        .<?php echo esc_attr($id); ?> .post-separator{
            background-color: <?php echo esc_attr(pixflow_colorConvertor($blog_foreground_color,'rgba',0.30)); ?>;
        }
</style>


<div id="<?php echo esc_attr($id) ?>" class="post-carousel-container <?php echo esc_attr($id.' '.$animation['has-animation']);?> "  <?php echo esc_attr($animation['animation-attrs']);?> data-flickity-options='{
                "contain": true,
                "prevNextButtons": false,
                "pageDots": true,
                "initialIndex": 1,
                "autoPlay": <?php echo esc_attr($carousel_autoplay) ?>,
                "wrapAround": true,
                "pauseAutoPlayOnHover": false,
                "selectedAttraction": 0.045,
                "friction: 0.5",
                "percentPosition": false,
            }'>
    <?php
    while ($query->have_posts()) {

        $query->the_post();
        global $post;
        $title=get_the_title();
        $format=get_post_format();

        if(strlen($title)>30){
            $title=substr($title, 0,20)."...";
        }

        $exc=get_the_excerpt();
        if(strlen($exc)>150){
         $exc = substr($exc, 0,130)."...";
        }
        global $md_allowed_HTML_tags ;
    ?>
    <div class="post-wrap">
        <div class="post-content-container">
            <?php
            if('quote'!=$format){
            ?>
                <div class="post-title <?php echo esc_attr($format); ?>" ><a href="<?php the_permalink(); ?>"><h1 class="blog-title"><?php echo esc_attr($title); ?></h1></a></div>
            <?php
            }
            else{
            ?>
                <div class="post-title <?php echo esc_attr($format); ?>" ><h1 class="blog-title"><?php echo esc_attr($title); ?></h1></div>
            <?php
            }
            ?>
            <div class="post-description"><p><?php echo wp_kses($exc,$md_allowed_HTML_tags ); ?></p></div>
            <div class="post-separator"></div>
            <div class="post-meta-container">
                <div class="post-author-image"><?php echo get_avatar(get_the_author_meta('ID'), 26 ); ?></div>
                <div class="post-author-name">By <?php echo get_the_author_meta('display_name'); ?></div>
            </div>
            <div class="vertical-separator"></div>
        </div>

        <div class="post-date">
            <div class="post-date-day"> <?php the_time( 'j', '', '', true ); ?> </div>
            <div class="post-date-month"><?php the_time( 'F', '', '', true ); ?></div>
        </div>
    </div>




    <?php
    }
    ?>
    </div>
    <script>
    "use strict";
    var $ = (jQuery);
    $(function() {
        if(typeof $.prototype.flickity == 'function') {
            setTimeout(function(){
            $('.<?php echo esc_attr($id); ?>').not('.flickity-enabled').flickity({
                    contain: true,
                    prevNextButtons: false,
                    pageDots: true,
                    initialIndex: 1,
                    autoPlay: <?php echo esc_attr($carousel_autoplay); ?>,
                    wrapAround: true,
                    pauseAutoPlayOnHover: false,
                    selectedAttraction: 0.045,
                    friction: 0.5,
                    percentPosition: false,
                });
                setTimeout(function(){
                    $('.<?php echo esc_attr($id); ?>').flickity('resize')
                },1000)
            },100)
        }
    });
    </script>
    <?php
    return ob_get_clean();
}







/*-----------------------------------------------------------------------------------*/
/*  Counter
/*-----------------------------------------------------------------------------------*/

function pixflow_sc_counter($atts, $content = null)
{
    $counter_from = $counter_to = $counter_title = $counter_title_color =
    $counter_icon_class=$counter_icon_color='';
    extract(shortcode_atts(array(
        'counter_from'         => '0',
        'counter_to'           => '46',
        'counter_title'        => 'Documents',
        'counter_title_color'  => 'rgb(0,0,0)',
        'counter_icon_class'   => 'icon-Diamond',
        'counter_icon_color'   => 'rgb(132,206,27)',
        'align'   => 'center',

    ), $atts));
    $animation = array();
    $animation = pixflow_shortcodeAnimation('md_counter',$atts);
    $id = pixflow_sc_id('counter');

    ob_start();
    ?>
    <style scoped="scoped">
        .<?php echo esc_attr($id)?> .icon i{
            color:<?php echo esc_attr($counter_icon_color); ?>;
        }
        .<?php echo esc_attr($id)?> .text h1,
        .<?php echo esc_attr($id)?> .text h2{
            color:<?php echo esc_attr($counter_title_color); ?>;
         }
    </style>

    <div id="id-<?php echo esc_attr($id) ?>" class="<?php echo esc_attr($id.' '.$animation['has-animation'].' md-align-'.$align); ?> md-counter" <?php echo esc_attr($animation['animation-attrs']); ?>>
        <div class="counter">
            <div class="icon">
                <i class="<?php echo esc_attr($counter_icon_class); ?>"></i>
            </div>
            <div class="text">
                <h1 class="timer count-number" id="<?php echo esc_attr($id) ?>" data-to="<?php echo esc_attr($counter_to); ?>" data-from="<?php echo esc_attr($counter_from); ?>" data-speed="1500"></h1>
                <h2 class="title"><?php echo esc_attr($counter_title); ?></h2>
            </div>
        </div>
    </div>
    <script>
        var $ = jQuery;

        if ( typeof pixflow_counterShortcode == 'function' ){
            pixflow_counterShortcode( "#id-<?php echo esc_attr($id) ?>", false );
        }
        <?php pixflow_callAnimation(); ?>
    </script>
    <?php
    return ob_get_clean();
}

/*-----------------------------------------------------------------------------------*/
/*  Count Box
/*-----------------------------------------------------------------------------------*/
function pixflow_sc_countbox($atts, $content = null)
{
    $countbox_to = $countbox_title = $countbox_desc = $countbox_general_color =
    $countbox_number_color=$counter_icon_color=
    $countbox_use_button=$countbox_button_style=$countbox_button_text=
    $countbox_button_icon_class=$countbox_button_color=$countbox_button_text_color=
    $countbox_button_bg_hover_color=$countbox_button_hover_color=$countbox_button_size=
    $left_right_padding=$countbox_button_url=$countbox_button_target='';

    extract(shortcode_atts(array(
        'countbox_to'         => '46',
        'countbox_title'      => 'YEARS OF MY EXPERIENCE',
        'countbox_desc'        => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec porta, mi ut facilisis ullamcorper, magna risus vehicula augue, eget faucibus magna massa at justo.',
        'countbox_general_color'  => 'rgb(0,0,0)',
        'countbox_number_color'   => 'rgb(255,54,116)',
        'countbox_use_button'           => 'yes',
        'countbox_button_style'         => 'come-in',
        'countbox_button_text'          => 'READ MORE',
        'countbox_button_icon_class'    => 'icon-chevron-right',
        'countbox_button_color'         => 'rgba(0,0,0,1)',
        'countbox_button_text_color'    => 'rgba(255,255,255,1)',
        'countbox_button_bg_hover_color'=> 'rgb(0,0,0)',
        'countbox_button_hover_color'   => 'rgb(255,255,255)',
        'countbox_button_size'          => 'standard',
        'left_right_padding'           => 0,
        'countbox_button_url'           => '#',
        'countbox_button_target'        => '_self',
        'align'        => 'center'
    ), $atts));

    $animation = array();
    $animation = pixflow_shortcodeAnimation('md_countbox',$atts);
    $id = pixflow_sc_id('countbox');

    ob_start();
    $titleClass = ($countbox_desc == '')?'countbox-nodesc':'';
    ?>

    <style scoped="scoped">

        .<?php echo esc_attr($id)?> .timer{
            color:<?php echo esc_attr($countbox_number_color); ?>;
         }

         .<?php echo esc_attr($id)?> h2,
         .<?php echo esc_attr($id)?> .countbox-title-separator,
         .<?php echo esc_attr($id)?> p{
            color:<?php echo esc_attr($countbox_general_color); ?>;
         }

         .<?php echo esc_attr($id)?> .countbox-title-separator{
             border-color:<?php echo esc_attr($countbox_general_color); ?>;
         }

    </style>

    <div id="id-<?php echo esc_attr($id) ?>" class="clearfix <?php echo esc_attr($id.' '.$animation['has-animation'].' md-align-'.$align); ?> md-counter md-countbox" <?php echo esc_attr($animation['animation-attrs']); ?>>
        <div class="counter">
            <div class="timer count-number" id="<?php echo esc_attr($id) ?>" data-to="<?php echo esc_attr((int)$countbox_to); ?>" data-from="0" data-speed="1500"></div>
            <div class="countbox-text">
                <?php if($countbox_title != ''){ ?>
                    <h2 class="title <?php echo esc_attr($titleClass); ?>"><?php echo esc_attr($countbox_title); ?></h2>

                <?php }if($countbox_desc != ''){ ?>
                    <div class="countbox-title-separator"></div>
                    <p><?php echo preg_replace("/&lt;(.*?)&gt;/i",'',esc_attr($countbox_desc)); ?></p>
                <?php }
                if($countbox_use_button=='yes'){?>
                <div class="countbox-button">
                    <?php echo pixflow_buttonMaker($countbox_button_style,$countbox_button_text,$countbox_button_icon_class,$countbox_button_url,$countbox_button_target,'left',$countbox_button_size,$countbox_button_color,$countbox_button_hover_color,$left_right_padding,$countbox_button_text_color,$countbox_button_bg_hover_color); ?>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>

    <script>
        var $ = jQuery;
         if ( typeof pixflow_counterShortcode == 'function' ){
            pixflow_counterShortcode( "#id-<?php echo esc_attr($id) ?>", false );
         }
        <?php pixflow_callAnimation(); ?>
    </script>

    <?php
    return ob_get_clean();
}

/*---------------------------------------------------------
--------------------Tab Horizontal--------------------------
----------------------------------------------------------*/
function pixflow_sc_hor_tabs( $atts, $content = null ){
    $animation=$output = $title = $tab_icon  = $general_color = $use_bg=$bg_type = $bg_color = $bg_image='';
    extract( shortcode_atts( array(
        'general_color' => 'rgb(255,255,255)',
        'use_bg'        => 'yes',
        'bg_type'       => 'color',
        'bg_color'      => 'rgb(215,176,126)',
        'hor_tab_hover_color' => 'rgb(215,176,126)',
        'bg_image'      => ''
    ), $atts ) );
    $animation = array();
    $animation = pixflow_shortcodeAnimation('md_hor_tabs',$atts);
    wp_enqueue_script('jquery-ui-tabs');
    $element = 'wpb_tabs';
    $id = esc_attr(pixflow_sc_id('md_hor_tabs'));
    ob_start();
    ?>
    <style scoped="scoped">
        .<?php echo esc_attr($id); ?>.wpb_content_element .wpb_tabs_nav li a i,
        .<?php echo esc_attr($id); ?>.wpb_content_element .wpb_tabs_nav li a .horTabTitle,
        .<?php echo esc_attr($id); ?>.wpb_content_element .wpb_tabs_nav li a.md-hor-tab-add-tab{
            color: <?php echo esc_attr($general_color); ?>;
        }
        .<?php echo esc_attr($id); ?>.wpb_content_element .wpb_tabs_nav li{
            border-bottom: solid 1px <?php echo esc_attr(pixflow_colorConvertor($general_color,'rgba', 0.5)); ?>;
        }
        .<?php echo esc_attr($id); ?>.wpb_content_element .wpb_tabs_nav li:first-child{
            border-top: solid 1px <?php echo esc_attr(pixflow_colorConvertor($general_color,'rgba', 0.5)); ?>;
        }
        <?php if($use_bg=='yes'){ ?>
        .<?php echo esc_attr($id); ?>.md_hor_tab.wpb_content_element .wpb_tabs_nav.md-custom-tab > li > a{
            padding: 0 20px 0 20px;
        }
        .<?php echo esc_attr($id); ?>.wpb_content_element .wpb_tabs_nav li.ui-tabs-active,
        .<?php echo esc_attr($id); ?>.wpb_content_element .wpb_tabs_nav li:hover{
            background-color: <?php echo esc_attr(pixflow_colorConvertor($general_color,'rgba', 0.3)); ?>;
        }
        <?php }else{ ?>
        .<?php echo esc_attr($id); ?>.md_hor_tab.wpb_content_element .wpb_tabs_nav.md-custom-tab > li > a{
            padding: 0;
        }
        .<?php echo esc_attr($id); ?>.wpb_content_element .wpb_tabs_nav li.ui-tabs-active,
        .<?php echo esc_attr($id); ?>.wpb_content_element .wpb_tabs_nav li:hover{
            background-color: transparent;
        }
        .<?php echo esc_attr($id); ?>.wpb_content_element .wpb_tabs_nav li .horTabTitle,
        .<?php echo esc_attr($id); ?>.wpb_content_element .wpb_tabs_nav li i{
            transition: color 0.3s;
        }

        .<?php echo esc_attr($id); ?>.wpb_content_element .wpb_tabs_nav li.ui-tabs-active .horTabTitle,
        .<?php echo esc_attr($id); ?>.wpb_content_element .wpb_tabs_nav li:hover .horTabTitle,
        .<?php echo esc_attr($id); ?>.wpb_content_element .wpb_tabs_nav li.ui-tabs-active i,
        .<?php echo esc_attr($id); ?>.wpb_content_element .wpb_tabs_nav li:hover i{
            color: <?php echo esc_attr($hor_tab_hover_color); ?>;
        }
        <?php } ?>
        <?php if($use_bg=='yes' && $bg_type=='color'){ ?>
        .<?php echo esc_attr($id); ?>.wpb_content_element.md_hor_tab ul.wpb_tabs_nav {
            background-color: <?php echo esc_attr($bg_color); ?>;
        }
        .<?php echo esc_attr($id); ?>.wpb_content_element.md_hor_tab .overlay{
            display:none;
        }
        <?php }
        if($use_bg=='yes' && $bg_type=='image'){
            if(is_numeric($bg_image)){
                $bg_image =  wp_get_attachment_image_src( $bg_image,'full') ;
                $bg_image = (false == $bg_image)?PIXFLOW_PLACEHOLDER_BLANK:$bg_image[0];
            }
        ?>
        .<?php echo esc_attr($id); ?>.wpb_content_element.md_hor_tab ul.wpb_tabs_nav {
            background-image: url(<?php echo esc_url($bg_image); ?>);
            background-color: transparent;
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
        }
        .<?php echo esc_attr($id); ?>.wpb_content_element.md_hor_tab .overlay{
            display:block;
        }
        <?php }else{
        ?>
        .<?php echo esc_attr($id); ?>.wpb_content_element.md_hor_tab .overlay{
            display:none;
        }
        <?php
        } ?>
    </style>
    <?php
    $output.=ob_get_clean();
    preg_match_all( '/md_hor_tab([^\]]+)/i', $content, $matches, PREG_OFFSET_CAPTURE );
    $tab_titles = array();
    if ( isset( $matches[1] ) ) {
        $tab_titles = $matches[1];
    }
    $tabs_nav = '';
    $hasBg = $use_bg;
    $tabs_nav .= '<ul class="wpb_tabs_nav ui-tabs-nav vc_clearfix md-custom-tab">';
    $i=0;
    foreach ( $tab_titles as $tab ) {
        $i++;
        $tab_atts = shortcode_parse_atts($tab[0]);
        $tab_atts['title'] = !array_key_exists('title',$tab_atts)?'Tab '.$i:$tab_atts['title'];
        $tab_atts['tab_icon'] = !array_key_exists('tab_icon',$tab_atts)?'icon-cog':$tab_atts['tab_icon'];
        if (isset($tab_atts['title']) || isset($tab_atts['tab_icon'])) {
            $tabs_nav .= '<li data-model="md_hor_tabs">
                    <a href="#tab-' . (isset($tab_atts['tab_id']) ? $tab_atts['tab_id'] : sanitize_title($tab_atts['title'])) . '"><i class="right-icon '.$tab_atts['tab_icon'].'"></i><div class="horTabTitle">'.$tab_atts['title'].'</div><i class="right-icon icon-angle-right"></i></a>
                </li>';
        }
    }
    if($hasBg=='yes'){
        $tabs_nav.= '<div class="overlay"></div>';
    }
    $tabs_nav .= '</ul>' . "\n";
    $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, trim( $element . ' wpb_content_element ' ), $atts );
    $output .= "\n\t" . '<div class="'.$id.' md_hor_tab clearfix '. $css_class .' '. esc_attr($animation["has-animation"]) .'" data-interval="' . 0 . '" '.esc_attr($animation["animation-attrs"]).'>';
    $output .= "\n\t\t" . '<div class="wpb_wrapper wpb_tour_tabs_wrapper ui-tabs vc_clearfix">';
    $output .= wpb_widget_title( array( 'title' => $title, 'extraclass' => $element . '_heading' ) );
    $output .= "\n\t\t\t" . $tabs_nav;
    $output .= "\n\t\t\t" . wpb_js_remove_wpautop( $content );
    $output .= "\n\t\t" . '</div> ' ;
    $output .= "\n\t" . '</div> ';
    ob_start();
    ?>
    <script type="text/javascript">
        var $ = jQuery;
        $(function(){
            if(typeof pixflow_horTab == 'function'){
                pixflow_horTab('<?php echo esc_attr($id); ?>','');
            }
        })
        <?php pixflow_callAnimation(); ?>
    </script>
    <?php
    $output.=ob_get_clean();
    return $output;
}

/*--------------------Horizontal Tab Shortcode--------------------------*/
function pixflow_sc_hor_tab( $atts, $content = null ){
    $output = $title = $tab_id = $tab_icon= '';
    extract( shortcode_atts( array(
            'tab_id'         =>'' ,
            'title'        => '',
            'tab_icon' => ''),
        $atts ) );
    wp_enqueue_script( 'jquery_ui_tabs_rotate' );
    $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_tab ui-tabs-panel wpb_ui-tabs-hide vc_clearfix', 'md_hor_tab', $atts );
    $output .= "\n\t\t\t" . '<div id="tab-' . ( empty( $tab_id ) ? sanitize_title( $title ) : $tab_id ) . '" class="' . $css_class . '">';
    $output .= ( $content == '' || $content == ' ' ) ? esc_attr__( "Empty tab. Edit page to add content here.", 'massive-dynamic' ) : "\n\t\t\t\t" . wpb_js_remove_wpautop( $content );
    $output .= "\n\t\t\t" . '</div> ';
    return $output;
}

/*---------------------------------------------------------
--------------------Tab Horizontal 2 (business)--------------------------
----------------------------------------------------------*/
function pixflow_sc_hor_tabs2( $atts, $content = null ){
    $animation=$output = $title = $tab_icon  = $general_color = $hor_tab_hover_color='';
    extract( shortcode_atts( array(
        'general_color' => 'rgb(0,0,0)',
        'hor_tab_hover_color' => 'rgb(215,176,126)'
    ), $atts ) );
    $animation = array();
    $animation = pixflow_shortcodeAnimation('md_hor_tabs2',$atts);
    wp_enqueue_script('jquery-ui-tabs');
    $element = 'wpb_tabs';
    $id = esc_attr(pixflow_sc_id('md_hor_tabs2'));
    ob_start();
    ?>
    <style scoped="scoped">
        .<?php echo esc_attr($id); ?>.wpb_content_element .wpb_tabs_nav li a i {
            color: <?php echo esc_attr(pixflow_colorConvertor($general_color,'rgba',0.7)); ?>
        }
        .<?php echo esc_attr($id); ?>.wpb_content_element .wpb_tabs_nav li a .horTabTitle,
        .<?php echo esc_attr($id); ?>.wpb_content_element .wpb_tabs_nav li a.md-hor-tab2-add-tab{
            color: <?php echo esc_attr($general_color); ?>;
        }

        .<?php echo esc_attr($id); ?>.wpb_content_element .wpb_tabs_nav li:hover a i,
        .<?php echo esc_attr($id); ?>.wpb_content_element .wpb_tabs_nav li:hover a .horTabTitle,
        .<?php echo esc_attr($id); ?>.wpb_content_element .wpb_tabs_nav li:hover a.md-hor-tab2-add-tab{
            color: <?php echo esc_attr($hor_tab_hover_color); ?>;
        }

        .<?php echo esc_attr($id); ?>.wpb_content_element .wpb_tabs_nav li.ui-tabs-active a i,
        .<?php echo esc_attr($id); ?>.wpb_content_element .wpb_tabs_nav li.ui-tabs-active a .horTabTitle{
            color: <?php echo esc_attr($hor_tab_hover_color); ?>;
        }
        .<?php echo esc_attr($id); ?>.wpb_content_element .wpb_tabs_nav li{
            border: solid 1px <?php echo esc_attr(pixflow_colorConvertor($general_color,'hex')); ?>;
            background: linear-gradient(<?php echo esc_attr(pixflow_colorConvertor($general_color,'hex')); ?>, <?php echo esc_attr(pixflow_colorConvertor($general_color,'hex')); ?>);
        }
    </style>
    <?php
    $output.=ob_get_clean();
    preg_match_all( '/md_hor_tab2([^\]]+)/i', $content, $matches, PREG_OFFSET_CAPTURE );
    $tab_titles = array();
    if ( isset( $matches[1] ) ) {
        $tab_titles = $matches[1];
    }
    $tabs_nav = '';
    $tabs_nav .= '<ul class="wpb_tabs_nav ui-tabs-nav vc_clearfix md-custom-tab">';
    $i=0;
    foreach ( $tab_titles as $tab ) {
        $i++;
        $tab_atts = shortcode_parse_atts($tab[0]);
        $tab_atts['title'] = !array_key_exists('title',$tab_atts)?'Tab '.$i:$tab_atts['title'];
        $tab_atts['tab_icon'] = !array_key_exists('tab_icon',$tab_atts)?'icon-cog':$tab_atts['tab_icon'];
        if (isset($tab_atts['title']) || isset($tab_atts['tab_icon'])) {
            $tabs_nav .= '<li data-model="md_hor_tabs2">
                    <a href="#tab-' . (isset($tab_atts['tab_id']) ? $tab_atts['tab_id'] : sanitize_title($tab_atts['title'])) . '"><i class="right-icon '.$tab_atts['tab_icon'].'"></i><div class="horTabTitle">'.$tab_atts['title'].'</div></a>
                </li>';
        }
    }
    $tabs_nav .= '</ul>' . "\n";
    $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, trim( $element . ' wpb_content_element ' ), $atts );
    $output .= "\n\t" . '<div class="'.esc_attr($id).' md_hor_tab2 clearfix '. $css_class .' '. esc_attr($animation["has-animation"]) .'" data-interval="' . 0 . '" '.esc_attr($animation["animation-attrs"]).'>';
    $output .= "\n\t\t" . '<div class="wpb_wrapper wpb_tour_tabs_wrapper ui-tabs vc_clearfix">';
    $output .= wpb_widget_title( array( 'title' => $title, 'extraclass' => $element . '_heading' ) );
    $output .= "\n\t\t\t" . $tabs_nav;
    $output .= "\n\t\t\t" . wpb_js_remove_wpautop( $content );
    $output .= "\n\t\t" . '</div> ' ;
    $output .= "\n\t" . '</div> ';
    ob_start();
    ?>
    <script type="text/javascript">
        var $ = jQuery;
        $(function(){
            if(typeof pixflow_horTab == 'function'){
                pixflow_horTab('<?php echo esc_attr($id); ?>','business');
            }
        })
        <?php pixflow_callAnimation(); ?>
    </script>
    <?php
    $output.=ob_get_clean();
    return $output;
}

/*--------------------Horizontal Tab 2 Shortcode--------------------------*/
function pixflow_sc_hor_tab2( $atts, $content = null ){
    $output = $title = $tab_id = $tab_icon= '';
    extract( shortcode_atts( array(
        'tab_id'         =>'' ,
        'title'        => '',
        'tab_icon' => ''),
        $atts ) );
    wp_enqueue_script( 'jquery_ui_tabs_rotate' );
    $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_tab ui-tabs-panel wpb_ui-tabs-hide vc_clearfix', 'md_hor_tab2', $atts );
    $output .= "\n\t\t\t" . '<div id="tab-' . ( empty( $tab_id ) ? sanitize_title( $title ) : $tab_id ) . '" class="' . $css_class . '">';
    $output .= ( $content == '' || $content == ' ' ) ? esc_attr__( "Empty tab. Edit page to add content here.", 'massive-dynamic' ) : "\n\t\t\t\t" . wpb_js_remove_wpautop( $content );
    $output .= "\n\t\t\t" . '</div> ';
    return $output;
}

/***********************************************************
 *                          Price Table
 * *********************************************************/
function pixflow_sc_pricetable( $atts, $content = null ){
    if ( !(in_array( 'go_pricing/go_pricing.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) || class_exists( 'GW_GoPricing' )) ) {
        $url = admin_url('themes.php?page=install-required-plugins');
        $a='<a href="'.esc_url($url).'">Go Pricing</a>';

       $mis = '<div class="miss-shortcode"><p class="title">'. esc_attr__('Oops!! Something\'s Missing','massive-dynamic').'</p><p class="desc">'.sprintf(esc_attr__('Please install and activate %s, then create a table. When it\'s done, you can drop the table using this shortcode. ','massive-dynamic'),$a).'</p></div>';

        return $mis;
    }
    extract( shortcode_atts( array(
        'pricetable_id' =>  '',
    ), $atts ) );

    ob_start();

        if ($pricetable_id == ''){
            $gopricing = get_posts( 'post_type="go_pricing_tables"&numberposts=-1' );
            if ( is_array($gopricing) && count($gopricing) > 0){
                $index = count($gopricing)-1;
                $pricetable_id = $gopricing[$index]->ID;
                echo do_shortcode('[go_pricing id="'.esc_attr($pricetable_id).'"]');
            }else{
                $url = admin_url('themes.php?page=install-required-plugins');
                $a='<a href="'.$url.'">Go Pricing</a>';

               $mis = '<div class="miss-shortcode"><p class="title">'. esc_attr__('Oops!! Something\'s Missing','massive-dynamic').'</p><p class="desc">'.sprintf(esc_attr__('No table found, make sure you have created a table in %s before using this shortcode. ','massive-dynamic'),$a).'</p></div>';

                echo wp_kses($mis,$md_allowed_HTML_tags);
              }

        }else{
            echo do_shortcode('[go_pricing id="'.$pricetable_id.'"]');
        }
    return ob_get_clean();
}

/***********************************************************
 *                     Pixflow Price Table
 * *********************************************************/
function pixflow_sc_price_table( $atts, $content = null ){
    extract( shortcode_atts( array(
        'title' =>  'Personal Plan',
        'title_color' =>  '#623e95',
        'price' =>  '50',
        'currency' =>  '$',
        'description' =>
            "Mobile-Optimized
Powerful Metrics
Free Domain
Annual Purchase
24/7 Support",
        'general_color' =>  '#898989',
        'bg_color' =>  '#fff',
        'use_button' =>  'yes',
        'use_button'           => 'yes',
        'button_style'         => 'fill-oval',
        'button_text'          => 'PURCHASE',
        'button_icon_class'    => 'icon-empty',
        'button_color'         => '#b3b3b3',
        'button_text_color'    => '#fff',
        'button_bg_hover_color'=> '#623e95',
        'button_hover_color'   => '#fff',
        'button_size'          => 'standard',
        'button_padding'           => 30,
        'button_url'           => '#',
        'button_target'        => '_self',
        'align'        => 'center',
    ), $atts ) );
    $id = pixflow_sc_id('md_price_table');
    $animation = array();
    $animation = pixflow_shortcodeAnimation('md_price_table',$atts);
    ob_start();
    ?>
    <div class="pixflow-price-table clearfix <?php echo esc_attr($id.' '.$animation['has-animation'].' md-align-'.$align); ?>" <?php echo esc_attr($animation['animation-attrs']); ?>>
        <style scoped="scoped">
            .<?php echo esc_attr($id); ?> .price-table-container{
                background-color:<?php echo esc_attr($bg_color); ?>;
            }
            .<?php echo esc_attr($id); ?> .price-container,
            .<?php echo esc_attr($id); ?> .description{
                color:<?php echo esc_attr($general_color); ?>;
            }
            .<?php echo esc_attr($id); ?> .title,
            .<?php echo esc_attr($id); ?> .separator{
                color:<?php echo esc_attr($title_color); ?>;
            }
        </style>
        <div class="price-table-container">
            <div class="price-container">
                <span class="currency"><?php echo esc_attr($currency); ?></span>
                <span class="price"><?php echo esc_attr($price); ?></span>
            </div>
            <div class="title"><?php echo esc_attr($title); ?></div>
            <div class="separator"><span class="icon-zigzag"></span></div>
            <p class="description"><?php echo preg_replace("/&lt;(.*?)&gt;/i",'',esc_attr($description)); ?></p>
            <div class="price-table-button">
                <?php echo ('yes' == $use_button)?pixflow_buttonMaker($button_style,$button_text,$button_icon_class,$button_url,$button_target,'center',$button_size,$button_color,$button_hover_color,$button_padding,$button_text_color,$button_bg_hover_color):''; ?>
            </div>
        </div>
    </div>
    <?php
    pixflow_callAnimation(true);
    return ob_get_clean();
}

/***********************************************************
 *                          Skill Chart Pie
 * *********************************************************/
function pixflow_sc_pie_chart( $atts, $content = null ){

    $output = $pie_chart_title = $pie_chart_percent = $pie_chart_percent_color=$pie_chart_text_color= '';
    extract( shortcode_atts( array(
        'pie_chart_title'         =>'Animation' ,
        'pie_chart_percent'       => '70',
        'pie_chart_percent_color' => 'rgb(34,188,168)',
        'pie_chart_text_color'    => 'rgb(0,0,0)',
        'align'    => 'center'
        ),$atts ));

    $id = pixflow_sc_id('pie_chart');
    $animation = array();
    $animation = pixflow_shortcodeAnimation('md_pie_chart',$atts);
    ob_start();

    ?>
    <style scoped="scoped">
        .<?php echo esc_attr($id); ?> .label,
        .<?php echo esc_attr($id); ?> .percentage{
            color:<?php echo esc_attr($pie_chart_text_color); ?>;
        }
    </style>
    <div class="<?php echo esc_attr($id.' '.$animation['has-animation'].' md-align-'.$align); ?> md-pie-chart type-1" id="<?php echo esc_attr($id); ?>" data-barColor="<?php echo esc_attr(pixflow_rgb2hex($pie_chart_percent_color)); ?>" data-trackColor="<?php echo esc_attr(str_replace(';','',pixflow_colorConvertor($pie_chart_percent_color,'rgba','0.2'))); ?>" <?php echo esc_attr($animation['animation-attrs']); ?>>

        <div class="chart">
          <div class="percentage" data-percent="<?php echo esc_attr($pie_chart_percent); ?>">
              <span><?php echo esc_attr($pie_chart_percent); ?></span><i>%</i>
          </div>
          <div class="label"><?php echo esc_attr($pie_chart_title); ?></div>
        </div>
    </div>
    <script>
        var $ = jQuery;

        $(function(){
            if ( typeof pixflow_pieChart == 'function' ){
                pixflow_pieChart($('#<?php echo esc_attr($id); ?>'),'<?php echo esc_attr(pixflow_rgb2hex($pie_chart_percent_color)); ?>','<?php echo esc_attr(str_replace(';','',pixflow_colorConvertor($pie_chart_percent_color,'rgba','0.2'))); ?>');
            }
        });
        <?php pixflow_callAnimation(); ?>
    </script>

<?php
    return ob_get_clean();
}

/***********************************************************
 *                          Skill Chart Pie 2
 * *********************************************************/
function pixflow_sc_pie_chart_2( $atts, $content = null ){

    $output = $pie_chart_title = $pie_chart_percent = $pie_chart_percent_color=$pie_chart_text_color= '';
    extract( shortcode_atts( array(
        'pie_chart2_title'         =>'Animation' ,
        'pie_chart2_percent'       => '70',
        'pie_chart2_percent_color' => 'rgb(34,188,168)',
        'pie_chart2_text_color'    => 'rgb(0,0,0)',
        'pie_chart2_icon'=>'icon-cog',
        'pie_chart2_animation'=>'easeInOutQuad',
        'pie_chart_2_show_type'=>'no',
        'pie_chart_2_animation_delay'=>'',
        'pie_chart_2_line_width'=>'9',
        'pie_chart2_bottom_title'=>'',
        'align'    => 'center'
        ),$atts ));

    $id = pixflow_sc_id('pie_chart2');
    $animation = array();
    $animation = pixflow_shortcodeAnimation('md_pie_chart2',$atts);
    if (''==$pie_chart2_title && 'yes'!=$pie_chart_2_show_type)
    {
      $pie_chart2_class="without-title";
    }else {
      $pie_chart2_class="";
    }
    ob_start();

    ?>
    <style scoped="scoped">
        .<?php echo esc_attr($id); ?> .label,
        .<?php echo esc_attr($id); ?> .percentage,
        .<?php echo esc_attr($id); ?> .md_pieChart2_title{
            color:<?php echo esc_attr($pie_chart2_text_color); ?>;
        }
    </style>
    <div class="<?php echo esc_attr($id.' '.$animation['has-animation'].' md-align-'.$align); ?> md-pie-chart type-2 <?php echo esc_attr($pie_chart2_class) ?>" id="<?php echo esc_attr($id); ?>" data-line-width="<?php echo esc_attr($pie_chart_2_line_width); ?>" data-animation-delay="<?php echo esc_attr($pie_chart_2_animation_delay); ?>" data-show-type="<?php echo esc_attr($pie_chart_2_show_type); ?>" data-barColor="<?php echo esc_attr(pixflow_rgb2hex($pie_chart2_percent_color)); ?>" data-animation-type="<?php echo esc_attr($pie_chart2_animation) ?>"    <?php echo esc_attr($animation['animation-attrs']); ?> data-trackColor="<?php echo esc_attr(str_replace(';','',pixflow_colorConvertor($pie_chart2_percent_color,'rgba','0.2'))); ?>"   >

        <div class="chart">
          <div class="percentage" data-percent="<?php echo esc_attr($pie_chart2_percent); ?>" data-title="<?php echo esc_attr($pie_chart2_title); ?>">
              <span class="icon <?php echo esc_attr($pie_chart2_icon); ?>"><p class="md_pieChart2_title"><?php echo esc_attr($pie_chart2_title); ?></p></span>
              <p class="pie_chart2_bottom_title"><?php echo esc_attr($pie_chart2_bottom_title) ?></p>
          </div>

        </div>
    </div>
    <script>
        var $ = jQuery;

        $(function(){
            if ( typeof pixflow_pieChart == 'function' ){
                pixflow_pieChart2($('#<?php echo esc_attr($id); ?>'),'<?php echo esc_attr(pixflow_rgb2hex($pie_chart2_percent_color)); ?>','<?php echo esc_attr(str_replace(';','',pixflow_colorConvertor($pie_chart2_percent_color,'rgba','0.2'))); ?>');
            }
        });
        <?php pixflow_callAnimation(); ?>
    </script>

<?php
    return ob_get_clean();
}

/***********************************************************
 *                  Google Map
 **********************************************************/
function pixflow_sc_google_map( $atts, $content = null ){

    $output = $md_google_map_lat = $md_google_map_lon = $md_google_map_zoom=$md_google_map_type= $md_google_map_height=$md_google_map_marker='';
    extract( shortcode_atts( array(
        'md_google_map_lat'  =>'37.7533106' ,
        'md_google_map_lon'  => '-122.4818691',
        'md_google_map_zoom' => '15',
        'md_google_map_type' => 'gray',
        'md_google_map_marker' => '',
        'md_google_map_height' => '400',
        ),$atts ));

    if(is_numeric($md_google_map_marker)){
        $md_google_map_marker =  wp_get_attachment_image_src( $md_google_map_marker, 'pixflow_recent-portfolio-widget') ;
        $md_google_map_marker = (false == $md_google_map_marker)?PIXFLOW_PLACEHOLDER_BLANK:$md_google_map_marker[0];
    }else{
        $md_google_map_marker=PIXFLOW_THEME_IMAGES_URI."/marker.png";
    }

    //Main JS handler
    wp_enqueue_script('googleMap', "http://maps.google.com/maps/api/js?v=3.15?sensor=false&amp;language=en", array(), PIXFLOW_THEME_VERSION, true);

    $id = pixflow_sc_id('google_map');
    ob_start();
    ?>
    <style scoped="scoped">
        .<?php echo esc_attr($id); ?>{
            height:<?php echo esc_attr($md_google_map_height); ?>px;
        }
    </style>
    <div class="<?php echo esc_attr($id); ?> md-google-map">
    </div>

    <script>
        var $ = jQuery;

        $(function(){
            if ( typeof pixflow_googleMap == 'function' ){
                pixflow_googleMap('<?php echo esc_attr($id); ?>','<?php echo esc_attr($md_google_map_lat); ?>','<?php echo esc_attr($md_google_map_lon); ?>','<?php echo esc_attr($md_google_map_zoom); ?>','<?php echo esc_attr($md_google_map_type); ?>','<?php echo esc_attr($md_google_map_marker); ?>');
            }
        });

    </script>

<?php
    return ob_get_clean();
}

/***********************************************************
*                  Master Slider
**********************************************************/
function pixflow_sc_masterslider( $atts, $content = null ){
    if (!(is_plugin_active( 'masterslider/masterslider.php' ) || defined( 'MSWP_AVERTA_VERSION' ))) {
        $url = admin_url('themes.php?page=install-required-plugins');
        $a='<a href="'.$url.'">Master Slider</a>';

       $mis = '<div class="miss-shortcode"><p class="title">'. esc_attr__('Oops!! Something\'s Missing','massive-dynamic').'</p><p class="desc">'.sprintf(esc_attr__('Please install and activate %s to use this shortcode','massive-dynamic'),$a).'</p></div>';

        return $mis;
    }
    $output = $md_masterslider_alias = '';
    extract( shortcode_atts( array(
        'md_masterslider_alias'  =>''
        ),$atts ));
    ob_start();
    $md_masterslider_alias = esc_attr($md_masterslider_alias);
    if ($md_masterslider_alias == ''){
        $sliders = get_masterslider_names( 'title-alias' );
        if ( is_array($sliders) && (count($sliders) > 0)){
            echo do_shortcode('[masterslider alias="'.esc_attr(current($sliders)).'"]');
        }else{
            $url = admin_url('themes.php?page=install-required-plugins');
            $a='<a href="'.$url.'">Master Slider</a>';
           $mis = '<div class="miss-shortcode"><p class="title">'. esc_attr__('Oops!! Something\'s Missing','massive-dynamic').'</p><p class="desc">'.sprintf(esc_attr__('Can\'t find any slider, please create a slider in %s, then use this shortcode. ','massive-dynamic'),$a).'</p></div>';
            return $mis;
        }
    }else{
        echo do_shortcode("[masterslider alias='$md_masterslider_alias']");
    }
    return ob_get_clean();

}

/***********************************************************
*                  Rev Slider
**********************************************************/
function pixflow_sc_rev_slider( $atts, $content = null ){

    if(!class_exists('RevSlider')) {
        $url = admin_url('themes.php?page=install-required-plugins');
        $a='<a href="'.$url.'">Revolution Slider</a>';

       $mis = '<div class="miss-shortcode"><p class="title">'. esc_attr__('Oops!! Something\'s Missing','massive-dynamic').'</p><p class="desc">'.sprintf(esc_attr__('Please install and activate %s to use this shortcode','massive-dynamic'),$a).'</p></div>';

        return $mis;
    }
    extract( shortcode_atts( array(
        'md_rev_slider_alias'  =>''
        ),$atts ));

    //$output = $md_rev_slider_alias = '';

    ob_start();
    $md_rev_slider_alias = esc_attr($md_rev_slider_alias);
    if ($md_rev_slider_alias == '' || $md_rev_slider_alias == '0'){

        $slider = new RevSlider();
        $arrSliders = $slider->getArrSliders();
        $revsliders = array();
        if ( $arrSliders ) {
            foreach ( $arrSliders as $slider ) {
                $revsliders[ $slider->getTitle() ] = $slider->getAlias();
            }
        }
        if ( is_array($revsliders) && (count($revsliders) > 0)){
            echo do_shortcode('[rev_slider alias="'.esc_attr(current($revsliders)).'"]');
        }else{
            $url = admin_url('admin.php?page=revslider');
            $a='<a href="'.$url.'">Revolution Slider</a>';
           $mis = '<div class="miss-shortcode"><p class="title">'. esc_attr__('Oops!! Something\'s Missing','massive-dynamic').'</p><p class="desc">'.sprintf(esc_attr__('Can\'t find any slider, please create a slider in %s, then use this shortcode. ','massive-dynamic'),$a).'</p></div>';
            return $mis;
        }
    }else{
        echo do_shortcode("[rev_slider alias=$md_rev_slider_alias]");
    }
    return ob_get_clean();

}

/***********************************************************
 *                    Classic Blog
 **********************************************************/
function pixflow_sc_blog_classic( $atts, $content = null ){
    $query=$output =$content
    =$blog_category=$blog_post_number=$blog_text_color=$blog_category_color=
    $blog_category_align=$blog_category_author= $blog_shadow_color  ='';
    $list=$day=array();
    $i=$subStr=0;
    global $paged,$post;
    extract( shortcode_atts( array(
        'blog_category'        => '',
        'blog_title_color'      => 'rgb(68,37,153)',
        'blog_text_color'      => 'rgb(163,163,163)' ,
        'blog_category_color'  => 'rgb(52,202,161)',
        'blog_category_align'  => 'left',
        'blog_category_author' => 'yes',
        'blog_post_number'     => '5',
        'blog_title_size'      => '47',
        'blog_shadow_color'    => 'rgba(0,0,0,.12)'
    ), $atts ) );

    $animation = array();
    $animation = pixflow_shortcodeAnimation('md_blog_classic',$atts);
    $id = pixflow_sc_id('blog-classic');


    if ( get_query_var('paged') ) {
        $paged = get_query_var('paged');
    } elseif ( get_query_var('page') ) {
        $paged = get_query_var('page');
    } else {
        $paged = 1;
    }

    $arrg = array(
        'category_name'=> $blog_category,
        'posts_per_page' => $blog_post_number,
        'paged'          => $paged,
    );

    $query = new WP_Query($arrg);

    ob_start();
    ?>

    <style scoped="scoped">
        <?php if($blog_category_align=='center'){ ?>
            .<?php echo esc_attr($id); ?>.classic-blog .loop-post-content,
            .<?php echo esc_attr($id); ?>.classic-blog .post-categories,
            .<?php echo esc_attr($id); ?>.classic-blog .post-title,
            .<?php echo esc_attr($id); ?>.classic-blog .post-info {
                text-align: center;
            }
        <?php }else{ ?>
            .<?php echo esc_attr($id); ?>.classic-blog .loop-post-content,
            .<?php echo esc_attr($id); ?>.classic-blog .post-categories,
            .<?php echo esc_attr($id); ?>.classic-blog .post-title,
            .<?php echo esc_attr($id); ?>.classic-blog .post-info {
                text-align: left;
            }
        <?php }?>

        .<?php echo esc_attr($id); ?> .loop-post-content{
            -webkit-box-shadow: 0 1px 21px <?php echo esc_attr($blog_shadow_color); ?>;
            -moz-box-shadow: 0 1px 21px <?php echo esc_attr($blog_shadow_color); ?>;;
            box-shadow: 0 1px 21px <?php echo esc_attr($blog_shadow_color); ?>;
        }

        .<?php echo esc_attr($id); ?>.classic-blog .post-title a
        {
            color: <?php echo esc_attr($blog_title_color) ?>;
        }

        .<?php echo esc_attr($id); ?>.classic-blog .continue-reading{
            color: <?php echo esc_attr(pixflow_colorConvertor( $blog_title_color,'rgba',.6)) ?>
        }

        .<?php echo esc_attr($id); ?>.classic-blog .continue-reading:hover{
            background-color: <?php echo esc_attr($blog_title_color) ?>;
            color:#ffffff;
        }

        .<?php echo esc_attr($id); ?>.classic-blog .post-categories a{
            background-color: <?php echo esc_attr($blog_category_color); ?> ;
            border: 2px solid <?php echo esc_attr($blog_category_color); ?>;
        }

        .<?php echo esc_attr($id); ?>.classic-blog .post-categories a:hover{
            color: <?php echo esc_attr($blog_text_color); ?>;
            border-color:<?php echo esc_attr($blog_text_color); ?> ;
            background-color: #FFFFFF;
        }

        .<?php echo esc_attr($id); ?>.classic-blog blockquote{
            color: <?php echo esc_attr(pixflow_colorConvertor($blog_category_color,'rgba',0.16)); ?> ;
        }

        .<?php echo esc_attr($id); ?>.classic-blog  .post-author,
        .<?php echo esc_attr($id); ?>.classic-blog  .post-date a,
        .<?php echo esc_attr($id); ?>.classic-blog blockquote .name{
            color: <?php echo esc_attr($blog_text_color,'rgba','0.6'); ?>;
        }
        .<?php echo esc_attr($id); ?>.classic-blog p{
            color: <?php echo esc_attr($blog_text_color); ?>;
        }
        <?php ?>
        .<?php echo esc_attr($id); ?>.classic-blog .post-title a{
            font-size: <?php echo esc_attr($blog_title_size);?>px;
        }
    </style>

    <div class="<?php echo esc_attr($id.' '.$animation['has-animation']);?> classic-blog classic-blog-<?php echo esc_attr($blog_category_align);?>" <?php echo esc_attr($animation['animation-attrs']);?>>

        <?php while ($query->have_posts()) {
            $subStr=0;
            $i++;
            $query->the_post();

            $format = get_post_format( $post->ID );
            if($format==false) $format = 'standard';

            ?>
        <div class="loop-post-content enblog-classic-container <?php echo esc_attr($format);?>" >

                <?php

                if($format=='audio'){ ?>
                        <?php
                        $audio=pixflow_extract_audio_info(get_post_meta(get_the_ID(), 'audio-url', true));
                        ?>
                        <div class="post-media">

                            <?php if($blog_category_author=='yes'){ ?>
                                <div class="post-author-meta">
                                    <span class="author-image">
                                   <?php $authorId =  get_the_author_meta('ID');
                                    echo get_avatar( $authorId, 50 ); ?>
                                    </span>
                                    <p class="post-author">by:<?php the_author_posts_link(); ?></p>
                                </div>
                            <?php } ?>
                            <?php
                            if($audio != null)
                            {
                                ?>
                                <div class="post-media audio-frame">
                                    <?php
                                    echo pixflow_soundcloud_get_embed($audio['url'],'460');
                                    ?>
                                </div>
                            <?php
                            }
                            ?>

                        </div> <!-- post media -->
                <?php }
                elseif($format=='gallery'){
                    wp_enqueue_script('flexslider-script');
                    wp_enqueue_style('flexslider-style');
                    ?>
                    <div class="post-media">
                        <?php if($blog_category_author=='yes'){ ?>
                            <div class="post-author-meta">
                               <span class="author-image">
                               <?php $authorId =  get_the_author_meta('ID');
                                echo get_avatar( $authorId, 50 ); ?>
                                </span>
                                <p class="post-author">by: <?php the_author_posts_link(); ?></p>
                            </div>
                        <?php } ?>
                    <?php
                    $images = get_post_meta( get_the_ID(), 'fg_perm_metadata');
                    $images = (isset($images[0]))?explode(',',$images[0]):array();
                    if(count($images))
                    { ?>
                        <div class="flexslider">
                            <ul class="slides">
                                <?php
                                $imageSize = 'pixflow_post-single';
                                foreach($images as $img){
                                    $imgTag = wp_get_attachment_image_src($img, $imageSize);
                                    $imgTag = (false == $imgTag)?PIXFLOW_PLACEHOLDER1:$imgTag[0];
                                    ?>
                                    <li class="images" style="background-image: url('<?php echo esc_url($imgTag); ?>'); cursor:pointer" onclick='window.location="<?php the_permalink(); ?>"'>
                                    </li>
                                <?php
                                }?>
                            </ul>
                        </div>
                    <?php
                    }?>
                 </div> <!-- post media -->

                <?php }
                elseif($format=='video'){
                    $videoUrl=get_post_meta( get_the_ID(), 'video-url', true);
                    $findme   = 'vimeo.com';
                    $pos = strpos($videoUrl, $findme);
                    if($pos==false) {
                        $host = 'youtube';
                    }else {
                        $host = 'vimeo';
                    }
                    ?>

                    <div class="post-media">
                        <?php if($blog_category_author=='yes'){ ?>
                            <div class="post-author-meta">
                               <span class="author-image">
                               <?php $authorId =  get_the_author_meta('ID');
                                echo get_avatar( $authorId, 50 ); ?>
                                </span>
                                <p class="post-author">by: <?php the_author_posts_link(); ?></p>
                            </div>
                        <?php } ?>
                        <div class="post-image" title="<?php echo esc_attr(get_the_title()); ?>" >
                            <?php
                            if ( function_exists('has_post_thumbnail') && has_post_thumbnail() ) {
                                $image = get_post_thumbnail_id($post->ID);
                            }else {
                                $image = "";
                            }

                            echo do_shortcode('[md_video md_video_host="'.$host.'" md_video_url_vimeo="'.$videoUrl.'" md_video_url_youtube="'.$videoUrl.'" md_video_style="squareImage" md_video_image="'.$image.'"]'); ?>
                        </div>
                    </div> <!-- post media -->
                <?php }
                elseif($format=='standard'){
                    //Post thumbnail
                    if ( function_exists('has_post_thumbnail') && has_post_thumbnail() ) { ?>
                        <div class="post-media">
                            <?php if($blog_category_author=='yes'){ ?>
                                <div class="post-author-meta">
                                   <span class="author-image">
                                       <?php $authorId =  get_the_author_meta('ID');
                                        echo get_avatar( $authorId, 50 ); ?>
                                    </span>
                                    <p class="post-author">by: <?php the_author_posts_link(); ?></p>
                                </div>
                            <?php } ?>
                            <div class="post-image" title="<?php echo esc_attr(get_the_title()); ?>" >
                                <?php $image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' ); ?>
                                <?php $image_url = (false == $image_url)?PIXFLOW_PLACEHOLDER1:$image_url[0]; ?>
                                <a href="<?php the_permalink(); ?>"><img src='<?php echo esc_url($image_url); ?>'></a>
                            </div>
                        </div> <!-- post media -->
                    <?php }

                }
                elseif($format=='quote'){?>
                    <blockquote class="px-icon icon-quotes-left">
                        <?php
                        $content = apply_filters('the_content',strip_shortcodes(get_the_content(esc_attr__('keep reading', 'massive-dynamic'))));
                        echo "<p>".$content."</p>";
                        ?>
                        <p class="name"><?php the_title(); ?></p>
                    </blockquote>
                </div>
                <?php } ?>

                <?php
                if($format!='quote'){?>
                    <h6 class="post-categories">
                        <?php
                        $terms = get_the_category($post->ID);
                        $catNames=array();
                        if($terms)
                            foreach ($terms as $term)
                                $catNames[] = "<a href=".esc_url( get_category_link( get_cat_ID($term->name)))." title='".$term->name."'>".$term->name."</a>" ;
                         echo implode(', ', $catNames);
                        ?>
                    </h6>
                    <?php
                    $archive_year  = get_the_time('Y');
                    $archive_month = get_the_time('m');
                    $archive_day   = get_the_time('d');
                    ob_start();
                    ?>
                        <div class="post-info-container ">

                            <div class="post-info ">
                                <p class="post-date"><i class="px-icon icon-clipboard3 classic-blog-icon"></i> <a href="<?php echo get_day_link( $archive_year, $archive_month, $archive_day); ?>"><?php the_time(get_option('date_format')) ?></a></p>
                            </div>

                        </div>
                    <?php
                    $postInfoHtml = ob_get_clean();
                    global $md_allowed_HTML_tags;
                    if($blog_category_align == 'left'){
                        echo wp_kses($postInfoHtml,$md_allowed_HTML_tags);
                    }
                    ?>
                    <div class="post-meta">
                        <h1 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
                        <?php
                        if($blog_category_align == 'center'){
                            echo wp_kses($postInfoHtml,$md_allowed_HTML_tags);
                        }
                        ?>
                    </div>
                <?php }

             if($format!='quote'){
                if(has_excerpt())
                {
                    $content = get_the_excerpt();
                }
                else
                {
                    $content = apply_filters('the_content',strip_shortcodes(get_the_content()));
                }
                $subStr=1;
                if(strlen($content) > 800 ){
                    $content= substr($content,0,800).'...';
                }?>
                <div class="classic-blog-content">
                    <p><?php echo wp_kses($content,$md_allowed_HTML_tags); ?></p>
                </div>
                <?php if($subStr){ ?>
                <a href="<?php the_permalink(); ?>" class="continue-reading">Continue Reading <i class="continue-reading-arrow px-icon icon-arrow-right2"></i> <a>
                <?php } ?>


                <div class="sharing clearfix">
                    <?php
                    if ( function_exists('is_plugin_active') && is_plugin_active( 'add-to-any/add-to-any.php' ) ) {
                        if(!get_post_meta( get_the_ID(), 'sharing_disabled', false)){?>
                            <div class="post-share">
                                <a href="#" class="share a2a_dd"></a>
                                <a href="#" class="a2a_dd share-hover"></a>
                            </div>
                            <span class="sepretor">|</span>
                        <?php  }
                    } ?>

                    <div class="post-comment-holder">
                        <a class="post-comment" href="<?php comments_link(); ?>"></a>
                        <a class="post-comment-hover" href="<?php comments_link(); ?>">
                            <span><?php comments_number('0','1','%');?></span>
                        </a>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            <?php

        }

    }

    // We check to see if the shortcode used in a front page or normal page so we can decide about pagination permalink structure
    if(is_front_page()){
        pixflow_get_pagination($query,'',false);
    }
    else{
        pixflow_get_pagination($query,'',true);
    }

    wp_reset_postdata();
    ?>
    </div>
    <script type="text/javascript">
        var $ = jQuery;

        $(function(){
            if ( typeof pixflow_blogPage == 'function' ){
                pixflow_blogPage();
            }
        });
        <?php pixflow_callAnimation(); ?>
    </script>
   <?php
   $return = ob_get_clean();
   return $return;
}

/***********************************************************
 *                       Icon
 **********************************************************/
function pixflow_sc_icon( $atts, $content = null ) {

    extract(shortcode_atts(array(
        'icon_source'               => 'massive_dynamic',
        'icon_icon'                 => 'icon-diamond',
        'icon_url'                  => 'http://',
        'icon_color'                => '#5f5f5f',
        'icon_hover_color'          => '#b6b6b6',
        'icon_fill_color'           => 'rgba(0,0,0,1)',
        'icon_hover_fill_color'     => 'rgba(100,100,100,1)',
        'icon_stroke_color'         => 'rgba(0,0,0,1)',
        'icon_hover_stroke_color'   => 'rgba(100,100,100,1)',
        'icon_size'                 => "153",
        'icon_use_link'             => "No",
        'icon_link'                 => "http://",
        'icon_link_target'          => "_blank",
        'align'                     => 'center'

    ), $atts));

    $animation = array();
    $animation = pixflow_shortcodeAnimation('md_icon',$atts);
    $id = pixflow_sc_id('icon');

    ob_start(); ?>

    <style scoped="scoped">
        <?php echo '.'.esc_attr($id) ?> .icon{
            color: <?php echo esc_attr($icon_color); ?>;
            font-size: <?php echo esc_attr($icon_size); ?>px;
            transition: color 400ms;
        }

        <?php echo '.'.esc_attr($id) ?> .icon:hover{
            color: <?php echo esc_attr($icon_hover_color); ?>;
        }
        <?php echo '.'.esc_attr($id);?> .svg{
            width:<?php echo esc_attr($icon_size); ?>px;
            height:<?php echo esc_attr($icon_size); ?>px;
        }
        <?php echo '.'.esc_attr($id);?> .svg path{
            fill: <?php echo esc_attr($icon_fill_color); ?>;
            stroke: <?php echo esc_attr($icon_stroke_color); ?>;
            transition: fill 400ms, stroke 400ms;
        }

        <?php echo '.'.esc_attr($id);?> .svg:hover path{
            fill: <?php echo esc_attr($icon_hover_fill_color); ?>;
            stroke: <?php echo esc_attr($icon_hover_stroke_color); ?>;
        }

    </style>
    <div class="md-icon <?php echo esc_attr($id.' '.$animation['has-animation']); ?> md-align-<?php echo esc_attr($align);?>" <?php echo esc_attr($animation['animation-attrs']); ?>>
        <?php if($icon_source=='massive_dynamic'){
            if($icon_use_link=='yes'){
            ?>
            <a target="<?php echo esc_attr($icon_link_target)?>" href="<?php echo esc_attr($icon_link)?>">
            <?php }?>
            <span class="icon <?php echo esc_attr($icon_icon) ?>"></span>
            <?php
            if($icon_use_link=='yes'){
            ?></a><?php
            }
        }else{
            if($icon_use_link=='yes'){
            ?>
            <a target="<?php echo esc_attr($icon_link_target)?>" href="<?php echo esc_attr($icon_link)?>">
            <?php }?>
            <img src="<?php echo esc_attr($icon_url)?>" class="svg" width="<?php echo esc_attr($icon_size)?>">
            <?php
            if($icon_use_link=='yes'){
            ?></a>
            <?php }?>
        <?php }?>
    </div>
    <?php
    if($icon_source!='massive_dynamic'){
    ?>
    <script>
        "use strict";
        var $ = (jQuery);
        $(document).ready(function(){
            if(typeof pixflow_iconShortcode == 'function'){
                pixflow_iconShortcode('<?php echo esc_attr($id)?>');
            }
        })
    </script>
    <?php
    }
    pixflow_callAnimation(true);
    return ob_get_clean();
}

/*-----------------------------------------------------------------------------------*/
/*  Text in Box
/*-----------------------------------------------------------------------------------*/

function pixflow_sc_textbox( $atts, $content = null ) {

    extract(shortcode_atts(array(
        'textbox_bg_color'          => '#FFF',
        'textbox_icon'              => 'icon-diamond',
        'textbox_icon_color'        => '#01b1ae',
        'textbox_title'             => 'Figure it out',
        'textbox_heading'           => 'h4',
        'textbox_description'       => 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable',
        'textbox_content_color'     => '#000'
    ), $atts));

    $animation = array();
    $animation = pixflow_shortcodeAnimation('md_textbox',$atts);
    $id = pixflow_sc_id('textbox');

    ob_start(); ?>

    <style scoped="scoped">
        <?php echo '.'.esc_attr($id) ?>{
          background-color: <?php echo esc_attr($textbox_bg_color); ?>;
          border-bottom: 3px solid <?php echo esc_attr($textbox_icon_color); ?>;
        }
        <?php echo '.'.esc_attr($id) ?> .icon{
          color: <?php echo esc_attr($textbox_icon_color); ?>;
        }
        <?php echo '.'.esc_attr($id) ?> .title,
        <?php echo '.'.esc_attr($id) ?> .description{
            color: <?php echo esc_attr($textbox_content_color); ?>;
        }
    </style>

    <div class="text-in-box <?php echo esc_attr($id.' '.$animation['has-animation']); ?>" <?php echo esc_attr($animation['animation-attrs']); ?>>
        <?php if( isset($textbox_icon) && 'icon-' != $textbox_icon ){ ?>
        <div class="icon-holder">
                <div class="icon <?php echo esc_attr($textbox_icon) ?>"></div>
        </div>
        <?php }?>
        <div class=" clearfix"></div>
        <!--End of Icon section-->

        <?php if( isset($textbox_title) && '' != $textbox_title ){ ?>
            <<?php echo esc_attr($textbox_heading) ?> class="title"> <?php echo esc_attr($textbox_title) ?> </<?php echo esc_attr($textbox_heading) ?>>
        <?php } ?>
        <!--End of Title section-->

        <?php if( isset($textbox_description) && '' != $textbox_description ){ ?>
            <p class="description"><?php echo preg_replace("/&lt;(.*?)&gt;/i",'',esc_attr($textbox_description)); ?></p>
        <div class=" clearfix"></div>
        <?php } ?>
        <!--End of Description section-->
    </div>

    <?php pixflow_callAnimation(true); ?>

    <?php
    return ob_get_clean();
}
/*-----------------------------------------------------------------------------------*/
/*  Fancy Text
/*-----------------------------------------------------------------------------------*/

function pixflow_sc_fancy_text( $atts, $content = null ) {

    extract(shortcode_atts(array(
        'fancy_text_bg_type'        => 'icon',
        'fancy_text_icon'              => 'icon-MusicalNote',
        'fancy_text_bg_text'             => '01',
        'fancy_text_bg_color'        => 'rgba(7, 0, 255, 0.15)',
        'fancy_text_title_color'    => 'rgba(55,55,55,1)',
        'fancy_text_title'          => 'Fancy Text',
        'fancy_text_heading'        => 'h5',
        'fancy_text_text_color'     => 'rgba(55,55,55,1)',
        'fancy_text_text'       => "Massive Dynamic has over 10 years of experience in Design. We take pride in delivering Intelligent Designs and Engaging Experiences for clients all over the World.",
        'align'                     => 'left'
    ), $atts));

    $animation = array();
    $animation = pixflow_shortcodeAnimation('md_fancy_text',$atts);
    $id = pixflow_sc_id('fancy_text');
    ob_start();
    ?>
    <style scoped="scoped">
    <?php echo '.'.esc_attr($id);?> .fancy-text-bg{
    color:<?php echo esc_attr($fancy_text_bg_color)?>;
    }
    <?php echo '.'.esc_attr($id);?> .fancy-text-title{
    color:<?php echo esc_attr($fancy_text_title_color)?>;
    }
    <?php echo '.'.esc_attr($id);?> .fancy-text-text{
    color:<?php echo esc_attr($fancy_text_text_color)?>;
    }

    </style>
    <div class="md-fancy-text-container <?php echo 'md-align-'.esc_attr($align); ?>">
        <div class="md-fancy-text fancy-text-type-<?php echo esc_attr($fancy_text_bg_type);?> <?php echo esc_attr($id.' '.$animation['has-animation'].' md-align-'.esc_attr($align)); ?>" <?php echo esc_attr($animation['animation-attrs']); ?>>

        <<?php echo esc_attr($fancy_text_heading) ?> class="fancy-text-bg <?php echo is_numeric($fancy_text_bg_text)?' fancy-text-numeric':''; ?> ">
            <?php
            if($fancy_text_bg_type == 'icon'){
            ?>
            <span class="icon <?php echo esc_attr($fancy_text_icon) ?>"></span>
            <?php }else{
                echo esc_attr($fancy_text_bg_text);
            }?>
        </<?php echo esc_attr($fancy_text_heading) ?>>
        <<?php echo esc_attr($fancy_text_heading) ?> class="fancy-text-title">
            <?php
            echo esc_attr($fancy_text_title);
            ?>
        </<?php echo esc_attr($fancy_text_heading) ?>>
        <p class="fancy-text-text"><?php echo esc_attr($fancy_text_text);?></p>
        </div>
        <div class="clearfix"></div>
        <?php pixflow_callAnimation(true); ?>
    </div>
    <?php
    return ob_get_clean();
}

/*-----------------------------------------------------------------------------------*/
/*  Pixflow Slider
/*-----------------------------------------------------------------------------------*/

function pixflow_sc_slider($atts, $content = null)
{
    $output = $slider_num = '';
    extract( shortcode_atts( array(
        'slider_num'         => '3',
        'slider_autoplay' => 'yes',
        'slider_autoplay_duration' => '3',
        'slider_height_mode' => 'fit',
        'slider_height' => '600',
        /*'slider_skin' => 'vertical',*/
        'slider_title_custom_font' => 'no',
        'slider_title_font' => 'font_family:Roboto%3A100%2C200%2C300%2Cregular%2C500%2C600%2C700%2C800%2C900|font_style:200%20light%20regular%3A200%3Anormal',
        'slider_subtitle_custom_font' => 'no',
        'slider_subtitle_font' => 'font_family:Roboto%3A100%2C200%2C300%2Cregular%2C500%2C600%2C700%2C800%2C900|font_style:200%20light%20regular%3A200%3Anormal',
        'slider_desc_custom_font' => 'no',
        'slider_desc_font' => 'font_family:Roboto%3A100%2C200%2C300%2Cregular%2C500%2C600%2C700%2C800%2C900|font_style:200%20light%20regular%3A200%3Anormal',
    ), $atts ) );

    for($i=1; $i<=$slider_num; $i++){
        $slides[$i] = shortcode_atts( array(
            'slide_subtitle_'.$i        => 'Know About',
            'slide_subtitle_color_'.$i    => "#dbdbdb",
            'slide_title_'.$i => 'Massive Dynamic <br> Unique Slider',
            'slide_title_color_'.$i => '#ffffff',
            'slide_desc_'.$i => 'Lorem ipsum dolor sit amet.Lorem ipsum dolor sit amet.Lorem ipsum dolor sit amet.',
            'slide_desc_color_'.$i => 'rgb(0, 255, 153)',
            'slide_image_'.$i => PIXFLOW_THEME_IMAGES_URI."/place-holder.jpg",
            'slide_image_color_'.$i => 'rgba(0, 0, 0, 0.4)',
            //button1
            'slide_btn1_'.$i => 'yes',
            'slide_btn1_title_'.$i => 'DOWNLOAD',
            'slide_btn1_link_'.$i => 'http://massivedynamic.co/',
            'slide_btn1_target_'.$i => '_blank',
            'slide_btn1_color_'.$i => '#FFF',
            'slide_btn1_hover_color_'.$i => '#ff0054',
            //button2
            'slide_btn2_'.$i => 'yes',
            'slide_btn2_title_'.$i => 'READ MORE',
            'slide_btn2_link_'.$i => 'http://demo.massivedynamic.co/general/',
            'slide_btn2_target_'.$i => '_blank',
            'slide_btn2_color_'.$i => '#FFF',
            'slide_btn2_hover_color_'.$i => '#ff0054',

        ), $atts );
    }
    $id = pixflow_sc_id('md_slider');
    // Load Custom fonts
    $slider_skin = 'classic';
    if('yes' == $slider_title_custom_font  && $slider_title_font != ''){
        $slider_title_font = str_replace("font_family:", "", $slider_title_font);
        $arr = explode("%3A", $slider_title_font, 2);
        $title_font = $arr[0];
        $title_font = str_replace("%20", " ", $title_font);
    }
    if('yes' == $slider_subtitle_custom_font  && $slider_subtitle_font != ''){
        $slider_subtitle_font = str_replace("font_family:", "", $slider_subtitle_font);
        $arr = explode("%3A", $slider_subtitle_font, 2);
        $subtitle_font = $arr[0];
        $subtitle_font = str_replace("%20", " ", $subtitle_font);
    }
    if('yes' == $slider_desc_custom_font  && $slider_desc_font != ''){
        $slider_desc_font = str_replace("font_family:", "", $slider_desc_font);
        $arr = explode("%3A", $slider_desc_font, 2);
        $desc_font = $arr[0];
        $desc_font = str_replace("%20", " ", $desc_font);
    }
    if('yes' == $slider_title_custom_font || 'yes' == $slider_subtitle_custom_font || 'yes' == $slider_desc_custom_font){
        if('yes' == $slider_title_custom_font) {
            wp_enqueue_style('vc_google_fonts_' . $title_font, '//fonts.googleapis.com/css?family=' . $slider_title_font);
            // Extract Title font style
            if (isset($slider_title_font[0])) {
                $slider_title_font = explode('|', rawurldecode($slider_title_font));
                $title_font_style = explode(':', $slider_title_font[1]);
                $title_font_style = explode(' ', $title_font_style[1]);
                $title_font_family = $title_font;
                $title_font_weight = $title_font_style[0];
                $title_font_style = $title_font_style[1];
            }
        }
        if('yes' == $slider_subtitle_custom_font) {
            wp_enqueue_style('vc_google_fonts_' . $subtitle_font, '//fonts.googleapis.com/css?family=' . $slider_subtitle_font);
            // Extract Subtitle font style
            if (isset($slider_subtitle_font[0])) {
                $slider_subtitle_font = explode('|', rawurldecode($slider_subtitle_font));
                $subtitle_font_style  = explode(':', $slider_subtitle_font[1]);
                $subtitle_font_style  = explode(' ', $subtitle_font_style[1]);
                $subtitle_font_family = $subtitle_font;
                $subtitle_font_weight = $subtitle_font_style[0];
                $subtitle_font_style  = $subtitle_font_style[1];
            }
        }
        if('yes' == $slider_desc_custom_font) {
            wp_enqueue_style('vc_google_fonts_' . $desc_font, '//fonts.googleapis.com/css?family=' . $slider_desc_font);
            // Extract Description font style
            if (isset($slider_subtitle_font[0])) {
                $slider_desc_font = explode('|', rawurldecode($slider_desc_font));
                $desc_font_style  = explode(':', $slider_desc_font[1]);
                $desc_font_style  = explode(' ', $desc_font_style[1]);
                $desc_font_family = $desc_font;
                $desc_font_weight = $desc_font_style[0];
                $desc_font_style  = $desc_font_style[1];
            }
        }
    }
    ob_start();
    $sliderClass = 'pixflow-slider ';
    $slideClass = 'pixflow-slide ';
    if ($slider_skin == 'vertical'){
        $data = 'data-skin='.esc_attr($slider_skin).' data-autoplay='.esc_attr($slider_autoplay).' data-autoplay-speed='.esc_attr($slider_autoplay_duration).' data-slider-id='.esc_attr($id).'';
    }else{
        $autoPlay = ($slider_autoplay == 'no') ? 'false' : 'true';
        $data = 'data-autoplay ='.$autoPlay.' data-autoplay-speed='.esc_attr($slider_autoplay_duration);
        $sliderClass .= 'gallery';
        $slideClass .= 'gallery-cell';
    }
    ?>
    <div class="md-pixflow-slider <?php echo esc_attr($id.' '.$slider_skin); ?>" >
        <div  <?php echo $data; ?>  data-height-mode="<?php echo esc_attr($slider_height_mode) ?>"  class="<?php echo esc_attr($sliderClass) ?>">
        <?php
        foreach( $slides as $key=>$slide ){
            $subtitle = $slide['slide_subtitle_'.$key];
            $subtitleColor = $slide['slide_subtitle_color_'.$key];
            $title = $slide['slide_title_'.$key];
            $titleColor = $slide['slide_title_color_'.$key];
            $desc = $slide['slide_desc_'.$key];
            $descColor = $slide['slide_desc_color_'.$key];
            $image = $slide['slide_image_'.$key];
            if ($image != '' && is_numeric($image)) {
                $image = wp_get_attachment_image_src($image, 'full') ;
                $image = (false == $image)?PIXFLOW_PLACEHOLDER_BLANK:$image[0];
            }
            $overlay = $slide['slide_image_color_'.$key];
            $btn1 = $slide['slide_btn1_'.$key];
            $btn1Title = $slide['slide_btn1_title_'.$key];
            $btn1Link = $slide['slide_btn1_link_'.$key];
            $btn1Target = $slide['slide_btn1_target_'.$key];
            $btn1Color = $slide['slide_btn1_color_'.$key];
            $btn1HoverColor = $slide['slide_btn1_hover_color_'.$key];

            $btn2 = $slide['slide_btn2_'.$key];
            $btn2Title = $slide['slide_btn2_title_'.$key];
            $btn2Link = $slide['slide_btn2_link_'.$key];
            $btn2Target = $slide['slide_btn2_target_'.$key];
            $btn2Color = $slide['slide_btn2_color_'.$key];
            $btn2HoverColor = $slide['slide_btn2_hover_color_'.$key];

            $subtitleStyle = ('vertical' == $slider_skin)?'background-color':'color';
            ?>
            <div class="<?php echo esc_attr($slideClass) ?>">
                <div class="pixflow-slide-bg" style="background-image: url(<?php echo esc_attr($image); ?>) "></div>
                <div class="pixflow-slide-overlay" style="background-color:<?php echo esc_attr($overlay) ?>"></div>
                <div class="pixflow-slide-container">
                    <div class="slide-subtitle" style="<?php echo esc_attr($subtitleStyle); ?>: <?php echo esc_attr($subtitleColor); ?>"><?php echo esc_attr($subtitle); ?></div>
                    <div class="slide-title" style="color: <?php echo esc_attr($titleColor); ?>"><?php echo preg_replace("/&lt;(.*?)&gt;/i",'',esc_attr($title));?></div>
                    <div class="slide-desc" style="color: <?php echo esc_attr($descColor); ?>"><?php echo preg_replace("/&lt;(.*?)&gt;/i",'',esc_attr($desc)); ?></div>
                    <?php if('classic' == $slider_skin){ ?>
                    <div class="btn-container">
                        <?php echo ('yes' == $btn1)?pixflow_buttonMaker('fade-oval',$btn1Title,'icon-empty',$btn1Link,$btn1Target,'left','standard',$btn1Color,$btn1HoverColor,0,'#fff','#000',array(),false):''; ?>
                        <?php echo ('yes' == $btn2)?pixflow_buttonMaker('fade-oval',$btn2Title,'icon-empty',$btn2Link,$btn2Target,'left','standard',$btn2Color,$btn2HoverColor,0,'#fff','#000',array(),false):''; ?>
                    </div>
                    <?php } ?>
                </div>
            </div>
    <?php } ?>
        </div>
        <div data-slider-id="<?php echo esc_attr($id); ?>" class="pixflow-slider-dots-container" >
            <div class="current-slide-no">01</div>
            <ul class="pixflow-slider-dots">
                <?php foreach( $slides as $key=>$slide ){ ?>
                    <li class="pixflow-slider-dot <?php echo ('1' == $key)?esc_attr('active'):''; ?>" data-slide-no="<?php echo esc_attr($key); ?>">
                        <span class="circle-dot"></span>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>

    <style scoped="scoped">
        .<?php echo esc_attr($id); ?> .pixflow-slide{
        <?php if('custom' == $slider_height_mode) {?>
            height: <?php echo esc_attr($slider_height); ?>px;
        <?php }?>
        }
        .<?php echo esc_attr($id); ?> .slide-subtitle{
        <?php if('yes' == $slider_subtitle_custom_font) {?>
            font-family:    <?php echo esc_attr($subtitle_font_family); ?>;
            font-style:     <?php echo esc_attr($subtitle_font_style); ?>;
            font-weight:    <?php echo esc_attr($subtitle_font_weight); ?>;
        <?php }?>
        }
        .<?php echo esc_attr($id); ?> .slide-title{
        <?php if('yes' == $slider_title_custom_font) {?>
            font-family:    <?php echo esc_attr($title_font_family); ?>;
            font-style:     <?php echo esc_attr($title_font_style); ?>;
            font-weight:    <?php echo esc_attr($title_font_weight); ?>;
        <?php }?>
        }
        .<?php echo esc_attr($id); ?> .shortcode-btn span{
        <?php if('yes' == $slider_title_custom_font) {?>
            font-family:    <?php echo esc_attr($title_font_family); ?>;
            font-style:     <?php echo esc_attr($title_font_style); ?>;
            font-weight:    <?php echo esc_attr($title_font_weight); ?>;
        <?php }?>
        }
        .<?php echo esc_attr($id); ?> .shortcode-btn .button-standard.fade-oval{
        <?php if('yes' == $slider_title_custom_font) {?>
            font-family:    <?php echo esc_attr($title_font_family); ?>;
            font-style:     <?php echo esc_attr($title_font_style); ?>;
            font-weight:    <?php echo esc_attr($title_font_weight); ?>;
        <?php }?>
        }
        .<?php echo esc_attr($id); ?> .slide-desc{
        <?php if('yes' == $slider_desc_custom_font) {?>
            font-family:    <?php echo esc_attr($desc_font_family); ?>;
            font-style:     <?php echo esc_attr($desc_font_style); ?>;
            font-weight:    <?php echo esc_attr($desc_font_weight); ?>;
        <?php }?>
        }
    </style>

    <script type="text/javascript">
        var $ = jQuery;
        if(typeof pixflow_pixflowSlider == 'function'){
            pixflow_pixflowSlider();
        }
    </script>

    <?php
    return ob_get_clean();
}

/*-----------------------------------------------------------------------------------*/
/*  Text Box
/*-----------------------------------------------------------------------------------*/

function pixflow_sc_text_box( $atts, $content = null ) {

    extract(shortcode_atts(array(
        'textbox_title'                   => 'Tags & Models',
        'textbox_text'                    => 'It is a long established fact that a reader will be dis It is a long',
        'textbox_icon'                    => 'icon-PriceTag',
        'textbox_text_color'              => 'rgb(80,80,80)',
        'textbox_text_hover_color'        => 'rgb(255,255,255)',
        'textbox_background_color'        => 'rgb(230,231,237)',
        'textbox_background_hover_color'  => 'rgb(255,0,84)'
    ), $atts));

    $animation = array();
    $animation = pixflow_shortcodeAnimation('md_text_box',$atts);
    $id = pixflow_sc_id('text_box');

    ob_start(); ?>

    <style scoped="scoped">
        <?php echo '.'.esc_attr($id); ?>{
          background-color: <?php echo esc_attr($textbox_background_color); ?>;
        }

        <?php echo '.'.esc_attr($id); ?>:hover{
          background-color: <?php echo esc_attr($textbox_background_hover_color); ?>;
        }

        <?php echo '.'.esc_attr($id); ?> .text-box-title,
        <?php echo '.'.esc_attr($id); ?> .text-box-icon,
        <?php echo '.'.esc_attr($id); ?> .text-box-description{
            color: <?php echo esc_attr($textbox_text_color); ?>;
        }

        <?php echo '.'.esc_attr($id); ?>:hover .text-box-title,
        <?php echo '.'.esc_attr($id); ?>:hover .text-box-icon,
        <?php echo '.'.esc_attr($id); ?>:hover .text-box-description{
            color: <?php echo esc_attr($textbox_text_hover_color); ?>;
        }

    </style>

    <div class="text-box <?php echo esc_attr($id.' '.$animation['has-animation']); ?>" <?php echo esc_attr($animation['animation-attrs']); ?>>
        <div class="text-box-content">
            <div class="text-box-icon-holder">
                <?php if( isset($textbox_icon) && 'icon-' != $textbox_icon ){ ?>
                    <div class="text-box-icon <?php echo esc_attr($textbox_icon) ?>"></div>
                <?php }?>
            </div>
            <div class="clearfix"></div>
            <!--End of Icon section-->

            <?php if( isset($textbox_title) && '' != $textbox_title ){ ?>
                <h3 class="text-box-title"> <?php echo substr(esc_attr($textbox_title),0,20); ?> </h3>
            <?php } ?>
            <!--End of Title section-->
        </div>
        <?php if( isset($textbox_text) && '' != $textbox_text ){ ?>
            <p class="text-box-description"><?php echo substr(preg_replace("/&lt;(.*?)&gt;/i",'',esc_attr($textbox_text)),0,80); ?></p>
        <div class="clearfix"></div>
        <?php } ?>
        <!--End of Description section-->
    </div>

    <script type="text/javascript">
        var $ = jQuery;
        if(typeof pixflow_textBox == 'function'){
            pixflow_textBox();
        }

        <?php pixflow_callAnimation(); ?>

    </script>

    <?php
    return ob_get_clean();
}

/*----------------------------------------------------------------
                    Subscribe Modern
-----------------------------------------------------------------*/
function pixflow_sc_modern_subscribe( $atts, $content = null ){
    if ( !shortcode_exists( 'mc4wp_form' ) ) {
        $url = admin_url('themes.php?page=install-required-plugins');
        $a='<a href="'.$url.'">MailChimp for WordPress Lite</a>';
        $mis = '<div class="miss-shortcode"><p class="title">'. esc_attr__('Oops!! Something\'s Missing','massive-dynamic').'</p><p class="desc">'.sprintf(esc_attr__('Please install and activate "%s" to use this shortcode.','massive-dynamic'),$a).'</p></div>';
        return $mis;
    }
    $mailChimp = get_posts( 'post_type="mc4wp-form"&numberposts=1' );

    if ( empty($mailChimp)){
        $url = admin_url('/admin.php?page=mailchimp-for-wp-forms&view=add-form');
        $a='<a href="'.$url.'">MailChimp for WordPress Lite</a>';
        $mis = '<div class="miss-shortcode"><p class="title">'. esc_attr__('Oops!! Something\'s Missing','massive-dynamic').'</p><p class="desc">'.sprintf(esc_attr__('Please create a form in " %s" plugin before using this shortcode. ','massive-dynamic'),$a).'</p></div>';
        return $mis;
    }
    extract( shortcode_atts( array(
        'subscribe_bgcolor'    =>'#fff',
        'subscribe_title'      =>'Sign Up To Our Newsletter',
        'subscribe_desc'       => 'To get the latest news from us please subscribe your email.we promise worthy news with no spam.',
        'subscribe_shadow'  =>'yes',
        'subscribe_textcolor'  =>'#000',
        'subscribe_image'      =>   PIXFLOW_THEME_IMAGES_URI."/place-holder.jpg",

    ), $atts ) );

    $animation = array();
    $animation = pixflow_shortcodeAnimation('md_modern_subscribe',$atts);
    if(strpos($subscribe_textcolor, 'rgb(') !== false){
        $subscribe_textcolor = pixflow_colorConvertor($subscribe_textcolor,'rgba',1);
    }

    $id = pixflow_sc_id('modern-subscribe');

    if(is_numeric($subscribe_image)){
        $subscribe_image =  wp_get_attachment_image_src( $subscribe_image, 'pixflow_subscribe-modern') ;
        $subscribe_image = (false == $subscribe_image)?PIXFLOW_PLACEHOLDER1:$subscribe_image[0];
    }
    $subscribeShadow = ('yes' == $subscribe_shadow)?'shadow':'';
    ob_start();
    ?>
    <style scoped="scoped">
        .<?php echo esc_attr($id);?>{
            background-color:<?php echo esc_attr($subscribe_bgcolor);?>;
        }
        .<?php echo esc_attr($id);?> .modern-subscribe-title{
            color: <?php echo esc_attr(pixflow_colorConvertor($subscribe_textcolor,'rgba',0.9)); ?> ;
        }
        .<?php echo esc_attr($id);?> .modern-subscribe-desc{
            color: <?php echo esc_attr(pixflow_colorConvertor($subscribe_textcolor,'rgba',0.7)); ?> ;
        }
        .<?php echo esc_attr($id);?> .subscribe-image{
            background-image:url(<?php echo esc_attr($subscribe_image); ?>);
        }
        .<?php echo esc_attr($id);?> .modern-subscribe-button{
            color: <?php echo esc_attr(pixflow_colorConvertor($subscribe_textcolor,'rgba',0.4)); ?> ;
        }

        .<?php echo esc_attr($id);?> .modern-subscribe-button:hover{
            color: <?php echo esc_attr(pixflow_colorConvertor($subscribe_textcolor,'rgba',1)); ?> ;
        }

        .<?php echo esc_attr($id);?> .modern-subscribe-textbox{
            border-color:<?php echo esc_attr(pixflow_colorConvertor($subscribe_textcolor,'rgba',0.7)); ?> ;
            color: <?php echo esc_attr(pixflow_colorConvertor($subscribe_textcolor,'rgba',0.5)); ?> ;
        }

        .<?php echo esc_attr($id);?> .send ::-webkit-input-placeholder{
            /* WebKit browsers */
            color:<?php echo esc_attr(pixflow_colorConvertor($subscribe_textcolor,'rgba',0.5)); ?> ;
        }

        .<?php echo esc_attr($id);?> .send :-moz-placeholder {
            /* Mozilla Firefox 4 to 18 */
            color:<?php echo esc_attr(pixflow_colorConvertor($subscribe_textcolor,'rgba',0.5)); ?> ;
            opacity: 1;
        }

        .<?php echo esc_attr($id);?> .send :-moz-placeholder {
            /* Mozilla Firefox 19+ */
            color:<?php echo esc_attr(pixflow_colorConvertor($subscribe_textcolor,'rgba',0.5)); ?> ;
            opacity: 1;
        }


        .<?php echo esc_attr($id);?> .send :-ms-input-placeholder {
            /* Internet Explorer 10+ */
            color:<?php echo esc_attr(pixflow_colorConvertor($subscribe_textcolor,'rgba',0.5)); ?> ;
        }
    </style>

    <div class="modern-subscribe <?php echo esc_attr($id.' '.$animation['has-animation'].' '.$subscribeShadow) ?> clearfix" <?php echo esc_attr($animation['animation-attrs']) ?>>
        <?php
        echo do_shortcode('[mc4wp_form id="'.$mailChimp[0]->ID.'"]');
        ?>
        <div class="subscribe-content">
            <?php if(!empty($subscribe_title)){ ?>
                <h2 class="modern-subscribe-title"><?php echo esc_attr($subscribe_title);?></h2>
            <?php } ?>
            <?php if(!empty($subscribe_desc)){ ?>
                <div class="modern-subscribe-desc"><?php echo esc_attr($subscribe_desc);?></div>
            <?php } ?>

            <form class="send">
                <input type="text" name="name" placeholder="Name" class="modern-subscribe-textbox name-input">
                <br/>
                <input type="email" name="mail" placeholder="Email Address" class="modern-subscribe-textbox email-input left">
                <button class="modern-subscribe-button left px-icon icon-arrow-right2"></button>
                <input type="hidden" class="errorcolor">
                <input type="hidden" class="successcolor">
                <div class="subscribe-err"></div>
            </form>

        </div>
        <div class="subscribe-image"></div>

    </div>

    <script type="text/javascript">
        var $ = jQuery;
        if(typeof pixflow_modernSubscribe == 'function'){
            pixflow_modernSubscribe();
        }
        <?php pixflow_callAnimation(); ?>
    </script>
    <?php
    return ob_get_clean();
}

/*-----------------------------------------------------------------------------------*/
/*  MD Slider Carousel
/*-----------------------------------------------------------------------------------*/

function pixflow_sc_slider_carousel($atts, $content = null)
{
    $slider_heights=0;
    extract(shortcode_atts(array(
        'slider_images'              => PIXFLOW_THEME_IMAGES_URI."/place-holder.jpg",
        'slider_heights'             => '600',
        'slider_margin'             => '20',
        'slider_nav_active_color'   => 'rgba(68,123,225,1)',
        'slider_shadow'             => 'yes',
        'slider_slider_speed'       => '5',
        'slider_auto_play'          => 'yes',
        'align'                     => 'center',
    ), $atts));
    $animation = array();
    $animation = pixflow_shortcodeAnimation('md_slider_carousel',$atts);
    $id = pixflow_sc_id('SliderCarousel');

    if($slider_auto_play=='yes'){
        $slider_auto_play= $slider_slider_speed*1000;
    }else{
        $slider_auto_play='false';
    }
    ob_start();

    // Main Image
    $image_url = wp_get_attachment_url($slider_images);
    $image_url = (false == $image_url)?PIXFLOW_PLACEHOLDER1:$image_url;

    $image_pointer = explode(",",$slider_images);

    if($image_url==false){
        $image_pointer=array(
        '0'=>$slider_images,
        '1'=>$slider_images,
        '2'=>$slider_images
        );
    }
    $counter = 0;
    ?>
    <style scoped="scoped">
        #<?php echo esc_attr($id); ?> .gallery-cell{
            height: <?php echo round(esc_attr($slider_heights))-40?>px;
            margin:0 <?php echo esc_attr($slider_margin)?>px;
        }
        #<?php echo esc_attr($id); ?> .flickity-viewport{
            height: <?php echo round(esc_attr($slider_heights))+40?>px !important;
        }

        #<?php echo esc_attr($id); ?> .dot.is-selected{
            background:<?php echo esc_attr($slider_nav_active_color)?>
        }
        <?php if($slider_shadow == 'yes'){?>
        @media screen and ( min-width: 768px ) {
            #<?php echo esc_attr($id); ?> .gallery-cell{
                  box-shadow: 0px 20px 40px 0px #aaa;
            }
        }
        <?php }?>
    </style>
    <div id="<?php echo esc_attr($id); ?>" class="slider-carousel <?php echo esc_attr($animation['has-animation'].' md-align-'.$align); ?>" <?php echo esc_attr($animation['animation-attrs']); ?>>

        <div class="gallery js-flickity" data-flickity-options='{
                "contain": true ,
                "initialIndex": 1 ,
                "autoPlay": <?php echo esc_attr($slider_auto_play);?>,
                "prevNextButtons": false,
                "percentPosition": false,
                "wrapAround": true,
                "pauseAutoPlayOnHover": false,
                "selectedAttraction": 0.045,
                "friction": 0.5
            }'>
            <?php
            foreach( $image_pointer as $value )
            {
                $image_url = wp_get_attachment_url($value);
                $image_url_flag = true;
                if ($image_url == false){
                    $image_url = PIXFLOW_PLACEHOLDER1;
                    $image_url_flag = false;
                }
                ?>
                <div class="gallery-cell" style="<?php echo "background-image:url('".esc_attr($image_url)."');"?>"></div>
            <?php
                $counter++;
            } ?>
        </div>
    </div> <!-- End Slider Carousel -->
    <script>
        var $ = jQuery;
        $(function(){
            if(typeof pixflow_sliderCarousel == 'function'){
                pixflow_sliderCarousel($('#<?php echo esc_attr($id); ?> .gallery'),<?php echo esc_attr($slider_auto_play);?>)
            }
        })
        <?php pixflow_callAnimation(); ?>
    </script>
    <?php
    return ob_get_clean();
}
/*-----------------------------------------------------------------------------------*/
/*  Double Slider
/*-----------------------------------------------------------------------------------*/
function pixflow_sc_doubleSlider($atts, $content = null){
    extract( shortcode_atts( array(
        'slide_num' => '3',
        'double_slider_auto_play' => 'yes',
        'double_slider_duration' => '5',
        'double_slider_height' => '500',
        'double_slider_appearance' => 'double-slider-left'
    ), $atts ) );

    for($i=1; $i<=$slide_num; $i++){
        $slides[$i] = shortcode_atts( array(
            'slide_title_'.$i => 'Title'.$i,
            'slide_sub_title_'.$i => 'Subtitle'.$i,
            'slide_description_'.$i => 'Slide Description'.$i,
            'slide_bg_'.$i => '#447be0',
            'slide_fg_'.$i => '#ffffff',
            'slide_image_'.$i => PIXFLOW_THEME_IMAGES_URI."/place-holder.jpg",
        ), $atts );
    }
    $animation = array();
    $animation = pixflow_shortcodeAnimation('md_double_slider',$atts);

    $id = pixflow_sc_id('md_double_slider');

    if( 'yes' == $double_slider_auto_play){
        $autoPlay = 'true';
    } else{
        $autoPlay = 'false';
    }
    ob_start();
    ?>
    <style scoped="scoped">
        #<?php echo esc_attr($id); ?> .double-slider-image-container li div{
            background-size: cover;
            height: <?php echo esc_attr($double_slider_height)?>px;
        }
        #<?php echo esc_attr($id); ?> .double-slider-text-container ul.double-slider-slides{
            height: <?php echo esc_attr($double_slider_height)?>px;
        }
    </style>
    <div id="<?php echo esc_attr($id); ?>" class="double-slider clearfix <?php echo esc_attr($animation['has-animation'].' '.$double_slider_appearance) ?>" <?php echo esc_attr($animation['animation-attrs']); ?>>
        <div class="double-slider-image-container">
            <ul class="double-slider-slides slides clearfix">
                <?php
                foreach($slides as $key=>$slide){
                    $image = $slide['slide_image_'.$key];
                    if($image != '' && is_numeric($image)){
                        $image = wp_get_attachment_image_src( $image,'full') ;
                        $image = (false == $image)?PIXFLOW_PLACEHOLDER1:$image[0];
                    }
                ?>
                <li>
                    <div style="background-image: url(<?php echo esc_attr($image);?>);"></div>
                </li>
                <?php
                }
                ?>
            </ul>
        </div>

        <div class="double-slider-text-container">
            <div class="double-slider-nav">
                <a href="#" class="double-slider-prev"><i class="px-icon icon-arrow-left4"></i></a>
                <a href="#" class="double-slider-next"><i class="px-icon icon-arrow-right7"></i></a>
            </div>
            <ul class="double-slider-slides slides clearfix">
                <?php
                $bg = array();
                $fgArr = array();
                foreach($slides as $key=>$slide){

                $title = $slide['slide_title_'.$key];
                $subTitle = $slide['slide_sub_title_'.$key];
                $decription = $slide['slide_description_'.$key];
                $bg[] = esc_attr($slide['slide_bg_'.$key]);
                $fgArr[] = esc_attr($slide['slide_fg_'.$key]);
                $fg = $slide['slide_fg_'.$key];
                $image = $slide['slide_image_'.$key];

                if($image != '' && is_numeric($image)){
                $image = wp_get_attachment_image_src( $image) ;
                $image = (false == $image)?PIXFLOW_PLACEHOLDER1:$image[0];
                }
                ?>
                <li style="color:<?php echo esc_attr($fg)?>">
                    <div class="double-slider-container">
                        <p class="double-slider-sub-title"><?php echo esc_attr($subTitle)?></p>
                            <h3 class="double-slider-title"><?php echo esc_attr($title)?></h3>
                        <p class="double-slider-description"><?php echo preg_replace("/&lt;(.*?)&gt;/i",'',esc_attr($decription))?></p>
                    </div>
                </li>
                <?php
                }
                ?>
            </ul>

        </div>
    </div>
    <script>
    "use strict";
    var $ = jQuery;
    $(function(){
        if(typeof pixflow_doubleSlider == 'function'){
            pixflow_doubleSlider('<?php echo esc_attr($id); ?>',["<?php echo implode('","',$bg);?>"],["<?php echo implode('","',$fgArr);?>"],<?php echo esc_attr($autoPlay)?>,<?php echo esc_attr($double_slider_duration*1000)?>);
        }
    })
    <?php echo pixflow_callAnimation(); ?>
    </script>
    <?php
    return ob_get_clean();
}
