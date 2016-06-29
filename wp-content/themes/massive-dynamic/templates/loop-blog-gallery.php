<div class="loop-post-content">
    <?php
    $images = get_post_meta( get_the_ID(), 'fg_perm_metadata');
    $images = (isset($images[0]))?explode(',',$images[0]):array();
    $images2=get_post_gallery_images();
    $style="";

    if(!count($images)&& !count($images2)){
      $style="display:none";
    }

    ?>
    <div class="post-media" style="<?php echo esc_attr($style) ?>">
      <?php
        if(count($images))
        { ?>
            <div class="flexslider">
                <ul class="slides">
                    <?php
                    $imageSize = 'pixflow_team-member-style2-thumb';
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
        else {
          $images=get_post_gallery_images();
          if(count($images))
          {
          ?>
          <div class="flexslider">
              <ul class="slides">
                  <?php
                  $imageSize = 'full';
                  foreach($images as $img){
                      ?>
                      <li class="images" style="background-image: url('<?php echo esc_url($img); ?>');">
                      </li>
                  <?php
                  }?>
              </ul>
          </div>
      <?php
        }
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
        $content = apply_filters('the_content',strip_shortcodes(get_the_content(esc_attr__('keep reading', 'massive-dynamic').'<i class="px-icon icon-arrow-right7"></i>')));
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