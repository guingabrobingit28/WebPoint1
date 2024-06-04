<?php
session_start();

include("./php/connection.php");
include("functions.php");
$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
//login
if($_SERVER['REQUEST_METHOD'] == "POST"){
	//something was posted
	$username = $_POST['username'];
	//$password = $_POST['password'];
	$password = $_POST['password'];

	if(!empty($username) && !empty($password) && !is_numeric($username)){
		//read from database
        
		$query = "select * from tbluseraccount where Username = '$username' limit 1";

		$result = mysqli_query($conn, $query);

		if($result && mysqli_num_rows($result) > 0){
			$user_data = mysqli_fetch_assoc($result);
			if (password_verify($password, $user_data['Password'])) {
				// Set the session variables
                if($user_data['User_Position_id'] == 2){
                    $_SESSION['User_id'] = $user_data['User_id'];

				    header("Location: dashboard.php");
                    exit();
                }else{
                    echo '<script> alert("You are not authorized to log in.");</script>';
                }
			}
            else {
				echo '<script> alert("Wrong Password!");</script>';
			}
		}else{
            echo '<script> alert("Wrong Password or Username");</script>';
        }

		

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
    <link href="css/txtReadexPro.css" rel="stylesheet">
    <link href="css/bootstrap-icons.css" rel="stylesheet">
    <link href="css/fontawesome-free-6.1.1-web/fontawesome-free-6.1.1-web/css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="css/css1/bootstrap.min.css">
    <link rel="stylesheet" href="css/admstyles.css">
    <title>Admin Login</title>
</head>
<body>
    <div class="container-fluid regLogBG position-relative d-flex p-0">
        <div class="container-fluid">
            <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
                <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                    <div class="sidebarGraColor rounded p-4 p-sm-5 my-4 mx-3">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <a href="index.html" class="">
                                <img src="icon/webpoint.png" width="175">
                            </a>
                            <h3><b>Login</b></h3>
                        </div>
                        <form action="#" method="post" id="form1" name="login">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="floatingText" name="username" placeholder="Username" required>
                        </div>
                        
                        <div class="form-floating mb-4">
                            <input type="password" class="form-control" id="floatingPassword" name="password" placeholder="Password" required>
                        </div>
                        
                        <button type="submit" class="btn btn-primary py-3 w-100 mb-4" form="form1">Login</button>
                        <p class="text-center mb-3">Don't have an Account yet? <a href="admregister.php">Register</a></p>
                        <p class="text-center mb-0">Forgot Password? <a href="">Click here!</a></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>



    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="admjs.js"></script>
</body>
</html>