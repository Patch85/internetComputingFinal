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
