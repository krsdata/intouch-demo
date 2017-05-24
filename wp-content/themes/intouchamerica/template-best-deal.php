<?php /* Template Name: BestDeal */ ?>
<?php get_header(); ?>
<?php // Show the selected frontpage content.
    if ( have_posts() ) :
        while ( have_posts() ) : the_post(); ?>
<div class="sub-banner">
        <?php echo get_the_post_thumbnail( $post_id, 'full' );  ?>
    </div>

<div class="third-section">
	<div class="container">
    	<div class="row">
        	<div class="col-sm-6">
            	<?php the_content(); ?>
            </div>
            <div class="col-sm-6">
            	<div class="third-form-in">
                	<div class="main-form">
                    	<h2>YES! I WANT TO LEARN MORE.</h2>
                    </div>
                    <?php echo do_shortcode('[contact-form-7 id="181" title="Best Deal"]'); ?>
                    <?php if ( is_active_sidebar( 'best_deal' ) ) { 
                     dynamic_sidebar( 'best_deal' );
                     } ?>
                    
                </div>
            </div>
        </div>
    </div>
</div>
<?php endwhile;
                endif; ?>
<?php get_footer(); ?>