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
    <title>Admin Homepage</title>
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
                            <h6 class="fw-normal text-dark mb-0">Profile updated</h6>
                            <small class="text-dark">15 minutes ago</small>
                        </a>
                        <hr class="dropdown-divider">
                        <a href="#" class="dropdown-item">
                            <h6 class="fw-normal text-dark mb-0">New user added</h6>
                            <small class="text-dark">15 minutes ago</small>
                        </a>
                        <hr class="dropdown-divider">
                        <a href="#" class="dropdown-item">
                            <h6 class="fw-normal text-dark mb-0">Password changed</h6>
                            <small class="text-dark">15 minutes ago</small>
                        </a>
                        <hr class="dropdown-divider">
                        <a href="#" class="dropdown-item text-dark text-center">See all notifications</a>
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
            <!--POS body-->
        <div class="container-fluid pt-0 px-4">
            <div class="row vh-120 sidebarGraColor rounded align-items-center justify-content-between mx-0">
                <div class="posContainer">
                    <div class="category">
                        <div class="logo">
                            <span>Category</span>
                        </div>
                        <form method="post">
                        <div class="btnContainer">
                            <div class="btnPosition btn-group-vertical me-2 ">
                            <button type="submit" class="btn btn-primary" name="showAll">Show All</button>
                        <?php
                        // Retrieve the list of categories from the database
                        $category_query = "SELECT category_id, category_name FROM tblcategory";
                        $category_result = $conn->query($category_query);
                        while ($category_row = $category_result->fetch_assoc()):?>
                        <button type="submit" class="btn btn-primary" value="<?php echo $category_row['category_id']?>" name="category"><?php echo $category_row['category_name']?></button>
                        <?php endwhile; ?>
                            </div>
                        </div>
                    </div>
                    <?php
                        
                        if(isset($_POST['category'])){
                          $category = $_POST['category'];
                          $query = "SELECT * FROM tblproductinfo WHERE category_id = $category;";
                          $result = mysqli_query($conn, $query);
                        }
                        else if(isset($_POST['showAll'])){
                        $query = "SELECT * FROM tblproductinfo;";
                        $result = mysqli_query($conn, $query);
                      }else{
                        $query = "SELECT * FROM tblproductinfo;";
                        $result = mysqli_query($conn, $query);
                      }
                      

                      if (!$result) {
                        die('Query failed: ' . mysqli_error($conn));
                      }
                      
                      $products = mysqli_fetch_all($result, MYSQLI_ASSOC);
                      if (!is_null($products) && is_array($products)) {
                          foreach ($products as $product) {
                              // your code for displaying each product
                          }
                      }
                      else {
                          echo "No products found.";
                      }
                        
                    ?>
                    </form>
                    <div class="search">
                        <div class="searchBar">
                            <div class="form">
                                <i class="fa-solid fa-magnifying-glass"></i>
                                <input type="text" placeholder="Search">
                                <button type="submit" class="btn btn-primary rounded-pill m-2">Search</button>
                            </div>
                        </div>
                        <h3 class="text-dark p-4"><b>Products</b></h3>
                        
                        <div class="scrollBar">
                            <div class="list" id="listItems">
                            <?php foreach ($products as $product) { ?>
                                <div class="item" data-key="<?php echo $product['product_id']; ?>">
                                <input type="number" class="hidden" name="product_id[]" value="<?php echo $product['product_id']; ?>">
                                    <div class="img">
                                        <img src="<?php echo $product['img_path']; ?>" alt="">
                                        <div class="itemName" name="itemName[]"><?php echo $product['product_name']; ?></div>
                                        <div class="price" name="price[]"><?php echo $product['product_price']; ?></div>
                                        <div class="stock"><i>Stock: <?php echo $product['quantity']; ?></i></div>
                                        <input type="number" name="quantity[]" class="count" min="1" max="<?php echo $product['quantity']; ?>" value="1">
                                        <button class="add btn btn-success m-2"><i class="fas fa-shopping-cart"></i></button>
                                        <button type="button" class="remove btn btn-danger" onclick="remove(<?php echo $product['product_id']; ?>)"><i class="far fa-trash-alt"></i></button>
                                    </div>
                                </div>
                            <?php } ?>

                            </div>
                        </div>
                    </div>
                    <div class="cart">
                        <div class="cartName">Order Lists</div>
                        <div class="scrollBar1">
                            <div class="listCart">

                            </div>
                        </div>
                        <div class="horizontal">
                            <hr style="border-color: black !important;border-style: solid; border-width: 1px">
                        </div>
                        <br>
                        <?php
                        $query1 = 'SELECT * FROM tblpaymentmethod';
                        $result1 = mysqli_query($conn, $query1);
                        
                        if (!$result1) {
                            die('Query failed: ' . mysqli_error($conn));
                        }
                        
                        $pMethod = mysqli_fetch_all($result1, MYSQLI_ASSOC);

                        $query2 = 'SELECT * FROM tbldelivermethod';
                        $result2 = mysqli_query($conn, $query2);
                        
                        if (!$result2) {
                            die('Query failed: ' . mysqli_error($conn));
                        }
                        
                        $dMethod = mysqli_fetch_all($result2, MYSQLI_ASSOC);
                        
                        //mysqli_close($conn);
                        ?>
                        <div class="checkout">
                                <div class="subtotal" name="subtotal" id="subtotal1">Subtotal: </div>
                                <div class="discount" name="discount">Discount:
                                    <input type="number" id="discount1" class="form-control discount-value" name="discount" min="0" placeholder="discount" value="0">
                                </div>
                                <div class="pMethod">Payment Method:<br>
                                    <?php foreach ($pMethod as $method) { ?>
                                        <button type="button" class="btn btn-outline-info m-2 payment-method-button" value="<?php echo $method['payment_method_id']?>"><?php echo $method['payment_method_name']; ?></button>
                                        <?php } ?>
                                </div>
                                <div class="date">Pickup/Delivery Date:
                                    <input type="date" id="pdDate1" name="pdDate" class="form-control">
                                </div>
                                <div class="dMethod">Deliver Method:<br>
                                    <?php foreach ($dMethod as $method) { ?>
                                        <button type="button" id="<?php echo $method['deliver_method_id']?>" class="btn btn-outline-info m-2 delivery-method-button" value="<?php echo $method['deliver_method_id']?>"><?php echo $method['deliver_method_name']; ?></button>
                                        <?php } ?>
                                        <input type="hidden" id="deliver_cost1" class="form-control deliver-value" name="deliver_cost" min="0" placeholder="Deliver Cost">
                                        <input type="hidden" id="customerLastName1" class="form-control deliver-value" name="customerLastName" placeholder="Customer Lastname">
                                        <input type="hidden" id="customerFirstName1" class="form-control deliver-value" name="customerFirstName" placeholder="Customer Firstname">
                                        <input type="hidden" id="customerContactNumber1" class="form-control deliver-value" name="customerContactNumber" placeholder="09xxxxxxxxx">
                                        <input type="hidden" id="customerEmailAddress1" class="form-control deliver-value" name="customerEmailAddress" placeholder="123example@gmail.com (optional)">
                                        <input type="hidden" id="streetAddress1" class="form-control deliver-value" name="streetAddress" placeholder="Street Address">
                                        <?php
                                          $sqlprovince="SELECT * FROM tblprovince";
                                          $province_result = mysqli_query($conn,$sqlprovince);
                                        ?>
                                        <select class="form-select mb-3 deliver-value" name="province" id="province1" aria-label=".form-select-sm example" hidden>
                                        <option value="0" >--Select Province--</option>
                                        <?php
                                        while ($province_row = $province_result->fetch_assoc()):?>
                                        <option value="<?php echo $province_row['province_id']?>"><?php echo $province_row['province_name']?></option>
                                        <?php endwhile; ?>
                                        </select>
                                        
                                        <select class="form-select mb-3 deliver-value" name="municipality" id="municipality1" aria-label=".form-select-sm example" hidden>
                                          <option value="0">--Select Municipality--</option>
                                          <?php
                                          $sql_municipal = "SELECT * FROM tblmunicipality m LEFT JOIN tblprovince p ON m.province_id = p.province_id;";
                                          $municipal_result = mysqli_query($conn,$sql_municipal);
                                        ?>
                                          <?php
                                          while ($municipal_row = $municipal_result->fetch_assoc()):?>
                                      <option value="<?php echo $municipal_row['municipality_id']?>" data-category="<?php echo $municipal_row['province_id']?>"><?php echo $municipal_row['municipality_name']?></option>
                                      <?php endwhile; ?>
                                        </select>
                                      <select class="form-select mb-3 deliver-value" name="barangay" id="barangay1" aria-label=".form-select-sm example" hidden>
                                          <option value="0">--Select Barangay--</option>
                                          <?php
                                          $sql_barangay = "SELECT * FROM tblbarangay b LEFT JOIN tblmunicipality m ON b.municipality_id = m.municipality_id;";
                                          $barangay_result = mysqli_query($conn,$sql_barangay);
                                        ?>
                                          <?php
                                          while ($barangay_row = $barangay_result->fetch_assoc()):?>
                                      <option value="<?php echo $barangay_row['barangay_id']?>" data-category="<?php echo $barangay_row['municipality_id']?>"><?php echo $barangay_row['barangay_name']?></option>
                                      <?php endwhile; ?>
                                      </select>
                                        <!-- <input type="hidden" id="barangay1" class="form-control deliver-value" name="barangay" placeholder="Barangay"> -->
                                        <!-- <input type="hidden" id="municipality1" class="form-control deliver-value" name="municipality" placeholder="Municipality"> -->
                                        <!-- <input type="hidden" id="province1" class="form-control deliver-value" name="province" placeholder="Province"> -->
                                        <input type="hidden" id="zipcode1" class="form-control deliver-value" name="zipcode" placeholder="Zip Code">  
                                </div>
                                <div class="pAmount">Amount Received:
                                    <input type="number" id="payment_amount1" class="form-control payment-value" name="payment_amount" min="0" placeholder="Amount Received" required>
                                </div>
                                
                                <div class="total" name="total">Total: </div>
                                <div class="change" name="customerChange">Change: </div><br>
                                
                                <div class="btnCheckout">
                                    <form action="./php/checkout.php" method="post">
                                        <input type="number" name="product_id2[]">
                                        <input type="number" name="quantity2[]">
                                        
                                        <div class="product-ids"></div>
                                        <div class="quantities"></div>
                                        
                                        <input type="number" name="payment_method_id" id="payment-method-id-input">
                                        <input type="number" name="deliver_method_id" id="deliver-method-id-input">
                                        <input type="number" name="subtotal" id="subtotal2">
                                        <input type="number" name="deliver_cost" id="deliver_cost2">
                                        <input type="number" name="total" id="total2">
                                        <input type="number" name="payment_amount" id="payment_amount2">
                                        <input type="date" name="pdDate" id="pdDate2" >
                                        <input type="number" name="discount2" id="discount2">
                                        <input type="number" name="customerChange" id="customerChange2">
                                        <input type="text" id="customerLastName2"  name="customerLastName" >
                                        <input type="text" id="customerFirstName2"  name="customerFirstName" >
                                        <input type="text" id="customerContactNumber2"  name="customerContactNumber" >
                                        <input type="text" id="customerEmailAddress2" name="customerEmailAddress" >
                                        <input type="text" id="streetAddress2"  name="streetAddress" >
                                        <input type="number" id="barangay2"  name="barangay" >
                                        <input type="number" id="municipality2"  name="municipality" >
                                        <input type="number" id="province2"  name="province" >
                                        <!-- <input type="text" id="region2"  name="region" > -->
                                        <input type="number" id="zipcode2"  name="zipcode">
                                        <!-- <button type="button" name="clear" id="clear" onclick="clear()" class="btn btn-danger rounded-pill mx-auto">Clear</button> -->
                                        <button type="submit" name="checkout" id="checkout" class="btn btn-danger rounded-pill mx-auto">CheckOut</button>
                                    </form>
                                </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
    </div>
