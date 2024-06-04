<?php
// import phpmailer into global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

session_start();

include("connection.php");
include("functions.php");


//signup
if($_SERVER['REQUEST_METHOD'] == "POST") {
    //something was posted
    $username = $_POST['username'];
    $phone_or_email = $_POST['phone_or_email'];
    $password = $_POST['password'];
    $cfpassword = $_POST['cfpassword'];

    if(empty($username) || empty($phone_or_email) || empty($password) || empty($cfpassword)) {
        ?>
            <script>
                alert("Please fill up all fields to sign up");
            </script>
        <?php
    }elseif (!isset($_POST['terms'])) {
        ?>
        <script>
            alert("Please agree to the terms and conditions to sign up");
        </script>
        <?php
    }  else {

            if(isValidPhoneNumber($phone_or_email)) {

            //check if passwords match, if it doesnt terminate the statement
            if($password != $cfpassword){
                ?>
                    <script>
                        alert("Sorry, passwords do not match, Try again.");
                    </script>
                <?php
                die();
            }

            //if passwords match, insert data into database
            $query = "INSERT INTO tbluseraccount (Username, User_Contact_Number, Password) VALUES ('$username', $phone_or_email, '$password')";
            $result = mysqli_query($con, $query);
            } elseif(filter_var($phone_or_email, FILTER_VALIDATE_EMAIL)){
                if($password != $cfpassword){
                    ?>
                        <script>
                            alert("Sorry, passwords do not match, Try again.");
                        </script>
                    <?php
                    die();
                }
            $query = "SELECT * FROM tbluseraccount WHERE User_EmailAddress='$phone_or_email'";
            $result = mysqli_query($con, $query);
            if (mysqli_num_rows($result) > 0) {
                ?>
                    <script>
                        alert("Email already registered.");
                    </script>
                <?php
                die();
            } else {
                //send an otp code to gmail
                //...
                $mail = new PHPMailer;

                try{
                    $mail->isSMTP();
                    $mail->SMTPDebug = 0;
                    $mail->Host = 'smtp.hostinger.com';
                    $mail->Port = 587;
                    $mail->SMTPAuth = true;
                    $mail->Username = 'hostingweb395@webpointph.com';
                    $mail->Password = 'Hostinger#123';
                    $mail->setFrom('hostingweb395@webpointph.com', 'Fixpoint');
                    $mail->addAddress($phone_or_email, $username);
                    $verification_code = substr(number_format(time() * rand(), 0, '', ''), 0, 6);
                    $mail->isHTML(true);
                    $mail->Subject = 'Email Verification';
                    $mail->Body = 'Your verification code is: <b>' . $verification_code . '</b>';
                    //$mail->addAttachment('attachment.txt');
                    $mail->send();
                    $encrypted_password = password_hash($password, PASSWORD_DEFAULT);
                    echo 'The email message was sent';
                    $_SESSION['User_EmailAddress'] = $phone_or_email;
                    $_SESSION['otp'] = $verification_code;
                    $_SESSION['Username'] = $username;
                    $_SESSION['Password']  = $encrypted_password;
                    //redirect to otp verification
                    header("Location: otp-verification.php");
                    exit();
                }catch(Exception $e) {
                    echo 'Mailer Error: ' . $mail->ErrorInfo;
                }
            }
            }else{
            echo "Invalid phone number or email.";
            exit();
        }
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="signup.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<title>Signup</title>
</head>
<body>

	<!-- body -->

	<div class="body-container">
		<div class="logo-container">
			<img src="./images/logo1.png">
		</div>

		<div class="signup-form">
			<h1>Signup</h1>
			<form action="#" method="post" id="form1">
				<div class="input-container">
					<i class="fas fa-user input-icon"></i>
					<input type="text" id="username" name="username" placeholder="Username" require>
				</div>
				<div class="input-container">
					<i class="fas fa-envelope input-icon"></i>
					<input type="text" id="phone_or_email" name="phone_or_email" placeholder="Phone or Email" require>
				</div>
				<div class="input-container">
					<i class="fas fa-lock input-icon"></i>
					<input type="password" id="password" name="password" placeholder="Password" require>
				</div>
				<div class="input-container">
					<i class="fas fa-lock input-icon"></i>
					<input type="password" id="cfpassword" name="cfpassword" placeholder="Confirm Password" require>
				</div>
				<div class="checkbox-container">
					<input type="checkbox" id="terms" name="terms">
					<label for="terms">I accept all the terms and conditions</label>
				</div>
				<button type="submit" form="form1">Signup</button>
			</form>
			<p>Already have an account? <a href="login.php">Login</a></p>
		</div>
	</div>
    <script>
         $('#phone_or_email').on('keyup',function(){
  		            var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  		            var mailformat = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
  		            var email = $("#phone_or_email").val();
  		            if(email.match(mailformat)){
  		                $('#message2').html('valid').css('color','green');
  		                $("#enter").prop('disabled',false);
  		            }
  		            else
  		                $('#message2').html('Invalid Email').css('color','red');

  		        }
  		        );
   </script>
</body>
</html>