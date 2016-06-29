<?php
$archive_year  = get_the_time('Y');
$archive_month = get_the_time('m');
$archive_day   = get_the_time('d');
?>
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

<h1 class="post-title">
    <?php the_title(); ?>
</h1>

<p class="post-date">
    <a href="<?php echo get_day_link( $archive_year, $archive_month, $archive_day); ?>">
        <?php echo get_the_time('F').' '.get_the_time('j').', '.get_the_time('Y'); ?>
    </a>

    <?php
        $terms = get_the_category($post->ID);
        $catNames=array();
        if($terms)
            foreach ($terms as $term)
                $catNames[] = "<a href=".esc_url( get_category_link( get_cat_ID($term->name)))." title='".$term->name."'>".$term->name."</a>" ;
         echo " - ". implode(', ', $catNames);;
        ?>

</p>

<p class="post-desc content-container">
    <?php the_content(); ?>
</p>

<p class="post-tags">
    <?php the_tags(); ?>
</p>
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
