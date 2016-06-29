<?php
class Pixflow_Text_Widget extends WP_Widget
{
    public function __construct()
    {
        parent::__construct(
            'Md_Text_Widgett',
            'Md - Text Widget',
            array(
                'description' => 'Text Widget'
            )
        );
    }

    public function widget( $args, $instance )
    {
        global $md_allowed_HTML_tags;

        if(empty($instance)){
            $instance['title']='';
            $instance['image']='';
            $instance['description']='';
            $instance['button-text']='';
            $instance['button-url']='';
        }
        ob_start();
        ?>
        <div class="widget widget-md-text">
            <h4 class="widget-title clearfix">
                <?php if($instance['image']=='' && $instance['title']!='') {
                    echo wp_kses($instance['title'].$args['after_title'],$md_allowed_HTML_tags);
                }else if($instance['image']!='') { ?>
                    <img class="text-widget-image" src="<?php echo esc_url($instance['image']); ?>" alt="<?php echo esc_attr($instance['title']); ?>" />
                    <?php echo wp_kses($args['after_title'],$md_allowed_HTML_tags);
                }
                ?>

            <?php if($instance['description']!=''){ ?>
            <div class="text-widget-desc"><p><?php echo wpautop(esc_attr($instance['description'],true)); ?></p></div>
            <?php } ?>
            <?php if($instance['button-text']!='' || $instance['button-url']!=''){ ?>
            <div id="text-widget-btn"><?php echo pixflow_buttonMaker('fade-square',$instance['button-text'],'',$instance['button-url'],'','small','','',''); ?></div>
            <?php } ?>
        </div>
        <?php
        ob_end_flush();
    }

    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;

        // Strip tags to remove HTML (important for text inputs)
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['image'] = strip_tags($new_instance['image']);
        $instance['description'] = strip_tags($new_instance['description']);
        $instance['button-text'] = strip_tags( $new_instance['button-text'] );
        $instance['button-url'] = strip_tags( $new_instance['button-url'] );
        return $instance;
    }

    public function form( $instance ){
        // Set up some default widget settings
        $defaults = array(
            'title' => '',
            'image' => '',
            'description'=> '' ,
            'button-text' => '' ,
            'button-url' => '' ,
        );

        $instance = wp_parse_args( (array) $instance, $defaults ); ?>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_attr_e('Title:', 'massive-dynamic') ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" value="<?php echo esc_attr($instance['title']);?>">
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('description')); ?>"><?php esc_attr_e('Text:', 'massive-dynamic') ?></label>
            <textarea class="widefat" id="<?php echo esc_attr($this->get_field_id('description')); ?>" name="<?php echo esc_attr($this->get_field_name('description')); ?>" rows="5" ><?php echo esc_attr($instance['description']);?></textarea>
        </p>


        <p>
            <label for="<?php echo esc_attr($this->get_field_id('button-text')); ?>"><?php esc_attr_e('Button Text:', 'massive-dynamic') ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('button-text')); ?>" name="<?php echo esc_attr($this->get_field_name( 'button-text' )); ?>" value="<?php echo esc_attr($instance['button-text']);?>">
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('button-url')); ?>"><?php esc_attr_e('Button Url:', 'massive-dynamic') ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id( 'button-url' )); ?>" name="<?php echo esc_attr($this->get_field_name('button-url')); ?>" value="<?php echo esc_attr($instance['button-url']);?>">
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('image')); ?>"><?php esc_attr_e('Image:', 'massive-dynamic') ?></label>
            <?php
            if ( $instance['image'] != '' ) :
                echo '<br/><img class="custom_media_image" src="' . esc_url($instance['image']) . '" style="max-width:100px;display:inline-block" /><br />';
            endif;
            ?>

            <input type="text" class="widefat custom_media_url" name="<?php echo esc_attr($this->get_field_name('image')); ?>" id="<?php echo esc_attr($this->get_field_id('image')); ?>" value="<?php echo esc_attr($instance['image']); ?>" style="margin-top:5px;">

            <input type="button" class="button button-primary custom_media_button" id="custom_media_button" name="<?php echo esc_attr($this->get_field_name('image')); ?>" value="Upload Image" style="margin-top:5px;" />
        </p>

    <?php
        wp_enqueue_media();
    }

}

// register widget
add_action( 'widgets_init', create_function( '', 'register_widget( "Pixflow_Text_Widget" );' ) );