<?php
function pixflow_page_add_meta_box() {
    $screens = array( 'page' );

    foreach ( $screens as $screen ) {
        add_meta_box('customizer',esc_attr__('customizer Options','massive-dynamic'),'pixflow_page_in_customize_callback',$screen,'normal','high');
    }
}
add_action( 'add_meta_boxes', 'pixflow_page_add_meta_box');

function pixflow_page_in_customize_callback() {
    $url = admin_url().'customize.php?url='.urlencode(get_permalink(get_the_ID()));
    ?>
    <div class="back-to-customizer">
        <div class="left-side">
            <h1 class="title">Continue building your website in<span>MASSIVE BUILDER</span></h1>
            <p class="description">If you change website settings, it will affect other pages too.<br> To have a custom layout for this page, choose unique settings.</p>
        </div>
        <div class="right-side">
            <a class="button" href="<?php echo esc_url($url); ?>">Live Edit This Page</a>
            <a target="_blank" href="http://support.pixflow.net" class="help"></a>
        </div>
    </div>
<?php
}


function pixflow_page_save_meta_box_data($post_id ) {


    if ( ! isset( $_POST['page_meta_box_nonce'] ) ) {
        return;
    }

    if ( ! wp_verify_nonce( $_POST['pixflow_page_meta_box_nonce'], 'pixflow_page_save_meta_box_data' ) ) {
        return;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    // Check the user's permissions.
    if ( 'page' == $_POST['post_type'] ) {

        if ( ! current_user_can( 'edit_page', $post_id ) ) {
            return;
        }

    } else {

        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }
    }


    if ( ! isset( $_POST['subtitle'] ) ) {
        return;
    }

    // Sanitize user input.
    $my_data = sanitize_text_field( $_POST['subtitle'] );

    // Update the meta field in the database.
    update_post_meta( $post_id, 'subtitle', $my_data );
}
add_action( 'save_post', 'pixflow_page_save_meta_box_data');
?>