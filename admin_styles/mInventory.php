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
    <title>Inventory Manager</title>
    <script src="./node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
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
                    <span>Admin</span>
                </div>
            </div>
            <div class="navbar-nav w-100">
                <a href="dashboard.php" class="nav-item nav-link "><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
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

                <div class="col-xl-10">
                <h3 class="mb-4"><b>Manage Inventory</b></h3>
                <a href="sproduct.php" class="btnUrl">Add Product</a>
                </div>
                <div class="container-fluid pt-0 px-4">
                    <div class="bg-light rounded h-100 p-4">
                        <h5 class="mb-4 text-dark"><b>Manage Inventory</b></h5>
                        <div class="searchAndEntries">
                        <div class="entriesPosition" id="divLeft">
                            <label class="text-dark">Show Entries:
                                <select name="tableLength" id="totalrows" aria-controls="example" class="" >
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                    <option value="200">Show All</option>
                                </select> 
                            </label>
                        </div>
                        <div class="searchBarPosition">
                            <label class="text-dark">Search:
                                <input id="search" name="search" class="form-control" type="text" placeholder="Search" onkeyup="mySearch()">
                            </label>
                        </div>
                    </div>
                        <div class="table-responsive">
                            <table id="invTable" class="table table-sortable" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th scope="col">Product no.</th>
                                        <th scope="col">Product Image</th>
                                        <th scope="col">Product Name</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Quantity</th>
                                        <th scope="col">Category</th>
                                        <th scope="col">Supplier</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody  id="tblInventory">
                                <?php
                                    

                                    $rowsPerPage = 5;

                                    // get the total number of rows in the table
                                    $sql = "SELECT COUNT(*) as count FROM tblproductinfo";
                                    $result = mysqli_query($conn, $sql);
                                    $row = mysqli_fetch_assoc($result);
                                    $totalRows = $row['count'];

                                    // calculate the total number of pages
                                    $totalPages = ceil($totalRows / $rowsPerPage);

                                    // get the current page number
                                    $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;

                                    // calculate the offset for the current page
                                    $offset = ($currentPage - 1) * $rowsPerPage;

                                    // get the rows for the current page
                                    
                                    $sql1 = "SELECT p.product_id, p.product_name, p.product_price, p.quantity, p.img_path, c.category_name, st.status_name, sp.supplier_name
                                     FROM tblproductinfo p
                                    JOIN tblcategory c ON p.category_id = c.category_id
                                    JOIN tblstatus st ON p.product_status_id = st.status_id JOIN tblsupplierinfo sp on p.supplier_id = sp.Supplier_id LIMIT $offset, $rowsPerPage;";
                                    $result1 = mysqli_query($conn, $sql1);

                                    if (mysqli_num_rows($result1) > 0) {
                                        while($row = mysqli_fetch_assoc($result1)) {
                                            echo "<tr>";
                                            echo "<td name='product_no'>" . $row['product_id'] . "</td>";
                                            echo "<td><img src='".$row['img_path']."' width='80px' height='75px'/></td>";
                                            echo "<td>" . $row['product_name'] . "</td>";
                                            echo "<td>" . $row['product_price'] . "</td>";
                                            echo "<td>" . $row['quantity'] . "</td>";
                                            echo "<td>" . $row['category_name'] . "</td>";
                                            echo "<td>" . $row['supplier_name'] . "</td>";
                                            echo "<td>" . $row['status_name'] . "</td>";
                                            echo "<td>";
                                            echo "<form action='./php/insertData.php' method='post'>";
                                            echo "<input type='hidden' name='pId' value='" . $row['product_id'] . "'>";
                                            echo "<a href='edit_product.php?id=". $row['product_id'] ."' class='btn btn-success'><i class='fas fa-edit'></i></a>";
                                            echo "<button type='submit' class='btn btn-danger' name='delete' id='delete-button'><i class='far fa-trash-alt'></i></button>";
                                            echo "</form>";
                                            echo "</td>";
                                            echo "</tr>";
                                            }
                                        } else {
                                            echo "<tr><td colspan='10'>0 results</td></tr>";
                                        }
                                        $conn->close();
                                    ?>
                                </tbody>
                            </table>
                            <?php 
                            echo "<div style='display:flex; justify-content:flex-end; margin-top: 20px;'>";
                            echo "<ul class='pagination'>";
                            if ($currentPage > 1) {
                                echo "<li class='page-item'><a class='page-link' href='?page=".($currentPage-1)."'>Previous</a></li>";
                                }
                                for ($i = 1; $i <= $totalPages; $i++) {
                                    if ($i == $currentPage) {
                                        echo "<li class='page-item active'><a class='page-link' href='?page=".$i."'>".$i."</a></li>";
                                    } else {
                                      echo "<li class='page-item'><a class='page-link' href='?page=".$i."'>".$i."</a></li>";
                                    }
                                }
                                if ($currentPage < $totalPages) {
                                    echo "<li class='page-item'><a class='page-link' href='?page=".($currentPage+1)."'>Next</a></li>";
                                }
                                echo "</ul>";
                                echo "</div>";
                            ?>
                        </div>
                    </div>
                </div>
                
                
            </div>
        </div>
    </div>
</div>
</body>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="admjs.js" type="text/javascript"></script>
    <script>logOut();</script>

</html>