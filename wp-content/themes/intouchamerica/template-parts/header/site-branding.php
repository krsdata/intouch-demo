<?php
/**
 * Displays header site branding
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

?>

<div class="header" id="nav_fix">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="logo">
                                <a href="
<?php echo site_url(); ?>" title="ixsolution"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.png" alt="ixsolution"></a>
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <?php if ( has_nav_menu( 'top' ) ) : ?>
                            	<div class="navbar-header">
								  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
									<img src="<?php echo get_template_directory_uri(); ?>/assets/images/burger.png" alt="menu">
								  </button>
								</div>
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<?php get_template_part( 'template-parts/navigation/navigation', 'top' ); ?>
				</div><!-- .wrap -->
		<?php endif; ?>
                
                        </div>
                    </div>
                </div>
            </div> <!--end header-->
<!-- <div class="site-branding">
	<div class="wrap">

		<?php the_custom_logo(); ?>

		<div class="site-branding-text">
			<?php if ( is_front_page() ) : ?>
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
			<?php else : ?>
				<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
			<?php endif; ?>

			<?php $description = get_bloginfo( 'description', 'display' );
				if ( $description || is_customize_preview() ) : ?>
					<p class="site-description"><?php echo $description; ?></p>
				<?php endif; ?>
		</div> --><!-- .site-branding-text -->

		<!-- <?php if ( ( twentyseventeen_is_frontpage() || ( is_home() && is_front_page() ) ) && ! has_nav_menu( 'top' ) ) : ?>
		<a href="#content" class="menu-scroll-down"><?php echo twentyseventeen_get_svg( array( 'icon' => 'arrow-right' ) ); ?><span class="screen-reader-text"><?php _e( 'Scroll down to content', 'twentyseventeen' ); ?></span></a>
	<?php endif; ?> -->

	<!-- </div> --><!-- .wrap -->
<!-- </div> --><!-- .site-branding -->
