<?php
session_start();

include("connection.php");
include("functions.php");

//login
if($_SERVER['REQUEST_METHOD'] == "POST"){
	//something was posted
	$username = $_POST['username'];
	//$password = $_POST['password'];
	$password = $_POST['password'];

	if(!empty($username) && !empty($password) && !is_numeric($username)){
		//read from database
		$query = "select * from tbluseraccount where Username = '$username' limit 1";

		$result = mysqli_query($con, $query);

		if($result && mysqli_num_rows($result) > 0){
			$user_data = mysqli_fetch_assoc($result);
			if (password_verify($_POST['password'], $user_data['Password'])) {
				// Set the session variables
				$_SESSION['User_id'] = $user_data['User_id'];

				header("Location: index.php");
				exit();
			} else {
				echo "Wrong password!";
			}
		}

		echo "Wrong username or password!";

	} else {
		if(empty($username) && empty($password)) {
		$error_msg = "Please enter your username and password.";
	    } elseif (empty($username)) {
		    $error_msg = "Please enter your username.";
	    } elseif (empty($password)) {
		    $error_msg = "Please enter your password.";
	    }
		?>
			<script>
				alert("<?php echo $error_msg; ?>");
			</script>
		<?php
	}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="login.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<title>Login</title>
</head>
<body>

	<!-- body -->

	<div class="body-container">
		<div class="logo-container">
			<img src="./images/logo1.png">
		</div>

		<div class="login-form">
			<h1>Login</h1>
			<form action="#" method="post" id="form1">
				<div class="input-container">
					<i class="fas fa-user input-icon"></i>
					<input type="text" id="username" name="username" placeholder="Username" require>
				</div>
				<div class="input-container">
					<i class="fas fa-lock input-icon"></i>
					<input type="password" id="password" name="password" placeholder="Password" require>
				</div>
				<button type="submit" form="form1">Login</button>
			</form>
			<p>Don't have an account? <a href="signup.php">Signup</a></p>
		</div>
	</div>
</body>
</html>
