<?php get_header();?>

<?php // Collect all the data needed to make a purchase order post
$category_ids = array($_POST['post_category_id']);

$meta_properties = array(
   'offer_id' => $_POST['meta_offer_id'],
   'order_location' => $_POST['meta_order_location']
);

$offer_object = get_post( $_POST['meta_offer_id'] );
$offer_title = "(default title)";
if($offer_object instanceof WP_Post){
   $offer_title = $offer_object->post_title;
}
$title = $_POST['meta_order_location'] . " – " . $offer_title;
$content = "Community Order (default content)";

$community_page = get_page_by_path( 'community' );
$parent = 0;
if($community_page instanceof WP_Post){
   $parent = $community_page->ID;
}
?>

<div class="cs-margin-basic">
   <h1>Order published.</h1>
   <a href="<?php echo home_url( "/community" ); ?>">Return to Community page</a>
</div>

<?php // Insert post
$new_post_id = wp_insert_post(
   array(
      'post_title'=>$title, 
      'post_content'=>$content, 
      'post_type'=>'post', 
      'post_category'=>$category_ids,
      'post_status'=>'publish',
      'post_parent'=>$parent)
   );
?>

<?php // Add post meta entries
   foreach($meta_properties as $key => $value){
      if(isset($value)){
         add_post_meta( $new_post_id, $key, $value );
      }
   }
   // Set the new post to use a custom template. This could maybe be included as an arg above
   update_post_meta( $new_post_id, "_wp_page_template", "/post-templates/community-order.php" );
?>

<?php get_footer(); ?>