<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
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
 * @version     2.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

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
						<li><div class="step" data-desc="Phones">2</div></li>
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
<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">
<div class="checkout-section">
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-8">
				<div class="contact-info">
					<h3>Please Fill Your Contact Information</h3>
					<?php do_action( 'woocommerce_checkout_billing' ); ?>
					<p class="colored-text"><a href="#">Why do we need this info?</a></p>
				</div>
				
				<div class="contact-info prefrence-info">
					<h3>Please Fill YOUR BILLING PREFERENCE</h3>
					<div class="form-group">
						<label for="inputEmail">How would you like to pay?  <a href="#">Learn More ?</a></label>
						<div class="check-select-prefrence">
							<span class="button-checkbox check-preference">
								<button type="button" class="btn btn-lg btn-primary" data-color="primary"><i class="state-icon glyphicon glyphicon-unchecked"></i>&nbsp;Pay by Check or Card</button>
								<input type="checkbox" class="hidden" name="billing_pre[]" value="Pay by Check or Card">
							</span>
						</div>
						<div class="check-select-prefrence">
							<span class="button-checkbox check-preference">
								<button type="button" class="btn btn-lg btn-primary" data-color="primary"><i class="state-icon glyphicon glyphicon-unchecked"></i>&nbsp;AutoPay</button>
								<input type="checkbox" class="hidden" unchecked="" name="billing_pre[]" value="AutoPay">
							</span>
						</div>
					</div>
					
					<div class="form-group">
						<label for="inputEmail">How would you like to receive your invoice?  <a href="#">Learn More ?</a></label>
						<div class="check-select-prefrence">
							<span class="button-checkbox check-preference">
								<button type="button" class="btn btn-lg btn-primary active" data-color="primary"><i class="state-icon glyphicon glyphicon-unchecked"></i>&nbsp;Email Billing</button>
								<input type="checkbox" class="hidden" name="invoice_pre[]" value="Email Billing">
							</span>
						</div>
						<div class="check-select-prefrence">
							<span class="button-checkbox check-preference">
								<button type="button" class="btn btn-lg btn-primary active" data-color="primary"><i class="state-icon glyphicon glyphicon-unchecked"></i>&nbsp;Extended Detailed Billing ($2.00)</button>
								<input type="checkbox" class="hidden" name="invoice_pre[]" value="Extended Detailed Billing ($2.00)">
							</span>
						</div>
						<div class="check-select-prefrence">
							<span class="button-checkbox check-preference">
								<button type="button" class="btn btn-lg btn-primary active" data-color="primary"><i class="state-icon glyphicon glyphicon-unchecked"></i>&nbsp;Standard Paper Invoicing</button>
								<input type="checkbox" class="hidden" name="invoice_pre[]" value="Standard Paper Invoicing">
							</span>
						</div>
					</div>
					
					<p><b>NOTE:</b> Your name will appear on your invoice above your address.</p>
					<p class="colored-text"><a href="#">Why do we need this info?</a></p>
					
				</div>
				
				<div class="contact-info prefrence-info">
						<h3>Please Fill YOUR SHIPPING INFORMATION</h3>
						
							<div class="form-group">
								<label for="inputEmail">Shipping Address</label>
								<div class="check-select-prefrence">
									<span class="button-checkbox check-preference">
										<button type="button" class="btn btn-lg btn-primary active" data-color="primary"><i class="state-icon glyphicon glyphicon-unchecked"></i>&nbsp;Same as billing address</button>
										<input type="checkbox" class="hidden" name="shipping_pre[]" value="Same as billing address">
									</span>
								</div>
								<p><b>NOTE:</b> Your name will appear on your invoice above your address.</p>
								
							</div>
							<div class="form-group">
								<label for="inputEmail">Shipping Address</label>
								<div class="check-select-prefrence">
									<span class="button-checkbox check-preference">
										<button type="button" class="btn btn-lg btn-primary active" data-color="primary"><i class="state-icon glyphicon glyphicon-unchecked"></i>&nbsp;Priority: 3-5 days (FREE)</button>
										<input type="checkbox" class="hidden" name="shipping_pre[]" value="Priority: 3-5 days (FREE)">
									</span>
								</div>
								<p>* All Express orders completed by 1:00 pm (PDT), Monday – Friday should be shipped the same day. Orders completed 
