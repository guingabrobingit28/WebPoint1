<?php
function check_login($conn){
    if(isset($_SESSION['User_id'])){
        $id = $_SESSION['User_id'];
        $query = "SELECT * FROM tbluseraccount WHERE User_id = ? LIMIT 1";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result && $result->num_rows > 0)
        {
            $user_data = $result->fetch_assoc();
            return $user_data;
        }
    }
    header("Location: dashboard.php");
    die();
}

function isValidPhoneNumber($phone) {
    // Remove any non-digit characters from the phone number
    $phone = preg_replace('/\D/', '', $phone);

    // Check that the phone number is exactly 11 digits long and starts with 0
    if (preg_match('/^0\d{10}$/', $phone)) {
        return true;
    } else {
        return false;
    }
}


