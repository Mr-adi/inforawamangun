<?php
if(get_post_meta( get_the_ID(), 'author-section', true)== 'show'){
    global $img,$current_user,$firstName,$lastName,$description ;

    $postId=get_the_ID();
    $userName = get_the_author_meta('ID');

    $author = get_user_by('id',$userName);
    $authorID=get_userdata( $author->ID );

    $firstName= esc_attr($authorID->user_firstname);
    $lastName=esc_attr($authorID->user_lastname);
    $description=$authorID->description;
    $img=get_avatar( $authorID->user_email, 105 , '','Avatar' );
    $filter_img=wp_kses($img,array('img' => array('alt' => array(),'src' => array(),'srcset' => array(),'hieght' => array(),'width' => array())));

    ?>
    <div class="author-section">
        <p class="title"><?php esc_attr_e('Author','massive-dynamic'); ?></p>
        <hr class="line">

        <div class="clearfix"></div>
        <div class="image"><a href="<?php echo get_author_posts_url($author->ID); ?>"><?php  echo($filter_img);?></a></div>
        <div class="info">
            <p class="name"><a href="<?php echo get_author_posts_url($author->ID); ?>"><?php echo esc_attr($firstName).' '.esc_attr($lastName); ?></a></p>
            <p class="description"><?php echo esc_attr($description);?></p>
        </div>
        <div class="clearfix"></div>
    </div>
<?php } ?>