</div>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="admjs.js"></script>
<script>
 function populateInputs(item) {
  let productIdInput = item.querySelector('input[name="product_id[]"]');
  let quantityInput = item.querySelector('input[name="quantity[]"]');


  let productId = productIdInput.value;
  let quantity = quantityInput.value;

  let productInputsContainer = document.querySelector('.product-ids');
  let quantityInputsContainer = document.querySelector('.quantities');

  let productInput = document.createElement('input');
  productInput.type = 'number';
  productInput.name = 'product_id2[]';
  productInput.value = productId;

  let quantityInput2 = document.createElement('input');
  quantityInput2.type = 'number';
  quantityInput2.name = 'quantity2[]';
  quantityInput2.value = quantity;


  productInputsContainer.appendChild(productInput);
  quantityInputsContainer.appendChild(quantityInput2);
}   

function cartList() {
  let buttons = document.querySelectorAll('.scrollbar,.add');
  
  buttons.forEach((button) => {
    button.addEventListener('click', function (event) {
      let item = event.target.closest('.item');
      const originalDiv = document.getElementById('listItems');
      var itemNew = item.cloneNode(true);
      itemNew.style.width = originalDiv.offsetWidth + 'px';
      let check = false;

      let listCart = document.querySelectorAll('.cart .item');
      listCart.forEach((cart) => {
        if (cart.getAttribute('data-key') == itemNew.getAttribute('data-key')) {
          check = true;
          cart.classList.add('danger');
          setTimeout(function () {
            cart.classList.remove('danger');
          }, 1000);
        }
      });
      let countInput1 = itemNew.querySelector('.count');
        countInput1.addEventListener('input', function() {
          let quantityInput = itemNew.querySelector('[name="quantity[]"]');
          quantityInput.value = countInput1.value;
        });
      if (check == false) {
        document.querySelector('.listCart').appendChild(itemNew);
        populateInputs(itemNew);
      }

        updateSubtotal(itemNew);
        let countInput = itemNew.querySelector('.count');
        countInput.addEventListener('input', function () {
            updateSubtotal(itemNew);
    })
  })
})
}

