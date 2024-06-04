<?php


include ("connection.php");

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

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

$rows = array(); // create an empty array to store the results

if (mysqli_num_rows($result1) > 0) {
    while($row = mysqli_fetch_assoc($result1)) {
        $rows[] = $row; // add each row to the array
    }
} else {
    $rows[] = array('error' => 'No results found'); // add an error message to the array
}

echo json_encode($rows);

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