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

require( plugin_dir_path( __FILE__ ) . "classes/class-curbside-farms.php" );

// Create a plugin object and register hooks using its methods
if(class_exists('CurbsidePlugin')){
    $curbsidePlugin = new CurbsidePlugin();
}

// Activate plugin
register_activation_hook( __FILE__, array($curbsidePlugin, 'activate') );

// Deactivate plugin
register_deactivation_hook( __FILE__, array($curbsidePlugin, 'deactivate') );

// Uninstall plugin
//register_uninstall_hook( __FILE__, array($curbsidePlugin, 'uninstall') );

require( plugin_dir_path( __FILE__ ) . "pages/order-bed.php" );