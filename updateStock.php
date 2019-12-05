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

$productID = $_POST['product_id'];
$newStock = filter_input(INPUT_POST, 'stock', FILTER_VALIDATE_INT);

if ($newStock == NULL || $newStock == FALSE) {
  echo "<strong>Invalid input, please try again</strong>";
  include('updateStockForm.php');
  exit;
}


$queryInsert = "UPDATE products
                SET numInStock=:newStock
                WHERE productNumber=:productID";
$statementInsert = $db->prepare($queryInsert);
$statementInsert->bindValue(':newStock', $newStock);
$statementInsert->bindValue(':productID', $productID);
$statementInsert->execute();
$statementInsert->closeCursor();

echo "<strong>Successful update to product</strong> <br />";
include('productListing.php');
?>
