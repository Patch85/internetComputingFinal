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

    // If the user has submitted the form, try to insert the user into the database
    if (isset($_POST['emailAddress'])) {
        $emailAddress = $_POST['emailAddress'];
        $password = $_POST['password'];
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $userType = "customer"; // All newly registered users are automatically set to type: customer
        $phoneNumber = $_POST['phoneNumber'];
        $address1 = $_POST['address1'];
        $address2 = $_POST['address2'];
        $city = $_POST['city'];
        $state = $_POST['state'];
        $zip = $_POST['zip'];

        //Encrypt the password with a randomly generated salt and Blowfish
        $attempt = 0;
        do {
            $hashedPW = password_hash($password, PASSWORD_BCRYPT);
           ++$attempt;
        } while ($hashedPW == false && attempt < 3);

        // If password encryption was successful, register the user
        if ($hashedPW != false) {
            // Attempt to add the new user
            $query = "INSERT INTO users 
                    (emailAddress, password, firstName, lastName, userType, phoneNumber, address1, address2, city, state, zip)
                VALUES 
                    (:emailAddress, :password, :firstName, :lastName, :userType, :phoneNumber, :address1, :address2, :city, :state, :zip)";

            $statement = $db->prepare($query);

            $statement->bindValue(':emailAddress', $emailAddress);
            $statement->bindValue(':password', $hashedPW);
            $statement->bindValue(':firstName', $firstName);
            $statement->bindValue(':lastName', $lastName);
            $statement->bindValue(':userType', $userType);
            $statement->bindValue(':phoneNumber', $phoneNumber);
            $statement->bindValue(':address1', $address1);
            $statement->bindValue(':address2', $address2);
            $statement->bindValue(':city', $city);
            $statement->bindValue(':state', $state);
            $statement->bindValue(':zip', $zip);

            $statement->execute();

            $statement->closeCursor();
        } else{ // If password encryption failed after 3 attempts, registration fails
            echo "<p>There was an error during registration. Please try again.</p>";
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

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">My Account</a>

                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">                        
                        <a class="dropdown-item" href="login.php">Log In</a>

                        <div class="dropdown-divider"></div>

                        <a class="dropdown-item active" href="register.php">Register<span class="sr-only">(current)</span></a>

                        <div class="dropdown-divider"></div>

                        <a class="dropdown-item" href="customerProfile.php">View/Update Profile<</a>

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
            <h1 class="jumboHeading">Registration</h1>
        </div>
    </div>

    <div class="container">
    <form class="col-md-6 m-auto" action="register.php" method="post">
            <div class="form-group">
                <label for="emailAddress">Email Address</label>
                <input type="email" name="emailAddress" id="emailAddress" class="form-control"
                    placeholder="you@email.com" autofocus required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="password"
                    required>
            </div>

            <div class="form-group">
                <label for="lastName">First Name</label>
                <input type="text" name="firstName" id="firstName" class="form-control" placeholder="Jane" required>
            </div>

            <div class="form-group">
                <label for="lastName">Last Name</label>
                <input type="text" name="lastName" id="lastName" class="form-control" placeholder="Doe" required>
            </div>

            <div class="form-group">
                <label for="phoneNumber">Phone Number</label>
                <input type="tel" name="phoneNumber" id="phoneNumber" class="form-control" placeholder="(555) 123-4567"
                    required>
            </div>

            <div class="form-group">
                <label for="address1">Street Address</label>
                <input type="text" name="address1" id="address1" class="form-control" placeholder="123 Main Street"
                    required>
            </div>

            <div class="form-group">
                <label for="address2">Unit/Apt Number</label>
                <input type="text" name="address2" id="address2" class="form-control" placeholder="Unit #4A">
            </div>

            <div class="form-group">
                <label for="city">City</label>
                <input type="text" name="city" id="city" class="form-control" placeholder="Your Town" required>
            </div>

            <div class="form-group">
                <label for="state">State</label>
                <input type="text" name="state" id="state" class="form-control" placeholder="Your State" required>
            </div>

            <div class="form-group">
                <label for="zip">Zip Code</label>
                <input type="text" name="zip" id="zip" class="form-control" placeholder="07470" required>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <!-- Bootstrap JQuery, Ajax & JavaScript CDN -->
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