<?php

require_once(PIXFLOW_THEME_LIB .'/post-types/post-type.php');

class PixflowPortfolio extends PixflowPostType
{

    function __construct()
    {
        parent::__construct('portfolio');
    }

    function Pixflow_CreatePostType()
    {

        // Add meta box goes into our admin_init function
        function pixflow_portfolio_add_meta_box() {
            add_meta_box('customizer', esc_attr__( 'a' ,'massive-dynamic' ),'pixflow_portfolio_meta_box_callback','portfolio');
        }
        add_action( 'add_meta_boxes', 'pixflow_portfolio_add_meta_box');

        function pixflow_portfolio_meta_box_callback() {
            $url = admin_url().'customize.php?url='.urlencode(get_permalink(get_the_ID()));
            ?>
            <div class="back-to-customizer">
                <div class="left-side">
                    <h1 class="title">Continue building your website in<span>MASSIVE BUILDER</span></h1>
                    <p class="description">If you change website settings, it will affect other pages too.<br> To have a custom layout for all portfolio posts, choose unique settings.</p>
                </div>
                <div class="right-side">
                    <a class="button" href="<?php echo esc_url($url); ?>">Live Edit This Page</a>
                    <a target="_blank" href="http://support.pixflow.net" class="help"></a>
                </div>
            </div>
        <?php
        }

    }

    function Pixflow_RegisterScripts()
    {
        wp_register_script('portfolio', PIXFLOW_THEME_LIB_URI . '/post-types/js/portfolio.js', array('jquery'), PIXFLOW_THEME_VERSION);

        parent::Pixflow_RegisterScripts();
    }

    function Pixflow_EnqueueScripts()
    {
        if (! wp_script_is( 'niceScroll', 'enqueued' )) {
            wp_enqueue_script( 'niceScroll',pixflow_path_combine(PIXFLOW_THEME_LIB_URI, 'assets/script/jquery.nicescroll.min.js'),false,PIXFLOW_THEME_VERSION,true);
        }
        wp_enqueue_script('portfolio');
    }
}
function pixflow_portfolio(){
    new PixflowPortfolio();
}
add_action('after_setup_theme', 'pixflow_portfolio');
