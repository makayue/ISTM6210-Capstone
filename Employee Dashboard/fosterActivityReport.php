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

  <title>FosterFinder: Generated Report</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href='styles.css' rel='stylesheet'>
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

  <!-- Bootstrap stylesheet -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

  </head>

  <body id="page-top">
  <?php
    $typeOption = $_SESSION['typeOption'];

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

      // Registered_Fosters Count
      $sql = "SELECT COUNT(*) AS count FROM registered_fosters";
      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
        //output data of each row
        while($row = $result->fetch_assoc()) {
          $regCount = $row['count'];
        }
      } else {
        $regCount = 0;
      }

      // Active Fosters Count
      $sql = "SELECT COUNT(*) AS count FROM registered_fosters WHERE fosterActivity = 'Active Foster'";
      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
        //output data of each row
        while($row = $result->fetch_assoc()) {
          $activeCount = $row['count'];
        }
      } else {
        $activeCount = 0;
      }

      // Inactive Fosters Count
      $sql = "SELECT COUNT(*) AS count FROM registered_fosters WHERE fosterActivity = 'Inactive Foster'";
      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
        //output data of each row
        while($row = $result->fetch_assoc()) {
          $inactiveCount = $row['count'];
        }
      } else {
        $inactiveCount = 0;
      }

      // Registered Animals Count
      $sql = "SELECT COUNT(*) AS count FROM animals WHERE fosterStatus != 'Adopted'";
      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
        //output data of each row
        while($row = $result->fetch_assoc()) {
          $animalCount = $row['count'];
        }
      } else {
        $animalCount = 0;
      }

      // Registered Animals in Foster Homes Count
      $sql = "SELECT COUNT(*) AS count FROM animals WHERE fosterStatus = 'Not available to foster'";
      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
        //output data of each row
        while($row = $result->fetch_assoc()) {
          $fosteredCount = $row['count'];
        }
      } else {
        $fosteredCount = 0;
      }

      // Registered Animals Needing Foster Homes Count
      $sql = "SELECT COUNT(*) AS count FROM animals WHERE fosterStatus = 'Available to foster' OR fosterStatus = 'Pending'";
      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
        //output data of each row
        while($row = $result->fetch_assoc()) {
          $seekingCount = $row['count'];
        }
      } else {
        $seekingCount = 0;
      }

      $conn->close();

  ?>

  <!-- Page Wrapper -->
  <div id="wrapper mt-3">
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">
        <div class='container-fluid'>

          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">FOSTERFINDER REPORT</h1>
          <hr size="10" width="100%" align="left" color="#3f577c">

          <!-- Employee Info -->
          <div class='table-responsive'>
            <table class="table table-bordered table-sm" id='employeeTable' width='100%' cellspacing='0'>
              <tr>
                <th class="table-dark">Name</th>
                <td>Jili Zhou</td>
                <th class="table-dark">Department</th>
                <td>Foster Management</td>
              </tr>
              <tr>
                <th class="table-dark">Email</th>
                <td>zhouj@shelter.com</td>
                <th class="table-dark">Purpose</th>
                <td><?php echo $typeOption;?></td>
              </tr>
              <tr>
                <th class="table-dark">Employee ID</th>
                <td>11435</td>
                <th class="table-dark">Date</th>
                <td><?php echo date('m-d-Y');?></td>
              </tr>
            </table>
          </div>
          <!-- End Employee Info -->

          <!-- Status Totals -->
          <h2 class="h4 mb-2 text-gray-800">STATUS TOTALS</h2>
          <hr>
          <div class='table-responsive'>
            <table class="table table-bordered table-sm" id="statusTable" width="100%" cellspacing="0">
              <tr>
                <th class="table-dark">Registered Fosters</th>
                <td><?php echo $regCount;?></td>
                <th class="table-dark">Registered Animals</th>
                <td><?php echo $animalCount;?></td>
              </tr>
              <tr>
                <th class="table-dark">Active Fosters</th>
                <td><?php echo $activeCount;?></td>
                <th class="table-dark">Animals Homed</th>
                <td><?php echo $fosteredCount;?></td>
              </tr>
              <tr>
                <th class="table-dark">Inactive Fosters</th>
                <td><?php echo $inactiveCount;?></td>
                <th class="table-dark">Animals Seeking Foster</th>
                <td><?php echo $seekingCount;?></td>
              </tr>
            </table>
          </div>

          <h2 class="h4 mb-2 text-gray-800">ACTIVITY INFORMATION</h2>
          <hr>

          <div class='table-responsive table-hover'>
            <table class="table table-bordered table-striped table-sm" id="dataTable" width="100%" cellspacing="0">
              <thead class="thead-dark">
                <tr>
                  <th>Activity ID</th>
                  <th>Foster Name</th>
                  <th>Contact Number</th>
                  <th>Animal ID</th>
                  <th>Start Date</th>
                  <th>Duration</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th>Activity ID</th>
                  <th>Foster Name</th>
                  <th>Contact Number</th>
                  <th>Animal ID</th>
                  <th>Start Date</th>
                  <th>Duration</th>
                  <th>Status</th>
                </tr>
              </tfoot>
              <tbody>
                <?php
                  //Connecting to the database
                    $server = 'localhost';
                    $username = 'cap_user';
                    $password = 'TeamAwesome1234!';
                    $db = 'capstone_test';

                    // Create connection
                    $conn = new mysqli($servername, $username, $password, $db);

                    // Check connection
                    if ($conn->connect_error) {
                      die("Connection failed: " . $conn->connect_error);
                    }

                    //Show table
                    $sql = "SELECT foster_activity.activityId AS id,
                    concat(registered_fosters.lastName, ', ', registered_fosters.firstName) AS fosterName,
                    registered_fosters.phone AS phone,
                    foster_activity.animalId AS animalId,
                    foster_activity.approvalDate AS startDate,
                    foster_activity.duration AS duration,
                    foster_activity.type AS status
                    FROM foster_activity
                    INNER JOIN registered_fosters
                    ON foster_activity.fosterId = registered_fosters.fosterId
                    WHERE foster_activity.type = 'active'";

                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                      //output data of each row
                      while($row = $result->fetch_assoc()) {
                        echo "<tr><td> " . $row ['id'] . "</td><td>" . $row['fosterName'] . "</td><td>" . $row['phone'] . "</td><td>" .
                        $row['animalId'] . "</td><td>" . $row['startDate'] . "</td><td>" . $row['duration'] . "</td><td>" . $row['status'] . "</td></tr>";
                      }
                    } else {
                      echo "0 results";
                    }
                    $conn->close();
              ?>

              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Custom scripts for this page-->
