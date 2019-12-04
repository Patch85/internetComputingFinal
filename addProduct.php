<?php
$dsn = 'mysql:host=localhost;dbname=music';
$user = 'admin';
$pass = 'pa55word';

$db = new PDO($dsn, $user, $pass);

$number = " ";
$productName = $_POST['ProductName'];
$category = $_POST['category'];
$subcategory = $_POST['Subcategory'];
$manufacturer = $_POST['manufacturer'];
$stock = filter_input(INPUT_POST, 'stock', FILTER_VALIDATE_INT);
$price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);
$description = $_POST['description'];
$image = $_POST['image'];

if ($productName == null || $manufacturer == null || $stock == false || $price == false || $description == null || $image == null) {
  echo "All fields required. Return and try again."
  ?>
  <a href="addProductForm.html">Return</a>
  <?php
  exit();
} else {
  $queryInsert = "INSERT INTO products (productNumber, productName, category, subcategory, manufacturer, numInStock, price, description, imagePath)
                  VALUES (:number, :productName, :category, :subcategory, :manufacturer, :stock, :price, :description, :image)";
  $statementInsert = $db->prepare($queryInsert);
  $statementInsert->bindValue(':number', $number);
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
?>