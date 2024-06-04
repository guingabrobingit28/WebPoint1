<?php
session_start();

require_once('connection.php');
require_once('../TCPDF-main/tcpdf.php');
include ("../functions.php");
require __DIR__ . '../vendor/autoload.php';


$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$user_data = null;
$logged_in = isset($_SESSION['User_id']);

if ($logged_in) {
    $user_data = check_login($conn);
}
$options = array(
    'cluster' => 'eu',
    'useTLS' => true
  );
  $pusher = new Pusher\Pusher(
    'c8c51b636e960568a241',
    '99497425c7600be45d8b',
    '1595129',
    $options
  );

if (isset($_POST['checkout'])){
    $payment_method_id = $_POST['payment_method_id'];
    $deliver_method_id = $_POST['deliver_method_id'];
    $discount = $_POST['discount2'];
    $subtotal = $_POST['subtotal'];
    $deliver_cost = $_POST['deliver_cost'];
    $customerLastName = $_POST['customerLastName'];
    $customerFirstName = $_POST['customerFirstName'];
    $customerContactNumber = $_POST['customerContactNumber'];
    $customerEmailAddress = $_POST['customerEmailAddress'];
    $streetAddress = $_POST['streetAddress'];
    $barangay = $_POST['barangay'];
    $municipality = $_POST['municipality'];
    $province = $_POST['province'];
    $zipcode = $_POST['zipcode'];
    $total = $_POST['total'];
    $payment_amount = $_POST['payment_amount'];
    $change = $_POST['customerChange'];
    $dpDate = $_POST['pdDate'];
    $productIds = $_POST['product_id2'];
    $quantities = $_POST['quantity2'];

    // var_dump($customerLastName,$customerFirstName,$customerContactNumber,$customerEmailAddress,$streetAddress,$barangay,$municipality,$province,$region,$zipcode);
    if($deliver_method_id == 1){
        $sql = "INSERT INTO tblcustomertransactionorder (subtotal, discount, delivery_method_id, delivery_fee, payment_amount, total_amount, customer_change, payment_method_id, transorder_datetime,pickup_date)
            VALUES ($subtotal, $discount, $deliver_method_id, 0, $payment_amount, $total, $change, $payment_method_id, NOW(),'$dpDate')";     
        if (mysqli_query($conn, $sql)) {
            $last_insert_id = mysqli_insert_id($conn);
            $sqlTrack = "INSERT INTO tbltrackorders(customer_order_id, payment_method_id, track_order_date,
            delivery_method_id, track_status_id)
            SELECT ct.customer_trans_ord_id, $payment_method_id, '$dpDate', $deliver_method_id, 1
            FROM tblcustomertransactionorder ct
            WHERE ct.customer_trans_ord_id = LAST_INSERT_ID();";

            sleep(1);
            // return $last_insert_id;
            if(mysqli_query($conn, $sqlTrack)){
                $data['message'] = 'New order received!';
                $pusher->trigger('my-channel', 'my-event', $data);
            }
            else {
                echo "Error: " . $sqlTrack . "<br>" . mysqli_error($conn);
            }
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
        
        $last_insert_id1 = $last_insert_id;
        //$conn->rollback();
        for ($i = 1; $i < count($productIds); $i++) {
            $productId = mysqli_real_escape_string($conn, $productIds[$i]);
            $quantity = mysqli_real_escape_string($conn, $quantities[$i]);

            $sqlInv = "SELECT quantity FROM tblproductinfo WHERE product_id = $productId";
            $resultInv = mysqli_query($conn, $sqlInv);
            $rowInv = mysqli_fetch_assoc($resultInv);
            $currentQuantity = $rowInv['quantity'];
        
            // Subtract quantity ordered from current quantity
            $newQuantity = $currentQuantity - $quantity;
        
            // Update inventory with new quantity
            $sqlQuantityUp = "UPDATE tblproductinfo SET quantity = $newQuantity WHERE product_id = $productId";
            mysqli_query($conn, $sqlQuantityUp);
            
            $sqlord = "INSERT INTO tblcustomerorders (customer_trans_ord_id, product_id, quantity)
                VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sqlord);
            $stmt->bind_param('iii', $last_insert_id1, $productId, $quantity);
            $stmt->execute();
            if($stmt->affected_rows === 0){
                // Error inserting into database
                echo "Error: " . $sqlord . "<br>" . mysqli_error($conn);
            }else{
                //$sqlQuantityUp = "";
            }
          }
         
          $output = '';

          $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

          // set document information
          $pdf->SetCreator(PDF_CREATOR);
          $pdf->SetAuthor('FIXPOINT');
          $pdf->SetTitle('Receipt');
          $pdf->SetSubject('Transaction Information');

          // set header and footer fonts
          $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
          $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

          // set default monospaced font
          $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

          // set margins
          $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
          $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
          $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

          // set auto page breaks
          $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

          // set font
          $pdf->SetFont('helvetica', '', 12);

          // add a page
          $content = '';

          $content .= '
          <style>
          th, td {
              text-align:center;
              border-style: none;

          }
          table {
              width: 100%;
              cellpadding:5;
          }
          </style>
              <h3 align="center">FixPoint Reciept</h3>
              <div style="display: flex; justify-content: space-between;">
              <div>  
            <b>Order no. </b>' .$last_insert_id; 
        $content .= '</div><div>
        <b style ="margin-left: 100px;">Serve By: </b>' .($logged_in ? $user_data['Username'] : '') .'<br>
        </div>
        </div>
            
              <table border-style>
                  <tr>
                      <th width="20%">Item no.</th>
                      <th width="55%">Product name</th>
                      <th width="10%">Qty</th>
                      <th width="15%">Price</th>
                  </tr>';
                  $productNames = array();
                  $productPrices = array();
                  $productIds1 = array();
                  $quantities1 = array();
                  for ($j = 1; $j < count($productIds); $j++) {
                      $productId = mysqli_real_escape_string($conn, $productIds[$j]);
                      $quantity = mysqli_real_escape_string($conn, $quantities[$j]);
                      $quantities1[] = $quantity;
                      
                      $productNameQuery = "SELECT product_id, product_name, product_price FROM tblproductinfo WHERE product_id = '$productId'";
                      $productNameResult = mysqli_query($conn, $productNameQuery);
                  
                      if (!$productNameResult) {
                          die("Error in productNameQuery: " . mysqli_error($conn));
                      }
                  
                      while ($productNameRow = mysqli_fetch_assoc($productNameResult)) {
                          $productIds1[] = $productNameRow['product_id'];
                          $productNames[] = $productNameRow['product_name'];
                          $productPrices[] = $productNameRow['product_price'];
                          
                      }
                  }
                  
                  // Process the product names and prices outside of the loop
                  for ($i = 0; $i < count($productNames); $i++) {
                      $productId = $productIds1[$i];
                      $productName = $productNames[$i];
                      $productPrice = $productPrices[$i];
                      $quantity = $quantities1[$i];

                      //$priceQty = (float)$productPrice * (int)$quantity[$i];
                      $priceQty = (float)$productPrice * (int)$quantity;
                      $content .='
                      <tr>
                          <td>'.$productId.'</td>
                          <td>'.$productName.'</td>
                          <td>'.$quantity.'</td>
                          <td>'.number_format($priceQty, 2).'</td>
                      </tr>';

                  }
                  
                      

              
              $paymentName = "SELECT `payment_method_name` FROM `tblpaymentmethod` WHERE `payment_method_id` = $payment_method_id;";
              $paymentResult = mysqli_query($conn,$paymentName);
              if (!$paymentResult) {
                  die("Error in paymentName query: " . mysqli_error($conn));
              }
              $paymentRow = mysqli_fetch_assoc($paymentResult);
              $paymentMethod = $paymentRow['payment_method_name'];

              $deliverName = "SELECT deliver_method_name FROM tbldelivermethod WHERE deliver_method_id = $deliver_method_id";
              $deliverResult = mysqli_query($conn,$deliverName);
              if (!$deliverResult) {
                  die("Error in deliverName query: " . mysqli_error($conn));
              }
              $deliverRow = mysqli_fetch_assoc($deliverResult);
              $deliverMethod = $deliverRow['deliver_method_name'];
          $content .='
              </table>
              <div class="horizontal">
                  <hr style="border-color: black !important;border-style: solid; border-width: 1px">
              </div>
              <div class="subtotal" name="subtotal" id="subtotal1">Subtotal: PHP '.$subtotal.' </div>
              <div class="discount" name="discount">Discount: PHP '.$discount.' </div>
              <div class="pMethod">Payment Method: '.$paymentMethod.' </div>
              <div class="date">Pickup Date: '.$dpDate.' </div>
              <div class="dMethod">Deliver Method: '.$deliverMethod.' </div>
              <div class="dMethod">Deliver Cost: PHP '.$deliver_cost.' </div>
              <div class="pAmount">Amount Received: PHP '.$payment_amount.' </div> 
              <div class="total" name="total">Total: PHP '.$total.' </div>
              <div class="change" name="customerChange">Change: PHP'.$change.' </div>
          ';
          $pdf->AddPage();
          $pdf->writeHTML($content, true, false, true, false, '');
          $pdf->Output("reciept.pdf", "I");
    }
    else if($deliver_method_id == 2){
        $sql = "INSERT INTO tblcustomertransactionorder (subtotal, discount, delivery_method_id, delivery_fee, payment_amount, total_amount, customer_change, payment_method_id, transorder_datetime,delivery_date)
            VALUES ($subtotal, $discount, $deliver_method_id, $deliver_cost, $payment_amount, $total, $change, $payment_method_id, NOW(),'$dpDate')";
        if (mysqli_query($conn, $sql)) {
            $last_insert_id = mysqli_insert_id($conn);
            $sqlTrack = "INSERT INTO tbltrackorders(customer_order_id, payment_method_id, track_order_date,
            delivery_method_id, track_status_id)
            SELECT ct.customer_trans_ord_id, $payment_method_id, $dpDate, $deliver_method_id, 1
            FROM tblcustomertransactionorder ct
            WHERE ct.customer_trans_ord_id = LAST_INSERT_ID();";
            sleep(1);
            if(mysqli_query($conn, $sqlTrack)){

            }
            else {
                echo "Error: " . $sqlTrack . "<br>" . mysqli_error($conn);
            }
            
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }

        $last_insert_id1 = $last_insert_id;
        for ($i = 1; $i < count($productIds); $i++) {
            $productId = mysqli_real_escape_string($conn, $productIds[$i]);
            $quantity = mysqli_real_escape_string($conn, $quantities[$i]);

            $sqlInv = "SELECT quantity FROM tblproductinfo WHERE product_id = $productId";
            $resultInv = mysqli_query($conn, $sqlInv);
            $rowInv = mysqli_fetch_assoc($resultInv);
            $currentQuantity = $rowInv['quantity'];
        
            // Subtract quantity ordered from current quantity
            $newQuantity = $currentQuantity - $quantity;
        
            // Update inventory with new quantity
            $sqlQuantityUp = "UPDATE tblproductinfo SET quantity = $newQuantity WHERE product_id = $productId";
            mysqli_query($conn, $sqlQuantityUp);
            
            $sqlord = "INSERT INTO tblcustomerorders (customer_trans_ord_id, product_id, quantity)
                VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sqlord);
            $stmt->bind_param('iii', $last_insert_id1, $productId, $quantity);
            $stmt->execute();
            if($stmt->affected_rows === 0){
                // Error inserting into database
                echo "Error: " . $sqlord . "<br>" . mysqli_error($conn);
            }

          
            
          }
          if($customerContactNumber && preg_match("/^(?:\+639|09)\d{9}$/",$customerContactNumber)){
            $sqlCustomer = "INSERT INTO tblcustomerinfo(customer_lastname, customer_firstname, customer_email, customer_contact_no, customer_type_id)
           VALUES (?,?,?,?,2);";
           $stmt = $conn->prepare($sqlCustomer);
           $stmt->bind_param('sssi',$customerLastName,$customerFirstName,$customerEmailAddress,$customerContactNumber);
           $stmt->execute();
           if($stmt->affected_rows === 0){
                echo "Error: " . $sqlCustomer . "<br>" . mysqli_error($conn);
           }else{
                $last_insert_id2 = mysqli_insert_id($conn);
                $last_insert_id3 = $last_insert_id2;
                $sqlAddress = "INSERT INTO tbladdress(street_address, barangay_id, municipality_id, province_id, zipcode, customer_id)
                 VALUES (?,?,?,?,?,?);";
                $stmt1 = $conn->prepare($sqlAddress);
                $stmt1->bind_param('siiiii',$streetAddress,$barangay,$municipality,$province,$zipcode,$last_insert_id3);
                $stmt1->execute();
                if($stmt1->affected_rows === 0){
                    echo "Error: " . $sqlAddress . "<br>" . mysqli_error($conn);
               }else{
                //     $last_insert_id4 = mysqli_insert_id($conn);
                //     $updateCustomer = "UPDATE tblcustomerinfo SET address_id=? WHERE ?";
                //     $stmt2 = $conn->prepare($updateCustomer);
                //     $stmt2->bind_param('ii',$last_insert_id4,$last_insert_id3);
                //     $stmt2->execute();
                //     if($stmt2->affected_rows === 0){
                //         echo "Error: " . $updateCustomer . "<br>" . mysqli_error($conn);
                //    }
               }
           }
          }
          
           
          $output = '';

          $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

          // set document information
          $pdf->SetCreator(PDF_CREATOR);
          $pdf->SetAuthor('FIXPOINT');
          $pdf->SetTitle('Reciept');
          $pdf->SetSubject('Transaction Information');

          // set header and footer fonts
          $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
          $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

          // set default monospaced font
          $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

          // set margins
          $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
          $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
          $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

          // set auto page breaks
          $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

          // set font
          $pdf->SetFont('helvetica', '', 12);

          // add a page
          $content = '';

          $content .= '
          <style>
          th, td {
              text-align:center;
              border-style: none;

          }
          table {
              width: 100%;
              cellpadding:5;
          }
          </style>
              <h3 align="center">FixPoint Reciept</h3>
              <div style="display: flex; justify-content: space-between;">
              <div>  
            <b>Order no. </b>' .$last_insert_id; 
        $content .= '</div><div>
        <b style ="margin-left: 100px;">Serve By: </b>' .($logged_in ? $user_data['Username'] : '') .'<br>
        </div>
        </div>
              <table border-style>
                  <tr>
                      <th width="20%">Item no.</th>
                      <th width="55%">Product name</th>
                      <th width="10%">Qty</th>
                      <th width="15%">Price</th>
                  </tr>';
                  $productNames = array();
                  $productPrices = array();
                  $productIds1 = array();
                  $quantities1 = array();
                  for ($j = 1; $j < count($productIds); $j++) {
                      $productId = mysqli_real_escape_string($conn, $productIds[$j]);
                      $quantity = mysqli_real_escape_string($conn, $quantities[$j]);
                      $quantities1[] = $quantity;
                      
                      $productNameQuery = "SELECT product_id, product_name, product_price FROM tblproductinfo WHERE product_id = '$productId'";
                      $productNameResult = mysqli_query($conn, $productNameQuery);
                  
                      if (!$productNameResult) {
                          die("Error in productNameQuery: " . mysqli_error($conn));
                      }
                  
                      while ($productNameRow = mysqli_fetch_assoc($productNameResult)) {
                          $productIds1[] = $productNameRow['product_id'];
                          $productNames[] = $productNameRow['product_name'];
                          $productPrices[] = $productNameRow['product_price'];
                          
                      }
                  }
                  
                  // Process the product names and prices outside of the loop
                  for ($i = 0; $i < count($productNames); $i++) {
                      $productId = $productIds1[$i];
                      $productName = $productNames[$i];
                      $productPrice = $productPrices[$i];
                      $quantity = $quantities1[$i];

                      //$priceQty = (float)$productPrice * (int)$quantity[$i];
                      $priceQty = (float)$productPrice * (int)$quantity;
                      $content .='
                      <tr>
                          <td>'.$productId.'</td>
                          <td>'.$productName.'</td>
                          <td>'.$quantity.'</td>
                          <td>'.number_format($priceQty, 2).'</td>
                      </tr>';

                  }
                  
                      

              
              $paymentName = "SELECT `payment_method_name` FROM `tblpaymentmethod` WHERE `payment_method_id` = $payment_method_id;";
              $paymentResult = mysqli_query($conn,$paymentName);
              if (!$paymentResult) {
                  die("Error in paymentName query: " . mysqli_error($conn));
              }
              $paymentRow = mysqli_fetch_assoc($paymentResult);
              $paymentMethod = $paymentRow['payment_method_name'];

              $deliverName = "SELECT deliver_method_name FROM tbldelivermethod WHERE deliver_method_id = $deliver_method_id";
              $deliverResult = mysqli_query($conn,$deliverName);
              if (!$deliverResult) {
                  die("Error in deliverName query: " . mysqli_error($conn));
              }
              $deliverRow = mysqli_fetch_assoc($deliverResult);
              $deliverMethod = $deliverRow['deliver_method_name'];
          $content .='
              </table>
              <div class="horizontal">
                  <hr style="border-color: black !important;border-style: solid; border-width: 1px">
              </div>
              <div class="subtotal" name="subtotal" id="subtotal1">Subtotal: PHP '.$subtotal.' </div>
              <div class="discount" name="discount">Discount: PHP '.$discount.' </div>
              <div class="pMethod">Payment Method: '.$paymentMethod.' </div>
              <div class="date">Delivery Date: '.$dpDate.' </div>
              <div class="dMethod">Deliver Method: '.$deliverMethod.' </div>
              <div class="dMethod">Deliver Cost: PHP '.$deliver_cost.' </div>
              <div class="pAmount">Amount Received: PHP '.$payment_amount.' </div> 
              <div class="total" name="total">Total: PHP '.$total.' </div>
              <div class="change" name="customerChange">Change: PHP'.$change.' </div>
          ';
          $pdf->AddPage();
          $pdf->writeHTML($content, true, false, true, false, '');
          $pdf->Output("reciept.pdf", "I");
    }
    else{
        echo "Wrong query not inserted";
    }
mysqli_close($conn);
    
}

function generatePDF1($conn){
    $payment_method_id = $_POST['payment_method_id'];
    $deliver_method_id = $_POST['deliver_method_id'];
    $discount = $_POST['discount2'];
    $subtotal = $_POST['subtotal'];
    $deliver_cost = $_POST['deliver_cost'];
    $total = $_POST['total'];
    $payment_amount = $_POST['payment_amount'];
    $change = $_POST['customerChange'];
    $dpDate = $_POST['pdDate'];
    $productIds = $_POST['product_id2'];
    $quantities = $_POST['quantity2'];

    
}





   