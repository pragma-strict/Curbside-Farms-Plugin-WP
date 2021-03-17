const BED_PRICE = 35;

let bedOrderForm;
let data;

// Define a function to run when once the DOM is fully loaded.
document.addEventListener('DOMContentLoaded', function(e) {
   bedOrderForm = document.getElementById('bed-order-form');
   data = getFormData();
   updateOrderPrice();

   // Add listener for input on all fields
   bedOrderForm.querySelectorAll(".field").forEach(field => field.addEventListener('input', inputReceived));

   // Define what happens when form is submitted
   bedOrderForm.addEventListener('submit', (e) => {
      
      // Prevent the default form submission behaviour so we can define our own
      e.preventDefault();  

      //If any bad input is found, add the error CSS and return. 
      if(! data.name){
         bedOrderForm.querySelector("[id=name-error]").classList.add("show-message");
         bedOrderForm.querySelector("[id=name]").classList.add("show-message");
         return;
      }

      if(! data.email || !validateEmail(data.email)){
         bedOrderForm.querySelector("[id=email-error]").classList.add("show-message");
         bedOrderForm.querySelector("[id=email]").classList.add("show-message");
         return;
      }

      if(data.area == "undefined"){
         bedOrderForm.querySelector("[id=area-error]").classList.add("show-message");
         bedOrderForm.querySelector("[id=area]").classList.add("show-message");
         return;
      }

      if(data.numberOfBeds == "undefined"){
         bedOrderForm.querySelector("[id=number-error]").classList.add("show-message");
         bedOrderForm.querySelector("[id=number-of-beds]").classList.add("show-message");
         return;
      }

      

      // Disable the button when ready to submit request
      let submitButton = bedOrderForm.querySelector("[type=submit]");
      submitButton.disabled = true;
      let sbOriginalHTML = submitButton.innerHTML;
      submitButton.innerHTML = "One moment please...";

      // Make the POST request with fetch()
      let url = bedOrderForm.dataset.url;
      let formData = new FormData(bedOrderForm);
      let urlReadyParams = new URLSearchParams(formData);
      let requestOptions = {
         method: "POST",
         body: urlReadyParams
      }
      fetch(url, requestOptions)
      .then(response => response.json())
      .catch(() => console.log("Something went wrong."))
      .then((data) => {
         bedOrderForm.innerHTML = 
         "<h3>Thank you!</h3>" + 
         "<p>You will receieve a confirmation email shortly.</p>";
         console.log(data);
      })
   })
});


// Called whenever there is input to the fields
function inputReceived(){
   resetFieldMessages();
   data = getFormData();
   updateOrderPrice();
}


// Get form data using querySelector on the form itself to avoid conflicts
function getFormData(){
   return {
      name: bedOrderForm.querySelector("[id=name]").value,
      email: bedOrderForm.querySelector("[id=email]").value,
      area: bedOrderForm.querySelector("[id=area]").value,
      numberOfBeds: bedOrderForm.querySelector("[id=number-of-beds]").value
   }
}

function resetFieldMessages(){
   document.querySelectorAll(".field-message").forEach(field => field.classList.remove('show-message'));
   document.querySelectorAll(".field").forEach(field => field.classList.remove("show-message"));
}

function updateOrderPrice(){
   let orderCostElement = document.getElementById('order-price');
   let cost = "0.00";
   if(data.numberOfBeds != "undefined"){
      cost = (data.numberOfBeds * BED_PRICE) + ".00";
   }
   orderCostElement.innerHTML = cost;
}

function validateEmail(email){
   let re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	return re.test(String(email).toLowerCase());
}