<div class="loop-post-content">
    <?php

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

            <div class="post-image" title="<?php echo esc_attr(get_the_title()); ?>" >

                <?php
                if ( function_exists('has_post_thumbnail') && has_post_thumbnail() ) {
                    $image = get_post_thumbnail_id($post->ID);
                }else {
                    $image = "";
                }
                echo do_shortcode('[md_video md_video_host="'.esc_attr($host).'" md_video_url_vimeo="'.esc_attr($videoUrl).'" md_video_style="squareImage" md_video_image="'.esc_attr($image).'"]'); ?>

            </div>

        </div> <!-- post media -->

    <h6 class="post-categories">
        <?php
        $terms = get_the_category($post->ID);
        $catNames=array();
        if($terms)
            foreach ($terms as $term)
                $catNames[] = "<a href=".esc_url( get_category_link( get_cat_ID($term->name)))." title='".esc_attr($term->name)."'>".esc_attr($term->name)."</a>" ;
        echo implode(', ', $catNames);;
        ?>
    </h6>

    <?php  get_template_part( 'templates/loop', "blog-meta" );

    if(has_excerpt())
    {
        echo the_excerpt(); 
    }
    else
    {
        $content = apply_filters('the_content',strip_shortcodes(get_the_content(esc_attr__('keep reading', 'massive-dynamic'))));
        echo $content;
    }

    ?>

    <div class="post-comment-holder">
        <a class="post-comment" href="<?php comments_link(); ?>"></a>
        <a class="post-comment-hover" href="<?php comments_link(); ?>">
            <span><?php comments_number('0','1','%');?></span>
        </a>
    </div>

    <?php
    if ( function_exists('is_plugin_active') && is_plugin_active( 'add-to-any/add-to-any.php' ) ) {
        if(!get_post_meta( get_the_ID(), 'sharing_disabled', false)){?>
            <div class="post-share">
                <a href="#" class="share a2a_dd"></a>
                <a href="#" class="a2a_dd share-hover"></a>
            </div>
        <?php  }
    } ?>

    <div class="clearfix"></div>
</div>
<?php
if( get_adjacent_post(true,'',true)!=''){
    $adjacent_post = get_adjacent_post(true,'',true);
    if(get_post_format($adjacent_post->ID)!='quote'){
        ?>
        <hr class="loop-bottom-seprator" />
    <?php }else{ ?>
        <hr class="loop-bottom-seprator-without-border" />
    <?php }
}else{
    ?><hr class="loop-bottom-seprator-without-border" />
<?php }?>