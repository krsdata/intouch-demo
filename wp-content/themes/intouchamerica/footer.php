<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.2
 */

?>

		</div><!-- #content -->

		<footer id="colophon" class="site-footer footer-main" role="contentinfo">
		<div class="footer">
				<?php
				get_template_part( 'template-parts/footer/footer', 'widgets' );

				if ( has_nav_menu( 'social' ) ) : ?>
					<nav class="social-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Footer Social Links Menu', 'twentyseventeen' ); ?>">
						<?php
							wp_nav_menu( array(
								'theme_location' => 'social',
								'menu_class'     => 'social-links-menu',
								'depth'          => 1,
								'link_before'    => '<span class="screen-reader-text">',
								'link_after'     => '</span>' . twentyseventeen_get_svg( array( 'icon' => 'chain' ) ),
							) );
						?>
					</nav><!-- .social-navigation -->
				<?php endif;

				get_template_part( 'template-parts/footer/site', 'info' );
				?>
			</div>
		</footer><!-- #colophon -->
	</div><!-- .site-content-contain -->
</div><!-- #page -->
<?php wp_footer(); ?>

    <!-- Include all compiled plugins (below), or include individual files as needed -->
	<script src="https://use.fontawesome.com/a832a5b49f.js"></script>
       <script>
    
        jQuery('.toBottom').click(function() {
        if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'')
            || location.hostname == this.hostname) {

            var target = jQuery(this.hash);
            target = target.length ? target : jQuery('[name=' + this.hash.slice(1) +']');
               if (target.length) {
                 jQuery('html,body').animate({
                     scrollTop: target.offset().top
                }, 1000);
                return false;
            }
        }
    });
    
    
        jQuery( document ).ready(function($) {
            $('#nav_fix').affix({
                offset: {
                    top: 100    
                }
            });
			
			/* highlight the top nav as scrolling occurs */ 
			$('body').scrollspy({ target: '#nav_fix' });
			
			$('.step').each(function(index, el) {
				$(el).not('.active').addClass('done');
				$('.done').html('<i class="icon-valid"></i>');
				if($(this).is('.active')) {
					$(this).parent().addClass('pulse')
					return false;
				}
			});

			var $content = $(".content").hide();
			$(".toggle").on("click", function(e){
				$(this).toggleClass("expanded");
				$content.slideToggle();
			});
			
			$( ".cart-toggle" ).click(function() {
				$( ".show-toggle" ).toggle( "slow" );
			});
			
			$( ".contact_button" ).click(function() {
			  $( ".contact_menu" ).toggle( "slow" );
			});
			
			$( ".menu_button" ).click(function() {
			  $( ".menu_menu" ).toggle( "slow" );
			});
			
        });
</script>
</body>
</html>
