<?php
require_once(PIXFLOW_THEME_LIB . '/includes/simple_html_dom.php');
function pixflow_get_pagination($query = null, $range = 3, $default_pagination = true) {
    global $paged, $wp_query, $md_allowed_HTML_tags;

    $q = $query == null ? $wp_query : $query;
    $output = '';

    // How much pages do we have?
    if ( !isset($max_page) ) {
        $max_page = $q->max_num_pages;

        if (array_key_exists('paged', $q->query)) {
            $post_count = esc_attr($q->query['paged']);
        }
        else{
            $post_count = 1;
        }
    }

    // We need the pagination only if there is more than 1 page
    if ( $max_page < 2 )
        return $output;

    $output .= '<div class="post-pagination">';

    if ( !$paged ) $paged = 1;

    // If current page is our home page we will change the pagination structure to prevent 404 error , if not we use the default structure
    if(!$default_pagination){
        $ppage=$paged+1;
        $npage=$paged-1;
        $plink=get_home_url()."/?paged=".$ppage;
        $nlink=get_home_url()."/?paged=".$npage;

        // If we are on page 2 , next page would be page 1 and its better that we just go to home page instead of passing pagination argument
        if($paged == 2){
            $nlink=$nlink=get_home_url();
        }
    }
    else{
        $plink=get_pagenum_link($paged+1);
        $nlink=get_pagenum_link($paged-1);
    }

    // Next page
    if($paged < $max_page)
        $output .= '<a class="prev-page-link" href="' . $plink  . '"><span class="prev-page"></span><span class="text">'. esc_attr__('PREVIOUS POSTS', 'massive-dynamic') .'</span></a>';
    else if( $paged == $max_page )
        $output .= '<a class="no-prev-page" href="#"><span class="text">'. esc_attr__('NO OLD POSTS', 'massive-dynamic') .'</span><span class="prev-page"></span></a>';


    $output .= '<span class="page-num">'. "Page $post_count of $max_page" .'</span>';

    // To the previous page
    if($paged > 1)
        $output .= '<a class="next-page-link" href="' . $nlink . '"><span class="text">'. esc_attr__('NEXT POSTS', 'massive-dynamic') .'</span><span class="next-page"></span></a>';
    else if( $paged == 1 )
        $output .= '<a class="no-next-page" href="#"><span class="text">'. esc_attr__('NO NEW POSTS', 'massive-dynamic') .'</span><span class="next-page"></span></a>';

    $output .= '<div class="clearfix"></div><a class="pagination-border"></a><a class="post-pagination-hover"></a></div><!-- post-pagination -->';

    echo wp_kses($output,$md_allowed_HTML_tags);
}

// retrieves the attachment ID from the file URL
function pixflow_get_image_id($image_url) {
    global $wpdb;

    $attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM " .$wpdb->prefix. "posts WHERE guid='%s';", $image_url));

    if(count($attachment))
        return $attachment[0];
    else
        return false;
}

function pixflow_get_related_posts_by_taxonomy($postId, $taxonomy, $maxPosts = 9)
{
    $terms   = wp_get_object_terms($postId, $taxonomy);

    if (!count($terms))
        return new WP_Query();

    $termsSlug = array();

    foreach($terms as $term)
        $termsSlug[] = $term->slug;

    $args=array(
        'post__not_in' => array((int)$postId),
        'post_type' => get_post_type($postId),
        'showposts'=>(int)$maxPosts,
        'tax_query' => array(
            array(
                'taxonomy' => $taxonomy,
                'field' => 'slug',
                'terms' => $termsSlug
            )
        )
    );

    return new WP_Query($args);
}


//Return theme option
function pixflow_opt($option){
    $opt = get_option(PIXFLOW_OPTIONS_KEY);

    return stripslashes($opt[$option]);
}


//Echo theme option
function pixflow_eopt($option){
    echo pixflow_opt($option);
}

function pixflow_print_terms($terms, $separatorString)
{
    $termIndex = 1;
    if($terms)
        foreach ($terms as $term)
        {
            echo esc_attr($term->name);

            if(count($terms) > $termIndex)
                echo esc_attr($separatorString);

            $termIndex++;
        }
}



/*
 * Gets array value with specified key, if the key doesn't exist
 * default value is returned
 */
function pixflow_array_value($key, $arr, $default='')
{
    return array_key_exists($key, $arr) ? $arr[$key] : $default;
}


/*
 * Deletes attachment by given url
 */
function pixflow_delete_attachment($url ) {
    global $wpdb;

    // We need to get the image's meta ID.
    $query = "SELECT ID FROM wp_posts where guid = '" . esc_url($url) . "' AND post_type = 'attachment'";
    $results = $wpdb->get_results($wpdb->prepare($query));

    // And delete it
    foreach ( $results as $row ) {
        wp_delete_attachment( $row->ID );
    }
}

function pixflow_get_post_terms_names($taxonomy)
{
    $terms = get_the_terms( get_the_ID(), $taxonomy );

    if(!is_array($terms))
        return $terms;

    $termNames = array();

    foreach ($terms as $term)
        $termNames[] = $term->name;

    return $termNames;
}


/*
 * Concatenate post category names
 */
function pixflow_implode_post_terms($taxonomy, $separator = ', ')
{
    $terms = pixflow_get_post_terms_names($taxonomy);

    if(!is_array($terms))
        return null;

    return implode($separator, $terms);
}


/*
 * Converts array of slugs to corresponding array of IDs
 */
function pixflow_slugs_to_ids($slugs=array(), $taxonomy)
{
    $tempArr = array();
    foreach($slugs as $slug)
    {
        if(!strlen(trim($slug))) continue;
        $term = get_term_by('slug', $slug, $taxonomy);
        if(!$term) continue;
        $tempArr[] = $term->term_id;
    }

    return $tempArr;
}

/* Get video url from known sources such as youtube and vimeo */

function pixflow_extract_video_info($string)
{
    //check for youtube video url
    if(preg_match('/https?:\/\/(?:www\.)?youtube\.com\/watch\?v=[^&\n\s"<>]+/i', $string, $matches ))
    {
        $url = parse_url($matches[0]);
        parse_str($url['query'], $queryParams);

        return array('type'=>'youtube', 'url'=> $matches[0], 'id' => $queryParams['v']);
    }
    //Vimeo
    else if(preg_match('/https?:\/\/(?:www\.)?vimeo\.com\/\d+/i', $string, $matches))
    {
        $url = parse_url($matches[0]);

        return array('type'=>'vimeo', 'url'=> $matches[0], 'id' => ltrim($url['path'], '/'));
    }


    return null;
}

function pixflow_extract_audio_info($string)
{
    //check for soundcloud url
    if(preg_match('/https?:\/\/(?:www\.)?soundcloud\.com\/[^&\n\s"<>]+\/[^&\n\s"<>]+\/?/i', $string, $matches ))
    {
        return array('type'=>'soundcloud', 'url'=> $matches[0]);
    }

    return null;
}

function pixflow_get_video_meta(array &$video)
{
    if($video['type']  != 'youtube' && $video['type'] != 'vimeo')
        return null;

    $ret = pixflow_get_url_content($video['url']/*, '127.0.0.1:8080'*/);

    if(is_array($ret))
        return 'Server Error: ' . $ret['error'] . " \nError No: " . $ret['errorno'];

    if(trim($ret) == '')
        return 'Error: got empty response from youtube';

    $html = pixflow_str_get_html($ret);
    $vW   = $html->find('meta[property="og:video:width"]');
    $vH   = $html->find('meta[property="og:video:height"]');

    if(count($vW) && count($vH))
    {
        $video['width']  = $vW[0]->content;
        $video['height'] = $vH[0]->content;
    }

    return null;
}

