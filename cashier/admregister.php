<?php
// import phpmailer into global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

session_start();

include("./php/connection.php");
include("functions.php");

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

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
    } else {

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
            $result = mysqli_query($conn, $query);
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
            $result = mysqli_query($conn, $query);
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
                    header("Location: admOtp.php");
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
    <link href="css/txtReadexPro.css" rel="stylesheet">
    <link href="css/bootstrap-icons.css" rel="stylesheet">
    <link href="css/fontawesome-free-6.1.1-web/fontawesome-free-6.1.1-web/css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="css/css1/bootstrap.min.css">
    <link rel="stylesheet" href="css/admstyles.css">
    <title>Admin Register</title>
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
                            <h3><b>Register</b></h3>
                        </div>
                        <form action="#" method="post" id="form1" name="register">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="floatingText" name="username" placeholder="Username" required>
                            
                        </div>
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="floatingInput" name="phone_or_email" placeholder="name123@example.com/09xxxxxxxxx">
                        </div>
                        <div class="form-floating mb-4">
                            <input type="password" class="form-control" id="floatingPassword" name="password" placeholder="Password" required> 
                        </div>
                        <div class="form-floating mb-4">
                            <input type="password" class="form-control" id="floatingConfirmPassword" name="cfpassword" placeholder="Confirm Password" required>
                        </div>
                        <button type="submit" class="btn btn-primary py-3 w-100 mb-4" form="form1">Register</button>
                        <p class="text-center mb-0">Already have an Account? <a href="index.php">Log in</a></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="admjs.js"></script>
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