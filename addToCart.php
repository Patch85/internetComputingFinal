<?php
    // Start a session
    session_start();
    
    // Declare variables
    $newProductName = $_POST['productName'];
    $newProductQty = intval($_POST['quantity']);
    $newProductPrice = $_POST['price'];

    // Check for an existing cart. Create one if it doesn't exist yet. Add the item if it does
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart']  = array();
    } else {
        // Get an array containing the names of products already in the cart
        $productsInCart = array_column($_SESSION['cart'], 'productName');

        // Check to see if the new product is already listed in the cart
        if (!in_array($newProductName, $productsInCart)) {
            // Add the new product to the cart if it isn't in there already
            $_SESSION['cart'][] = array(
                productName => $newProductName,
                quantity =>$newProductQty,
                price => $newProductPrice);
        } else { // If the product is already listed in the cart, update the quantity
            // Get the index of the appropriate item array in the cart
            $cartKey = array_search($newProductName, $productsInCart);
            
            // Update the product's quantity
            $oldQty = intval($_SESSION['cart'][$cartKey]['quantity']);
            $_SESSION['cart'][$cartKey]['quantity'] = $oldQty + $newProductQty;
        }
    }
    // Redirect the user back to the page they were viewing
    header('Location: ' . $_SERVER['HTTP_REFERER']);