after this time will be shipped the following business day. Express orders do not ship on Saturday, Sunday or holidays.</p>
<p><b>NOTE:</b> Delivery time frames are based on USPS estimates. Shipments aren’t guaranteed
to arrive within the expressed range.</p>
								
							</div>
													
					</div>
					
					<div class="contact-info prefrence-info">
						<h3>Please Fill YOUR SHIPPING INFORMATION</h3>
						
							<div class="form-group">
								<label for="inputEmail">How did you hear about us?	</label>
								<div class="check-select-prefrence">
									<select class="selectpicker" name="shipping_info[]">
										<option value="Select Your Message Here">Select Your Message Here</option>
										<option value="Select Your Message Here">Select Your Message Here</option>
										<option value="Select Your Message Here">Select Your Message Here</option>
										<option value="Select Your Message Here">Select Your Message Here</option>
										<option value="Select Your Message Here">Select Your Message Here</option>
									</select>
								</div>
								
							</div>
							<div class="form-group">
								<label for="inputEmail">Would you like to receive our monthly e-newsletter?</label>
								<div class="check-select-prefrence">
									<span class="button-checkbox check-preference">
										<button type="button" class="btn btn-lg btn-primary active" data-color="primary"><i class="state-icon glyphicon glyphicon-unchecked"></i>&nbsp;Yes</button>
										<input type="checkbox" class="hidden" unchecked="" name="newsletter[]" value="Yes">
									</span>
								</div>
								<div class="check-select-prefrence">
									<span class="button-checkbox check-preference">
										<button type="button" class="btn btn-lg btn-primary active" data-color="primary"><i class="state-icon glyphicon glyphicon-unchecked" ></i>&nbsp;No</button>
										<input type="checkbox" class="hidden" name="newsletter[]" value="no">
									</span>
								</div>
								
								
							</div>
							<div class="form-group">
								<label for="inputEmail">Were you referred by someone?</label>
								<div class="check-select-prefrence">
									<span class="button-checkbox check-preference">
										<button type="button" class="btn btn-lg btn-primary active" data-color="primary"><i class="state-icon glyphicon glyphicon-unchecked"></i>&nbsp;Yes</button>
										<input type="checkbox" class="hidden" name="referred[]" value="Yes">
									</span>
								</div>
								<div class="check-select-prefrence">
									<span class="button-checkbox check-preference">
										<button type="button" class="btn btn-lg btn-primary active" data-color="primary" name="shipping_info[]" value="No"><i class="state-icon glyphicon glyphicon-unchecked"></i>&nbsp;No</button>
										<input type="checkbox" class="hidden" name="referred[]" value="No">
									</span>
								</div>
								<p class="colored-text"><a href="#">AARP Member or want to join AARP? Click here.</a></p>
								
							</div>
						
					</div>
					
				<div class="contact-info prefrence-info card-detail">
					<h3>PAY FOR YOUR ORDER</h3>					
					<div id="order_review" class="woocommerce-checkout-review-order">
						<?php do_action( 'woocommerce_checkout_order_review' ); ?>
					</div>						
				</div>				
			</div>
			<div class="col-sm-4 check-side-cart">
				<div class="show-toggle">
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
				<div class="vete">
					<img src="<?php echo get_template_directory_uri(); ?>/assets/img/vete.jpg" alt="">
				</div>
				<div class="vete">
					<img src="<?php echo get_template_directory_uri(); ?>/assets/img/bbb-header-main.jpg" alt="">
				</div>
				<div class="vete">
					<img src="<?php echo get_template_directory_uri(); ?>/assets/img/other-pic.png" alt="">
				</div>
			</div>
		</div>
	</div>
</div>
</form>

<script>
jQuery(function ($) {	

    $('.button-checkbox').each(function () {

        // Settings
        var $widget = $(this),
            $button = $widget.find('button'),
            $checkbox = $widget.find('input:checkbox'),
            color = $button.data('color'),
            settings = {
                on: {
                    icon: 'glyphicon glyphicon-check'
                },
                off: {
                    icon: 'glyphicon glyphicon-unchecked'
                }
            };

        // Event Handlers
        $button.on('click', function () {
            $checkbox.prop('checked', !$checkbox.is(':checked'));
            $checkbox.triggerHandler('change');
            updateDisplay();
        });
        $checkbox.on('change', function () {
            updateDisplay();
        });

        // Actions
        function updateDisplay() {
            var isChecked = $checkbox.is(':checked');

            // Set the button's state
            $button.data('state', (isChecked) ? "on" : "off");

            // Set the button's icon
            $button.find('.state-icon')
                .removeClass()
                .addClass('state-icon ' + settings[$button.data('state')].icon);

            // Update the button's color
            if (isChecked) {
                $button
                    .removeClass('btn-default')
                    .addClass('btn-' + color + ' active');
            }
            else {
                $button
                    .removeClass('btn-' + color + ' active')
                    .addClass('btn-default');
            }
        }

        // Initialization
        function init() {

            updateDisplay();

            // Inject the icon if applicable
            if ($button.find('.state-icon').length == 0) {
                $button.prepend('<i class="state-icon ' + settings[$button.data('state')].icon + '"></i> ');
            }
        }
        init();
    });
});
</script>
