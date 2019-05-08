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

</head>

<body id="page-top">
  <?php
    // Grab name from login credentials (still need to get that working to pull from table)
    $userName = $_SESSION['userName'];

    // Grab shelterId for table filtering (still need to get login credentials working)
    if (!empty($_SESSION['shelterId'])) {
      $shelter = $_SESSION['shelterId'];
      $shelterName = $_SESSION['shelterName'];
    } else {
      $shelter = 91009;
      $shelterName = 'Just a Little Husky Animal Shelter';
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

    // Emergency Animals
    $sql = "SELECT COUNT(*) AS count FROM shelter_animal WHERE daysToEuth = 0";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      //output data of each row
      while($row = $result->fetch_assoc()) {
        $emergency = $row['count'];
      }
    } else {
      $emergency = 0;
    }

    // Pending Foster applications
    $sql = "SELECT count(*) AS count
            FROM foster_applications
            INNER JOIN foster_applicants
            ON foster_applications.applicantId = foster_applicants.fosterId
            INNER JOIN foster_preference
            ON foster_applications.applicantId = foster_preference.applicantId
            WHERE status != 'Denied'
            AND (foster_preference.shelter1 = 91009 OR foster_preference.shelter2 = 91009)";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      //output data of each row
      while($row = $result->fetch_assoc()) {
        $pendingFosters = $row['count'];
      }
    } else {
      $pendingFosters = 0;
    }

    // Pending Animal Requests
    $sql = "SELECT count(*) AS count
            FROM animal_request
            INNER JOIN registered_fosters
            ON animal_request.fosterId = registered_fosters.fosterId
            INNER JOIN foster_preference
            ON animal_request.fosterId = foster_preference.fosterId
            INNER JOIN Animals
            ON animal_request.animalId = animals.animalId
            WHERE animals.shelterId = $shelter
            AND animal_request.requestStatus != 'Approved'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      //output data of each row
      while($row = $result->fetch_assoc()) {
        $pendingAnReq = $row['count'];
      }
    } else {
      $pendingAnReq = 0;
    }

    // Pending Cat Requests
    $sql = "SELECT count(*) AS count
            FROM animals
            WHERE location = 'home'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      //output data of each row
      while($row = $result->fetch_assoc()) {
        $adoptions = $row['count'];
      }
    } else {
      $adoptions = 0;
    }

    if(isset($_GET['fosterAppId'])) {
      $_SESSION['fosterAppId'] = $_GET['fosterAppId'];
    }

    if(isset($_GET['regFosId'])) {
      $_SESSION['regFosId'] = $_GET['regFosId'];
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

            <!-- Shelter being viewed-->
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
          <div class="d-sm-flex align-items-center justify-content-between col-lg-6 mb-4">
            <h1 class="h3 mb-0 text-gray-800"><b>Dashboard</b> - Home</h1>
          </div>
          <div class="col-lg-6 mb-4">
            <a href="addShelter.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Add Shelter</a>
            <a href="addAnimal.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Add Animal</a>
            <a href="addFoster.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Add Foster</a>
            <a href="reports.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
          </div>
          <!--<div class="row">
            <div class="col-xl-3 col-md-6 mb-4">
              <form method="post" action="employeeHome.php">
                <select type="text" id="shelterSelect" name="shelterSelect" class="form-control" required value="<?php //echo $shelter;?>">
                    <option value=91002 selected>Arlington Shelter</option>
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
      						<script type="text/javascript"> document.getElementById('shelterSelect').value = "<?php //echo $_POST['shelter'];?>";</script>
                  <br>
                  <div class="col-md-12">
                    <input type="submit" value="Select" class="btn btn-primary py-2 px-4 text-white">
                  </div>
                </form>
              </div>
            </div>-->

          <!-- Content Row -->
          <div class="row">

            <!-- Animals Euthanized Card -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <a href="animalRescueToday.php"><div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Animals scheduled for euthanasia today</div></a>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $emergency;?>

                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-exclamation-triangle fa-2x text-danger"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Pending Foster Applications Card -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Pending Foster Applications</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $pendingFosters;?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-file-contract fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Pending Animal Requests Card -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Pending Animal Requests</div>
                      <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                          <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $pendingAnReq;?></div>
                        </div>

                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-dog fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Adoptions Card -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Adoptions!</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $adoptions;?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-cat fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Content Row -->

          <div class="row">

            <!-- Foster Applications Table -->
            <div class="col-lg-12 mb-4">
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">Pending Foster Applications</h6>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>Status</th>
                          <th>Submission Date</th>
                          <th>Applicant Name</th>
                          <th>View Application</th>
                        </tr>
                      </thead>
                      <tfoot>
                        <tr>
                          <th>ID</th>
                          <th>Status</th>
                          <th>Submission Date</th>
                          <th>Applicant Name</th>
                          <th>View Application</th>
                        </tr>
                      </tfoot>
                      <tbody id='show-table'>
                        <?php
                          //Show table
                            $sql = "SELECT foster_applications.applicationId AS applicationId,
                            foster_applications.status AS status,
                            foster_applications.submissionDate AS subdate,
                            concat(foster_applicants.lastName, ', ', foster_applicants.firstName) AS name,
                            foster_applicants.fosterId AS fosterAppId
                            FROM foster_applications
                            INNER JOIN foster_applicants
                            ON foster_applications.applicantId = foster_applicants.fosterId
                            INNER JOIN foster_preference
                            ON foster_applications.applicantId = foster_preference.applicantId
                            WHERE status != 'Denied'
                            AND (foster_preference.shelter1 = $shelter OR foster_preference.shelter2 = $shelter)
                            ORDER BY foster_applications.applicationId";

                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                              //output data of each row
                              while($row = $result->fetch_assoc()) {
                                echo "<tr><td> " . $row['applicationId']. "</td><td>" . $row['status'] . "</td><td>" .
                                     $row['subdate'] . "</td><td v-b-tooltip.hover title='View Profile'>" .
                                     '<a href="fosterProfile.php?regFosId=' . $row['fosterAppId'] . '">'. $row ['name'] . "</a></td><td v-b-tooltip.hover title='View Application'>" .
                                     '<a href="fosterApp.php?fosterAppId=' . $row['fosterAppId'] . '">Approve/Deny Application</a>' . "</td></tr>";
                              }
                            } else {
                              echo "<tr><td>0 results</td></tr>";
                            }
                            $conn->close();
                      ?>

                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            <!-- End Foster Applications Table -->

          </div>
          </div>
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

  <!-- Page level plugins -->
  <script src="vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="js/demo/datatables-demo.js"></script>

  <!-- Page level plugins -->
  <script src="vendor/chart.js/Chart.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="js/demo/chart-area-demo.js"></script>
  <script src="js/demo/chart-pie-demo.js"></script>

</body>

</html>
