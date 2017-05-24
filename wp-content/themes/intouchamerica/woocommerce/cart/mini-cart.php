<?php
/**
 * Mini-cart
 *
 * Contains the markup for the mini-cart, used by the cart widget.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/mini-cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.5.0
 */
 global $woocommerce;

 $total = $woocommerce->cart->total;
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if( check_plan_in_cart() ){
	echo '<div class="head-cart">
			<h3>PLANS & SERVICES Due Monthly</h3>
		</div>';
		
	cart_products('Plan');
}

if( check_phone_in_cart() ){
	echo '<div class="head-cart">
			<h3>Phone And Device</h3>
		</div>';
		
	cart_products('Phone');
}

if( isset($total) && $total > 0 ){
	echo '<div class="cart-detail">
			<div class="cart-left">
				<h4 class="total-text">Total Monthly Charges</h4>
			</div>
			<div class="cart-right">
				<h4 class="total-text">'.wc_price($total).'</h4>
			</div>
		</div>';
}

?>											
<div class="head-cart">
<h3>INVOICE CREDITS	Next Invoice</h3>
</div>
<div class="cart-detail">
<p><span>First Month Free</span>
Your order qualifies for our First
Month Free promotion! Talk and
Connect Plans, plus any additional
line fees, will be complimentary for
your first monthly billing cycle. We'll
apply this credit to your first invoice.</p>
</div>

<?php do_action( 'woocommerce_after_mini_cart' ); ?>
