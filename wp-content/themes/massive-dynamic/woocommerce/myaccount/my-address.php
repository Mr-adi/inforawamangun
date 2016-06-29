<?php
/**
 * My Addresses
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$customer_id = get_current_user_id();

if ( ! wc_ship_to_billing_address_only() && get_option( 'woocommerce_calc_shipping' ) !== 'no' ) {
	$page_title = apply_filters( 'woocommerce_my_account_my_address_title', esc_attr__( 'My Addresses', 'massive-dynamic' ) );
	$get_addresses = apply_filters( 'woocommerce_my_account_get_addresses', array(
		'billing' => esc_attr__( 'Billing Address', 'massive-dynamic' ),
		'shipping' => esc_attr__( 'Shipping Address', 'massive-dynamic' )
	), $customer_id );
} else {
	$page_title = apply_filters( 'woocommerce_my_account_my_address_title', esc_attr__( 'My Address', 'massive-dynamic' ) );
	$get_addresses    = apply_filters( 'woocommerce_my_account_get_addresses', array(
		'billing' =>  esc_attr__( 'Billing Address', 'massive-dynamic' )
	), $customer_id );
}

$col = 1;
?>

<?php if ( ! wc_ship_to_billing_address_only() && get_option( 'woocommerce_calc_shipping' ) !== 'no' ) echo '<div class="col2-set addresses">'; ?>

<?php foreach ( $get_addresses as $name => $title ) : ?>

	<div class="custom-edit-<?php echo esc_attr($name) ?> address">

		<h2 class="title">
			<h3><?php echo esc_attr($title); ?></h3>
		</h2>

		<address>
			<?php
			global $md_allowed_HTML_tags;

			$address = apply_filters( 'woocommerce_my_account_my_address_formatted_address', array(
					'first_name'  => get_user_meta( $customer_id, esc_attr($name) . '_first_name', true ),
					'last_name'   => get_user_meta( $customer_id, esc_attr($name) . '_last_name', true ),
					'company'     => get_user_meta( $customer_id, esc_attr($name) . '_company', true ),
					'address_1'   => get_user_meta( $customer_id, esc_attr($name) . '_address_1', true ),
					'address_2'   => get_user_meta( $customer_id, esc_attr($name) . '_address_2', true ),
					'city'        => get_user_meta( $customer_id, esc_attr($name) . '_city', true ),
					'state'       => get_user_meta( $customer_id, esc_attr($name) . '_state', true ),
					'postcode'    => get_user_meta( $customer_id, esc_attr($name) . '_postcode', true ),
					'country'     => get_user_meta( $customer_id, esc_attr($name) . '_country', true )
				), $customer_id, esc_attr($name) );

				$formatted_address = WC()->countries->get_formatted_address( $address );

				if ( ! $formatted_address )
					esc_attr_e( 'You have not set up this type of address yet.', 'massive-dynamic' );
				else
					echo wp_kses($formatted_address,$md_allowed_HTML_tags);

			?>
		</address>

		<a href="<?php echo wc_get_endpoint_url( 'edit-address', esc_attr($name) ); ?>" class="edit changed-target"> <?php esc_attr_e( 'Edit', 'massive-dynamic' ); ?> </a>

	</div>

<?php endforeach; ?>

<?php if ( ! wc_ship_to_billing_address_only() && get_option( 'woocommerce_calc_shipping' ) !== 'no' ) echo '</div>'; ?>
