<?php
// Start the session
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>FosterFinder Login</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script src="js/userlogin.js" type="text/javascript"></script>
<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="img/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="styles/vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="styles/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="styles/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="styles/vendor/animate/animate.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="styles/vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="styles/vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="styles/vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="styles/vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="styles/css/util.css">
	<link rel="stylesheet" type="text/css" href="styles/css/main.css">
<!--===============================================================================================-->
</head>

<body>
	<?php
	/*Initiate error returns*/
	$eaErr = $passErr = $error = "";

	if ($_SERVER["REQUEST_METHOD"] == "POST") {

		/* Email Address Validation */
		if (empty($_POST["email"])) {
      $eaErr = "*Please enter your email address";
    } else {
      $email = test_input($_POST["email"]);
      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $eaErr = "*Invalid email address";
      }
    }

		/* Password Validation */
		if (empty($_POST["pass"])) {
			$passErr = "*Please enter a password";
		} else {
			$pass = test_input($_POST["pass"]);
			if (!preg_match("/^[a-zA-Z0-9 !?@]*$/", $pass)) {
				$passErr = "*Please enter a valid password";
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

	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-50">
				<form class="login100-form validate-form" name="myform" method='post'>
					<span class="login100-form-title p-b-33">
						FosterFinder Account Login
					</span>

					<div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
						<input class="input100" type="text" name="email" placeholder="Email" value="<?php echo $email;?>">
						<span class="focus-input100-1"></span>
						<span class="focus-input100-2"></span>
					</div>

					<div class="wrap-input100 rs1 validate-input" data-validate="Password is required">
						<input class="input100" type="password" name="password" placeholder="Password">
						<span class="focus-input100-1"></span>
						<span class="focus-input100-2"></span>
					</div>

					<div class="container-login100-form-btn m-t-20">
						<button type='submit' class="login100-form-btn">
							Sign in
						</button>
					</div>

					<div class="text-center p-t-45 p-b-4">
						<span class="txt1">
							Forgot
						</span>

						<a href="#" class="txt2 hov1">
							Username / Password?
						</a>
					</div>

					<div class="text-center">
						<span class="txt1">
							Create an account?
						</span>

						<a href="accountRegistration.php" class="txt2 hov1">
							Sign up
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>
	<?php
    if (!empty($_POST['email'])) {

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

					// Assign redirection based on email Address
					if (strpos($_POST['email'], '@gmail.com')) {
						$sql = "SELECT firstName from foster_applicants where emailAddress = '$email'";
						echo "<script type='text/javascript'>";
						echo "window.location='FHS/fosterFinder.php'";
						echo "</script>";
					} elseif (strpos($_POST['email'], '@shelter.com')) {
						echo "<script type='text/javascript'>";
						echo "window.location='employeeHome.php'";
						echo "</script>";
					} else {
						$error = "Incorrect username or password";
					}
				}
				mysqli_close($conn);
				?>




<!--===============================================================================================-->
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/daterangepicker/moment.min.js"></script>
	<script src="vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>
</html>
