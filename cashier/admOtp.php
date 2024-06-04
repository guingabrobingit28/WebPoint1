<?php
session_start();

include("./php/connection.php");

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

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
        $query = "INSERT INTO tbluseraccount (Username, User_EmailAddress, Password, User_Position_id, Registration_Datetime, user_status_id) VALUES (?, ?, ?,'3',NOW(),'1')";
        $statement = $conn->prepare($query);
        $statement->bind_param("sss", $username, $phone_or_email, $encrypted_password);
        $statement->execute();

        // Remove the email and OTP from the session
        unset($_SESSION['User_EmailAddress']);
        unset($_SESSION['otp']);
        unset($_SESSION['Username']);
        unset($_SESSION['Password']);

        // Redirect to the home page
        header("Location: index.php");
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
                        <form action="#" method="post" id="form1" name="form1">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="otp" name="otp" placeholder="Enter OTP" required>
                        </div>
                        <button type="submit" class="btn btn-primary py-3 w-100 mb-4" name="verify_code" form="form1">Vefify</button>
                        <p class="text-center mb-0">Already have an Account? <a href="admlogin.html">Log in</a></p>
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