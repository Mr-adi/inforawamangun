<?php
define('PIXFLOW_THEME_SLUG', 'massive-dynamic');
define('MASSIVEDYNAMIC_THEME_SLUG', 'massive-dynamic');

/**************************************************
	FOLDERS
**************************************************/

define('PIXFLOW_THEME_DIR',         get_template_directory());
define('PIXFLOW_THEME_LIB',			PIXFLOW_THEME_DIR . '/lib');
define('PIXFLOW_THEME_ADMIN',		PIXFLOW_THEME_LIB . '/admin');
define('PIXFLOW_THEME_INCLUDES',    PIXFLOW_THEME_LIB . '/includes');
define('PIXFLOW_THEME_CUSTOMIZER',	PIXFLOW_THEME_LIB . '/customizer');
define('PIXFLOW_THEME_LANGUAGES',	PIXFLOW_THEME_LIB . '/languages');
define('PIXFLOW_THEME_CACHE',	    PIXFLOW_THEME_DIR . '/cache');
define('PIXFLOW_THEME_ASSETS',   	PIXFLOW_THEME_DIR . '/assets');
define('PIXFLOW_THEME_PLUGINS',		PIXFLOW_THEME_DIR . '/plugins');
define('PIXFLOW_THEME_JS',			PIXFLOW_THEME_ASSETS . '/js');
define('PIXFLOW_THEME_CSS',			PIXFLOW_THEME_ASSETS . '/css');
define('PIXFLOW_THEME_IMAGES',		PIXFLOW_THEME_ASSETS . '/img');


/**************************************************
	FOLDER URI
**************************************************/

define('PIXFLOW_THEME_URI',		    	get_template_directory_uri());
define('PIXFLOW_THEME_LIB_URI',		    PIXFLOW_THEME_URI . '/lib');
define('PIXFLOW_THEME_ADMIN_URI',		PIXFLOW_THEME_LIB_URI . '/admin');
define('PIXFLOW_THEME_CUSTOMIZER_URI',	PIXFLOW_THEME_LIB_URI . '/customizer');
define('PIXFLOW_THEME_WOOCOMMERCE_URI',	PIXFLOW_THEME_LIB_URI . '/woocommerce');
define('PIXFLOW_THEME_LANGUAGES_URI',	PIXFLOW_THEME_LIB_URI . '/languages');
define('PIXFLOW_THEME_PLUGINS_URI',	    PIXFLOW_THEME_URI . '/plugins');
define('PIXFLOW_THEME_CACHE_URI',	    PIXFLOW_THEME_URI     . '/cache');
define('PIXFLOW_THEME_ASSETS_URI',	    PIXFLOW_THEME_URI     . '/assets');
define('PIXFLOW_THEME_JS_URI',			PIXFLOW_THEME_ASSETS_URI . '/js');
define('PIXFLOW_THEME_CSS_URI',			PIXFLOW_THEME_ASSETS_URI . '/css');
define('PIXFLOW_THEME_IMAGES_URI',		PIXFLOW_THEME_ASSETS_URI . '/img');
define('PIXFLOW_PLACEHOLDER_BLANK',		PIXFLOW_THEME_IMAGES_URI . '/placeholders/blank.png');
define('PIXFLOW_PLACEHOLDER1',	PIXFLOW_THEME_IMAGES_URI . '/placeholders/placeholder1.jpg');
define('PIXFLOW_PLACEHOLDER_BG',		PIXFLOW_THEME_IMAGES_URI . '/placeholders/blank.png');

/**************************************************
 * Content view
 *************************************************/
function pixflow_custom_excerpt_length($length ) {
    return 90;
}
add_filter( 'excerpt_length', 'pixflow_custom_excerpt_length', 999 );

function pixflow_new_excerpt_more($more ) {
    return '<a class="more-link" href="'. get_permalink( get_the_ID() ) . '">SEE DETAILS <span class="more-link-image"></span><span class="more-link-hover-image"></span></a>';

}
add_filter( 'excerpt_more', 'pixflow_new_excerpt_more');

/**************************************************
	Text Domain
**************************************************/

load_theme_textdomain( 'massive-dynamic', PIXFLOW_THEME_DIR . '/languages' );

/**************************************************
	Content Width
**************************************************/

if ( !isset( $content_width ) ) $content_width = 1170;

/**************************************************
	LIBRARIES
**************************************************/
require_once(PIXFLOW_THEME_LIB . '/framework.php');
