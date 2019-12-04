<?php
$dsn = 'mysql:host=localhost;dbname=music';
$user = 'admin';
$pass = 'pa55word';

$db = new PDO($dsn, $user, $pass);

$productID = $_POST['product_id'];

$queryRetrieval = "SELECT *
                   FROM products
                   WHERE productNumber=:productID";
$statementRetrieval = $db->prepare($queryRetrieval);
$statementRetrieval->bindValue(':productID', $productID);
$statementRetrieval->execute();
$product = $statementRetrieval->fetch();
$statementRetrieval->closeCursor();

?>

<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Update stock form</title>
  </head>
  <body>
    <p>The product you're updating is <?php echo $product['productName']; ?> <br>
    <form action="updateStock.php" method="post">
      Enter the amount you wish to update it to: <input type="text" name="stock" value="<?php echo $product['numInStock']; ?>">
      <input type="submit" value="Update stock">
      <input type="hidden" name="product_id" value="<?php echo $product['productNumber']; ?>">
    </form>

  </body>
</html>
