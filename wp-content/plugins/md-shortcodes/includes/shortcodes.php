<?php
function pixflow_vc_add_custom_fields() {
    if (!function_exists('vc_add_shortcode_param')){
		return false;
	}
	// add icon picker field to vc
    vc_add_shortcode_param('md_vc_slider', 'pixflow_vc_slider_field', PIXFLOW_THEME_LIB_URI . '/extendvc/js/all.js' );
    vc_add_shortcode_param('md_vc_url', 'pixflow_vc_url_field', PIXFLOW_THEME_LIB_URI . '/extendvc/js/all.js' );
    vc_add_shortcode_param('md_vc_multiselect', 'pixflow_vc_multiselect_field', PIXFLOW_THEME_LIB_URI . '/extendvc/js/all.js' );
    vc_add_shortcode_param('md_vc_checkbox', 'pixflow_vc_checkbox_field', PIXFLOW_THEME_LIB_URI . '/extendvc/js/all.js' );
    vc_add_shortcode_param('md_vc_description', 'pixflow_vc_description_field', PIXFLOW_THEME_LIB_URI . '/extendvc/js/all.js' );
    vc_add_shortcode_param('md_vc_separator', 'pixflow_vc_separator_field', PIXFLOW_THEME_LIB_URI . '/extendvc/js/all.js' );
    vc_add_shortcode_param('md_vc_gradientcolorpicker', 'pixflow_vc_gradientcolorpicker_field', PIXFLOW_THEME_LIB_URI . '/extendvc/js/all.js' );
    vc_add_shortcode_param('md_vc_colorpicker', 'pixflow_vc_colorpicker_field', PIXFLOW_THEME_LIB_URI . '/extendvc/js/all.js' );
    vc_add_shortcode_param('md_vc_iconpicker', 'pixflow_vc_iconpicker_field', PIXFLOW_THEME_LIB_URI . '/extendvc/js/all.js' );

}
add_action( 'admin_init', 'pixflow_vc_add_custom_fields');
add_action( 'admin_enqueue_scripts', 'pixflow_vc_add_custom_fields');
/*  MD Button */
add_shortcode('md_button', 'pixflow_sc_button');

/* Full Button */
add_shortcode('md_full_button', 'pixflow_sc_full_button');

/* Blog Carousel */
add_shortcode('md_blog_carousel', 'pixflow_sc_blog_carousel');

/* Call to Action */
add_shortcode('md_call_to_action', 'pixflow_sc_callToAction');

/*Accordion*/
add_shortcode('md_accordion', 'pixflow_sc_accordion');

/*Accordion Tab*/
add_shortcode('md_accordion_tab', 'pixflow_sc_accordion_tab');

/*Toggle*/
add_shortcode('md_toggle', 'pixflow_sc_toggle');

/*Toggle Tab*/
add_shortcode('md_toggle_tab', 'pixflow_sc_toggle_tab');

/*Business Toggle*/
add_shortcode('md_toggle2', 'pixflow_sc_toggle2');

/*Business Toggle Tab*/
add_shortcode('md_toggle_tab2', 'pixflow_sc_toggle_tab2');

/*Display Slider*/
add_shortcode('md_display_slider', 'pixflow_sc_display_slider');

/*Icon Box Top*/
add_shortcode('md_iconbox_top', 'pixflow_sc_iconbox_top');

/*Icon Box Side*/
add_shortcode('md_iconbox_side', 'pixflow_sc_iconbox_side');

/*Icon Box Side 2*/
add_shortcode('md_iconbox_side2', 'pixflow_sc_iconbox_side2');

/*Product Compare*/
add_shortcode('md_product_compare', 'pixflow_sc_product_compare');

/*Image Box Slider*/
add_shortcode('md_image_box_slider', 'pixflow_sc_imageBoxSlider');

/*Image Box Fancy*/
add_shortcode('md_image_box_fancy', 'pixflow_sc_imageBoxFancy');

/*Image Box Full*/
add_shortcode('md_imagebox_full', 'pixflow_sc_imagebox_full');

/*Tabs*/
add_shortcode('md_tabs', 'pixflow_sc_tabs');

/*Tab*/
add_shortcode('md_tab', 'pixflow_sc_tab');

/*Team Member Classic*/
add_shortcode('md_team_member_classic', 'pixflow_sc_teamMemberClassic');

/*Text*/
add_shortcode('md_text', 'pixflow_sc_text');

/*Column Text*/
add_shortcode('vc_column_text', 'vc_sc_column_text');

/*Modern Tabs*/
add_shortcode('md_modernTabs', 'pixflow_sc_modernTabs');

/*Modern Tab*/
add_shortcode('md_modernTab', 'pixflow_sc_modernTab');

