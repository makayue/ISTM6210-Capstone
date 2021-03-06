<?php
// Start the session
session_start();
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <title>FosterFinder &mdash; Our Shelters</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Nanum+Gothic:400,700,800" rel="stylesheet">
    <link rel="stylesheet" href="fonts/icomoon/style.css">

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">
    <link rel="stylesheet" href="css/jquery-ui.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">

    <link rel="stylesheet" href="css/bootstrap-datepicker.css">

    <link rel="stylesheet" href="fonts/flaticon/font/flaticon.css">

    <link rel="stylesheet" href="css/aos.css">
    <link rel="stylesheet" href="css/rangeslider.css">

    <link rel="stylesheet" href="css/style.css">
    <link rel='stylesheet' href='css/mystyles.css'>

  </head>
  <body>

    <?php
    if (isset($_SESSION['firstName'])) {
      $firstName = $_SESSION['firstName'];
      if (isset($_SESSION['applicationId'])) {
        $buttonCaption = 'View Available Animals';
        $buttonLink = 'listings.php';
      } else {
        $buttonCaption = 'Submit Foster Application';
        $buttonLink = 'fosterApplication.php';
      }
    } else {
      $firstName = 'Visitor';
      $buttonCaption = 'Log In/Sign Up';
      $buttonLink = '../userlogin.php';
    }

    if(isset($_GET['animalId'])) {
      $_SESSION['animalId'] = $_GET['animalId'];
    }

    if(isset($_GET['species'])) {
      $_SESSION['species'] = $_GET['species'];
    }

    if(isset($_GET['species'])) {
      $_SESSION['species'] = $_GET['species'];
    }
     ?>

  <div class="site-wrap">

    <div class="site-mobile-menu">
      <div class="site-mobile-menu-header">
        <div class="site-mobile-menu-close mt-3">
          <span class="icon-close2 js-menu-toggle"></span>
        </div>
      </div>
      <div class="site-mobile-menu-body"></div>
    </div>

    <header class="site-navbar container py-0 bg-white" role="banner">

      <!-- <div class="container"> -->
        <div class="row align-items-center">

          <div class="col-6 col-xl-2">
            <h1 class="mb-0 site-logo"><a href="fosterFinder.php" class="text-black mb-0">Foster<span class="text-primary">Finder</span>  </a></h1>
          </div>
          <div class="col-12 col-md-10 d-none d-xl-block">
            <nav class="site-navigation position-relative text-right" role="navigation">

              <ul class="site-menu js-clone-nav mr-auto d-none d-lg-block">
                <li class="active"><a href="fosterFinder.php">Home</a></li>
                <li><a href="shelters.php">Shelters</a></li>
                <li class="has-children">
                  <a href="fosterFinder.php">Fosters</a>
                  <ul class="dropdown">
                    <li><a href="becomeAFoster.php">Become a Foster</a></li>
                    <li><a href="listings.php">Available Animals</a></li>
                  </ul>
                </li>
				        <li><a href="about.php">About Us</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li class="ml-xl-3 login active"><span class="border-left pl-xl-4"></span><?php echo 'Welcome, ' . $firstName;?></li>

                <li><a href="<?php echo $buttonLink;?>" class="cta"><span class="bg-primary text-white rounded"><?php echo $buttonCaption;?></span></a></li>
              </ul>
            </nav>
          </div>


          <div class="d-inline-block d-xl-none ml-auto py-3 col-6 text-right" style="position: relative; top: 3px;">
            <a href="#" class="site-menu-toggle js-menu-toggle text-black"><span class="icon-menu h3"></span></a>
          </div>

        </div>
      <!-- </div> -->

    </header>



    <div class="site-blocks-cover inner-page-cover overlay" style="background-image: url(images/hero_3.jpg);" data-aos="fade" data-stellar-background-ratio="0.5">
      <div class="container">
        <div class="row align-items-center justify-content-center text-center">

          <div class="col-md-10" data-aos="fade-up" data-aos-delay="400">


            <div class="row justify-content-center mt-5">
              <div class="col-md-8 text-center">
                <h1>Our Shelters</h1>
                <p class="mb-0">The backbone of FosterFinder</p>
              </div>
            </div>


          </div>
        </div>
      </div>
    </div>

    <div class="site-section justify-content-center"  data-aos="fade">
      <div class="container">


        <div class="row justify-content-center mb-5">
          <div class="col-md-8 text-center">
            <p>Without our shelters, FosterFinder could never reach our goal of zero shelter animals euthanized in the US. They are the backbone that
               allows us to contribute to this effort.</p>
            <p>Through the FosterFinder system, you can register with two or more of the shelters listed below and access the
               hundreds of animals looking for foster homes.</p>
          </div>
        </div>
        <div class='justify-content-center'>
            <div class="row mb-5">
              <div class="col-md-7 text-left border-primary">
                <h2 class="font-weight-light text-primary">Shelters</h2>
              </div>
            </div>
            <div class="row col-md-8">
              <div class="col-12  block-13 justify-content-center">
                <?php
                //Connecting to the database
                $server = [REDACTED];
                $username = [REDACTED];
                $password = [REDACTED];
                $db = [REDACTED];

                // Create connection
                $conn = new mysqli($servername, $username, $password, $db);

                // Check connection
                if ($conn->connect_error) {
                  die("Connection failed: " . $conn->connect_error);
                }

                $sql = "SELECT shelterName,
                               concat(shelterAddress, ', ', shelterCity, ', ', shelterState, ' ', shelterZip) AS address,
                               shelterPhoneNumber AS phone
                        FROM shelters
                        WHERE euthStatus = 'no euthanasia'
                        ORDER BY shelterName";

                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                  //output data of each row
                  while($row = $result->fetch_assoc()) {
                    $shelterName = $row['shelterName'];
                    echo
                    '<div class="card shadow mb-4 d-block d-md-flex listing vertical">
                      <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">' . $shelterName . '</h6>
                      </div>
                      <div class="card-body">
                        <div class="table">
                          <table class="table table-bordered table-sm table-fixed" width="100%" cellspacing="0">
                                     <tr><th style="width: 25%">Address</th><td style="width: 75%">' . $row ['address'] . '</td></tr>
                                         <tr><th>Phone Number</th><td>' . $row['phone'] . '</td></tr>
                          </table>
                        </div>

                      </div>
                    </div>';

                  }
                }


                ?>
              </div>
            </div>
      </div>
        <!--End Shelter Listings-->
      </div>
    </div>

    <div class="newsletter bg-primary py-5">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-md-6">
            <h2>Newsletter</h2>
            <p>To follow what we are doing, subscribe to our weekly newsletter!</p>
          </div>
          <div class="col-md-6">

            <form class="d-flex">
              <input type="text" class="form-control" placeholder="Email">
              <input type="submit" value="Subscribe" class="btn btn-white">
            </form>
          </div>
        </div>
      </div>
    </div>


    <footer class="site-footer">
      <div class="container">
        <div class="row">
          <div class="col-md-9">
            <div class="row">
              <div class="col-md-6">
                <h2 class="footer-heading mb-4">About</h2>
                <p>FosterFinder is a web-based information system that automates the fostering process and monitors animal registration to reduce the number of animals euthanized in the DMV area.</p>
              </div>

              <div class="col-md-3">
                <h2 class="footer-heading mb-4">Navigations</h2>
                <ul class="list-unstyled">
                  <li><a href="about.php">About Us</a></li>
                  <li><a href="shelters.php">Shelters</a></li>
                  <li><a href="becomeAFoster.php">Become A Foster</a></li>
                  <li><a href="contact.php">Contact Us</a></li>
                </ul>
              </div>
              <div class="col-md-3">
                <h2 class="footer-heading mb-4">Follow Us</h2>
                <a href="#" class="pl-0 pr-3"><span class="icon-facebook"></span></a>
                <a href="#" class="pl-3 pr-3"><span class="icon-twitter"></span></a>
                <a href="#" class="pl-3 pr-3"><span class="icon-instagram"></span></a>
                <a href="#" class="pl-3 pr-3"><span class="icon-linkedin"></span></a>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <form action="#" method="post">
              <div class="input-group mb-3">
                <input type="text" class="form-control border-secondary text-white bg-transparent" placeholder="Search animals..." aria-label="Enter Email" aria-describedby="button-addon2">
                <div class="input-group-append">
                  <button class="btn btn-primary text-white" type="button" id="button-addon2">Search</button>
                </div>
              </div>
            </form>
          </div>
        </div>
        <div class="row pt-5 mt-5 text-center">
          <div class="col-md-12">
            <div class="border-top pt-5">
            <p>
            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
            Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="icon-heart" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank" >Colorlib</a>
            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
            </p>
            </div>
          </div>

        </div>
      </div>
    </footer>
  </div>

  <script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/jquery-migrate-3.0.1.min.js"></script>
  <script src="js/jquery-ui.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/jquery.stellar.min.js"></script>
  <script src="js/jquery.countdown.min.js"></script>
  <script src="js/jquery.magnific-popup.min.js"></script>
  <script src="js/bootstrap-datepicker.min.js"></script>
  <script src="js/aos.js"></script>
  <script src="js/rangeslider.min.js"></script>

  <script src="js/main.js"></script>

  </body>
</html>
