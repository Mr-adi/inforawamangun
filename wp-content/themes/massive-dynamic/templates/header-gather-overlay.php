<?php
$logo = (pixflow_get_theme_mod('dark_logo',PIXFLOW_DARK_LOGO) == '') ? PIXFLOW_DARK_LOGO : pixflow_get_theme_mod('dark_logo',PIXFLOW_DARK_LOGO);
?>
<div class="gather-overlay">
    <div class="gather-btn">
        <span class="icon-close" ></span>
    </div>
    <a class="logo">
        <img src="<?php echo esc_url($logo); ?>"/>
    </a>
    <div class="menu">
        <nav class="navigation hidden-tablet hidden-phone" >
            <?php
            wp_nav_menu(array(
                'container' => '',
                'menu_class' => 'clearfix',
                'before' => '',
                'theme_location' => 'primary-nav',
                'walker' => new PixflowCustomNavWalker(),
                'fallback_cb' => false
            ));
            ?>
        </nav>
    </div>
</div>
