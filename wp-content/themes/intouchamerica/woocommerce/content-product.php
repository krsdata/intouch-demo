<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
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
 * @version 2.6.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

// Ensure visibility
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}

?>
<div class="col-sm-3">
	<div class="phone-box">		
		<?php
			do_action( 'woocommerce_before_shop_loop_item_title' );
			
			$title = $product->get_title();
			if( isset($title) && $title!='' ){
				echo '<h3>'.$title.'</h3>';
			}
		?>
		<!--<p>
			<span>
				<i class="fa fa-star"></i>
			</span> 
			<span>
				<i class="fa fa-star"></i>
			</span> 
			<span>
				<i class="fa fa-star"></i>
			</span> 
			<span>
				<i class="fa fa-star"></i>
			</span> 
			<span>
				<i class="fa fa-star"></i>
			</span> 
			<span class="r-review">
				<a href="#">Read Review</a>
			</span>			
		</p>-->
		<p class="price-phone">
			<?php echo wc_price($product->get_price()); ?>
		</p>
		<div class="phone-btn">
			<a data-toggle="modal" data-target="#myModal<?php echo $product->id; ?>">View Detail</a> 
			<a href="<?php echo get_the_permalink($product->id); ?>">Add to cart</a> 
		</div>
	</div>		
</div>
<div class="modal fade" id="myModal<?php echo $product->id; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">SPECIFICATIONS</h4>
			</div>
			<div class="modal-body">
				<?php wc_get_template_part( 'content-single', 'product' ); ?>
			</div>
		</div>
	</div>
</div>
