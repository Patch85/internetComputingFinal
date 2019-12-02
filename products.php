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
                    <a class="nav-link active" href="products.php" tabindex="-1">Products<span
                            class="sr-only">(current)</span></a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">My Account</a>

                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="login.php">Log In</a>

                        <div class="dropdown-divider"></div>

                        <a class="dropdown-item " href="register.php">Register</a>

                        <div class="dropdown-divider"></div>

                        <a class="dropdown-item" href="customerProfile.php">View/Update Profile</a>

                        <div class="dropdown-divider"></div>

                        <a class="dropdown-item " href="changePassword.php">Change Password</a>

                        <div class="dropdown-divider"></div>

                        <a class="dropdown-item  disabled" href="#">Order History</a>

                        <div class="dropdown-divider"></div>

                        <a class="dropdown-item" href="logout.php">Log Out</a>
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
            <h1 class="jumboHeading">Products</h1>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <?php // Query the DB for all products
                $query = ('SELECT * FROM products ORDER BY category');
                $statement = $db->prepare($query);
                $statement -> execute();
                $product = $statement->fetch(); // get the first row
                while ($product != null) { ?>
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

                        <div>
                            <button type="button" class="btn btn-primary mr-5" data-toggle="modal"
                                data-target="#<?php echo $product['productName']; ?>">
                                <i class="fas fa-expand-arrows-alt"></i>
                            </button>

                            <a href="#" class="btn btn-success"><i class="fas fa-cart-plus"></i></a>
                        </div>
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
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <a href="#" class="btn btn-success"><i class="fas fa-cart-plus"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <?php $product = $statement->fetch(); // get the next row
                }
            ?>
        </div>
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