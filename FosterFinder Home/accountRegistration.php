<?php
// Start the session
session_start();
?>
<!-- What needs to be done
1. Remove random bar at the bottom of the page.
-->

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
  $fnErr = $lnErr = $eaErr = $pwErr = $pw2Err = "";

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["first_name"])) {
			$fnErr = "*First name is required";
		} else {
			$firstName = test_input($_POST["first_name"]);
			$_SESSION['firstName'] = $firstName;
			if (!preg_match("/^[a-zA-Z ]*$/", $firstName)) {
				$fnErr = "*Only letters and white space allowed";
			}
		}

    if (empty($_POST["last_name"])) {
			$lnErr = "*Last name is required";
		} else {
			$lastName = test_input($_POST["last_name"]);
			$_SESSION['lastName'] = $lastName;
			if (!preg_match("/^[a-zA-Z ]*$/", $lastName)) {
				$lnErr = "*Only letters and white space allowed";
			}
		}

    if (empty($_POST["your_email"])) {
      $eaErr = "*Please enter your email address";
    } else {
      $emailAddress = test_input($_POST["your_email"]);
			$_SESSION['emailAddress'] = $emailAddress;
      if (!filter_var($emailAddress, FILTER_VALIDATE_EMAIL)) {
        $eaErr = "*Invalid email address";
      }
    }

		if (empty($_POST["comfirm_password"])) {
			$pw2Err = "*Passwords must match.";
		} else {
			if (!($password1 === $password2)) {
				$pw2Err = "*Passwords must match.";
			}
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
				<p class="text-1">We are so excited to welcome you to the FosterFinder family in our quest to find homes for those animals in need.</p>
				<p class="text-2"><span>As a Foster:</span> You will be granted access to our list of animals in urgent need. From there, you will have the opportunity to apply to foster them in your own home.</p>
				<div class="form-left-last">
					<input type="submit" id='loginreturn' name="account" class="account" value="Have An Account?">
				</div>
			</div>
			<form class="form-detail" method="post" id="myform">
				<h2>REGISTRATION FORM</h2>
				<div class="form-group">
					<div class="form-row form-row-1">
						<label for="first_name">First Name</label>
						<input type="text" name="first_name" id="first_name" class="input-text" value="<?php echo $_SESSION['firstName'];?>">
					</div>
					<div class="form-row form-row-1">
						<label for="last_name">Last Name</label>
						<input type="text" name="last_name" id="last_name" class="input-text" value="<?php echo $_SESSION['lastName'];?>">
					</div>
				</div>
				<div class="form-row">
					<label for="your_email">Your Email</label>
					<input type="text" name="your_email" id="your_email" class="input-text" required value="<?php echo $_SESSION['emailAddress'];?>">
				</div>
				<div class="form-group">
					<div class="form-row form-row-1 ">
						<label for="password">Password</label>
						<input type="password" name="password" id="password" class="input-text" required value="<?php echo $password1;?>">
					</div>
					<div class="form-row form-row-1">
						<label for="comfirm-password">Confirm Password</label>
						<input type="password" name="comfirm_password" id="comfirm_password" class="input-text" required value="<?php echo $password2;?>">
					</div>
				</div>
				<div class="form-row-last">
					<input type="submit" name="register" class="register" value="Continue">
				</div>
			</form>
		</div>
	</div>
	<?php
    if (!empty($_POST['last_name']) && !empty($_POST['first_name']) && !empty($_POST['your_email']) && !empty($_POST['password']) && !empty($_POST['comfirm_password'])) {

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

  				$sql = "INSERT INTO foster_applicants (lastName, firstName, emailAddress)
  								VALUES ('$lastName', '$firstName', '$emailAddress')";
  				if ($conn->query($sql) === FALSE) {
  					echo "Error: " . $sql . "<br>" . $conn->error;
  				} else {
  					$applicantId = $conn->insert_id;
  				}

					$_SESSION['applicantId'] = $applicantId;

					$pwdHash = md5($password1);


					$sql2 = "INSERT INTO foster_accounts (accountId, fosterPasswordHash, applicantId)
									 VALUES ('$emailAddress', '$pwdHash', '$applicantId')";

					if ($conn->query($sql2) === FALSE) {
						echo "Error: " . $sql2 . "<br>" . $conn->error;
					}

					header("location:accountRegistration2.php");
  				$conn->close();
  			}
			?>
	<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
	<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
	<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
	<script type='text/javascript'>
			document.getElementById('loginreturn').onclick = function() {
				location.href = 'userlogin.php';
			};
	</script>

</body><!-- This templates was made by Colorlib (https://colorlib.com) -->
</html>
