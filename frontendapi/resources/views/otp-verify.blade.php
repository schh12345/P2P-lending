<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>otp-verify-P2P-lending</title>

    <!-- bootstrap stylesheet-->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- css template stylesheet-->
    <link href="css/otp-verify.css" rel="stylesheet">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet"> 

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!--Icon stylesheet-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <div class="otp-container">
        <div class="brand mb-2">LoanBridge</div>
        <div class="info">Enter the 6-digit code we sent to your email or phone</div>
    
        <form id="otpForm" novalidate>
          <div class="d-flex justify-content-center mb-3">
            <input type="text" class="form-control otp-input" maxlength="1" inputmode="numeric">
            <input type="text" class="form-control otp-input" maxlength="1" inputmode="numeric">
            <input type="text" class="form-control otp-input" maxlength="1" inputmode="numeric">
            <input type="text" class="form-control otp-input" maxlength="1" inputmode="numeric">
            <input type="text" class="form-control otp-input" maxlength="1" inputmode="numeric">
            <input type="text" class="form-control otp-input" maxlength="1" inputmode="numeric">
          </div>
          <div class="invalid-feedback text-center mb-2" id="otpError"></div>
          <button type="submit" class="btn btn-dark w-100">Verify</button>
          <div class="resend-link">
            Didn’t receive a code? <a href="#" id="resendBtn">Resend</a>
          </div>
        </form>
      </div>
    


    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/otp-verify.js"></script>

</body>
</html>