<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include("./php/connection.php");
include("functions.php");

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$user_data = null;
$logged_in = isset($_SESSION['User_id']);

if ($logged_in) {
    $user_data = check_login($conn);
}
// Save all session data to database
if(isset($_POST["saveSession"])){
    $customerName= $_POST["customerName"];
    $customerContact= $_POST["customerContact"];
    $scheduleDate= $_POST["scheduleDate"];
    $scheduleTime= $_POST["scheduleTime"];
    $total = $_POST["hidden_total1"];
    // var_dump($total);
    if(!empty($customerName) && !empty($customerContact) && !empty($scheduleDate) && !empty($scheduleTime)&& !empty($total)){
        $sqlapp = "INSERT INTO tblcustomertransactionapp(customer_name, customer_contact,
            appointment_date, appointment_time, total_sprice)
            VALUES ('$customerName','$customerContact','$scheduleDate','$scheduleTime',$total)";
    if(mysqli_query($conn, $sqlapp)){
        sleep(1);
    }
    else{
        echo '<script>alert("Failed to Saved Appointment")</script>';
    }
    if(isset($_SESSION["selected_option"])){
        $last_insert_id = mysqli_insert_id($conn);
        foreach($_SESSION["selected_option"] as $values){
            $service_id = $values["Service_id"];
            $service_name = $values["Service_Name"];
            $service_price = $values["Service_Price"];

            $initTotal = 0;
            
            $sqlAppSer = "INSERT INTO tblappserviceprices (cus_trans_app_id, service_id, service_prices)
                VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sqlAppSer);
            $stmt->bind_param('iid', $last_insert_id, $service_id, $service_price);
            $stmt->execute();
            if($stmt->affected_rows === 0){
                // Error inserting into database
                echo "Error: " . $sqlAppSer . "<br>" . mysqli_error($conn);
            }

           
        }
        unset($_SESSION["selected_option"]);
    }
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
    <title>Maintenance</title>

<script src="./node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

