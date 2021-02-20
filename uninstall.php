<?php

/**
 * @package CurbsideFarmsPlugin 
 */

if(!defined('WP_UNINSTALL_PLUGIN')){
    die;
}


// Remove plugin data from database
function delete_pages(){
    $post = get_page_by_title( "New page" );
    if ($post != null){
        wp_delete_post( $post->ID, true);
    }
}

delete_pages();

// You could also use SQL directly from wpdb. This is faster.
//global $wpdb;
//$wpdb->query("DELETE FROM wp_posts WHERE post_type = 'test'");
//$wpdb->query("DELETE FROM wp_postmeta WHERE post_id NOT IN (SELECT id FROM wp_posts)");