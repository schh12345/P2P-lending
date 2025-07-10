(() => {
    'use strict';
  
    const form = document.querySelector('.needs-validation');
    const email = document.getElementById('email');
    const emailError = document.getElementById('emailError');
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    console.log('yeah');
    // Function to validate email field
    function validateEmailField() {
      const emailInput = email.value.trim();
  
      if (!email) {
        email.classList.add('is-invalid');
        email.classList.remove('is-valid');
        emailError.textContent = 'Email is required.';
        return false;
      } else if (!emailRegex.test(emailInput)) {
        email.classList.remove('is-valid');
        email.classList.add('is-invalid');
        emailError.textContent='Please enter a valid email address.';
        return false;
      } else {
        email.classList.remove('is-invalid');
        email.classList.add('is-valid');
        emailError.textContent='';
        return true;
      }
    }
  
    // Live email validation as the user types
    email.addEventListener('input', validateEmailField);

   // Password validation
const password = document.getElementById('password');
const passwordError=document.getElementById('passwordError');


// prevent user to input space;
password.addEventListener('keypress', function(event) {
  if(event.key===' ') {
    event.preventDefault();
  }
})

function validatePasswordField() {
   const passwordInput=password.value;
   const regex=/.{8,}/;

   if (!passwordInput) {
    password.classList.remove('is-valid');
    password.classList.add('is-invalid');
    passwordError.textContent='password is required';
    return false;
   }
   if (passwordInput.length>=8) {
    password.classList.remove('is-invalid');
    password.classList.add('is-valid');
    passwordError.textContent='';
    return true;
   } else {
    password.classList.remove('is-valid');
    password.classList.add('is-invalid');
    passwordError.textContent='password must be at lease 8 characters';
    return false;
   }
}
  password.addEventListener('input', validatePasswordField);

    // Form submit validation
    
  form.addEventListener('submit', function(event) {
    let isEmailValide=validateEmailField();
    let isPasswordValid=validatePasswordField();
    if (!isEmailValide || !isPasswordValid) {
      event.preventDefault();
    }
  },false)
})()