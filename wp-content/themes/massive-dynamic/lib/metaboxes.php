<?php
function pixflow_loadMetabox(){
    /**
     * Load options, metaboxes array templates.
     */

    // Portfolio meta boxes
    $tmpl_portfolio  = PIXFLOW_THEME_LIB . '/metabox/portfolio.php';
    $mb_portfolio = new VP_Metabox($tmpl_portfolio);
}
add_action('init', 'pixflow_loadMetabox',1);
