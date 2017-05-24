/*!
 * WooCommerce Add to Cart JS
 */
jQuery( function( $ ) {

	/* global wc_add_to_cart_params */
	if ( typeof wc_add_to_cart_params === 'undefined' ) {
		return false;
	}

	// Ajax add to cart
	$( document ).on( 'click', '.custom_ajax_add_to_cart', function(e) {
		e.preventDefault();
		// AJAX add to cart request
		var $thisbutton = $( this );

		if ( $thisbutton.is( '.ajax_add_to_cart' ) ) {

			if ( ! $thisbutton.attr( 'data-product_id' ) ) {
				return true;
			}

			$thisbutton.removeClass( 'added' );
			$thisbutton.addClass( 'loading' );
			$thisbutton.find('fa-plus').css('display','none');
			$thisbutton.css('opacity','0.6');
			$thisbutton.html('Adding to cart...');

			var data = {};

			$.each( $thisbutton.data(), function( key, value ) {
				data[key] = value;
			});

			// Trigger event
			$( document.body ).trigger( 'adding_to_cart', [ $thisbutton, data ] );

			// Ajax action
			$.post( wc_add_to_cart_params.wc_ajax_url.toString().replace( '%%endpoint%%', 'add_to_cart' ), data, function( response ) {

				if ( ! response ) {
					return;
				}

				var this_page = window.location.toString();

				this_page = this_page.replace( 'add-to-cart', 'added-to-cart' );

				if ( response.error && response.product_url ) {
					alert("Only one plan can be select");
					$thisbutton.css('opacity','1');
					$thisbutton.html('Select Plan <i class="fa fa-plus"></i>');
					//window.location = response.product_url;
					return;
				}

					var c_data = {
					   'action': 'mode_theme_update_mini_cart'
					 };
					 $.post(
					   woocommerce_params.ajax_url, // The AJAX URL
					   c_data, // Send our PHP function
					   function(response){
						 $('.show-toggle').html(response); // Repopulate the specific element with the new content
					   }
					 );

					$thisbutton.removeClass( 'loading' );
					$thisbutton.css('opacity','1');
					$('.custom_ajax_add_to_cart').html('Select Plan <i class="fa fa-plus"></i>');
					$thisbutton.html('Added to cart <i class="fa fa-check"></i>');
					$thisbutton.find('fa-plus').css('display','none');
					$thisbutton.find('fa-check').css('display','block');

					var fragments = response.fragments;
					var cart_hash = response.cart_hash;

					// Block fragments class
					if ( fragments ) {
						$.each( fragments, function( key ) {
							$( key ).addClass( 'updating' );
						});
					}

					// Block widgets and fragments
					$( '.shop_table.cart, .updating, .cart_totals' ).fadeTo( '400', '0.6' ).block({
						message: null,
						overlayCSS: {
							opacity: 0.6
						}
					});

					// Changes button classes
					$thisbutton.addClass( 'added' );

					// View cart text
					/* if ( ! wc_add_to_cart_params.is_cart && $thisbutton.parent().find( '.added_to_cart' ).length === 0 ) {
						$thisbutton.after( ' <a href="' + wc_add_to_cart_params.cart_url + '" class="added_to_cart wc-forward" title="' +
							wc_add_to_cart_params.i18n_view_cart + '">' + wc_add_to_cart_params.i18n_view_cart + '</a>' );
					} */

					// Replace fragments
					if ( fragments ) {
						$.each( fragments, function( key, value ) {
							$( key ).replaceWith( value );
						});
					}

					// Unblock
					$( '.widget_shopping_cart, .updating' ).stop( true ).css( 'opacity', '1' ).unblock();

					// Cart page elements
					$( '.shop_table.cart' ).load( this_page + ' .shop_table.cart:eq(0) > *', function() {

						$( '.shop_table.cart' ).stop( true ).css( 'opacity', '1' ).unblock();

						$( document.body ).trigger( 'cart_page_refreshed' );
					});

					$( '.cart_totals' ).load( this_page + ' .cart_totals:eq(0) > *', function() {
						$( '.cart_totals' ).stop( true ).css( 'opacity', '1' ).unblock();
					});

					// Trigger event so themes can refresh other areas
					$( document.body ).trigger( 'added_to_cart', [ fragments, cart_hash, $thisbutton ] );
				
			});

			return false;

		}

		return true;
	});

});
