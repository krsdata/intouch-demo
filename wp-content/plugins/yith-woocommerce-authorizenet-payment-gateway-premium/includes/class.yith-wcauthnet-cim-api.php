<?php
/*  Copyright 2013  Your Inspiration Themes  (email : plugins@yithemes.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/**
 * API handler class
 *
 * @author Your Inspiration Themes
 * @package YITH WooCommerce Authorize.net
 * @version 1.0.0
 */

if ( ! defined( 'YITH_WCAUTHNET' ) ) {
	exit;
} // Exit if accessed directly

if( ! class_exists( 'YITH_WCAUTHNET_CIM_API' ) ){
	/**
	 * WooCommerce Authorize.net CIM API handler class
	 *
	 * @since 1.0.0
	 */
	class YITH_WCAUTHNET_CIM_API {

		/**
		 * @const Sandbox payment url
		 */
		const AUTHORIZE_NET_XML_SANDBOX_PAYMENT_URL = 'https://apitest.authorize.net/xml/v1/request.api';

		/**
		 * @const Public payment url
		 */
		const AUTHORIZE_NET_XML_PRODUCTION_PAYMENT_URL = 'https://api2.authorize.net/xml/v1/request.api';

		/**
		 * @var string Whether or not we're using a development env
		 */
		public $sandbox;

		/**
		 * @var string Authorize.net Login ID
		 */
		public $login_id;

		/**
		 * @var string Authorize.net transaction key
		 */
		public $transaction_key;

		/**
		 * @var bool Whether or not transactions should be itemized
		 */
		public $itemized;

		/**
		 * @var bool whether or not transaction should handle payment profiles
		 */
		public $cim_handling;

		/**
		 * Single instance of the class
		 *
		 * @var \YITH_WCAUTHNET_CIM_API
		 * @since 1.0.0
		 */
		protected static $instance;

		/**
		 * Instance of the class XMLWriter, used to create xml request to server
		 *
		 * @var \XMLWriter
		 * @since 1.0.0
		 */
		protected $xml_writer = null;

		/**
		 * Returns single instance of the class
		 *
		 * @return \YITH_WCAUTHNET_CIM_API
		 * @since 1.0.0
		 */
		public static function get_instance(){
			if( is_null( self::$instance ) ){
				self::$instance = new self;
			}

			return self::$instance;
		}

		/**
		 * Constructor method
		 *
		 * @return \YITH_WCAUTHNET_CIM_API
		 * @since 1.0.0
		 */
		public function __construct() {
			$this->xml_writer = new XMLWriter();
		}

		/**
		 * Process a request to Authorize.net servers
		 *
		 * @param $xml string Xml to send through request
		 *
		 * @return string Xml response from the server
		 * @throws Exception
		 * @since 1.0.0
		 */
		public function do_request( $xml ){
			if( empty( $this->login_id ) || empty( $this->transaction_key ) ){
				return false;
			}

			if ( $this->sandbox ) {
				$process_url = self::AUTHORIZE_NET_XML_SANDBOX_PAYMENT_URL;
			}
			else {
				$process_url = self::AUTHORIZE_NET_XML_PRODUCTION_PAYMENT_URL;
			}

			$wp_http_args = array(
				'timeout'     => apply_filters( 'yith_wcauthnet_cim_api_timeout', 45 ),
				'redirection' => 0,
				'httpversion' => '1.0',
				'sslverify'   => false,
				'blocking'    => true,
				'headers'     => array(
					'accept'       => 'application/xml',
					'content-type' => 'application/xml' ),
				'body'        => $xml,
				'cookies'     => array(),
				'user-agent'  => "PHP " . PHP_VERSION
			);

			$response = wp_remote_post( $process_url, $wp_http_args );

			// Check for Network timeout, etc.
			if ( is_wp_error( $response ) ) {
				throw new Exception( $response->get_error_message() );
			}

			// return blank XML document if response body doesn't exist
			$response = ( isset( $response[ 'body' ] ) ) ? $response[ 'body' ] : '<?xml version="1.0" encoding="utf-8"?>';

			return $response;
		}

		/**
		 * Parse xml response from the server
		 *
		 * @param $response string XML response from the server
		 *
		 * @return \SimpleXMLElement Parsed xml
		 * @since 1.0.0
		 */
		public function parse_response( $response ) {
			// Remove namespace as SimpleXML throws warnings with invalid namespace URI provided by Authorize.net
			$response = preg_replace( '/[[:space:]]xmlns[^=]*="[^"]*"/i', '', $response );

			// LIBXML_NOCDATA ensures that any XML fields wrapped in [CDATA] will be included as text nodes
			$response = new SimpleXMLElement( $response, LIBXML_NOCDATA );

			return $response;
		}

		/**
		 * Execute a request for payment transaction, and return parsed response
		 *
		 * @param $order \WC_Order Order to pay
		 * @param $payment_details \StdClass Payment details
		 *
		 * @return \SimpleXMLElement Parsed xml
		 * @since 1.0.0
		 */
		public function create_payment_transaction( $order, $payment_details, $transaction_mode = 'authCaptureTransaction' ){
			$response = $this->do_request( $this->get_create_payment_transaction_xml( $order, $payment_details, $transaction_mode ) );

			if( ! $response ){
				return false;
			}

			return $this->parse_response( $response );
		}

		/**
		 * Execute a request for refund transaction, and return parsed response
		 *
		 * @param $order \WC_Order Order to refund
		 * @param $amount float Amount to refund
		 * @param $payment_details \StdClass Payment details, masked
		 *
		 * @return \SimpleXMLElement Parsed xml
		 * @since 1.0.0
		 */
		public function crete_refund_transaction( $order, $amount, $payment_details ) {
			$response = $this->do_request( $this->get_create_refund_transaction_xml( $order, $amount, $payment_details ) );

			if( ! $response ){
				return false;
			}

			return $this->parse_response( $response );
		}

		/**
		 * Execute a request for create customer profile, and return parsed response
		 *
		 * @param $user \WP_User User to map in Authorize.net servers
		 * @param $payment \StdClass|bool Payment details (false if no payment to add)
		 *
		 * @return \SimpleXMLElement Parsed xml
		 * @since 1.0.9
		 */
		public function create_customer_profile( $user, $payment = false ) {
			$response = $this->do_request( $this->get_create_customer_profile_xml( $user, $payment ) );

			if( ! $response ){
				return false;
			}

			return $this->parse_response( $response );
		}

		/**
		 * Execute a request for create customer payment profile, and return parsed response
		 *
		 * @param $order \WC_Order Order to use as a base for billTo section
		 * @param $customer_profile_id string Customer profile unique ID
		 * @param $payment \StdClass Payment details
		 *
		 * @return \SimpleXMLElement Parsed xml
		 * @since 1.0.0
		 */
		public function create_customer_payment_profile( $order, $customer_profile_id, $payment ) {
			$response = $this->do_request( $this->get_create_customer_payment_profile_xml( $order, $customer_profile_id, $payment ) );

			if( ! $response ){
				return false;
			}

			return $this->parse_response( $response );
		}

		/**
		 * Execute a request for create customer payment profile, and return parsed response
		 *
		 * @param $order \WC_Order Order to use as a base for billTo section
		 * @param $customer_profile_id string Customer profile unique ID
		 *
		 * @return \SimpleXMLElement Parsed xml
		 * @since 1.0.0
		 */
		public function update_customer_profile( $order, $customer_profile_id ) {
			$response = $this->do_request( $this->get_update_customer_profile_xml( $order , $customer_profile_id ) );

			if( ! $response ){
				return false;
			}

			return $this->parse_response( $response );
		}

		/**
		 * Execute a request for update customer payment profile, and return parsed response
		 *
		 * @param $order \WC_Order Order to use as a base for billTo section
		 * @param $customer_profile_id string Customer profile unique ID
		 * @param $customer_payment_profile_id string Customer payment profile unique ID
		 * @param $payment_details \StdClass Payment details
		 *
		 * @return \SimpleXMLElement Parsed xml
		 * @since 1.0.0
		 */
		public function update_customer_payment_profile( $order, $customer_profile_id, $customer_payment_profile_id, $payment_details ) {
			$response = $this->do_request( $this->get_update_customer_payment_profile_xml( $order , $customer_profile_id, $customer_payment_profile_id, $payment_details ) );

			if( ! $response ){
				return false;
			}

			return $this->parse_response( $response );
		}

		/**
		 * Execute a request for delete customer payment profile, and return parsed response
		 *
		 * @param $customer_profile_id string Customer profile unique ID
		 * @param $customer_payment_profile_id string Customer payment profile unique ID
		 *
		 * @return \SimpleXMLElement Parsed xml
		 * @since 1.0.0
		 */
		public function delete_customer_payment_profile( $customer_profile_id, $customer_payment_profile_id ) {
			$response = $this->do_request( $this->get_delete_customer_payment_profile_xml( $customer_profile_id, $customer_payment_profile_id ) );

			if( ! $response ){
				return false;
			}

			return $this->parse_response( $response );
		}

		/**
		 * Returns xml string to create a payment transaction on Authorize.net
		 *
		 * @param $order \WC_Order Order to pay
		 * @param $payment_details \StdClass Payment details
		 * @param $transaction_mode string Transaction mode
		 *
		 * @return string XML request
		 * @since 1.0.0
		 */
		public function get_create_payment_transaction_xml( $order, $payment_details, $transaction_mode = 'authCaptureTransaction' ) {
			// starts xml document
			$this->xml_writer->openMemory();
			$this->xml_writer->startDocument( '1.0', 'UTF-8' );

			// <createTransactionRequest xmlns="AnetApi/xml/v1/schema/AnetApiSchema.xsd">
			$this->xml_writer->startElementNs( null, 'createTransactionRequest', 'AnetApi/xml/v1/schema/AnetApiSchema.xsd' );

			// adds authentication info
			$this->add_auth_xml();

			// <transactionRequest>
			$this->xml_writer->startElement( 'transactionRequest' );

			// <transactionType>authCaptureTransaction</transactionType>
			$this->xml_writer->writeElement( 'transactionType', $transaction_mode );

			// <amount>Order Amount</amount>
			$this->xml_writer->writeElement( 'amount', $order->get_total() );

			// <currencyCode>Order Currency Code</currencyCode>
			$this->xml_writer->writeElement( 'currencyCode', $order->get_order_currency() );

			// adds payment detail
			$this->add_payment_xml( $payment_details );

			// adds profile detail
			$this->add_profile_xml( $payment_details );

			// <order>
			$this->xml_writer->startElement( 'order' );

			// <invoiceNumber>Order ID</invoiceNumber>
			$this->xml_writer->writeElement( 'invoiceNumber', $order->id );

			// <description>Order description</description>
			$this->xml_writer->writeElement( 'description', 'Order ' . $order->get_order_number() );

			// </order>
			$this->xml_writer->endElement();

			if( $this->itemized ){
				// <lineItems>
				$this->xml_writer->startElement( 'lineItems' );

				// add line items informations for itemized transactions
				$this->add_line_items_xml( $order );

				// </lineItems>
				$this->xml_writer->endElement();
			}

			if ( $order->get_total_tax() > 0 ) {
				$this->add_tax_xml( $order );
			}

			if ( $order->get_total_shipping() > 0 ) {
				$this->add_shipping_xml( $order );
			}

			// <customer>
			$this->xml_writer->startElement( 'customer' );

			$this->xml_writer->writeElement( 'id', isset( $order->customer_user ) ? $order->customer_user : get_current_user_id() );

			if ( $order->billing_email ) {
				$this->xml_writer->writeElement( 'email', $order->billing_email );
			}

			// </customer>
			$this->xml_writer->endElement();

			// <billTo>
			if( $payment_details->type != 'profile' ) {
				$this->xml_writer->startElement( 'billTo' );

				// add billing informations
				$this->add_address_xml( $order );

				// </billTo>
				$this->xml_writer->endElement();
			}

			if( ! empty( $order->shipping_country ) ){
				// <shipTo>
				$this->xml_writer->startElement( 'shipTo' );

				// add billing informations
				$this->add_address_xml( $order, 'shipping' );

				// </shipTo>
				$this->xml_writer->endElement();
			}

			$this->add_user_info( $order );

			// </transactionRequest>
			$this->xml_writer->endElement();

			// </createTransactionRequest>
			$this->xml_writer->endElement();

			// ends xml document and returns it
			$this->xml_writer->endDocument();
			return $this->xml_writer->outputMemory();
		}

		/**
		 * Returns xml string to create a refund transaction on Authorize.net
		 *
		 * @param $order \WC_Order Order to refund
		 * @param $amount float Amount to refund
		 * @param $payment_details \StdClass Payment details
		 *
		 * @return string XML request
		 * @since 1.0.0
		 */
		public function get_create_refund_transaction_xml( $order, $amount, $payment_details ){
			if( empty( $amount ) ){
				$amount = $order->get_total();
			}

			$trans_id = $order->get_transaction_id();

			if( empty( $trans_id ) ){
				return false;
			}

			// starts xml document
			$this->xml_writer->openMemory();
			$this->xml_writer->startDocument( '1.0', 'UTF-8' );

			// <createTransactionRequest xmlns="AnetApi/xml/v1/schema/AnetApiSchema.xsd">
			$this->xml_writer->startElementNs( null, 'createTransactionRequest', 'AnetApi/xml/v1/schema/AnetApiSchema.xsd' );

			// adds authentication info
			$this->add_auth_xml();

			// <transactionRequest>
			$this->xml_writer->startElement( 'transactionRequest' );

			// <transactionType>authCaptureTransaction</transactionType>
			$this->xml_writer->writeElement( 'transactionType', 'refundTransaction' );

			// <amount>Order Amount</amount>
			$this->xml_writer->writeElement( 'amount', $amount );

			// <currencyCode>Order Currency Code</currencyCode>
			$this->xml_writer->writeElement( 'currencyCode', $order->get_order_currency() );

			// adds payment detail
			$this->add_payment_xml( $payment_details );

			$this->xml_writer->writeElement( 'refTransId', $trans_id );

			// </transactionRequest>
			$this->xml_writer->endElement();

			// </createTransactionRequest>
			$this->xml_writer->endElement();

			// ends xml document and returns it
			$this->xml_writer->endDocument();
			return $this->xml_writer->outputMemory();
		}

		/**
		 * Returns xml string to create a customer payment transaction on Authorize.net
		 *
		 * @param $user \WP_User User to map in Authorize.net servers
		 * @param $payment \StdClass|bool Payment details (false if no payment to add)
		 *
		 * @return string XML request
		 * @since 1.0.9
		 */
		public function get_create_customer_profile_xml( $user, $payment = false ){
			// starts xml document
			$this->xml_writer->openMemory();
			$this->xml_writer->startDocument( '1.0', 'UTF-8' );

			// <createCustomerPaymentProfileRequest xmlns="AnetApi/xml/v1/schema/AnetApiSchema.xsd">
			$this->xml_writer->startElementNs( null, 'createCustomerProfileRequest', 'AnetApi/xml/v1/schema/AnetApiSchema.xsd' );

			$this->add_auth_xml();

			// <profile>
			$this->xml_writer->startElement( 'profile' );

			$this->xml_writer->writeElement( 'merchantCustomerId', $user->ID );
			$this->xml_writer->writeElement( 'email', $user->user_email);

			if( false !== $payment ) {

				// <paymentProfile>
				$this->xml_writer->startElement( 'paymentProfiles' );

				$this->add_payment_xml( $payment );

				// </paymentProfiles>
				$this->xml_writer->endElement();

			}

			// </profile>
			$this->xml_writer->endElement();

			$this->xml_writer->writeElement( 'validationMode', 'none' );

			// </createCustomerProfileRequest>
			$this->xml_writer->endElement();

			// ends xml document and returns it
			$this->xml_writer->endDocument();
			return $this->xml_writer->outputMemory();
		}

		/**
		 * Returns xml string to create a customer payment profile transaction on Authorize.net
		 *
		 * @param $order \WC_Order Order to use as a base for billTo
		 * @param $customer_profile_id string Customer profile unique ID
		 * @param $payment \StdClass Payment details
		 *
		 * @return string XML request
		 * @since 1.0.0
		 */
		public function get_create_customer_payment_profile_xml( $order, $customer_profile_id, $payment ){
			// starts xml document
			$this->xml_writer->openMemory();
			$this->xml_writer->startDocument( '1.0', 'UTF-8' );

			// <createCustomerPaymentProfileRequest xmlns="AnetApi/xml/v1/schema/AnetApiSchema.xsd">
			$this->xml_writer->startElementNs( null, 'createCustomerPaymentProfileRequest', 'AnetApi/xml/v1/schema/AnetApiSchema.xsd' );

			$this->add_auth_xml();

			$this->xml_writer->writeElement( 'customerProfileId', $customer_profile_id );

			// <paymentProfile>
			$this->xml_writer->startElement( 'paymentProfile' );

			if( ! is_null( $order ) ):

				// <billTo>
				$this->xml_writer->startElement( 'billTo' );

				$this->add_address_xml( $order, 'billing' );

				// </billTo>
				$this->xml_writer->endElement();

			endif;

			$this->add_payment_xml( $payment );

			// </paymentProfile>
			$this->xml_writer->endElement();

			$this->xml_writer->writeElement( 'validationMode', 'none' );

			// </createCustomerPaymentProfileRequest>
			$this->xml_writer->endElement();

			// ends xml document and returns it
			$this->xml_writer->endDocument();
			return $this->xml_writer->outputMemory();
		}

		/**
		 * Returns xml string to update a customer profile transaction on Authorize.net
		 *
		 * @param $order \WC_Order Order to use as a base for billTo
		 * @param $customer_profile_id string Customer profile unique ID
		 *
		 * @return string XML request
		 * @since 1.0.0
		 */
		public function get_update_customer_profile_xml( $order, $customer_profile_id ) {
			$user_id = get_current_user_id();
			$user = wp_get_current_user();
			$user_email = ! empty( $user->billing_email ) ? $user->billing_email : $user->user_email;
			
			// starts xml document
			$this->xml_writer->openMemory();
			$this->xml_writer->startDocument( '1.0', 'UTF-8' );

			// <updateCustomerProfileRequest xmlns="AnetApi/xml/v1/schema/AnetApiSchema.xsd">
			$this->xml_writer->startElementNs( null, 'updateCustomerProfileRequest', 'AnetApi/xml/v1/schema/AnetApiSchema.xsd' );

			$this->add_auth_xml();

			$this->xml_writer->startElement( 'profile' );

			$this->xml_writer->writeElement( 'merchantCustomerId', $user_id );
			$this->xml_writer->writeElement( 'email', is_null( $order ) ? $user_email : $order->billing_email );
			$this->xml_writer->writeElement( 'customerProfileId', $customer_profile_id );

			$this->xml_writer->endElement();

			// </updateCustomerProfileRequest>
			$this->xml_writer->endElement();

			// ends xml document and returns it
			$this->xml_writer->endDocument();
			return $this->xml_writer->outputMemory();
		}

		/**
		 * Returns xml string to update a customer payment profile transaction on Authorize.net
		 *
		 * @param $order \WC_Order Order to use as a base for billTo
		 * @param $customer_profile_id string Customer profile unique ID
		 * @param $customer_payment_profile_id string Customer payment profile unique ID
		 * @param $payment_details \StdClass Payment details
		 *
		 * @return string XML request
		 * @since 1.0.0
		 */
		public function get_update_customer_payment_profile_xml(  $order, $customer_profile_id, $payment_profile_id, $payment_details ){
			// starts xml document
			$this->xml_writer->openMemory();
			$this->xml_writer->startDocument( '1.0', 'UTF-8' );

			// <updateCustomerProfileRequest xmlns="AnetApi/xml/v1/schema/AnetApiSchema.xsd">
			$this->xml_writer->startElementNs( null, 'updateCustomerPaymentProfileRequest', 'AnetApi/xml/v1/schema/AnetApiSchema.xsd' );

			$this->add_auth_xml();

			$this->xml_writer->writeElement( 'customerProfileId', $customer_profile_id );

			$this->xml_writer->startElement( 'paymentProfile' );

			if( ! is_null( $order ) ):
					
				$this->xml_writer->startElement( 'billTo' );
	
				$this->add_address_xml( $order );
	
				$this->xml_writer->endElement();
					
			endif;

			$this->add_payment_xml( $payment_details );

			$this->xml_writer->writeElement( 'customerPaymentProfileId', $payment_profile_id );

			$this->xml_writer->endElement();

			$this->xml_writer->writeElement( 'validationMode', 'none' );

			// </updateCustomerProfileRequest>
			$this->xml_writer->endElement();

			// ends xml document and returns it
			$this->xml_writer->endDocument();
			return $this->xml_writer->outputMemory();
		}

		/**
		 * Returns xml string to delete a customer profile transaction on Authorize.net
		 *
		 * @param $customer_profile_id string Customer profile unique ID
		 * @param $customer_payment_profile_id string Customer payment profile unique ID
		 *
		 * @return string XML request
		 * @since 1.0.0
		 */
		public function get_delete_customer_payment_profile_xml( $customer_profile_id, $customer_payment_profile_id ){
			// starts xml document
			$this->xml_writer->openMemory();
			$this->xml_writer->startDocument( '1.0', 'UTF-8' );

			// <deleteCustomerPaymentProfileRequest xmlns="AnetApi/xml/v1/schema/AnetApiSchema.xsd">
			$this->xml_writer->startElementNs( null, 'deleteCustomerPaymentProfileRequest', 'AnetApi/xml/v1/schema/AnetApiSchema.xsd' );

			$this->add_auth_xml();

			$this->xml_writer->writeElement( 'customerProfileId', $customer_profile_id );

			$this->xml_writer->writeElement( 'customerPaymentProfileId', $customer_payment_profile_id );

			// </deleteCustomerPaymentProfileRequest>
			$this->xml_writer->endElement();

			// ends xml document and returns it
			$this->xml_writer->endDocument();
			return $this->xml_writer->outputMemory();
		}

		/**
		 * Add xml to authenticate merchant on Authorize.net servers
		 *
		 * @return void
		 * @since 1.0.0
		 */
		protected function add_auth_xml() {

			// <merchantAuthentication>
			$this->xml_writer->startElement( 'merchantAuthentication' );

			// <name>{api_login_id}</name>
			$this->xml_writer->writeElement( 'name', $this->login_id );

			// <transactionKey>{api_transaction_key}</transactionKey>
			$this->xml_writer->writeElement( 'transactionKey', $this->transaction_key );

			// </merchantAuthentication>
			$this->xml_writer->endElement();
		}

		/**
		 * Add xml for an address (shipping or billig)
		 *
		 * @param $order \WC_Order Order from which retrieve address information
		 * @param $type string billing/shipping
		 * @param $fields array An array of field to print
		 *
		 * @return void
		 * @since 1.0.0
		 */
		protected function add_address_xml( $order, $type = 'billing', $fields = array() ) {
			if( empty( $fields ) ){
				$fields = array(
					'first_name',
					'last_name',
					'company',
					'address',
					'city',
					'state',
					'zip',
					'country',
					'phone'
				);
			}

			foreach ( $fields as $field ) {

				$field_name = $type . '_' . $field;
				$xml_name = lcfirst( str_replace( ' ', '', ucwords( str_replace( '_', ' ', $field ) ) ) );

				if ( 'shipping' == $type && 'phone' == $field ) {
					continue;
				}

				if ( 'address' == $field ) {
					$this->xml_writer->writeElement( 'address', $order->{ $type . '_address_1' } . ' ' . $order->{ $type . '_address_2' } );
					continue;
				}

				if( 'zip' == $field ){
					$this->xml_writer->writeElement( 'zip', $order->{ $type . '_postcode' } );
					continue;
				}

				if( 'phone' == $field ){
					$this->xml_writer->writeElement( 'phoneNumber', $order->billing_phone );
					continue;
				}

				if ( $order->$field_name ) {
					$this->xml_writer->writeElement( $xml_name, $order->$field_name );
				}
			}
		}

		/**
		 * Add xml for payment information
		 *
		 * @param $payment \StdClass Payment details
		 *
		 * @return void
		 * @since 1.0.0
		 */
		protected function add_payment_xml( $payment ) {
			if( $payment->type != 'profile' ) {
				// <payment>
				$this->xml_writer->startElement( 'payment' );

				if ( 'echeck' === $payment->type ) {

					// <bankAccount>
					$this->xml_writer->startElement( 'bankAccount' );

					if ( ! empty( $payment->routing_number ) ) {
						$this->xml_writer->writeElement( 'routingNumber', $payment->routing_number );
					}

					if ( ! empty( $payment->account_number ) ) {
						$this->xml_writer->writeElement( 'accountNumber', $payment->account_number );
					}

					if ( ! empty( $payment->name_on_account ) ) {
						$this->xml_writer->writeElement( 'nameOnAccount', $payment->name_on_account );
					}


					// $this->xml_writer->writeElement( 'echeckType', 'WEB' );

					// </bankAccount>
					$this->xml_writer->endElement();

				} elseif ( 'credit_card' === $payment->type ) {

					// <creditCard>
					$this->xml_writer->startElement( 'creditCard' );

					if ( ! empty( $payment->card_number ) ) {
						$this->xml_writer->writeElement( 'cardNumber', $payment->card_number );
					}

					if ( ! empty( $payment->expiration_date ) ) {
						$this->xml_writer->writeElement( 'expirationDate', $payment->expiration_date );
					}

					if ( ! empty( $payment->cvv ) ) {
						$this->xml_writer->writeElement( 'cardCode', $payment->cvv );
					}

					// </creditCard>
					$this->xml_writer->endElement();
				}

				// </payment>
				$this->xml_writer->endElement();
			}
		}

		/**
		 * Add xml for profile information
		 *
		 * @param $payment \StdClass Payment details
		 *
		 * @return void
		 * @since 1.0.0
		 */
		protected function add_profile_xml( $payment ){
			if( $this->cim_handling && is_user_logged_in() ){
				// <profile>
				$this->xml_writer->startElement( 'profile' );

				if( $payment->type != 'profile' ) {
					$this->xml_writer->writeElement( 'createProfile', true );
				}

				if( ! empty( $payment->customer_profile_id ) ){
					$this->xml_writer->writeElement( 'customerProfileId', $payment->customer_profile_id );
				}

				if( 'profile' === $payment->type ){
					$this->xml_writer->startElement( 'paymentProfile' );

					$this->xml_writer->writeElement( 'paymentProfileId', $payment->payment_profile_id );

					$this->xml_writer->endElement();
				}

				// </profile>
				$this->xml_writer->endElement();
			}
		}

		/**
		 * Add xml for items information
		 *
		 * @param $order \WC_Order Order to use to retrieve items
		 *
		 * @return void
		 * @since 1.0.0
		 */
		protected function add_line_items_xml( $order ){
			$line_items = $order->get_items( 'line_item' );
			$fees_item = $order->get_fees();

			$order_items = array_merge( $line_items, $fees_item );
			$counter = 0;

			if( ! empty( $order_items ) ){
				foreach( $order_items as $item_id => $item ){
					if( $counter >= 30 ){
						break;
					}

					// <lineItem>
					$this->xml_writer->startElement( 'lineItem' );

					// <itemId>Item id</itemId>
					$this->xml_writer->writeElement( 'itemId', $item_id );
					// <name>Item name</name>
					$this->xml_writer->writeElement( 'name', htmlentities( substr( $item['name'], 0, 20 ), ENT_QUOTES, 'UTF-8', false ) );
					// <quantity>Item quantity</quantity>
					$this->xml_writer->writeElement( 'quantity', isset( $item['qty'] ) ? $item['qty'] : 1 );
					// <unitPrice>Item unit price</unitPrice>
					$this->xml_writer->writeElement( 'unitPrice', $order->get_item_total( $item ) );
					// </lineItem>
					$this->xml_writer->endElement();

					$counter ++;
				}
			}
		}

		/**
		 * Add xml for tax information
		 *
		 * @param $order \WC_Order Order to use to retrieve taxes
		 *
		 * @return void
		 * @since 1.0.0
		 */
		protected function add_tax_xml( $order ) {

			// <tax>
			$this->xml_writer->startElement( 'tax' );

			// <amount>
			$this->xml_writer->writeElement( 'amount', $order->get_total_tax() );

			// <name>
			$this->xml_writer->writeElement( 'name', __( 'Taxes', 'yith-wcauthnet' ) );

			$taxes = array();

			foreach ( $order->get_tax_totals() as $tax_code => $tax ) {

				$taxes[] = sprintf( '%s (%s) - %s', $tax->label, $tax_code, $tax->amount );
			}

			// </tax>
			$this->xml_writer->endElement();
		}

		/**
		 * Add xml for shipping costs information
		 *
		 * @param $order \WC_Order Order to use to retrieve shipping costs
		 *
		 * @return void
		 * @since 1.0.0
		 */
		protected function add_shipping_xml( $order ) {

			// <shipping>
			$this->xml_writer->startElement( 'shipping' );

			// <amount>
			$this->xml_writer->writeElement( 'amount', $order->get_total_shipping() );

			// <name>
			$this->xml_writer->writeElement( 'name', __( 'Shipping', 'yith-wcauthnet' ) );

			// </shipping>
			$this->xml_writer->endElement();
		}

		/**
		 * Add xml for user information
		 *
		 * @param $order \WC_Order Order to use to retrieve user informations
		 *
		 * @return void
		 * @since 1.0.0
		 */
		protected function add_user_info( $order ){
			$user_info = apply_filters( 'yith_wcauthnet_user_info', array(
				'transaction_email' => $order->billing_email,
				'transaction_amount' => $order->get_total()
			), $order );

			if( ! empty( $user_info ) ){
				$this->xml_writer->startElement( 'userFields' );
				foreach( $user_info as $id => $value ){
					$this->xml_writer->startElement( 'userField' );

					$this->xml_writer->writeElement( 'name', $id );
					$this->xml_writer->writeElement( 'value', $value );

					$this->xml_writer->endElement();
				}
				$this->xml_writer->endElement();
			}
		}
	}
}

/**
 * Unique access to instance of YITH_WCAUTHNET_CIM_API class
 *
 * @return \YITH_WCAUTHNET_CIM_API
 * @since 1.0.0
 */
function YITH_WCAUTHNET_CIM_API(){
	return YITH_WCAUTHNET_CIM_API::get_instance();
}