<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
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

global $product;

?>
<div class="container-fluid phone-detail-sec" itemscope itemtype="<?php echo woocommerce_get_product_schema(); ?>" id="product-<?php the_ID(); ?>">
	<div class="card">
		<div class="container-fliud">
			<div class="wrapper row">
				<div class="preview col-md-4">
					<?php
						$attachment_ids = $product->get_gallery_attachment_ids();
						$html = '';
						if( isset($attachment_ids) && !empty($attachment_ids) ){
							$html .='<div class="preview-pic tab-content">';
							$i=0;
							foreach( $attachment_ids as $attachment_id ){
								$class = '';
								if( $i==0 ){
									$class = 'active';
								}
								$image_link = wp_get_attachment_url( $attachment_id );
								if( isset($image_link) && $image_link!='' ){
									$html .='<div class="tab-pane '.$class.'" id="pic-'.$i.'">
											<img src="'.$image_link.'" />
										</div>';
								}
								$i++;
							} 
							$html .='</div>';
							$html .='<ul class="preview-thumbnail nav nav-tabs">';
							$i=0;
							foreach( $attachment_ids as $attachment_id ){
								$class = '';
								if( $i==0 ){
									$class = 'active';
								}
								$image_link = wp_get_attachment_url( $attachment_id );
								if( isset($image_link) && $image_link!='' ){
									$html .='<li class="'.$class.'">
												<a data-target="#pic-'.$i.'" data-toggle="tab">
													<img src="'.$image_link.'" />
												</a>
											</li>';
								}
								$i++;
							} 
							$html .='</ul>';
							echo $html;
						}else{
							echo get_the_post_thumbnail( $product->id, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ) );
						}
					?>					  
					
				</div>
				<div class="details col-md-8">
					<h3 class="product-title"><?php echo $product->get_title(); ?></h3>
					<!--<div class="rating">
						<div class="stars">
							<span class="fa fa-star checked"></span>
							<span class="fa fa-star checked"></span>
							<span class="fa fa-star checked"></span>
							<span class="fa fa-star"></span>
							<span class="fa fa-star"></span>
						</div>
						<span class="review-no">Read Review</span>
					</div>-->
					<p class="product-description"><?php echo $product->get_description(); ?></p>
					<h4 class="price">current price: <span><?php echo wc_price($product->get_price()); ?></span></h4>
					<!--<p class="vote"><strong>91%</strong> of buyers enjoyed this product! <strong>(87 votes)</strong></p>-->
					
					<?php 
						do_action( 'woocommerce_single_product_summary' );
					?>
				</div>
			</div>
		</div>
	</div>
</div>


