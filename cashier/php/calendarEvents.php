<?php
session_start();

include 'connection.php';

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$where_sql = '';

if(!empty($_GET['appointment_date']) && !empty($_GET['appointment_time'])){
    $where_sql .= " WHERE appointment_date BETWEEN '".$_GET['appointment_date']."' AND '".$_GET['appointment_time']."'";
}

$sqlCalEvent = "SELECT * FROM tblcustomertransactionapp $where_sql";
$result = $conn->query($sqlCalEvent);
$sqlQueJoin = "SELECT ct.customer_trans_app, ct.customer_name, ct.customer_contact, ct.appointment_date, ct.appointment_time,
 ct.total_sprice, asp.service_id, asp.service_prices, ms.Service_Name, ms.Service_Price
 FROM tblcustomertransactionapp ct INNER JOIN tblappserviceprices asp ON ct.customer_trans_app = asp.cus_trans_app_id
 INNER JOIN tblmaintenanceservice ms ON asp.service_id = ms.Service_id;";
$result1 = $conn->query($sqlQueJoin);
$eventsArr = array();


// if($result1->num_rows > 0){
//     while($row = $result1->fetch_assoc()){
//         $services = array(); // create an empty array to hold the service names
//         $services[] = $row['Service_Name'];

//         $customer_services = implode(',', $services);
//         $event = array(
//             'title' => $row['customer_name'],
//             'start' => date('Y-m-d', strtotime($row['appointment_date'])),
//             'time' => !empty($row['appointment_time']) ? date('H:i:s', strtotime($row['appointment_time'])) : '',
//             'customer' => $customer_services
//         );
//         array_push($eventsArr,$event);
//     }
// }
if($result1->num_rows > 0){
    while($row = $result1->fetch_assoc()){
        // Check if this customer has already been added to the events array
        $customerIndex = false;
        foreach($eventsArr as $index => $event){
            if($event['title'] == $row['customer_name']){
                $customerIndex = $index;
                break;
            }
        }
        
        // If not, create a new event
        if($customerIndex === false){
            $event = array(
                'title' => $row['customer_name'],
                'start' => date('Y-m-d', strtotime($row['appointment_date'])),
                'time' => !empty($row['appointment_time']) ? date('H:i:s', strtotime($row['appointment_time'])) : '',
                'customer' => $row['Service_Name']
            );
            array_push($eventsArr,$event);
        }
        // If yes, add the service to the existing event
        else {
            $eventsArr[$customerIndex]['customer'] .= ', ' . $row['Service_Name'];
        }
    }
}


echo json_encode($eventsArr);
    