function pixflow_soundcloud_get_embed($url, $height)
{
    $json = pixflow_get_url_content("http://soundcloud.com/oembed?format=json&url=$url"/*, '127.0.0.1:8580'*/);

    if(is_array($json))
        return 'Server Error: ' . $json['error'] . " \nError No: " . $json['errorno'];

    if(trim($json) == '')
        return 'Error: got empty response from soundcloud';

    //Convert the response string to PHP object
    $data = json_decode($json);

    if(NULL == $data)
        return "Cant decode the soundcloud response \nData: $json" ;

    //TODO: add additional error checks
    $data->html=str_replace('height="400"','height="'.$height.'"',$data->html);
    return $data->html;
}



/* downloads data from given url */

function pixflow_get_url_content($url, $proxy='')
{
    $args = array(
        'headers'     => array(),
        'body'        => null,
        'sslverify'   => true,
    );

    $response = wp_remote_get( $url, array(
            'timeout' => 45,
        )
    );

    if ( is_wp_error( $response ) ) {
        $error_message = $response->get_error_message();
        $ret = array('error' => $error_message, 'errorno' => '' );
    } else {
        $ret = $response['body'];
    }

    return $ret;
}


//Thanks to:
//http://bavotasan.com/tutorials/limiting-the-number-of-words-in-your-excerpt-or-content-in-wordpress/
function pixflow_excerpt($limit) {
    $excerpt = explode(' ', get_the_excerpt(), $limit);
    if (count($excerpt)>=$limit) {
        array_pop($excerpt);
        $excerpt = implode(" ",$excerpt).'...';
    } else {
        $excerpt = implode(" ",$excerpt);
    }
    $excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
    return $excerpt;
}

/* Sidebar widget count */
function pixflow_count_sidebar_widgets($sidebar_id, $echo = false ) {
    $sidebars = wp_get_sidebars_widgets();

    if( !isset( $sidebars[$sidebar_id] ) ){
        return -1;
    }


    $cnt = count( $sidebars[$sidebar_id] );

    if( $echo )
        echo esc_attr($cnt);
    else
        return $cnt;
}

function pixflow_get_custom_sidebars()
{
    $sidebarStr = pixflow_opt('custom_sidebars');

    if(strlen($sidebarStr) < 1)
        return array();

    $arr      = explode(',', $sidebarStr);
    $sidebars = array();

    foreach($arr as $item)
    {
        $sidebars["custom-" . hash("crc32b", $item)] = str_replace('%666', ',', $item);
    }

    return $sidebars;
}

/* Get Sidebar */
function pixflow_get_sidebar($id='main-sidebar' , $type , $class)
{
    $sidebarClass = "sidebar widget-area";
    $sidebarWidth = $GLOBALS['sidebarWidth'];
    $sidebarWidth = ($GLOBALS['sidebarPosition']=='double')? $sidebarWidth/2 :$sidebarWidth;

    if('' != $class)
        $sidebarClass .= " $class";

    if ($type == 'sticky'){
        if(pixflow_count_sidebar_widgets($id) < 1)
            $sidebarClass .= ' no-widgets';
        ?>
        <div class="stickySidebar" style="width: <?php echo esc_attr($sidebarWidth) . '%'; ?>">
            <aside class="<?php echo esc_attr($sidebarClass); ?>">
                <div class="color-overlay"></div>
                <div class="texture-overlay"></div>
                <div class="bg-image"></div>
                <?php dynamic_sidebar($id); ?>
            </aside>
        </div>

        <?php
    }
    elseif($type != 'sticky' )
    {
        if(pixflow_count_sidebar_widgets($id) < 1)
            $sidebarClass .= ' no-widgets';

        $closeIcon = (strpos($sidebarClass , 'smart-sidebar') < 0 || !strpos($sidebarClass , 'smart-sidebar')) ? true : false;

        ?>
        <div widgetID="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($sidebarClass); ?>" style="width: <?php echo esc_attr($sidebarWidth) . '%'; ?>">

            <?php if ($closeIcon) { ?>
                <div class="color-overlay color-type"></div>
                <div class="color-overlay texture-type"></div>
                <div class="color-overlay image-type"></div>
                <div class="texture-overlay"></div>
                <div class="bg-image"></div>
            <?php } else{ ?>
                <span class="close-sidebar"><i class="icon-cross"></i></span>
            <?php } ?>
            <?php dynamic_sidebar($id); ?>
        </div>

        <?php
    }
    ?>

    <?php
}

// not Function
function pixflow_not($value){
    switch ($value) {
        case 'left':
            return 'right';
        case 'right':
            return 'left';
        default :
            return $value;
    }
}

// Get socials
function pixflow_get_active_socials(){
    $active_socials = array();
    $socials = array(
        'facebook'=>'icon-facebook2',
        'twitter' => 'icon-twitter5' ,
        'vimeo'=> 'icon-vimeo',
        'youtube' => 'icon-youtube2' ,
        'googleP' => 'icon-googleplus' ,
        'dribbble' => 'icon-dribbble' ,
        'tumblr' => 'icon-tumblr' ,
        'linkedin' => 'icon-linkedin' ,
        'flickr' => 'icon-flickr2' ,
        'forrst'=>'icon-forrst' ,
        'github' => 'icon-github2' ,
        'lastfm' => 'icon-lastfm' ,
        'paypal'=>'icon-paypal2',
        'rss'=>'icon-feed2',
        'wp'=>'icon-wordpress',
        'deviantart'=>'icon-deviantart2',
        'steam'=>'icon-steam',
        'soundcloud'=>'icon-soundcloud3' ,
        'foursquare'=>'icon-foursquare' ,
        'skype' => 'icon-skype' ,
        'reddit'=>'icon-reddit' ,
        'instagram'=>'icon-instagram' ,
        'blogger'=>'icon-blogger',
        'yahoo'=>'icon-yahoo',
        'delicious'=>'icon-delicious',
        'stumbleupon'=>'icon-stumbleupon3',
        'pinterest'=>'icon-pinterest3',
        'xing'=>'icon-xing'
    );
    $defaults = array('facebook','twitter','youtube');

    foreach ($socials as $setting => $icon ){
        $link = pixflow_get_theme_mod($setting.'_social');
        $default =(in_array($setting,$defaults))?'#':'';
        $link = ($link === null)?$default:$link;
        if($link != ''){
            $active_socials[$setting]['title'] = $setting;
            $active_socials[$setting]['icon'] = $icon;
            $active_socials[$setting]['link'] = $link;
        }
    }
    if(count($active_socials)>0){
        return $active_socials;
    }else{
        return false;
    }
}

function pixflow_colorConvertor($color, $to, $alpha = 1){

    if(strpos($color, 'rgba') !== false){
        $format =  'rgba';
    }elseif(strpos($color, 'rgb') !== false){
        $format = 'rgb';
    }elseif(strpos($color, '#') !== false){
        $format =  'hex';
    }else{
        return '#000';
    }


    switch ($format){
        case 'rgb':
            if ($to == 'rgba'){
                sscanf($color, 'rgb(%d,%d,%d)',$r,$g,$b);
                return ('rgba(' . $r . ',' . $g . ',' . $b . ',' . $alpha . ');' );
            }elseif($to == 'hex'){
                return pixflow_rgb2hex($color);
            }elseif($to == 'rgb'){
                return $color;
            }
            break;

        case 'rgba':
            if ($to == 'rgb'){
                return pixflow_RgbaToRgb($color);
            }elseif($to == 'hex'){
                $rgb = pixflow_RgbaToRgb($color);
                return pixflow_rgb2hex($rgb);
            }elseif ( $to == 'rgba' ){
                sscanf($color, 'rgba(%d,%d,%d,%f)',$r,$g,$b,$a);
                return ('rgba(' . $r . ',' . $g . ',' . $b . ',' . $alpha . ');' );
            }
            break;

        case 'hex' :
            $default = 'rgb(0,0,0)';
            //Sanitize $color if "#" is provided
            if ($color[0] == '#' ) {
                $color = substr( $color, 1 );
            }
            //Check if color has 6 or 3 characters and get values
            if (strlen($color) == 6) {
                $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
            } elseif ( strlen( $color ) == 3 ) {
                $hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
            } else {
                return $default;
            }
            //Convert hexadec to rgb
            $rgb =  array_map('hexdec', $hex);

            if ($to == 'rgba'){
                return 'rgba('.implode(",",$rgb).','.$alpha.')';
            }elseif($to == 'rgb'){
                return 'rgb('.implode(",",$rgb).')';
            }elseif($to == 'hex'){
                return $color;
            }
    }
}

