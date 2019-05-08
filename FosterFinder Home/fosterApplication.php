<?php
// Start the session
session_start();

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>FosterFinder &mdash; Foster Application</title>
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
    $fosterId = $_SESSION["applicantId"];


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


    /*Initiate error returns*/
    $esErr = $snErr = $haErr = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

      /* Employment Status Validation */
      if (empty($_POST["employmentStatus"])) {
        $esErr = "*Please enter your employment information";
      } else {
        $employmentStatus = $_POST['employmentStatus'];
        }

      /* Special Needs Validation */
      if (empty($_POST["specialNeedsExp"])) {
        $snErr = "*Please enter your experience";
      } else {
        $specialNeedsExp = $_POST['specialNeedsExp'];
      }

      /* Hours Away Validation */
      if (empty($_POST['hoursAway'])) {
        $haErr = "*Please enter your hours away from home";
      } else {
        $hoursAway = $_POST['hoursAway'];
      }

      /* Home Type Validation */
      if (!empty($_POST['homeType'])) {
        $homeType = $_POST['homeType'];
      }

      /* fencedBackyard Validation */
      if (!empty($_POST['fencedBackyard'])) {
        $fencedBackyard = $_POST['fencedBackyard'];
      }

      /* homeOwnership Validation */
      if (!empty($_POST['homeOwnership'])) {
        $homeOwnership = $_POST['homeOwnership'];
      }

      /* residents Validation */
      if (!empty($_POST['residents'])) {
        $residents = $_POST['residents'];
      }

      /* pets Validation */
      if (!empty($_POST['pets'])) {
        $pets = $_POST['pets'];
      }

      /* petsVaccinated Validation */
      if (!empty($_POST['petsVaccinated'])) {
        $petsVaccinated = $_POST['petsVaccinated'];
      }

      /* shelter1 Validation */
      if (!empty($_POST['shelter1'])) {
        $shelter1 = $_POST['shelter1'];
      }

      /* shelter2 Validation */
      if (!empty($_POST['shelter2'])) {
        $shelter2 = $_POST['shelter2'];
      }

      /* species Validation */
      if (!empty($_POST['species'])) {
        $species = $_POST['species'];
      }

      /* size Validation */
      if (!empty($_POST['size'])) {
        $size = $_POST['size'];
      }

      /* age Validation */
      if (!empty($_POST['age'])) {
        $age = $_POST['age'];
      }

      /* specialNeeds Validation */
      if (!empty($_POST['specialNeeds'])) {
        $specialNeeds = $_POST['specialNeeds'];
      }

      /* fosterToAdopt Validation */
      if (!empty($_POST['fosterToAdopt'])) {
        $fosterToAdopt = $_POST['fosterToAdopt'];
      }

      /* fosterToAdopt Validation */
      if (!empty($_POST['animalCount'])) {
        $animalCount = $_POST['animalCount'];
      }


      /* availableNow Validation */
      if (!empty($_POST['availableNow'])) {
        $availableNow = $_POST['availableNow'];
      }

    }

    /* Function to validate user input */
    function test_input($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
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
            <h1 class="mb-0 site-logo"><a href="index.html" class="text-black mb-0">Foster<span class="text-primary">Finder</span>  </a></h1>
          </div>
          <div class="col-12 col-md-10 d-none d-xl-block">
            <nav class="site-navigation position-relative text-right" role="navigation">

              <ul class="site-menu js-clone-nav mr-auto d-none d-lg-block">
                <li><a href="fosterHome.php">Home</a></li>
                <li><a href="shelters.php">Shelters</a></li>
                <li class="has-children">
                  <a href="fosterHome.php">Fosters</a>
                  <ul class="dropdown">
                    <li><a href="fosterApplication.php">Become a Foster</a></li>
                    <li><a href="listings.php">Available Animals</a></li>
                  </ul>
                </li>
                <li><a href="about.php">About Us</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li class="ml-xl-3 login active"><span class="border-left pl-xl-4"></span><?php echo 'Welcome, ' . $firstName;?></li>

                <li><a href="fosterFinderTest.php" class="cta"><span class="bg-primary text-white rounded">Return to FosterFinder</span></a></li>
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

          <div class="col-md-10" data-aos="fade-up" data-aos-delay="300">


            <div class="row justify-content-center mt-5">
              <div class="col-md-8 text-center">
                <h1>Foster Application</h1>
                <p data-aos="fade-up" data-aos-delay="100">Submit an application to be eligible to foster an animal.</p>
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
                <h2>More About You</h2>

                <div class="col-md-12">
                  <label class="text-black" for="employmentStatus">Employment Status</label>
                  <select type="text" id="employmentStatus" name = "employmentStatus" class="form-control" required value="<?php echo $employmentStatus;?>">
                    <option disabled selected value="">Select an option</option>
                    <option value="Employed">Employed</option>
      							<option value="Unemployed">Not Employed</option>
                    <option value="Student">Student</option>
                    <option value="Retired">Retired</option>
      						</select>
                </div>
              </div>

              <div class="row form-group">

                <div class="col-md-12">
                  <label class="text-black" for="specialNeedsExp">Experience with Special Needs</label>
                  <select type="text" id="specialNeedsExp" name = "specialNeedsExp" class="form-control" required value="<?php echo $specialNeedsExp;?>">
                    <option disabled selected value="">Select an option</option>
                    <option value="yes">Yes</option>
      							<option value="no">No</option>
      						</select>
                </div>
              </div>

              <div class='row form-group'>

                <div class='col-md-12'>
                  <label class="text-black" for="hoursAway">How many hours are you away from home each day?</label>
                  <input class="form-control" pattern="[0-9]{,2}" name="hoursAway" required value="<?php echo $hoursAway;?>" placeholder="Enter a number">
                </div>
              </div>

              <br>

              <h2>About Your Home</h2>

              <div class="row form-group">

                <div class="col-md-12">
                  <label class="text-black" for="homeType">Home Type</label>
                  <select type="text" id="homeType" name = "homeType" class="form-control" required value="<?php echo $homeType;?>">
                    <option disabled selected value="">Select an option</option>
                    <option value="house">Single Home</option>
      							<option value="house">Townhome</option>
                    <option value="apartment or condo">Apartment/Condo</option>
                  </select>
                </div>
              </div>

              <div class="row form-group">

                <div class="col-md-12">
                  <label class="text-black" for="fencedBackyard">Do you have a fenced backyard?</label>
                  <select type="text" id="fencedBackyard"  name = "fencedBackyard"class="form-control" required value="<?php echo $fencedBackyard;?>">
                    <option disabled selected value="">Select an option</option>
                    <option value="yes">Yes</option>
      							<option value="no">No</option>
                  </select>
                </div>
              </div>

              <div class="row form-group">

                <div class="col-md-12">
                  <label class="text-black" for="homeOwnership">Do you own your home?</label>
                  <select type="text" id="homeOwnership" name = "homeOwnership" class="form-control" required value="<?php echo $homeOwnership;?>">
                    <option disabled selected value="">Select an option</option>
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                  </select>
                </div>
              </div>

              <div class="row form-group">

                <div class="col-md-12">
                  <label class="text-black" for="residents">Including yourself, how many people live in your home?</label>
                  <input type="text" id="residents" name = "residents" class="form-control" pattern="[0-9]{,2}" required value="<?php echo $residents;?>" placeholder="Enter a number">
                </div>
              </div>

              <div class="row form-group">

                <div class="col-md-12">
                  <label class="text-black" for="pets">How many pets do you have?</label>
                  <input type="text" id="pets"  name = "pets" class="form-control" pattern="[0-9]{,2}" required value="<?php echo $pets;?>" placeholder="Enter a number">
                </div>
              </div>

              <div class="row form-group">

                <div class="col-md-12">
                  <label class="text-black" for="petsVaccinated">If you have pets, are their vaccinations up to date?</label>
                  <span>Select 'Not Applicable' if you do not have any pets.</span>
                  <select type="text" id="petsVaccinated" name = "petsVaccinated" class="form-control" required value="<?php echo $petsVaccinated;?>">
                    <option disabled selected value="">Select an option</option>
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                    <option value="not applicable">Not Applicable</option>
                  </select>
                </div>
              </div>

              <br>

              <h2>Your Shelter Preference</h2>
              <p>Please select the shelters from which you'd like to foster. When you search for animals,
                those that are located at your preferred shelters will be highlighted.</p>
              <div class="row form-group">

                <div class="col-md-12">
                  <label class="text-black" for="shelter1">Primary Shelter</label>
                  <select type="text" id="shelter1" name="shelter1" class="form-control" required value="<?php echo $shelter1;?>">
                    <option disabled selected value="">Select an option</option>
                    <option value=91002>Arlington Shelter</option>
                    <option value=91001>Fluffy Tails Animal Shelter</option>
                    <option value=91011>Four Paws Up Animal Rescue</option>
                    <option value=91004>Kennel Resist Rescue</option>
                    <option value=91009>Just A Little Husky Animal Shelter</option>
                    <option value=91007>No Ruff Days Animal Rescue</option>
                    <option value=91003>NOVA Animal Shelter</option>
                    <option value=91008>Paws and Claws Rescue</option>
                    <option value=91005>Paws Patrol Animal Rescue</option>
                    <option value=91006>Puppy Noses and Kitty Tails Rescue</option>
                    <option value=91010>Round of A-PAWS Rescue</option>
                    <option value=91000>Your Neighborhood Animal Rescue</option>
                  </select>
                </div>
              </div>

              <div class="row form-group">

                <div class="col-md-12">
                  <label class="text-black" for="shelter2">Secondary Shelter</label>
                  <select type="text" id="shelter2" name="shelter2" class="form-control" required value="<?php echo $shelter2;?>">
                    <option disabled selected value="">Select an option</option>
                    <option value=91002>Arlington Shelter</option>
                    <option value=91001>Fluffy Tails Animal Shelter</option>
                    <option value=91011>Four Paws Up Animal Rescue</option>
                    <option value=91004>Kennel Resist Rescue</option>
                    <option value=91009>Just A Little Husky Animal Shelter</option>
                    <option value=91007>No Ruff Days Animal Rescue</option>
                    <option value=91003>NOVA Animal Shelter</option>
                    <option value=91008>Paws and Claws Rescue</option>
                    <option value=91005>Paws Patrol Animal Rescue</option>
                    <option value=91006>Puppy Noses and Kitty Tails Rescue</option>
                    <option value=91010>Round of A-PAWS Rescue</option>
                    <option value=91000>Your Neighborhood Animal Rescue</option>
                  </select>
                </div>
              </div>


              <br>

              <h2>Your Foster Preference</h2>
                <p>Here you will specify the types of animals you are interested in fostering.</p>

                <div class="row form-group">

                  <div class="col-md-12">
                    <label class="text-black" for="species">Species</label>
                    <select type="text" id="species" name = "species" class="form-control" required value="<?php echo $species;?>">
                      <option disabled selected value="">Select an option</option>
                      <option value="dog">Dogs</option>
                      <option value="cat">Cats</option>
                      <option value="any">Both Dogs and Cats</option>
                    </select>
                  </div>
                </div>

                <div class="row form-group">

                  <div class="col-md-12">
                    <label class="text-black" for="size">Animal Size</label>
                    <select type="text" id="size" name = "size" class="form-control" required value="<?php echo $size;?>">
                      <option disabled selected value="">Select an option</option>
                      <option value="small">Small</option>
                      <option value="medium">Medium</option>
                      <option value="large">Large</option>
                      <option value="any">Any Size</option>
                    </select>
                  </div>
                </div>

                <div class="row form-group">

                  <div class="col-md-12">
                    <label class="text-black" for="age">Animal Age</label>
                    <select type="text" id="age" name = "age" class="form-control" required value="<?php echo $age;?>">
                      <option disabled selected value="">Select an option</option>
                      <option value="newborn">Newborn (1 month and younger)</option>
                      <option value="baby">Baby (1-6 months)</option>
                      <option value="young">Young (7-24 months)</option>
                      <option value="adult">Adult (25-71 months)</option>
                      <option value="senior">Senior (72+ months)</option>
                      <option value="any">Any Age</option>
                    </select>
                  </div>
                </div>

                <div class="row form-group">

                  <div class="col-md-12">
                    <label class="text-black" for="specialNeeds">Animal with Special Needs</label>
                    <select type="text" id="specialNeeds" name = "specialNeeds" class="form-control" required value="<?php echo $specialNeeds;?>">
                      <option disabled selected value="">Select an option</option>
                      <option value="yes">Behavioral</option>
                      <option value="yes">Medical</option>
                      <option value="no">No</option>
                    </select>
                  </div>
                </div>

                <div class="row form-group">

                  <div class="col-md-12">
                    <label class="text-black" for="fosterToAdopt">Are you interested in fostering to adopt?</label>
                    <select type="text" id="fosterToAdopt" name = "fosterToAdopt" class="form-control" required value="<?php echo $fosterToAdopt;?>">
                      <option disabled selected value="">Select an option</option>
                      <option value="yes">Yes</option>
                      <option value="no">No</option>
                    </select>
                  </div>
                </div>

                <div class="row form-group">

                  <div class="col-md-12">
                    <label class="text-black" for="pets">How many animals are you willing to foster?</label>
                    <input type="text" id="animalCount"  name = "animalCount" class="form-control" pattern="[0-9]{,2}" required value="<?php echo $animalCount;?>" placeholder="Enter a number">
                  </div>
                </div>


                <div class="row form-group">

                  <div class="col-md-12">
                    <label class="text-black" for="availableNow">Are you available immediately?</label>
                    <select type="text" id="availableNow" name = "availableNow" class="form-control" required value="<?php echo $availableNow;?>">
                      <option disabled selected value="">Select an option</option>
                      <option value="yes">Yes</option>
                      <option value="no">No</option>
                    </select>
                  </div>
                </div>

                <br>

              <div class="row form-group">
                <div class="col-md-12">
                  <input type="submit" value="Submit Application" class="btn btn-primary py-2 px-4 text-white">
                </div>
              </div>


            </form>
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

  <?php
  if ($_SERVER["REQUEST_METHOD"] == "POST") {

    //Connecting to the database
        $server = [REDACTED];
        $username = [REDACTED];
        $password = [REDACTED];
        $db = [REDACTED];

        // Create connection
        $conn = new mysqli($servername, $username, $password, $db);
        if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
        }

        $sql = "INSERT INTO foster_applications (applicantId)
                VALUES ('$fosterId')";

        if ($conn->query($sql) === FALSE) {
          echo "Error: " . $sql . "<br>" . $conn->error;
        } else {
          $applicationId = $conn->insert_id;
          $_SESSION['applicationId'] = $applicationId;
        }

        if (!empty($_POST['employmentStatus']) && !empty($_POST['specialNeedsExp']) && !empty($_POST['hoursAway'])) {

          $sql = "UPDATE foster_applicants
                  SET employmentStatus = '$employmentStatus',
                      specialNeedsExp = '$specialNeedsExp',
                      hoursAway = '$hoursAway',
                      applicationId = '$applicationId'
                  WHERE fosterId = '$fosterId'";

          if ($conn->query($sql) === FALSE) {
            echo "Error: " . $sql . "<br>" . $conn->error;
          }
      }

      if (!empty($_POST['homeType']) && !empty($_POST['fencedBackyard']) && !empty($_POST['homeOwnership'])
          && !empty($_POST['residents']) && !empty($_POST['pets']) && !empty($_POST['petsVaccinated'])) {

            $sql = "INSERT INTO foster_home (homeType, fencedBackyard, homeOwnership, residents, pets, petsVaccinated, applicantId)
                    VALUES ('$homeType','$fencedBackyard','$homeOwnership','$residents','$pets','$petsVaccinated','$fosterId')";

            if ($conn->query($sql) === FALSE) {
              echo "Error: " . $sql . "<br>" . $conn->error;
            }
          }

      if (!empty($_POST['shelter1']) && !empty($_POST['shelter2']) && !empty($_POST['species'])
          && !empty($_POST['size']) && !empty($_POST['age']) && !empty($_POST['specialNeeds'])
          && !empty($_POST['fosterToAdopt']) && !empty($_POST['animalCount']) && !empty($_POST['availableNow'])) {

            $sql = "INSERT INTO foster_preference (shelter1, shelter2, species, size, age, specialNeeds, fosterToAdopt, availableNow, animalCount, applicantId)
                    VALUES ('$shelter1','$shelter2','$species','$size','$age','$specialNeeds','$fosterToAdopt','$availableNow','$animalCount','$fosterId')";

            if ($conn->query($sql) === FALSE) {
              echo "Error: " . $sql . "<br>" . $conn->error;
            } else {
              echo "<script type='text/javascript'>";
  						echo "window.location='applicationSubmitted.php'";
  						echo "</script>";
            }
          }


        $conn->close();
      }
    ?>


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
