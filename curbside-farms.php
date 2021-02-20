<?
/**
 * @package CurbsideFarmsPlugin 
 */

 /**
  * Plugin Name: Curbside Farms Plugin
  * Plugin URI: https://curbsidefarms.ca/
  * Description: This adds some pages and associated functionality for the Curbside Farms website
  * Author: Ian DeJong
  * Author URI: https://github.com/pragma-strict
  * Text Domain: curbside-farms
  */

if (! defined('ABSPATH')){
    die;
}


// Class contains most of the functionality of this plugin
class CurbsidePlugin
{ 
    // Titles of pages the plugin creates. Duplicates will not be added.
    public $curbside_page_titles = array(
        "Order Bed",
        "Community",
        "My Page"
    ); 
    public $curbside_page_meta_key = "curbside_farms_page";

    function activate(){
        $this->add_pages_without_check();
    }

    function deactivate(){
        $this->trash_pages();
    }

    // Add pages unique to the Curbside Farms system
    function generate_pages(){
        
        $existing_pages = $this->get_posts_with_title("Order Bed");
        
        
        //debug_output_chars(count($existing_pages));
        $existing_curbside_page_titles = array();
        foreach($existing_pages as $post){
            $meta = get_post_meta( $post->ID, true );
            if($meta != 0){
                array_push($existing_curbside_page_titles, $meta);
            }
        }


        // Add pages with titles not on the list
        foreach($this->curbside_page_titles as $title){
            if (!in_array($title, $existing_curbside_page_titles)){
                $post_args = array(
                    'post_title' => $title,
                    'post_content' => 'This is the content of my new page',
                    'post_type' => 'page',
                    'post_status' => 'publish'
                );
                //$post_id = wp_insert_post( $post_args );
                //add_post_meta( $post_id, $this->curbside_page_meta_key, $title, false );
            }
        }
    }

    function add_pages_without_check(){
        foreach($this->curbside_page_titles as $title){
            $post_args = array(
                'post_title' => $title,
                'post_content' => 'This is the content of my new page',
                'post_type' => 'page',
                'post_status' => 'publish'
            );
            $post_id = wp_insert_post( $post_args );
            //add_post_meta( $post_id, $this->curbside_page_meta_key, $title, false );
        }
    }

    // Move Curbside pages to trash
    function trash_pages(){
        $existing_pages = $this->get_curbside_pages();
        foreach($existing_pages as $post){
            wp_delete_post( $post->ID, false);
        }
    }

    function get_cs_pages_by_query(){
        $meta_args = array(
            'meta_key' => 'curbside_farms_page',
            'post_type' => 'page',
            'post_status' => 'any',
            'posts_per_page' => -1
        );
        $existing_pages = new WP_Query($meta_args);
        $posts = $existing_pages->posts;
        debug_output_chars(count($posts));
        return $posts;
    }

    // Return array of WP_Posts with meta keys matching the curbside page meta key
    function get_curbside_pages(){
        $get_post_args = array(
            //'meta_key' => $this->curbside_page_meta_key,
            'post_type' => 'page',
            'post_status' => 'any',
            'posts_per_page' => -1
        );
        $posts = get_posts( $get_post_args );
        debug_output_chars(count($posts));
        return $posts;
    }

    function get_posts_with_title($title){
        $get_post_args = array(
            'post_title' => $title,
            'post_type' => 'page',
            'post_status' => 'any',
            'posts_per_page' => -1
        );
        $posts = get_posts( $get_post_args );
        debug_output_chars(count($posts));
        return $posts;
    }
}


// Create a plugin object and register hooks using its methods
if(class_exists('CurbsidePlugin')){
    $curbsidePlugin = new CurbsidePlugin();
}

// Activate plugin
register_activation_hook( __FILE__, array($curbsidePlugin, 'activate') );

// Deactivate plugin
register_deactivation_hook( __FILE__, array($curbsidePlugin, 'deactivate') );



// Echo a given number of chars. Useful(ish) for primitive debugging when headers already sent
function debug_output_chars($number){
    for($i = 0; $i < $number; $i++){
        echo " ";
    }
}