function pixflow_rgb2hex($color){
    $hex = "#";
    if(!is_array($color)){
        $color = explode(',',$color);
        $color[0] = str_replace('rgb','',$color[0]);
        $color[0] = str_replace('(','',$color[0]);
        $color[2] = str_replace(')','',$color[2]);
    }
    $hex .= str_pad(dechex($color[0]), 2, "0", STR_PAD_LEFT);
    $hex .= str_pad(dechex($color[1]), 2, "0", STR_PAD_LEFT);
    $hex .= str_pad(dechex($color[2]), 2, "0", STR_PAD_LEFT);
    return $hex; // returns the hex value including the number sign (#)
}

// convert rgba to rgb
function pixflow_RgbaToRgb($rgba){

    sscanf($rgba, 'rgba(%d,%d,%d,%f)',$r,$g,$b,$a);
    return ('rgb(' . $r . ',' . $g . ',' . $b . ');' );
}

//Return customizer option value
function pixflow_get_theme_mod($name, $default = null , $post_id = false, $vc_customizer = false){

    if($post_id != false){
        $post_id = $post_id;
    }elseif(isset($_SESSION['pixflow_post_id']) && $_SESSION['pixflow_post_id']!=null){
        $post_id = $_SESSION['pixflow_post_id'];
    }else{
        if(is_home()|| is_404()|| is_search()){
            $post_id = get_option( 'page_for_posts' );
        }elseif(function_exists('is_shop') && (is_shop() || is_product_category()) && !is_product()) {
            $post_id = get_option( 'woocommerce_shop_page_id' );
        }else{
            $post_id = get_the_ID();
        }
    }
    $post_type = get_post_type($post_id);
    if((isset($_SESSION['temp_status'])) && $_SESSION['temp_status']['id'] == $post_id){
        $setting_status = $_SESSION['temp_status']['status'];
    }elseif(get_option( 'page_for_posts' ) != $post_id && ($post_type == 'post' || $post_type == 'portfolio' || $post_type == 'product')){
        if(isset($_SESSION[$post_type . '_status'])){
            $setting_status = $_SESSION[$post_type . '_status'];
        }else{
            $setting_status = get_option( $post_type.'_setting_status' );
        }
    }else{
        $setting_status = get_post_meta( $post_id,'setting_status',true ) ;
    }

    $setting_status = ($setting_status == 'unique')?'unique':'general';

    $customizedValues = (isset($_SESSION[$setting_status.'_customized']))?$_SESSION[$setting_status.'_customized']:array();
    if(isset($_POST['customized'])){
        $customizedValues = json_decode( wp_unslash( $_POST['customized'] ), true );
    }

    if(count($customizedValues) && array_key_exists($name,$customizedValues)){
        $value = $customizedValues[$name];

    }else{
        global $md_uniqueSettings;
        $settings = $md_uniqueSettings;

        if($setting_status == 'unique' && in_array($name, $settings)){

            if($post_type == 'post' || $post_type == 'portfolio' || $post_type == 'product' ){
                $value = get_option( $post_type.'_'.$name );
                $value = ($value === false)?get_theme_mod($name,$default):$value;
            }else{
                $value = get_post_meta( $post_id,$name,true );
                $value = ($value === 'false')?false:$value;
            }

            if($value === ''){
                $value = get_theme_mod($name,$default);
                $value = ($value === '')?$default:$value;
            }
        }else{
            $value = get_theme_mod($name,$default);
        }
    }
    $value = ($value === 'false')?false:$value;
    return $value;
}

