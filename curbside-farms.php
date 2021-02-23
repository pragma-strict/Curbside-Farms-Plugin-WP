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


/**
 * Note: For now this plugin will add pages unless pages with the same name already exist. On uninstall it will remove pages based on their name - if there are multiple pages with the same name it will remove the first one it finds. This is a problem because it might accidentally cause non-curbside pages to be removed but I'll sort that out later. 
 */

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
        $this->add_pages();
        // Add Shortcode
    }

    function deactivate(){
        $this->trash_pages();
    }

    static function uninstall(){
        //CurbsidePlugin::trash_pages();
    }

    // Add Curbside pages unless pages with the same name already exist.
    function add_pages(){ 
        foreach( $this->curbside_page_titles as $title ){
            $posts_with_title = $this->get_posts_with_title( $title );
            if ( empty( $posts_with_title ) ){
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
        return $posts_with_title;
    }

    // Adds pages without checking for existing pages. Do not use.
    function add_pages_without_check(){
        foreach( $this->curbside_page_titles as $title ){
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
        foreach( $this->curbside_page_titles as $title ){
            $pages_with_title = $this->get_posts_with_title( $title );
            if ( !empty($pages_with_title) ){
                $post_to_delete = $pages_with_title[0];
                wp_delete_post( $post_to_delete->ID, false);
            }
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
        return $posts;
    }

    function get_posts_with_title($title){
        $get_post_args = array(
            'title' => $title,
            'post_type' => 'page',
            'post_status' => 'any',
            'posts_per_page' => -1
        );
        $posts = get_posts( $get_post_args );
        return $posts;
    }
}


// Create a plugin object and register hooks using its methods
if(class_exists('CurbsidePlugin')){
    $curbsidePlugin = new CurbsidePlugin();
}

function curbside_debug() {
    $curbsidePlugin = new CurbsidePlugin();
    $content = "";
    $pages_with_title = $curbsidePlugin->get_posts_with_title("Order Bed");
    foreach($pages_with_title as $page){
        $content .= ("<p>" . print_r($page) . "</p>");
        $content .= "<hr>";
    }
    return $content;
}
add_shortcode( 'debug_curbside', 'curbside_debug' );

require( plugin_dir_path( __FILE__ ) . "/pages/order-bed.php" );

// Activate plugin
register_activation_hook( __FILE__, array($curbsidePlugin, 'activate') );

// Deactivate plugin
register_deactivation_hook( __FILE__, array($curbsidePlugin, 'deactivate') );

// Uninstall plugin
//register_uninstall_hook( __FILE__, array($curbsidePlugin, 'uninstall') );