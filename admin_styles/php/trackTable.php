<?php
session_start();

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

$table = '';
if (mysqli_num_rows($result1) > 0) {
    while($row = mysqli_fetch_assoc($result1)) {
            // build the table rows
    $table .= '<tr>';
    $table .= '<td>' . $row['order_date'] . '</td>';
    $table .= '<td>' . $row['customer_name'] . '</td>';
    $table .= '<td>' . $row['customer_email'] . '</td>';
    $table .= '<td>' . $row['deliver_method_name'] . '</td>';
    $table .= '<td>' . $row['trans_order_status_name'] . '</td>';
    $table .= '<td>' . $row['payment_method_name'] . '</td>';
    $table .= '<td>' . $row['subtotal'] . '</td>';
    $table .= '<td>' . $row['discount'] . '</td>';
    $table .= '<td>' . $row['delivery_fee'] . '</td>';
    $table .= '<td>' . $row['total_amount'] . '</td>';
    $table .= '<td>' . $row['customer_change'] . '</td>';
    $table .= '<td>' . $row['delivery_date'] . '</td>';
    $table .= '<td>' . $row['pickup_date'] . '</td>';
    $table .= '</tr>';
}
}

// // build the table headers
// $tableHeaders = '<tr>';
// $tableHeaders .= '<th>Order Date</th>';
// $tableHeaders .= '<th>Customer Name</th>';
// $tableHeaders .= '<th>Customer Email</th>';
// $tableHeaders .= '<th>Delivery Method</th>';
// $tableHeaders .= '<th>Order Status</th>';
// $tableHeaders .= '<th>Payment Method</th>';
// $tableHeaders .= '<th>Subtotal</th>';
// $tableHeaders .= '<th>Discount</th>';
// $tableHeaders .= '<th>Delivery Fee</th>';
// $tableHeaders .= '<th>Total Amount</th>';
// $tableHeaders .= '<th>Customer Change</th>';
// $tableHeaders .= '<th>Delivery Date</th>';
// $tableHeaders .= '<th>Pickup Date</th>';
// $tableHeaders .= '</tr>';

// build the pagination links
$pagination = '<div class="pagination">';
$pagination .= '<a href="?page=1">&laquo; First</a>';
if ($currentPage > 1) {
    $prevPage = $currentPage - 1;
    $pagination .= '<a href="?page=' . $prevPage . '">&lsaquo; Prev</a>';
}
for ($i = 1; $i <= $totalPages; $i++) {
    if ($i == $currentPage) {
        $pagination .= '<span class="current">' . $i . '</span>';
    } else {
        $pagination .= '<a href="?page=' . $i . '">' . $i . '</a>';
    }
}
if ($currentPage < $totalPages) {
    $nextPage = $currentPage + 1;
    $pagination .= '<a href="?page=' . $nextPage . '">Next &rsaquo;</a>';
}
$pagination .= '<a href="?page=' . $totalPages . '">Last &raquo;</a>';
$pagination .= '</div>';

// build the final HTML
$html = '<table>';
// $html .= $tableHeaders;
$html .= $table;
$html .= '</table>';
$html .= $pagination;

// output the HTML
echo $html;


?>