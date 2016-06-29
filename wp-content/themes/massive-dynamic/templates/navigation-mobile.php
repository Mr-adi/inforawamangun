<nav class="navigation-mobile <?php echo 'header-'.esc_attr(pixflow_get_theme_mod('header_responsive_skin',PIXFLOW_HEADER_RESPONSIVE_SKIN)); ?>">
    <?php
    wp_nav_menu(array(
        'container' =>'',
        'theme_location' => 'mobile-nav',
        'fallback_cb' => false,
        'walker'      => new PixflowCustomNavWalker('menu-item-mobile'),
    ));

    get_search_form();
    ?>
</nav>