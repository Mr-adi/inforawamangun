<?php

require_once(PIXFLOW_THEME_LIB .'/string.php');

class PixflowFramework {
    /**
     * Includes (require_once) php file(s) inside selected folder
     */
    public static function Pixflow_Require_Files($path, $fileName)
    {

        if(is_string($fileName))
        {
            require_once(pixflow_path_combine($path, $fileName) . '.php');
        }
        elseif(is_array($fileName))
        {
            foreach($fileName as $name)
            {
                require_once(pixflow_path_combine($path, $name) . '.php');
            }
        }
        else
        {
            //Throw error
            throw new Exception('Unknown parameter type');
        }
    }
}

//Include framework files

PixflowFramework::Pixflow_Require_Files( PIXFLOW_THEME_LIB,
    array('constants',
          'utilities',
          'admin/admin',
          'google-fonts',
          'scripts',
          'support',
          'retina-upload',
          'sidebars',
          'plugins-handler',
          'nav-walker',
          'menus',
          'shortcodes/shortcodes',
          'customizer/customizer',
          'metaboxes',
          'layout-functions',
          'post-like',
          'unique-setting',
          'woocommerce/woocommerce',
          'instagram/instagram',
    ));

//Add post types
PixflowFramework::Pixflow_Require_Files( PIXFLOW_THEME_LIB . '/post-types',
    array( 'blog','page','portfolio','featured-gallery'));

//Add widgets
PixflowFramework::Pixflow_Require_Files( PIXFLOW_THEME_LIB . '/widgets',
    array(
    'widget-recent-portfolio',
    'widget-recent-posts',
    'widget-progress',
    'widget-contact-info',
    'widget-instagram',
    'widget-text',
    'widget-social',
    //'widget-twitter',
    'widget-subscribe'
    )
);
