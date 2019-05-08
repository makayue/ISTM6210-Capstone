<?php
// Start the session
session_start();

$animalId = $_GET['animalId'];
$_SESSION['animalId'] = $animalId;

if(isset($_GET['animalId'])) {
  $_SESSION['animalId'] = $_GET['animalId'];
}


if (isset($_SESSION['firstName'])) {
  $firstName = $_SESSION['firstName'];
  if (isset($_SESSION['applicationId'])) {
    $buttonCaption = 'Submit Animal Request';
    $buttonLink = 'animalRequest.php?animalId=' . $animalId;
    $buttonLinkRequest = 'animalRequest.php?animalId=' . $animalId;
  } else {
    $buttonCaption = 'Submit Foster Application';
    $buttonLink = 'fosterApplication.php';
    $buttonLinkRequest = 'becomeAFoster.php';
  }
} else {
  $firstName = 'Visitor';
  $buttonCaption = 'Log In/Sign Up';
  $buttonLink = '../userlogin.php';
  $buttonLinkRequest = 'becomeAFoster.php';
}



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

$sql = "SELECT animals.animalName AS animalName,
               animals.species AS species,
               animals.sex AS sex,
               animals.breed1 AS breed1,
               animals.color1 AS color1,
               animals.color2 AS color2,
               animals.ageStatus AS age,
               animals.size AS size,
               animals.goodWithDogs AS goodWithDogs,
               animals.goodWithCats AS goodWithCats,
               animals.goodWithOther AS goodWithOther,
               animals.goodWithChildren AS goodWithChildren,
               animals.houseTrained AS houseTrained,
               animals.specialNeeds AS specialNeeds,
               animals.vaccinated AS vaccinated,
               animals.sterilized AS sterilized,
               animal_photos.photoPath AS photoPath,
               shelters.shelterName AS shelterName,
               shelters.shelterCity AS shelterCity,
               shelters.shelterState AS shelterState
        FROM animals
        INNER JOIN animal_photos
        ON animals.animalId = animal_photos.animalId
        INNER JOIN shelters
        ON animals.shelterId = shelters.shelterId
        WHERE animals.animalId = $animalId";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
  //output data of each row
  while($row = $result->fetch_assoc()) {
    $animalName = $row['animalName'];
    $species = $row['species'];
    $sex = $row['sex'];
    $breed1 = $row['breed1'];
    $color1 = $row['color1'];
    $color2 = $row['color2'];
    $age = $row['age'];
    $size = $row['size'];
    $goodWithDogs = $row['goodWithDogs'];
    $goodWithCats = $row['goodWithCats'];
    $goodWithOther = $row['goodWithOther'];
    $goodWithChildren = $row['goodWithChildren'];
    $houseTrained = $row['houseTrained'];
    $specialNeeds = $row['specialNeeds'];
    $vaccinated = $row['vaccinated'];
    $photoPath = $row['photoPath'];
    $shelterName = $row['shelterName'];
    $shelterCity = $row['shelterCity'];
    $shelterState = $row['shelterState'];

    if ($sex = 'female') {
      $sex_pronoun = 'She';
    } else {
      $sex_pronoun = 'He';
    }
  }
}
?>



