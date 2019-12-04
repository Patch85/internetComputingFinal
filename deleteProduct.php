<?php
$dsn = 'mysql:host=localhost;dbname=music';
$user = 'admin';
$pass = 'pa55word';

$db = new PDO($dsn, $user, $pass);

$category = $_POST['category'];

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
echo $category;
include('productListing.php');
?>
