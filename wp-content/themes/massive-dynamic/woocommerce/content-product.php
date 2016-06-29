<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product, $woocommerce_loop;

// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) ) {
	$woocommerce_loop['loop'] = 0;
}

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) ) {
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );
}

// Ensure visibility
if ( ! $product || ! $product->is_visible() ) {
	return;
}

// Increase loop count
$woocommerce_loop['loop']++;

// Extra post classes
$classes = array();
if ( 0 === ( $woocommerce_loop['loop'] - 1 ) % $woocommerce_loop['columns'] || 1 === $woocommerce_loop['columns'] ) {
	$classes[] = 'first';
}
if ( 0 === $woocommerce_loop['loop'] % $woocommerce_loop['columns'] ) {
	$classes[] = 'last';
}
?>
<?php
global $product;
$attachment_ids = $product->get_gallery_attachment_ids();
$first_image = '';
foreach( $attachment_ids as $attachment_id )
{
    $image = wp_get_attachment_url( $attachment_id );
    $image = (false == $image)?PIXFLOW_PLACEHOLDER_BLANK:$image;
    $first_image =  $image_link = $image;
	break;
}
?>
<li <?php post_class( $classes ); ?> data-img="<?php echo esc_url($first_image); ?>">

	<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>
    <div class="purchase-buttom-holder">
        <?php do_action( 'woocommerce_before_shop_loop_item_title' ); ?>
        <?php do_action( 'woocommerce_after_shop_loop_item' ); ?>
    </div>
    <a class="title-link" href="">
        <?php
        /**
         * woocommerce_shop_loop_item_title hook
         *
         * @hooked woocommerce_template_loop_product_title - 10
         */
        do_action( 'woocommerce_shop_loop_item_title' );
        ?>
    </a>
    <?php
        /**
         * woocommerce_after_shop_loop_item_title hook
         *
         * @hooked woocommerce_template_loop_rating - 5
         * @hooked woocommerce_template_loop_price - 10
         */
        remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
        add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 11 );
        do_action( 'woocommerce_after_shop_loop_item_title' );

	?>

</li>
