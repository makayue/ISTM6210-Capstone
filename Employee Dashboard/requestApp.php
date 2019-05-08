<?php
// Start PHP Session to grab employee name
session_start();
 ?>

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
  <link href="styles.css" rel="stylesheet">


  </head>
  <?php
  $fosterReqId = $_GET['fosterReqId'];

  if (!empty($_POST['decOption'])) {
    $decOption = $_POST['decOption'];
  }

  if (!empty($_POST['reasonCode'])) {
    $reasonCode = $_POST['reasonCode'];
  }
   ?>

  <body id="page-top">
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

    //Select animal request ID associated with fosterId
    $sql = "SELECT requestId, fosterId, animalId from Animal_Request
            WHERE requestId = $fosterReqId";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      //output data of each row
      while($row = $result->fetch_assoc()) {
        $animalReqId = $row['requestId'];
        $_SESSION['animalReqId'] = $animalReqId;
        $fosterId = $row['fosterId'];
        $_SESSION['fosterId'] = $fosterId;
        $animalId = $row['animalId'];
        $_SESSION['animalId'] = $animalId;
      }
    } else {
      $_SESSION['animalReqId'] = 51550;
      $animalReqId = 51550;
    }

  ?>

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
          <h1 class="h3 mb-4 text-gray-800">Animal Request</h1>
          <p class="mb-4">Review the selected animal request to process. Ensure that a reason code has been selected
            for both an approval and denial.</p>

            <!-- Application ID -->
          <div class="row mb-4 col-md-12">
            <label for='appId'>Request ID</label>
            <div class="row mb-4 col-md-12">
              <input type='text' class='form-control col-md-3' id='appId' disabled value=<?php echo $animalReqId;?>>
            </div>
          </div>
          <!-- End Application ID -->


            <!-- Foster Information -->
            <div class="card shadow mb-4">
              <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Foster Information</h6>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-bordered table-sm table-fixed" width="100%" cellspacing="0">
                    <?php
                        $fosterId = $_SESSION['fosterId'];
                        //Show table
                        $sql = "SELECT concat(lastName, ', ', firstName) AS name,
                                       fosterId,
                                       emailAddress,
                                       concat(userAddress, ', ', userCity, ', ', userState, ' ', userZipCode) AS address,
                                       phone,
                                       (year(now()) - year(birthdate)) AS age,
                                       employmentStatus AS es,
                                       specialNeedsExp AS sne,
                                       hoursAway
                                FROM registered_fosters
                                WHERE fosterId = $fosterId";

                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                          //output data of each row
                          while($row = $result->fetch_assoc()) {
                            echo "<tr><th style='width: 50%'>Applicant Name</th><td style='width: 50%'>" . $row ['name'] . "</td></tr>" .
                                 "<tr><th>Applicant ID</th><td>" . $row['fosterId'] . "</td></tr>" .
                                 "<tr><th>Email Address</th><td>" . $row['emailAddress'] . "</td></tr>" .
                                 "<tr><th>Address</th><td>" . $row['address'] . "</td></tr>" .
                                 "<tr><th>Phone</th><td>" . $row['phone'] . "</td></tr>" .
                                 "<tr><th>Age</th><td>" . $row['age'] . "</td></tr>" .
                                 "<tr><th>Employment Status</th><td>" . $row['es'] . "</td></tr>" .
                                 "<tr><th>Special Needs Exp</th><td>" . $row['sne'] . "</td></tr>" .
                                 "<tr><th>Hours Away</th><td>" . $row['hoursAway'] . "</td></tr>";
                            $_SESSION['fosterId'] = $row['fosterId'];
                          }
                        } else {
                          echo "0 results";
                        }

                  ?>
                  </table>
                </div>

              </div>
            </div>
            <!-- End of Foster Information -->

            <!-- Animal Information -->
            <div class="card shadow mb-4">
              <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Animal Information</h6>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-bordered table-sm table-fixed" width="100%" cellspacing="0">
                    <?php
                        //Show table
                        $sql = "SELECT animals.animalId AS animalId,
                                       animals.animalName AS animalName,
                                       animals.age AS animalAge,
                                       animals.location AS location,
                                       shelters.shelterName AS shelterName,
                                       animals.species AS species,
                                       animals.breed1 AS breed1,
                                       animals.sex AS sex,
                                       animals.sterilized AS sterilized,
                                       animals.vaccinated AS vaccinated,
                                       DATEDIFF(current_timestamp,registrationDate) AS shelterTenure,
                                       animals.specialNeeds AS sn,
                                       animals.fosterStatus AS fs
                               FROM Animals
                               INNER JOIN Animal_Request
                               ON animals.animalId = animal_request.animalId
                               INNER JOIN shelters
                               ON animals.shelterId = shelters.shelterId
                               WHERE animals.animalId = $animalId";


                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                          //output data of each row
                          while($row = $result->fetch_assoc()) {
                            $animalId = $row['animalId'];
                            echo "<tr><th style='width: 50%'>Animal ID</th><td style='width: 50%'>" . $row ['animalId'] . "</td></tr>" .
                                 "<tr><th>Name</th><td>" . $row['animalName'] . "</td></tr>" .
                                 "<tr><th>Age</th><td>" . $row['animalAge'] . "</td></tr>" .
                                 "<tr><th>Location</th><td>" . $row['location'] . "</td></tr>" .
                                 "<tr><th>Shelter Name</th><td>" . $row['shelterName'] . "</td></tr>" .
                                 "<tr><th>Species</th><td>" . $row['species'] . "</td></tr>" .
                                 "<tr><th>Primary Breed</th><td>" . $row['breed1'] . "</td></tr>" .
                                 "<tr><th>Sex</th><td>" . $row['sex'] . "</td></tr>" .
                                 "<tr><th>Sterilized</th><td>" . $row['sterilized'] . "</td></tr>" .
                                 "<tr><th>Vaccinated</th><td>" . $row['vaccinated'] . "</td></tr>" .
                                 "<tr><th>Shelter Tenure</th><td>" . $row['shelterTenure'] . "</td></tr>" .
                                 "<tr><th>Special Needs</th><td>" . $row['sn'] . "</td></tr>" .
                                 "<tr><th>Foster Status</th><td>" . $row['fs'] . "</td></tr>";
                          }
                        } else {
                          echo "0 results";
                        }
                  ?>
                  </table>
                </div>

              </div>
            </div>
            <!-- End of Animal Information -->

            <!-- Matching Criteria -->
            <div class="card shadow mb-4">
              <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Matching Criteria</h6>
              </div>
              <div class="card-body">
                <p>In this section, the animal's needs are compared to what the foster can provide.</p>
                <div class="table-responsive">
                  <table class="table table-bordered table-sm table-fixed" width="100%" cellspacing="0">
                    <thead>
                      <th>Criteria</th>
                      <th>Animal Needs</th>
                      <th>Foster Response</th>
                    </thead>
                    <tbody>
                      <?php

                        //Show table
                        $sql = "SELECT animal_request.animalId AS animalId,
                                       animal_request.fosterId AS fosterId,
                                       home_requirements.hometype AS animalHomeType,
                                       foster_home.homeType AS homeType,
                                       home_requirements.fencedBackyard AS animalFB,
                                       foster_home.fencedBackyard AS fencedBackyard,
                                       home_requirements.homePrefWithMen AS animalhpwm,
                                       home_requirements.homePrefWithWomen AS animalhpww,
                                       home_requirements.homePrefWithChildren AS animalhpwc,
                                       home_requirements.homePrefWithPets AS animalhpwp,
                                       foster_home.pets AS pets,
                                       foster_home.petsVaccinated AS petsVaccinated
                                FROM animal_request
                                INNER JOIN home_requirements
                                  ON animal_request.animalId = home_requirements.animalId
                                INNER JOIN foster_home
                                  ON animal_request.fosterId = foster_home.fosterId
                                WHERE animal_request.animalId = $animalId
                                AND animal_request.fosterId = $fosterId;


                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                          //output data of each row
                          while($row = $result->fetch_assoc()) {
                            if ($row['pets'] > 0) {
                              $homeHasPets = 'yes';
                            } else {
                              $homeHasPets = 'no';
                            }
                            echo "<tr><th style='width: 33%'>Home Type</th>" .
                                      "<td style='width: 33%'>" . $row['animalHomeType'] . "</td>" .
                                      "<td style='width: 33%'>" . $row['homeType'] . "</td></tr>" .
                                  "<tr><th>Fenced Backyard</th>" .
                                      "<td>" . $row['animalFB'] . "</td>" .
                                      "<td>" . $row['fencedBackyard'] . "</td></tr>" .
                                  "<tr><th>Home Preference</th><td></td><td></td></tr>" .
                                  "<tr><td>With Men</td><td>" . $row['animalhpwm'] . "</td><td>yes</td></tr>" .
                                  "<tr><td>With Women</td><td>" . $row['animalhpww'] . "</td><td>yes</td></tr>" .
                                  "<tr><td>With Children</td><td>" . $row['animalhpwc'] . "</td><td>no</td></tr>" .
                                  "<tr><td>With Pets</td><td>" . $row['animalhpwp'] . "</td><td>" . $homeHasPets . ", vaccinated: " . $row['petsVaccinated'] . "</td></tr>"
                                  ;
                          }
                        } else {
                          echo "0 results";
                        }
                      ?>
                        </tbody>


                  </table>
                </div>

              </div>
            </div>
            <!-- End of Matching Criteria -->

            <!-- Decision Form -->
            <div class="card shadow mb-4">
              <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Request Decision</h6>
              </div>
              <div class="card-body">

                <form id='appDecision' method="post" class="form-detail reportType">
                  <div class='form-group'>

                      <!-- App Decision -->
                      <label class='text-gray-800' for='decOption'>Select Decision</label>
                      <div class="row mb-4 col-md-12">
                        <select type="text" id="decOption" name = "decOption" class="form-control form-group input-text col-md-3" required value="<?php echo $decOption;?>">
                          <option disabled selected value=''>Select an option</option>
              						<option value='Approved'>Approve</option>
                          <option value='Denied'>Deny</option>
              						<option value=''>Request more information</option>
            						</select>
                      </div>

                      <!-- Reason Code -->
                      <label class='text-gray-800' for='decOption'>Reason Code</label>
                      <div class="row mb-4 col-md-12">
                        <select type="text" id="reasonCode" name = "reasonCode" class="form-control form-group input-text col-md-3" required value="<?php echo $reasonCode;?>">
                          <option disabled selected value=''>Select an option</option>
                          <option value='No Issues'>No Issues</option>
                          <option value='Behavioral'>Behavioral</option>
                          <option value='Home Situation'>Home Situation</option>
                          <option value='Hours Away'>Hours Away</option>
                          <option value='Income Stability'>Income Stability</option>
                        </select>
                      </div>

                      <!-- Comments -->
                      <label class='text-gray-800' for='comments'>Additional Comments</label>
                      <div class="row mb-4 col-md-12">
                        <textarea type="text" id="comments" name = "comments" class="form-control form-group input-text"
                                  size="4" placeholder="Additional Comments">
                        </textarea>
                      </div>

                        <!-- Form Submit Button -->
                      <div class="row mb-4 col-md-12">
                        <input type="submit" value="Process Application" class="btn btn-primary py-2 px-4 text-white">
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            <!-- End of Decision Form -->
            <?php
              if(!empty($_POST['decOption']) && $_POST['reasonCode']) {
                $employeeId = 11050;

                /* Insert application decision into the foster_app_decisions table */
        				$sql = "INSERT INTO request_decisions (employeeId, requestId, decision, reasonCode)
        								VALUES ('$employeeId', '$animalReqId','$decOption', '$reasonCode')";
        				if ($conn->query($sql) === FALSE) {
        					echo "Error: " . $sql . "<br>" . $conn->error;
        				}

                if ($_POST['decOption'] == 'Approved') {
                  /* Update foster activity */
                  $sql = "UPDATE foster_activity
                          SET type = 'pending pickup',
                              approvalDate = CURRENT_TIMESTAMP,
                              status = 'approved'
                          WHERE fosterId = '$fosterId'
                          AND animalId = '$animalId'";

                  if ($conn->query($sql) === FALSE) {
          					echo "Error: " . $sql . "<br>" . $conn->error;
          				}

                  $sql = "UPDATE animal_request
                          SET requestStatus = 'Approved'
                          WHERE fosterId = $fosterId
                          AND animalId = $animalId";

                  if ($conn->query($sql) === FALSE) {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                  }

                  $sql = "UPDATE Animals
                          SET fosterStatus = 'Pending'
                          WHERE animalId = $animalId";

                  if ($conn->query($sql) === FALSE) {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                  } else {
                    $conn->close();
                    echo "<script type='text/javascript'>";
                    echo "window.location='reqProcessed.php'";
                    echo "</script>";
                  }

                }
                $conn->close();
              }



          			?>


        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

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
