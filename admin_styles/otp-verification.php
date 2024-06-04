<?php
session_start();

include("connection.php");

if (isset($_POST['verify_code'])) {
    // Get the verification code from the POST request
    $verification_code = $_POST['otp'];

    // Get the email address from the session
    $phone_or_email = $_SESSION['User_EmailAddress'];

    // Check if the verification code matches the code sent to the email
    if ($verification_code == $_SESSION['otp']) {
        echo "Verification successful!";

        // Get the user's details from the session
        $username = $_SESSION['Username'];
        $encrypted_password = $_SESSION['Password'];

        // Insert data into the database
        $query = "INSERT INTO tbluseraccount (Username, User_EmailAddress, Password, User_Position_id, user_status_id) VALUES (?, ?, ?,'1','1')";
        $statement = $con->prepare($query);
        $statement->bind_param("sss", $username, $phone_or_email, $encrypted_password);
        $statement->execute();

        // // Retrieve the auto-generated User_id value
        // $user_id = $con->insert_id;

        // // Insert customer info into tblcustomerinfo with the retrieved User_id value
        // $query = "INSERT INTO tblcustomerinfo (User_id, customer_email) VALUES (?, ?)";
        // $statement = $con->prepare($query);
        // $statement->bind_param("is",$user_id,$phone_or_email);
        // $statement->execute();

        // Remove the email and OTP from the session
        unset($_SESSION['User_EmailAddress']);
        unset($_SESSION['otp']);
        unset($_SESSION['Username']);
        unset($_SESSION['Password']);

        // Redirect to the home page
        header("Location: login.php");
        exit();
    } else {
        echo "Verification failed!";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="otp-verification.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>OTP Verification</title>
</head>
<body>

    <!-- body -->

    <div class="body-container">
        <div class="logo-container">
            <img src="/images/logo1.png">
        </div>

        <div class="otp-form">
            <h1>OTP Verification</h1>
            <p>An OTP has been sent to your email/phone number. Please enter the OTP below to verify your account.</p>
            <form action="#" method="post" id="form1">
                <div class="input-container">
                    <i class="fas fa-lock input-icon"></i>
                    <input type="text" id="otp" name="otp" placeholder="Enter OTP">
                </div>
                <button type="submit" name="verify_code" form="form1">Verify</button>
            </form>
            <p>Didn't receive an OTP? <a href="#">Resend OTP</a></p>
        </div>
    </div>
</body>
</html>