/*
    generate Visual Composer frontend editor url
    If load from customizer and VC is activated return VC Frontend Editor URL
    Else return false
*/
function pixflow_vc_url(){
// Check for VC plugin status
    if(function_exists('is_plugin_active')){
        if ( is_plugin_active( 'js_composer/js_composer.php' ) && false == is_home() && !(true == is_singular( 'portfolio' ) && 'standard' == pixflow_metabox('portfolio_options.template_type','standard')) ) {
            // Check that page load from customizer
            $_SERVER['HTTP_REFERER'] = (isset($_SERVER['HTTP_REFERER']))?$_SERVER['HTTP_REFERER']:'';
            $parentURL = $_SERVER['HTTP_REFERER'];
            (($pos = strpos($parentURL,"?")) === false)? $parentURL = $parentURL:$parentURL = substr($parentURL,0, $pos);
            if (strpos($parentURL,'wp-admin/customize.php') !== false) {
                $_POST['customized'] = isset($_POST['customized'])?urlencode($_POST['customized']):'';
                $id = get_the_ID();
                if(function_exists('is_shop')){
                    if(is_product() && !(is_shop() || is_product_category())){
                        return false;
                    }
                    if((is_shop() || is_product_category()) && !is_product()){
                        $id = get_option( 'woocommerce_shop_page_id' );
                    }
                }
                remove_action('wp_enqueue_scripts', 'pixflow_theme_scripts');
                add_action('wp_enqueue_scripts', 'pixflow_clearAllenqueues');
                $vc_url = @admin_url().'post.php?vc_action=vc_inline&post_id='.$id.'&post_type='.get_post_type( $id ).'&customizer=true&customized='.$_POST['customized'];
                wp_enqueue_script('loadFrames', PIXFLOW_THEME_JS_URI.'/loadFrames.js', false, PIXFLOW_THEME_VERSION, false);
                $localizeVals = array('vcURL'=>$vc_url);
                wp_localize_script( 'loadFrames', 'localizeVals', $localizeVals );
                @wp_head();
                die();
                //return $vc_url;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }else{
        return false;
    }
}
function pixflow_clearAllenqueues(){
    global $wp_styles,$wp_scripts;

    // loop over all of the registered scripts
    foreach ($wp_styles->registered as $handle => $data)
    {
        // remove it
        wp_deregister_style($handle);
        wp_dequeue_style($handle);
    }
    // loop over all of the registered scripts
    foreach ($wp_scripts->registered as $handle => $data)
    {
        if($handle == 'loadFrames') continue;
        // remove it
        wp_deregister_script($handle);
        wp_dequeue_script($handle);
    }
}
/*
    generate gradient css
    parameters: json(if source is json(json string)),first color(hex or rgb-optional),second color(hex or rgb-optional),start position(int),end position(int),angle(int0-360)
*/
function pixflow_makeGradientCSS($json=false, $color1='#fff', $color2='#000', $pos1=0, $pos2=100, $angle=0){
    if($json && $json!=''){
        $value = json_decode($json);
        $color1 = $value->{"color1"};
        $color2 = $value->{"color2"};
        $pos1 = $value->{"color1Pos"};
        $pos2 = $value->{"color2Pos"};
        $angle = $value->{"angle"};
    }
    $angle  = (int)$angle;
    if($angle <= 90){
        $masterAngle = 90 - $angle;
    }else{
        $masterAngle = 360 - ($angle - 90);
    }
    /*$masterAngle = (int)$angle + 90;
    $masterAngle = ($masterAngle>360)?$masterAngle - 360:$masterAngle;*/
    ob_start();
    ?>
    background: <?php echo esc_attr($color1) ?>;
    background: -webkit-gradient(linear, <?php echo esc_attr($angle) ?>deg, color-stop(<?php echo esc_attr($pos1) ?>%,<?php echo esc_attr($color1) ?>), color-stop(<?php echo esc_attr($pos2) ?>%,<?php echo esc_attr($color2) ?>));
    background: -webkit-linear-gradient(<?php echo esc_attr($angle) ?>deg,  <?php echo esc_attr($color1) ?> <?php echo esc_attr($pos1) ?>%,<?php echo esc_attr($color2) ?> <?php echo esc_attr($pos2) ?>%);
    background: -o-linear-gradient(<?php echo esc_attr($angle) ?>deg,  <?php echo esc_attr($color1) ?> <?php echo esc_attr($pos1) ?>%,<?php echo esc_attr($color2) ?> <?php echo esc_attr($pos2) ?>%);
    background: -ms-linear-gradient(<?php echo esc_attr($angle) ?>deg,  <?php echo esc_attr($color1) ?> <?php echo esc_attr($pos1) ?>%,<?php echo esc_attr($color2) ?> <?php echo esc_attr($pos2) ?>%);
    background: linear-gradient(<?php echo esc_attr($masterAngle) ?>deg,  <?php echo esc_attr($color1) ?> <?php echo esc_attr($pos1) ?>%,<?php echo esc_attr($color2) ?> <?php echo esc_attr($pos2) ?>%);
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='<?php echo esc_attr($color1) ?>', endColorstr='<?php echo esc_attr($color2) ?>', GradientType=0);
    <?php
    return ob_end_flush();
}

add_action( 'wp_ajax_pixflow_generateThumbs', 'pixflow_generateThumbs');
add_action( 'wp_ajax_nopriv_pixflow-generateThumbs', 'pixflow_generateThumbs');
function pixflow_generateThumbs()
{
    set_time_limit(0);
    if(!isset($_SESSION['pixflow_media']) && !is_array($_SESSION['pixflow_media'])){
        die('err');
    }
    foreach($_SESSION['pixflow_media'] as $post_id=>$item){
        wp_update_attachment_metadata( $post_id, wp_generate_attachment_metadata( $post_id, $item ) );
    }
    die('done!');
}

// Demo Importer
add_action( 'wp_ajax_pixflow_ImportClearCache', 'pixflow_ImportClearCache');
add_action( 'wp_ajax_nopriv_pixflow_ImportClearCache', 'pixflow_ImportClearCache');
function pixflow_ImportClearCache()
{
    if(!isset($_SESSION['importDemo']) || $_SESSION['importDemo'] != $_POST['demo']) {
        unset($_SESSION['importPosts']);
        unset($_SESSION['importRemove']);
        unset($_SESSION['importFiles']);
        unset($_SESSION['importImported']);
        unset($_SESSION['importContent']);
        unset($_SESSION['importDoIt']);
        unset($_SESSION['importProcessedPosts']);
        unset($_SESSION['importProcessedAuthors']);
        unset($_SESSION['importProcessedMenuItems']);
        unset($_SESSION['importProcessedTerms']);
        unset($_SESSION['importMenuItemOrphans']);
        unset($_SESSION['importMissingMenuItems']);
    }elseif($_SESSION['importDemo'] == $_POST['demo']){
        echo "retry";
        unset($_SESSION['importDemo']);
    }
}
add_action( 'wp_ajax_pixflow_ImportClearAllCache', 'pixflow_ImportClearAllCache');
add_action( 'wp_ajax_nopriv_pixflow_ImportClearAllCache', 'pixflow_ImportClearAllCache');
function pixflow_ImportClearAllCache()
{
    unset($_SESSION['importPosts']);
    unset($_SESSION['importRemove']);
    unset($_SESSION['importFiles']);
    unset($_SESSION['importImported']);
    unset($_SESSION['importContent']);
    unset($_SESSION['importDoIt']);
    unset($_SESSION['importProcessedPosts']);
    unset($_SESSION['importProcessedAuthors']);
    unset($_SESSION['importProcessedMenuItems']);
    unset($_SESSION['importProcessedTerms']);
    unset($_SESSION['importMenuItemOrphans']);
    unset($_SESSION['importMissingMenuItems']);

}

add_action( 'wp_ajax_pixflow_ImportDummyData', 'pixflow_ImportDummyData');
add_action( 'wp_ajax_nopriv_pixflow_ImportDummyData', 'pixflow_ImportDummyData');
function pixflow_ImportDummyData()
{
    @set_time_limit(0);
    @ini_set('max_execution_time', 0);

    if(pixflow_get_filesystem()){
        global $wp_filesystem;
    }

    $demo = $_POST['demo'];
    $_SESSION['importDemo'] = $demo;
    $revslider = $_POST['revslider'];
    $content = $_POST['content'];
    $setting = $_POST['setting'];
    $widget = $_POST['widget'];
    $media = $_POST['media'];
    $isStore = $_POST['isStore'];
    $revslider = ($revslider == 'false')?false:true;
    $content = ($content == 'false')?false:true;
    $setting = ($setting == 'false')?false:true;
    $widget = ($widget == 'false')?false:true;
    $media = ($media == 'false')?false:true;
    $isStore = ($isStore == 'false')?false:$isStore;
    // Check woocommerce is active
    $revsliderErr = false;
    $woocommerceErr = false;
    $cf7Err = false;
    $pxPortfolioErr = false;
    $woocommerce = 'deactive';
    if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) || class_exists( 'WooCommerce' ) ) {
        $woocommerce = 'active';
    }
    // Check contact form 7 is active
    $cf7 = 'deactive';
    if ((is_plugin_active( 'contact-form-7/wp-contact-form-7.php' ) || defined( 'WPCF7_PLUGIN' ))) {
        $cf7 = 'active';
    }
    // Check Pixflow Portfolio is active
    $px_portfolio = 'deactive';
    if (defined( 'PX_PORTFOLIO_VER' )) {
        $px_portfolio = 'active';
    }
    // Check Rev Slider is active
    $revsliderStatus = 'deactive';
    if(class_exists('RevSlider')) {
        $revsliderStatus = 'active';
    }
    if($isStore && $woocommerce == 'deactive'){
        $woocommerceErr = true;
    }
    if($revslider && $revsliderStatus == 'deactive'){
        $revsliderErr = true;
    }
    if($cf7 == 'deactive' && $content == true){
        $cf7Err = true;
    }
    if($px_portfolio == 'deactive' && $content == true){
        $pxPortfolioErr = true;
    }
    if($cf7Err == true || $pxPortfolioErr == true || $woocommerceErr == true || $revsliderErr == true){
        $err = array();
        if($cf7Err == true){
            $err[] = esc_attr__('Please install & activate ContactForm7 before importing this demo data.','massive-dynamic');
        }
        if($revsliderErr == true){
            $err[] = esc_attr__('Please install & activate Revolution Slider before importing this demo data.','massive-dynamic');
        }
        if($pxPortfolioErr == true){
            $err[] = esc_attr__('Please install & activate Pixflow Portfolio before importing this demo data.','massive-dynamic');
        }
        if($woocommerceErr == true){
            $err[] = esc_attr__('Please install & activate WooCommerce before importing this demo data.','massive-dynamic');
        }
        echo(json_encode($err));
        die();
    }

    $demo_url = 'http://massivedynamic.co/dummydata/demo'.$demo;
    $upload_dir = wp_upload_dir();
    if(!isset($_SESSION['importRemove']) || $_SESSION['importRemove'] !== true) {
        if (is_dir($upload_dir['basedir'] . '/demo')) {
            $dirPath = $upload_dir['basedir'] . '/demo/';
            $files = glob($dirPath . '*', GLOB_MARK);
            foreach ($files as $file) {
                unlink($file);
            }
            rmdir($dirPath);
        }
        $_SESSION['importRemove'] = true;
        echo 'continue';
        return;
    }
    if (!is_dir($upload_dir['basedir'].'/demo')) {
        mkdir($upload_dir['basedir'].'/demo', 0777, true);
        $wp_filesystem->put_contents($upload_dir['basedir'].'/demo/importing.txt', '', FS_CHMOD_FILE);
    }
    if(!isset($_SESSION['importFiles'])) {
        $files = array();
        if ($revslider && $content) {
            $files[] = 'revslider.zip';
        }
        if ($content) {
            $files[] = 'content.xml';
        }
        if ($setting) {
            $files[] = 'customizer.dat';
        }
        if ($widget) {
            $files[] = 'widget.json';
        }
        $_SESSION['importFiles']=$files;
    }else{
        $files = $_SESSION['importFiles'];
    }
    foreach($files as $key=>$file){
        $i = 0;
        // Try to download file for 20 times
        while(++$i <= 20) {
            $response = wp_remote_get(
                $demo_url.'/'.$file,
                array(
                    "timeout" => 90,
                    "sslverify" => false
                )
            );
            if (is_array($response) && $response["response"]["code"] == 200) {
                $wp_filesystem->put_contents($upload_dir['basedir'].'/demo/'.$file, $response['body'], FS_CHMOD_FILE);
                break;
            }
        }
        if(!is_array($response)){
            return 'not response!';
            die();
        }
        unset($_SESSION['importFiles'][$key]);
        echo 'continue';
        return;
    }
    // Import Content

    if($content && !isset($_SESSION['importContent'])){
        if(!class_exists( 'WP_Import' ))
        {
            //Try to use custom version of the plugin
            require_once PIXFLOW_THEME_INCLUDES . '/demo-importer/wordpress-importer.php';
        }
        $wp_import = new WP_Import();
        $wp_import->fetch_attachments = $media;
        // dont remove it
        /*if($media == false){
            $wp_import->placeholder = true;
        }*/
        $wp_import->import($upload_dir['basedir'] . '/demo/content.xml');
        $_SESSION['importContent'] = true;
        die('continue:1/1');
    }

    // Import Customizer Setting
    if($setting){
        if(!class_exists('Pixflow_CEI_Core'))
        {
            require_once PIXFLOW_THEME_INCLUDES . '/demo-importer/class-pixflow-cei-core.php';
        }
        global $wp_customize;
        //$customizer_file = content_url().'/uploads/demo/customizer.dat';
        Pixflow_CEI_Core::init('import',$wp_customize,$upload_dir['basedir'] . '/demo/customizer.dat');
        // Set front & blog page

        if(is_page(pixflow_get_theme_mod('front_page_type', get_option('show_on_front')))) {
            update_option('show_on_front', pixflow_get_theme_mod('front_page_type', get_option('show_on_front')));
        }
        if(is_page(pixflow_get_theme_mod('front_page_static_page', get_option('page_on_front')))) {
            update_option('page_on_front', pixflow_get_theme_mod('front_page_static_page', get_option('page_on_front')));
        }
        if(is_page(pixflow_get_theme_mod('front_page_posts_page', get_option('page_for_posts')))) {
            update_option('page_for_posts', pixflow_get_theme_mod('front_page_posts_page', get_option('page_for_posts')));
        }
        //set navigation to theme locations
        $menus = array();
        $menus = wp_get_nav_menus ( array( 'hide_empty' => true ) );
        if(count($menus)>0){
            $menu = $menus[0];
            $locations['primary-nav'] = $menu->term_id;
            $locations['mobile-nav'] = $menu->term_id;
            set_theme_mod('nav_menu_locations', $locations);
        }
    }

    //Import Widgets
    if($widget){
        // include Widget data class
        if (!class_exists('Pixflow_Widget_Data')) {
            require_once PIXFLOW_THEME_INCLUDES . '/demo-importer/class-widget-data.php';
        }

        $widget_data = new Pixflow_Widget_Data();
        $widget_data->ajax_import_widget_data($upload_dir['basedir'] . '/demo/widget.json');
    }


    // Import revslider
    if($revslider){

        require_once ABSPATH . 'wp-admin/includes/file.php';
        if(pixflow_get_filesystem()){
            global $wp_filesystem;
        }
        $filepath = $upload_dir['basedir'] . '/demo/revslider.zip';
        ob_start();
        $slider = new RevSlider();
        $response = $slider->importSliderFromPost(true, true, $filepath, false, false);
        ob_end_clean();

    }

    // Remove Downloaded files
    $dirPath = $upload_dir['basedir'].'/demo/';
    $files = glob($dirPath . '*', GLOB_MARK);
    foreach ($files as $file) {
        unlink($file);
    }
    rmdir($dirPath);

    unset($_SESSION['importPosts']);
    unset($_SESSION['importImported']);
    unset($_SESSION['importFiles']);
    unset($_SESSION['importRemove']);
    unset($_SESSION['importContent']);
    unset($_SESSION['importDemo']);
    unset($_SESSION['importDoIt']);
    unset($_SESSION['importProcessedPosts']);
    unset($_SESSION['importProcessedAuthors']);
    unset($_SESSION['importProcessedMenuItems']);
    unset($_SESSION['importProcessedTerms']);
    unset($_SESSION['importMenuItemOrphans']);
    unset($_SESSION['importMissingMenuItems']);

    wp_cache_flush();

    return true;
    die();
}

