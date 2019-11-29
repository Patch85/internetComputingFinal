<?php
    // start or resume a session
    session_start();

    // Remove all session variables
    session_unset();
    // Destroy the session
    session_destroy();    
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
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">

        <a class="navbar-brand" href="index.php">DDM, Inc.</a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navLinks"
            aria-controls="navLinks" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

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

                <li class="nav-item">
                    <a class="nav-link" href="login.php">Log In</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link active" href="logout.php">Log Out<span class="sr-only">(current)</span></a>
                </li>
            </ul>

            <form class="form-inline my-2 my-lg-0" action="searchResults.php" method="post">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>
    </nav>

    <!-- Jumbotron/Hero element : Features a random background image and a tagline for the company -->
    <div class="jumbotron jumbotron-fluid musicJumbotron">
        <div class="container">
            <h1 class="jumboHeading">Logged Out</h1>
            <h2 class="jumboTagline">Thanks for shopping with DDM!</h2>
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