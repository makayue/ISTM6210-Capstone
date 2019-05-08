<?php
// Start the session
session_start();

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>FosterFinder &mdash; Foster Request</title>
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

  </head>

  <?php
  // Grab fosterId from session
  $userName = $_SESSION["firstName"];
  $animalId = $_SESSION['animalId'];

   ?>

  <body>
    <?php
      //Connect to the database
      $server = [REDACTED];
      $username = [REDACTED];
      $password = [REDACTED];
      $db = [REDACTED];

      // Create connection
      $conn = new mysqli($servername, $username, $password, $db);
      if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }

      $sql = "SELECT concat(lastName, ', ', firstName) AS name,
              fosterId,
              emailAddress,
              concat(userAddress, ', ', userCity, ', ', userState, ' ', userZipCode) AS address,
              phone,
              (year(now()) - year(birthdate)) AS age,
              employmentStatus,
              specialNeedsExp,
              hoursAway
              FROM registered_fosters
              WHERE lastName = 'Chao'";

      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
          $fosterId = $row['fosterId'];
          $fosterName = $row['name'];
          $emailAddress = $row['emailAddress'];
          $userAddress = $row['address'];
          $phone = $row['phone'];
          $age = $row['age'];
          $employmentStatus = $row['employmentStatus'];
          $specialNeedsExp = $row['specialNeedsExp'];
          $hoursAway = $row['hoursAway'];
        }
      } else {
        echo "0 results";
      }

      $sql = "SELECT animalName,
              animalId,
              species,
              breed1,
              specialNeeds,
              fosterStatus
              FROM Animals
              WHERE animalId = $animalId";

      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
          $animalName = $row['animalName'];
          $_SESSION['animalName'] = $animalName;
          $animalId = $row['animalId'];
          $species = $row['species'];
          $breed1 = $row['breed1'];
          $specialNeeds = $row['specialNeeds'];
          $fosterStatus = $row['fosterStatus'];
        }
      } else {
        echo "0 results";
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
                <li><a href="fosterFinder.php">Home</a></li>
                <li><a href="shelters.php">Shelters</a></li>
                <li class="has-children">
                  <a href="fosterFinder.php">Fosters</a>
                  <ul class="dropdown">
                    <li><a href="fosterApplication.php">Become a Foster</a></li>
                    <li><a href="listings.php">Available Animals</a></li>
                  </ul>
                </li>
                <li><a href="about.php">About Us</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li class="ml-xl-3 login active"><span class="border-left pl-xl-4"></span><?php echo 'Welcome, ' . $userName;?></li>

                <li><a href="fosterFinder.php" class="cta"><span class="bg-primary text-white rounded">Return to FosterFinder</span></a></li>
              </ul>
            </nav>
          </div>


          <div class="d-inline-block d-xl-none ml-auto py-3 col-6 text-right" style="position: relative; top: 3px;">
            <a href="#" class="site-menu-toggle js-menu-toggle text-black"><span class="icon-menu h3"></span></a>
          </div>

        </div>
      <!-- </div> -->

    </header>



    <div class="site-blocks-cover inner-page-cover overlay" style="background-image: url(images/hero_1.jpg);" data-aos="fade" data-stellar-background-ratio="0.5">
      <div class="container">
        <div class="row align-items-center justify-content-center text-center">

          <div class="col-md-10" data-aos="fade-up" data-aos-delay="300">


            <div class="row justify-content-center mt-5">
              <div class="col-md-8 text-center">
                <h1>Animal Request</h1>
                <p data-aos="fade-up" data-aos-delay="100">We thank you from the bottom of our hearts for considering to foster an animal with us.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="site-section bg-light">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-7 mb-5"  data-aos="fade">
            <form method="post" class="p-5 bg-white" data-aos="fade-up" data-aos-delay="800">
              <div class="row form-group">
                <p>Ensure the following information is correct before submitting your request.</p>

                <!-- Your Information Content -->
                <h4>Your Information</h4>

                <div class="table-responsive">
                  <table class="table table-bordered table-sm table-fixed" width="100%" cellspacing="0">
                    <tr>
                      <th style='width: 50%'>Name</th>
                      <td style='width: 50%'><?php echo $fosterName;?></td>
                    </tr>
                    <tr>
                      <th >Foster ID</th>
                      <td><?php echo $fosterId;?></td>
                    </tr>
                    <tr>
                      <th>Email Address</th>
                      <td><?php echo $emailAddress;?></td>
                    </tr>
                    <tr>
                      <th>Address</th>
                      <td><?php echo $userAddress;?></td>
                    </tr>
                    <tr>
                      <th>Phone</th>
                      <td><?php echo $phone;?></td>
                    </tr>
                    <tr>
                      <th>Age</th>
                      <td><?php echo $age;?></td>
                    </tr>
                    <tr>
                      <th>Employment Status</th>
                      <td><?php echo $employmentStatus;?></td>
                    </tr>
                    <tr>
                      <th>Special Needs Experience</th>
                      <td><?php echo $specialNeedsExp;?></td>
                    </tr>
                    <tr>
                      <th>Hours Away</th>
                      <td><?php echo $hoursAway;?></td>
                    </tr>
                  </table>
                </div>
              </div>
                <!-- End of Your Information -->

                <!-- Animal Info Content -->
              <div class="row form-group">
                <h4>Animal Information</h4>

                <div class="table-responsive">
                  <table class="table table-bordered table-sm table-fixed" width="100%" cellspacing="0">
                    <tr>
                      <th style='width: 50%'>Animal Name</th>
                      <td style='width: 50%'><?php echo $animalName;?></td>
                    </tr>
                    <tr>
                      <th >Animal ID</th>
                      <td><?php echo $animalId;?></td>
                    </tr>
                    <tr>
                      <th>Species</th>
                      <td><?php echo $species;?></td>
                    </tr>
                    <tr>
                      <th>Breed</th>
                      <td><?php echo $breed1;?></td>
                    </tr>
                    <tr>
                      <th>Special Needs</th>
                      <td><?php echo $specialNeeds;?></td>
                    </tr>
                    <tr>
                      <th>Available to Foster</th>
                      <td>Yes</td>
                    </tr>
                  </table>
                </div>

              </div>
              <!-- End of Animal Info -->

              <p>If the information above is correct, click the "Submit Request" button
                to submit your request to foster an animal.</p>

              <!-- Submit Button -->
              <div class="row form-group">
                <div class="col-md-12">
                  <input type="submit" value="Submit Request" class="btn btn-primary py-2 px-4 text-white">
                </div>
              </div>

            </form>
          </div>
          <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
              $sql = "INSERT INTO animal_request (fosterId, animalId)
                      VALUES ($fosterId, $animalId)";

              if ($conn->query($sql) === FALSE) {
                echo "Error: " . $sql . "<br>" . $conn->error;
              } else {
                $requestId = $conn->insert_id;
                $_SESSION['requestId'] = $requestId;
              }

              $sql = "INSERT INTO foster_activity (fosterId, animalId)
                      VALUES ($fosterId, $animalId)";

              if ($conn->query($sql) === FALSE) {
                echo "Error: " . $sql . "<br>" . $conn->error;
              } else {
                echo "<script type='text/javascript'>";
    						echo "window.location='requestSubmitted.php'";
    						echo "</script>";
              }
            }
          ?>

        </div>
      </div>
    </div>


    <div class="newsletter bg-primary py-5">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-md-6">
            <h2>Newsletter</h2>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
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
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Provident rerum unde possimus molestias dolorem fuga, illo quis fugiat!</p>
              </div>

              <div class="col-md-3">
                <h2 class="footer-heading mb-4">Navigations</h2>
                <ul class="list-unstyled">
                  <li><a href="#">About Us</a></li>
                  <li><a href="#">Services</a></li>
                  <li><a href="#">Testimonials</a></li>
                  <li><a href="#">Contact Us</a></li>
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
                <input type="text" class="form-control border-secondary text-white bg-transparent" placeholder="Search products..." aria-label="Enter Email" aria-describedby="button-addon2">
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
  <script>
    $("select[name=shelter1]").change(function(){
      $("select[name=shelter2] option").removeAttr("disabled");
      $("select[name=shelter2] option[value=" + $("select[name=shelter1]").val() + "]").attr("disabled", "disabled");
    });
  </script>

  </body>
</html>
