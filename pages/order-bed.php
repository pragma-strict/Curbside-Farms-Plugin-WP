<?
/**
 * @package CurbsideFarmsPlugin 
 */

if (! defined('ABSPATH')){
    die;
}

function order_bed(){
   return "This is the bed ordering page!";
}

add_shortcode( 'cs_order_bed', 'order_bed' );