<?
/**
 * @package CurbsideFarmsPlugin 
 */

if (! defined('ABSPATH')){
    die;
} 

if($_POST){
   echo "YAY";
}

?>
<div class="container">
    This is what we're all about!
    <form action="">
        <input type="text" value="text here" class="send-field">
        <input type="text" value="more text" class="send-field">
    </form>
    <button onclick="submit_bed_order('<?php echo plugin_dir_url( __FILE__ ) ?>', 'send-field')">Submit</button>
</div>

<script type="text/javascript" src="<?php echo plugins_url("curbside-farms/js/order-bed.js"); ?>"></script>