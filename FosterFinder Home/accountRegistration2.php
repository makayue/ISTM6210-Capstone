<!-- What needs to be done still
1. Fix width/placement of street address
2. Increase width of city to make sure the line matches up on the right side with everything else
3. Fix height of Gender and State (they are slightly taller than everything else)
-->
<?php
// Start the session
session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>FosterFinder: Account Registration</title>
	<!-- Mobile Specific Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<!-- Font-->
	<link rel="stylesheet" type="text/css" href="css/opensans-font.css">
	<link rel="stylesheet" type="text/css" href="fonts/line-awesome/css/line-awesome.min.css">
	<!-- Jquery -->
	<link rel="stylesheet" href="https://jqueryvalidation.org/files/demo/site-demos.css">
	<!-- Main Style Css -->
  <link rel="stylesheet" href="css/style_ar2.css"/>
</head>

<body class="form-v4">
	<?php
  /* Initialize error returns*/
  $genErr = $uaErr = $ucErr = $usErr = $uzErr = $phoneErr = $bdErr = "";

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
		// Gender
		if (empty($_POST["gender"])) {
      $genErr = "*Please select your gender";
    } else {
      $gender = test_input($_POST["gender"]);
    }

		/* userAddress */
    if (empty($_POST["userAddress"])) {
      $uaErr = "*Please enter your street address";
    } else {
      $userAddress = test_input($_POST["userAddress"]);
    }

    /* userCity */
    if (empty($_POST["userCity"])) {
      $ucErr = "*Please enter your city";
    } else {
      $userCity = test_input($_POST["userCity"]);
    }

    /* userState */
    if (empty($_POST["userState"])) {
      $usErr = "*Please select your state";
    } else {
      $userState = test_input($_POST["userState"]);
    }

    /* userZipCode */
    if (empty($_POST["userZipCode"])) {
      $uzErr = "*Please enter your zip code";
    } else {
      $userZipCode = test_input($_POST["userZipCode"]);
    }

    /* phone */
    if (empty($_POST["phone"])) {
      $phoneErr = "*Please enter your phone number";
    } else {
      $phone = test_input($_POST["phone"]);
    }

    /* birthdate */
    if (empty($_POST["birthdate"])) {
      $bdErr = "*Please enter your date of birth";
    } else {
      $birthdate = $_POST["birthdate"];
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

	<div class="page-content">
		<div class="form-v4-content">
			<div class="form-left">
				<h2>Welcome to FosterFinder!</h2>
				<p class="text-1">You're almost done!</p>
				<p class="text-2">Please complete the following information.</p>
				<div class="form-left-last">
					<input type="submit" name="account" class="account" value="Go Back" onclick="goBack()">
				</div>
			</div>
			<form class="form-detail" method="post" id="myform">
				<h2>REGISTRATION FORM</h2>
				<div class="form-group">
					<div class="form-row form-row-1">
						<label for="gender">Gender</label>
            <select class="input-text" name="gender" id="gender" required value="<?php echo $gender;?>">
                <option disabled selected value="">Gender</option>
                <option value="female">Female</option>
                <option value="male">Male</option>
								<option value="not specified">Prefer not to specify</option>
            </select>
					</div>
					<div class="form-row form-row-1">
						<label for="birthdate">Birthdate</label>
						<input type="date" name="birthdate" class="input-text" required value="<?php echo $birthdate;?>">
						<!--Keep option selected with POST-->
						<script type="text/javascript"> document.getElementById('birthdate').value = "<?php echo $_GET['birthdate'];?>";</script>
					</div>
				</div>
				<div class="form-group">
					<div class="form-row form-row-2">
						<label for="userAddress">Street Address</label>
						<input type="input-text" name="userAddress" id="userAddress" class="input-text" required value="<?php echo $userAddress;?>">
					</div>
				</div>
				<div class="form-group">
					<div class="form-row form-row-1 ">
						<label for="userCity">City</label>
						<input type="input-text" name="userCity" id="userCity" class="input-text" required value="<?php echo $userCity;?>">
					</div>
					<div class="form-row form-row-1">
						<label for="userState">State</label>
						<select name="userState" id="userState" class="input-text" required value="<?php echo $userState;?>">
							<option disabled selected value="">State</option>
							<option value="AL">Alabama</option>
							<option value="AK">Alaska</option>
							<option value="AZ">Arizona</option>
							<option value="AR">Arkansas</option>
							<option value="CA">California</option>
							<option value="CO">Colorado</option>
							<option value="CT">Connecticut</option>
							<option value="DE">Delaware</option>
							<option value="DC">District Of Columbia</option>
							<option value="FL">Florida</option>
							<option value="GA">Georgia</option>
							<option value="HI">Hawaii</option>
							<option value="ID">Idaho</option>
							<option value="IL">Illinois</option>
							<option value="IN">Indiana</option>
							<option value="IA">Iowa</option>
							<option value="KS">Kansas</option>
							<option value="KY">Kentucky</option>
							<option value="LA">Louisiana</option>
							<option value="ME">Maine</option>
							<option value="MD">Maryland</option>
							<option value="MA">Massachusetts</option>
							<option value="MI">Michigan</option>
							<option value="MN">Minnesota</option>
							<option value="MS">Mississippi</option>
							<option value="MO">Missouri</option>
							<option value="MT">Montana</option>
							<option value="NE">Nebraska</option>
							<option value="NV">Nevada</option>
							<option value="NH">New Hampshire</option>
							<option value="NJ">New Jersey</option>
							<option value="NM">New Mexico</option>
							<option value="NY">New York</option>
							<option value="NC">North Carolina</option>
							<option value="ND">North Dakota</option>
							<option value="OH">Ohio</option>
							<option value="OK">Oklahoma</option>
							<option value="OR">Oregon</option>
							<option value="PA">Pennsylvania</option>
							<option value="RI">Rhode Island</option>
							<option value="SC">South Carolina</option>
							<option value="SD">South Dakota</option>
							<option value="TN">Tennessee</option>
							<option value="TX">Texas</option>
							<option value="UT">Utah</option>
							<option value="VT">Vermont</option>
							<option value="VA">Virginia</option>
							<option value="WA">Washington</option>
							<option value="WV">West Virginia</option>
							<option value="WI">Wisconsin</option>
							<option value="WY">Wyoming</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<div class="form-row form-row-1">
						<label for="userZipCode">Zipcode</label>
						<input type="input-text" name="userZipCode" id="userZipCode" class="input-text" required pattern="[0-9]{5}" value="<?php echo $userZipCode;?>">
					</div>
					<div class="form-row form-row-1">
						<label for="phone">Phone Number</label>
						<input type="tel" class='input-text' name="phone" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" required value="<?php echo $phone;?>">
					</div>
				</div>
				<div class="form-checkbox">
					<label class="container"><p>I agree to the <a href="#" class="text">Terms and Conditions</a></p>
					  	<input type="checkbox" name="checkbox">
					  	<span class="checkmark"></span>
					</label>
				</div>
				<div class="form-row-last">
					<input type="submit" name="register" class="register" value="Continue">
				</div>
			</form>
		</div>
	</div>
	<?php
    if (!empty($_POST['gender']) && !empty($_POST['birthdate']) && !empty($_POST['userAddress']) && !empty($_POST['userCity']) && !empty($_POST['userState']) && !empty($_POST['userZipCode']) && !empty($_POST['phone'])) {

      //Connecting to the database
  				$server = [REDACTED];
  		    $username = [REDACTED];
  		    $password = [REDACTED];
  		    $db = [REDACTED];

  		    // Create connection
  		    $conn = new mysqli($servername, $username, $password, $db);
  				if ($conn->connect_error) {
  					die("Connection failed: " . $conn->connect_error);
  				} else {
  					$accountId = $conn->insert_id;
  				}

					$fosterId = $_SESSION["applicantId"];

  				$sql = "UPDATE foster_applicants
									SET gender = '$gender',
									 		birthdate = '$birthdate',
											userAddress = '$userAddress',
											userCity = '$userCity',
											userState = '$userState',
											userZipCode = '$userZipCode',
											phone = '$phone'
									WHERE fosterId = '$fosterId'";

  				if ($conn->query($sql) === FALSE) {
  					echo "Error: " . $sql . "<br>" . $conn->error;
  				} else {
  					echo "<script type='text/javascript'>";
						echo "window.location='accountCreated.php'";
						echo "</script>";
  				}

  				$conn->close();
  			}
			?>
	<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
	<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
	<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
	<script type="text/javascript">
	function goBack() {
		window.history.back();
	}
	</script>


</body><!-- This templates was made by Colorlib (https://colorlib.com) -->
</html>
