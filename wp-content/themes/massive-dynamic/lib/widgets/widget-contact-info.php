<?php
class Pixflow_Contact_Info_Widget extends WP_Widget
{
    public function __construct()
    {
        parent::__construct(
            'Md_Contact_Info_Widgett',
            'Md - Contact Info Widget',
            array(
                'description' => 'Contact Info Widget'
            )
        );
    }

    public function widget( $args, $instance )
    {
        global $md_allowed_HTML_tags;

        if(empty($instance)){
            $instance['title']='';
            $instance['address1']='';
            $instance['address2']='';
            $instance['phone1']='';
            $instance['phone2']='';
            $instance['fax']='';
            $instance['email']='';
            $instance['web']='';
        }


        $frontend='<div class="widget widget-contact-info">';
        $frontend.='<h4 class="widget-title">'.$instance['title'].$args['after_title'].'</h4>';
            $frontend.='<div class="widget-contact-info-content">';
            if($instance['address1']!='')
                $frontend.='<p>'.$instance['address1'].'</p>';
            if($instance['address2']!='')
                $frontend.='<p>'.$instance['address2'].'</p>';
            if($instance['phone1']!='')
                $frontend.='<p><span>'.esc_attr__('Phone:','massive-dynamic').' </span><span>'.$instance['phone1'].'</span></p>';
            if($instance['phone2']!='')
                $frontend.='<p><span>'.esc_attr__('Phone:','massive-dynamic').' </span><span>'.$instance['phone2'].'</span></p>';
            if($instance['fax']!='')
                $frontend.='<p><span>'.esc_attr__('Fax:','massive-dynamic').' </span><span>'.$instance['fax'].'</span></p>';
            if($instance['email']!='')
                $frontend.='<p><span>'.esc_attr__('E-Mail:','massive-dynamic').' </span><span>'.$instance['email'].'</span></p>';
            if($instance['web']!='')
                $frontend.='<p><span>'.esc_attr__('Web Site:','massive-dynamic').' </span><span>'.$instance['web'].'</span></p>';
        $frontend.='</div></div>';


        echo wp_kses($frontend,$md_allowed_HTML_tags);

    }

    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;

        // Strip tags to remove HTML (important for text inputs)
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['address1'] = strip_tags($new_instance['address1']);
        $instance['address2'] = strip_tags($new_instance['address2']);
        $instance['phone1'] = strip_tags( $new_instance['phone1'] );
        $instance['phone2'] = strip_tags( $new_instance['phone2'] );
        $instance['fax'] = strip_tags( $new_instance['fax'] );
        $instance['email'] = strip_tags($new_instance['email']);
        $instance['web'] = strip_tags($new_instance['web']);
        return $instance;
    }

    public function form( $instance ){
        // Set up some default widget settings
        $defaults = array(
            'title' => 'CONTACT US',
            'address1' => '',
            'address2'=> '' ,
            'phone1' => '' ,
            'phone2' => '' ,
            'fax' => '' ,
            'email' => '' ,
            'web' => '' ,
        );

        $instance = wp_parse_args( (array) $instance, $defaults ); ?>


        <p>
            <label for="<?php echo  esc_attr($this->get_field_id('title')); ?>"><?php esc_attr_e('Title:', 'massive-dynamic') ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" value="<?php echo esc_attr($instance['title']);?>">
        </p>


        <p>
            <label for="<?php echo esc_attr($this->get_field_id('address1')); ?>"><?php esc_attr_e('Address :', 'massive-dynamic') ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('address1')); ?>" name="<?php echo esc_attr($this->get_field_name('address1')); ?>" value="<?php echo esc_attr($instance['address1']);?>">
        </p>


        <p>
            <label for="<?php echo esc_attr($this->get_field_id('address2')); ?>"><?php esc_attr_e('Address:', 'massive-dynamic') ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('address2')); ?>" name="<?php echo esc_attr($this->get_field_name('address2')); ?>" value="<?php echo esc_attr($instance['address2']);?>">
        </p>


        <p>
            <label for="<?php echo esc_attr($this->get_field_id('phone1')); ?>"><?php esc_attr_e('Phone:', 'massive-dynamic') ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('phone1')); ?>" name="<?php echo esc_attr($this->get_field_name( 'phone1' )); ?>" value="<?php echo esc_attr($instance['phone1']);?>">
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('phone2')); ?>"><?php esc_attr_e('Phone:', 'massive-dynamic') ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id( 'phone2' )); ?>" name="<?php echo esc_attr($this->get_field_name('phone2')); ?>" value="<?php echo esc_attr($instance['phone2']);?>">
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('fax')); ?>"><?php esc_attr_e('Fax:', 'massive-dynamic') ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('fax')); ?>" name="<?php echo esc_attr($this->get_field_name('fax')); ?>" value="<?php echo esc_attr($instance['fax']);?>">
        </p>

        <p>
            <label for="<?php echo esc_url($this->get_field_id( 'email' )); ?>"><?php esc_attr_e('Email:', 'massive-dynamic') ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('email')); ?>" name="<?php echo esc_attr($this->get_field_name('email')); ?>" value="<?php echo esc_attr($instance['email']);?>">
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('web')); ?>"><?php esc_attr_e('Web Site:', 'massive-dynamic') ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('web')); ?>" name="<?php echo esc_attr($this->get_field_name('web')); ?>" value="<?php echo esc_attr($instance['web']);?>">
        </p>

    <?php
    }
}

// register widget
add_action( 'widgets_init', create_function( '', 'register_widget( "Pixflow_Contact_Info_Widget" );' ) );
