// Define a function to run when once the DOM is fully loaded.
document.addEventListener('DOMContentLoaded', function(e) {
   let bedOrderForm = document.getElementById('bed-order-form');

   // Define what happens when form is submitted
   bedOrderForm.addEventListener('submit', (e) => {
      
      // Prevent the default form submission behaviour so we can define our own
      e.preventDefault();  

      // Handle all validation, form messages, data and ajax here...
   })
});