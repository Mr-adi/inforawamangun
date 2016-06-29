<div class="loop-post-content">
    <blockquote>
        <?php
        $content = apply_filters('the_content',strip_shortcodes(get_the_content(esc_attr__('keep reading', 'massive-dynamic'))));
        echo $content;
        ?>
        <div class="name"><?php the_title(); ?></div>
    </blockquote>
</div>

<?php
if( get_adjacent_post(true,'',true)==''){
    ?><hr class="loop-bottom-seprator-without-border" />
<?php }?>