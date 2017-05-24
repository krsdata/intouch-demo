<?php
/*
Template Name: Best Deal
*/
get_header();
$banner_image = get_field('banner_image');
if(isset($banner_image) && $banner_image!='')
{
?>
<div class="sub-banner">
    	<img src="<?php echo $banner_image; ?>">
    </div>
<?php } ?>
	<div class="third-section">
    	<div class="container">
        	<div class="row">
            	<div class="col-sm-6">
				<?php if( have_rows('right_side_options') ): ?>
				<?php 
				while( have_rows('right_side_options') ): the_row(); 
				$label = get_sub_field('label');
				?>
                <p><?php echo $label; ?></p>
              	<?php endwhile; ?>
				<?php endif; ?>
                    <div class="detail-btn">
                    	<a href="<?php echo get_field( "details_of_month_link" );?>">Detail Of The Month</a>
                    </div>
					<?php $deal_image = get_field('best_deal_image');
					if(isset($deal_image) && $deal_image!='')
					{
					?>
                    <div class="third-device">
                    	<img src="<?php echo $deal_image; ?>">
                    </div>
					<?php } ?>
                </div>
                <div class="col-sm-6">
                	<div class="third-form-in best_deal_contact">
                    	<div class="main-form">
                        	<h2>YES! I WANT TO LEARN MORE.</h2>
                        </div>
						<div class="bestdealmian">
                        <?php echo do_shortcode('[contact-form-7 id="181" title="Contact Us Best Deal"]'); ?>
						</div>
                        <p class="third-form-content">
                        	Keep Your Same Phone Number Serving You For Nearly 30 Years Best 4G Unlimited Everything Plans CALL US: <b>(800) 500-0066</b>
                        </p>
                        <div class="brand-form-logo">
                        	<img src="<?php echo get_template_directory_uri()?>/assets/img/best-deal/bbb-header-main.jpg" alt="">
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php  get_footer();?>