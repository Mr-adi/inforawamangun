<?php

// Widget class
class Pixflow_Social_Widget extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'Md_Social', // Base ID
            'Md - Social Widget', // Name
            array( 'description' => esc_attr__( 'Displays your social links', 'massive-dynamic' ) ) // Args
        );
    }

    function widget( $args, $instance ) {
        extract( $args );
       

        if(empty($instance)){
            $instance['title']='';
        }

        // Our variables from the widget settings
        $title      = apply_filters('widget_title', $instance['title'] );

        global $md_allowed_HTML_tags;

        ?>
        <div class="widget widget-md-social">
            <h4 class="widget-title"><?php echo esc_attr($title); echo wp_kses($args['after_title'],$md_allowed_HTML_tags); ?></h4>
            <div class="item-list">
        <?php
        $socials = pixflow_get_active_socials();
        if ($socials) {
            foreach ($socials as $social) {
                $title = $social['title'];
                $icon = $social['icon'];
                $link = $social['link'];
            ?>
            <div data-social="<?php echo esc_attr($title) ?>" class="item clearfix">
            <span>
                <a href="<?php echo esc_url($link) ?>">
                    <i class="icon <?php echo esc_attr($icon); ?>"></i>
                    <i class="text"> <?php echo esc_attr($title); ?> </i>
                </a>
            </span>
            </div>
            <?php } }  ?>
            </div>
        </div>
   <?php }

    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        // Strip tags to remove HTML (important for text inputs)
        $instance['title'] = strip_tags( $new_instance['title'] );
        return $instance;
    }

    function form( $instance ) {
        // Set up some default widget settings
        $defaults = array(
            'title' => 'Socials'
        );
        $instance = wp_parse_args( (array) $instance, $defaults ); ?>
        <!-- Widget Title: Text Input -->
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_attr_e('Title:', 'massive-dynamic') ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" value="<?php echo esc_attr($instance['title']); ?>" />
        </p>
    <?php
    }
}

// register widget
add_action( 'widgets_init', create_function( '', 'register_widget( "Pixflow_Social_Widget" );' ) );