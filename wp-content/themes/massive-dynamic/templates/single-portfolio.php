<?php
$contentType = pixflow_metabox('portfolio_options.template_type','standard');// standard or shortcode base
$relatedSec = pixflow_metabox('portfolio_options.related_items','show');
$class = '';
if($contentType == 'standard'){
    $template = pixflow_metabox('portfolio_options.standard_group.0.portfolio_template','split');
    $class = ' portfolio-'.$template;
}
$post = get_post( get_the_ID() );
$previous_post = get_previous_post();
$next_post = get_next_post();
?>
<div <?php post_class('content-container'.$class); ?>>
    <?php
    if($contentType == 'standard'){
        get_template_part( 'templates/single', "portfolio-$template" );
    } else {
        while (have_posts()) {
            the_post();
            the_content();
        }
    }

$terms = get_the_terms($post->ID, 'skills', 'string');
if ($terms != false) {
    $term_ids = wp_list_pluck($terms, 'term_id');
    $second_query = new WP_Query(array(
        'post_type' => 'Portfolio',
        'tax_query' => array(
            array(
                'taxonomy' => 'skills',
                'field' => 'id',
                'terms' => $term_ids,
                'operator' => 'IN'
            )),
        'posts_per_page' => 10,
        'ignore_sticky_posts' => 1,
        'orderby' => 'rand',
        'post__not_in' => array($post->ID)
    ));
}
?>
<div class="portfolio-nav nav-thumbflip">
    <?php if($previous_post != ''){ ?>
        <a class="prev" href="<?php echo esc_url(get_permalink($previous_post->ID)) ?>">
            <span class="icon-wrap"><span class="nav-icon icon-angle-left"></span></span>
        <span class="post-detail">
            <?php
            $thumbId= get_post_thumbnail_id( $previous_post->ID );
            $thumb = wp_get_attachment_image_src( $thumbId , 'thumbnail' );
            $thumb = (false == $thumb)?PIXFLOW_PLACEHOLDER_BLANK:$thumb[0];
            ?>
            <div class="last-post-thumbnail" style="background-image: <?php echo 'url('. esc_url($thumb) .')';?>"></div>
            <span class="post-detail-overlay"></span>
            <span class="post-detail-title"><?php echo esc_html($previous_post->post_title); ?></span>
        </span>
        </a>
    <?php } if($next_post != ''){ ?>
        <a class="next" href="<?php echo esc_url(get_permalink($next_post->ID)) ?>">
            <span class="icon-wrap"><span class="nav-icon icon-angle-right"></span></span>
        <span class="post-detail">
            <?php
            $thumbId= get_post_thumbnail_id( $next_post->ID );
            $thumb = wp_get_attachment_image_src( $thumbId , 'thumbnail' );
            $thumb = (false == $thumb)?PIXFLOW_PLACEHOLDER_BLANK:$thumb[0];
            ?>
            <div class="last-post-thumbnail" style="background-image: <?php echo 'url('. esc_url($thumb) .')';?>"></div>
            <span class="post-detail-overlay"></span>
            <span class="post-detail-title"><?php echo esc_html($next_post->post_title); ?></span>
        </span>
        </a>
    <?php } ?>
</div>


<?php
if($terms != false && $relatedSec == 'show') { ?>
<div class="recent-project">
    <div class="recent-container box_size">
        <h1 class="recent-title"><?php esc_attr_e('More Projects','massive-dynamic') ?></h1>
        <div class="recent-title-seprator"></div>
        <div class="recent-items">
            <?php
                if ($second_query->have_posts()) {
                    while ($second_query->have_posts()) : $second_query->the_post();
                        global $post;?>
                        <div class="single_related">
                            <a href="<?php the_permalink() ?>" title="<?php the_title(); ?>">
                                <div class="recent-image">

                                    <?php if (has_post_thumbnail()) {
                                        $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'pixflow_music-thumb' );
                                            if (is_array($thumb)){
                                                $url = $thumb['0'];
                                            }else{
                                                $url = PIXFLOW_PLACEHOLDER1;
                                            }
                                          ?>
                                            <span class="image-holder" style="background-image: url(<?php echo esc_url($url); ?>)"></span>

                                    <?php } else { ?>
                                        <span><?php the_title(); ?></span>
                                    <?php } ?>
                                    <div class="recent-overlay"></div>

                                </div>

                                    <h5 class="recent-single-title"><?php the_title(); ?></h5>
                                    <h6 class="recent-single-cat"><?php
                                        $singleTerms = get_the_terms($post->ID, 'skills');
                                        if ($singleTerms && !is_wp_error($singleTerms)) :
                                            $term_slugs_arr = array();
                                            foreach ($singleTerms as $term) {
                                                $term_slugs_arr[] = $term->name;
                                            }
                                            $terms_slug_str = join(", ", $term_slugs_arr);
                                        endif;
                                        echo esc_attr($terms_slug_str);
                                        ?>
                                    </h6>
                                </a>
                            </div>
                        <?php endwhile;
                        wp_reset_postdata();
                    }
                    ?>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    <?php } ?>
    </div>