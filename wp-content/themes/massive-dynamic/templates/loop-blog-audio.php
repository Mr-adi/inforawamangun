<div class="loop-post-content">
    <?php

    $audio=pixflow_extract_audio_info(get_post_meta(get_the_ID(), 'audio-url', true));
    ?>

    <div class="post-media">

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

    <h6 class="post-categories">
        <?php
        $terms = get_the_category($post->ID);
        $catNames=array();
        if($terms)
            foreach ($terms as $term)
                $catNames[] = "<a href=".esc_url( get_category_link( get_cat_ID($term->name)))." title='".$term->name."'>".$term->name."</a>" ;
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