<?php
$format = get_post_format();
if ( false === $format )
    $format = 'standard';
get_template_part( 'templates/single', "post-$format" );
wp_link_pages(array('echo'=>1));
