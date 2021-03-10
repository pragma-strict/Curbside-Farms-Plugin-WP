// Define a function to run when once the DOM is fully loaded.
document.addEventListener('DOMContentLoaded', function(e) {
   let bedOrderForm = document.getElementById('bed-order-form');

   // Clear error messages on input to any field
   bedOrderForm.querySelectorAll(".field").forEach(field => field.addEventListener('input', resetFieldMessages));

   // Define what happens when form is submitted
   bedOrderForm.addEventListener('submit', (e) => {
      
      // Prevent the default form submission behaviour so we can define our own
      e.preventDefault();  

      // Collect data from our form using querySelector on the form itself to avoid conflicts 
      let data = {
         name: bedOrderForm.querySelector("[id=name]").value,
         email: bedOrderForm.querySelector("[id=email]").value,
         area: bedOrderForm.querySelector("[id=area]").value,
         numberOfBeds: bedOrderForm.querySelector("[id=number-of-beds]").value
      }

      // If any bad input is found, add the error CSS and return. 
      // if(! data.name){
      //    bedOrderForm.querySelector("[id=name-error]").classList.add("show-message");
      //    bedOrderForm.querySelector("[id=name]").classList.add("show-message");
      //    return;
      // }

      // if(! data.email || !validateEmail(data.email)){
      //    bedOrderForm.querySelector("[id=email-error]").classList.add("show-message");
      //    bedOrderForm.querySelector("[id=email]").classList.add("show-message");
      //    return;
      // }

      // if(data.area == "undefined"){
      //    bedOrderForm.querySelector("[id=area-error]").classList.add("show-message");
      //    bedOrderForm.querySelector("[id=area]").classList.add("show-message");
      //    return;
      // }

      // if(data.numberOfBeds == "undefined"){
      //    bedOrderForm.querySelector("[id=number-error]").classList.add("show-message");
      //    bedOrderForm.querySelector("[id=number-of-beds]").classList.add("show-message");
      //    return;
      // }

      // Disable the button when ready to submit request
      let submitButton = bedOrderForm.querySelector("[type=submit]");
      submitButton.disabled = true;
      submitButton.innerHTML = "One moment please...";

      // Make the POST request with fetch()
      let url = bedOrderForm.dataset.url;
      let formData = new URLSearchParams(new FormData(bedOrderForm));
      //let urlReadyParams = new URLSearchParams(formData);
      let requestOptions = {
         method: "POST",
         body: formData
      }
      let testUrl = 'https://jsonplaceholder.typicode.com/posts';
      fetch(url, requestOptions)
      .then(response => response.json())
      .then(data => console.log(data))
   })
});

function resetFieldMessages(){
   document.querySelectorAll(".field-message").forEach(field => field.classList.remove('show-message'));
   document.querySelectorAll(".field").forEach(field => field.classList.remove("show-message"));
}

function validateEmail(email){
   let re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	return re.test(String(email).toLowerCase());
}