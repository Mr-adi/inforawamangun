<?php
while ( have_posts() ) {
    the_post();
    global $post;
?>
<div <?php post_class(); ?>>
    <div class="post-content">
        <?php
        get_template_part( 'templates/single', "post-meta" );
        get_template_part( 'templates/single', "post-author" );
        get_template_part( 'templates/single', "post-subscribe" );
        get_template_part( 'templates/single', "post-related" );
        ?>
    </div>
    <div class="comments">
        <?php comments_template('', true); ?>
    </div>
</div>
<?php } ?>