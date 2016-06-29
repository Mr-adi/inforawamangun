<?php
/**
 * My Account page
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

wc_print_notices(); ?>

<article class="account-title">
	<h1><?php esc_attr_e('My Account','massive-dynamic'); ?></h1>
	<h3><?php esc_attr_e('Register as a new author or login','massive-dynamic'); ?></h3>
	<a class="public-logout" href="<?php echo esc_url($aa = wc_get_endpoint_url( 'customer-logout', '', wc_get_page_permalink( 'myaccount' ) )); ?>" ><?php esc_attr_e('LOGOUT','massive-dynamic'); ?></a>
</article>

<div class="left-col">

	<div class="tabs account-pass active"> <?php esc_attr_e('Account / Password','massive-dynamic'); ?> </div>

	<div class="tabs billing-address"> <?php esc_attr_e('Billing Address','massive-dynamic'); ?> </div>

	<div class="tabs shipping-address"> <?php esc_attr_e('Shipping Address','massive-dynamic'); ?> </div>

</div>

<div class="right-col">

	<div class="custom-edit-pass-account active">

		<p class="myaccount_user">
			<?php
				printf(
					esc_attr__( 'Hello', 'massive-dynamic' ).' <italic>%1$s.</italic>  ',
					$current_user->display_name,
					wc_get_endpoint_url( 'customer-logout', '', wc_get_page_permalink( 'myaccount' ) )
				);
			?>
		</p>

		<p>
			<?php
				echo '<br />';

				printf( esc_attr__( ' From your account dashboard you can view your recent orders, manage your shipping and billing addresses.', 'massive-dynamic' ),
					wc_customer_edit_account_url()
				);
			?>
		</p>

		<?php printf(  ' <a class="edit changed-target" href="%s">'.esc_attr__('Edit Password / Account', 'massive-dynamic' ).' </a>', wc_customer_edit_account_url() ); ?>

	</div> <!-- end edit pass account -->

	<div class="edit-billing">

		<?php wc_get_template( 'myaccount/my-address.php' ); ?>

	</div>

</div>

<?php do_action( 'woocommerce_before_my_account' ); ?>

<?php wc_get_template( 'myaccount/my-downloads.php' ); ?>

<?php wc_get_template( 'myaccount/my-orders.php', array( 'order_count' => $order_count ) ); ?>

<?php do_action( 'woocommerce_after_my_account' ); ?>
