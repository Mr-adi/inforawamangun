<?php

abstract class PixflowPostType
{
    protected $postType;

    function __construct($postType)
    {
        $this->postType = $postType;

        add_action( 'init', array(&$this, 'Pixflow_CreatePostType') );

        add_action('add_meta_boxes', array(&$this, 'Pixflow_AddMetaBoxes'));
        add_action('admin_print_scripts-post-new.php', array( &$this, 'Pixflow_InitScripts'));
        add_action('admin_print_scripts-post.php', array( &$this, 'Pixflow_InitScripts'));

        /* Save post meta on the 'save_post' hook. */
        add_action( 'save_post', array( &$this, 'Pixflow_SaveData'), 10, 2 );
    }

    function Pixflow_SaveData($post_id = false, $post = false)
    {
        /* Verify the nonce before proceeding. */
        $nonce = PIXFLOW_THEME_NAME_SEO . '_post_nonce';

        if ( !isset( $_POST[$nonce] ) || !wp_verify_nonce( $_POST[$nonce], 'theme-post-meta-form' ) )
            return $post_id;

        // check autosave
        if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
            return $post_id;


        if( $post->post_type != $this->postType || !current_user_can('edit_post', $post_id))
            return $post_id;

        //CRUD Operation
        foreach($this->Pixflow_GetOptionsForStore() as $key => $settings )
        {
            //Let the derived class intercept the process
            if($this->Pixflow_OnProcessFieldForStore($post_id, $key, $settings))
                continue;

            $postedVal = isset( $_POST[$key] ) ? $_POST[$key] : '';
            $val       = get_post_meta( $post_id, $key, true );

            //Insert
            if ( $postedVal != '' && $val == '' )
            {
                add_post_meta( $post_id, $key, $postedVal, true );
            }
            //Delete
            elseif ( $val != '' && $postedVal == '' )
            {
                delete_post_meta( $post_id, $key );

                //Delete the attachment as well
                if($settings['type'] == 'upload')
                {
                    pixflow_delete_attachment($val);
                }
            }
            //Update
            elseif ( $postedVal != $val )
            {
                update_post_meta( $post_id, $key, $postedVal );
            }

        }

        return $post_id;
    }

    function Pixflow_OnProcessFieldForStore($post_id, $key, $settings)
    {
        return false;
    }

    function Pixflow_CreatePostType()
    {

    }

    protected function Pixflow_GetOptionsForStore()
    {
        $options = $this->Pixflow_GetOptions();
        $values  = array();

        foreach($options as $box)
        {
            foreach($box['options'] as $section)
            {
                foreach($section['fields'] as $key => $field)
                {
                    $ignore = pixflow_array_value('dontsave', pixflow_array_value('meta', $field, array()), false);

                    if($ignore)
                        continue;

                    $values[$key] = $field;
                }
            }
        }

        return $values;
    }

    protected function Pixflow_GetOptions()
    {
        return array();
    }

    function Pixflow_AddMetaBoxes()
    {
        $options = $this->Pixflow_GetOptions();



        foreach($options as $box)
        {

            add_meta_box(
                $box['id'], // $id
                $box['title'], // $title
                array(&$this, 'Pixflow_ShowMetaBox'), // $callback
                $this->postType, // $page
                $box['context'], // $context
                $box['priority'],// $priority
                $box['options']
            );

        }

    }

    function Pixflow_ShowMetaBox($post, $metabox)
    {
        $args = $metabox['args'];
    }

    function Pixflow_InitScripts()
    {
        global $post_type;

        if( $post_type != $this->postType )
            return;

        $this->Pixflow_RegisterScripts();
        $this->Pixflow_EnqueueScripts();
    }

    protected function Pixflow_RegisterScripts()
    {

        wp_register_script('niceScroll',pixflow_path_combine(PIXFLOW_THEME_LIB_URI, 'assets/script/jquery.nicescroll.min.js'),false,PIXFLOW_THEME_VERSION,true);
        wp_register_script('adminJs',pixflow_path_combine(PIXFLOW_THEME_LIB_URI,'/assets/script/admin.js'),false,PIXFLOW_THEME_VERSION,true);

    }

    protected function Pixflow_EnqueueScripts()
    {

        wp_enqueue_script( 'niceScroll' );

        if (! wp_script_is( 'adminJs', 'enqueued' )) {
            wp_enqueue_script( 'adminJs');
            wp_localize_script('adminJs', 'admin_var', array(
                    'addTab' => esc_attr__('ADD TAB','massive-dynamic'),
                    'chooseImage' => esc_attr__('Choose Image','massive-dynamic'),
                    'classicMode' => esc_attr__('Classic Mode','massive-dynamic'),
                    'backendEditor' => esc_attr__('Backend Editor','massive-dynamic'),
                    'yourStyle' => esc_attr__('Your Style','massive-dynamic'),
                    'supportForum' => esc_attr__('Support Forum','massive-dynamic'),
                    'massiveBuilder' => esc_attr__('Massive Builder','massive-dynamic'),
                    'portfolioPostLayout' => esc_attr__('PORTFOLIO POST LAYOUT','massive-dynamic'),
                    'welcomeMsg' => esc_attr__('Welcome to layout builder, you have no content yet!Start creating your layout for this post :)','massive-dynamic'),
                    'split' => esc_attr__('Split','massive-dynamic'),
                    'fullwidth' => esc_attr__('Fullwidth','massive-dynamic'),
                    'center' => esc_attr__('Center','massive-dynamic'),
                    'fancy' => esc_attr__('Fancy','massive-dynamic'),
                    'changeLayout' => esc_attr__('Change Layout','massive-dynamic'),
                    'changeLayoutMsg' => esc_attr__("If you change this layout, you will lose this portfolio's contents. Continue?",'massive-dynamic'),
                    'createWeb' => esc_attr__('Create Website With','massive-dynamic'),
                    'massiveBuilderMsg' => esc_attr__('A live website builder with simple drag & drop ability, It gives you the power to make changes and see the result instantly & create a whole website in minutes!','massive-dynamic'),
                    'videoMsg' => esc_attr__('To view this video please enable JavaScript, and consider upgrading to a web browser that supports HTML5 video','massive-dynamic'),
                    'updateErr' => esc_attr__("There was an issue with updating the live preview. Make sure that you click Save to ensure your changes aren't lost.",'massive-dynamic'),
                    'selectImage' => esc_attr__('Select Images','massive-dynamic'),
                    'blankPage' => esc_attr__('Blank Page!','massive-dynamic'),
                    'dragShortcode' => esc_attr__('Drag your shortcodes here and start<br>building your website','massive-dynamic'),
                    'chooseShortcode' => esc_attr__('Choose a shortcode and start<br>building your website','massive-dynamic'),
                    'editSelection' => esc_attr__('Edit Selection','massive-dynamic'),
                )
            );
        }
    }
}