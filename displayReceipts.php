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

    if (!isset($_SESSION['userType'])) {
        // if user is not logged in, redirect to login
        header("Location: ./login.php");
    } elseif ($_SESSION['userType'] == "customer") {
        // If user is a customer, redirect to Customer view for order history
        header("Location: ./CustomerReceipts.php");
    } elseif ($_SESSION['userType'] == "manager" || $_SESSION['userType'] == "employee") {
        // If user is a manager or employee query for complete order history
        $queryGetOrderNumbers = "SELECT *
                                FROM orders";
        $statementGetOrderNums = $db->prepare($queryGetOrderNumbers);
        $statementGetOrderNums->execute();
        $orderNums = $statementGetOrderNums->fetchall();
        $statementGetOrderNums->closeCursor();
    }
?>
<html lang="en" dir="ltr">

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
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home</a>
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

                        <a class="dropdown-item active" href="CustomerReceipts.php">Order History<span
                                class="sr-only">(current)</span></a>

                        <div class="dropdown-divider"></div>

                        <?php
                        if (isset($_SESSION['userType'])) {
                            // If the user is logged in and is a manager, display appropriate admin links
                            if ($_SESSION['userType'] == "manager") {
                                echo '<a class="dropdown-item" href="addProductForm.php">Add New Product</a>
                                <div class="dropdown-divider"></div>';

                                echo' <a class="dropdown-item" href="productListing.php">Update Inventory / Delete Product</a>
                                <div class="dropdown-divider"></div>';

                                echo' <a class="dropdown-item disabled" href="#">View/Edit Users</a>
                                <div class="dropdown-divider"></div>';
                            } elseif ($_SESSION['userType'] == "employee") {
                                // If the user is logged in and is an employee, display appropriate admin links
                                echo '<a class="dropdown-item" href="empProductListing.php">View Inventory</a>
                                <div class="dropdown-divider"></div>';
                            }
                        }?>

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
            <h1 class="jumboHeading">Admin: Order History</h1>
            <h2 class="jumboTagline"><?php echo $_SESSION['userName'].": ".$_SESSION['userType']; ?>
                View
            </h2>
        </div>
    </div>

    <!-- Display A Complete Order History for Manager/Employee -->
    <div class="container">


        <?php foreach ($orderNums as $orderNum) {
    $QueryGetOrders = "SELECT * FROM order_items WHERE orderNumber = :orderNumber";
    $statementGetOrders = $db->prepare($QueryGetOrders);
    $statementGetOrders->bindValue(":orderNumber", $orderNum['orderNumber']);
    $statementGetOrders->execute();
    $Orders = $statementGetOrders->fetchall();
    $statementGetOrders->closeCursor(); ?>

        <h4>Order # <?php  echo $orderNum['orderNumber']; ?>
        </h4>
        <h5>Account # <?php echo $orderNum['accountNumber']; ?>
        </h5>
        <h6>Date: <?php echo $orderNum['orderDate']; ?>
        </h6>
        <table class="table table-sm">

            <tr class="thead-dark">
                <th>Product Name</th>
                <th>Price</th>
                <th>Quantity</th>
            </tr>

            <?php foreach ($Orders as $Order) {
        $nameQuery = "SELECT productName FROM products WHERE productNumber = :productNumber";
        $statement = $db->prepare($nameQuery);
        $statement->bindValue(":productNumber", $Order['productNumber']);
        $statement->execute();
        $pName = $statement->fetch();
        $prodName = $pName['productName'];
        $statement->closeCursor(); ?>

            <tr>
                <td> <?php echo $prodName; ?>
                </td>
                <td> $<?php echo $Order['price']; ?>
                </td>
                <td> <?php echo $Order['quantity']; ?>
                </td>
            </tr>

            <?php
    } ?>
        </table> <br> <br>
        <?php
} ?>

        <!-- Bootstrap: jQuery, ajax & JavaScript Bundle CDNs -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
            integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
        </script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
            integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
        </script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
            integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
        </script>

</body>

</html>