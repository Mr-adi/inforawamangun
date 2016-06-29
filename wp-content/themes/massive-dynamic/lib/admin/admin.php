<?php

// Embed pixflow metabox to theme, so we deactivate pixflow metabox anymore
if( defined('PX_Metabox_VER') ){
    deactivate_plugins( WP_PLUGIN_DIR.'/pixflow-metabox/pixflow-metabox.php' );
}

/**
 * Include Vafpress Framework
 */
require_once PIXFLOW_THEME_ADMIN.'/bootstrap.php';

/**
 * Include Custom Data Sources
 */
require_once PIXFLOW_THEME_ADMIN.'/data_sources.php';
/*
 * EOF
 */