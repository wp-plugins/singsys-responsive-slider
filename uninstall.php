<?php
// If uninstall is not called from WordPress, exit
if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit();
}
 
$option_name = 'singsys_slide_version';
 
delete_option( $option_name );
 
// For site options in Multisite
delete_site_option( $option_name );  
 
// Drop a custom db table
global $wpdb;
$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}singsys_slider" );
$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}singsys_items" );