// Ajax Search
add_action( 'wp_ajax_pixflow_load_search_results', 'pixflow_load_search_results');
add_action( 'wp_ajax_nopriv_pixflow_load_search_results', 'pixflow_load_search_results');

function pixflow_load_search_results() {
    $query = esc_attr($_POST['query']);

    $args = array(
        'post_status' => 'publish',
        's' => $query
    );
    $search = new WP_Query( $args );

    ob_start();

    if ( $search->have_posts() ) :
        ?>
        <div class="search-title"><span class="stand-out"><?php echo sizeof($search->posts)?></span> <?php echo esc_attr__('result(s) found for', 'massive-dynamic')?> <span class="stand-out"><?php echo esc_attr($query); ?></span></div>
        <div class="row">
            <?php
            while ( $search->have_posts() ) : $search->the_post();
                $id = get_the_ID();
                $title = the_title('','',false);
                $type = get_post_type( $id );
                $thumbnail = (has_post_thumbnail())?get_post_thumbnail_id( $id ):PIXFLOW_THEME_IMAGES_URI . '/placeholder-'.$type.'.jpg';
                if(is_numeric($thumbnail)){
                    $thumbnail = wp_get_attachment_image_src( $thumbnail,'pixflow_post-related-sm' ) ;
                    $thumbnail = (false == $thumbnail)?PIXFLOW_PLACEHOLDER_BLANK:$thumbnail[0];
                } ?>
                <div class="item col-lg-3 col-md-3 col-sm-3 col-xs-1">
                    <a href="<?php echo get_permalink() ?>">
                        <div class="thumbnail" style="background-image: url('<?php echo esc_url($thumbnail); ?>')"><div class="background-overlay"></div></div>
                        <h4 class="title"><?php echo esc_attr($title); ?></h4>
                    </a>
                </div>
                <?php
            endwhile; ?>
        </div>
        <a class="more-result" href="<?php echo get_search_link( $query ); ?>"><?php echo esc_attr__('See more results..', 'massive-dynamic')?></a>
        <?php
    else :
        echo '<div class="search-title-empty">' . esc_attr__('Nothing Found!', 'massive-dynamic') . '</div>';
    endif;

    ob_get_flush();
    die();

}

