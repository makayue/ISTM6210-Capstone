<?php
// Start PHP Session to grab employee name
session_start();
 ?>

<!-- What to do:
      1. Add javascript so that instead of redirecting on submission, the table disappears and some success dialogue shows instead
-->

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>FosterFinder Employee Dashboard</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

  </head>
  <?php
  if ($_SERVER["REQUEST_METHOD"] == "POST") {

    //Animal Name
    $animalName = $_POST['animalName'];
    $species = $_POST['species'];
    $breed1 = $_POST['breed1'];
    $age = $_POST['age'];

    // Age status
    if ($_POST['age'] == '1') {
      $ageStatus = 'newborn';
    } elseif($_POST['age'] < '7') {
      $ageStatus = 'baby';
    } elseif ($_POST['age'] < '25') {
      $ageStatus = 'young';
    } elseif ($_POST['age'] < '73') {
      $ageStatus = 'adult';
    } else {
      $ageStatus = 'senior';
    }

    $sex = $_POST['sex'];
    $color1 = $_POST['color1'];
    $color2 = $_POST['color2'];
    $size = $_POST['size'];
    $vaccinated = $_POST['vaccinated'];
    $sterilized = $_POST['sterilized'];
    $houseTrained = $_POST['houseTrained'];
    $specialNeeds = $_POST['specialNeeds'];
    $microchipId = $_POST['microchipId'];

    //Good with dogs
    if (!empty($_POST['goodWithDogs'])) {
      $goodWithDogs = $_POST['goodWithDogs'];
    } else {
      $goodWithDogs = 'no';
    }

    //Good with cats
    if (!empty($_POST['goodWithCats'])) {
      $goodWithCats = $_POST['goodWithCats'];
    } else {
      $goodWithCats = 'no';
    }

    //Good with other
    if (!empty($_POST['goodWithOther'])) {
      $goodWithOther = $_POST['goodWithOther'];
    } else {
      $goodWithOther = 'no';
    }

    //Good with children
    if (!empty($_POST['goodWithChildren'])) {
      $goodWithChildren = $_POST['goodWithChildren'];
    } else {
      $goodWithChildren = 'no';
    }

    //Shelter location
    if (!empty($_POST['shelterId'])) {
      $shelterId = $_POST['shelterId'];
    }

    if(!empty($_POST['description'])) {
      $description = $_POST['description'];
    }


    //homeType
    if (!empty($_POST['homeType'])) {
      $homeType = $_POST['homeType'];
    }

    //Home Preferences - without men
    if (!empty($_POST['homePrefWithoutMen'])) {
      $homePrefWithoutMen = 'no';
    } else {
      $homePrefWithoutMen = 'yes';
    }

    //Home Preferences - without women
    if (!empty($_POST['homePrefWithoutWomen'])) {
      $homePrefWithoutWomen = 'no';
    } else {
      $homePrefWithoutWomen = 'yes';
    }

    //Home Preferences - without children
    if (!empty($_POST['homePrefWithoutChildren'])) {
      $homePrefWithoutChildren = 'no';
    } else {
      $homePrefWithoutChildren = 'yes';
    }

    //Home Preferences - without pets
    if (!empty($_POST['homePrefWithoutPets'])) {
      $homePrefWithoutPets = 'no';
    } else {
      $homePrefWithoutPets = 'yes';
    }

    //Fenced backyard
    if (!empty($_POST['fencedBackyard'])) {
      $fencedBackyard = $_POST['fencedBackyard'];
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

  <body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="employeeHome.php">
        <div class="sidebar-brand-icon rotate-n-15">
          <i class="fas fa-paw"></i>
        </div>
        <div class="sidebar-brand-text mx-3">FosterFinder</div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item active">
        <a class="nav-link" href="employeeHome.php">
          <i class="fas fa-fw fa-chalkboard"></i>
          <span>Shelter Dashboard</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Management
      </div>

      <!-- Nav Item - Foster Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-fw fa-user"></i>
          <span>Fosters</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Foster Information</h6>
            <a class="collapse-item" href="activeFosters.php">Active Fosters</a>
            <a class="collapse-item" href="inactiveFosters.php">Inactive Fosters</a>
            <a class="collapse-item" href="pendingFosters.php">Pending Fosters</a>
            <a class="collapse-item" href="completedFosterApps.php">Completed Applications</a>
          </div>
        </div>
      </li>

      <!-- Nav Item - Animals Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
          <i class="fas fa-fw fa-dog"></i>
          <span>Animals</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Animal Information</h6>
            <a class="collapse-item" href="animals.php">Registered Animals</a>
            <a class="collapse-item" href="shelterAnimals.php">Unregistered Animals</a>
          </div>
        </div>
      </li>

      <!-- Nav Item - Activity Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseActivity" aria-expanded="true" aria-controls="collapseUtilities">
          <i class="fas fa-fw fa-home"></i>
          <span>Foster Activity</span>
        </a>
        <div id="collapseActivity" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Activity Information</h6>
            <a class="collapse-item" href="activeFosterActivity.php">Active Fosters</a>
            <a class="collapse-item" href="pendingAnimalRequests.php">Pending Animal Requests</a>
            <a class="collapse-item" href="completedRequests.php">Completed Requests</a>
          </div>
        </div>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>

          <!-- Topbar Search -->
          <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
            <div class="input-group">
              <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
              <div class="input-group-append">
                <button class="btn btn-primary" type="button">
                  <i class="fas fa-search fa-sm"></i>
                </button>
              </div>
            </div>
          </form>

          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

            <!-- Nav Item - Search Dropdown (Visible Only XS) -->
            <li class="nav-item dropdown no-arrow d-sm-none">
              <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
              </a>
              <!-- Dropdown - Messages -->
              <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                <form class="form-inline mr-auto w-100 navbar-search">
                  <div class="input-group">
                    <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                      <button class="btn btn-primary" type="button">
                        <i class="fas fa-search fa-sm"></i>
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </li>

            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><b>Just a Little Husky Animal Shelter</b></span>
              </a>
            </li>
            <!-- Nav Item - Alerts -->
            <li class="nav-item dropdown no-arrow mx-1">
              <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>
                <!-- Counter - Alerts -->
                <span class="badge badge-danger badge-counter">3+</span>
              </a>
              <!-- Dropdown - Alerts -->
              <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header">
                  Alerts Center
                </h6>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="mr-3">
                    <div class="icon-circle bg-primary">
                      <i class="fas fa-file-alt text-white"></i>
                    </div>
                  </div>
                  <div>
                    <div class="small text-gray-500">December 12, 2019</div>
                    <span class="font-weight-bold">A new monthly report is ready to download!</span>
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="mr-3">
                    <div class="icon-circle bg-success">
                      <i class="fas fa-donate text-white"></i>
                    </div>
                  </div>
                  <div>
                    <div class="small text-gray-500">December 7, 2019</div>
                    $290.29 has been deposited into your account!
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="mr-3">
                    <div class="icon-circle bg-warning">
                      <i class="fas fa-exclamation-triangle text-white"></i>
                    </div>
                  </div>
                  <div>
                    <div class="small text-gray-500">December 2, 2019</div>
                    Spending Alert: We've noticed unusually high spending for your account.
                  </div>
                </a>
                <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
              </div>
            </li>

            <!-- Nav Item - Messages -->
            <li class="nav-item dropdown no-arrow mx-1">
              <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-envelope fa-fw"></i>
                <!-- Counter - Messages -->
                <span class="badge badge-danger badge-counter">7</span>
              </a>
              <!-- Dropdown - Messages -->
              <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="messagesDropdown">
                <h6 class="dropdown-header">
                  Message Center
                </h6>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="dropdown-list-image mr-3">
                    <img class="rounded-circle" src="https://source.unsplash.com/fn_BT9fwg_E/60x60" alt="">
                    <div class="status-indicator bg-success"></div>
                  </div>
                  <div class="font-weight-bold">
                    <div class="text-truncate">Hi there! I am wondering if you can help me with a problem I've been having.</div>
                    <div class="small text-gray-500">Emily Fowler · 58m</div>
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="dropdown-list-image mr-3">
                    <img class="rounded-circle" src="https://source.unsplash.com/AU4VPcFN4LE/60x60" alt="">
                    <div class="status-indicator"></div>
                  </div>
                  <div>
                    <div class="text-truncate">I have the photos that you ordered last month, how would you like them sent to you?</div>
                    <div class="small text-gray-500">Jae Chun · 1d</div>
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="dropdown-list-image mr-3">
                    <img class="rounded-circle" src="https://source.unsplash.com/CS2uCrpNzJY/60x60" alt="">
                    <div class="status-indicator bg-warning"></div>
                  </div>
                  <div>
                    <div class="text-truncate">Last month's report looks great, I am very happy with the progress so far, keep up the good work!</div>
                    <div class="small text-gray-500">Morgan Alvarez · 2d</div>
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="dropdown-list-image mr-3">
                    <img class="rounded-circle" src="https://source.unsplash.com/Mv9hjnEUHR4/60x60" alt="">
                    <div class="status-indicator bg-success"></div>
                  </div>
                  <div>
                    <div class="text-truncate">Am I a good boy? The reason I ask is because someone told me that people say this to all dogs, even if they aren't good...</div>
                    <div class="small text-gray-500">Chicken the Dog · 2w</div>
                  </div>
                </a>
                <a class="dropdown-item text-center small text-gray-500" href="#">Read More Messages</a>
              </div>
            </li>

            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Jili Zhou</span>
                <img class="img-profile rounded-circle" src="img/jili.jpg">
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  Profile
                </a>
                <a class="dropdown-item" href="#">
                  <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                  Settings
                </a>
                <a class="dropdown-item" href="#">
                  <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                  Activity Log
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>
              </div>
            </li>

          </ul>

        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800">Add Animal</h1>
          <p class="mb-4">Complete the following information to add a new animal to the FosterFinder system.</p>

          <!-- Form Content -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Add New Animal</h6>
            </div>
            <div class="card-body" id='first'>
              <form id='animalProfile' method="post" class="form-detail animalProfile">

                <h5 class="mb-4"><b>Animal Information</b></h5>

                <!-- Check if they are an unregistered animal -->
                <div class='row form-group'>
                  <div class='col-md-12'>
                    <label class='text-gray-800' for='shelterName'>Select ID if animal came from a registered kill shelter</label>
                    <select type="text" id="shelterState" name = "shelterState" class="form-control" required value="<?php echo $shelterAnimalId;?>">
                      <option selected value='ID'>ID</option>
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

                        $sql = "SELECT shelterAnimalId from shelter_animal";

                        $result = $conn->query($sql);

                        if ($result->num_rows>0) {
                          //output data of each row to an option
                          while($row = $result->fetch_assoc()) {
                            echo "<option value=" . $row['shelterAnimalId'] . ">" . $row['shelterAnimalId'] . "</option>";
                          }
                        }
                        ?>
                      </select>
                  </div>
                </div>

                <!-- Animal Name -->
                <div class='row form-group'>
                  <div class='col-md-12'>
                    <label class='text-gray-800' for='animalName'>Animal Name</label>
                    <input type="text" name="animalName" id="animalName" class="form-control" required value="<?php echo $animalName;?>">
                  </div>
                </div>

                <!-- Species -->
                <div class='row form-group'>
                  <div class='col-md-12'>
                    <label class='text-gray-800' for='species'>Species</label>
                    <select type="text" id="species" name = "species" class="form-control" value="<?php echo $species;?>">
                      <option disabled selected value="">Select an option</option>
                      <option value="dog">Dog</option>
        							<option value="cat">Cat</option>
        						</select>
                  </div>
                </div>

                <!-- Breed1 -->
                <div class='row form-group'>
                  <div class='col-md-12'>
                    <label class='text-gray-800' for='breed1'>Primary Breed</label>
                    <select type="text" id="breed1" name = "breed1" class="form-control" required value="<?php echo $breed1;?>" size="4">
                      <option disabled value=''>Select a species</option>
                      <!--Options populated using JavaScript-->
        						</select>
                  </div>
                </div>

                <!-- Age -->
                <div class='row form-group'>
                  <div class='col-md-12'>
                    <label class='text-gray-800' for='age'>Age (in months)</label>
                    <input type="int" name="age" id="age" class="form-control" required pattern="[0-9]{,5}" value="<?php echo $age;?>">
                  </div>
                </div>

                <!-- Sex -->
                <div class='row form-group'>
                  <div class='col-md-12'>
                    <label class='text-gray-800' for='sex'>Sex</label>
                    <div class="radio" name="fence">
                      <label><input type="radio" class='text-gray-800' name='sex' <?php if (isset($sex) && $sex=="female") echo "checked";?> value="female">  Female</label>
                      <label><input type="radio" class='text-gray-800' name='sex' <?php if (isset($sex) && $sex=="male") echo "checked";?> value="male">  Male</label>
                    </div>
                  </div>
                </div>

                <!-- Primary Color -->
                <div class='row form-group'>
                  <div class='col-md-12'>
                    <label class='text-gray-800' for='color1'>Primary Color</label>
                    <select type="text" id="color1" name = "color1" class="form-control" required value="<?php echo $color1;?>">
                      <option disabled selected value=''>Select an option</option>
          						<option value='black'>Black</option>
          						<option value='brown'>Brown</option>
          						<option value='golden'>Golden</option>
          						<option value='yellow'>Yellow</option>
          						<option value='cream'>Cream</option>
          						<option value='gray'>Gray</option>
          						<option value='white'>White</option>
        						</select>
                  </div>
                </div>

                <!-- Secndary Color -->
                <div class='row form-group'>
                  <div class='col-md-12'>
                    <label class='text-gray-800' for='color2'>Secondary Color</label>
                    <select type="text" id="color2" name = "color2" class="form-control" required value="<?php echo $color2;?>">
                      <option disabled selected value=''>Select an option</option>
          						<option value='black'>Black</option>
          						<option value='brown'>Brown</option>
          						<option value='golden'>Golden</option>
          						<option value='yellow'>Yellow</option>
          						<option value='cream'>Cream</option>
          						<option value='gray'>Gray</option>
          						<option value='white'>White</option>
        						</select>
                  </div>
                </div>

                <!-- Maturity Size -->
                <div class='row form-group'>
                  <div class='col-md-12'>
                    <label class='text-gray-800' for='size'>Maturity Size</label>
                    <select type="text" id="size" name = "size" class="form-control" required value="<?php echo $size;?>">
                      <option disabled selected value=''>Select an option</option>
                      <option value='small'>Small</option>
          						<option value='medium'>Medium</option>
          						<option value='large'>Large</option>
          						<option value='extra large'>Extra Large</option>
        						</select>
                  </div>
                </div>

                <!-- Vaccination Status -->
                <div class='row form-group'>
                  <div class='col-md-12'>
                    <label class='text-gray-800' for='vaccinated'>Vaccination Status</label>
                    <select type="text" id="vaccinated" name = "vaccinated" class="form-control" required value="<?php echo $vaccinated;?>">
                      <option disabled selected value=''>Select an option</option>
                      <option value='up-to-date'>Vaccinations Up-To-Date</option>
          						<option value='notVaccinated'>Not Vaccinated</option>
          						<option value='unknown'>Unknown</option>
        						</select>
                  </div>
                </div>

                <!-- Sterilization Status -->
                <div class='row form-group'>
                  <div class='col-md-12'>
                    <label class='text-gray-800' for='sterilized'>Has the animal been spayed/neutered?</label>
                    <div class="radio" name="sterilized">
                      <label><input type="radio" class='text-gray-800' name='sterilized' <?php if (isset($sterilized) && $sterilized=="yes") echo "checked";?> value="yes">  Yes</label>
                      <label><input type="radio" class='text-gray-800' name='sterilized' <?php if (isset($sterilized) && $sterilized=="no") echo "checked";?> value="no">  No</label>
                    </div>
                  </div>
                </div>

                <!-- House-Trained Status -->
                <div class='row form-group'>
                  <div class='col-md-12'>
                    <label class='text-gray-800' for='houseTrained'>Is the animal house-trained?</label>
                    <select type="text" id="houseTrained" name = "houseTrained" class="form-control" required value="<?php echo $houseTrained;?>">
                      <option disabled selected value=''>Select an option</option>
                      <option value='yes'>Yes</option>
          						<option value='no'>No</option>
        						</select>
                  </div>
                </div>

                <!-- Special Needs Status -->
                <div class='row form-group'>
                  <div class='col-md-12'>
                    <label class='text-gray-800' for='specialNeeds'>Does the animal have any special needs?</label>
                    <select type="text" id="specialNeeds" name = "specialNeeds" class="form-control" required value="<?php echo $specialNeeds;?>">
                      <option disabled selected value=''>Select an option</option>
                      <option value="no">No special needs</option>
                      <option value="behavioral">Behavioral</option>
          						<option value="medical">Medical</option>
        						</select>
                  </div>
                </div>

                <!-- MicrochipId -->
                <div class='row form-group'>
                  <div class='col-md-12'>
                    <label class='text-gray-800' for='microchipId'>Microchip ID</label>
                    <input type="text" name="microchipId" id="microchipId" class="form-control" required value="<?php echo $microchipId;?>">
                  </div>
                </div>

                <!-- Good with... -->
                <div class='row form-group'>
                  <div class='col-md-12'>
                    <label class='text-gray-800' for='goodWith'>Is Good With:</label>
                    <div class="checkbox" name="goodWith">
                      <label><input type="checkbox" class='text-gray-800' name='goodWithDogs' <?php if (isset($goodWithDogs) && $goodWithDogs=="yes") echo "checked";?> value='yes'>  Dogs</label>
                      <label><input type="checkbox" class='text-gray-800' name='goodWithCats' <?php if (isset($goodWithCats) && $goodWithCats=="yes") echo "checked";?> value='yes'>  Cats</label>
                      <label><input type="checkbox" class='text-gray-800' name='goodWithOther' <?php if (isset($goodWithOther) && $goodWithOther=="yes") echo "checked";?> value='yes'>  Other Animals</label>
                      <label><input type="checkbox" class='text-gray-800' name='goodWithChildren' <?php if (isset($goodWithChildren) && $goodWithChildren=="yes") echo "checked";?> value='yes'>  Children</label>
                    </div>
                  </div>
                </div>

                <!-- Shelter Location -->
                <div class='row form-group'>
                  <div class='col-md-12'>
                    <label class='text-gray-800' for='shelterId'>Shelter Location</label>
                    <select type="text" id="shelterId" name = "shelterId" class="form-control" required value="<?php echo $shelterId;?>">
                      <option selected value=''>Select an option</option>
                      <?php
                        $sql = "SELECT shelterId, shelterName FROM shelters WHERE euthStatus = 'no euthanasia'";

                        $result = $conn->query($sql);

                        if ($result->num_rows>0) {
                          //output data of each row to an option
                          while($row = $result->fetch_assoc()) {
                            echo "<option value=" . $row['shelterId'] . ">" . $row['shelterName'] . "</option>";
                          }
                        }
                        ?>
                      </select>
                  </div>
                </div>

                <br>
                <h5 class="mb-4"><b>Home Requirements</b></h5>

                <!-- Home Type -->
                <div class='row form-group'>
                  <div class='col-md-12'>
                    <label class='text-gray-800' for='home'>Home Type</label>
                    <div class="radio" name="home">
                      <label><input type="radio" class='text-gray-800' name='homeType' <?php if (isset($homeType) && $homeType=="house") echo "checked";?> value='house'>  Single Home</label>
                      <label><input type="radio" class='text-gray-800' name='homeType' <?php if (isset($homeType) && $homeType=="apartment or condo") echo "checked";?> value="apartment or condo">  Townhouse/Condo</label>
                      <label><input type="radio" class='text-gray-800' name='homeType' <?php if (isset($homeType) && $homeType=="any") echo "checked";?> value="any">  Any</label>
                    </div>
                  </div>
                </div>

                <!-- Fenced Backyard -->
                <div class='row form-group'>
                  <div class='col-md-12'>
                    <label class='text-gray-800' for='fence'>Fenced Backyard</label>
                    <div class="radio" name="fence">
                      <label><input type="radio" class='text-gray-800' name='fencedBackyard' <?php if (isset($fencedBackyard) && $fencedBackyard=="yes") echo "checked";?> value="yes">  Yes</label>
                      <label><input type="radio" class='text-gray-800' name='fencedBackyard' <?php if (isset($fencedBackyard) && $fencedBackyard=="no") echo "checked";?> value="no">  No</label>
                    </div>
                  </div>
                </div>

                <!-- Good with... -->
                <div class='row form-group'>
                  <div class='col-md-12'>
                    <label class='text-gray-800' for='homeWithout'>Prefers a Home Without:</label>
                    <div class="checkbox" name="homeWithout">
                      <label><input type="checkbox" class='text-gray-800' name='homePrefWithoutMen' <?php if (isset($homePrefWithoutMen) && $homePrefWithoutMen=="no") echo "checked";?> value='no'>  Men</label>
                      <label><input type="checkbox" class='text-gray-800' name='homePrefWithoutWomen' <?php if (isset($homePrefWithoutWomen) && $homePrefWithoutWomen=="no") echo "checked";?> value='no'>  Women</label>
                      <label><input type="checkbox" class='text-gray-800' name='homePrefWithoutChildren' <?php if (isset($homePrefWithoutChildren) && $homePrefWithoutChildren=="no") echo "checked";?> value='no'>  Children</label>
                      <label><input type="checkbox" class='text-gray-800' name='homePrefWithoutPets' <?php if (isset($homePrefWithoutPets) && $homePrefWithoutPets=="no") echo "checked";?> value='no'>  Pets</label>
                    </div>
                  </div>
                </div>

                <!-- Description -->
                <div class='row form-group'>
                  <div class='col-md-12'>
                    <label class='text-gray-800' for='description'>Description</label>
                    <textarea size="4" name="description" id="description" class="form-control" value="<?php echo $description;?>" placeholder="Add any additional information"></textarea>
                  </div>
                </div>




                <!-- Form Submit Button -->
                <div class="row form-group">
                  <div class="col-md-12">
                    <input type="submit" value="Add Animal" class="btn btn-primary py-2 px-4 text-white">
                  </div>
                </div>

              </form>

              <script type="text/javascript">
      				/*
      				From JavaScript and Forms Tutorial at dyn-web.com
      				Find information and updates at http://www.dyn-web.com/tutorials/forms/
      				*/

      				// removes all option elements in select list
      				// removeGrp (optional) boolean to remove optgroups
      				function removeAllOptions(sel, removeGrp) {
      				    var len, groups, par;
      				    if (removeGrp) {
      				        groups = sel.getElementsByTagName('optgroup');
      				        len = groups.length;
      				        for (var i=len; i; i--) {
      				            sel.removeChild( groups[i-1] );
      				        }
      				    }

      				    len = sel.options.length;
      				    for (var i=len; i; i--) {
      				        par = sel.options[i-1].parentNode;
      				        par.removeChild( sel.options[i-1] );
      				    }
      				}

      				function appendDataToSelect(sel, obj) {
      				    var f = document.createDocumentFragment();
      				    var labels = [], group, opts;

      				    function addOptions(obj) {
      				        var f = document.createDocumentFragment();
      				        var o;

      				        for (var i=0, len=obj.text.length; i<len; i++) {
      				            o = document.createElement('option');
      				            o.appendChild( document.createTextNode( obj.text[i] ) );

      				            if ( obj.value ) {
      				                o.value = obj.value[i];
      				            }

      				            f.appendChild(o);
      				        }
      				        return f;
      				    }

      				    if ( obj.text ) {
      				        opts = addOptions(obj);
      				        f.appendChild(opts);
      				    } else {
      				        for ( var prop in obj ) {
      				            if ( obj.hasOwnProperty(prop) ) {
      				                labels.push(prop);
      				            }
      				        }

      				        for (var i=0, len=labels.length; i<len; i++) {
      				            group = document.createElement('optgroup');
      				            group.label = labels[i];
      				            f.appendChild(group);
      				            opts = addOptions(obj[ labels[i] ] );
      				            group.appendChild(opts);
      				        }
      				    }
      				    sel.appendChild(f);
      				}

      				// anonymous function assigned to onchange event of controlling select list
      				document.forms['animalProfile'].elements['species'].onchange = function(e) {
      				    // name of associated select list
      				    var relName = 'breed1';

      				    // reference to associated select list
      				    var relList = this.form.elements[ relName ];

      				    // get data from object literal based on selection in controlling select list (this.value)
      				    var obj = Select_List_Data[ relName ][ this.value ];

      				    // remove current option elements
      				    removeAllOptions(relList, true);

      				    // call function to add optgroup/option elements
      				    // pass reference to associated select list and data for new options
      				    appendDataToSelect(relList, obj);
      				};

      				// object literal holds data for optgroup/option elements
      				var Select_List_Data = {

      				    // name of associated select list
      				    'breed1': {

      				        // names match option values in controlling select list
      				        dog: {
      				            text: ['Mixed Breed','Affenpinscher','Afghan Hound','Airedale Terrier','Akbash','Akita','Alaskan Malamute','American Bulldog',
      				            'American Eskimo Dog','American Hairless Terrier','American Staffordshire Terrier','American Water Spaniel','Anatolian Shepherd',
      				            'Appenzell Mountain Dog','Australian Cattle Dog/Blue Heeler','Australian Kelpie','Australian Shepherd','Australian Terrier',
      				            'Basenji','Basset Hound','Beagle','Bearded Collie','Beauceron','Bedlington Terrier','Belgian Shepherd Dog Sheepdog',
      				            "Belgian Shepherd Laekenois","Belgian Shepherd Malinois","Belgian Shepherd Tervuren","Bernese Mountain Dog","Bichon Frise","Black and Tan Coonhound",
      				            "Black Labrador Retriever","Black Mouth Cur","Black Russian Terrier","Bloodhound","Blue Lacy","Bluetick Coonhound","Boerboel","Bolognese","Border Collie",
      				            "Border Terrier","Borzoi","Boston Terrier","Bouvier des Flanders","Boxer","Boykin Spaniel","Briard","Brittany Spaniel","Brussels Griffon","Bull Terrier",
      				            "Bullmastiff","Cairn Terrier","Canaan Dog","Cane Corso Mastiff","Carolina Dog","Catahoula Leopard Dog","Cattle Dog","Caucasian Sheepdog (Caucasian Ovtcharka)",
      				            "Cavalier King Charles Spaniel","Chesapeake Bay Retriever","Chihuahua","Chinese Crested Dog","Chinese Foo Dog","Chinook","Chocolate Labrador Retriever",
      				            "Chow Chow","Cirneco dell'Etna","Clumber Spaniel","Cockapoo","Cocker Spaniel","Collie","Coonhound","Corgi","Coton de Tulear","Curly-Coated Retriever",
      				            "Dachshund","Dalmatian","Dandi Dinmont Terrier","Doberman Pinscher","Dogo Argentino","Dogue de Bordeaux","Dutch Shepherd","English Bulldog",
      				            "English Cocker Spaniel","English Coonhound","English Pointer","English Setter","English Shepherd","English Springer Spaniel","English Toy Spaniel",
      				            "Entlebucher","Eskimo Dog","Feist","Field Spaniel","Fila Brasileiro","Finnish Lapphund","Finnish Spitz","Flat-coated Retriever","Fox Terrier",
      				            "Foxhound","French Bulldog","Galgo Spanish Greyhound","German Pinscher","German Shepherd Dog","German Shorthaired Pointer","German Spitz",
      				            "German Wirehaired Pointer","Giant Schnauzer","Glen of Imaal Terrier","Golden Retriever","Gordon Setter","Great Dane","Great Pyrenees",
      				            "Greater Swiss Mountain Dog","Greyhound","Harrier","Havanese","Hound","Hovawart","Husky","Ibizan Hound","Illyrian Sheepdog","Irish Setter",
      				            "Irish Terrier","Irish Water Spaniel","Irish Wolfhound","Italian Greyhound","Italian Spinone","Jack Russell Terrier","Jack Russell Terrier (Parson Russell Terrier)",
      				            "Japanese Chin","Jindo","Kai Dog","Karelian Bear Dog","Keeshond","Kerry Blue Terrier","Kishu","Klee Kai","Komondor","Kuvasz","Kyi Leo","Labrador Retriever",
      				            "Lakeland Terrier","Lancashire Heeler","Leonberger","Lhasa Apso","Lowchen","Maltese","Manchester Terrier","Maremma Sheepdog","Mastiff","McNab","Miniature Pinscher",
      				            "Mountain Cur","Mountain Dog","Munsterlander","Neapolitan Mastiff","New Guinea Singing Dog","Newfoundland Dog","Norfolk Terrier","Norwegian Buhund",
      				            "Norwegian Elkhound","Norwegian Lundehund","Norwich Terrier","Nova Scotia Duck-Tolling Retriever","Old English Sheepdog","Otterhound","Papillon",
      				            "Patterdale Terrier (Fell Terrier)","Pekingese","Peruvian Inca Orchid","Petit Basset Griffon Vendeen","Pharaoh Hound","Pit Bull Terrier","Plott Hound",
      				            "Podengo Portugueso","Pointer","Polish Lowland Sheepdog","Pomeranian","Poodle","Portuguese Water Dog","Presa Canario","Pug","Puli","Pumi","Rat Terrier",
      				            "Redbone Coonhound","Retriever","Rhodesian Ridgeback","Rottweiler","Saint Bernard","Saluki","Samoyed","Sarplaninac","Schipperke","Schnauzer","Scottish Deerhound",
      				            "Scottish Terrier Scottie","Sealyham Terrier","Setter","Shar Pei","Sheep Dog","Shepherd","Shetland Sheepdog Sheltie","Shiba Inu","Shih Tzu","Siberian Husky",
      				            "Silky Terrier","Skye Terrier","Sloughi","Smooth Fox Terrier","South Russian Ovtcharka","Spaniel","Spitz","Staffordshire Bull Terrier","Standard Poodle",
      				            "Sussex Spaniel","Swedish Vallhund","Terrier","Thai Ridgeback","Tibetan Mastiff","Tibetan Spaniel","Tibetan Terrier","Tosa Inu","Toy Fox Terrier",
      				            "Treeing Walker Coonhound","Vizsla","Weimaraner","Welsh Corgi","Welsh Springer Spaniel","Welsh Terrier","West Highland White Terrier Westie",
      				            "Wheaten Terrier","Whippet","White German Shepherd","Wire Fox Terrier","Wire-haired Pointing Griffon","Wirehaired Terrier","Xoloitzcuintle/Mexican Hairless",
      				            "Yellow Labrador Retriever","Yorkshire Terrier Yorkie"],
      				            value: ['Mixed Breed','Affenpinscher','Afghan Hound','Airedale Terrier','Akbash','Akita','Alaskan Malamute','American Bulldog',
      				            'American Eskimo Dog','American Hairless Terrier','American Staffordshire Terrier','American Water Spaniel','Anatolian Shepherd',
      				            'Appenzell Mountain Dog','Australian Cattle Dog/Blue Heeler','Australian Kelpie','Australian Shepherd','Australian Terrier',
      				            'Basenji','Basset Hound','Beagle','Bearded Collie','Beauceron','Bedlington Terrier','Belgian Shepherd Dog Sheepdog',
      				            "Belgian Shepherd Laekenois","Belgian Shepherd Malinois","Belgian Shepherd Tervuren","Bernese Mountain Dog","Bichon Frise","Black and Tan Coonhound",
      				            "Black Labrador Retriever","Black Mouth Cur","Black Russian Terrier","Bloodhound","Blue Lacy","Bluetick Coonhound","Boerboel","Bolognese","Border Collie",
      				            "Border Terrier","Borzoi","Boston Terrier","Bouvier des Flanders","Boxer","Boykin Spaniel","Briard","Brittany Spaniel","Brussels Griffon","Bull Terrier",
      				            "Bullmastiff","Cairn Terrier","Canaan Dog","Cane Corso Mastiff","Carolina Dog","Catahoula Leopard Dog","Cattle Dog","Caucasian Sheepdog (Caucasian Ovtcharka)",
      				            "Cavalier King Charles Spaniel","Chesapeake Bay Retriever","Chihuahua","Chinese Crested Dog","Chinese Foo Dog","Chinook","Chocolate Labrador Retriever",
      				            "Chow Chow","Cirneco dell'Etna","Clumber Spaniel","Cockapoo","Cocker Spaniel","Collie","Coonhound","Corgi","Coton de Tulear","Curly-Coated Retriever",
      				            "Dachshund","Dalmatian","Dandi Dinmont Terrier","Doberman Pinscher","Dogo Argentino","Dogue de Bordeaux","Dutch Shepherd","English Bulldog",
      				            "English Cocker Spaniel","English Coonhound","English Pointer","English Setter","English Shepherd","English Springer Spaniel","English Toy Spaniel",
      				            "Entlebucher","Eskimo Dog","Feist","Field Spaniel","Fila Brasileiro","Finnish Lapphund","Finnish Spitz","Flat-coated Retriever","Fox Terrier",
      				            "Foxhound","French Bulldog","Galgo Spanish Greyhound","German Pinscher","German Shepherd Dog","German Shorthaired Pointer","German Spitz",
      				            "German Wirehaired Pointer","Giant Schnauzer","Glen of Imaal Terrier","Golden Retriever","Gordon Setter","Great Dane","Great Pyrenees",
      				            "Greater Swiss Mountain Dog","Greyhound","Harrier","Havanese","Hound","Hovawart","Husky","Ibizan Hound","Illyrian Sheepdog","Irish Setter",
      				            "Irish Terrier","Irish Water Spaniel","Irish Wolfhound","Italian Greyhound","Italian Spinone","Jack Russell Terrier","Jack Russell Terrier (Parson Russell Terrier)",
      				            "Japanese Chin","Jindo","Kai Dog","Karelian Bear Dog","Keeshond","Kerry Blue Terrier","Kishu","Klee Kai","Komondor","Kuvasz","Kyi Leo","Labrador Retriever",
      				            "Lakeland Terrier","Lancashire Heeler","Leonberger","Lhasa Apso","Lowchen","Maltese","Manchester Terrier","Maremma Sheepdog","Mastiff","McNab","Miniature Pinscher",
      				            "Mountain Cur","Mountain Dog","Munsterlander","Neapolitan Mastiff","New Guinea Singing Dog","Newfoundland Dog","Norfolk Terrier","Norwegian Buhund",
      				            "Norwegian Elkhound","Norwegian Lundehund","Norwich Terrier","Nova Scotia Duck-Tolling Retriever","Old English Sheepdog","Otterhound","Papillon",
      				            "Patterdale Terrier (Fell Terrier)","Pekingese","Peruvian Inca Orchid","Petit Basset Griffon Vendeen","Pharaoh Hound","Pit Bull Terrier","Plott Hound",
      				            "Podengo Portugueso","Pointer","Polish Lowland Sheepdog","Pomeranian","Poodle","Portuguese Water Dog","Presa Canario","Pug","Puli","Pumi","Rat Terrier",
      				            "Redbone Coonhound","Retriever","Rhodesian Ridgeback","Rottweiler","Saint Bernard","Saluki","Samoyed","Sarplaninac","Schipperke","Schnauzer","Scottish Deerhound",
      				            "Scottish Terrier Scottie","Sealyham Terrier","Setter","Shar Pei","Sheep Dog","Shepherd","Shetland Sheepdog Sheltie","Shiba Inu","Shih Tzu","Siberian Husky",
      				            "Silky Terrier","Skye Terrier","Sloughi","Smooth Fox Terrier","South Russian Ovtcharka","Spaniel","Spitz","Staffordshire Bull Terrier","Standard Poodle",
      				            "Sussex Spaniel","Swedish Vallhund","Terrier","Thai Ridgeback","Tibetan Mastiff","Tibetan Spaniel","Tibetan Terrier","Tosa Inu","Toy Fox Terrier",
      				            "Treeing Walker Coonhound","Vizsla","Weimaraner","Welsh Corgi","Welsh Springer Spaniel","Welsh Terrier","West Highland White Terrier Westie",
      				            "Wheaten Terrier","Whippet","White German Shepherd","Wire Fox Terrier","Wire-haired Pointing Griffon","Wirehaired Terrier","Xoloitzcuintle/Mexican Hairless",
      				            "Yellow Labrador Retriever","Yorkshire Terrier Yorkie"]
      				          },

      				        cat: {
      				            // example without optgroups
      				            text: ["Mixed Breed","Abyssinian","American Curl","American Shorthair","American Wirehair","Applehead Siamese","Balinese","Bengal"
      				            ,"Birman","Bobtail","Bombay","British Shorthair","Burmese","Burmilla","Calico","Canadian Hairless","Chartreux","Chausie","Chinchilla"
      				            ,"Cornish Rex","Cymric","Devon Rex","Dilute Calico","Dilute Tortoiseshell","Domestic Long Hair","Domestic Medium Hair","Domestic Short Hair"
      				            ,"Egyptian Mau","Exotic Shorthair","Extra-Toes Cat (Hemingway Polydactyl)","Havana","Himalayan","Japanese Bobtail","Javanese","Korat","LaPerm"
      				            ,"Maine Coon","Manx","Munchkin","Nebelung","Norwegian Forest Cat","Ocicat","Oriental Long Hair","Oriental Short Hair","Oriental Tabby","Persian"
      				            ,"Pixie-Bob","Ragamuffin","Ragdoll","Russian Blue","Scottish Fold","Selkirk Rex","Siamese","Siberian","Silver","Singapura","Snowshoe","Somali"
      				            ,"Sphynx (hairless cat)","Tabby","Tiger","Tonkinese","Torbie","Tortoiseshell","Turkish Angora","Turkish Van","Tuxedo"],
      				            value: ["Mixed Breed","Abyssinian","American Curl","American Shorthair","American Wirehair","Applehead Siamese","Balinese","Bengal"
      				            ,"Birman","Bobtail","Bombay","British Shorthair","Burmese","Burmilla","Calico","Canadian Hairless","Chartreux","Chausie","Chinchilla"
      				            ,"Cornish Rex","Cymric","Devon Rex","Dilute Calico","Dilute Tortoiseshell","Domestic Long Hair","Domestic Medium Hair","Domestic Short Hair"
      				            ,"Egyptian Mau","Exotic Shorthair","Extra-Toes Cat (Hemingway Polydactyl)","Havana","Himalayan","Japanese Bobtail","Javanese","Korat","LaPerm"
      				            ,"Maine Coon","Manx","Munchkin","Nebelung","Norwegian Forest Cat","Ocicat","Oriental Long Hair","Oriental Short Hair","Oriental Tabby","Persian"
      				            ,"Pixie-Bob","Ragamuffin","Ragdoll","Russian Blue","Scottish Fold","Selkirk Rex","Siamese","Siberian","Silver","Singapura","Snowshoe","Somali"
      				            ,"Sphynx (hairless cat)","Tabby","Tiger","Tonkinese","Torbie","Tortoiseshell","Turkish Angora","Turkish Van","Tuxedo"]
      				        }
      				    }

      				};

      				// populate associated select list when page loads
      				window.onload = function() {
      				    var form = document.forms['animalProfile'];

      				    // reference to controlling select list
      				    var sel = form.elements['species'];
      				    sel.selectedIndex = 0;

      				    // name of associated select list
      				    var relName = 'breed1';
      				    // reference to associated select list
      				    var rel = form.elements[ relName ];

      				    // get data for associated select list passing its name
      				    // and value of selected in controlling select list
      				    var data = Select_List_Data[ relName ][ sel.value ];

      				    // add options to associated select list
      				    appendDataToSelect(rel, data);
      				};

      				</script>

            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <?php
  		if (!empty($_POST['animalName'])) {



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

  				// Insert into Animals Table
  				$sql = "INSERT INTO animals (animalName,age,ageStatus,microchipId,
  				  species,breed1,sex,color1,color2,size,sterilized,vaccinated,
  				  houseTrained,specialNeeds,goodWithDogs,goodWithCats,goodWithOther,
  				  goodWithChildren,shelterId,description)
  				        VALUES ('$animalName','$age','$ageStatus','$microchipId',
  				          '$species','$breed1','$sex','$color1','$color2',
  				          '$size','$sterilized','$vaccinated','$houseTrained',
  				          '$specialNeeds','$goodWithDogs','$goodWithCats',
  				          '$goodWithOther','$goodWithChildren','$shelterId','$description')";
  				if ($conn->query($sql) === FALSE) {
    				echo "Error: " . $sql . "<br>" . $conn->error;
  				} else {
  					$animalId = $conn->insert_id;
            $_SESSION['animalName'] = $animalName;
  				}

  				// Insert into Home_Requirements Table
  				$sql = "INSERT INTO home_requirements (homeType,fencedBackyard,homePrefWithMen,
  				homePrefWithWomen,homePrefWithChildren,homePrefWithPets,animalId) VALUES (
  					'$homeType','$fencedBackyard','$homePrefWithoutMen','$homePrefWithoutWomen',
  					'$homePrefWithoutChildren','$homePrefWithoutPets','$animalId'
  				)";
  				if ($conn->query($sql) === FALSE) {
    				echo "Error: " . $sql . "<br>" . $conn->error;
  				} else {
  					echo "<script type='text/javascript'>";
  					echo "window.location='animalAdded.php'";
  					echo "</script>";
  				}

  				$conn->close();
  			}
  		?>

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; FosterFinder 2019</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="login.html">Logout</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

</body>

</html>
