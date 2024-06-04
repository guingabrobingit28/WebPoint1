<?php
session_start();
require_once ('connection.php');

$conn = mysqli_connect($servername, $username, $password, $dbname);

$jsonStr = file_get_contents('php://input');
$jsonObj = json_decode($jsonStr);

if($jsonObj->request_type == 'addEvent'){
    $start = $jsonObj ->start;
    // $end = $jsonObj ->end;

    $event_data= $jsonObj->event_data;
    $eventCusName = !empty($event_data[0])?$event_data[0]:'';
    $eventCusContNo = !empty($event_data[0])?$event_data[0]:'';
    $eventAppTime = !empty($event_data[0]) ? DateTime::createFromFormat('h:i A', $event_data[0])->format('H:i:s') : '';
    $eventServType = !empty($event_data[0])?$event_data[0]:'';
    // $eventAppTime = !empty($event_data[0])? date('H:i', strtotime($event_data[0])):'';

    if(!empty($eventCusName)){
        $sqlQuery = "INSERT INTO tblcustomertransactionapp
            (customer_name, customer_contact, service_id, appointment_date, appointment_time)
             VALUES (?,?,?,?,?)";
        $stmt = $conn->prepare($sqlQuery);
        $stmt-> bind_param("ssiss",$eventCusName,$eventCusContNo,$eventServType,$start,$eventAppTime);
        $insert = $stmt->execute();
        echo 'Query executed';

        if($insert){
            $output = [
                'status' => 1
            ];
            echo json_encode($output);
        }
        else{
            echo json_encode(['error' => 'Event add request Failed!']);
        }
    }
}