<?php
/**
 * Empty cart page
 *
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

wc_print_notices();

?>

<div class="empty-cart-container">
    
    <div class="empty-cart-icon-container"></div>
    
    <p class="cart-empty"><?php esc_attr_e( 'YOUR CART IS EMPTY !', 'massive-dynamic' ) ?></p>
    

    <?php do_action( 'woocommerce_cart_is_empty' ); ?>

    <p class="return-to-shop"><a class="button wc-backward" href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>"><?php esc_attr_e( 'Return To Shop', 'massive-dynamic' ) ?></a></p>


</div>
