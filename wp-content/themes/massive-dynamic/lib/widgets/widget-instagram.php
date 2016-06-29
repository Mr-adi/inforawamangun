<?php
class Pixflow_Instagram_Widget extends WP_Widget
{
    public $setting;
    public $instagram;
    public $user;
    public $data;
    public $token;
    public $code;
    public $loginURL;
    public $images;
    public $profile = array();
    public $imagesData = array();

    public function __construct()
    {
        parent::__construct(
            'Md_Instagram_Widget',
            'Md - Instagram Widget',
            array(
                'description' => 'Instagram Widget'
            )
        );
        $redirect_uri = admin_url() . 'widgets.php';
        $instagram = new pixflow_Instagram(array(
            'apiKey' => 'a0416c7630d74bfb894916fb4c8d0c70',
            'apiSecret' => '9df90946a6c142c9b75e6df51726124c',
            'apiCallback' => 'http://demo2.pixflow.net/instagram-app/redirect.php?redirect_uri=' . urlencode($redirect_uri) // must point to success.php
        ));
        $this->instagram = $instagram;
        $this->loginURL = $this->instagram->getLoginUrl();

        $this->setting = parent::get_settings();
        $token_access = '';
        foreach($this->setting as $arr){
            foreach($arr as $key=>$value){
                if($key == 'token_access'){
                    $token_access = $value;
                }
            }
        }
        if($token_access!=''){
            $this->token = $token_access;
        }
        if ($this->token == '' && isset($_GET['code'])) {
            $this->token = $_GET['code'];
        }

    }

    public function widget($args, $instance)
    {
        // check authentication
        if ($this->token !== false && $this->token != '') {
            // store user access token
            $this->instagram->setAccessToken($this->token);
            // now we have access to all authenticated user methods
            $this->images = $this->instagram->getUserMedia();
            $this->user = $this->instagram->getUser();
            $this->profile['image'] = $this->user->data->profile_picture;
            $this->profile['bio'] = $this->user->data->bio;
            $this->profile['username'] = $this->user->data->username;
            $this->imagesData = $this->images->data;
        }
        global $md_allowed_HTML_tags;
        ob_start();
        ?>
        <div class="widget widget-instagram">
            <h4 class="widget-title"><?php echo wp_kses($instance['title'] .$args['after_title'],$md_allowed_HTML_tags);?>
            <div class="widget-content clearfix">
                <div class="featured-item"></div>
                <?php
                if(isset($this->images->data) && is_array($this->images->data)){
                    $avatar = $this->profile['image'];
                    $username = $this->profile['username'];
                    $bio = $this->profile['bio'];?>
                    <div class='user-info'>
                        <div class='avatar' style='background-image: url(<?php echo esc_url($avatar);?>);'></div>
                        <h5 class='username'><a href='https://instagram.com/<?php echo esc_attr($username);?>' target='_blank'>@<?php echo esc_attr($username);?></a></h5>
                        <p class='biography'><?php echo esc_attr($bio);?></p>
                    </div>
                    <?php
                    $counter = 1;
                    foreach ($this->images->data as $media) {
                        if($counter > $instance['images']){
                            break;
                        }
                        $likes = $media->likes->count;
                        $comments = $media->comments->count;
                        //$comment = $media->caption->text;
                        ?>
                        <?php
                        // output media
                        if ($media->type === 'video') {
                            continue;
                            //video
                            $poster = $media->images->low_resolution->url;
                            $source = $media->videos->standard_resolution->url;?>
                            <div class='item'>
                                <video class="media video-js vjs-default-skin" width="250" height="250" poster="<?php echo esc_url($poster)?>" data-setup='{"controls":true, "preload": "auto"}'>
                                    <source src="<?php echo esc_url($source)?>" type="video/mp4" />
                                </video>
                                <div class='meta'>
                                    <span class='likes'><i class='icon-heart3'></i><?php echo esc_attr($likes);?> </span>
                                    <span class='comments'><i class='icon-comment'></i> <?php echo esc_attr($comments);?> </span>
                                </div>
                            </div>
                        <?php
                        } else {
                            // image
                            $image = $media->images->low_resolution->url;
                            ?>
                            <div class='item'>
                                <img src="<?php echo esc_url($image);?>" alt='Instagram Photo'>
                                <div class='meta'>
                                    <span class='likes'><i class='icon-heart3'></i><?php echo esc_attr($likes);?> </span>
                                    <span class='comments'><i class='icon-comment'></i> <?php echo esc_attr($comments);?> </span>
                                </div>
                            </div>
                        <?php
                        }
                        // output media
                        ?>
                        <?php
                        $counter++;
                    }
                }
            ?>
            </div>
        </div>
        <?php
        ob_end_flush();
    }

