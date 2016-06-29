<?php
if(get_post_meta( get_the_ID(), 'related-post', true )== 'show') {

        global $post;
        $categories = get_the_category($post->ID);
        if ($categories) {
            $category_ids = array();
            foreach($categories as $individual_category) $category_ids[] = $individual_category->term_id;
            $args=array(
                'category__in' => $category_ids,
                'post__not_in' => array($post->ID),
                'tax_query' => array(
                    array(
                        'taxonomy' => 'post_format',
                        'field'    => 'slug',
                        'terms'    => array( 'post-format-quote' ),
                        'operator' => 'NOT IN',
                    )
                ),
                'posts_per_page'=> 8, // Number of related posts that will be displayed.
                'ignore_sticky_posts'=> 1,
                'orderby'=>'rand' // Randomize the posts
            );
            $my_query = new wp_query( $args );
            if( $my_query->have_posts() ) {
?>

<div class="recent-post">
    <div class="recent-container">
        <h1 class="recent-title"><?php esc_attr_e('YOU MIGHT ALSO LIKE THESE','massive-dynamic'); ?></h1>
        <div class="recent-items">
            <?php
            while( $my_query->have_posts() ) {  $my_query->the_post();
                global $post;

                if(strlen($post->post_title)>45)
                    $subStr = '...';
                else
                    $subStr='';


                ?>

                    <div class="single_related">
                    <?php if(get_post_format()=='quote'){ ?>
                        <a href="#" title="<?php the_title(); ?>">
                    <?php }else{ ?>
                        <a href="<?php the_permalink() ?>" title="<?php the_title(); ?>">
                    <?php } ?>
                            <div class="recent-image">

                                <?php if (has_post_thumbnail()) { ?>
                                    <?php the_post_thumbnail('pixflow_post-related-sm', array('alt' => get_the_title())); ?>
                                <?php } else { ?>
                                    <span><?php echo substr($post->post_title,0,45).$subStr; ?></span>
                                <?php } ?>
                                <div class="recent-overlay"></div>

                            </div>

                            <h5 class="recent-single-title"><?php echo substr($post->post_title,0,45).$subStr; ?></h5>
                            <h6 class="recent-single-cat">
                                <?php
                                $catNames = array();
                                $counter=0;
                                $terms = get_the_category($post->ID);
                                if($terms)
                                    foreach ($terms as $term)
                                    {
                                      $counter++;
                                      if($counter>5)
                                      break;
                                      $catNames[] = $term->name;
                                    }

                                echo implode(', ', $catNames);
                                ?>
                            </h6>
                        </a>
                    </div>
                <?php }
                wp_reset_postdata();

            ?>
            <div class="clearfix"></div>
        </div>
    </div>
</div>

<?php } } }?>
