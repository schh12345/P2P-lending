(() => {
  'use strict';
  const form = document.querySelector('.needs-validation');

  const firstname=document.getElementById('firstName');
  const firstError=document.getElementById('firstError');

  function validateFirstNameField() {
    const firstNameInput=firstname.value.trim();
    if (!firstNameInput) {
      firstError.textContent='First name is required';
      firstname.classList.remove('is-valid');
      firstname.classList.add('is-invalid');
      return false;
    } else {
      firstError.textContent='';
      firstname.classList.remove('is-invalid');
      firstname.classList.add('is-valid');
      return true;
    }
  }
  firstname.addEventListener('input', validateFirstNameField);

// validate last name
  const lastName=document.getElementById('lastName');
  const lastError=document.getElementById('lastError');

  function validateLastNameField() {
    const lastNameInput=lastName.value.trim();
    if (!lastNameInput) {
      lastError.textContent='Last name is required';
      lastName.classList.remove('is-valid');
      lastName.classList.add('is-invalid');
      return false;
    } else {
      lastError.textContent='';
      lastName.classList.remove('is-invalid');
      lastName.classList.add('is-valid');
      return true;
    }
  }

  lastName.addEventListener('input', validateLastNameField);

  //validation gender
  const selectGender=document.querySelector('input[name="gender"]');
  const male=document.getElementById('male');
  const female=document.getElementById('female');
  const genderError=document.getElementById('genderError');
  

  function validateGenderField() {
    
    if (!male.checked && !female.checked) {
      genderError.textContent='Gender is required';
      female.classList.add('is-invalid');
      male.classList.add('is-invalid');
      return false;
    } else {
      genderError.textContent='';
      female.classList.remove('is-invalid');
      male.classList.remove('is-invalid');
      return true;
    }
  }
  female.addEventListener('change', validateGenderField);
  male.addEventListener('change', validateGenderField);



//validation phone number
const phone = document.getElementById('phone');
const phoneError=document.getElementById('phoneError')

function validatePhonefield() {
  const phoneInput = phone.value.trim();
  let normalized = phoneInput.startsWith('+855') ? phoneInput : phoneInput.replace(/^0/, '+855');
  const regex = /^\+855(1\d{7}|[2-9]\d{7,8})$/;
  
  if (!phoneInput) {
    phone.classList.remove('is-valid');
    phone.classList.add('is-invalid');
    phoneError.textContent='phone number is require';
    return false;
  } else if (!regex.test(normalized)) {
    phone.classList.remove('is-valid');
    phone.classList.add('is-invalid');
    phoneError.textContent='Please enter a valid phone number';
    return false;
  } else {
    phone.classList.remove('is-invalid');
    phone.classList.add('is-valid');
    phoneError.textContent='';
    return true;
  }
}

 // Live phone validation as the user types
 phone.addEventListener('input', validatePhonefield);
 

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

// password comfirmation validation
const confirmError = document.getElementById('confirmError');
const confirmPassword = document.getElementById('confirmPassword');


function checkPasswordMatch() {
  const confirmPasswordInput=confirmPassword.value;
  if (!confirmPasswordInput){
    confirmPassword.classList.remove('is-valid');
    confirmPassword.classList.add('is-invalid');
    confirmError.textContent='confirm password is required';
    return false;
  }
  if (confirmPasswordInput!==password.value) {
    confirmPassword.classList.remove('is-valid');
    confirmPassword.classList.add('is-invalid');
    confirmPassword.setCustomValidity("Passwords do not match");
    confirmError.textContent = "Passwords do not match";
    return false;
  } else {
    confirmPassword.setCustomValidity("");
    confirmPassword.classList.remove('is-invalid');
    confirmPassword.classList.add('is-valid');
    confirmError.textContent = "";
    return true;
  }
}

confirmPassword.addEventListener('input', checkPasswordMatch);

//validate role
const role=document.getElementById('role');
const roleError=document.getElementById('roleError');

function validateRoleField() {
  if (role.value==='') {
    roleError.textContent='role is required';
    role.classList.remove('is-valid');
    role.classList.add('is-invalid');
    return false;
  } else {
    roleError.textContent='';
    role.classList.remove('is-invalid');
    role.classList.add('is-valid');
    return true;
  }
}

role.addEventListener('change', validateRoleField);

// validate occupation 
const occupation=document.getElementById('occupation');
const occupationError=document.getElementById('occupationError');

function validateOccupationField() {
  const occupationInput=occupation.value.trim();
  if (!occupationInput) {
    occupationError.textContent='Occupation is required';
    occupation.classList.remove('is-valid');
    occupation.classList.add('is-invalid');
    return false
  } else {
    occupationError.textContent='';
    occupation.classList.remove('is-invalid');
    occupation.classList.add('is-valid');
    return true;
  }
}
occupation.addEventListener('input', validateOccupationField);

// validate adress
const address=document.getElementById('address');
const addressError=document.getElementById('addressError');
function validateAddressField() {
  const addressInput=address.value.trim();
  if (!addressInput) {
    addressError.textContent='Address is required';
    address.classList.remove('is-valid');
    address.classList.add('is-invalid');
    return false;
  } else {
    addressError.textContent='';
    address.classList.remove('is-invalid');
    address.classList.add('is-valid');
    return true;
  }
}

address.addEventListener('input', validateAddressField);

// validate file upload
const dropArea = document.getElementById('drop-area');
  const fileInput = document.getElementById('fileInput');
  const fileDetails = document.getElementById('fileDetails');
  const fileInfo = document.getElementById('fileInfo');
  const fileExt = document.getElementById('fileExt');
  const fileName = document.getElementById('fileName');
  const cancelBtn = document.getElementById('cancelBtn');
  const fileError=document.getElementById('fileError');

  let currentFileURL = null;

  fileInput.addEventListener('change', (e) => {
    handleFile(e.target.files[0]);
  });

  dropArea.addEventListener('dragover', (e) => {
    e.preventDefault();
    dropArea.style.background = "#f0f0ff";
  });

  dropArea.addEventListener('dragleave', () => {
    dropArea.style.background = "#f9f9ff";
  });

  dropArea.addEventListener('drop', (e) => {
    e.preventDefault();
    const file = e.dataTransfer.files[0];
    fileInput.files = e.dataTransfer.files;
    handleFile(file);
  });

  function handleFile(file) {
    const allowedTypes = ['application/pdf'];
    const maxSizeMB = 5;

    if (!file) {
      fileError.textContent="file is required";
      fileError.style.color='red';
      return false;
    }

    if (!allowedTypes.includes(file.type)) {
      fileError.textContent="Only PDF files are allowed.";
      fileError.style.color='red';
      fileInput.value = '';
      return false;
    }

    if (file.size > maxSizeMB * 1024 * 1024) {
      fileError.textContent=`File size should be under ${maxSizeMB} MB.`;
      fileError.style.color='red';
      fileInput.value = '';
      return false;
    }

    const ext = file.name.split('.').pop().toUpperCase();
    fileExt.textContent = ext;
    fileName.textContent = `${file.name} (${(file.size / 1024).toFixed(1)} KB)`;
    currentFileURL = URL.createObjectURL(file);
    fileDetails.style.display = 'flex';
    fileError.textContent='';
    return true;
  }

  cancelBtn.addEventListener('click', () => {
    fileInput.value = '';
    fileDetails.style.display = 'none';
    if (currentFileURL) {
      URL.revokeObjectURL(currentFileURL);
      currentFileURL = null;
    }
  });

  fileInfo.addEventListener('click', () => {
    if (currentFileURL) {
      window.open(currentFileURL, '_blank');
    }
  })  

// validate date input
const dob=document.getElementById('dob');
const dobError=document.getElementById('dobError');

function validateDobField() {
  const dobInput=dob.value;
  const timestampt=Date.parse(dobInput);
  if (!isNaN(timestampt)) {
    dob.classList.remove('is-invalid');
    dob.classList.add('is-valid');
    dobError.textContent='';
    return true;
  } else {
    dob.classList.remove('is-valid');
    dob.classList.add('is-invalid');
    dobError.textContent='Date of birth is required';
    return false;
  }
}
dob.addEventListener('input', validateDobField);

form.addEventListener('submit', function(e) {
  let isfirstValid=validateFirstNameField();
  let islastValid=validateLastNameField();
  let isgenderValid=validateGenderField();
  let isphoneValid=validatePhonefield();
  let isPasswordValid=validatePasswordField();
  let ischeckPasswordValid=checkPasswordMatch();
  let isRoleValidate=validateRoleField();
  let isOccupationValidate=validateOccupationField();
  let isAddressValidate=validateAddressField();
  let isfileValid=handleFile(fileInput.files[0])
  let isDobvalid=validateDobField();
  if (!isfirstValid ||!islastValid ||!isgenderValid || !isphoneValid || !isPasswordValid || !ischeckPasswordValid || !isRoleValidate || !isOccupationValidate || !isAddressValidate || !isfileValid || !isDobvalid) {
    e.preventDefault();
    console.log('yeah')
  }
  console.log('yeah');
  // form.classList.add('was-validated')
},false)
})()
