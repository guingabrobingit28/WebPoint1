<?php
session_start();

require_once('connection.php');

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

function addProduct($conn){
    

    if(getimagesize($_FILES['imagefile']['tmp_name']) == false) {
        echo "<h2>Select Image</h2>";
    } else {
        if(isset($_FILES['imagefile'])) {
            // get image data from file
            $image = $_FILES['imagefile']['name'];
            $target_dir = "../admImages/products/";
            $target_file = $target_dir . basename($image);
            $target_dir2 = "./admImages/products/";
            $target_file2 = $target_dir2 . basename($image);
    
            // escape special characters in image data
            //$image = $conn->real_escape_string($image);
    
            $productname = $_POST['productname'];
            $price = $_POST['price'];
            $quantity = $_POST['quantity'];
            $category = $_POST['category'];
            $supplierid = $_POST['supplierid'];
            $status = $_POST['status'];
            $criticalValue = $_POST['criticalValue'];

            
            
            // SQL query to insert image data into database
            $sqlinsert = "INSERT INTO tblproductinfo (product_name, product_price, product_status_id, img_path, supplier_id, category_id, quantity, critical_value) 
                          VALUES ('$productname', $price, $status, '{$target_file2}', $supplierid, $category, $quantity, $criticalValue)";
    
            // execute SQL query
            if(mysqli_query($conn, $sqlinsert)) {
                $_SESSION['status'] = "Query Successful";
                header('location:../sproduct.php');
                move_uploaded_file($_FILES['imagefile']['tmp_name'], $target_file);
            } else {
                echo "Error inserting image: " . mysqli_error($conn);
            }
        } else {
            echo "Please choose an image to upload";
        }
    }
    
}


function addCategory($conn){

    if (isset($_GET['alert_message'])) {
        // escape the message to prevent XSS attacks
        $alert_message = htmlspecialchars($_GET['alert_message']);
        // display the alert message
        echo "<script>alert('$alert_message');</script>";
      }

    if(getimagesize($_FILES['imagecat']['tmp_name']) == false){
        
        echo "<h2>Please select Image</h2>";

    }else{
    if(isset($_FILES['imagecat'])) {
	// get image data from file
        $image = $_FILES['imagecat']['name'];
        $target_dir = "../admImages/category/";
        $target_file = $target_dir . basename($image);
        $target_dir2 = "./admImages/category/";
        $target_file2 = $target_dir2 . basename($image);

	// escape special characters in image data
        $categoryname = $_POST['namecat'];

	// SQL query to insert image data into database
	    //$sql = "INSERT INTO images (image_name, image_data) VALUES ('{$_FILES['image']['name']}', '{$imageData}')";
        $sqlQueCat = "INSERT INTO tblcategory(category_name, img_path) VALUES ('$categoryname','{$target_file2}')";

	// execute SQL query
	        if ($conn->query($sqlQueCat) === TRUE) {
                $_SESSION['status'] = "Query Successful";
                header('location:../category.php');
                move_uploaded_file($_FILES['imagecat']['tmp_name'], $target_file);
	        } else {
	        echo "Error inserting image: " . $conn->error;
	        }
        }
        else {
	        echo "Please choose an image to upload";
        }
    }
}

function addSubcategory($conn){
    if (isset($_GET['alert_message'])) {
        // escape the message to prevent XSS attacks
        $alert_message = htmlspecialchars($_GET['alert_message']);
        // display the alert message
        echo "<script>alert('$alert_message');</script>";
      }

        $subcategoryname = $_POST['subcategory'];
        $categoryname = $_POST['category'];

	// SQL query to insert image data into database
	    //$sql = "INSERT INTO images (image_name, image_data) VALUES ('{$_FILES['image']['name']}', '{$imageData}')";
        $sqlQueSub = "INSERT INTO tblsubcategory(Subcategory_name) VALUES ('$subcategoryname')";

	// execute SQL query
	    if ($conn->query($sqlQueSub) === TRUE) {
            $last_insert_id = mysqli_insert_id($conn);
            $sqlAttribute = "INSERT INTO tblattributes(category_id, subcategory_id)
             VALUES ($categoryname,$last_insert_id)";
             if($conn->query($sqlAttribute) === TRUE){
                $_SESSION['status'] = "Query Successful";
                header('location:../subcategory.php');
             }else{
                echo "Error inserting Data: " . $conn->error;
             }
            
    
	    } else {
	        echo "Error inserting Data: " . $conn->error;
	        }
}

