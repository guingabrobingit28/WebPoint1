<?php
session_start();

include("./php/connection.php");

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
if(isset($_SESSION['User_id'])){
    unset($_SESSION['User_id']);
    session_destroy();
}

header("Location: index.php");
die;
?>