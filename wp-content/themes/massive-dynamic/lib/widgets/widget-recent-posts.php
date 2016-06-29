<?php

// Widget class
class Pixflow_Recent_Posts_Widget extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'Md_Recent_Posts', // Base ID
            'Md - Recent Posts Widget', // Name
            array( 'description' => esc_attr__( 'Displays your recent posts', 'massive-dynamic' ) ) // Args
        );
    }

    function widget( $args, $instance ) {
        extract( $args );

        if(empty($instance)){
            $instance['title']='';
            $instance['count']='';
        }

        // Our variables from the widget settings
        $title      = apply_filters('widget_title', $instance['title'] );
        $postcount  = $instance['count'];

        ?>
        <div class="widget widget-md-recent-post">
            <h4 class="widget-title"><?php echo esc_attr($title); ?></h4>

        <?php

        //Exclude quote post formats
        $query = new WP_Query(array(
            'posts_per_page' => $postcount,
            'tax_query' => array(
                array(
                    'taxonomy' => 'post_format',
                    'field'    => 'slug',
                    'terms'    => array( 'post-format-quote' ),
                    'operator' => 'NOT IN',
                )
            )
        ));


        if( $query->have_posts()) {
            ?>
            <div class="item-list">
                <?php while ($query->have_posts()) { $query->the_post();
                    global $post;

                    if(strlen($post->post_title)>30)
                        $subStr = '...';
                    else
                        $subStr='';
                    ?>
                    <div class="item clearfix">
                        <a href="<?php the_permalink(); ?>" class="item-image">
                            <?php if ( function_exists('has_post_thumbnail') && has_post_thumbnail() ) {
                                the_post_thumbnail('pixflow_recent-post-widget');
                                ?><div class="overlay" ></div ><?php
                            }?>
                        </a>
                        <div class="item-info">
                            <a href="<?php the_permalink(); ?>" class="item-title"><?php echo substr($post->post_title,0,30).$subStr; ?>
                            <br/><?php the_time(get_option('date_format')); ?></a>
                        </div>
                    </div>
                <?php }  ?>
            </div>
        </div>
        <?php
        }//If have posts

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
            'title' => 'Recent Posts',
            'count' => '3'
        );

        $instance = wp_parse_args( (array) $instance, $defaults ); ?>

        <!-- Widget Title: Text Input -->
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_attr_e('Title:', 'massive-dynamic') ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" value="<?php echo esc_attr($instance['title']); ?>" />
        </p>

        <!-- Post Count: Text Input -->
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'count' )); ?>"><?php esc_attr_e('Number Of Posts:', 'massive-dynamic') ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id( 'count' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'count' )); ?>" value="<?php echo esc_attr($instance['count']); ?>" />
        </p>

    <?php
    }
}

// register widget
add_action( 'widgets_init', create_function( '', 'register_widget( "Pixflow_Recent_Posts_Widget" );' ) );