function addQrcodeImage($conn){
    if (isset($_GET['alert_message'])) {
        // escape the message to prevent XSS attacks
        $alert_message = htmlspecialchars($_GET['alert_message']);
        // display the alert message
        echo "<script>alert('$alert_message');</script>";
      }

    if(getimagesize($_FILES['imageqr']['tmp_name']) == false){
        
        echo "<h2>Please select Image</h2>";

    }else{
    if(isset($_FILES['imageqr'])) {
	// get image data from file
        $image = $_FILES['imageqr']['name'];
        $target_dir = "../admImages/payMethod/";
        $target_file = $target_dir . basename($image);
        $target_dir2 = "./admImages/payMethod/";
        $target_file2 = $target_dir2 . basename($image);

        $qrname = $_POST['qrname'];

	// SQL query to insert image data into database
	    //$sql = "INSERT INTO images (image_name, image_data) VALUES ('{$_FILES['image']['name']}', '{$imageData}')";
        $sqlQueQr = "INSERT INTO tblqrpayment(payment_name, paymentqr_img_path) VALUES ('$qrname','{$target_file2}')";

	// execute SQL query
	        if ($conn->query($sqlQueQr) === TRUE) {
                $_SESSION['status'] = "Query Successful";
                header('location:../qrpayment.php');
                move_uploaded_file($_FILES['imageqr']['tmp_name'], $target_file);
    
	        } else {
	        echo "Error inserting image: " . $conn->error;
	        }
        }
        else {
	        echo "Please choose an image to upload";
        }
    }
}

function update($conn){

    if(getimagesize($_FILES['imagefile']['tmp_name']) == false){
        
        echo "<h2>select Image</h2>";

    }
    else{
        
        if(isset($_FILES['imagefile'])) {
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
        
            // SQL query to insert image data into database
            $sqlupdate = "UPDATE tblproductinfo SET product_name='$productname', product_price=$price, product_status_id=$status,
            product_img='{$image}', supplier_id=$supplierid, category_id=$category, subcategory_id=$subcategory, quantity=$quantity
            WHERE product_id = $product_id";
        
            // execute SQL query
                    if ($conn->query($sqlupdate) === TRUE) {
                        $_SESSION['status'] = "Query Successful";
                        header('location:../mInventory.php');
            
                    } else {
                    echo "Error inserting image: " . $conn->error;
                    }
                }
                else {
                    echo "Please choose an image to upload";
                }
    }
}

function delProduct($conn){
    // delete inventory item
        $product_id = $_POST['pId'];

        $sql = "DELETE FROM tblproductinfo WHERE product_id= $product_id";

        if (mysqli_query($conn, $sql)) {
            $message = "Record deleted successfully";
            echo "<script type='text/javascript'>alert('$message');</script>";
            header('location:../mInventory.php');
        } else {
            echo "Error deleting record: " . mysqli_error($conn);
        }
}

function addServices($conn){
    if (isset($_GET['alert_message'])) {
        // escape the message to prevent XSS attacks
        $alert_message = htmlspecialchars($_GET['alert_message']);
        // display the alert message
        echo "<script>alert('$alert_message');</script>";
      }

        $serviceName = $_POST['serviceName'];
        $servicePrice = $_POST['servicePrice'];

	// SQL query to insert image data into database
        $sqlQueSer = "INSERT INTO tblmaintenanceservice(Service_Name, Service_Price) VALUES ('$serviceName',$servicePrice);";

	// execute SQL query
	    if ($conn->query($sqlQueSer) === TRUE) {
            $_SESSION['status'] = "Query Successful";
            header('location:../addService.php');
    
	    } else {
	        echo "Error inserting image: " . $conn->error;
	        }
}
function addSupplier($conn){
    if (isset($_GET['alert_message'])) {
        // escape the message to prevent XSS attacks
        $alert_message = htmlspecialchars($_GET['alert_message']);
        // display the alert message
        echo "<script>alert('$alert_message');</script>";
      }

        $supplierName = $_POST['supplierName'];
        $contactNumber = $_POST['contactNumber'];

	// SQL query to insert image data into database
        $sqlQueSup = "INSERT INTO tblsupplierinfo(Supplier_name, Supplier_Contact_Number) VALUES ('$supplierName',$contactNumber);";

	// execute SQL query
	    if ($conn->query($sqlQueSup) === TRUE) {
            $_SESSION['status'] = "Added Successful";
            header('location:../supplier.php');
    
	    } else {
	        echo "Error inserting image: " . $conn->error;
	        }
}

