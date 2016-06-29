<?php
$archive_year  = get_the_time('Y');
$archive_month = get_the_time('m');
$archive_day   = get_the_time('d');
?>
<div class="post-meta">

    <a href="<?php the_permalink(); ?>"><h1 class="post-title"><?php the_title(); ?></h1></a>

    <div class="post-info-container clearfix">

        <div class="post-info clearfix">
            <p class="post-author"><?php esc_attr_e('By ','massive-dynamic').the_author_posts_link().esc_attr_e(' on','massive-dynamic'); ?> </p>
            <p class="post-date"><a href="<?php echo get_day_link( $archive_year, $archive_month, $archive_day); ?>"><?php the_time(get_option('date_format')) ?></a></p>
            <p class="post-category"><?php
                $terms = get_the_category($post->ID);
                $catNames=array();
                if($terms)
                    foreach ($terms as $term)
                        $catNames[] = "<a href=".esc_url( get_category_link( get_cat_ID($term->name)))." title='".$term->name."'>".$term->name."</a>" ;
                 echo " - " . implode(', ', $catNames);;
                ?></p>
        </div>

    </div>

</div>
