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

if (isset($_POST['product_id'])) {
  $productID = $_POST['product_id'];
} else {
  $productID = false;
}


if ($productID != false) {
  $queryDelete = "DELETE FROM products
                  WHERE productNumber=:productID";
  $statementDelete = $db->prepare($queryDelete);
  $statementDelete->bindValue(':productID', $productID);
  $success = $statementDelete->execute();
  $statementDelete->closeCursor();
}
$word = "<strong> Product successfully deleted </strong>";

include('productListing.php');
?>
