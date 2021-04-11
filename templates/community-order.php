
<?php 
/*
Template Name: Community Order 
Template Post Type: post

This template is used to display posts in the category of 'community-order'. 
It needs to determine which specific post it's showing and then show its data. 
*/
?>

<?php get_header(); ?>

<?php // Collect data to be inserted amongst the HTML
$error = false; // True if unable to get necessary data. Error message will go out to user :0

// Get main post data
$post_ID = url_to_postid(  get_permalink() );
$post = get_post( $post_ID );
if($post instanceof WP_Post){
   $post_title = $post->post_title;
   $post_content = $post->post_content;

   // Get data relating to purchasers
   $purchasers = get_post_meta( $post_ID, "cs_group_purchase_member" ); 
   $total_units_ordered = 0;
   $purchaser_ids = array();
   foreach($purchasers as $meta_entry){
      array_push($purchaser_ids, $meta_entry['member_id']);
      $total_units_ordered += $meta_entry['units_ordered'];
   }

   // Get data about the offer
   $offer_ID = get_post_meta( $post_ID, "offer_id" )[0];
   $offer = get_post( $offer_ID );
   if($offer instanceof WP_Post){
      $offer_price = get_post_meta( $offer_ID, "unit_price" )[0];
      $offer_unit = get_post_meta( $offer_ID, "unit_name" )[0];
   } else{
      $error = true;
   }
} else{
   $error = true;
}
?>

<?php // Handle form data
   if(isset($_POST['purchase_amt'])){
      $enable_join = false;
      $user = wp_get_current_user();
      if($user->exists()){
         $meta_value = ['member_id' => $user->ID, 'units_ordered' => $_POST['purchase_amt']];
         add_post_meta( $post_ID, 'cs_group_purchase_member', $meta_value );
      }
   }
   else {
      $enable_join = true;
   }
?>

<?php if(!$error): /* If we were able to find all the data we need, display the HTML */ ?>

<div class="cs-margin-basic">
   <h6><?php echo $post_title ?></h6>
   <p>Price: $<?php echo $offer_price ?>/<?php echo $offer_unit ?></p>
   <p>Number of participants: <?php echo count($purchaser_ids) ?></p>
   <p>Total <?php echo $offer_unit ?>s ordered so far: <?php echo $total_units_ordered ?></p>
   <hr>
   <?php if( wp_get_current_user()->exists() ): // If user is logged in ?>
      <?php if( $enable_join ): // If we should allow user to join ?>
         <div class="cs-form-test">
            <h6>Participate in collective purchase:</h6>
            <form action="<?php echo get_permalink( ); ?>" method="POST">
               <label for="purchase_amt">How many <?php echo $offer_unit ?>s would you like?</label>
               <input type="number" id="purchase_amt" name="purchase_amt" min="0"><br>
               <input type="submit" value="Join Purchasing Group">
            </form>
         </div>
      <?php else: // If the user has already joined the group ?>
         <h6>Thank you for your offer of <?php echo $_POST['purchase_amt'] . " " . $offer_unit . "s!" ?></h6>
         <p>You will be notified when the purchase requirements have been met.</p>
      <?php endif; ?>
   <?php else: // If user is not logged in ?>
      <h6>Log in to participate in group purchase. </h6>
   <?php endif; ?>
</div>

<?php else: /* Display some error HTML if there was an error collecting necessary data. */ ?>

<div class="cs-margin-basic">
   <h4>Uh oh!</h4> 
   <p>Unable to locate some of the data needed for this page!</p>
   <p>Sorry :0</p>
   <p><i>- Ian</i></p>
</div>

<?php endif; ?>

