<?php
session_start();
include ("./php/connection.php");
include ("functions.php");
//include ("./php/trackOrdersTablePaginate.php");

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
    <title>Maintenance</title>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="./node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
  <script>

    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('c8c51b636e960568a241', {
      cluster: 'eu'
    });

    var channel = pusher.subscribe('my-channel');
    channel.bind('my-event', function(data) {
      alert(JSON.stringify(data));
    });
  </script>
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
                <a href="dashboard.php" class="nav-item nav-link"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
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
        <div class="container-fluid pt-0 px-4">
            <div class="row vh-120 sidebarGraColor rounded align-items-center justify-content-between mx-0">

                <div class="col-xl-10">
                <h3 class="mb-4"><b>Track Orders</b></h3>
                </div>
                <div class="container-fluid pt-0 px-4">
                    <div class="bg-light rounded h-100 p-4">
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
                                <input id="search" name="search" class="form-control" type="text" placeholder="Search" onkeyup="mySearch1()">
                            </label>
                        </div>
                    </div>
                        <div class="table-responsive">
                            <table id="invTable" class="table table-sortable" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <!-- <th scope="col">Track Order no.</th> -->
                                        <th scope="col">Customer Order no.</th>
                                        <th scope="col">Payment Method</th>
                                        <th scope="col">Order Date</th>
                                        <th scope="col">Deliver Method</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Customer no.</th>
                                        <th scope="col">Subtotal</th>
                                        <th scope="col">Discount</th>
                                        <th scope="col">Delivery fee</th>
                                        <th scope="col">Amount Payment</th>
                                        <th scope="col">Total Amount</th>
                                        <th scope="col">Customer Change</th>
                                        <th scope="col">Deliver Date</th>
                                        <th scope="col">PickUp Date</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody  id="tblTrackOrders">
                                    <?php
                                    $rowsPerPage = 10;

                                    // get the total number of rows in the table
                                    $sql = "SELECT COUNT(*) as count FROM tbltrackorders";
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
                                
                                    $sql1 = "SELECT *, dm.deliver_method_name, ts.trans_order_status_name, pm.payment_method_name,
                                    cto.customer_id ,cto.subtotal,cto.discount,cto.delivery_fee,cto.payment_amount,cto.total_amount,
                                    cto.customer_change,cto.delivery_date,
                                    cto.pickup_date FROM tbltrackorders tr
                                    JOIN tblcustomertransactionorder cto ON tr.customer_order_id = cto.customer_trans_ord_id
                                    JOIN tbldelivermethod dm ON tr.delivery_method_id = dm.deliver_method_id
                                    JOIN tblpaymentmethod pm ON tr.payment_method_id = pm.payment_method_id
                                    JOIN tbltrackstatus ts ON tr.track_status_id = ts.transorder_status_id LIMIT $offset, $rowsPerPage;";
                                    $result1 = mysqli_query($conn, $sql1);
                                    if (!$result1) {
                                    die("Query failed: " . mysqli_error($conn));
                                    }
                                    if (mysqli_num_rows($result1) > 0) {
                                    while($row = mysqli_fetch_assoc($result1)) {
                                        echo "<tr>";
                                        // echo "<td name='trackOrders'>" . $row['track_order_id'] . "</td>";
                                        echo "<td>" . $row['customer_order_id'] . "</td>";
                                        echo "<td>" . $row['payment_method_name'] . "</td>";
                                        echo "<td>" . $row['track_order_date'] . "</td>";
                                        echo "<td>" . $row['deliver_method_name'] . "</td>";
                                        echo "<td>" . $row['trans_order_status_name'] . "</td>";
                                        echo "<td>" . $row['customer_id'] . "</td>";
                                        echo "<td>" . $row['subtotal'] . "</td>";
                                        echo "<td>" . $row['discount'] . "</td>";
                                        echo "<td>" . $row['delivery_fee'] . "</td>";
                                        echo "<td>" . $row['payment_amount'] . "</td>";
                                        echo "<td>" . $row['total_amount'] . "</td>";
                                        echo "<td>" . $row['customer_change'] . "</td>";
                                        echo "<td>" . $row['delivery_date'] . "</td>";
                                        echo "<td>" . $row['pickup_date'] . "</td>";
                                        echo "<td>";
                                        echo "<form action='./php/insertData.php' method='post'>";
                                        echo "<input type='hidden' name='pId' value='" . $row['track_order_id'] . "'>";
                                        echo "<a href='edit_trackOrders.php?id=". $row['track_order_id'] ."' class='btn btn-success'><i class='fas fa-edit'></i></a>";
                                        echo "<button type='submit' class='btn btn-danger' name='delete' id='delete-button'><i class='far fa-trash-alt'></i></button>";
                                        echo "</form>";
                                        echo "</td>";
                                        echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='17'>0 results</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <?php //pagination($currentPage, $totalPages);?>
                            <div id="pagination-container"></div>
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

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="admjs.js"></script>
<script>

// function poll() {
//   // create an XMLHttpRequest object
//   var xhr = new XMLHttpRequest();

//   // set the callback function
//   xhr.onreadystatechange = function() {
//     if (xhr.readyState === 4 && xhr.status === 200) {
//       // update the table with the new data
//       document.getElementById("tblTrackOrders").innerHTML = xhr.responseText;
//     }
//   };

//   // open the request with the URL of the PHP file
//   xhr.open("GET", "./php/trackOrdersTable.php", true);

//   // send the request
//   xhr.send();
// }

// // call the poll function every 5 seconds
// setInterval(poll, 5000);
// function poll(pageNumber, recordsPerPage) {
//   // create an XMLHttpRequest object
//   var xhr = new XMLHttpRequest();

//   // set the callback function
//   xhr.onreadystatechange = function() {
//     if (xhr.readyState === 4 && xhr.status === 200) {
//       // update the table with the new data
//       document.getElementById("tblTrackOrders").innerHTML = xhr.responseText;
//     }
//   };

//   // construct the URL with the pagination parameters
//   var url = "./php/trackOrdersTable.php?page=" + pageNumber + "&records=" + recordsPerPage;

//   // open the request with the constructed URL
//   xhr.open("GET", url, true);

//   // send the request
//   xhr.send();
// }

// // set the initial page number and number of records per page
// var pageNumber = 1;
// var recordsPerPage = 10;

// // call the poll function with the initial pagination parameters
// poll(pageNumber, recordsPerPage);

// // call the poll function with new pagination parameters every 5 seconds
// setInterval(function() {
//   pageNumber++;
//   poll(pageNumber, recordsPerPage);
// }, 5000);
// initialize page number to 1
// var page = 1;

// function poll() {
//   // create an XMLHttpRequest object
//   var xhr = new XMLHttpRequest();

//   // set the callback function
//   xhr.onreadystatechange = function() {
//     if (xhr.readyState === 4 && xhr.status === 200) {
//       // update the table with the new data
//       document.getElementById("tblTrackOrders").innerHTML = xhr.responseText;

//       // update the pagination links
//       updatePagination(xhr.getResponseHeader("X-Total-Count"));
//     //   setInterval(poll, 5000);
//     setTimeout(poll, 60000);
//     }
//   };

//   // open the request with the URL of the PHP file and the page number
//   xhr.open("GET", "./php/trackOrdersTable.php?page=" + page, true);

//   // send the request
//   xhr.send();
// }
// function poll(lastUpdateTime) {
//   var xhr = new XMLHttpRequest();
//   xhr.onreadystatechange = function() {
//     if (xhr.readyState === 4 && xhr.status === 200) {
//       var response = JSON.parse(xhr.responseText);
//       var updateTime = response.update_time; // get the timestamp of the latest update
//       if (updateTime > lastUpdateTime) {
//         // update the table with the new data
//         document.getElementById("tblTrackOrders").innerHTML = response.table_html;
//         lastUpdateTime = updateTime; // update the last update time
//       }
//     }
//   };
//   xhr.open("GET", "./php/trackOrdersTable.php?last_update_time=" + lastUpdateTime, true);
//   xhr.send();
//   setTimeout(function() {
//     poll(lastUpdateTime);
//   }, 5000);
// }
// update the pagination links based on the total number of pages
// $.ajax({
//     url: './php/trackOrdersTablePaginate.php',
//     type: 'get',
//     data: {page: currentPage},
//     dataType: 'json', // add this line to specify the data type
//     success: function(response) {
//         $('#pagination-container').html(response.pagination);
//     }
// });

// $(document).ready(function() {
//     // Get the current page number from the URL
//     var currentPage = parseInt(getUrlParameter('page')) || 1;

//     // Send an AJAX request to pagination.php to get the pagination HTML
//     $.ajax({
//         url: './php/trackOrdersTablePaginate.php',
//         type: 'get',
//         data: {page: currentPage},
//         success: function(response) {
//             // Update the pagination container with the new HTML
//             $('#pagination-container').html(response.paginationHtml);

//             // Update the current page number in the URL
//             history.replaceState({}, document.title, '?page=' + currentPage);

//             // Update any other elements on the page that need to change when the page changes
//             // ...

//             // Add event listeners to handle page navigation
//             $('.pagination a').on('click', function(event) {
//                 event.preventDefault();

//                 // Get the new page number from the link's href attribute
//                 var newPage = parseInt($(this).attr('href').split('=')[1]);

//                 // Send another AJAX request to get the new pagination HTML
//                 $.ajax({
//                     url: './php/trackOrdersTablePaginate.php',
//                     type: 'get',
//                     data: {page: newPage},
//                     success: function(response) {
//                         // Update the pagination container with the new HTML
//                         $('#pagination-container').html(response.paginationHtml);

//                         // Update the current page number in the URL
//                         history.replaceState({}, document.title, '?page=' + newPage);

//                         // Update any other elements on the page that need to change when the page changes
//                         // ...
//                     },
//                     error: function() {
//                         // Handle any errors that occur
//                         // ...
//                     }
//                 });
//             });
//         },
//         error: function() {
//             // Handle any errors that occur
//             // ...
//         }
//     });
// });

// function updatePagination(totalCount) {
//   var totalPages = Math.ceil(totalCount / 10);
//   var paginationContainer = document.getElementById("pagination-container");
//   var paginationHTML = "";

//   // create the previous link
//   if (page > 1) {
//     paginationHTML += '<a href="#" onclick="page--; poll();">&laquo; Previous</a>';
//   } else {
//     paginationHTML += '<span class="disabled">&laquo; Previous</span>';
//   }

//   // create the page links
//   for (var i = 1; i <= totalPages; i++) {
//     if (i == page) {
//       paginationHTML += '<span class="current" active>' + i + '</span>';
//     } else {
//       paginationHTML += '<a href="#" onclick="page=' + i + '; poll();">' + i + '</a>';
//     }
//   }

//   // create the next link
//   if (page < totalPages) {
//     paginationHTML += '<a href="#" onclick="page++; poll();">Next &raquo;</a>';
//   } else {
//     paginationHTML += '<span class="disabled">Next &raquo;</span>';
//   }

//   // update the pagination container
//   paginationContainer.innerHTML = paginationHTML;
// }

// // call the poll function every 5 seconds


// // call the poll function on page load
// poll(0);


</script>
    <script>logOut();</script>
</body>
</html>