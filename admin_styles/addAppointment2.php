<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include './php/connection.php';

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Save all session data to database
if(isset($_POST["saveSession"])){
    $customerName= $_POST["customerName"];
    $customerContact= $_POST["customerContact"];
    $scheduleDate= $_POST["scheduleDate"];
    $scheduleTime= $_POST["scheduleTime"];
    $total = floatval($_POST["hidden_total"]);

    $sqlapp = "INSERT INTO tblcustomertransactionapp(customer_name, customer_contact,
            appointment_date, appointment_time, total_sprice)
            VALUES ('$customerName','$customerContact','$scheduleDate','$scheduleTime',$total)";
    if(mysqli_query($conn, $sqlapp)){
        sleep(5);
    }
    else{
        echo '<script>alert("Failed to Saved Appointment")</script>';
    }
    if(isset($_SESSION["serviceList"])){
        $sqlAppSer = "INSERT INTO tblappserviceprices (cus_trans_app_id, service_id, service_prices)
                    SELECT ct.customer_trans_app, ?, ?
                    FROM tblcustomertransactionapp ct
                    WHERE ct.customer_trans_app = LAST_INSERT_ID();";
            $stmt = $conn->prepare($sqlAppSer);
        foreach($_SESSION["serviceList"] as $key => $values){
            $service_id = $values["serviceId"];
            $service_name = $values["serviceName"];
            $service_price = $values["servicePrice"];
            
            $stmt->bind_param('id', $service_id, $service_price);
            $stmt->execute();
            if($stmt->affected_rows === 0){
                // Error inserting into database
                echo "Error: " . $sqlAppSer . "<br>" . mysqli_error($conn);
            }
            unset($_SESSION["serviceList"][$key]);
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
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/admstyles.css">
    <title>Maintenance</title>

<script src="./node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
</head>
<body>
<div class="container-fluid position-relative d-flex p-0">
    <!--side bar section-->
    <div class="sidebar pe-4 pb-3">
        <nav class="navbar sidebarGraColor navbar-dark">
            <a href="index.php" class="navbar-brand mx-4 mb-3">
                <img src="icon/webpoint.png" width="175">
            </a>
            <div class="d-flex align-items-center ms-4 mb-4">
                <div class="position-relative">
                    <img class="rounded-circle" src="miguel mangulabnan.jpg" alt="" style="width: 40px; height: 40px;">
                </div>
                <div class="ms-3">
                    <h6 class="mb-0">Miguel Mangulabnan</h6>
                    <span>Admin</span>
                </div>
            </div>
            <div class="navbar-nav w-100">
                <a href="index.php" class="nav-item nav-link"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-item nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="fa fa-laptop me-2"></i>Transactions</a>
                        <div class="dropdown-menu bg-transparent border-0">
                            <a href="POS.php" class="dropdown-item"><b>POS</b></a>
                            <a href="#" class="dropdown-item"><b>History</b></a>
                        </div>
                    </div>
                    <div class="nav-item dropdown">
                    <a href="#" class="nav-item nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="fa-solid fa-warehouse me-2"></i>Inventory</a>
                        <div class="dropdown-menu bg-transparent border-0">
                            <a href="sproduct.php" class="dropdown-item"><b>Add Product</b></a>
                            <a href="mInventory.php" class="dropdown-item"><b>Manage Inventory</b></a>
                        </div>
                    </div>
                    <div class="nav-item dropdown">
                    <a href="#" class="nav-item nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="fa-solid fa-location-dot me-2"></i>Track Orders</a>
                        <div class="dropdown-menu bg-transparent border-0">
                            <a href="sproduct.php" class="dropdown-item"><b>Track Orders List</b></a>
                            <a href="trackstatus.php" class="dropdown-item"><b>Track Status</b></a>
                        </div>
                    </div>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-item nav-link dropdown-toggle" data-bs-toggle="dropdown"><img src="icon/repairing-service.png" width="35" class="imageInverter">&emsp;Services</a>
                        <div class="dropdown-menu bg-transparent border-0">
                            <a href="schedCalendar.php" class="dropdown-item"><b>Active Appointments</b></a>
                            <a href="schedules.php" class="dropdown-item"><b>Scheduling</b></a>
                            <a href="addService.php" class="dropdown-item"><b>Add Services</b></a>
                        </div>
                    </div>
                <a href="#" class="nav-item nav-link"><i class="fa fa-table me-2"></i>Reports</a>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-item nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="fas fa-wrench me-2"></i>Maintenance</a>
                        <div class="dropdown-menu bg-transparent border-0">
                            <a href="category.php" class="dropdown-item"><b>Category</b></a>
                            <a href="subcategory.php" class="dropdown-item"><b>subcategory</b></a>
                            <a href="supplier.php" class="dropdown-item"><b>Supplier</b></a>
                            <a href="status.php" class="dropdown-item"><b>Status</b></a>
                            <a href="trackstatus.php" class="dropdown-item"><b>Track Status</b></a>
                            <a href="delivermethod.php" class="dropdown-item"><b>Deliver Method</b></a>
                            <a href="paymethod.php" class="dropdown-item"><b>Payment Method</b></a>
                            <a href="qrpayment.php" class="dropdown-item"><b>QRcode Payment</b></a>
                            <a href="#" class="dropdown-item"><b>Back up</b></a>
                            <a href="#" class="dropdown-item"><b>Terms and Condition</b></a>
                        </div>
                </div>   
            </div>
        </nav>
    </div>
    
    <div class="content">
        <!--Nav bar Section-->
        <nav class="navbar navbar-expand navGraColor navbar-dark sticky-top px-4 py-0">
            <a href="index.php" class="navbar-brand d-flex d-lg-none me-4">
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
                        <span class="d-none d-lg-inline-flex">Miguel Mangulabnan</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end sidebarGraColor border-0 rounded-0 rounded-bottom m-0">
                        <a href="#" class="dropdown-item">My Profile</a>
                        <a href="#" class="dropdown-item">Settings</a>
                        <a href="#" class="dropdown-item">Log Out</a>
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
                    <form action="" method="POST" id="serviceTable">
                        <div class="col-xl-10">
                            <h5 class="mb-3">Services & Prices</h5>
                            <?php echo $dropdown_list; ?>
                            <input type="submit" name="add" value="Add" class="btn btn-warning">
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
                                $remove_id = $_POST['remove'];
                
                                // Unset the session variable that contains the selected options
                                unset($_SESSION['selected_option'][$remove_id]);
                                echo '<script>Swal.fire({
                                    icon: "success",
                                    title: "DELETE",
                                    text: "Service has been deleted!",
                                  });</script>';
                                 // Regenerate the table body HTML
                                $table_body = '';
                                $total_value = 0;
                                foreach ($_SESSION['selected_option'] as $option) {
                                    $table_body .= '<tr><td>' . $option['Service_Name'] . '</td><td>'. number_format($option['Service_Price'],2) . '</td><td><button type="submit" class="btn btn-danger" name="remove" value="'.$option['Service_id'].'"><i class="far fa-trash-alt"></i></button></td></tr>';
                                    $total_value += $option['Service_Price'];
                                }
                                $table_body .= '<tr><td colspan="2"><strong>Total</strong></td><td>₱' . number_format($total_value,2) . '</td></tr>';

                                // Return the table body HTML only
                                echo $table_body;
                            }
                            if (isset($_POST['add'])) {
                            // Get selected option value
                            $option_id = $_POST['option'];
                        
                            // Retrieve selected option from database
                            $sql = "SELECT * FROM tblmaintenanceservice WHERE Service_id = $option_id";
                            $result = mysqli_query($conn, $sql);
                            $row = mysqli_fetch_assoc($result);
                        
                            // Save selected option to session
                            $_SESSION['selected_option'][$option_id] = $row;
                            
                            
                            // Calculate total value
                            $total_value = 0;
                            ?>    
                            
                                <?php
                            //if(!empty($_SESSION['selected_option'])){
                            foreach ($_SESSION['selected_option'] as $option) {
                                echo '<tr><td>' . $option['Service_Name'] . '</td><td>'. number_format($option['Service_Price'],2) . '</td><td><button type="submit" class="btn btn-danger" name="remove" value="'.$option['Service_id'].'"><i class="far fa-trash-alt"></i></button></td></tr>';
                                $total_value += $option['Service_Price'];
                                
                            }
                            echo '<tr><td colspan="2"><strong>Total</strong></td><td>₱' . number_format($total_value,2) . '</td></tr>';
                            echo '<input type="number" class="hidden" name="hidden_total" value="'.$total_value.'" >';
                            //}
                        }
                        
                        ?>
                    </table>
                </form> 
                </div>
            </div>
        </div>

        <div class="container-fluid pt-0 px-4">
            <div class="row vh-120 sidebarGraColor rounded align-items-center justify-content-between mx-0">
            <form action="addAppointment.php" method="post" id="services" name="services">
                        <div class="col-xl-10">
                        </div>
                        <div class="col-xl-10">
                            <h5 class="mb-3">Customer Name</h5>
                            <div class="form-floating mb-2">
                                <input type="text" class="form-control" id="floatingText" id="customerName" name="customerName" required>
                                <label for="floatingText">Enter Customer Name</label>
                            </div>
                        </div>
                        <div class="col-xl-10">
                            <h5 class="mb-3">Customer Contact</h5>
                            <div class="form-floating mb-2">
                                <input type="Number" class="form-control" id="floatingText" id="customerContact" name="customerContact" required>
                                <label for="floatingText">Enter Customer Contact</label>
                            </div>
                        </div>
                        <div class="col-xl-10">
                            <h5 class="mb-3">Schedule Date</h5>
                            <div class="form-floating mb-2">
                                <input type="Date" class="form-control" id="floatingText" id="scheduleDate" name="scheduleDate" required>
                            </div>
                        </div>
                        <div class="col-xl-10">
                            <h5 class="mb-3">Schedule Time</h5>
                            <div class="form-floating mb-2">
                                <input type="Time" class="form-control" id="floatingText" id="scheduleTime" name="scheduleTime" required>
                            </div>
                        </div>
                        
                        <div class="col-xl-10">
                            <button type="submit" id="saveService" name="saveSession" class="btn btn-primary rounded-pill m-2">Submit</button>
                            <button type="button" class="btn btn-primary rounded-pill m-2">Cancel</button>
                        </div>
                    </form>
            </div>
        </div>
        <!-- <div class="container-fluid pt-0 px-4">
            <div class="row vh-120 sidebarGraColor rounded align-items-center justify-content-between mx-0">
                
            </div>
        </div> -->
    </div>
</div>
<?php 
        if(isset($_SESSION['status'])){
            $message = $_SESSION['status'];
            echo "<script type='text/javascript'>alert('$message');</script>";
            unset($_SESSION['status']); 
        }
    ?>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
<script src="admjs.js"></script>
<script>
    $(document).ready(function() {
    $('#serviceTable').on('click', 'button[name=remove]', function(e) {
        e.preventDefault();
         var form_data = $(this).closest('form').serialize();
         var url = $(this).closest('form').attr('action');
         var table_body = $(this).closest('table').find('tbody');
        $.ajax({
            type: 'POST',
            url: url,
            data: form_data,
            success: function(data) {
                // update the table here
                table_body.html(data);   
            }
        });
    });
});    
</script>
    
    
</body>

</html>