<?php
/*
Plugin Name: Remove Version
Plugin URI: http://barryko.com/
Description: Remove the WordPress version number from Meta, RSS, and Javascript & CSS parameters to increase security and thwart potential hacks.
Author: Barry Ko
Author URI: http://barryko.com/
Version: 1.0
*/

function remove_wp_ver() { return ''; }
add_filter('the_generator', 'remove_wp_ver');

function remove_wp_ver_par( $src ) {
    if ( strpos( $src, 'ver=' . get_bloginfo( 'version' ) ) )
        $src = remove_query_arg( 'ver', $src );
    return $src;
}
add_filter( 'style_loader_src', 'remove_wp_ver_par', 9999 );
add_filter( 'script_loader_src', 'remove_wp_ver_par', 9999 );

?>
