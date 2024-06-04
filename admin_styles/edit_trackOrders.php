<?php
session_start();
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
// check if form is submitted
if(isset($_POST['submit'])) {
    $trackOrder = $_POST['trackOrder'];
    $orderNumber= $_POST['orderNumber'];
    $status_id = $_POST['trackStatusId'];
    $discount = $_POST['discount'];
    $deliveryFee = $_POST['deliveryFee'];
    $customerChange = $_POST['customerChange'];
    $deliverDate = $_POST['deliverDate'];
    
    //  var_dump($trackOrder,$orderNumber,$status_id,$discount,$deliveryFee,$customerChange,$deliverDate);
    if(!empty($status_id) && !empty($trackOrder) ){
        if($discount){
            $sql = "UPDATE tblcustomertransactionorder SET discount=$discount
         WHERE customer_trans_ord_id = $orderNumber";
        if(mysqli_query($conn,$sql)){

        }else{
            echo 'error: ' . mysqli_error($conn);
        }
        }else{

        }
        if($deliveryFee){
            $sql = "UPDATE tblcustomertransactionorder SET delivery_fee=$deliveryFee
         WHERE customer_trans_ord_id = $orderNumber";
        if(mysqli_query($conn,$sql)){

        }else{
            echo 'error: ' . mysqli_error($conn);
        }
        }else{

        }
        if($customerChange){
            $sql = "UPDATE tblcustomertransactionorder SET customer_change=$customerChange
         WHERE customer_trans_ord_id = $orderNumber";
        if(mysqli_query($conn,$sql)){

        }else{
            echo 'error: ' . mysqli_error($conn);
        }
        }else{

        }
        if($deliverDate){
            $sql = "UPDATE tblcustomertransactionorder SET delivery_date=$deliverDate
         WHERE customer_trans_ord_id = $orderNumber";
        if(mysqli_query($conn,$sql)){

        }else{
            echo 'error: ' . mysqli_error($conn);
        }
        }else{

        }
        // $sql = "UPDATE tblcustomertransactionorder SET 
        // discount=$discount,delivery_fee=$deliveryFee,customer_change=$customerChange,delivery_date=$deliverDate
        //  WHERE customer_trans_ord_id = $orderNumber";
        // if(mysqli_query($conn,$sql)){

        // }else{
        //     echo 'error: ' . mysqli_error($conn);
        // }
        if($status_id){
            $sql1 = "UPDATE tbltrackorders SET track_status_id=$status_id WHERE track_order_id = $trackOrder";
            if(mysqli_query($conn,$sql1)){

            }else{
                echo 'error: ' . mysqli_error($conn);
            }
        }else{

        }
        
        // $sql = "UPDATE tblcustomertransactionorder SET 
        // discount=?,delivery_fee=?,customer_change=?,delivery_date=?
        //  WHERE customer_trans_ord_id = ?";
        // $stmt= mysqli_prepare($conn,$sql);
        // $stmt->bind_param('dddsi',$discount,$deliveryFee,$customerChange,$deliverDate,$orderNumber);
        // $stmt->execute();
        // if($stmt->affected_rows === 0){
        //     echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        // }else{

        // }
        // $sql1 = "UPDATE tbltrackorders SET track_status_id=? WHERE track_order_id = ?";
        // $stmt1 = mysqli_prepare($conn,$sql1);
        // $stmt1->bind_param('ii',$status_id,$trackOrder);
        // $stmt1->execute(); 
        // if($stmt1->affected_rows === 0){
        //     echo "Error: " . $sql1 . "<br>" . mysqli_error($conn);
        // }else{

        // }
    }else{

    }
}

       


