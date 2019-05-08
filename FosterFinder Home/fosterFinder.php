<?php
// Start the session
session_start();
?>

<!DOCTYPE html>

<html lang="en">
  <head>
    <title>FosterFinder &mdash; Welcome!</title>
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

    <link href="../Admin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="fonts/flaticon/font/flaticon2.css">
    <link rel="stylesheet" href="fonts/flaticon/font/flaticon.css">


    <link rel="stylesheet" href="css/aos.css">
    <link rel="stylesheet" href="css/rangeslider.css">

    <link rel="stylesheet" href="css/style.css">

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

    if(isset($_GET['locationInput'])) {
      $_SESSION['locationInput'] = $_GET['locationInput'];
    }

    //Get animal counts
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

    // Dog Count
    $sql = "SELECT count(*) AS dogCount
            FROM Animals
            WHERE species='dog'
            AND fosterStatus != 'Adopted'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      //output data of each row
      while($row = $result->fetch_assoc()) {
        $dogCount = $row['dogCount'];
      }
    }

    // Cat Count
    $sql = "SELECT count(*) AS catCount
            FROM Animals
            WHERE species='cat'
            AND fosterStatus != 'Adopted'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      //output data of each row
      while($row = $result->fetch_assoc()) {
        $catCount = $row['catCount'];
      }
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



    <div class="site-blocks-cover overlay" style="background-image: url(images/hero_3.jpg);" >
      <div class="container">
        <div class="row align-items-center justify-content-center text-center">

          <div class="col-md-12">


            <div class="row justify-content-center mb-4">
              <div class="col-md-8 text-center">
                <h1 class="" data-aos="fade-up">Welcome to FosterFinder!</h1>
                <p data-aos="fade-up" data-aos-delay="100">Search to view the animals in need of fostering. If you are interested
                in becoming a foster, create an account and submit a foster application.</p>
              </div>
            </div>

            <div class="form-search-wrap" data-aos="fade-up" data-aos-delay="200">
              <form method="get" action='<?php echo "listings.php?species='" . $species . "'&location='" . $locationInput . "'"?>'>
                <div class="row align-items-center">
                  <div class="col-lg-12 mb-4 mb-xl-0 col-xl-4">
                    <div class="select-wrap">
                      <span class="icon"><span class="icon-keyboard_arrow_down"></span></span>
                      <select class="form-control rounded" name="species" id="species" value='<?php echo $species;?>'>
                        <option value="">What type of animal?</option>
                        <option value="'dog'">Dog</option>
                        <option value="'cat'">Cat</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-lg-12 mb-4 mb-xl-0 col-xl-3">
                    <div class="wrap-icon">
                      <span class="icon icon-room"></span>
                      <input type="text" class="form-control rounded" id='locationInput' name='locationInput' placeholder="Location" value='<?php echo $locationInput;?>'>
                    </div>

                  </div>
                  <!--<div class="col-lg-12 mb-4 mb-xl-0 col-xl-3">
                    <div class="select-wrap">
                      <span class="icon"><span class="icon-keyboard_arrow_down"></span></span>
                      <select class="form-control rounded" name="" id="">
                        <option value="">All Categories</option>
                        <option value="">Real Estate</option>
                        <option value="">Books &amp;  Magazines</option>
                        <option value="">Furniture</option>
                        <option value="">Electronics</option>
                        <option value="">Cars &amp; Vehicles</option>
                        <option value="">Others</option>
                      </select>
                    </div>
                  </div>-->
                  <div class="col-lg-12 col-xl-2 ml-auto text-right">
                    <input type="submit" class="btn btn-primary btn-block rounded" value="Search">
                  </div>

                </div>
              </form>
            </div>

          </div>
        </div>
      </div>
    </div>

    <div class="site-section bg-light">
      <div class="container">

        <!-- Animal Icons -->
        <div class="overlap-category mb-5">
          <div class="row justify-content-center no-gutters">
            <div class="col-sm-6 col-md-4 mb-4 mb-lg-0 col-lg-2">
              <a href="listings.php?species='dog'" class="popular-category h-100">
                <span class="icon"><span class="fas fa-fw fa-dog"></span></span>
                <span class="caption mb-2 d-block">Dogs</span>
                <span class="number"><?php echo $dogCount;?></span>
              </a>
            </div>
            <div class="col-sm-6 col-md-4 mb-4 mb-lg-0 col-lg-2">
              <a href="listings.php?species='cat'" class="popular-category h-100">
                <span class="icon"><span class="fas fa-fw fa-cat"></span></span>
                <span class="caption mb-2 d-block">Cats</span>
                <span class="number"><?php echo $catCount;?></span>
              </a>
            </div>
          </div>
        </div>
        <!-- End of Animal Icons -->

        <!-- Animal Gallery -->
        <div class="row mb-5">
          <div class="col-md-7 text-left border-primary">
            <h2 class="font-weight-light text-primary">Animal Gallery</h2>
          </div>
        </div>
        <div class="row">
          <div class="col-12  block-13">
            <div class="owl-carousel nonloop-block-13">

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
                      ORDER BY RAND() LIMIT 9";

              $result = $conn->query($sql);

              if ($result->num_rows > 0) {
                //output data of each row
                while($row = $result->fetch_assoc()) {
                  echo '<div class="d-block d-md-flex listing vertical">' .
                    '<a href="listings-single.php?animalId=' . $row['animalId'] . '" class="img d-block" style="background-image: url(' . $row['photoPath'] . ')"></a>
                    <div class="lh-content">
                      <span class="category">' . $row['breed1'] . ', ' . $row['sex'] . '</span>
                      <a href="listings-single.php?animalId=' . $row['animalId'] . '" class="bookmark"><span class="icon-heart"></span></a>
                      <h3><a href="listings-single.php?animalId=' . $row['animalId'] . '">' . $row['animalName'] . '</a></h3>
                      <address>' . $row['shelterCity'] . ', ' . $row['shelterState'] . '</address>

                    </div>
                  </div>';
                }
              }
              ?>






            </div>
          </div>


        </div>
      </div>
    </div>
    <!-- End of Animal Gallery -->



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

     <!-- Featured Animals -->
     <div class="site-section" data-aos="fade">
        <div class="container">
          <div class="row justify-content-center mb-5">
            <div class="col-md-7 text-center border-primary">
              <h2 class="font-weight-light text-primary">Featured Animals</h2>
              <p class="color-black-opacity-5"></p>
            </div>
          </div>

          <div class="row">

            <!-- SQL Animal Selection -->
            <?php

            // Row of 3 //
            $sql = "SELECT animal_photos.photoPath AS photoPath,
                           animals.animalId AS animalId,
                           animals.animalName AS animalName,
                           animals.sex AS sex,
                           animals.breed1 AS breed1,
                           animals.location AS location,
                           shelters.shelterCity AS shelterCity,
                           shelters.shelterState AS shelterState
                    FROM Animal_Photos
                    INNER JOIN Animals
                    ON Animal_Photos.animalId = Animals.animalId
                    INNER JOIN Shelters
                    ON Animals.shelterId = Shelters.shelterId
                    WHERE animals.animalID > 31821 AND animals.animalId < 31825";

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
              //output data of each row
              while($row = $result->fetch_assoc()) {
                echo '<div class="col-md-6 mb-4 mb-lg-4 col-lg-4">
                        <div class="listing-item">
                          <div class="listing-image">
                            <img src="' . $row['photoPath'] . '" alt="Image" class="img-fluid">
                    </div>
                    <div class="listing-item-content">
                      <a href="listings-single.php?animalId=' . $row['animalId'] . '" class="bookmark" data-toggle="tooltip" data-placement="left" title="Bookmark"><span class="icon-heart"></span></a>
                      <a class="px-3 mb-3 category" href="listings-single.php?animalId=' . $row['animalId'] . '">' .
                        $row['breed1'] . ', ' . $row['sex'] . '</a>
                      <h2 class="mb-1"><a href="listings-single.php?animalId=' . $row['animalId'] . '">' . $row['animalName'] . '</a></h2>
                      <span class="address">' . $row['shelterCity'] . ', ' . $row['shelterState'] . '</span>
                    </div>
                  </div>

                </div>';
            }
          }

          // Row of 2 //
          $sql = "SELECT animal_photos.photoPath AS photoPath,
                         animals.animalId AS animalId,
                         animals.animalName AS animalName,
                         animals.sex AS sex,
                         animals.breed1 AS breed1,
                         animals.location AS location,
                         shelters.shelterCity AS shelterCity,
                         shelters.shelterState AS shelterState
                  FROM Animal_Photos
                  INNER JOIN Animals
                  ON Animal_Photos.animalId = Animals.animalId
                  INNER JOIN Shelters
                  ON Animals.shelterId = Shelters.shelterId
                  WHERE animals.animalID > 31824 AND animals.animalId < 31827";

          $result = $conn->query($sql);

          if ($result->num_rows > 0) {
            //output data of each row
            while($row = $result->fetch_assoc()) {
              echo '<div class="col-md-6 mb-4 mb-lg-4 col-lg-6">
                      <div class="listing-item">
                        <div class="listing-image">
                          <img src="' . $row['photoPath'] . '" alt="Image" class="img-fluid">
                  </div>
                  <div class="listing-item-content">
                    <a href="listings-single.php?animalId=' . $row['animalId'] . '" class="bookmark" data-toggle="tooltip" data-placement="left" title="Bookmark"><span class="icon-heart"></span></a>
                    <a class="px-3 mb-3 category" href="listings-single.php?animalId=' . $row['animalId'] . '">' .
                      $row['breed1'] . ', ' . $row['sex'] . '</a>
                    <h2 class="mb-1"><a href="listings-single.php?animalId=' . $row['animalId'] . '">' . $row['animalName'] . '</a></h2>
                    <span class="address">' . $row['shelterCity'] . ', ' . $row['shelterState'] . '</span>
                  </div>
                </div>

              </div>';
          }
          $conn->close();
        }

          ?>


            <!-- End SQL Animal Selection -->
          </div>
        </div>
      </div>
    <!-- End Featured Animals -->

    <div class="site-section bg-white">
      <div class="container">

        <div class="row justify-content-center mb-5">
          <div class="col-md-7 text-center border-primary">
            <h2 class="font-weight-light text-primary">Shelter Animals Statistics</h2>
          </div>
        </div>

        <div class="slide-one-item home-slider owl-carousel">
          <div>
            <div class="testimonial">
              <figure class="mb-4">
                <img src="images/person_3.jpg" alt="Image" class="img-fluid mb-3">
                <p>Fact 1</p>
              </figure>
              <blockquote>
                <p>&ldquo;Approximately 6.5 million companion animals enter U.S. animal shelters nationwide every year. Of those, approximately 3.3 million are dogs and 3.2 million are cats.  We estimate that the number of dogs and cats entering U.S. shelters annually has declined from approximately 7.2 million in 2011.  The biggest decline was in dogs (from 3.9 million to 3.3 million).&rdquo;</p>
              </blockquote>
            </div>
          </div>
          <div>
            <div class="testimonial">
              <figure class="mb-4">
                <img src="images/person_2.jpg" alt="Image" class="img-fluid mb-3">
                <p>Fact 2</p>
              </figure>
              <blockquote>
                <p>&ldquo;Each year, approximately 1.5 million shelter animals are euthanized (670,000 dogs and 860,000 cats).  The number of dogs and cats euthanized in U.S. shelters annually has declined from approximately 2.6 million in 2011.  This decline can be partially explained by an increase in the percentage of animals adopted and an increase in the number of stray animals successfully returned to their owners.&rdquo;</p>
              </blockquote>
            </div>
          </div>

          <div>
            <div class="testimonial">
              <figure class="mb-4">
                <img src="images/person_4.jpg" alt="Image" class="img-fluid mb-3">
                <p>Fact 3</p>
              </figure>
              <blockquote>
                <p>&ldquo;Approximately 3.2 million shelter animals are adopted each year (1.6 million dogs and 1.6 million cats).&rdquo;</p>
              </blockquote>
            </div>
          </div>

          <div>
            <div class="testimonial">
              <figure class="mb-4">
                <img src="images/person_5.jpg" alt="Image" class="img-fluid mb-3">
                <p>Fact 4</p>
              </figure>
              <blockquote>
                <p>&ldquo;About 710,000 animals who enter shelters as strays are returned to their owners. Of those, 620,000 are dogs and only 90,000 are cats.&rdquo;</p>
              </blockquote>
            </div>
          </div>

        </div>
      </div>
    </div>



    <div class="site-section bg-light">
      <div class="container">
        <div class="row justify-content-center mb-5">
          <div class="col-md-7 text-center border-primary">
            <h2 class="font-weight-light text-primary">Foster Stories</h2>
            <p class="color-black-opacity-5">Fostered Dogs & Cats</p>
          </div>
        </div>
        <div class="row mb-3 align-items-stretch">
          <div class="col-md-6 col-lg-4 mb-4 mb-lg-4">
            <div class="h-entry">
              <img src="images/hero_1.jpg" alt="Image" class="img-fluid rounded">
              <h2 class="font-size-regular"><a href="#" class="text-black">Bob has changed my life</a></h2>
              <div class="meta mb-3">by Maggie<span class="mx-1">&bullet;</span> Jan 18, 2019 <span class="mx-1">&bullet;</span> <a href="#">More...</a></div>
              <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Natus eligendi nobis ea maiores sapiente veritatis reprehenderit suscipit quaerat rerum voluptatibus a eius.</p>
            </div>
          </div>
          <div class="col-md-6 col-lg-4 mb-4 mb-lg-4">
            <div class="h-entry">
              <img src="images/hero_2.jpg" alt="Image" class="img-fluid rounded">
              <h2 class="font-size-regular"><a href="#" class="text-black">Foster animal is so rewarding</a></h2>
              <div class="meta mb-3">by Anna<span class="mx-1">&bullet;</span> Feb 21, 2019 <span class="mx-1">&bullet;</span> <a href="#">More...</a></div>
              <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Natus eligendi nobis ea maiores sapiente veritatis reprehenderit suscipit quaerat rerum voluptatibus a eius.</p>
            </div>
          </div>
          <div class="col-md-6 col-lg-4 mb-4 mb-lg-4">
            <div class="h-entry">
              <img src="images/hero_4.jpg" alt="Image" class="img-fluid rounded">
              <h2 class="font-size-regular"><a href="#" class="text-black">Make a difference</a></h2>
              <div class="meta mb-3">by Katie<span class="mx-1">&bullet;</span> march 13, 2019 <span class="mx-1">&bullet;</span> <a href="#">More...</a></div>
              <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Natus eligendi nobis ea maiores sapiente veritatis reprehenderit suscipit quaerat rerum voluptatibus a eius.</p>
            </div>
          </div>

          <div class="col-12 text-center mt-4">
            <a href="#" class="btn btn-primary rounded py-2 px-4 text-white">View All Posts</a>
          </div>
        </div>
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
