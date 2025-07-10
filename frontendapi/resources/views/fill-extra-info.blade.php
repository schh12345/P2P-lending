<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>fill-extra-info-P2P-lending</title>

    <!-- bootstrap stylesheet-->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- css template stylesheet-->
    <link href="css/fill-extra-info.css" rel="stylesheet">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet"> 

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!--Icon stylesheet-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  
</head>
<body>

    <div class="profile-form-container">
      <div class="brand mb-2">LoanBridge</div>
      <div class="section-title">Account Infomation</div>
  
      <form id="profileForm" class="needs-validation" novalidate>
        <div class="mb-3 d-flex justify-content-between">
          <div class="me-3">
            <label for="firstname" class="form-label visually-hidden">First Name</label>
            <input type="text" class="form-control" id="firstName" placeholder="First Name" required>
            <div class="invalid-feedback" id="firstError">First name is required.</div>
          </div>
          <div class="ms-3">
            <label for="lastname" class="form-label visually-hidden">Last Name</label>
            <input type="text" class="form-control" id="lastName" placeholder="Last Name" required>
            <div class="invalid-feedback" id="lastError">Last name is required</div>
         </div>
        </div>

        <div class="d-flex mb-3">
          <div class="form-check me-3">
            <input type="radio" class="form-check-input" id="male" name="gender" value="Male" required>
            <label class="form-check-label" for="male">Male</label>
            <div class="invalid-feedback" id="genderError" >Please choose your gender</div>
          </div>

          <div class="form-check ms-3">
            <input type="radio" class="form-check-input" id="female" name="gender" value="female" required>
            <label class="form-check-label" for="female">Female</label>
          </div>
        </div>
        
        <div class="mb-3">
          <label class="form-label visually-hidden" for="phone">Phone number</label>
          <div class="input-group has-validation">
            <!-- <span class="input-group-text" id="inputGroupPrepend3">+855</span> -->
            <input type="tel" class="form-control" id="phone" placeholder="Phone number" required>
            <div class="invalid-feedback" id="phoneError">Phone number is required</div>
          </div>
        </div>

        <div class="mb-3">
          <label for="password" class="form-label visually-hidden">Password</label>
          <input type="password" class="form-control" id="password" placeholder="Password" required>
          <div class="invalid-feedback" id="passwordError">Password must be at least 8 characters.</div>
          
        </div>
  
        <div class="mb-3">
          <label for="confirmPassword" class="form-label visually-hidden">Confirm Password</label>
          <input type="password" class="form-control" id="confirmPassword" placeholder="Confirm Password" required>
          <div class="invalid-feedback" id="confirmError">Passwords must match.</div>
        </div>
  
        <div class="mb-3">
          <label for="dob" class="form-label visually-hidden">Date of Birth</label>
          <input type="date" class="form-control" id="dob" required>
          <div class="invalid-feedback" id="dobError">Date of birth is required.</div>
        </div>
  
        <div class="mb-3">
          <label for="role" class="form-label visually-hidden">Role</label>
          <select class="form-select" id="role" required>
            <option value="" disabled selected>Select role</option>
            <option value="borrower">Borrower</option>
            <option value="lender">Lender</option>
          </select>
          <div class="invalid-feedback" id="roleError">Please select a role.</div>
        </div>
  
        <div class="mb-3">
          <label for="occupation" class="form-label visually-hidden">Occupation</label>
          <input type="text" class="form-control" id="occupation" placeholder="Occupation" required>
          <div class="invalid-feedback" id="occupationError">Occupation is required.</div>
        </div>
  
        <div class="mb-3">
          <label for="address" class="form-label visually-hidden">Address</label>
          <textarea class="form-control" id="address" rows="3" placeholder="Address" required></textarea>
          <div class="invalid-feedback" id="addressError">Address is required.</div>
        </div>
  
        <!-- <div class="mb-3">
          <label for="document" class="form-label">Upload ID or Passport</label>
          <input class="form-control" type="file" id="document" accept=".pdf,.jpg,.jpeg,.png" required>
          <div class="invalid-feedback" id="documentError">Please upload a valid ID or passport.</div>
        </div> -->
        <div class="upload-box mb-3">
         
          <div class="drop-area" id="drop-area">
            <i>📤</i>
            <p>Drag & Drop your files here<br></p>
            <label class="browse-btn" for="fileInput">Browse Files</label>
            <input type="file" id="fileInput" />
          </div>
      
          <div class="file-details" id="fileDetails" style="display: none;">
            <div class="file-info" id="fileInfo">
              <div class="icon" id="fileExt">TXT</div>
              <div class="name" id="fileName">File name</div>
            </div>
            <button class="cancel-btn" id="cancelBtn">&times;</button>
          </div>
        </div>
        <div id="fileError" class="mb-3"></div>
  
        <button type="submit" class="btn btn-dark w-100">Submit Profile</button>
      </form>
    </div>

    


<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/fill-extra-info.js"></script>
</body>
</html>