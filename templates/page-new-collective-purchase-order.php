<?php 
get_header(); 
require __DIR__ . '/custom/utils.php'; 
?>


<div class="cs-margin-basic">
   <h2>Set up a new community order.</h2>
   <p>This is great if you would like to organize with your neighbors and agree to make a group purchase in order to get better prices!</p>
   <a href="<?php echo home_url( 'add-collective-purchasing-offer' ); ?> " class="new-button">
   + Register New Offer</a>
   <hr>
   <div class="cs-form-test">
      <form action="/new-collective-purchase-order-handler" method="post" autocomplete="off">
         <input type="hidden" id="post_category_id" name="post_category_id" value="
            <?php
               $order_cat_ID = 0;
               $order_cat = get_category_by_slug( "collective-purchase-order" );
               if($order_cat instanceof WP_Term){
                  $order_cat_ID = $order_cat->term_id;
               } 
               echo $order_cat_ID; 
            ?> 
         ">
         <!-- meta -->
         <label for="meta_offer_id">What to order:</label>
         <select name="meta_offer_id" id="meta_offer_id">
            <?php
               $offer_cat = get_category_by_slug( "collective-purchase-opportunity" );
               if($offer_cat instanceof WP_Term){
                  $get_post_args = array(
                     'numberposts' => -1,
                     'category' => $offer_cat->term_id
                  ); 
                  $offer_posts = get_posts( $get_post_args );
                  foreach($offer_posts as $offer){
                     echo "<option value='" . $offer->ID . "'>" . $offer->post_title . "</option>";
                  }
               }
            ?>
         </select><br>
         <label for="meta_order_location">Neighborhood:</label>
         <select name="meta_order_location" id="meta_order_location">
            <?php insert_areas_as_options(); ?>
         </select><br>
         <input type="submit" value="Make Post">
      </form>
   </div>
</div>

<?php 
get_footer();
?>