<?php
    // Start a session
    session_start();
    // Set initial variables
    $dsn = 'mysql:host=localhost;dbname=music';
    // musicman has global privileges for the music database
    // make sure to create and use a more limited user for customer access
    $dbUsername = 'musicman';
    $dbPassword = 'bQC_2AFWpq46M4N';
    //  Attempt to connect to the database
    try {
        $db = new PDO($dsn, $dbUsername, $dbPassword);
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        echo " <p>An error occurred while connecting to the database: $error_message</p>";
        die();
    }

if (isset($_POST['acntNum'])) {
  $queryGetOrderNumbers = "SELECT *
                           FROM orders
                           WHERE accountNumber=".$_POST['acntNum'];
  $statementGetOrderNums = $db->prepare($queryGetOrderNumbers);
  $statementGetOrderNums->execute();
  $orderNums = $statementGetOrderNums->fetchall();
  $statementGetOrderNums->closeCursor();
} else {
  $queryGetOrderNumbers = "SELECT *
                           FROM orders";
  $statementGetOrderNums = $db->prepare($queryGetOrderNumbers);
  $statementGetOrderNums->execute();
  $orderNums = $statementGetOrderNums->fetchall();
  $statementGetOrderNums->closeCursor();
}

/*
if (!empty($acntNumber)) {
  $queryGetOrderNumbers = "SELECT *
                           FROM orders
                           WHERE accountNumber=".$acntNumber;
  $statementGetOrderNums = $db->prepare($queryGetOrderNumbers);
  $statementGetOrderNums->execute();
  $orderNums = $statementGetOrderNums->fetchall();
  $statementGetOrderNums->closeCursor();

} else {
$queryGetOrderNumbers = "SELECT *
                         FROM orders";
$statementGetOrderNums = $db->prepare($queryGetOrderNumbers);
$statementGetOrderNums->execute();
$orderNums = $statementGetOrderNums->fetchall();
$statementGetOrderNums->closeCursor();
 */

?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>DDM, Inc. Music Shop</title>

    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">


    <!-- Add the custom CSS on top of Bootstrap -->
    <link rel="stylesheet" href="assets\styles\custom.css">

    <!-- FontAwesome -->
    <script src="https://kit.fontawesome.com/69d8b1cf3c.js" crossorigin="anonymous"></script>

</head>

<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <!-- DDM Brand -->
        <a class="navbar-brand" href="index.php">DDM, Inc.</a>
        <!-- Use Bootstrap's Toggler to allow for expanding from and collapsing to a hamburger menu -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navLinks"
            aria-controls="navLinks" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Provide Nav links in a List  -->
        <div class="collapse navbar-collapse" id="navLinks">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="products.php" tabindex="-1">Products</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="viewCart.php">Shopping Cart</a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">My Account</a>

                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item " href="login.php">Log In</a>

                        <div class="dropdown-divider"></div>

                        <a class="dropdown-item " href="register.php">Register</a>

                        <div class="dropdown-divider"></div>

                        <a class="dropdown-item " href="customerProfile.php">View/Update Profile</a>

                        <div class="dropdown-divider"></div>

                        <a class="dropdown-item " href="changePassword.php">Change Password</a>

                        <div class="dropdown-divider"></div>

                        <a class="dropdown-item  disabled" href="#">Order History</a>

                        <div class="dropdown-divider"></div>

                        <a class="dropdown-item " href="logout.php">Log Out</a>
                    </div>
                </li>
            </ul>

            <!-- Allow searching for products from the navbar -->
            <form class="form-inline my-2 my-lg-0" action="searchResults.php" method="post">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search"
                    name="SearchQuery">

                <select class="form-control mr-sm-2" name="categoryInput">
                    <option value="productName">Product Name</option>
                    <option value="category">Category</option>
                    <option value="subcategory">subcategory</option>
                    <option value="manufacturer">Manufacturer</option>
                </select>

                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>
    </nav>

    <!-- Jumbotron/Hero element : Features a random background image and a tagline for the company -->
    <div class="jumbotron jumbotron-fluid musicJumbotron">
        <div class="container">
            <h1 class="jumboHeading">DDM</h1>
            <h2 class="jumboTagline">The Only Place for all Your Musical Needs</h2>
        </div>
    </div>

    <!-- Main Section of the page: Show 6 Featured Products as cards with brief descriptions -->
    <div class="container">

    Enter a number to view a specific account: <input type="text" name="acntNum">
    <input type="submit" value="Go" class="btn btn-success">
    </form>
    <br>
    <table class="table table-sm">
      <thead class="thead-dark">
      <tr >
        <th scope="col">Order number</th>
        <th scope="col">Account number</th>
        <th scope="col">Product Number</th>
        <th scope="col">Price</th>
        <th scope="col">Quantity</th>
      </tr>
    </thead>

      <?php foreach($orderNums as $orderNum) {
        $QueryGetOrders = "SELECT *
                           FROM order_items
                           WHERE orderNumber=".$orderNum['orderNumber'];
        $statementGetOrders = $db->prepare($QueryGetOrders);
        $statementGetOrders->execute();
        $Orders = $statementGetOrders->fetchall();
        $statementGetOrders->closeCursor();

        foreach($Orders as $Order) {
         ?>
      <tr>
        <td> <?php echo $orderNum['orderNumber']; ?> </td>
        <td> <?php echo $orderNum['accountNumber']; ?> </td>
        <td> <?php echo $Order['productNumber']; ?> </td>
        <td> <?php echo $Order['price']; ?> </td>
        <td> <?php echo $Order['quantity']; ?> </td>
      </tr>
    <?php }
        } ?>
    </table>

  </body>
</html>
