<?php
/**
 * Displays header media
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

?>
<div class="custom-header">
	<div class="top-bar">
		<div class="container">
			<div class="row">
				<div class="col-sm-6">
					<p><i class="fa fa-envelope"></i> &nbsp; name@domain.com</p> <p><i class="fa fa-phone"></i> &nbsp; 1800-1200-2365</p>
				</div>
				<div class="col-sm-6">
					<div class="pull-right">
					<p><a href="#" class="payment-btn">Payment</a></p><p><a href="#" class="payment-btn blue-btn">Languages</a></p>  <p class="top-icon"><a href="#"><i class="fa fa-search"></i></a> <a href="#"><i class="fa fa-facebook"></i></a> <a href="#"><i class="fa fa-twitter"></i></a> <a href="#"><i class="fa fa-linkedin"></i></a></p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- <div class="custom-header-media">
		<?php the_custom_header_markup(); ?>
	</div> -->

	<?php get_template_part( 'template-parts/header/site', 'branding' ); ?>

</div><!-- .custom-header -->
