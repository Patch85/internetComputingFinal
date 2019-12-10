<?php
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



$productName = $_POST['productName'];
$category = $_POST['category'];
$subcategory = $_POST['subcategory'];
$manufacturer = $_POST['manufacturer'];
$stock = intval($_POST['numInStock']);
$price = floatval($_POST['price']);
$description = $_POST['description'];
$image = $_POST['imagePath'];

if (!isset($_POST['productName'])) {
    echo "All fields required. Return and try again.";
    exit();
} else {
    $queryInsert = "INSERT INTO products (productName, category, subcategory, manufacturer, numInStock, price, description, imagePath)
                  VALUES ( :productName, :category, :subcategory, :manufacturer, :stock, :price, :description, :image)";
    $statementInsert = $db->prepare($queryInsert);
    // $statementInsert->bindValue(':number', $number);
    $statementInsert->bindValue(':productName', $productName);
    $statementInsert->bindValue(':category', $category);
    $statementInsert->bindValue(':subcategory', $subcategory);
    $statementInsert->bindValue(':manufacturer', $manufacturer);
    $statementInsert->bindValue(':stock', $stock);
    $statementInsert->bindValue(':price', $price);
    $statementInsert->bindValue(':description', $description);
    $statementInsert->bindValue(':image', $image);
    $statementInsert->execute();
    $statementInsert->closeCursor();
}

include('productListing.php');
