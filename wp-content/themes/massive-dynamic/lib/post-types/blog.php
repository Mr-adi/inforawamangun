<?php

function pixflow_general_blog_add_meta_box() {

    $screens = array( 'post' );

    foreach ( $screens as $screen ) {

        add_meta_box('customizer',esc_attr__('customizer Options','massive-dynamic'),'pixflow_blog_in_customizer_callback',$screen);
        add_meta_box('pixflow-general-blog-setting',esc_attr__( 'Post Setting Section', 'massive-dynamic' ),'pixflow_general_blog_meta_box_callback',$screen);


    }
}
add_action( 'add_meta_boxes', 'pixflow_general_blog_add_meta_box' );

function pixflow_general_blog_meta_box_callback( $post ) {

    wp_nonce_field( 'pixflow_general_blog_save_meta_box_data', 'pixflow_general_blog_meta_box_nonce' );

    $heightValue      = get_post_meta( $post->ID, 'image-height', true );
    $authorValue      = get_post_meta( $post->ID, 'author-section', true );
    $relatedPostValue = get_post_meta( $post->ID, 'related-post', true );
    $subscribeValue   = get_post_meta( $post->ID, 'subscribe-section', true );

    echo '<table>';

    echo '<tr><td width="150"><label for="image-height">';
    esc_attr_e( 'Media Height', 'massive-dynamic' );
    echo '</label></td><td>';
    echo '<input type="text" id="image-height" placeholder="example : 500" name="image-height" value="' . esc_attr( $heightValue ) . '" size="25" /></td></tr>';

    echo '<tr><td><label for="author-section">';
    esc_attr_e( 'About Author Section', 'massive-dynamic' );
    echo '</label></td><td>'; ?>

    <select name="author-section" id="author-section">
                <option value="show" <?php selected( esc_attr( $authorValue ), "show" ); ?>>Show</option>
                <option value="hide" <?php selected( esc_attr( $authorValue ), "hide" ); ?>>Hide</option>
    </select></td></tr>

    <?php
    echo '<tr><td><label for="related-post">';
    esc_attr_e( 'Related Post Section', 'massive-dynamic' );
    echo '</label></td><td>'; ?>
    <select name="related-post" id="related-post">
                <option value="show" <?php selected( esc_attr( $relatedPostValue ), "show" ); ?>>Show</option>
                <option value="hide" <?php selected( esc_attr( $relatedPostValue ), "hide" ); ?>>Hide</option>
    </select></td></tr>

    <?php
    echo '<tr><td><label for="subscribe-section">';
    esc_attr_e( 'Subscribe Section', 'massive-dynamic' );
    echo '</label></td><td>'; ?>
    <select name="subscribe-section" id="subscribe-section">
                <option value="show" <?php selected( esc_attr( $subscribeValue ), "show" ); ?>>Show</option>
                <option value="hide" <?php selected( esc_attr( $subscribeValue ), "hide" ); ?>>Hide</option>
    </select></td></tr>
<?php
}

function pixflow_general_blog_save_meta_box_data( $post_id ) {


    if ( ! isset( $_POST['pixflow_general_blog_meta_box_nonce'] ) ) {
        return;
    }

    if ( ! wp_verify_nonce( $_POST['pixflow_general_blog_meta_box_nonce'], 'pixflow_general_blog_save_meta_box_data' ) ) {
        return;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    // Check the user's permissions.
    if ( 'post' == $_POST['post_type'] ) {

        if ( ! current_user_can( 'edit_page', $post_id ) ) {
            return;
        }

    } else {

        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }
    }


    if ( ! isset( $_POST['image-height'] ) ) {
        return;
    }

    // Sanitize user input.

    $heightValue      = sanitize_text_field( $_POST['image-height'] );
    $authorValue      = sanitize_text_field( $_POST['author-section'] );
    $relatedPostValue = sanitize_text_field( $_POST['related-post'] );
    $subscribeValue   = sanitize_text_field( $_POST['subscribe-section'] );

    // Update the meta field in the database.
    update_post_meta( $post_id, 'image-height', $heightValue );
    update_post_meta( $post_id, 'author-section', $authorValue );
    update_post_meta( $post_id, 'related-post', $relatedPostValue );
    update_post_meta( $post_id, 'subscribe-section', $subscribeValue );



}
add_action( 'save_post', 'pixflow_general_blog_save_meta_box_data' );

