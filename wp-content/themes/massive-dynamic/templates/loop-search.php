<div class="results clearfix">

    <?php
    $i=1;
    $page = get_query_var('paged') ? get_query_var('paged') : 1;
    if($page > 1) $i = (($page - 1) * get_query_var('posts_per_page')) + 1;

    while(have_posts()){ the_post(); ?>

        <div class="search-item clearfix">
            <div class="content">

                <?php $hasPostThumbnail = has_post_thumbnail() ?>

                <div class=

                    <?php
                        $postThumbnail = wp_get_attachment_image_src( get_post_thumbnail_id(), array( 1000, 1000 ) );
                        $src = (false == $postThumbnail)?PIXFLOW_PLACEHOLDER1:$postThumbnail[0];

                        if ($hasPostThumbnail) { ?>
                           "place-holder-thumbnail" style=" background-image: url(<?php echo esc_url($src) ?>) ">
                        <?php } else { ?>
                            "place-holder-no-thumbnail">
                        <?php }?>

                </div>

                <h3 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
            </div>
        </div>

    <?php $i++; } ?>

</div>