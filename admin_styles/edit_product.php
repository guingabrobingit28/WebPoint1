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
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $quantity = $_POST['quantity'];
    $category_id = $_POST['category_id'];
    $supplier_id = $_POST['supplier_id'];
    $product_status_id = $_POST['status_id'];
    $description = $_POST['description'];

    // check if an image is uploaded
    if(isset($_FILES['product_img']) && $_FILES['product_img']['size'] > 0) {
        $image = $_FILES['product_img']['name'];
        $target_dir = "./admImages/products/";
        $target_file = $target_dir . basename($image);
        $target_dir2 = "./admImages/products/";
        $target_file2 = $target_dir2 . basename($image);
        $img_type = $_FILES['product_img']['type'];

        // check if image is valid
        $valid_image_types = array(
            "image/jpeg",
            "image/png",
            "image/gif",
            "image/webp"
        );
        
        if(in_array($img_type, $valid_image_types)) {
            $sql = "UPDATE tblproductinfo SET product_name = '$product_name', product_price = '$product_price',
             quantity = '$quantity', category_id = $category_id,
             supplier_id = '$supplier_id', product_status_id = '$product_status_id', img_path = '$target_file2',
             description = '$description'
             WHERE product_id = $product_id";
            $message = "Product updated successfully";
            if(mysqli_query($conn, $sql)) {
                echo "<script type='text/javascript'>alert('$message');</script>";
                move_uploaded_file($_FILES['product_img']['tmp_name'], $target_file);
                
            }
            else {
                echo "Error updating product: " . mysqli_error($conn);
            }
        } else {
            $message = "Invalid image type. Only JPEG, PNG, GIF, and WebP are allowed.";
            echo "<script type='text/javascript'>alert('$message');</script>";
            $sql = "";
        }
    } else {
        $sql = "UPDATE tblproductinfo SET product_name = '$product_name', product_price = '$product_price', 
        quantity = '$quantity', category_id = $category_id, 
        supplier_id = '$supplier_id', product_status_id = '$product_status_id', ,
            description = '$description' WHERE product_id = $product_id";
        $message = "Product updated successfully";
        if($sql != "" && mysqli_query($conn, $sql)) {
            echo "<script type='text/javascript'>alert('$message');</script>";
            // move_uploaded_file($_FILES['product_img']['tmp_name'], $target_file);
            
        }
        else {
            echo "Error updating product: " . mysqli_error($conn);
        }
    }

    // // execute SQL query
    // if($sql != "" && mysqli_query($conn, $sql)) {
    //     echo "<script type='text/javascript'>alert('$message');</script>";
    //     move_uploaded_file($_FILES['product_img']['tmp_name'], $target_file);
        
    // }
    // else {
    //     echo "Error updating product: " . mysqli_error($conn);
    // }
}

       


// get product details
if(isset($_GET['id'])) {
    $product_id = $_GET['id'];
    $sql = "SELECT * FROM tblproductinfo WHERE product_id = $product_id";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
    } else {
        echo "Product not found";
        exit;
    }
} else {
    echo "Product ID not specified";
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
            <div class="row vh-120 sidebarGraColor rounded align-items-center justify-content-between mx-0">
            <h2>Edit Product</h2>
        <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">
        <div class="col-xl-10">
            <h5>Product Name</h5>
            <div class="form-group">
            <input type="text" class="form-control input-sm" name="product_name" value="<?php echo $row['product_name']; ?>">
            </div>
        </div>
        <div class="col-xl-10">
            <h5>Price</h5>
            <div class="form-group">
            <input type="number" class="form-control input-sm" name="product_price" value="<?php echo $row['product_price']; ?>">
            </div>
        </div>
        <div class="col-xl-10">
            <h5>Quantity</h5>
            <div class="form-group">
            <input type="number" class="form-control input-sm" name="quantity" value="<?php echo $row['quantity']; ?>">
            </div>
        </div>
        <div class="col-xl-10">
            <h5>Category</h5>
            <div class="form-group">
            <select name="category_id" class="form-select" aria-label=".form-select-sm example">
        <?php
        // retrieve list of categories
            $sql = "SELECT * FROM tblcategory";
            $result = mysqli_query($conn, $sql);
            // display dropdown options
                    while($category = mysqli_fetch_assoc($result)) {
                        if($category['category_id'] == $row['category_id']) {
                            echo "<option value='" . $category['category_id'] . "' selected>" . $category['category_name'] . "</option>";
                        } else {
                        echo "<option value='" . $category['category_id'] . "'>" . $category['category_name'] . "</option>";
                        }
                    }
        ?></select>
            </div>
        </div>
        
        <div class="col-xl-10">
            <h5>Supplier</h5>
            <div class="form-group">
            <select name="supplier_id" class="form-select" aria-label=".form-select-sm example">
        <?php
            // retrieve list of suppliers
            $sql = "SELECT * FROM tblsupplierinfo";
            $result = mysqli_query($conn, $sql);

            // display dropdown options
            while($supplier = mysqli_fetch_assoc($result)) {
                if($supplier['Supplier_id'] == $row['Supplier_id']) {
                    echo "<option value='" . $supplier['Supplier_id'] . "' selected>" . $supplier['Supplier_name'] . "</option>";
                } else {
                    echo "<option value='" . $supplier['Supplier_id'] . "'>" . $supplier['Supplier_name'] . "</option>";
                }
            }
        ?></select>
            </div>
        </div>
        <div class="col-xl-10">
            <h5>Product Status</h5>
            <div class="form-group">
            <select name="status_id" class="form-select" aria-label=".form-select-sm example">
        <?php
            // retrieve list of product statuses
            $sql = "SELECT * FROM tblstatus";
            $result = mysqli_query($conn, $sql);

            // display dropdown options
            while($product_status = mysqli_fetch_assoc($result)) {
                if($product_status['status_id'] == $row['status_id']) {
                    echo "<option value='" . $product_status['status_id'] . "' selected>" . $product_status['status_name'] . "</option>";
                } else {
                    echo "<option value='" . $product_status['status_id'] . "'>" . $product_status['status_name'] . "</option>";
                }
            }
        ?></select>
            </div>
        </div>
        <div class="col-xl-10">
            <h5 class="mb-3">Description</h5>
            <div class="form-floating mb-3">
                    <textarea class="form-control" name="description" id="floatingTextarea" placeholder="Descriptions"></textarea>
            </div>
        </div>
        <div class="col-xl-10">
            <h5>Product Image</h5>
            <input type="file" name="product_img"><br><br>
            <img src="<?php echo $row['img_path']; ?>" height="150px"><br><br>
            <input type="submit" name="submit" value="Update Product" class="btn btn-primary">
            </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
<script src="./admjs.js" type="text/javascript"></script>
<script>logOut();</script>
</body>
</html>