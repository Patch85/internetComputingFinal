<?php
    // Start a session
    $lifetime = 60 * 60 * 6; // 6 hours in seconds
    session_start();

    // Create a mulitdimensional array to hold shopping cart data
    // Check for an existing cart. Create one if it doesn't exist yet. Add the new item if it does
    if (!isset($_SESSION['cart']) || !isset($_SESSION['shipping'])) {
        // If there is no cart or shipping info at this stage, the user should be redirected
        header("Location: index.php");
    }
    // Set PDO variables
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

    // If the user has progessed through checkout, and confirmed their order, continue to
    // insert the order into the database
    if (isset($_SESSION['shipping']['firstName'])) {
        $time = new DateTime("now");
        $time = $time->format("r");

        $query = "INSERT INTO orders
            (accountNumber, orderDate, forFirstName, forLastName, shipAddress1, shipAddress2, shipCity, shipState shipZip, comments)
            VALUES 
            (:accountNumber, :orderDate, :forFirstName, :forLastName, :shipAddress1, :shipAddress2, :shipCity, :shipState, :shipZip, :comments)";
        
        $statement = $db->prepare($query);

        $statement->bindValue(':accountNumber', $_SESSION['acctNum']);
        $statement->bindValue(':orderDate', $time);
        $statement->bindValue(':forFirstName', $_SESSION['shipping']['firstName']);
        $statement->bindValue(':forLastName', $_SESSION['shipping']['lastName']);
        $statement->bindValue(':shipAddress1', $_SESSION['shipping']['address1']);
        $statement->bindValue(':shipAddress2', $_SESSION['shipping']['address2']);
        $statement->bindValue(':shipCity', $_SESSION['shipping']['city']);
        $statement->bindValue(':shipState', $_SESSION['shipping']['state']);
        $statement->bindValue(':shipZip', $_SESSION['shipping']['zip']);
        $statement->bindValue(':comments', $_SESSION['shipping']['comments']);

        $statement->execute();

        $orderNumber = $db->lastInsertId();

        $statement->closeCursor();

        foreach ($_SESSION['cart'] as $item) {
            // if ($item['quantity'] > 0) {
            $pName = $item['productName'];
            $price = $item['price'];
            $qty = $item['quantity'];

            $selectQuery = "SELECT productNumber FROM products WHERE productName = :productName";

            $statement = $db->prepare($selectQuery);
            $statement->bindValue(':productName', $pName);
            $statement->execute();

            $pNum = $statement->fetchColumn();

            $statement->closeCursor();

            $insertQuery = "INSERT INTO order_items
                        (orderNumber, productNumber, price, quantity)
                    VALUES
                        (:orderNumber, :productNumber, :price, :quantity)";

            $statement = $db->prepare($insertQuery);

            $statement->bindValue(':orderNumber', $orderNumber);
            $statement->bindValue(':productNumber', $pNum);
            $statement->bindValue(':price', $price);
            $statement->bindValue(':quantity', $qty);

            $statement->execute();
            $statement->closeCursor();
            // }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

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
            <h1 class="jumboHeading">Order Submitted</h1>
            <h2 class="jumboTagline">Thanks for shopping at DDM!</h2>
        </div>
    </div>

    <!-- Main Section of the page: Show 6 Featured Products as cards with brief descriptions -->
    <div class="container">
        <p>Order Number: <?php echo $orderNumber; ?> Confirmed</p>

        <h3>Delivered to:</h3>
        <?php foreach ($_SESSION['shipping'] as $key => $value) {
    echo "<p>".$value."</p>";
}?>
    </div>

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