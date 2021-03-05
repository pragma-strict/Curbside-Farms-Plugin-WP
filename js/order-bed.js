/**
 * Trying to send the form data with AJAX instead of normal thing. Currently getting all values from the fields and sending a post request here, though I'm sending it to the file argument which, for now, is about.php and this is giving a 403 when I send to it. I'm using about.php as a test space. If I can just get my php page to recieve my post request then I can stick the data in the database and use js to hide the form on submit. Kind of nice to be using js like this.
 */


function sendData( file, data ) {
   console.log( 'Sending data' );

   const request = new XMLHttpRequest();

   let urlEncodedData = "",
      urlEncodedDataPairs = [],
      name;

   // Turn the data object into an array of URL-encoded key/value pairs.
   for( name in data ) {
      //console.log(name);
      urlEncodedDataPairs.push( encodeURIComponent( name ) + '=' + encodeURIComponent( data[name] ) );
   }

   // Combine the pairs into a single string and replace all %-encoded spaces to
   // the '+' character; matches the behavior of browser form submissions.
   urlEncodedData = urlEncodedDataPairs.join( '&' ).replace( /%20/g, '+' );

   request.addEventListener('readystatechange', () => {console.log(request.readyState)})

   // Define what happens on successful data submission
   request.addEventListener( 'load', function(event) {
      alert( 'Yeah! Data sent and response loaded.' );
   } );

   // Define what happens in case of error
   request.addEventListener( 'error', function(event) {
      alert( 'Oops! Something went wrong.' );
   } );

   // Set up our request
   request.open( 'POST', file );

   // Add the required HTTP header for form data POST requests
   request.setRequestHeader( 'Content-Type', 'application/x-www-form-urlencoded' );

   // Finally, send our data.
   request.send( urlEncodedData );
   }
   
   function submit_bed_order(file, outputFieldClassName){
      var fieldElements = document.getElementsByClassName(outputFieldClassName);
      var values = [];
      for(var i = 0; i < fieldElements.length; i++){
         values.push(fieldElements[i].value);
         console.log(fieldElements[i].value);
      }
      sendData(file, values);
      return false;
   }