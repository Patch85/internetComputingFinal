<?php
    // Start a session
    session_start();

    // Set initial variables
    $dsn = 'mysql:host=localhost;dbname=music';
    // musicman has global privileges for the music database
    // make sure to create and use a more limited user for customer access
    $dbUsername = 'musicman';
    $dbPassword = 'bQC_2AFWpq46M4N';
    $tellTheUser = "";

    // If the user is already logged in, let them know...
    if (isset($_SESSION['userName'])) {
        $tellTheUser = "Hello, ". $_SESSION['userName'].", you're already logged in.";
    }
    //  Attempt to connect to the database
    try {
        $db = new PDO($dsn, $dbUsername, $dbPassword);
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        echo " <p>An error occurred while connecting to the database: $error_message</p>";
        die();
    }

    // If the user has submitted the form, attempt authentication
    if (isset($_POST['emailAddress']) && isset($_POST['password'])) {
        // Assign the POST data to variables for easier use
        $emailAddress = $_POST['emailAddress'];
        $pw = $_POST['password'];

        // Query the database for the appropriate user
        $query = "SELECT accountNumber, emailAddress, password, firstName FROM users WHERE emailAddress = :emailAddress";
        $statement = $db->prepare($query);
        $statement->bindValue(":emailAddress", $emailAddress);
        $statement->execute();
        $userData = $statement->fetch();
        $statement->closeCursor();

        // If the email address matched a registered user, confirm that the password is correct
        if ($userData != null) {
            $validPassword = password_verify($pw, $userData['password']);
            //If the entered password matches the decrypted stored password, set session variables
            if ($validPassword) {
                $_SESSION['userName'] = $userData['firstName'];
                $_SESSION['acctNum'] = $userData['accountNumber'];
                $tellTheUser = "Welcome, ". $_SESSION['userName'] ."!";
            } else {
                $tellTheUser = "That password was incorrect. Please try again.";
            }
        } else { // The user's entered email address doesn't match a registered user
            $tellTheUser = "The email address you entered did not match any registered users. <br>
                If you are a member, please try again. <br> If you are not a member, please register now.";
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
                    <a class="nav-link" href="products.php">Products</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="register.php" tabindex="-1">Register</a>
                </li>

                <li class="nav-item active">
                    <a class="nav-link" href="login.php">Log In <span class="sr-only">(current)</span></a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Log Out</a>
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
            <h1 class="jumboHeading">Log In</h1>
        </div>
    </div>

    <div class="container">
        <form class="col-md-6 m-auto" action="login.php" method="post">
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

            <button type="submit" class="btn btn-primary">Log In</button>
            <a href="register.php">Not a member yet? Click here to register!</a>
            <p> <br><?php echo $tellTheUser;?></p>
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