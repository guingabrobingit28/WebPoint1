<?php
$sql = "SELECT * FROM inventory";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['product_name'] . "</td>";
        echo "<td>" . $row['price'] . "</td>";
        echo "<td>" . $row['quantity'] . "</td>";
        echo "<td>" . $row['category'] . "</td>";
        echo "<td>" . $row['subcategory'] . "</td>";
        echo "<td>" . $row['supplier'] . "</td>";
        echo "<td>" . $row['status'] . "</td>";
        echo "<td><a href='edit.php?id=" . $row['id'] . "' class='btn btn-success'><i class='fas fa-edit'></i></a>";
        echo "<a href='delete.php?id=" . $row['id'] . "' class='btn btn-danger'><i class='far fa-trash-alt'></i></a></td>";
        echo "</tr>";
    }
} else {
    echo "0 results";
}
// Pagination
$records_per_page = 10;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $records_per_page;

// Read operation with pagination
$sql = "SELECT * FROM inventory LIMIT $offset, $records_per_page";
$result = mysqli_query($conn, $sql);

// Count total records
$sql_count = "SELECT COUNT(*) FROM inventory";
$result_count = mysqli_query($conn, $sql_count);
$row_count = mysqli_fetch_row($result_count);
$total_records = $row_count[0];

// Calculate total pages
$total_pages = ceil($total_records / $records_per_page);

echo "<ul class='pagination'>";
for ($i = 1; $i <= $total_pages; $i++) {
    if ($i == $page) {
        echo "<li class='active'><a href='#'>$i</a></li>";
    } else {
        echo "<li><a href='?page=$i'>$i</a></li>";
    }
}
echo "</ul>";

// update inventory item
if (isset($_POST['update'])) {
    $product_no = $_POST['product_no'];
    $product_name = $_POST['product_name'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $category = $_POST['category'];
    $subcategory = $_POST['subcategory'];
    $supplier = $_POST['supplier'];
    $status = $_POST['status'];

    $sql = "UPDATE inventory SET product_name='$product_name', price='$price', quantity='$quantity', category='$category', subcategory='$subcategory', supplier='$supplier', status='$status' WHERE product_no='$product_no'";

    if (mysqli_query($conn, $sql)) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}

if (isset($_POST['delete'])) {
    $product_no = $_POST['product_no'];

    $sql = "DELETE FROM inventory WHERE product_no='$product_no'";

    if (mysqli_query($conn, $sql)) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
}