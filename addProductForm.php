<?php
    session_start();
    if ($_SESSION['userType'] != "manager") {
        header("Location: index.php"); //Only managers should have access to adding products
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
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navLinks" aria-controls="navLinks"
      aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <!-- Provide Nav links in a List  -->
    <div class="collapse navbar-collapse" id="navLinks">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item ">
          <a class="nav-link" href="index.php">Home</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="products.php" tabindex="-1">Products</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="viewCart.php">Shopping Cart</a>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">My Account</a>

          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item " href="login.php">Log In</a>

            <div class="dropdown-divider"></div>

            <a class="dropdown-item " href="register.php">Register</a>

            <div class="dropdown-divider"></div>

            <a class="dropdown-item " href="customerProfile.php">View/Update Profile</a>

            <div class="dropdown-divider"></div>

            <a class="dropdown-item " href="changePassword.php">Change Password</a>

            <div class="dropdown-divider"></div>

            <a class="dropdown-item" href="CustomerReceipts.php">Order History</a>

            <div class="dropdown-divider"></div>

            <?php
                        if (isset($_SESSION['userType'])) {
                            // If the user is logged in and is a manager, display appropriate admin links
                            if ($_SESSION['userType'] == "manager") {
                                echo '<a class="dropdown-item active" href="addProductForm.php">Add New Product<span class="sr-only">(current)</span></a>
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
        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="SearchQuery">

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
      <h1 class="jumboHeading">Admin:</h1>
      <h2 class="jumboTagline">Add a New Product</h2>
    </div>
  </div>

  <!-- Main Section of the page: Show 6 Featured Products as cards with brief descriptions -->
  <div class="container">

    <form class="col-md-6 m-auto" action="addProduct.php" method="post">

      <div class="form-group">
        <label for="subcategory">Product Name</label>
        <input type="text" class="form-control" name="productName" id="productName" placeholder="Stratocaster" required>
      </div>

      <div class="form-group">
        <label for="category">Category</label>
        <select name="category" id="category" class="form-control" required>
          <option disabled selected value="">Select a category</option>
          <option value="String">String</option>
          <option value="Woodwind">Woodwind</option>
          <option value="Brass">Brass</option>
          <option value="Keyboard">Keyboard</option>
          <option value="Percussion">Percussion</option>
        </select>
      </div>

      <div class="form-group">
        <label for="subcategory">Subcategory</label>
        <input type="text" class="form-control" name="subcategory" id="subcategory" placeholder="electric guitar">
      </div>

      <div class="form-group">
        <label for="subcategory">Manufacturer</label>
        <input type="text" class="form-control" name="manufacturer" id="manufacturer" placeholder="Fender" required>
      </div>

      <div class="form-group">
        <label for="numInStock"># In Stock</label>
        <input type="number" class="form-control" name="numInStock" id="numInStock" placeholder="6" required>
      </div>

      <div class="form-group">
        <label for="price">Price</label>
        <input type="text" class="form-control" name="price" id="price" placeholder="754.99" required>
      </div>

      <div class="form-group">
        <label for="description">Description</label>
        <textarea class="form-control" name="description" id="description" required></textarea>
      </div>

      <div class="form-group">
        <label for="imagePath">Image filename</label>
        <input type="text" class="form-control" name="imagePath" id="imagePath" placeholder="strat.jpg" required>
      </div>
      <input type="submit" class="btn btn-success" value="Add product">
    </form>


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