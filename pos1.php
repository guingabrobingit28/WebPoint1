<?php

$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "mydatabase";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// Retrieve all products from database
$sql = "SELECT * FROM products";
$result = mysqli_query($conn, $sql);

$productListHtml = "";

// Generate HTML code for each product
while ($row = mysqli_fetch_assoc($result)) {
  $productListHtml .= '<div class="item" data-key="' . $row["id"] . '">';
  $productListHtml .= '<div class="img">';
  $productListHtml .= '<img src="products/' . $row["image"] . '" alt="">';
  $productListHtml .= '<div class="itemName">' . $row["name"] . '</div>';
  $productListHtml .= '<div class="price">&#8369;' . $row["price"] . '</div>';
  $productListHtml .= '<div class="stock"><i>Stock: ' . $row["stock"] . '</i></div>';
  $productListHtml .= '<input type="number" class="count" min="1">';
  $productListHtml .= '<button class="add btn btn-success m-2"><i class="fas fa-shopping-cart"></i></button>';
  $productListHtml .= '<button type="button" class="remove btn btn-danger" onclick="remove(' . $row["id"] . ')"><i class="far fa-trash-alt"></i></button>';
  $productListHtml .= '</div></div>';
}

// Close database connection
mysqli_close($conn);

?>

<!-- HTML code with PHP variable for product list -->
<div class="search">
  <div class="searchBar">
    <div class="form">
      <i class="fa-solid fa-magnifying-glass"></i>
<input type="text" class="searchTerm" placeholder="Search products...">
<button type="submit" class="searchButton">
<i class="fa-solid fa-search"></i>
</button>
</div>

  </div>
</div>
<div class="productList">
  <?php echo $productListHtml; ?>
</div>
<script>

  // Add event listener to search bar
  document.querySelector('.searchTerm').addEventListener('keyup', function(event) {
    let filter = event.target.value.toLowerCase();
    let items = document.querySelectorAll('.item');
    items.forEach(function(item) {
      let name = item.querySelector('.itemName').textContent.toLowerCase();
      if (name.includes(filter)) {
        item.style.display = '';
      } else {
        item.style.display = 'none';
      }
    });
  });

  // Add event listener to add button
  let addButtons = document.querySelectorAll('.add');
  addButtons.forEach(function(button) {
    button.addEventListener('click', function(event) {
      let item = event.target.closest('.item');
      let key = item.dataset.key;
      let count = item.querySelector('.count').value;
      let url = 'add_to_cart.php?key=' + key + '&count=' + count;
      fetch(url).then(function(response) {
        return response.text();
      }).then(function(text) {
        console.log(text);
      }).catch(function(error) {
        console.error(error);
      });
    });
  });

  // Function to remove item from cart
  function remove(key) {
    let url = 'remove_from_cart.php?key=' + key;
    fetch(url).then(function(response) {
      return response.text();
    }).then(function(text) {
      console.log(text);
    }).catch(function(error) {
      console.error(error);
    });
  }

</script> 
</body>
</html>
<?php

$host = 'localhost';
$username = 'your_username';
$password = 'your_password';
$dbname = 'your_database_name';

$connection = mysqli_connect($host, $username, $password, $dbname);

if (!$connection) {
    die('Connection failed: ' . mysqli_connect_error());
}

$query = 'SELECT * FROM products';
$result = mysqli_query($connection, $query);

if (!$result) {
    die('Query failed: ' . mysqli_error($connection));
}

$products = mysqli_fetch_all($result, MYSQLI_ASSOC);

mysqli_close($connection);

?>

<!-- Use the $products variable to display the product data in the HTML code -->
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
        <div class="list">
        <?php foreach ($products as $product) { ?>
            <div class="item" data-key="<?php echo $product['id']; ?>">
                <div class="img">
                    <img src="products/<?php echo $product['image']; ?>" alt="">
                    <div class="itemName"><?php echo $product['name']; ?></div>
                    <div class="price">&#8369;<?php echo $product['price']; ?></div>
                    <div class="stock"><i>Stock: <?php echo $product['stock']; ?></i></div>
                    <input type="number" class="count" min="1">
                    <button class="add btn btn-success m-2"><i class="fas fa-shopping-cart"></i></button>
                    <button type="button" class="remove btn btn-danger" onclick="remove(<?php echo $product['id']; ?>)"><i class="far fa-trash-alt"></i></button>
                </div>
            </div>
        <?php } ?>
        </div>
    </div>
</div>
<div class="cart">
    <div class="cartName">CART</div>
    <div class="scrollBar1">
        <div class="listCart">

        </div>
    </div>
    <div class="horizontal">
        <hr style="border-color: black !important;border-style: solid; border-width: 1px">
    </div>
</div>
</div>
</div>
<script>
    function cartList(){
        let buttons = document.querySelectorAll('.scrollbar,.add');
        buttons.forEach(button => {
            button.addEventListener('click', function(event){
            let item = event.target.closest('.item');
            var itemNew = item.cloneNode(true);
        let check = false;

        let listCart = document.querySelectorAll('.cart .item');
        listCart.forEach(cart =>{
          if(cart.getAttribute('data-key') == itemNew.getAttribute('data-key')){
            check = true;
            cart.classList.add('danger');
            setTimeout(function(){
              cart.classList.remove('danger');
            },1000)
          }
        })
        if(check == false){
          document.querySelector('.listCart').appendChild(itemNew);
        }
      })
    })
}
cartList();

function remove($key){
  let listCart = document.querySelectorAll('.cart .item');
  listCart.forEach(item =>{
    if(item.getAttribute('data-key') ==$key){
      item.remove();
      return;
    }
  })
}