    function update($new_instance, $old_instance)
    {
        $instance = $old_instance;

        // Strip tags to remove HTML (important for text inputs)
        $instance['title'] = trim($new_instance['title']);
        $instance['token_access'] = strip_tags($new_instance['token_access']);
        $instance['images'] = strip_tags($new_instance['images']);
        $instance['show_like'] = strip_tags($new_instance['show_like'] == '')?0:1;
        $instance['show_comment'] = strip_tags($new_instance['show_comment']=='')?0:1;
        return $instance;
    }

    public function form($instance)
    {
        // Set up some default widget settings
        $defaults = array(
            'title' => 'My Instagram',
            'token_access' => '',
            'images' => '5',
            'show_like' => 1,
            'show_comment' => 1
        );
        $instance = wp_parse_args((array)$instance, $defaults);

        if ($instance['token_access'] != '') {
            $instance['token_access'] = $instance['token_access'];
        } elseif (isset($this->token) && isset($_GET['code'])) {
            $instance['token_access'] = $this->token;
        }
        ?>


        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_attr_e('Title:', 'massive-dynamic') ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('title')); ?>"
                   value=" <?php echo esc_attr(trim($instance['title'])); ?>">
        </p>


        <p>
            <label
                for="<?php echo esc_attr($this->get_field_id('token_access')); ?>"><?php esc_attr_e('Token Access :', 'massive-dynamic') ?></label>
            <a href=" <?php echo esc_url($this->loginURL); ?>"><?php echo esc_attr__('Get Token Access','massive-dynamic'); ?></a>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('token_access')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('token_access')); ?>"
                   value="<?php echo esc_attr($instance['token_access']); ?>">
        </p>


        <p>
            <label

                for="<?php echo esc_attr($this->get_field_id('images')); ?>"><?php esc_attr_e('show how many image?:', 'massive-dynamic') ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('images')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('images')); ?>"
                   value="<?php echo esc_attr($instance['images']); ?>">
        </p>


        <p>
            <input type="checkbox" class="checkbox" id="<?php echo esc_attr($this->get_field_id('show_like')); ?>" name="<?php echo esc_attr($this->get_field_name('show_like')); ?>" value="<?php echo esc_attr($instance['show_like']=='')?0:1; ?>" <?php echo esc_attr($instance['show_like'] == 1)?'checked="checked"':""; ?>>
            <label for="<?php echo esc_attr($this->get_field_id('show_like')); ?>"><?php esc_attr_e('Show Like count', 'massive-dynamic') ?></label>
        </p>

        <p>
            <input type="checkbox" class="checkbox" id="<?php echo esc_attr($this->get_field_id('show_comment')); ?>" name="<?php echo esc_attr($this->get_field_name('show_comment')); ?>" value="<?php echo esc_attr($instance['show_comment'] == '')?0:1; ?>" <?php echo esc_attr($instance['show_comment'] == 1)?'checked="checked"':""; ?>>
            <label for="<?php echo esc_attr($this->get_field_id('show_comment')); ?>"><?php esc_attr_e('Show Comment count', 'massive-dynamic') ?></label>
        </p>

        <?php
    }
}

// register widget
add_action('widgets_init', create_function('', 'register_widget( "Pixflow_Instagram_Widget" );'));
