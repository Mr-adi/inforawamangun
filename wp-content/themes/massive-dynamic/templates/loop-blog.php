<div class="isotope posts clearfix box_size">
    <?php

    while(have_posts())
    {
        the_post();

        global $post;
        $format = get_post_format();

        if ( false === $format )
            $format = 'standard';
        ?>
        <article <?php post_class('item clearfix'); ?> >
            <div class="small-thumb">
                <?php get_template_part( 'templates/loop', "blog-$format" ); ?>
            </div>

        </article>
    <?php } ?>
</div>