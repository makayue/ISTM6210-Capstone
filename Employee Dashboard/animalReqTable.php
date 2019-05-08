<!-- Animal Requests Table -->
<div class="col-xl-8 col-lg-7">
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Pending Animal Requests</h6>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>ID</th>
              <th>Status</th>
              <th>Submission Date</th>
              <th>Foster Name</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th>ID</th>
              <th>Status</th>
              <th>Submission Date</th>
              <th>Foster Name</th>
            </tr>
          </tfoot>
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

                //Show table
                $sql = "SELECT animal_request.requestId,
                animal_request.requestStatus,
                animal_request.requestDate,
                concat(registered_fosters.lastName, ', ', registered_fosters.firstName) AS name
                FROM animal_request
                INNER JOIN registered_fosters ON animal_request.fosterId = registered_fosters.fosterId
                WHERE requestStatus != 'Approved'";

                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                  //output data of each row
                  while($row = $result->fetch_assoc()) {
                    echo "<tr><td> " . $row['requestId']. "</td><td>" . $row['requestStatus'] . "</td><td>" . $row['requestDate'] . "</td><td>" . $row['name'] . "</td></tr>";
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

<!-- End Animal Requests Table -->
