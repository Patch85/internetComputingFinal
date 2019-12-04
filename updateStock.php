<?php
$dsn = 'mysql:host=localhost;dbname=music';
$user = 'admin';
$pass = 'pa55word';

$db = new PDO($dsn, $user, $pass);

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
