<?php 

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header( 'shop' ); 

 global $woocommerce;

 $total = $woocommerce->cart->total;

$top_banner = get_field('top_banner','option');
if( isset($top_banner) && $top_banner!='' ){
	?>
	<div class="sub-banner">
		<img src="<?php echo $top_banner; ?>" width="100%;">
	</div>
	<?php
}

$shop_id = woocommerce_get_page_id('shop');
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

<div class="choose-plan">
   	<div class="container-fluid">
    	<div class="row">
        	<div class="col-sm-8">
            	<div class="choose-plan-content">
					<?php
						if( isset($shop_id) && $shop_id!='' ){
							$top_block_left = get_field('top_block_left',$shop_id);
							if( isset($top_block_left) && $top_block_left!='' ){
								echo $top_block_left;
							}
						}						
					?>                	
                </div>
            </div>
            <div class="col-sm-4">
            	<div class="right-main-content">
					<?php 
						if( isset($shop_id) && $shop_id!='' ){
							$top_block_right = get_field('top_block_right',$shop_id);
							if( isset($top_block_right) && $top_block_right!='' ){
								echo $top_block_right;
							}
						}
					?>                	
                </div>
            </div>
        </div>
    </div>
</div>

<?php if ( have_posts() ) : ?>
	
	<div class="phone-device">
    	<div class="container-fluid">
			<div class="row">			

				<?php while ( have_posts() ) : the_post(); ?>

					<?php wc_get_template_part( 'content', 'product' ); ?>

				<?php endwhile; // end of the loop. ?>

			</div>
		</div>
	</div>

<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>

	<?php wc_get_template( 'loop/no-products-found.php' ); ?>

<?php endif; ?>

<?php get_footer( 'shop' ); ?>