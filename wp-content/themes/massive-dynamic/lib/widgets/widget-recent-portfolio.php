<?php

// Widget class
class Pixflow_Recent_Portfolio_Widget extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'Md_Recent_Portfolio', // Base ID
            'Md - Recent Portfolio Widget', // Name
            array( 'description' => esc_attr__( 'Displays your recent portfolio items', 'massive-dynamic' ) ) // Args
        );
    }

    function widget( $args, $instance ) {
        extract( $args );
        if(empty($instance)){
            $instance['title']='';
            $instance['count']= '6';
        }

        // Our variables from the widget settings
        $title     = apply_filters('widget_title', $instance['title'] );
        $postcount = $instance['count'];

        $query = new WP_Query();
        $query->query('post_type=portfolio&posts_per_page=' . esc_attr($postcount));
        ?>

        <div class="widget widget-md-recent-portfolio">
            <h4 class="widget-title"><?php echo esc_attr($title); ?></h4>
        <?php

        if( $query->have_posts()) {
            ?>
            <div class="item-list">
                <?php while ($query->have_posts()) { $query->the_post();  ?>
                    <div class="item">
                        <a href="<?php the_permalink(); ?>" class="item-image">
                            <?php if ( function_exists('has_post_thumbnail') && has_post_thumbnail() ) {
                                ?>
                                <div style = "background-image:url(<?php the_post_thumbnail_url( 'pixflow_recent-portfolio-widget' ); ?>);"></div>

                           <?php }else{ ?>
                                <span><?php the_title(); ?></span>
                            <?php }

                            ?>
                            <div class="overlay"></div>
                        </a>

                    </div>
                <?php }  ?>
                <div class="clearfix"></div>
            </div>

        <?php
        }//If have posts
        ?>
        </div>
        <?php
        wp_reset_postdata();

    }


    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;

        // Strip tags to remove HTML (important for text inputs)
        $instance['title'] = strip_tags( $new_instance['title'] );

        $count = intval($new_instance['count']);
        $count = max(min($count, 10), 1);
        $instance['count'] = $count;

        return $instance;
    }

    function form( $instance ) {

        // Set up some default widget settings
        $defaults = array(
            'title' => 'Portfolio',
            'count' => '6'
        );

        $instance = wp_parse_args( (array) $instance, $defaults ); ?>

        <!-- Widget Title: Text Input -->
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_attr_e('Title:', 'massive-dynamic') ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" value="<?php echo esc_attr($instance['title']); ?>" />
        </p>

        <!-- Post Count: Text Input -->
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'count' )); ?>"><?php esc_attr_e('Number Of Recent Works:', 'massive-dynamic') ?></label>
            <select class="widefat" id="<?php echo esc_attr($this->get_field_id( 'count' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'count' )); ?>">
                <option <?php if($instance['count']==3) echo 'selected="selected"' ?> value="3">3</option>
                <option <?php if($instance['count']==6) echo 'selected="selected"' ?> value="6">6</option>
                <option <?php if($instance['count']==9) echo 'selected="selected"' ?> value="9">9</option>
            </select>
        </p>

    <?php
    }
}

// register widget
add_action( 'widgets_init', create_function( '', 'register_widget( "Pixflow_Recent_Portfolio_Widget" );' ) );