<?php
    // Start a session
    session_start();

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

    $results = array();

    // If the user has searched, get the post data and run the search
    if (isset($_POST['searchQuery'])) {
        $SearchTerm = $_POST['searchQuery'];
        $category = $_POST['categoryInput'];
        
        // Query the database, using the user's input

        // determine which query to run based on the user's selection from the dropdown menu
        if ($category == "productName") {
            $SearchQuery = "SELECT *
            FROM products
            WHERE productName
            LIKE \"%".$SearchTerm."%\"";
        } elseif ($category == "category") {
            $SearchQuery = "SELECT *
            FROM products
            WHERE category
            LIKE \"%".$SearchTerm."%\"";
        } elseif ($category == "subcategory") {
            $SearchQuery = "SELECT *
            FROM products
            WHERE subcategory
            LIKE \"%".$SearchTerm."%\"";
        } else {
            $SearchQuery = "SELECT *
            FROM products
            WHERE manufacturer
            LIKE \"%".$SearchTerm."%\"";
        }
        // Prepare and execute the query, assinging the results to an array
        $statementSearch = $db->prepare($SearchQuery);
        $statementSearch->execute();
        $results = $statementSearch->fetchAll();
        $statementSearch->closeCursor();
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
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link active" href="products.php" tabindex="-1">Products</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="viewCart.php">Shopping Cart</a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">My Account</a>

                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="login.php">Log In</a>

                        <div class="dropdown-divider"></div>

                        <a class="dropdown-item" href="register.php">Register</a>

                        <div class="dropdown-divider"></div>

                        <a class="dropdown-item" href="customerProfile.php">View/Update Profile<</a> <div
                                class="dropdown-divider">
                    </div>

                    <a class="dropdown-item " href="changePassword.php">Change Password</a>

                    <div class="dropdown-divider"></div>

                    <a class="dropdown-item" href="CustomerReceipts.php">Order History</a>

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

                    <a class="dropdown-item" href="logout.php">Log Out</a>
                </li>
            </ul>
        </div>

        <!-- Allow searching for products from the navbar -->
        <form class="form-inline my-2 my-lg-0" action="searchResults.php" method="post">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search"
                name="searchQuery">

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
            <h1 class="jumboHeading">Search Results</h1>
        </div>
    </div>

    <div class="container-fluid ml-2 mr-2">
        <div class="row">
            <?php foreach ($results as $product) { ?>
            <!-- Create a card for each product -->
            <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2">
                <div class="card m-2">
                    <img src="assets\images\productImages\resized\<?php echo $product['imagePath']; ?>"
                        class="card-img-top"
                        alt="Image of <?php echo $product['productName'] ?>">

                    <div class="card-body">
                        <h5 class="card-title"><?php echo $product['productName']; ?>
                        </h5>

                        <h6 class="card-subtitle text-muted mb-2">$<?php echo $product['price']; ?>
                        </h6>

                        <!-- <p class="card-text"><?php echo substr($product['description'], 0, 35) . "..."; ?>
                        </p> -->

                        <form action="addToCart.php" method="post" class="mt-2">
                            <input type="hidden" name="productName"
                                value="<?php echo $product['productName']; ?>">
                            <input type="hidden" name="price"
                                value="<?php echo $product['price']; ?>">
                            <input type="hidden" name="quantity" value="1">

                            <button type="button" class="btn btn-primary mr-5" data-toggle="modal"
                                data-target="#<?php echo $product['productName']; ?>">
                                <i class="fas fa-expand-arrows-alt"></i>
                            </button>

                            <button type="submit" class="btn btn-success"><i class="fas fa-cart-plus"></i></button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Create the modal for each product  -->
            <!-- Clicking on the expand button will show more detailed product info, with a larger image if available -->
            <div class="modal fade"
                id="<?php echo $product['productName']; ?>"
                tabindex="-1" role="dialog"
                aria-labelledby="<?php echo $product['productName']; ?>Title"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title"
                                id="<?php echo $product['productName']; ?>Title">
                                <?php echo $product['productName']; ?>
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <img src="assets\images\productImages\resized\<?php echo $product['imagePath']; ?>"
                                class="card-img-top"
                                alt="Image of <?php echo $product['productName'] ?>">

                            <h6 class="text-muted">$<?php echo $product['price']; ?>
                            </h6>

                            <p><?php echo $product['description']; ?>
                            </p>
                        </div>
                        <div class="modal-footer">
                            <form action="addToCart.php" method="post" class="mt-2">
                                <input type="hidden" name="productName"
                                    value="<?php echo $product['productName']; ?>">
                                <input type="hidden" name="price"
                                    value="<?php echo $product['price']; ?>">
                                <input type="hidden" name="quantity" value="1">

                                <button type="button" class="btn btn-primary mr-5" data-toggle="modal"
                                    data-target="#<?php echo $product['productName']; ?>">
                                    <i class="fas fa-expand-arrows-alt"></i>
                                </button>

                                <button type="submit" class="btn btn-success"><i class="fas fa-cart-plus"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php }?>
        </div>

        <!-- Bootstrap JavaScript Bundle CDN -->
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