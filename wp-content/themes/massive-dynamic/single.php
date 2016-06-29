<?php
/**
 * Template for displaying all single posts.
 */

$postType = get_post_type();
if ($postType == 'portfolio'){
    pixflow_generate_page('single-portfolio');
}elseif ($postType == 'post'){

    pixflow_generate_page('single-post');
}