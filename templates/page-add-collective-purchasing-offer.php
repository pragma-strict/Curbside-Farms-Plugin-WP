<?php get_header();?>


<div class="cs-margin-basic">
   <h2>Add a collective purchasing offer.</h2>
   <p>Admins can use this to let members know about a bulk-purchasing opportunity.</p>
   <hr>
   <div class="cs-form-test">
      <form action="/add-collective-purchasing-offer-handler" method="post" autocomplete="off">
         <!-- Data to go into the post -->
         <label for="post_title">Offer Title:</label>
         <input type="text" id="post_title" name="post_title"><br>

         <label for="post_content">Description:</label>
         <input type="text" id="post_content" name="post_content"><br>

         <input type="hidden" id="post_category_slug" name="post_category_slug" value="collective-purchase-opportunity">

         <!-- post_meta data -->
         <label for="meta_unit_name">Unit Name (ie. 100 seeds):</label>
         <input type="text" id="meta_unit_name" name="meta_unit_name"><br>

         <label for="meta_min_units">Minimum Units Required For Offer:</label>
         <input type="number" id="meta_min_units" name="meta_min_units" value="0" min="0" step=".01"><br>

         <label for="meta_unit_price">Unit Price:</label>
         <input type="number" id="meta_unit_price" name="meta_unit_price" value="0.00" min="0" step=".01"><br>

         <label for="meta_unit_price_original">Unit Price Without Offer:</label>
         <input type="number" id="meta_unit_price_original" name="meta_unit_price_original" value="0.00" min="0" step=".01"><br>

         <label for="meta_base_price">Fixed Cost To Order (ie. delivery):</label>
         <input type="number" id="meta_base_price" name="meta_base_price" value="0.00" min="0" step=".01"><br>

         <label for="meta_supplier">Supplier Name:</label>
         <input type="text" id="meta_supplier" name="meta_supplier"><br>

         <input type="submit" value="Post Offer">
      </form>
   </div>
</div>

<?php 
get_footer();
?>