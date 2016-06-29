<?php

/*********************Checkout*****************************/
function pixflow_woocommerceCheckout() {
    wp_enqueue_script('checkout_js', PIXFLOW_THEME_WOOCOMMERCE_URI . '/assets/js/checkout.js', array());
}

add_action( 'woocommerce_after_checkout_form', 'pixflow_woocommerceCheckout');

/*********************Single Product***********************/
function pixflow_woocommerceSingleProduct(){
    wp_enqueue_script('singleProduct_js',PIXFLOW_THEME_WOOCOMMERCE_URI .'/assets/js/single-product.js',array());
}

add_action('woocommerce_after_single_product', 'pixflow_woocommerceSingleProduct');

/*********************Cart***********************/
function pixflow_woocommerceCart() {
    wp_enqueue_script('cart_js', PIXFLOW_THEME_WOOCOMMERCE_URI . '/assets/js/cart.js', array());
}

add_action( 'woocommerce_after_cart_table', 'pixflow_woocommerceCart');