// Save temp VC content when a controller with refresh transport has been run.
add_action( 'wp_ajax_pixflow_save_temp_vc_content', 'pixflow_save_temp_vc_content');
add_action( 'wp_ajax_nopriv_pixflow_save_temp_vc_content', 'pixflow_save_temp_vc_content');
function pixflow_save_temp_vc_content() {
    $nonce = $_POST['nonce'];
    if ( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) )
        die ( '' );
    $content = $_POST['content'];
    $_SESSION['vc_temp_content'] = $content;
    return true;
}

//return the content
function pixflow_the_content($post){
    remove_filter('the_post','pixflow_the_content');
    if(isset($_SESSION['vc_temp_content'])){
        $post->post_content = stripslashes($_SESSION['vc_temp_content']);
    }
    return $post;
}
add_filter( 'the_post', 'pixflow_the_content', 1 );

// remove temp content and vars in frontend
add_action( 'get_header', 'pixflow_removeTemp');
function pixflow_removeTemp() {
    // destroy session when site load in frontend
    if(is_customize_preview() == false && !isset($_GET['vc_editable'])){
        unset($_SESSION['general_customized']);
        unset($_SESSION['unique_customized']);
        unset($_SESSION['temp_status']);
        unset($_SESSION['vc_temp_content']);
    }
}

if(basename($_SERVER['PHP_SELF']) == 'customize.php'){
    if(session_id() == '' && !headers_sent()) {
        session_start();
    }
    unset($_SESSION['temp_status']);
    echo('&nbsp;<div class="customizer-beautifier"></div>');
}

//Customizing wp_title
function pixflow_filter_wp_title($title, $separator ) {

    if ( is_feed() ) return $title;

    global $paged, $page;

    if ( is_search() ) {
        $title = sprintf( esc_attr__( 'Search results for %s', 'massive-dynamic' ), '"' . get_search_query() . '"' );

        if ( $paged >= 2 ) {
            $title .= " $separator " . sprintf( esc_attr__( 'Page %s', 'massive-dynamic' ), $paged );
        }
        $title .= " $separator " . get_bloginfo( 'name', 'display' );
        return $title;
    }

    $title .= get_bloginfo( 'name', 'display' );
    $site_description = get_bloginfo( 'description', 'display' );

    if ( $site_description && ( is_home() || is_front_page() ) ) {
        $title .= " $separator " . $site_description;
    }

    if ( $paged >= 2 || $page >= 2 ) {
        $title .= " $separator " . sprintf( esc_attr__( 'Page %s', 'massive-dynamic' ), max( $paged, $page ) );
    }

    return $title;
}
add_filter( 'wp_title', 'pixflow_filter_wp_title', 10, 2 );

/* Detect Browser */
function pixflow_detectBrowser($user_agent){
    if(empty($user_agent)){
        return false;
    }
    if(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== FALSE){
        return 'Internet explorer';
    }elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox') !== FALSE){
        return 'Mozilla Firefox';
    }elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome') !== FALSE){
        return 'Google Chrome';
    }else{
        return 'Something else';
    }
}

function pixflow_redirectToCustomizer($links){
    remove_filter('install_plugin_complete_actions','pixflow_redirectToCustomizer');
    return '';
}

// add a Customizer link to the WP Toolbar
function pixflow_custom_toolbar_link($wp_admin_bar) {
    $site_url=get_site_url();
    if(is_home()){
        $pageID = get_option( 'page_for_posts' );
    }elseif(function_exists('is_shop') && (is_shop() || is_product_category()) && !is_product()) {
        $pageID = get_option( 'woocommerce_shop_page_id' );
    }else{
        $pageID = get_the_ID();
    }
    if($pageID != 0) {
        $link = get_permalink($pageID);
    }else{
        $link = home_url('/');
    }
    $address=$site_url."/wp-admin/customize.php?url=".esc_url($link);

    $args = array(
        'id' => 'md_customizer_button',
        'title' => 'Edit With Massive Builder',
        'href' => $address,
        'meta' => array(
            'class' => 'md_customizer',
            'title' => 'Edit With Massive Builder'
        )
    );
    if(!is_admin())
    {
        $wp_admin_bar->add_node($args);
    }

}
add_action('admin_bar_menu', 'pixflow_custom_toolbar_link', 999);

// Ensure cart contents update when products are added to the cart via AJAX
add_filter( 'woocommerce_add_to_cart_fragments', 'pixflow_woocommerce_header_add_to_cart_fragment');
function pixflow_woocommerce_header_add_to_cart_fragment($fragments ) {
    ob_start();
    global $woocommerce,$md_allowed_HTML_tags;

    do_action( 'woocommerce_before_mini_cart' );
    ?>
    <ul class="cart_list product_list_widget ">

        <?php if ( ! $woocommerce->cart->is_empty() ) : ?>

            <?php
            foreach ( $woocommerce->cart->get_cart() as $cart_item_key => $cart_item ) {
                $_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
                $product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

                if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ) {

                    $product_name  = apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key );
                    $product_price = apply_filters( 'woocommerce_cart_item_price', $woocommerce->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
                    $url = wp_get_attachment_image_src( get_post_thumbnail_id($_product->id), 'woocommerce_cart_item_thumbnail' );
                    $url = (false == $url)?PIXFLOW_PLACEHOLDER_BLANK:$url['0'];
                    if ($url != '')
                        $thumbnail = '<div class="cart-img" style="background-image: url('.$url.')"></div>';

                    ?>
                    <li class="<?php echo esc_attr( apply_filters( 'woocommerce_mini_cart_item_class', 'mini_cart_item', $cart_item, $cart_item_key ) ); ?>">
                        <?php
                        echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
                            '<a href="%s" class="remove" title="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
                            esc_url( $woocommerce->cart->get_remove_url( $cart_item_key ) ),
                            esc_attr__( 'Remove this item', 'massive-dynamic' ),
                            esc_attr( $product_id ),
                            esc_attr( $_product->get_sku() )
                        ), $cart_item_key );
                        ?>
                        <?php if ( ! $_product->is_visible() ) : ?>
                            <?php echo str_replace( array( 'http:', 'https:' ), '', $thumbnail ) . $product_name . '&nbsp;'; ?>
                        <?php else : ?>
                            <a href="<?php echo esc_url( $_product->get_permalink( $cart_item ) ); ?>">
                                <?php echo str_replace( array( 'http:', 'https:' ), '', $thumbnail ) . $product_name . '&nbsp;'; ?>
                            </a>
                        <?php endif; ?>
                        <?php echo wp_kses($woocommerce->cart->get_item_data( $cart_item ),$md_allowed_HTML_tags); ?>

                        <?php echo apply_filters( 'woocommerce_widget_cart_item_quantity', '<span class="quantity">' . sprintf( '%s &times; %s', $cart_item['quantity'], $product_price ) . '</span>', $cart_item, $cart_item_key ); ?>
                    </li>
                    <?php
                }
            }
            ?>

        <?php else : ?>

            <li class="empty"><?php esc_attr_e( 'No products in the cart.', 'massive-dynamic' ); ?></li>

        <?php endif; ?>

    </ul><!-- end product list -->

    <?php if ( ! WC()->cart->is_empty() ) : ?>

        <p class="total"><strong><?php esc_attr_e( 'Subtotal', 'massive-dynamic' ); ?>:</strong> <?php echo WC()->cart->get_cart_subtotal(); ?></p>

        <?php do_action( 'woocommerce_widget_shopping_cart_before_buttons' ); ?>

        <p class="buttons">
            <a href="<?php echo WC()->cart->get_cart_url(); ?>" class="button wc-forward"><?php esc_attr_e( 'View Cart', 'massive-dynamic' ); ?></a>
            <a href="<?php echo WC()->cart->get_checkout_url(); ?>" class="button checkout wc-forward"><?php esc_attr_e( 'Checkout', 'massive-dynamic' ); ?></a>
        </p>

    <?php endif; ?>

    <?php do_action( 'woocommerce_after_mini_cart' ); ?>
    <script type="text/javascript">pixflow_addToCart();</script>
    <?php
    $fragments['ul.cart_list'] = ob_get_clean();

    return $fragments;
}


