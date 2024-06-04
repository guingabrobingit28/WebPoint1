<?php

session_start();
// Set the timezone to Asia/Manila
date_default_timezone_set('Asia/Manila');

include("connection.php");
include("functions.php");


if(isset($_POST['email']) && isset($_POST['password']) && isset($_POST['cfpassword'])){
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cfpassword = $_POST['cfpassword'];

    // Get the token and expiration from the URL
    $token = isset($_GET['token']) ? $_GET['token'] : '';
    $expires = isset($_GET['expires']) ? $_GET['expires'] : '';

    // Check if the expiration has passed
    if($expires < date('Y-m-d H:i:s')){
        $response = array(
            'status' => 'error',
            'message' => 'Link has expired.'
        );
        echo json_encode($response);
        exit();
    }

    // Verify the token against the one in the database
    $stmt = $con->prepare("SELECT user_id, Password FROM tblforgotpasswordtokens JOIN tbluseraccount ON tblforgotpasswordtokens.user_id = tbluseraccount.User_id WHERE token = ? AND expiration >= NOW()");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    if($result->num_rows === 0){
        $response = array(
            'status' => 'error',
            'message' => 'Invalid token.'
        );
        echo json_encode($response);
        exit();
    }

    $user_data = $result->fetch_assoc();
    $db_password = $user_data['Password'];
    $user_id = $user_data['user_id'];

    if($password == $cfpassword){
        if(password_verify($password, $db_password)){
            $response = array(
                'status' => 'error',
                'message' => 'Please use a different password.'
            );
            echo json_encode($response);
            exit();
        }

        // Password encryption
        $encrypted_password = password_hash($password, PASSWORD_BCRYPT);

        // Update the user's password in the database
        $stmt = $con->prepare("UPDATE tbluseraccount SET Password = ? WHERE User_EmailAddress = ?");
        $stmt->bind_param('ss', $encrypted_password, $email);
        $stmt->execute();
        $stmt->close();

        // Delete the forgot_password entry from the database
        $stmt = $con->prepare("DELETE FROM tblforgotpasswordtokens WHERE user_id = ?");
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        $stmt->close();

        // Send a response to the user
        $response = array(
            'status' => 'success',
            'message' => 'Your password has been changed!'
        );
        echo json_encode($response);
        exit();
    }else{
        $response = array(
            'status' => 'error',
            'message' => 'Passwords do not match!'
        );
        echo json_encode($response);
        exit();
    }
}else{
    $response = array(
    'status' => 'error',
    'message' => 'Please fill out all fields!'
    );
    echo json_encode($response);
    exit();
    }