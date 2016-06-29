<?php
$content = pixflow_metabox('portfolio_options.standard_group.0.content');
$attrs = pixflow_metabox('portfolio_options.standard_group.0.attribute_group',array());
$images = pixflow_metabox('portfolio_options.standard_group.0.gallery_group',array());
$linkText = pixflow_metabox('portfolio_options.standard_group.0.link_text','');
$linkURL = pixflow_metabox('portfolio_options.standard_group.0.link_url','#');
$videoPosition = pixflow_metabox('portfolio_options.standard_group.0.video_position','at_start');
$terms = get_the_terms($post->ID, 'skills', 'string');
$portfolioFormat =  get_post_format() ? : 'standard';
$count =  0;

$videoImageSize = $videoImage ='';
if('video' == $portfolioFormat){
    $videoType = pixflow_metabox('portfolio_options.standard_group.0.video_group.0.video_src','youtube');
    //youtube or vimeo
    $videoUrl = pixflow_metabox('portfolio_options.standard_group.0.video_group.0.video_url');
    $videoImage=pixflow_metabox('portfolio_options.standard_group.0.video_group.0.video_image');
    $videoImageSize=pixflow_metabox('portfolio_options.standard_group.0.video_group.0.fullsize_image');
}

if(count($images)>0){
    $gallery = array();
    foreach($images as $image){
        if(!empty($image['images'])){
            $gallery[] = $image['images'];
        }
    }
    $images = $gallery;
}

?>

<div class="owl-carousel" data-video-image-url="<?php echo esc_url($videoImage); ?>" data-fullsize="<?php echo esc_attr($videoImageSize); ?>">
    <?php if( $portfolioFormat == 'video' && $videoPosition == 'at_start') {
        //Parse the content for the first occurrence of video url
        $video = pixflow_extract_video_info($videoUrl);
        if ($video != null) {
            pixflow_get_video_meta($video);
            //Extract video ID
            ?>
            <?php
            if ($video['type'] == 'youtube')
                $src = "http://www.youtube.com/embed/" . esc_attr($video['id']);
            else
                $src = "http://player.vimeo.com/video/" . esc_attr($video['id']) . "?color=ff4c2f";
            ?>
            <div class="item video" data-merge="<?php echo esc_attr($count) ?>">
                <a class="owl-video" href="<?php echo esc_url($src); ?>"></a>
            </div>
            <?php
        }
    }

    for($imageIndex = 0;$imageIndex<count($images);$imageIndex++ ) {
        $count++;
        echo '<div class="item image" data-merge="'. $count.'"><img src="' . esc_url($images[$imageIndex]) . '"><div class="image-holder" style=background-image:url("' . esc_url($images[$imageIndex]) . '");></div></div>';
    }

    if( $portfolioFormat == 'video' && $videoPosition != 'at_start') {
        //Parse the content for the first occurrence of video url
        $video = pixflow_extract_video_info($videoUrl);
        if ($video != null) {
            pixflow_get_video_meta($video);
            //Extract video ID
            ?>
            <?php
            if ($video['type'] == 'youtube')
                $src = "http://www.youtube.com/embed/" . esc_attr($video['id']);
            else
                $src = "http://player.vimeo.com/video/" . esc_attr($video['id']) . "?color=ff4c2f";

            $count++;
            ?>
            <div class="item video" data-merge="<?php echo esc_attr($count) ?>">
                <a class="owl-video" href="<?php echo esc_url($src); ?>"></a>
            </div>
            <?php
        }
    }
    ?>

</div>
<div class="row">
    <div class="box_size clearfix">
        <div class="col-md-12 col-xl-12" >
            <div class="data">

                <?php if ($terms != false) { ?>
                    <div class="category">
                        <?php for($i = 0; $i < count($terms);$i++ ){
                            echo '<span>'.$terms[$i]->name.'</span>';
                        }  ?>

                    </div>
                <?php } ?>

                <h2 class="title"><?php the_title() ?></h2>

                <div class="portfolio-content">
                    <?php echo wpautop($content); ?>
                </div>

                <?php if($linkText != ''){?>
                    <a target="_blank" class="more-project accent-color" href="<?php echo esc_url($linkURL); ?>"><?php echo esc_attr($linkText); ?></a>
                <?php } ?>


                <?php
                if(count($attrs) > 0 ){
                    $emptyArray = (count($attrs) == 1 && $attrs[0]['attr_title'] == '' && $attrs[0]['attr_value'] == '')?true:false;
                    if ($emptyArray){
                        ?>
                        <br>
                        <?php
                    }
                    else{
                    ?>
                    <div class="attributes">
                        <?php for($index = 0; $index < count($attrs);$index++ ){ ?>
                            <div class="attribute clearfix" style="width: calc( 100% / <?php echo count($attrs) ?> )">
                                <?php if(intval($attrs[$index]['attr_icon_enable'])){ ?>
                                    <i class="<?php echo esc_attr($attrs[$index]['attr_icon']); ?>"></i>
                                <?php } ?>

                                <?php if($attrs[$index]['attr_title']!= ''){ ?>
                                    <span class="attr-title"><?php echo esc_attr($attrs[$index]['attr_title']); ?></span>
                                <?php } if($attrs[$index]['attr_value']!=''){ ?>
                                    <div class="desc"><?php echo wpautop($attrs[$index]['attr_value']); ?></div>
                                <?php } ?>

                            </div>
                        <?php }  ?>
                    </div>
                <?php }
                    }
                $sharing = ( function_exists('is_plugin_active') && is_plugin_active( 'add-to-any/add-to-any.php' ) ) ? 'sharing-on':'sharing-off';
                ?>

                <div class="buttons clearfix <?php echo esc_attr($sharing); ?>">
                    <?php echo pixflow_getPostLikeLink( get_the_ID(),'detail' );?>
                    <?php if ( function_exists('is_plugin_active') && is_plugin_active( 'add-to-any/add-to-any.php' ) ) {
                        if(!get_post_meta( get_the_ID(), 'sharing_disabled', false)){?>
                            <div class="sharing">
                                <a href="#" class="share a2a_dd"><i class="icon-share3"></i><span><?php esc_attr_e('SHARE','massive-dynamic'); ?></span></a>
                            </div>
                        <?php  }
                    } ?>
                </div>

            </div>
        </div>
    </div>
</div>