cartList();

let countInputs = document.querySelectorAll('.count');
countInputs.forEach((input) => {
  input.addEventListener('input', function (event) {
    let item = event.target.closest('.item');
    updateSubtotal(item);
  });
});

let discountInput = document.querySelector('.discount-value');
    discountInput.addEventListener('input', function () {
  updateSubtotal();
});
let deliverInput = document.querySelector('.deliver-value');
    deliverInput.addEventListener('input', function () {
    updateSubtotal();
});

let paymentInput = document.querySelector('.payment-value');
    paymentInput.addEventListener('input', function () {
    updateSubtotal();
});

function updateSubtotal(item) {
    let cartItems = document.querySelectorAll('.cart .item');
    let subtotal = 0;
    
    subtotal = isNaN(subtotal) ? 0 : subtotal;
    
    
    cartItems.forEach(item => {
    let price = parseFloat(item.querySelector('.price').textContent);
    let quantity = parseInt(item.querySelector('.count').value);
    if (!isNaN(price)) {
      subtotal += price * quantity || 0;
    }
  });

    const subtotalText = 'Subtotal: ₱ ' + subtotal.toFixed(2);
    document.querySelector('.subtotal').textContent = subtotalText;
    const inputSubtotal2 = document.getElementById('subtotal2');
    inputSubtotal2.value = subtotal.toFixed(2);

    let discountValue = parseFloat(document.querySelector('.discount-value').value) || 0;
    let deliverValue = parseFloat(document.querySelector('.deliver-value').value) || 0;

    let total = ((subtotal - discountValue)+ deliverValue)|| 0;
    total = isNaN(total) ? 0 : total;
    const totalValue = 'Total:₱ ' + total.toFixed(2);
    document.querySelector('.total').textContent = totalValue;
    const inputTotal2 = document.getElementById('total2');
    inputTotal2.value = total.toFixed(2);

    let paymentValue = parseFloat(document.querySelector('.payment-value').value);
    let change = paymentValue - total || 0;
    change = paymentValue >= total ? paymentValue - total : 0;
    change = isNaN(change) ? 0 : change;
    const changeValue = 'Change:₱ ' + change.toFixed(2);
    document.querySelector('.change').textContent = changeValue;
    const inputChange2 = document.getElementById('customerChange2');
    inputChange2.value = change.toFixed(2);
}

