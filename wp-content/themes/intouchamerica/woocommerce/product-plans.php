<?php

/*
 * Template Name:Plans
 */
 
 get_header();
  
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
<?php 
	$rate_content = get_field('rate_content',$post->ID);
	if( isset($rate_content) && $rate_content!='' ){
?>
<div class="rate-head">
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-12 text-center">
				<span><input type="checkbox" class="check-rate"><span class="rate-content"><?php echo $rate_content; ?></span> <img src="<?php echo get_template_directory_uri() ?>/assets/img/flag.jpg" class="flag"></span>
				
			</div>
		</div>
	</div>
</div>
<?php
	}
?>

<div class="choose-plan">
   	<div class="container-fluid">
    	<div class="row">
        	<div class="col-sm-8">
            	<div class="choose-plan-content">
					<?php
						$top_block_left = get_field( 'top_block_left',$post->ID );
						if( isset($top_block_left) && $top_block_left!='' ){
							echo $top_block_left;
						}
					?>                	
                </div>
            </div>
            <div class="col-sm-4">
            	<div class="right-main-content">
					<?php
						$top_block_right = get_field( 'top_block_right',$post->ID );
						if( isset($top_block_right) && $top_block_right!='' ){
							echo $top_block_right;
						}
					?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="new-pricing">
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-12">
				<?php
					$order_smartphone_plans = get_field('order_smartphone_plans',$post->ID);
					$i=1;
					foreach($order_smartphone_plans as $osp){
						$class = '';
						if( $i==3 ){
							$class = 'active-price';
						}
						
						$_product = wc_get_product( $osp );
						
						
						?>
						<div class="new-price-box <?php echo $class; ?>">
							<p class="main-price">
								<?php echo wc_price($_product->get_price()); ?>
							</p>
							<p class="m-acc">
								<?php echo $_product->get_title(); ?>
							</p>
							<p>
								<?php
									if( $i==3 ){
										echo '<img src="'.get_template_directory_uri().'/assets/img/free-light.jpg">';
									}else{
										echo '<img src="'.get_template_directory_uri().'/assets/img/free-dark.jpg">';
									}
								?>							
							</p>
							<?php echo $_product->get_description(); ?>
							 <p class="select-btn">							 
							 <?php echo apply_filters( 'woocommerce_loop_add_to_cart_link',
								sprintf( '<a href="%s" id="demo" rel="nofollow" data-product_id="%s" data-product_sku="%s" class="button %s product_type_%s">%s <i class="fa fa-plus"></i></a>',
									esc_url( $_product->add_to_cart_url() ),
									esc_attr( $_product->id ),
									esc_attr( $_product->get_sku() ),
									$_product->is_purchasable() ? 'custom_ajax_add_to_cart ajax_add_to_cart' : '',
									esc_attr( $_product->product_type ),
									esc_html( 'Select Plan' )
								),
							$_product );?>
							 </p>
							<?php
								if( $i==3 ){
									?>
									<p class="price-pos"><img src="<?php echo get_template_directory_uri() ?>/assets/img/price-pos.png"></p>
									<?php
								}
							?>
						</div>
						<?php
						$i++;
					}
				?>				
			</div>	
		</div>
	</div>
</div>

<div class="smart-value">
   	<div class="container-fluid">
    	<div class="row">
        	<div class="col-sm-12 text-center">
            	<h2>Smartphone value plans:</h2>
                <p>Exceptional Talk, Text & Data Plans on America's Best 4G Networks</p>
            </div>
        </div>
    </div>
</div>

