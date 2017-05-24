=== YITH WooCommerce Authorize.net Payment Gateway ===

Contributors: yithemes
Tags: authorize.net, woocommerce, products, themes, yit, e-commerce, shop, payment gateway, yith, woocommerce authorize.net payment gateway, woocommerce 2.6 ready, credit card, authorize
Requires at least: 4.0.0
Tested up to: 4.5.3
Stable tag: 1.0.9
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

== Changelog ==

= 1.0.10 - Released: Aug, 01 - 2016 =

* Tweak: Added again payment method description to payment method form
* Tweak: updated plugin-fw
* Fixed: form requesting card details on Authorize.net payment method (redirect transaction type)

= 1.0.9 - Released: Jun, 17 - 2016 =

* Added WooCommerce 2.6 compatibility
* Added: WooCommerce 2.6 tokenization support
* Tweak: Switched authorize.net serve url to https://secure2.authorize.net/gateway/transact.dll (Akamai SureRoute production)
* Tweak: rmeove old Saved Cards template to use WooCommerce my-account endpoint

= 1.0.8 - Released: May, 05 - 2016 =

* Added: Support to WordPress 4.5.1
* Added: Support to WooCommerce 2.5.5
* Added: js code to keep user data through update_checkout process
* Tweak: Removed deprecated WC functions/methods
* Fixed: Phone field problem with CIM library
* Fixed: eCheck not passing transactionMode in XML request, causing transaction error
* Fixed: system always resetting default card when deleting one

= 1.0.7 - Released: Jan, 13 - 2016 =

* Added: yith essential kit 1 compatibility
* Added: option to customize "Pay button"
* Added: WC 2.5-RC Compatibility
* Added: WP 4.4 Compatibility
* Tweak: Performance improved with new plugin core 2.0

= 1.0.6 - Released: Aug, 13 - 2015 =

* Added: Compatibility with WP 4.2.4
* Added: Compatibility with WC 2.4.2
* Tweak: Updated internal plugin-fw

= 1.0.5 - Released: Jul, 03 - 2015 =

* Tweak: formatted order amount with number_format() function
* Tweak: formatted relay url with user_trailingslashit() function
* Fixed: Fingerprint calculation for SIM

= 1.0.4 - Released: Jun, 19 - 2015 =

* Added: WooCommerce 2.3.11
* Fixed: Fingerprint calculation for prices without decimals

= 1.0.3 - Released: May, 04 - 2015 =

* Fixed: "Plugin Documentation" link appearing on all plugins
* Fixed: minor bugs

= 1.0.2 - Released: Apr, 29 - 2015 =

* Added: handling for "Authorize only" transactions
* Fixed: escaped add_query_arg and remove_query_arg

= 1.0.1 - Released: Mar, 09 - 2015 =

* Fixed: minor fixes

= 1.0.0 - Released: Feb, 20 - 2015 =

* Initial release