let deliverButtons = document.querySelectorAll('.delivery-method-button');
deliverButtons.forEach(button => {
  button.addEventListener('click', function() {
    if (button.id == 2) {
      document.querySelectorAll('.deliver-value').forEach(input => {
        input.style.display = 'block';
        if (input.id == 'deliver_cost1') {
          input.type = 'number';
          input.required = true;
        } else if (input.id == 'customerLastName1') {
          input.type = 'text';
          input.required = false;
        }
        else if (input.id == 'customerFirstName1') {
          input.type = 'text';
          input.required = false;
        }
        else if (input.id == 'customerContactNumber1') {
          input.type = 'text';
          input.required = false;
        }
        else if (input.id == 'customerEmailAddress1') {
          input.type = 'email';
          input.required = false;
        }
        else if (input.id == 'streetAddress1') {
          input.type = 'text';
          input.required = false;
        }
        else if (input.id == 'zipcode1') {
          input.type = 'number';
          input.required = false;
        }
      });
      document.querySelectorAll('.deliver-value').forEach(select => {
      // select.classList.remove('hidden');
        select.hidden = false; 
      });
    } else {
      document.querySelectorAll('.deliver-value').forEach(input => {
        input.style.display = 'none';
      });
      document.querySelectorAll('.deliver-value').forEach(select => {
      // select.classList.remove('hidden');
        select.hidden = true; 
      });
    }
  });
});

