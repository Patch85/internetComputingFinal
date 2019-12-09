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

    if (isset($_SESSION['userName']) && !isset($_POST['emailAddress'])) {
        // User is logged in, but has not tried to update their profile yet
        // Display the profile page.

        // Retrieve user's data from database
        $query = "SELECT * FROM users where accountNumber = :accountNumber";
        $statement = $db->prepare($query);
        $statement->bindValue(":accountNumber", $_SESSION['acctNum']);
        $statement->execute();
        $userProfile = $statement->fetch();
        $statement->closeCursor();

        // Assign data to simple variable names
        $accountNumber = $userProfile['accountNumber'];
        $emailAddress = $userProfile['emailAddress'];
        $password = $userProfile['password'];
        $firstName = $userProfile['firstName'];
        $lastName = $userProfile['lastName'];
        $phoneNumber = $userProfile['phoneNumber'];
        $address1 = $userProfile['address1'];
        $address2 = $userProfile['address2'];
        $city = $userProfile['city'];
        $state = $userProfile['state'];
        $zip = $userProfile['zip'];
    }else if (isset($_SESSION['userName']) && isset($_POST['emailAddress'])) {
        // User is logged in and submitted the form to update their profile/account information

        // Retrieve user's hashed password from database
        $query = "SELECT password FROM users where accountNumber = :accountNumber";
        $statement = $db->prepare($query);
        $statement->bindValue(":accountNumber", $_SESSION['acctNum']);
        $statement->execute();
        $userProfile = $statement->fetch();
        $statement->closeCursor();

        // Assign the current password to a variable
        $hashedPass = $userProfile['password'];

        // Assign the form data to required variables
        $emailAddress = $_POST['emailAddress'];
        $password = $_POST['password'];
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $phoneNumber = $_POST['phoneNumber'];
        $address1 = $_POST['address1'];
        $address2 = $_POST['address2'];
        $city = $_POST['city'];
        $state = $_POST['state'];
        $zip = $_POST['zip'];  

        // Ensure that the old password the user provided is valid before updating
        $validPassword = password_verify($password, $hashedPass);        

        // If the user provided a valid 'old password' update their profile
        if ($validPassword) {
            $query = "UPDATE users
                    SET emailAddress = :emailAddress,                      
                        firstName = :firstName,
                        lastName = :lastName,
                        phoneNumber = :phoneNumber,
                        address1 = :address1,
                        address2 = :address2,
                        city = :city,
                        state = :state,
                        zip = :zip
                    WHERE accountNumber = :accountNumber";
            $statement = $db->prepare($query);
            $statement->bindValue(':emailAddress', $emailAddress);
            $statement->bindValue(':firstName', $firstName);
            $statement->bindValue(':lastName', $lastName);
            $statement->bindValue(':phoneNumber', $phoneNumber);
            $statement->bindValue(':address1', $address1);
            $statement->bindValue(':address2', $address2);
            $statement->bindValue(':city', $city);
            $statement->bindValue(':state', $state);
            $statement->bindValue(':zip', $zip);
            $statement->execute();
            $statement->closeCursor();
        }else{
            // The password the user provided was incorrect
            // Redirect to login page
            header("Location: ./login.php");

        }
    } else {
        // User is not logged in, redirect to login page
        header("Location: ./login.php");
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
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">My Account</a>

                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">                        
                        <a class="dropdown-item " href="login.php">Log In</a>

                        <div class="dropdown-divider"></div>

                        <a class="dropdown-item " href="register.php">Register</a>

                        <div class="dropdown-divider"></div>

                        <a class="dropdown-item active" href="customerProfile.php">View/Update Profile<span class="sr-only">(current)</span></a>

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
            <h1 class="jumboHeading"><?php echo $_SESSION['userName']?>'s
                Profile</h1>
        </div>
    </div>

    <div class="container">
        <form class="col-md-6 m-auto" action="customerProfile.php" method="post" autocomplete="off">
            <div class="form-group">
                <label for="emailAddress">Email Address</label>
                <input type="email" name="emailAddress" id="emailAddress" class="form-control"
                    value="<?php echo $emailAddress; ?>" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" class="form-control"
                    placeholder="Enter your password to process changes" required>
            </div>

            <div class="form-group">
                <label for="lastName">First Name</label>
                <input type="text" name="firstName" id="firstName" class="form-control"
                    value="<?php echo $firstName; ?>" required>
            </div>

            <div class="form-group">
                <label for="lastName">Last Name</label>
                <input type="text" name="lastName" id="lastName" class="form-control"
                    value="<?php echo $lastName; ?>" required>
            </div>

            <div class="form-group">
                <label for="phoneNumber">Phone Number</label>
                <input type="tel" name="phoneNumber" id="phoneNumber" class="form-control"
                    value="<?php echo $phoneNumber; ?>" required>
            </div>

            <div class="form-group">
                <label for="address1">Street Address</label>
                <input type="text" name="address1" id="address1" class="form-control"
                    value="<?php echo $address1; ?>" required>
            </div>

            <div class="form-group">
                <label for="address2">Unit/Apt Number</label>
                <input type="text" name="address2" id="address2" class="form-control" placeholder="Unit #4A"
                    value="<?php echo $address2; ?>">
            </div>

            <div class="form-group">
                <label for="city">City</label>
                <input type="text" name="city" id="city" class="form-control"
                    value="<?php echo $city; ?>" required>
            </div>

            <div class="form-group">
                <label for="state">State</label>
                <input type="text" name="state" id="state" class="form-control"
                    value="<?php echo $state; ?>" required>
            </div>

            <div class="form-group">
                <label for="zip">Zip Code</label>
                <input type="text" name="zip" id="zip" class="form-control"
                    value="<?php echo $zip; ?>" required>
            </div>

            <button type="submit" class="btn btn-primary">Update Profile</button>
        </form>
    </div>

    <!-- Bootstrap JavaScript Bundle CDNs -->
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