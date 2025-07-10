<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>P2P-lending</title>

    <!-- bootstrap stylesheet-->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- css template stylesheet-->
    <link href="css/style.css" rel="stylesheet">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet"> 

   <!--Icon stylesheet-->
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  
</head>
<body>
    
    <!--navigation-->
    @include("layout.navigation");
    <!--navigation-->
    

    <!-- hero header -->
    <div class="container-fluid bg-primary py-5 mb-5 hero-header">
        <div class="container my-5 py-5 px-lg-5">
            <div class="row g-5 py-5">
                <div class="col-lg-6 text-center text-lg-start">
                    <h1 class="text-white mb-4 animated zoomIn">LoanBridge Quick & Easy</h1>
                    <p class="text-white pb-3 animated zoomIn">This is the first lending marketplace plateform in Cambodia. We try to briul a community that user can support with each other.</p>
                    <a href="" class="btn btn-light py-sm-3 px-sm-5 rounded-pill me-3">Sign Up Now</a>
                    <a href="" class="btn btn-outline-light py-sm-3 px-sm-5 rounded-pill animated slideInRight">Contact Us</a>
                </div>
                <div class="col-lg-6 text-center text-lg-start">
                    <img class="img-fluid" src="img/Peer-To-Peer-Lending.png" alt="hero-header">
                </div>
            </div>
        </div>

    </div>



    <!--footer-->
    @include("layout.footer");
    <!--footer-->

<!-- bootstrap js-->
<script src="js/bootstrap.bundle.min.js"></script>



</body>
</html>