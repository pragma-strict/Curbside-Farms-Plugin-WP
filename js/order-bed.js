// Define a function to run when once the DOM is fully loaded.
document.addEventListener('DOMContentLoaded', function(e) {
   let bedOrderForm = document.getElementById('bed-order-form');

   bedOrderForm.addEventListener('submit', (e) => {
      e.preventDefault();
      console.log("submit attempted!");
   })
});