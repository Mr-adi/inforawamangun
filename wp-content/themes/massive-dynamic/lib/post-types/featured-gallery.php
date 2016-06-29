<?php
function pixflow_fg_enqueue_stuff(){
wp_enqueue_media();
wp_localize_script('fg-admin-script', 'myAjax', array('ajaxurl' => admin_url('admin-ajax.php')));
}

function pixflow_fg_register_metabox()
{
$post_types = apply_filters('fg_post_types', array('post'));
$context = apply_filters('fg_context','side');
$priority = apply_filters('fg_priority', 'low');
foreach ($post_types as $post_type) {
add_meta_box('featuredgallerydiv', esc_attr__('Featured Gallery', 'massive-dynamic'), 'pixflow_fg_display_metabox', $post_type, $context, $priority);
}
}

function pixflow_fg_display_metabox()
{
    global $post;
    global $md_allowed_HTML_tags;
// Get the Information data if its already been entered
$galleryHTML = '';
$oldfix = '';
if (get_bloginfo('version') >= 3.8) {
$button = '';
} else {
$button = '<button class="media-modal-icon"></button>';
$oldfix = ' premp6';
}
$selectText = esc_attr__('Select Images', 'massive-dynamic');
$visible = ''; //SHOULD WE SHOW THE REMOVE ALL BUTTON? THIS WILL BE APPLIED AS A CLASS, AND IS BLANK BY DEFAULT.
$galleryArray = pixflow_get_post_gallery_ids($post->ID);
$galleryString = pixflow_get_post_gallery_ids($post->ID, 'string');
if (!empty($galleryString)) {
foreach ($galleryArray as &$id) {
    $imageSrc = wp_get_attachment_url($id);
    $imageSrc = (false == $imageSrc)?PIXFLOW_PLACEHOLDER_BLANK:$imageSrc;
    $galleryHTML .= '<li>' . $button . '<img id="' . $id . '" src="' . $imageSrc . '"></li> ';
}
$selectText = esc_attr__('Edit Selection', 'massive-dynamic');
$visible = " visible";
}
update_post_meta($post->ID, 'fg_temp_metadata', $galleryString); // Overwrite the temporary featured gallery data with the permanent data. This is a precaution in case someone clicks Preview Changes, then exits withing saving. ?>
<input type="hidden" name="fg_temp_noncedata" id="fg_temp_noncedata"
       value="<?php echo wp_create_nonce('fg_temp_noncevalue'); ?>"/>
<input type="hidden" name="fg_perm_noncedata" id="fg_perm_noncedata"
       value="<?php echo wp_create_nonce(plugin_basename(__FILE__)); ?>"/>
<input type="hidden" name="fg_perm_metadata" id="fg_perm_metadata" value="<?php echo esc_attr($galleryString); ?>"
       data-post_id="<?php echo esc_attr($post->ID); ?>"/>
<button class="button" id="fg_select"><?php echo esc_attr($selectText); ?></button>
<button class="button<?php echo esc_attr($visible . $oldfix); ?>"
        id="fg_removeall"><?php esc_attr_e('Remove All', 'massive-dynamic'); ?></button>
    <ul><?php echo wp_kses($galleryHTML,$md_allowed_HTML_tags); ?></ul>
<div style="clear:both;"></div><?php
}

function pixflow_fg_save_perm_metadata($post_id, $post)
{
    //Only run the call when updating a Featured Gallery.
    if (empty($_POST['fg_perm_noncedata'])) {
        return;
    }
    // Noncename
    if (!wp_verify_nonce($_POST['fg_perm_noncedata'], plugin_basename(__FILE__))) {
        return;
    }
    // Verification of User
    if (!current_user_can('edit_post', $post->ID)) {
        return;
    }
    // OK, we're authenticated: we need to find and save the data
    $events_meta['fg_perm_metadata'] = $_POST['fg_perm_metadata'];
    // Add values of $events_meta as custom fields
    foreach ($events_meta as $key => $value) {
        if ($post->post_type == 'revision') {
            return;
        }
        $value = implode(',', (array)$value);
        if (get_post_meta($post->ID, $key, FALSE)) {
            update_post_meta($post->ID, $key, $value);
        } else {
            add_post_meta($post->ID, $key, $value);
        }
        if (!$value) {
            delete_post_meta($post->ID, $key);
        }
    }

}

function pixflow_fg_update_temp()
{
    if (!wp_verify_nonce($_REQUEST['fg_temp_noncedata'], "fg_temp_noncevalue")) {
        exit("You shouldn't have gotten here, something is going wrong.");
    }
    if (!current_user_can('edit_post', $_REQUEST['fg_post_id'])) {
        exit("You don't appear to be logged in, something is going wrong here.");
    }
    $newValue = $_REQUEST['fg_temp_metadata'];
    $oldValue = get_post_meta($_REQUEST['fg_post_id'], 'fg_temp_metadata', 1);
    $response = "success";
    if ($newValue != $oldValue) {
        $success = update_post_meta($_REQUEST['fg_post_id'], 'fg_temp_metadata', $newValue);
        if ($success == false) {
            $response = "error";
        }
    }
    echo json_encode($response);
    die();
}

function pixflow_get_post_gallery_ids($id, $max_images = -1, $method = "array")
{
    if (is_preview($id)) {
        $galleryString = get_post_meta($id, 'fg_temp_metadata', 1);
    } else {
        $galleryString = get_post_meta($id, 'fg_perm_metadata', 1);
    }
    if ($method == "string" || $max_images == "string") {
        return $galleryString;
    } else {
        if ($max_images == -1) {
            return explode(',', $galleryString);
        } else {
            return array_slice(explode(',', $galleryString), 0, $max_images);
        }
    }
}

add_action('add_meta_boxes', 'pixflow_fg_register_metabox');
add_action('save_post', 'pixflow_fg_save_perm_metadata', 1, 2);
add_action('admin_enqueue_scripts', 'pixflow_fg_enqueue_stuff');
add_action('wp_ajax_pixflow_fg_update_temp', 'pixflow_fg_update_temp');