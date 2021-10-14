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

// Hook activation function defined in the CurbsidePlugin class
register_activation_hook( __FILE__, array($curbsidePlugin, 'activate') );

// Hook deactivation function defined in the CurbsidePlugin class
register_deactivation_hook( __FILE__, array($curbsidePlugin, 'deactivate') );

// Hook uninstall function defined in the CurbsidePlugin class
//register_uninstall_hook( __FILE__, array($curbsidePlugin, 'uninstall') );

$curbsidePlugin->register_shortcodes();
$curbsidePlugin->register_actions();