<div class="new-pricing">
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-12">
				<?php
					$order_smartphone_value_plan = get_field('order_smartphone_value_plan',$post->ID);
					$i=1;
					foreach($order_smartphone_value_plan as $osvp){
						$class = '';
						if( $i==3 ){
							$class = 'active-price';
						}
						
						$_product = wc_get_product( $osvp );
						
						
						?>
						<div class="new-price-box <?php echo $class; ?>">
							<p class="main-price">
								<?php echo wc_price($_product->get_price()); ?>
							</p>
							<p class="m-acc">
								<?php echo $_product->get_title(); ?>
							</p>
							<p>
								<?php
									if( $i==3 ){
										echo '<img src="'.get_template_directory_uri().'/assets/img/free-light.jpg">';
									}else{
										echo '<img src="'.get_template_directory_uri().'/assets/img/free-dark.jpg">';
									}
								?>							
							</p>
							<?php echo $_product->get_description(); ?>
							 <p class="select-btn">							 
							 <?php echo apply_filters( 'woocommerce_loop_add_to_cart_link',
								sprintf( '<a href="%s" id="demo" rel="nofollow" data-product_id="%s" data-product_sku="%s" class="button %s product_type_%s">%s <i class="fa fa-plus"></i></a>',
									esc_url( $_product->add_to_cart_url() ),
									esc_attr( $_product->id ),
									esc_attr( $_product->get_sku() ),
									$_product->is_purchasable() ? 'custom_ajax_add_to_cart ajax_add_to_cart' : '',
									esc_attr( $_product->product_type ),
									esc_html( 'Select Plan' )
								),
								$_product );?>
							 </p>
							<?php
								if( $i==3 ){
									?>
									<p class="price-pos"><img src="<?php echo get_template_directory_uri() ?>/assets/img/price-pos.png"></p>
									<?php
								}
							?>
						</div>
						<?php
						$i++;
					}
				?>				
			</div>	
		</div>
	</div>
</div>

<?php
	$continue_shopping = get_field('continue_shopping',$post->ID);
	if( isset($continue_shopping) && $continue_shopping!='' ){
		?>
		<div class="continue-shoping text-center">
			<a href="<?php echo $continue_shopping; ?>">Continue</a>
		</div>
		<?php
	}
?>

<div class="features feature2">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 text-center">
				<h2>Included Features on all plans</h2>			   
			</div>
		</div>
		<div class="row categories">
			<div class="col-sm-4">
				<div class="box text-center">
					<?php
						$features_block_one = get_field('features_block_one',$post->ID);
						if( isset($features_block_one) && $features_block_one!='' ){
							echo $features_block_one;
						}
					?>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="box text-center">
					<?php
						$features_block_two = get_field('features_block_two',$post->ID);
						if( isset($features_block_two) && $features_block_two!='' ){
							echo $features_block_two;
						}
					?>
				</div>
			</div>
			<div class="col-sm-4 right_border">
				<div class="box text-center">
					<?php
						$features_block_three = get_field('features_block_three',$post->ID);
						if( isset($features_block_three) && $features_block_three!='' ){
							echo $features_block_three;
						}
					?>
				</div>
			</div>
		</div>
		
		<div class="row categories">
			<div class="col-sm-4 ">
				<div class="box text-center bottom_border ">
					<?php
						$features_block_four = get_field('features_block_four',$post->ID);
						if( isset($features_block_four) && $features_block_four!='' ){
							echo $features_block_four;
						}
					?>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="box text-center bottom_border">
					<?php
						$features_block_five = get_field('features_block_five',$post->ID);
						if( isset($features_block_five) && $features_block_five!='' ){
							echo $features_block_five;
						}
					?>
				</div>
			</div>
			<div class="col-sm-4 right_border">
				<div class="box text-center bottom_border">
					<?php
						$features_block_six = get_field('features_block_six',$post->ID);
						if( isset($features_block_six) && $features_block_six!='' ){
							echo $features_block_six;
						}
					?>
				</div>
			</div>
		</div>	
	</div>
</div>
<script>
	$('.step').each(function(index, el) {
		$(el).not('.active').addClass('done');
		$('.done').html('<i class="icon-valid"></i>');
		if($(this).is('.active')) {
			$(this).parent().addClass('pulse')
			return false;
		}
	});
</script>
 <?php
 get_footer();