// get product details
if(isset($_GET['id'])) {
    $track_id = $_GET['id'];
    $sql = "SELECT *, dm.deliver_method_name, ts.trans_order_status_name, pm.payment_method_name,
    cto.customer_id ,cto.subtotal,cto.discount,cto.delivery_fee,cto.payment_amount,cto.total_amount,
    cto.customer_change,cto.delivery_date,
    cto.pickup_date FROM tbltrackorders tr
    JOIN tblcustomertransactionorder cto ON tr.customer_order_id = cto.customer_trans_ord_id
    JOIN tbldelivermethod dm ON tr.delivery_method_id = dm.deliver_method_id
    JOIN tblpaymentmethod pm ON tr.payment_method_id = pm.payment_method_id
    JOIN tbltrackstatus ts ON tr.track_status_id = ts.transorder_status_id WHERE track_order_id = $track_id";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
    } else {
        echo "<script type='text/javascript'>alert('Track Order not found');</script>";
        exit;
    }
} else {
    echo "<script type='text/javascript'>alert('Product ID not specified');</script>";
    exit;
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
    <title>Update Product</title>
    <script src="./node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
</head>
<body><div class="container-fluid position-relative d-flex p-0">
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
                    <span>Admin</span>
                </div>
            </div>
            <div class="navbar-nav w-100">
                <a href="dashboard.php" class="nav-item nav-link active "><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
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
                            <a href="returnproduct.php" class="dropdown-item"><b>Add Return Products</b></a>
                            <a href="exchangeProduct.php" class="dropdown-item"><b>Add Exchange Products</b></a>
                        </div>
                    </div>
                    <div class="nav-item dropdown">
                    <a href="#" class="nav-item nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="fa-solid fa-location-dot me-2"></i>Track Orders</a>
                        <div class="dropdown-menu bg-transparent border-0">
                            <a href="trackOrders.php" class="dropdown-item"><b>Track Orders List</b></a>
                            <a href="trackstatus.php" class="dropdown-item"><b>Track Status</b></a>
                        </div>
                    </div>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-item nav-link dropdown-toggle" data-bs-toggle="dropdown"><img src="icon/repairing-service.png" width="35" class="imageInverter">&emsp;Services</a>
                            <div class="dropdown-menu bg-transparent border-0">
                                <a href="schedCalendar.php" class="dropdown-item"><b>Active Appointments</b></a>
                                <a href="addAppointment.php" class="dropdown-item"><b>Scheduling</b></a>
                                <a href="addService.php" class="dropdown-item"><b>Add Services</b></a>
                                <a href=".php" class="dropdown-item"><b>Void Appointments</b></a>
                            </div>
                        </div>
                    <a href="#" class="nav-item nav-link"><i class="fa fa-table me-2"></i>Reports</a>
                    <div class="nav-item dropdown">
                    <a href="#" class="nav-item nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="fas fa-wrench me-2"></i>Maintenance</a>
                        <div class="dropdown-menu bg-transparent border-0">
                            <a href="category.php" class="dropdown-item"><b>Category</b></a>
                            <a href="sproduct.php" class="dropdown-item"><b>Products</b></a>
                            <a href="supplier.php" class="dropdown-item"><b>Supplier</b></a>
                            <a href="status.php" class="dropdown-item"><b>Add Status</b></a>
                            <a href="trackstatus.php" class="dropdown-item"><b>Add Track Status</b></a>
                            <a href="delivermethod.php" class="dropdown-item"><b>Deliver Method</b></a>
                            <a href="paymethod.php" class="dropdown-item"><b>Payment Method</b></a>
                            <a href="qrpayment.php" class="dropdown-item"><b>QRcode Payment</b></a>
                            <a href="customerType.php" class="dropdown-item"><b>Add Customer Type</b></a>
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
        <!--product maintenance-->
        <div class="container-fluid pt-0 px-4">
            <div class="row vh-150 sidebarGraColor rounded align-items-center justify-content-between mx-0">
            <h2>Edit Track Status</h2>
        <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="trackOrder" value="<?php echo $row['track_order_id']; ?>">
        <input type="hidden" name="orderNumber" value="<?php echo $row['customer_order_id']; ?>">
        <div class="col-xl-10">
            <h5>Order no.</h5>
            <div class="form-group">
            <div><b><?php echo $row['customer_order_id']; ?></b></div>
            </div>
        </div>
        <div class="col-xl-10">
            <h5>Payment Method</h5>
            <div class="form-group">
            <div><b><?php echo $row['payment_method_name']; ?></b></div>
            </div>
        </div>
        <div class="col-xl-10">
            <h5>Order Date</h5>
            <div class="form-group">
            <div><b><?php echo $row['track_order_date']; ?></b></div>
            </div>
        </div>
        <div class="col-xl-10">
            <h5>Deliver Method</h5>
            <div class="form-group">
            <div><b><?php echo $row['deliver_method_name']; ?></b></div>
            </div>
        </div>
        <div class="col-xl-10">
            <h5>Track Status</h5>
            <div class="form-group">
            <select name="trackStatusId" class="form-select" aria-label=".form-select-sm example">

        <?php
            // retrieve list of product statuses
            $sql = "SELECT * FROM tbltrackstatus";
            $result = mysqli_query($conn, $sql);

            // display dropdown options
            while($track_status = mysqli_fetch_assoc($result)) {
                if($track_status['transorder_status_id'] == $row['track_status_id']) {
                    echo "<option value='" . $track_status['transorder_status_id'] . "' selected>" . $track_status['trans_order_status_name'] . "</option>";
                } else {
                    echo "<option value='" . $track_status['transorder_status_id'] . "'>" . $track_status['trans_order_status_name'] . "</option>";
                }
            }
        ?></select>
            </div>
        </div>
        <div class="col-xl-10">
            <h5>Customer no.</h5>
            <div class="form-group">
            <div><b><?php echo $row['customer_id']; ?></b></div>
            </div>
        </div>
        <div class="col-xl-10">
            <h5>Subtotal</h5>
            <div class="form-group">
            <div><b><?php echo $row['subtotal']; ?></b></div>
            </div>
        </div>
        <div class="col-xl-10">
            <h5>Discount</h5>
            <div class="form-group">
            <input type="number" class="form-control input-sm" name="discount" value="<?php echo $row['discount']; ?>">
            </div>
        </div>
        <div class="col-xl-10">
            <h5>Delivery fee</h5>
            <div class="form-group">
                <?php
                if($row['deliver_method_id'] == 1){?>
                    <input type="number" class="form-control input-sm" name="deliveryFee" value="<?php echo $row['delivery_fee']; ?>" disabled>
                <?php
                }else{?>
                    <input type="number" class="form-control input-sm" name="deliveryFee" value="<?php echo $row['delivery_fee']; ?>">
                <?php }
                ?>
            </div>
        </div>
        <div class="col-xl-10">
            <h5>Amount Payment</h5>
            <div class="form-group">
            <div><b><?php echo $row['payment_amount']; ?></b></div>
            </div>
        </div>
        <div class="col-xl-10">
            <h5>Total Amount</h5>
            <div class="form-group">
            <div><b><?php echo $row['total_amount']; ?></b></div>
            </div>
        </div>
        <div class="col-xl-10">
            <h5>Customer Change</h5>
            <div class="form-group">
            <input type="number" class="form-control input-sm" name="customerChange" value="<?php echo $row['customer_change']; ?>">
            </div>
        </div>
        <div class="col-xl-10">
            <h5>Deliver Date</h5>
            <div class="form-group">
                <?php
                    if($row['deliver_method_id'] == 1){?>
                        <input type="date" class="form-control input-sm" name="deliverDate" value="<?php echo $row['delivery_date']; ?>" disabled>
                <?php }else{?>
                    <input type="date" class="form-control input-sm" name="deliverDate" value="<?php echo $row['delivery_date']; ?>">
                <?php }
                ?>
            
            </div>
        </div>
        <div class="col-xl-10">
            <h5>Pickup Date</h5>
            <div class="form-group">
            <div><b><?php echo $row['pickup_date']; ?></b></div>
            </div>
        </div>
        </div>
            <input type="submit" name="submit" value="Update Product" class="btn btn-primary">
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
<script src="./admjs.js" type="text/javascript"></script>
<script>

</script>
<script>logOut();</script>
</body>
</html>