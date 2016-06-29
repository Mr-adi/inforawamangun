<?php
$format = get_post_format();
$height=esc_attr(get_post_meta( get_the_ID(), 'image-height', true));
if($format==false){
    if ( function_exists('has_post_thumbnail') && has_post_thumbnail() ) { ?>
        <?php
        $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
        $image = (false == $image)?PIXFLOW_PLACEHOLDER_BLANK:$image[0];
        ?>
        <div class="single-post-media" style="background-image: url('<?php echo esc_url($image); ?>'); <?php if($height!='') echo 'height:'.esc_attr($height).'px'; ?>">
        </div>
    <?php
    }
}elseif($format=='audio'){
    $audio=pixflow_extract_audio_info(get_post_meta(get_the_ID(), 'audio-url', true));
    if($audio != null)
    {
        ?>
        <div class="single-post-media audio-frame" <?php if($height!='') echo 'style="height:'.esc_attr($height).'px"'; ?>">
            <?php
            echo pixflow_soundcloud_get_embed($audio['url'],$height);
            ?>
        </div>
    <?php
    }

}elseif($format=='video') {

    $videoUrl = get_post_meta(get_the_ID(), 'video-url', true);


    //Parse the content for the first occurrence of video url
    $video = pixflow_extract_video_info($videoUrl);
    if ($video != null) {
        pixflow_get_video_meta($video);

        //Extract video ID
        ?>
        <div class="single-post-media" <?php if ($height != '') echo 'style="height:' . esc_attr($height) . 'px"'; ?>>
            <?php
            if ($video['type'] == 'youtube')
                $src = "http://www.youtube.com/embed/" . esc_attr($video['id']);
            else
                $src = "http://player.vimeo.com/video/" . esc_attr($video['id']) . "?color=ff4c2f";
            ?>
            <iframe src="<?php echo esc_url($src); ?>" width="100%" height="<?php echo esc_attr($height); ?>" frameborder="0"
                    webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
        </div>
    <?php
    }
}elseif($format=='gallery'){ ?>

    <?php
    $images =get_post_meta( get_the_ID(), 'fg_perm_metadata');
    $images = (isset($images[0]))?explode(',',$images[0]):array();
    $images2=get_post_gallery_images();
    if(!count($images)&& !count($images2)){
      $height=100;
    }
    ?>

    <div class="single-post-media" <?php if($height!='') echo 'style="height:'.esc_attr($height).'px"'; ?>>
        <?php
        $images =get_post_meta( get_the_ID(), 'fg_perm_metadata');
        $images = (isset($images[0]))?explode(',',$images[0]):array();

        if(count($images))
        { ?>
            <div class="flexslider">
                <ul class="slides">
                    <?php


                    $imageSize = 'full';
                    foreach($images as $img){
                        $imgTag = wp_get_attachment_image_src($img, $imageSize);
                        $imgTag = (false == $imgTag)?PIXFLOW_PLACEHOLDER1:$imgTag[0];
                        ?>
                        <li class="images" style="background-image: url('<?php echo esc_url($imgTag); ?>'); <?php if($height!='') echo 'height:'.esc_attr($height).'px'; ?>">
                        </li>
                    <?php
                    }?>
                </ul>
            </div>
        <?php
      }
      else {
        $images=get_post_gallery_images();
        if(count($images))
        { ?>
            <div class="flexslider">
                <ul class="slides">
                    <?php
                    $imageSize = 'full';
                    foreach($images as $img){
                        ?>
                        <li class="images" style="background-image: url('<?php echo esc_url($img); ?>'); <?php if($height!='') echo 'height:'.$height.'px'; ?>">
                        </li>
                    <?php
                    }?>
                </ul>
            </div>
        <?php
      }
      }
        ?>
    </div>
<?php
}
?>
