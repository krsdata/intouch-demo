<?php
/*
 * Template Name:Test
 */
 
 get_header();
 
$admin_email = get_option('admin_email');
if( isset($admin_email) && $admin_email!='' ){

	if( isset($_COOKIE['order_data']) && $_COOKIE['order_data']!='' ){
	
		$order_data = json_decode(stripslashes($_COOKIE['order_data']));
		print_r($order_data);
		$attachments = "";
		$subject = "Order Mail - 123";
		$email = "";
		ob_start();
		include(TEMPLATEPATH . '/woocommerce/email-template.php');
			$message = ob_get_contents();
		ob_end_clean();
 
		/* $headers = "From: ".."";
		$headers .= "Return-Path: ".."";
		$headers .= "MIME-Version: 1.0";
		$headers .= "Content-Type: text/html; charset=UTF-8";
		$headers .= "BCC: thisIsMe@gmail.com";
		//$headers .= "BCC: rochesterj@gmail.com";
		wp_mail( $email, $subject, $message, $headers, $attachments ); */
	}		
}

get_footer();