function remove($key){
  let listCart = document.querySelectorAll('.cart .item');
  listCart.forEach(item =>{
    if(item.getAttribute('data-key') == $key){
      item.remove();
      updateSubtotal();
      return;
    }
  })
}
function clear(){
    let clones = document.querySelectorAll('.scrollbar,.add');
  clones.forEach(function(clone) {
    clone.remove();
  });

  // set input fields to default values
  let inputDeliverId = document.getElementById('deliver-id-input');
  inputDeliverId.value = '1';

  let inputPaymentId = document.getElementById('payment-method-id-input');
  inputPaymentId.value = '1';

  let discountInput = document.querySelector('.discount-value');
  discountInput.value = '0';

  let deliverInput = document.querySelector('.deliver-value');
  deliverInput.value = '0';

  let paymentInput = document.querySelector('.payment-value');
  paymentInput.value = '0';

  updateSubtotal();
}

function searchProducts() {
  const searchInput = document.querySelector('.form input');
  const productList = document.querySelectorAll('.item');

  const searchTerm = searchInput.value.toLowerCase();

  productList.forEach(product => {
    const productName = product.querySelector('.itemName').textContent.toLowerCase();

    if (productName.includes(searchTerm)) {
      product.style.display = 'block';
    } else {
      product.style.display = 'none';
    }
  });
}
const searchBtn = document.querySelector('.form button');
searchBtn.addEventListener('click', searchProducts);

