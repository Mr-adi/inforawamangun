<?php
class Pixflow_Subscribe_Widget extends WP_Widget
{
    public function __construct()
    {
        parent::__construct(
            'Md_Subscribe_Widgett',
            'Md - Subscribe Widget',
            array(
                'description' => 'Subscribe Widget'
            )
        );
    }

    public function widget( $args, $instance )
    {
        global $md_allowed_HTML_tags;

        if(empty($instance)){
            $instance['title']='';
            $instance['desc']='';
        }

        if ( !shortcode_exists( 'mc4wp_form' ) ) {
            $url = admin_url('themes.php?page=install-required-plugins');
            $a='<a href="'.esc_url($url).'">'.esc_attr__("MailChimp for WordPress Lite.","massive-dynamic").'</a>';
            $mis = '<div class="miss-shortcode"><p class="title">'. esc_attr__('Oops!! Something\'s Missing','massive-dynamic').'</p><p class="desc">'.sprintf(esc_attr__('Please install and activate "%s" to use this shortcode.','massive-dynamic'),$a).'</p></div>';
            echo wp_kses($mis,$md_allowed_HTML_tags);
            return;
        }
        ob_start();
        ?>
        <div class="widget widget-subscribe">
       <?php
        $mailChimp = get_posts( 'post_type="mc4wp-form"&numberposts=1' );
        if ( empty($mailChimp)){
            $url = admin_url('/admin.php?page=mailchimp-for-wp-forms&view=add-form');
            $a='<a href="'.esc_url($url).'">'.esc_attr__("MailChimp for WordPress Lite.","massive-dynamic").'</a>';
            $mis = '<div class="miss-shortcode"><p class="title">'. esc_attr__('Oops!! Something\'s Missing','massive-dynamic').'</p><p class="desc">'.sprintf(esc_attr__('Please create a form in " %s" plugin before using this shortcode. ','massive-dynamic'),$a).'</p></div>';
            echo wp_kses($mis,$md_allowed_HTML_tags);
            ob_end_flush();
            return;
        }
        echo do_shortcode('[mc4wp_form id="'.$mailChimp[0]->ID.'"]');?>
        <h4 class="widget-title"><?php echo wp_kses($instance['title'],$md_allowed_HTML_tags).wp_kses($args['after_title'],$md_allowed_HTML_tags) ?>
        <div class="subscribe-holder"><div class="widget-desc"><?php echo esc_attr($instance['desc']) ?></div>
        <form class="send clearfix">
            <input type="email" name="mail" placeholder="E-Mail" class="widget-subscribe-textbox">
                <button class="widget-subscribe-button"></button>
        </form>
        </div><div class="subscribe-err"></div></div>;
<?php
       ob_end_flush();
    }

    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;

        // Strip tags to remove HTML (important for text inputs)
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['desc'] = strip_tags($new_instance['desc']);
        return $instance;
    }

    public function form( $instance ){
        // Set up some default widget settings
        $defaults = array(
            'title' => 'Subscribe',
            'desc'  => '',
        );

        $instance = wp_parse_args( (array) $instance, $defaults ); ?>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_attr_e('Title:', 'massive-dynamic') ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" value="<?php echo esc_attr($instance['title']);?>">
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('desc')); ?>"><?php esc_attr_e('Description:', 'massive-dynamic') ?></label>
            <textarea class="widefat" id="<?php echo esc_attr($this->get_field_id('desc')); ?>" name="<?php echo esc_attr($this->get_field_name('desc')); ?>" rows="5"><?php echo esc_attr($instance['desc']);?></textarea>
        </p>

    <?php
    }
}

// register widget
add_action( 'widgets_init', create_function( '', 'register_widget( "Pixflow_Subscribe_Widget" );' ) );
