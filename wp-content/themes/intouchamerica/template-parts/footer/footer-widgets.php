<?php
/**
 * Displays footer widgets if assigned
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

?>
<div class="container">
        	<div class="row">
<?php
if ( is_active_sidebar( 'sidebar-2' ) ||
	 is_active_sidebar( 'sidebar-3' ) || is_active_sidebar( 'sidebar-6' ) || is_active_sidebar( 'sidebar-7' ) ) :
?>

	<aside class="widget-area" role="complementary">
		<?php
		if ( is_active_sidebar( 'sidebar-2' ) ) { ?>
			<div class="col-sm-2 block">
				<?php dynamic_sidebar( 'sidebar-2' ); ?>
			</div>
		<?php }
		if ( is_active_sidebar( 'sidebar-3' ) ) { ?>
			<div class="col-sm-2 block">
				<?php dynamic_sidebar( 'sidebar-3' ); ?>
			</div>
		<?php } ?>
		<div class="col-sm-3 block">
		<?php dynamic_sidebar( 'sidebar-6' ); ?>
		</div>
		<?php dynamic_sidebar( 'sidebar-7' ); ?>
	</aside><!-- .widget-area -->

<?php endif; ?>
</div>
</div>