</head>
<body>
<div class="container-fluid position-relative d-flex p-0">
    <!--side bar section-->
    <div class="sidebar pe-4 pb-3">
        <nav class="navbar sidebarGraColor navbar-dark">
            <a href="dashboard.php" class="navbar-brand mx-4 mb-3">
                <img src="icon/webpoint.png" width="175">
            </a>
            <div class="d-flex align-items-center ms-4 mb-4">
                <div class="position-relative">
                    <img class="rounded-circle" src="miguel mangulabnan.jpg" alt="" style="width: 40px; height: 40px;">
                </div>
                <div class="ms-3">
                    <h6 class="mb-0"><?php echo $logged_in ? $user_data['Username'] : '';?></h6>
                    <span>Cashier</span>
                </div>
            </div>
            <div class="navbar-nav w-100">
                <a href="dashboard.php" class="nav-item nav-link"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-item nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="fa fa-laptop me-2"></i>Transactions</a>
                        <div class="dropdown-menu bg-transparent border-0">
                            <a href="POS.php" class="dropdown-item"><b>POS</b></a>
                            <a href="#" class="dropdown-item"><b>History</b></a>
                        </div>
                    </div>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-item nav-link dropdown-toggle" data-bs-toggle="dropdown"><img src="icon/repairing-service.png" width="35" class="imageInverter">&emsp;Services</a>
                        <div class="dropdown-menu bg-transparent border-0">
                            <a href="schedCalendar.php" class="dropdown-item"><b>Active Appointments</b></a>
                            <a href="addAppointment.php" class="dropdown-item"><b>Scheduling</b></a>
                            
                        </div>
                    </div> 
            </div>
        </nav>
    </div>
    
    <div class="content">
        <!--Nav bar Section-->
        <nav class="navbar navbar-expand navGraColor navbar-dark sticky-top px-4 py-0">
            <a href="dashboard.php" class="navbar-brand d-flex d-lg-none me-4">
                <h2 class="text-primary mb-0"><i class="fa fa-user-edit"></i></h2>
            </a>
            <a href="#" class="sidebar-toggler flex-shrink-0">
                <i class="fa fa-bars"></i>
            </a>
            <div class="navbar-nav align-items-center ms-auto">

                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                        <i class="fa fa-bell me-lg-2"></i>
                        <span class="d-none d-lg-inline-flex">Notification</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end sidebarGraColor border-0 rounded-0 rounded-bottom m-0">
                        <a href="#" class="dropdown-item">
                            <h6 class="fw-normal mb-0">Profile updated</h6>
                            <small>15 minutes ago</small>
                        </a>
                        <hr class="dropdown-divider">
                        <a href="#" class="dropdown-item">
                            <h6 class="fw-normal mb-0">New user added</h6>
                            <small>15 minutes ago</small>
                        </a>
                        <hr class="dropdown-divider">
                        <a href="#" class="dropdown-item">
                            <h6 class="fw-normal mb-0">Password changed</h6>
                            <small>15 minutes ago</small>
                        </a>
                        <hr class="dropdown-divider">
                        <a href="#" class="dropdown-item text-center">See all notifications</a>
                    </div>
                </div>
                <!--nav Admin section-->
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                        <img class="rounded-circle me-lg-2" src="miguel mangulabnan.jpg" alt="" style="width: 40px; height: 40px;">
                        <span class="d-none d-lg-inline-flex"><?php echo $logged_in ? $user_data['Username'] : '';?></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end sidebarGraColor border-0 rounded-0 rounded-bottom m-0">
                        <a href="#" class="dropdown-item">My Profile</a>
                        <a href="#" class="dropdown-item">Settings</a>
                        <a href="#" id="logout-link" class="dropdown-item">Log Out</a>
                    </div>
                </div>
            </div>
        </nav>

        <?php
        $sql = "SELECT *  FROM tblmaintenanceservice";
        $result = mysqli_query($conn, $sql);
        
        // Initialize dropdown list HTML code
        $dropdown_list = '<select class="form-select mb-2" name="option" aria-label=".form-select-sm example">';
        $dropdown_list .= '<option value="">--Select Service--</option>';
        while ($row = mysqli_fetch_assoc($result)) {
            $dropdown_list .= '<option value="' . $row['Service_id'] . '">' . $row['Service_Name'] . ' (₱' . number_format($row['Service_Price'],2) . ')</option>';
        }
        $dropdown_list .= '</select>';
        ?>

        <div class="container-fluid pt-0 px-4">
            <div class="row vh-120 sidebarGraColor rounded align-items-center justify-content-between mx-0">
                    <h3 class="mb-4"><b></b>Add Customer Schedules</b></h3>
                    <div class="container">
                    <form action="addAppointment.php" method="POST" id="serviceTable">
                        <div class="col-xl-10">
                            <h5 class="mb-3">Services & Prices</h5>
                            <?php echo $dropdown_list; ?>
                            <button type="submit" name="add" class="btn btn-warning" id="add">Add</button>
                            <!-- <input type="submit" name="add" value="Add" class="btn btn-warning" id="add"> -->
                        </div>
                        <table class="table table-bordered">
                                <tr>
                                    <th width="40%">Service Name</th>
                                    <th width="30%">Service Price</th>
                                    <th width="10%">action</th>
                                </tr>
                        <?php

                            
                                if (isset($_POST['remove'])) {
                                    // Get the ID of the option to remove
                                    echo '<script>Swal.fire({
                                        icon: "success",
                                        title: "DELETE",
                                        text: "Service has been deleted!"
                                    });</script>';
                                    $remove_id = $_POST['remove'];
                    
                                    // Unset the session variable that contains the selected options
                                    unset($_SESSION['selected_option'][$remove_id]);
                                    
                                    // Regenerate the table body HTML
                                    $table_body = '';
                                    $total_value = 0;
                                    foreach ($_SESSION['selected_option'] as $option) {
                                        $table_body .= '<tr><td>' . $option['Service_Name'] . '</td><td>'. number_format($option['Service_Price'],2) . '</td><td><button type="submit" class="btn btn-danger" id="remove" name="remove" value="'.$option['Service_id'].'"><i class="far fa-trash-alt"></i></button></td></tr>';
                                        $total_value += $option['Service_Price'];
                                    }
                                    $table_body .= '<tr><td colspan="2"><strong>Total</strong></td><td><div id="totalPrice" name="totalPrice">' . number_format($total_value,2) . '</div></td></tr>';

                                    // Return the table body HTML only
                                    echo $table_body;
                                }

                            
                                if (isset($_POST['add'])){
                                    if(empty($_POST['option'])){
                                        echo '<script>Swal.fire({
                                            icon: "error",
                                            title: "No Selected",
                                            text: "Please select a service!"
                                          });
                                          </script>';
                                          $table_body = '';
                                        $total_value = 0;
                                    foreach ($_SESSION['selected_option'] as $option) {
                                        $table_body .= '<tr><td>' . $option['Service_Name'] . '</td><td>'. number_format($option['Service_Price'],2) . '</td><td><button type="submit" class="btn btn-danger" id="remove" name="remove" value="'.$option['Service_id'].'"><i class="far fa-trash-alt"></i></button></td></tr>';
                                        $total_value += $option['Service_Price'];
                                    }
                                    $table_body .= '<tr><td colspan="2"><strong>Total</strong></td><td><div id="totalPrice" name="totalPrice">' . number_format($total_value,2) . '</div></td></tr>';

                                    // Return the table body HTML only
                                    echo $table_body;
                                    }
                                    // Get selected option value
                                    else{
                                    $option_id = $_POST['option'];
                                
                                    // Retrieve selected option from database
                                    $sql = "SELECT * FROM tblmaintenanceservice WHERE Service_id = $option_id";
                                    $result = mysqli_query($conn, $sql);
                                    $row = mysqli_fetch_assoc($result);
                                
                                    // Save selected option to session
                                    $_SESSION['selected_option'][$option_id] = $row;
                                                 
                                    // Calculate total value
                                    $total_value = 0;
                                    foreach ($_SESSION['selected_option'] as $option) {
                                        echo '<tr><td>' . $option['Service_Name'] . '</td><td>'. number_format($option['Service_Price'],2) . '</td><td><button type="submit" class="btn btn-danger" name="remove" value="'.$option['Service_id'].'"><i class="far fa-trash-alt"></i></button></td></tr>';
                                        $total_value += $option['Service_Price'] ;
                                    }
                                    echo '<tr><td colspan="2"><strong>Total:</strong></td><td><div id="totalPrice" name="totalPrice">' . number_format($total_value,2) . '</div></td></tr>';
                                    
                                } 
                            } 
                        ?>
                    </table>
                        <div class="col-xl-10">
                            <h5 class="mb-3">Customer Name</h5>
                            <div class="form-floating mb-2">
                                <input type="text" class="form-control" id="floatingText" id="customerName" name="customerName" placeholder="Enter Customer Name">
                            </div>
                        </div>
                        <div class="col-xl-10">
                            <h5 class="mb-3">Customer Contact</h5>
                            <div class="form-floating mb-2">
                                <input type="Number" class="form-control" id="floatingText" id="customerContact" name="customerContact">
                                <label for="floatingText">Enter Customer Contact</label>
                            </div>
                        </div>
                        <div class="col-xl-10">
                            <h5 class="mb-3">Schedule Date</h5>
                            <div class="form-floating mb-2">
                                <input type="Date" class="form-control" id="floatingText" id="scheduleDate" name="scheduleDate">
                            </div>
                        </div>
                        <div class="col-xl-10">
                            <h5 class="mb-3">Schedule Time</h5>
                            <div class="form-floating mb-2">
                                <input type="Time" class="form-control" id="floatingText" id="scheduleTime" name="scheduleTime">
                            </div>
                        </div>
                        <div class="hidden" name="hidden_total" id="hidden_total"></div>
                        <input type="number" class="hidden"  name="hidden_total1" id="hidden_total1">
                        <div class="col-xl-10">
                            <button type="submit" id="saveService" name="saveSession" class="btn btn-primary rounded-pill m-2">Submit</button>
                            <button type="button" class="btn btn-primary rounded-pill m-2">Cancel</button>
                        </div>
                </form> 
                </div>
            </div>
        </div>

        <div class="container-fluid pt-0 px-4">
            <div class="row vh-120 sidebarGraColor rounded align-items-center justify-content-between mx-0">
            <form action="addAppointment.php" method="post" id="services" name="services">
                        
            </form>
            </div>
        </div>
    </div>
</div>

<script src="css/js/bootstrap.bundle.min.js"></script>
<script src="admjs.js"></script>
<script>
    

  var firstDiv = document.getElementById("totalPrice");
    var secondDiv = document.getElementById("hidden_total");

// Get the content of the first div
    var firstDivContent1 = firstDiv.innerHTML;

// Set the content of the second div to the content of the first div
    secondDiv.innerHTML = firstDivContent1;
    
    var secondDivNumber = parseFloat(secondDiv.innerHTML);
// Log the updated content of the second div
    document.getElementById("hidden_total1").value = secondDivNumber;
    console.log(secondDivNumber);

    
</script>

<script>logOut();</script>
</body>

</html>