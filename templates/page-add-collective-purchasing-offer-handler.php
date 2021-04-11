<?php get_header();?>

<?php 
// Make variables for all of the fields
$title = $_POST['post_title'];
$content = $_POST['post_content'];

// Get category id from slug. Not 100% sure if this will work.
$category_ids = array(0);
$category = get_category_by_slug( $_POST['post_category_slug'] );
if(isset($category)){
   $category_ids[0] = $category->term_id;
}

$meta_properties = array(
   'unit_name' => $_POST['meta_unit_name'],
   'min_units' => $_POST['meta_min_units'],
   'unit_price' => $_POST['meta_unit_price'],
   'unit_price_original' => $_POST['meta_unit_price_original'],
   'base_price' => $_POST['meta_base_price'],
   'supplier' => $_POST['meta_supplier']
);
?>

<div class="cs-margin-basic">
   <h1>Offer published.</h1>
   Title: <?php echo $title; ?><br>
   Description: <?php echo $content; ?>
   <a href="<?php echo home_url( "/community" ); ?>">Go to Community page</a>
</div>

<?php // Insert post
$new_post_id = wp_insert_post(
   array(
      'post_title'=>$title, 
      'post_content'=>$content, 
      'post_type'=>'post', 
      'post_category'=>$category_ids,
      'post_status'=>'publish')
   );
?>

<?php // Add post meta entries
   foreach($meta_properties as $key => $value){
      if(isset($value)){
         add_post_meta( $new_post_id, $key, $value );
      }
   }
?>

<?php get_footer(); ?>