/*Tablet Slider*/
add_shortcode('md_tablet_slider', 'pixflow_sc_tablet_slider');

/*Mobile Slider*/
add_shortcode('md_mobile_slider', 'pixflow_sc_mobile_slider');

/*Contact Form*/
add_shortcode('md_contactform', 'pixflow_sc_contactform');

/*Skill Style1*/
add_shortcode('md_skill_style1', 'pixflow_sc_skill_style1');

/*Skill Style2*/
add_shortcode('md_skill_style2', 'pixflow_sc_skill_style2');

/*Portfolio Multisize*/
add_shortcode('md_portfolio_multisize', 'pixflow_sc_portfolio_multisize');

/*Video*/
add_shortcode('md_video', 'pixflow_sc_video');

/*Showcase*/
add_shortcode('md_showcase','pixflow_sc_showcase');

/*Testimonial Classic*/
add_shortcode('md_testimonial_classic', 'pixflow_sc_testimonial_classic');

/*Testimonial Carousel*/
add_shortcode('md_testimonial_carousel', 'pixflow_sc_testimonial_carousel');

/*Client Normal*/
add_shortcode('md_client_normal', 'pixflow_sc_client_normal');

/*Clinet Carousel*/
add_shortcode('md_client_carousel', 'pixflow_sc_client_carousel');

/*Instagram*/
add_shortcode('md_instagram', 'pixflow_sc_instagram');

/*Blog*/
add_shortcode('md_blog', 'pixflow_sc_blog');

/*List*/
add_shortcode('md_list', 'pixflow_sc_list');

/*Process Steps*/
add_shortcode('md_process_steps', 'pixflow_sc_process_steps');

/*Music*/
add_shortcode('md_music', 'pixflow_sc_music');

/*Separator*/
add_shortcode('md_separator', 'pixflow_sc_separator');

/*Subscribe*/
add_shortcode('md_subscribe', 'pixflow_sc_subscribe');

/*Products Categories*/
add_shortcode('md_product_categories', 'pixflow_sc_product_categories');

/*Products*/
add_shortcode('md_products', 'pixflow_sc_products');

/*Products Carousel*/
add_shortcode('md_products_carousel', 'pixflow_sc_products_carousel');

/*Team Member 2*/
add_shortcode('md_teammember2', 'pixflow_sc_teamMemberCarousel');

/*Blog Masonry*/
add_shortcode('md_blog_masonry', 'pixflow_sc_blog_masonry');

/*Counter*/
add_shortcode('md_counter', 'pixflow_sc_counter');

/*Count Box*/
add_shortcode('md_countbox', 'pixflow_sc_countbox');

/*Horizontal Tabs*/
add_shortcode('md_hor_tabs', 'pixflow_sc_hor_tabs');

/*Horizontal Tab*/
add_shortcode('md_hor_tab', 'pixflow_sc_hor_tab');

/*Horizontal Tabs 2*/
add_shortcode('md_hor_tabs2', 'pixflow_sc_hor_tabs2');

/*Horizontal Tab 2*/
add_shortcode('md_hor_tab2', 'pixflow_sc_hor_tab2');

/*Price Table*/
add_shortcode('md_pricetabel', 'pixflow_sc_pricetable');

/*Pie Chart*/
add_shortcode('md_pie_chart', 'pixflow_sc_pie_chart');

/*Pie Chart 2*/
add_shortcode('md_pie_chart2', 'pixflow_sc_pie_chart_2');

/*Google Map*/
add_shortcode('md_google_map', 'pixflow_sc_google_map');

/*Master Slider*/
add_shortcode('md_masterslider', 'pixflow_sc_masterslider');

/*Blog Classic*/
add_shortcode('md_blog_classic', 'pixflow_sc_blog_classic');

/*Icon*/
add_shortcode('md_icon', 'pixflow_sc_icon');

/*Text Box*/
add_shortcode('md_textbox', 'pixflow_sc_textbox');

/*Fancy Text*/
add_shortcode('md_fancy_text', 'pixflow_sc_fancy_text');

/*Pixflow Slider*/
add_shortcode('md_slider', 'pixflow_sc_slider');

/*TextBox*/
add_shortcode('md_text_box', 'pixflow_sc_text_box');

/*Slider Carousel*/
add_shortcode('md_slider_carousel', 'pixflow_sc_slider_carousel');

/*Modern Subscribe*/
add_shortcode('md_modern_subscribe', 'pixflow_sc_modern_subscribe');

/*Pixflow Price Table*/
add_shortcode('md_price_table', 'pixflow_sc_price_table');

/*Double Slider*/
add_shortcode('md_double_slider', 'pixflow_sc_doubleSlider');

/*Revolution Slider*/
add_shortcode('md_rev_slider', 'pixflow_sc_rev_slider');
?>