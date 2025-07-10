<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login-P2P-lending</title>

    <!-- bootstrap stylesheet-->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- css template stylesheet-->
    <link href="css/login.css" rel="stylesheet">

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

    <div class="login-container">
        <div class="brand mb2">LoanBridge</div>
        <div class="tagline">Welcome back</div>
        <form class="needs-validation mb-3" novalidate>
            <div class="mb-4">
                <label for="email" class="form-label visually-hidden">Email address</label>
                <input type="email" class="form-control" id="email" placeholder="Email Address" required>
                <div class="invalid-feedback" id="emailError">Email is required</div>
            </div>
            <div class="mb-4">
                <label for="password" class="form-label visually-hidden">password</label>
                <input type="password" class="form-control" id="password" placeholder="Password" required>
                <div class="invalid-feedback" id="passwordError">password is required</div>
            </div>
            
                <button type="submit" class="btn btn-dark w-100">Continue</button>
            
        </form>
        <div class="mb-3 d-flex justify-content-center">Don't have an account? <a href="/sign-up" class="ms-2">Sign up</a></div>
        <div class="d-flex justify-content-center term">
            <a href="#" class="me-3">Terms of Condition</a>
            <p>|</p>
            <a href="#" class="ms-3">Privacy Policy</a>
        </div>
    </div>

    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/login.js"></script>

    </body>
    </html>