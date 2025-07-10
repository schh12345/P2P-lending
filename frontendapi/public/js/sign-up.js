// 
(() => {
    'use strict';
  
    const form = document.querySelector('.needs-validation');
    const emailInput = document.getElementById('email');
    const emailError = document.getElementById('emailError');
    const invalidCheck= document.getElementById('invalidCheck');
    const checkError=document.getElementsByClassName('checkError');
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  
    // Function to validate email field
    function validateEmailField() {
      const email = emailInput.value.trim();
  
      if (!email) {
        emailInput.classList.add('is-invalid');
        emailInput.classList.remove('is-valid');
        emailError.textContent = 'Email is required.';
        return false;
      } else if (!emailRegex.test(email)) {
        emailInput.classList.add('is-invalid');
        emailInput.classList.remove('is-valid');
        emailError.textContent = 'Please enter a valid email address.';
        return false;
      } else {
        emailInput.classList.remove('is-invalid');
        emailInput.classList.add('is-valid');
        emailError.textContent = '';
        return true;
      }
    }

    
    // Live email validation as the user types
    emailInput.addEventListener('input', validateEmailField);
  
    // Form submit validation
    form.addEventListener('submit', function (event) {
      const isEmailValid = validateEmailField();
  
      if (!form.checkValidity()) {
        event.preventDefault();
        event.stopPropagation();
      } 
  
      form.classList.add('was-validated');
    }, false);
  })();
  