function buttonActive(){
    // Get all the payment method buttons and add a click event listener
  const paymentMethodButtons = document.querySelectorAll('.payment-method-button');
    paymentMethodButtons.forEach(button => {
        button.addEventListener('click', () => {
            // Remove the "active" class from all the buttons
            paymentMethodButtons.forEach(b => b.classList.remove('active'));
            button.classList.add('active')});
        })

    // Get all the delivery method buttons and add a click event listener
    const deliveryMethodButtons = document.querySelectorAll('.delivery-method-button');
    deliveryMethodButtons.forEach(button => {
        button.addEventListener('click', () => {
            // Remove the "active" class from all the buttons
            deliveryMethodButtons.forEach(b => b.classList.remove('active'))
            // Add the "active" class to the clicked button
            button.classList.add('active')})
        })
    const firstPaymentMethodButton = document.querySelector('.payment-method-button');
    firstPaymentMethodButton.classList.add('active');

    // Add the "active" class to the first delivery method button
    const firstDeliveryMethodButton = document.querySelector('.delivery-method-button');
    firstDeliveryMethodButton.classList.add('active');
}
buttonActive();
function restrictDropdown(){
  const provinceDropdown = document.getElementById('province1');
  const municipalityDropdown = document.getElementById('municipality1');
  const barangayDropdown = document.getElementById('barangay1');

    municipalityDropdown.disabled= true;
    barangayDropdown.disabled= true;

    // Filter the attribute options when the category changes
      provinceDropdown.addEventListener('change', () => {
      // Get the selected category value 
      const selectedProvince = provinceDropdown.value;

      // Loop through each attribute option and hide/show based on the category
      for (let i = 0; i < municipalityDropdown.options.length; i++) {
          const municipalityOption = municipalityDropdown.options[i];
          const municipalityProvince = municipalityOption.dataset.category;
          
          // Hide/show based on whether the category matches the selected category
          municipalityOption.hidden = municipalityProvince !== selectedProvince.toString();
          if(selectedProvince !== municipalityProvince){
            municipalityDropdown.value = 0;
            municipalityDropdown.disabled= true;
          }else{
            municipalityDropdown.disabled= false;
            municipalityDropdown.addEventListener('change', () => {
            // Get the selected category value 
            const selectedMunicipality = municipalityDropdown.value;

            // Loop through each attribute option and hide/show based on the category
            for (let i = 0; i < barangayDropdown.options.length; i++) {
                const barangayOption = barangayDropdown.options[i];
                const barangayMunicipality = barangayOption.dataset.category;
                
                // Hide/show based on whether the category matches the selected category
                 barangayOption.hidden = barangayMunicipality !== selectedMunicipality.toString();
                
                if(selectedMunicipality !== barangayMunicipality){
                  barangayDropdown.value = 0;
                  barangayDropdown.disabled= true;
                }else{
                  barangayDropdown.disabled= false;
                }
              }
            });
          }
        }
           
    });
    
}
restrictDropdown();