// Style Our Customizer Button
function pixflow_style_admin_bar() { ?>
    <style type="text/css">
        #wpadminbar #wp-admin-bar-md_customizer_button a{background-color: #4BA25E;transition:all 0.3s ease-in;}
        #wpadminbar #wp-admin-bar-md_customizer_button{background-color: transparent;}
        #wpadminbar #wp-admin-bar-md_customizer_button a:hover{ background-color: rgba(75, 162, 94, 0.65);color:white;}
        #wpadminbar #wp-admin-bar-md_customizer_button a:before {content: "\f100";top:4px;}
        #wp-admin-bar-vc_inline-admin-bar-link{display:none;}
    </style>
<?php }

add_action( 'admin_head', 'pixflow_style_admin_bar');
add_action( 'wp_head', 'pixflow_style_admin_bar');

//Notifications
function pixflow_checkNotifications(){
    $response = wp_remote_get( 'http://massivedynamic.co/notifications.php', array(
            'timeout' => 45,
        )
    );
    if(is_array($response) && $response['body'] != '') {
        $messages = json_decode($response['body'],true);
        if (!get_option('md_notifications')) {
            update_option('md_notifications', '[]');
        }
        $notifications = json_decode(get_option('md_notifications'),true);
        $return = array();
        foreach ($messages as $id => $message) {
            if (!isset($notifications[$id])) {
                @$notifications[$id] = array('new', $message);
                $return[$id] = array('new', $message);
            } elseif (@$notifications[$id][0] != 'delete') {
                if($message != $notifications[$id][1]) {
                    @$notifications[$id] = array('new', $message);
                }
                $return[$id] = array($notifications[$id][0], $message);
            }
        }
        update_option('md_notifications', json_encode($notifications));
        echo json_encode($return);
    }else{
        echo get_option('md_notifications');
    }
    die();
}
add_action( 'wp_ajax_nopriv_pixflow_checkNotifications', 'pixflow_checkNotifications');
add_action( 'wp_ajax_pixflow_checkNotifications', 'pixflow_checkNotifications');

function pixflow_setAsReadNotifications(){

    $notifications = json_decode(get_option('md_notifications'),true);
    foreach($notifications as $id => $notification){
        if($notifications[$id][0] == 'new') {
            $notifications[$id] = array('old', $notification[1]);
        }
    }
    update_option('md_notifications',json_encode($notifications));
    return true;
}
add_action( 'wp_ajax_nopriv_pixflow_setAsReadNotifications', 'pixflow_setAsReadNotifications');
add_action( 'wp_ajax_pixflow_setAsReadNotifications', 'pixflow_setAsReadNotifications');

function pixflow_deleteNotification(){
    $deleteID = $_POST['del'];
    $notifications = json_decode(get_option('md_notifications'),true);
    foreach($notifications as $id => $notification){
        if($id == $deleteID) {
            $notifications[$id] = array('delete', $notification[1]);
        }
    }
    update_option('md_notifications',json_encode($notifications));
    return true;
}
add_action( 'wp_ajax_nopriv_pixflow_deleteNotification', 'pixflow_deleteNotification');
add_action( 'wp_ajax_pixflow_deleteNotification', 'pixflow_deleteNotification');

function pixflow_clearNotifications(){
    $notifications = json_decode(get_option('md_notifications'),true);
    foreach($notifications as $id => $notification){
        $notifications[$id] = array('delete', $notification[1]);
    }
    update_option('md_notifications',json_encode($notifications));
    return true;
}
add_action( 'wp_ajax_nopriv_pixflow_clearNotifications', 'pixflow_clearNotifications');
add_action( 'wp_ajax_pixflow_clearNotifications', 'pixflow_clearNotifications');

//set sefault setting for add to any plugin
if (function_exists('A2A_menu_locale')){
    $options = get_option('addtoany_options');
    $options['display_in_posts_on_front_page'] = '-1';
    $options['display_in_posts_on_archive_pages'] = '-1';
    $options['display_in_excerpts'] = '-1';
    $options['display_in_posts'] = '-1';
    $options['display_in_feed'] = '-1';
    $options['display_in_pages'] = '-1';
    $options['display_in_posts_on_front_page'] = '-1';
    $options['display_in_cpt_portfolio'] = '-1';
    if (isset($options['display_in_cpt_product'])) {
        $options['display_in_cpt_product'] = '-1';
    }
    update_option('addtoany_options', $options);
}

// Add new element in customizer (Page,Post,Portfolio)
function pixflow_addNewElement(){
    $type = $_POST['postType'];
    $my_post=array(
        'post_title'  => $_POST['pageTitle'],
        'post_type'   => $type,
        'post_parent' => 0,
        'post_author' => get_current_user_id(),
        'post_status' => 'publish'
    );
    $id = wp_insert_post( $my_post );
    $url = get_permalink ( $id );
    echo esc_url($url);
}
add_action( 'wp_ajax_nopriv_pixflow_addNewElement', 'pixflow_addNewElement');
add_action( 'wp_ajax_pixflow_addNewElement', 'pixflow_addNewElement');

//Load Google Font Dropdown
function pixflow_googleFontsDropDown(){
    global $md_allowed_HTML_tags;
    $id = $_POST['id'];
    $gf = new PixflowGoogleFonts(pixflow_path_combine(PIXFLOW_THEME_LIB_URI, 'googlefonts.json'));
    $fontNames = $gf->Pixflow_GetFontNames();
    $string = '';
    $default = ('PIXFLOW_'.defined(strtoupper(str_replace('-','_',$id))))?constant('PIXFLOW_'.strtoupper(str_replace('-','_',$id))):'';
    $value = pixflow_get_theme_mod($id,$default);
    foreach($fontNames as $font){
        $selected = ($font == $value)?'selected':'';
        $string .= '<span value="'.$font.'" class="select-item '.$selected.'">'.$font.'<span class="cd-dropdown-option"></span></span>';
    }
    echo wp_kses($string,$md_allowed_HTML_tags);
    exit();
}
add_action( 'wp_ajax_nopriv_pixflow_googleFontsDropDown', 'pixflow_googleFontsDropDown');
add_action( 'wp_ajax_pixflow_googleFontsDropDown', 'pixflow_googleFontsDropDown');

//Get Metabox value from vafpress function
function pixflow_metabox($key, $default=null){
    $value = vp_metabox($key,$default);
    $value = (null == $value)?$default:$value;
    return $value;
}

function pixflow_drfw_postID_by_url($url) {
    global $wpdb;
    $id = url_to_postid($url);
    if($id==0) {
        $fileupload_url = get_option('fileupload_url',null).'/';
        if (strpos($url,$fileupload_url)!== false) {
            $url = str_replace($fileupload_url,'',$url);
            $id = $wpdb->get_var($wpdb->prepare("SELECT wposts.ID FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta WHERE wposts.ID = wpostmeta.post_id AND wpostmeta.meta_key = '_wp_attached_file' AND wpostmeta.meta_value = '$url' AND wposts.post_type = 'attachment'"));
        }
    }
    return $id;
}