function addStatus($conn){
    if (isset($_GET['alert_message'])) {
        // escape the message to prevent XSS attacks
        $alert_message = htmlspecialchars($_GET['alert_message']);
        // display the alert message
        echo "<script>alert('$alert_message');</script>";
      }

        $statusName = $_POST['statusName'];

	// SQL query to insert image data into database
        $sqlQueSta = "INSERT INTO tblstatus(status_name) VALUES ('$statusName');";

	// execute SQL query
	    if ($conn->query($sqlQueSta) === TRUE) {
            $_SESSION['status'] = "Added Successful";
            header('location:../status.php');
    
	    } else {
	        echo "Error inserting image: " . $conn->error;
	        }
}
function addTrackStatus($conn){
    if (isset($_GET['alert_message'])) {
        // escape the message to prevent XSS attacks
        $alert_message = htmlspecialchars($_GET['alert_message']);
        // display the alert message
        echo "<script>alert('$alert_message');</script>";
      }

        $trackStatusName = $_POST['trackStatusName'];

	// SQL query to insert image data into database
        $sqlQueSta = "INSERT INTO tbltrackstatus(trans_order_status_name) VALUES ('$trackStatusName');";

	// execute SQL query
	    if ($conn->query($sqlQueSta) === TRUE) {
            $_SESSION['status'] = "Added Successful";
            header('location:../trackstatus.php');
    
	    } else {
	        echo "Error inserting image: " . $conn->error;
	        }
}
function addDeliver($conn){
    if (isset($_GET['alert_message'])) {
        // escape the message to prevent XSS attacks
        $alert_message = htmlspecialchars($_GET['alert_message']);
        // display the alert message
        echo "<script>alert('$alert_message');</script>";
      }

        $deliverName = $_POST['deliverName'];

	// SQL query to insert image data into database
        $sqlQueDel = "INSERT INTO tbldelivermethod(deliver_method_name) VALUES ('$deliverName');";

	// execute SQL query
	    if ($conn->query($sqlQueDel) === TRUE) {
            $_SESSION['status'] = "Added Successful";
            header('location:../delivermethod.php');
    
	    } else {
	        echo "Error inserting image: " . $conn->error;
	        }
}
function addPayment($conn){
    if (isset($_GET['alert_message'])) {
        // escape the message to prevent XSS attacks
        $alert_message = htmlspecialchars($_GET['alert_message']);
        // display the alert message
        echo "<script>alert('$alert_message');</script>";
      }

        $paymentName = $_POST['paymentName'];

	// SQL query to insert image data into database
        $sqlQuePay = "INSERT INTO tblpaymentmethod(payment_method_name) VALUES ('$paymentName');";

	// execute SQL query
	    if ($conn->query($sqlQuePay) === TRUE) {
            $_SESSION['status'] = "Added Successful";
            header('location:../paymethod.php');
    
	    } else {
	        echo "Error inserting image: " . $conn->error;
	        }
}
function addTempService($conn){
    $serviceId = $_POST['serviceId'];

  // Remove the selected option from the session
  unset($_SESSION['selected_option'][$serviceId]);

    // Get selected option value
    $option_id = $_POST['option'];

    // Retrieve selected option from database
    $sql = "SELECT * FROM tblmaintenanceservice WHERE Service_id = $option_id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    // Save selected option to session
    $_SESSION['selected_option'][$option_id] = $row;
}
function addReturnedProduct($conn){
    if(getimagesize($_FILES['imagefile']['tmp_name']) == false) {
        echo "<h2>Select Image</h2>";
    } else {
        if(isset($_FILES['imagefile'])) {
            // get image data from file
            $image = $_FILES['imagefile']['name'];
            $target_dir = "../admImages/productreturn/";
            $target_file = $target_dir . basename($image);
            $target_dir2 = "./admImages/productreturn/";
            $target_file2 = $target_dir2 . basename($image);
    
            // escape special characters in image data
            //$image = $conn->real_escape_string($image);
            $orderNumber= $_POST['orderNumber'];
            $productname = $_POST['productName'];
            $quantity = $_POST['quantity'];
            $returnStatement = $_POST['returnStatement'];
            
    
            // SQL query to insert image data into database
            $sqlinsert = "INSERT INTO tblproductreturn(customer_order_id, product_name, quantity, proof_condition_img_path, return_statement)
             VALUES ($orderNumber,'$productname',$quantity,'$target_file2','$returnStatement');";
    
            // execute SQL query
            if(mysqli_query($conn, $sqlinsert)) {
                $_SESSION['status'] = "Query Successful";
                header('location:../returnproduct.php');
                move_uploaded_file($_FILES['imagefile']['tmp_name'], $target_file);
            } else {
                echo "Error inserting image: " . mysqli_error($conn);
            }
        } else {
            echo "Please choose an image to upload";
        }
    }
}

