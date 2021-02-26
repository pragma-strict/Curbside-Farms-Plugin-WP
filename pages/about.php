<?
/**
 * @package CurbsideFarmsPlugin 
 */

if (! defined('ABSPATH')){
    die;
}

function get_vision(){
   $content = "This is the vision page!";
   return $content;
}

add_shortcode( 'cs_vision', 'get_vision' );