<!DOCTYPE html>
<html lang="en">
  <head>
    <title>FosterFinder &mdash; <?php echo $animalName;?></title>
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
  <body>

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
                    <li><a href="<?php echo $buttonLink;?>">Become a Foster</a></li>
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



    <div class="site-blocks-cover inner-page-cover overlay" style="background-image: url(images/hero_1.jpg);" data-aos="fade" data-stellar-background-ratio="0.5">
      <div class="container">
        <div class="row align-items-center justify-content-center text-center">

          <div class="col-md-10" data-aos="fade-up" data-aos-delay="400">


            <div class="row justify-content-center mt-5">
              <div class="col-md-8 text-center">
                <h1><?php echo $animalName;?></h1>
                <p class="mb-0"><?php echo $breed1 . ', ' . $sex;?></p>
				        <p class="mb-0"><?php echo $shelterCity . ', ' . $shelterState;?></p>
              </div>
            </div>


          </div>
        </div>
      </div>
    </div>

    <div class="site-section">
      <div class="container">
        <div class="row">
          <div class="col-lg-8">

            <div class="mb-4">
              <div class="slide-one-item home-slider owl-carousel">
                <div><img src='<?php echo $photoPath;?>' alt="Image" class="img-fluid"></div>
              </div>
            </div>

            <h4 class="h5 mb-4 text-black">Description</h4>
            <p></p>
            <p><?php echo $animalName;?> is great.</p>
            <p><?php echo $sex_pronoun;?> is good on a leash and gets along well with other <?php echo $species;?>s.</p>
            <p><?php echo $animalName;?> is very friendly and loves to play with her animal friends.</p>

          </div>
          <div class="col-lg-3 ml-1">

            <div class="mb-5">
              <div class="row form-group">
                <div class="col-md-12">
                  <a href='<?php echo $buttonLinkRequest;?>' class="btn btn-primary py-2 px-4 text-white" role="button">Foster <?php echo $animalName;?></a>
                </div>
              </div>
            </div>

            <div class="mb-5">
              <h3 class="h5 text-black mb-3">Summary</h3>
              <p> Breed: <?php echo $breed1;?></p>
      			  <p> Age: <?php echo $age;?></p>
      			  <P> Size: <?php echo $size;?></p>
      			  <p> Color: <?php echo $color1;?> / <?php echo $color2;?></p>
      			  <p> Vaccination Status: <?php echo $vaccinated;?></p>
      			  <P> Sprayed/Neutered Status: <?php echo $sterilized;?></p>
      			  <P> House Trained: <?php echo $houseTrained;?></p>
      			  <p> Special Needs: <?php echo $specialNeeds;?></P>
      			  <p> Good with Dogs: <?php echo $goodWithDogs;?></p>
      			  <p> Good with Cats: <?php echo $goodWithCats;?></p>
      			  <p> Good with Other Animals: <?php echo $goodWithOther;?></p>
      			  <p> Good with Children: <?php echo $goodWithChildren;?></p>
            </div>


            <div class="mb-5">
              <h3 class="h6 mb-3">More Info</h3>
              <p> Shelter: <?php echo $shelterName;?></p>
			        <p> Adoption Fee: $250</p>

            </div>

          </div>

        </div>
      </div>
    </div>

    <!-- Available Animals -->
    <div class="site-section bg-light">
      <div class="container">
        <div class="row mb-5">
          <div class="col-md-7 text-left border-primary">
            <h2 class="font-weight-light text-primary">Available Animals</h2>
          </div>
        </div>
        <div class="row mt-5">
            <?php

            $sql = "SELECT animal_photos.photoPath AS photoPath,
                           animals.animalId AS animalId,
                           animals.animalName AS animalName,
                           animals.sex AS sex,
                           animals.breed1 AS breed1,
                           animals.location AS location,
                           shelters.shelterName AS shelterName,
                           shelters.shelterCity AS shelterCity,
                           shelters.shelterState AS shelterState
                    FROM Animal_Photos
                    INNER JOIN Animals
                    ON Animal_Photos.animalId = Animals.animalId
                    INNER JOIN Shelters
                    ON Animals.shelterId = Shelters.shelterId
                    ORDER BY RAND() LIMIT 6";

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
              //output data of each row
              while($row = $result->fetch_assoc()) {

                  echo '<div class="col-lg-6"><div class="d-block d-md-flex listing">
                    <a href="listings-single.php?animalId=' . $row['animalId'] . '" class="img d-block" style="background-image: url(' . $row['photoPath'] . ')"></a>
                    <div class="lh-content">
                      <span class="category">' . $row['breed1'] . ', ' . $row['sex'] . '</span>
                      <a href="listings-single.php?animalId=' . $row['animalId'] . '" class="bookmark"><span class="icon-heart"></span></a>
                      <h3><a href="listings-single.php?animalId=' . $row['animalId'] . '">' . $row['animalName'] . '</a></h3>
                      <address>' . $row['shelterCity'] . ', ' . $row['shelterState'] . '</address>

                    </div>
                  </div>
                  </div>';
            }
          }

          ?>

        </div>
      </div>
    </div>
    <!-- End Available Animals -->




    <div class="newsletter bg-primary py-5">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-md-6">
            <h2>Newsletter</h2>
            <p>Enter your email to receive latest news.</p>
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
                <p>FosterFind is committed to help homeless animals.</p>
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

  </body>
</html>
