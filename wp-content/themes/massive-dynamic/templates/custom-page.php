<?php
if ( $leftHeader ){
        get_template_part( 'templates/left-header' );
}

if($fullSidebar){
    //if sidebar is right sidebar then add class right to it
    ?>

    <div id="full-sidebar"><?php get_sidebar(); ?></div>

<?php
}
?>

<div class="right-sec">

    <?php
        // Normal Header
        if ( !$leftHeader ){

            get_template_part( 'templates/header' );
        }
    ?>

    <div class="row">

        <div class="<?php echo esc_attr($contentClass); ?>"></div>

        <?php

        //Normal Sidebar
        //if sidebar is right sidebar then add class right to it
        if(!$fullSidebar && $sidebar){ ?>

            <div id="sidebar" class="<?php echo esc_attr($sidebarClass); ?>"><?php get_sidebar(); ?></div>

        <?php   }  ?>
    </div>

    <?php get_footer(); ?>

</div>
