<?php
// must include this for sending email to reset password
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

session_start();
date_default_timezone_set('Asia/Manila');

include("connection.php");

// if email is set and not empty execute this code
if(isset($_POST['email']) && !empty($_POST['email'])){
    $email = $_POST['email'];
    // query to get the user_id from the email inputted by the user
    $sql = "SELECT User_id FROM tbluseraccount WHERE User_EmailAddress = '$email'";
    $stmt = $con->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $user_id = $row['User_id'];

    // if user_id is true (in the database) execute this
    if($user_id){
        // code for generating the token
        $token = bin2hex(random_bytes(16));
        // code for generating the expiration time, 15 minutes before expiration
        $expires = date('Y-m-d H:i:s', strtotime('+15 minutes'));
        $url = "http://localhost/webpoint/index-page/passReset.php?id=" . urlencode($user_id) . "&token=" . urlencode($token) . "&expires=" . urlencode($expires);
        // insert the forgot password details in the database
        $statement = $con->prepare("INSERT INTO tblforgotpasswordtokens (user_id, token, expiration) VALUES (?, ?, ?)");
        $statement->bind_param('iss', $user_id, $token, $expires);
        $statement->execute();
        $statement->close();
        $con->close();

        //send email for password reset link
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
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = 'Password Reset Request';
            $mail->Body = 'Dear User,

            We have received a request to reset your password. If you did not make this request, please disregard this email.
            <br><br>
            To reset your password, please follow these steps:
            <br><br>
            1. Click on the following link: ' . $url . '<br>
            2. Enter your email address and the new password you would like to use<br>
            3. Click "Submit"<br><br>

            If you have any questions or concerns, please do not hesitate to contact us.
            <br><br>
            Best regards,
            <br>
            Fixpoint';

            $mail->send();
            //set the expiration to the session to use it for the actual resetting of password
            $_SESSION['expiration'] = $expires;

            // throw a response to the ajax
            $response = array(
                'status' => 'success',
                'message' => 'An email has been sent to your address with instructions on how to reset your password.'
            );
            echo json_encode($response);
            exit();
        }catch(Exception $e){
            // throw a response to the ajax
            $response = array(
                'status' => 'error',
                'message' => 'No user with that email address was found'
            );
            echo json_encode($response);
            exit();
        }
    }else{
        // if there is no email address that matches in the database
        // throw a response to the ajax
        $response = array(
            'status' => 'error',
            'message' => 'No user with that email address was found'
        );
        echo json_encode($response);
        exit();
    }
}else{
    // if the field is empty
    // throw a response to the ajax
    $response = array(
        'status' => 'error',
        'message' => 'Please fill out the field!'
    );
    echo json_encode($response);
    exit();
}

