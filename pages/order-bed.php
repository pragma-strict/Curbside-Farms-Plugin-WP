<?
/**
 * @package CurbsideFarmsPlugin 
 */

if (! defined('ABSPATH')){
    die;
}

if($_POST){
      //user posted variables
      $name = 'name';
      $email = 'ian@curbsidefarms.ca';
      $message = 'Test Mail';
      
      //php mailer variables
      $to = 'ianrdejong@gmail.com';
      $subject = "Report";
      $headers = 'From: '. $email . "\r\n" .
         'Reply-To: ' . $email . "\r\n";
      
      //Here put your Validation and send mail
      $sent = wp_mail($to, $subject, strip_tags($message), $headers);

      return "Sent mail! Thanks for submitting!";
      // Redirect to this page.
      //header( "Location: {../order-bed}", true, 303 );
      //exit();
   }
?>

<div style='min-height: 2rem;'></div>
<div class="container">
   <h3>Order a garden bed</h3>
   <p>All beds are handmade in Fairfield from locally-sourced wooden pallets</p>
   <hr>
   <form action='../order-bed' method='post'>
   <label for='name'>First name: </label>
   <input type='text' name='name' style='float:right'>
   <br>
   <label for='email'>Email: </label>
   <input type='email' name='email' style='float:right'>
   <br>
   <label for='area'>Neighborhood: </label>
   <select name='area' style='float:right' >
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
   <br>
   <label for='number-of-beds'>Number of beds: </label>
   <select name='number-of-beds' style='float:right'>
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
   <hr>
   <button type='submit' class='btn-primary'>Place Order</button>
   <p>Beds are $35 each. We can only accept payment at time of delivery for now.</p>
   <p>For cancellations or alterations, email: ianrdejong@gmail.com</p>
   </form>
</div>