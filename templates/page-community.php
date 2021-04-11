<?php 
/* 
Template Name: Community 
Template Post Type: page
*/ 

require __DIR__ . '/../custom/utils.php'; 
get_header(); // in the HTML body tag now ?>

<!-- Import the community page js -->
<script src="/wp-content/themes/Curbsite/js/community.js" type="text/javascript"></script>

<h1>Community</h1>

<!-- Tab links -->
<div class="tab">
   <button class="tablinks" onclick="showTab(event, 'Market')">Market</button>
   <button class="tablinks" onclick="showTab(event, 'Co-op')">Co-op</button>
   <button class="tablinks" onclick="showTab(event, 'Forum')">Forum</button>
   <button class="tablinks" onclick="showTab(event, 'Collective-purchasing')">Collective Purchasing</button>
</div>


<!------------------------------ 
         MARKET TAB
------------------------------->
<div id="Market" class="tabcontent">
<h3>Produce</h3>
<hr>
<?php 
   $produce_args = array(
   'post_type' => 'post',
   'category_name' => 'Produce' 
   ); 
   $q = new WP_Query($produce_args);

   // Loop through posts and display them (just their title for now)
   if ( $q->have_posts() ) : 
      while ( $q->have_posts() ) : $q->the_post(); ?>
      <div class="community-list-item">
         <h4><a href=<?php echo get_permalink() ?>> <?php the_title(); ?></a> </h4>
      </div>
      <?php endwhile; ?>
   <?php else : ?>
      <p><?php __('Nothing here! :0'); ?></p>
   <?php endif; ?>
</div>



<!------------------------------ 
            CO-OP TAB
------------------------------->
<div id="Co-op" class="tabcontent">
<h3>Co-op</h3>
<hr>
<?php
   $coop_args = array(
   'post_type' => 'post',
   'category_name' => 'Tasks, Decisions'
   ); 
   $q = new WP_Query($coop_args);
   if ( $q->have_posts() ) : 
      while ( $q->have_posts() ) : $q->the_post();   ?>
      <div class="community-list-item">
         <h4><a href=<?php echo get_permalink() ?>> <?php the_title(); ?></a></h4>

      <?php if( in_category( "Tasks" ) ) : ?>
         <div class="form-check">
            <label class="form-check-label">
               <input type="checkbox" class="form-check-input" name="" id="" value="checkedValue" unchecked>
               Task Completed
            </label>
         </div>
      
      <?php elseif( in_category( "Decisions" ) ) : ?>
         <form action="" method="post">
               <label for="decision-info">What we should do?</label>
               <input type="text" name="post_title"><br>
               <input type="submit" value="Submit Decision">
         </form>
      
      <?php endif; ?>

      </div>

      <?php endwhile; ?>
   <?php else : ?>
      <p><?php __('Nothing here! :0'); ?></p>
   <?php endif; ?>
</div>



<!------------------------------ 
            FORUM TAB
------------------------------->
<div id="Forum" class="tabcontent">
<h3>Forum</h3>
<hr>
<p>Forum goes here XD</p>
</div>



<!------------------------------ 
COLLECTIVE PURCHASING TAB
------------------------------->
<div id="Collective-purchasing" class="tabcontent">
<h3>Current Community Orders</h3>
<p>Filter by location: 
   <select name="location" id="location" onchange="filterCommunityOrders(this)">
      <option value="none">None</option>
      <?php insert_areas_as_options(); ?>
   </select>
   <a href="<?php echo home_url( 'new-collective-purchase-order' ); ?>" class="new-button right">
   + Initiate New Order</a>
</p>
<hr>
   <?php
      $community_page = get_page_by_path( 'community' );
      $produce_args = array(
      'post_type' => 'post',
      'category_name' => 'collective-purchase-order' 
      ); 
      $query = new WP_Query($produce_args);
      if ( $query->have_posts() ) : 
         while ( $query->have_posts() ) : $query->the_post(); 
            $post_data = get_community_order_data(get_the_ID());
            ?>

            <!-- Community Order HTML -->
            <div class="community-list-item <?php echo str_replace(' ', '', $post_data['location']); ?>">
               <h6><a href=<?php echo get_permalink() ?>> <?php the_title(); ?></a> </h6>
               <?php if($post_data['min_order'] > 0): ?>
                  <p><?php echo $post_data['units_ordered'] . "/" . $post_data['min_order']; ?> units ordered.</p>
               <?php else: 
                  $num_contributors = count($post_data['member_ids']);
                  if($num_contributors == 0){
                     $avg_savings = 0.00;
                  } else{
                     $avg_savings = $post_data['fixed_cost'] - $post_data['fixed_cost'] / count($post_data['member_ids']); 
                  }?>
               <p>Avg savings per order: $<?php echo $avg_savings; ?></p>
               <?php endif; ?>
               <?php insert_community_order_contributer_bar($post_data['member_ids'], $post_data['order_amounts'], $post_data['min_order']); ?>
            </div>

         <?php endwhile; ?>
      <?php else : ?>
         <p>No community orders right now.</p>
      <?php endif; ?>
</div>
