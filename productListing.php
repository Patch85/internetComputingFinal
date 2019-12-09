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


if (!empty($category)) {
    $queryProdcts = "SELECT *
                   FROM products
                   WHERE category=:category";
    $statementProducts = $db->prepare($queryProdcts);
    $statementProducts->bindValue(':category', $category);
    $statementProducts->execute();
    $products = $statementProducts->fetchAll();
    $statementProducts->closeCursor();
} else {
    $queryProdcts = "SELECT *
                   FROM products";
    $statementProducts = $db->prepare($queryProdcts);
    $statementProducts->execute();
    $products = $statementProducts->fetchAll();
    $statementProducts->closeCursor();
}
?>

<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>Delete Product</title>
</head>

<body>
  Display a specific category:
  <form action="deleteProduct.php" method="post">
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
      <th>Current stock</th>
    </tr>
    <?php foreach ($products as $product) { ?>
    <tr>
      <td><?php echo $product['productNumber']; ?>
      </td>
      <td><?php echo $product['productName']; ?>
      </td>
      <td><?php echo $product['price']; ?>
      </td>
      <td><?php echo $product['numInStock']; ?>
      </td>
      <td>
        <form action="deleteProduct.php" method="post">
          <input type="hidden" name="product_id"
            value="<?php echo $product['productNumber']; ?>">
          <input type="submit" value="Delete">
        </form>
      </td>
      <td>
        <form action="updateStockForm.php" method="post">
          <input type="hidden" name="product_id"
            value="<?php echo $product['productNumber']; ?>">
          <input type="submit" value="Update stock">
        </form>
      </td>

    </tr>
    <?php } ?>
  </table>
  <a href="addProductForm.html">Add a product</a>
</body>

</html>