<?php
// Start the session
session_start();
?>
<?php echo $locationInput;?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>FosterFinder &mdash; Animal Listings</title>
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
        <?php
        if(isset($_GET['species'])) {
          $species = $_GET['species'];
          $_SESSION['species'] = $species;
          $addSpecies = "WHERE animals.species = $species";
        } else {
          $addSpecies = "WHERE animals.species = 'dog' OR animals.species = 'cat'";
        }


        if(!empty($_GET['locationInput'])) {
          $locationInput = $_GET['locationInput'];
          $addLocation = "AND concat(shelters.shelterCity, ', ', shelters.shelterState) = '$locationInput'";
        }

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
                    <li><a href='becomeAFoster.php'>Become a Foster</a></li>
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
                <h1>Our Foster Animals</h1>
                <p class="mb-0">View the animals in need of a foster home</p>
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

            <div class="row">

              <!-- Animal Listings -->
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
                      $addSpecies
                      $addLocation
                      ORDER BY RAND()
                      LIMIT 10";

              $result = $conn->query($sql);

              if ($result->num_rows > 0) {
                //output data of each row
                while($row = $result->fetch_assoc()) {
                    echo '<div class="col-lg-6">

                      <div class="d-block d-md-flex listing vertical">' .
                      '<a href="listings-single.php?animalId=' . $row['animalId'] . '" class="img d-block" style="background-image: url(' . $row['photoPath'] . ')"></a>
                        <div class="lh-content">
                          <span class="category">' . $row['breed1'] . ', ' . $row['sex'] . '</span>
                          <a href="listings-single.php?animalId=' . $row['animalId'] . '" class="bookmark"><span class="icon-heart"></span></a>
                          <h3><a href="listings-single.php?animalId=' . $row['animalId'] . '">' . $row['animalName'] . '</a></h3>
                          <address>' . $row['shelterCity'] . ', ' . $row['shelterState'] . '</address>
                        </div>
                      </div>

                    </div>';
            }
          } else {
            echo '<p>No animals match your criteria</p>';}
          ?>
            </div>
          </div>
          <!-- End of Animal Listings -->

          <div class="col-lg-3 ml-auto">

            <div class="mb-5">
              <h3 class="h5 text-black mb-3">Filters</h3>
              <form action="#" method="post">

                <!-- Age Selection -->
                <div class="form-group">
                  <div class="select-wrap">
                      <span class="icon"><span class="icon-keyboard_arrow_down"></span></span>
                      <select class="form-control" name="age" id="age">
                        <option value="" selected>All Ages</option>
                        <option value="baby">Baby</option>
                        <option value="young">Young</option>
                        <option value="adult">Adult</option>
                        <option value="senior">Senior</option>
                      </select>
                    </div>
                </div>

                <!-- Size Selection -->
                <div class="form-group">
                  <div class="select-wrap">
                      <span class="icon"><span class="icon-keyboard_arrow_down"></span></span>
                      <select class="form-control" name="size" id="size">
                        <option value="" selected>All Sizes</option>
                        <option value="small">Small</option>
                        <option value="medium">Medium</option>
                        <option value="large">Large</option>
                        <option value="extra large">Extra Large</option>
                      </select>
                    </div>
                </div>

                <!-- Sex Selection -->
                <div class="form-group">
                  <div class="select-wrap">
                      <span class="icon"><span class="icon-keyboard_arrow_down"></span></span>
                      <select class="form-control" name="sex" id="sex">
                        <option value="" selected>Any Sex</option>
                        <option value="female">Female</option>
                        <option value="male">Male</option>
                      </select>
                    </div>
                </div>


                <!-- Special Needs Selection -->
                <div class="form-group">
                  <div class="select-wrap">
                      <span class="icon"><span class="icon-keyboard_arrow_down"></span></span>
                      <select class="form-control" name="specialNeeds" id="specialNeeds">
                        <option value="no" selected>No Special Needs</option>
                        <option value="behavioral">Behavioral</option>
                        <option value="medical">Medical</option>
                      </select>
                    </div>
                </div>

                <!-- Size Selection -->
                <div class="form-group">
                  <div class="select-wrap">
                      <span class="icon"><span class="icon-keyboard_arrow_down"></span></span>
                      <select class="form-control" name="specialNeeds" id="specialNeeds">
                        <option value="no" selected>No Special Needs</option>
                        <option value="behavioral">Behavioral</option>
                        <option value="medical">Medical</option>
                      </select>
                    </div>
                </div>


                <div class="form-group">
                  <!-- select-wrap, .wrap-icon -->
                  <div class="wrap-icon">
                    <span class="icon icon-room"></span>
                    <input type="text" placeholder="Location" class="form-control">
                  </div>
                </div>
              </form>
            </div>

            <div class="mb-5">
              <form action="#" method="post">
                <div class="form-group">
                  <p>More filters</p>
                </div>
                <div class="form-group">
                  <ul class="list-unstyled">
                    <li>
                      <label for="option1">
                        <input type="checkbox" id="option1" checked>
                        House Trained
                      </label>
                    </li>
                    <li>
                      <label for="option2">
                        <input type="checkbox" id="option2" checked>
                        Spayed/Neutered
                      </label>
                    </li>
                    <li>
                      <label for="option3">
                        <input type="checkbox" id="option3" checked>
                        Good with Dogs
                      </label>
                    </li>
                    <li>
                      <label for="option4">
                        <input type="checkbox" id="option4" checked>
                        Good with Cats
                      </label>
                    </li>
                    <li>
                      <label for="option4">
                        <input type="checkbox" id="option4" checked>
                        Good with Children
                      </label>
                    </li>
                    <li>
                      <label for="option4">
                        <input type="checkbox" id="option4" checked>
                        Requires Fenced Backyard
                      </label>
                    </li>

                  </ul>
                </div>
              </form>
            </div>

          </div>

        </div>
      </div>
    </div>

    <!-- Featured Animals -->
    <div class="site-section bg-light" data-aos="fade">
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
            <h2 class="font-weight-light text-primary">Testimonials</h2>
          </div>
        </div>

        <div class="slide-one-item home-slider owl-carousel">
          <div>
            <div class="testimonial">
              <figure class="mb-4">
                <img src="images/person_3.jpg" alt="Image" class="img-fluid mb-3">
                <p>John Smith</p>
              </figure>
              <blockquote>
                <p>&ldquo;Lorem ipsum dolor sit amet consectetur adipisicing elit. Consectetur unde reprehenderit aperiam quaerat fugiat repudiandae explicabo animi minima fuga beatae illum eligendi incidunt consequatur. Amet dolores excepturi earum unde iusto.&rdquo;</p>
              </blockquote>
            </div>
          </div>
          <div>
            <div class="testimonial">
              <figure class="mb-4">
                <img src="images/person_2.jpg" alt="Image" class="img-fluid mb-3">
                <p>Christine Aguilar</p>
              </figure>
              <blockquote>
                <p>&ldquo;Lorem ipsum dolor sit amet consectetur adipisicing elit. Consectetur unde reprehenderit aperiam quaerat fugiat repudiandae explicabo animi minima fuga beatae illum eligendi incidunt consequatur. Amet dolores excepturi earum unde iusto.&rdquo;</p>
              </blockquote>
            </div>
          </div>

          <div>
            <div class="testimonial">
              <figure class="mb-4">
                <img src="images/person_4.jpg" alt="Image" class="img-fluid mb-3">
                <p>Robert Spears</p>
              </figure>
              <blockquote>
                <p>&ldquo;Lorem ipsum dolor sit amet consectetur adipisicing elit. Consectetur unde reprehenderit aperiam quaerat fugiat repudiandae explicabo animi minima fuga beatae illum eligendi incidunt consequatur. Amet dolores excepturi earum unde iusto.&rdquo;</p>
              </blockquote>
            </div>
          </div>

          <div>
            <div class="testimonial">
              <figure class="mb-4">
                <img src="images/person_5.jpg" alt="Image" class="img-fluid mb-3">
                <p>Bruce Rogers</p>
              </figure>
              <blockquote>
                <p>&ldquo;Lorem ipsum dolor sit amet consectetur adipisicing elit. Consectetur unde reprehenderit aperiam quaerat fugiat repudiandae explicabo animi minima fuga beatae illum eligendi incidunt consequatur. Amet dolores excepturi earum unde iusto.&rdquo;</p>
              </blockquote>
            </div>
          </div>

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

  </body>
</html>
