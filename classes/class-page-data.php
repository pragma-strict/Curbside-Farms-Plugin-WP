<?php 
/**
 * @package CurbsideFarmsPlugin 
 */

  if (! defined('ABSPATH')){
    die;
}

class CurbsidePageData
{
    public $title;
    //public $shortcode;
    public $file_name;
    //public $function;

    function __construct($title, $file_name){
        $this->$title = $title;
        //$this->$shortcode = $shortcode;
        $this->$file_name = $file_name;
        //$this->$function = $function;
    }
}