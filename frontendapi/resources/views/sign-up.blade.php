<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>sign-up-P2P-lending</title>

    <!-- bootstrap stylesheet-->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- css template stylesheet-->
    <link href="css/sign-up.css" rel="stylesheet">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet"> 

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

   <!--Icon stylesheet-->
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  
<body>

    <div class="signup-container">
        <div class="brand mb-2">LoanBridge</div>
        <div class="tagline">Join the trusted community of peer-to-peer lenders & borrowers</div>
    
        <form class="needs-validation" novalidate>
          <div class="mb-0">
            <label for="email" class="form-label visually-hidden">Enter your email to get started</label>
            <input type="email" class="form-control" id="email" placeholder="Email address" required>
            <div class="invalid-feedback" id="emailError">Email is required</div>
          </div>
         
          <div class="info-box mt-1 mb-3">
            Please make sure that this is the email you want to use for your account.
          </div>

          <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" value="" id="invalidCheck" required>
            <label class="form-check-label" for="invalidCheck">
                By signing up you agree with our <a href="#">terms & conditions</a> and <a href="#">Privacy Policy</a>
            </label>
            <div class="invalid-feedback checkError">
                You must agree before submitting.
            </div>
          </div>

          <button type="submit" class="btn btn-dark w-100">Continue with Email</button>
        </form>
    
        <!-- <div class="divider"><span>OR</span></div>
        
        <a href="#" class="btn btn-outline-dark w-100">Start with Phone Number</a> -->
    
        <div class="mt-3 text-center">
          <small>Already have an account? <a href="/log-in">Log in</a></small>
        </div>
      </div>


    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/sign-up.js"></script>
</body>
</head>