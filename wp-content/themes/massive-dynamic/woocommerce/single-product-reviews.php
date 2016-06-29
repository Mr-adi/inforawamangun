<?php
/**
 * Display single product reviews (comments)
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.2
 */
global $product;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! comments_open() ) {
	return;
}

?>
<div id="reviews">
	<div id="comments">

		<?php if ( have_comments() ) : ?>

			<ol class="commentlist">
				<?php wp_list_comments( apply_filters( 'woocommerce_product_review_list_args', array( 'callback' => 'woocommerce_comments' ) ) ); ?>
			</ol>

			<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
				echo '<nav class="woocommerce-pagination">';
				paginate_comments_links( apply_filters( 'woocommerce_comment_pagination_args', array(
					'prev_text' => '&larr;',
					'next_text' => '&rarr;',
					'type'      => 'list',
				) ) );
				echo '</nav>';
			endif; ?>

		<?php else : ?>

			<p class="woocommerce-noreviews"><?php esc_attr_e( 'There are no reviews yet.', 'massive-dynamic' ); ?></p>

		<?php endif; ?>
	</div>

	<?php if ( get_option( 'woocommerce_review_rating_verification_required' ) === 'no' || wc_customer_bought_product( '', get_current_user_id(), $product->id ) ) : ?>

		<div id="review_form_wrapper">
			<div id="review_form">
				<?php
					$commenter = wp_get_current_commenter();

					$comment_form = array(
						'title_reply'          => have_comments() ? esc_attr__( 'Add a review', 'massive-dynamic' ) : esc_attr__( 'Be the first to review', 'massive-dynamic' ) . ' &ldquo;' . get_the_title() . '&rdquo;',
						'title_reply_to'       => esc_attr__( 'Leave a Reply to %s', 'massive-dynamic'),
						'comment_notes_before' => '',
						'comment_notes_after'  => '',
						'fields'               => array(
							'author' => '<p class="comment-form-author">' .
							            '<input id="author" placeholder="' . esc_attr__( 'Name *', 'massive-dynamic' ) . '" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" aria-required="true" /></p>',
							'email'  => '<p class="comment-form-email">' .
							            '<input id="email" name="email" placeholder="' . esc_attr__( 'Email *', 'massive-dynamic' ) . '" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30" aria-required="true" /></p>',
						),
						'label_submit'  => esc_attr__( 'Submit Review', 'massive-dynamic' ),
						'logged_in_as'  => '',
						'comment_field' => '',
						'class_submit'  => 'pixflow-wc-submit',
					);

					if ( $account_page_url = wc_get_page_permalink( 'myaccount' ) ) {
						$comment_form['must_log_in'] = '<p class="must-log-in">' .  sprintf( wp_kses( __(  'You must be <a href="%s">logged in</a> to post a review.', 'massive-dynamic' ),array('a' => array('href' => array()))), esc_url( $account_page_url ) ) . '</p>';
					}

                    $comment_form['comment_field'] = '<p class="comment-form-comment"><label for="comment"></label><textarea placeholder="' . esc_attr__( 'Your Review', 'massive-dynamic' ) . '" id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></p>';

					if ( get_option( 'woocommerce_enable_review_rating' ) === 'yes' ) {
						$comment_form['comment_field'] .= '<p class="comment-form-rating"><label for="rating">' . esc_attr__( 'Your Rating', 'massive-dynamic' ) .'</label><select name="rating" id="rating">
							<option value="">' . esc_attr__( 'Rate&hellip;', 'massive-dynamic' ) . '</option>
							<option value="5">' . esc_attr__( 'Perfect', 'massive-dynamic' ) . '</option>
							<option value="4">' . esc_attr__( 'Good', 'massive-dynamic' ) . '</option>
							<option value="3">' . esc_attr__( 'Average', 'massive-dynamic' ) . '</option>
							<option value="2">' . esc_attr__( 'Not that bad', 'massive-dynamic' ) . '</option>
							<option value="1">' . esc_attr__( 'Very Poor', 'massive-dynamic') . '</option>
						</select></p>';
					}

					comment_form( apply_filters( 'woocommerce_product_review_comment_form_args', $comment_form ) );
				?>
			</div>
		</div>

	<?php else : ?>

		<p class="woocommerce-verification-required"><?php esc_attr_e( 'Only logged in customers who have purchased this product may leave a review.', 'massive-dynamic' ); ?></p>

	<?php endif; ?>

	<div class="clear"></div>
</div>
