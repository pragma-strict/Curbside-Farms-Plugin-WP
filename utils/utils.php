<?php

/* GLOBALS */
$_areas = array(
   'Vic West',
   'Esquimalt',
   'Cadboro Bay',
   'Fernwood',
   'Fairfield',
   'Downtown'
);


/* Return an array of useful data about a community order or false if failed. */
function get_community_order_data($post_ID){
   $post = get_post( $post_ID );
   if($post instanceof WP_Post){
      $post_title = $post->post_title;
      $post_content = $post->post_content;

      $location = get_post_meta( $post_ID, "order_location" )[0];

      // Get data relating to purchasers
      $purchasers = get_post_meta( $post_ID, "cs_group_purchase_member" ); 
      $total_units_ordered = 0;
      $member_ids = array();
      $order_amounts = array();
      foreach($purchasers as $meta_entry){
         array_push($member_ids, $meta_entry['member_id']);
         array_push($order_amounts, $meta_entry['units_ordered']);
         $total_units_ordered += $meta_entry['units_ordered'];
      }

      // Get data about the offer
      $offer_ID = get_post_meta( $post_ID, "offer_id", true );
      $offer = get_post( $offer_ID );
      if($offer instanceof WP_Post){
         $unit_price = get_post_meta( $offer_ID, "unit_price", true );
         $unit_price_original = get_post_meta( $offer_ID, "unit_price_original", true );
         $unit_name = get_post_meta( $offer_ID, "unit_name", true );
         $min_order = get_post_meta( $offer_ID, "min_units", true );
         $supplier = get_post_meta( $offer_ID, "supplier", true );
         $fixed_cost = get_post_meta( $offer_ID, "base_price", true );
      } else{
         return false;
      }
   } else{
      return false;
   }

   // Prepare and return array
   $data = [
      'title' => $post_title,
      'content' => $post_content,
      'location' => $location,
      'units_ordered' => $total_units_ordered,
      'member_ids' => $member_ids,
      'order_amounts' => $order_amounts,
      'unit_name' => $unit_name,
      'unit_price' => $unit_price,
      'unit_price_original' => $unit_price_original,
      'min_order' => $min_order,
      'fixed_cost' => $fixed_cost,
      'supplier' => $supplier
   ];
   return $data;
}

function insert_areas_as_options(){
   global $_areas;
   foreach($_areas as $area){
      echo "<option value='";
      echo str_replace(' ', '', $area);
      echo "'>";
      echo $area;
      echo "</option>";
   }
}

function insert_community_order_contributer_bar($member_ids, $order_amounts, $min_order){
   echo "<div class='cs-progress-bar'>";
   
   if(count($member_ids) == count($order_amounts)){

      // Get the total number of units ordered
      $total_units_ordered = array_sum($order_amounts);

      // Add filler divs for each order
      for($i = 0; $i < count($member_ids); $i++){
         $percent_units_ordered = $order_amounts[$i] / $total_units_ordered * 100;
         echo "<div class='cs-progress-bar-fill' style='width:";
         echo $percent_units_ordered;
         echo "%; background-color:#";
         $rand_col = dechex(255 - $percent_units_ordered);
         echo $rand_col . $rand_col . $rand_col;
         echo ";'></div>";
      }
   }

   echo "</div>";
}

?>