function addExcProduct($conn){
    if (isset($_GET['alert_message'])) {
        // escape the message to prevent XSS attacks
        $alert_message = htmlspecialchars($_GET['alert_message']);
        // display the alert message
        echo "<script>alert('$alert_message');</script>";
      }

      $orderNumber= $_POST['orderNumber'];
      $productname = $_POST['productNameExc'];
      $quantity = $_POST['quantity'];

	// SQL query to insert image data into database
        $sqlExcProduct = "INSERT INTO tblexchangeproduct(customer_order_id, product_name_exc, quantity, return_datetime)
         VALUES ($orderNumber,'$productname',$quantity,NOW());";

	// execute SQL query
	    if ($conn->query($sqlExcProduct) === TRUE) {
            $_SESSION['status'] = "Added Successful";
            header('location:../exchangeProduct.php');
    
	    } else {
	        echo "Error inserting image: " . $conn->error;
	        }
}
function addCustomerType($conn){
    if (isset($_GET['alert_message'])) {
        // escape the message to prevent XSS attacks
        $alert_message = htmlspecialchars($_GET['alert_message']);
        // display the alert message
        echo "<script>alert('$alert_message');</script>";
      }

        $customerTypeName = $_POST['customerTypeName'];

	// SQL query to insert image data into database
        $sqlCusType = "INSERT INTO tblcustomertype(customer_type_name) VALUES ('$customerTypeName');";

	// execute SQL query
	    if ($conn->query($sqlCusType) === TRUE) {
            $_SESSION['status'] = "Added Successful";
            header('location:../customerType.php');
    
	    } else {
	        echo "Error inserting image: " . $conn->error;
	        }
}
// add
if (isset($_POST['save'])){
    addProduct($conn);
}

if (isset($_POST['save1'])){
    addCategory($conn);
}

if (isset($_POST['save2'])){
    addSubcategory($conn);
}
if (isset($_POST['saveQr'])){
    addQrcodeImage($conn);
}
if (isset($_POST['saveService'])){
    addServices($conn);
}

if (isset($_POST['saveTrackStatus'])){
    addTrackStatus($conn);
}
if (isset($_POST['saveSupp'])){
    addSupplier($conn);
}
if (isset($_POST['saveStatus'])){
    addStatus($conn);
}
if (isset($_POST['saveDeliver'])){
    addDeliver($conn);
}
if (isset($_POST['savePayment'])){
    addPayment($conn);
}
if (isset($_POST['saveReturn'])){
    addReturnedProduct($conn);
}
if (isset($_POST['saveExcProduct'])){
    addExcProduct($conn);
}
if (isset($_POST['saveCustomerType'])){
    addCustomerType($conn);
}
// update
if (isset($_POST['update'])) {
    update($conn);
}
//delete
if (isset($_POST['delete'])) {
    delProduct($conn);
}

// Temporary stored data
if (isset($_POST['serviceId'])) {
    addTempService($conn);
}

$conn->close();