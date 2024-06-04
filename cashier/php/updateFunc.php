<?php
session_start();

include('connection.php');


$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if(getimagesize($_FILES['imagefile']['tmp_name']) == false){
        
    echo "<h2>select Image</h2>";

}
else{
    
    if (isset($_FILES['imagefile'])) {
        // get image data from file
        $image = file_get_contents($_FILES['imagefile']['tmp_name']);
        
        // escape special characters in image data
        $image = $conn->real_escape_string($image);
        
        $product_id = $_POST['product_id'];
        $product_query = "SELECT * FROM tblproductinfo WHERE product_id = $product_id";
        $product_result = $conn->query($product_query);
        $product_row = $product_result->fetch_assoc();
        
        $productname = $product_row['product_name'];
        $price = $product_row['product_price'];
        $quantity = $product_row['quantity'];
        $category = $product_row['category_id'];
        $subcategory = $product_row['subcategory_id'];
        $supplierid = $product_row['supplier_id'];
        $status = $product_row['product_status_id'];
        
        // SQL query to update the product info in the database
        $sqlupdate = "UPDATE tblproductinfo SET product_name='$productname', product_price=$price, product_status_id=$status,
                      product_img='{$image}', supplier_id=$supplierid, category_id=$category, subcategory_id=$subcategory, quantity=$quantity
                      WHERE product_id = $product_id";
        
        // execute SQL query
        if ($conn->query($sqlupdate) === TRUE) {
          $_SESSION['status'] = "Query Successful";
          header('location:../mInventory.php');
        } else {
          echo "Error updating product info: " . $conn->error;
        }
      } else {
        echo "Please choose an image to upload";
      }
}