<?php

// Widget class
class Pixflow_Progress_Widget extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'Md_Progress', // Base ID
            'Md - Progress Widget', // Name
            array( 'description' => esc_attr__( 'Displays 4 progress bars with a title', 'massive-dynamic' ) ) // Args
        );
    }

    function widget( $args, $instance ) {
        global $md_allowed_HTML_tags;

        $id_Progressbar = pixflow_sc_id('progress_bar');

        extract( $args );

        // Our variables from the widget settings
        $title = apply_filters('title', $instance['title'] );

        // Before widget (defined by theme functions file)
        echo wp_kses($before_widget,$md_allowed_HTML_tags);


        // Display the widget title if one was input
        if ( $title )
            echo wp_kses($before_title,$md_allowed_HTML_tags) . wp_kses($title,$md_allowed_HTML_tags) . wp_kses($after_title,$md_allowed_HTML_tags);

        ?>
        <div id="<?php echo esc_attr($id_Progressbar) ?>" class="progress-list" data-widget-type="progress">
            <?php
            for($i=1; $i<=6; $i++)
            {
                $id = "title$i";
                $progId = "progress$i";

                if(!strlen($instance[$id]))
                    continue;
                ?>
                <div class="progressbar">
                    <div class="bar-percentage" data-percentage="<?php echo esc_attr($instance[$progId]); ?>">0%</div>

                    <div class="bar-container">
                        <div class="bar"></div>
                    </div>

                    <h4 class="title"><?php echo esc_attr($instance[$id]); ?></h4>
                </div>
                <?php
            }
            ?>
        </div>

        <?php
        // After widget (defined by theme functions file)
        echo wp_kses($after_widget,$md_allowed_HTML_tags);
    }


    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;

        // Strip tags to remove HTML (important for text inputs)
        $instance['title'] = strip_tags( $new_instance['title'] );

        for($i=1; $i<=6; $i++)
        {
            $id = "title$i";
            $strId = "progress$i";

            $instance[$id] = trim(strip_tags( $new_instance[$id] ));
            $instance[$strId] = $new_instance[$strId];
        }

        return $instance;
    }

    function form( $instance ) {

        // Set up some default widget settings
        $defaults = array(
            'title' => esc_attr__('OUR SKILLS','massive-dynamic'),
        );

        for($i=1; $i<=6; $i++)
        {
            $defaults["title$i"] = '';
            $defaults["progress$i"] = '';
        }

        $instance = wp_parse_args( (array) $instance, $defaults ); ?>

        <!-- Widget Title: Text Input -->
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_attr_e('Title:', 'massive-dynamic') ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" value="<?php echo esc_attr($instance['title']); ?>" />
        </p>

        <?php for($i=1; $i<=6; $i++){ ?>
            <!-- Title: Text Input -->
            <p>
                <?php $id="title$i"; ?>
                <label for="<?php echo esc_attr($this->get_field_id( $id )); ?>"><?php printf(esc_attr__('Progress %d Title:', 'massive-dynamic'), $i); ?></label>
                <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id( $id )); ?>" name="<?php echo esc_attr($this->get_field_name( $id )); ?>" value="<?php echo esc_attr($instance[$id]); ?>" />
            </p>

            <!-- Progress: Text Input -->
            <p>
                <?php $id="progress$i"; ?>
                <label for="<?php echo esc_attr($this->get_field_id( $id )); ?>"><?php printf(esc_attr__('Progress %d:', 'massive-dynamic'), $i); ?></label>
                <select id="<?php echo esc_attr($this->get_field_id( $id )); ?>" name="<?php echo esc_attr($this->get_field_name( $id )); ?>" class="widefat">
                    <?php for($j=0; $j<=100; $j+=5){ ?>
                        <option <?php selected($instance[$id], $j);?> value="<?php echo esc_attr($j) ?>"><?php echo esc_attr($j) ?>%</option>
                    <?php } ?>
                </select>
            </p>

        <?php }//end for(...) ?>

        <?php
    }
}

// register widget
add_action( 'widgets_init', create_function( '', 'register_widget( "Pixflow_Progress_Widget" );' ) );