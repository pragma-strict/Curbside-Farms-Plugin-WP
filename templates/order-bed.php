<?
/**
 * @package CurbsideFarmsPlugin 
 */

if (! defined('ABSPATH')){
    die;
}

      //user posted variables
      // $name = 'name';
      // $email = 'ian@curbsidefarms.ca';
      //$message = "New bed order for: " . $_POST['name'];
      //$message .= " in " . $_POST['area'] . "\n";
      //$message .= "Return email: " . $_POST['email'];

      //php mailer variables
      // $to = 'ianrdejong@gmail.com';
      // $subject = "Report";
      // $headers = 'From: '. $email . "\r\n" .
      //    'Reply-To: ' . $email . "\r\n";
      
      //Here put your Validation and send mail
      //$sent = wp_mail($to, $subject, strip_tags($message), $headers);

      // ob_start();
      // //require_once( plugin_dir_path( __FILE__ ) . "/order-bed-confirmation.php" );
      // echo ob_get_clean();
      ?>

<link rel="stylesheet" href="<?php echo (plugins_url('curbside-farms/css/order-bed.css')); ?> ">

<div style='min-height: 2rem;'></div>

<div class="container" id="bed-order-template">
   <h3>Order a garden bed</h3>
   <p>All beds are handmade in Fairfield from repurposed wooden pallets</p>
   <hr>

   <form id="bed-order-form" action="#" method="post" data-url="<? echo admin_url('admin-ajax.php'); ?>">
      
      <div class="field-container">
         <input type='text' id='name' name='name' class="field" placeholder="First Name">
         <small id="name-error" class="field-message error">What should we call you?</small>
      </div>

      <div class="field-container">
         <input type='text' id='email' name='email' class="field" placeholder="Email">
         <small id="email-error" class="field-message error">Please enter a valid email address :)</small>
      </div>

      <div class="field-container">
         <select id='area' name='area' class="field">
            <option value="undefined">Select neighborhood</option>
            <option value='burnside-gorge'>Burnside Gorge</option>
            <option value='downtown-harris-green'>Downtown Harris Green</option>
            <option value='fairfield-gonzales'>Fairfield & Gonzales</option>
            <option value='fernwood'>Fernwood</option>
            <option value='hillside-quadra'>Hillside-Quadra</option>
            <option value='james-bay'>James Bay</option>
            <option value='jubilee'>Jubilee</option>
            <option value='north-park'>North Park</option>
            <option value='oaklands'>Oaklands</option>
            <option value='rockland'>Rockland</option>
            <option value='vic-west'>Vic West</option>
         </select>
         <small id="area-error" class="field-message">
            Your neighborhood helps us plan deliveries.
         </small>
      </div>

      <div class="field-container">
         <select id='number-of-beds' name='number-of-beds' class="field">
            <option value="undefined">Number of beds</option>
            <option value='1'>1</option>
            <option value='2'>2</option>
            <option value='3'>3</option>
            <option value='4'>4</option>
            <option value='5'>5</option>
            <option value='6'>6</option>
            <option value='7'>7</option>
            <option value='8'>8</option>
            <option value='9'>9</option>
            <option value='10'>10</option>
         </select>
         <small id="number-error" class="field-message">
            How many beds do you want?
         </small>
      </div>

      <div>
         <p>
            Total: $<span id="order-price"></span>
         </p>
      </div>

      <hr>

      <div class="field-container">
         <p>Note: We are currently working through a backlog of orders and will build yours as soon as possible. </p>
         <p>Also, we can <b>only accept cash</b> payments at the time of delivery until we upgrade our website. For questions, cancellations or alterations, email: ianrdejong@gmail.com</p>
         <button type='submit' class='btn btn-primary'>Place Order</button>
         <small id="submission-in-progress" class="field-message success">Submission in progress...</small>
      </div>
      
      <input type="hidden" name="action" value="submit_bed_order">
   </form>
</div>

<script type='text/javascript' src="<?php echo plugins_url("curbside-farms/js/order-bed.js"); ?>"></script>