<?php
    // Start a session
    $lifetime = 60 * 60 * 6; // 6 hours in seconds
    session_start();

    // Create a mulitdimensional array to hold shopping cart data
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart']  = array();
    }
    $cartTotal = 0.00;
    $itemCount = 0;

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

    // Ensure that the user is logged in, redirect to login page if not
    if (!isset($_SESSION['userName'])) {
        header("Location: ./login.php");
    } else {
        // Get the user's address from the database
        $query = "SELECT 
            lastName, address1, address2, city, state, zip 
            FROM users 
            WHERE accountNumber = :accountNumber";
        $statement = $db->prepare($query);
        $statement->bindValue(":accountNumber", $_SESSION['acctNum']);
        $statement->execute();
        $userData = $statement->fetch();
        $statement->closeCursor();

        // Assign the fetched data to variables for autofilling the form
        $lastName = $userData['lastName'];
        $address1 = $userData['address1'];
        $address2 = $userData['address2'];
        $city = $userData['city'];
        $state = $userData['state'];
        $zip = $userData['zip'];
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
            <h1 class="jumboHeading">Check Out</h1>
            <h2 class="jumboTagline">Shipping & Payment</h2>
        </div>
    </div>

    <div class="container">

        <h3 class="mb-2">If not shipping to the address you entered during registration, change the shipping address
            here. </h3>

        <form class="col-md-6 m-auto" action="confirmOrder.php" method="post">

            <div class="form-group">
                <label for="firstName">Recipient's First Name</label>
                <input type="text" name="firstName" id="firstName" class="form-control" placeholder="Jane"
                    value="<?php echo $_SESSION['userName'] ?>"
                    required>
            </div>

            <div class="form-group">
                <label for="lastName">Recipient's Last Name</label>
                <input type="text" name="lastName" id="lastName" class="form-control" placeholder="Doe"
                    value="<?php echo $lastName ?>" required>
            </div>

            <div class="form-group">
                <label for="address1">Ship To: Street Address</label>
                <input type="text" name="address1" id="address1" class="form-control" placeholder="123 Main Street"
                    value="<?php echo $address1 ?>" required>
            </div>

            <div class="form-group">
                <label for="address2">Ship To: Unit/Apt Number</label>
                <input type="text" name="address2" id="address2" class="form-control" placeholder="Unit #4A">
                value="<?php echo $address2 ?>"
            </div>

            <div class="form-group">
                <label for="city">Ship To: City</label>
                <input type="text" name="city" id="city" class="form-control" placeholder="Your Town"
                    value="<?php echo $city ?>" required>
            </div>

            <div class="form-group">
                <label for="state">Ship To: State</label>
                <input type="text" name="state" id="state" class="form-control" placeholder="Your State"
                    value="<?php echo $state ?>" required>
            </div>

            <div class="form-group">
                <label for="zip">Ship To: Zip Code</label>
                <input type="text" name="zip" id="zip" class="form-control" placeholder="07470"
                    value="<?php echo $zip ?>" required>
            </div>

            <div class="form-group">
                <label for="comments">Shipping Comments</label>
                <textarea name="comments" id="comments" cols="30" rows="10"></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
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