function pixflow_video_blog_add_meta_box() {

    $screens = array( 'post' );

    foreach ( $screens as $screen ) {

        add_meta_box(
            'blog_meta_box_video_url',
            esc_attr__( 'Post Video', 'massive-dynamic' ),
            'pixflow_video_blog_meta_box_callback',
            $screen
        );
    }
}
add_action( 'add_meta_boxes', 'pixflow_video_blog_add_meta_box' );

function pixflow_video_blog_meta_box_callback( $post ) {

    wp_nonce_field( 'pixflow_video_blog_save_meta_box_data', 'pixflow_video_blog_meta_box_nonce' );

    $videoValue       = get_post_meta( $post->ID, 'video-url', true );

    echo '<label for="video-url">';
    esc_attr_e( 'Video URL', 'massive-dynamic' );
    echo '</label>';
    echo '<input type="text" id="video-url" name="video-url" value="' . esc_attr( $videoValue ) . '" size="25" /><br/>';

}

function pixflow_video_blog_save_meta_box_data( $post_id ) {


    if ( ! isset( $_POST['pixflow_video_blog_meta_box_nonce'] ) ) {
        return;
    }

    if ( ! wp_verify_nonce( $_POST['pixflow_video_blog_meta_box_nonce'], 'pixflow_video_blog_save_meta_box_data' ) ) {
        return;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    // Check the user's permissions.
    if ( 'post' == $_POST['post_type'] ) {

        if ( ! current_user_can( 'edit_page', $post_id ) ) {
            return;
        }

    } else {

        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }
    }


    if ( ! isset( $_POST['video-url'] ) ) {
        return;
    }

    // Sanitize user input.

    $videoValue       = sanitize_text_field( $_POST['video-url'] );

    // Update the meta field in the database.
    update_post_meta( $post_id, 'video-url', $videoValue );

}
add_action( 'save_post', 'pixflow_video_blog_save_meta_box_data' );

function pixflow_audio_blog_add_meta_box() {

    $screens = array( 'post' );

    foreach ( $screens as $screen ) {

        add_meta_box(
            'blog_meta_box_audio_url',
            esc_attr__( 'Post Audio', 'massive-dynamic' ),
            'pixflow_audio_blog_meta_box_callback',
            $screen
        );
    }
}
add_action( 'add_meta_boxes', 'pixflow_audio_blog_add_meta_box' );

function pixflow_audio_blog_meta_box_callback( $post ) {

    wp_nonce_field( 'pixflow_audio_blog_save_meta_box_data', 'pixflow_audio_blog_meta_box_nonce' );

    $audioValue       = get_post_meta( $post->ID, 'audio-url', true );

    echo '<label for="audio-url">';
    esc_attr_e( 'Audio URL', 'massive-dynamic' );
    echo '</label>';
    echo '<input type="text" id="audio-url" name="audio-url" value="' . esc_attr( $audioValue ) . '" size="25" /><br/>';
}

function pixflow_audio_blog_save_meta_box_data( $post_id ) {


    if ( ! isset( $_POST['pixflow_audio_blog_meta_box_nonce'] ) ) {
        return;
    }

    if ( ! wp_verify_nonce( $_POST['pixflow_audio_blog_meta_box_nonce'], 'pixflow_audio_blog_save_meta_box_data' ) ) {
        return;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    // Check the user's permissions.
    if ( 'post' == $_POST['post_type'] ) {

        if ( ! current_user_can( 'edit_page', $post_id ) ) {
            return;
        }

    } else {

        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }
    }


    if ( ! isset( $_POST['audio-url'] ) ) {
        return;
    }

    // Sanitize user input.
    $audioValue       = sanitize_text_field( $_POST['audio-url'] );



    // Update the meta field in the database.
    update_post_meta( $post_id, 'audio-url', $audioValue );


}
add_action( 'save_post', 'pixflow_audio_blog_save_meta_box_data' );


function pixflow_blog_in_customizer_callback() {
    $url = admin_url().'customize.php?url='.urlencode(get_permalink(get_the_ID()));
    ?>
    <div class="back-to-customizer">
        <div class="left-side">
            <h1 class="title">Continue building your website in<span>MASSIVE BUILDER</span></h1>
            <p class="description">If you change website settings, it will affect other pages too.<br> To have a custom layout for all blog posts, choose unique settings.</p>
        </div>
        <div class="right-side">
            <a class="button" href="<?php echo esc_url($url); ?>">Live Edit This Page</a>
            <a target="_blank" href="http://support.pixflow.net" class="help"></a>
        </div>
    </div>
<?php
}