<?
/**
 * @package CurbsideFarmsPlugin 
 */

if (! defined('ABSPATH')){
    die;
}

function get_debug_page() {
   $curbsidePlugin = new CurbsidePlugin();
   $content = "";
   $pages_with_title = $curbsidePlugin->get_posts_with_title("Order Bed");
   foreach($pages_with_title as $page){
      $content .= ("<p>" . print_r($page) . "</p>");
      $content .= "<hr>";
   }
   return $content;
}
add_shortcode( 'debug_curbside', 'get_debug_page' );


/**
 * Note: For now this plugin will add pages unless pages with the same name already exist. On uninstall it will remove pages based on their name - if there are multiple pages with the same name it will remove the first one it finds. This is a problem because it might accidentally cause non-curbside pages to be removed but I'll sort that out later. 
 */

// Class contains most of the functionality of this plugin
class CurbsidePlugin
{ 
   // Titles of pages the plugin creates. Duplicates will not be added.
   public $curbside_page_titles = array(
      "Order Bed" => "[cs_order_bed]",
      "Vision" => "[cs_vision]"
   ); 
   public $curbside_page_meta_key = "curbside_farms_page";

   function activate(){
      $this->add_pages();
   }

   function deactivate(){
      $this->trash_pages();
   }

   static function uninstall(){
      //CurbsidePlugin::trash_pages();
   }

   // Add Curbside pages unless pages with the same name already exist.
   function add_pages(){ 
      foreach( $this->curbside_page_titles as $title => $shortcode){
         $posts_with_title = $this->get_posts_with_title( $title );
         if ( empty( $posts_with_title ) ){
               $post_args = array(
                  'post_title' => $title,
                  'post_content' => $shortcode,
                  'post_type' => 'page',
                  'post_status' => 'publish'
               );
               $post_id = wp_insert_post( $post_args );
               //add_post_meta( $post_id, $this->curbside_page_meta_key, $title, false );
         }
      }
      return $posts_with_title;
   }

   // Move Curbside pages to trash
   function trash_pages(){
      foreach( $this->curbside_page_titles as $title => $shortcode){
         $pages_with_title = $this->get_posts_with_title( $title );
         if ( !empty($pages_with_title) ){
               $post_to_delete = $pages_with_title[0];
               wp_delete_post( $post_to_delete->ID, false);
         }
      }
   }

   function get_cs_pages_by_query(){
      $meta_args = array(
         'meta_key' => 'curbside_farms_page',
         'post_type' => 'page',
         'post_status' => 'any',
         'posts_per_page' => -1
      );
      $existing_pages = new WP_Query($meta_args);
      $posts = $existing_pages->posts;
      return $posts;
   }

   // Return array of WP_Posts with meta keys matching the curbside page meta key
   function get_curbside_pages(){
      $get_post_args = array(
         //'meta_key' => $this->curbside_page_meta_key,
         'post_type' => 'page',
         'post_status' => 'any',
         'posts_per_page' => -1
      );
      $posts = get_posts( $get_post_args );
      return $posts;
   }

   function get_posts_with_title($title){
      $get_post_args = array(
         'title' => $title,
         'post_type' => 'page',
         'post_status' => 'any',
         'posts_per_page' => -1
      );
      $posts = get_posts( $get_post_args );
      return $posts;
   }

   public function submit_bed_order(){
      $name = sanitize_text_field( $_POST['name'] );
      $customer_email = sanitize_email( $_POST['email'] );
      $area = sanitize_text_field( $_POST['area'] );
      $bed_count = sanitize_text_field( $_POST['number-of-beds'] );
      
      $admin_public_email = "ian@curbsidefarms.ca";
      $admin_private_email = "ianrdejong@gmail.com";

      $this->send_customer_bed_order_email($name, $customer_email, $bed_count, $admin_public_email);
      $this->send_admin_bed_order_email($name, $customer_email, $bed_count, $area, $admin_public_email, $admin_private_email);
      wp_die();
   }
   
      function send_customer_bed_order_email($name, $email, $bed_count, $reply_email){
         $subject = "Garden Bed Order";
         $message = "Hi " . $name . ". We've received your order for " . $bed_count . " garden bed(s) and will contact you as soon as it's ready. Thank you very much for your interest in our project!";
         $headers = 'From: '. $reply_email . "\r\n" .
            'Reply-To: ' . $reply_email . "\r\n";
         wp_mail($email, $subject, strip_tags($message), $headers);
      }

   function send_admin_bed_order_email($name, $customer_email, $bed_count, $area, $reply_email, $admin_email){
      $subject = "New Bed Order Received";
      $message = "New order from " . $name . " (" . $customer_email . ") in " . $area . " for " . $bed_count . " beds.";
      $headers = 'From: '. $reply_email . "\r\n" .
         'Reply-To: ' . $reply_email . "\r\n";
      wp_mail($admin_email, $subject, strip_tags($message), $headers);
   }

   function get_order_bed(){
      ob_start();
      require_once(plugin_dir_path( __FILE__ ) . "../templates/order-bed.php");
      return ob_get_clean();
   }

   function get_vision(){
      ob_start();
      require_once(plugin_dir_path( __FILE__ ) . "../templates/about.php");
      return ob_get_clean();
   }

   function register_shortcodes(){
      add_shortcode( 'cs_order_bed', array( $this, 'get_order_bed' ) );
      add_shortcode( 'cs_vision', array( $this, 'get_vision' ) );
   }

   function register_actions(){
      add_action( 'wp_ajax_submit_bed_order', array( $this, 'submit_bed_order'));

      // This allows non-logged-in users to make submissions using the same php function. I think.
      add_action( 'wp_ajax_nopriv_submit_bed_order', array( $this, 'submit_bed_order'));
   }
}