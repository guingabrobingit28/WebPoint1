<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include("connection.php");
include("../functions.php");

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// $user_data = null;
// $logged_in = isset($_SESSION['User_id']);

// if ($logged_in) {
//     $user_data = check_login($conn);
// }

// $password = $_POST['password'];
// $query = "select * from tbluseraccount where User_Position_id  = 2";
// $result = mysqli_query($conn, $query);

// header('Content-Type: application/json');
// if ($result && mysqli_num_rows($result) > 0) {
//     $user_data = mysqli_fetch_assoc($result);
//     if (password_verify($password, $user_data['Password'])) {
//         $response = array('success' => true);
//         echo json_encode($response);
//     } else {
//         $response = array('success' => false, 'message' => 'Invalid password');
//         echo json_encode($response);
//     }
// } else {
//     $response = array('success' => false, 'message' => 'No admin account found');
//     echo json_encode($response);
// }
// if ($result && mysqli_num_rows($result) > 0) {
//     $user_data = mysqli_fetch_assoc($result);
//     if (password_verify($password, $user_data['Password'])) {
//         //$response = array('success' => true);
//         $response  = true;
//     } else {
//         // $response = array('success' => false, 'message' => 'Invalid password');
//         $response  = false;
//     }
// } else {
//     // $response = array('success' => false, 'message' => 'No admin account found');
//     $response  = false;
// }

// echo json_encode($response);

if (isset($_POST['password'])) {
    //$username = $_POST['username'];
    $password = $_POST['password'];
    //var_dump($password);
    $query = "select * from tbluseraccount where User_Position_id  = 2";
    $result = mysqli_query($conn, $query);

    //header('Content-Type: application/json');
    if ($result && mysqli_num_rows($result) > 0) {
        $user_data = mysqli_fetch_assoc($result);
        if (password_verify($password, $user_data['Password'])) {
            $response = array('success' => true);
            //echo json_encode($response);
        } else {
            $response = array('success' => false, 'message' => 'Invalid password');
            //echo json_encode($response);
        }
    } else {
        $response = array('success' => false, 'message' => 'No admin account found');
        //echo json_encode($response);
    }
} else {
    $response = array('success' => false, 'message' => 'Password not provided');
    //echo json_encode($response);
}
echo json_encode($response);
exit();