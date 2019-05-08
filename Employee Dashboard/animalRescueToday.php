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
          <div class='table-responsive table-sm'>
            <table class="table table-bordered" id='employeeTable' width='100%' cellspacing='0'>
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
                <td>Shelter Animal Rescue</td>
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
          <h2 class="h4 mb-2 text-gray-800">REGISTERED ANIMAL SHELTERS</h2>
          <hr>
          <div class='table-responsive table-hover'>
            <table class="table table-bordered table-striped table-sm text-center" id="dataTable" width="100%" cellspacing="0">
              <thead class="thead-dark">
                <tr>
                  <th>Shelter ID</th>
                  <th>Shelter Name</th>
                  <th>Contact Number</th>
                  <th>Animal Count</th>
                  <th>Animals Exp Today</th>
                </tr>
              </thead>
              <tbody>
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

                    // SQL query
                    $sql = "SELECT shelters.shelterId AS shelterId,
                            shelters.shelterName AS name,
                            shelters.shelterPhoneNumber AS phone,
                            COUNT(*) AS count,
                            sa.animalCount AS animalCount
                            FROM shelters
                            INNER JOIN shelter_animal
                            ON shelters.shelterId = shelter_animal.shelterId
                            INNER JOIN (
                              SELECT shelterAnimalId, shelterId, COUNT(*) AS animalCount
                              FROM shelter_animal
                              WHERE daysToEuth = 0
                              GROUP BY shelterId) AS sa
                            ON shelters.shelterId = sa.shelterId
                            WHERE shelters.euthStatus = 'euthanasia'
                            GROUP BY shelter_animal.shelterId
                            ORDER BY animalCount DESC";

                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                              //output data of each row
                              while($row = $result->fetch_assoc()) {
                                echo "<tr><td> " . $row ['shelterId'] . "</td><td>" . $row['name'] . "</td><td>" . $row['phone'] . "</td><td>" .
                                $row['count'] . "</td><td>" . $row['animalCount'] . "</td></tr>";
                              }
                            } else {
                              echo "0 results";
                            }

              ?>

              </tbody>
            </table>
          </div>

          <h2 class="h4 mb-2 text-gray-800">IMMEDIATE ANIMAL RESCUES</h2>
          <hr>

          <div class='table-responsive table-hover'>
            <table class="table table-bordered table-striped table-sm text-center" id="dataTable" width="100%" cellspacing="0">
              <thead class="thead-dark">
                <tr>
                  <tr>
                    <th>Animal ID</th>
                    <th>Species</th>
                    <th>Shelter ID</th>
                    <th>Arrival Date</th>
                    <th>Shelter Expiration</th>
                    <th>Days Remaining</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>Animal ID</th>
                    <th>Species</th>
                    <th>Shelter ID</th>
                    <th>Arrival Date</th>
                    <th>Shelter Expiration</th>
                    <th>Days Remaining</th>
                  </tr>
              </tfoot>
              <tbody>
                <?php
                    //Show table
                    $sql = "SELECT shelterAnimalId, species, shelterId, arrivalDate,
                            euthDate, daysToEuth
                            FROM shelter_animal
                            WHERE daysToEuth = 0
                            ORDER BY daysToEuth ASC";

                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                      //output data of each row
                      while($row = $result->fetch_assoc()) {
                        echo "<tr><td> " . $row ['shelterAnimalId'] . "</td><td>" . $row['species'] . "</td><td>" . $row['shelterId'] . "</td><td>" .
                        $row['arrivalDate'] . "</td><td>" . $row['euthDate'] . "</td><td>" . $row['daysToEuth'] . "</td></tr>";
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
