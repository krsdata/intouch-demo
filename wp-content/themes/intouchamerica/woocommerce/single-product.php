<?php
/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header( 'shop' ); 

 $top_banner = get_field('top_banner','option');
 if( isset($top_banner) && $top_banner!='' ){
	?>
	<div class="sub-banner">
		<img src="<?php echo $top_banner; ?>" width="100%;">
	</div>
	<?php
 }
 
  global $woocommerce;

 $total = $woocommerce->cart->total;

?>
<div class="plan-process">
   	<div class="container-fluid">
    	<div class="row">
        	<div class="col-sm-8">
            	<div id="steps">
					<ul>
						<li><div class="step" data-desc="Plans">1</div></li>
						<li><div class="step active" data-desc="Phones">2</div></li>
						<li><div class="step" data-desc="Checkout">3</div></li>
						<!-- <li><div class="step" data-desc="Validation">4</div></li>
						<li><div class="step" data-desc="Payment">5</div></li>
						<li><div class="step" data-desc="Resume">6</div></li>-->
						<!--<li><div class="step" data-desc="Other">7</div></li> -->
					</ul>
				</div>
            </div>
            <div class="col-sm-4">
            	<div class="due-box">
					<span>
						Due Today 
						<?php 							
							if( isset($total) && $total > 0 ){
								echo wc_price($total);
							}else{
								echo wc_price(0);
							}
						?>
					</span>
                </div>
            
				<div class="due-box2">
					<span>
						Due Monthly
						<?php 							
							if( isset($total) && $total > 0 ){
								echo wc_price($total);
							}else{
								echo wc_price(0);
							}
						?>
					</span>
				</div>
				
				<div class="add-to-cart-btn">
					<button class="cart-toggle"><i class="fa fa-sort-desc" aria-hidden="true"></i> View Cart <i class="fa fa-sort-desc" aria-hidden="true"></i></button>
				</div>
				
				<div class="show-toggle" style="display:none">
					<?php
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
				</div>
            </div>
        </div>
    </div> 
</div>

	<?php while ( have_posts() ) : the_post(); ?>

		<?php wc_get_template_part( 'content', 'single-product' ); ?>

	<?php endwhile; // end of the loop. ?>

<?php get_footer( 'shop' ); ?>
