<?php
session_start();

include('connection.php');
include ("../functions.php");

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$user_data = null;
$logged_in = isset($_SESSION['User_id']);

if ($logged_in) {
    $user_data = check_login($conn);
}

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){ // Check if user is logged in
  if($_SESSION["admin"] === true || isset($_SESSION["admin_password_entered"])){ // Check if user has admin privileges or has entered the admin password
    // Perform action that requires admin privileges
  }
  else{
    // User does not have admin privileges
    if(isset($_POST["password"]) && $_POST["password"] === "admin_password"){ // Check if password is correct
      $_SESSION["admin_password_entered"] = true; // Set session variable indicating that the user has entered the correct password
      // Perform action that requires admin privileges
    }
    else{ // Prompt for password
        echo "<script>
        Swal.fire({
          title: 'Enter admin password',
          input: 'password',
          showCancelButton: true,
          confirmButtonText: 'Submit',
          showLoaderOnConfirm: true,
          preConfirm: (password) => {
            if (password === 'admin_password') {
              return true;
            } else {
              Swal.showValidationMessage('Invalid password');
            }
          },
          allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
          if (result.isConfirmed) {
            // Set session variable indicating that the user has entered the correct password
            window.location.href = 'admin_page.php'; // replace with URL of admin page
          }
        });
        </script>";
    }
  }
}
else{
  // User is not logged in
  echo "You must be logged in to perform this action.";
}

