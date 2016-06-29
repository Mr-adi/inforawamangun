<?php
if (
    in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins'))) &&
    (
    is_product() || is_shop() || is_product_category() || is_product_tag()
    )
) { ?>
    <div class="container">
        <?php woocommerce_content(); ?>
    </div>
<?php } else {
    if (have_posts()) {
        while (have_posts()) {
            the_post();
            ?>
            <div id="post-<?php the_ID(); ?>" <?php post_class('content-container'); ?> >
                <?php the_content(); ?>
            </div>
            <?php
        }//While have_posts
    }//If have_posts
    wp_reset_query();
    if( comments_open() || get_comments_number() ){ ?>
        <div class="comments">
            <?php comments_template('', true); ?>
        </div>
    <?php
    }
}