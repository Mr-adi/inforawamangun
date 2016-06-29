<?php
/**
 * Displayed when no products are found matching the current query
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/no-products-found.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see 	    http://docs.woothemes.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>
<Div class="md-woocommerce-info">

	<p class="md-empty-category-title"><?php esc_attr_e( 'SORRY !', 'massive-dynamic' ); ?></p>

	<p class="md-empty-category-subtitle"><?php esc_attr_e( 'THERE\'S NOTHING ASSIGNED TO THIS CATEGORY', 'massive-dynamic' ); ?></p>

	<div id="empty-cart-page-button" class="shortcode-btn ">
        
		<a class="button fade-oval button-standard button-56c16404cab01" href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>" target="_self"><i class="button-icon icon-angle-left"></i><span><?php esc_attr_e('BACK TO SHOP','massive-dynamic'); ?></span></a>
        
	</div>

</div>

<style>.page-title{display:none;}</style>
