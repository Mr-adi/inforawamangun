<?php if(( is_single() && pixflow_get_theme_mod('sidebar-switch-single',PIXFLOW_SIDEBAR_SWITCH_SINGLE)) ||
            (((is_front_page() && is_home()) ||  is_home() ) && pixflow_get_theme_mod('sidebar-switch-blog',PIXFLOW_SIDEBAR_SWITCH_BLOG))||
            (is_page() && pixflow_get_theme_mod('sidebar-switch',PIXFLOW_SIDEBAR_SWITCH))||
            ((in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' )))) && is_woocommerce()&& pixflow_get_theme_mod('sidebar-switch-shop',PIXFLOW_SIDEBAR_SWITCH_SHOP)) ){
                $sidebarId = '';
                if (is_single()) $sidebarId = "post-sidebar";
                elseif ( (is_front_page() && is_home()) ||  is_home()) $sidebarId = 'main-sidebar';
                elseif ( is_page() ) $sidebarId = 'page-sidebar' ;
                elseif ( is_woocommerce() ) $sidebarId = 'shop-sidebar';

                 pixflow_get_sidebar($sidebarId,'normal','border smart-sidebar hidden-desktop visible-tablet light-sidebar');

}?>
<div class="clearfix"></div>
<!--end of layout element-->
</div>
<!-- end of layout container -->
</div>

<!-- Go to top button -->
<?php
$goToTopButton = pixflow_get_theme_mod('go_to_top_status',PIXFLOW_GO_TO_TOP_STATUS);
$goToTopButtonClass = ( $goToTopButton == false || $goToTopButton == 'false')?' md-hidden':'';
?>
	<div class="go-to-top <?php echo esc_attr(pixflow_get_theme_mod('footer_section_gototop_skin',PIXFLOW_FOOTER_SECTION_GOTOTOP_SKIN).$goToTopButtonClass) ?>"></div>
	<!-- Theme Hook -->
	<?php
	wp_footer();
	?>

</body>
</html>
<?php
if(isset($_GET['vc_editable'])){
	unset($_SESSION['vc_temp_content']);
}
?>