//Moving comment form to bottom
function pixflow_move_comment_field_to_bottom($fields ) {
    $comment_field = $fields['comment'];
    unset( $fields['comment'] );
    $fields['comment'] = $comment_field;
    return $fields;
}

add_filter( 'comment_form_fields', 'pixflow_move_comment_field_to_bottom');


//Add no-js class to body tag in a non hardcode way
add_action( 'body_class', 'pixflow_add_custom_bodyclass');

function pixflow_add_custom_bodyclass($classes ) {
    $classes[] = 'no-js';
    return $classes;
}


// Allow users to upload to media library for using in icon shortcode
function pixflow_mime_types($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'pixflow_mime_types');

// remove Open Sans font
add_action( 'wp_enqueue_scripts', 'pixflow_deregister_styles', 100 );

function pixflow_deregister_styles() {
    wp_deregister_style('open-sans');
    wp_register_style('open-sans', false);
    wp_enqueue_style('open-sans');
}

function pixflow_decodeSetting(){
    list($detail,$setting_status,$pageID) = pixflow_getPageInfo();
    if(isset($_POST['customized'])){
        $_SESSION[$setting_status.'_customized'] = json_decode( wp_unslash( $_POST['customized'] ), true );
    }
    return true;
}
function pixflow_metaPageType(){
    list($detail,$setting_status,$pageID) = pixflow_getPageInfo();
    if($pageID!=0){
        $link =get_permalink ($pageID);
    }else{
        $link = '';
    }
    //Get sidebar
    $sidebar = '';
    if( is_single() ){
        $sidebar = 'blogSingle';
    }elseif ( (is_front_page() && is_home()) ||  is_home()  ){
        $sidebar='blogPage';
    }elseif(is_page()){
        $sidebar = 'general';
    }
    if((in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) || class_exists( 'WooCommerce' )) && function_exists('is_woocommerce')){
        if(is_woocommerce()){
            $sidebar = 'shop';
        }
    }
    echo '<meta sidebar-type="'.esc_attr($sidebar).'" name="post-id" content="'.esc_attr($pageID).'" setting-status="'.esc_attr($setting_status).'" detail="'.esc_attr($detail).'" page-url="'.esc_url($link).'" />';
}
function pixflow_getPageInfo(){
    if(is_home()){
        $pageID = get_option( 'page_for_posts' );
    }elseif(function_exists('is_shop') && (is_shop() || is_product_category()) && !is_product()) {
        $pageID = get_option( 'woocommerce_shop_page_id' );
    }else{
        $pageID = get_the_ID();
    }

    $post_type = get_post_type($pageID);
    if ((isset($_SESSION['temp_status'])) && ($_SESSION['temp_status']['id'] == $pageID || ($_GET['vc_editable'] != 'true' && !is_home()))) {
        $setting_status = $_SESSION['temp_status']['status'];
    } else {
        if (isset($_SESSION['temp_status'])) {
            unset($_SESSION['temp_status']);
        }
        if (is_single() && ($post_type == 'post' || $post_type == 'portfolio' || $post_type == 'product')) {
            if (isset($_SESSION[$post_type . '_status'])) {
                $setting_status = $_SESSION[$post_type . '_status'];
                unset($_SESSION[$post_type . '_status']);
            } else {
                $setting_status = get_option($post_type . '_setting_status');
            }
        } else {
            $setting_status = get_post_meta($pageID, 'setting_status', true);
        }
    }
    $setting_status = ($setting_status == 'unique') ? 'unique' : 'general';
    if (is_singular('post')) {
        $detail = 'post';
    } elseif (is_singular('portfolio')) {
        $detail = 'portfolio';
    } elseif (is_singular('product')) {
        $detail = 'product';
    } else {
        $detail = 'other';
    }
    return array($detail, $setting_status, $pageID);
}


function pixflow_get_filesystem()
{
    $access_type = get_filesystem_method();
    if($access_type === 'direct')
    {
        /* you can safely run request_filesystem_credentials() without any issues and don't need to worry about passing in a URL */
        $creds = request_filesystem_credentials(site_url() . '/wp-admin/', '', false, false, array());
        /* initialize the API */
        if ( ! WP_Filesystem($creds) ) {
            /* any problems and we exit */
            return false;
        }
        return true;
    }
    else{
        return false;
    }
}

function pixflow_forbiddenStyle(){
    global $wp_styles;
    // loop over all of the registered scripts
    foreach ($wp_styles->registered as $handle => $data)
    {
        // remove it
        wp_deregister_style($handle);
        wp_dequeue_style($handle);
    }
    wp_enqueue_style("robotoFont","https://fonts.googleapis.com/css?family=Roboto");
    wp_enqueue_style("forbiddenStyles",PIXFLOW_THEME_CSS_URI."/forbidden-styles.css");
}
function pixflow_vcInstallationStyles(){
    global $wp_styles;
    // loop over all of the registered scripts
    foreach ($wp_styles->registered as $handle => $data)
    {
        // remove it
        wp_deregister_style($handle);
        wp_dequeue_style($handle);
    }
    wp_enqueue_style("robotoFont","https://fonts.googleapis.com/css?family=Roboto");
    wp_enqueue_style("vcInstallation",PIXFLOW_THEME_CSS_URI."/vc-installation.css");
}

/*Make retina image for orginal file*/
function pixflow_makeRetiaImage($post_ID) {
    $file = get_attached_file( $post_ID );
    $path_parts = pathinfo($file);
    $retinaFile = $path_parts['dirname'].'/'.$path_parts['filename'].'@2x.'.$path_parts['extension'];
    copy($file, $retinaFile);
    return $post_ID;
}
add_filter('add_attachment', 'pixflow_makeRetiaImage', 10, 2);

/*Remove retina original image after delete*/
function pixflow_removeRetinaImage($post_ID) {
    $file = get_attached_file( $post_ID );
    $path_parts = pathinfo($file);
    $retinaFile = $path_parts['dirname'].'/'.$path_parts['filename'].'@2x.'.$path_parts['extension'];
    @unlink($retinaFile);
    return $post_ID;
}
add_filter('delete_attachment', 'pixflow_removeRetinaImage', 10, 2);

/*********************************************************************/
/* Add featured post checkbox
/********************************************************************/

add_action( 'add_meta_boxes', 'pixflow_showPageTitleMetaBox' );
function pixflow_showPageTitleMetaBox() {
    add_meta_box('show_page_title_id',esc_attr__('Display Page Title ?','massive-dynamic'), 'pixflow_pageMetaBox_callback', 'page', 'normal', 'high');
}
function pixflow_pageMetaBox_callback( $post ) {
    global $post;
    $showPageTitle=get_post_meta( $post->ID, 'show_page_title', true );
    //$showPageTitle = ($showPageTitle === '')?'yes':$showPageTitle;
    ?>

    <input type="checkbox" name="show_page_title" value="yes" <?php echo (($showPageTitle=='yes') ? 'checked="checked"': '');?>/> YES
    <?php
}

add_action('save_post', 'pixflow_savePageMetaBox');
function pixflow_savePageMetaBox(){
    global $post;
    if(null == $post || !isset($_POST['show_page_title'])){
        return;
    }
    update_post_meta( $post->ID, 'show_page_title', $_POST['show_page_title']);
}


// Embed pixflow metabox to theme, so we deactivate pixflow metabox anymore
function pixflow_deactivatePixflowMetabox(  $plugin, $network_activation ) {
    if( defined('PX_Metabox_VER') ){
        deactivate_plugins( WP_PLUGIN_DIR.'/pixflow-metabox/pixflow-metabox.php' );
    }
}
add_action( 'activated_plugin', 'pixflow_deactivatePixflowMetabox', 10, 2 );