function checkOutInput(){
    const btnDeliver = document.querySelectorAll('.delivery-method-button');
    const inputDeliverId = document.getElementById('deliver-method-id-input');

    btnDeliver.forEach(function(button) {
    button.addEventListener('click', function() {
        // Set the value of the input field to the value of the clicked button
        inputDeliverId.value = button.value;
    });
    });
    const btnPayment = document.querySelectorAll('.payment-method-button');
    const inputPaymentId = document.getElementById('payment-method-id-input');

    btnPayment.forEach(function(button) {
    button.addEventListener('click', function() {
        // Set the value of the input field to the value of the clicked button
        inputPaymentId.value = button.value;
    });
    });
    document.addEventListener('DOMContentLoaded', function() {
  // Check if any of the delivery buttons are already active
  const activeDeliverButton = document.querySelector('.delivery-method-button.active');
  if (activeDeliverButton) {
    inputDeliverId.value = activeDeliverButton.value;
  }

  // Check if any of the payment buttons are already active
  const activePaymentButton = document.querySelector('.payment-method-button.active');
  if (activePaymentButton) {
    inputPaymentId.value = activePaymentButton.value;
  }
});
    const inputDiscount1 = document.getElementById('discount1');
    const inputDiscount2 = document.getElementById('discount2');
    
    inputDiscount2.value = inputDiscount1.value;

    inputDiscount1.addEventListener('change', function() {
        inputDiscount2.value = inputDiscount1.value;
    });
    const inputDeliver1 = document.getElementById('deliver_cost1');
    const inputDeliver2 = document.getElementById('deliver_cost2');
    inputDeliver2.value = inputDeliver1.value;

    inputDeliver1.addEventListener('change', function() {
        inputDeliver2.value = inputDeliver1.value;
    });

    const inputLastName1 = document.getElementById('customerLastName1');
    const inputLastName2 = document.getElementById('customerLastName2');

    inputLastName1.addEventListener('change', function() {
      inputLastName2.value = inputLastName1.value;
    });
    const inputFirstName1 = document.getElementById('customerFirstName1');
    const inputFirstName2 = document.getElementById('customerFirstName2');

    inputFirstName1.addEventListener('change', function() {
      inputFirstName2.value = inputFirstName1.value;
    });
    const inputContactNumber1 = document.getElementById('customerContactNumber1');
    const inputContactNumber2 = document.getElementById('customerContactNumber2');

    inputContactNumber1.addEventListener('change', function(event) {
      inputContactNumber2.value = inputContactNumber1.value;

      const inputText = event.target.value;

      const pattern = /^(639|09)\d{9}$/;
      if (!pattern.test(inputText)) {
        // Show error message and disable submit button
        Swal.fire({
          icon: 'error',
          title: 'Invalid Format',
          text: 'Please enter a valid contact number in 639 or 09 format.'
        });
      } 

    });

    const inputEmail1 = document.getElementById('customerEmailAddress1');
    const inputEmail2 = document.getElementById('customerEmailAddress2');

    inputEmail1.addEventListener('change', function() {
      inputEmail2.value = inputEmail1.value;
      const email = inputEmail1.value;
      const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.(com|org|net)$/;

      if (!emailRegex.test(email)) {
        // Display an error message using SweetAlert2
        Swal.fire({
          icon: "error",
          title: "Invalid Email Address",
          text: "Please enter a valid email address with a @ and .com, .org, or .net extension.",
        });

        // Clear the email input field
        emailField.value = "";
      }
    });
    const inputStreet1 = document.getElementById('streetAddress1');
    const inputStreet2 = document.getElementById('streetAddress2');

    inputStreet1.addEventListener('change', function() {
      inputStreet2.value = inputStreet1.value;
    });
    const inputBarangay1 = document.getElementById('barangay1');
    const inputBarangay2 = document.getElementById('barangay2');

    inputBarangay1.addEventListener('change', function() {
      inputBarangay2.value = inputBarangay1.value;
    });
    const inputMunicipal1 = document.getElementById('municipality1');
    const inputMunicipal2 = document.getElementById('municipality2');

    inputMunicipal1.addEventListener('change', function() {
      inputMunicipal2.value = inputMunicipal1.value;
    });
    const inputProvince1 = document.getElementById('province1');
    const inputProvince2 = document.getElementById('province2');

    inputProvince1.addEventListener('change', function() {
      inputProvince2.value = inputProvince1.value;
    });
    // const inputRegion1 = document.getElementById('region1');
    // const inputRegion2 = document.getElementById('region2');

    // inputRegion1.addEventListener('change', function() {
    //   inputRegion2.value = inputRegion1.value;
    // });
    const inputZipcode1 = document.getElementById('zipcode1');
    const inputZipcode2 = document.getElementById('zipcode2');

    inputZipcode1.addEventListener('change', function() {
      inputZipcode2.value = inputZipcode1.value;
    });
    
    const inputPayment1 = document.getElementById('payment_amount1');
    const inputPayment2 = document.getElementById('payment_amount2');

    inputPayment1.addEventListener('change', function() {
        inputPayment2.value = inputPayment1.value;
    });
    const inputDate1 = document.getElementById('pdDate1');
    const inputDate2 = document.getElementById('pdDate2');

    // Add a 'change' event listener to input1
    inputDate1.addEventListener('change', function() {
    // Update the value of input2 with the value of input1
        inputDate2.value = inputDate1.value;
    });

}
checkOutInput();

</script>
<script>logOut();</script>
</body>
</html>