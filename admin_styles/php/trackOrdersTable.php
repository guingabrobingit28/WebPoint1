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

    // function pagination($currentPage, $totalPages){
    // echo "<div style='display:flex; justify-content:flex-end; margin-top: 20px;'>";
    // echo "<ul class='pagination'>";
    // if ($currentPage > 1) {
    //     echo "<li class='page-item'><a class='page-link' href='?page=".($currentPage-1)."'>Previous</a></li>";
    //     }
    //     for ($i = 1; $i <= $totalPages; $i++) {
    //         if ($i == $currentPage) {
    //             echo "<li class='page-item active'><a class='page-link' href='?page=".$i."'>".$i."</a></li>";
    //         } else {
    //             echo "<li class='page-item'><a class='page-link' href='?page=".$i."'>".$i."</a></li>";
    //         }
    //     }
    //     if ($currentPage < $totalPages) {
    //         echo "<li class='page-item'><a class='page-link' href='?page=".($currentPage+1)."'>Next</a></li>";
    //     }
    //     echo "</ul>";
    //     echo "</div>";
    // }
    function paginationToJson($currentPage, $totalPages){
        $pagination = "<div style='display:flex; justify-content:flex-end; margin-top: 20px;'>";
        $pagination .= "<ul class='pagination'>";
        if ($currentPage > 1) {
            $pagination .= "<li class='page-item'><a class='page-link' href='?page=".($currentPage-1)."'>Previous</a></li>";
            }
            for ($i = 1; $i <= $totalPages; $i++) {
                if ($i == $currentPage) {
                    $pagination .= "<li class='page-item active'><a class='page-link' href='?page=".$i."'>".$i."</a></li>";
                } else {
                    $pagination .= "<li class='page-item'><a class='page-link' href='?page=".$i."'>".$i."</a></li>";
                }
            }
            if ($currentPage < $totalPages) {
                $pagination .= "<li class='page-item'><a class='page-link' href='?page=".($currentPage+1)."'>Next</a></li>";
            }
            $pagination .= "</ul>";
            $pagination .= "</div>";
        
        return json_encode(array("pagination" => $pagination));
    }
    
    
    ?>