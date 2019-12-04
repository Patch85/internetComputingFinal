<?php
$dsn = 'mysql:host=localhost;dbname=music';
$user = 'admin';
$pass = 'pa55word';

$db = new PDO($dsn, $user, $pass);


if (!empty($category)) {
  $queryProdcts = "SELECT *
                   FROM products
                   WHERE category=:category";
  $statementProducts = $db->prepare($queryProdcts);
  $statementProducts->bindValue(':category', $category);
  $statementProducts->execute();
  $products = $statementProducts->fetchAll();
  $statementProducts->closeCursor();
  // code...
} else {
  $queryProdcts = "SELECT *
                   FROM products";
  $statementProducts = $db->prepare($queryProdcts);
  $statementProducts->execute();
  $products = $statementProducts->fetchAll();
  $statementProducts->closeCursor();
  // code...
}


?>

<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Product Listing</title>
  </head>
  <body>
    Display a specific category:
    <form action="empCategoryDisplay.php" method="post">
    <select name="category">
      <option value="">-</option>
      <option value="String">String</option>
      <option value="Woodwind">Woodwind</option>
      <option value="Brass">Brass</option>
      <option value="Keyboard">Keyboard</option>
      <option value="Percussion">Percussion</option>
    </select>
    <input type="submit" value="Submit">
    </form>

    <caption>Product Listing</caption>
    <table border="1">
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Price</th>
      </tr>
      <?php foreach ($products as $product) { ?>
      <tr>
        <td><?php echo $product['productNumber']; ?></td>
        <td><?php echo $product['productName']; ?></td>
        <td><?php echo $product['price']; ?></td>

      </tr>
    <?php } ?>
    </table>
  </body>
</html>
