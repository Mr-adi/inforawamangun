<?php if ( pixflow_get_theme_mod('notification_enable' , PIXFLOW_NOTIFICATION_ENABLE) ){ ?>
    <div class="notification-center close <?php echo esc_attr(pixflow_get_theme_mod('notify_bg',PIXFLOW_NOTIFY_BG)) ?>">
        <div class="header">
            <div class="info clearfix">
                <span class="time"></span><span class="date"></span>
            </div>
            <?php if(pixflow_get_theme_mod('notify_logo',PIXFLOW_NOTIFY_LOGO) != ''){ ?>
                <span class="logo"><img src="<?php echo esc_url(pixflow_get_theme_mod('notify_logo',PIXFLOW_NOTIFY_LOGO)) ?>"></span>
            <?php } ?>
        </div>
        <div id="notification-tabs">

            <div class="pager" >
                <a class="tab-item posts" ><?php echo esc_attr_e('POSTS','massive-dynamic'); ?> </a>
                <a class="tab-item portfolio" ><?php echo esc_attr_e('PORTFOLIO','massive-dynamic'); ?></a>
                <a class="tab-item search" ><?php echo esc_attr_e('SEARCH', 'massive-dynamic'); ?> </a>
                <a class="tab-item shop" ><?php echo esc_attr_e('SHOP','massive-dynamic'); ?></a>
            </div>

            <div class="tabs-container" >

                <div id="opt1" class="posts-tab tab-cell">
                    <div class="clearfix notification-tab">
                        <span class="tab-title"><?php esc_attr_e('POSTS','massive-dynamic'); ?></span>
                        <div class="posts tab-container">
                    <?php
                    $query = new WP_query(array(
                        'post_type' => 'post',
                        'posts_per_page'=>pixflow_get_theme_mod('post_count',PIXFLOW_POST_COUNT)
                    ));

                    while ($query->have_posts()) : $query->the_post();?>
                        <div class="post tab-item" >
                            <div class="date">
                                <span class="day accent-color"><?php echo get_the_time('j'); ?></span>

                                <div class="detail">
                                    <span class="month"><?php echo get_the_time('F'); ?></span>
                                    <span class="year"><?php echo get_the_time('Y'); ?></span>
                                </div>

                                <a class="title" href="<?php the_permalink(); ?>">
                                    <?php the_title(); ?>
                                </a>

                            </div>
                        </div>
            <?php
                    endwhile;
                    wp_reset_postdata();
            ?>
                        </div>
                    </div>
                </div>

                <div id="opt2" class="protfolio-tab tab-cell">
                    <div class="clearfix notification-tab">
                        <span class="tab-title"><?php esc_attr_e('PORTFOLIO','massive-dynamic'); ?></span>

                        <div class="portfolio clearfix" >
                        <?php
                        $query = new WP_query(array(
                            'post_type' => 'portfolio',
                            'posts_per_page'=>pixflow_get_theme_mod('project_count',PIXFLOW_PROJECT_COUNT)
                        ));

                        while ($query->have_posts()) : $query->the_post();?>

                            <div class="portfolio-item tab-item">

                                    <a class="title" href="<?php the_permalink(); ?>">
                                        <?php $thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'medium' ); ?>
                                        <?php $thumbnail = (false == $thumbnail)?PIXFLOW_PLACEHOLDER1:$thumbnail[0]; ?>
                                        <div style="background-image:url(<?php echo esc_url($thumbnail); ?>)" class="portfolio-thumbnail"></div>
                                        <div class="portfolio-title"><?php the_title(); ?></div>
                                        <div class="portfolio-category"><?php
                                            $terms = get_the_terms( get_the_ID(), 'skills' );
                                            $termNames = array();
                                            if($terms){
                                                foreach ($terms as $term){
                                                    if(is_object($term)){
                                                        $termNames[] = @$term->name;
                                                    }
                                                }
                                            }
                                            $portfolioCategories = implode(', ',$termNames);
                                            $categoryPortfolio = $portfolioCategories == ''? '&nbsp;': $portfolioCategories;
                                            echo esc_attr($categoryPortfolio);

                                            ?>
                                        </div>

                                </a>

                            </div>
                        <?php   endwhile;
                        wp_reset_postdata();
                        ?>
                        </div>
                    </div>

                </div>

                <div id="opt3" class="search-tab tab-cell">
                    <div class="notification-tab clearfix">
                        <span class="tab-title"><?php esc_attr_e('SEARCH','massive-dynamic'); ?></span>
                        <div class="search-container">
                            <div class="input-holder">
                                <input id="search-input" placeholder="Search something">
                                <div class="clear-button"></div>
                            </div>
                            <div id="result-container"></div>
                        </div>
                    </div>
                </div>

                <div id="opt4" class="shop-tab tab-cell">
                    <div class="clearfix notification-tab">
                        <span class="tab-title"><?php esc_attr_e('SHOP','massive-dynamic'); ?></span>
                        <div class="absolute">
                            <?php if(function_exists('woocommerce_mini_cart')){
                                woocommerce_mini_cart();
                            }else{
                                ?>
                                <ul class="cart_list">
                                    <li class="empty"><?php esc_attr_e( 'Your Cart Is Empty!','massive-dynamic' ); ?></li>
                                </ul>
                            <?php
                            }?>
                        </div>
                        </div>
                    </div>

            </div>

            <div class="notification-collapse-area"></div>
            <div class="notification-collapse"></div>
        </div>
    </div>
<?php } ?>
