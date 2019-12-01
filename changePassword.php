<?php
    // Start a session
    session_start();

    // Set pdo variables
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

    // If user is not logged in, redirect to login page
    if (!isset($_SESSION['userName'])) {
        header("Location: ./login.php");
    } elseif (isset($_SESSION['userName']) && isset($_POST['currentPassword'])) {
        // If user is logged in and has submitted the form...
        // Assign form data to variables
        $currentPassword = $_POST['currentPassword'];
        $newPasswword = $_POST['newPassword'];

        // Retrieve the hashed password from the database for comparison
        $query = "SELECT password FROM users WHERE accountNUmber = :accountNumber";
        $statement = $db->prepare($query);
        $statement->bindValue(":accountNumber", $_SESSION['acctNum']);
        $statement->execute();
        $results = $statement->fetch();
        $statement->closeCursor();

        // Declare a variable to store the hashed password from the database
        $hashedPassword = $results['password'];

        // Compare the provided 'current password' matches the hashed password in the database
        $validPW = password_verify($currentPassword, $hashedPassword);

        // If the user provided a valid current password, update the DB with the new password they provided
        if ($validPW) {
            //Encrypt the password with a randomly generated salt and Blowfish
            $newPasswword = password_hash($newPasswword, PASSWORD_BCRYPT);

            // Update the database with the user's new encrypted password
            $query = "UPDATE users
                        SET password = :password
                        WHERE accountNumber = :accountNumber";
            $statement = $db->prepare($query);
            $statement->bindValue(":password", $newPasswword);
            $statement->bindValue(":accountNumber", $_SESSION['acctNum']);
            $statement->execute();
            $statement->closeCursor();

            $passwordChangeMessage = "Your password has been changed.";
        } else {
            // The user provided an invalid current password
            $passwordChangeMessage = "The current password you provided was invalid. Please try again.";
        }
    }else{// The user is logged in, but hasn't yet submitted the form
        $passwordChangeMessage = ""; // No message on initial page load
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
                        <a class="dropdown-item " href="login.php">Log In</a>

                        <div class="dropdown-divider"></div>

                        <a class="dropdown-item " href="register.php">Register</a>

                        <div class="dropdown-divider"></div>

                        <a class="dropdown-item " href="customerProfile.php">View/Update Profile</a>

                        <div class="dropdown-divider"></div>

                        <a class="dropdown-item active" href="changePassword.php">Change Password<span class="sr-only">(current)</span></a>

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
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>
    </nav>

    <!-- Jumbotron/Hero element : Features a random background image and a tagline for the company -->
    <div class="jumbotron jumbotron-fluid musicJumbotron">
        <div class="container">
            <h1 class="jumboHeading"><?php echo $_SESSION['userName']; ?></h1>
            <h2 class="jumboTagline">Change your password here.</h2>
        </div>
    </div>

    <div class="container">
        <form class="col-md-6 m-auto" action="changePassword.php" method="post">
            <div class="form-group">
                <label for="currentPassword">Current Password</label>
                <input type="password" name="currentPassword" id="currentPassword" class="form-control"
                    placeholder="Current Password" required>
            </div>

            <div class="form-group">
                <label for="newPassword">New Password</label>
                <input type="password" name="newPassword" id="newPassword" class="form-control"
                    placeholder="New Password" required>
            </div>

            <button type="submit" class="btn btn-danger">Change password</button>
            <p><br><?php echo $passwordChangeMessage; ?></p>
        </form>
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