<?
/**
 * @package CurbsideFarmsPlugin 
 */

if (! defined('ABSPATH')){
    die;
}

function get_order_bed(){
   return "This is the bed ordering page!";
}

add_shortcode( 'cs_order_bed', 'get_order_bed' );